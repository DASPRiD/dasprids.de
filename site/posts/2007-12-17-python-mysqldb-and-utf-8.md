---
title: Python, MySQLdb and UTF-8
date: 2007-12-17 12:40:30 +0100
tags: [Python, MySQL]
---

So, after waisting way too much time with UTF-8 and MySQLdb, I've finally found a solutution, which seems to work with the newest version of MySQLdb. You maybe also know this problem with the following error message:

"UnicodeEncodeError:'latin-1' codec can't encode character ..."

This is because MySQLdb normally tries to encode everythin to latin-1. This can be fixed by executing the following commands right after you've etablished the connection:

```py
db.set_character_set('utf8')
dbc.execute('SET NAMES utf8;')
dbc.execute('SET CHARACTER SET utf8;')
dbc.execute('SET character_set_connection=utf8;')```

"db" is the result of MySQLdb.connect, and "dbc" is the result of db.cursor().

I hope this will help some guys out, not waisting as much time as I did for this issue.