---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

Deletes the characters which are insignificant to JavaScript. Comments will be removed. Tabs will be replaced with spaces. Carriage returns will be replaced with linefeeds. Most spaces and linefeeds will be removed.

## Methods

public **filter** (*mixed* $content)

Filters the content using JSMIN