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

# Migraciones de Bases de Datos

Las migraciones son una manera conveniente para modificar su base de datos en una forma estructurada y organizada.

<h5 class='alert alert-danger'>Migrations are available in <a href="/[[language]]/[[version]]/devtools-usage">Phalcon Developer Tools</a> You need at least Phalcon Framework version 0.5.0 to use developer tools.</h5>

A menudo en el desarrollo necesitamos actualizar cambios en entornos de producción. Algunos de estos cambios podrían ser modificaciones de la base de datos como nuevos campos, nuevas tablas, eliminación de índices, etcétera.

Cuando se genera una migración se crea un conjunto de clases para describir cómo está estructurada la base de datos en ese preciso momento. Estas clases pueden utilizarse para sincronizar la estructura del esquema en bases de datos remotas configurando su base de datos para trabajar con los nuevos cambios que implementa la aplicación. Las migraciones describen estas transformaciones usando simple PHP.

<div align='center'>
    <iframe src='https://player.vimeo.com/video/41381817' width='500' height='281' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

## Volcado de esquema

The [Phalcon Developer Tools](/[[language]]/[[version]]/devtools-usage) provides scripts to manage migrations (generation, running and rollback).

The available options for generating migrations are:

![](/images/content/migrations-1.png)

Running this script without any parameters will simply dump every object (tables and views) from your database into migration classes.

Each migration has a version identifier associated with it. The version number allows us to identify if the migration is newer or older than the current 'version' of our database. Versions will also inform Phalcon of the running order when executing a migration.

![](/images/content/migrations-2.png)

When a migration is generated, instructions are displayed on the console to describe the different steps of the migration and the execution time of those statements. At the end, a migration version is generated.

By default [Phalcon Developer Tools](/[[language]]/[[version]]/devtools-usage) uses the `app/migrations` directory to dump the migration files. You can change the location by setting one of the parameters on the generation script. Each table in the database has its respective class generated in a separated file under a directory referring its version:

![](/images/content/migrations-2.png)

## Anatomía de la clase de migración

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

| Índice       | Descripción                                                                                                                                                            | Opcional |
| ------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | Una matriz con el conjunto de columnas de la tabla                                                                                                                     |    No    |
| `indexes`    | Una matriz con el conjunto de índices de la tabla.                                                                                                                     |    Sí    |
| `references` | Una matriz con el conjunto de referencias de la tabla (claves foráneas).                                                                                               |    Sí    |
| `options`    | Un array con un conjunto de opciones de creación de la tabla. Estas opciones están a menudo relacionadas al sistema de base de datos en la que se generó la migración. |    Sí    |

### Definición de columnas

`Phalcon\Db\Column` is used to define table columns. It encapsulates a wide variety of column related features. Its constructor receives as first parameter the column name and an array describing the column. The following options are available when describing columns:

| Opción          | Descripción                                                                                                                         | Opcional |
| --------------- | ----------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `type`          | Tipo de columna. Debe ser una constante de `Phalcon\Db\Column` (ver lista de abajo)                                               |    No    |
| `size`          | Some type of columns like VARCHAR or INTEGER may have a specific size                                                               |    Sí    |
| `scale`         | DECIMAL or NUMBER columns may be have a scale to specify how much decimals it must store                                            |    Sí    |
| `unsigned`      | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                     |    Sí    |
| `notNull`       | ¿La columna puede almacenar valores nulos?                                                                                          |    Sí    |
| `default`       | Define un valor predeterminado para una columna (sólo puede ser un valor real, no una función como `NOW()`)                         |    Sí    |
| `autoIncrement` | Con este atributo la columna se incrementará automáticamente con un entero. Solo una columna en la tabla puede tener este atributo. |    Sí    |
| `first`         | La columna debe colocarse en primera posición en el orden de columnas                                                               |    Sí    |
| `after`         | La columna debe colocarse después de la columna indicada                                                                            |    Sí    |

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

### Definición de índices

`Phalcon\Db\Index` defines table indexes. An index only requires that you define a name for it and a list of its columns. Note that if any index has the name PRIMARY, Phalcon will create a primary key index for that table.

### Definición de referencias

`Phalcon\Db\Reference` defines table references (also called foreign keys). The following options can be used to define a reference:

| Índice              | Descripción                                                                                               | Opcional | Implementado en  |
| ------------------- | --------------------------------------------------------------------------------------------------------- |:--------:| ---------------- |
| `referencedTable`   | Es auto descriptivo. Se refiere al nombre de la tabla referenciada.                                       |    No    | Todos            |
| `columns`           | Una matriz con el nombre de las columnas en la tabla que tiene la referencia                              |    No    | Todos            |
| `referencedColumns` | Una matriz con el nombre de las columnas de la tabla de referencia                                        |    No    | Todos            |
| `referencedSchema`  | La tabla de referencia está tal vez en otro esquema o base de datos. Esta opción le permite definir esto. |    Sí    | Todos            |
| `onDelete`          | Si se elimina el registro foráneo, realizar esta acción en el o los registros locales.                    |    Sí    | MySQL PostgreSQL |
| `onUpdate`          | Si se actualiza el registro foráneo, realizar esta acción en el o los registros locales.                  |    Sí    | MySQL PostgreSQL |

## Escribiendo migraciones

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

## Ejecutando migraciones

Once the generated migrations are uploaded on the target server, you can easily run them as shown in the following example:

![](/images/content/migrations-4.png)

![](/images/content/migrations-5.png)

Depending on how outdated is the database with respect to migrations, Phalcon may run multiple migration versions in the same migration process. If you specify a target version, Phalcon will run the required migrations until it reaches the specified version.