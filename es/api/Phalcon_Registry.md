# Clase final **Phalcon\\Registry**

*implements* [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php), [Countable](http://php.net/manual/en/class.countable.php), [Iterator](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/registry.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Un registro es un contenedor para almacenar objetos y valores en el espacio de la aplicación. Al almacenar el valor en un registro, el mismo objeto siempre está disponible en todo su aplicación.

```php
<?php

$registry = new \Phalcon\Registry();

// Set value
$registry->something = "something";
// or
$registry["something"] = "something";

// Get value
$value = $registry->something;
// or
$value = $registry["something"];

// Check if the key exists
$exists = isset($registry->something);
// or
$exists = isset($registry["something"]);

// Unset
unset($registry->something);
// or
unset($registry["something"]);

```

Además de ArrayAccess, Phalcon\\Registry también implementa Countable (count ($registry) devolverá la cantidad de elementos en el registro), Serializable e Iterator (puede iterar sobre el registro utilizando un bucle foreach) interfaces. Para PHP 5.4 y superior, JsonSerializable la interfaz está implementada.

Phalcon\\Registry es muy rápido (generalmente es más rápido que cualquier implementación de registro); sin embargo, esto tiene un precio: Phalcon\\Registry es una clase final y no se puede heredada.

Aunque Phalcon\\Registry expone métodos como __get (), offsetGet(), count() etc, no se recomienda invocarlos manualmente (estos métodos existen principalmente para hacer coincidir las interfaces que implementa el registro): $registry->__get("property") es varias veces más lento que $registry->property.

Internamente todos los métodos mágicos (e interfaces excepto JsonSerializable) se implementan utilizando manejadores de objetos o técnicas similares: esto permite para eludir llamadas a métodos relativamente lentos.

## Methods

final public **__construct** ()

Registry constructor

final public **offsetExists** (*mixed* $offset)

Checks if the element is present in the registry

final public **offsetGet** (*mixed* $offset)

Returns an index in the registry

final public **offsetSet** (*mixed* $offset, *mixed* $value)

Sets an element in the registry

final public **offsetUnset** (*mixed* $offset)

Unsets an element in the registry

final public **count** ()

Checks how many elements are in the register

final public **next** ()

Moves cursor to next row in the registry

final public **key** ()

Gets pointer number of active row in the registry

final public **rewind** ()

Rewinds the registry cursor to its beginning

public **valid** ()

Checks if the iterator is valid

public **current** ()

Obtains the current value in the internal iterator

final public **__set** (*mixed* $key, *mixed* $value)

Sets an element in the registry

final public **__get** (*mixed* $key)

Returns an index in the registry

final public **__isset** (*mixed* $key)

...

final public **__unset** (*mixed* $key)

...