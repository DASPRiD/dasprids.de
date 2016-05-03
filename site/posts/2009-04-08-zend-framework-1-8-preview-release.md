---
id: b9cecc2e-ec97-4d01-8653-08a9341eaea5
title: Zend Framework 1.8 preview release
date: 2009-04-08 14:27:29 +0200
tags: [Zend Framework]
---

All the waiting is (nearly) over. Yesterday the preview release of the 1.8 release of the Zend Framework had made it to the public, and the final release is on its way. This preview release does not contain all components of the final release, but a good bunch of that, which is mostly or completly done.

The major two components in this release are [Zend_Tool](http://framework.zend.com/manual/en/zend.tool.framework.html) and [Zend_Application](http://framework.zend.com/manual/en/zend.application.html). Zend_Tool is a CLI client by [Ralph Schindler](http://ralphschindler.com/) for creating and managing your project directory structure, like modules, controllers and actions. It also utilizes Zend_Application for setting up the bootstrap.

Zend_Application itself is a component for managing the bootstrapping, which includes several features like resource, initialization methods, depency checking and so on. The preview release does not contain all resources which will be shipped with the final release, so there is for example no router resource at the moment. Thanks to [Matthew Weier o'Phinney](http://weierophinney.net/) at this point for supporting me so heavily in the development of this component and taking off some work from me like all unit tests and most of the documentation.

Another feature of mine which made it into the PR are translation-aware routes, which I described in an [earlier blog post](/blog/2009/04/01/translated-segments-for-standard-route/).

Zend_Tag (and its sub-component Zend_Tag_Cloud) didn't made it into the PR tho, as the entire documentation is still missing. But since it is completly done and all unit tests are working, you can check it out from the [incubator](http://framework.zend.com/svn/framework/standard/incubator/) and test/use it, if you like.

There are also several other components like Zend_Navigation by Robin Skoglund, multiple enhancements and new features for Zend_Filter and Zend_Validate by [Thomas Weidner](http://www.thomasweidner.com/flatpress/) and EC2 and S3 support for Amazon by [Jon Whitcraft](http://www.bombdiggity.net/).

Since this is the PR release, we are happy for any feedback and issue reports. Now let's wait for the final release with a whole bunch of even more components, which didn't make it into the PR.