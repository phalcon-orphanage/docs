---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Debug'
---

* [Phalcon\Debug](#debug)
* [Phalcon\Debug\Dump](#debug-dump)
* [Phalcon\Debug\Exception](#debug-exception)

<h1 id="debug">Clase Phalcon\Debug</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Debug.zep)

| Namespace | Phalcon | | Uses | ErrorException, Phalcon\Helper\Arr, Phalcon\Version, Phalcon\Tag, ReflectionClass, ReflectionFunction |

Proporciona capacidades de depuración para aplicaciones Phalcon

## Propiedades

```php
/**
 * @var array
    */
protected blacklist;

//
protected data;

/**
 * @var bool
 */
protected hideDocumentRoot = false;

/**
 * @var bool
 */
protected static isActive;

/**
 * @var bool
 */
protected showBackTrace = true;

/**
 * @var bool
 */
protected showFileFragment = false;

/**
 * @var bool
 */
protected showFiles = true;

/**
 * @var string
    */
protected uri = https://assets.phalcon.io/debug/4.0.x/;

```

## Métodos

```php
public function clearVars(): Debug;
```

Elimina las variables añadidas previamente

```php
public function debugVar( mixed $varz, string $key = null ): Debug;
```

Agrega una variable al resultado de la depuración

```php
public function getCssSources(): string;
```

Devuelve las fuentes CSS

```php
public function getJsSources(): string;
```

Devuelve las fuentes JavaScript

```php
public function getVersion(): string;
```

Genera un enlace a la versión actual de la documentación

```php
public function halt(): void;
```

Detiene la solicitud mostrando una traza inversa

```php
public function listen( bool $exceptions = bool, bool $lowSeverity = bool ): Debug;
```

Escucha excepciones no capturadas y avisos o advertencias no silenciosas

```php
public function listenExceptions(): Debug;
```

Escucha excepciones no capturadas

```php
public function listenLowSeverity(): Debug;
```

Escucha avisos o advertencias no silenciosas

```php
public function onUncaughtException( \Throwable $exception ): bool;
```

Maneja las excepciones no capturadas

```php
public function onUncaughtLowSeverity( mixed $severity, mixed $message, mixed $file, mixed $line, mixed $context ): void;
```

Lanza una excepción cuando se lanza un aviso o advertencia

```php
public function renderHtml( \Throwable $exception ): string;
```

```php
public function setBlacklist( array $blacklist ): Debug;
```

Establece si los archivos deben mostrar la traza inversa de la excepción

```php
public function setShowBackTrace( bool $showBackTrace ): Debug;
```

Establece si los archivos deben mostrar la traza inversa de la excepción

```php
public function setShowFileFragment( bool $showFileFragment ): Debug;
```

Establece si los ficheros se deben abrir y mostrar completamente en la salida o sólo el fragmento relacionado con la excepción

```php
public function setShowFiles( bool $showFiles ): Debug;
```

Establezca si los archivos que forman parte de la traza inversa se deben mostrar en la salida

```php
public function setUri( string $uri ): Debug;
```

Cambia la URI base para recursos estáticos

```php
protected function escapeString( mixed $value ): string;
```

Escapa una cadena con htmlentities

```php
protected function getArrayDump( array $argument, mixed $n = int ): string | null;
```

Produce una representación recursiva de un vector

```php
protected function getVarDump( mixed $variable ): string;
```

Produce una representación de cadena de una variable

```php
final protected function showTraceItem( int $n, array $trace ): string;
```

Muestra un elemento de traza inversa

<h1 id="debug-dump">Class Phalcon\Debug\Dump</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Debug/Dump.zep)

| Namespace | Phalcon\Debug | | Uses | Phalcon\Di, Phalcon\Helper\Json, Reflection, ReflectionClass, ReflectionProperty, stdClass |

Vuelca información de una variable(s)

```php
$foo = 123;

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");
```

```php
$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);
```

## Propiedades

```php
/**
 * @var bool
 */
protected detailed = false;

/**
 * @var array
 */
protected methods;

/**
 * @var array
 */
protected styles;

```

## Métodos

```php
public function __construct( array $styles = [], bool $detailed = bool );
```

Constructor Phalcon\Debug\Dump

```php
public function all(): string;
```

Alias del método variables()

```php
public function getDetailed(): bool
```

```php
public function one( mixed $variable, string $name = null ): string;
```

Alias del método variable()

```php
public function setDetailed( bool $detailed )
```

```php
public function setStyles( array $styles = [] ): array;
```

Establece estilos para el tipo vars

```php
public function toJson( mixed $variable ): string;
```

Devuelve una cadena JSON de información sobre una única variable.

```php
$foo = [
    "key" => "value",
];

echo (new \Phalcon\Debug\Dump())->toJson($foo);

$foo = new stdClass();
$foo->bar = "buz";

echo (new \Phalcon\Debug\Dump())->toJson($foo);
```

```php
public function variable( mixed $variable, string $name = null ): string;
```

Devuelve una cadena HTML de información sobre una única variable.

```php
echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");
```

```php
public function variables(): string;
```

Devuelve una cadena HTML de información de depuración sobre cualquier número de variables, cada una envuelta en una etiqueta "pre".

```php
$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);
```

```php
protected function getStyle( string $type ): string;
```

Obtiene el estilo para el tipo

```php
protected function output( mixed $variable, string $name = null, int $tab = int ): string;
```

Prepara una cadena HTML de información sobre una única variable.

<h1 id="debug-exception">Class Phalcon\Debug\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Debug/Exception.zep)

| Namespace | Phalcon\Debug | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Debug usarán esta clase
