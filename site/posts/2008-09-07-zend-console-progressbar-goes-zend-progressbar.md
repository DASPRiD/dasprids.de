---
id: 6b0c593d-636c-4617-8139-6f376ca5cbe4
title: Zend_Console_Progressbar goes Zend_ProgressBar
date: 2008-09-07 17:16:08 +0200
tags: [Zend Framework]
---

After Ralph poked be a bit around, I started to refactor Zend\_Console\_ProgressBar. The result was a solution of the well known "ProgressBar Problem", which often occures in RIAs (Rich Internet Applications). If you have some long-running process, like sending out hundreds of emails, and you want to do it in real-time. You would like to inform the user about the process. For this purpose, Zend\_ProgressBar ships with a [Comet](http://en.wikipedia.org/wiki/Comet_(programming)) adapter, which enables you to display the process to the user via the forever-frame technique. The adapter itself is library-independent, which means, that you can use it with any JavaScript library or even without any.

The entire component is currently waiting for approval and will hopefully soon be in trunk.