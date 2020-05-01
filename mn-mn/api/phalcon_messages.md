---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Messages'
---

* [Phalcon\Messages\Exception](#messages-exception)
* [Phalcon\Messages\Message](#messages-message)
* [Phalcon\Messages\MessageInterface](#messages-messageinterface)
* [Phalcon\Messages\Messages](#messages-messages)

<h1 id="messages-exception">Class Phalcon\Messages\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Messages/Exception.zep)

| Namespace | Phalcon\Messages | | Extends | \Phalcon\Exception |

Phalcon\Validation\Exception

Exceptions thrown in Phalcon\Messages\* classes will use this class

<h1 id="messages-message">Class Phalcon\Messages\Message</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Messages/Message.zep)

| Namespace | Phalcon\Messages | | Uses | JsonSerializable | | Implements | MessageInterface, JsonSerializable |

Phalcon\Messages\Message

Stores a message from various components

## Properties

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

## Methods

Phalcon\Messages\Message constructor

```php
public function __construct( string $message, mixed $field = string, string $type = string, int $code = int, array $metaData = [] );
```

Magic __toString method returns verbose message

```php
public function __toString(): string;
```

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

Serializes the object for json_encode

```php
public function jsonSerialize(): array;
```

Sets code for the message

```php
public function setCode( int $code ): MessageInterface;
```

Sets field name related to message

```php
public function setField( mixed $field ): MessageInterface;
```

Sets verbose message

```php
public function setMessage( string $message ): MessageInterface;
```

Sets message metadata

```php
public function setMetaData( array $metaData ): MessageInterface;
```

Sets message type

```php
public function setType( string $type ): MessageInterface;
```

<h1 id="messages-messageinterface">Interface Phalcon\Messages\MessageInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Messages/MessageInterface.zep)

| Namespace | Phalcon\Messages |

Phalcon\Messages\MessageInterface

Interface for Phalcon\Messages\MessageInterface

## Methods

Magic __toString method returns verbose message

```php
public function __toString(): string;
```

Returns the message code related to this message

```php
public function getCode();
```

Returns field name related to message

```php
public function getField();
```

Returns verbose message

```php
public function getMessage(): string;
```

Returns message metadata

```php
public function getMetaData(): array;
```

Returns message type

```php
public function getType(): string;
```

Sets code for the message

```php
public function setCode( int $code ): MessageInterface;
```

Sets field name related to message

```php
public function setField( string $field ): MessageInterface;
```

Sets verbose message

```php
public function setMessage( string $message ): MessageInterface;
```

Sets message metadata

```php
public function setMetaData( array $metaData ): MessageInterface;
```

Sets message type

```php
public function setType( string $type ): MessageInterface;
```

<h1 id="messages-messages">Class Phalcon\Messages\Messages</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Messages/Messages.zep)

| Namespace | Phalcon\Messages | | Uses | ArrayAccess, Countable, Iterator, JsonSerializable | | Implements | ArrayAccess, Countable, Iterator, JsonSerializable |

Represents a collection of messages

## Properties

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

## Methods

Phalcon\Messages\Messages constructor

```php
public function __construct( array $messages = [] );
```

Appends a message to the collection

```php
$messages->appendMessage(
    new \Phalcon\Messages\Message("This is a message")
);
```

```php
public function appendMessage( MessageInterface $message );
```

Appends an array of messages to the collection

```php
$messages->appendMessages($messagesArray);
```

```php
public function appendMessages( mixed $messages );
```

Returns the number of messages in the list

```php
public function count(): int;
```

Returns the current message in the iterator

```php
public function current(): MessageInterface;
```

Filters the message collection by field name

```php
public function filter( string $fieldName ): array;
```

Returns serialised message objects as array for json_encode. Calls jsonSerialize on each object if present

```php
$data = $messages->jsonSerialize();
echo json_encode($data);
```

```php
public function jsonSerialize(): array;
```

Returns the current position/key in the iterator

```php
public function key(): int;
```

Moves the internal iteration pointer to the next position

```php
public function next(): void;
```

Checks if an index exists

```php
var_dump(
    isset($message["database"])
);
```

```php
public function offsetExists( mixed $index ): bool;
```

Gets an attribute a message using the array syntax

```php
print_r(
    $messages[0]
);
```

```php
public function offsetGet( mixed $index ): mixed;
```

Sets an attribute using the array-syntax

```php
$messages[0] = new \Phalcon\Messages\Message("This is a message");
```

```php
public function offsetSet( mixed $index, mixed $message ): void;
```

Removes a message from the list

```php
unset($message["database"]);
```

```php
public function offsetUnset( mixed $index ): void;
```

Rewinds the internal iterator

```php
public function rewind(): void;
```

Check if the current message in the iterator is valid

```php
public function valid(): bool;
```