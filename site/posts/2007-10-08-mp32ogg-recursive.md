---
title: mp32ogg (recursive)
date: 2007-10-08 21:48:01 +0200
tags: [Bash]
---

Hi folks,

I have just finished my mp32ogg script, based on dirogg. dirogg is a very nice script to convert your entire mp3 collection into OGG. The problem with it was, that it just copied the ID3 tags from the MP3 file, which is deprecated in newer OGG version and therefor not supported by MPD (Music Player Daemon).

So I wrote my own script out of it, which gets the most common tags with id3info and writes them with vorbiscomment into the new OGG file. You can download the script from my [files section](/files/Scripts/mp32ogg).