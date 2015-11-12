Class **Phalcon\\Db\\Dialect\\MySQL**
=====================================

*extends* abstract class :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

*implements* :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/dialect/mysql.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Db\\Dialect\\Mysql  Generates database specific SQL for the MySQL RDBMS


Methods
-------

public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Gets the column name in MySQL



public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Generates SQL to add a column to a table



public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column, [:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $currentColumn])

Generates SQL to modify a column in a table



public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

Generates SQL to delete a column from a table



public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Generates SQL to add an index to a table



public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

Generates SQL to delete an index from a table



public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Generates SQL to add the primary key to a table



public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

Generates SQL to delete primary key from a table



public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)

Generates SQL to add an index to a table



public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

Generates SQL to delete a foreign key from a table



public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *array* $definition)

Generates SQL to create a table



public  **dropTable** (*unknown* $tableName, [*unknown* $schemaName], [*unknown* $ifExists])

Generates SQL to drop a table



public  **createView** (*unknown* $viewName, *array* $definition, [*unknown* $schemaName])

Generates SQL to create a view



public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists])

Generates SQL to drop a view



public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

        echo $dialect->tableExists("posts", "blog");
        echo $dialect->tableExists("posts");




public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.view



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




public  **listViews** ([*unknown* $schemaName])

Generates the SQL to list all views of a schema or user



public  **describeIndexes** (*unknown* $table, [*unknown* $schema])

Generates SQL to query indexes on a table



public  **describeReferences** (*unknown* $table, [*unknown* $schema])

Generates SQL to query foreign keys on a table



public  **tableOptions** (*unknown* $table, [*unknown* $schema])

Generates the SQL to describe the table creation options



protected  **_getTableOptions** (*array* $definition)

Generates SQL to add the table creation options



public  **registerCustomFunction** (*unknown* $name, *unknown* $customFunction) inherited from Phalcon\\Db\\Dialect

Registers custom SQL functions



public  **getCustomFunctions** () inherited from Phalcon\\Db\\Dialect

Returns registered functions



final public  **escape** (*unknown* $str, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Escape identifiers



public  **limit** (*unknown* $sqlQuery, *unknown* $number) inherited from Phalcon\\Db\\Dialect

Generates the SQL for LIMIT clause 

.. code-block:: php

    <?php

        $sql = $dialect->limit('SELECT * FROM robots', 10);
        echo $sql; // SELECT * FROM robots LIMIT 10
    
        $sql = $dialect->limit('SELECT * FROM robots', [10, 50]);
        echo $sql; // SELECT * FROM robots LIMIT 10 OFFSET 50




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




final public  **getColumnList** (*array* $columnList, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Gets a list of columns with escaped identifiers 

.. code-block:: php

    <?php

        echo $dialect->getColumnList(array('column1', 'column'));




final public  **getSqlColumn** (*unknown* $column, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve Column expressions



public  **getSqlExpression** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Transforms an intermediate representation for a expression into a database system valid expression



final public  **getSqlTable** (*unknown* $table, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Transform an intermediate representation of a schema/table into a database system valid expression



public  **select** (*array* $definition) inherited from Phalcon\\Db\\Dialect

Builds a SELECT statement



public  **supportsSavepoints** () inherited from Phalcon\\Db\\Dialect

Checks whether the platform supports savepoints



public  **supportsReleaseSavepoints** () inherited from Phalcon\\Db\\Dialect

Checks whether the platform supports releasing savepoints.



public  **createSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to create a new savepoint



public  **releaseSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to release a savepoint



public  **rollbackSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to rollback a savepoint



final protected  **getSqlExpressionScalar** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve Column expressions



final protected  **getSqlExpressionObject** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve object expressions



final protected  **getSqlExpressionQualified** (*array* $expression, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Resolve qualified expressions



final protected  **getSqlExpressionBinaryOperations** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve binary operations expressions



final protected  **getSqlExpressionUnaryOperations** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve unary operations expressions



final protected  **getSqlExpressionFunctionCall** (*array* $expression, *unknown* $escapeChar, [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve function calls



final protected  **getSqlExpressionList** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve Lists



final protected  **getSqlExpressionAll** (*array* $expression, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Resolve *



final protected  **getSqlExpressionCastValue** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve CAST of values



final protected  **getSqlExpressionConvertValue** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

Resolve CONVERT of values encodings



final protected  **getSqlExpressionCase** (*array* $expression, [*unknown* $escapeChar], [*unknown* $bindCounts]) inherited from Phalcon\\Db\\Dialect

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



