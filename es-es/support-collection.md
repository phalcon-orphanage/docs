---
layout: default
title: 'Coleccion'
upgrade: '#support-collection'
keywords: 'colecciones, collection, arrayaccess, countable, iteratoraggregate, jsonserializeable, serializable'
---

# Coleccion
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
`Phalcon\Support\Collection` is an object-oriented array. Ofrece velocidad, así como implementaciones de varias interfaces PHP. Estas son:

- [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)
- [Countable](https://php.net/manual/en/class.countable.php)
- [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php)
- [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)
- [Serializable](https://php.net/manual/en/class.serializable.php)

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);
```

## Constructor
Puede construir el objeto como cualquier otro objeto en PHP. Sin embargo, el constructor acepta un parámetro opcional `array`, que rellenará el objeto por usted.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);
```

## Sensible a mayúsculas
Al instanciar el objeto se puede especificar un segundo parámetro de tipo `bool`, el cual controlará la búsqueda por claves en el objeto. By default `$insensitive` is set to `true`, making searches in the collection case-insensitive. Setting this value to `false` will make the search for the element in a case-sensitive manner.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data, false);

echo $collection->has('COLORS'); // false
```

## Reutilización
También puede reutilizar el componente, volviéndolo a rellenar. `Phalcon\Support\Collection` exposes the `clear()` and `init()` methods, which will clear and repopulate the internal array respectively,

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->count(); // 2

$data = [
    'year' => 1987,
];

$collection->clear();
$collection->init($data);

echo $collection->count(); // 1
```

## Obtener
As mentioned above, `Phalcon\Support\Collection` implements several interfaces, in order to make the component as flexible as possible. Recuperar datos almacenados en un elemento se puede hacer usando:
- Propiedad
- `__get()`
- Acceso como arreglo (`$collection[$element]`)
- `offsetGet()`
- `get()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->year;                    // 1987
```

Puede usar `__get($element)` pero no es recomendable ya que es mucho más lenta que la sintaxis de propiedad. Lo mismo se aplica a `offsetGet`

```php
echo $collection->__get('year');           // 1987
echo $collection['year'];                  // 1987
echo $collection->offsetGet('year');       // 1987
echo $collection->get('year', 1987, true); // 1987
```

```php
public function get(
    string $element, 
    mixed $defaultValue = null, 
    string $cast = null
):  mixed
```

Using `get()` offers three parameters. `$key` is the key of the element we want to retrieve

If `$defaultValue` is set, it will be returned if the `$key` is not set or the `$key` is set and its value is `null`

The `cast` parameter accepts a string that defines what the returned value will be cast. Los valores disponibles son:

- `array`
- `bool`
- `boolean`
- `double`
- `float`
- `int`
- `integer`
- `null`
- `object`
- `string`

El objeto de colección también ofrece dos *getters* más `getKeys()` y `getValues()`. `getKeys(bool $insensitive = true)` devuelve todas las claves almacenadas internamente en la colección. By default, it will return the keys case-insensitive manner i.e. all lowercase. Si se pasa `false` en la llamada, retornará las claves exactamente como han sido almacenadas. `getValues()` devuelve los valores almacenados en la colección interna.

## Has
Para comprobar si un elemento existe o no en la colección, puede usar lo siguiente:
- `isset()` en la propiedad
- `__isset()`
- Acceso como arreglo (`isset($coollection[$element])`)
- `offsetExists()`
- `has()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo isset($collection->year); // true
```

Puede usar `__isset(element)` pero no es recomendable porque es mucho más lento que la sintaxis de propiedad. Lo mismo se aplica a `offsetExists`

```php
echo $collection->__isset('year');        // true
echo isset($collection['year']);          // true
echo $collection->offsetExists('year');   // true
echo $collection->has('year', true);      // true
```

```php
public function has(string $element):  bool
```

## Establecer
Para establecer un elemento en la colección, puede utilizar lo siguiente:
- asignar el valor a la propiedad
- `__set()`
- asignación basado en vector
- `offsetSet()`
- `set()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
];

$collection = new Collection($data);

$collection->year = 1987;
```

Puedes usar `__set($element, $value)` pero no es recomendable ya que es mucho más lento que la sintaxis de propiedades. Lo mismo se aplica a `offsetSet`

```php
$collection->__set('year', 1987);
$collection['year'] = 1987;
$collection->offsetSet('year', 1987);
$collection->set('year', 1987); 
```

## Eliminar
Para eliminar un elemento en la colección, puede utilizar lo siguiente:
- desestablecer la propiedad
- `__unset()`
- desestablecer basado en vector
- `offsetUnset()`
- `remove()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
];

$collection = new Collection($data);

unset($collection->year);
```

Puedes usar `__unset($element)` pero no es recomendable ya que es mucho más lento que la sintaxis de propiedades. Lo mismo se aplica a `offsetUnset`

```php
$collection->__unset('year');
unset($collection['year']);
$collection->offsetUnset('year');
$collection->remove('year'); 
```

```php
public function remove(string $element):  void
```

## Iteración
Dado que el objeto de colección implementa `\IteratorAggregate`, puedes iterar con facilidad a través del objeto. El método `getIterator()` devuelve un objeto `ArrayIterator()`

```php
<?php

use Phalcon\Support\Collection;

$data = [
   'red',
   'green',
   'blue'
];

$collection = new Collection($data);

foreach ($collection as $key => $value) {
    echo $key . ' - ' . $value . PHP_EOL;
}
```

## Contar
La implementación de la interfaz `\Countable` expone el método `count()`, que almacena el número de elementos en la colección.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->count();    // 2
```

## Serialización
Las interfaces `\Serializable` y `\JsonSerializable` exponen métodos que le permiten serializar y deserializar un objeto. `serialize()` y `unserialize()` utilizan las funciones `serialize` y `unserialize` de PHP. `jsonSerialize()` devuelve un arreglo que puede ser usado con `json_encode()` para serializar el objeto.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->serialize();    
// a:2:{s:6:"colors";a:3:{i:0;s:3:"red";
//  i:1;s:5:"green";i:2;s:4:"blue";}s:4:"year";i:1987;}

$serialized = 'a:2:{s:6:"colors";a:3:{i:0;s:3:"red";'
    . 'i:1;s:5:"green";i:2;s:4:"blue";}s:4:"year";i:1987;}';
$collection->unserialize($serialized);

echo $collection->jsonSerialize(); // $data
```

## Transformaciones
`Phalcon\Support\Collection` also exposes two transformation methods: `toArray()` and `toJson(int $options)`. `toArray()` devuelve el objeto transformado como un arreglo. Este método devuelve el mismo *array* que `jsonSerialize()`.


```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->toArray();  // $data
```

`toJson(int $options)` devuelve una representación JSON del objeto. Utiliza `json_encode()` internamente y acepta un parámetro, que representa las banderas que `json_encode` acepta. By default, the options are set up with the value 79, ([RFC4327](https://www.ietf.org/rfc/rfc4627.txt)) which translates to:

- `JSON_HEX_TAG`
- `JSON_HEX_APOS`
- `JSON_HEX_AMP`
- `JSON_HEX_QUOT`
- `JSON_UNESCAPED_SLASHES`

Puede pasar cualquier bandera válida al método según sus necesidades.

```php
<?php

use Phalcon\Support\Collection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new Collection($data);

echo $collection->toJson();    // ["red","green","blue"],"year":1987}

echo $collection->toJson(74 + JSON_PRETTY_PRINT);
/**
{
    "colors": [
        "red",
        "green",
        "blue"
    ],
    "year": 1987
}
*/
```

## Read Only Collection
Phalcon también ofrece un componente que puede utilizarse de forma de sólo lectura. `Phalcon\Support\Collection\ReadOnlyCollection` can serve as a collection in your application that can only be populated with initial data but not allowing its contents to be changed throughout the application.

> This class has been renamed from `ReadOnly` in order to avoid collisions with PHP 8.x reserved words. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Support\Collection\ReadOnlyCollection;

$data = [
    'colors' => [
        'red',
        'green',
        'blue',
    ],
    'year'   => 1987,
];

$collection = new ReadOnly($data);

echo $collection->toJson();    // ["red","green","blue"],"year":1987}

$collection->set('colors', ['red']); // Exception
```

## Objetos Personalizados
Phalcon allows developers to define their Collection objects. These objects must implement the [Phalcon\Support\Collection\CollectionInterface][support-collection-collectioninterface]:

```php
<?php

namespace MyApp;

use Phalcon\Support\Collection\CollectionInterface

class MyCollection implements CollectionInterface
{
    public function __get(string $element): mixed;

    public function __isset(string $element): bool;

    public function __set(string $element, mixed $value): void;

    public function __unset(string $element): void;

    public function clear(): void;

    public function get(
        string $element, 
        mixed $defaultValue = null, 
        string $cast = null
    ): mixed;

    public function getKeys(bool $insensitive = true): array;

    public function getValues(): array;

    public function has(string $element): bool;

    public function init(array $data = []): void;

    public function remove(string $element): void;

    public function set(string $element, var $value): void;

    public function toArray(): array;

    public function toJson(int $options = 79): string;
}

```


[support-collection-collectioninterface]: api/phalcon_support#support-collection-collectioninterface
