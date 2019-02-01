---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

Elimina i caratteri che sono insignificanti in JavaScript. I commenti verranno rimossi. Le tabulazioni vengono sostituite con spazi. Ritorni a capo vengono sostituiti con caratteri di avanzamento riga. Spazi multipli e caratteri di avanzamento riga verranno rimossi.

## Metodi

public **filter** (*mixed* $content)

Filters the content using JSMIN