Class **Phalcon\\Mvc\\Model\\Query**
====================================

This class takes a PHQL intermediate representation and executes it. 

.. code-block:: php

    <?php



Methods
---------

public **__construct** (*string* $phql)

Phalcon\\Mvc\\Model\\Query constructor



public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injection container



:doc:`Phalcon\\DI <../api/Phalcon_DI.rst>` public **getDI** ()

Returns the dependency injection container



*string* protected **_getQualified** ()

Replaces the model's name to its source name in a qualified-name expression



*string* protected **_getCallArgument** ()

Resolves a expression in a single call argument



*string* protected **_getFunctionCall** ()

Resolves a expression in a single call argument



*string* protected **_getExpression** ()

Resolves an expression from its intermediate code into a string



*array* protected **_getSelectColumn** ()

Resolves a column from its intermediate representation into an array used to determine if the resultset produced will be simple or complex



*string* protected **_getTable** ()

Resolves a table in a SELECT statement checking if the model exists



*array* protected **_getJoin** ()

Resolves a JOIN clause checking if the associated models exist



*string* protected **_getJoinType** ()

Resolves a JOIN type



*array* protected **_getJoins** ()

Resolves all the JOINS in a SELECT statement



*string* protected **_getLimitClause** ()

Returns a processed limit clause for a SELECT statement



*string* protected **_getOrderClause** ()

Returns a processed order clause for a SELECT statement



*string* protected **_getGroupClause** ()

Returns a processed group clause for a SELECT statement



protected **_prepareSelect** ()

Analyzes a SELECT intermediate code and produces an array to be executed later



*array* protected **_prepareInsert** ()

Analyzes an INSERT intermediate code and produces an array to be executed later



*array* protected **_prepareUpdate** ()

Analyzes an UPDATE intermediate code and produces an array to be executed later



*array* protected **_prepareDelete** ()

Analyzes a DELETE intermediate code and produces an array to be executed later



*array* public **parse** (*Phalcon\Mvc\Model* $manager)

Parses the intermediate code produced by Phalcon\\Mvc\\Model\\Query\\Lang generating another intermediate representation that could be executed by Phalcon\\Mvc\\Model\\Query



:doc:`Phalcon\\Mvc\\Query\\Resultset <../api/Phalcon_Mvc_Query_Resultset.rst>` protected **_executeSelect** ()

Executes the SELECT intermediate representation producing a Phalcon\\Mvc\\Query\\Resultset



:doc:`Phalcon\\Mvc\\Query\\Status <../api/Phalcon_Mvc_Query_Status.rst>` protected **_executeInsert** ()

Executes the INSERT intermediate representation producing a Phalcon\\Mvc\\Query\\Status



:doc:`Phalcon\\Mvc\\Query\\Status <../api/Phalcon_Mvc_Query_Status.rst>` protected **_executeUpdate** ()

Executes the UPDATE intermediate representation producing a Phalcon\\Mvc\\Query\\Status



:doc:`Phalcon\\Mvc\\Query\\Status <../api/Phalcon_Mvc_Query_Status.rst>` protected **_executeDelete** ()

Executes the DELETE intermediate representation producing a Phalcon\\Mvc\\Query\\Status



*mixed* public **execute** (*array* $placeholders)

Executes a parsed PHQL statement



