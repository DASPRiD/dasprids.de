---
title: Zend Framework 2 Routing and Reverse Proxies
date: 2013-10-11 17:43:22 +0200
tags: [Zend Framework]
---

I came about a pretty interesting routing scenario in #zftalk.dev which was not quite easy to solve, so I thought about writing a blog post about that. A user was using an HTTP reverse proxy with the following configuration:

```httpd
ProxyPass /application/ http://www.example.com/
ProxyPassReverse /application/ http://www.example.com/```

As it turned out, reverse proxies will not pass any path information via headers, so this is not detectable at all. What's even worse is, that the matching works as expected, but the assembling will not have the path from the proxy included. This means that assembled URLs cannot be matched. Setting the base path to /myapplication/newpath/ doesn't work either, as matching will fail in that case then. The solution to the problem is a little bit dirty, but it should work in 99% of all cases. What you must basically do is allowing the router to do the matching with the detected base path, and afterwards set it to the proxy's path, so assembled URLs look correct. The problem with this approach is, that this only works with a single reverse proxy. As soon as you have more (for whatever reason), this will not work anymore. This is, as I wrote, because the reverse proxy does not pass any path information to the target server.

So after coming up with this idea, [Peter Hough](http://www.peterhough.co.uk/), who asked the question, worked out the code for this and supplied me the code for demonstration. The entire code is compressed into a single re-usable module, so everyone who needs it can just use it:

```php
class Module
{
    /**
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        
        // Trigger after matched route & before authorization modules.
        $eventManager->attach(
            MvcEvent::EVENT_ROUTE, 
            array($this, 'setBaseUrl'), 
            -100
        );
        
        // Trigger before 404s are rendered.
        $eventManager->attach(
            MvcEvent::EVENT_RENDER, 
            array($this, 'setBaseUrl'), 
            -1000
        );
    }
    
    /**
     * Triggered after route matching to set the base URL for assembling with ProxyPass.
     * 
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function setBaseUrl(MvcEvent $e) {
        $request = $e->getRequest();
        $baseUrl = $request->getServer('APPLICATION_BASEURL');

        if (!empty($baseUrl) && $request->getServer('HTTP_X_FORWARDED_FOR', false)) {
            $router = $e->getApplication()->getServiceManager()->get('Router');
            $router->setBaseUrl($baseUrl);
            $request->setBaseUrl($baseUrl);
        }
    }
}```

To enable the replacement, you have to set an environment variable named APPLICATION_BASEURL. If that one is not set or it is not a proxy request (accessing the application directly), nothing will happen. Setting the base URL is pretty simple.

Apache:

```
SetEnv APPLICATION_BASEURL "/application/"```

nginx:

```
fastcgi_param APPLICATION_BASEURL /application/;```

Again, thanks to Peter Hough providing the code.