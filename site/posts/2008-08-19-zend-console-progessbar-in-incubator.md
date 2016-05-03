---
id: 487549d8-c4c1-4299-8ef4-60d94947c9e8
title: Zend_Console_ProgessBar in Incubator
date: 2008-08-19 18:43:15 +0200
tags: [Zend Framework]
---

I was bored the other day again, and thought about some tiny component, which would be as well helpful for some other developers. And there the idea came: Console applications need to show the status somehow, and what is a better way than a progressbar? Well, without telling much, you can kinda simply test it out yourself. Get `Zend/Console/ProgressBar.php` from the Incubator, and use the following test code:

```php
<?php
require_once 'Zend/Console/ProgressBar.php';

fwrite(STDOUT, "Please wait, while I sleep:\n");

$progressBar = new Zend_Console_ProgressBar();
for ($i = 1; $i <= 100; $i++) {
    $progressBar->update($i);
    usleep(1000000);
}

fwrite(STDOUT, "\n");
```

If you have any further improvements you want in this component, just tell me.

# Features:
- Custom min/max values
- Custom order of elements (percent, ETA, bar) as well as leaving out elements
- Automatic ETA calculation
- Automatic window width calculation