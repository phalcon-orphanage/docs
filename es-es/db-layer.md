* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Capa de abstracción de base de datos

[Phalcon\Db](api/Phalcon_Db) is the component behind [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) that powers the model layer in the framework. Este consiste en una capa de abstracción de alto nivel independiente para bases de datos, escrito completamente en C.

Este componente permite una manipulación de base de datos a nivel inferior que el uso de los modelos tradicionales.

<a name='adapters'></a>

## Adaptadores de base de datos

Este componente hace uso de adaptadores para encapsular detalles específicos del sistema de base de datos. Phalcon utiliza PDO para conectar a las bases de datos. Son soportados los siguientes motores de base de datos:

| Clase                                                                          | Descripción                                                                                                                                                                                                                                                |
| ------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Db\Adapter\Pdo\Mysql](api/Phalcon_Db_Adapter_Pdo_Mysql)           | Es el sistema de gestión de bases de datos relacionales (RDBMS) más utilizado en el mundo. se ejecuta como un servidor que provee acceso a usuarios a un número de bases de datos                                                                          |
| [Phalcon\Db\Adapter\Pdo\Postgresql](api/Phalcon_Db_Adapter_Pdo_Postgresql) | PostgreSQL es un sistema de base de datos relacional de código abierto muy potente. Tiene más de 15 años de desarrollo activo y una arquitectura probada que se ha ganado una sólida reputación por la fiabilidad, la integridad y exactitud de los datos. |
| [Phalcon\Db\Adapter\Pdo\Sqlite](api/Phalcon_Db_Adapter_Pdo_Sqlite)         | SQLite es una biblioteca de software que implementa un motor de base de datos SQL transaccional independiente, sin servidor, sin configuración                                                                                                             |

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

### Implementando sus propios adaptadores

The [Phalcon\Db\AdapterInterface](api/Phalcon_Db_AdapterInterface) interface must be implemented in order to create your own database adapters or extend the existing ones.

<a name='dialects'></a>

## Dialectos de la base de datos

Phalcon encapsula los detalles específicos de cada motor de base de datos en dialectos. Estos proporcionan funciones comunes y generadores de SQL a los adaptadores.

| Clase                                                                 | Descripción                                           |
| --------------------------------------------------------------------- | ----------------------------------------------------- |
| [Phalcon\Db\Dialect\Mysql](api/Phalcon_Db_Dialect_Mysql)           | Dialecto específico SQL para base de datos MySQL      |
| [Phalcon\Db\Dialect\Postgresql](api/Phalcon_Db_Dialect_Postgresql) | Dialecto específico SQL para base de datos PostgreSQL |
| [Phalcon\Db\Dialect\Sqlite](api/Phalcon_Db_Dialect_Sqlite)         | Dialecto específico SQL para base de datos de SQLite  |

<a name='dialects-custom'></a>

### Implementar sus propios dialectos

The [Phalcon\Db\DialectInterface](api/Phalcon_Db_DialectInterface) interface must be implemented in order to create your own database dialects or extend the existing ones. Incluso puede mejorar su dialecto actual agregando más comandos/métodos para que PHQL los entienda.

Por ejemplo, cuando utilizamos el adaptador MySQL, y queremos permitir que PHQL reconozca la sintaxis `MATCH ... AGAINST ...`. Asociamos la sintaxis con `MATCH_AGAINST`

Instanciamos el dialecto. Agregamos la función personalizada para que PHQL comprenda qué hacer cuando la encuentra durante el proceso de análisis sintáctico. En el siguiente ejemplo, registramos una nueva función personalizada llamada `MATCH_AGAINST`. Después de eso todo lo que tenemos que hacer es añadir el objeto del dialecto personalizado a nuestra conexión.

```php
<?php

use Phalcon\Db\Dialect\MySQL as SqlDialect;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

$dialect = new SqlDialect();

$dialect->registerCustomFunction(
    'MATCH_AGAINST',
    function($dialect, $expression) {
        $arguments = $expression['arguments'];
        return sprintf(
            " MATCH (%s) AGAINST (%)",
            $dialect->getSqlExpression($arguments[0]),
            $dialect->getSqlExpression($arguments[1])
         );
    }
);

$connection = new Connection(
    [
        "host"          => "localhost",
        "username"      => "root",
        "password"      => "",
        "dbname"        => "test",
        "dialectClass"  => $dialect
    ]
);
```

Ahora podemos utilizar esta nueva función en PHQL, que a su vez lo traducirá en la sintaxis SQL adecuada:

```php
$phql = "
  SELECT *
  FROM   Posts
  WHERE  MATCH_AGAINST(title, :pattern:)";

$posts = $modelsManager->executeQuery($phql, ['pattern' => $pattern]);
```

<a name='connection'></a>

## Conexión a bases de datos

Para crear una conexión es necesario crear una instancia de la clase del adaptador. Solo se requiere un arreglo con los parámetros de conexión. En el ejemplo siguiente se muestra cómo crear una conexión pasando tanto los parámetros opcionales como los parámetros requeridos:

##### MySQL Required elements

```php
<?php

$config = [
    'host'     => '127.0.0.1',
    'username' => 'mike',
    'password' => 'sigma',
    'dbname'   => 'test_db',
];
```

##### MySQL Optional

```php
$config['persistent'] = false;
```

##### MySQL Create a connection

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);
```

##### PostgreSQL Required elements

```php
<?php

$config = [
    'host'     => 'localhost',
    'username' => 'postgres',
    'password' => 'secret1',
    'dbname'   => 'template',
];
```

##### PostgreSQL Optional

```php
$config['schema'] = 'public';
```

##### PostgreSQL Create a connection

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);
```

##### SQLite Required elements

```php
<?php

$config = [
    'dbname' => '/path/to/database.db',
];
```

##### SQLite Create a connection

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
```

<a name='options'></a>

## Configuración de opciones adicionales de PDO

Se pueden definir opciones de PDO al momento de conexión pasando los parámetros en `options`:

```php
<?php

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

También se puede utilizar un simple archivo `ini` para configurar o conectar el servicio `db` a la base de datos.

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

[Phalcon\Db](api/Phalcon_Db) provides several methods to query rows from tables. The specific SQL syntax of the target database engine is required in this case:

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';

// Send a SQL statement to the database system
$result = $connection->query($sql);

// Print each robot name
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Get all rows in an array
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot['name'];
}

// Get only the first row
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

The `Phalcon\Db::query()` returns an instance of [Phalcon\Db\Result\Pdo](api/Phalcon_Db_Result_Pdo). Estos objetos encapsulan toda la funcionalidad relacionada con el resultado devuelto, es decir, recorrer los registros, buscar registros específicos, contarlos, etcétera.

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

## Enlazando parámetros

Bound parameters is also supported in [Phalcon\Db](api/Phalcon_Db). Aunque hay un mínimo impacto en la performance al utilizar parámetros enlazados, le animamos a utilizar esta metodología, con el fin de eliminar la posibilidad que su código esté sujeto a ataques de inyección SQL. Se admiten dos tipos de marcadores: por nombre o numérico. El enlazado de parámetros se hace simplemente de la siguiente manera:

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

Cuando se utilizan marcadores numéricos, necesita definirlos como enteros, es decir, 1 o 2. En este caso '1' o '2' se consideran cadenas y no números, por lo que el marcador de posición no podría sustituirse con éxito. With any adapter data are automatically escaped using [PDO Quote](https://www.php.net/manual/en/pdo.quote.php).

Esta función tiene en cuenta el conjunto de caracteres de conexión, por lo que se recomienda definir el conjunto de caracteres correcto en los parámetros de conexión o en la configuración de servidor de base de datos, como un conjunto de caracteres incorrecto producirá efectos no deseados al almacenar o recuperar datos.

También, se puede pasar sus parámetros directamente a los métodos `execute` o `query`. En este caso los parámetros enlazados se pasan directamente al PDO:

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

## Marcadores con tipo de dato

Los marcadores permiten enlazar parámetros para evitar inyecciones de SQL:

```php
<?php

$phql = "SELECT * FROM Store\Robots WHERE id > :id:";

$robots = $this->modelsManager->executeQuery($phql, ['id' => 100]);
```

Sin embargo, algunos sistemas de bases de datos requieren acciones adicionales al usar marcadores, como especificar el tipo de parámetro:

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

Se puede utilizar marcadores con tipo de datos en sus parámetros, en lugar de especificar los tipos en el método `executeQuery()`:

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

También puede omitir el tipo si usted no necesita especificarlo:

```php
<?php

$phql = "SELECT * FROM Store\Robots WHERE name <> {name}";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['name' => $name]
);
```

Los marcadores con tipo de datos son además más potentes, ya que ahora podemos enlazar un arreglo estático sin tener que pasar cada elemento independientemente como un marcador:

```php
<?php

$phql = "SELECT * FROM Store\Robots WHERE id IN ({ids:array})";
$robots = $this->modelsManager->executeQuery(
    $phql,
    ['ids' => [1, 2, 3, 4]]
);
```

Las siguientes tipos están disponibles:

| Tipo de enlace | Constante de tipo de enlace       | Ejemplo             |
| -------------- | --------------------------------- | ------------------- |
| str            | `Column::BIND_PARAM_STR`          | `{name:str}`        |
| int            | `Column::BIND_PARAM_INT`          | `{number:int}`      |
| double         | `Column::BIND_PARAM_DECIMAL`      | `{price:double}`    |
| bool           | `Column::BIND_PARAM_BOOL`         | `{enabled:bool}`    |
| blob           | `Column::BIND_PARAM_BLOB`         | `{image:blob}`      |
| null           | `Column::BIND_PARAM_NULL`         | `{exists:null}`     |
| array          | Array de `Column::BIND_PARAM_STR` | `{codes:array}`     |
| array-str      | Array de `Column::BIND_PARAM_STR` | `{names:array-str}` |
| array-int      | Array de `Column::BIND_PARAM_INT` | `{flags:array-int}` |

<a name='cast-bound-parameter-values'></a>

## Moldear valores de parámetros enlazados

De forma predeterminada, los parámetros enlazados no se moldean en el dominio de PHP a los tipos de enlace especificados; esta opción le permite a Phalcon moldear los valores antes de vincularlos con PDO. Una situación clásica de cuando surge este problema, es al pasar una cadena en un marcador de `LIMIT`/`OFFSET`:

```php
<?php

$number = '100';
$robots = $modelsManager->executeQuery(
    'SELECT * FROM Some\Robots LIMIT {number:int}',
    ['number' => $number]
);
```

Esto provoca la siguiente excepción:

    Fatal error: Uncaught exception 'PDOException' with message 'SQLSTATE[42000]:
    Syntax error or access violation: 1064 You have an error in your SQL syntax;
    check the manual that corresponds to your MySQL server version for the right
    syntax to use near ''100'' at line 1' in /Users/scott/demo.php:78
    

Esto sucede porque 100 es una variable de tipo cadena. Es fácilmente corregible moldeando primero el valor a entero:

```php
<?php

$number = '100';
$robots = $modelsManager->executeQuery(
    'SELECT * FROM Some\Robots LIMIT {number:int}',
    ['number' => (int) $number]
);
```

Sin embargo, esta solución requiere que el desarrollador preste especial atención acerca de los parámetros enlazados, en cómo son pasados y sus tipos. Para facilitar esta tarea y evitar excepciones inesperadas puede indicar a Phalcon que haga el moldeado por usted:

```php
<?php

\Phalcon\Db::setup(['forceCasting' => true]);
```

Las siguientes acciones se llevan a cabo según el tipo de enlace especificado:

| Tipo de enlace               | Action                                               |
| ---------------------------- | ---------------------------------------------------- |
| Column::BIND_PARAM_STR     | Convertir el valor como una cadena PHP nativa        |
| Column::BIND_PARAM_INT     | Convertir el valor como un número entero PHP nativo  |
| Column::BIND_PARAM_BOOL    | Convertir el valor como un valor booleano PHP nativo |
| Column::BIND_PARAM_DECIMAL | Convertir el valor como un número doble PHP nativo   |

<a name='cast-on-hydrate'></a>

## Moldeado en Hidratación

Los valores devueltos por el sistema de base de datos siempre aparecen como valores de tipo cadena en PDO, sin importar, por ejemplo, si el valor corresponde a una columna de tipo numérico o booleano. Esto sucede porque algunos tipos de columna no se pueden representar con sus correspondientes tipos nativos en PHP debido a sus limitaciones de tamaño. Por ejemplo, un `BIGINT` de MySQL el cual puede almacenar números enteros grandes, no puede ser representado como un entero de 32 bits en PHP. Por eso, PDO y el ORM, por defecto, toman la decisión segura de dejar todos los valores como cadenas.

Puede configurar el ORM a moldear automáticamente los tipos considerados seguros a sus correspondientes tipos nativos de PHP:

```php
<?php

\Phalcon\Mvc\Model::setup(['castOnHydrate' => true]);
```

De esta manera puede utilizar operadores estrictas o hacer suposiciones sobre el tipo de variables:

```php
<?php

$robot = Robots::findFirst();
if (11 === $robot->id) {
    echo $robot->name;
}
```

<a name='crud'></a>

## Inserting/Updating/Deleting Rows

Para Insertar, actualizar o eliminar filas, puede utilizar SQL crudo o utilizar las funciones proporcionadas por la clase:

```php
<?php

// Insertando datos con instrucciones SQL en bruto
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)';
$success = $connection->execute($sql);

// Con marcadores
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        1952,
    ]
);

// Generando dinámicamente el SQL necesario
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

// Generando dinámicamente el SQL necesario (otra sintaxis)
$success = $connection->insertAsDict(
    'robots',
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);

// Actualizando datos con instrucciones SQL en crudo
$sql     = 'UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101';
$success = $connection->execute($sql);

// Con marcadores
$sql     = 'UPDATE `robots` SET `name` = ? WHERE `id` = ?';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        101,
    ]
);

// Generando dinámicamente el SQL necesario
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    'id = 101' // Advertencia! En este caso los valores no son escapados
);

// Generando dinámicamente el SQL necesario (otra sintaxis)
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    'id = 101' // ¡Advertencia! En este caso los valores no son escapados
);

// Con condiciones de escape
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
        'bindTypes'  => [PDO::PARAM_INT], // Parámetro opcional
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
        'bindTypes'  => [PDO::PARAM_INT], // Parámetro opcional
    ]
);

// Borrando datos con instrucciones SQL en crudo
$sql     = 'DELETE `robots` WHERE `id` = 101';
$success = $connection->execute($sql);

// Con marcadores
$sql     = 'DELETE `robots` WHERE `id` = ?';
$success = $connection->execute($sql, [101]);

// Generando dinámicamente el SQL necesario
$success = $connection->delete(
    'robots',
    'id = ?',
    [
        101,
    ]
);
```

<a name='transactions'></a>

## Transactions and Nested Transactions

Trabajar con transacciones es posible como lo es con PDO. Realizar manipulación de datos dentro de las transacciones a menudo aumenta el rendimiento en la mayoría de sistemas de base de datos:

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

In addition to standard transactions, [Phalcon\Db](api/Phalcon_Db) provides built-in support for [nested transactions](https://en.wikipedia.org/wiki/Nested_transaction) (if the database system used supports them). When you call begin() for a second time a nested transaction is created:

```php
<?php

try {
    // Iniciar una transacción
    $connection->begin();

    // Ejecutar algunas instrucciones SQL
    $connection->execute('DELETE `robots` WHERE `id` = 101');

    try {
        // Iniciar una transacción anindada
        $connection->begin();

        // Ejecutar estas instrucciones SQL en una transacción anidada
        $connection->execute('DELETE `robots` WHERE `id` = 102');
        $connection->execute('DELETE `robots` WHERE `id` = 103');

        // Crear un punto de guardado
        $connection->commit();
    } catch (Exception $e) {
        // Ocurrió un error, liberar la transacción anindada
        $connection->rollback();
    }

    // Continuar ejecutando más instrucciones SQL
    $connection->execute('DELETE `robots` WHERE `id` = 104');

    // Confirmar si todo salio bien
    $connection->commit();
} catch (Exception $e) {
    // Ocurrió un error, deshacemos la transacción
    $connection->rollback();
}
```

<a name='events'></a>

## Database Events

[Phalcon\Db](api/Phalcon_Db) is able to send events to a [EventsManager](/4.0/en/events) if it's present. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

| Nombre de evento      | Disparado                                            | ¿Detiene la operación? |
| --------------------- | ---------------------------------------------------- |:----------------------:|
| `afterConnect`        | After a successfully connection to a database system |           No           |
| `beforeQuery`         | Before send a SQL statement to the database system   |           Si           |
| `afterQuery`          | After send a SQL statement to database system        |           No           |
| `beforeDisconnect`    | Before close a temporal database connection          |           No           |
| `beginTransaction`    | Before a transaction is going to be started          |           No           |
| `rollbackTransaction` | Before a transaction is rollbacked                   |           No           |
| `commitTransaction`   | Before a transaction is committed                    |           No           |

Bind an EventsManager to a connection is simple, [Phalcon\Db](api/Phalcon_Db) will trigger the events with the type `db`:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$eventsManager = new EventsManager();

// Escuchar todos los eventos de la base de datos
$eventsManager->attach('db', $dbListener);

$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Asignar el gestor de eventos a la instancia del adaptador de base de datos
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

        // Buscar palabras maliciosas en sentencias SQL
        if (preg_match('/DROP|ALTER/i', $sql)) {
            // Las operaciones DROP/ALTER no están permitidas en la aplicación
            // ¡Esto debe ser una inyección SQL!
            return false;
        }

        // Todo bien
        return true;
    }
);
```

<a name='profiling'></a>

## Perfilando sentencias SQL

[Phalcon\Db](api/Phalcon_Db) includes a profiling component called [Phalcon\Db\Profiler](api/Phalcon_Db_Profiler), that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With [Phalcon\Db\Profiler](api/Phalcon_Db_Profiler):

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

$eventsManager = new EventsManager();

$profiler = new DbProfiler();

// Escuchar todos los eventos de la base de datos
$eventsManager->attach(
    'db',
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === 'beforeQuery') {
            $sql = $connection->getSQLStatement();

            // Iniciar el perfil con la conexión activa
            $profiler->startProfile($sql);
        }

        if ($event->getType() === 'afterQuery') {
            // Detener el perfil activo
            $profiler->stopProfile();
        }
    }
);

// Asignar el gestor de eventos a la conexión
$connection->setEventsManager($eventsManager);

$sql = 'SELECT buyer_name, quantity, product_name '
     . 'FROM buyers '
     . 'LEFT JOIN products ON buyers.pid = products.id';

// Ejecutar la instrucción SQL
$connection->query($sql);

// Obtener el último perfil del perfilador
$profile = $profiler->getLastProfile();

echo 'Instrucción SQL: ', $profile->getSQLStatement(), "\n";
echo 'Tiempo de inicio: ', $profile->getInitialTime(), "\n";
echo 'Tiempo de final: ', $profile->getFinalTime(), "\n";
echo 'Tiempo total: ', $profile->getTotalElapsedSeconds(), "\n";
```

You can also create your own profile class based on [Phalcon\Db\Profiler](api/Phalcon_Db_Profiler) to record real time statistics of the statements sent to the database system:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as Profiler;
use Phalcon\Db\Profiler\Item as Item;

class DbProfiler extends Profiler
{
    /**
     * Ejecutado antes de enviar la instrucción SQL al servidor de base de datos
     */
    public function beforeStartProfile(Item $profile)
    {
        echo $profile->getSQLStatement();
    }

    /**
     * Ejecutado después de enviar la instrucción SQL al servidor de base de datos
     */
    public function afterEndProfile(Item $profile)
    {
        echo $profile->getTotalElapsedSeconds();
    }
}

// Crear un gestor de eventos
$eventsManager = new EventsManager();

// Crear un perfil
$dbProfiler = new DbProfiler();

// Adjuntar el perfil a todos los eventos de la base de datos
$eventsManager->attach('db', $dbProfiler);
```

<a name='logging-statements'></a>

## Logging SQL Statements

Using high-level abstraction components such as [Phalcon\Db](api/Phalcon_Db) to access a database, it is difficult to understand which statements are sent to the database system. [Phalcon\Logger](api/Phalcon_Logger) interacts with [Phalcon\Db](api/Phalcon_Db), providing logging capabilities on the database abstraction layer.

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

Como en el anterior ejemplo, el archivo `app/logs/db.log` contendrá algo como esto:

```bash
[Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
(name, price) VALUES ('Hot pepper', 3.50)
```

<a name='logger-custom'></a>

## Implementing your own Logger

Usted puede implementar su propia clase logger para consultas de bases de datos, mediante la creación de una clase que implementa un único método llamado `log`. The method needs to accept a string as the first argument. Luego usted puede pasar su objeto de registro a `Phalcon\Db::setLogger()`, y de ahí en adelante cualquier instrucción SQL ejecutada llamará ese método para registrar los resultados.

<a name='describing-tables'></a>

## Describing Tables/Views

[Phalcon\Db](api/Phalcon_Db) also provides methods to retrieve detailed information about tables and views:

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

Una descripción de la tabla es muy similar al comando `DESCRIBE` de MySQL, contiene la siguiente información:

| Field        | Tipo        | Key                                                | Null                               |
| ------------ | ----------- | -------------------------------------------------- | ---------------------------------- |
| Field's name | Column Type | Is the column part of the primary key or an index? | Does the column allow null values? |

Los métodos para obtener información acerca de las vistas también se aplican para cada sistema de base de datos soportadas:

```php
<?php

// Get views on the test_db database
$tables = $connection->listViews('test_db');

// Is there a view 'robots' in the database?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## Creating/Altering/Dropping Tables

Diferentes sistemas de base de datos (MySQL, Postgresql, etc.) ofrecen la capacidad para crear, modificar o eliminar tablas con el uso de comandos como `CREATE`, `ALTER` o `DROP`. The SQL syntax differs based on which database system is used. `Phalcon\Db` ofrece una interfaz unificada para modificar las tablas, sin la necesidad de diferenciar la sintaxis SQL basandose en el sistema de almacenamiento de destino.

<a name='tables-create'></a>

### Creating Tables

En el ejemplo siguiente se muestra cómo crear una tabla:

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

`Phalcon\Db::CreateTable()` acepta un array asociativo que describe la tabla. Columns are defined with the class [Phalcon\Db\Column](api/Phalcon_Db_Column). La tabla siguiente muestra las opciones disponibles para definir una columna:

| Opción          | Descripción                                                                                                                         | Opcional |
| --------------- | ----------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `type`          | Column type. Must be a [Phalcon\Db\Column](api/Phalcon_Db_Column) constant (see below for a list)                                 |    No    |
| `primary`       | True if the column is part of the table's primary key                                                                               |    Si    |
| `size`          | Some type of columns like `VARCHAR` or `INTEGER` may have a specific size                                                           |    Si    |
| `scale`         | `DECIMAL` or `NUMBER` columns may be have a scale to specify how many decimals should be stored                                     |    Si    |
| `unsigned`      | `INTEGER` columns may be signed or unsigned. This option does not apply to other types of columns                                   |    Si    |
| `notNull`       | ¿La columna puede almacenar valores nulos?                                                                                          |    Si    |
| `default`       | Default value (when used with `'notNull' => true`).                                                                              |    Si    |
| `autoIncrement` | Con este atributo la columna se incrementará automáticamente con un entero. Solo una columna en la tabla puede tener este atributo. |    Si    |
| `bind`          | One of the `BIND_TYPE_*` constants telling how the column must be bound before save it                                              |    Si    |
| `first`         | La columna debe colocarse en primera posición en el orden de columnas                                                               |    Si    |
| `after`         | La columna debe colocarse después de la columna indicada                                                                            |    Si    |

[Phalcon\Db](api/Phalcon_Db) supports the following database column types:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_TEXT`

El array asociativo pasado en `Phalcon\Db::createTable()` puede tener las siguientes claves:

| Índice       | Descripción                                                                                                                            | Opcional |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | An array with a set of table columns defined with [Phalcon\Db\Column](api/Phalcon_Db_Column)                                         |    No    |
| `indexes`    | An array with a set of table indexes defined with [Phalcon\Db\Index](api/Phalcon_Db_Index)                                           |    Si    |
| `references` | An array with a set of table references (foreign keys) defined with [Phalcon\Db\Reference](api/Phalcon_Db_Reference)                 |    Si    |
| `options`    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. |    Si    |

<a name='tables-altering'></a>

### Altering Tables

A medida que su aplicación crece, puede que necesite modificar su base de datos, como parte de una refactorización o añadiendo nuevas funciones. No todos los sistemas de base de datos permiten modificar las columnas existentes o agregar columnas entre dos ya existentes. [Phalcon\Db](api/Phalcon_Db) is limited by these constraints.

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

### Dropping Tables

Para eliminar una tabla existente de la base de datos actual, use el método `dropTable`. Para eliminar una tabla de una base de datos personalizada, use el segundo parámetro para describir el nombre de la base de datos. Examples on dropping tables:

```php
<?php

// Borrar la tabla 'robot' desde la base de datos activa
$connection->dropTable('robots');

// Borrar la tabla 'robot' desde la base de datos 'machines'
$connection->dropTable('robots', 'machines');
```