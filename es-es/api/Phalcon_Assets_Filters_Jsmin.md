* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Filters\Jsmin'

* * *

# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](/4.0/en/api/Phalcon_Assets_FilterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/filters/jsmin.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Deletes the characters which are insignificant to JavaScript. Comments will be removed. Tabs will be replaced with spaces. Carriage returns will be replaced with linefeeds. Most spaces and linefeeds will be removed.

## Métodos

public **filter** (*mixed* $content)

Filters the content using JSMIN