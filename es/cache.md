<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Mejorar el Rendimiento Mediante Caché</a> <ul>
        <li>
          <a href="#implementation">¿Cuándo Implementar Caché?</a>
        </li>
        <li>
          <a href="#caching-behavior">Comportamiento de Almacenamiento en Caché</a>
        </li>
        <li>
          <a href="#factory">Fábrica</a>
        </li>
        <li>
          <a href="#output-fragments">Almacenamiento en Caché de Fragmentos de Salida</a>
        </li>
        <li>
          <a href="#arbitrary-data">Almacenamiento en Caché de Datos Arbitrarios</a> <ul>
            <li>
              <a href="#backend-file-example">Ejemplo de archivo de Backend</a>
            </li>
            <li>
              <a href="#backend-memcached-example">Ejemplo de Backend de Memcached</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#read">Consultando el Caché</a>
        </li>
        <li>
          <a href="#delete">Eliminación de Datos del caché</a>
        </li>
        <li>
          <a href="#exists">Comprobación de Existencia de Caché</a>
        </li>
        <li>
          <a href="#lifetime">Tiempo de Vida</a>
        </li>
        <li>
          <a href="#multi-level">Memoria Caché de Niveles Múltiples</a>
        </li>
        <li>
          <a href="#adapters-frontend">Adaptadores de Frontend</a> <ul>
            <li>
              <a href="#adapters-frontend-custom">Implementar tus Propios Adaptadores de Frontend</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters-backend">Adaptadores de Backend</a> <ul>
            <li>
              <a href="#adapters-backend-custom">Implementar sus propios adaptadores de back-end</a>
            </li>
            <li>
              <a href="#adapters-backend-file">Opciones de archivos backend</a>
            </li>
            <li>
              <a href="#adapters-backend-libmemcached">Opciones de back-end para Libmemcached</a>
            </li>
            <li>
              <a href="#adapters-backend-memcache">Opciones de back-end para Memcached</a>
            </li>
            <li>
              <a href="#adapters-backend-apc">Opciones de back-end para APC</a>
            </li>
            <li>
              <a href="#adapters-backend-apcu">Opciones de back-end para APCU</a>
            </li>
            <li>
              <a href="#adapters-backend-mongo">Opciones de back-end para Mongo</a>
            </li>
            <li>
              <a href="#adapters-backend-xcache">Opciones de back-end para XCache</a>
            </li>
            <li>
              <a href="#adapters-backend-redis">Opciones de back-end para Redis</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Mejorar el Rendimiento Mediante Caché

Phalcon proporciona la clase `Phalcon\Cache` que permite un acceso más rápido a datos usados frecuentemente o ya procesados. `Phalcon\Cache` está escrito en C, logrando un mayor rendimiento y reduciendo la sobrecarga cuando se obtienen items de los backends. Esta clase utiliza una estructura interna de los componentes frontend y backend. Los componentes del Frontend actúan como fuentes de entrada o interfaces, mientras que componentes del Backend ofrecen opciones de almacenamiento para la clase.

<a name='implementation'></a>

## ¿Cuándo Implementar Caché?

Aunque este componente es muy rápido, su aplicación en los casos que no es necesario puede llevar a una pérdida de performance en lugar de ganancia. Le recomendamos que consulte que estos casos antes de usar un caché:

- Usted está haciendo cálculos complejos que siempre devuelven el mismo resultado (cambian con poca frecuencia)
- Utiliza un montón de ayudantes y la salida generada es casi siempre la misma
- Se accede a datos de la base de datos constantemente y rara vez cambian de estos datos

<h5 class='alert alert-warning'><em>Nota</em> Incluso después de implementar el caché, debe comprobar la proporción de aciertos de su caché durante un período de tiempo. Esto puede hacerse fácilmente, especialmente en el caso de Memcache o Apc, con las herramientas pertinentes que proporcionan los backends.</h5>

<a name='caching-behavior'></a>

## Comportamiento de Almacenamiento en Caché

El proceso de almacenamiento en caché se divide en 2 partes:

- **Frontend**: esta parte es responsable de comprobar si una clave ha expirado y realizar transformaciones adicionales a los datos antes de guardarlos y después recuperarlos desde el backend
- **Backend**: esta parte es responsable de comunicar, escribir y leer los datos requeridos por la interfaz.

<a name='factory'></a>

## Fábrica

Crear instancias de adaptadores del frontend o del backend, puede lograrse de dos maneras:

- Tradicional

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Crea una salida frontend. Cachear archivos por 2 días
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Crear el componente que realiza el cache desde la salida 'Output' a un archivo 'File' de backend
// Establece el directorio del archivo de cache - es importante mantener la '/' al final 
// del valor 'cacheDir'
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);
```

o usando el objeto Factory de la siguiente manera:

```php
<?php

use Phalcon\Cache\Frontend\Factory as FFactory;
use Phalcon\Cache\Backend\Factory as BFactory;

 $options = [
     'lifetime' => 172800,
     'adapter'  => 'data',
 ];
 $frontendCache = FFactory::load($options);


$options = [
    'cacheDir' => '../app/cache/',
    'prefix'   => 'app-data',
    'frontend' => $frontendCache,
    'adapter'  => 'file',
];

$backendCache = BFactory::load($options);
```

Si las opciones

<a name='output-fragments'></a>

## Almacenamiento en Caché de Fragmentos de la Salida

Un fragmento de la salida es un trozo de HTML o de texto que se almacena en caché como esté y se recupera tal cual es. La salida es capturada automáticamente con las funciones `ob_*` o la salida de PHP para que puedan guardarse en el caché. El ejemplo siguiente muestra dicho uso. Recibe la salida generada por PHP y la almacena en un archivo. El contenido del archivo se actualiza cada 172.800 segundos (2 días).

La implementación de este mecanismo de almacenamiento en caché nos permite mejorar el rendimiento al no ejecutar la llamada auxiliar `Phalcon\Tag::linkTo()` cada vez que se llama a este fragmento de código.

```php
<?php

use Phalcon\Tag;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Crear una salida frontend. Cachear estos archivos por 2 días
$frontCache = new FrontOutput(
    [
        'lifetime' => 172800,
    ]
);

// Crear el componenta que almacena la salida 'Output' en un archivo 'File' en el backend
// Establecer el directorio de cacheo - es importante mantener la barra '/' al final 
// del valor cacheDir
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

// Obtener/establecer el archivo de cache en ../app/cache/my-cache.html
$content = $cache->start('my-cache.html');

// Si $content es idéntico a null entonces el contenido debe ser generado para el cache
if ($content === null) {
    // Imprimir fecha y hora
    echo date('r');

    // Generar un link a la acción de registro
    echo Tag::linkTo(
        [
            'user/signup',
            'Registrarme',
            'class' => 'signup-button',
        ]
    );

    // Almacenar la salida en el archivo de cache
    $cache->save();
} else {
    // Imprimir la salida cacheada
    echo $content;
}
```

<h5 class='alert alert-warning'><em>Nota</em> En el ejemplo anterior, nuestro código sigue siendo el mismo, haciéndose eco de salida para el usuario como lo ha venido haciendo antes. Nuestro componente de caché captura transparentemente esa salida y almacena en el archivo de caché (cuando se genera la caché) o envía hacia el usuario previamente compilado de una llamada anterior, evitando así operaciones costosas.</h5>

<a name='arbitrary-data'></a>

## Almacenamiento en Caché de Datos Arbitrarios

Almacenar sólo datos es igualmente importante para su aplicación. El almacenamiento en caché puede reducir la carga de la base de datos mediante la reutilización de datos comúnmente utilizados (pero no actualizados), acelerando así su aplicación.

<a name='backend-file-example'></a>

### Ejemplo de archivo de Backend

Uno de los adaptadores de almacenamiento en caché es 'File'. La única área clave para este adaptador es el lugar de donde se almacenarán los archivos de caché. Esto se controla mediante la opción `cacheDir` que *debe* tener una barra invertida al final de la misma.

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Los archivos del cache se almacenan por 2 días usando el frontend Data
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Crear el componente de cache para 'Data' con destino en 'File' backend
// Establecer el directorio de cacheo - Es importante mantener la barra `/` al final
// del valor cacheDir
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

$cacheKey = 'robots_order_id.cache';

// Intentar obtener los registros almacenados
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots es nulo debido a que el cache expiro o no existía
    // Hacer una llamada a la base de datos para completar la variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Almacenarlo en el cache
    $cache->save($cacheKey, $robots);
}

// Usar los $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<a name='backend-memcached-example'></a>

### Ejemplo de Backend de Memcached

El ejemplo anterior cambia ligeramente (sobre todo en términos de la configuración) cuando estamos utilizando un servidor Memcached.

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

// Cachear datos por una hora
$frontCache = new FrontData(
    [
        'lifetime' => 3600,
    ]
);

// Crear el componente que almacenará 'Data' al backend 'Memcached'
// Configuración de conexión de Memcached
$cache = new BackMemCached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => '11211',
                'weight' => '1',
            ]
        ]
    ]
);

$cacheKey = 'robots_order_id.cache';

// Intentar obtener registros almacenados
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots es nulo porque el cache expiro o no existía
    // Hacer la llamada a base de datos para generar la variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Almacenar en base de datos
    $cache->save($cacheKey, $robots);
}

// Usar $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<h5 class='alert alert-warning'><em>Nota</em> Llamar a <code>save()</code> regresará un booleano, indicando éxito (<code>true</code>) o fracaso (<code>false</code>). Dependiendo el servidor backend que utilices, necesitaras buscar en los registros pertinentes para identificar fallas.</h5>

<a name='read'></a>

## Consultando el Caché

Los elementos agregados al cache se identifican de manera única por una clave. En el caso del backend File, la clave es el nombre de archivo actual. Para recuperar datos desde el cache, solo debemos consultar utilizando la clave única. Si la clave no existe, el método `get()` devolverá `null`.

```php
<?php

// Recuperar productos con la clave 'myProducts'
$products = $cache->get('myProducts');
```

Si desea averiguar que claves están almacenadas en la memoria del cache, puede utilizar el método `queryKeys()`:

```php
<?php

// Consultar todas las claves utilizadas en el cache
$keys = $cache->queryKeys();

foreach ($keys as $key) {
    $data = $cache->get($key);

    echo 'Clave=', $key, ' Datos=', $data;
}

// Consultar todas las claves en el cache que comienzan con 'my-prefix'
$keys = $cache->queryKeys('my-prefix');
```

<a name='delete'></a>

## Eliminación de datos de la caché

Hay momentos donde es necesario invalidar una entrada de caché (debido a una actualización de los datos en caché). El único requisito es saber la clave con la que los datos han sido almacenados.

```php
<?php

// Borrar un item con una clave específica
$cache->delete('someKey');

$keys = $cache->queryKeys();

// Borrar todos los items del cache
foreach ($keys as $key) {
    $cache->delete($key);
}
```

<a name='exists'></a>

## Comprobación de existencia de caché

Es posible comprobar si un cache existe, pasando su clave:

```php
<?php

if ($cache->exists('someKey')) {
    echo $cache->get('someKey');
} else {
    echo '¡El cache no existe!';
}
```

<a name='lifetime'></a>

## Tiempo de vida

Un `lifetime` es un tiempo en segundos que un caché vive sin caducar. Por defecto, todos los caches creados usan el `lifetime` establecido en la creación del frontend. Es posible establecer el `lifetime` en la creación o al recuperar los datos desde el almacenamiento:

Establecer el tiempo de vida cuando se recuperan registros:

```php
<?php

$cacheKey = 'my.cache';

// Establecer el cache cuando se obtienen resultados
$robots = $cache->get($cacheKey, 3600);

if ($robots === null) {
    $robots = 'some robots';

    // Almacenarlo en cache
    $cache->save($cacheKey, $robots);
}
```

Establecer el tiempo de vida cuando se guardan registros:

```php
<?php

$cacheKey = 'my.cache';

$robots = $cache->get($cacheKey);

if ($robots === null) {
    $robots = 'some robots';

    // Establecer el cache cuando se guardan datos
    $cache->save($cacheKey, $robots, 3600);
}
```

<a name='multi-level'></a>

## Memoria Caché de Niveles Múltiples

Esta característica del componente de cache, permite al desarrollador implementar almacenamientos en cache de múltiples niveles. Esta nueva característica es muy útil debido a que puede almacenar los mismos datos en distintos lugares con distintos tiempos de vida, leyendo primer desde el adaptador más rápido y terminando por el más lento hasta que caduquen los datos:

```php
<?php

use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\File as FileCache;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;

$ultraFastFrontend = new DataFrontend(
    [
        'lifetime' => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        'lifetime' => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        'lifetime' => 604800,
    ]
);

// Los backends se registran del más rápido al más lento
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                'prefix' => 'cache',
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                'prefix' => 'cache',
                'host'   => 'localhost',
                'port'   => '11211',
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                'prefix'   => 'cache',
                'cacheDir' => '../app/cache/',
            ]
        ),
    ]
);

// save(), guarda en cada backend
$cache->save('my-key', $data);
```

<a name='adapters-frontend'></a>

## Adaptadores de Frontend

Los adaptadores de frontend disponibles que se usan como interfaces o fuentes de entrada para el cache son:

| Adaptador                            | Descripción                                                                                                                                                                                   |
| ------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Cache\Frontend\Output`   | Lee los datos de entrada desde la salida estándar de PHP.                                                                                                                                     |
| `Phalcon\Cache\Frontend\Data`     | Es utilizando para almacenar cualquier tipo de datos PHP (arreglos grandes, objectos, texto, etcétera). Los datos son serializados antes de almacenarse en el backend.                        |
| `Phalcon\Cache\Frontend\Base64`   | Es utilizado para almacenar datos binarios. Los datos se serializan utilizando `base64_encode` antes de almacenarse en backend.                                                               |
| `Phalcon\Cache\Frontend\Json`     | Los datos se condifican en JSON antes de ser almacenados en el backend. Son decodificados antes de devolverse. Este frontend es útil para compartir datos entre otros lenguajes o frameworks. |
| `Phalcon\Cache\Frontend\Igbinary` | Es utilizando para almacenar cualquier tipo de datos PHP (arreglos grandes, objectos, texto, etcétera). Los datos son serializados usando `Igbinary` antes de almacenarse en el backend.      |
| `Phalcon\Cache\Frontend\None`     | Se usa para almacenar en caché cualquier tipo de datos PHP sin serializarlos.                                                                                                                 |

<a name='adapters-frontend-custom'></a>

### Implementar tus Propios Adaptadores de Frontend

Debe implementar la interfaz `Phalcon\Cache\FrontendInterface` para crear sus propios adaptadores frontend o extender los ya existentes.

<a name='adapters-backend'></a>

## Adaptadores de Backend

Los adaptadores de backend disponibles para almacenar datos en cache son:

| Adaptador                               | Descripción                                                               | Info                                      | Extensiones Requeridas                             |
| --------------------------------------- | ------------------------------------------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Almacena los datos a la Caché Alternativa de PHP (APC).                   | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`         | Almacena los datos en la APCu (APC sin almacenamiento en caché de opcode) | [APCu](http://php.net/apcu)               | [APCu](http://pecl.php.net/package/APCu)           |
| `Phalcon\Cache\Backend\File`         | Almacena los datos en archivos planos locales.                            |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | Almacena los datos en un servidor memcached.                              | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | Almacena los datos en un servidor memcached.                              | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Mongo`        | Almacena los datos en base de datos Mongo.                                | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Almacena datos en Redis.                                                  | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | Almacena datos en XCache.                                                 | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |

<h5 class='alert alert-warning'><em>Nota</em> En PHP 7 para utilizar las clases de adaptadores base phalcon <code>apc</code> necesitastas instalar los paquetes <code>apcu</code> y <code>apcu_bc</code> desde pecl. Ahora en Phalcon 3.2.0 puede cambiar su clases <code>*\Apc</code> a <code>*\Apcu</code> y eliminar <code>apcu_bc</code>. Tenga en cuenta que en Phalcon 4 seguramente eliminaremos todas las clases <code>*\Apc</code>.</h5>

<a name='adapters-backend-custom'></a>

### Implementar sus propios adaptadores de back-end

Debe implementar la interfaz `Phalcon\Cache\BackendInterface` para crear sus propios adaptadores backend o extender los ya existentes.

<a name='adapters-backend-file'></a>

### Opciones de archivos backend

Este backend almacena contenido cacheado en archivos en el servidor local. Las opciones disponibles para este componente son:

| Opción     | Descripción                                                                             |
| ---------- | --------------------------------------------------------------------------------------- |
| `prefix`   | Un prefijo se antepone automáticamente en las claves de caché.                          |
| `cacheDir` | Un directorio con permisos para escribir en la que se colocarán los archivos cacheados. |

<a name='adapters-backend-libmemcached'></a>

### Opciones de back-end para Libmemcached

Este backend almacena contenido cacheado en un servidor memcached. Por defecto se utilizan los pools de conexión persistente de memcached. Las opciones disponibles para este backend son:

**Opciones Generales**

| Opción          | Descripción                                                                                                                          |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| `statsKey`      | Utilizado para seguimiento de claves almacenado en memoria caché.                                                                    |
| `prefix`        | Un prefijo se antepone automáticamente en las claves de caché.                                                                       |
| `persistent_id` | Para crear una instancia que persiste entre las solicitudes, utilice `persistent_id` para especificar un ID único para la instancia. |

**Opciones de Servidor**

| Opción   | Descripción                                                                                                               |
| -------- | ------------------------------------------------------------------------------------------------------------------------- |
| `host`   | El servidor `memcached`.                                                                                                  |
| `port`   | El puerto `memcached`.                                                                                                    |
| `weight` | El parámetro de carga tiene el efecto hash consistente utilizado para determinar desde qué servidor leer/escribir claves. |

**Opciones de cliente**

Utilizado para configurar las opciones de Memcached. Vea [Memcached::setOptions](http://php.net/manual/en/memcached.setoptions.php) para más información.

**Ejemplo**

```php
<?php
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cachear los datos por 2 días
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Creamos las opciones de conexión para memcached
$cache = new Libmemcached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => 11211,
                'weight' => 1,
            ],
        ],
        'client' => [
            \Memcached::OPT_HASH       => \Memcached::HASH_MD5,
            \Memcached::OPT_PREFIX_KEY => 'prefix.',
        ],
        'persistent_id' => 'my_app_cache',
    ]
);
```

<a name='adapters-backend-memcache'></a>

### Opciones de back-end para Memcached

Este backend almacena contenido cacheado en un servidor memcached. Las opciones disponibles son:

| Opción       | Descripción                                                    |
| ------------ | -------------------------------------------------------------- |
| `prefix`     | Un prefijo se antepone automáticamente en las claves de caché. |
| `host`       | El servidor memcached.                                         |
| `port`       | El puerto memcached.                                           |
| `persistent` | ¿Crear una conexión persistente a memcached?                   |

<a name='adapters-backend-apc'></a>

### Opciones de back-end para APC

Este backend almacenará contenido cacheado en la memoria caché alternativa de PHP ([APC](http://php.net/apc)). Las opciones disponibles son:

| Opción   | Descripción                                                    |
| -------- | -------------------------------------------------------------- |
| `prefix` | Un prefijo se antepone automáticamente en las claves de caché. |

<a name='adapters-backend-apcu'></a>

### Opciones de back-end para APCU

Este backend almacenará contenido cacheado en la memoria caché alternativa de PHP ([APCU](http://php.net/apcu)). Las opciones disponibles son:

| Opción   | Descripción                                                    |
| -------- | -------------------------------------------------------------- |
| `prefix` | Un prefijo se antepone automáticamente en las claves de caché. |

<a name='adapters-backend-mongo'></a>

### Opciones de back-end para Mongo

Este backend almacena contenido cacheado en un servidor de MongoDB ([MongoDB](http://mongodb.org/)). Las opciones disponibles son:

| Opción       | Descripción                                                    |
| ------------ | -------------------------------------------------------------- |
| `prefix`     | Un prefijo se antepone automáticamente en las claves de caché. |
| `server`     | Una cadena de conexión de MongoDB.                             |
| `db`         | Nombre de la base de datos de Mongo.                           |
| `collection` | Colección de Mongo en la base de datos.                        |

<a name='adapters-backend-xcache'></a>

### Opciones de back-end para XCache

Este backend almacena contenido cacheado en XCache ([XCache](http://xcache.lighttpd.net/)). Las opciones disponibles son:

| Opción   | Descripción                                                    |
| -------- | -------------------------------------------------------------- |
| `prefix` | Un prefijo se antepone automáticamente en las claves de caché. |

<a name='adapters-backend-redis'></a>

### Opciones de back-end para Redis

Este backend almacena contenido cacheado en un servidor Redis ([Redis](http://redis.io/)). Las opciones disponibles son:

| Opción       | Descripción                                                       |
| ------------ | ----------------------------------------------------------------- |
| `prefix`     | Un prefijo se antepone automáticamente en las claves de caché.    |
| `host`       | Servidor Redis.                                                   |
| `port`       | Puerto de Redis.                                                  |
| `auth`       | Contraseña para autenticarse en un servidor Redis con protección. |
| `persistent` | Crear una conexión persistente a Redis.                           |
| `index`      | El índice a utilizar en la base de datos de Redis.                |

Se dispone de más adaptadores en la [Incubadora de Phalcon](https://github.com/phalcon/incubator)