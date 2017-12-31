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

Si estás organizando tu código usando espacios de nombres, o usando bibliotecas externas que los utilizan, el método `registerNamespaces()` proporciona el mecanismo de carga automática. Se necesita una matriz asociativa; las claves son los prefijos de los espacio de nombres y los valores son los directorios donde se encuentran las clases. El separador de espacio de nombres se sustituirá por el separador de directorio cuando el cargador intente encontrar las clases. Recuerda siempre añadir una barra al final de los caminos.

```php
<?php

use Phalcon\Loader;

// Crear el autocargador
$loader = new Loader();

// Registrar algunos espacios de nombres
$loader->registerNamespaces(
    [
       'Example\Base'    => 'vendor/example/base/',
       'Example\Adapter' => 'vendor/example/adapter/',
       'Example'         => 'vendor/example/',
    ]
);

// Registrar el autocargador
$loader->register();

// La clase requerida incluirá automáticamente
// el archivo vendor/example/adapter/Some.php
$some = new \Example\Adapter\Some();
```

<a name='registering-directories'></a>

## Registrando directorios

La tercera opción es registrar directorios, en los cuales pueden ser encontradas las clases. Esta opción no se recomienda en términos de rendimiento, ya que Phalcon tendrá que realizar un gran número de estadísticas de archivo en cada carpeta, buscando el archivo con el mismo nombre que la clase. Es importante registrar los directorios en orden de importancia. Recuerda siempre añadir una barra al final de los caminos.

```php
<?php

use Phalcon\Loader;

// Crear el autocargador
$loader = new Loader();

// Registrar algunos directorios
$loader->registerDirs(
    [
        'library/MyComponent/',
        'library/OtherComponent/Other/',
        'vendor/example/adapters/',
        'vendor/example/',
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

La última opción es registrar el nombre de la clase y su camino. Este cargador automático puede ser muy útil cuando la convención de la carpeta del proyecto no permite la fácil recuperación del archivo utilizando la ruta de acceso y el nombre de clase. Este es el método más rápido de carga. Sin embargo mientras más crece su aplicación, más clases y archivos necesitan ser agregados a este cargador automático, lo que hará que el mantenimiento de la lista de clases sea muy engorroso y no es recomendable.

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

Usted también puede registrar archivos que son `sin-clases` por lo tanto necesitan un `require`. Esto es muy útil para incluir archivos que sólo tienen funciones:

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

Estos archivos se cargan automáticamente en el método `register()`.

<a name='registering-file-extensions'></a>

## Extensiones de archivo adicionales

Algunas estrategias de carga tales como `prefijos`, `espacios de nombres` o `directorios` automáticamente agregar la extensión de `php` al final del archivo comprobado. Si usted está usando extensiones adicionales se podrían establecerlas con el método `setExtensions()`. Los archivos se comprueban en el orden como fueron definidos:

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

<a name='modifying-current-strategies'></a>

## Modificando estrategias actuales

Se pueden agregar datos adicionales a la carga automática pueden añadirse a los valores existentes, pasando `true` como segundo parámetro:

```php
<?php

// Agregando más directorios
$loader->registerDirs(
    [
        '../app/library/',
        '../app/plugins/',
    ],
    true
);
```

<a name='events'></a>

## Eventos de carga automática

En el ejemplo siguiente, el `EventsManager` está trabajando con el cargador de clases, lo que nos permite obtener información de depuración sobre el flujo de operación:

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

Si algún evento devuelve `false` podría detener la operación activa. Los siguientes eventos son soportados:

| Nombre del evento  | Activador                                                                                                                          | ¿Puede detener la operación? |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- | ---------------------------- |
| `beforeCheckClass` | Activado antes de iniciar el proceso de auto carga                                                                                 | Sí                           |
| `pathFound`        | Se activa cuando el cargador localiza una clase                                                                                    | No                           |
| `afterCheckClass`  | Se activa después de acabado el proceso de carga. Si este evento es lanzado si el autocargador no encuentra el archivo de la clase | No                           |

<a name='troubleshooting'></a>

## Resolución de problemas

Tenga en mente esta lista cuando utilice auto cargadores universales:

- El proceso de auto carga es sensible a mayúsculas, la clase se cargará como fue escrita en el código
- Las estrategias basadas en espacios de nombres o prefijos son más rápidas que las estrategias de directorios
- Si un cache de bytecode como [APC](http://php.net/manual/en/book.apc.php) está instalado este puede ser utilizado para recuperar el archivo solicitado (se realiza un almacenamiento en caché implícito del archivo)