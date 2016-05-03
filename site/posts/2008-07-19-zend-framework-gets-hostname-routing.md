---
id: 42e9e1e0-9638-4fc0-aa9f-0852945e41bb
title: Zend Framework gets hostname routing
date: 2008-07-19 13:43:36 +0200
tags: [Zend Framework]
---

Introducing note: The examples in this article don't reflect the usage of the final hostname routing in 1.6 anymore.

There were many needs for it, in different mailing lists, forums and blogs, but it was never officially requested. There were also many approaches to accomplish it, but they were all kinda hacky. As I neeed it in an earlier project yet, were I had do do the hacky way as well, and now a new project came up, were I even need a more complex implementation, I decided to put a feature-rich hostname routing implementation into the ZF core itself. I did most of the implementation stuff myself, created unit tests and documenation, and [SpotSec](http://www.spotsec.com) did some finetuning on it afterwards.

Well, it will be included in ZF 1.6 RC1, which will come very soon. Between the final release will be an RC2, which gives you enough time to try it out and send in issues, if there are any. I really guess, this is a feature which was hardly required by many developers. For those of you who are interested yet, you can check it out from trunk. Here is the documentation part:

> **Hostname routing**
> You can also use the hostname for route matching. For simple matching there is a static hostname option:
>
> ```php
> <?php
> $route = new Zend_Controller_Router_Route(
>     array(
>         'host' => 'blog.mysite.com',
>         'path' => 'archive'
>     ),
>     array(
>         'module'     => 'blog',
>         'controller' => 'archive',
>         'action'     => 'index'
>     )
> );
> $router->addRoute('archive', $route);
> ```
>
> If you want to match parameters in the hostname, there is a regex option. In the following example, the subdomain is used as username parameter for the action controller. When assembling the route, you simply give the username as parameter, as you would with the other path parameters:
>
> ```php
> <?php
> $route = new Zend_Controller_Router_Route(
>     array(
>         'host' => array(
>             'regex'   => '([a-z]+).mysite.com',
>             'reverse' => '%s.mysite.com'
>             'params'  => array(
>                 1 => 'username'
>             )
>         ),
>         'path' => ''
>     ),
>     array(
>         'module'     => 'users',
>         'controller' => 'profile',
>         'action'     => 'index'
>     )
> );
> $router->addRoute('profile', $route);
> ```