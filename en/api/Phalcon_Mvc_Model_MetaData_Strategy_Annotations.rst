Class **Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Annotations**
==============================================================

Queries the table meta-data in order to instrospect the model's metadata


Methods
---------

public *array*  **getMetaData** (:doc:`Phalcon\\Mvc\\ModelInstance <Phalcon_Mvc_ModelInstance>` $model, :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

The meta-data is obtained by reading the column descriptions from the database information schema



public *array*  **getColumnMaps** ()

Read the model's column map, this can't be infered



