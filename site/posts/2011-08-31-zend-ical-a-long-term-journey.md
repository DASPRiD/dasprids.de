---
id: 58a3584a-949b-41ea-b6ba-8419c151e5a4
title: Zend\Ical – A long term journey
date: 2011-08-31 18:00:54 +0200
tags: [Zend Framework]
---

About four years ago, I proposed Zend_Ical to the public, a component, which should enable everyone to read, create, and work with iCalender files. At that point, I had no idea about how complex the entire topic is. I were interrupted multiple times by other components with a higher priority, so I only worked on it from time to time. I where asked a lot about when the component would be done, and my usual answer was "I am working on it". Surely, most of the time, that was a lie.

Since creating the proposal, I refactored the Zend\Ical component about five times, especially the parser itself. About two weeks ago I started working on it again. I don't exactly know why, I somehow felt motivated. So I started finishing the parser and creating a complete new data structure whithin just two days with the help of libical, the official reference implementation. I occasionally noticed that I was working against the old [RFC 2445](http://www.ietf.org/rfc/rfc2445.txt), which was superseded by [RFC 5545](http://www.ietf.org/rfc/rfc5545.txt) in 2009. Fortunately it only added a few minor restrictions, but also a lot of clarifications of yet vague topics. After upgrading Zend\Ical to reflect the new RFC, I had to notice that there was a second, and also very important, [RFC 5546](http://www.ietf.org/rfc/rfc5546.txt), which adds further restrictions based on the calendar's METHOD property. This resulted in the data structure and parser being completly useless, so I had to make a final rewrite of it.

A week ago, I was able to finish the parser to a certain amount, enough to start testing the different value types. I adopted the recurrence iterator from libical, but fixed a few bugs and added missing restrictions. It is not complete by now, but it contains enough logic to work with most timezone definitions. After that, I searched for a way to create timezone components from timezone identifiers. The solution was the [Olson TZ database](ftp://elsie.nci.nih.gov/pub/) together with [vzic](http://code.google.com/p/tzurl/), which converts the Olson timezones to iCalendar timezones.

Right now I'm working on the timezone functionality, to be able to convert local dates to UTC timestamps and vice versa. If you are interested in the current code, you can take a look at it in my [GitHub repository](https://github.com/DASPRiD/zf2/tree/feature%2Fical/).