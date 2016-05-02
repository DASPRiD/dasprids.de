---
title: 'Bugfix: Tremstats 0.5.1'
date: 2006-11-27 22:01:43 +0100
tags: [Tremstats]
---

After having much trouble yesterday with the parser, I've fixed it now. The problem was, that Tremstats was taking logfiles while Tremulous still had a pointer to the file. So now it works like this:

Firstly, Tremstats renames the original logfile to a temporary logfile. This let's Tremulous still write to the temporary file. In the second run, Tremstats looks, if a new original logfile exists. If yes, the temporary file is finishes and can be parsed. If not, Tremstats exists and tries it the next time. After parsing, it renames the original logfile again, and the game begins again.

I really advise you to download the new bugfix, to get all logs right.