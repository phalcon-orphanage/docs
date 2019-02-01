---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Di\FactoryDefault\Cli'
---
# Class **Phalcon\Di\FactoryDefault\Cli**

*extends* class [Phalcon\Di\FactoryDefault](Phalcon_Di_FactoryDefault)

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/factorydefault/cli.zep)

This is a variant of the standard Phalcon\Di. Por defecto, automáticamente registra todos los servicios provistos por el marco. Gracias a esto, el desarrollador no necesita registrar cada servicio individualmente. Esta clase es especialmente adecuada para aplicaciones CLI

## Métodos

public **__construct** ()

Phalcon\Di\FactoryDefault\Cli constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di](Phalcon_Di)

Configurar el gestor de eventos interno

public **getInternalEventsManager** () inherited from [Phalcon\Di](Phalcon_Di)

Devuelve el administrador de eventos interno

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Registrar un servicio en el contenedor de servicios

public **setShared** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Registra un servicio "siempre compartido" en el contenedor de servicios

public **remove** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Elimina un servicio en el contenedor de servicios. También elimina cualquier instancia compartida creada para el servicio

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Intenta registrar un servicio en el contenedor de servicios. Esto solo es posible si un servicio no ha sido registrado previamente con el mismo nombre

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition) inherited from [Phalcon\Di](Phalcon_Di)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Devuelve una definición de servicio sin resolver

public **getService** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Returns a Phalcon\Di\Service instance

public **get** (*mixed* $name, [*mixed* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Resuelve el servicio basado en su configuración

public *mixed* **getShared** (*string* $name, [*array* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Resuelve un servicio. El servicio resuelto es almacenado en el DI. Las solicitudes subsiguientes para este servicio devolverán la misma instancia

public **has** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Comprueba si el DI contiene un servicio por un nombre

public **wasFreshInstance** () inherited from [Phalcon\Di](Phalcon_Di)

Comprueba si el último servicio obtenido mediante getShared produjo una instancia nueva o una ya existente

public **getServices** () inherited from [Phalcon\Di](Phalcon_Di)

Devuelve los servicios registrados en el DI

public **offsetExists** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Comprueba si un servicio está registrado utilizando la sintaxis del arreglo

public **offsetSet** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Permite registrar un servicio compartido utilizando la sintaxis del arreglo

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Permite obtener un servicio compartido utilizando la sintaxis del arreglo

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Elimina un servicio del contenedor de servicios utilizando la sintaxis del arreglo

public **__call** (*mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Di](Phalcon_Di)

Método mágico para obtener o establecer servicios utilizando setters o getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider) inherited from [Phalcon\Di](Phalcon_Di)

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

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di](Phalcon_Di)

Configura un contenedor de inyección de dependencia por defecto para ser obtenido en métodos estáticos

public static **getDefault** () inherited from [Phalcon\Di](Phalcon_Di)

Devuelve el último DI creado

public static **reset** () inherited from [Phalcon\Di](Phalcon_Di)

Restrablece el DI interno por defecto

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks]) inherited from [Phalcon\Di](Phalcon_Di)

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

public **loadFromPhp** (*mixed* $filePath) inherited from [Phalcon\Di](Phalcon_Di)

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

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Di](Phalcon_Di)

Carga los servicios desde un objeto de Configuración.