# Class **Phalcon\\Di\\Service\\Builder**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di/service/builder.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class builds instances based on complex definitions

## Methods

private *mixed* **_buildParameter** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector, *int* $position, *array* $argument)

Resolves a constructor/call parameter

private **_buildParameters** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector, *array* $arguments)

Resolves an array of parameters

public *mixed* **build** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector, *array* $definition, [*array* $parameters])

Builds a service using a complex service definition