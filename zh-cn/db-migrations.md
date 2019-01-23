---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### 本文来自于 v3.4, 尚未修订

{:.alert .alert-danger}

<a name='overview'></a>

# 数据库迁移

迁移是一种以结构化和有组织的方式更改数据库的便捷方式。

<h5 class='alert alert-danger'>迁移在 <a href="/4.0/en/devtools-usage">phalcon 开发人员工具</a> 中提供, 您至少需要 phalcon 框架版本0.5.0 才能使用开发人员工具。</h5>

通常在开发过程中, 我们需要更新生产环境中的更改。 其中一些更改可能是数据库修改, 如新字段、新表、删除索引等。

迁移生成时，创建一组类来描述您的数据库如何构成的一些情况。 这些类可以被用于同步数据库结构到远程数据库，设置您的应用程序实现的新的数据库上的结构变化。 迁移使用纯 PHP 描述这些转换。

<div align='center'>
    <iframe src='https://player.vimeo.com/video/41381817' width='500' height='281' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='chema-dumping'></a>

## 结构导出

[Phalcon开发工具](/4.0/en/devtools-usage) 提供脚本来管理迁移(生成、 运行和回滚)。

可用于生成迁移的选项包括：

![](/assets/images/content/migrations-1.png)

在没有任何参数的情况下运行此脚本将简单地将数据库中的每个对象 (表和视图) 转储到迁移类中。

每次迁移，都有与它相关联的版本标识符。 版本号使我们能够确定迁移是否比我们的数据库的当前 "版本" 更新或旧。 在执行迁移时，版本号亦会告知Phalcon的运行顺序。

![](/assets/images/content/migrations-2.png)

当一个迁移在生成时，说明会显示在控制台上，以描述迁移的不同步骤和这些语句的执行时间。 在结束时, 将生成迁移版本。

默认情况下 [Phalcon开发工具](/4.0/en/devtools-usage) 使用 `app/migrations` 目录转储迁移文件。 您可以生成脚本上设置一个参数，来更改这个位置的设置。 Each table in the database has its respective class generated in a separated file under a directory referring its version:

![](/assets/images/content/migrations-2.png)

<a name='class-anatomy'></a>

## 迁移类解剖

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

| 索引           | 描述                                                                                                                                          | 可选 |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------- |:--:|
| `columns`    | 具有一组表中的列的数组                                                                                                                                 | 否  |
| `indexes`    | 具有一组表索引的数组。                                                                                                                                 | 是的 |
| `references` | 具有一组表引用(外键) 的数组。                                                                                                                            | 是的 |
| `options`    | An array with a set of table creation options. These options are often related to the database system in which the migration was generated. | 是的 |

<a name='class-anatomy-columns'></a>

### 定义列

[Phalcon\Db\Column](api/Phalcon_Db_Column) is used to define table columns. It encapsulates a wide variety of column related features. Its constructor receives as first parameter the column name and an array describing the column. The following options are available when describing columns:

| 选项              | 描述                                                                                                                                         | 可选 |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |:--:|
| `type`          | Column type. Must be a [Phalcon\Db\Column](api/Phalcon_Db_Column) constant (see below)                                                   | 否  |
| `size`          | 某种类型的像 VARCHAR 或 INTEGER列，可能有特定的大小                                                                                                         | 是的 |
| `scale`         | 十进制或数字列可能有一个尺度去指定多少小数必须存储                                                                                                                  | 是的 |
| `unsigned`      | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                            | 是的 |
| `notNull`       | 列可以存储 null 值吗？                                                                                                                             | 是的 |
| `default`       | 定义列的默认的值(只能是实际的值，不是如 `now()` 的函数)                                                                                                          | 是的 |
| `autoIncrement` | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. | 是的 |
| `first`         | 列必须被放置在列顺序的第一个位置中                                                                                                                          | 是的 |
| `after`         | 列必须置于指定列之后                                                                                                                                 | 是的 |

Database migrations support the following database column types:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_TIMESTAMP`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_TEXT`
* `Phalcon\Db\Column::TYPE_BOOLEAN`
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

### 定义索引

[Phalcon\Db\Index](api/Phalcon_Db_Index) defines table indexes. An index only requires that you define a name for it and a list of its columns. Note that if any index has the name PRIMARY, Phalcon will create a primary key index for that table.

<a name='class-anatomy-references'></a>

### 定义引用

[Phalcon\Db\Reference](api/Phalcon_Db_Reference) defines table references (also called foreign keys). The following options can be used to define a reference:

| 索引                  | 描述                                                                                                  | 可选 | 被实现              |
| ------------------- | --------------------------------------------------------------------------------------------------- |:--:| ---------------- |
| `referencedTable`   | It's auto-descriptive. It refers to the name of the referenced table.                               | 否  | 所有               |
| `columns`           | 一个带名称的数组，在这个表已经被引用                                                                                  | 否  | 所有               |
| `referencedColumns` | 在被引用的表上，一个带有表名称的数组                                                                                  | 否  | 所有               |
| `referencedSchema`  | The referenced table maybe is on another schema or database. This option allows you to define that. | 是的 | 所有               |
| `ondelete`          | 如果外键的记录被删除, 对本地的记录执行此操作.                                                                            | 是的 | MySQL PostgreSQL |
| `onUpdate`          | 如果对外键的记录进行更新，对本地的记录执行此操作。                                                                           | 是的 | MySQL PostgreSQL |

<a name='writing'></a>

## 写入迁移

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

## 运行迁移

Once the generated migrations are uploaded on the target server, you can easily run them as shown in the following example:

![](/assets/images/content/migrations-4.png)

![](/assets/images/content/migrations-5.png)

Depending on how outdated is the database with respect to migrations, Phalcon may run multiple migration versions in the same migration process. If you specify a target version, Phalcon will run the required migrations until it reaches the specified version.