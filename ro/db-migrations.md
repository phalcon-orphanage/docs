<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Pagination</a> <ul>
        <li>
          <a href="#data-adapters">Data Adapters</a>
        </li>
        <li>
          <a href="#examples">Examples</a>
        </li>
        <li>
          <a href="#using-adapters">Using Adapters</a>
        </li>
        <li>
          <a href="#page-attributes">Page Attributes</a>
        </li>
        <li>
          <a href="#custom">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Database Migrations

Migrations are a convenient way for you to alter your database in a structured and organized manner.

<h5 class='alert alert-danger'>Migrations are available in <a href="/[[language]]/[[version]]/devtools-usage">Phalcon Developer Tools</a> You need at least Phalcon Framework version 0.5.0 to use developer tools.</h5>

Often in development we need to update changes in production environments. Some of these changes could be database modifications like new fields, new tables, removing indexes, etc.

When a migration is generated a set of classes are created to describe how your database is structured at that particular moment. These classes can be used to synchronize the schema structure on remote databases setting your database ready to work with the new changes that your application implements. Migrations describe these transformations using plain PHP.

<div align='center'>
    <iframe src='https://player.vimeo.com/video/41381817' width='500' height='281' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

## Schema Dumping

The [Phalcon Developer Tools](/[[language]]/[[version]]/devtools-usage) provides scripts to manage migrations (generation, running and rollback).

The available options for generating migrations are:

![](/images/content/migrations-1.png)

Running this script without any parameters will simply dump every object (tables and views) from your database into migration classes.

Each migration has a version identifier associated with it. The version number allows us to identify if the migration is newer or older than the current 'version' of our database. Versions will also inform Phalcon of the running order when executing a migration.

![](/images/content/migrations-2.png)

When a migration is generated, instructions are displayed on the console to describe the different steps of the migration and the execution time of those statements. At the end, a migration version is generated.

By default [Phalcon Developer Tools](/[[language]]/[[version]]/devtools-usage) uses the `app/migrations` directory to dump the migration files. You can change the location by setting one of the parameters on the generation script. Each table in the database has its respective class generated in a separated file under a directory referring its version:

![](/images/content/migrations-2.png)

## Migration Class Anatomy

Each file contains a unique class that extends the `Phalcon\Mvc\Model\Migration` class. These classes normally have two methods: `up()` and `down()`. `up()` performs the migration, while `down()` rolls it back.

`up()` also contains the `magic` method `morphTable()`. The magic comes when it recognizes the changes needed to synchronize the actual table in the database to the description given.

```php
<?php

use Phalcon\Db\Column as Column;
use Phalcon\Db\Index as Index;
use Phalcon\Db\Reference as Reference;
use Phalcon\Mvc\Model\Migration;

class ProductsMigration_100 extends Migration
{
    public function up()
    {
        $this->morphTable(
            'products',
            [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type'          => Column::TYPE_INTEGER,
                            'size'          => 10,
                            'unsigned'      => true,
                            'notNull'       => true,
                            'autoIncrement' => true,
                            'first'         => true,
                        ]
                    ),
                    new Column(
                        'product_types_id',
                        [
                            'type'     => Column::TYPE_INTEGER,
                            'size'     => 10,
                            'unsigned' => true,
                            'notNull'  => true,
                            'after'    => 'id',
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type'    => Column::TYPE_VARCHAR,
                            'size'    => 70,
                            'notNull' => true,
                            'after'   => 'product_types_id',
                        ]
                    ),
                    new Column(
                        'price',
                        [
                            'type'    => Column::TYPE_DECIMAL,
                            'size'    => 16,
                            'scale'   => 2,
                            'notNull' => true,
                            'after'   => 'name',
                        ]
                    ),
                ],
                'indexes' => [
                    new Index(
                        'PRIMARY',
                        [
                            'id',
                        ]
                    ),
                    new Index(
                        'product_types_id',
                        [
                            'product_types_id',
                        ]
                    ),
                ],
                'references' => [
                    new Reference(
                        'products_ibfk_1',
                        [
                            'referencedSchema'  => 'invo',
                            'referencedTable'   => 'product_types',
                            'columns'           => ['product_types_id'],
                            'referencedColumns' => ['id'],
                        ]
                    ),
                ],
                'options' => [
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'ENGINE'          => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci',
                ],
            ]
        );
    }
}
```

The class is called `ProductsMigration_100`. Suffix 100 refers to the version 1.0.0. `morphTable()` receives an associative array with 4 possible sections:

| Index        | Description                                                                                                                                 | Optional |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | An array with a set of table columns                                                                                                        |    No    |
| `indexes`    | An array with a set of table indexes.                                                                                                       |   Yes    |
| `references` | An array with a set of table references (foreign keys).                                                                                     |   Yes    |
| `options`    | An array with a set of table creation options. These options are often related to the database system in which the migration was generated. |   Yes    |

### Defining Columns

`Phalcon\Db\Column` is used to define table columns. It encapsulates a wide variety of column related features. Its constructor receives as first parameter the column name and an array describing the column. The following options are available when describing columns:

| Option          | Description                                                                                                                                | Optional |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |:--------:|
| `type`          | Column type. Must be a `Phalcon\Db\Column` constant (see below)                                                                          |    No    |
| `size`          | Some type of columns like VARCHAR or INTEGER may have a specific size                                                                      |   Yes    |
| `scale`         | DECIMAL or NUMBER columns may be have a scale to specify how much decimals it must store                                                   |   Yes    |
| `unsigned`      | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                            |   Yes    |
| `notNull`       | Column can store null values?                                                                                                              |   Yes    |
| `default`       | Defines a default value for a column (can only be an actual value, not a function such as `NOW()`)                                         |   Yes    |
| `autoIncrement` | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. |   Yes    |
| `first`         | Column must be placed at first position in the column order                                                                                |   Yes    |
| `after`         | Column must be placed after indicated column                                                                                               |   Yes    |

Database migrations support the following database column types:

- `Phalcon\Db\Column::TYPE_INTEGER`
- `Phalcon\Db\Column::TYPE_VARCHAR`
- `Phalcon\Db\Column::TYPE_CHAR`
- `Phalcon\Db\Column::TYPE_DATE`
- `Phalcon\Db\Column::TYPE_DATETIME`
- `Phalcon\Db\Column::TYPE_TIMESTAMP`
- `Phalcon\Db\Column::TYPE_DECIMAL`
- `Phalcon\Db\Column::TYPE_TEXT`
- `Phalcon\Db\Column::TYPE_BOOLEAN`
- `Phalcon\Db\Column::TYPE_FLOAT`
- `Phalcon\Db\Column::TYPE_DOUBLE`
- `Phalcon\Db\Column::TYPE_TINYBLOB`
- `Phalcon\Db\Column::TYPE_BLOB`
- `Phalcon\Db\Column::TYPE_MEDIUMBLOB`
- `Phalcon\Db\Column::TYPE_LONGBLOB`
- `Phalcon\Db\Column::TYPE_JSON`
- `Phalcon\Db\Column::TYPE_JSONB`
- `Phalcon\Db\Column::TYPE_BIGINTEGER`

### Defining Indexes

`Phalcon\Db\Index` defines table indexes. An index only requires that you define a name for it and a list of its columns. Note that if any index has the name PRIMARY, Phalcon will create a primary key index for that table.

### Defining References

`Phalcon\Db\Reference` defines table references (also called foreign keys). The following options can be used to define a reference:

| Index               | Description                                                                                         | Optional | Implemented in   |
| ------------------- | --------------------------------------------------------------------------------------------------- |:--------:| ---------------- |
| `referencedTable`   | It's auto-descriptive. It refers to the name of the referenced table.                               |    No    | All              |
| `columns`           | An array with the name of the columns at the table that have the reference                          |    No    | All              |
| `referencedColumns` | An array with the name of the columns at the referenced table                                       |    No    | All              |
| `referencedSchema`  | The referenced table maybe is on another schema or database. This option allows you to define that. |   Yes    | All              |
| `onDelete`          | If the foreign record is removed, perform this action on the local record(s).                       |   Yes    | MySQL PostgreSQL |
| `onUpdate`          | If the foreign record is updated, perform this action on the local record(s).                       |   Yes    | MySQL PostgreSQL |

## Writing Migrations

Migrations aren't only designed to 'morph' table. A migration is just a regular PHP class so you're not limited to these functions. For example after adding a column you could write code to set the value of that column for existing records. For more details and examples of individual methods, check the [database component](/[[language]]/[[version]]/db).

```php
<?php

use Phalcon\Mvc\Model\Migration;

class ProductsMigration_100 extends Migration
{
    public function up()
    {
        // ...

        self::$_connection->insert(
            'products',
            [
                'Malabar spinach',
                14.50,
            ],
            [
                'name',
                'price',
            ]
        );
    }
}
```

## Running Migrations

Once the generated migrations are uploaded on the target server, you can easily run them as shown in the following example:

![](/images/content/migrations-4.png)

![](/images/content/migrations-5.png)

Depending on how outdated is the database with respect to migrations, Phalcon may run multiple migration versions in the same migration process. If you specify a target version, Phalcon will run the required migrations until it reaches the specified version.