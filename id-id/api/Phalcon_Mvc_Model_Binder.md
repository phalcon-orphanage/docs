---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Binder'
---
# Class **Phalcon\Mvc\Model\Binder**

*implements* [Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/binder.zep)

Phalcon\Mvc\Model\Binding

Ini adalah kelas untuk model mengikat menjadi params untuk handler

## Metode

public **getBoundModels** ()

Array untuk menyimpan model terikat aktif

publik **getOriginalValues** ()

Array untuk nilai asli

public **__construct** ([[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache])

Phalcon\Mvc\Model\Binder constructor

public **setCache** ([Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache)

Mendapat contoh tembolok

public **getCache** ()

Menetapkan contoh tembolok

public **bindToHandler** (*mixed* $handler, *array* $params, *mixed* $cacheKey, [*mixed* $methodName])

Bind model menjadi params di handler yang tepat

protected **findBoundModel** (*mixed* $paramValue, *mixed* $className)

Temukan model dengan nilai param.

protected **getParamsFromCache** (*mixed* $cacheKey)

Dapatkan params kelas dari cache dengan kunci

protected **getParamsFromReflection** (*mixed* $handler, *array* $params, *mixed* $cacheKey, *mixed* $methodName)

Dapatkan params modifikasi untuk handler menggunakan refleksi