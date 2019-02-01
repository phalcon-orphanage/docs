---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Di'
---
# Class **Phalcon\Di**

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di.zep)

Phalcon\Di is a component that implements Dependency Injection/Service Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\Di is essential to integrate the different components of the framework. Geliştirici, bağımlılıkları enjekte etmek ve uygulamada kullanılan farklı sınıfların genel örneklerini yönetmek için bu bileşeni de kullanabilir.

Temel olarak, bu bileşen `Inversion of Control` modelini uygular. Bunu uygulamak nesneler bağımlılıklarını setterleri veya kurucuları kullanarak almazlar, ancak hizmet bağımlılığı enjektörünü isterler. Bu, bir bileşende gerekli bağımlılıkları elde etmek için yalnızca bir yol olduğundan genel karmaşıklığı azaltır.

Buna ek olarak, bu model koddaki test edilebilirliği artırır, böylece hatalara daha az meyilli olur.

```php
<?php

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

## Metodlar

genel**__construct** ()

Phalcon\Di constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Dahili olay yöneticisini ayarlar

genel **getInternalEventsManager** ()

Dahili olay yöneticisini döndürür

genel **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Servis konteynırının içine bir servis kaydeder

public **setShared** (*mixed* $name, *mixed* $definition)

Registers an "always shared" service in the services container

public **remove** (*mixed* $name)

Hizmetler kapsayıcısındaki bir hizmeti kaldırır Ayrıca hizmet için oluşturulan paylaşılan örneği de kaldırır

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

Hizmet konteynerine kayıt olma denemesi yalnızca o servis daha önce aynı isimle kaydedilmediyse başarılı olur

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name)

Returns a service definition without resolving

public **getService** (*mixed* $name)

Returns a Phalcon\Di\Service instance

public **get** (*mixed* $name, [*mixed* $parameters])

Resolves the service based on its configuration

public *mixed* **getShared** (*string* $name, [*array* $parameters])

Bir hizmeti düzeltir, çözümlenen servis DI'da saklanır, bu hizmet için müteakip talepler aynı örnegi iade edecektir

public **has** (*mixed* $name)

Check whether the DI contains a service by a name

public **wasFreshInstance** ()

GetShared ile elde edilen son hizmetin yeni bir durum oluşturup oluşturmadığını veya mevcut bir örneği üretip üretmediğini kontrol eder

public **getServices** ()

Return the services registered in the DI

public **offsetExists** (*mixed* $name)

Check if a service is registered using the array syntax

public **offsetSet** (*mixed* $name, *mixed* $definition)

Dizilim sözdizimini kullanarak paylaşılan bir hizmeti kaydetmeye izin verir

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name)

Dizilim sözdizimini kullanarak paylaşılan bir hizmeti elde etmeyi sağlar

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name)

Removes a service from the services container using the array syntax

public **__call** (*mixed* $method, [*mixed* $arguments])

Magic method to get or set services using setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider)

Bir servis sağlayıcı kaydeder.

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

Set a default dependency injection container to be obtained into static methods

public static **getDefault** ()

Return the latest DI created

public static **reset** ()

Resets the internal default DI

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks])

Servisleri bir yaml dosyasından yükler.

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

And the services can be specified in the file as:

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

Loads services from a php config file.

```php
<?php

$di->loadFromPhp("path/services.php");

```

And the services can be specified in the file as:

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

Loads services from a Config object.