---
layout: default
version: '4.0'
title: 'Collection'
keywords: 'collection, arrayaccess, countable, iteratoraggregate, jsonserializeable, serializable'
---

# Collection

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Επισκόπηση

`Phalcon\Collection` είναι μια συστοιχία με πρόσβαση σαν αντικείμενο. It offers speed, as well as implementations of various PHP interfaces. These are:

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

## Κατασκευαστής

Μπορείτε να κατασκευάσετε το αντικείμενο όπως οποιοδήποτε άλλο αντικείμενο στην PHP. Ωστόσο, ο κατασκευαστής δέχεται μια προαιρετική παράμετρο `array`, η οποία θα συμπληρώσει το αντικείμενο για εσάς.

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

## Ευαισθησία πεζών-κεφαλαίων

Όταν εγκαθιστάτε το αντικείμενο μπορείτε να καθορίσετε μια δεύτερη παράμετρο `bool`, η οποία θα ελέγχει το κλειδί που ψάχνει στο αντικείμενο. Από προεπιλογή `$insensitive` έχει οριστεί σε `true`, καθιστώντας τις αναζητήσεις σε περίπτωση συλλογής μη ευαίσθητες. Ο ορισμός αυτής της τιμής σε `false` θα κάνει την αναζήτηση για το στοιχείο με ευαίσθητο τρόπο.

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

## Επαναχρησιμοποίηση

Μπορείτε επίσης να χρησιμοποιήσετε ξανά το στοιχείο, επανατοποθετώντας το. `Phalcon\Collection` εκθέτει τις `clear()` και `init()` μεθόδους, οι οποίες θα καθαρίσουν και θα ξανασυμπληρώσουν τον εσωτερικό πίνακα αντίστοιχα,

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

## Λήψη

Όπως προαναφέρθηκε, το `Phalcon\Collection` υλοποιεί διάφορες διεπαφές, προκειμένου το στοιχείο να καταστεί όσο το δυνατόν πιο ευέλικτο. Η ανάκτηση δεδομένων αποθηκευμένων σε ένα στοιχείο μπορεί να γίνει με τη χρήση:

- Ιδιότητα
- `__get()`
- λήψη από πίνακα (`$collection[$element]`)
- `offsetGet()`
- `get()`

Ο ταχύτερος τρόπος είναι με τη χρήση της σύνταξης ιδιότητας:

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

echo $collection->year;                    // 1776
```

Μπορείς να χρησιμοποιήσεις `__get($element)` αλλά δε συνηστάται καθώς είναι πολύ πιο αργή από τη σύνταξη ιδιότητας. Το ίδιο ισχύει και για το `offsetGet`

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

Η χρήση του `get()` προσφέρει τρεις επιπλέον παραμέτρους. Όταν `$defaultValue` οριστεί στην κλήση και το στοιχείο δεν βρέθηκε, `$defaultValue` θα επιστραφεί. Η παράμετρος `cast` δέχεται μια συμβολοσειρά που καθορίζει τον τύπο της τιμής που θα επιστραφεί. Οι διαθέσιμες τιμές είναι:

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

The collection object also offers two more getters `getKeys` and `getValues` `getKeys( bool $insensitive = true )` returns all the keys stored internally in the collection. By default, it will return the keys case insensitive manner i.e. all lowercase. If `false` is passed in the call, it will return the keys exactly as they have been stored. `getValues` returns the values stored in the internal collection.

## Has

To check whether an element exists or not in the collection, you can use the following:

- `isset()` on the property
- `__isset()`
- array based isset (`isset($coollection[$element])`)
- `offsetExists()`
- `has()`

The fastest way is by using the property syntax:

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

You can use `__isset(element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetExists`

```php
echo $collection->__isset('year');        // true
echo isset($collection['year']);          // true
echo $collection->offsetExists('year');   // true
echo $collection->has('year', true);      // true
```

```php
public function has(string $element):  bool
```

## Set

To set an element in the collection, you can use the following:

- assign the value to the property
- `__set()`
- array based assignment 
- `offsetSet()`
- `set()`

The fastest way is by using the property syntax:

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

You can use `__set($element, $value)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetSet`

```php
$collection->__set('year', 1776);
$collection['year'] = 1776;
$collection->offsetSet('year', 1776);
$collection->set('year', 1776); 
```

## Remove

To remove an element in the collection, you can use the following:

- unset the property
- `__unset()`
- array based unset 
- `offsetUnset()`
- `remove()`

The fastest way is by using the property syntax:

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

You can use `__unset($element)` but it is not advisable as it is much slower than the property syntax. The same applies to `offsetUnset`

```php
$collection->__unset('year');
unset($collection['year']);
$collection->offsetUnset('year');
$collection->remove('year'); 
```

```php
public function remove(string $element):  void
```

## Επαναλήψεις

Since the collection object implements `\IteratorAggregate`, you can iterate through the object with ease. The method `getIterator()` returns an `ArrayIterator()` object

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

## Count

The implementation of the `\Countable` interface exposes the `count()` method, which stores the number of elements in the collection.

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

## Serialization

The `\Serializable` and `\JsonSerializable` interfaces expose methods that allow you to serialize and unserialize the object. `serialize()` and `unserialize()` use PHP's `serialize` and `unserialize` functions. `jsonSerialize()` returns an array which can be used with `json_encode` to serialize the object.

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

echo $collection->serialize();    // a:2:{s:6:"colors";a:3:{i:0;s:3:"red";i:1;s:5:"white";i:2;s:4:"blue";}s:4:"year";i:1776;}

$serialized = 'a:2:{s:6:"colors";a:3:{i:0;s:3:"red";i:1;s:5:"white";i:2;s:4:"blue";}s:4:"year";i:1776;}';
$collection->unserialize($serialized);

echo $collection->jsonSerialize(); // $data
```

## Μεταμορφώσεις

`Phalcon\Collection` also exposes two transformation methods: `toArray()` and `toJson(int $options)`. `toArray()` returns the object transformed as an array. This method returns the same array as `jsonSerialize()`.

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

echo $collection->toArray();  // $data
```

`toJson(int $options)` returns a JSON representation of the object. It uses `json_encode` internally and accepts a parameter, which represents the flags that `json_encode` accepts. By default the options are set up with the value 74, ([RFC4327](https://www.ietf.org/rfc/rfc4627.txt)) which translates to:

- `JSON_HEX_TAG`
- `JSON_HEX_APOS`
- `JSON_HEX_AMP`
- `JSON_HEX_QUOT`
- `JSON_UNESCAPED_SLASHES`

You can pass any valid flags to the method according to your needs.

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

echo $collection->toJson();    // ["red","white","blue"],"year":1776}

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

## Read Only

Phalcon also offers a component that can be used in a read-only fashion. `Phalcon\Collection\ReadOnly` can serve as a collection in your application that can only be populated with initial data but not allowing its contents to be changed throughout the application.

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

echo $collection->toJson();    // ["red","white","blue"],"year":1776}

$collection->set('colors', ['red']); // Exception
```
