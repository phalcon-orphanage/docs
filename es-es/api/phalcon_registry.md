---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Registry'
---

* [Phalcon\Registry](#registry)

<h1 id="registry">Final Class Phalcon\Registry</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Registry.zep)

| Namespace | Phalcon | | Uses | Traversable | | Extends | Collection |

Phalcon\Registry

Un registro es un contenedor para almacenar objetos y valores en el espacio de la aplicación. Al almacenar el valor en un registro, el mismo objeto siempre está disponible en toda la aplicación.

```php
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

Además de ArrayAccess, Phalcon\Registry también implementa los interfaces Countable (count ($registry) devolverá la cantidad de elementos en el registro), Serializable e Iterator (puede iterar sobre el registro utilizando un bucle foreach). Para PHP 5.4 y superior, se implementa la interfaz JsonSerializable.

Phalcon\\Registry es muy rápido (generalmente es más rápido que cualquier implementación del registro en el espacio de usuario); sin embargo, esto tiene un precio: Phalcon\Registry es una clase final y no se puede heredar.

Aunque Phalcon\\Registry expone métodos como __get(), offsetGet(), count() etc, no se recomienda invocarlos manualmente (estos métodos existen principalmente para hacer coincidir las interfaces que implementa el registro): $registry->__get("property") es varias veces más lento que $registry->property.

Internamente todos los métodos mágicos (e interfaces excepto JsonSerializable) se implementan utilizando manejadores de objetos o técnicas similares: esto permite eludir llamadas a métodos relativamente lentas.

## Métodos

```php
final public function __construct( array $data = null );
```

Constructor

```php
final public function __get( string $element ): mixed;
```

*Getter* mágico para obtener un elemento de la colección

```php
final public function __isset( string $element ): bool;
```

*Isset* mágico para comprobar si un elemento existe o no

```php
final public function __set( string $element, mixed $value ): void;
```

*Setter* mágico para asignar valores a un elemento

```php
final public function __unset( string $element ): void;
```

*Unset* mágico para eliminar un elemento de la colección

```php
final public function clear(): void;
```

Limpia la colección interna

```php
final public function count(): int;
```

Cuenta los elementos de un objeto

@link https://php.net/manual/en/countable.count.php

```php
final public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```

Obtiene el elemento de la colección

```php
final public function getIterator(): Traversable;
```

Devuelve el iterador de la clase

```php
final public function has( string $element ): bool;
```

Determina si un elemento está presente en la colección.

```php
final public function init( array $data = [] ): void;
```

Inicializa el vector interno

```php
final public function jsonSerialize(): array;
```

Especifica los datos que deben ser serializados a JSON

@link https://php.net/manual/en/jsonserializable.jsonserialize.php

```php
final public function offsetExists( mixed $element ): bool;
```

Si existe un desplazamiento

@link https://php.net/manual/en/arrayaccess.offsetexists.php

```php
final public function offsetGet( mixed $element ): mixed;
```

Desplazamiento a obtener

@link https://php.net/manual/en/arrayaccess.offsetget.php

```php
final public function offsetSet( mixed $element, mixed $value ): void;
```

Desplazamiento a establecer

@link https://php.net/manual/en/arrayaccess.offsetset.php

```php
final public function offsetUnset( mixed $element ): void;
```

Desplazamiento a deconfigurar

@link https://php.net/manual/en/arrayaccess.offsetunset.php

```php
final public function remove( string $element ): void;
```

Elimina el elemento de la colección

```php
final public function serialize(): string;
```

Representación del objeto como cadena de texto

@link https://php.net/manual/en/serializable.serialize.php

```php
final public function set( string $element, mixed $value ): void;
```

Establece un elemento en la colección

```php
final public function toArray(): array;
```

Devuelve el objeto en un formato vector

```php
final public function toJson( int $options = int ): string;
```

Devuelve el objeto en un formato JSON

La cadena predeterminada usa las siguientes opciones para *json_encode*

JSON_HEX_TAG, JSON_HEX_APOS, JSON_HEX_AMP, JSON_HEX_QUOT, JSON_UNESCAPED_SLASHES

@see https://www.ietf.org/rfc/rfc4627.txt

```php
final public function unserialize( mixed $serialized ): void;
```

Construye el objeto

@link https://php.net/manual/en/serializable.unserialize.php
