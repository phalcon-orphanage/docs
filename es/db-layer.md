<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Capa de abstracción de base de datos</a> 
      <ul>
        <li>
          <a href="#adapters">Adaptadores de base de datos</a> 
          <ul>
            <li>
              <a href="#adapters-factory">Factory</a>
            </li>
            <li>
              <a href="#adapters-custom">Implementar tus propios adaptadores</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#dialects">Dialectos de la base de datos</a> 
          <ul>
            <li>
              <a href="#dialects-custom">Implementar sus propios dialectos</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#connection">Conexión a bases de datos</a> 
          <ul>
            <li>
              <a href="#connection-factory">Conexión usando Factory</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#options">Configuración de opciones adicionales de PDO</a>
        </li>
        <li>
          <a href="#finding-rows">Encontrar Registros</a>
        </li>
        <li>
          <a href="#binding-parameters">Enlazando parámetros</a>
        </li>
        <li>
          <a href="#typed-placeholders">Typed placeholders</a>
        </li>
        <li>
          <a href="#cast-bound-parameter-values">Cast bound parameters values</a>
        </li>
        <li>
          <a href="#cast-on-hydrate">Cast on Hydrate</a>
        </li>
        <li>
          <a href="#crud">Insertar/Actualizar/Borrar registros</a>
        </li>
        <li>
          <a href="#transactions">Transacciones y transacciones anidadas</a>
        </li>
        <li>
          <a href="#events">Eventos de base de datos</a>
        </li>
        <li>
          <a href="#profiling">Perfiles de sentencias SQL</a>
        </li>
        <li>
          <a href="#logging-statements">Log de sentencias SQL</a>
        </li>
        <li>
          <a href="#logger-custom">Implementar tu propio Logger</a>
        </li>
        <li>
          <a href="#describing-tables">Descripción de tablas o vistas</a>
        </li>
        <li>
          <a href="#tables">Crear/Modificar/Eliminar tablas</a> 
          <ul>
            <li>
              <a href="#tables-create">Crear tablas</a>
            </li>
            <li>
              <a href="#tables-altering">Modificar tablas</a>
            </li>
            <li>
              <a href="#tables-dropping">Eliminar tablas</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Capa de abstracción de base de datos

`Phalcon\Db` es el componente detrás de `Phalcon\Mvc\Model` que impulsa la capa del modelo del framework. Este consiste en una capa de abstracción de alto nivel independiente para bases de datos, escrito completamente en C.

Este componente permite una manipulación de base de datos a nivel inferior que el uso de los modelos tradicionales.

<a name='adapters'></a>

## Adaptadores de base de datos

Este componente hace uso de adaptadores para encapsular detalles específicos del sistema de base de datos. Phalcon utiliza PDO para conectar a las bases de datos. Son soportados los siguientes motores de base de datos:

| Clase                                   | Descripción                                                                                                                                                                                                                                                |
| --------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Db\Adapter\Pdo\Mysql`      | Es el sistema de gestión de bases de datos relacionales (RDBMS) más utilizado en el mundo, se ejecuta como un servidor que provee acceso a múltiples usuarios a un número de bases de datos.                                                               |
| `Phalcon\Db\Adapter\Pdo\Postgresql` | PostgreSQL es un sistema de base de datos relacional de código abierto muy potente. Tiene más de 15 años de desarrollo activo y una arquitectura probada que se ha ganado una sólida reputación por la fiabilidad, la integridad y exactitud de los datos. |
| `Phalcon\Db\Adapter\Pdo\Sqlite`     | SQLite es una biblioteca de software que implementa un motor de base de datos SQL transaccional que es auto contenido, que no requiere de un servidor y que no requiere configuración.                                                                     |

<a name='adapters-factory'></a>

### Factory

<a name='factory'></a>

Carga la clase del Adaptador PDO utilizando la opción `adapter`. Por ejemplo:

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

### Implementar tus propios adaptadores

Debe implementar la interfaz `Phalcon\Db\AdapterInterface` para crear sus propios adaptadores de base de datos o extender los ya existentes.

<a name='dialects'></a>

## Dialectos de la base de datos

Phalcon encapsula los detalles específicos de cada motor de base de datos en dialectos. Estos proporcionan funciones comunes y generadores de SQL a los adaptadores.

| Clase                              | Descripción                                           |
| ---------------------------------- | ----------------------------------------------------- |
| `Phalcon\Db\Dialect\Mysql`      | Dialecto específico SQL para base de datos MySQL      |
| `Phalcon\Db\Dialect\Postgresql` | Dialecto específico SQL para base de datos PostgreSQL |
| `Phalcon\Db\Dialect\Sqlite`     | Dialecto específico SQL para base de datos de SQLite  |

<a name='dialects-custom'></a>

### Implementar sus propios dialectos

Debe implementar la interfaz `Phalcon\Db\DialectInterface` para crear sus propios dialectos de la base de datos o extender los ya existentes.

<a name='connection'></a>

## Conexión a bases de datos

Para crear una conexión es necesario crear una instancia del adaptador. Sólo requiere una arreglo con los parámetros de conexión. En el ejemplo siguiente se muestra cómo crear una conexión pasando parámetros requeridos y opcionales:

```php
<?php

// Requeridos
$config = [
    'host'     => '127.0.0.1',
    'username' => 'mike',
    'password' => 'sigma',
    'dbname'   => 'test_db',
];

// Opcionales
$config['persistent'] = false;

// Crear una conexión
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);
```

```php
<?php

// Requeridos
$config = [
    'host'     => 'localhost',
    'username' => 'postgres',
    'password' => 'secret1',
    'dbname'   => 'template',
];

// Opcionales
$config['schema'] = 'public';

// Crear una conexión
$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);
```

```php
<?php

// Requeridos
$config = [
    'dbname' => '/path/to/database.db',
];

// Crear una conexión
$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
```

<a name='options'></a>

## Configuración de opciones adicionales de PDO

Se pueden definir opciones de PDO al momento de conexión pasando los parámetros en `options`:

```php
<?php

// Crear una conexión con opciones PDO
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

## Conexión usando Factory

También puede utilizar un simple archivo `ini` para configurar/conectar el servicio de `db` para la base de datos.

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

Lo anterior devuelve la instancia de base de datos correcta y también tiene la ventaja de que puedes cambiar las credenciales de conexión o incluso el adaptador de la base de datos sin cambiar una sola línea de código en su aplicación.

<a name='finding-rows'></a>

## Encontrar Registros

`Phalcon\Db` proporciona varios métodos para consultar las filas de las tablas. En este caso se requiere la sintaxis SQL específica para el motor de base de datos de destino:

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';

// Enviar una consulta SQL al sistema de base de datos
$result = $connection->query($sql);

// Imprimir cada nombre de robot
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Obtener todas las filas en un array
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot['name'];
}

// Obtener solo la primera fila
$robot = $connection->fetchOne($sql);
```

Por defecto estas llamadas crean arrays con índices asociativos y numéricos. Usted puede cambiar este comportamiento mediante `Phalcon\Db\Result::setFetchMode()`. Este método recibe una constante, definiendo qué tipo de índice necesita.

| Constante                  | Descripción                                           |
| -------------------------- | ----------------------------------------------------- |
| `Phalcon\Db::FETCH_NUM`   | Devuelve un array con índices numéricos               |
| `Phalcon\Db::FETCH_ASSOC` | Devuelve un array con índices asociativos             |
| `Phalcon\Db::FETCH_BOTH`  | Devuelve un array con índices asociativos y numéricos |
| `Phalcon\Db::FETCH_OBJ`   | Devolver un objeto en lugar de un array               |

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';
$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);
while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

`Phalcon\Db::query()` devuelve una instancia de `Phalcon\Db\Result\Pdo`. Estos objetos encapsulan toda la funcionalidad relacionada con el resultado devuelto, es decir, recorrer los registros, buscar registros específicos, contarlos, etcétera.

```php
<?php

$sql = 'SELECT id, name FROM robots';
$result = $connection->query($sql);

// Recorrer el conjunto de resultados
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Buscar la tercer fila
$result->seek(2);
$robot = $result->fetch();

// Contar cuantos registros hay en el conjunto de resultados
echo $result->numRows();
```

<a name='binding-parameters'></a>

## Enlazando parámetros

Los parámetros enlazados también son compatibles con `Phalcon\Db`. Aunque hay un mínimo impacto en la performance al utilizar parámetros enlazados, le animamos a utilizar esta metodología, con el fin de eliminar la posibilidad que su código esté sujeto a ataques de inyección SQL. Se admiten dos tipos de marcadores: por nombre o numérico. El enlazado de parámetros se hace simplemente de la siguiente manera:

```php
<?php

// Enlazando con marcadores numéricos
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        'Wall-E',
    ]
);

// Enlazando con marcadores nombrados
$sql     = 'INSERT INTO `robots`(name`, year) VALUES (:name, :year)';
$success = $connection->query(
    $sql,
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

Cuando se utilizan marcadores numéricos, necesita definirlos como enteros, es decir, 1 o 2. En este caso '1' o '2' se consideran cadenas y no números, por lo que el marcador de posición no podría sustituirse con éxito. Con cualquier adaptador de datos se escapan automáticamente utilizando [PDO Quote](http://www.php.net/manual/en/pdo.quote.php).

Esta función tiene en cuenta el conjunto de caracteres de conexión, por lo que se recomienda definir el conjunto de caracteres correcto en los parámetros de conexión o en la configuración de servidor de base de datos, como un conjunto de caracteres incorrecto producirá efectos no deseados al almacenar o recuperar datos.

También, se puede pasar sus parámetros directamente a los métodos `execute` o `query`. En este caso los parámetros enlazados se pasan directamente al PDO:

```php
<?php

// Enlazando con marcadores PDO
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        1 => 'Wall-E',
    ]
);
```

<a name='typed-placeholders'></a>

## Typed placeholders

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

## Cast bound parameters values

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

## Cast on Hydrate

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

## Insertar/Actualizar/Borrar registros

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

## Transacciones y transacciones anidadas

Working with transactions is supported as it is with PDO. Perform data manipulation inside transactions often increase the performance on most database systems:

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

In addition to standard transactions, `Phalcon\Db` provides built-in support for [nested transactions](http://en.wikipedia.org/wiki/Nested_transaction) (if the database system used supports them). When you call begin() for a second time a nested transaction is created:

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

## Eventos de base de datos

`Phalcon\Db` is able to send events to a [EventsManager](/[[language]]/[[version]]/events) if it's present. Some events when returning boolean false could stop the active operation. The following events are supported:

| Nombre de Evento      | Activador                                                          | ¿Puede detener la operación? |
| --------------------- | ------------------------------------------------------------------ |:----------------------------:|
| `afterConnect`        | Después de una conexión con éxito a un sistema de base de datos    |              No              |
| `beforeQuery`         | Antes de enviar una instrucción SQL en el sistema de base de datos |              Sí              |
| `afterQuery`          | Después de enviar una instrucción SQL a la base de datos           |              No              |
| `beforeDisconnect`    | Antes de cerrar una conexión temporal de base de datos             |              No              |
| `beginTransaction`    | Antes de comenzar una transacción                                  |              No              |
| `rollbackTransaction` | Antes de anular (roolback) una transacción                         |              No              |
| `commitTransaction`   | Antes de que una finalizar (commit) una transacción                |              No              |

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

## Perfiles de sentencias SQL

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

## Log de sentencias SQL

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

## Implementar tu propio Logger

You can implement your own logger class for database queries, by creating a class that implements a single method called `log`. The method needs to accept a string as the first argument. You can then pass your logging object to `Phalcon\Db::setLogger()`, and from then on any SQL statement executed will call that method to log the results.

<a name='describing-tables'></a>

## Descripción de tablas o vistas

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

| Campo            | Tipo            | Clave                                                      | Nulo                              |
| ---------------- | --------------- | ---------------------------------------------------------- | --------------------------------- |
| Nombre del campo | Tipo de columna | ¿Es la columna parte de la clave principal o de un índice? | ¿La columna permite valores null? |

Methods to get information about views are also implemented for every supported database system:

```php
<?php

// Get views on the test_db database
$tables = $connection->listViews('test_db');

// Is there a view 'robots' in the database?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## Crear/Modificar/Eliminar tablas

Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of commands such as CREATE, ALTER or DROP. The SQL syntax differs based on which database system is used. `Phalcon\Db` offers a unified interface to alter tables, without the need to differentiate the SQL syntax based on the target storage system.

<a name='tables-create'></a>

### Crear tablas

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

| Opción          | Description                                                                                                                         | Opcional |
| --------------- | ----------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `type`          | Tipo de columna. Debe ser una constante de `Phalcon\Db\Column` (ver lista de abajo)                                               |    No    |
| `primary`       | `true` si la columna forma parte de la clave primaria de la tabla                                                                   |   Yes    |
| `size`          | Algunos tipos de columnas como `VARCHAR` o `INTEGER` puede tener un tamaño específico                                               |   Yes    |
| `scale`         | Columnas `DECIMAL` o `NUMBER` pueden tener una escala para especificar cuántos decimales deben almacenarse                          |   Yes    |
| `unsigned`      | Las columnas `INTEGER` pueden tener signo o no. Esta opción no se aplica a otros tipos de columnas                                  |   Yes    |
| `notNull`       | ¿La columna puede almacenar valores nulos?                                                                                          |   Yes    |
| `default`       | Valor por defecto (cuando se usa con `'notNull' => true`).                                                                       |   Yes    |
| `autoIncrement` | Con este atributo la columna se incrementará automáticamente con un entero. Solo una columna en la tabla puede tener este atributo. |   Yes    |
| `bind`          | Una de las constantes `BIND_TYPE_*` que indica como debe tratarse la columna antes de guardarse                                     |   Yes    |
| `first`         | La columna debe colocarse en primera posición en el orden de columnas                                                               |   Yes    |
| `after`         | La columna debe colocarse después de la columna indicada                                                                            |   Yes    |

`Phalcon\Db` supports the following database column types:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in `Phalcon\Db::createTable()` can have the possible keys:

| Índice       | Description                                                                                                                                                     | Opcional |
| ------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | Un array con un conjunto de columnas de la tabla definida con `Phalcon\Db\Column`                                                                             |    No    |
| `indexes`    | Un array con un conjunto de índices de la tabla definida con `Phalcon\Db\Index`                                                                               |   Yes    |
| `references` | Un array con un conjunto de referencias de tabla (foreign keys) definidas con `Phalcon\Db\Reference`                                                          |   Yes    |
| `options`    | Un array con un conjunto de opciones de creación de la tabla. Estas opciones se refieren a menudo al sistema de base de datos en la que se generó la migración. |   Yes    |

<a name='tables-altering'></a>

### Modificar tablas

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

### Eliminar tablas

Examples on dropping tables:

```php
<?php

// Drop table robot from active database
$connection->dropTable('robots');

// Drop table robot from database 'machines'
$connection->dropTable('robots', 'machines');
```