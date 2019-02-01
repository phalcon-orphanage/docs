---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

Löscht die Zeichen, die für JavaScript unbedeutend sind. Kommentare werden entfernt. Tabs werden durch Leerzeichen ersetzt. Zeilenumbrüche werden mit Zeilenvorschüben ersetzt. Die meisten Leerzeichen und Zeilenumbrüche werden entfernt.

## Methoden

public **filter** (*mixed* $content)

Filtert den Inhalt mit JSMIN