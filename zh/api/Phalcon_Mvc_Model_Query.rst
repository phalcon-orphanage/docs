Class **Phalcon\\Mvc\\Model\\Query**
====================================

<<<<<<< HEAD
This class takes a PHQL intermediate representation and executes it. 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This class takes a PHQL intermediate representation and executes it.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     $phql  = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c JOIN Brands AS b WHERE b.name = :name: ORDER BY c.name";
    
     $result = $manager->executeQuery($phql, array(
       'name' => 'Lamborghini'
     ));
    
     foreach ($result as $row) {
       echo "Name: ", $row->cars->name, "\n";
       echo "Price: ", $row->cars->price, "\n";
       echo "Taxes: ", $row->taxes, "\n";
     }



<<<<<<< HEAD
=======
Constants
---------

*integer* **TYPE_SELECT**

*integer* **TYPE_INSERT**

*integer* **TYPE_UPDATE**

*integer* **TYPE_DELETE**

>>>>>>> 0.7.0
Methods
---------

public  **__construct** (*string* $phql)

Phalcon\\Mvc\\Model\\Query constructor



<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the dependency injection container



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

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

<<<<<<< HEAD
Resolves a column from its intermediate representation into an array used to determine if the resulset produced will be simple or complex
=======
Resolves a column from its intermediate representation into an array used to determine if the resulset produced is simple or complex
>>>>>>> 0.7.0



protected *string*  **_getTable** ()

Resolves a table in a SELECT statement checking if the model exists



protected *array*  **_getJoin** ()

Resolves a JOIN clause checking if the associated models exist



protected *string*  **_getJoinType** ()

Resolves a JOIN type



protected *array*  **_getJoins** ()

Resolves all the JOINS in a SELECT statement



<<<<<<< HEAD
protected *string*  **_getLimitClause** ()

Returns a processed limit clause for a SELECT statement



=======
>>>>>>> 0.7.0
protected *string*  **_getOrderClause** ()

Returns a processed order clause for a SELECT statement



protected *string*  **_getGroupClause** ()

Returns a processed group clause for a SELECT statement



<<<<<<< HEAD
protected  **_prepareSelect** ()
=======
protected *array*  **_prepareSelect** ()
>>>>>>> 0.7.0

Analyzes a SELECT intermediate code and produces an array to be executed later



protected *array*  **_prepareInsert** ()

Analyzes an INSERT intermediate code and produces an array to be executed later



protected *array*  **_prepareUpdate** ()

Analyzes an UPDATE intermediate code and produces an array to be executed later



protected *array*  **_prepareDelete** ()

Analyzes a DELETE intermediate code and produces an array to be executed later



<<<<<<< HEAD
public *array*  **parse** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $manager)
=======
public *array*  **parse** ()
>>>>>>> 0.7.0

Parses the intermediate code produced by Phalcon\\Mvc\\Model\\Query\\Lang generating another intermediate representation that could be executed by Phalcon\\Mvc\\Model\\Query



<<<<<<< HEAD
protected :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **_executeSelect** ()
=======
public  **cache** (*array* $cacheOptions)

Sets the cache parameters of the query



public  **getCacheOptions** ()

Returns the current cache options



public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()

Returns the current cache backend instance



protected :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **_executeSelect** ()
>>>>>>> 0.7.0

Executes the SELECT intermediate representation producing a Phalcon\\Mvc\\Model\\Resultset



<<<<<<< HEAD
protected :doc:`Phalcon\\Mvc\\Model\\Query\\Status <Phalcon_Mvc_Model_Query_Status>`  **_executeInsert** ()
=======
protected :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`  **_executeInsert** ()
>>>>>>> 0.7.0

Executes the INSERT intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



<<<<<<< HEAD
protected :doc:`Phalcon\\Mvc\\Model\\Query\\Status <Phalcon_Mvc_Model_Query_Status>`  **_executeUpdate** ()
=======
protected :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **_getRelatedRecords** ()

Query the records on which the UPDATE/DELETE operation well be done



protected :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`  **_executeUpdate** ()
>>>>>>> 0.7.0

Executes the UPDATE intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



<<<<<<< HEAD
protected :doc:`Phalcon\\Mvc\\Model\\Query\\Status <Phalcon_Mvc_Model_Query_Status>`  **_executeDelete** ()
=======
protected :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`  **_executeDelete** ()
>>>>>>> 0.7.0

Executes the DELETE intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



<<<<<<< HEAD
public *mixed*  **execute** (*array* $placeholders)
=======
public *mixed*  **execute** (*array* $bindParams, *array* $bindTypes)
>>>>>>> 0.7.0

Executes a parsed PHQL statement



<<<<<<< HEAD
=======
public  **setType** (*int* $type)

Sets the type of PHQL statement to be executed



public *int*  **getType** ()

Gets the type of PHQL statement executed



public  **setIntermediate** (*array* $intermediate)

Allows to set the IR to be executed



public *array*  **getIntermediate** ()

Returns the intermediate representation of the PHQL statement



>>>>>>> 0.7.0
