---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Flash'
---

* [Phalcon\Flash\AbstractFlash](#flash-abstractflash)
* [Phalcon\Flash\Direct](#flash-direct)
* [Phalcon\Flash\Exception](#flash-exception)
* [Phalcon\Flash\FlashInterface](#flash-flashinterface)
* [Phalcon\Flash\Session](#flash-session)

<h1 id="flash-abstractflash">Abstract Class Phalcon\Flash\AbstractFlash</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/AbstractFlash.zep)

| Namespace | Phalcon\Flash | | Uses | Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Escaper\EscaperInterface, Phalcon\Session\ManagerInterface | | Extends | AbstractInjectionAware | | Implements | FlashInterface |

Muestra notificaciones HTML relacionadas con diferentes circunstancias. Las clases se pueden estilizar usando CSS

```php
$flash->success("The record was successfully deleted");
$flash->error("Cannot open the file");
```

## Propiedades

```php
/**
 * @var bool
 */
protected autoescape = true;

/**
 * @var bool
 */
protected automaticHtml = true;

/**
 * @var array
 */
protected cssClasses;

/**
 * @var string
 */
protected customTemplate = ;

/**
 * @var EscaperInterface | null
 */
protected escaperService;

/**
 * @var bool
 */
protected implicitFlush = true;

/**
 * @var array
 */
protected messages;

/**
 * @var SessionInterface | null
 */
protected sessionService;

```

## Métodos

```php
public function __construct( EscaperInterface $escaper = null, SessionInterface $session = null );
```

Constructor Phalcon\Flash

```php
public function clear(): void;
```

Limpia los mensajes acumulados cuando el vaciado implícito está deshabilitado

```php
public function error( string $message ): string | null;
```

Muestra un mensaje de error HTML

```php
$flash->error("This is an error");
```

```php
public function getAutoescape(): bool
```

```php
public function getCssClasses(): array
```

```php
public function getCustomTemplate(): string
```

```php
public function getEscaperService(): EscaperInterface;
```

Devuelve un Servicio Escapador

```php
public function notice( string $message ): string | null;
```

Muestra un mensaje de aviso/información HTML

```php
$flash->notice("This is an information");
```

```php
public function outputMessage( string $type, mixed $message );
```

Muestra un mensaje formateándolo con HTML

```php
$flash->outputMessage("error", $message);
```

```php
public function setAutoescape( bool $autoescape ): FlashInterface;
```

Establece el modo autoescapado en el HTML generado

```php
public function setAutomaticHtml( bool $automaticHtml ): FlashInterface;
```

Establece si la salida se debe formatear implícitamente en HTML

```php
public function setCssClasses( array $cssClasses ): FlashInterface;
```

Establece un vector con clases CSS para formatear los mensajes

```php
public function setCustomTemplate( string $customTemplate ): FlashInterface;
```

Establece una plantilla personalizada para mostrar los mensajes

```php
public function setEscaperService( EscaperInterface $escaperService ): FlashInterface;
```

Establece el Servicio Escapador

```php
public function setImplicitFlush( bool $implicitFlush ): FlashInterface;
```

Establece si la salida se debe vaciar implícitamente a la salida o devolución como cadena

```php
public function success( string $message ): string | null;
```

Muestra un mensaje de éxito HTML

```php
$flash->success("The process was finished successfully");
```

```php
public function warning( string $message ): string | null;
```

Muestra un mensaje de advertencia HTML

```php
$flash->warning("Hey, this is important");
```

<h1 id="flash-direct">Class Phalcon\Flash\Direct</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/Direct.zep)

| Namespace | Phalcon\Flash | | Extends | AbstractFlash |

Esta es una implementación de Phalcon\Flash\FlashInterface que muestra inmediatamente cualquier mensaje que se le haya pasado.

## Métodos

```php
public function message( string $type, mixed $message ): string | null;
```

Muestra un mensaje

```php
public function output( bool $remove = bool ): void;
```

Imprime los mensajes acumulados en el flasheador

<h1 id="flash-exception">Class Phalcon\Flash\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/Exception.zep)

| Namespace | Phalcon\Flash | | Extends | \Phalcon\Exception |

Las excepciones lanzadas por Phalcon\Flash usarán esta clase

<h1 id="flash-flashinterface">Interface Phalcon\Flash\FlashInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/FlashInterface.zep)

| Namespace | Phalcon\Flash |

Phalcon\Flash\FlashInterface

Interfaz para clases Phalcon\Flash

## Métodos

```php
public function error( string $message ): string | null;
```

Muestra un mensaje de error HTML

```php
public function message( string $type, string $message ): string | null;
```

Muestra un mensaje

```php
public function notice( string $message ): string | null;
```

Muestra un mensaje de aviso/información HTML

```php
public function success( string $message ): string | null;
```

Muestra un mensaje de éxito HTML

```php
public function warning( string $message ): string | null;
```

Muestra un mensaje de advertencia HTML

<h1 id="flash-session">Class Phalcon\Flash\Session</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/Session.zep)

| Namespace | Phalcon\Flash | | Uses | Phalcon\Di\DiInterface, Phalcon\Session\ManagerInterface | | Extends | AbstractFlash |

Esta es una implementación de Phalcon\Flash\FlashInterface que almacena temporalmente los mensajes en sesión, por lo que los mensajes se pueden imprimir en la siguiente petición.

## Métodos

```php
public function clear(): void;
```

Limpia los mensajes en el mensajero de sesión

```php
public function getMessages( mixed $type = null, bool $remove = bool ): array;
```

Devuelve los mensajes en el flasheador de sesión

```php
public function getSessionService(): ManagerInterface;
```

Devuelve el Servicio Sesión

```php
public function has( mixed $type = null ): bool;
```

Comprueba si hay mensajes

```php
public function message( string $type, string $message ): string | null;
```

Añade un mensaje al flasheador de sesión

```php
public function output( bool $remove = bool ): void;
```

Imprime los mensajes del flasheador de sesión

```php
protected function getSessionMessages( bool $remove, mixed $type = null ): array;
```

Devuelve los mensajes almacenados en sesión

```php
protected function setSessionMessages( array $messages ): array;
```

Almacena los mensajes en sesión
