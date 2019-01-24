---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\ManagerInterface'
---
# Interface **Phalcon\Mvc\Model\ManagerInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/managerinterface.zep)

## Metode

abstract public **initialize** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setModelSource** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $source)

...

abstract public **getModelSource** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setModelSchema** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $schema)

...

abstract public **getModelSchema** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

...

abstract public **setReadConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

...

abstract public **getReadConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setWriteConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

...

abstract public **getWriteConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getReadConnection** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getWriteConnection** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstrak publik **isInitialized** (*mixed* $modelName)

...

abstrak publik **getLastInitialized** ()

...

publik abstrak **beban** (*campur* $modelName, [*campur* $newInstance])

...

abstract public **addHasOne** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...

abstract public **addBelongsTo** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...

abstract public **addHasMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...

publik abstrak **ada Milik Untuk** (*campur* $modelName, *campur* $modelRelation)

...

publik abstrak **ada Banyak Memiliki** (*campur* $modelName, *campur* $modelRelation)

...

publik abstrak **ada Memiliki Satu** (*campur* $modelName, *campur* $modelRelation)

...

abstract public **getBelongsToRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

...

abstract public **getHasManyRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

...

abstract public **getHasOneRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

...

abstract public **getBelongsTo** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getHasMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getHasOne** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getHasOneAndHasMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstrak publik **mendapatkan Hubungan** (*campur* $modelName)

...

abstrak publik **mendapatkan Hubungan Antara** (*campur* $first, *campur* $second)

...

abstrak publik **buat Pernyataan** (*campur* $phql)

...

publik abstrak **jalankan Pernyataan** (*campur* $phql, [*campur* $placeholders])

...

publik abstrak **buat Pembangun** ([*campur* $params])

...

abstract public **addBehavior** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface) $behavior)

...

abstract public **notifyEvent** (*mixed* $eventName, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

...

abstract public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $eventName, *mixed* $data)

...

publik abstrak **dapatkan Pertanyaan Terakhir** ()

...

publik abstrak **mendapatkan Hubungan Dengan Alias** (*campur* $modelName, *campur* $alias)

...