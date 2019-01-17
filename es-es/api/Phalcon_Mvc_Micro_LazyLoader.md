---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\Micro\LazyLoader'
---
# Class **Phalcon\Mvc\Micro\LazyLoader**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro/lazyloader.zep)

Lazy-Load of handlers for Mvc\Micro using auto-loading

## Métodos

public **getDefinition** ()

...

public **__construct** (*mixed* $definition)

Phalcon\Mvc\Micro\LazyLoader constructor

public *mixed* **__call** (*string* $method, *array* $arguments)

Initializes the internal handler, calling functions on it

public *mixed* **callMethod** (*string* $method, *array* $arguments, [[Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder])

Calling __call method