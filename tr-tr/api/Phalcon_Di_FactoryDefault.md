---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Di\FactoryDefault'
---
# Class **Phalcon\Di\FactoryDefault**

*extends* class [Phalcon\Di](Phalcon_Di)

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Phalcon\DiInterface](Phalcon_DiInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/factorydefault.zep)

This is a variant of the standard Phalcon\Di. Varsayılan olarak, framework tarafından sağlanan tüm hizmetleri otomatik kaydeder. Bu sayede, geliştiricinin her bir hizmeti ayrı ayrı kaydettirmesi gerekmez; bu, tam bir yığın framework ü sağlar

## Metodlar

genel**__construct** ()

Phalcon\Di\FactoryDefault constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di](Phalcon_Di)

Dahili olay yöneticisini ayarlar

public **getInternalEventsManager** () inherited from [Phalcon\Di](Phalcon_Di)

Dahili olay yöneticisini döndürür

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Servis konteynırının içine bir servis kaydeder

public **setShared** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Registers an "always shared" service in the services container

public **remove** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Hizmetler kapsayıcısındaki bir hizmeti kaldırır Ayrıca hizmet için oluşturulan paylaşılan örneği de kaldırır

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Hizmet konteynerine kayıt olma denemesi yalnızca o servis daha önce aynı isimle kaydedilmediyse başarılı olur

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition) inherited from [Phalcon\Di](Phalcon_Di)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Returns a service definition without resolving

public **getService** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Returns a Phalcon\Di\Service instance

public **get** (*mixed* $name, [*mixed* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Resolves the service based on its configuration

public *mixed* **getShared** (*string* $name, [*array* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Bir hizmeti düzeltir, çözümlenen servis DI'da saklanır, bu hizmet için müteakip talepler aynı örnegi iade edecektir

public **has** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Check whether the DI contains a service by a name

public **wasFreshInstance** () inherited from [Phalcon\Di](Phalcon_Di)

GetShared ile elde edilen son hizmetin yeni bir durum oluşturup oluşturmadığını veya mevcut bir örneği üretip üretmediğini kontrol eder

public **getServices** () inherited from [Phalcon\Di](Phalcon_Di)

Return the services registered in the DI

public **offsetExists** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Check if a service is registered using the array syntax

public **offsetSet** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Dizilim sözdizimini kullanarak paylaşılan bir hizmeti kaydetmeye izin verir

```php
<?php

$di["request"] = new \Phalcon\Http\Request();

```

public **offsetGet** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Dizilim sözdizimini kullanarak paylaşılan bir hizmeti elde etmeyi sağlar

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Removes a service from the services container using the array syntax

public **__call** (*mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Di](Phalcon_Di)

Magic method to get or set services using setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider) inherited from [Phalcon\Di](Phalcon_Di)

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

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di](Phalcon_Di)

Set a default dependency injection container to be obtained into static methods

public static **getDefault** () inherited from [Phalcon\Di](Phalcon_Di)

Return the latest DI created

public static **reset** () inherited from [Phalcon\Di](Phalcon_Di)

Resets the internal default DI

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks]) inherited from [Phalcon\Di](Phalcon_Di)

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

public **loadFromPhp** (*mixed* $filePath) inherited from [Phalcon\Di](Phalcon_Di)

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

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Di](Phalcon_Di)

Loads services from a Config object.