---
title: A short status update about Zend Framework 3
date: 2014-04-01 00:00:00 +0200
tags: [Zend Framework, PHP]
description: Beware, a lot of things will change with Zend Framework 3.
---

As many of you surely know, the development of the next major version of Zend Framework pretty much came to a hold as the Zend team was and is still occupied with [apigility](http://www.apigility.org/). The maintenance of Zend Framework 2 is also coming along pretty slowly right now, although it's not completely stalled.

For those following the discussions in our development IRC channel more frequently, you probably saw that some of us are actually working on refactoring many components for Zend Framework 3, some a little more (like the completely rewritten [Dash Router](https://github.com/DASPRiD/Dash)), and some with just minor BC breaks like the service manager, the event manager and everything around forms.

There was quite a bit of discussions on IRC, the mailing list and on GitHub about how we could speed up the development of ZF3, so we could get a release out in a proper time. We not only came to a final decision, but also developed a plan to reduce the number of future BC breaks permanently. So what does this look like? Well, this is actully a plan with multiple steps.

First we are going to define all component layers via interfaces within Zend Framework itself. We won't ship any concrete implementations with it, but only make our MVC layer consume and work with those interfaces. The next step is developing reference implementations as separate projects, although still maintained by Zend. This way we are still able to ship a complete application framework, while making it easier to completely swap out specific components. The reference implementations will hook into the system as normal modules, so that they can also supply application configuration on their own.

So what is the timeframe for all this you may ask? As I wrote earlier, we don't want to fall behind too much, so we planned to finalize all the interfaces until the end of this month. We then will write bridges to older ZF2 components where required, so that they can already be used in the new architecture. In cases where we already have new implementations in place, like the router, service mager and such, we will alter those to follow the defined interfaces.

Another plus side on this new approach is that we can directly target PHP 5.5 on components here it makes sense to use new features, while other components can still be PHP 5.4. For those components which make use of PHP 5.5 features, we will parallely maintain PHP 5.4 compliant versions, which will automatically be selected by composer if the user is running an older PHP version.

If everything goes as planned, we should have a beta release of Zend Framework 3 out by May 16th, and a release candidate around June 1st. Proposals for all interfaces will be posted throughout this month, so make sure to watch the mailing list and join the discussion and bring in your ideas!