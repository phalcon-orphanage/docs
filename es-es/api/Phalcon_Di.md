---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Di'
---
# Class **Phalcon\Di**

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di.zep)

Phalcon\Di is a component that implements Dependency Injection/Service Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\Di is essential to integrate the different components of the framework. Los desarrolladores pueden utilizar este componente para inyectar dependencias y administrar las instacias globales de las diferentes clases utilizadas en la aplicacion.

Básicamente, este componente implementa el patrón de `Inversión de Control`. Aplicando esto, los objetos no establecen sus dependencias usando configuradores o constructores, sino solicitando el servicio de un inyector de dependencias. Esto reduce la complejidad total puesto que hay solamente una manera de conseguir las dependencias necesarias dentro de un componente.

Además, este patrón aumenta la posibilidad de pruebas con el código, por lo que es menos propenso a errores.

```php
<? php 

use Phalcon\Di; 
Use Phalcon\Http\Request;

$di = new Di();  

// Utilizando una definicion directa
$di-> set ("request", Request::class, true);  

// Utilizando una función anónima 
$di -> setShared (
   "request", 
   function () 
   {return new Request();     
   } 
   ); 

$request = $di -> getRequest();

```

## Métodos

public **__construct** ()

Phalcon\Di constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Configurar el gestor de eventos interno

public **getInternalEventsManager** ()

Devuelve el administrador de eventos interno

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Registrar un servicio en el contenedor de servicios

public **setShared** (*mixed* $name, *mixed* $definition)

Registra un servicio "siempre compartido" en el contenedor de servicios

public **remove** (*mixed* $name)

Elimina un servicio en el contenedor de servicios. También elimina cualquier instancia compartida creada para el servicio

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Intenta registrar un servicio en el contenedor de servicios. Esto solo es posible si un servicio no ha sido registrado previamente con el mismo nombre

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name)

Devuelve una definición de servicio sin resolver

public **getService** (*mixed* $name)

Returns a Phalcon\Di\Service instance

public **get** (*mixed* $name, [*mixed* $parameters])

Resuelve el servicio basado en su configuración

public *mixed* **getShared** (*string* $name, [*array* $parameters])

Resuelve un servicio. El servicio resuelto es almacenado en el DI. Las solicitudes subsiguientes para este servicio devolverán la misma instancia

public **has** (*mixed* $name)

Comprueba si el DI contiene un servicio por un nombre

public **wasFreshInstance** ()

Comprueba si el último servicio obtenido mediante getShared produjo una instancia nueva o una ya existente

public **getServices** ()

Devuelve los servicios registrados en el DI

public **offsetExists** (*mixed* $name)

Comprueba si un servicio está registrado utilizando la sintaxis del arreglo

public **offsetSet** (*mixed* $name, *mixed* $definition)

Permite registrar un servicio compartido utilizando la sintaxis del arreglo

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name)

Permite obtener un servicio compartido utilizando la sintaxis del arreglo

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name)

Elimina un servicio del contenedor de servicios utilizando la sintaxis del arreglo

public **__call** (*mixed* $method, [*mixed* $arguments])

Método mágico para obtener o establecer servicios utilizando setters o getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider)

Registra un proveedor de servicios.

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared('service', function () {
            // ...
        });
    }
}

```

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura un contenedor de inyección de dependencia por defecto para ser obtenido en métodos estáticos

public static **getDefault** ()

Devuelve el último DI creado

public static **reset** ()

Restrablece el DI interno por defecto

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks])

Carga los servicios desde un archivo yaml.

```php
<?php

$di->loadFromYaml(
    "path/services.yaml",
    [
        "!approot" => function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);

```

Y los servicios pueden ser especificados en el archivo como:

```php
<?php

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

public **loadFromPhp** (*mixed* $filePath)

Carga los servicios desde un archivo de configuración php.

```php
<?php

$di->loadFromPhp("path/services.php");

```

Y los servicios pueden ser especificados en el archivo como:

```php
<?php

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

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config)

Carga los servicios desde un objeto de Configuración.