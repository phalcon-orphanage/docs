---
layout: default
language: 'pl-pl'
version: '4.0'
title: 'Phalcon\Mvc\Model\Binder'
---
# Class **Phalcon\Mvc\Model\Binder**

*implements* [Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/binder.zep)

Phalcon\Mvc\Model\Binding

This is an class for binding models into params for handler

## Metody

public **getBoundModels** ()

Array for storing active bound models

public **getOriginalValues** ()

Array for original values

public **__construct** ([[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache])

Phalcon\Mvc\Model\Binder constructor

public **setCache** ([Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache)

Gets cache instance

public **getCache** ()

Sets cache instance

public **bindToHandler** (*mixed* $handler, *array* $params, *mixed* $cacheKey, [*mixed* $methodName])

Bind models into params in proper handler

protected **findBoundModel** (*mixed* $paramValue, *mixed* $className)

Find the model by param value.

protected **getParamsFromCache** (*mixed* $cacheKey)

Get params classes from cache by key

protected **getParamsFromReflection** (*mixed* $handler, *array* $params, *mixed* $cacheKey, *mixed* $methodName)

Get modified params for handler using reflection