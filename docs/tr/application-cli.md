<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-cli-application">Creating a CLI Application</a>
    </li>
  </ul>
</div>

# Creating a Command Line (CLI) Application

CLI uygulamaları komut satırından çalıştırılır. Bu uygulamalar özellikle zamanlanmış görevler, betikler ve benzer daha bir çok farklı amaçla kullanılabilir.

## Yapı

A minimal structure of a CLI application will look like this:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <--ana önyükleme dosyası

## Creating a Bootstrap

Normal MVC uygulamalarında olduğu gibi uygulamayı önyüklemek için bir önyükleme (bootstrap) dosyası kullanılır. Web uygulamalarında önyükleyici olarak index.php kullanılırken CLI uygulamalarında önyükleme için cli.php dosyasını kullanırız.

Bu uygulamamızda kullanacağımız önyükleyici örneği şöyledir;

```php
<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;

// CLI uygulamamız için servis kapsayıcısı 
$di = new CliDI();

/**
 * Otomatik yükleyiciyi çağıralım ve görev dizinini kaydettirelim
 */
$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . '/tasks',
    ]
);

$loader->register();

// Ayar dosyasını yükleyelim (varsa)
$configFile = __DIR__ . '/config/config.php';

if (is_readable($configFile)) {
    $config = include $configFile;

    $di->set('config', $config);
}

// CLI uygulamamızı oluşturalım
$console = new ConsoleApp();

$console->setDI($di);

/**
 * Uygulamamıza parametre olarak gönderilen verileri işleyelim
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
    // Gelen parametreleri okuyalım
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();

    exit(255);
}
```

Bu kod parçası şöyle çalıştırılabilir:

```bash
php app/cli.php
```

## Görevler

Tasks work similar to controllers. Any CLI application needs at least a MainTask and a mainAction and every task needs to have a mainAction which will run if no action is given explicitly.

Below is an example of the `app/tasks/MainTask.php` file:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
}
```

## Processing action parameters

It's possible to pass parameters to actions, the code for this is already present in the sample bootstrap.

If you run the application with the following parameters and action:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }

    /**
     * @param array $params
     */
    public function testAction(array $params)
    {
        echo sprintf('hello %s', $params[0]);

        echo PHP_EOL;

        echo sprintf('best regards, %s', $params[1]);

        echo PHP_EOL;
    }
}
```

We can then run the following command:

```bash
php app/cli.php main test world universe

hello world
best regards, universe
```

## Running tasks in a chain

It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself to the DI:

```php
<?php

$di->setShared("console", $console);

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();

    exit(255);
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
        echo "This is the default task and the default action" . PHP_EOL;

        $this->console->handle(
            [
                "task"   => "main",
                "action" => "test",
            ]
        );
    }

    public function testAction()
    {
        echo "I will get printed too!" . PHP_EOL;
    }
}
```

However, it's a better idea to extend `Phalcon\Cli\Task` and implement this kind of logic there.