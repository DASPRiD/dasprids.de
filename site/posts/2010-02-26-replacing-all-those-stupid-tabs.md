---
title: Replacing all those stupid tabs
date: 2010-02-26 12:32:38 +0100
tags: [Bash]
---

I joined an existing project in my company a week ago, and was very annoyed when I saw tabs and spaces mixed all over the project. After we merged everything together, I took some time today to get all those tabs expanded to spaces. As this is not completly trivial, I wanted to post to code so I don't have to remember it later:

```sh
for file in `
  find . -path '*/.svn' -prune -o -type f -print
  | grep -v "\.\(gif\|jpg\|png\|ico\|ttf\)"
`;
do
    expand -t4 $file > /tmp/expand.tmp;
    cp /tmp/expand.tmp $file;
done;
rm -f /tmp/expand.tmp;
```

This snipped will find all files which are not withing .svn directories, and also exclude common binary files which should not be expanded. Those files are then converted with the expand command, stored to a temporary file and then copied back to the original location. The reason for that indirect way is because you can't pipe the output to the file which you are currently reading.