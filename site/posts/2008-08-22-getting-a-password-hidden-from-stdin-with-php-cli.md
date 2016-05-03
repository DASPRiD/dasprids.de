---
title: Getting a password hidden from STDIN with PHP-CLI
date: 2008-08-22 23:03:28 +0200
tags: [PHP]
---

Today a friend asked me if it is possible to get a password with PHP-CLI, without the usual output of STDIN. I was kinda sure that there must be some way, and so I tried a bit around. I quickly found out, that there was no native PHP way, just a partly working one with non-blocking STDIN, but not really what I expected. So I searched a bit on the internet, and found a way, how to catch single characters on the shell. With this knowledge I was able to create a tiny function, which can both output nothing while entering the password as well as character replacing stars. For those of you who are interested in this piece of code, here it is:

**Note: This works on \*nix systems only!**

```php
<?php
/**
 * Get a password from the shell.
 *
 * This function works on *nix systems only and requires shell_exec and stty.
 *
 * @param  boolean $stars Wether or not to output stars for given characters
 * @return string
 */
function getPassword($stars = false)
{
    // Get current style
    $oldStyle = shell_exec('stty -g');

    if ($stars === false) {
        shell_exec('stty -echo');
        $password = rtrim(fgets(STDIN), "\n");
    } else {
        shell_exec('stty -icanon -echo min 1 time 0');

        $password = '';
        while (true) {
            $char = fgetc(STDIN);

            if ($char === "\n") {
                break;
            } else if (ord($char) === 127) {
                if (strlen($password) > 0) {
                    fwrite(STDOUT, "\x08 \x08");
                    $password = substr($password, 0, -1);
                }
            } else {
                fwrite(STDOUT, "*");
                $password .= $char;
            }
        }
    }

    // Reset old style
    shell_exec('stty ' . $oldStyle);

    // Return the password
    return $password;
}

// Get the password
fwrite(STDOUT, "Password: ");
$password = getPassword(true);

// Output the password
echo "Your password: " . $password . "\n";
```
