* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Cargador automático de clases

[Phalcon\Loader](api/Phalcon_Loader) allows you to load project classes automatically, based on some predefined rules. Since this component is written in C, it provides the lowest overhead in reading and interpreting external PHP files.

The behavior of this component is based on the PHP's capability of [autoloading classes](https://www.php.net/manual/en/language.oop5.autoload.php). If a class that does not yet exist is used in any part of the code, a special handler will try to load it. [Phalcon\Loader](api/Phalcon_Loader) serves as the special handler for this operation. By loading classes on a need-to-load basis, the overall performance is increased since the only file reads that occur are for the files needed. This technique is called [lazy initialization](https://en.wikipedia.org/wiki/Lazy_initialization).

With this component you can load files from other projects or vendors, this autoloader is [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4.md) compliant.

[Phalcon\Loader](api/Phalcon_Loader) offers four options to autoload classes. You can use them one at a time or combine them.

<a name='security'></a>

## Capa de seguridad

[Phalcon\Loader](api/Phalcon_Loader) offers a security layer sanitizing by default class names avoiding possible inclusion of unauthorized files. Consider the following example:

```php
<?php

// Autocargador básico
spl_autoload_register(
    function ($className) {
        $filepath = $className . '.php';

        if (file_exists($filepath)) {
            require $filepath;
        }
    }
);
```

The above auto-loader lacks any kind of security. If a function mistakenly launches the auto-loader and a malicious prepared string is used as parameter this would allow to execute any file accessible by the application:

```php
<?php

// Esta variable no esta filtrada y proviene de una fuente insegura
$className = '../processes/important-process';

// Chequear si existe esta clase activado el autocargador
if (class_exists($className)) {
    // ...
}
```

If `../processes/important-process.php` is a valid file, an external user could execute the file without authorization.

To avoid these or most sophisticated attacks, [Phalcon\Loader](api/Phalcon_Loader) removes invalid characters from the class name, reducing the possibility of being attacked.

<a name='registering-namespaces'></a>

## Registrando espacios de nombres

If you're organizing your code using namespaces, or using external libraries which do, the `registerNamespaces()` method provides the autoloading mechanism. It takes an associative array; the keys are namespace prefixes and their values are directories where the classes are located in. The namespace separator will be replaced by the directory separator when the loader tries to find the classes.

```php
<?php

use Phalcon\Loader;

// Crear el  auto cargador
$loader = new Loader();

// Registrar algunos nobres de espacios
$loader->registerNamespaces(
    [
        "Example\\Base"    => "vendor/example/base",
        "Example\\Adapter" => "vendor/example/adapter",
        "Example"          => "vendor/example",
    ]
);

// Registrear el auto cargador
$loader->register();

// Al requerir esta clase incluirá automáticamente el archivo vendor/example/adapter/Some.php
$some = new \Example\Adapter\Some();
```

<a name='registering-directories'></a>

## Registrando directorios

The third option is to register directories, in which classes could be found. This option is not recommended in terms of performance, since Phalcon will need to perform a significant number of file stats on each folder, looking for the file with the same name as the class. It's important to register the directories in relevance order.

```php
<?php

use Phalcon\Loader;

// Crear el autocargador
$loader = new Loader();

// Registrar algunos directorios
$loader->registerDirs(
    [
        'library/MyComponent',
        'library/OtherComponent/Other',
        'vendor/example/adapters',
        'vendor/example',
    ]
);

// Registrar el autocargador
$loader->register();

// La clase requerida incluirá automáticamente el archivo 
// desde el primer directorio donde sea encontrado
// por ejemplo: library/OtherComponent/Other/Some.php
$some = new \Some();
```

<a name='registering-classes'></a>

## Registrando clases

The last option is to register the class name and its path. This autoloader can be very useful when the folder convention of the project does not allow for easy retrieval of the file using the path and the class name. This is the fastest method of autoloading. However the more your application grows, the more classes/files need to be added to this autoloader, which will effectively make maintenance of the class list very cumbersome and it is not recommended.

```php
<?php

use Phalcon\Loader;

// Crear el autocargador
$loader = new Loader();

// Registrar algunas clases
$loader->registerClasses(
    [
        'Some'         => 'library/OtherComponent/Other/Some.php',
        'Example\Base' => 'vendor/example/adapters/Example/BaseClass.php',
    ]
);

// Registrar el autocargador
$loader->register();

// Requiriendo una clase se incluirá automáticamente el archivo
// al que se hace referencia en el array asociativo
// por ejemplo library/OtherComponent/Other/Some.php
$some = new \Some();
```

<a name='registering-files'></a>

## Registrando archivos

You can also registers files that are `non-classes` hence needing a `require`. This is very useful for including files that only have functions:

```php
<?php

use Phalcon\Loader;

// Crear el autocargador
$loader = new Loader();

// Registrar algunos archivos
$loader->registerFiles(
    [
        'functions.php',
        'arrayFunctions.php',
    ]
);

// Registrar el autocargador
$loader->register();
```

These files are automatically loaded in the `register()` method.

<a name='registering-file-extensions'></a>

## Extensiones de archivo adicionales

Some autoloading strategies such as `prefixes`, `namespaces` or `directories` automatically append the `php` extension at the end of the checked file. If you are using additional extensions you could set it with the method `setExtensions`. Files are checked in the order as it were defined:

```php
<?php

use Phalcon\Loader;

// Crear el autocargador
$loader = new Loader();

// Establecer las extensiones de archivo a comprobar
$loader->setExtensions(
    [
        'php',
        'inc',
        'phb',
    ]
);
```

<a name='file-checking-callback'></a>

## Chequeo de archivo por retro llamada

You can speed up the loader by setting a different file checking callback method using the `setFileCheckingCallback` method.

The default behavior uses `is_file`. However you can also use `null` which will not check whether a file exists or not before loading it or you can use `stream_resolve_include_path` which is much faster than `is_file` but will cause problems if the target file is removed from the file system.

```php
<?php

// Default behavior.
$loader->setFileCheckingCallback("is_file");

// Faster than `is_file()`, but implies some issues if
// the file is removed from the filesystem.
$loader->setFileCheckingCallback("stream_resolve_include_path");

// Do not check file existence.
$loader->setFileCheckingCallback(null);
```

<a name='modifying-current-strategies'></a>

## Modificando estrategias actuales

Additional auto-loading data can be added to existing values by passing `true` as the second parameter:

```php
<?php

// Agregando más directorios
$loader->registerDirs(
    [
        '../app/library',
        '../app/plugins',
    ],
    true
);
```

<a name='events'></a>

## Eventos de carga automática

In the following example, the `EventsManager` is working with the class loader, allowing us to obtain debugging information regarding the flow of operation:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Loader;

$eventsManager = new EventsManager();

$loader = new Loader();

$loader->registerNamespaces(
    [
        'Example\Base'    => 'vendor/example/base',
        'Example\Adapter' => 'vendor/example/adapter',
        'Example'         => 'vendor/example',
    ]
);

// Escuchando todos los eventos del cargador
$eventsManager->attach(
    'loader:beforeCheckPath',
    function (Event $event, Loader $loader) {
        echo $loader->getCheckedPath();
    }
);

$loader->setEventsManager($eventsManager);

$loader->register();
```

Some events when returning boolean `false` could stop the active operation. The following events are supported:

| Nombre de evento   | Disparado                                                                                                                          | ¿Detiene la operación? |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- | ---------------------- |
| `beforeCheckClass` | Activado antes de iniciar el proceso de auto carga                                                                                 | Si                     |
| `pathFound`        | Se activa cuando el cargador localiza una clase                                                                                    | No                     |
| `afterCheckClass`  | Se activa después de acabado el proceso de carga. Si este evento es lanzado si el autocargador no encuentra el archivo de la clase | No                     |

<a name='troubleshooting'></a>

## Resolución de problemas

Some things to keep in mind when using the universal autoloader:

* El proceso de auto carga es sensible a mayúsculas, la clase se cargará como fue escrita en el código
* Las estrategias basadas en espacios de nombres o prefijos son más rápidas que las estrategias de directorios
* If a cache bytecode like [APC](https://php.net/manual/en/book.apc.php) is installed this will used to retrieve the requested file (an implicit caching of the file is performed)