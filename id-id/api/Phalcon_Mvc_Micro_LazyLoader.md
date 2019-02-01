---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Micro\LazyLoader'
---
# Class **Phalcon\Mvc\Micro\LazyLoader**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro/lazyloader.zep)

Lazy-Load of handlers for Mvc\Micro using auto-loading

## Metode

publik **getDefinition** ()

...

publik **__construct** (*mixed* $definition)

Phalcon\Mvc\Micro\LazyLoader constructor

publik *campuran* **__memanggil** (*tali* $method, *array* $arguments)

Menginiliasasi handler internal, memangil fungsi di atasnya

public *mixed* **callMethod** (*string* $method, *array* $arguments, [[Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder])

Metode Calling __call