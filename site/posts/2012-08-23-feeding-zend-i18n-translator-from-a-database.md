---
title: Feeding Zend\I18n\Translator from a database
date: 2012-08-23 14:21:24 +0200
tags: [Zend Framework, i18n]
---

Sometimes you need to get translation messages from a database, for instance when you want your clients to be able to add or edit translations. By default, this is not possible with the translator, but its extendibility allows you to easily integrate it.

Let's get started with the table layout. To get full support for all features, you will need two tables:

```sql
CREATE TABLE `locales` (
  `locale_id` char(5) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `locale_plural_forms` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  PRIMARY KEY (`locale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locale_id` char(5) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `message_domain` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `message_key` text NOT NULL,
  `message_translation` text NOT NULL,
  `message_plural_index` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `locale_id` (`locale_id`),
  KEY `message_domain` (`message_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1`
  FOREIGN KEY (`locale_id`)
  REFERENCES `locales` (`locale_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
```

The first table is pretty easy to explain. It contains the 5-character locale (for instance: en-EN) and the definitions for the plural forms. The plural forms are defined the same way as they are in gettext and other formats.

The second table is not much more complex. It contains a primary integer key, a reference to the locale and the message specific data. Those are for once text domain, the key, so the string which you use in your source code, the translation for it and optionally the plural index, in case the translation requires plural forms. The plural index shoudl be equivalent with the result of the plural forms evaluation.

Now after we have created our table layout, we need to write a translation loader which is able to retrieve translations from the database. A very simple implementation with Zend\Db could look something like this:

```php
<?php
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Sql\Sql;
use Zend\I18n\Translator\Loader\LoaderInterface;
use Zend\I18n\Translator\Plural\Rule as PluralRule;
use Zend\I18n\Translator\TextDomain;

class DatabaseTranslationLoader implements LoaderInterface
{
    protected $dbAdapter;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function load($filename, $locale)
    {
        $textDomain = new TextDomain();
        $sql        = new Sql($this->dbAdapter);

        $select = $sql->select();
        $select->from('locales');
        $select->columns(array('locale_plural_forms'));
        $select->where(array('locale_id' => $locale));

        $localeInformation = $this->dbAdapter->query(
            $sql->getSqlStringForSqlObject($select),
            DbAdapter::QUERY_MODE_EXECUTE
        );

        if (!count($localeInformation)) {
            return $textDomain;
        }

        $localeInformation = reset($localeInformation);

        $textDomain->setPluralRules(
            PluralRule::fromString($localeInformation['locale_plural_forms'])
        );

        $select = $sql->select();
        $select->from('messages');
        $select->columns(array(
            'message_key',
            'message_translation',
            'message_plural_index'
        ));
        $select->where(array(
            'locale_id'      => $locale,
            'message_domain' => $filename
        ));

        $messages = $this->dbAdapter->query(
            $sql->getSqlStringForSqlObject($select),
            DbAdapter::QUERY_MODE_EXECUTE
        );

        foreach ($messages as $message) {
            if (isset($textDomain[$message['message_key']])) {
                if (!is_array($textDomain[$message['message_key']])) {
                    $textDomain[$message['message_key']] = array(
                        $message['message_plural_index'] => $textDomain[$message['message_key']]
                    );
                }

                $textDomain[$message['message_key']][$message['message_plural_index']]
                    = $message['message_translation'];
            } else {
                $textDomain[$message['message_key']] = $message['message_translation'];
            }
        }

        return $textDomain;
    }
}
```

This loader is a little bit tricky, as we are abusing the $filename parameter to pass in the text domain we want to load. Apart from that, the code should be pretty much self-explaining. Next you need to create a factory, so that the service manager can populate the loader with a database adapter when the translator requests an instance of the loader:

```php
<?php
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DatabaseTranslationLoaderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DatabaseTranslationLoader(
            $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }
}
```

Finally we can add the translations to our application:

```php
<?php
$translator->addTranslationFile(
    'DatabaseTranslationLoader',
    'text-domain',
    'text-domain'
);
```

We have to enter the text domain twice here, as you read earlier we are abusing the $filename parameter to pass it to the loader. Now the translator is ready to use. You should make sure to use caching, as loading the translations on every request is kinda heavy. You'd usually choose a long caching time, and then simply invalidate the cache everytime the database translations are updated.

I hope this post will help all of you seeking for a solution to this problem. All code examples are written down out of my head, so they may contain mistakes or something may be missing at all. In that case please [gist](https://gist.github.com/) me a corrected version of that part, so I can update it.

Be sure that more i18n related topics are following in the near future, and when you are going to [ZendCon](http://www.zendcon.com), don't miss my [i18n](http://zendcon.com/sessions/?tid=2622#session-22628) or [router](http://zendcon.com/sessions/?tid=2622#session-22627) talk there!

**Update:** I'm currently working on a database translation loader added to ZF2 itself. It will most likely be available in 2.1.
