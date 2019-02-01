---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

Elimina los caracteres que son insignificantes a JavaScript. Los comentarios serán eliminados. Los tabuladores se reemplazarán con espacios. Retornos de carro se reemplazará con saltos de línea. Se eliminará la mayoría de los espacios y saltos de línea.

## Métodos

public **filter** (*mixed* $content)

Filtra el contenido utilizando JSMIN