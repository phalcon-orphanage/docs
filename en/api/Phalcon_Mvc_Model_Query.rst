Class **Phalcon\\Mvc\\Model\\Query**
====================================

This class takes a PHQL intermediate representation and executes it. 

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



Methods
---------

public  **__construct** (*string* $phql)

Phalcon\\Mvc\\Model\\Query constructor



public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injection container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

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

Resolves a column from its intermediate representation into an array used to determine if the resulset produced will be simple or complex



protected *string*  **_getTable** ()

Resolves a table in a SELECT statement checking if the model exists



protected *array*  **_getJoin** ()

Resolves a JOIN clause checking if the associated models exist



protected *string*  **_getJoinType** ()

Resolves a JOIN type



protected *array*  **_getJoins** ()

Resolves all the JOINS in a SELECT statement



protected *string*  **_getLimitClause** ()

Returns a processed limit clause for a SELECT statement



protected *string*  **_getOrderClause** ()

Returns a processed order clause for a SELECT statement



protected *string*  **_getGroupClause** ()

Returns a processed group clause for a SELECT statement



protected  **_prepareSelect** ()

Analyzes a SELECT intermediate code and produces an array to be executed later



protected *array*  **_prepareInsert** ()

Analyzes an INSERT intermediate code and produces an array to be executed later



protected *array*  **_prepareUpdate** ()

Analyzes an UPDATE intermediate code and produces an array to be executed later



protected *array*  **_prepareDelete** ()

Analyzes a DELETE intermediate code and produces an array to be executed later



public *array*  **parse** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $manager)

Parses the intermediate code produced by Phalcon\\Mvc\\Model\\Query\\Lang generating another intermediate representation that could be executed by Phalcon\\Mvc\\Model\\Query



protected :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **_executeSelect** ()

Executes the SELECT intermediate representation producing a Phalcon\\Mvc\\Model\\Resultset



protected :doc:`Phalcon\\Mvc\\Model\\Query\\Status <Phalcon_Mvc_Model_Query_Status>`  **_executeInsert** ()

Executes the INSERT intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



protected :doc:`Phalcon\\Mvc\\Model\\Query\\Status <Phalcon_Mvc_Model_Query_Status>`  **_executeUpdate** ()

Executes the UPDATE intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



protected :doc:`Phalcon\\Mvc\\Model\\Query\\Status <Phalcon_Mvc_Model_Query_Status>`  **_executeDelete** ()

Executes the DELETE intermediate representation producing a Phalcon\\Mvc\\Model\\Query\\Status



public *mixed*  **execute** (*array* $placeholders)

Executes a parsed PHQL statement



