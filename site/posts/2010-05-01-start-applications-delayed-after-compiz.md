---
title: Start applications delayed after compiz
date: 2010-05-01 19:38:25 +0200
tags: [Compiz]
---

Since I have some applications which should start with gnome (which are Thunderbird, Empathy and X-Chat), I surely like to have them in popping up in certain places with fixed sizes. Since DevilsPie does not work very well with compiz, I'm using compiz' features itself to position the windows. The problem is, compiz needs some time to start, and thus applications may not be positioned at start. I solved this problem with a small bash script which is executed as startup program:

```sh
#!/bin/bash

function isCompizRunning()
{
    local result=$(dbus-send --print-reply \
                             --type=method_call \
                             --dest=org.freedesktop.compiz \
                               /org/freedesktop/compiz/dbus/screen0 \
                               org.freedesktop.compiz.list \
                   | wc -l)

    echo "$result"
}

while [ $(isCompizRunning) = 0 ]
do
    sleep 1
done

thunderbird &
empathy &
xchat &```

Hopefully this will help some people having the same problem.