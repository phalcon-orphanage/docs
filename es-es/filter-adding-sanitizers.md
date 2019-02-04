---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filtro'
---
# Componente Filtro

* * *

## Creación de limpiadores

Se pueden añadir nuevos limpiadores a [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator). El nuevo limpiador puede ser una función anónima cuando se inicializa el localizador:

```php
<?php

use Phalcon\Filter\FilterLocator;

$servicios = [
    'md5' => function ($input) {
        return md5($input);
    },
];

$localizador   = new FilterLocator($servicios);
$limpio = $localizador->sanitize($valor, 'md5');
```

Ahora bien, si ya hay una instancia de `FilterLocator` (p.e. si se ha usado [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory) y `newInstance()`), basta con agregar el nuevo filtro:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

$localizador->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$limpio = $localizador->sanitize($valor, 'md5');
```

O, si lo prefiere, puede implementar el filtro en una clase:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

class IPv4
{
    public function __invoke($valor)
    {
        return filter_var($valor, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

$localizador->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Limpieza con el filtro 'ipv4' 
$IpFiltrada = $localizador->sanitize('127.0.0.1', 'ipv4');
```