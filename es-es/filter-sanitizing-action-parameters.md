---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filtro'
---
# Componente Filtro

* * *

## Limpieza de los parámetros de la acción

Si se utiliza la "fábrica por defecto" [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) como contenedor de DI (Inyector de dependencias), el [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) ya se encuentra incluido, al igual que todos los limpiadores predeterminados. Para emplearlo se utiliza la palabra clave `filter`. Cuando no se utiliza el contenedor [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) es necesario definirlo como servicio, de tal manera que sea accessible por los controladores.

A continuación un ejemplo de cómo limpiar los valores pasados a las acciones del controlador:

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Mvc\Controller;

/**
 * Class ProductosController
 * 
 * @property FilterLocator $filter
 */
class ProductosController extends Controller
{
    public function mostrarAction($productoId)
    {
        $productoId = $this->filter->sanitize($productoId, 'absint');
    }
}
```