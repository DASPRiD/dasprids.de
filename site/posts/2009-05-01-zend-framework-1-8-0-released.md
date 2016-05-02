---
title: Zend Framework 1.8.0 released
date: 2009-05-01 13:02:19 +0200
tags: [Zend Framework]
---

Today the 1.8.0 release of the Zend Framework made it out of the door. It not only contains over 200 bugfixes, but also alot of new components and features. The most interesting ones are Zend_Application and Zend_Tool for rapid application development.

Zend_Tool is a command line client, which supports you in setting up and managing Zend Framework projects. In relation Zend_Application brings you and object oriented way of bootstrapping your application, comming with a new autoloader (Zend_Loader_Autoloader), which replaces the old Zend_Loader which is now deprecated and will be removed with 2.0.

Many other contributions made it into this release, check the list below to find out:

    *  Zend_Tool, contributed by Ralph Schindler
    * Zend_Application, contributed by Ben Scholzen and Matthew Weier O'Phinney
    * Zend_Loader_Autoloader and Zend_Loader_Autoloader_Resource, contributed by Matthew Weier O'Phinney
    * Zend_Navigation, contributed by Robin Skoglund
    * Zend_CodeGenerator, by Ralph Schindler
    * Zend_Reflection, Ralph Schindler and Matthew Weier O'Phinney
    * Zend Server backend for Zend_Cache, contributed by Alexander Veremyev
    * Zend_Service_Amazon_Ec2, contributed by Jon Whitcraft
    * Zend_Service_Amazon_S3, Justin Plock and Stas Malyshev
    * Incorporated Dojo 1.3
    * Added support for arbitrary Dojo Dijits via view helpers
    * Zend_Filter_Encrypt, contributed by Thomas Weidner
    * Zend_Filter_Decrypt, contributed by Thomas Weidner
    * Zend_Filter_LocalizedToNormalized and _NormalizedToLocalized, contributed by Thomas Weidner
    * Support for file upload progress support in Zend_File_Transfer, contributed by Thomas Weidner
    * Translation-aware routes, contributed by Ben Scholzen
    * Route chaining capabilities, contributed by Ben Scholzen
    * Zend_Json expression support, contributed by Benjamin Eberlei and Oscar Reales
    * Zend_Http_Client_Adapter_Curl, contributed by Benjamin Eberlei
    * SOAP input and output header support, contributed by Alexander Veremyev
    * Support for keyword field search using query strings, contributed by Alexander Veremyev
    * Support for searching across multiple indexes in Zend_Search_Lucene, contributed by Alexander Veremyev
    * Significant improvements for Zend_Search_Lucene search result match highlighting capabilities, contributed by Alexander Veremyev
    * Support for page scaling, shifting and skewing in Zend_Pdf, contributed by Alexander Veremyev
    * Zend_Tag_Cloud, contributed by Ben Scholzen
    * Locale support in Zend_Validate_Int and Zend_Validate_Float, contributed by Thomas Weidner
    * Phonecode support in Zend_Locale, contributed by Thomas Weidner
    * Zend_Validate_Db_RecordExists and _RecordNotExists, contributed by Ryan Mauger
    * Zend_Validate_Iban, contributed by Thomas Weidner
    * Zend_Validate_File_WordCount, contributed by Thomas Weidner

Thanks to all contributors who have worked so hard on this release. If you want to find out more, check out the [devzone article](http://devzone.zend.com/article/4524-Zend-Framework-1.8.0-Released)!

Now, what's next? On my plan I've got Zend_Ical and ZendX_Whois for the next release, and, if the next release would be 2.0, a complete refactoring of the Zend_Controller_Router component.