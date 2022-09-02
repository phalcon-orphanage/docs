---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Application'
---

* [Phalcon\Application\AbstractApplication](#application-abstractapplication)
* [Phalcon\Application\Exception](#application-exception)

<h1 id="application-abstractapplication">Abstract Class Phalcon\Application\AbstractApplication</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Application/AbstractApplication.zep)

| Namespace | Phalcon\Application | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Extends | Injectable | | Implements | EventsAwareInterface |

Clase base para Phalcon\Cli\Console y Phalcon\Mvc\Application.

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

```php
public function __construct( DiInterface $container = null );
```

Constructor Phalcon\AbstractApplication

```php
public function getDefaultModule(): string;
```

Devuelve el nombre de módulo por defecto

```php
public function getEventsManager(): ManagerInterface;
```

Devuelve el administrador de eventos interno

```php
public function getModule( string $name ): array | object;
```

Obtiene la definición de módulo registrada en la aplicación a través del nombre del módulo

```php
public function getModules(): array;
```

Devuelve los módulos registrados en la aplicación

```php
public function registerModules( array $modules, bool $merge = bool ): AbstractApplication;
```

Registra un vector de módulos presente en la aplicación

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

Establece el nombre del módulo que se utilizará si el router no devuelve un módulo válido

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

<h1 id="application-exception">Class Phalcon\Application\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Application/Exception.zep)

| Namespace | Phalcon\Application | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en la clase Phalcon\Application usarán esta clase
