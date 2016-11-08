Class **Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection**
================================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\MetaData\\StrategyInterface <Phalcon_Mvc_Model_MetaData_StrategyInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadata/strategy/introspection.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Queries the table meta-data in order to introspect the model's metadata


Methods
-------

final public  **getMetaData** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

The meta-data is obtained by reading the column descriptions from the database information schema



final public  **getColumnMaps** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Read the model's column map, this can't be inferred



