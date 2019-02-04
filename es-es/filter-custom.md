---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filtro'
---
# Componente Filtro

* * *

## Cómo implementar un limpiador propio

Se puede implementar un limpiador personalizado como función anónima. Sin embargo, si se prefiere crear una clase por cada limpiador, basta con implementar una función de autollamada mediente el uso del método mágico \[__invoke\]\[invoke\] con los parámetros pertinentes.

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

O también se puede implementar el limpiador en una clase:

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