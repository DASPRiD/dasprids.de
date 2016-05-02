---
title: Determining the environment in your application
date: 2009-03-25 11:55:15 +0100
tags: [PHP]
---

Every user has another way to do it, and for every project it has to be a bit different than before. I'm talking about the decision in which environment your application currently runs. In the past, I always let it depends on the hostname, but that got tricky and dirty, when it was available via multiple hostnames, if a hostname changes or when another developer wanted to checkout the source and work on it.

After some looking around, i found mod_env of apache, which lets you set environment variables accessible by PHP. It works like that, first you install/enable mod_env, if not done yet. Then you create a new enviornment variable. I only tested it in the global apache-config, but it can probably also work for single virtualhosts:

```
<IfModule env_module>
    SetEnv environment development
</IfModule>```

After reloading apache, you can now simply check for the environment in your bootstrap file:

```php
<?php
if (isset($_SERVER['environment']) && $_SERVER['environment'] === 'development') {
    define('APPLICATION_ENV', 'development');
} else {
    define('APPLICATION_ENV', 'production');
}```

I hope that this will be helpful for some of you.