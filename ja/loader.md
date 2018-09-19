<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">クラスオートローダ</a> <ul>
        <li>
          <a href="#security">Security Layer</a>
        </li>
        <li>
          <a href="#registering-namespaces">名前空間の登録</a>
        </li>
        <li>
          <a href="#registering-directories">ディレクトリの登録</a>
        </li>
        <li>
          <a href="#registering-classes">クラスの登録</a>
        </li>
        <li>
          <a href="#registering-files">ファイルの登録</a>
        </li>
        <li>
          <a href="#registering-file-extensions">追加のファイル拡張子</a>
        </li>
        <li>
          <a href="#modifying-current-strategies">Modifying current strategies</a>
        </li>
        <li>
          <a href="#events">Autoloading Events</a>
        </li>
        <li>
          <a href="#troubleshooting">トラブルシューティング</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# クラスオートローダ

`Phalcon\Loader` により、定義済みのルールに基づいて、自動的にプロジェクトのクラスを読み込むことができます。 Since this component is written in C, it provides the lowest overhead in reading and interpreting external PHP files.

このコンポーネントの動作は、[クラスのオートローディング](http://www.php.net/manual/en/language.oop5.autoload.php) に関する PHP の機能に基づいています。 まだ存在しないクラスがコードの任意の部分で利用される場合、特別なハンドラーがそれをロードしようとします。 `Phalcon\Loader` はこの操作に対して、特別なハンドラーとして機能します。 By loading classes on a need-to-load basis, the overall performance is increased since the only file reads that occur are for the files needed. この手法は、[lazy initialization](http://en.wikipedia.org/wiki/Lazy_initialization) と呼ばれます。

このコンポーネントによって他のプロジェクトやベンダーからファイルをロードする事ができます。このオートローダーは [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) と [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4.md) 準拠です。

`Phalcon\Loader` offers four options to autoload classes. You can use them one at a time or combine them.

<a name='security'></a>

## Security Layer

`Phalcon\Loader` offers a security layer sanitizing by default class names avoiding possible inclusion of unauthorized files. Consider the following example:

```php
<?php

// Basic autoloader
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

// This variable is not filtered and comes from an insecure source
$className = '../processes/important-process';

// Check if the class exists triggering the auto-loader
if (class_exists($className)) {
    // ...
}
```

If `../processes/important-process.php` is a valid file, an external user could execute the file without authorization.

To avoid these or most sophisticated attacks, `Phalcon\Loader` removes invalid characters from the class name, reducing the possibility of being attacked.

<a name='registering-namespaces'></a>

## Registering Namespaces

If you're organizing your code using namespaces, or using external libraries which do, the `registerNamespaces()` method provides the autoloading mechanism. It takes an associative array; the keys are namespace prefixes and their values are directories where the classes are located in. The namespace separator will be replaced by the directory separator when the loader tries to find the classes.

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
       'Example\Base'    => 'vendor/example/base',
       'Example\Adapter' => 'vendor/example/adapter',
       'Example'         => 'vendor/example',
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

The third option is to register directories, in which classes could be found. This option is not recommended in terms of performance, since Phalcon will need to perform a significant number of file stats on each folder, looking for the file with the same name as the class. It's important to register the directories in relevance order.

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some directories
$loader->registerDirs(
    [
        'library/MyComponent',
        'library/OtherComponent/Other',
        'vendor/example/adapters',
        'vendor/example',
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
        '../app/library',
        '../app/plugins',
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
        'Example\Base'    => 'vendor/example/base',
        'Example\Adapter' => 'vendor/example/adapter',
        'Example'         => 'vendor/example',
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

* Auto-loading process is case-sensitive, the class will be loaded as it is written in the code
* Strategies based on namespaces/prefixes are faster than the directories strategy
* If a cache bytecode like [APC](http://php.net/manual/en/book.apc.php) is installed this will used to retrieve the requested file (an implicit caching of the file is performed)