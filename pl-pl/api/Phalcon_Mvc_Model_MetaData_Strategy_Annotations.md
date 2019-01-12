* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\MetaData\Strategy\Annotations'

* * *

# Class **Phalcon\Mvc\Model\MetaData\Strategy\Annotations**

*implements* [Phalcon\Mvc\Model\MetaData\StrategyInterface](/4.0/en/api/Phalcon_Mvc_Model_MetaData_StrategyInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/metadata/strategy/annotations.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Metody

final public **getMetaData** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector)

The meta-data is obtained by reading the column descriptions from the database information schema

final public **getColumnMaps** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector)

Read the model's column map, this can't be inferred