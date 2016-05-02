---
title: Fetching random rows of MySQL efficiently
date: 2008-06-07 03:35:11 +0200
tags: [MySQL]
---

After having a discussion with a friend about how inefficient the usual way of fetching random table rows is, I came to the result that he really had the better way. Hence I will present you this solution here. First let's see, what's the problem about the normal way is.

Usually, you would try to get random rows with something like the following query:

```sql
SELECT `column` FROM `table` ORDER BY RAND() LIMIT 5```

So, you would get 5 random rows from the table and would be happy; but the database wouldn't. It had to assign a random number to every row in the table, to just fetch 5 of them. Well, while speaking about a table with about one hundred entries, this may be fine, but what about a table with one hundred thousand entries? There you will notice a huge performance slowdown.

So now you may ask, if there's a better solution; and yes, there is. It is quite simple, after you understood the principle. I assume at this point, that you have an auto-increment primary key, which should be the default for most tables. For the entire procedure you need three queries (when working with MySQL only; with a scripting language, you could do the second step on client-side, which I also suggest). The first one will determine the highest primary key in the table:

```sql
SELECT @max_id := MAX(`id`) FROM `table`;```

Now we have the highest ID and can do some tricks on the client side. Let's first try to get a single random row. For this, we need a random number between 1 and the highest ID:

```sql
@rand_id := FLOOR(1 + (RAND() * (@max_id - 1)));```

Now we will select a random row with this ID. as the row with this the generated random ID could be deleted yet, we have to some some trick:

```sql
SELECT `column` FROM `table` WHERE `id` >= @rand_id ORDER BY `id` ASC LIMIT 1```

So, now we have a single random column selected. But what, if we want more columns like in our beginning example? Just raising the limit wouldn't be a good idea, since we would get the four following rows. For this result, we have to digg a bit deeper. There is sadly no perfect way for it yet, and it requires some client-side programming.

After fetching the highest ID, you generate ten times so many random IDs as you want to fetch from the table, and concetinate them with ",". So we can want to get 5 rows, you generate 50 random IDs. Now you can try the following query:

```sql
SELECT `column` FROM `table` WHERE `id` IN ($randIds) LIMIT 5```

After fetching the result, you check, if you got the expected number of rows. If it doesn't match (which should very less the case), you can still fallback to the classic method with "ORDER BY RAND()".

**Update 1**
I have created a benchmark, to show you how huge the difference between those two methods is, click on the image to get it in full size:

[[][http://stuff.dasprids.de/images/benchmark-random-row-small.png]](http://stuff.dasprids.de/images/benchmark-random-row-full.png)

**Update 2**
As many people don't know, I've also written a [new article on devzone](http://www.dasprids.de/blog/2009/05/05/fetching-multiple-random-rows-from-a-database) which gives a better random results, and also works well with multiple results.