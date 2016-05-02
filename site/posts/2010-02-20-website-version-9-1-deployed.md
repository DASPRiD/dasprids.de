---
title: Website version 9.1 deployed
date: 2010-02-20 16:10:59 +0100
tags: [Site]
---

After I could finish the refactoring, I started working on some new features and changes.  The two comming with this version are:* Reply option for comments, using a bit of Dojo* Wider layout, to make full use of a 1024-wide resolutionBeside that, I've also set up a CI server on http://dasprids.de:8080 based on Hudson. Future steps will be to get a greater code coverage of the tests.

**Update**
I just introduced prefixing of the JS and CSS folders, so all browsers are forced to reload those files when a new version is deployed. Additionally I fixed the lucene sync script, so that the search is fully functionaly again.