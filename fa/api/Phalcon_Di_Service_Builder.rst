Class **Phalcon\\Di\\Service\\Builder**
=======================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di/service/builder.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class builds instances based on complex definitions


Methods
-------

private *mixed* **_buildParameter** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *int* $position, *array* $argument)

Resolves a constructor/call parameter



private  **_buildParameters** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *array* $arguments)

Resolves an array of parameters



public *mixed* **build** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *array* $definition, [*array* $parameters])

Builds a service using a complex service definition



