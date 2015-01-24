# Welcome to commonwisdom

commonwisdom is a simple way of editing and viewing your markdown files, based on [fredoliveira/commonplace](https://github.com/fredoliveira/commonplace) but written in PHP to make running on your own computer super easy.

### Tech
* Markdown rendering: commonwisdom's markdown is rendered by [marked](https://github.com/chjj/marked) and supports [github flavored](https://help.github.com/articles/github-flavored-markdown/) markdown. For those familiar with marked, the following options are used:  
``` 
gfm: true,
tables: true,
breaks: false,
pedantic: false,
sanitize: true
```
* [Silex](http://silex.sensiolabs.org/) for a lightweight framework
* [Twig](http://twig.sensiolabs.org/) for layouts/templates
* [jQuery](http://jquery.com/) for the usual magic
* [Font Awesome](http://fortawesome.github.io/Font-Awesome/) for icons

### Version

1.1.0


#### Did I mention there's gifs?

![](http://i.imgur.com/2sREC.gif)
