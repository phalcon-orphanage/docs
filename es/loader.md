<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Cargador automático de clases</a> <ul>
        <li>
          <a href="#security">Capa de seguridad</a>
        </li>
        <li>
          <a href="#registering-namespaces">Registrando espacios de nombres</a>
        </li>
        <li>
          <a href="#registering-directories">Registrando directorios</a>
        </li>
        <li>
          <a href="#registering-classes">Registrando clases</a>
        </li>
        <li>
          <a href="#registering-files">Registrando archivos</a>
        </li>
        <li>
          <a href="#registering-file-extensions">Extensiones de archivo adicionales</a>
        </li>
        <li>
          <a href="#modifying-current-strategies">Modificando estrategias actuales</a>
        </li>
        <li>
          <a href="#events">Eventos de carga automática</a>
        </li>
        <li>
          <a href="#troubleshooting">Resolución de problemas</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Cargador automático de clases

`Phalcon\Loader` le permite cargar clases de proyecto automáticamente, basado en algunas reglas predefinidas. Ya que este componente está escrito en C, provee una sobrecarga mínima en lectura e interpretación de archivos PHP externos.

El comportamiento de este componente se basa en la capacidad de PHP de [carga automática de clases](http://www.php.net/manual/en/language.oop5.autoload.php). Si se utiliza una clase que todavía no existe en ninguna parte del código, un gestor especial intentará cargarlo. `Phalcon\Loader` sirve como el gestor especial para esta operación. Al cargar las clases en función de la necesidad de carga, el rendimiento general aumenta ya que las únicas lecturas de archivos que se producen son para los archivos necesarios. Esta técnica se llama [inicialización perezosa](http://en.wikipedia.org/wiki/Lazy_initialization).

Con este componente se pueden cargar archivos de otros proyectos o proveedores, este cargador automático es compatible con [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) y [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4.md).

`Phalcon\Loader` ofrece cuatro opciones para autocarga de clases. Se puede utilizar una a la vez o combinarlas.

<a name='security'></a>

## Capa de seguridad

`Phalcon\Loader` ofrece una capa de seguridad que desinfecta por nombres de clase predeterminados, evitando la posible inclusión de archivos no autorizados. Considere el siguiente ejemplo:

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

El autocargador anterior carece de cualquier tipo de seguridad. Si una función inicia por error el autocargador y una cadena maliciosa preparada se utiliza como parámetro, esto permitiría ejecutar cualquier archivo accesible por la aplicación:

```php
<?php

// Esta variable no esta filtrada y proviene de una fuente insegura
$className = '../processes/important-process';

// Chequear si existe esta clase activado el autocargador
if (class_exists($className)) {
    // ...
}
```

Si `../processes/important-process.php` es un archivo válido, un usuario externo puede ejecutar el archivo sin autorización.

Para evitar este tipo de ataques o más sofisticados aún, `Phalcon\Loader` elimina los caracteres no válidos del nombre de clase, reduciendo la posibilidad de ser atacados.

<a name='registering-namespaces'></a>

## Registrando espacios de nombres

If you're organizing your code using namespaces, or using external libraries which do, the `registerNamespaces()` method provides the autoloading mechanism. It takes an associative array; the keys are namespace prefixes and their values are directories where the classes are located in. The namespace separator will be replaced by the directory separator when the loader tries to find the classes. Always remember to add a trailing slash at the end of the paths.

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
       'Example\Base'    => 'vendor/example/base/',
       'Example\Adapter' => 'vendor/example/adapter/',
       'Example'         => 'vendor/example/',
    ]
);

// Register autoloader
$loader->register();

// The required class will automatically include the
// file vendor/example/adapter/Some.php
$some = new \Example\Adapter\Some();
```

<a name='registering-directories'></a>

## Registering Directories

The third option is to register directories, in which classes could be found. This option is not recommended in terms of performance, since Phalcon will need to perform a significant number of file stats on each folder, looking for the file with the same name as the class. It's important to register the directories in relevance order. Remember always add a trailing slash at the end of the paths.

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some directories
$loader->registerDirs(
    [
        'library/MyComponent/',
        'library/OtherComponent/Other/',
        'vendor/example/adapters/',
        'vendor/example/',
    ]
);

// Register autoloader
$loader->register();

// The required class will automatically include the file from
// the first directory where it has been located
// i.e. library/OtherComponent/Other/Some.php
$some = new \Some();
```

<a name='registering-classes'></a>

## Registering Classes

The last option is to register the class name and its path. This autoloader can be very useful when the folder convention of the project does not allow for easy retrieval of the file using the path and the class name. This is the fastest method of autoloading. However the more your application grows, the more classes/files need to be added to this autoloader, which will effectively make maintenance of the class list very cumbersome and it is not recommended.

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some classes
$loader->registerClasses(
    [
        'Some'         => 'library/OtherComponent/Other/Some.php',
        'Example\Base' => 'vendor/example/adapters/Example/BaseClass.php',
    ]
);

// Register autoloader
$loader->register();

// Requiring a class will automatically include the file it references
// in the associative array
// i.e. library/OtherComponent/Other/Some.php
$some = new \Some();
```

<a name='registering-files'></a>

## Registering Files

You can also registers files that are `non-classes` hence needing a `require`. This is very useful for including files that only have functions:

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some classes
$loader->registerFiles(
    [
        'functions.php',
        'arrayFunctions.php',
    ]
);

// Register autoloader
$loader->register();
```

These files are automatically loaded in the `register()` method.

<a name='registering-file-extensions'></a>

## Additional file extensions

Some autoloading strategies such as `prefixes`, `namespaces` or `directories` automatically append the `php` extension at the end of the checked file. If you are using additional extensions you could set it with the method `setExtensions`. Files are checked in the order as it were defined:

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Set file extensions to check
$loader->setExtensions(
    [
        'php',
        'inc',
        'phb',
    ]
);
```

<a name='modifying-current-strategies'></a>

## Modifying current strategies

Additional auto-loading data can be added to existing values by passing `true` as the second parameter:

```php
<?php

// Adding more directories
$loader->registerDirs(
    [
        '../app/library/',
        '../app/plugins/',
    ],
    true
);
```

<a name='events'></a>

## Autoloading Events

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
        'Example\Base'    => 'vendor/example/base/',
        'Example\Adapter' => 'vendor/example/adapter/',
        'Example'         => 'vendor/example/',
    ]
);

// Listen all the loader events
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

| Event Name         | Triggered                                                                                                           | Can stop operation? |
| ------------------ | ------------------------------------------------------------------------------------------------------------------- | ------------------- |
| `beforeCheckClass` | Triggered before starting the autoloading process                                                                   | Yes                 |
| `pathFound`        | Triggered when the loader locate a class                                                                            | No                  |
| `afterCheckClass`  | Triggered after finish the autoloading process. If this event is launched the autoloader didn't find the class file | No                  |

<a name='troubleshooting'></a>

## Troubleshooting

Some things to keep in mind when using the universal autoloader:

- Auto-loading process is case-sensitive, the class will be loaded as it is written in the code
- Strategies based on namespaces/prefixes are faster than the directories strategy
- If a cache bytecode like [APC](http://php.net/manual/en/book.apc.php) is installed this will used to retrieve the requested file (an implicit caching of the file is performed)