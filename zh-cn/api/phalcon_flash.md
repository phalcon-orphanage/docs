---
layout: default
title: 'Phalcon\Flash'
---

* [Phalcon\Flash\AbstractFlash](#flash-abstractflash)
* [Phalcon\Flash\Direct](#flash-direct)
* [Phalcon\Flash\Exception](#flash-exception)
* [Phalcon\Flash\FlashInterface](#flash-flashinterface)
* [Phalcon\Flash\Session](#flash-session)

<h1 id="flash-abstractflash">Abstract Class Phalcon\Flash\AbstractFlash</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/AbstractFlash.zep)

| Namespace  | Phalcon\Flash | | Uses       | Phalcon\Di\Di, Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Html\Escaper\EscaperInterface, Phalcon\Session\ManagerInterface, Phalcon\Support\Helper\Str\Interpolate | | Extends    | AbstractInjectionAware | | Implements | FlashInterface |

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS

```php
$flash->success("The record was successfully deleted");
$flash->error("Cannot open the file");
```

Class AbstractFlash

@package Phalcon\Flash


## Properties
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
 * @var array
 */
protected cssIconClasses;

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
 * @var Interpolate
 */
protected interpolator;

/**
 * @var array
 */
protected messages;

/**
 * @var SessionInterface|null
 */
protected sessionService;

```

## Methods

```php
public function __construct( EscaperInterface $escaper = null, SessionInterface $session = null );
```
AbstractFlash constructor.


```php
public function clear(): void;
```
Clears accumulated messages when implicit flush is disabled


```php
public function error( string $message ): string | null;
```
Shows a HTML error message

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
public function getCssIconClasses(): array
```

```php
public function getCustomTemplate(): string
```

```php
public function getEscaperService(): EscaperInterface;
```
Returns the Escaper Service


```php
public function notice( string $message ): string | null;
```
Shows a HTML notice/information message

```php
$flash->notice("This is an information");
```


```php
public function outputMessage( string $type, mixed $message ): string | null;
```
Outputs a message formatting it with HTML

```php
$flash->outputMessage("error", $message);
```


```php
public function setAutoescape( bool $autoescape ): AbstractFlash;
```
Set the autoescape mode in generated HTML


```php
public function setAutomaticHtml( bool $automaticHtml ): AbstractFlash;
```
Set if the output must be implicitly formatted with HTML


```php
public function setCssClasses( array $cssClasses ): AbstractFlash;
```
Set an array with CSS classes to format the messages


```php
public function setCssIconClasses( array $cssIconClasses ): AbstractFlash;
```
Set an array with CSS classes to format the icon messages


```php
public function setCustomTemplate( string $customTemplate ): AbstractFlash;
```
Set a custom template for showing the messages


```php
public function setEscaperService( EscaperInterface $escaperService ): AbstractFlash;
```
Sets the Escaper Service


```php
public function setImplicitFlush( bool $implicitFlush ): AbstractFlash;
```
Set whether the output must be implicitly flushed to the output or returned as string


```php
public function success( string $message ): string | null;
```
Shows a HTML success message

```php
$flash->success("The process was finished successfully");
```


```php
public function warning( string $message ): string | null;
```
Shows a HTML warning message

```php
$flash->warning("Hey, this is important");
```




<h1 id="flash-direct">Class Phalcon\Flash\Direct</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/Direct.zep)

| Namespace  | Phalcon\Flash | | Extends    | AbstractFlash |

Class Direct

@package Phalcon\Flash


## Methods

```php
public function message( string $type, mixed $message ): string | null;
```
Outputs a message


```php
public function output( bool $remove = bool ): void;
```
Prints the messages accumulated in the flasher




<h1 id="flash-exception">Class Phalcon\Flash\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/Exception.zep)

| Namespace  | Phalcon\Flash | | Extends    | \Exception |

Exceptions thrown in Phalcon\Flash classes will use this class



<h1 id="flash-flashinterface">Interface Phalcon\Flash\FlashInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/FlashInterface.zep)

| Namespace  | Phalcon\Flash |

Interface FlashInterface

@package Phalcon\Flash


## Methods

```php
public function error( string $message ): string | null;
```
Shows a HTML error message


```php
public function message( string $type, string $message ): string | null;
```
Outputs a message


```php
public function notice( string $message ): string | null;
```
Shows a HTML notice/information message


```php
public function success( string $message ): string | null;
```
Shows a HTML success message


```php
public function warning( string $message ): string | null;
```
Shows a HTML warning message




<h1 id="flash-session">Class Phalcon\Flash\Session</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Flash/Session.zep)

| Namespace  | Phalcon\Flash | | Uses       | Phalcon\Session\ManagerInterface | | Extends    | AbstractFlash |

This is an implementation of the Phalcon\Flash\FlashInterface that temporarily stores the messages in session, then messages can be printed in the next request.

Class Session

@package Phalcon\Flash


## 常量
```php
const SESSION_KEY = _flashMessages;
```

## Methods

```php
public function clear(): void;
```
Clear messages in the session messenger

@throws Exception


```php
public function getMessages( mixed $type = null, bool $remove = bool ): array;
```
Returns the messages in the session flasher


```php
public function getSessionService(): ManagerInterface;
```
Returns the Session Service


```php
public function has( string $type = null ): bool;
```
Checks whether there are messages


```php
public function message( string $type, mixed $message ): string | null;
```
Adds a message to the session flasher


```php
public function output( bool $remove = bool ): void;
```
Prints the messages in the session flasher


```php
protected function getSessionMessages( bool $remove, string $type = null ): array;
```
Returns the messages stored in session


```php
protected function setSessionMessages( array $messages ): array;
```
Stores the messages in session
