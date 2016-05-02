---
title: About fluffly TagClouds
date: 2008-11-25 18:01:50 +0100
tags: [Zend Framework]
---

Do you know the tag cloud in my right sidebar? Probably you are interested in an easy way to create to? Well that isn't really that hard, at least not with the next version of the Zend Framework. A few days ago, I have created a proposal for Zend_TagCloud, after I received an e-mail from a user asking me, how the tag cloud on my website works.

Well long story short, I quickly sticked a prototype together, which supplies you with a basic HTML decorator, which allows nearly any kind of HTML tag cloud. Additonally, you can create your own decorators very easily. The usage of the tag cloud component is even simpler than anyone could describe it. Let some code speak for it:

```php
<?php
$tags = array( 
    array('title'  => 'Tag 1', 
          'weight' => 50, 
          'url'    => '/tag/1'), 
    array('title'  => 'Tag 2', 
          'weight' => 20, 
          'url'    => '/tag/2'), 
    array('title'  => 'Tag 3', 
          'weight' => 34, 
          'url'    => '/tag/3'), 
); 
 
$cloud = new Zend_TagCloud(array('tags' => $tags)); 
echo $cloud; ```

And yeah, that's it. No fancy magic. You simply give an array of tags to it and it works. You can also specify some options. For instance which decorators to use for the tags and for the cloud, and also give options directly to the decorators. The decorators allow you to specify a list of tags and optionally attributes to assign to the tags. The default tag decorator creates at least an anchor element with the defined URL as href and the tag title as content.

Right now, you may want to take a look at the [Zend_Tag_Cloud proposal](http://framework.zend.com/wiki/display/ZFPROP/Zend_TagCloud+-+Ben+Scholzen) or checkout the [Zend_TagCloud prototype](http://framework.zend.com/svn/framework/standard/branches/user/dasprid/TagCloud) from svn.