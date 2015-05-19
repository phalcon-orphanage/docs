Class **Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection**
================================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\MetaData\\StrategyInterface <Phalcon_Mvc_Model_MetaData_StrategyInterface>`

Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Instrospection  Queries the table meta-data in order to instrospect the model's metadata


Methods
-------

final public *array*  **getMetaData** (*unknown* $model, *unknown* $dependencyInjector)

The meta-data is obtained by reading the column descriptions from the database information schema



final public *array*  **getColumnMaps** (*unknown* $model, *unknown* $dependencyInjector)

Read the model's column map, this can't be infered



