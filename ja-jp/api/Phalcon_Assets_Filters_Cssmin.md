---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Assets\Filters\Cssmin'
---
# Class **Phalcon\Assets\Filters\Cssmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/cssmin.zep)

cssの最小化 - コメントの除去 改行文字除去やラインフィード文字保持 最後のプロパティから最後のセミコロンを除去

## メソッド

public **filter** (*mixed* $content)

CSSMIN を使用してコンテンツをフィルタします。