---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Di\Service\Builder'
---
# Class **Phalcon\Di\Service\Builder**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service/builder.zep)

Esta clase crea instancias basadas en definiciones complejas

## Métodos

private *mixed* **_buildParameter** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *int* $position, *array* $argument)

Resuelve un parámetro de un constructor o llamada

private **_buildParameters** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *array* $arguments)

Resuelve un arreglo de parámetros

public *mixed* **build** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *array* $definition, [*array* $parameters])

Crea un servicio utilizando una definición de servicio compleja