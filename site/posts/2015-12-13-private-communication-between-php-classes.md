---
title: Private communication between PHP classes
date: 2015-12-13 18:08:59 +0100
tags: [PHP, Software Architecture]
description: How to protect commnication between your internal PHP classes.
---

# Introduction
I am currently working on [BaconPdf](https://github.com/Bacon/BaconPdf), and while doing so, I ran into an interesting problem. Consider that there are two classes, namely Document and Page. The user may extend both classes to add specific functionality, but they may never alter the underlying data structure, as that would mean that we'd always have to validate it completely whenever a Page is added to the Document. Thus we must prevent the user from ever getting access to that data structure.

# Implementation
Since we don't have friend classes or private classes in PHP, this is kinda tricky. You cannot let the Document ask the Page for the data structure, as the user could do the same then. You also cannot let the Page tell the Document directly about it, as the user could tell the Document any invalid data structure then as well. Thus we need some kind of verification process, which doesn't involve validating the entire data structure. Thus I came up with the following architecture, which is somewhat related to the visitor design pattern. Consider the following Document class:

```php
class Document
{
    private $pagesData = [];
    
    final public function addPage(Page $page)
    {
        $page->acceptDocument($this);
    }
    
    final public function addPageData(Page $page, $pageData)
    {
        if (!$page->verifyPageData($pageData)) {
            throw new DomainException('Supplied data are not coming from a Page');
        }
        
        $this->pagesData[] = $pageData;
    }
}
```

This is pretty simple and explained just as quickly. There is a public function specifically designed for users, where they can simply call `addPage()` with their `Page` object and that's all they have to care about. Now there's an additional public method called `addPageData()` which will accept page data, but only together with a `Page` object. The document will ask the given page to verify the data it received and throw a DomainException if the verification fails.

Since the `$pagesData` property is private, even an extending class will not be able to read it or write to it. The `addPageData()` method has to be final though, as the user could otherwise intercept the `$pageData` in an extending class. The `addPage()` method has to be final as well, the reason for that is explained later. Now lets take a look at the `Page` class:

```php
class Page
{
    private $pageData;
    
    public function __construct()
    {
        $this->pageData = new stdClass();
    }

    final public function acceptDocument(Document $document)
    {
        $document->addPageData($this, $this->pageData);
    }
    
    final public function verifyPageData(stdClass $pageData)
    {
        return $pageData === $this->pageData;
    }
}
```

Here we have to methods again, of which none are actually meant for the user to be called. But even when they do call them, they can do no harm to the underlying data or even access it. Now when the user calls `addPage()` on the Document, it will pass itself to `acceptDocument()` on the `Page` object. This page object will tell the document to add its private `$pageData`, together with itself as an instance for verifying the data. The document will then call the `verifyPageData()` method on the `Page` object to make sure that the page data actually originate from that `Page` object.

Since the page data are an object, all we really have to do to verify them is to check that they reference the same object. The `verifyPageData()` method has to be final of course, as otherwise the user could extend the class and override the method to always return true. The `acceptDocument()` method does need to be final, as a user could override it and make it do nothing, which would break the entire workflow.

So, to come back to the earlier question, why the `addPage()` method on the document has to be final. The user could not only add pages to the document via the `addPage()` method, but also by calling `acceptDocument()` on the `Page` object. Thus, if a user would override the `addPage()` method to add additional functionality, it would be circumvented by adding the page via the `acceptDocument()` method. That's why there must not be any additional functionality in the `addPage()` method, it actually only exists for convenience there and to make the usage a bit more logical.

# Conclusion
The entire approach is of course a lot of logic, and while it exposes three public functions which are technically not meant for the user, they cannot do any harm to the underlying structure by getting their hands on it. As this is PHP, they can still use reflection or abuse bound closures, but I'd consider that cheating. The important part is, that you cannot break the architecture via the public interface. It stil has the downside though that you do have a public interface, to which a change would be a backward incompatibility break, which must not be done in minor versions of a software, if you follow semver.

