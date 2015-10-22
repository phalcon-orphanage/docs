Class **Phalcon\\Db\\Dialect\\Oracle**
======================================

*extends* abstract class :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

*implements* :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/dialect/oracle.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Generates database specific SQL for the Oracle RDBMS


Methods
-------

public  **limit** (*unknown* $sqlQuery, *unknown* $number)

Generates the SQL for LIMIT clause



public  **getColumnDefinition** (*unknown* $column)

Gets the column name in Oracle



public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

Generates SQL to add a column to a table



public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column, [*unknown* $currentColumn])

Generates SQL to modify a column in a table



public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

Generates SQL to delete a column from a table



public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Generates SQL to add an index to a table



public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

/** /** Generates SQL to delete an index from a table



public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Generates SQL to add the primary key to a table



public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

Generates SQL to delete primary key from a table



public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

Generates SQL to add an index to a table



public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

Generates SQL to delete a foreign key from a table



public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

Generates SQL to create a table in Oracle



public  **dropTable** (*unknown* $tableName, *unknown* $schemaName, [*unknown* $ifExists])

Generates SQL to drop a table



public  **createView** (*unknown* $viewName, *unknown* $definition, [*unknown* $schemaName])

Generates SQL to create a view



public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists])

Generates SQL to drop a view



public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.view



public  **listViews** ([*unknown* $schemaName])

Generates the SQL to list all views of a schema or user



public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

        echo $dialect->tableExists("posts", "blog");
        echo $dialect->tableExists("posts");




public  **describeColumns** (*unknown* $table, [*unknown* $schema])

Generates SQL describing a table 

.. code-block:: php

    <?php

        print_r($dialect->describeColumns("posts"));




public  **listTables** ([*unknown* $schemaName])

List all tables in database 

.. code-block:: php

    <?php

        print_r($dialect->listTables("blog"))




public  **describeIndexes** (*unknown* $table, [*unknown* $schema])

Generates SQL to query indexes on a table



public  **describeReferences** (*unknown* $table, [*unknown* $schema])

Generates SQL to query foreign keys on a table



public  **tableOptions** (*unknown* $table, [*unknown* $schema])

Generates the SQL to describe the table creation options



public  **supportsSavepoints** ()

Checks whether the platform supports savepoints



public  **supportsReleaseSavepoints** ()

Checks whether the platform supports releasing savepoints.



public  **registerCustomFunction** (*unknown* $name, *unknown* $customFunction) inherited from Phalcon\\Db\\Dialect

Registers custom SQL functions



public  **getCustomFunctions** () inherited from Phalcon\\Db\\Dialect

Returns registered functions



final public  **escape** (*unknown* $str, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Escape identifiers



public  **forUpdate** (*unknown* $sqlQuery) inherited from Phalcon\\Db\\Dialect

Returns a SQL modified with a FOR UPDATE clause 

.. code-block:: php

    <?php

     $sql = $dialect->forUpdate('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots FOR UPDATE




public  **sharedLock** (*unknown* $sqlQuery) inherited from Phalcon\\Db\\Dialect

Returns a SQL modified with a LOCK IN SHARE MODE clause 

.. code-block:: php

    <?php

     $sql = $dialect->sharedLock('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE




final public  **getColumnList** (*unknown* $columnList, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Gets a list of columns with escaped identifiers 

.. code-block:: php

    <?php

        echo $dialect->getColumnList(array('column1', 'column'));




final public  **getSqlColumn** (*unknown* $column, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve Column expressions



public  **getSqlExpression** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Transforms an intermediate representation for a expression into a database system valid expression



final public  **getSqlTable** (*unknown* $table, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Transform an intermediate representation of a schema/table into a database system valid expression



public  **select** (*unknown* $definition) inherited from Phalcon\\Db\\Dialect

Builds a SELECT statement



public  **createSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to create a new savepoint



public  **releaseSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to release a savepoint



public  **rollbackSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to rollback a savepoint



final protected  **getSqlExpressionScalar** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve Column expressions



final protected  **getSqlExpressionObject** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve object expressions



final protected  **getSqlExpressionQualified** (*unknown* $expression, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Resolve qualified expressions



final protected  **getSqlExpressionBinaryOperations** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve binary operations expressions



final protected  **getSqlExpressionUnaryOperations** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve unary operations expressions



final protected  **getSqlExpressionFunctionCall** (*unknown* $expression, *unknown* $escapeChar, [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve function calls



final protected  **getSqlExpressionList** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve Lists



final protected  **getSqlExpressionAll** (*unknown* $expression, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Resolve *



final protected  **getSqlExpressionCastValue** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve CAST of values



final protected  **getSqlExpressionConvertValue** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve CONVERT of values encodings



final protected  **getSqlExpressionCase** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve CASE expressions



final protected  **getSqlExpressionFrom** (*unknown* $expression, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Resolve a FROM clause



final protected  **getSqlExpressionJoins** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve a JOINs clause



final protected  **getSqlExpressionWhere** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve a WHERE clause



final protected  **getSqlExpressionGroupBy** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve a GROUP BY clause



final protected  **getSqlExpressionHaving** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve a HAVING clause



final protected  **getSqlExpressionOrderBy** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve a ORDER BY clause



final protected  **getSqlExpressionLimit** (*unknown* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve a LIMIT clause



protected  **prepareColumnAlias** (*unknown* $qualified, [*unknown* $alias], [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Prepares column for this RDBMS



protected  **prepareTable** (*unknown* $table, [*unknown* $schema], [*unknown* $alias], [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Prepares table for this RDBMS



protected  **prepareQualified** (*unknown* $column, [*unknown* $domain], [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Prepares qualified for this RDBMS



