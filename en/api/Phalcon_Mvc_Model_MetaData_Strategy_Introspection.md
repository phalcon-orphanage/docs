# Class **Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection**

*implements* [Phalcon\Mvc\Model\MetaData\StrategyInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_Model_MetaData_StrategyInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadata/strategy/introspection.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Queries the table meta-data in order to introspect the model's metadata


## Methods
final public  **getMetaData** ([Phalcon\Mvc\ModelInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector)

The meta-data is obtained by reading the column descriptions from the database information schema



final public  **getColumnMaps** ([Phalcon\Mvc\ModelInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_ModelInterface) $model, [Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector)

Read the model's column map, this can't be inferred



