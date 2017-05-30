# Final class **Phalcon\\Registry**

*implements* [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php), [Countable](http://php.net/manual/en/class.countable.php), [Iterator](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/registry.zep" class="btn btn-default btn-sm">Source on GitHub</a>

A registry is a container for storing objects and values in the application space.
By storing the value in a registry, the same object is always available throughout
your application.

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

In addition to ArrayAccess, Phalcon\\Registry also implements Countable
(count($registry) will return the number of elements in the registry),
Serializable and Iterator (you can iterate over the registry
using a foreach loop) interfaces. For PHP 5.4 and higher, JsonSerializable
interface is implemented.

Phalcon\\Registry is very fast (it is typically faster than any userspace
implementation of the registry); however, this comes at a price:
Phalcon\\Registry is a final class and cannot be inherited from.

Though Phalcon\\Registry exposes methods like __get(), offsetGet(), count() etc,
it is not recommended to invoke them manually (these methods exist mainly to
match the interfaces the registry implements): $registry->__get("property")
is several times slower than $registry->property.

Internally all the magic methods (and interfaces except JsonSerializable)
are implemented using object handlers or similar techniques: this allows
to bypass relatively slow method calls.


## Methods
final public  **__construct** ()

Registry constructor



final public  **offsetExists** (*mixed* $offset)

Checks if the element is present in the registry



final public  **offsetGet** (*mixed* $offset)

Returns an index in the registry



final public  **offsetSet** (*mixed* $offset, *mixed* $value)

Sets an element in the registry



final public  **offsetUnset** (*mixed* $offset)

Unsets an element in the registry



final public  **count** ()

Checks how many elements are in the register



final public  **next** ()

Moves cursor to next row in the registry



final public  **key** ()

Gets pointer number of active row in the registry



final public  **rewind** ()

Rewinds the registry cursor to its beginning



public  **valid** ()

Checks if the iterator is valid



public  **current** ()

Obtains the current value in the internal iterator



final public  **__set** (*mixed* $key, *mixed* $value)

Sets an element in the registry



final public  **__get** (*mixed* $key)

Returns an index in the registry



final public  **__isset** (*mixed* $key)

...


final public  **__unset** (*mixed* $key)

...


