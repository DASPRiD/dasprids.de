---
title: Decoding JamLegend tracks
date: 2010-12-22 15:45:51 +0100
tags: [PHP, JamLegend]
---

About half a year back in time, I was playing a bit [JamLegend](http://www.jamlegend.com), and was a bit annoyed by the bad performance of the Flash-based frontend on Linux. Thus I raised a [feature request](http://getsatisfaction.com/jamlegend/topics/provide_an_html5_interface_instead_of_flash) and created a prototype of the Flash-frontend [in HTML5](http://stuff.dasprids.de/testing/jamlegend-html5/). At that time, I didn't had any time to create an actually playable version, also because I didn't had any so called jam-tracks for any song.

A few days ago, I was looking at the prototype again, and I thought that an actually playable version would be pretty cool anyway. So I tried to download a song from JamLegend together with its track.jam file. This was not that easy, as every request to the song-page limits the access to the song and the track.jam file to a single download. That was pretty easy to work around, as I simply canceled the flash player and thus was able to download both the song and the track.jam file. The song is a simple MP3, so there's no magic there. The interesting part is the track.jam file.

After looking around how to contribute to JamLegend and investigating the decompiled Flash player (the resulting code was mostly garbage), I found out, that the track.jam file had to be some kind of MIDI. After analyzing the track.jam file, I found out, that it wasn't a MIDI, so I looked at the decompiled code again. Apart from many crap lines, I finally found an AES encryption integrated in the MIDI parser class. As the cipher and the key were both nicely readable, I was able to create a small decryption script:

```php
$cipher = 'rijndael-128';
$mode   = 'ecb';
$key    = pack('H*', '280f9d1a5eb28306c15a0bf40a2554e82d5134388bc1a144dcf3aed93d71ce50');

$decrypted = mcrypt_decrypt($cipher, $key, file_get_contents('track.jam'), $mode);```

This isn't the entire decoding. As I had to find out, the data were also padded with PKCS#5, which is not supported by mcrypt. Thankfully, a user had already posted a workaround in the PHP manual comments:

```php
$pad = ord($decrypted{strlen($decrypted)-1});

if ($pad > strlen($decrypted)) {
    exit('Padding is larger than data');
}

if (strspn($decrypted, chr($pad), strlen($decrypted) - $pad) !== $pad) {
    exit('Could not unpad data');
}

$unpadded = substr($decrypted, 0, -1 * $pad); ```

But this wasn't the end. After looking at the decrypted data, I could still not recognize a MIDI file. So, back to the decompiled code and after another hour, I found out that the MIDI data were appended to some other data, which I couldn't clearly identify. But since MIDI files always have a header at the very first byte position, I could simply truncate everything which comes before it:

```php
$headerPos = strpos($unpadded, 'MThd');

if ($headerPos === false) {
    exit('No MIDI header found');
}

$midi = substr($unpadded, $headerPos);```

The result finally was a playable MIDI file. Now I only had to identify, how the notes were stored for the player. I first looked at Frets on Fire, on which track.jam files by JamLegend are based on, but that didn't completely match. So I opened the MIDI file with Rosegarden, and the result was the following: Tabs for normal difficulty are on C3 and the two following notes, skilled difficulty on C4 and the three following notes, and so on.

With this knowledge, I should now be able to create a fully working prototype. As soon as there is something to play with, you'll surely read a tweet about it.