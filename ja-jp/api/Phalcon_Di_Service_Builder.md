---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Di\Service\Builder'
---
# Class **Phalcon\Di\Service\Builder**

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service/builder.zep)

This class builds instances based on complex definitions

## メソッド

private *mixed* **_buildParameter** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *int* $position, *array* $argument)

Resolves a constructor/call parameter

private **_buildParameters** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *array* $arguments)

Resolves an array of parameters

public *mixed* **build** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *array* $definition, [*array* $parameters])

Builds a service using a complex service definition