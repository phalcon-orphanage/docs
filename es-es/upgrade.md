---
layout: default
language: 'es-es'
version: '4.0'
title: 'Guía de Actualización'
keywords: 'upgrade, v3, v4'
---

# Guía de Actualización

* * *

# Actualizando a V4

Así que ha decidido hacer la actualización a v4, **¡felicitaciones!**

Phalcon v4 trae muchos cambios en los componentes, interfaces, tipos estrictos, adición y eliminación de componentes. El objetivo de esta guía es ayudarle a actualizar una aplicación existente en Phalcon a la v4. Se delinearán las áreas en las cuales se debe poner atención para hacer los cambios necesarios, de tal manera que el código se siga ejecutando con la misma armonía que en v3. A pesar de que los cambios son considerables, la tarea de actualización será más metódica que abrumadora.

## Requerimentos

### PHP 7.2

Phalcon v4 soporta sólo PHP 7.2 y superiores. PHP 7.1 fue publicado hace años y su período de [soporte activo](https://secure.php.net/supported-versions.php) terminó en diciembre de 2019; Phalcon seguirá trabajando solo con versiones de PHP activas.

<a name='psr'></a>

### PSR (Recomendaciones Estándar de PHP)

Phalcon requiere la extensión PSR. La extensión se puede descargar y compilar desde [este repositorio de GitHub](https://github.com/jbboehr/php-psr). Las instrucciones de instalación están disponibles en el archivo `README` del repositorio. Una vez que la extensión haya sido compilada y esté disponible en su sistema, necesitará cargarla a su `php.ini`. Necesitarás añadir esta línea:

```ini
extension=psr.so
```

antes

```ini
extension=phalcon.so
```

Alternativamente algunas distribuciones añaden un prefijo numérico en los archivos `ini`. Si ese es el caso, elija un número alto para Phalcon (por ejemplo `50-phalcon.ini`).

### Instalación

Descarga la última `zephir.phar` desde [aquí](https://github.com/phalcon/zephir/releases). Añada a una carpeta a la que puede acceder su sistema.

Clonar el repositorio

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilación de Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Comprueba el módulo

```bash
php -m | grep phalcon
```

* * *

## Notas generales

### Aplicaciones

- `Phalcon\Mvc\Application`, `Phalcon\Mvc\Micro` y `Phalcon\Mvc\Router` ahora deben tener una URI para procesar

### Excepciones

- `Exception` se a cambiado por `Throwable`

* * *

# Componentes

## ACL

> Estado: **cambios requeridos**
> 
> Uso: [Documentación ACL](acl)
{: .alert .alert-info }

En componente [ACL](acl) se le ha cambiado el nombre a algunos métodos y componentes. La funcionalidad sigue siendo la misma que en versiones anteriores.

### Controladores

Los componentes necesarios para trabajar con ACL han sido renombrados. En particular `Resource` ha sido renombrado a `Component` en todas las interfaces, clases y métodos relevantes que utiliza este componente.

- Añadido `Phalcon\Acl\Adapter\AbstractAdapter`
- Añadido `Acl\Enum`

- Eliminado `Phalcon\Acl`

- Eliminado `Phalcon\Acl\Adapter`

- Renombrado `Phalcon\Acl\Resource` a `Phalcon\Acl\Component`

- Renombrado `Phalcon\Acl\ResourceInterface` a `Phalcon\Acl\ComponentInterface`
- Renombrado `Phalcon\Acl\ResourceAware` a `Phalcon\Acl\ComponentAware`
- Renombrado `Phalcon\Acl\AdapterInterface::isResource` a `Phalcon\Acl\AdapterInterface::isComponent`
- Renombrado `Phalcon\Acl\AdapterInterface::addResource` a `Phalcon\Acl\AdapterInterface::addComponent`
- Renombrado `Phalcon\Acl\AdapterInterface::addResourceAccess` a `Phalcon\Acl\AdapterInterface::addComponentAccess`
- Renombrado `Phalcon\Acl\AdapterInterface::dropResourceAccess` a `Phalcon\Acl\AdapterInterface::dropComponentAccess`
- Renombrado `Phalcon\Acl\AdapterInterface::getActiveResource` a `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Renombrado `Phalcon\Acl\AdapterInterface::getResources` a `Phalcon\Acl\AdapterInterface::getComponents`
- Renombrado `Phalcon\Acl\Adapter::getActiveResource` a `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Renombrado `Phalcon\Acl\Adapter\Memory::isResource` a `Phalcon\Acl\Adapter\Memory::isComponent`
- Renombrado `Phalcon\Acl\Adapter\Memory::addResource` a `Phalcon\Acl\Adapter\Memory::addComponent`
- Renombrado `Phalcon\Acl\Adapter\Memory::addResourceAccess` a `Phalcon\Acl\Adapter\Memory::addComponentAccess`
- Renombrado `Phalcon\Acl\Adapter\Memory::dropResourceAccess` a `Phalcon\Acl\Adapter\Memory::dropComponentAccess`
- Renombrado `Phalcon\Acl\Adapter\Memory::getResources` a `Phalcon\Acl\Adapter\Memory::getComponents`

### Acl\Adapter\Memory

- Añadido `getActiveKey`, `activeFunctionCustomArgumentsCount` y `getActiveFunction` para obtener la última clave, número de argumentos personalizados y la función usada para adquirir el acceso
- Añadido soporte a `addOpertion` para múltiples heredados

### Acl\Enum (Constantes)

Ejemplo:

```php
use Phalcon\Acl\Enum;

echo Enum::ALLOW; //imprime 1
echo Enum::DENY;  //imprime 0

```

* * *

## Recursos Activos

> Estado: **cambios requeridos**
> 
> Uso: [Documención de Assets](assets)
{: .alert .alert-info }

Los filtros CSS y JS se han eliminado del componente [Assets](assets). Debido a limitaciones de licencia, se han eliminado los minizadores de CSS y JS (filtros) para la v4. En futuras versiones con la ayuda de la comunidad podemos volver a introducir estos filtros. Usted siempre puede implementar los suyos propios implementando `Phalcon\Assets\FilterInterface`.

- Eliminado `Phalcon\Assets\Filters\CssMin`
- Eliminado `Phalcon\Assets\Filters\JsMin`
- Renombrado `Phalcon\Assets\Resource` a `Phalcon\Assets\Asset`
- Renombrado `Phalcon\Assets\ResourceInterface` a `Phalcon\Assets\AssetInterface`
- Renombrado `Phalcon\Assets\Manager::addResource` a `Phalcon\Assets\Manager::addAsset`
- Renombrado `Phalcon\Assets\Manager::addResourceByType` a `Phalcon\Assets\Manager::addAssetByType`
- Renombrado `Phalcon\Assets\Manager::collectionResourcesByType` a `Phalcon\Assets\Manager::collectionAssetsByType`

* * *

## Cache

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Cache](cache)
{: .alert .alert-info }

Los adaptadores `xcache`, `apc` y `memcache` han sido deprecados y eliminados. Los dos primeros no soportan PHP 7.2+. `apc` ha sido reemplazado por `apcu` y `memcache` puede ser reemplazado por el `libmemcached`.

- Eliminado `Phalcon\Annotations\Adapter\Apc`
- Eliminado `Phalcon\Annotations\Adapter\Xcache`
- Eliminado `Phalcon\Cache\Backend\Apc`
- Eliminado `Phalcon\Cache\Backend\Memcache`
- Eliminado `Phalcon\Cache\Backend\Xcache`
- Eliminado `Phalcon\Mvc\Model\Metadata\Apc`
- Eliminado `Phalcon\Mvc\Model\Metadata\Memcache`
- Eliminado `Phalcon\Mvc\Model\Metadata\Xcache`

El componente `Cache` ha sido reescrito para cumplir con el [PSR-16](https://www.php-fig.org/psr/psr-16/). Esto permite que se utilice [Phalcon\Cache](api/Phalcon_Cache) en cualquier aplicación que utilice [PSR-16](https://www.php-fig.org/psr/psr-16/), no solo en aplicaciones basadas en Phalcon.

En la v3, la caché se dividió en dos componentes, el Frontend y el Backend. Esto creó un poco de confusión, pero era funcional. Para crear un componente de caché primero tenías que crear el Frontend y luego inyectarlo al Backend correspondiente (que actuaba como adaptador también).

Ahora en la v4, hemos reescrito el componente completamente. Primero creamos una clase `Storage` que es la base de las clases de caché. Creamos clases Serializer cuya única responsabilidad es serializar y desserializar los datos antes de guardarlos en el adaptador de caché y después de recuperarlos. Estas clases son inyectadas (basadas en la elección del desarrollador) a un objeto Adapter que se conecta a un backend (`Memcached`, `Redis` etc.), mientras cumple con una interfaz común de adaptador.

La clase Cache implementa [PSR-16](https://www.php-fig.org/psr/psr-16/) y acepta un adaptador en su constructor, que a su vez está haciendo todo el trabajo pesado con la conexión al almacenamiento y la manipulación de datos.

Para una explicación más detallada sobre cómo funciona el nuevo componente de Caché, por favor visite la página correspondiente en nuestra documentación.

### Creando un Cache

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\Serializer\SerializerFactory;

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory($serializerFactory);

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200
];

$adapter = $adapterFactory->newInstance('apcu', $options);

$cache = new Cache($adapter);
```

Registrándolo en el DI

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\Serializer\SerializerFactory;

$container = new Di();

$container->set(
    'cache',
    function () {
        $options = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200
        ];

        $adapter = (new AdapterFactory(new SerializerFactory()))
                    ->newInstance('apcu', $options); 

        return new Cache($adapter);
    }
);
```

* * *

## CLI

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de CLI](cli)
{: .alert .alert-info }

### Parámetros

Los parámetros ahora se comportan de la misma manera que los controladores MVC. Mientras que anteriormente todos existían en la propiedad `$params`, ahora puede nombrarlos apropiadamente:

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

### Cli\Console

- Eliminado `Phalcon\Cli\Console::addModules` a favor de `Phalcon\Cli\Console::registerModules`

### Cli\Router\RouteInterface

- Añadido `delimiter`, `getDelimiter`

### Cli\Dispatcher

- Añadido `getTaskSuffix()`, `setTaskSuffix()`

### Cli\DispatcherInterface

- Añadido `setOptions`, `getOptions`

* * *

## Container

- Añadido `Phalcon\Container`, una clase proxy del `Phalcon\DI` implementando PSR-11

* * *

## Depuración

- Eliminado `Phalcon\Debug::getMajorVersion`

* * *

## Db

- Se añadió el ajuste global `orm.case_insensitive_column_map` para intentar encontrar el valor, en el mapa de columnas, siendo insensiblemente mayúsculas. También se puede activar configurando la clave `caseInsensitiveColumnMap` en `\Phalcon\Mvc\Model::setup()`
- Eliminado el espacio de nombres `Phalcon\Db`. Reemplazado por `Phalcon\Db\AbstractDb` para los métodos necesarios y `Phalcon\Db\Enum` para las constantes, por ejemplo:

```php
use Phalcon\Db\Enum;

echo Enum::FETCH_ASSOC;
```

### Db\AdapterInterface

- Añadido fetchColumn, insertAsDict, updateAsDict

### Db\Adapter\Pdo

- Se han añadido más tipos de columnas para el adaptador Mysql. Soporte para adaptadores -`TYPE_BIGINTEGER` 
    - `TYPE_BIT`
    - `TYPE_BLOB`
    - `TYPE_BOOLEAN`
    - `TYPE_CHAR`
    - `TYPE_DATE`
    - `TYPE_DATETIME`
    - `TYPE_DECIMAL`
    - `TYPE_DOUBLE`
    - `TYPE_ENUM`
    - `TYPE_FLOAT`
    - `TYPE_INTEGER`
    - `TYPE_JSON`
    - `TYPE_JSONB`
    - `TYPE_LONGBLOB`
    - `TYPE_LONGTEXT`
    - `TYPE_MEDIUMBLOB`
    - `TYPE_MEDIUMINTEGER`
    - `TYPE_MEDIUMTEXT`
    - `TYPE_SMALLINTEGER`
    - `TYPE_TEXT`
    - `TYPE_TIME`
    - `TYPE_TIMESTAMP`
    - `TYPE_TINYBLOB`
    - `TYPE_TINYINTEGER`
    - `TYPE_TINYTEXT`
    - `TYPE_VARCHAR` Algunos adaptadores no soportan ciertos tipos. Por ejemplo, `JSON` no es compatible con `Sqlite`. Se cambiará automáticamente a `VARCHAR`.

### Db\DialectInterface

- Añadido `registerCustomFunction`, `getCustomFunctions`, `getSqlExpression`

### Db\Dialect\Postgresql

- Se modificó addPrimaryKey para hacer que los nombres de restricciones de clave primaria sean únicos prefijándolos con el nombre de la tabla.

* * *

## DI

### Di\ServiceInterface

- Añadido getParameter, isResolved

### Di\Service

- Se cambió el constructor de Phalcon\Di\Service para que deje de tomar el nombre del servicio.

* * *

## Dispatcher

- Eliminado `Phalcon\Dispatcher::setModelBinding()` a favor de `Phalcon\Dispatcher::setModelBinder()`
- Added `getHandlerSuffix()`, `setHandlerSuffix()`

* * *

## Eventos

### Events\ManagerInterface

- Añadido `hasListeners`

* * *

## Flash

- Se ha añadido la capacidad de establecer una plantilla personalizada para el mensajero Flash.
- El constructor ya no acepta un array para las clases CSS. Se necesitará usar `setCssClasses()` para establecer tus clases CSS personalizadas para el componente
- El constructor ahora acepta un objeto opcional `Phalcon\Escaper`, así como un objeto `Phalcon\Session\Manager` (en el caso de `Phalcon\Flash\Session`), en caso de que no desee utilizar el DI y establecerlo usted mismo.

* * *

## Filtro

> Estado: **cambios requeridos**
> 
> Usage: [Filter Documentation](filter)
{: .alert .alert-info }

The `Filter` component has been rewritten, utilizing a service locator. Each sanitizer is now enclosed on its own class and lazy loaded to provide maximum performance and the lowest resource usage as possible.

### Controladores

The `Phalcon\Filter` object has been rewritten to act as a service locator for different *sanitizers*. This object allows you to sanitize input as before using the `sanitize()` method.

The values sanitized are automatically cast to the relevant types. This is the default behavior for the `int`, `bool` and `float` filters.

When instantiating the filter object, it does not know about any sanitizers. You have two options:

#### Load All the Default Sanitizers

You can load all the Phalcon supplied sanitizers by utilizing the [Phalcon\Filter\FilterFactory](api/Phalcon_Filter#filter-filterfactory) component.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();
$locator = $factory->newInstance();
```

Calling`newInstance()` will return a [Phalcon\Filter](api/Phalcon_Filter#filter) object with all the sanitizers registered. The sanitizers are lazy loaded so they are instantiated only when called from the locator.

#### Load Only Sanitizers You Want

You can instantiate the [Phalcon\Filter](api/Phalcon_Filter#filter) component and either use the `set()` method to set all the sanitizers you need, or pass an array in the constructor with the sanitizers you want to register.

### Using the `FactoryDefault`

If you use the [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) container, then the [Phalcon\Filter](api/Phalcon_Filter#filter) is automatically loaded in the container. You can then continue to use the service in your controllers or components as you did before. The name of the service in the Di is `filter`, just as before.

Also components that utilize the filter service, such as the [Request](api/phalcon_http#http-request) object, transparently use the new filter locator. No additional changes required for those components.

### Using a Custom `Di`

If you have set up all the services in the [Phalcon\Di](api/Phalcon_Di) yourself and need the filter service, you will need to change its registration as follows:

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterFactory;

$container = new Di();

$container->set(
    'filter',
    function () {
        $factory = new FilterFactory();
        return $factory->newInstance();
    }
);
```

> **NOTE**: Note that even if you register the filter service manually, the **name** of the service must be **filter** so that other components can use it
{: .alert .alert-warning }

### Constantes

The constants that the v3 `Phalcon\Filter` have somewhat changed.

#### Removed

- `FILTER_INT_CAST` (`int!`)
- `FILTER_FLOAT_CAST` (`float!`)

By default the service sanitizers cast the value to the appropriate type so these are obsolete

- `FILTER_APHANUM` has been removed - replaced by `FILTER_ALNUM`

#### Changed

- `FILTER_SPECIAL_CHARS` has changed been removed - replaced by `FILTER_SPECIAL`
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

## Formularios

### Forms\Form

- `Phalcon\Forms\Form::clear` will no longer call `Phalcon\Forms\Element::clear`, instead it will clear/set default value itself, and `Phalcon\Forms\Element::clear` will now call `Phalcon\Forms\Form::clear` if it’s assigned to the form, otherwise it will just clear itself.
- `Phalcon\Forms\Form::getValue` will now also try to get the value by calling `Tag::getValue` or element’s `getDefault` method before returning `null`, and `Phalcon\Forms\Element::getValue` calls `Tag::getDefault` only if it’s not added to the form.

* * *

## Html

### Html\Breadcrumbs

- Added `Phalcon\Html\Breadcrumbs`, a component that creates HTML code for breadcrumbs.

### Html\Tag

- Added `Phalcon\Html\Tag`, a component that creates HTML elements. It will replace `Phalcon\Tag` in a future version. This component does not use static method calls.

### Http\RequestInterface

- Removed `isSecureRequest` in favor of `isSecure`
- Removed `isSoapRequested` in favor of `isSoap`

### Http\Response

- Added `hasHeader()` method to `Phalcon\Http\Response` to provide the ability to check if a header exists.
- Added `Phalcon\Http\Response\Cookies::getCookies`
- Changed `setHeaders` now merges the headers with any pre-existing ones in the internal collection
- Added two new events `response::beforeSendHeaders` and `response::afterSendHeaders`

* * *

## Imágenes

- Added `Phalcon\Image\Enum`
- Renamed `Phalcon\Image\Adapter` to `Phalcon\Image\Adapter\AbstractAdapter`
- Renamed `Phalcon\Image\Factory` to `Phalcon\Image\ImageFactory`
- Removed `Phalcon\Image`

## Image\Enum (Constants)

Ejemplo:

```php
<?php

use Phalcon\Image\Enum;

// Resizing constraints
echo Enum::AUTO;    // prints 4
echo Enum::HEIGHT;  // prints  3
echo Enum::INVERSE; // prints  5
echo Enum::NONE;   // prints  1
echo Enum::PRECISE; // prints  6
echo Enum::TENSILE; // prints  7
echo Enum::WIDTH;   // prints  2

// Flipping directions
echo Enum::HORIZONTAL; // prints  11
echo Enum::VERTICAL;   // prints  12
```

* * *

## Logger

> Estado: **cambios requeridos**
> 
> Usage: [Logger Documentation](logger)
{: .alert .alert-info }

The `Logger` component has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). This allows you to use the [Phalcon\Logger](api/Phalcon_Logger) to any application that utilizes a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.

### Creating a Logger Component

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

Registrándolo en el DI

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

### Multiple Loggers

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
$logger->error('Algo falló');
```

* * *

## Messages

- `Phalcon\Messages\Message` and its collection `Phalcon\Messages\Messages` are new components that handle messages for models and validation. In the past we had two components, one for validation and one for models. We have merged these two, so you should be getting back a `MessageInterface[]` back when calling `save` on a model or when retrieving validation messages. 
    - Changed `Phalcon\Mvc\Model` to use the `Phalcon\Messages\Message` object for its messages
    - Changed `Phalcon\Validation\*` to use the `Phalcon\Messages\Message` object for its messages

* * *

### Transacciones

Removed in version 4.0: - Removed `$logger->begin()` - Removed `$logger->commit()`

### Log Level

- Removed `$logger->setLogLevel()`

## Modelos

> Estado: **cambios requeridos**
> 
> Usage: [Models Documentation](db-models)
{: .alert .alert-info }

- You can no longer assign data to models while saving them

### Inicialización

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

### Save

The `save()` method no longer accepts parameters to set data. You can use `assign` instead.

### Criteria

The second parameter of `Criteria::limit()` ('offset') must now be an integer or null. Previously there was no type requirement.

```php
$criteria->limit(10);

$criteria->limit(10, 5);

$criteria->limit(10, null);
```

* * *

## MVC

> Estado: **cambios requeridos**
> 
> Usage: [MVC Documentation](mvc)
{: .alert .alert-info }

### Mvc\Collection

- Removed `Phalcon\Mvc\Collection::validationHasFailed`
- Removed calling `Phalcon\Mvc\Collection::validate` with object of type `Phalcon\Mvc\Model\ValidatorInterface`

### Mvc\Micro\Lazyloader

- Removed `__call` in favor of `callMethod`

### Mvc\Model

- Removed `Phalcon\Model::reset`
- Added `isRelationshipLoaded` to check if relationship is loaded
- Changed `Phalcon\Model::assign` parameters order to $data, $whiteList, $dataColumnMap
- Changed `Phalcon\Model::findFirst` to return `null` instead of `false` if no record was found
- Changed `Phalcon\Model::getRelated()` to return `null` for one to one relationships if no record was found

### Mvc\Model\Criteria

- Removed `addWhere`
- Removed `order`
- Removed `order` in favor of `orderBy`

### Mvc\Model\CriteriaInterface

- Added `distinct`, `leftJoin`, `innerJoin`, `rightJoin`, `groupBy`, `having`, `cache`, `getColumns`, `getGroupBy`, `getHaving`

### Mvc\Model\Manager

- `Load` no longer reuses already initialized models
- Removed `Phalcon\Model\Manager::registerNamespaceAlias()`
- Removed `Phalcon\Model\Manager::getNamespaceAlias()`
- Removed `Phalcon\Model\Manager::getNamespaceAliases()`
- The signature of `Phalcon\Mvc\Model\Manager::getRelationRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getBelongsToRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getHasOneRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getHasManyRecords()` has changed

### Mvc\Model\ManagerInterface

- Added `isVisibleModelProperty`, `keepSnapshots`, `isKeepingSnapshots`, `useDynamicUpdate`, `isUsingDynamicUpdate`, `addHasManyToMany`, `existsHasManyToMany`, `getRelationRecords`, `getHasManyToMany`
- Removed `Phalcon\Model\ManagerInterface::getNamespaceAlias()`
- Removed `Phalcon\Model\ManagerInterface::registerNamespaceAlias()`

### Mvc\Model\MessageInterface

- Added `setModel`, `getModel`, `setCode`, `getCode`

### Mvc\Model\QueryInterface

- Added `getSingleResult`, `setBindParams`, `getBindParams`, `setBindTypes`, `setSharedLock`, `getBindTypes`, `getSql`

### Mvc\Model\Query\BuilderInterface

- Added `offset`

### Mvc\Model\Query\Builder

- Added bind support. The Query Builder has the same methods as `Phalcon\Mvc\Model\Query`; `getBindParams`, `setBindParams`, `getBindTypes` and `setBindTypes`.
- Changed `addFrom` to remove third parameter `$with`

### Mvc\Model\Query\BuilderInterface

- Added `distinct`, `getDistinct`, `forUpdate`, `offset`, `getOffset`

### Mvc\Model\RelationInterface

- Added `getParams`

### Mvc\Model\ResultsetInterface

- Added `setHydrateMode`, `getHydrateMode`, `getMessages`, `update`, `delete`, `filter`

### Mvc\Model\Transaction\ManagerInterface

- Added `setDbService`, `getDbService`, `setRollbackPendent`, `getRollbackPendent`

### Mvc\Model\Validator*

- Removed `Phalcon\Mvc\Model\Validator\*` in favor of `Phalcon\Validation\Validator\*`

### Mvc\ModelInterface

- Added `getModelsMetaData`

### Mvc\Router

- Removed `getRewriteUri()`. The URI needs to be passed in the `handle` method of the application object.

### Mvc\RouterInterface

- Added `attach`

### Mvc\Router\RouteInterface

- Added `convert` so that calling `add` will return an instance that has `convert` method

### Mvc\Router\RouteInterface

- Added response handler to `Phalcon\Mvc\Micro`, `Phalcon\Mvc\Micro::setResponseHandler`, to allow use of a custom response handler.

### Mvc\User

- Removed `Phalcon\Mvc\User\Component` - use `Phalcon\Di\Injectable` instead
- Removed `Phalcon\Mvc\User\Module` - use `Phalcon\Di\Injectable` instead
- Removed `Phalcon\Mvc\User\Plugin` - use `Phalcon\Di\Injectable` instead

### Mvc\View\Engine\Volt

The options for Volt have changed (the key names). Using the old syntax will produce a deprecation warning. The new options are:

- `always` - Always compile
- `extension` - Extension of files
- `separator` - Separator (used for the folders/routes)
- `stat` - Stat each file before trying to use it
- `path` - The path of the files
- `prefix` - The prefix of the files

* * *

## Paginator

- `getPaginate` now becomes `paginate`
- `$before` is removed and replaced with `$previous`
- `$total_pages` is removed since it contained the same information as `$last`
- Added `Phalcon\Paginator\RepositoryInterface` for repository the current state of `paginator` and also optional sets the aliases for properties repository

## Router

- Removed `getRewriteUri()`. The URI needs to be passed in the `handle` method of the application object.
- You can add `CONNECT`, `PURGE`, `TRACE` routes to the Router Group. They function the same as they do in the normal Router:

```php
use Phalcon\Mvc\Router\Group;

$group = new Group();

$group->addConnect(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'connect',
    ]
);

$group->addPurge(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'purge',
    ]
);

$group->addTrace(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'trace',
    ]
);
```

* * *

## Seguridad

- Removed `hasLibreSsl`
- Removed `getSslVersionNumber`
- Added `setPadding`
- Added a retainer for the current token to be used during the checks, so when `getToken` is called the token used for checks does not change

* * *

## Consulta

### Http\Request

- Added `numFiles` returning `long` - the number of files present in the request
- Changed `hasFiles` to return `bool` - if the request has files or not

### Http\RequestInterface

- Added `numFiles` returning `long` - the number of files present in the request
- Changed `hasFiles` to return `bool` - if the request has files or not

* * *

## Session

> Estado: **cambios requeridos**
> 
> Usage: [Session Documentation](session)
{: .alert .alert-info }

`Session` and `Session\Bag` no longer get loaded by default in `Phalcon\DI\FactoryDefault`. Session was refactored.

- Added `Phalcon\Session\Adapter\AbstractAdapter`
- Added `Phalcon\Session\Adapter\Noop`
- Added `Phalcon\Session\Adapter\Stream`
- Added `Phalcon\Session\Manager`
- Added `Phalcon\Session\ManagerInterface`
- Removed `Phalcon\Session\Adapter` - replaced by `Phalcon\Session\Adapter\AbstractAdapter`
- Removed `Phalcon\Session\AdapterInterface` - replaced by native `SessionHandlerInterface`
- Removed `Phalcon\Session\Adapter\Files` - replaced by `Phalcon\Session\Adapter\Stream`
- Removed `Phalcon\Session\Adapter\Memcache`
- Removed `Phalcon\Session\BagInterface`
- Removed `Phalcon\Session\Factory`

### Session\Adapter

Each adapter implements PHP's `SessionHandlerInterface`. Available adapters are:

- `Phalcon\Session\Adapter\AbstractAdapter`
- `Phalcon\Session\Adapter\Libmemcached`
- `Phalcon\Session\Adapter\Noop`
- `Phalcon\Session\Adapter\Redis`
- `Phalcon\Session\Adapter\Stream`

### Session\Manager

- Now is the single component that offers session manipulation by using adapters (see above). Each adapter implements PHP's `SessionHandlerInterface`
- Developers can add any adapter that implements `SessionHandlerInterface`

* * *

## Tag

- Added `renderTitle()` that renders the title enclosed in `<title>` tags.
- Changed `getTitle`. It returns only the text. It accepts `prepend`, `append` booleans to prepend or append the relevant text to the title.
- Changed `textArea` to use `htmlspecialchars` to prevent XSS injection.

* * *

## Text

> Estado: **cambios requeridos**
> 
> Usage: [Str Documentation](helpers#str)
{: .alert .alert-info }

The `Phalcon\Text` component has been removed in favor of the `Phalcon\Helper\Str`. The functionality offered by `Phalcon\Text` in v3 is replicated and enhanced in the new class: `Phalcon\Helper\Str`.

* * *

## Validación

### Validation\Message

- Removed `Phalcon\Validation\Message` and `Phalcon\Mvc\Model\Message` in favor of `Phalcon\Messages\Message`
- Removed `Phalcon\Validation\MessageInterface` and `Phalcon\Mvc\Model\MessageInterface` in favor of `Phalcon\Messages\MessageInterface`
- Removed `Phalcon\Validation\Message\Group` in favor of `Phalcon\Messages\Messages`
- Validator messages have been moved inside each validator

### Validation\Validator

- Removed `isSetOption`

### Validation\Validator\Ip

- Added `Phalcon\Validation\Validator\Ip`, class used to validate ip address fields. It allows to validate a field selecting IPv4 or IPv6, allowing private or reserved ranges and empty values if necessary.

* * *

## Vistas

> Estado: **cambios requeridos**
> 
> Usage: [View Documentation](views)
{: .alert .alert-info }

View caching along with the `viewCache` service have been removed from the framework because they were incompatible with the new Cache component. Developers can easily utilize a *view cache* from external services such as Varnish, Cloudflare etc. Additionally, developers can cache fragments by either using the `Phalcon\Mvc\View\Simple::render()` or the `Phalcon\Mvc\View::toString()`. Those two methods return the produced HTML that can be cached in the cache backend of your choice.

* * *

## Url

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Url](url)
{: .alert .alert-info }

El componente `Phalcon\Mvc\Url` ha sido renombrado a `Phalcon\Url`. La funcionalidad sigue siendo la misma.

## Cheat Sheet

### Acl

| 3.4.x                  | Estado       | 4.0.x                                  |
| ---------------------- | ------------ | -------------------------------------- |
| Phalcon\Acl           | Removed      |                                        |
| Phalcon\Acl\Adapter  | Renombrado a | Phalcon\Acl\Adapter\AbstractAdapter |
| Phalcon\Acl\Resource | Renombrado a | Phalcon\Acl\Component                |
|                        | Nuevo        | Phalcon\Acl\Enum                     |

### Anotaciones

| 3.4.x                                 | Estado       | 4.0.x                                          |
| ------------------------------------- | ------------ | ---------------------------------------------- |
| Phalcon\Annotations\Adapter         | Renombrado a | Phalcon\Annotations\Adapter\AbstractAdapter |
| Phalcon\Annotations\Adapter\Apc    | Removed      |                                                |
| Phalcon\Annotations\Adapter\Files  | Renombrado a | Phalcon\Annotations\Adapter\Stream          |
| Phalcon\Annotations\Adapter\Xcache | Removed      |                                                |
| Phalcon\Annotations\Factory         | Renombrado a | Phalcon\Annotations\AnnotationsFactory       |

### Application

| 3.4.x                | Estado       | 4.0.x                                     |
| -------------------- | ------------ | ----------------------------------------- |
| Phalcon\Application | Renombrado a | Phalcon\Application\AbstractApplication |

### Recursos Activos

| 3.4.x | State | 4.0.x | |\---\---\---\---\---\---\---\---\---|\---\---\---\---|\---\---\---\---\---\---\---\-----| Phalcon\Assets\Resource | Renamed to | Phalcon\Assets\Asset | Phalcon\Assets\Resource\Css | Renamed to | Phalcon\Assets\Asset\Css | Phalcon\Assets\Resource\Js | Renamed to | Phalcon\Assets\Asset\Js |

### Cache

| 3.4.x                                 | Estado       | 4.0.x                                               |
| ------------------------------------- | ------------ | --------------------------------------------------- |
| Phalcon\Cache\Backend\Apc          | Removed      |                                                     |
| Phalcon\Cache\Backend               | Renombrado a | Phalcon\Cache                                      |
| Phalcon\Cache\Backend\Factory      | Renombrado a | Phalcon\Cache\AdapterFactory                      |
| Phalcon\Cache\Backend\Apcu         | Renombrado a | Phalcon\Cache\Adapter\Apcu                       |
| Phalcon\Cache\Backend\File         | Renombrado a | Phalcon\Cache\Adapter\Stream                     |
| Phalcon\Cache\Backend\Libmemcached | Renombrado a | Phalcon\Cache\Adapter\Libmemcached               |
| Phalcon\Cache\Backend\Memcache     | Removed      |                                                     |
| Phalcon\Cache\Backend\Memory       | Renombrado a | Phalcon\Cache\Adapter\Memory                     |
| Phalcon\Cache\Backend\Mongo        | Removed      |                                                     |
| Phalcon\Cache\Backend\Redis        | Renombrado a | Phalcon\Cache\Adapter\Redis                      |
|                                       | Nuevo        | Phalcon\Cache\CacheFactory                        |
| Phalcon\Cache\Backend\Xcache       | Removed      |                                                     |
| Phalcon\Cache\Exception             | Renombrado a | Phalcon\Cache\Exception\Exception                |
|                                       | Nuevo        | Phalcon\Cache\Exception\InvalidArgumentException |
| Phalcon\Cache\Frontend\Base64      | Removed      |                                                     |
| Phalcon\Cache\Frontend\Data        | Removed      |                                                     |
| Phalcon\Cache\Frontend\Factory     | Removed      |                                                     |
| Phalcon\Cache\Frontend\Igbinary    | Removed      |                                                     |
| Phalcon\Cache\Frontend\Json        | Removed      |                                                     |
| Phalcon\Cache\Frontend\Msgpack     | Removed      |                                                     |
| Phalcon\Cache\Frontend\None        | Removed      |                                                     |
| Phalcon\Cache\Frontend\Output      | Removed      |                                                     |
| Phalcon\Cache\Multiple              | Removed      |                                                     |

### Collection

| 3.4.x | Estado | 4.0.x                          |
| ----- | ------ | ------------------------------ |
|       | Nuevo  | Phalcon\Collection            |
|       | Nuevo  | Phalcon\Collection\Exception |
|       | Nuevo  | Phalcon\Collection\ReadOnly  |

### Configuración

| 3.4.x                    | Estado       | 4.0.x                          |
| ------------------------ | ------------ | ------------------------------ |
| Phalcon\Config\Factory | Renombrado a | Phalcon\Config\ConfigFactory |

### Container

| 3.4.x | Estado | 4.0.x              |
| ----- | ------ | ------------------ |
|       | Nuevo  | Phalcon\Container |

### Db

| 3.4.x                              | Estado       | 4.0.x                                  |
| ---------------------------------- | ------------ | -------------------------------------- |
| Phalcon\Db                        | Renombrado a | Phalcon\Db\AbstractDb                |
| Phalcon\Db\Adapter               | Renombrado a | Phalcon\Db\Adapter\AbstractAdapter  |
| Phalcon\Db\Adapter\Pdo          | Renombrado a | Phalcon\Db\Adapter\Pdo\AbstractPdo |
| Phalcon\Db\Adapter\Pdo\Factory | Renombrado a | Phalcon\Db\Adapter\PdoFactory       |
|                                    | Nuevo        | Phalcon\Db\Enum                      |

### Dispatcher

| 3.4.x               | Estado       | 4.0.x                                   |
| ------------------- | ------------ | --------------------------------------- |
| Phalcon\Dispatcher | Renombrado a | Phalcon\Dispatcher\AbstractDispatcher |
|                     | Nuevo        | Phalcon\Dispatcher\Exception          |

### Di

| 3.4.x | Estado | 4.0.x                                              |
| ----- | ------ | -------------------------------------------------- |
|       | Nuevo  | Phalcon\Di\AbstractInjectionAware                |
|       | Nuevo  | Phalcon\Di\Exception\ServiceResolutionException |

### Domain

| 3.4.x | Estado | 4.0.x                                    |
| ----- | ------ | ---------------------------------------- |
|       | Nuevo  | Phalcon\Domain\Payload\Payload        |
|       | Nuevo  | Phalcon\Domain\Payload\PayloadFactory |
|       | Nuevo  | Phalcon\Domain\Payload\Status         |

### Factory

| 3.4.x            | Estado       | 4.0.x                             |
| ---------------- | ------------ | --------------------------------- |
| Phalcon\Factory | Renombrado a | Phalcon\Factory\AbstractFactory |

### Filtro

| 3.4.x | Estado | 4.0.x                                  |
| ----- | ------ | -------------------------------------- |
|       | Nuevo  | Phalcon\Filter\FilterFactory         |
|       | Nuevo  | Phalcon\Filter\Sanitize\AbsInt      |
|       | Nuevo  | Phalcon\Filter\Sanitize\Alnum       |
|       | Nuevo  | Phalcon\Filter\Sanitize\Alpha       |
|       | Nuevo  | Phalcon\Filter\Sanitize\BoolVal     |
|       | Nuevo  | Phalcon\Filter\Sanitize\Email       |
|       | Nuevo  | Phalcon\Filter\Sanitize\FloatVal    |
|       | Nuevo  | Phalcon\Filter\Sanitize\IntVal      |
|       | Nuevo  | Phalcon\Filter\Sanitize\Lower       |
|       | Nuevo  | Phalcon\Filter\Sanitize\LowerFirst  |
|       | Nuevo  | Phalcon\Filter\Sanitize\Regex       |
|       | Nuevo  | Phalcon\Filter\Sanitize\Remove      |
|       | Nuevo  | Phalcon\Filter\Sanitize\Replace     |
|       | Nuevo  | Phalcon\Filter\Sanitize\Special     |
|       | Nuevo  | Phalcon\Filter\Sanitize\SpecialFull |
|       | Nuevo  | Phalcon\Filter\Sanitize\StringVal   |
|       | Nuevo  | Phalcon\Filter\Sanitize\Striptags   |
|       | Nuevo  | Phalcon\Filter\Sanitize\Trim        |
|       | Nuevo  | Phalcon\Filter\Sanitize\Upper       |
|       | Nuevo  | Phalcon\Filter\Sanitize\UpperFirst  |
|       | Nuevo  | Phalcon\Filter\Sanitize\UpperWords  |
|       | Nuevo  | Phalcon\Filter\Sanitize\Url         |

### Flash

| 3.4.x          | Estado       | 4.0.x                         |
| -------------- | ------------ | ----------------------------- |
| Phalcon\Flash | Renombrado a | Phalcon\Flash\AbstractFlash |

### Formularios

| 3.4.x                   | Estado       | 4.0.x                                    |
| ----------------------- | ------------ | ---------------------------------------- |
| Phalcon\Forms\Element | Renombrado a | Phalcon\Forms\Element\AbstractElement |

### Ayudantes

| 3.4.x | Estado | 4.0.x                      |
| ----- | ------ | -------------------------- |
|       | Nuevo  | Phalcon\Helper\Arr       |
|       | Nuevo  | Phalcon\Helper\Exception |
|       | Nuevo  | Phalcon\Helper\Fs        |
|       | Nuevo  | Phalcon\Helper\Json      |
|       | Nuevo  | Phalcon\Helper\Number    |
|       | Nuevo  | Phalcon\Helper\Str       |

### Html

| 3.4.x | Estado | 4.0.x                                      |
| ----- | ------ | ------------------------------------------ |
|       | Nuevo  | Phalcon\Html\Attributes                  |
|       | Nuevo  | Phalcon\Html\Breadcrumbs                 |
|       | Nuevo  | Phalcon\Html\Exception                   |
|       | Nuevo  | Phalcon\Html\Helper\AbstractHelper      |
|       | Nuevo  | Phalcon\Html\Helper\Anchor              |
|       | Nuevo  | Phalcon\Html\Helper\AnchorRaw           |
|       | Nuevo  | Phalcon\Html\Helper\Body                |
|       | Nuevo  | Phalcon\Html\Helper\Button              |
|       | Nuevo  | Phalcon\Html\Helper\Close               |
|       | Nuevo  | Phalcon\Html\Helper\Element             |
|       | Nuevo  | Phalcon\Html\Helper\ElementRaw          |
|       | Nuevo  | Phalcon\Html\Helper\Form                |
|       | Nuevo  | Phalcon\Html\Helper\Img                 |
|       | Nuevo  | Phalcon\Html\Helper\Label               |
|       | Nuevo  | Phalcon\Html\Helper\TextArea            |
|       | Nuevo  | Phalcon\Html\Link\EvolvableLink         |
|       | Nuevo  | Phalcon\Html\Link\EvolvableLinkProvider |
|       | Nuevo  | Phalcon\Html\Link\Link                  |
|       | Nuevo  | Phalcon\Html\Link\LinkProvider          |
|       | Nuevo  | Phalcon\Html\Link\Serializer\Header    |
|       | Nuevo  | Phalcon\Html\TagFactory                  |

### Http

| 3.4.x | Estado | 4.0.x                                                       |
| ----- | ------ | ----------------------------------------------------------- |
|       | Nuevo  | Phalcon\Http\Message\AbstractCommon                      |
|       | Nuevo  | Phalcon\Http\Message\AbstractMessage                     |
|       | Nuevo  | Phalcon\Http\Message\AbstractRequest                     |
|       | Nuevo  | Phalcon\Http\Message\Exception\InvalidArgumentException |
|       | Nuevo  | Phalcon\Http\Message\Request                             |
|       | Nuevo  | Phalcon\Http\Message\RequestFactory                      |
|       | Nuevo  | Phalcon\Http\Message\Response                            |
|       | Nuevo  | Phalcon\Http\Message\ResponseFactory                     |
|       | Nuevo  | Phalcon\Http\Message\ServerRequest                       |
|       | Nuevo  | Phalcon\Http\Message\ServerRequestFactory                |
|       | Nuevo  | Phalcon\Http\Message\Stream                              |
|       | Nuevo  | Phalcon\Http\Message\StreamFactory                       |
|       | Nuevo  | Phalcon\Http\Message\Stream\Input                       |
|       | Nuevo  | Phalcon\Http\Message\Stream\Memory                      |
|       | Nuevo  | Phalcon\Http\Message\Stream\Temp                        |
|       | Nuevo  | Phalcon\Http\Message\UploadedFile                        |
|       | Nuevo  | Phalcon\Http\Message\UploadedFileFactory                 |
|       | Nuevo  | Phalcon\Http\Message\Uri                                 |
|       | Nuevo  | Phalcon\Http\Message\UriFactory                          |
|       | Nuevo  | Phalcon\Http\Server\AbstractMiddleware                   |
|       | Nuevo  | Phalcon\Http\Server\AbstractRequestHandler               |

### Imágenes

| 3.4.x                   | Estado       | 4.0.x                                    |
| ----------------------- | ------------ | ---------------------------------------- |
| Phalcon\Image          | Removed      |                                          |
| Phalcon\Image\Adapter | Renombrado a | Phalcon\Image\Adapter\AbstractAdapter |
|                         | Nuevo        | Phalcon\Image\Enum                     |
| Phalcon\Image\Factory | Renombrado a | Phalcon\Image\ImageFactory             |

### Logger

| 3.4.x                               | Estado       | 4.0.x                                         |
| ----------------------------------- | ------------ | --------------------------------------------- |
|                                     | Nuevo        | Phalcon\Logger\AdapterFactory               |
| Phalcon\Logger\Adapter            | Renombrado a | Phalcon\Logger\Adapter\AbstractAdapter     |
| Phalcon\Logger\Adapter\Blackhole | Renombrado a | Phalcon\Logger\Adapter\Noop                |
| Phalcon\Logger\Adapter\File      | Renombrado a | Phalcon\Logger\Adapter\Stream              |
| Phalcon\Logger\Adapter\Firephp   | Removed      |                                               |
| Phalcon\Logger\Factory            | Renombrado a | Phalcon\Logger\LoggerFactory                |
| Phalcon\Logger\Formatter          | Renombrado a | Phalcon\Logger\Formatter\AbstractFormatter |
| Phalcon\Logger\Formatter\Firephp | Removed      |                                               |
| Phalcon\Logger\Formatter\Syslog  | Removed      |                                               |
| Phalcon\Logger\Multiple           | Removed      |                                               |

### Message (new in V4, Formerly Phalcon\Validation\Message in 3.4)

| 3.4.x | Estado | 4.0.x                        |
| ----- | ------ | ---------------------------- |
|       | Nuevo  | Phalcon\Messages\Exception |
|       | Nuevo  | Phalcon\Messages\Message   |
|       | Nuevo  | Phalcon\Messages\Messages  |

### Mvc

| 3.4.x                                             | Estado       | 4.0.x                                        |
| ------------------------------------------------- | ------------ | -------------------------------------------- |
| Phalcon\Mvc\Collection                          | Renombrado a | Phalcon\Collection                          |
| Phalcon\Mvc\Collection\Behavior                | Removed      |                                              |
| Phalcon\Mvc\Collection\Behavior\SoftDelete    | Removed      |                                              |
| Phalcon\Mvc\Collection\Behavior\Timestampable | Removed      |                                              |
| Phalcon\Mvc\Collection\Document                | Removed      |                                              |
| Phalcon\Mvc\Collection\Exception               | Renombrado a | Phalcon\Collection\Exception               |
| Phalcon\Mvc\Collection\Manager                 | Removed      |                                              |
|                                                   | Nuevo        | Phalcon\Collection\ReadOnly                |
| Phalcon\Mvc\Model\Message                      | Renombrado a | Phalcon\Messages\Message                   |
| Phalcon\Mvc\Model\MetaData\Apc                | Removed      |                                              |
| Phalcon\Mvc\Model\MetaData\Files              | Renombrado a | Phalcon\Mvc\Model\MetaData\Stream        |
| Phalcon\Mvc\Model\MetaData\Memcache           | Removed      |                                              |
| Phalcon\Mvc\Model\MetaData\Session            | Removed      |                                              |
| Phalcon\Mvc\Model\MetaData\Xcache             | Removed      |                                              |
| Phalcon\Mvc\Model\Validator                    | Renombrado a | Phalcon\Validation\Validator               |
| Phalcon\Mvc\Model\Validator\Email             | Renombrado a | Phalcon\Validation\Validator\Email        |
| Phalcon\Mvc\Model\Validator\Exclusionin       | Renombrado a | Phalcon\Validation\Validator\ExclusionIn  |
| Phalcon\Mvc\Model\Validator\Inclusionin       | Renombrado a | Phalcon\Validation\Validator\InclusionIn  |
| Phalcon\Mvc\Model\Validator\Ip                | Renombrado a | Phalcon\Validation\Validator\Ip           |
| Phalcon\Mvc\Model\Validator\Numericality      | Renombrado a | Phalcon\Validation\Validator\Numericality |
| Phalcon\Mvc\Model\Validator\PresenceOf        | Renombrado a | Phalcon\Validation\Validator\PresenceOf   |
| Phalcon\Mvc\Model\Validator\Regex             | Renombrado a | Phalcon\Validation\Validator\Regex        |
| Phalcon\Mvc\Model\Validator\StringLength      | Renombrado a | Phalcon\Validation\Validator\StringLength |
| Phalcon\Mvc\Model\Validator\Uniqueness        | Renombrado a | Phalcon\Validation\Validator\Uniqueness   |
| Phalcon\Mvc\Model\Validator\Url               | Renombrado a | Phalcon\Validation\Validator\Url          |
| Phalcon\Mvc\Url                                 | Renombrado a | Phalcon\Url                                 |
| Phalcon\Mvc\Url\Exception                      | Renombrado a | Phalcon\Url\Exception                      |
| Phalcon\Mvc\User\Component                     | Renombrado a | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\User\Module                        | Renombrado a | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\User\Plugin                        | Renombrado a | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\View\Engine                        | Renombrado a | Phalcon\Mvc\View\Engine\AbstractEngine   |

### Paginator

| 3.4.x                       | Estado       | 4.0.x                                        |
| --------------------------- | ------------ | -------------------------------------------- |
| Phalcon\Paginator\Adapter | Renombrado a | Phalcon\Paginator\Adapter\AbstractAdapter |
| Phalcon\Paginator\Factory | Renombrado a | Phalcon\Paginator\PaginatorFactory         |
|                             | Nuevo        | Phalcon\Paginator\Repository               |

### Queue

| 3.4.x                                | Estado  | 4.0.x |
| ------------------------------------ | ------- | ----- |
| Phalcon\Queue\Beanstalk            | Removed |       |
| Phalcon\Queue\Beanstalk\Exception | Removed |       |
| Phalcon\Queue\Beanstalk\Job       | Removed |       |

### Session

| 3.4.x                               | Estado       | 4.0.x                                      |
| ----------------------------------- | ------------ | ------------------------------------------ |
| Phalcon\Session\Adapter           | Renombrado a | Phalcon\Session\Adapter\AbstractAdapter |
| Phalcon\Session\Adapter\Files    | Renombrado a | Phalcon\Session\Adapter\Stream          |
|                                     | Nuevo        | Phalcon\Session\Adapter\Noop            |
| Phalcon\Session\Adapter\Memcache | Removed      |                                            |
| Phalcon\Session\Factory           | Renombrado a | Phalcon\Session\Manager                  |

### Storage

| 3.4.x | Estado | 4.0.x                                            |
| ----- | ------ | ------------------------------------------------ |
|       | Nuevo  | Phalcon\Storage\AdapterFactory                 |
|       | Nuevo  | Phalcon\Storage\Adapter\AbstractAdapter       |
|       | Nuevo  | Phalcon\Storage\Adapter\Apcu                  |
|       | Nuevo  | Phalcon\Storage\Adapter\Libmemcached          |
|       | Nuevo  | Phalcon\Storage\Adapter\Memory                |
|       | Nuevo  | Phalcon\Storage\Adapter\Redis                 |
|       | Nuevo  | Phalcon\Storage\Adapter\Stream                |
|       | Nuevo  | Phalcon\Storage\Exception                      |
|       | Nuevo  | Phalcon\Storage\SerializerFactory              |
|       | Nuevo  | Phalcon\Storage\Serializer\AbstractSerializer |
|       | Nuevo  | Phalcon\Storage\Serializer\Base64             |
|       | Nuevo  | Phalcon\Storage\Serializer\Igbinary           |
|       | Nuevo  | Phalcon\Storage\Serializer\Json               |
|       | Nuevo  | Phalcon\Storage\Serializer\Msgpack            |
|       | Nuevo  | Phalcon\Storage\Serializer\None               |
|       | Nuevo  | Phalcon\Storage\Serializer\Php                |

### Traducciones

| 3.4.x                       | Estado       | 4.0.x                                        |
| --------------------------- | ------------ | -------------------------------------------- |
| Phalcon\Translate          | Eliminado    |                                              |
| Phalcon\Translate\Adapter | Renombrado a | Phalcon\Translate\Adapter\AbstractAdapter |
|                             | Nuevo        | Phalcon\Translate\InterpolatorFactory      |
| Phalcon\Translate\Factory | Renombrado a | Phalcon\Translate\TranslateFactory         |

### Url

| 3.4.x | Estado | 4.0.x                   |
| ----- | ------ | ----------------------- |
|       | Nuevo  | Phalcon\Url            |
|       | Nuevo  | Phalcon\Url\Exception |

### Validación

| 3.4.x                                        | Estado       | 4.0.x                                                   |
| -------------------------------------------- | ------------ | ------------------------------------------------------- |
| Phalcon\Validation\CombinedFieldsValidator | Renombrado a | Phalcon\Validation\AbstractCombinedFieldsValidator    |
| Phalcon\Validation\Message                 | Renombrado a | Phalcon\Messages\Message                              |
| Phalcon\Validation\Message\Group          | Renombrado a | Phalcon\Messages\Messages                             |
| Phalcon\Validation\Validator               | Renombrado a | Phalcon\Validation\AbstractValidator                  |
|                                              | Nuevo        | Phalcon\Validation\AbstractValidatorComposite         |
|                                              | Nuevo        | Phalcon\Validation\Exception                          |
|                                              | Nuevo        | Phalcon\Validation\ValidatorFactory                   |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\AbstractFile      |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\MimeType          |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\Resolution\Equal |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\Resolution\Max   |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\Resolution\Min   |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\Size\Equal       |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\Size\Max         |
|                                              | Nuevo        | Phalcon\Validation\Validator\File\Size\Min         |
|                                              | Nuevo        | Phalcon\Validation\Validator\StringLength\Max       |
|                                              | Nuevo        | Phalcon\Validation\Validator\StringLength\Min       |