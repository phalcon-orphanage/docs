---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Filters\Cssmin'
---
# Class **Phalcon\Assets\Filters\Cssmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/cssmin.zep)

Minify the css - removes comments removes newlines and line feeds keeping removes last semicolon from last property

## 方法

public **filter** (*mixed* $content)

Filters the content using CSSMIN