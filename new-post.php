#!/usr/bin/php
<?php
// Little helper script to quickly create a new post
chdir(__DIR__);
require 'vendor/autoload.php';

if (count($argv) < 2) {
    echo "Missing title argument\n";
    exit(1);
}

$config = require 'config.php';

$title = implode(' ', array_splice($argv, 1));
$uuid = Ramsey\Uuid\Uuid::uuid4();
$date = new DateTimeImmutable();
$slug = (new BaconStringUtils\Slugifier())->slugify($title);

if (false !== strpos($title, ':')) {
    $yamlTitle = "'" . $title . "'";
} else {
    $yamlTitle = $title;
}

$markdown = '---
id: ' . $uuid . '
title: ' . $yamlTitle . '
date: ' . $date->format('Y-m-d H:i:s O') . '
tags: []
---

';

file_put_contents($config['site_path'] . '/posts/' . $date->format('Y-m-d') . '-' . $slug . '.md', $markdown);
echo $config['site_path'] . '/posts/' . $date->format('Y-m-d') . '-' . $slug . '.md' . "\n";
