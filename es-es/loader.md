---
layout: default
language: 'es-es'
version: '4.0'
title: 'Loader'
keywords: 'cargador, psr-4, autocargar, autocargador'
---

# Loader

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Loader](api/phalcon_loader#loader) es un autocargador que implementa [PSR-4](https://www.php-fig.org/psr/psr-4/). Como cualquier autocargador, dependiendo de su configuración, intentará encontrar los ficheros que su código está buscando en base a fichero, clase, espacio de nombres, etc. Como este componente está escrito en C, ofrece la menor sobrecarga al procesar su configuración, ofreciendo así un aumento de rendimiento.

![](/assets/images/implements-psr--4-blue.svg)

Este componente se basa en la capacidad de [autocarga de clases](https://www.php.net/manual/en/language.oop5.autoload.php) de PHP. Si una clase definida en el código todavía no se ha incluido, un manejador especial intentará cargarla. [Phalcon\Loader](api/phalcon_loader#loader) sirve como el manejador especial para esta operación. Al cargar clases en función de la necesidad de carga, el rendimiento general aumenta, ya que las únicas lecturas de archivos se producen para los ficheros necesarios. Esta técnica se llama [inicialización perezosa](https://en.wikipedia.org/wiki/Lazy_initialization).

El componente ofrece opciones para cargar ficheros basados en su clase, nombre de fichero, directorios en su sistema de ficheros así como extensiones de fichero.

## Registro

Generalmente usaríamos [spl_autoload_register()](https://www.php.net/manual/en/function.spl-autoload-register.php) para registrar un autocargador personalizado para nuestra aplicación. [Phalcon\Loader](api/phalcon_loader#loader) oculta esta complejidad. Después defina todos sus espacios de nombres, clases, directorios y ficheros que necesitará llamar a la función `register()`, y el autocargador está listo para usar.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();
```

`register()` usa [spl_autoload_register()](https://www.php.net/manual/en/function.spl-autoload-register.php) internamente. Como resultado, acepta también el parámetro booleano `prepend`. Si es suministrado y es `true`, el autocargador se añadirá al inicio de la cola de autocarga en lugar de al final (comportamiento predeterminado).

Siempre puede llamar al método `isRegistered()` para comprobar si su autocargador está registrado o no.

> **NOTA**: Si hay un error al registrar el autocargador, el componente lanzará una excepción.
{: .alert .alert-warning }


```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();

echo $loader->isRegistered(); // true
```

Desregistrar el autocargador es igualmente fácil. Todo lo que necesita es llamar a `unregister()`.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();

if (true === $loader->isRegistered()) {
    $loader->unregister();
}
```

## Capa de seguridad

[Phalcon\Loader](api/phalcon_loader#loader) incorpora una capa de seguridad, saneando los nombres de las clases por defecto, es decir, eliminando caracteres inválidos. Esto dificulta que se inyecte código malicioso en su aplicación.

Considere el ejemplo siguiente:

```php
<?php

// Basic autoloader
spl_autoload_register(
    function (string $className) {
        $filepath = $className . '.php';

        if (file_exists($filepath)) {
            require $filepath;
        }
    }
);
```

El cargador automático anterior carece de ningún tipo de seguridad. Si una parte de su código accidentalmente llama al autocargador con un nombre que apunta a un *script* que contiene código malicioso, entonces su aplicación se verá comprometida.

```php
<?php

$className = '../processes/important-process';

if (class_exists($className)) {
    // ...
}
```

En el fragmento anterior, si `../processes/important-process.php` es un fichero válido, podría haber sido subido por un hacker o desde un proceso de subida no tan cuidadoso, entonces un usuario externo podría ejecutar el código sin ninguna autorización y posteriormente obtener acceso a toda la aplicación si no al servidor.

Para evitar la mayoría de tipos de ataques, [Phalcon\Loader](api/phalcon_loader#loader) elimina caracteres inválidos del nombre de la clase.

## Espacios de nombres

Una forma muy popular de organizar su aplicación es con directorios, cada uno representando un espacio de nombres en particular. [Phalcon\Loader](api/phalcon_loader#loader) puede registrar estos espacios de nombres en el mapeo de directorios y recorrer estos directorios para buscar el fichero que su aplicación necesita.

El método `registerNamespaces()` acepta un vector, donde las claves son los espacios de nombres y los valores son los directorios actuales en el sistema de ficheros. El separador de espacio de nombres se sustituirá por el separador de directorio cuando el cargador intente encontrar las clases.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'             => 'app/library',
       'MyApp\Controllers' => 'app/controllers',
       'MyApp\Models'      => 'app/models',
    ]
);

$loader->register();
```

En el ejemplo anterior, cuando hacemos referencia a un controlador, el cargador lo buscará en `app/controllers` y sus subdirectorios. De forma similar, para un modelo la búsqueda tendrá lugar en `app/models`.

No es necesario registrar los subespacios de nombres, si los archivos reales están ubicados en subdirectorios que asignan la convención de nomenclatura del espacio de nombres.

Así por ejemplo, el ejemplo anterior define nuestro espacio de nombres `MyApp` para apuntar a `app/library`. Si tenemos un fichero:

```bash
/app/library/Components/Mail.php
```

que tiene un espacio de nombres de:

```bash
MyApp\Components
```

entonces el cargador, definido anteriormente, no necesita saber la ubicación del espacio de nombres `MyApp\Components`, o tenerlo definido en la declaración `registerNamespaces()`.

Si el componente referenciado en el código es `MyApp\Components\Mail`, se asumirá que es un subdirectorio del espacio de nombres raíz. Sin embargo, ya que especificamos una ubicación diferente para los espacios de nombres `MyApp\Controllers` y `MyApp\Models`, el cargador buscará esos espacios de nombres en los directorios especificados.

El método `registerNamespaces()` también acepta un segundo parámetro `merge`. Por defecto es `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerNamespaces()` para que las definiciones de espacio de nombres se unan.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'             => 'app/library',
    ]
);

$loader->registerNamespaces(
    [
       'MyApp\Controllers' => 'app/controllers',
       'MyApp\Models'      => 'app/models',
    ],
    true
);

$loader->register();
```

El ejemplo anterior une la segunda declaración de `registerNamespaces()` con la anterior.

Si necesita comprobar qué espacios de nombres están registrados en el autocargador, puede usar el *getter* `getNamespaces()`, que devuelve el vector de los espacios de nombres registrados. Para el ejemplo anterior, `getNamespaces()` devuelve:

```php
[
   'MyApp'             => 'app/library',
   'MyApp\Controllers' => 'app/controllers',
   'MyApp\Models'      => 'app/models',
]
```

## Clases

Otra forma de permitir a [Phalcon\Loader](api/phalcon_loader#loader) conocer donde se ubican sus componentes/clases, para que el autocargador pueda cargarlos apropiadamente, es usando `registerClasses()`.

El método acepta un vector, donde la clave es la clase con el espacio de nombres y el valor es la ubicación del fichero que contiene la clase. Como era de esperar, esta es la manera más rápida de autocargar una clase, ya que el autocargador no necesita escanear o sacar estadísticas de ficheros para encontrar las referencias de los ficheros.

Sin embargo, usar este método puede dificultar el mantenimiento de su aplicación. Cuanto más crece su aplicación, más ficheros se añaden, lo más fácil es llegar a cometer un error al mantener la lista de ficheros usados en `registerClasses()`

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerClasses(
    [
        'MyApp\Components\Mail'             => 'app/library/Components/Mail.php',
        'MyApp\Controllers\IndexController' => 'app/controllers/IndexController.php',
        'MyApp\Controllers\AdminController' => 'app/controllers/AdminController.php',
        'MyApp\Models\Invoices'             => 'app/models/Invoices.php',
        'MyApp\Models\Users'                => 'app/models/Users.php',
    ]
);

$loader->register();
```

En el ejemplo anterior, estamos definiendo la relación entre una clase con espacio de nombres y un fichero. Como puede ver, el cargador será tan rápido como pueda pero la lista empezará a crecer, cuanto más crece nuestra aplicación, dificultando el mantenimiento. Sin embargo, si su aplicación no tiene demasiados componentes, no hay razón por la que no pueda usar este método de autocarga de componentes.

El método `registerClasses()` también acepta un segundo parámetro `merge`. Por defecto es `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerClasses()` para que las definiciones de clase se unan.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerClasses(
    [
        'MyApp\Components\Mail'             => 'app/library/Components/Mail.php',
        'MyApp\Controllers\IndexController' => 'app/controllers/IndexController.php',
        'MyApp\Controllers\AdminController' => 'app/controllers/AdminController.php',
    ]
);

$loader->registerClasses(
    [
        'MyApp\Models\Invoices'             => 'app/models/Invoices.php',
        'MyApp\Models\Users'                => 'app/models/Users.php',
    ],
    true
);

$loader->register();
```

El ejemplo anterior une la segunda declaración de `registerClasses()` con la anterior.

Si necesita comprobar qué clases están registradas en el autocargador, puede usar el *getter* `getClasses()`, que devuelve el vector de las clases registradas. Para el ejemplo anterior, `getClasses()` devuelve:

```php
[
    'MyApp\Components\Mail'             => 'app/library/Components/Mail.php',
    'MyApp\Controllers\IndexController' => 'app/controllers/IndexController.php',
    'MyApp\Controllers\AdminController' => 'app/controllers/AdminController.php',
    'MyApp\Models\Invoices'             => 'app/models/Invoices.php',
    'MyApp\Models\Users'                => 'app/models/Users.php',
]
```

## Archivos

Hay veces que podría necesitar *requerir* un fichero específico que contiene una clase sin un espacio de nombres o un fichero que contiene algún código que necesita. Un ejemplo sería un fichero que contiene funciones de depuración prácticas.

[Phalcon\Loader](api/phalcon_loader#loader) ofrece `registerFiles()` que se usa para *requerir* estos ficheros. Acepta un vector, que contiene el nombre y localización de cada fichero.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerFiles(
    [
        'functions.php',
        'arrayFunctions.php',
    ]
);

$loader->register();
```

Estos ficheros se cargan automáticamente cuando se llama al método `register()`.

El método `registerFiles()` también acepta un segundo parámetro `merge`. Por defecto es `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerFiles()` para que las definiciones de clase se unan.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerFiles(
    [
        'app/functions/functions.php',
    ]
);

$loader->registerFiles(
    [
        'app/functions/debug.php',
    ],
    true
);

$loader->register();
```

El ejemplo anterior une la segunda declaración de `registerFiles()` con la anterior.

Si necesita comprobar qué ficheros están registrados en el autocargador, puede usar el *getter* `getFiles()`, que devuelve el vector de los ficheros registrados. Para el ejemplo anterior, `getFiles()` devuelve:

```php
[
    'app/functions/functions.php',
    'app/functions/debug.php',
]
```

También tiene acceso al método `loadFiles()`, que recorrerá todos los ficheros registrados y si existen los `requerirá`. Este método se llama automáticamente cuando se llama a `register()`.

## Directorios

Otra forma de permitir a [Phalcon\Loader](api/phalcon_loader#loader) conocer donde están los ficheros de su aplicación es registrar directorios. Cuando un fichero necesita ser requerido por la aplicación, el autocargador escaneará los directorios registrados para encontrar el fichero referenciado para poder requerirlo.

El método `registerDirs()` acepta un vector donde cada elemento es un directorio del sistema de ficheros que contiene los ficheros que serán requeridos por la aplicación.

Este tipo de registro no se recomienda en términos de rendimiento. Adicionalmente, el orden de los directorios declarados importa, ya que el autocargador intenta localizar los archivos buscando directorios secuencialmente. Como resultado, el directorio que contiene los ficheros más referenciados debería declararse primero, etc.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        'app/functions',
        'app/controllers',
        'app/models',
    ]
);

$loader->register();
```

El método `registerDirs()` también acepta un segundo parámetro `merge`. Por defecto es `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerDirs()` para que las definiciones de clase se unan.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        'app/functions',
    ]
);

$loader->registerDirs(
    [
        'app/controllers',
        'app/models',
    ],
    true
);

$loader->register();
```

El ejemplo anterior une la segunda declaración de `registerDirs()` con la anterior.

Si necesita comprobar qué directorios están registrados en el autocargador, puede usar el *getter* `getDirs()`, que devuelve el vector de los directorios registrados. Para el ejemplo anterior, `getDirs()` devuelve:

```php
[
    'app/functions',
    'app/controllers',
    'app/models',
]
```

## Extensiones de Ficheros

Cuando usa `registerNamespaces()` y `registerDirs()`, [Phalcon\Loader](api/phalcon_loader#loader) asume automáticamente que sus ficheros tendrán la extensión `.php`. Puede cambiar este comportamiento usando el método `setExtensions()`. El método acepta un vector, donde cada elemento es la extensión a comprobar (sin el `.`):

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setExtensions(
    [
        'php',
        'inc',
        'phb',
    ]
);

$loader->registerDirs(
    [
        'app/functions',
    ]
);
```

En el ejemplo anterior, cuando se referencia un fichero `Mail`, el autocargador buscará en `app/functions` los siguientes archivos:

* `Mail.php`
* `Mail.inc`
* `Mail.phb`

Los ficheros se comprueban en el orden en el que se define cada extensión.

## Función de Retorno de Comprobación de Fichero

Puede acelerar el cargador configurando un método distinto de llamada de retorno de comprobación de fichero usando el método `setFileCheckingCallback()`.

El comportamiento predeterminado usa [is_file](https://www.php.net/manual/en/function.is-file.php). Sin embargo, también puede usar `null` que no comprobará si un fichero existe o no, antes de cargarlo o puede usar [stream_resolve_include_path](https://www.php.net/manual/en/function.stream-resolve-include-path.php) que es mucho más rápido que [is_file](https://www.php.net/manual/en/function.is-file.php) pero causará problemas si el fichero de destino se elimina del sistema de ficheros.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback("is_file");
```

Comportamiento predeterminado

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback("stream_resolve_include_path");
```

Más rápido que `is_file()`, pero introduce problemas si el fichero se elimina del sistema de ficheros.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback(null);
```

No comprueba la existencia del fichero.

## Eventos

El componente \[Gestor de Eventos\]\[events\] ofrece ganchos que se pueden implementar para observar o expandir la funcionalidad del cargador. [Phalcon\Loader](api/phalcon_loader#loader) implementa [Phalcon\Events\EventsAwareInterface](api/phalcon_events#events-eventsawareinterface), y como resultado están disponibles los métodos `getEventsManager()` y `setEventsManager()`.

Los siguientes eventos están disponibles:

| Evento             | Descripción                                                                                         | ¿Detiene la operación? |
| ------------------ | --------------------------------------------------------------------------------------------------- | ---------------------- |
| `afterCheckClass`  | Se dispara al final del proceso de autocarga cuando la clase no ha sido encontrada.                 | No                     |
| `beforeCheckClass` | Se dispara al principio del proceso de autocarga, antes de comprobar la clase.                      | Si                     |
| `beforeCheckPath`  | Se dispara antes de comprobar un directorio por un fichero de clase.                                | Si                     |
| `pathFound`        | Se dispara cuando el cargador localiza un fichero de clase o un fichero en un directorio registrado | Si                     |

El el siguiente ejemplo, el `Gestor de Eventos` trabaja con la clase cargador, ofreciendo información adicional en el flujo de operación:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Loader;

$eventsManager = new Manager();
$loader        = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$eventsManager->attach(
    'loader:beforeCheckPath',
    function (
        Event $event, 
        Loader $loader
    ) {
        echo $loader->getCheckedPath();
    }
);

$loader->setEventsManager($eventsManager);

$loader->register();
```

En el ejemplo anterior, creamos un nuevo objeto Gestor de Eventos, adjuntamos un método al evento `loader:beforeCheckPath` y lo registramos en nuestro autocargador. Cada vez que el cargador itere y busque un fichero particular en una ruta específica, la ruta será mostrada por pantalla.

`getCheckedPath()` mantiene la ruta que se escanea durante cada iteración del bucle interno. También puede usar el método `getfoundPath()`, que mantiene la ruta del fichero encontrado durante el bucle interno.

Para eventos que pueden parar la operación, todo lo que necesitará hacer es devolver `false` en el método adjunto al evento en particular:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Loader;

$eventsManager = new Manager();
$loader        = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$eventsManager->attach(
    'loader:beforeCheckPath',
    function (
        Event $event, 
        Loader $loader
    ) {
        if ('app/models' === $loader->getCheckedPath()) {
            return false;
        }
    }
);

$loader->setEventsManager($eventsManager);

$loader->register();
```

En el ejemplo anterior, cuando el autocargador empieza a escanear la carpeta `app/models` por el espacio de nombres `MyApp\Models`, detendrá la operación.

## Resolución de problemas

Algunas cosas a tener en cuenta cuando se usa el autocargador:

* El proceso de carga automática es sensible a mayúsculas y minúsculas
* Las estrategias basadas en espacios de nombres/prefijos son más rápidas que la estrategia de directorios
* Si se instala un cache de bytecode, como [APCu](https://php.net/manual/en/book.apcu.php), se usará para obtener el fichero solicitado (se realiza un cacheado implícito del fichero)
