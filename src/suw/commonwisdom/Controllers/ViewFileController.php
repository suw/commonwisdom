<?php

/**
 * Controller for viewing a markdown(able) file
 *
 * @author Su Wang <suw@uci.edu>
 */

namespace suw\commonwisdom\Controllers;

use Symfony\Component\HttpFoundation\Request;

class ViewFileController
{

    /**
     * @var \Silex\Application
     */
    private $app;


    /**
     * @var mixed
     */
    private $twig;

    /**
    * Constructor
    *
    * @param \Silex\Application $app
    */
    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
        $this->twig = $app['twig'];
    }

    /**
     * Render the edit view of a file
     *
     * @param String $fileName
     * @param bool   $saveSuccess
     * @return mixed
     */
    public function renderEditFileView($fileName, $saveSuccess = false) {

        $fileContents = $this->getFileContents($fileName);

        $template = $this->twig->loadTemplate('edit.html');
        return $template->render(
            array(
                'fileContents'      => $fileContents,
                'fileName'          => $fileName,
                'displaySavedNote'  => $saveSuccess
            )
        );
    }

    /**
     * Render a view-only page for file with a given file name
     *
     * @param $fileName
     * @return mixed
     */
    public function renderFileView($fileName) {

        $fileContents = $this->getFileContents($fileName);

        $template = $this->twig->loadTemplate('view.html');
        return $template->render(
            array(
                'fileContents' => $fileContents,
                'fileName'    => $fileName
            )
        );
    }

    /**
     * Get the markdown contents of a file
     *
     * @param $fileName
     * @return string
     */
    private function getFileContents($fileName)
    {
        $fileLocation = $this->makeFileLocation($fileName);

        if (file_exists($fileLocation)) {
            $fileContents = file_get_contents($fileLocation);
        } else {
            $fileContents = "# $fileName";
        }

        return $fileContents;
    }

    /**
     * Edit and then render the file.
     *
     * @param Request $request
     * @param $fileName
     * @return mixed
     */
    public function saveAndRenderFile(Request $request, $fileName)
    {
        $fileLocation = $this->makeFileLocation($fileName);
        file_put_contents($fileLocation, $request->get('fileContents'));

        return $this->renderEditFileView($fileName, true);
    }

    /**
     * Render the list of files in the file directory
     *
     * @return mixed
     */
    public function renderFileList()
    {
        $files = $this->getFileList();
        $template = $this->twig->loadTemplate('viewFileList.html');
        return $template->render(
            array(
                'files' => $files
            )
        );
    }

    /**
     * Get the list of files we can edit/view
     *
     * @return array
     */
    private function getFileList() {

        $files = array();
        foreach (new \DirectoryIterator(FILE_DIRECTORY) as $fileInfo) {
            $fileName = $fileInfo->getFilename();
            if (strpos($fileName, '.md') !== false
                || strpos($fileName, '.MD') !== false) {
                $files[] = array(
                    'fileName' => $fileName,
                    'lastModified' => $fileInfo->getMTime()
                );
            }
        }

        $sortByModifiedTime = function($fileA, $fileB) {
            if ($fileA['lastModified'] == $fileB['lastModified']) {
                return 0;
            }
            return ($fileA['lastModified'] < $fileB['lastModified']) ? 1 : -1;
        };

        usort($files, $sortByModifiedTime);

        $formatModifiedTime = function($fileInfo) {
            $fileInfo['lastModified'] = date(DATE_RFC2822, $fileInfo['lastModified']);
            return $fileInfo;
        };

        $files = array_map($formatModifiedTime, $files);

        return $files;
    }

    /**
     * Create a file location with a given file name
     *
     * @param $fileName
     * @return string
     */
    private function makeFileLocation($fileName)
    {
        return FILE_DIRECTORY . '/' . $fileName;
    }

}
