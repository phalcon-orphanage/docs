---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

Menghapus karakter yang tidak perlu untuk JavaScript. Komentar akan dihapus. Tab akan diganti dengan spasi. Pengembalian kargo akan diganti dengan linefeeds. Sebagian besar spasi dan linefeeds akan dihapus.

## Metode

public **filter** (*mixed* $content)

Menyaring konten menggunakan JSMIN