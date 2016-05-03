---
title: Modern Application Design - Part 1
date: 2010-03-05 16:50:03 +0100
tags: [Zend Framework, PHP, Best practices]
---

# Introduction
Based on the wishes by many people I was convinced to start a serial about modern application design. This serial will be completly based on my [blog's source code](http://site.svn.dasprids.de/trunk), where I'll try to explain as many parts of my application as possible. As some parts were already covered in previous blog articles by me and other authors, I'll refer to them when the topics occur. In this first chapter I'm going to write about the basic setup of the application with some quirks which are rather not seen in most other setups.

# Coding standard
This is probably the most important point, since it is leading through your entire application. There may still be people out there using some abitrary standard, if you can call it like that. But if there are more than only one person working on a project, you should definitely have one. For simplicity, I'm just using the [Zend Framework coding standard](http://framework.zend.com/manual/en/coding-standard.html).

# Directory structure
As every project it always starts with choosing a specific directory structure. In my case I've choosen the [Default modular directory structure](http://framework.zend.com/wiki/display/ZFPROP/Zend+Framework+Default+Project+Structure+-+Wil+Sinclair) proposed by Wil Sinclair, with some tiny modifications. One of those modifications is the additional library folder within my application folder, which holds the application library being non-specific to any module. I've also removed some folders of the proposal which I was not going to use. You may ask yourself, if a default directory structure is really important, and the answer is yes. When a developer comes from another Zend Framework project using the same structure, he will have no problem finding the way through your application within minutes.

# Configuration
Many people nowadays use Zend_Tool to setup their initial project. As this automatically generates an INI config file, most developers stay with this kind of configuration. For many reasons I'm not doing that and instead using PHP config files, which I had written down about a year ago in [another blog post](/blog/2009/05/08/writing-powerful-and-easy-config-files-with-php-arrays/).

# Bootstrapping
Every new developer should be familiar with Zend_Application, which I and Matthew invented and published in Zend Framework 1.8. It has many benefits compared to the old and well-known procedural bootstrapping:* Your bootstraping code is portable and reusable* It is easier to test with PHPUnit* You can use single resource for individual scripts* It comes with many bootstrapping resources out-of-the-boxThis is just a small list, but you should get the idea. I'll not go into detail about this component, as it is a pretty huge topic. Though you should know that I'm prefering _init* methods over resource plugins, since they are still partly portable and offer a greater performance bonus.

A few things to note about my quirks in bootstrapping: As I like to keep general services and models within the Default module, I am adding an additional resource autoloader for that module. I am also using module bootstrapping, as this automatically adds executes one bootstrap per module and registers a resource autoloader for it.

# Routing
Many people just go with the default module route, which has some disadvantages. You have less control about the URIs and validation has always to be done in the controller. Also you will sooner or later get trouble with duplicate content, as many URIs can lead to the same controller-action. With custom routes, you can exacly define, how URLs should look like and do some rudimentary validation.

# Exception handling
There are many kinds of exceptions, not the usual ones thrown by Zend Framework itself. For example, Zend Framework comes with three exceptions, which are "controller not found", "action not found" and, as of ZF 1.10, "route not found". Those can be used in the error controller to nicely display 404 (not found) pages. Additional to that, I'm using a custom App_PageNotFound exception, which is thrown by controllers if a request item could not be found. Another exception I use is the App_Permission exception. Those two will also be handled by the error controller to create appropriate output. All other exceptions will just generate a 500 (server error) page and log those exceptions.

# To be continued …
In the next chapter of this serial I'm going to write about the service and model architecture used in my blog, stay tuned!