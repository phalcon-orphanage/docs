---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Domain/Payload/Payload.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Throwable | | Implements | PayloadInterface |

Mantiene la carga útil

## Propiedades

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

## Métodos

```php
public function getException(): Throwable | null;
```

Obtiene la excepción potencial lanzada en la capa de dominio

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
public function setException( Throwable $exception ): PayloadInterface;
```

Establece una excepción lanzada en el dominio

```php
public function setExtras( mixed $extras ): PayloadInterface;
```

Establece información adicional del dominio arbitraria.

```php
public function setInput( mixed $input ): PayloadInterface;
```

Establece la entrada del dominio.

```php
public function setMessages( mixed $messages ): PayloadInterface;
```

Establece los mensajes del dominio.

```php
public function setOutput( mixed $output ): PayloadInterface;
```

Establece la salida del dominio.

```php
public function setStatus( mixed $status ): PayloadInterface;
```

Establece el estado de la carga útil.

<h1 id="domain-payload-payloadfactory">Class Phalcon\Domain\Payload\PayloadFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Domain/Payload/PayloadFactory.zep)

| Namespace | Phalcon\Domain\Payload |

Factoría para crear objetos de carga útil

## Métodos

```php
public function newInstance(): PayloadInterface;
```

Instancia un nuevo objeto

<h1 id="domain-payload-payloadinterface">Interface Phalcon\Domain\Payload\PayloadInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Domain/Payload/PayloadInterface.zep)

| Namespace | Phalcon\Domain\Payload | | Extends | ReadableInterface |

Esta interfaz se usa para consumidores

<h1 id="domain-payload-readableinterface">Interface Phalcon\Domain\Payload\ReadableInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Domain/Payload/ReadableInterface.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Throwable |

Esta interfaz se usa para consumidores (sólo lectura)

## Métodos

```php
public function getException(): Throwable | null;
```

Obtiene la excepción potencial lanzada en la capa de dominio

```php
public function getExtras(): mixed;
```

Obtiene los valores adicionales arbitrarios producidos por la capa de dominio.

```php
public function getInput(): mixed;
```

Obtiene la entrada recibida por la capa de dominio.

```php
public function getMessages(): mixed;
```

Obtiene los mensajes producidos por la capa de dominio.

```php
public function getOutput(): mixed;
```

Obtiene la salida producida desde la capa de dominio.

```php
public function getStatus(): mixed;
```

Obtiene el estado de esta carga útil.

<h1 id="domain-payload-status">Class Phalcon\Domain\Payload\Status</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Domain/Payload/Status.zep)

| Namespace | Phalcon\Domain\Payload |

Mantiene los códigos de estado de la carga útil

## Constantes

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

## Métodos

```php
final private function __construct();
```

Instanciación no permitida.

<h1 id="domain-payload-writeableinterface">Interface Phalcon\Domain\Payload\WriteableInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Domain/Payload/WriteableInterface.zep)

| Namespace | Phalcon\Domain\Payload | | Uses | Throwable |

Esta interfaz se usa para consumidores (escritura)

## Métodos

```php
public function setException( Throwable $exception ): PayloadInterface;
```

Establece una excepción producida por la capa de dominio.

```php
public function setExtras( mixed $extras ): PayloadInterface;
```

Establece valores adicionales arbitrarios producidos por la capa de dominio.

```php
public function setInput( mixed $input ): PayloadInterface;
```

Establece la entrada recibida por la capa de dominio.

```php
public function setMessages( mixed $messages ): PayloadInterface;
```

Establece los mensajes producidos por la capa de dominio.

```php
public function setOutput( mixed $output ): PayloadInterface;
```

Establece la salida producida desde la capa de dominio.

```php
public function setStatus( mixed $status ): PayloadInterface;
```

Establece el estado de esta carga útil.
