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
          <a href="#typed-placeholders">Marcadores con tipo de dato</a>
        </li>
        <li>
          <a href="#cast-bound-parameter-values">Moldear valores de parámetros enlazados</a>
        </li>
        <li>
          <a href="#cast-on-hydrate">Moldeado en Hidratación</a>
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

| Tipo de enlace               | Acción                                               |
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

## Insertar/Actualizar/Borrar registros

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
    'id = 101' // Advertencia! en este caso los valores no son escapados
);

// Generando dinámicamente el SQL necesario (otra sintaxis)
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    'id = 101' // ¡Advertencia! en este caso los valores no son escapados
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

## Transacciones y transacciones anidadas

Trabajar con transacciones es posible como lo es con PDO. Realizar manipulación de datos dentro de las transacciones a menudo aumenta el rendimiento en la mayoría de sistemas de base de datos:

```php
<?php

try {
    // Comenzar una transacción
    $connection->begin();

    // Ejecutar algunas instrucciones SQL
    $connection->execute('DELETE `robots` WHERE `id` = 101');
    $connection->execute('DELETE `robots` WHERE `id` = 102');
    $connection->execute('DELETE `robots` WHERE `id` = 103');

    // Confirmar si todo salio bien
    $connection->commit();
} catch (Exception $e) {
    // Ocurrió una excepción, deshacemos la transacción
    $connection->rollback();
}
```

Además de las transacciones estándar, `Phalcon\Db` ofrece soporte incorporado para [transacciones anidadas](http://en.wikipedia.org/wiki/Nested_transaction) (si el sistema de base de datos las admite). Cuando se llama `begin()` por segunda vez, se crea una transacción anidada:

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

## Eventos de base de datos

`Phalcon\Db` es capaz de enviar eventos al [EventsManager](/[[language]]/[[version]]/events) si está presente. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

| Nombre de Evento      | Activador                                                          | ¿Puede detener la operación? |
| --------------------- | ------------------------------------------------------------------ |:----------------------------:|
| `afterConnect`        | Después de una conexión con éxito a un sistema de base de datos    |              No              |
| `beforeQuery`         | Antes de enviar una instrucción SQL en el sistema de base de datos |              Sí              |
| `afterQuery`          | Después de enviar una instrucción SQL a la base de datos           |              No              |
| `beforeDisconnect`    | Antes de cerrar una conexión temporal de base de datos             |              No              |
| `beginTransaction`    | Antes de comenzar una transacción                                  |              No              |
| `rollbackTransaction` | Antes de anular (roolback) una transacción                         |              No              |
| `commitTransaction`   | Antes de que una finalizar (commit) una transacción                |              No              |

Vincular un EventsManager a una conexión es muy sencillo, `Phalcon\Db` activará los eventos con el tipo `db`:

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

Detener las operaciones de SQL son muy útiles, si por ejemplo, usted desea implementar algún comprobador de inyecciones SQL de último recurso:

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

## Perfiles de sentencias SQL

`Phalcon\Db` incluye un componente de generación de perfiles llamado `Phalcon\Db\Profiler`, que se utiliza para analizar el rendimiento de las operaciones de base de datos con el fin de diagnosticar problemas de rendimiento y descubrir los cuellos de botella.

Perfilar base de datos es muy fácil, con `Phalcon\Db\Profiler`:

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

También puede crear su propia clase de perfiles basado en `Phalcon\Db\Profiler` para grabar en tiempo real las estadísticas de las instrucciones enviadas al sistema de base de datos:

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

## Log de sentencias SQL

Al utilizar componentes de alto nivel de abstracción como `Phalcon\Mvc\Model` para acceder a una base de datos, es difícil entender qué sentencias son finalmente enviadas al sistema de base de datos. `Phalcon\Logger` interactúa con `Phalcon\Db`, proporcionando las funciones de registro en la capa de abstracción de base de datos.

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

// Asignar el gestor de eventos a la instancia de base de datos
$connection->setEventsManager($eventsManager);

// Ejecutar alguna instrucción SQL
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

## Implementar tu propio Logger

Usted puede implementar su propia clase logger para consultas de bases de datos, mediante la creación de una clase que implementa un único método llamado `log`. El método debe aceptar un `string` como primer argumento. Luego usted puede pasar su objeto de registro a `Phalcon\Db::setLogger()`, y de ahí en adelante cualquier instrucción SQL ejecutada llamará ese método para registrar los resultados.

<a name='describing-tables'></a>

## Descripción de tablas o vistas

`Phalcon\Db` también proporciona métodos para recuperar información detallada sobre tablas y vistas:

```php
<?php

// Obtener las tablas en la base de datos test_db
$tables = $connection->listTables('test_db');

// ¿Hay una tabla llamada 'robots' en la base de datos?
$exists = $connection->tableExists('robots');

// Obtener el nombre, tipos de datos y características especiales de los campos de la tabla 'robots'
$fields = $connection->describeColumns('robots');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}

// Obtener los índices de la tabla 'robots'
$indexes = $connection->describeIndexes('robots');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}

// Obtener las llaves foráneas de la tabla 'robots'
$references = $connection->describeReferences('robots');
foreach ($references as $reference) {
    // Imprimir las columnas referenciadas
    print_r(
        $reference->getReferencedColumns()
    );
}
```

Una descripción de la tabla es muy similar al comando `describe` de MySQL, contiene la siguiente información:

| Campo            | Tipo            | Clave                                                      | Nulo                              |
| ---------------- | --------------- | ---------------------------------------------------------- | --------------------------------- |
| Nombre del campo | Tipo de columna | ¿Es la columna parte de la clave principal o de un índice? | ¿La columna permite valores null? |

Los métodos para obtener información acerca de las vistas también se aplican para cada sistema de base de datos soportadas:

```php
<?php

// Obtener las vistas en la base de datos 'test_db'
$tables = $connection->listViews('test_db');

// ¿Hay una vista llamada 'robots' en la base de datos?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## Crear/Modificar/Eliminar tablas

Diferentes sistemas de base de datos (MySQL, Postgresql etc.) ofrecen la capacidad para crear, modificar o eliminar tablas con el uso de comandos como CREATE, ALTER o DROP. La sintaxis SQL difiere según el sistema de base de datos utilizado. `Phalcon\Db` ofrece una interfaz unificada para modificar las tablas, sin la necesidad de diferenciar la sintaxis SQL basandose en el sistema de almacenamiento de destino.

<a name='tables-create'></a>

### Crear tablas

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

`Phalcon\Db::CreateTable()` acepta un array asociativo que describe la tabla. Las columnas se definen con la clase `Phalcon\Db\Column`. La tabla siguiente muestra las opciones disponibles para definir una columna:

| Opción          | Descripción                                                                                                                         | Opcional |
| --------------- | ----------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `type`          | Tipo de columna. Debe ser una constante de `Phalcon\Db\Column` (ver lista de abajo)                                               |    No    |
| `primary`       | `true` si la columna forma parte de la clave primaria de la tabla                                                                   |    Sí    |
| `size`          | Algunos tipos de columnas como `VARCHAR` o `INTEGER` puede tener un tamaño específico                                               |    Sí    |
| `scale`         | Columnas `DECIMAL` o `NUMBER` pueden tener una escala para especificar cuántos decimales deben almacenarse                          |    Sí    |
| `unsigned`      | Las columnas `INTEGER` pueden tener signo o no. Esta opción no se aplica a otros tipos de columnas                                  |    Sí    |
| `notNull`       | ¿La columna puede almacenar valores nulos?                                                                                          |    Sí    |
| `default`       | Valor por defecto (cuando se usa con `'notNull' => true`).                                                                       |    Sí    |
| `autoIncrement` | Con este atributo la columna se incrementará automáticamente con un entero. Solo una columna en la tabla puede tener este atributo. |    Sí    |
| `bind`          | Una de las constantes `BIND_TYPE_*` que indica como debe tratarse la columna antes de guardarse                                     |    Sí    |
| `first`         | La columna debe colocarse en primera posición en el orden de columnas                                                               |    Sí    |
| `after`         | La columna debe colocarse después de la columna indicada                                                                            |    Sí    |

`Phalcon\Db` soporta los siguientes tipos de columna de base de datos:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_TEXT`

El array asociativo pasado en `Phalcon\Db::createTable()` puede tener las siguientes claves:

| Índice       | Descripción                                                                                                                                                     | Opcional |
| ------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | Un array con un conjunto de columnas de la tabla definida con `Phalcon\Db\Column`                                                                             |    No    |
| `indexes`    | Un array con un conjunto de índices de la tabla definida con `Phalcon\Db\Index`                                                                               |    Sí    |
| `references` | Un array con un conjunto de referencias de tabla (foreign keys) definidas con `Phalcon\Db\Reference`                                                          |    Sí    |
| `options`    | Un array con un conjunto de opciones de creación de la tabla. Estas opciones se refieren a menudo al sistema de base de datos en la que se generó la migración. |    Sí    |

<a name='tables-altering'></a>

### Modificar tablas

A medida que su aplicación crece, puede que necesite modificar su base de datos, como parte de una refactorización o añadiendo nuevas funciones. No todos los sistemas de base de datos permiten modificar las columnas existentes o agregar columnas entre dos ya existentes. `Phalcon\Db` está limitado por estas restricciones.

```php
<?php

use Phalcon\Db\Column as Column;

// Agregar una columna nueva
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

// Modificar una columna existente
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

// Borrar la columna 'name'
$connection->dropColumn(
    'robots',
    null,
    'name'
);
```

<a name='tables-dropping'></a>

### Eliminar tablas

Ejemplos de borrado de tablas:

```php
<?php

// Borrar la tabla 'robot' desde la base de datos activa
$connection->dropTable('robots');

// Borrar la tabla 'robot' desde la base de datos 'machines'
$connection->dropTable('robots', 'machines');
```