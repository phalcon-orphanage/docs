<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Миграции базы данных</a> <ul>
        <li>
          <a href="#schema-dumping">Сохранение схемы БД</a>
        </li>
        <li>
          <a href="#migration-class-anatomy">Структура класса Migration</a>
        </li>
        <li>
          <a href="#defining-columns">Определение столбцов</a>
        </li>
        <li>
          <a href="#defining-indexes">Определение индексов</a>
        </li>
        <li>
          <a href="#defining-references">Определение ключей</a>
        </li>
        <li>
          <a href="#writing-migrations">Запись миграций</a>
        </li>
        <li>
          <a href="#running-migrations">Запуск миграций</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Миграции базы данных

Миграции — это удобный способ изменения вашей базы данных структурированным и организованным способом.

<div class="alert alert-danger">
    <p>
        Миграции доступны через <a href="/[[language]]/[[version]]/devtools-usage">Phalcon Developer Tools</a>. Вам потребуется Phalcon версии не ниже 0.5.0 для использования инструментов разработчика.
    </p>
</div>

Часто при разработке необходимо вносить изменения уже на стадии релиза приложения, на боевом сервере. Некоторые из этих изменений могут касаться изменений в базе данных: новые столбцы, новые таблицы, удаление индексов и т.д.

При миграции создается набор классов, чтобы описать, как ваша база данных структурирована в данный момент. Эти классы могут использоваться для синхронизации структуры схемы в удаленных базах данных и подготовки вашей базы данных к работе с новыми изменениями, которые реализует ваше приложение. Миграции описывают эти изменения с использованием простого PHP.

<div align='center'>
    <iframe src='https://player.vimeo.com/video/41381817' width='500' height='281' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='schema-dumping'></a>

## Сохранение схемы БД

[Phalcon Developer Tools](/[[language]]/[[version]]/devtools-usage) предоставляет скрипты для управления миграциями (генерация, запуск и откат).

Доступные опции для генерации миграций:

![](/images/content/migrations-1.png)

Запуск скрипта без каких-либо параметров делает простой дамп каждого объекта (таблиц и представлений) из вашей базы данных в классы миграции.

Каждая миграция имеет версию — идентификатор, который с ней ассоциируется. Номер версии позволяет нам определить, является ли миграция старше или новее текущей версии нашей базы данных. Версии также сообщают Phalcon о рабочем состоянии при выполнении миграции.

![](/images/content/migrations-2.png)

При генерации миграции, в консоли отображаются инструкции, описывающие шаги миграции, и время их выполнения. В конце концов, версия миграция будет создана.

По умолчанию [Phalcon Developer Tools](/[[language]]/[[version]]/devtools-usage) использует директорию `app/migrations` для сохранения файлов миграции. Вы можете изменить расположение, установив один из параметров по генерации скрипта. Каждая таблица в базе данных имеет свой соответствующий класс, созданный в отдельном файле директории, ссылающейся на её версию:

![](/images/content/migrations-2.png)

<a name='migration-class-anatomy'></a>

## Структура класса Migration

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

| Index        | Описание                                                                                                                                    | Опционально |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------- |:-----------:|
| `columns`    | An array with a set of table columns                                                                                                        |     Нет     |
| `indexes`    | An array with a set of table indexes.                                                                                                       |     Да      |
| `references` | An array with a set of table references (foreign keys).                                                                                     |     Да      |
| `options`    | An array with a set of table creation options. These options are often related to the database system in which the migration was generated. |     Да      |

<a name='defining-columns'></a>

### Определение столбцов

`Phalcon\Db\Column` is used to define table columns. It encapsulates a wide variety of column related features. Its constructor receives as first parameter the column name and an array describing the column. The following options are available when describing columns:

| Свойство        | Описание                                                                                                                                   | Опционально |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |:-----------:|
| `type`          | Column type. Must be a `Phalcon\Db\Column` constant (see below)                                                                          |     Нет     |
| `size`          | Some type of columns like `VARCHAR` or `INTEGER` may have a specific size                                                                  |     Да      |
| `scale`         | `DECIMAL` or `NUMBER` columns may be have a scale to specify how much decimals it must store                                               |     Да      |
| `unsigned`      | `INTEGER` columns may be signed or unsigned. This option does not apply to other types of columns                                          |     Да      |
| `notNull`       | Column can store null values?                                                                                                              |     Да      |
| `default`       | Defines a default value for a column (can only be an actual value, not a function such as `NOW()`)                                         |     Да      |
| `autoIncrement` | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. |     Да      |
| `first`         | Column must be placed at first position in the column order                                                                                |     Да      |
| `after`         | Column must be placed after indicated column                                                                                               |     Да      |

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

<a name='defining-indexes'></a>

### Определение Индексов

`Phalcon\Db\Index` defines table indexes. An index only requires that you define a name for it and a list of its columns. Note that if any index has the name `PRIMARY`, Phalcon will create a primary key index for that table.

<a name='defining-references'></a>

### Определение Связей

`Phalcon\Db\Reference` defines table references (also called foreign keys). The following options can be used to define a reference:

| Index               | Описание                                                                                            | Опционально | Реализовано в    |
| ------------------- | --------------------------------------------------------------------------------------------------- |:-----------:| ---------------- |
| `referencedTable`   | It's auto-descriptive. It refers to the name of the referenced table.                               |     Нет     | Все адаптеры     |
| `columns`           | An array with the name of the columns at the table that have the reference                          |     Нет     | Все адаптеры     |
| `referencedColumns` | An array with the name of the columns at the referenced table                                       |     Нет     | Все адаптеры     |
| `referencedSchema`  | The referenced table maybe is on another schema or database. This option allows you to define that. |     Да      | Все адаптеры     |
| `onDelete`          | If the foreign record is removed, perform this action on the local record(s).                       |     Да      | MySQL PostgreSQL |
| `onUpdate`          | If the foreign record is updated, perform this action on the local record(s).                       |     Да      | MySQL PostgreSQL |

<a name='writing-migrations'></a>

## Запись миграций

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

<a name='running-migrations'></a>

## Запуск миграций

Once the generated migrations are uploaded on the target server, you can easily run them as shown in the following example:

![](/images/content/migrations-4.png)

![](/images/content/migrations-5.png)

Depending on how outdated is the database with respect to migrations, Phalcon may run multiple migration versions in the same migration process. If you specify a target version, Phalcon will run the required migrations until it reaches the specified version.