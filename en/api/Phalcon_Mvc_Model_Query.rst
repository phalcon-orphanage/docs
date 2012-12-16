Class **Phalcon\\Mvc\\Model\\Query**
====================================

*implements* :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This class takes a PHQL intermediate representation and executes it.  

.. code-block:: php

    <?php

     $phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c JOIN Brands AS b WHERE b.name = :name: ORDER BY c.name";
    
     $result = $manager->executeQuery($phql, array(
       'name' => 'Lamborghini'
     ));
    
     foreach ($result as $row) {
       echo "Name: ", $row->cars->name, "\n";
       echo "Price: ", $row->cars->price, "\n";
       echo "Taxes: ", $row->taxes, "\n";
     }



Constants
---------

*integer* **TYPE_SELECT**

*integer* **TYPE_INSERT**

*integer* **TYPE_UPDATE**

*integer* **TYPE_DELETE**

Methods
---------

public  **__construct** (*string* $phql)

Phalcon\\Mvc\\Model\\Query constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injection container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the dependency injection container



protected *string*  **_getQualified** ()

Replaces the model's name to its source name in a qualifed-name expression



protected *string*  **_getCallArgument** ()

Resolves a expression in a single call argument



protected *string*  **_getFunctionCall** ()

Resolves a expression in a single call argument



protected *string*  **_getExpression** ()

Resolves an expression from its intermediate code into a string



protected *array*  **_getSelectColumn** ()

Resolves a column from its intermediate representation into an array used to determine if the resulset produced is simple or complex



protected *string*  **_getTable** ()

Resolves a table in a SELECT statement checking if the model exists



protected *array*  **_getJoin** ()

Resolves a JOIN clause checking if the associated models exist



protected *string*  **_getJoinType** ()

Resolves a JOIN type



protected *array*  **_getJoins** ()

Resolves all the JOINS in a SELECT statement



protected *string*  **_getOrderClause** ()

Returns a processed order clause for a SELECT statement



protected *string*  **_getGroupClause** ()

Returns a processed group clause for a SELECT statement



protected *array*  **_prepareSelect** ()

Analyzes a SELECT intermediate code and produces an array to be executed later



protected *array*  **_prepareInsert** ()

Analyzes an INSERT intermediate code and produces an array to be executed later



protected *array*  **_prepareUpdate** ()

Analyzes an UPDATE intermediate code and produces an array to be executed later



protected *array*  **_prepareDelete** ()

Analyzes a DELETE intermediate code and produces an array to be executed later



public *array*  **parse** ()

Parses the intermediate code produced by Phalcon\\Mvc\\Model\\Query\\Lang generating another intermediate representation that could be executed by Phalcon\\Mvc\\Model\\Query



public  **cache** (*array* $cacheOptions)

Sets the cache parameters of the query



public  **getCacheOptions** ()

Returns the current cache options



public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()

Returns the current cache backend instance



protected :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **_executeSelect** ()

Executes the SELECT intermediate representation producing a Phalcon\\Mvc\\Model\\Resultset



protected :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`  **_executeInsert** ()

Executes the INSERT intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



protected :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **_getRelatedRecords** ()

Query the records on which the UPDATE/DELETE operation well be done



protected :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`  **_executeUpdate** ()

Executes the UPDATE intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



protected :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`  **_executeDelete** ()

Executes the DELETE intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



public *mixed*  **execute** (*array* $bindParams, *array* $bindTypes)

Executes a parsed PHQL statement



public  **setType** (*int* $type)

Sets the type of PHQL statement to be executed



public *int*  **getType** ()

Gets the type of PHQL statement executed



public  **setIntermediate** (*array* $intermediate)

Allows to set the IR to be executed



public *array*  **getIntermediate** ()

Returns the intermediate representation of the PHQL statement



