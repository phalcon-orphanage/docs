---
layout: article
language: 'el-gr'
version: '4.0'
title: 'Phalcon\Mvc\Model\MetaData\Strategy\Introspection'
---
# Class **Phalcon\Mvc\Model\MetaData\Strategy\Introspection**

*implements* [Phalcon\Mvc\Model\MetaData\StrategyInterface](Phalcon_Mvc_Model_MetaData_StrategyInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/metadata/strategy/introspection.zep)

Queries the table meta-data in order to introspect the model's metadata

## Methods

final public **getMetaData** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Τα από μεταδεδομένα δεδομένων αποκτώνται διαβάζοντας τις της στήλης το σχήμα πληροφοριών βάσης περιγραφές

final public **getColumnMaps** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Read the model's column map, this can't be inferred