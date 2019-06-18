---
layout: default
language: 'th-th'
version: '4.0'
title: 'Phalcon\Collection'
---

# Class [Phalcon\Collection](Phalcon_Collection)

**implements** [ArrayAccess](https://secure.php.net/manual/en/class.arrayaccess.php), [Countable](https://secure.php.net/manual/en/class.countable.php), [IteratorAggregate](https://secure.php.net/manual/en/class.iteratoraggregate.php), [JsonSerializable](https://secure.php.net/manual/en/class.jsonserializable.php), [Serializable](https://secure.php.net/manual/en/class.serializable.php)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/collection.zep)

Phalcon\Collection is a supercharged object oriented array.

It can be used in any part of the application that needs collection of data. Such implementations are for instance accessing globals `$_GET`, `$_POST` etc.

## Properties

```php
protected $data = [];
```

Internal array holding the data of the collection.

```php
protected $lowerKeys = [];
```

Internal array, storing the case insensitive key to the case sensitive key map.

## Methods

```php
public function __construct( [array $data = []] ): void
```

Object Constructor

* * *

```php
public function __get( string $element ): mixed
```

Magic getter to get an element from the collection.

* * *

```php
public function __isset( string $element ): bool
```

Magic `isset` to check whether an element exists or not. This method is **not** case insensitive.

* * *

```php
public function __set( string $element, mixed $value ): void
```

Magic setter to assign values to an element.

* * *

```php
public function __unset( string $element ): void
```

Magic `unset` to remove an element from the collection.

* * *

```php
public function clear(): void
```

Clears the internal collection.

* * *

```php
public function count(): int
```

* * *

```php
public function get( 
    string $element [, mixed $defaultValue = null [, bool $insensitive = true]] 
): bool
```

Get an element element from the collection. The method checks the key of the internal array. The default behavior is to check the key in a case-insensitive manner. If this is not desired, you can pass `false` as the third parameter. You can also supply a default value as the second parameter. It will returned if the element does not exist in the collection.

* * *

```php
public function getIterator(): Traversable
```

Returns the iterator of the class.

* * *

```php
public function has( string $element [, bool $insensitive = true] ): bool
```

Check if an element exists in the collection. The method checks the key of the internal array. The default behavior is to check the key in a case-insensitive manner. If this is not desired, you can pass `false` as the second parameter.

* * *

```php
public function init( [array $data = []] )
```

Initializes the internal collection with the supplied array. This method can be used to repopulate the collection after the object was created. Calling this method will clear the internal array and repopulate it with the supplied data. If an empty array has been supplied or the method is called without parameters, this method operates the same way as `clear()`.

* * *

```php
public function jsonSerialize(): array
```

Specify data which should be serialized to JSON.

* * *

```php
public function offsetGet( mixed $element ): mixed
```

Get an element from the collection.

* * *

```php
public function offsetExists( mixed $element ): bool
```

Check whether an element exists or not. This method is **not** case insensitive.

* * *

```php
public function offsetSet( mixed $element, mixed $value ): void
```

Magic setter to assign values to an element.

* * *

```php
public function offsetUnset( mixed $element ): void
```

Remove an element from the collection.

* * *

```php
public function remove( string $element [, bool $insensitive = true] ): void
```

Remove an element from the collection. The method checks the key of the internal array. The default behavior is to check the key in a case-insensitive manner. If this is not desired, you can pass `false` as the second parameter.

* * *

```php
public function serialize(): string
```

String representation of the object.

* * *

```php
public function set( string $element, mixed $value ): void
```

Assign values to an element.

* * *

```php
public function toArray(): array
```

Returns the object in an array format

* * *

```php
public function toJson(): string
```

Returns the object in a JSON format. The default string uses the following options for `json_encode`: `JSON_HEX_TAG`, `JSON_HEX_APOS`, `JSON_HEX_AMP`, `JSON_HEX_QUOT`, `JSON_UNESCAPED_SLASHES`

* * *

```php
public function unserialize( mixed $serialized ): void
```

Constructs the object by unserializing the passed string. It uses `unserialize` internally. Calling this method will overwrite the internal array.

* * *