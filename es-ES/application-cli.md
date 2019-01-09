* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='creating-cli-application'></a>

# Crear una Aplicación de Línea de Comandos (CLI)

CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

<a name='structure'></a>

## Estructura

La estructura mínima de una aplicación CLI se verá así:

* `app/config/config.php`
* `app/tasks/MainTask.php`
* `app/cli.php` <-- main bootstrap file

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

Las tareas funcionan de manera similar a los controladores. Any CLI application needs at least a MainTask and a mainAction and every task needs to have a mainAction which will run if no action is given explicitly.

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

It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself to the DI:

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

Then you can use the console inside of any task. Below is an example of a modified MainTask.php:

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