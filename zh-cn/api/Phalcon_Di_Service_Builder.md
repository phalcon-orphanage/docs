* * *

layout: default language: 'en' version: '4.0' title: 'Phalcon\Di\Service\Builder'

* * *

# Class **Phalcon\Di\Service\Builder**

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/di/service/builder.zep" class="btn btn-default btn-sm">源码在GitHub</a>

This class builds instances based on complex definitions

## 方法

private *mixed* **_buildParameter** ([Phalcon\DiInterface](/3.4/en/api/Phalcon_DiInterface) $dependencyInjector, *int* $position, *array* $argument)

Resolves a constructor/call parameter

private **_buildParameters** ([Phalcon\DiInterface](/3.4/en/api/Phalcon_DiInterface) $dependencyInjector, *array* $arguments)

Resolves an array of parameters

public *mixed* **build** ([Phalcon\DiInterface](/3.4/en/api/Phalcon_DiInterface) $dependencyInjector, *array* $definition, [*array* $parameters])

Builds a service using a complex service definition