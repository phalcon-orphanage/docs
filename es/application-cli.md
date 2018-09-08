<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-cli-application">Crear una Aplicación de Línea de Comandos (CLI)</a> 
      <ul>
        <li>
          <a href="#structure">Estructura</a>
        </li>
        <li>
          <a href="#creating-bootstrap">Creando un Archivo Principal de Ejecución</a>
        </li>
        <li>
          <a href="#tasks">Tasks (Tareas)</a>
        </li>
        <li>
          <a href="#processing-action-parameters">Procesar parámetros del Action</a>
        </li>
        <li>
          <a href="#running-tasks-chain">Ejecutando Tasks en cadena</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='creating-cli-application'></a>

# Crear una Aplicación de Línea de Comandos (CLI)

Las aplicaciones CLI son ejecutadas desde la consola de comandos. Son útiles para crear trabajos cron, scripts, comandos de utilidades y más.

<a name='structure'></a>

## Estructura

La estructura mínima de una aplicación CLI se verá así:

* `app/config/config.php`
* `app/tasks/MainTask.php`
* `app/cli.php` archivo principal de ejecución

<a name='creating-bootstrap'></a>

## Creando un Archivo Principal de Ejecución

Como en aplicaciones MVC normales, un archivo principal se utiliza para arrancar la ejecución de la aplicación. En lugar del archivo `index.php` que inicia las aplicaciones web, se utiliza un archivo llamado `cli.php` para que la aplicación arranque.

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
}
```

Este fragmento de código se puede ejecutar utilizando:

```bash
php app/cli.php
```

<a name='tasks'></a>

## Tasks (Tareas)

Las tareas funcionan de manera similar a los controladores. Cualquier aplicación CLI necesita al menos un `MainTask` y un `mainAction` y cada Task debe tener un `mainAction` que se ejecutará si no se indica alguna acción explícitamente.

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

También es posible ejecutar tareas en cadena is es necesario. Para lograr esto, debe agregar la consola al DI:

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
}
```

Luego puede utilizar la consola dentro de cualquier tarea. A continuación vemos un ejemplo modificado del MainTask.php:

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

Sin embargo, es una mejor idea extender la clase `Phalcon\Cli\Task` y poner en práctica este tipo de lógica ahí.