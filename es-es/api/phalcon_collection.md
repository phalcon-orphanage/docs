---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Collection'
---

- [Phalcon\Collection](#collection)
- [Phalcon\Collection\CollectionInterface](#collection-collectioninterface)
- [Phalcon\Collection\Exception](#collection-exception)
- [Phalcon\Collection\ReadOnly](#collection-readonly)

<h1 id="collection">Class Phalcon\Collection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Collection.zep)

| Namespace | Phalcon | | Uses | ArrayAccess, ArrayIterator, Countable, IteratorAggregate, JsonSerializable, Phalcon\Collection\CollectionInterface, Phalcon\Helper\Json, Serializable, Traversable | | Implements | ArrayAccess, CollectionInterface, Countable, IteratorAggregate, JsonSerializable, Serializable |

`Phalcon\Collection` es un objeto sobrecargado orientado a vector. Implementa:

- [ArrayAccess](https://www.php.net/manual/es/class.arrayaccess.php)
- [Countable](https://www.php.net/manual/es/class.countable.php)
- [IteratorAggregate](https://www.php.net/manual/es/class.iteratoraggregate.php)
- [JsonSerializable](https://www.php.net/manual/es/class.jsonserializable.php)
- [Serializable](https://www.php.net/manual/es/class.serializable.php)

Se puede usar como parte de la aplicación que necesite recolección de datos. Tales implementaciones están por ejemplo al acceder a los globales `$_GET`, `$_POST`, etc.

## Propiedades

```php
/**
 * @var array
 */
protected data;

/**
 * @var bool
 */
protected insensitive = true;

/**
 * @var array
 */
protected lowerKeys;

```

## Métodos

```php
public function __construct( array $data = [], bool $insensitive = bool );
```

Constructor de la colección.

```php
public function __get( string $element ): mixed;
```

*Getter* mágico para obtener un elemento de la colección

```php
public function __isset( string $element ): bool;
```

*Isset* mágico para comprobar si un elemento existe o no

```php
public function __set( string $element, mixed $value ): void;
```

*Setter* mágico para asignar valores a un elemento

```php
public function __unset( string $element ): void;
```

*Unset* mágico para eliminar un elemento de la colección

```php
public function clear(): void;
```

Limpia la colección interna

```php
public function count(): int;
```

Cuenta los elementos de un objeto. Ver [count](https://php.net/manual/en/countable.count.php)

```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```

Obtiene el elemento de la colección

```php
public function getIterator(): Traversable;
```

Devuelve el iterador de la clase

```php
public function getKeys( bool $insensitive = bool ): array;
```

```php
public function getValues(): array;
```

```php
public function has( string $element ): bool;
```

Determina si un elemento está presente en la colección.

```php
public function init( array $data = [] ): void;
```

Inicializa el vector interno

```php
public function jsonSerialize(): array;
```

Especifica los datos que deberían se serializados a JSON. Ver [jsonSerialize](https://php.net/manual/en/jsonserializable.jsonserialize.php)

```php
public function offsetExists( mixed $element ): bool;
```

Indica si existe un desplazamiento. Ver [offsetExists](https://php.net/manual/en/arrayaccess.offsetexists.php)

```php
public function offsetGet( mixed $element );
```

Desplazamiento a obtener. Ver [offsetGet](https://php.net/manual/en/arrayaccess.offsetget.php)

```php
public function offsetSet( mixed $element, mixed $value ): void;
```

Desplazamiento a establecer. Ver [offsetSet](https://php.net/manual/en/arrayaccess.offsetset.php)

```php
public function offsetUnset( mixed $element ): void;
```

Desplazamiento a eliminar. Ver [offsetUnset](https://php.net/manual/en/arrayaccess.offsetunset.php)

```php
public function remove( string $element ): void;
```

Elimina el elemento de la colección

```php
public function serialize(): string;
```

Representación del objeto como cadena. Ver [serialize](https://php.net/manual/en/serializable.serialize.php)

```php
public function set( string $element, mixed $value ): void;
```

Establece un elemento en la colección

```php
public function toArray(): array;
```

Devuelve el objeto en un formato vector

```php
public function toJson( int $options = int ): string;
```

Devuelve el objeto en un formato JSON

La cadena predeterminada usa las siguientes opciones para *json_encode*

`JSON_HEX_TAG`, `JSON_HEX_APOS`, `JSON_HEX_AMP`, `JSON_HEX_QUOT`, `JSON_UNESCAPED_SLASHES`

Ver [rfc4627](https://www.ietf.org/rfc/rfc4627.txt)

```php
public function unserialize( mixed $serialized ): void;
```

Construye el objeto. Ver [unserialize](https://php.net/manual/en/serializable.unserialize.php)

```php
protected function setData( string $element, mixed $value ): void;
```

Método interno para establecer datos

<h1 id="collection-collectioninterface">Interface Phalcon\Collection\CollectionInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Collection/CollectionInterface.zep)

| Namespace | Phalcon\Collection |

Phalcon\Collection\CollectionInterface

Interfaz para la clase Phalcon\Collection

## Métodos

```php
public function __get( string $element ): mixed;
```

```php
public function __isset( string $element ): bool;
```

```php
public function __set( string $element, mixed $value ): void;
```

```php
public function __unset( string $element ): void;
```

```php
public function clear(): void;
```

```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```

```php
public function getKeys( bool $insensitive = bool ): array;
```

```php
public function getValues(): array;
```

```php
public function has( string $element ): bool;
```

```php
public function init( array $data = [] ): void;
```

```php
public function remove( string $element ): void;
```

```php
public function set( string $element, mixed $value ): void;
```

```php
public function toArray(): array;
```

```php
public function toJson( int $options = int ): string;
```

<h1 id="collection-exception">Class Phalcon\Collection\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Collection/Exception.zep)

| Namespace | Phalcon\Collection | | Uses | Throwable | | Extends | \Phalcon\Exception | | Implements | Throwable |

Excepciones para el objeto *Collection*

<h1 id="collection-readonly">Class Phalcon\Collection\ReadOnly</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Collection/ReadOnly.zep)

| Namespace | Phalcon\Collection | | Uses | Phalcon\Collection | | Extends | Collection |

Phalcon\Collection\ReadOnly es un objeto *Collection* de sólo lectura

## Métodos

```php
public function remove( string $element ): void;
```

Elimina el elemento de la colección

```php
public function set( string $element, mixed $value ): void;
```

Establece un elemento en la colección