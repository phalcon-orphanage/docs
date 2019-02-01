---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Migrasi Database

Migrations are a convenient way for you to alter your database in a structured and organized manner.

<h5 class='alert alert-danger'>Migrations are available in <a href="/4.0/en/devtools-usage">Phalcon Developer Tools</a> You need at least Phalcon Framework version 0.5.0 to use developer tools.</h5>

Often in development we need to update changes in production environments. Some of these changes could be database modifications like new fields, new tables, removing indexes, etc.

When a migration is generated a set of classes are created to describe how your database is structured at that particular moment. These classes can be used to synchronize the schema structure on remote databases setting your database ready to work with the new changes that your application implements. Migrations describe these transformations using plain PHP.

<div align='center'>
    <iframe src='https://player.vimeo.com/video/41381817' width='500' height='281' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='chema-dumping'></a>

## Skema Dumping

The [Phalcon Developer Tools](/4.0/en/devtools-usage) provides scripts to manage migrations (generation, running and rollback).

The available options for generating migrations are:

![](/assets/images/content/migrations-1.png)

Running this script without any parameters will simply dump every object (tables and views) from your database into migration classes.

Each migration has a version identifier associated with it. The version number allows us to identify if the migration is newer or older than the current 'version' of our database. Versions will also inform Phalcon of the running order when executing a migration.

![](/assets/images/content/migrations-2.png)

When a migration is generated, instructions are displayed on the console to describe the different steps of the migration and the execution time of those statements. At the end, a migration version is generated.

By default [Phalcon Developer Tools](/4.0/en/devtools-usage) uses the `app/migrations` directory to dump the migration files. You can change the location by setting one of the parameters on the generation script. Each table in the database has its respective class generated in a separated file under a directory referring its version:

![](/assets/images/content/migrations-2.png)

<a name='class-anatomy'></a>

## Anatomi Kelas Migrasi

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

| Indeks      | Deskripsi                                                                                                                                   | Opsional |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `kolom`     | Sebuah array dengan satu set kolom tabel                                                                                                    |  Tidak   |
| `indeks`    | Sebuah array dengan seperangkat indeks tabel.                                                                                               |    Ya    |
| `referensi` | Sebuah array dengan satu set referensi tabel (foreign key).                                                                                 |    Ya    |
| `pilihan`   | An array with a set of table creation options. These options are often related to the database system in which the migration was generated. |    Ya    |

<a name='class-anatomy-columns'></a>

### Mendefinisikan Kolom

[Phalcon\Db\Column](api/Phalcon_Db_Column) is used to define table columns. It encapsulates a wide variety of column related features. Its constructor receives as first parameter the column name and an array describing the column. The following options are available when describing columns:

| Pilihan                  | Deskripsi                                                                                                                                  | Opsional |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------ |:--------:|
| `jenis`                  | Column type. Must be a [Phalcon\Db\Column](api/Phalcon_Db_Column) constant (see below)                                                   |  Tidak   |
| `ukuran`                 | Beberapa jenis kolom seperti VARCHAR atau INTEGER mungkin memiliki ukuran tertentu                                                         |    Ya    |
| `skala`                  | DESIMAL atau JUMLAH kolom dapat memiliki skala untuk menentukan berapa banyak bilangan desimal itu harus toko                              |    Ya    |
| `belum di tanda tangani` | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                            |    Ya    |
| `bukan`                  | Kolom dapat menyimpan nilai null?                                                                                                          |    Ya    |
| `default`                | Mendefinisikan nilai default untuk kolom (hanya bisa berupa nilai sebenarnya, bukan fungsi seperti itu `NOW()`)                            |    Ya    |
| `autoIncrement`          | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. |    Ya    |
| `pertama`                | Kolom harus ditempatkan pada posisi pertama dalam urutan kolom                                                                             |    Ya    |
| `setelah`                | Kolom harus ditempatkan setelah kolom ditunjukkan                                                                                          |    Ya    |

Database migrations support the following database column types:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Kolom Phalcon\Db\:: TYPE_VARCHAR`
* `Phalcon\Db\Kolom::TYPE_CHAR`
* `Phalcon\Db\Kolom::TYPE_DATE`
* `Phalcon\Db\Kolom::TYPE_DATETIME`
* `Phalcon\Db\kolom::TYPE_TIMESTAMP`
* `Phalcon\Db\kolom::TYPE_DECIMAL`
* `Phalcon\Db\kolom::TYPE_TEXT`
* `Phalcon\Db\Column::TYPE_JSON`
* `Phalcon\Db\Column::TYPE_FLOAT`
* `Phalcon\Db\Column::TYPE_DOUBLE`
* `Phalcon\Db\Column::TYPE_TINYBLOB`
* `Phalcon\Db\Column::TYPE_BLOB`
* `Phalcon\Db\Column::TYPE_MEDIUMBLOB`
* `Phalcon\Db\Column::TYPE_LONGBLOB`
* `Phalcon\Db\Column::TYPE_JSON`
* `Phalcon\Db\Column::TYPE_JSONB`
* `Phalcon\Db\Column::TYPE_BIGINTEGER`

<a name='class-anatomy-indexes'></a>

### Mendefinisikan Indeks

[Phalcon\Db\Index](api/Phalcon_Db_Index) defines table indexes. An index only requires that you define a name for it and a list of its columns. Note that if any index has the name PRIMARY, Phalcon will create a primary key index for that table.

<a name='class-anatomy-references'></a>

### Mendefinisikan Referensi

[Phalcon\Db\Reference](api/Phalcon_Db_Reference) defines table references (also called foreign keys). The following options can be used to define a reference:

| Indeks                  | Deskripsi                                                                                           | Opsional | Diimplementasikan di |
| ----------------------- | --------------------------------------------------------------------------------------------------- |:--------:| -------------------- |
| `direferensikanTabel`   | It's auto-descriptive. It refers to the name of the referenced table.                               |  Tidak   | Semua                |
| `kolom`                 | Sebuah array dengan nama kolom pada tabel yang memiliki referensi                                   |  Tidak   | Semua                |
| `direferensikanColumns` | Sebuah array dengan nama kolom pada tabel yang direferensikan                                       |  Tidak   | Semua                |
| `dirujukSchema`         | The referenced table maybe is on another schema or database. This option allows you to define that. |    Ya    | Semua                |
| `onDelete`              | Jika catatan asing dihapus, lakukan tindakan ini pada catatan lokal. record(s).                     |    Ya    | MySQL PostgreSQL     |
| `di Perbaharui`         | Jika catatan asing diperbarui, lakukan tindakan ini pada catatan lokal. record(s).                  |    Ya    | MySQL PostgreSQL     |

<a name='writing'></a>

## Menuliskan Migrasi

Migrations aren't only designed to 'morph' table. A migration is just a regular PHP class so you're not limited to these functions. For example after adding a column you could write code to set the value of that column for existing records. For more details and examples of individual methods, check the [database component](/4.0/en/db).

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

<a name='running'></a>

## Menjalankan migrasi

Once the generated migrations are uploaded on the target server, you can easily run them as shown in the following example:

![](/assets/images/content/migrations-4.png)

![](/assets/images/content/migrations-5.png)

Depending on how outdated is the database with respect to migrations, Phalcon may run multiple migration versions in the same migration process. If you specify a target version, Phalcon will run the required migrations until it reaches the specified version.