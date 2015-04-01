Class **Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection**
================================================================

Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Instrospection  Queries the table meta-data in order to instrospect the model's metadata


Methods
---------

public *array*  **getMetaData** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

The meta-data is obtained by reading the column descriptions from the database information schema



public *array*  **getColumnMaps** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Read the model's column map, this can't be infered



