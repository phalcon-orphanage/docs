<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-cli-application">CLI Uygulaması Oluşturma</a>
    </li>
  </ul>
</div>

# Bir Komut Satırı (CLI) Uygulaması Oluşturma

CLI uygulamaları komut satırından çalıştırılır. Bu uygulamalar özellikle zamanlanmış görevler, betikler ve benzer daha bir çok farklı amaçla kullanılabilir.

## Yapı

Bir CLI uygulamasının asgari yapısı şöyle görünecektir:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <--ana önyükleme dosyası

## Bir Önyükleme Oluşturma

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

Görevlerin çalışma şekli aynı kontrolcüler gibidir. Bir CLI uygulaması için en az bir Ana Görev (MainTask) ve Ana İşlem (MainAction) gereklidir ve her görev için (eğer özel bir işlem belirtilmediyse çalışacak) bir Ana İşlem (mainAction) olmalıdır.

Aşağıda `app/tasks/MainTask.php` dosyasına bir örnek verilmiştir:

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

## Eylem parametrelerini işlemek

Örnek önyükleyici dosyasında da göreceğiniz üzere işlemlere parametreler geçirebilirsiniz.

Uygulamayı aşağıdaki parametreler ve eylemle çalıştırırsanız:

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

## Bir zincirde görevleri çalıştırma

Gerektiğinde görevleri bir zincir içerisinde yürütmek de mümkündür. Bunu başarmak için, konsolun kendisini DI'ye eklemelisiniz:

```php
<?php

$di->setShared("console", $console);

try {
    // Gelen bağımsız değişkenleri yönet
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();

    exit(255);
}
```

Ardından konsolu herhangi bir görevin içinde kullanabilirsiniz. Aşağıda, değiştirilmiş bir MainTask.php örneği verilmiştir:

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

Bununla birlikte, `Phalcon\Cli\Task`'ı genişletmek ve bu tür mantığı orada uygulamak daha iyi bir fikirdir.