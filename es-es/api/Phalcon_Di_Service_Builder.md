* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Di\Service\Builder'

* * *

# Class **Phalcon\Di\Service\Builder**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/di/service/builder.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

This class builds instances based on complex definitions

## Métodos

private *mixed* **_buildParameter** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector, *int* $position, *array* $argument)

Resolves a constructor/call parameter

private **_buildParameters** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector, *array* $arguments)

Resolves an array of parameters

public *mixed* **build** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector, *array* $definition, [*array* $parameters])

Builds a service using a complex service definition