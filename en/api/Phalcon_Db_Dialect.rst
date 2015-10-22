Abstract class **Phalcon\\Db\\Dialect**
=======================================

*implements* :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/dialect.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBMS related syntax


Methods
-------

public  **registerCustomFunction** (*unknown* $name, *unknown* $customFunction)

Registers custom SQL functions



public  **getCustomFunctions** ()

Returns registered functions



final public  **escape** (*unknown* $str, [*unknown* $escapeChar])

Escape identifiers



public  **limit** (*unknown* $sqlQuery, *unknown* $number)

Generates the SQL for LIMIT clause 

.. code-block:: php

    <?php

        $sql = $dialect->limit('SELECT * FROM robots', 10);
        echo $sql; // SELECT * FROM robots LIMIT 10
    
        $sql = $dialect->limit('SELECT * FROM robots', [10, 50]);
        echo $sql; // SELECT * FROM robots LIMIT 10 OFFSET 50




public  **forUpdate** (*unknown* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause 

.. code-block:: php

    <?php

     $sql = $dialect->forUpdate('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots FOR UPDATE




public  **sharedLock** (*unknown* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause 

.. code-block:: php

    <?php

     $sql = $dialect->sharedLock('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE




final public  **getColumnList** (*unknown* $columnList, [*unknown* $escapeChar], [*unknown* $bindCounts])

Gets a list of columns with escaped identifiers 

.. code-block:: php

    <?php

        echo $dialect->getColumnList(array('column1', 'column'));




final public  **getSqlColumn** (*unknown* $column, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve Column expressions



public  **getSqlExpression** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Transforms an intermediate representation for a expression into a database system valid expression



final public  **getSqlTable** (*unknown* $table, [*unknown* $escapeChar])

Transform an intermediate representation of a schema/table into a database system valid expression



public  **select** (*unknown* $definition)

Builds a SELECT statement



public  **supportsSavepoints** ()

Checks whether the platform supports savepoints



public  **supportsReleaseSavepoints** ()

Checks whether the platform supports releasing savepoints.



public  **createSavepoint** (*unknown* $name)

Generate SQL to create a new savepoint



public  **releaseSavepoint** (*unknown* $name)

Generate SQL to release a savepoint



public  **rollbackSavepoint** (*unknown* $name)

Generate SQL to rollback a savepoint



final protected  **getSqlExpressionScalar** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve Column expressions



final protected  **getSqlExpressionObject** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve object expressions



final protected  **getSqlExpressionQualified** (*unknown* $expression, [*unknown* $escapeChar])

Resolve qualified expressions



final protected  **getSqlExpressionBinaryOperations** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve binary operations expressions



final protected  **getSqlExpressionUnaryOperations** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve unary operations expressions



final protected  **getSqlExpressionFunctionCall** (*unknown* $expression, *unknown* $escapeChar, [*unknown* $bindCounts])

Resolve function calls



final protected  **getSqlExpressionList** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve Lists



final protected  **getSqlExpressionAll** (*unknown* $expression, [*unknown* $escapeChar])

Resolve *



final protected  **getSqlExpressionCastValue** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve CAST of values



final protected  **getSqlExpressionConvertValue** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve CONVERT of values encodings



final protected  **getSqlExpressionCase** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve CASE expressions



final protected  **getSqlExpressionFrom** (*unknown* $expression, [*unknown* $escapeChar])

Resolve a FROM clause



final protected  **getSqlExpressionJoins** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve a JOINs clause



final protected  **getSqlExpressionWhere** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve a WHERE clause



final protected  **getSqlExpressionGroupBy** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve a GROUP BY clause



final protected  **getSqlExpressionHaving** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve a HAVING clause



final protected  **getSqlExpressionOrderBy** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve a ORDER BY clause



final protected  **getSqlExpressionLimit** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts])

Resolve a LIMIT clause



protected  **prepareColumnAlias** (*unknown* $qualified, [*unknown* $alias], [*unknown* $escapeChar])

Prepares column for this RDBMS



protected  **prepareTable** (*unknown* $table, [*unknown* $schema], [*unknown* $alias], [*unknown* $escapeChar])

Prepares table for this RDBMS



protected  **prepareQualified** (*unknown* $column, [*unknown* $domain], [*unknown* $escapeChar])

Prepares qualified for this RDBMS



abstract public  **getColumnDefinition** (*unknown* $column) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column, [*unknown* $currentColumn]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **createView** (*unknown* $viewName, *unknown* $definition, [*unknown* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **dropTable** (*unknown* $tableName, *unknown* $schemaName) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **describeColumns** (*unknown* $table, [*unknown* $schema]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **listTables** ([*unknown* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **describeIndexes** (*unknown* $table, [*unknown* $schema]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **describeReferences** (*unknown* $table, [*unknown* $schema]) inherited from Phalcon\\Db\\DialectInterface

...


abstract public  **tableOptions** (*unknown* $table, [*unknown* $schema]) inherited from Phalcon\\Db\\DialectInterface

...


