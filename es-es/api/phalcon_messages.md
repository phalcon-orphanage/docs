---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Messages'
---

* [Phalcon\Messages\Exception](#messages-exception)
* [Phalcon\Messages\Message](#messages-message)
* [Phalcon\Messages\MessageInterface](#messages-messageinterface)
* [Phalcon\Messages\Messages](#messages-messages)

<h1 id="messages-exception">Class Phalcon\Messages\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Messages/Exception.zep)

| Namespace | Phalcon\Messages | | Extends | \Phalcon\Exception |

Phalcon\Validation\Exception

Las excepciones lanzadas en las clases Phalcon\Messages\* usarán esta clase

<h1 id="messages-message">Class Phalcon\Messages\Message</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Messages/Message.zep)

| Namespace | Phalcon\Messages | | Uses | JsonSerializable | | Implements | MessageInterface, JsonSerializable |

Phalcon\Messages\Message

Almacena un mensaje de varios componentes

## Propiedades

```php
/**
 * @var int
 */
protected code;

/**
 * @var string
 */
protected field;

/**
 * @var string
 */
protected message;

/**
 * @var string
 */
protected type;

/**
 * @var array
 */
protected metaData;

```

## Métodos

```php
public function __construct( string $message, mixed $field = string, string $type = string, int $code = int, array $metaData = [] );
```

Constructor Phalcon\Messages\Message

```php
public function __toString(): string;
```

Método mágico __toString que devuelve un mensaje detallado

```php
public function getCode(): int
```

```php
public function getField(): string
```

```php
public function getMessage(): string
```

```php
public function getMetaData(): array
```

```php
public function getType(): string
```

```php
public function jsonSerialize(): array;
```

Serializa el objeto por json_encode

```php
public function setCode( int $code ): MessageInterface;
```

Establece el código del mensaje

```php
public function setField( mixed $field ): MessageInterface;
```

Establece el campo nombre relacionado con el mensaje

```php
public function setMessage( string $message ): MessageInterface;
```

Establece un mensaje detallado

```php
public function setMetaData( array $metaData ): MessageInterface;
```

Establece los metadatos del mensaje

```php
public function setType( string $type ): MessageInterface;
```

Establece el tipo del mensaje

<h1 id="messages-messageinterface">Interface Phalcon\Messages\MessageInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Messages/MessageInterface.zep)

| Namespace | Phalcon\Messages |

Phalcon\Messages\MessageInterface

Interfaz para Phalcon\Messages\MessageInterface

## Métodos

```php
public function __toString(): string;
```

Método mágico __toString que devuelve un mensaje detallado

```php
public function getCode();
```

Devuelve el código del mensaje relacionado con este mensaje

```php
public function getField();
```

Devuelve el nombre del campo relacionado con el mensaje

```php
public function getMessage(): string;
```

Devuelve un mensaje detallado

```php
public function getMetaData(): array;
```

Devuelve los metadatos del mensaje

```php
public function getType(): string;
```

Devuelve el tipo de mensaje

```php
public function setCode( int $code ): MessageInterface;
```

Establece el código del mensaje

```php
public function setField( string $field ): MessageInterface;
```

Establece el campo nombre relacionado con el mensaje

```php
public function setMessage( string $message ): MessageInterface;
```

Establece un mensaje detallado

```php
public function setMetaData( array $metaData ): MessageInterface;
```

Establece los metadatos del mensaje

```php
public function setType( string $type ): MessageInterface;
```

Establece el tipo del mensaje

<h1 id="messages-messages">Class Phalcon\Messages\Messages</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Messages/Messages.zep)

| Namespace | Phalcon\Messages | | Uses | ArrayAccess, Countable, Iterator, JsonSerializable | | Implements | ArrayAccess, Countable, Iterator, JsonSerializable |

Representa una colección de mensajes

## Propiedades

```php
/**
 * @var int
 */
protected position = 0;

/**
 * @var array
 */
protected messages;

```

## Métodos

```php
public function __construct( array $messages = [] );
```

Constructor Phalcon\Messages\Messages

```php
public function appendMessage( MessageInterface $message );
```

Añade un mensaje a la colección

```php
$messages->appendMessage(
    new \Phalcon\Messages\Message("This is a message")
);
```

```php
public function appendMessages( mixed $messages );
```

Añade un vector de mensajes a la colección

```php
$messages->appendMessages($messagesArray);
```

```php
public function count(): int;
```

Devuelve el número de mensajes en la lista

```php
public function current(): MessageInterface;
```

Devuelve el mensaje actual en el iterador

```php
public function filter( string $fieldName ): array;
```

Filtra la colección de mensajes por nombre de campo

```php
public function jsonSerialize(): array;
```

Devuelve objetos de mensaje serializados como vector por json_encode. Llama jsonSerialize en cada objeto si está presente

```php
$data = $messages->jsonSerialize();
echo json_encode($data);
```

```php
public function key(): int;
```

Devuelve la llave/posición actual del iterador

```php
public function next(): void;
```

Mueve el puntero interno de iteración a la siguiente posición

```php
public function offsetExists( mixed $index ): bool;
```

Comprueba si existe un índice

```php
var_dump(
    isset($message["database"])
);
```

```php
public function offsetGet( mixed $index ): mixed;
```

Obtiene un atributo de un mensaje usando la sintaxis vector

```php
print_r(
    $messages[0]
);
```

```php
public function offsetSet( mixed $index, mixed $message ): void;
```

Establece un atributo usando la sintaxis-vector

```php
$messages[0] = new \Phalcon\Messages\Message("This is a message");
```

```php
public function offsetUnset( mixed $index ): void;
```

Elimina un mensaje de la lista

```php
unset($message["database"]);
```

```php
public function rewind(): void;
```

Rebobina el iterador interno

```php
public function valid(): bool;
```

Comprueba si el mensaje actual en el iterador es válido
