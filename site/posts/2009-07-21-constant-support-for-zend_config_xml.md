---
title: Constant support for Zend_Config_Xml
date: 2009-07-21 23:36:57 +0200
tags: [Zend Framework, PHP, XML]
---

Today I added support for constants in Zend_Config_Xml. This new feature will be available in Zend Framework 1.9. It was added via a Zend_Config_Xml specific XML namespace. To give you an easy example of how that may work:

```xml
<config xmlns:zf="http://framework.zend.com/xml/zend-config-xml/1.0/">
    <production>
        <includePath><zf:const zf:name="APPLICATION_PATH"/>/library</includePath>
    </production>
</config>
```

On PHP side, it works like usual:

```php
<?php
define('APPLICATION_PATH', dirname(__FILE__));
$config = new Zend_Config_Xml($xmlString, 'production');

echo $config->includePath; // Prints "/var/www/something/library"
```

Additionally, the `extends` attribute was also moved to this new namespace, making the NULL namespaced extends attribute deprecated until ZF 2.0, when it will be removed.