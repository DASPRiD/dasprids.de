---
title: About {@inheritDoc} and other useless documentation
date: 2013-10-28 01:33:52 +0100
tags: [PHP]
description: Why I don't like the redundant usage of {@inheritDoc} and pointless return type documentation like void.
---

I've seen and followed many different documentation rules in my life. Everytime when I was taught something new for code documentation and it made any sense to me, I tend to addopt these pretty quickly. When looking back, some of the rules certainly made sense, especially when our poor IDEs weren't as good with resolving documentation as they are now. What I want to teach you with this article is, how to reduce redundant documentation and keep it as short as possible, without loosing any documentation from auto completion or API docs.

First, let's talk about the @return annotation. It became pretty popular in PHP to write "@return void" when the method will not return anything. Techncially though, it is actually returning "null". But writing "@return null" isn't actually helping much either. Since you are really not returning anything, it is perfectly fine to ommit the @return annotation completely. Any IDE or API-doc generator will interpret this as the classical "@return void".

So, let us start with a very simple interface to demonstrate all following usecases:

```php
interface ToasterInterface
{
    /**
     * Toast a bread.
     *
     * This method will toast a bread for a given amount of seconds.
     *
     * @param Bread $bread
     * @param int   $time
     */
    public function toast(Bread $bread, $time);
}
```

When generating API-docs from this with phpDocumentor, it will look like this:

```
Toast a bread.

This method will toast a bread for a given amount of seconds.

    access: public

void toast (Bread $bread, int $time)

    Bread $bread
    int $time
```

There's nothing really special about this you haven't seen before. Now there are quite a few ways people take to document the method in an implementation. I won't list all here to keep the article short, so let's just get to the point. If your method doesn't do anything special over the already documented interface, just leave the doc-block out. Every API-doc generator will take everything from the parent, which is in this case the short description, long description and all annotations. Now let's say that you want to change something, e.g. you throw exceptions in your implementation. In that case, you'd only include the @throws annotation in your doc block:

```php
class AwesomeToaster implements ToasterInterface
{
    /**
     * @throws RuntimeException
     */
    public function toast(Bread $bread, $time) {}
}
```

In case you want to override the short description, you can so so easily:

```php
class AwesomeToaster implements ToasterInterface
{
    /**
     * Toast a white-bread.
     */
    public function toast(Bread $bread, $time) {}
}
```

Let's come to the {@inheritDoc} inline annotation. First I have to clearify that you cannot override the long description without having a short description first. The {@inheritDoc} annotation is there to include the parent's long description, so you can actually use that one and extending it with your own documentation. In your case, this could look like this:

```php
class AwesomeToaster implements ToasterInterface
{
    /**
     * Toast a white-bread.
     *
     * {@inheritDoc} It only accepts white-bread thought.
     */
    public function toast(Bread $bread, $time) {}
}
```

There you go. We have the original description and on top of that our implementation-specific one. This would output like this:

```
Toast a white-bread.

This method will toast a bread for a given amount of seconds.
It only accepts white-bread thought.

    access: public

void toast (Bread $bread, int $time)

    Bread $bread
    int $time
```

A last thing about overriding @param keywords. This is possible, but will make no sense most of the time, since a parent pretty much describes what the method should be able to take. In some cases you may want to widen the allowed range of values though. If that's the case, you only have to put the @param annotation for that single argument in your doc-block, and not repeat any of the other annotations.

I hope that this helps a few people to reduce the insaneness of way too much redundant and copy-pasted inline documentation and gives you a bit more time to actually produce awesome code.

**Update**
I changed the Toast to Bread, based on Geeh's comment.