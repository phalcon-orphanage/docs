---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filtro'
---
# Componente Filtro

* * *

## Limpieza de datos

Es el proceso de desinfección o saneamiento que elimina caracteres específicos de un valor, bien por ser innecesarios o bien por ser indeseados por el usuario o aplicación. Al desinfectar la entrada nos aseguramos que la integridad de las aplicaciones permanecerá intacta.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

// devuelve 'alguien@ejemplo.com'
$localizador->sanitize('alg(uie)n@ejemp\lo.com', 'email');

// devuelve 'hola'
$localizador->sanitize('hola<<', 'string');

// devuelve '100019'
$localizador->sanitize('!100a019', 'int');

// devuelve '100019.01'
$localizador->sanitize('!100a019.01a', 'float');
```