<div class='article-menu'>
  <ul>
    <li>
      <a href="#ایجاد یک برنامه کوچک">ایجاد یک برنامه کوچک</a> <ul>
        <li>
          <a href="#ساختار">ساختار</a>
        </li>
        <li>
          <a href="#ایجاد خود راه انداز">ایجاد خود راه انداز</a>
        </li>
        <li>
          <a href="#وظایف">وظایف</a>
        </li>
        <li>
          <a href="#پارامترهای عمل پردازش">پارامترهای عمل پردازش</a>
        </li>
        <li>
          <a href="#کارهای در حال اجرا در زنجیره">کارهای در حال اجرا در زنجیره</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='creating-cli-application'></a>

# ایجاد یک خط فرمان (CLI)

برنامه های CLI از خط فرمان اجرا می شوند. آنها برای ایجاد مشاغل کرون، اسکریپت ها، ابزارهای فرمان و موارد دیگر مفید هستند.

<a name='structure'></a>

## ساختار

ساختار حداقل یک برنامه CLI مانند این خواهد بود:

- `app/config/config.php`
- `app/tasks/MainTask.php`
- `app/cli.php` <-- فایل های خود راه انداز اصلی

<a name='creating-bootstrap'></a>

## ایجاد خود راه انداز

همانطور که در برنامه های MVC به طور منظم، یک فایل بوت استرپ برای راه اندازی برنامه کاربردی استفاده می شود. به جای استفاده از index.php خود راه اندازدر برنامه های وب، از فایل cli.php برای بوت استرپ کردن برنامه استفاده می کنیم.

در زیر یک بوت استرپ نمونه است که برای این مثال استفاده می شود.

```php
<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;

// Using the CLI factory default services container
$di = new CliDI();

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . '/tasks',
    ]
);

$loader->register();

// Load the configuration file (if any)
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

این قطعه کد را می توان با استفاده از:

```bash
php app/cli.php
```

<a name='tasks'></a>

## وظایف

وظایف شبیه به کنترل کننده ها است. هر برنامه کاربردی CLI نیاز به حداقل یک کارهای اصلی و یک عمل اصلی دارد و هر کار باید یک عمل اصلی انجام دهد که اگر هیچ اقدام صریحا داده نشود اجرا خواهد شد.

در زیر یک نمونه از آن است `app/tasks/MainTask.php` فایل:

```php
<?php

use Phalcon\Cli\Task;
{
    تابع عمومی عمل اصلی ()
    {
        echo 'این کار پیش فرض و عمل پیش فرض است'. PHP _EOL;
    }
}
```

<a name='processing-action-parameters'></a>

## پارامترهای عمل پردازش

امکان انتقال پارامترها به اعمال وجود دارد، کد برای این در حال حاضر در نمونه اولیه بوت استرپ وجود دارد.

اگر برنامه را با پارامترها و عمل زیر اجرا کنید:

```php
<?php

استفاده Phalcon\Cli\Task;

کلاس وظیفه اصلی و توسعه وظیفه
{
    تابع عمومی عمل اصلی()
    {
       echo 'این کار پیش فرض و عمل پیش فرض است' . PHP_EOL;
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

سپس می توانیم دستور زیر را اجرا کنیم:

```bash
برنامه php/cli.php جهان اصلی جهان تست

سلام دنیا
با احترام، جهان
```

<a name='running-tasks-chain'></a>

## کارهای در حال اجرا در زنجیره

اگر لازم باشد، وظایف را در یک زنجیره نیز ممکن است انجام شود. برای انجام این کار باید خود کنسول را به DI اضافه کنید:

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

سپس میتوانید از کنسول داخل هر کار استفاده کنید. در زیر یک نمونه از کار اصلی اصلی اصلاح شده php است:

```php
<?php

استفاده Phalcon\Cli\Task;

کلاس وظیفه اصلی و توسعه وظیفه
{
    تابع عمومی عمل اصلی()
    {
       echo;این کار پیش فرض و عمل پیش فرض است" . PHP_EOL;

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

با این حال، این ایده بهتر است برای گسترش `Phalcon\Cli\Task` و پیاده سازی این نوع منطق وجود داشته باشد.