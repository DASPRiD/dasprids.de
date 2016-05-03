---
title: Writing powerful and easy config files with PHP-arrays
date: 2009-05-08 11:20:59 +0200
tags: [Zend Framework, PHP]
---

I was asked many times how I organize my config files, and my response was always the same, until some time ago when I switched began refactoring the codebase of my blog. I always used PHP config files in some way (as I got inspired to it by Matthew Weier O'Phinney). So first let's clearify the advantages of PHP-array config files:

· they allow to organize one config into multiple files
· they can be cached by an opcode cache
· they support constants
· they allow to create easily readable config trees
· they support boolean and integer values

Looking at those advantages, you may ask now why not everbody is using them. Well the problem mostly is that you cannot create extend-sections (when working with Zend_Config for example). So in the past I always had to create separate config files for each development and production environment. When I started refactoring the codebase I thought about that problem and came to a very simple solution. First you have your base config file looking somehow like this:

```php
<?php
return array_merge_recursive(array(
    'resources'   => array(
        'frontController' => array(
            'moduleDirectory' => APPLICATION_PATH . '/modules'
        ),
        'router' => array(
            'routes' => include dirname(__FILE__) . '/routes.config.php'
        ),
        'db' => array(
            'adapter' => 'pdo_mysql',
            'params'  => array(
                'charset' => 'utf-8'
            )
        )
    )
), include dirname(__FILE__) . '/' . APPLICATION_ENV . '.config.php');
```

This config file uses array_merge_recursive to tage a basic config array and overwrite or extend properties from an environment specific config file (in this case development.config.php and production.config.php). Additionally the routes for the router are outsourced into a separate file, since they are taking up a lot of space. Now let's take a look at the the development.config.php:

```php
<?php
return array(
    'phpSettings' => array(
        'display_startup_errors' => 1,
        'display_errors'         => 1,
        'error_reporting'        => (E_ALL | E_STRICT)
    ),
    'resources'   => array(
        'frontController' => array(
            'baseUrl'         => '/some/dev/path',
            'throwExceptions' => true
        ),
        'db' => array(
            'params'  => array(
                'host'     => 'localhost',
                'username' => 'foo',
                'password' => 'bar',
                'dbname'   => 'baz'
            )
        )
    )
);
```

As you can see, the development specific config file now enables all the error reporting, set the baseUrl for the front controller and the connection parameters for the database adapter. The production specific config file is doing similar things but disabling all error reporting. As you have seen in the base config file, two constants should already be set (APPLICATION_PATH and APPLICATION_ENV). To use the base config file within your Zend Framework application, you load it like this:

```php
<?php
// Loading the config manually
$config = new Zend_Config(require APPLICATION_PATH . '/config/config.php');

// Or telling Zend_Application to load the config
$application = new Zend_Application(APPLICATION_ENV,
                                    APPLICATION_PATH . '/config/config.php');
```

If you want to see a full example of a working config-structure, you can take a look at my new codebase in my [SVN repository](http://site.svn.dasprids.de/trunk/application/config/).

**Update 2010-10-07:** As of PHP 5.3, you should use *array_replace_recursive()* instead of *array_merge_recursive()*.