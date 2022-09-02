---
layout: default
title: 'Loader'
upgrade: '#autoload'
keywords: 'loader, psr-4, auto-loading, autoloader'
---

# Loader
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

> The `Phalcon\Autoload\Loader` class has been renamed `Phalcon\Autoload\Loader`. La funcionalidad sigue siendo la misma. 
> 
> {: .alert .alert-warning }

## Resumen
[Phalcon\Autoload\Loader][loader] is an autoloader that implements [PSR-4][psr-4]. Como cualquier autocargador, dependiendo de su configuración, intentará encontrar los ficheros que su código está buscando en base a fichero, clase, espacio de nombres, etc. Como este componente está escrito en C, ofrece la menor sobrecarga al procesar su configuración, ofreciendo así un aumento de rendimiento.

![](/assets/images/implements-psr--4-blue.svg)

This component relies on PHP's [autoloading classes][autoloading] capability. Si una clase definida en el código todavía no se ha incluido, un manejador especial intentará cargarla. [Phalcon\Autoload\Loader][loader] serves as the special handler for this operation. Al cargar clases en función de la necesidad de carga, el rendimiento general aumenta, ya que las únicas lecturas de archivos se producen para los ficheros necesarios. This technique is called [lazy initialization][lazy_initialization].

El componente ofrece opciones para cargar ficheros basados en su clase, nombre de fichero, directorios en su sistema de ficheros así como extensiones de fichero.

## Registro
Usually we would use the [spl_autoload_register()][spl-autoload-register] to register a custom autoloader for our application. [Phalcon\Autoload\Loader][loader] hides this complexity. Después defina todos sus espacios de nombres, clases, directorios y ficheros que necesitará llamar a la función `register()`, y el autocargador está listo para usar.

```php
<?php

use Phalcon\Autoload\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();
```

`register()` uses [spl_autoload_register()][spl-autoload-register] internally. Como resultado, acepta también el parámetro booleano `prepend`. Si es suministrado y es `true`, el autocargador se añadirá al inicio de la cola de autocarga en lugar de al final (comportamiento predeterminado).

Siempre puede llamar al método `isRegistered()` para comprobar si su autocargador está registrado o no.

> **NOTE**: If there is an error in registering the autoloader, the component will throw an exception. 
> 
> {: .alert .alert-warning }


```php
<?php

use Phalcon\Autoload\Loader;

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

use Phalcon\Autoload\Loader;

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
[Phalcon\Autoload\Loader][loader] incorporates a security layer, by sanitizing class names by default i.e. removing invalid characters. Esto dificulta que se inyecte código malicioso en su aplicación.

Considere el ejemplo siguiente:

```php
<?php

spl_autoload_register(
    function (string $className) {
        $filepath = $className . '.php';

        if (file_exists($filepath)) {
            require $filepath;
        }
    }
);
```

The above autoloader lacks any kind of security. If a part of your code accidentally calls the autoloader with a name that points to a script containing malicious code, then your application will be compromised.

```php
<?php

$className = '../processes/important-process';

if (class_exists($className)) {
    // ...
}
```

En el fragmento anterior, si `../processes/important-process.php` es un fichero válido, podría haber sido subido por un hacker o desde un proceso de subida no tan cuidadoso, entonces un usuario externo podría ejecutar el código sin ninguna autorización y posteriormente obtener acceso a toda la aplicación si no al servidor.

To avoid most of these kind of attacks, [Phalcon\Autoload\Loader][loader] removes invalid characters from the class name.

## Espacios de nombres
Una forma muy popular de organizar su aplicación es con directorios, cada uno representando un espacio de nombres en particular. [Phalcon\Autoload\Loader][loader] can register those namespace to directory mapping and traverse those directories to search the file that your application is requiring.

El método `registerNamespaces()` acepta un vector, donde las claves son los espacios de nombres y los valores son los directorios actuales en el sistema de ficheros. El separador de espacio de nombres se sustituirá por el separador de directorio cuando el cargador intente encontrar las clases.

```php
<?php

use Phalcon\Autoload\Loader;

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

En el ejemplo anterior, cuando hacemos referencia a un controlador, el cargador lo buscará en `app/controllers` y sus subdirectorios. Similarly, for a model the search will occur in `app/models`.

You do not need to register the sub namespaces, if the actual files are located in subdirectories that map the namespace naming convention.

Así por ejemplo, el ejemplo anterior define nuestro espacio de nombres `MyApp` para apuntar a `app/library`. Si tenemos un fichero:

```bash
/app/library/Components/Mail.php
```

que tiene un espacio de nombres de:

```bash
MyApp\Components
```

entonces el cargador, definido anteriormente, no necesita saber la ubicación del espacio de nombres `MyApp\Components`, o tenerlo definido en la declaración `registerNamespaces()`.

If the component referenced in the code is `MyApp\Components\Mail`, it will assume that it is a subdirectory of the root namespace. Sin embargo, ya que especificamos una ubicación diferente para los espacios de nombres `MyApp\Controllers` y `MyApp\Models`, el cargador buscará esos espacios de nombres en los directorios especificados.

El método `registerNamespaces()` también acepta un segundo parámetro `merge`. By default, it is `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerNamespaces()` para que las definiciones de espacio de nombres se unan.

```php
<?php

use Phalcon\Autoload\Loader;

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
Another way to let [Phalcon\Autoload\Loader][loader] know where your components/classes are located, so that the autoloader can load them properly, is by using `registerClasses()`.

El método acepta un vector, donde la clave es la clase con el espacio de nombres y el valor es la ubicación del fichero que contiene la clase. Como era de esperar, esta es la manera más rápida de autocargar una clase, ya que el autocargador no necesita escanear o sacar estadísticas de ficheros para encontrar las referencias de los ficheros.

Sin embargo, usar este método puede dificultar el mantenimiento de su aplicación. Cuanto más crece su aplicación, más ficheros se añaden, lo más fácil es llegar a cometer un error al mantener la lista de ficheros usados en `registerClasses()`

```php
<?php

use Phalcon\Autoload\Loader;

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

El método `registerClasses()` también acepta un segundo parámetro `merge`. By default, it is `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerClasses()` para que las definiciones de clase se unan.

```php
<?php

use Phalcon\Autoload\Loader;

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
There are times that you might need to _require_ a specific file that contains a class without a namespace or a file that contains some code that you need. Un ejemplo sería un fichero que contiene funciones de depuración prácticas.

[Phalcon\Autoload\Loader][loader] offers `registerFiles()` which is used to _require_ such files. Acepta un vector, que contiene el nombre y localización de cada fichero.

```php
<?php

use Phalcon\Autoload\Loader;

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

El método `registerFiles()` también acepta un segundo parámetro `merge`. By default, it is `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerFiles()` para que las definiciones de clase se unan.

```php
<?php

use Phalcon\Autoload\Loader;

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
Another way to let [Phalcon\Autoload\Loader][loader] know where your application files are is to register directories. Cuando un fichero necesita ser requerido por la aplicación, el autocargador escaneará los directorios registrados para encontrar el fichero referenciado para poder requerirlo.

El método `registerDirs()` acepta un vector donde cada elemento es un directorio del sistema de ficheros que contiene los ficheros que serán requeridos por la aplicación.

Este tipo de registro no se recomienda en términos de rendimiento. Additionally, the order of declared directories matters, since the autoloader tries to locate the files by searching directories sequentially. Como resultado, el directorio que contiene los ficheros más referenciados debería declararse primero, etc.

```php
<?php

use Phalcon\Autoload\Loader;

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

El método `registerDirs()` también acepta un segundo parámetro `merge`. By default, it is `false`. Sin embargo, puede establecerlo a `true` cuando se tienen múltiples llamadas a `registerDirs()` para que las definiciones de clase se unan.

```php
<?php

use Phalcon\Autoload\Loader;

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
When you use the `registerNamespaces()` and `registerDirs()`,  [Phalcon\Autoload\Loader][loader] automatically assumes that your files will have the `.php` extension. Puede cambiar este comportamiento usando el método `setExtensions()`. El método acepta un vector, donde cada elemento es la extensión a comprobar (sin el `.`):

```php
<?php

use Phalcon\Autoload\Loader;

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

- `Mail.php`
- `Mail.inc`
- `Mail.phb`

Los ficheros se comprueban en el orden en el que se define cada extensión.

## Función de Retorno de Comprobación de Fichero
Puede acelerar el cargador configurando un método distinto de llamada de retorno de comprobación de fichero usando el método `setFileCheckingCallback()`.

The default behavior uses [is_file][is_file]. However, you can also use `null` which will not check whether a file exists or not, before loading it, or you can use [stream_resolve_include_path][stream_resolve_include_path] which is much faster than [is_file][is_file] but will cause problems if the target file is removed from the file system.

```php
<?php

use Phalcon\Autoload\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback("is_file");
```

Comportamiento predeterminado

```php
<?php

use Phalcon\Autoload\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback("stream_resolve_include_path");
```

Más rápido que `is_file()`, pero introduce problemas si el fichero se elimina del sistema de ficheros.

```php
<?php

use Phalcon\Autoload\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback(null);
```

No comprueba la existencia del fichero.

## Eventos
El componente \[Gestor de Eventos\]\[events\] ofrece ganchos que se pueden implementar para observar o expandir la funcionalidad del cargador. The [Phalcon\Autoload\Loader][loader] implements the [Phalcon\Events\EventsAwareInterface][eventsawareinterface], and therefore the `getEventsManager()` and `setEventsManager()` methods are available.

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
use Phalcon\Autoload\Loader;

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

`getCheckedPath()` mantiene la ruta que se escanea durante cada iteración del bucle interno. Also, you can use the `getfoundPath()` method, which holds the path of the found file during the internal loop.


Para eventos que pueden parar la operación, todo lo que necesitará hacer es devolver `false` en el método adjunto al evento en particular:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Autoload\Loader;

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

* The autoloading process is case-sensitive
* Las estrategias basadas en espacios de nombres/prefijos son más rápidas que la estrategia de directorios
* If a bytecode cache, such as [APCu][apcu], is installed, it will be used to get the requested file (an implicit caching of the file is performed)

## Debugging
The `Phalcon\Autoload\Loader` can be instantiated with passing `true` to the constructor, so that you can enable debug mode. In debug mode, the loader will collect data about searching and finding files that are requested. You can then use the `getDebug()` method to output the debug messages, to diagnose issues.

```php
<?php

use Phalcon\Autoload\Loader;

$loader    = new Loader(true);
$directory = dataDir('some/directory/');
$loader->addDirectory($directory);

$loader->autoload('Simple');

var_dump($loader->getDebug());

// [
//     'Loading: Simple',
//     'Class: 404: Simple',
//     'Namespace: 404: Simple',
//     'Require: some/directory/Simple.php',
//     'Directories: some/directory/Simple.php',
// ];
```

## Métodos
```php
public function __construct(bool $isDebug = false)
```
Constructor. If `$isDebug` is `true`, debugging information will be collected.

```php
public function addClass(string $name, string $file): Loader
```
Adds a class to the internal collection for the mapping

```php
public function addDirectory(string $directory): Loader
```
Adds a directory for the loaded files

```php
public function addExtension(string $extension): Loader
```
Adds an extension for the loaded files

```php
public function addFile(string $file): Loader
```
Adds a file to be added to the loader

```php
public function addNamespace(
  string $name,
  mixed $directories,
  bool $prepend = false
): Loade
```
Adds a namespace to the loader, mapping it to different directories. The third parameter allows to prepend the namespace.

```php
public function autoload(string $className): bool
```
Carga automáticamente las clases registradas

```php
public function getCheckedPath(): string | null
```
Obtiene la ruta que está revisando el cargador para un ruta específica

```php
public function getClasses(): array
```
Devuelve el mapa de clases que actualmente tiene registrado el auto cargador

```php
public function getDebug(): array
```
Returns debug information collected

```php
public function getDirectories(): array
```
Devuelve los directorios registrados actualmente en el autocargador

```php
public function getExtensions(): array
```
Devuelve las extensiones de archivo registradas en el cargador

```php
public function getFiles(): array
```
Devuelve los archivos registrados actualmente en el auto cargador

```php
public function getFoundPath(): string | null
```
Obtiene la ruta cuando una clase fue encontrada

```php
public function getNamespaces(): array
```
Devuelve los espacios de nombres registrados actualmente en el autocargador

```php
public function loadFiles(): void
```
Comprueba si un archivo existe y a continuación añade el archivo haciendo un `require` virtual

```php
public function register(bool $prepend = false): Loader
```
Registrar el método de autocarga

```php
public function setClasses(
    array $classes, 
    bool $merge = false
): Loader
```
Registra las clases y sus ubicaciones

```php
public function setDirectories(
    array $directories, 
    bool $merge = false
): Loader
```
Registra los directorios en los que se pueden localizar las clases "no encontradas"

```php
public function setExtensions(
    array $extensions, 
    bool $merge = false
): Loader
```
Sets an array of file extensions that the loader must try in each attempt to locate the file

```php
public function setFileCheckingCallback(
    mixed $method = null
): Loader
```
Establece la función de retorno de la comprobación de fichero.

```php
public function setFiles(
    array $files, 
    bool $merge = false
): Loader
```
Register files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

```php
public function setNamespaces(
    array namespaces, 
    bool merge = false
): Loader
```
Registra los espacios de nombres y sus directorios relacionados

```php
public function unregister(): Loader
```
Anula el registro del método de autocarga


[spl-autoload-register]: https://www.php.net/manual/en/function.spl-autoload-register.php
[is_file]: https://www.php.net/manual/en/function.is-file.php
[stream_resolve_include_path]: https://www.php.net/manual/en/function.stream-resolve-include-path.php
[autoloading]: https://www.php.net/manual/en/language.oop5.autoload.php
[lazy_initialization]: https://en.wikipedia.org/wiki/Lazy_initialization
[psr-4]: https://www.php-fig.org/psr/psr-4/
[apcu]: https://php.net/manual/en/book.apcu.php
[loader]: api/phalcon_autoload#autoload-loader
[eventsawareinterface]: api/phalcon_events#events-eventsawareinterface
