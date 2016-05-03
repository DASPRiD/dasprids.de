---
id: 9e9e0fac-2814-4c44-9b32-33ba38dd23d1
title: Sequel of the Internet Explorer hell
date: 2012-12-15 23:02:09 +0100
tags: [CSS, Android]
---

Many of you may remember the "good old days", when Windows XP came out which would let Joe Average be stuck with Internet Explorer 6 for a while, while finally giving him IE7, on which he'd be stuck for all eternity though, unless he'd upgrade to another browser like Firefox or Chrome. Surely, Joe Average may not know about these or be happy with this browser, which was very bad for us web developers. Eventually, the IE6 and IE7 were falling, and (depending on your business) we were able to drop support for those legacy browsers.

Everything seemed to be fine for the moment, until the prefix hell begun. But so far we were able to survive it, until recently browser vendors started to drop vendor prefixes on many key features (even IE9 came with a few unprefixed CSS3 features). Microsoft is also doing well with IE10, by implementing all those new CSS3 features without prefixes at all, following a recommendation from the CSS working group.

So, this basically sounds very exciting, but since we don't live in a perfect world, there's always some bad player; In this case it's Webkit. So far, less of the mostly used CSS3 features are available unprefixed in current, near future or farther future versions of Webkit, like background gradients, transitions and so on. But okay, we can live with this for now, it's just a single additional prefix, right?

Wrong! Do you remember the first paragraph, were I was talking about people with old operation systems and stock browsers? Well, the same thing is now repeating in the mobile world. For instance, the majority of Android users is stuck on Gingerbread (Android 2.3), which comes with a (relatively) very outdated stock browser, which even requires you to use an even older prefix with a different syntax for gradients. This forces us again to use a third version, which works completely different from the official and the newer webkit implementation.

Again, people could upgrade to a different browser (Firefox, Opera, …), but most simply don't care, because the browser works for them. What's the solution you may ask? Well, in my opinion, Google should handle the browser as any other app in the system and upgrade the Webkit base as often as they upgrade their desktop browser. Those are just my two cents, and I know that this action wouldn't change anything about the status quo, but could avoid the same problem in the future.