---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Domain'
---

* [Phalcon\Domain\Payload\Payload](#Domain_Payload_Payload)
* [Phalcon\Domain\Payload\PayloadFactory](#Domain_Payload_PayloadFactory)
* [Phalcon\Domain\Payload\PayloadInterface](#Domain_Payload_PayloadInterface)
* [Phalcon\Domain\Payload\ReadableInterface](#Domain_Payload_ReadableInterface)
* [Phalcon\Domain\Payload\Status](#Domain_Payload_Status)
* [Phalcon\Domain\Payload\WriteableInterface](#Domain_Payload_WriteableInterface)

<h1 id="Domain_Payload_Payload">Class Phalcon\Domain\Payload\Payload</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/domain/payload/payload.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Phalcon\Domain\Payload\PayloadInterface | | Implements | PayloadInterface |

Holds the payload

## Properties

```php
/**
 * Extra information
 *
 * @var mixed
 */
protected extras;

/**
 * Input
 *
 * @var mixed
 */
protected input;

/**
 * Messages
 *
 * @var mixed
 */
protected messages;

/**
 * Status
 *
 * @var mixed
 */
protected status;

/**
 * Output
 *
 * @var mixed
 */
protected output;

```

## Methods

```php
public function getExtras(): mixed
```

```php
public function getInput(): mixed
```

```php
public function getMessages(): mixed
```

```php
public function getOutput(): mixed
```

```php
public function getStatus(): mixed
```

```php
public function setExtras( mixed $extras ): PayloadInterface;
```

Sets arbitrary extra domain information.

```php
public function setInput( mixed $input ): PayloadInterface;
```

Sets the domain input.

```php
public function setMessages( mixed $messages ): PayloadInterface;
```

Sets the domain messages.

```php
public function setOutput( mixed $output ): PayloadInterface;
```

Sets the domain output.

```php
public function setStatus( mixed $status ): PayloadInterface;
```

Sets the payload status.

<h1 id="Domain_Payload_PayloadFactory">Class Phalcon\Domain\Payload\PayloadFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/domain/payload/payloadfactory.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Phalcon\Domain\Payload\Payload, Phalcon\Domain\Payload\PayloadInterface |

Factory to create payload objects

## Methods

```php
public function newInstance(): PayloadInterface;
```

Instantiate a new object

<h1 id="Domain_Payload_PayloadInterface">Interface Phalcon\Domain\Payload\PayloadInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/domain/payload/payloadinterface.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Phalcon\Domain\Payload\ReadableInterface, Phalcon\Domain\Payload\WriteableInterface | | Extends | Array |

This interface is used for consumers

<h1 id="Domain_Payload_ReadableInterface">Interface Phalcon\Domain\Payload\ReadableInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/domain/payload/readableinterface.zep)

| Namespace | Phalcon\Domain\Payload |

This interface is used for consumers (read only)

## Methods

```php
public function getExtras(): mixed;
```

Gets arbitrary extra values produced by the domain layer.

```php
public function getInput(): mixed;
```

Gets the input received by the domain layer.

```php
public function getMessages(): mixed;
```

Gets the messages produced by the domain layer.

```php
public function getOutput(): mixed;
```

Gets the output produced from the domain layer.

```php
public function getStatus(): mixed;
```

Gets the status of this payload.

<h1 id="Domain_Payload_Status">Class Phalcon\Domain\Payload\Status</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/domain/payload/status.zep)

| Namespace | Phalcon\Domain\Payload |

Holds the status codes for the payload

## Constants

```php
const ACCEPTED = ACCEPTED;
const AUTHENTICATED = AUTHENTICATED;
const AUTHORIZED = AUTHORIZED;
const CREATED = CREATED;
const DELETED = DELETED;
const ERROR = ERROR;
const FAILURE = FAILURE;
const FOUND = FOUND;
const NOT_ACCEPTED = NOT_ACCEPTED;
const NOT_AUTHENTICATED = NOT_AUTHENTICATED;
const NOT_AUTHORIZED = NOT_AUTHORIZED;
const NOT_CREATED = NOT_CREATED;
const NOT_DELETED = NOT_DELETED;
const NOT_FOUND = NOT_FOUND;
const NOT_UPDATED = NOT_UPDATED;
const NOT_VALID = NOT_VALID;
const PROCESSING = PROCESSING;
const SUCCESS = SUCCESS;
const UPDATED = UPDATED;
const VALID = VALID;
```

## Methods

```php
final private function __construct();
```

Instantiation not allowed.

<h1 id="Domain_Payload_WriteableInterface">Interface Phalcon\Domain\Payload\WriteableInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/domain/payload/writeableinterface.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Phalcon\Domain\Payload\PayloadInterface |

This interface is used for consumers (write)

## Methods

```php
public function setExtras( mixed $extras ): PayloadInterface;
```

Sets arbitrary extra values produced by the domain layer.

```php
public function setInput( mixed $input ): PayloadInterface;
```

Sets the input received by the domain layer.

```php
public function setMessages( mixed $messages ): PayloadInterface;
```

Sets the messages produced by the domain layer.

```php
public function setOutput( mixed $output ): PayloadInterface;
```

Sets the output produced from the domain layer.

```php
public function setStatus( mixed $status ): PayloadInterface;
```

Sets the status of this payload.