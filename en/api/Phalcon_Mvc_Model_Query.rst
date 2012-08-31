Class **Phalcon\\Mvc\\Model\\Query**
====================================

Phalcon\\Mvc\\Model\\Query is designed to simplify building of search on models. It provides a set of helpers to generate searchs in a dynamic way to support differents databases.  

.. code-block:: php

    <?php



Methods
---------

public **__construct** (*unknown* $phql)

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injection container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the dependency injection container



protected **_getQualified** ()

protected **_getCallArgument** ()

protected **_getFunctionCall** ()

protected **_getExpression** ()

protected **_getSelectColumn** ()

protected **_getTable** ()

protected **_getJoin** ()

protected **_getJoinType** ()

protected **_getJoins** ()

protected **_getLimitClause** ()

protected **_getOrderClause** ()

protected **_getGroupClause** ()

protected **_prepareSelect** ()

protected **_prepareInsert** ()

protected **_prepareUpdate** ()

protected **_prepareDelete** ()

public **parse** (*unknown* $manager)

protected **_executeSelect** ()

protected **_executeInsert** ()

protected **_executeUpdate** ()

protected **_executeDelete** ()

public **execute** (*unknown* $placeholders)

