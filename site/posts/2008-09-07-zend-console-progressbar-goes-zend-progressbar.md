---
title: Zend_Console_Progressbar goes Zend_ProgressBar
date: 2008-09-07 17:16:08 +0200
tags: [Zend Framework, Console]
---

After Ralph poked be a bit around, I started to refactor Zend_Console_ProgressBar. The result was a solution of the well known "ProgressBar Problem", which often occures in RIAs (Rich Internet Applications). If you have some long-running process, like sending out hundreds of emails, and you want to do it in real-time. You would like to inform the user about the process. For this purpose, Zend_ProgressBar ships with a [Comet](http://en.wikipedia.org/wiki/Comet_(programming)) adapter, which enables you to display the process to the user via the forever-frame technique. The adapter itself is library-independent, which means, that you can use it with any JavaScript library or even without any. There is a demo in the laboratory, which looks like this:

[][http://www.dasprids.de/media/images/misc/zend-progressbar-adapter-comet.png]

The entire component is currently waiting for approval and will hopefully soonly be in trunk.