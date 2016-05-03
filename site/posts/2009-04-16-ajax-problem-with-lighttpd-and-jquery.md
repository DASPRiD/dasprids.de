---
title: AJAX problem with Lighttpd and jQuery
date: 2009-04-16 17:22:00 +0200
tags: [JavaScript, Webserver]
---

While converting the environment of one of my business projects from Apache to Lighttpd, I experienced a problem, which didn't occur with Apache before. The following code worked fine in Aapache:

```js
$.post('http://example.com/ajax');
```

When executing the same request to Lighttpd, you receive the following error message:

```html
411 - Length Required
```

The solution was pretty simple, thought I only found it because it was working in another place with a similar case. The solution is to add an empty POST-object to the request (which will then send the content-length header):

```js
$.post('http://example.com/ajax', {});
```

Hopefully this will help somone who experienced the same problem.