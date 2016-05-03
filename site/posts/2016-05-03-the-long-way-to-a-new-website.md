---
id: a7f00502-8e22-4650-8a4b-81f98be1bee0
id: af7f1d5e-141d-44ab-a57e-82f7c1be4a40
title: The long way to a new website
date: 2016-05-03 22:44:59 +0200
description: After a long time, I managed to put up a completely overhauled website.
tags: [Site, PHP]
---

It took me practically forever, but after a long time I managed to get a new website up and running. I had multiple new design ideas over the past few years, and even had a quite complex design for a business version of my website done by [MARTES NEW MEDIA](http://www.martes.de), but eventually I decided that I would not need a business website at all. About a week ago I started tinkering with the website agian, and decided to work one something new.

I heard about static site generators a while back already, but never came around to look more into them. So I started with a recommendation from [Ocramius](http://ocramius.github.io/), namely what he uses as well, [Sculpin](https://sculpin.io/). At first it seemed to work quite well, and I started to write up a nice layout with Bootstrap 3 and CSS. After that, I tried to set up all the different templates I would need, but quickly ran into a lot of bugs, some of which I could solve with workarounds, but others which were real showstoppers.

So I looked around on the web a little, and found out about a few more popular static site generators, the major ones being [Jekyll](https://jekyllrb.com/), [Hugo](https://gohugo.io/) and [Pelican](http://blog.getpelican.com/). Well, I tried working with all of them and a few others, but eventually I always ran into one bug or another which made me really hate each one. Of course I asked Google a lot for workarounds and solutions, but all of those generators have a maintenance which makes most serious developers cry.

Eventually I gave up on that and concluded that if I want something working from A to Z, I'd have to write it myself. So I started writing a really small 200-line script, which generated my blog and the few static pages really nicely (and without bugs!). Since I'm a perfectionist though, I decided to write the entire thing down in a nice library, which I could eventually re-use if I'd want to. The code of the site generator is public, although it's currently combined with the [repository of my website on GitHub](https://github.com/DASPRiD/dasprids.de). You are allowed to fork it though if you like to use it for your own website. If interest would be large enough, I may even consider making the site generator its own composer package. 

As I didn't want the website to be completely static, I also added [Disqus](https://disqus.com) as a commenting platform. It was a little tricky to get my comments exported from my old system (let alone the articles, which I had to convert to markdown and then clean up manually), but I managed to link everything up properly.

Another change I decided was to finally have my website ran completely through HTTPS. I already had a few other domains of mine  set-up for that through [Let's Encrypt](https://letsencrypt.org/), but my old website had some hard-coded parts which made it impossible to run on HTTPS.

Last but not least, don't consider this the final version of the new website. I only wanted to bring it up so that no new comments get added to the old comment system. I will eventually add a few more static pages with more information about myself. But then, most of your are probably just interested in development topics, of which I may post more frequently in the foreseeable future.
