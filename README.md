# Commonwisdom
Simple local personal Markdown wiki.

## Requirements
* PHP 5.4+
* Webserver - For the designed use case of Commonwisdom, the [PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php)
  is recommended.

_Note: There are no security features built into Commonwisdom as it is mean to be a locally
ran personal wiki, not for external use. It is highly recommended to set your web server to
only listen for localhost and/or add a nice little firewall to prevent some bad people from
adding gifs to your wiki (or worse!)._


## Simple setup using PHP built-in web server

1. Install [Composer](https://getcomposer.org/)
1. Install composer assets

    `php composer.phar install`

1. Run PHP web server

    `php -S localhost:8080 -t web web/index.php`
