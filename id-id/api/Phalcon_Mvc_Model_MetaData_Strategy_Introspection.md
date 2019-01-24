---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\MetaData\Strategy\Introspection'
---
# Class **Phalcon\Mvc\Model\MetaData\Strategy\Introspection**

*implements* [Phalcon\Mvc\Model\MetaData\StrategyInterface](Phalcon_Mvc_Model_MetaData_StrategyInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/metadata/strategy/introspection.zep)

Queries pada daftar meta-data dalam pengenalan model pesanan metadata

## Metode

final public **getMetaData** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Meta-data diperoleh dengan membaca deskripsi kolom dari skema informasi database

final public **getColumnMaps** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Baca peta kolom model, ini tidak dapat disimpulkan