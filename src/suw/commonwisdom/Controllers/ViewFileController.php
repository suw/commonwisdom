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
    * Constructor
    *
    * @param \Silex\Application $app
    */
    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param $fileName
     * @return mixed
     */
    public function renderFile($fileName) {
        $fileLocation = FILE_DIRECTORY . '/' . $fileName;
        if (!file_exists($fileLocation)) {
            $this->app->abort(404);
        } else {
            $fileContents = file_get_contents($fileLocation);
            $twig = $this->app['twig'];
            $template = $twig->loadTemplate('view.html');
            return $template->render(
                array(
                    'fileContents' => $fileContents,
                    'fileName'    => $fileName
                )
            );
        }

    }


    /**
     * Load the layout
     */
    public function render()
    {

    }
}
