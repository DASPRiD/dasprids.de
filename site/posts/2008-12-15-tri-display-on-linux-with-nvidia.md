---
title: Tri-Display on Linux with nvidia
date: 2008-12-15 11:18:44 +0100
tags: [PC setup]
---

A few days ago, I got two new graphics cards (Geforce 9800 GT) and a third monitor. So far, so good - I thought. I had yet only set up a quad-display setup at my old work, and that was on a Windows PC. I didn't think that this setup would be something unusual, so I started by browser and searched on Google about it. But the results I got were anything else than promising:

TwinView does not support multi-card desktops, and Xinerama won't allow compositing together with nvidia drivers due to a bug. After some more searching, I discovered that somebody got a [6-Display setup running on Ubuntu 8.04 via xserver-xgl](http://ubuntuforums.org/showthread.php?t=884161&amp;page=21). So I tried it that way, but ran into a wall. The development of xserver-xgl was stopped January 2008, and it had way too many problems with Ubuntu 8.10, like messed up keyboard mapping, and also like two crash per hour.

So this was no acceptable solution, which forced me to run the third monitor as a separate X-screen. That was no huge problem so far, as I only wanted to display chats, music player and such on it. But the world wouldn't be perfect, when if everything would run flawlessly. TwinView has a another nice bug which seems to drop the faked xinerama information, so your desktop manager doesn't know anymore, that your desktop belongs to two displays, which results in login screen centered between both displays, and the panels streched over both displays.

With some help of a friend I could fix this with a tiny program called [Fake Xinerama](http://ktown.kde.org/~seli/fakexinerama/). In fact, this is no program, but just the source for a shared object, which will replace the libXinerama.so. It basically worked very well, but not for the login screen, as the config file for Fake Xinerama had to be placed in ~/.fakexinerama by default. After some thinking I came to the point to rewrite the source (which was only about 40 lines long) to read the configuration from /etc/fakexinerama. This allowed the login screen to be centered on the main display again.

So all this is currently just a temporary solution, until either xrandr 1.3 is released (which should replace xinerama and allows multi-card output with compositing), or nvidia enhances TwinView.