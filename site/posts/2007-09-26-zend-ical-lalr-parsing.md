---
id: bfe85555-ec9f-4997-861e-b2f96608a2dc
title: 'Zend_Ical: LALR parsing'
date: 2007-09-26 23:37:58 +0200
tags: [Zend Framework]
---

Oh my god. I totally didn't knew, how much work such a LALR parser is. The RFC of the iCalendar format doesn't seem to end, and the parser grows and grows. I hope to finish the parser as soon as possible, means within the next five or six days.

After that, I will create the first public functions, which will be more than I thought now. After those are done, I'm going to set the proposal to a "ready for review" status. Then I can concentrate on finishing the public functions and in the end createing the writer methods.

To tell a bit about the writer method. This can either have one argument, which means, the data are saved into a new file, or no argument, if the original data were loaded from an existing file. In this case, the new data are saved back into the existing file. This means, that the constructor's parameter of Zend_Ical can be omitted now. If so, a new ICS file will be create.