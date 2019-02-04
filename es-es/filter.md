---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Componente Filtro

* * *

- [Filtrado y Limpieza](filter-overview)
- [Built-in Sanitizers](filter-sanitizers)
- [Sanitizing data](filter-sanitizing)
- [Limpieza en controladores](filter-sanitizing-from-controllers)
- [Sanitizing Action Parameters](filter-sanitizing-action-parameters)
- [Filtrado de datos](filter-sanitizing-data)
- [Combining Sanitizers](filter-combining-sanitizers)
- [Complex Sanitizing and Filtering](filter-complex-sanitization-filtering)
- [Implementing your own Sanitizer](filter-custom)

* * *

## Filtrado y Limpieza

Una tarea fundamental en el desarrollo de software es la limpieza o saneamiento de datos enviados por los usuarios. Descuidar esta tarea o simplemente confiar en dichos datos sin sanearlos puede facilitar el acceso no autorizado al contenido de la aplicación, a los datos de otros usuarios, o incluso al servidor donde se encuentra alojada la aplicación.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327)

En Phalcon hay dos clases para limpiar datos: [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) y [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory).

## FilterLocatorFactory

Este componente crea un localizador con filtros predefinidos. Cada filtro se carga solo cuando es necesario ("lazy loading" en inglés) para lograr el máximo rendimiento. Para instanciar la clase [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) con los limpiadores preconfigurados se utiliza `newInstance()`

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();
```

Una vez instanciado, el localizador se puede utilizar en cualquier parte para limpiar el contenido (según las necesidades de la aplicación).

## FilterLocator

El filtro localizador (`FilterLocator`) también se puede utilizar como componente autónomo y sin necesidad de inicializar los filtros predeterminados.

```php
<?php

use MiApp\Limpiadores\HolaLimpiador;
use Phalcon\Filter\FilterLocator;

$servicios = [
    'hola' => HolaLimpiador::class,
];
$localizador = new FilterLocator($servicios);
$texto = $localizador->hola('Mundo');
```

> El contenedor `Phalcon\Di` trae de manera predeterminada el objeto `Phalcon\Filter\FilterLocator` junto con los demás limpiadores predefinidos. Se puede acceder al componente utilizando el nombre del filtro (`filter`). {: .alert .alert-info }