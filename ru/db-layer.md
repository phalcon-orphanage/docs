<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Уровень абстракции базы данных</a> 
      <ul>
        <li>
          <a href="#adapters">Адаптеры баз данных</a> 
          <ul>
            <li>
              <a href="#adapters-factory">Фабрика</a>
            </li>
            <li>
              <a href="#adapters-custom">Реализация собственных адаптеров</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#dialects">Диалекты базы данных</a> 
          <ul>
            <li>
              <a href="#dialects-custom">Реализация собственных диалектов</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#connection">Подключение к базе данных</a> 
          <ul>
            <li>
              <a href="#connection-factory">Подключение с помощью фабрики</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#options">Настройка дополнительных параметров PDO</a>
        </li>
        <li>
          <a href="#finding-rows">Поиск строк</a>
        </li>
        <li>
          <a href="#binding-parameters">Подготавливаемые запросы</a>
        </li>
        <li>
          <a href="#typed-placeholders">Типизированные псевдопеременные</a>
        </li>
        <li>
          <a href="#cast-bound-parameter-values">Приведение типов связываемых параметров</a>
        </li>
        <li>
          <a href="#cast-on-hydrate">Приведение типов при гидрации</a>
        </li>
        <li>
          <a href="#crud">Вставка, обновление и удаление строк</a>
        </li>
        <li>
          <a href="#transactions">Транзакции и вложенные транзакции</a>
        </li>
        <li>
          <a href="#events">События базы данных</a>
        </li>
        <li>
          <a href="#profiling">Профилирование SQL запросов</a>
        </li>
        <li>
          <a href="#logging-statements">Логирование SQL выражений</a>
        </li>
        <li>
          <a href="#logger-custom">Реализация собственного логера</a>
        </li>
        <li>
          <a href="#describing-tables">Описание таблиц и представлений</a>
        </li>
        <li>
          <a href="#tables">Создание, изменение и удаление таблиц</a> 
          <ul>
            <li>
              <a href="#tables-create">Создание таблиц</a>
            </li>
            <li>
              <a href="#tables-altering">Изменение таблиц</a>
            </li>
            <li>
              <a href="#tables-dropping">Удаление таблиц</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Уровень абстракции базы данных

`Phalcon\Db` является компонентом, располагающимся под `Phalcon\Mvc\Model`, который управляет слоем моделей в фреймворке. Он состоит из независимых абстракций высокого уровня для баз данных, полностью написанных на C.

Этот компонент позволяет производить манипуляции с базой данных на более низком уровне, чем при использовании традиционных моделей.

<a name='adapters'></a>

## Адаптеры баз данных

Данный компонент позволяет использовать адаптеры для инкапсуляции конкретных деталей системы баз данных. Phalcon использует PDO для подключения к базам данных. Поддерживаются следующие СУБД:

| Класс                                   | Описание                                                                                                                                                                                                                          |
| --------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Db\Adapter\Pdo\Mysql`      | Наиболее часто используемая реляционная система управления базами данных (RDBMS), которая работает как сервер, обеспечивающий многопользовательский доступ к некоторому набору баз данных.                                        |
| `Phalcon\Db\Adapter\Pdo\Postgresql` | PostgreSQL- мощная реляционная система баз данных с открытым исходным кодом. Это более чем 15 лет активного развития и проверенная архитектура, которая завоевала прочную репутацию за надежность, целостность данных и точность. |
| `Phalcon\Db\Adapter\Pdo\Sqlite`     | Библиотека SQLite реализует автономную, бессерверную, не требующую конфигурации и при этом поддерживающую транзакции базу данных на основе языка SQL.                                                                             |

<a name='adapters-factory'></a>

### Фабрика

<a name='factory'></a>

Загружает адаптер PDO используя параметр `adapter`. Например:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Factory;

$options = [
    'host'     => 'localhost',
    'dbname'   => 'blog',
    'port'     => 3306,
    'username' => 'sigma',
    'password' => 'secret',
    'adapter'  => 'mysql',
];

$db = Factory::load($options);
```

<a name='adapters-custom'></a>

### Реализация собственных адаптеров

The `Phalcon\Db\AdapterInterface` interface must be implemented in order to create your own database adapters or extend the existing ones.

<a name='dialects'></a>

## Диалекты баз данных

Phalcon encapsulates the specific details of each database engine in dialects. Those provide common functions and SQL generator to the adapters.

| Класс                              | Описание                                      |
| ---------------------------------- | --------------------------------------------- |
| `Phalcon\Db\Dialect\Mysql`      | Специфичный SQL диалект для MySQL             |
| `Phalcon\Db\Dialect\Postgresql` | Специфичный SQL диалект для систем PostgreSQL |
| `Phalcon\Db\Dialect\Sqlite`     | Специфичный SQL диалект для SQLite            |

<a name='dialects-custom'></a>

### Реализация собственных диалектов

The `Phalcon\Db\DialectInterface` interface must be implemented in order to create your own database dialects or extend the existing ones.

<a name='connection'></a>

## Подключение к базе данных

Чтобы создать подключение, необходимо создать экземпляр класса адаптера. It only requires an array with the connection parameters. The example below shows how to create a connection passing both required and optional parameters:

```php
<?php

// Required
$config = [
    'host'     => '127.0.0.1',
    'username' => 'mike',
    'password' => 'sigma',
    'dbname'   => 'test_db',
];

// Optional
$config['persistent'] = false;

// Create a connection
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);
```

```php
<?php

// Required
$config = [
    'host'     => 'localhost',
    'username' => 'postgres',
    'password' => 'secret1',
    'dbname'   => 'template',
];

// Optional
$config['schema'] = 'public';

// Create a connection
$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);
```

```php
<?php

// Required
$config = [
    'dbname' => '/path/to/database.db',
];

// Create a connection
$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
```

<a name='options'></a>

## Настройка дополнительных параметров PDO

You can set PDO options at connection time by passing the parameters `options`:

```php
<?php

// Create a connection with PDO options
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'sigma',
        'dbname'   => 'test_db',
        'options'  => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_CASE               => PDO::CASE_LOWER,
        ]
    ]
);
```

<a name='connection-factory'></a>

## Подключение с помощью фабрики

You can also use a simple `ini` file to configure/connect your `db` service to your database.

```ini
[database]
host = TEST_DB_MYSQL_HOST
username = TEST_DB_MYSQL_USER
password = TEST_DB_MYSQL_PASSWD
dbname = TEST_DB_MYSQL_NAME
port = TEST_DB_MYSQL_PORT
charset = TEST_DB_MYSQL_CHARSET
adapter = mysql
```

```php
<?php

use Phalcon\Config\Adapter\Ini;
use Phalcon\Di;
use Phalcon\Db\Adapter\Pdo\Factory;

$di = new Di();
$config = new Ini('config.ini');

$di->set('config', $config);

$di->set(
    'db', 
    function () {
        return Factory::load($this->config->database);
    }
);
```

The above will return the correct database instance and also has the advantage that you can change the connection credentials or even the database adapter without changing a single line of code in your application.

<a name='finding-rows'></a>

## Поиск строк

`Phalcon\Db` provides several methods to query rows from tables. The specific SQL syntax of the target database engine is required in this case:

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';

// Отправляем SQL выражение в базу данных
$result = $connection->query($sql);

// Выводим имя каждого робота
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Получаем все строки в массив
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot['name'];
}

// Получаем только первую строку
$robot = $connection->fetchOne($sql);
```

По умолчанию эти вызовы создают массивы с ассоциативными и нумерованными индексами. Вы можете изменить это поведение используя `Phalcon\Db\Result::setFetchMode()`. Этот метод принимает константу, определяющую необходимый тип индексов.

| Константа                  | Описание                                                   |
| -------------------------- | ---------------------------------------------------------- |
| `Phalcon\Db::FETCH_NUM`   | Возврат массива с нумерованными индексами                  |
| `Phalcon\Db::FETCH_ASSOC` | Возврат массива с ассоциативными индексами                 |
| `Phalcon\Db::FETCH_BOTH`  | Возврат массива с ассоциативными и нумерованными индексами |
| `Phalcon\Db::FETCH_OBJ`   | Возврат объекта вместо массива                             |

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';
$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);
while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

`Phalcon\Db::query()` возвращает экземпляр класса `Phalcon\Db\Result\Pdo`. These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

```php
<?php

$sql = 'SELECT id, name FROM robots';
$result = $connection->query($sql);

// Traverse the resultset
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Seek to the third row
$result->seek(2);
$robot = $result->fetch();

// Count the resultset
echo $result->numRows();
```

<a name='binding-parameters'></a>

## Подготавливаемые запросы

Bound parameters is also supported in `Phalcon\Db`. Although there is a minimal performance impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and positional placeholders are supported. Binding parameters can simply be achieved as follows:

```php
<?php

// Binding with numeric placeholders
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        'Wall-E',
    ]
);

// Binding with named placeholders
$sql     = 'INSERT INTO `robots`(name`, year) VALUES (:name, :year)';
$success = $connection->query(
    $sql,
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case '1' or '2' are considered strings and not numbers, so the placeholder could not be successfully replaced. С любым адаптером данные автоматически экранируются с помощью [PDO Quote](http://www.php.net/manual/en/pdo.quote.php).

Эта функция принимает во внимание кодировку подключения, поэтому рекомендуется определить корректную кодировку в параметрах подключения или в конфигурации сервера баз данных, так как ошибочная кодировка приведет к неожиданным эффектам при сохранении или извлечении данных.

Also, you can pass your parameters directly to the execute/query methods. In this case bound parameters are directly passed to PDO:

```php
<?php

// Binding with PDO placeholders
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        1 => 'Wall-E',
    ]
);
```

<a name='typed-placeholders'></a>

## Типизированные псевдопеременные

Placeholders allowed you to bind parameters to avoid SQL injections:

```php
<?php

$phql = "SELECT * FROM Store\Robots WHERE id > :id:";

$robots = $this->modelsManager->executeQuery($phql, ['id' => 100]);
```

However, some database systems require additional actions when using placeholders such as specifying the type of the bound parameter:

```php
<?php

use Phalcon\Db\Column;

// ...

$phql = "SELECT * FROM Store\Robots LIMIT :number:";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['number' => 10],
    Column::BIND_PARAM_INT
);
```

You can use typed placeholders in your parameters, instead of specifying the bind type in `executeQuery()`:

```php
<?php

$phql = "SELECT * FROM Store\Robots LIMIT {number:int}";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['number' => 10]
);

$phql = "SELECT * FROM Store\Robots WHERE name <> {name:str}";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['name' => $name]
);
```

You can also omit the type if you don't need to specify it:

```php
<?php

$phql = "SELECT * FROM Store\Robots WHERE name <> {name}";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['name' => $name]
);
```

Typed placeholders are also more powerful, since we can now bind a static array without having to pass each element independently as a placeholder:

```php
<?php

$phql = "SELECT * FROM Store\Robots WHERE id IN ({ids:array})";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['ids' => [1, 2, 3, 4]]
);
```

The following types are available:

| Bind Type | Bind Type Constant                | Example          |
| --------- | --------------------------------- | ---------------- |
| str       | `Column::BIND_PARAM_STR`          | `{name:str}`     |
| int       | `Column::BIND_PARAM_INT`          | `{number:int}`   |
| double    | `Column::BIND_PARAM_DECIMAL`      | `{price:double}` |
| bool      | `Column::BIND_PARAM_BOOL`         | `{enabled:bool}` |
| blob      | `Column::BIND_PARAM_BLOB`         | `{image:blob}`   |
| null      | `Column::BIND_PARAM_NULL`         | `{exists:null}`  |
| array     | Array of `Column::BIND_PARAM_STR` | `{codes:array}`  |
| array-str | Array of `Column::BIND_PARAM_STR` | `{names:array}`  |
| array-int | Array of `Column::BIND_PARAM_INT` | `{flags:array}`  |

<a name='cast-bound-parameter-values'></a>

## Приведение типов связываемых параметров

By default, bound parameters aren't casted in the PHP userland to the specified bind types, this option allows you to make Phalcon cast values before bind them with PDO. A classic situation when this problem raises is passing a string in a `LIMIT`/`OFFSET` placeholder:

```php
<?php

$number = '100';
$robots = $modelsManager->executeQuery(
    'SELECT * FROM Some\Robots LIMIT {number:int}',
    ['number' => $number]
);
```

This causes the following exception:

    Fatal error: Uncaught exception 'PDOException' with message 'SQLSTATE[42000]:
    Syntax error or access violation: 1064 You have an error in your SQL syntax;
    check the manual that corresponds to your MySQL server version for the right
    syntax to use near ''100'' at line 1' in /Users/scott/demo.php:78
    

This happens because 100 is a string variable. It is easily fixable by casting the value to integer first:

```php
<?php

$number = '100';
$robots = $modelsManager->executeQuery(
    'SELECT * FROM Some\Robots LIMIT {number:int}',
    ['number' => (int) $number]
);
```

However this solution requires that the developer pays special attention about how bound parameters are passed and their types. To make this task easier and avoid unexpected exceptions you can instruct Phalcon to do this casting for you:

```php
<?php

\Phalcon\Db::setup(['forceCasting' => true]);
```

The following actions are performed according to the bind type specified:

| Bind Type                    | Action                                 |
| ---------------------------- | -------------------------------------- |
| Column::BIND_PARAM_STR     | Cast the value as a native PHP string  |
| Column::BIND_PARAM_INT     | Cast the value as a native PHP integer |
| Column::BIND_PARAM_BOOL    | Cast the value as a native PHP boolean |
| Column::BIND_PARAM_DECIMAL | Cast the value as a native PHP double  |

<a name='cast-on-hydrate'></a>

## Приведение типов при гидрации

Values returned from the database system are always represented as string values by PDO, no matter if the value belongs to a numerical or boolean type column. This happens because some column types cannot be represented with its corresponding PHP native types due to their size limitations. For instance, a `BIGINT` in MySQL can store large integer numbers that cannot be represented as a 32bit integer in PHP. Because of that, PDO and the ORM by default, make the safe decision of leaving all values as strings.

You can set up the ORM to automatically cast those types considered safe to their corresponding PHP native types:

```php
<?php

\Phalcon\Mvc\Model::setup(['castOnHydrate' => true]);
```

This way you can use strict operators or make assumptions about the type of variables:

```php
<?php

$robot = Robots::findFirst();
if (11 === $robot->id) {
    echo $robot->name;
}
```

<a name='crud'></a>

## Вставка, обновление и удаление строк

To insert, update or delete rows, you can use raw SQL or use the preset functions provided by the class:

```php
<?php

// Inserting data with a raw SQL statement
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        1952,
    ]
);

// Generating dynamically the necessary SQL
$success = $connection->insert(
    'robots',
    [
        'Astro Boy',
        1952,
    ],
    [
        'name',
        'year',
    ],
);

// Generating dynamically the necessary SQL (another syntax)
$success = $connection->insertAsDict(
    'robots',
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);

// Updating data with a raw SQL statement
$sql     = 'UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'UPDATE `robots` SET `name` = ? WHERE `id` = ?';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        101,
    ]
);

// Generating dynamically the necessary SQL
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    'id = 101' // Warning! In this case values are not escaped
);

// Generating dynamically the necessary SQL (another syntax)
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    'id = 101' // Warning! In this case values are not escaped
);

// With escaping conditions
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [101],
        'bindTypes'  => [PDO::PARAM_INT], // Optional parameter
    ]
);
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [101],
        'bindTypes'  => [PDO::PARAM_INT], // Optional parameter
    ]
);

// Deleting data with a raw SQL statement
$sql     = 'DELETE `robots` WHERE `id` = 101';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'DELETE `robots` WHERE `id` = ?';
$success = $connection->execute($sql, [101]);

// Generating dynamically the necessary SQL
$success = $connection->delete(
    'robots',
    'id = ?',
    [
        101,
    ]
);
```

<a name='transactions'></a>

## Транзакции и вложенные транзакции

Работа с транзакциями поддерживается также, как и в PDO. Выполнение изменения данных внутри транзакций, часто увеличивает производительность в большинстве систем баз данных:

```php
<?php

try {
    // Start a transaction
    $connection->begin();

    // Execute some SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 101');
    $connection->execute('DELETE `robots` WHERE `id` = 102');
    $connection->execute('DELETE `robots` WHERE `id` = 103');

    // Commit if everything goes well
    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

В дополнение к стандартным транзакциям, `Phalcon\Db` предоставляет встроенную поддержку для [вложенных транзакций](http://en.wikipedia.org/wiki/Nested_transaction) (если используемая база данных поддерживает их). When you call begin() for a second time a nested transaction is created:

```php
<?php

try {
    // Start a transaction
    $connection->begin();

    // Execute some SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 101');

    try {
        // Start a nested transaction
        $connection->begin();

        // Execute these SQL statements into the nested transaction
        $connection->execute('DELETE `robots` WHERE `id` = 102');
        $connection->execute('DELETE `robots` WHERE `id` = 103');

        // Create a save point
        $connection->commit();
    } catch (Exception $e) {
        // An error has occurred, release the nested transaction
        $connection->rollback();
    }

    // Continue, executing more SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 104');

    // Commit if everything goes well
    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

<a name='events'></a>

## События базы данных

`Phalcon\Db` is able to send events to a [EventsManager](/[[language]]/[[version]]/events) if it's present. Some events when returning boolean false could stop the active operation. Поддерживаются следующие события:

| Название события      | Срабатывает                                          | Может остановить операцию? |
| --------------------- | ---------------------------------------------------- |:--------------------------:|
| `afterConnect`        | После успешного подключения к базе данных            |            Нет             |
| `beforeQuery`         | Перед отправкой SQL выражения в базу данных          |             Да             |
| `afterQuery`          | После отправки SQL выражения в базу данных           |            Нет             |
| `beforeDisconnect`    | Перед закрытием временного подключения к базе данных |            Нет             |
| `beginTransaction`    | Перед тем, как транзакция будет запущена             |            Нет             |
| `rollbackTransaction` | Перед тем, как транзакция откатится                  |            Нет             |
| `commitTransaction`   | Перед фиксацией транзакции                           |            Нет             |

Bind an EventsManager to a connection is simple, `Phalcon\Db` will trigger the events with the type `db`:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$eventsManager = new EventsManager();

// Listen all the database events
$eventsManager->attach('db', $dbListener);

$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);
```

Stop SQL operations are very useful if for example you want to implement some last-resource SQL injector checker:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) {
        $sql = $connection->getSQLStatement();

        // Check for malicious words in SQL statements
        if (preg_match('/DROP|ALTER/i', $sql)) {
            // DROP/ALTER operations aren't allowed in the application,
            // this must be a SQL injection!
            return false;
        }

        // It's OK
        return true;
    }
);
```

<a name='profiling'></a>

## Профилирование SQL запросов

`Phalcon\Db` includes a profiling component called `Phalcon\Db\Profiler`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With `Phalcon\Db\Profiler`:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

$eventsManager = new EventsManager();

$profiler = new DbProfiler();

// Listen all the database events
$eventsManager->attach(
    'db',
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === 'beforeQuery') {
            $sql = $connection->getSQLStatement();

            // Start a profile with the active connection
            $profiler->startProfile($sql);
        }

        if ($event->getType() === 'afterQuery') {
            // Stop the active profile
            $profiler->stopProfile();
        }
    }
);

// Assign the events manager to the connection
$connection->setEventsManager($eventsManager);

$sql = 'SELECT buyer_name, quantity, product_name '
     . 'FROM buyers '
     . 'LEFT JOIN products ON buyers.pid = products.id';

// Execute a SQL statement
$connection->query($sql);

// Get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo 'SQL Statement: ', $profile->getSQLStatement(), "\n";
echo 'Start Time: ', $profile->getInitialTime(), "\n";
echo 'Final Time: ', $profile->getFinalTime(), "\n";
echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), "\n";
```

You can also create your own profile class based on `Phalcon\Db\Profiler` to record real time statistics of the statements sent to the database system:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as Profiler;
use Phalcon\Db\Profiler\Item as Item;

class DbProfiler extends Profiler
{
    /**
     * Executed before the SQL statement will sent to the db server
     */
    public function beforeStartProfile(Item $profile)
    {
        echo $profile->getSQLStatement();
    }

    /**
     * Executed after the SQL statement was sent to the db server
     */
    public function afterEndProfile(Item $profile)
    {
        echo $profile->getTotalElapsedSeconds();
    }
}

// Create an Events Manager
$eventsManager = new EventsManager();

// Create a listener
$dbProfiler = new DbProfiler();

// Attach the listener listening for all database events
$eventsManager->attach('db', $dbProfiler);
```

<a name='logging-statements'></a>

## Логирование SQL выражений

Using high-level abstraction components such as `Phalcon\Db` to access a database, it is difficult to understand which statements are sent to the database system. `Phalcon\Logger` interacts with `Phalcon\Db`, providing logging capabilities on the database abstraction layer.

```php
<?php

use Phalcon\Logger;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;

$eventsManager = new EventsManager();

$logger = new FileLogger('app/logs/db.log');

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) use ($logger) {
        $sql = $connection->getSQLStatement();

        $logger->log($sql, Logger::INFO);
    }
);

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);

// Execute some SQL statement
$connection->insert(
    'products',
    [
        'Hot pepper',
        3.50,
    ],
    [
        'name',
        'price',
    ]
);
```

As above, the file `app/logs/db.log` will contain something like this:

```bash
[Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
(name, price) VALUES ('Hot pepper', 3.50)
```

<a name='logger-custom'></a>

## Реализация собственного логера

You can implement your own logger class for database queries, by creating a class that implements a single method called `log`. The method needs to accept a string as the first argument. You can then pass your logging object to `Phalcon\Db::setLogger()`, and from then on any SQL statement executed will call that method to log the results.

<a name='describing-tables'></a>

## Описание таблиц и представлений

`Phalcon\Db` also provides methods to retrieve detailed information about tables and views:

```php
<?php

// Get tables on the test_db database
$tables = $connection->listTables('test_db');

// Is there a table 'robots' in the database?
$exists = $connection->tableExists('robots');

// Get name, data types and special features of 'robots' fields
$fields = $connection->describeColumns('robots');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}

// Get indexes on the 'robots' table
$indexes = $connection->describeIndexes('robots');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}

// Get foreign keys on the 'robots' table
$references = $connection->describeReferences('robots');
foreach ($references as $reference) {
    // Print referenced columns
    print_r(
        $reference->getReferencedColumns()
    );
}
```

A table description is very similar to the MySQL describe command, it contains the following information:

| Поле         | Тип         | Ключ                                               | Null                               |
| ------------ | ----------- | -------------------------------------------------- | ---------------------------------- |
| Field's name | Column Type | Is the column part of the primary key or an index? | Does the column allow null values? |

Methods to get information about views are also implemented for every supported database system:

```php
<?php

// Get views on the test_db database
$tables = $connection->listViews('test_db');

// Is there a view 'robots' in the database?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## Создание, изменение и удаление таблиц

Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of commands such as CREATE, ALTER or DROP. The SQL syntax differs based on which database system is used. `Phalcon\Db` offers a unified interface to alter tables, without the need to differentiate the SQL syntax based on the target storage system.

<a name='tables-create'></a>

### Создание таблиц

The following example shows how to create a table:

```php
<?php

use \Phalcon\Db\Column as Column;

$connection->createTable(
    'robots',
    null,
    [
       'columns' => [
            new Column(
                'id',
                [
                    'type'          => Column::TYPE_INTEGER,
                    'size'          => 10,
                    'notNull'       => true,
                    'autoIncrement' => true,
                    'primary'       => true,
                ]
            ),
            new Column(
                'name',
                [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 70,
                    'notNull' => true,
                ]
            ),
            new Column(
                'year',
                [
                    'type'    => Column::TYPE_INTEGER,
                    'size'    => 11,
                    'notNull' => true,
                ]
            ),
        ]
    ]
);
```

`Phalcon\Db::createTable()` accepts an associative array describing the table. Columns are defined with the class `Phalcon\Db\Column`. The table below shows the options available to define a column:

| Параметр        | Description                                                                                                                                | Опционально |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |:-----------:|
| `type`          | Column type. Must be a `Phalcon\Db\Column` constant (see below for a list)                                                               |     No      |
| `primary`       | True if the column is part of the table's primary key                                                                                      |     Yes     |
| `size`          | Some type of columns like `VARCHAR` or `INTEGER` may have a specific size                                                                  |     Yes     |
| `scale`         | `DECIMAL` or `NUMBER` columns may be have a scale to specify how many decimals should be stored                                            |     Yes     |
| `unsigned`      | `INTEGER` columns may be signed or unsigned. This option does not apply to other types of columns                                          |     Yes     |
| `notNull`       | Column can store null values?                                                                                                              |     Yes     |
| `default`       | Default value (when used with `'notNull' => true`).                                                                                     |     Yes     |
| `autoIncrement` | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. |     Yes     |
| `bind`          | One of the `BIND_TYPE_*` constants telling how the column must be bound before save it                                                     |     Yes     |
| `first`         | Column must be placed at first position in the column order                                                                                |     Yes     |
| `after`         | Column must be placed after indicated column                                                                                               |     Yes     |

`Phalcon\Db` supports the following database column types:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in `Phalcon\Db::createTable()` can have the possible keys:

| Индекс       | Description                                                                                                                            | Опционально |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------- |:-----------:|
| `columns`    | An array with a set of table columns defined with `Phalcon\Db\Column`                                                                |     No      |
| `indexes`    | An array with a set of table indexes defined with `Phalcon\Db\Index`                                                                 |     Yes     |
| `references` | An array with a set of table references (foreign keys) defined with `Phalcon\Db\Reference`                                           |     Yes     |
| `options`    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. |     Yes     |

<a name='tables-altering'></a>

### Изменение таблиц

As your application grows, you might need to alter your database, as part of a refactoring or adding new features. Not all database systems allow to modify existing columns or add columns between two existing ones. `Phalcon\Db` is limited by these constraints.

```php
<?php

use Phalcon\Db\Column as Column;

// Adding a new column
$connection->addColumn(
    'robots',
    null,
    new Column(
        'robot_type',
        [
            'type'    => Column::TYPE_VARCHAR,
            'size'    => 32,
            'notNull' => true,
            'after'   => 'name',
        ]
    )
);

// Modifying an existing column
$connection->modifyColumn(
    'robots',
    null,
    new Column(
        'name',
        [
            'type'    => Column::TYPE_VARCHAR,
            'size'    => 40,
            'notNull' => true,
        ]
    )
);

// Deleting the column 'name'
$connection->dropColumn(
    'robots',
    null,
    'name'
);
```

<a name='tables-dropping'></a>

### Удаление таблиц

Examples on dropping tables:

```php
<?php

// Drop table robot from active database
$connection->dropTable('robots');

// Drop table robot from database 'machines'
$connection->dropTable('robots', 'machines');
```