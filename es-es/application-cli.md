* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='creating-cli-application'></a>

# Crear una Aplicación de Línea de Comandos (CLI)

Las aplicaciones CLI se ejecutan desde la linea de comandos. Estas son útiles para crear tareas programadas por crons, scripts, herramientas de comandos y más.

<a name='structure'></a>

## Estructura

La estructura mínima de una aplicación CLI se verá así:

* `app/config/config.php`
* `app/tasks/MainTask.php`
* `app/cli.php` <-- archivo principal de ejecución

<a name='creating-bootstrap'></a>

## Creando un Archivo Principal de Ejecución

Como en aplicaciones MVC normales, un archivo principal se utiliza para arrancar la ejecución de la aplicación. En lugar del archivo index.php que inicia las aplicaciones web, se utiliza un archivo llamado cli.php para que la aplicación arranque.

A continuación el Archivo Principal de Arranque que se utiliza en este ejemplo.

```php
<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;

// Uso del contenedor de servicios predeterminado CLI
$di = new CliDI();

/**
 * Registrar el autocargador e indicarle que registre el directorio de tareas
 */
$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . '/tasks',
    ]
);

$loader->register();

// Cargar archivo de configuración (si hay alguno)
$configFile = __DIR__ . '/config/config.php';

if (is_readable($configFile)) {
    $config = include $configFile;

    $di->set('config', $config);
}

// Crear una aplicación de consola (o de linea de comandos)
$console = new ConsoleApp();

$console->setDI($di);

/**
 * Procesar los argumentos de la consola
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    // Gestionar los argumentos recibidos
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Gestionar el error de Phalcon aquí
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

Este fragmento de código se puede ejecutar utilizando:

```bash
php app/cli.php
```

<a name='tasks'></a>

## Tasks (Tareas)

Los Task o tareas funcionan de forma similar a los controladores. Cualquier aplicación CLI necesita al menos un MainTask y un mainAction y cada Task debe tener un mainAction que se ejecutará si no se indica alguna acción explícitamente.

A continuación un ejemplo del archivo `app/tasks/MainTask.php`:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'Este es el Task por default y el Action por default' . PHP_EOL;
    }
}
```

<a name='processing-action-parameters'></a>

## Procesar parámetros del Action

Es posible pasar parámetros a los Action, el código ya está presente en el archivo principal del ejemplo.

Si ejecuta la aplicación con los siguientes parámetros y acción:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'Este es el Task por default y el Action por default' . PHP_EOL;
    }

    /**
     * @param array $params
     */
    public function testAction(array $params)
    {
        echo sprintf('hola %s', $params[0]);

        echo PHP_EOL;

        echo sprintf('saludos cordiales, %s', $params[1]);

        echo PHP_EOL;
    }
}
```

A continuación podemos ejecutar el siguiente comando:

```bash
php app/cli.php main test mundo universo

hola mundo
saludos cordiales, universo
```

<a name='running-tasks-chain'></a>

## Ejecutando Tasks en cadena

También es posible ejecutar tareas en cadena si es necesario. Para lograr esto se debe agregar la consola al DI:

```php
<?php

$di->setShared("console", $console);

try {
    // Gestionar argumentos recibidos
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Gestionar el error de Phalcon aquí
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

Luego puede utilizar la consola dentro de cualquier tarea. A continuación un ejemplo de un MainTask.php modificado:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo "Este es el Task por default y el Action por default" . PHP_EOL;

        $this->console->handle(
            [
                "task"   => "main",
                "action" => "test",
            ]
        );
    }

    public function testAction()
    {
        echo "Yo también seré mostrado en pantalla!" . PHP_EOL;
    }
}
```

However, it's a better idea to extend [Phalcon\Cli\Task](api/Phalcon_Cli_Task) and implement this kind of logic there.