---
title: QR-Code generation in PHP, now with bacon flavor
date: 2013-04-01 20:23:49 +0200
tags: [PHP]
---

First of, this is not an April Fool's joke. I actually planed to make one this year, but eventually gave up. Anyway, as some of you who follow me on Twitter may know, I worked on a modern QR-Code library, known as BaconQrCode, the past few weeks. Eventually it is now fully working and the public API can be considered stable.

<img src="http://stuff.dasprids.de/images/bacon-qrcode.png" alt="" style="float: right; margin-bottom: 10px; margin-left: 10px; " /> As a base for my implementation I had choosen the [ZXing library](http://code.google.com/p/zxing/) library. After writing the first unit tests though I noted that their implementation of the Reed-Solomon codec performed rather bad in PHP, so I exchanged it with the much faster implementation by [Phil Karn](http://www.ka9q.net/). As the rest of the library performed quite well and seemed much more logical, I choosed to stay with it instead of a different implementation like [qrencode](http://fukuchi.org/works/qrencode/), which formed the base for [PHP QR Code](http://phpqrcode.sourceforge.net/).

So far my complete implementation works, at least according to the unit tests and some personal testing. I'd like to encourage you to try it out and give me your feedback. I have implemented three different renderers so far, namely Bitmap (PNG), SVG and EPS. There is still a little bit of work to be done for me, like finishing the code-documentation, adding a few more unit tests and doing a few more PHP-specific optimizations, but all that work won't influence the public API anymore.

So, what are you waiting for? As always, you can find the library in the [Bacon repository on GitHub](https://github.com/Bacon/BaconQrCode) or include it in your application via [Packagist](https://packagist.org/packages/bacon/bacon-qr-code). If you are interested in more cool stuff, check out the [website of of Bacon](http://bacon.dasprids.de).

Oh and before I forget it. I may also add QR-Code decoding in the future. This would really be a feature you won't find in any other QR-Code library for PHP ;)