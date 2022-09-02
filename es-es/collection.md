---
layout: default
language: 'es-es'
version: '4.0'
title: 'Colección'
keywords: 'colecciones, collection, arrayaccess, countable, iteratoraggregate, jsonserializeable, serializable'
---

# Colección *(Collection)*

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Preámbulo

`Phalcon\Collection` es un arreglo o *array* orientado a objetos. Ofrece velocidad, así como implementaciones de varias interfaces PHP. Estas son:

- [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)
- [Countable](https://php.net/manual/en/class.countable.php)
- [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php)
- [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)
- [Serializable](https://php.net/manual/en/class.serializable.php)

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);
```

## Constructor

Puede construir el objeto como cualquier otro objeto en PHP. Sin embargo, el constructor acepta un parámetro opcional `array`, que rellenará el objeto por usted.

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);
```

## Sensible a mayúsculas

Al instanciar el objeto se puede especificar un segundo parámetro de tipo `bool`, el cual controlará la búsqueda por claves en el objeto. Por defecto `$insensitive` se establece en `true`, haciendo que las búsquedas en la colección sean insensibles a mayúsculas. Establecer este valor en `false` hará que la búsqueda del elemento sea sensible a mayúsculas y minúsculas.

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data, false);

echo $collection->has('COLORS'); // false
```

## Reutilizando

También puede reutilizar el componente, volviéndolo a rellenar. `Phalcon\Collection` expone los métodos `clear()` e `init()` que borrarán y rellenaran la matriz interna respectivamente,

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->count(); // 2

$data = [
    'year' => 1776,
];

$collection->clear();
$collection->init($data);

echo $collection->count(); // 1
```

## *Get*

Como se mencionó anteriormente, `Phalcon\Collection` implementa varias interfaces, con el fin de hacer el componente lo más flexible posible. Recuperar datos almacenados en un elemento se puede hacer mediante el uso:

- Propiedad
- `__get()`
- Acceso como arreglo (`$collection[$element]`)
- `offsetGet()`
- `get()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->year; // 1776
```

Puede usar `__get($element)` pero no es recomendable ya que es mucho más lento que la sintaxis de propiedades. Lo mismo se aplica a `offsetGet`

```php
echo $collection->__get('year');           // 1776
echo $collection['year'];                  // 1776
echo $collection->offsetGet('year');       // 1776
echo $collection->get('year', 1776, true); // 1776
```

```php
public function get(
    string $element, 
    mixed $defaultValue = null, 
    string $cast = null
):  mixed
```

El método `get()` ofrece tres parámetros extra. Cuando `$defaultValue` esté definido en la llamada y no se encuentre el elemento, se devolverá `$defaultValue`. El parámetro `cast` acepta una cadena que define el tipo del valor devuelto. Los valores disponibles son:

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

El objeto de colección también ofrece dos *getters* más `getKeys()` y `getValues()`. `getKeys(bool $insensitive = true)` devuelve todas las claves almacenadas internamente en la colección. De forma predeterminada, devolverá las claves de forma insensible, es decir, todas las minúsculas. Si se pasa `false` en la llamada, retornará las claves exactamente como han sido almacenadas. `getValues()` devuelve los valores almacenados en la colección interna.

## *Has*

Para comprobar si un elemento existe o no en la colección, puede utilizar lo siguiente:

- `isset()` en la propiedad
- `__isset()`
- Acceso como arreglo (`isset($coollection[$element])`)
- `offsetExists()`
- `has()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo isset($collection->year); // true
```

Puedes usar `__isset($element)` pero no es recomendable ya que es mucho más lento que la sintaxis de propiedades. Lo mismo se aplica a `offsetExists`

```php
echo $collection->__isset('year');        // true
echo isset($collection['year']);          // true
echo $collection->offsetExists('year');   // true
echo $collection->has('year', true);      // true
```

```php
public function has(string $element):  bool
```

## *Set*

Para establecer un elemento en la colección, puede utilizar lo siguiente:

- asignar el valor a la propiedad
- `__set()`
- asignación basada en arreglos 
- `offsetSet()`
- `set()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
];

$collection = new Collection($data);

$collection->year = 1776;
```

Puedes usar `__set($element, $value)` pero no es recomendable ya que es mucho más lento que la sintaxis de propiedades. Lo mismo se aplica a `offsetSet`

```php
$collection->__set('year', 1776);
$collection['year'] = 1776;
$collection->offsetSet('year', 1776);
$collection->set('year', 1776); 
```

## *Remove*

Para eliminar un elemento en la colección, puede utilizar lo siguiente:

- desestablecer la propiedad
- `__unset()`
- desestablecer con la sintaxis de arreglos 
- `offsetUnset()`
- `remove()`

La manera más rápida es usando la sintaxis de propiedad:

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
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

use Phalcon\Collection;

$data = [
   'red',
   'white',
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

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->count();    // 2
```

## Serialización

Las interfaces `\Serializable` y `\JsonSerializable` exponen métodos que le permiten serializar y deserializar un objeto. `serialize()` y `unserialize()` utilizan las funciones `serialize` y `unserialize` de PHP. `jsonSerialize()` devuelve un arreglo que puede ser usado con `json_encode()` para serializar el objeto.

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->serialize(); // a:2:{s:6:"colors";a:3:{i:0;s:3:"red";i:1;s:5:"white";i:2;s:4:"blue";}s:4:"year";i:1776;}

$serialized = 'a:2:{s:6:"colors";a:3:{i:0;s:3:"red";i:1;s:5:"white";i:2;s:4:"blue";}s:4:"year";i:1776;}';
$collection->unserialize($serialized);

echo $collection->jsonSerialize(); // $data
```

## Transformaciones

`Phalcon\Collection` también expone dos métodos de transformación: `toArray()` y `toJson(int $options)`. `toArray()` devuelve el objeto transformado como un arreglo. Este método devuelve el mismo *array* que `jsonSerialize()`.

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->toArray(); // $data
```

`toJson(int $options)` devuelve una representación JSON del objeto. Utiliza `json_encode()` internamente y acepta un parámetro, que representa las banderas que `json_encode` acepta. Por defecto, las opciones se configuran con el valor `74`, ([RFC4327](https://www.ietf.org/rfc/rfc4627.txt)) que se traduce a:

- `JSON_HEX_TAG`
- `JSON_HEX_APOS`
- `JSON_HEX_AMP`
- `JSON_HEX_QUOT`
- `JSON_UNESCAPED_SLASHES`

Puede pasar cualquier bandera válida al método según sus necesidades.

```php
<?php

use Phalcon\Collection;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new Collection($data);

echo $collection->toJson(); // ["red","white","blue"],"year":1776}

echo $collection->toJson(74 + JSON_PRETTY_PRINT);
/**
{
    "colors": [
        "red",
        "white",
        "blue"
    ],
    "year": 1776
}
*/
```

## Sólo lectura

Phalcon también ofrece un componente que puede utilizarse de forma de sólo lectura. `Phalcon\Collection\ReadOnly` puede servir como una colección en su aplicación que sólo puede ser establecida con datos iniciales pero no permite que su contenido sea cambiado en toda la aplicación.

```php
<?php

use Phalcon\Collection\ReadOnly;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

$collection = new ReadOnly($data);

echo $collection->toJson(); // ["red","white","blue"],"year":1776}

$collection->set('colors', ['red']); // Exception
```
