[![Supernano](https://img.shields.io/badge/Supernano-Skeleton-ff69f4.svg)](https://github.com/delfimov/Supernano)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/delfimov/GDImage/blob/master/LICENSE)

# Supernano Skeleton

Basic skeleton for [Supernano framework](https://github.com/delfimov/Supernano).

## Requirements
 
 * [PHP >= 5.4](http://www.php.net/) (though, I highly recommend to use PHP 7) 
 * [Composer](https://getcomposer.org/download/)

## Installation

 * Open your favorite shell
 * Change working directory to your webserver root or wherever you want to create a new project
 * Run `composer create-project supernano/skeleton my_project_name`
 * Answer to a couple questions
 * Your project will be created in `my_project_name` directory
 * Add dev domain to `c:\Windows\System32\drivers\etc\hosts` or `/etc/hosts`
 * Add VirtualHost to Apache configuration or server to Nginx
 * Check `my_project_name\composer.json`
 * Run `composer update`

## How to use

### Templates 
 * Templates are stored in `tpl` directory
 * `tpl/super/layout.php` is a basic template for you web site
 
### Routing  

 * Template name without `.php` extension is a first part of URL-path. 
 * Allowed template name is `/[a-z0-9_-]+/`.
 * Default template (requests with empty URL-path like ``http://www.example.com/`) is `tpl/index.php`.
 * If requested template is not exists, `tpl/super/error404.php` will be used insted ("Error 404 - Page not found" page).
   
Let's say we have a request like `http://www.example.com/whatever`.

This means template name is *whatever*, the framework will look for 
`tpl/whatever.php` and include it in `tpl/super/layout.php` file.
 
If `tpl/whatever.php` is not exists,  `tpl/super/error404.php` will be used.

Request `http://www.example.com/what/ever` will look for `tpl/what.php`, 
URL-path will be stored in `$this->request` array (`[0 => 'ever']` in this case). 

### Available variables
 * `$this->request` - array with URL-path request
 * `$this->get` -  array similar with get request
 * `$this->tplPath` - path to templates directory
 * `$this->template` - current template name
 * `$this->templateFile` - current template filename
