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
     * @param $fileName
     * @return mixed
     */
    public function renderEditFileView($fileName) {

        $fileContents = $this->getFileContents($fileName);

        $template = $this->twig->loadTemplate('edit.html');
        return $template->render(
            array(
                'fileContents' => $fileContents,
                'fileName'    => $fileName
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

        return $this->renderFile($fileName);
    }

    /**
     * Render the list of files in the file directory
     *
     * @return mixed
     */
    public function renderFileList()
    {
        $files = scandir(FILE_DIRECTORY);

        // Only show markdown files
        $filterForMarkdown = function($fileName) {
            return strpos($fileName, '.md') !== false || strpos($fileName, '.MD') !== false;
        };
        $files = array_filter($files, function($fileName) {
            return strpos($fileName, '.md') !== false
                || strpos($fileName, '.MD') !== false;
        });

        $template = $this->twig->loadTemplate('viewFileList.html');
        return $template->render(
            array(
                'files' => $files
            )
        );
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


    /**
     * Load the layout
     */
    public function render()
    {
        // TODO: Is this still needed?
    }
}
