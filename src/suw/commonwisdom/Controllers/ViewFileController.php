<?php

/**
 * Controller for viewing a markdown(able) file
 *
 * @author Su Wang <suw@uci.edu>
 */

namespace suw\commonwisdom\Controllers;

use Symfony\Component\HttpFoundation\Request;
use suw\commonwisdom\Controllers\DefaultController;

class ViewFileController extends DefaultController
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
     * Render a file with a given file name
     *
     * @param $fileName
     * @return mixed
     */
    public function renderFile($fileName) {
        $fileLocation = $this->makeFileLocation($fileName);

        if (file_exists($fileLocation)) {
            $fileContents = file_get_contents($fileLocation);
        } else {
            $fileContents = "# $fileName";
        }

        $template = $this->twig->loadTemplate('view.html');
        return $template->render(
            array(
                'fileContents' => $fileContents,
                'fileName'    => $fileName
            )
        );

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
