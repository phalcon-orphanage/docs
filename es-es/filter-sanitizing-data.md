---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filtro'
---
# Componente Filtro

* * *

## Filtrado de datos

Con la clase [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) se pueden limpiar y filtrar datos --dependiendo de cuáles limpiadores y filtros se utilicen. Por ejemplo, el limpiador `trim` eliminará todos los espacios antes y después de la entrada sin afectar su contenido. La descripción de cada limpiador (véase [Limpiadores predeterminados](https://docs.phalconphp.com/4.0/es-es/filter-sanitizers)) es útil para comprender y saber cuándo utilizarlo.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

// Devuelve 'Hola'
$localizador->sanitize('<h1>Hola</h1>', 'striptags');

// Devuelve 'Hola'
$localizador->sanitize('  Hola   ', 'trim');
```