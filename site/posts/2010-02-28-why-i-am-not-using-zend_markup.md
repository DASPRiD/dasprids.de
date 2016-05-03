---
title: Why I am not using Zend_Markup
date: 2010-02-28 19:48:19 +0100
tags: [Zend Framework]
---

About three months ago I took notice of the new [Zend_Markup](http://framework.zend.com/manual/en/zend.markup.html) component and I was very pleased to see such a component in Zend Framework. To my own fault I forgot about it follow the development process in the incubator and only remembered it again two weeks before the Zend Framework 1.10 release. By that time it had many flaws and inconsistency in the code, to name just a few of them:* Converter codes where called tags, which only was correct for the BBCode to HTML conversion* It didn't follow the PHP coding standard completly* The documentation was more than incomplete* There were majors bugs and inconsistency against other BBCode parsersThose were just the points I noticed when looking over the code. I surely informed the author [Pieter Kokx](http://kokx.nl/) about those issues, and he started to work them out. As there wasn't much time left, he didn't get everything done in time. His parser implementation was also really slow, as he was doing a character-by-character parsing like one would do in C, but which was not suitable in PHP. I showed him my implementation I also held a talk on [about tokens and lexemes](http://www.slideshare.net/dasprid/about-tokens-and-lexemes), after which he implemented it at least in the BBCode-parser.

When Matthew was ready to create the 1.10.0 tag, I mentioned to him that Zend_Markup would still require some more time before it could make it into the Zend Framework core, tho it was already merged into trunk by him. I was really wondering at that point, why Matthew didn't look deeper into the code while reviewing it, but on the other hand he cannot always understand the complete complexity of a component, so I don't really blame him for that. Tho he should have spotted that the documentation was incomplete and that the coding standard was violated at some points.

As he was going to create the 1.10.0 tag and I told him about some flaws which were still left, he moved the release two days further, so Pieter Kokx had still some time left to fix the missing parts. At that point I already forgot about the documentation and Zend_Markup made it into the 1.10 release.

A few days later, I wanted to implement Zend_Markup in my blog, replacing the old [StringParser_BBCode](http://www.christian-seiler.de/projekte/php/bbcode/index_en.html). After I converted all callbacks and implemented all BBCodes I started unit-testing Zend_Markup against my old implementation. At that point I started spotting other major bugs which should not be unique to my own code:* BBCodes withing a code-tag would have been rendered after the closing code-tag* Newline characters would be rendered around block-level elements* List-items cannot contain newlines within, as they are treated as stoppers for those* Converter codes were partly still called tagsI informed Pieter about those issues for sure, and the first bug was closed quickly. When I asked how he had solved it, he told me that specific tags were hard-coded within the parser now, instead of the renderer. This is surely a complete wrong approach, as the responsibility of treating contents of a tag should be within the parser, but withing the renderer. This meant to me that I couldn't add a php-tag easily, except if I would extend the renderer class. This was one of the points for me where I started thinking about using my own BBCode parser.

When I noticed the problem with newline characters, I told Pieter that I'd create an issue ticket together with a patch, which I planned to work like in my own implementation to handle newline-characters around and within tags. To illustrate the problem, think about the common usual BBCode:

```html
This is a nice list:

[list]
[*]First item
[*]Second item
[/list]

That's the list
```

This code would (somewhat) result in the following HTML with Zend_Markup:

```html
This is a nice list:<br />
<br />
<ul>
<li>First item</li>
<li>Second item</li>
</ul><br />
<br />
That's the list
```

As you can see, there will be unwanted newlines rendered around the <ul> block-level element. After some tinkering around I had to find out that it was impossible to implement without major refactoring, which would affect the backward compatibility and thus had no chance to be fixed before Zend Framework 2.0.

In the end there is a component left which has neither a complete documentation (many methods are not documented in the manual) nor it can be used to full extend as a usual BBCode-Parser. I ended up refactoring the BBCode-parser I partly wrote withing my company and [using it as final replacement](http://site.svn.dasprids.de/trunk/application/library/App/BBCode/) until I can see that Zend_Markup does not suffer by those teething problems.

Again I'm really disapointed that this component was rushed into the 1.10 release, which again was partly my fault by not noticing given problems earlier. The probably best thing would have been to postpone it to 1.11 or 2.0, so that the all problems requiring a BC-break could be fixed and the documentation be fixed, but now it's too late for that.