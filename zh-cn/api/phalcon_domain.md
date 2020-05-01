---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Domain'
---

* [Phalcon\Domain\Payload\Payload](#domain-payload-payload)
* [Phalcon\Domain\Payload\PayloadFactory](#domain-payload-payloadfactory)
* [Phalcon\Domain\Payload\PayloadInterface](#domain-payload-payloadinterface)
* [Phalcon\Domain\Payload\ReadableInterface](#domain-payload-readableinterface)
* [Phalcon\Domain\Payload\Status](#domain-payload-status)
* [Phalcon\Domain\Payload\WriteableInterface](#domain-payload-writeableinterface)

<h1 id="domain-payload-payload">Class Phalcon\Domain\Payload\Payload</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Domain/Payload/Payload.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Throwable | | Implements | PayloadInterface |

Holds the payload

## Properties

```php
/**
 * Exception if any
 *
 * @var Throwable|null
 */
protected exception;

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

Gets the potential exception thrown in the domain layer

```php
public function getException(): Throwable | null;
```

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

Sets an exception thrown in the domain

```php
public function setException( Throwable $exception ): PayloadInterface;
```

Sets arbitrary extra domain information.

```php
public function setExtras( mixed $extras ): PayloadInterface;
```

Sets the domain input.

```php
public function setInput( mixed $input ): PayloadInterface;
```

Sets the domain messages.

```php
public function setMessages( mixed $messages ): PayloadInterface;
```

Sets the domain output.

```php
public function setOutput( mixed $output ): PayloadInterface;
```

Sets the payload status.

```php
public function setStatus( mixed $status ): PayloadInterface;
```

<h1 id="domain-payload-payloadfactory">Class Phalcon\Domain\Payload\PayloadFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Domain/Payload/PayloadFactory.zep)

| Namespace | Phalcon\Domain\Payload |

Factory to create payload objects

## Methods

Instantiate a new object

```php
public function newInstance(): PayloadInterface;
```

<h1 id="domain-payload-payloadinterface">Interface Phalcon\Domain\Payload\PayloadInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Domain/Payload/PayloadInterface.zep)

| Namespace | Phalcon\Domain\Payload | | Extends | ReadableInterface |

This interface is used for consumers

<h1 id="domain-payload-readableinterface">Interface Phalcon\Domain\Payload\ReadableInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Domain/Payload/ReadableInterface.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Throwable |

This interface is used for consumers (read only)

## Methods

Gets the potential exception thrown in the domain layer

```php
public function getException(): Throwable | null;
```

Gets arbitrary extra values produced by the domain layer.

```php
public function getExtras(): mixed;
```

Gets the input received by the domain layer.

```php
public function getInput(): mixed;
```

Gets the messages produced by the domain layer.

```php
public function getMessages(): mixed;
```

Gets the output produced from the domain layer.

```php
public function getOutput(): mixed;
```

Gets the status of this payload.

```php
public function getStatus(): mixed;
```

<h1 id="domain-payload-status">Class Phalcon\Domain\Payload\Status</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Domain/Payload/Status.zep)

| Namespace | Phalcon\Domain\Payload |

Holds the status codes for the payload

## 常量

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

Instantiation not allowed.

```php
final private function __construct();
```

<h1 id="domain-payload-writeableinterface">Interface Phalcon\Domain\Payload\WriteableInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Domain/Payload/WriteableInterface.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Throwable |

This interface is used for consumers (write)

## Methods

Sets an exception produced by the domain layer.

```php
public function setException( Throwable $exception ): PayloadInterface;
```

Sets arbitrary extra values produced by the domain layer.

```php
public function setExtras( mixed $extras ): PayloadInterface;
```

Sets the input received by the domain layer.

```php
public function setInput( mixed $input ): PayloadInterface;
```

Sets the messages produced by the domain layer.

```php
public function setMessages( mixed $messages ): PayloadInterface;
```

Sets the output produced from the domain layer.

```php
public function setOutput( mixed $output ): PayloadInterface;
```

Sets the status of this payload.

```php
public function setStatus( mixed $status ): PayloadInterface;
```