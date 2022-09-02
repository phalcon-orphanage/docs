---
layout: default
title: 'Phalcon\Application'
---

* [Phalcon\Application\AbstractApplication](#application-abstractapplication)
* [Phalcon\Application\Exception](#application-exception)

<h1 id="application-abstractapplication">Abstract Class Phalcon\Application\AbstractApplication</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Application/AbstractApplication.zep)

| Namespace  | Phalcon\Application | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Extends    | Injectable | | Implements | EventsAwareInterface |

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.


## Properties
```php
/**
 * @var DiInterface|null
 */
protected container;

/**
 * @var string
 */
protected defaultModule = "";

/**
 * @var ManagerInterface|null
 */
protected eventsManager;

/**
 * @var array
 */
protected modules;

```

## メソッド

```php
public function __construct( DiInterface $container = null );
```
Phalcon\AbstractApplication constructor


```php
public function getDefaultModule(): string;
```
Returns the default module name


```php
public function getEventsManager(): ManagerInterface | null;
```
内部イベントマネージャーを返します


```php
public function getModule( string $name ): array | object;
```
モジュール名でアプリケーションに登録されているモジュール定義を取得します。


```php
public function getModules(): array;
```
アプリケーションに登録されているモジュールを返す


```php
public function registerModules( array $modules, bool $merge = bool ): AbstractApplication;
```
Register an array of modules present in the application

```php
$this->registerModules(
    [
        "frontend" => [
            "className" => \Multiple\Frontend\Module::class,
            "path"      => "../apps/frontend/Module.php",
        ],
        "backend" => [
            "className" => \Multiple\Backend\Module::class,
            "path"      => "../apps/backend/Module.php",
        ],
    ]
);
```


```php
public function setDefaultModule( string $defaultModule ): AbstractApplication;
```
Sets the module name to be used if the router doesn't return a valid module


```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```
イベントマネージャーをセットします




<h1 id="application-exception">Class Phalcon\Application\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Application/Exception.zep)

| Namespace  | Phalcon\Application | | Extends    | \Exception |

Exceptions thrown in Phalcon\Application class will use this class
