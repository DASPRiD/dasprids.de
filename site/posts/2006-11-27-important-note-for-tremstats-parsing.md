---
id: 050f4e31-463a-476b-bdf2-af9a3a41b275
title: Important note for Tremstats Parsing
date: 2006-11-27 00:40:31 +0100
tags: [Tremstats]
---

I just found an important thing for the parsing of the logfiles. Because the parser needs the start and the end of a game in a logfile, to count everything in it, Tremulous has to be setup to only flush the logs at every mapchange. To do so, add the following line to your server.cfg and restart the server or change it by rcon, too:

```sh
set g_logsync 0
```