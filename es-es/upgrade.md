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

Phalcon v4 soporta sólo PHP 7.2 y superiores. PHP 7.1 fue publicado hace 2 años y su [soporte activo](https://www.php.net/supported-versions.php) ha caducado, así que decidimos seguir activamente las versiones soportadas de PHP.

<a name='psr'></a>

### PSR (Recomendaciones Estándar de PHP)

Phalcon requiere la extensión PSR. La extensión se puede descargar y compilar desde [este repositorio de GitHub](https://github.com/jbboehr/php-psr). Las instrucciones de instalación están disponibles en el archivo `README` del repositorio. Una vez que la extensión haya sido compilada y esté disponible en su sistema, necesitará cargarla a su `php.ini`. Necesitarás añadir esta línea:

```ini
extension=psr.so
```

before

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

# Components

## ACL

> Estado: **cambios requeridos**
> 
> Uso: [Documentación ACL](acl)
{: .alert .alert-info }

En componente [ACL](acl) se le ha cambiado el nombre a algunos métodos y componentes. La funcionalidad sigue siendo la misma que en versiones anteriores.

### Resumen

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

## Assets

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

## Debug

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

- Añadido `fetchColumn`, `insertAsDict`, `updateAsDict`

### Db\Adapter\Pdo

- Se han añadido más tipos de columnas para el adaptador Mysql. Soporte de adaptadores 
    - `TYPE_BIGINTEGER`
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

- Se modificó `addPrimaryKey` para hacer que los nombres de restricciones de clave primaria sean únicos prefijándolos con el nombre de la tabla.

* * *

## DI

### Di\ServiceInterface

- Añadido `getParameter`, `isResolved`

### Di\Service

- Se cambió el constructor del `Phalcon\Di\Service` para que dejara de tomar el nombre del servicio.

* * *

## Dispatcher

- Eliminado `Phalcon\Dispatcher::setModelBinding()` a favor de `Phalcon\Dispatcher::setModelBinder()`
- Añadido `getHandlerSuffix()`, `setHandlerSuffix()`

* * *

## Events

### Events\ManagerInterface

- Añadido `hasListeners`

* * *

## Flash

- Se ha añadido la capacidad de establecer una plantilla personalizada para el mensajero Flash.
- El constructor ya no acepta un array para las clases CSS. Se necesitará usar `setCssClasses()` para establecer tus clases CSS personalizadas para el componente
- El constructor ahora acepta un objeto opcional `Phalcon\Escaper`, así como un objeto `Phalcon\Session\Manager` (en el caso de `Phalcon\Flash\Session`), en caso de que no desee utilizar el DI y establecerlo usted mismo.

* * *

## Filter

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Filters](filter)
{: .alert .alert-info }

El componente `Filter` ha sido reescrito, utilizando un localizador de servicios. Cada sanitizador está ahora encerrado en su propia clase y cargado de forma perezosa para proporcionar el máximo rendimiento y el menor uso de recursos posible.

### Resumen

La clase `Phalcon\Filter` ha sido reescrita para actuar como un localizador de servicios para diferentes *sanitizadores*. Este objeto le permite limpiar la entrada, como antes, al usar el método `sanitize()`.

Los valores saneados se convierten automáticamente a los tipos relevantes. Este es el comportamiento predeterminado para los filtros `int`, `bool` y `float`.

Al instanciar el objeto de filtro, no tiene precargado ningún saneador. Entonces tienes dos opciones:

#### Cargar todos los sanitizadores por defecto

Puede cargar todos los sanitizadores suministrados utilizando el componente [Phalcon\Filter\FilterFactory](api/Phalcon_Filter#filter-filterfactory).

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();
$locator = $factory->newInstance();
```

Llamando a `newInstance()` devolverá un objeto [Phalcon\Filter](api/Phalcon_Filter#filter) con todos los limpiadores registrados. Los sanitizadores están cargados perezosamente, por lo que se instanciaran sólo cuando se les llame desde el localizador.

#### Cargar solo los sanitizadores que quieras

Puede instanciar el componente [Phalcon\Filter](api/Phalcon_Filter#filter) y utilizar el método `set()` para establecer todos los limpiadores que necesite. o pasar un array en el constructor con los limpiadores que desea registrar.

### Usando `FactoryDefault`

Si utiliza el contenedor [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault), entonces el [Phalcon\Filter](api/Phalcon_Filter#filter) se carga automáticamente en el contenedor. Luego puede continuar usando el servicio en sus controladores o componentes como lo hacia antes. El nombre del servicio del DI es `filter`, como antes.

También los componentes que utilizan el servicio de filtros, como el objeto [Request](api/phalcon_http#http-request), utilizan de forma transparente el nuevo localizador de filtros. No se requieren cambios adicionales para esos componentes.

### Usando un `DI` personalizado

Si usted mismo ha configurado todos los servicios en el [Phalcon\Di](api/Phalcon_Di) y necesita el servicio de filtro, necesitarás cambiar su registro de la siguiente manera:

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

> **NOTA**: Tenga en cuenta que incluso si registra el servicio de filtro manualmente, el **nombre** del servicio debe ser **filter** para que otros componentes puedan usarlo
{: .alert .alert-warning }

### Constantes

Las constantes de la v3 en `Phalcon\Filter` han cambiado.

#### Eliminado

- `FILTER_INT_CAST` (`int!`)
- `FILTER_FLOAT_CAST` (`float!`)

Por defecto, el servicio de sanitizadores convierten el valor al tipo apropiado por lo que estos son obsoletos

- `FILTER_APHANUM` ha sido removido, reemplazado por `FILTER_ALNUM`

#### Cambiado

- `FILTER_SPECIAL_CHARS` ha sido eliminado, reemplazado por `FILTER_SPECIAL`
- `FILTER_ALNUM` reemplaza a `FILTER_ALPHANUM`
- `FILTER_ALPHA` sanitiza solo caracteres alfabéticos
- `FILTER_BOOL` sanitiza booleanos incluyendo "yes", "no", etc.
- `FILTER_LOWERFIRST` sanitiza usando `lcfirst`
- `FILTER_REGEX` sanitiza basado en un patrón (`preg_replace`)
- `FILTER_REMOVE` sanitiza eliminando caracteres (`str_replace`)
- `FILTER_REPLACE` sanitiza reemplazando caracteres (`str_replace`)
- `FILTER_SPECIAL` reemplaza a `FILTER_SPECIAL_CHARS`
- `FILTER_SPECIALFULL` sanitiza caracteres especiales (`filter_var`)
- `FILTER_UPPERFIRST` sanitiza utilizando `ucfirst`
- `FILTER_UPPERWORDS` sanitiza utilizando `ucwords`

* * *

## Forms

### Forms\Form

- `Phalcon\Forms\Form::clear` ya no llamará `Phalcon\Forms\Element::clear`, en su lugar limpiará/establecerá el valor por defecto en sí mismo, y `Phalcon\Forms\Element::clear` ahora llamará a `Phalcon\Forms\Form::clear` si está asignado al formulario, de lo contrario, se limpiara a si mismo.
- `Phalcon\Forms\Form::getValue` ahora también intentará obtener el valor llamando `Tag::getValue` o el método `getDefault` del elemento antes de devolver `null`, y `Phalcon\Forms\Element::getValue` llama a `Tag::getDefault` solo si no se añade al formulario.

* * *

## Html

### Html\Breadcrumbs

- Añadido `Phalcon\Html\Breadcrumbs`, un componente que crea código HTML para migas de pan.

### Html\Tag

- Añadido `Phalcon\Html\Tag`, un componente que crea elementos HTML. Reemplazará a `Phalcon\Tag` en una versión futura. Este componente no utiliza llamadas a métodos estáticos.

### Http\RequestInterface

- Eliminado `isSecureRequest` a favor de `isSecure`
- Eliminado `isSoapRequested` a favor de `isSoap`

### Http\Response

- Se añadió el método `hasHeader()` a `Phalcon\Http\Response` para proporcionar la capacidad de comprobar si existe un encabezado.
- Añadido `Phalcon\Http\Response\Cookies::getCookies`
- Modificado `setHeaders` ahora combina los encabezados con los preexistentes en la colección interna
- Se añadieron dos nuevos eventos `response::beforeSendHeaders` y `response::afterSendHeaders`

* * *

## Imagen

- Añadido `Phalcon\Image\Enum`
- Renombrado `Phalcon\Image\Adapter` a `Phalcon\Image\Adapter\AbstractAdapter`
- Renombrado `Phalcon\Image\Factory` a `Phalcon\Image\ImageFactory`
- Eliminado `Phalcon\Image`

## Image\Enum (Constantes)

Ejemplo:

```php
<?php

use Phalcon\Image\Enum;

// Restricciones de redimensionado
echo Enum::AUTO;    // imprime 4
echo Enum::HEIGHT;  // imprime 3
echo Enum::INVERSE; // imprime 5
echo Enum::NONE;   // imprime 1
echo Enum::PRECISE; // imprime 6
echo Enum::TENSILE; // imprime 7
echo Enum::WIDTH;   // imprime   2

// Direcciones de volteado
echo Enum::HORIZONTAL; // imprime 11
echo Enum::VERTICAL;   // imprime 12
```

* * *

## Logger

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Logger](logger)
{: .alert .alert-info }

El componente `Logger` ha sido reescrito para cumplir con el [PSR-3](https://www.php-fig.org/psr/psr-3/). Esto le permite utilizar el [Phalcon\Logger](api/Phalcon_Logger) para cualquier aplicación que utilice un registro [PSR-3](https://www.php-fig.org/psr/psr-3/) y no solo las basadas en Phalcon.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.

### Crear un componente Logger

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

### Multiples Loggers

El componente `Phalcon\Logger\Multiple` ha sido eliminado. Puede lograr la misma funcionalidad usando el componente logger y registrando más de un adaptador:

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

- `Phalcon\Messages\Message` y su colección `Phalcon\Messages\Messages` son nuevos componentes que manejan mensajes para modelos y validación. En el pasado teníamos dos componentes, uno para la validación y otro para los modelos. Hemos fusionado estos dos, así que deberías volver a obtener una `MessageInterface[]` al llamar a `save` en un modelo o al recuperar mensajes de validación. 
    - Modificado `Phalcon\Mvc\Model` para usar el objeto `Phalcon\Messages\Message` para sus mensajes
    - Modificado `Phalcon\Validation\*` para usar el objeto `Phalcon\Messages\Message` para sus mensajes

* * *

### Transacciones

Eliminado en la versión 4.0:

- Eliminado `$logger->begin()`
- Eliminado `$logger->commit()`

### Nivel de registro

- Eliminado `$logger->setLogLevel()`

## Models

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Modelos](db-models)
{: .alert .alert-info }

- Ya no puede asignar datos a los modelos al guardarlos

### Inicialización

El método `getSource()` ha sido marcado como `final`. Como tal, ya no puede sobreescribir este método en su modelo para establecer la tabla/fuente correspondiente del RDBMS. En su lugar, ahora puede utilizar el método `initialize()` y `setSource()` para establecer la fuente de su modelo.

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

### Guardar

El método `save()` ya no acepta parámetros para establecer datos. En su lugar, puede usar el método `assign`.

### Criteria

El segundo parámetro de `Criteria::limit()` ('offset') ahora debe ser un entero o nulo. Anteriormente no existía ningún tipo de requisito.

```php
$criteria->limit(10);

$criteria->limit(10, 5);

$criteria->limit(10, null);
```

* * *

## MVC

> Estado: **cambios requeridos**
> 
> Uso: [Documentación del MVC](mvc)
{: .alert .alert-info }

### Mvc\Collection

- Eliminado `Phalcon\Mvc\Collection::validationHasFailed`
- Llamada eliminada `Phalcon\Mvc\Collection::validate` con un objeto de tipo `Phalcon\Mvc\Model\ValidatorInterface`

### Mvc\Micro\Lazyloader

- Se ha eliminado `__call` a favor de `callMethod`

### Mvc\Model

- Eliminado `Phalcon\Model::reset`
- Se añadió `isRelationshipLoaded` para comprobar si la relación está cargada
- Cambiado en el método `Phalcon\Model::assign` el orden de los parámetros a `$data`, `$whiteList`, `$dataColumnMap`
- Cambió `Phalcon\Model::findFirst` para devolver `null` en lugar de `false` si no se encontró ningún registro
- Cambiado `Phalcon\Model::getRelated()` para devolver `null` para una relación "uno a uno" si no se encontró ningún registro

### Mvc\Model\Criteria

- Eliminado `addWhere`
- Eliminado `order`
- Eliminado `order` a favor del `orderBy`

### Mvc\Model\CriteriaInterface

- Añadido `distinct`, `leftJoin`, `innerJoin`, `rightJoin`, `groupBy`, `having`, `cache`, `getColumns`, `getGroupBy`, `getHaving`

### Mvc\Model\Manager

- `load` ya no reutiliza modelos ya inicializados
- Eliminado `Phalcon\Model\Manager::registerNamespaceAlias()`
- Eliminado `Phalcon\Model\Manager::getNamespaceAlias()`
- Eliminado `Phalcon\Model\Manager::getNamespaceAliases()`
- El armado de `Phalcon\Mvc\Model\Manager::getRelationRecords()` ha cambiado
- El armado de `Phalcon\Mvc\Model\Manager::getBelongsToRecords()` ha cambiado
- El armado de `Phalcon\Mvc\Model\Manager::getHasOneRecords()` ha cambiado
- El armado de `Phalcon\Mvc\Model\Manager::getHasManyRecords()` ha cambiado

### Mvc\Model\ManagerInterface

- Añadido `isVisibleModelProperty`, `keepSnapshots`, `isKeepingSnapshots`, `useDynamicUpdate`, `isUsingDynamicUpdate`, `addHasManyToMany`, `existsHasManyToMany`, `getRelationRecords`, `getHasManyToMany`
- Eliminado `Phalcon\Model\ManagerInterface::getNamespaceAlias()`
- Eliminado `Phalcon\Model\ManagerInterface::registerNamespaceAlias()`

### Mvc\Model\MessageInterface

- Añadido `setModel`, `getModel`, `setCode`, `getCode`

### Mvc\Model\QueryInterface

- Añadido `getSingleResult`, `setBindParams`, `getBindParams`, `setBindTypes`, `setSharedLock`, `getBindTypes`, `getSql`

### Mvc\Model\Query\BuilderInterface

- Añadido `offset`

### Mvc\Model\Query\Builder

- Añadido soporte para enlazar parámetros. El Query Builder tiene los mismos métodos que `Phalcon\Mvc\Model\Query`; `getBindParams`, `setBindParams`, `getBindTypes` y `setBindTypes`.
- Se ha cambiado `addFrom` para eliminar el tercer parámetro `$with`

### Mvc\Model\Query\BuilderInterface

- Añadido `distinct`, `getDistinct`, `forUpdate`, `offset`, `getOffset`

### Mvc\Model\RelationInterface

- Añadido `getParams`

### Mvc\Model\ResultsetInterface

- Añadido `setHydrateMode`, `getHydrateMode`, `getMessages`, `update`, `delete`, `filter`

### Mvc\Model\Transaction\ManagerInterface

- Añadido `setDbService`, `getDbService`, `setRollbackPendent`, `getRollbackPendent`

### Mvc\Model\Validator*

- Eliminado `Phalcon\Mvc\Model\Validator\*` a favor de `Phalcon\Validation\Validator\*`

### Mvc\ModelInterface

- Añadido `getModelsMetaData`

### Mvc\Router

- Se ha eliminado `getRewriteUri()`. La URI necesita ser pasada en el método `handle` del objeto de la aplicación.

### Mvc\RouterInterface

- Añadido `attach`

### Mvc\Router\RouteInterface

- Añadido `convert` para que la llamada `add` devuelva una instancia que tiene el método `convert`

### Mvc\Router\RouteInterface

- Añadido el gestor de respuesta a `Phalcon\Mvc\Micro`, `Phalcon\Mvc\Micro::setResponseHandler`, para permitir el uso de un gestor de respuesta personalizado.

### Mvc\User

- Eliminado `Phalcon\Mvc\User\Component`, utilizar `Phalcon\Di\Injectable` en su lugar
- Eliminado `Phalcon\Mvc\User\Module`, utilizar `Phalcon\Di\Injectable` en su lugar
- Eliminado `Phalcon\Mvc\User\Plugin`, utilizar `Phalcon\Di\Injectable` en su lugar

### Mvc\View\Engine\Volt

Las opciones para Volt han cambiado (los nombres de las claves). Usar la sintaxis antigua producirá una advertencia de deprecado. Las nuevas opciones son:

- `always` - Siempre compila
- `extension` - Extensión de los archivos
- `separator` - Separador (usado para las carpetas/rutas)
- `stat` - Estado de cada archivo antes de intentar usarlo
- `path` - La ruta de los archivos
- `prefix` - El prefijo de los archivos

* * *

## Paginator

- `getPaginate` ahora se convierte en `paginate`
- `$before` es eliminado y reemplazado por `$previous`
- `$total_pages` es eliminado ya que contiene la misma información que `$last`
- Añadido `Phalcon\Paginator\RepositoryInterface` para el repositorio del estado actual del `paginator` y también opcionalmente establece los alias para el repositorio de propiedades

## Router

- Se ha eliminado `getRewriteUri()`. La URI necesita ser pasada en el método `handle` del objeto de la aplicación.
- Puedes añadir `CONNECT`, `PURGE`, `TRACE` a las rutas al grupo enrutador. Funcionan del mismo modo que funcionan en el Router:

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

## Security

- Eliminado `hasLibreSsl`
- Eliminado `getSslVersionNumber`
- Añadido `setPadding`
- Se ha añadido un retenedor para que el token actual se utilice durante las comprobaciones, así que cuando `getToken` es llamado el token usado para verificaciones no cambia

* * *

## Request

### Http\Request

- Añadido `numFiles` retornando `int` - el número de archivos presentes en la solicitud
- Se ha cambiado `hasFiles` para devolver `bool` - si la solicitud tiene archivos o no

### Http\RequestInterface

- Añadido `numFiles` retornando `int` - el número de archivos presentes en la solicitud
- Se ha cambiado `hasFiles` para devolver `bool` - si la solicitud tiene archivos o no

* * *

## Session

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Session](session)
{: .alert .alert-info }

`Session` y `Session\Bag` ya no se cargan por defecto en `Phalcon\DI\FactoryDefault`. `Session` fue refactorizada.

- Añadido `Phalcon\Session\Adapter\AbstractAdapter`
- Añadido `Phalcon\Session\Adapter\Noop`
- Añadido `Phalcon\Session\Adapter\Stream`
- Añadido `Phalcon\Session\Manager`
- Añadido `Phalcon\Session\ManagerInterface`
- Eliminado `Phalcon\Session\Adapter` - reemplazado por `Phalcon\Session\Adapter\AbstractAdapter`
- Eliminado `Phalcon\Session\AdapterInterface` - reemplazado por nativo `SessionHandlerInterface`
- Eliminado `Phalcon\Session\Adapter\Files` - reemplazado por `Phalcon\Session\Adapter\Stream`
- Eliminado `Phalcon\Session\Adapter\Memcache`
- Eliminado `Phalcon\Session\BagInterface`
- Eliminado `Phalcon\Session\Factory`

### Session\Adapter

Cada adaptador implementa `SessionHandlerInterface` de PHP. Los adaptadores disponibles son:

- `Phalcon\Session\Adapter\AbstractAdapter`
- `Phalcon\Session\Adapter\Libmemcached`
- `Phalcon\Session\Adapter\Noop`
- `Phalcon\Session\Adapter\Redis`
- `Phalcon\Session\Adapter\Stream`

### Session\Manager

- Ahora es el único componente que ofrece manipulación de sesión mediante el uso de adaptadores (ver arriba). Cada adaptador implementa `SessionHandlerInterface` de PHP
- Los desarrolladores pueden añadir cualquier adaptador que implemente `SessionHandlerInterface`

* * *

## Tag

- Añadido `renderTitle()` que renderiza el título encerrado entre etiquetas `<title>`.
- Se ha cambiado `getTitle`. Sólo devuelve el texto del título. Acepta `prepend`, `append` booleanos para agregar un prefijo o sufijo al título.
- Se ha cambiado `textArea` para usar `htmlspecialchars` para prevenir la inyección XSS.

* * *

## Text

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de Str](helpers#str)
{: .alert .alert-info }

El componente `Phalcon\Text` se ha eliminado a favor del `Phalcon\Helper\Str`. La funcionalidad ofrecida por `Phalcon\Text` en v3 es replicada y mejorada en la nueva clase: `Phalcon\Helper\Str`.

* * *

## Validation

### Validation\Message

- Eliminado `Phalcon\Validation\Message` y `Phalcon\Mvc\Model\Message` a favor de `Phalcon\Messages\Message`
- Eliminado `Phalcon\Validation\MessageInterface` y `Phalcon\Mvc\Model\MessageInterface` a favor de `Phalcon\Messages\MessageInterface`
- Eliminado `Phalcon\Validation\Message\Group` a favor de `Phalcon\Messages\Messages`
- Los mensajes del validador se han movido dentro de cada validador

### Validation\Validator

- Eliminado `isSetOption`

### Validation\Validator\Ip

- Añadido `Phalcon\Validation\Validator\Ip`, clase utilizada para validar campos de dirección ip. Permite validar un campo seleccionando IPv4 o IPv6, permitiendo rangos privados o reservados y valores vacíos si es necesario.

* * *

## Views

> Estado: **cambios requeridos**
> 
> Uso: [Documentación de View](views)
{: .alert .alert-info }

La caché de vista junto con el servicio de `viewCache` se han eliminado del framework porque eran incompatibles con el nuevo componente de caché. Los desarrolladores pueden utilizar fácilmente un *caché de vista* de servicios externos como Varnish, Cloudflare, etc. Además, los desarrolladores pueden almacenar fragmentos en caché utilizando `Phalcon\Mvc\View\Simple::render()` o el `Phalcon\Mvc\View::toString()`. Estos dos métodos devuelven el HTML producido que puede ser almacenado en caché en el backend de tu elección.

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
| Phalcon\Acl           | Eliminado    |                                        |
| Phalcon\Acl\Adapter  | Renombrado a | Phalcon\Acl\Adapter\AbstractAdapter |
| Phalcon\Acl\Resource | Renombrado a | Phalcon\Acl\Component                |
|                        | Nuevo        | Phalcon\Acl\Enum                     |

### Annotations

| 3.4.x                                 | Estado       | 4.0.x                                          |
| ------------------------------------- | ------------ | ---------------------------------------------- |
| Phalcon\Annotations\Adapter         | Renombrado a | Phalcon\Annotations\Adapter\AbstractAdapter |
| Phalcon\Annotations\Adapter\Apc    | Eliminado    |                                                |
| Phalcon\Annotations\Adapter\Files  | Renombrado a | Phalcon\Annotations\Adapter\Stream          |
| Phalcon\Annotations\Adapter\Xcache | Eliminado    |                                                |
| Phalcon\Annotations\Factory         | Renombrado a | Phalcon\Annotations\AnnotationsFactory       |

### Application

| 3.4.x                | Estado       | 4.0.x                                     |
| -------------------- | ------------ | ----------------------------------------- |
| Phalcon\Application | Renombrado a | Phalcon\Application\AbstractApplication |

### Assets

| 3.4.x                          | Estado       | 4.0.x                       |
| ------------------------------ | ------------ | --------------------------- |
| Phalcon\Assets\Resource      | Renombrado a | Phalcon\Assets\Asset      |
| Phalcon\Assets\Resource\Css | Renombrado a | Phalcon\Assets\Asset\Css |
| Phalcon\Assets\Resource\Js  | Renombrado a | Phalcon\Assets\Asset\Js  |

### Cache

| 3.4.x                                 | Estado       | 4.0.x                                               |
| ------------------------------------- | ------------ | --------------------------------------------------- |
| Phalcon\Cache\Backend\Apc          | Eliminado    |                                                     |
| Phalcon\Cache\Backend               | Renombrado a | Phalcon\Cache                                      |
| Phalcon\Cache\Backend\Factory      | Renombrado a | Phalcon\Cache\AdapterFactory                      |
| Phalcon\Cache\Backend\Apcu         | Renombrado a | Phalcon\Cache\Adapter\Apcu                       |
| Phalcon\Cache\Backend\File         | Renombrado a | Phalcon\Cache\Adapter\Stream                     |
| Phalcon\Cache\Backend\Libmemcached | Renombrado a | Phalcon\Cache\Adapter\Libmemcached               |
| Phalcon\Cache\Backend\Memcache     | Eliminado    |                                                     |
| Phalcon\Cache\Backend\Memory       | Renombrado a | Phalcon\Cache\Adapter\Memory                     |
| Phalcon\Cache\Backend\Mongo        | Eliminado    |                                                     |
| Phalcon\Cache\Backend\Redis        | Renombrado a | Phalcon\Cache\Adapter\Redis                      |
|                                       | Nuevo        | Phalcon\Cache\CacheFactory                        |
| Phalcon\Cache\Backend\Xcache       | Eliminado    |                                                     |
| Phalcon\Cache\Exception             | Renombrado a | Phalcon\Cache\Exception\Exception                |
|                                       | Nuevo        | Phalcon\Cache\Exception\InvalidArgumentException |
| Phalcon\Cache\Frontend\Base64      | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\Data        | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\Factory     | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\Igbinary    | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\Json        | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\Msgpack     | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\None        | Eliminado    |                                                     |
| Phalcon\Cache\Frontend\Output      | Eliminado    |                                                     |
| Phalcon\Cache\Multiple              | Eliminado    |                                                     |

### Colección

| 3.4.x | Estado | 4.0.x                          |
| ----- | ------ | ------------------------------ |
|       | Nuevo  | Phalcon\Collection            |
|       | Nuevo  | Phalcon\Collection\Exception |
|       | Nuevo  | Phalcon\Collection\ReadOnly  |

### Config

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

### Filter

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

### Forms

| 3.4.x                   | Estado       | 4.0.x                                    |
| ----------------------- | ------------ | ---------------------------------------- |
| Phalcon\Forms\Element | Renombrado a | Phalcon\Forms\Element\AbstractElement |

### Helper

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

### Image

| 3.4.x                   | Estado       | 4.0.x                                    |
| ----------------------- | ------------ | ---------------------------------------- |
| Phalcon\Image          | Eliminado    |                                          |
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
| Phalcon\Logger\Adapter\Firephp   | Eliminado    |                                               |
| Phalcon\Logger\Factory            | Renombrado a | Phalcon\Logger\LoggerFactory                |
| Phalcon\Logger\Formatter          | Renombrado a | Phalcon\Logger\Formatter\AbstractFormatter |
| Phalcon\Logger\Formatter\Firephp | Eliminado    |                                               |
| Phalcon\Logger\Formatter\Syslog  | Eliminado    |                                               |
| Phalcon\Logger\Multiple           | Eliminado    |                                               |

### Message (nuevo en V4, Anteriormente Phalcon\Validation\Message en 3.4)

| 3.4.x | Estado | 4.0.x                        |
| ----- | ------ | ---------------------------- |
|       | Nuevo  | Phalcon\Messages\Exception |
|       | Nuevo  | Phalcon\Messages\Message   |
|       | Nuevo  | Phalcon\Messages\Messages  |

### Mvc

| 3.4.x                                             | Estado       | 4.0.x                                        |
| ------------------------------------------------- | ------------ | -------------------------------------------- |
| Phalcon\Mvc\Collection                          | Renombrado a | Phalcon\Collection                          |
| Phalcon\Mvc\Collection\Behavior                | Eliminado    |                                              |
| Phalcon\Mvc\Collection\Behavior\SoftDelete    | Eliminado    |                                              |
| Phalcon\Mvc\Collection\Behavior\Timestampable | Eliminado    |                                              |
| Phalcon\Mvc\Collection\Document                | Eliminado    |                                              |
| Phalcon\Mvc\Collection\Exception               | Renombrado a | Phalcon\Collection\Exception               |
| Phalcon\Mvc\Collection\Manager                 | Eliminado    |                                              |
|                                                   | Nuevo        | Phalcon\Collection\ReadOnly                |
| Phalcon\Mvc\Model\Message                      | Renombrado a | Phalcon\Messages\Message                   |
| Phalcon\Mvc\Model\MetaData\Apc                | Eliminado    |                                              |
| Phalcon\Mvc\Model\MetaData\Files              | Renombrado a | Phalcon\Mvc\Model\MetaData\Stream        |
| Phalcon\Mvc\Model\MetaData\Memcache           | Eliminado    |                                              |
| Phalcon\Mvc\Model\MetaData\Session            | Eliminado    |                                              |
| Phalcon\Mvc\Model\MetaData\Xcache             | Eliminado    |                                              |
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

| 3.4.x                       | Estado       | 4.0.x                                |
| --------------------------- | ------------ | ------------------------------------ |
| Phalcon\Paginator\Adapter | Renombrado a | Phalcon\Paginator\Adapter          |
| Phalcon\Paginator\Factory | Renombrado a | Phalcon\Paginator\PaginatorFactory |
|                             | Nuevo        | Phalcon\Paginator\Repository       |

### Queue

| 3.4.x                                | Estado    | 4.0.x |
| ------------------------------------ | --------- | ----- |
| Phalcon\Queue\Beanstalk            | Eliminado |       |
| Phalcon\Queue\Beanstalk\Exception | Eliminado |       |
| Phalcon\Queue\Beanstalk\Job       | Eliminado |       |

### Session

| 3.4.x                               | Estado       | 4.0.x                                      |
| ----------------------------------- | ------------ | ------------------------------------------ |
| Phalcon\Session\Adapter           | Renombrado a | Phalcon\Session\Adapter\AbstractAdapter |
| Phalcon\Session\Adapter\Files    | Renombrado a | Phalcon\Session\Adapter\Stream          |
|                                     | Nuevo        | Phalcon\Session\Adapter\Noop            |
| Phalcon\Session\Adapter\Memcache | Eliminado    |                                            |
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

### Translate

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