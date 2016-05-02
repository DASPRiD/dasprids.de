---
title: Wrapper-Factory for Zend_Cache
date: 2009-04-15 02:12:04 +0200
tags: [Zend Framework, Best practices]
---

When creating a huge application, you mostly have to keep caching out of your development environment, but want to fully control the caching backend in your production environment, without all the calls to the Zend_Cache factory in your models or controllers.

I had to struggle with the problem in the past sometimes, and came to the conlusion, that a singleton-factory would solve this issue very well. With this term I describe a factory, which creates unique caches always just a single time. As my caches always just vary in their lifetime, I use this lifetime value as unique identifier for each cache instance.

For a very simple case, here follows a basic cache factory. It usually should surely be configured through a configuration file:

```php
<?php
class App_Factory
{
    /**
     * List of lifetime-caches
     *
     * @var array
     */
    protected static $_caches = array();
    
    /**
     * Get a cache with a specific lifetime
     *
     * @param  integer $lifetime
     * @return Zend_Cache_Core|null
     */
    public static function getCache($lifetime)
    {
        if (!isset(self::$_caches[$lifetime])) {
            self::$_caches[$lifetime] = Zend_Cache::factory(
                'Core',
                'File',
                array('lifetime' => $lifetime,
                      'automatic_serialization' => true),
                array('cache_dir' => CACHE_PATH)
            );
        }
    
        return self::$_caches[$lifetime];
    }
}```

Using this factory then is pretty simple; say you want to cache some pretty complex array, you'd simply do the following:

```php
<?php
$cache   = App_Factory::getCache(3600);
$cacheId = 'FooBar';

if ($cache === null || ($cache->load($cacheId)) === false) {
    $data = /* Some complex stuff here */;

    if ($cache !== null) {
        $cache->save($data, $cacheId);
    }
}```

When the factory returns null (as in, no cache defined) or the data weren't cached yet, the data will be created by some complex code. As I said before, this is a very basic example, but it should give you an idea about how to use this in your own application.