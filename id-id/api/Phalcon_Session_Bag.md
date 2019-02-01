---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Session\Bag'
---
# Class **Phalcon\Session\Bag**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Session\BagInterface](Phalcon_Session_BagInterface), [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php), [Traversable](https://php.net/manual/en/class.traversable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/session/bag.zep)

This component helps to separate session data into "namespaces". Working by this way you can easily create groups of session variables into the application

```php
<?php

$user = new \Phalcon\Session\Bag("user");

$user->name = "Kimbra Johnson";
$user->age  = 22;

```

## Metode

public **__construct** (*mixed* $name)

Phalcon\Session\Bag constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **initialize** ()

Initializes the session bag. This method must not be called directly, the class calls it when its internal data is accessed

public **destroy** ()

Hancurkan tas sesi

```php
<?php

$user->destroy();

```

public **set** (*mixed* $property, *mixed* $value)

Menetapkan nilai dalam tas sesi

```php
<?php

$user->set("name", "Kimbra");

```

public **__set** (*mixed* $property, *mixed* $value)

Magic setter untuk menetapkan nilai pada tas sesi

```php
<?php

$user->name = "Kimbra";

```

public **get** (*mixed* $property, [*mixed* $defaultValue])

Mendapatkan nilai dari tas sesi secara opsional menetapkan nilai default

```php
<?php

echo $user->get("name", "Kimbra");

```

public **__get** (*mixed* $property)

Magic getter mendapatkan nilai dari tas sesi

```php
<?php

echo $user->name;

```

public **has** (*mixed* $property)

Periksa apakah sebuah properti didefinisikan di dalam tas internal

```php
<?php

var_dump(
    $user->has("name")
);

```

public **__isset** (*mixed* $property)

Magic isset untuk memeriksa apakah sebuah properti didefinisikan di dalam tas

```php
<?php

var_dump(
    isset($user["name"])
);

```

public **remove** (*mixed* $property)

Menghapus sebuah properti dari tas internal

```php
<?php

$user->remove("name");

```

public **__unset** (*mixed* $property)

Magic unset untuk menghapus item menggunakan sintaks array

```php
<?php

unset($user["name"]);

```

final public **count** ()

Kembalikan Panjang Tas

```php
<?php

echo $user->count();

```

final public **getIterator** ()

 Kembalikan iterator tas

final public **offsetSet** (*mixed* $property, *mixed* $value)

...

final public **offsetExists** (*mixed* $property)

...

final public **offsetUnset** (*mixed* $property)

...

final public **offsetGet** (*mixed* $property)

...