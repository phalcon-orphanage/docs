---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

JavaScript に解釈されない不要な文字を削除します。 コメントは削除されます。 タブをスペースに置き換えます。 キャリッジリターンをラインフィードに置き換えます。 ほとんどのスペースやラインフィードが削除されます。

## メソッド

public **filter** (*mixed* $content)

JSMIN を使用してコンテンツをフィルタします。