---
title: Translated segments for standard route
date: 2009-04-01 10:15:52 +0200
tags: [Zend Framework, i18n]
---

I have finally done the translated route, which is now part of the standard route in the Zend Framework, and merged it to trunk. There is not much to tell about it, but the example from the manual should give you an idea how it works. Basically it'll help you to localize your routes based on the current language:

```php
<?php
// Prepate the translator
$translator = new Zend_Translate('array', array(), 'en');
$translator->addTranslation(array('archive' => 'archiv',
                                  'year'    => 'jahr',
                                  'month'   => 'monat'),
                            'de');

// Set the current locale for the translator
$translator->setLocale('en');

// Set it as default translator for routes
Zend_Controller_Router_Route::setDefaultTranslator($translator);

// Create the route
$route = new Zend_Controller_Router_Route(
    '@archive/:@mode/:value',
    array(
        'mode'       => 'year'
        'value'      => 2005,
        'controller' => 'archive',
        'action'     => 'show'
    ),
    array('mode'  => '(month|year)'
          'value' => '\d+')
);
$router->addRoute('archive', $route);

// Assemble the URL in default locale: archive/month/5
$route->assemble(array('mode' => 'month', 'value' => '5'));

// Assemble the URL in german: archiv/monat/5
$route->assemble(array('mode' => 'month', 'value' => '5', '@locale' => 'de'));
```

This feature will be available with the soonish released 1.8 version of the framework. Against my past thoughts, Zend_Ical and ZendX_Whois will also be available with this release.

**Update:** The information about Zend_Ical and ZendX_Whois being in 1.8 was surely an April's fool joke.