<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-cli-application">CLI Uygulaması Oluşturma</a> <ul>
        <li>
          <a href="#structure">Yapı</a>
        </li>
        <li>
          <a href="#creating-bootstrap">Bir Önyükleme Oluşturma</a>
        </li>
        <li>
          <a href="#tasks">Görevler</a>
        </li>
        <li>
          <a href="#processing-action-parameters">Eylem parametrelerini işlemek</a>
        </li>
        <li>
          <a href="#running-tasks-chain">Bir zincirdeki görevleri çalıştırma</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='creating-cli-application'></a>

# Bir Komut Satırı (CLI) Uygulaması Oluşturma

CLI uygulamaları komut satırından yürütülür. Bunlar, cron işleri, komut dosyaları, komut araçları ve daha fazlasını oluşturmak için yararlıdır.

<a name='structure'></a>

## Structure

CLI uygulamasının asgari bir yapısı şöyle görünecektir:

- `app/config/config.php`
- `app/tasks/MainTask.php`
- `app/cli.php` <-- ana önyükleme dosyası

<a name='creating-bootstrap'></a>

## Creating a Bootstrap

Normal MVC uygulamalarında olduğu gibi, bir önyükleme dosyası, uygulamayı önyüklemek için kullanılır. Web uygulamalarında index.php önyükleme yerine, uygulamayı önyüklemek için bir cli.php dosyası kullanırız.

Bu örnek için kullanacağımız önyükleyici şöyledir:

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

// Create a console application
$console = new ConsoleApp();

$console->setDI($di);

/**
 * Process the console arguments
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
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
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

Bu kod parçası şöyle çalıştırılabilir:

```bash
php app/cli.php
```

<a name='tasks'></a>

## Tasks

Görevlerin çalışma şekli aynı kontrolcüler gibidir. Bir CLI uygulaması için en az bir Ana Görev (MainTask) ve Ana İşlem (MainAction) gereklidir ve her görev için (eğer özel bir işlem belirtilmediyse çalışacak) bir Ana İşlem (mainAction) olmalıdır.

Below is an example of the `app/tasks/MainTask.php` file:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'Bu varsayılan görev ve varsayılan eylemdir' . PHP_EOL;
    }
}
```

<a name='processing-action-parameters'></a>

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
        echo 'Bu varsayılan görev ve varsayılan eylemdir' . PHP_EOL;
    }

    /**
     * @param array $params
     */
    public function testAction(array $params)
    {
        echo sprintf('merhaba %s', $params[0]);

        echo PHP_EOL;

        echo sprintf('saygılarımla, %s', $params[1]);

        echo PHP_EOL;
    }
}
```

Daha sonra aşağıdaki komutu çalıştırabiliriz:

```bash
php app/cli.php main test dünya evren

merhaba dünya
saygılarımla, evren
```

<a name='running-tasks-chain'></a>

## Running tasks in a chain

It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself to the DI:

```php
<?php

$di->setShared("console", $console);

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
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
        echo "Bu varsayılan görev ve varsayılan eylemdir" . PHP_EOL;

        $this->console->handle(
            [
                "task"   => "main",
                "action" => "test",
            ]
        );
    }

    public function testAction()
    {
        echo "Ben de ekrana basılmış olacağım!" . PHP_EOL;
    }
}
```

However, it's a better idea to extend `Phalcon\Cli\Task` and implement this kind of logic there.