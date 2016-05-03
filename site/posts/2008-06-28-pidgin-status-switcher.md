---
id: 76e3be36-4499-4ea6-af55-2423a32d0dec
title: Pidgin Status Switcher
date: 2008-06-28 14:39:03 +0200
tags: [Python]
---

Previously I always had the problem while playing, that some guys were always messaging me, and the popups made trouble while my games running in fullscreen. Now I finally found the perfect solution to solve that problem. I wrote a tiny script, which has two options. It can a) set the status of your Pidgin offline and b) restore the last status. I then wrote another shell script, which calls the status switcher, pushing Pidgin in offline mode, then starts the game, and afterwards restores the Pidgin status again. The latter script shouldn't really matter you, but here's the status switcher script. It requires you for having Pidgin for sure, Python and a *nix system with DBUS:

```py
#!/usr/bin/python
import dbus, gobject, os, sys

# Status constant for beeing offline
STATUS_OFFLINE = 1

# File to store the status 
STORAGE_FILE = os.path.abspath(sys.path[0]) + '/storedStatus'

# Get purple DBUS object
bus    = dbus.SessionBus()
obj    = bus.get_object("im.pidgin.purple.PurpleService",
                        "/im/pidgin/purple/PurpleObject")
purple = dbus.Interface(obj, "im.pidgin.purple.PurpleInterface")

# Check command line arguments
method = None
if len(sys.argv) > 1:
    method = sys.argv[1]

if method not in ('--offline', '--restore'):
    print 'Use either with --offline or --restore' 
    sys.exit(0)
    
# Check what to do
if method == '--offline':
    # Fetch the current status and store it for later restore
    currentStatus = purple.PurpleSavedstatusGetCurrent()
    storeFile     = file(STORAGE_FILE, 'w')
    print >> storeFile, currentStatus
    storeFile.close()

    # Create the offline status and activate it
    offlineStatus = purple.PurpleSavedstatusNew("", STATUS_OFFLINE)
    purple.PurpleSavedstatusActivate(offlineStatus)
    
    print 'Gone offline'
else:
    try:
        # Read the stored status
        storeFile    = file(STORAGE_FILE, 'r')
        storedStatus = int(storeFile.readline())
        storeFile.close()
        
        # Restore the stored status
        purple.PurpleSavedstatusActivate(storedStatus)
        
        print 'Status restored'
    except:
        print 'Could not restore status'```

I hope this is helpfful for somebody.