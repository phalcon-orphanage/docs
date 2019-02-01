---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

JavaScript'e göre önemsiz olan karakterleri siler. Yorumlar kaldırılacaktır. Tablar, boşluklar ile değiştirilecek. Satır başları, satır atlamaları ile değiştirilecektir. Çoğu boşluk ve satır atlamaları silinecektir.

## Metodlar

public **filter** (*mixed* $content)

İçeriği JSMIN kullanarak filtreler