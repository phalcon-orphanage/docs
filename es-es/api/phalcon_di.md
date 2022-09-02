---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Di'
---

* [Phalcon\Di](#di)
* [Phalcon\Di\AbstractInjectionAware](#di-abstractinjectionaware)
* [Phalcon\Di\DiInterface](#di-diinterface)
* [Phalcon\Di\Exception](#di-exception)
* [Phalcon\Di\Exception\ServiceResolutionException](#di-exception-serviceresolutionexception)
* [Phalcon\Di\FactoryDefault](#di-factorydefault)
* [Phalcon\Di\FactoryDefault\Cli](#di-factorydefault-cli)
* [Phalcon\Di\Injectable](#di-injectable)
* [Phalcon\Di\InjectionAwareInterface](#di-injectionawareinterface)
* [Phalcon\Di\Service](#di-service)
* [Phalcon\Di\Service\Builder](#di-service-builder)
* [Phalcon\Di\ServiceInterface](#di-serviceinterface)
* [Phalcon\Di\ServiceProviderInterface](#di-serviceproviderinterface)

<h1 id="di">Class Phalcon\Di</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\Service, Phalcon\Di\DiInterface, Phalcon\Di\Exception, Phalcon\Di\Exception\ServiceResolutionException, Phalcon\Config\Adapter\Php, Phalcon\Config\Adapter\Yaml, Phalcon\Config\ConfigInterface, Phalcon\Di\ServiceInterface, Phalcon\Events\ManagerInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Di\ServiceProviderInterface | | Implements | DiInterface |

Phalcon\Di es un componente que implementa Inyección de Dependencias/Localización de Servicios y es en si mismo un contenedor para ellos.

Como Phalcon es altamente desacoplado, Phalcon\Di es esencial para integrar los diferentes componentes del framework. El desarrollador puede usar también este componente para inyectar dependencias y gestionar instancias globales de las diferentes clases usadas en la aplicación.

Básicamente, este componente implementa el patrón `Inversión de Control`. Aplicando esto, los objetos no reciben sus dependencias usando *setters* o constructores, sino solicitando un servicio de inyección de dependencias. Esto reduce la complejidad general, ya que sólo hay una forma de obtener las dependencias requeridas desde un componente.

Además, este patrón incrementa la testabilidad en el código, ya que lo hace menos propenso a errores.

```php
use Phalcon\Di;
use Phalcon\Http\Request;

$di = new Di();

// Using a string definition
$di->set("request", Request::class, true);

// Using an anonymous function
$di->setShared(
    "request",
    function () {
        return new Request();
    }
);

$request = $di->getRequest();
```

## Propiedades

```php
/**
 * List of registered services
 *
 * @var ServiceInterface[]
 */
protected services;

/**
 * List of shared instances
 */
protected sharedInstances;

/**
 * Events Manager
 *
 * @var ManagerInterface | null
 */
protected eventsManager;

/**
 * Latest DI build
 *
 * @var DiInterface | null
 */
protected static _default;

```

## Métodos

```php
public function __call( string $method, array $arguments = [] ): mixed | null;
```

Método mágico para obtener o establecer servicios usando *setters*/*getters*

```php
public function __construct();
```

Constructor Phalcon\Di

```php
public function attempt( string $name, mixed $definition, bool $shared = bool ): ServiceInterface | bool;
```

Intenta registrar un servicio en el contenedor de servicios Sólo será exitoso si no ha sido registrado ningún servicio previamente con el mismo nombre

```php
public function get( string $name, mixed $parameters = null ): mixed;
```

Resuelve el servicio según su configuración

```php
public static function getDefault(): DiInterface | null;
```

Devuelve el último DI creado

```php
public function getInternalEventsManager(): ManagerInterface | null;
```

Devuelve el administrador de eventos interno

```php
public function getRaw( string $name ): mixed;
```

Devuelve una definición de servicio sin resolver

```php
public function getService( string $name ): ServiceInterface;
```

Devuelve una instancia Phalcon\Di\Service

```php
public function getServices(): ServiceInterface[];
```

Devuelve los servicios registrados en el DI

```php
public function getShared( string $name, mixed $parameters = null ): mixed;
```

Resuelve un servicio, el servicio resuelto se almacena en el DI, las siguientes peticiones de este servicio devolverán la misma instancia

```php
public function has( string $name ): bool;
```

Comprueba si el DI contiene un servicio por un nombre

```php
public function loadFromPhp( string $filePath ): void;
```

Carga servicios desde un fichero de configuración php.

```php
$di->loadFromPhp("path/services.php");
```

Y los servicios se pueden especificar en un fichero como:

```php
return [
     'myComponent' => [
         'className' => '\Acme\Components\MyComponent',
         'shared' => true,
     ],
     'group' => [
         'className' => '\Acme\Group',
         'arguments' => [
             [
                 'type' => 'service',
                 'service' => 'myComponent',
             ],
         ],
     ],
     'user' => [
         'className' => '\Acme\User',
     ],
];
```

@link https://docs.phalcon.io/en/latest/reference/di.html

```php
public function loadFromYaml( string $filePath, array $callbacks = null ): void;
```

Carga servicios desde un fichero yaml.

```php
$di->loadFromYaml(
    "path/services.yaml",
    [
        "!approot" => function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);
```

Y los servicios se pueden especificar en un fichero como:

```php
myComponent:
    className: \Acme\Components\MyComponent
    shared: true

group:
    className: \Acme\Group
    arguments:

        - type: service
          name: myComponent

user:
   className: \Acme\User
```

@link https://docs.phalcon.io/en/latest/reference/di.html

```php
public function offsetExists( mixed $name ): bool;
```

Comprueba si un servicio está registrando usando la sintaxis vector

```php
public function offsetGet( mixed $name ): mixed;
```

Permite obtener un servicio compartido usando la sintaxis vector

```php
var_dump($di["request"]);
```

```php
public function offsetSet( mixed $name, mixed $definition ): void;
```

Permite registrar un servicio compartido usando la sintaxis vector

```php
$di["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset( mixed $name ): void;
```

Elimina un servicio del contenedor de servicios usando la sintaxis vector

```php
public function register( ServiceProviderInterface $provider ): void;
```

Registra un proveedor de servicios.

```php
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared(
            'service',
            function () {
                // ...
            }
        );
    }
}
```

```php
public function remove( string $name ): void;
```

Elimina un servicio en el contenedor de servicios También elimina cualquier instancia compartida creada para el servicio

```php
public static function reset(): void;
```

Resetea el *DI* interno predeterminado

```php
public function set( string $name, mixed $definition, bool $shared = bool ): ServiceInterface;
```

Registra un servicio en el contenedor de servicios

```php
public static function setDefault( DiInterface $container ): void;
```

Establece un contenedor de inyección de dependencias predeterminado para ser obtenido en métodos estáticos

```php
public function setInternalEventsManager( ManagerInterface $eventsManager );
```

Establece el gestor de eventos interno

```php
public function setService( string $name, ServiceInterface $rawDefinition ): ServiceInterface;
```

Establece un servicio usando una definición `Phalcon\Di\Service` sin procesar

```php
public function setShared( string $name, mixed $definition ): ServiceInterface;
```

Registra un servicio "siempre compartido" en el contenedor de servicios

```php
protected function loadFromConfig( ConfigInterface $config ): void;
```

Carga servicios desde un objeto `Config`.

<h1 id="di-abstractinjectionaware">Abstract Class Phalcon\Di\AbstractInjectionAware</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/AbstractInjectionAware.zep)

| Namespace | Phalcon\Di | | Implements | InjectionAwareInterface |

Esta clase abstracta ofrece acceso común al DI en una clase

## Propiedades

```php
/**
 * Dependency Injector
 *
 * @var DiInterface
 */
protected container;

```

## Métodos

```php
public function getDI(): DiInterface;
```

Devuelve el inyector de dependencias interno

```php
public function setDI( DiInterface $container ): void;
```

Configura el inyector de dependencia

<h1 id="di-diinterface">Interface Phalcon\Di\DiInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/DiInterface.zep)

| Namespace | Phalcon\Di | | Uses | ArrayAccess | | Extends | ArrayAccess |

Interfaz para Phalcon\Di

## Métodos

```php
public function attempt( string $name, mixed $definition, bool $shared = bool ): ServiceInterface | bool;
```

Intenta registrar un servicio en el contenedor de servicios Sólo será exitoso si no ha sido registrado ningún servicio previamente con el mismo nombre

```php
public function get( string $name, mixed $parameters = null ): mixed;
```

Resuelve el servicio según su configuración

```php
public static function getDefault(): DiInterface | null;
```

Devuelve el último DI creado

```php
public function getRaw( string $name ): mixed;
```

Devuelve una definición de servicio sin resolver

```php
public function getService( string $name ): ServiceInterface;
```

Devuelve la correspondiente instancia Phalcon\Di\Service para un servicio

```php
public function getServices(): ServiceInterface[];
```

Devuelve los servicios registrados en el DI

```php
public function getShared( string $name, mixed $parameters = null ): mixed;
```

Devuelve un servicio compartido según su configuración

```php
public function has( string $name ): bool;
```

Comprueba si el DI contiene un servicio por un nombre

```php
public function remove( string $name ): void;
```

Devuelve un servicio del contenedor de servicios

```php
public static function reset(): void;
```

Resetea el *DI* interno predeterminado

```php
public function set( string $name, mixed $definition, bool $shared = bool ): ServiceInterface;
```

Registra un servicio en el contenedor de servicios

```php
public static function setDefault( DiInterface $container ): void;
```

Establece un contenedor de inyección de dependencias predeterminado para ser obtenido en métodos estáticos

```php
public function setService( string $name, ServiceInterface $rawDefinition ): ServiceInterface;
```

Establece un servicio usando una definición `Phalcon\Di\Service` sin procesar

```php
public function setShared( string $name, mixed $definition ): ServiceInterface;
```

Registra un servicio "siempre compartido" en el contenedor de servicios

<h1 id="di-exception">Class Phalcon\Di\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/Exception.zep)

| Namespace | Phalcon\Di | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Di usarán esta clase

<h1 id="di-exception-serviceresolutionexception">Class Phalcon\Di\Exception\ServiceResolutionException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/Exception/ServiceResolutionException.zep)

| Namespace | Phalcon\Di\Exception | | Extends | \Phalcon\Di\Exception |

Phalcon\Di\Exception\ServiceResolutionException

<h1 id="di-factorydefault">Class Phalcon\Di\FactoryDefault</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/FactoryDefault.zep)

| Namespace | Phalcon\Di | | Uses | Phalcon\Filter\FilterFactory | | Extends | \Phalcon\Di |

Esta es una variante del estándar Phalcon\Di. Por defecto, registra automáticamente todos los servicios proporcionados por el framework. Gracias a esto, el desarrollador no necesita registrar cada servicio individualmente proporcionando un framework de pila completa

## Métodos

```php
public function __construct();
```

Constructor Phalcon\Di\FactoryDefault

<h1 id="di-factorydefault-cli">Class Phalcon\Di\FactoryDefault\Cli</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/FactoryDefault/Cli.zep)

| Namespace | Phalcon\Di\FactoryDefault | | Uses | Phalcon\Di\FactoryDefault, Phalcon\Di\Service, Phalcon\Filter\FilterFactory | | Extends | FactoryDefault |

Phalcon\Di\FactoryDefault\Cli

Esta es una variante del estándar Phalcon\Di. Por defecto, registra automáticamente todos los servicios proporcionados por el framework. Gracias a esto, el desarrollador no necesita registrar cada servicio individualmente. Esta clase es especialmente apropiada para aplicaciones CLI

## Métodos

```php
public function __construct();
```

Constructor Phalcon\Di\FactoryDefault\Cli

<h1 id="di-injectable">Abstract Class Phalcon\Di\Injectable</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/Injectable.zep)

| Namespace | Phalcon\Di | | Uses | Phalcon\Di, Phalcon\Session\BagInterface | | Implements | InjectionAwareInterface |

Esta clase permite acceder a servicios en el contenedor de servicios simplemente accediendo a una propiedad pública con el mismo nombre que el servicio registrado

@property \Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher @property \Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router @property \Phalcon\Url|\Phalcon\Url\UrlInterface $url @property \Phalcon\Http\Request|\Phalcon\Http\RequestInterface $request @property \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface $response @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies @property \Phalcon\Filter $filter @property \Phalcon\Flash\Direct $flash @property \Phalcon\Flash\Session $flashSession @property \Phalcon\Session\ManagerInterface $session @property \Phalcon\Events\Manager|\Phalcon\Events\ManagerInterface $eventsManager @property \Phalcon\Db\Adapter\AdapterInterface $db @property \Phalcon\Security $security @property \Phalcon\Crypt|\Phalcon\CryptInterface $crypt @property \Phalcon\Tag $tag @property \Phalcon\Escaper|\Phalcon\Escaper\EscaperInterface $escaper @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter $annotations @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata @property \Phalcon\Mvc\Model\Transaction\Manager|\Phalcon\Mvc\Model\Transaction\ManagerInterface $transactionManager @property \Phalcon\Assets\Manager $assets @property \Phalcon\Di|\Phalcon\Di\DiInterface $di @property \Phalcon\Session\Bag|\Phalcon\Session\BagInterface $persistent @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view

## Propiedades

```php
/**
 * Dependency Injector
 *
 * @var DiInterface
 */
protected container;

```

## Métodos

```php
public function __get( string $propertyName ): mixed | null;
```

Método mágico __get

```php
public function __isset( string $name ): bool;
```

Método mágico __isset

```php
public function getDI(): DiInterface;
```

Devuelve el inyector de dependencias interno

```php
public function setDI( DiInterface $container ): void;
```

Configura el inyector de dependencias

<h1 id="di-injectionawareinterface">Interface Phalcon\Di\InjectionAwareInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/InjectionAwareInterface.zep)

| Namespace | Phalcon\Di |

Esta interfaz se debe implementar en aquellas clases que usan internamente el Phalcon\Di que las crea

## Métodos

```php
public function getDI(): DiInterface;
```

Devuelve el inyector de dependencias interno

```php
public function setDI( DiInterface $container ): void;
```

Configura el inyector de dependencia

<h1 id="di-service">Class Phalcon\Di\Service</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/Service.zep)

| Namespace | Phalcon\Di | | Uses | Closure, Phalcon\Di\Exception\ServiceResolutionException, Phalcon\Di\Service\Builder | | Implements | ServiceInterface |

Representa individualmente a un servicio en el contenedor de servicios

```php
$service = new \Phalcon\Di\Service(
    "request",
    \Phalcon\Http\Request::class
);

$request = service->resolve();
```

## Propiedades

```php
//
protected definition;

/**
 * @var bool
 */
protected resolved = false;

/**
 * @var bool
 */
protected shared = false;

//
protected sharedInstance;

```

## Métodos

```php
final public function __construct( mixed $definition, bool $shared = bool );
```

Phalcon\Di\Service

```php
public function getDefinition(): mixed;
```

Obtiene la definición del servicio

```php
public function getParameter( int $position );
```

Obtiene un parámetro en una posición específica

```php
public function isResolved(): bool;
```

Devuelve `true` si se resolvió el servicio

```php
public function isShared(): bool;
```

Comprueba si el servicio es compartido o no

```php
public function resolve( mixed $parameters = null, DiInterface $container = null ): mixed;
```

Resuelve el servicio

```php
public function setDefinition( mixed $definition ): void;
```

Establece la definición del servicio

```php
public function setParameter( int $position, array $parameter ): ServiceInterface;
```

Cambia un parámetro en la definición sin resolver el servicio

```php
public function setShared( bool $shared ): void;
```

Establece si el servicio es compartido o no

```php
public function setSharedInstance( mixed $sharedInstance ): void;
```

Establece/Reestablece la instancia compartida relacionada con el servicio

<h1 id="di-service-builder">Class Phalcon\Di\Service\Builder</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/Service/Builder.zep)

| Namespace | Phalcon\Di\Service | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\Exception |

Phalcon\Di\Service\Builder

Esta clase construye instancias según definiciones complejas

## Métodos

```php
public function build( DiInterface $container, array $definition, mixed $parameters = null );
```

Construye un servicio usando una definición de servicio compleja

<h1 id="di-serviceinterface">Interface Phalcon\Di\ServiceInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/ServiceInterface.zep)

| Namespace | Phalcon\Di |

Representa un servicio en el contenedor de servicios

## Métodos

```php
public function getDefinition(): mixed;
```

Devuelve la definición del servicio

```php
public function getParameter( int $position );
```

Devuelve un parámetro en una posición específica

```php
public function isResolved(): bool;
```

Devuelve `true` si se resolvió el servicio

```php
public function isShared(): bool;
```

Comprueba si el servicio es compartido o no

```php
public function resolve( mixed $parameters = null, DiInterface $container = null ): mixed;
```

Resuelve el servicio

```php
public function setDefinition( mixed $definition );
```

Establece la definición del servicio

```php
public function setParameter( int $position, array $parameter ): ServiceInterface;
```

Cambia un parámetro en la definición sin resolver el servicio

```php
public function setShared( bool $shared );
```

Establece si el servicio es compartido o no

<h1 id="di-serviceproviderinterface">Interface Phalcon\Di\ServiceProviderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Di/ServiceProviderInterface.zep)

| Namespace | Phalcon\Di |

Se debería implementar por proveedores de servicio, o aquellos componentes que registran un servicio en el contenedor de servicios.

```php
namespace Acme;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared(
            'service',
            function () {
                // ...
            }
        );
    }
}
```

## Métodos

```php
public function register( DiInterface $di ): void;
```

Registra un proveedor de servicios.
