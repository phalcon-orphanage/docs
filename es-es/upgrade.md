---
layout: default
language: 'es-es'
version: '4.0'
---
# Upgrade Guide

* * *

# Upgrading to v4

So you have decided to upgrade to v4! **Congratulations**!!

Phalcon v4 contains a lot of changes to components, including changes to interfaces, strict types, removal of components and additions of new ones. This document is an effort to help you upgrade your existing Phalcon application to v4. We will outline the areas that you need to pay attention to and make necessary alterations so that your code can run as smoothly as it has been with v3. Although the changes are significant, it is more of a methodical task than a daunting one.

<a name='requirements'></a>

## Requerimentos

### PHP 7.2

Phalcon v4 supports only PHP 7.2 and above. PHP 7.1 was released 2 years ago and its [active support](https://secure.php.net/supported-versions.php) has lapsed, so we decided to follow actively supported PHP versions.

<a name='psr'></a>

### PSR

Phalcon requires the PSR extension. The extension can be downloaded and compiled from [this](https://github.com/jbboehr/php-psr) GitHub repository. Installation instructions are available in the `README` of the repository. Once the extension has been compiled and is available in your system, you will need to load it to your `php.ini`. You will need to add this line:

```ini
extension=psr.so
```

before

```ini
extension=phalcon.so
```

Alternatively some distributions add a number prefix on `ini` files. If that is the case, choose a high number for Phalcon (e.g. `50-phalcon.ini`).

<a name='installation'></a>

### Instalación

Download the latest `zephir.phar` from [here](https://github.com/phalcon/zephir/releases). Add it to a folder that can be accessed by your system.

Clone the repository

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilar Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0-alpha1 ./
zephir fullclean
zephir build
```

Check the module

```bash
php -m | grep phalcon
```

* * *

<a name='acl'></a>

## ACL

> Status: **changes required**
> 
> Usage: [ACL Documentation](acl)
{: .alert .alert-info }

The [ACL](acl) component has had some methods and components renamed. The functionality remains the same as in previous versions.

### Overview

The components needed for the ACL to work have been renamed. In particular `Resource` has been renamed to `Component` in all relevant interfaces, classes and methods that this component uses.

### Changed

- Renamed `Phalcon\Acl\Resource` to `Phalcon\Acl\Component`
- Renamed `Phalcon\Acl\ResourceInterface` to `Phalcon\Acl\ComponentInterface`
- Renamed `Phalcon\Acl\ResourceAware` to `Phalcon\Acl\ComponentAware`
- Renamed `Phalcon\Acl\AdapterInterface::isResource` to `Phalcon\Acl\AdapterInterface::isComponent`
- Renamed `Phalcon\Acl\AdapterInterface::addResource` to `Phalcon\Acl\AdapterInterface::addComponent`
- Renamed `Phalcon\Acl\AdapterInterface::addResourceAccess` to `Phalcon\Acl\AdapterInterface::addComponentAccess`
- Renamed `Phalcon\Acl\AdapterInterface::dropResourceAccess` to `Phalcon\Acl\AdapterInterface::dropComponentAccess`
- Renamed `Phalcon\Acl\AdapterInterface::getActiveResource` to `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Renamed `Phalcon\Acl\AdapterInterface::getResources` to `Phalcon\Acl\AdapterInterface::getComponents`
- Renamed `Phalcon\Acl\Adapter::getActiveResource` to `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Renamed `Phalcon\Acl\Adapter\Memory::isResource` to `Phalcon\Acl\Adapter\Memory::isComponent`
- Renamed `Phalcon\Acl\Adapter\Memory::addResource` to `Phalcon\Acl\Adapter\Memory::addComponent`
- Renamed `Phalcon\Acl\Adapter\Memory::addResourceAccess` to `Phalcon\Acl\Adapter\Memory::addComponentAccess`
- Renamed `Phalcon\Acl\Adapter\Memory::dropResourceAccess` to `Phalcon\Acl\Adapter\Memory::dropComponentAccess`
- Renamed `Phalcon\Acl\Adapter\Memory::getResources` to `Phalcon\Acl\Adapter\Memory::getComponents`

* * *

<a name='cli'></a>

## CLI

> Status: **changes required**
> 
> Usage: [CLI Documentation](cli)
{: .alert .alert-info }

### Parameters

Parameters now behave the same way as MVC controllers. Whilst previously they all existed in the `$params` property, you can now name them appropriately:

```php
use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function testAction(string $yourName, string $myName)
    {
        echo sprintf(
            'Hello %s!' . PHP_EOL,
            $yourName
        );

        echo sprintf(
            'Best regards, %s' . PHP_EOL,
            $myName
        );
    }
}
```

* * *

<a name='filter'></a>

## Filtro

> Status: **changes required**
> 
> Usage: [Filter Documentation](filter)
{: .alert .alert-info }

The `Filter` component has been rewritten, utilizing a service locator. Each sanitizer is now enclosed on its own class and lazy loaded to provide maximum performance and the lowest resource usage as possible.

### Overview

The `Phalcon\Filter` object has been removed from the framework. In its place we have two components that can help with sanitizing input.

The equivalent of the v3 `Phalcon\Filter` is now the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) object. This object allows you to sanitize input as before using the `sanitize()` method.

The values sanitized are automatically cast to the relevant types. This is the default behavior for the `int`, `bool` and `float` filters.

When instantiating the locator object, it does not know about any sanitizers. You have two options:

#### Load all the default sanitizers

You can load all the Phalcon supplied sanitizers by utilizing the [Phalcon\Filter\FilterLocatorFactory](Phalcon_Filter_FilterLocatorFactory) component.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();
```

Calling`newInstance()` will return a [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) object with all the sanitizers registered. The sanitizers are lazy loaded so they are instantiated only when called from the locator.

#### Load only sanitizers you want

You can instantiate the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) component and either use the `set()` method to set all the sanitizers you need, or pass an array in the constructor with the sanitizers you want to register.

### Using the `FactoryDefault`

If you use the [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) container, then the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) is automatically loaded in the container. You can then continue to use the service in your controllers or components as you did before. The name of the service in the Di is `filter`, just as before.

Also components that utilize the filter service, such as the [Request](api/Phalcon_Http_Request) object, transparently use the new filter locator. No additional changes required for those components.

### Using a custom `Di`

If you have set up all the services in the [Phalcon\Di](api/Phalcon_Di) yourself and need the filter service, you will need to change its registration as follows:

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterLocatorFactory;

$container = new Di();

$container->set(
    'filter',
    function () {
        $factory = new FilterLocatorFactory();
        return $factory->newInstance();
    }
);
```

> Note that even if you register the filter service manually, the **name** of the service must be **filter** so that other components can use it
{: .alert .alert-warning }

### Constantes

The constants that the v3 `Phalcon\Filter` have somewhat changed. They are now located in the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) class.

#### Removed

- `FILTER_INT_CAST` (`int!`)
- `FILTER_FLOAT_CAST` (`float!`)

By default the service sanitizers cast the value to the appropriate type so these are obsolete

- `FILTER_APHANUM` has been removed - replaced by `FILTER_ALNUM`

#### Changed

- `FILTER_SPECIAL_CHARS` has changed been removed - replaced by `FILTER_SPECIAL`

#### Added

- `FILTER_ALNUM` - replaced `FILTER_ALPHANUM`
- `FILTER_ALPHA` - sanitize only alpha characters
- `FILTER_BOOL` - sanitize boolean including "yes", "no", etc.
- `FILTER_LOWERFIRST` - sanitze using `lcfirst`
- `FILTER_REGEX` - sanitize based on a pattern (`preg_replace`)
- `FILTER_REMOVE` - sanitize by removing characters (`str_replace`)
- `FILTER_REPLACE` - sanitize by replacing characters (`str_replace`)
- `FILTER_SPECIAL` - replaced `FILTER_SPECIAL_CHARS`
- `FILTER_SPECIALFULL` - sanitize special chars (`filter_var`)
- `FILTER_UPPERFIRST` - sanitize using `ucfirst`
- `FILTER_UPPERWORDS` - sanitize using `ucwords`

* * *

<a name='logger'></a>

## Logger

> Status: **changes required**
> 
> Usage: [Logger Documentation](logger)
{: .alert .alert-info }

The `Logger` component has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). de tal manera que se puede utilizar con cualquier aplicación que necesite un componente de registro compatible con [PSR-3](https://www.php-fig.org/psr/psr-3/) --incluso sin estar basada en Phalcon.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.

### Creating a logger component

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Algo falló');
```

Registering it in the DI

```php
<?php

use Phalcon\Di;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new Di();

$container->set(
    'logger',
    function () {
        $adapter = new Stream('/logs/application.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return $logger;
    }
);
```

### Multiple loggers

The `Phalcon\Logger\Multiple` component has been removed. You can achieve the same functionality using the logger component and registering more than one adapter:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

* * *

<a name='models'></a>

## Models

> Status: **changes required**
> 
> Usage: [Models Documentation](db-models)
{: .alert .alert-info }

### Initialization

The `getSource()` method has been marked as `final`. As such you can no longer override this method in your model to set the corresponding table/source of the RDBMS. Instead, you can now use the `initialize()` method and `setSource()` to set the source of your model.

```php
<?php

use Phalcon\Mvc\Model;

class Users
{
    public function initialize()
    {
        $this->setSource('Users');
        // ....
    }
}
```