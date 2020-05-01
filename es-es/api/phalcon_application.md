---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Application'
---

* [Phalcon\Application\AbstractApplication](#application-abstractapplication)
* [Phalcon\Application\Exception](#application-exception)

<h1 id="application-abstractapplication">Abstract Class Phalcon\Application\AbstractApplication</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Application/AbstractApplication.zep)

| Namespace | Phalcon\Application | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Extends | Injectable | | Implements | EventsAwareInterface |

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## Propiedades

```php
/**
 * @var DiInterface
 */
protected container;

/**
 * @var string
 */
protected defaultModule;

/**
 * @var null | ManagerInterface
 */
protected eventsManager;

/**
 * @var array
 */
protected modules;

```

## Métodos

Phalcon\AbstractApplication constructor

```php
public function __construct( DiInterface $container = null );
```

Returns the default module name

```php
public function getDefaultModule(): string;
```

Devuelve el administrador de eventos interno

```php
public function getEventsManager(): ManagerInterface;
```

Gets the module definition registered in the application via module name

```php
public function getModule( string $name ): array | object;
```

Return the modules registered in the application

```php
public function getModules(): array;
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
public function registerModules( array $modules, bool $merge = bool ): AbstractApplication;
```

Sets the module name to be used if the router doesn't return a valid module

```php
public function setDefaultModule( string $defaultModule ): AbstractApplication;
```

Establece el administrador de eventos

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

<h1 id="application-exception">Class Phalcon\Application\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Application/Exception.zep)

| Namespace | Phalcon\Application | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Application class will use this class