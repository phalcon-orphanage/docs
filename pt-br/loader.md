---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Loader'
keywords: 'oader, psr-4, autoloading, autoloader'
---

# Loader

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Loader](api/phalcon_loader#loader) is an autoloader that implements [PSR-4](https://www.php-fig.org/psr/psr-4/). Just like any autoloader, depending on its setup, it will try and find the files your code is looking for based on file, class, namespace etc. Since this component is written in C, it offers the lowest overhead when processing its setup, thus offering a performance boost.

![](/assets/images/implements-psr--4-blue.svg)

This component relies on PHP's [autoloading classes](https://secure.php.net/manual/en/language.oop5.autoload.php) capability. If a class defined in the code has not been included yet, a special handler will try to load it. [Phalcon\Loader](api/phalcon_loader#loader) serves as the special handler for this operation. By loading classes on a need to load basis, the overall performance is increased since the only file reads that occur are for the files needed. This technique is called [lazy initialization](https://en.wikipedia.org/wiki/Lazy_initialization).

The component offers options for loading files based on their class, file name, directories on your file system as well as file extensions.

## Registration

Usually we would use the [spl_autoload_register()](https://www.php.net/manual/en/function.spl-autoload-register.php) to register a custom autoloader for our application. [Phalcon\Loader](api/phalcon_loader#loader) hides this complexity. After you define all your namespaces, classes, directories and files you will need to call the `register()` function, and the autoloader is ready to be used.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();
```

`register()` uses [spl_autoload_register()](https://www.php.net/manual/en/function.spl-autoload-register.php) internally. As a result it accepts also accepts the boolean `prepend` parameter. If supplied and is `true`, the autoloader will be prepended on the autoload queue instead of appended (default behavior).

You can always call the `isRegistered()` method to check if your autoloader is registered or not.

> **NOTE**: If there is an error in registering the autoloader, the component will throw an exception.
{: .alert .alert-warning }


```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();

echo $loader->isRegistered(); // true
```

Unregistering the autoloader is similarly easy. All you need to do is call `unregister()`.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$loader->register();

if (true === $loader->isRegistered()) {
    $loader->unregister();
}
```

## Security Layer

[Phalcon\Loader](api/phalcon_loader#loader) incorporates a security layer, by sanitizing class names by default i.e. removing invalid characters. As such it makes it more difficult for malicious code to be injected in your application.

Consider the following example:

```php
<?php

// Basic autoloader
spl_autoload_register(
    function (string $className) {
        $filepath = $className . '.php';

        if (file_exists($filepath)) {
            require $filepath;
        }
    }
);
```

The above auto loader lacks any kind of security. If a part of your code accidentally calls the auto loader with a name that points to a script containing malicious code, then your application will be compromised.

```php
<?php

$className = '../processes/important-process';

if (class_exists($className)) {
    // ...
}
```

In the above snippet, if `../processes/important-process.php` is a valid file, that could have been uploaded by a hacker or from a not so careful upload process, then an external user could execute the code without any authorization and subsequently get access to the whole application if not the server.

To avoid most of these kind of attacks, [Phalcon\Loader](api/phalcon_loader#loader) removes invalid characters from the class name.

## Namespaces

A very popular way to organize your application is with directories, each representing a particular namespace. [Phalcon\Loader](api/phalcon_loader#loader) can register those namespace to directory mapping and traverse those directories to search the file that your application is requiring.

The `registerNamespaces()` method accepts an array, where keys are the namespaces and values are the actual directories in the file system. The namespace separator will be replaced by the directory separator when the loader tries to find the classes.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'             => 'app/library',
       'MyApp\Controllers' => 'app/controllers',
       'MyApp\Models'      => 'app/models',
    ]
);

$loader->register();
```

In the above example, whenever we reference a controller, the loader will search for it in `app/controllers` and its subdirectories. Similarly for a model the search will occur in `app/models`.

You do not need to register the sub namespaces, if the actual files are located in sub directories that map the namespace naming convention.

So for instance the above example defines our `MyApp` namespace to point to `app/library`. If we have a file:

```bash
/app/library/Components/Mail.php
```

that has a namespace of:

```bash
MyApp\Components
```

then the loader, as defined above, does not need to know about the `MyApp\Components` namespace location, or have it defined in the `registerNamespaces()` declaration.

If the component referenced in the code is `MyApp\Components\Mail`, it will assume that it is a sub directory of the root namespace. However, since we specified a different location for the `MyApp\Controllers` and `MyApp\Models` namespaces, the loader will look for those namespaces in the specified directories.

The `registerNamespaces()` method also accepts a second parameter `merge`. By default it is `false`. You can however set it to `true` when having multiple calls to `registerNamespaces()` so that the namespace definitions are merged.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'             => 'app/library',
    ]
);

$loader->registerNamespaces(
    [
       'MyApp\Controllers' => 'app/controllers',
       'MyApp\Models'      => 'app/models',
    ],
    true
);

$loader->register();
```

The above example merges the second declaration of `registerNamespaces()` with the previous one.

If you need to check what classes are registered in the autoloader, you can use the `getNamespaces()` getter, which returns the array of the registered namespaces. For the example above, `getNamespaces()` returns:

```php
[
   'MyApp'             => 'app/library',
   'MyApp\Controllers' => 'app/controllers',
   'MyApp\Models'      => 'app/models',
]
```

## Classes

Another way to let [Phalcon\Loader](api/phalcon_loader#loader) know where your classes are components/classes are located, so that the autoloader can load them properly, is by using `registerClasses()`.

The method accepts an array, where the key is the namespaced class and the value is the location of the file that contains the class. As expected, this is the fastest way to autoload a class, since the autoloader does not need to do file scans or stats to find the files references.

However, using this method can hinder the maintenance of your application. The more your application grows, the more files are added, the easier it becomes to make a mistake while maintaining the list of files used in `registerClasses()`

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerClasses(
    [
        'MyApp\Components\Mail'             => 'app/library/Components/Mail.php',
        'MyApp\Controllers\IndexController' => 'app/controllers/IndexController.php',
        'MyApp\Controllers\AdminController' => 'app/controllers/AdminController.php',
        'MyApp\Models\Invoices'             => 'app/models/Invoices.php',
        'MyApp\Models\Users'                => 'app/models/Users.php',
    ]
);

$loader->register();
```

In the above example, we are defining the relationship between a namespaced class and a file. As you can see, the loader will be as fast as it can be but the list will start growing, the more our application grows, making maintenance difficult. If however your application does not have that many components, there is no reason why you cannot use this method of autoloading components.

The `registerClasses()` method also accepts a second parameter `merge`. By default it is `false`. You can however set it to `true` when having multiple calls to `registerClasses()` so that the class definitions are merged.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerClasses(
    [
        'MyApp\Components\Mail'             => 'app/library/Components/Mail.php',
        'MyApp\Controllers\IndexController' => 'app/controllers/IndexController.php',
        'MyApp\Controllers\AdminController' => 'app/controllers/AdminController.php',
    ]
);

$loader->registerClasses(
    [
        'MyApp\Models\Invoices'             => 'app/models/Invoices.php',
        'MyApp\Models\Users'                => 'app/models/Users.php',
    ],
    true
);

$loader->register();
```

The above example merges the second declaration of `registerNamespaces()` with the previous one.

If you need to check what classes are registered in the autoloader, you can use the `getClasses()` getter, which returns the array of the registered classes. For the example above, `getClasses()` returns:

```php
[
    'MyApp\Components\Mail'             => 'app/library/Components/Mail.php',
    'MyApp\Controllers\IndexController' => 'app/controllers/IndexController.php',
    'MyApp\Controllers\AdminController' => 'app/controllers/AdminController.php',
    'MyApp\Models\Invoices'             => 'app/models/Invoices.php',
    'MyApp\Models\Users'                => 'app/models/Users.php',
]
```

## Files

There are times that you might need to *require* a specific file that contains a class without a namespace or a file that contains some code that you need. An example would be a file that contains handy debugging functions.

[Phalcon\Loader](api/phalcon_loader#loader) offers `registerFiles()` which is used to *require* such files. It accepts an array, containing the file name and location of each file.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerFiles(
    [
        'functions.php',
        'arrayFunctions.php',
    ]
);

$loader->register();
```

These files are automatically loaded when the `register()` method is called..

The `registerFiles()` method also accepts a second parameter `merge`. By default it is `false`. You can however set it to `true` when having multiple calls to `registerFiles()` so that the file definitions are merged.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerFiles(
    [
        'app/functions/functions.php',
    ]
);

$loader->registerFiles(
    [
        'app/functions/debug.php',
    ],
    true
);

$loader->register();
```

The above example merges the second declaration of `registerFiles()` with the previous one.

If you need to check what classes are registered in the autoloader, you can use the `getFiles()` getter, which returns the array of the registered files. For the example above, `getFiles()` returns:

```php
[
    'app/functions/functions.php',
    'app/functions/debug.php',
]
```

You also have access to the `loadFiles()` method, which will traverse all the files registered and if they exist it will `require` them. This method is automatically called when you call `register()`.

## Directories

Another way to let [Phalcon\Loader](api/phalcon_loader#loader) know where your application files are is to register directories. When a file needs to be required by the application, the autoloader will scan the registered directories to find the referenced file so that it can require it.

The `registerDirs()` method accepts an array with each element being a directory in the file system containing the files that will be required by the application.

This type of registration is not recommended in terms of performance. Additionally the order of declared directories matters, since the autoloader tries to locate the files by searching directories sequentially. As a result, the directory that contains the most referenced files should be declared first, etc.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        'app/functions',
        'app/controllers',
        'app/models',
    ]
);

$loader->register();
```

The `registerDirs()` method also accepts a second parameter `merge`. By default it is `false`. You can however set it to `true` when having multiple calls to `registerDirs()` so that the class definitions are merged.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        'app/functions',
    ]
);

$loader->registerDirs(
    [
        'app/controllers',
        'app/models',
    ],
    true
);

$loader->register();
```

The above example merges the second declaration of `registerDirs()` with the previous one.

If you need to check what classes are registered in the autoloader, you can use the `getDirs()` getter, which returns the array of the registered classes. For the example above, `getDirs()` returns:

```php
[
    'app/functions',
    'app/controllers',
    'app/models',
]
```

## File Extensions

When you use the `registerNamespaces()` and `registerDirs()`, [Phalcon\Loader](api/phalcon_loader#loader) automatically assumes that your files will have the `.php` extension. You can change this behavior by using the `setExtensions()` method. The method accepts an array, where each element is the extension to be checked (without the `.`):

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setExtensions(
    [
        'php',
        'inc',
        'phb',
    ]
);

$loader->registerDirs(
    [
        'app/functions',
    ]
);
```

In the example above, when referencing a file `Mail`, the autoloader will search in `app/functions` for the following files:

* `Mail.php`
* `Mail.inc`
* `Mail.phb`

Files are checked in the order that each extension is defined.

## File Checking Callback

You can speed up the loader by setting a different file checking callback method using the `setFileCheckingCallback()` method.

The default behavior uses [is_file](https://www.php.net/manual/en/function.is-file.php). However you can also use `null` which will not check whether a file exists or not, before loading it or you can use [stream_resolve_include_path](https://www.php.net/manual/en/function.stream-resolve-include-path.php) which is much faster than [is_file](https://www.php.net/manual/en/function.is-file.php) but will cause problems if the target file is removed from the file system.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback("is_file");
```

Default behavior

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback("stream_resolve_include_path");
```

Faster than `is_file()`, but introduces issues if the file is removed from the filesystem.

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->setFileCheckingCallback(null);
```

Do not check file existence.

## Events

The \[Events Manager\]\[events\] component offers hooks that can be implemented to observe or expand the functionality of the loader. The [Phalcon\Loader](api/phalcon_loader#loader) implements the [Phalcon\Events\EventsAwareInterface](api/phalcon_events#events-eventsawareinterface), and therefore the `getEventsManager()` and `setEventsManager()` methods are available.

The following events are available:

| Event              | Description                                                                             | Can stop operation? |
| ------------------ | --------------------------------------------------------------------------------------- | ------------------- |
| `afterCheckClass`  | Fires at the end of the end of the auto load process when the class has not been found. | No                  |
| `beforeCheckClass` | Fires at the beginning of the auto load process, before checking for the class.         | Yes                 |
| `beforeCheckPath`  | Fires before checking a directory for a class file.                                     | Yes                 |
| `pathFound`        | Fires when the loader locates a class file or a file in a registered directory          | Yes                 |

In the following example, the `EventsManager` is working with the class loader, offering additional information on the operation flow:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Loader;

$eventsManager = new Manager();
$loader        = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$eventsManager->attach(
    'loader:beforeCheckPath',
    function (
        Event $event, 
        Loader $loader
    ) {
        echo $loader->getCheckedPath();
    }
);

$loader->setEventsManager($eventsManager);

$loader->register();
```

In the above example, we create a new Events Manager object, attach a method to the `loader:beforeCheckPath` event and then set it in our autoloader. Every time the loader loops and looks for a particular file in a specific path, the path will be printed on screen.

The `getCheckedPath()` holds the path that is scanned during each iteration of the internal loop. Also you can use the `getfoundPath()` method, which holds the path of the found file during the internal loop.

For events that can stop operation, all you will need to do is return `false` in the method that is attached to the particular event:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Loader;

$eventsManager = new Manager();
$loader        = new Loader();

$loader->registerNamespaces(
    [
       'MyApp'        => 'app/library',
       'MyApp\Models' => 'app/models',
    ]
);

$eventsManager->attach(
    'loader:beforeCheckPath',
    function (
        Event $event, 
        Loader $loader
    ) {
        if ('app/models' === $loader->getCheckedPath()) {
            return false;
        }
    }
);

$loader->setEventsManager($eventsManager);

$loader->register();
```

In the above example, when the autoloader starts scanning the `app/models` folder for the `MyApp\Models` namespace, it will stop the operation.

## Troubleshooting

Some things to keep in mind when using the autoloader:

* The auto-loading process is case-sensitive
* Strategies based on namespaces/prefixes are faster than the directories strategy
* If a bytecode cache, such as [APCu](https://php.net/manual/en/book.apcu.php), is installed, it will be used to get the requested file (an implicit caching of the file is performed)