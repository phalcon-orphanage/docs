---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations'
---

* [Phalcon\Annotations\Adapter\AbstractAdapter](#annotations-adapter-abstractadapter)
* [Phalcon\Annotations\Adapter\AdapterInterface](#annotations-adapter-adapterinterface)
* [Phalcon\Annotations\Adapter\Apcu](#annotations-adapter-apcu)
* [Phalcon\Annotations\Adapter\Memory](#annotations-adapter-memory)
* [Phalcon\Annotations\Adapter\Stream](#annotations-adapter-stream)
* [Phalcon\Annotations\Annotation](#annotations-annotation)
* [Phalcon\Annotations\AnnotationsFactory](#annotations-annotationsfactory)
* [Phalcon\Annotations\Collection](#annotations-collection)
* [Phalcon\Annotations\Exception](#annotations-exception)
* [Phalcon\Annotations\Reader](#annotations-reader)
* [Phalcon\Annotations\ReaderInterface](#annotations-readerinterface)
* [Phalcon\Annotations\Reflection](#annotations-reflection)

<h1 id="annotations-adapter-abstractadapter">Abstract Class Phalcon\Annotations\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Annotations\Adapter | | Uses | Phalcon\Annotations\Reader, Phalcon\Annotations\Exception, Phalcon\Annotations\Collection, Phalcon\Annotations\Reflection, Phalcon\Annotations\ReaderInterface | | Implements | AdapterInterface |

Esta es la clase base para adaptadores Phalcon\Annotations

## Propiedades

```php
/**
 * @var array
 */
protected annotations;

/**
 * @var Reader
 */
protected reader;

```

## Métodos

```php
public function get( mixed $className ): Reflection;
```

Analiza o recupera todas las anotaciones encontradas en una clase

```php
public function getMethod( string $className, string $methodName ): Collection;
```

Devuelve las anotaciones encontradas en un método específico

```php
public function getMethods( string $className ): array;
```

Devuelve las anotaciones encontradas en todos los métodos de la clase

```php
public function getProperties( string $className ): array;
```

Devuelve las anotaciones encontradas en todas las propiedades de la clase

```php
public function getProperty( string $className, string $propertyName ): Collection;
```

Devuelve las anotaciones encontradas en un propiedad específica

```php
public function getReader(): ReaderInterface;
```

Devuelve el lector de anotaciones

```php
public function setReader( ReaderInterface $reader );
```

Establece el analizador de anotaciones

<h1 id="annotations-adapter-adapterinterface">Interface Phalcon\Annotations\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Annotations\Adapter | | Uses | Phalcon\Annotations\Reflection, Phalcon\Annotations\Collection, Phalcon\Annotations\ReaderInterface |

Esta interfaz debe ser implementada por adaptadores de Phalcon\Annotations

## Métodos

```php
public function get( string $className ): Reflection;
```

Analiza o recupera todas las anotaciones encontradas en una clase

```php
public function getMethod( string $className, string $methodName ): Collection;
```

Devuelve las anotaciones encontradas en un método específico

```php
public function getMethods( string $className ): array;
```

Devuelve las anotaciones encontradas en todos los métodos de la clase

```php
public function getProperties( string $className ): array;
```

Devuelve las anotaciones encontradas en todas las propiedades de la clase

```php
public function getProperty( string $className, string $propertyName ): Collection;
```

Devuelve las anotaciones encontradas en un propiedad específica

```php
public function getReader(): ReaderInterface;
```

Devuelve el lector de anotaciones

```php
public function setReader( ReaderInterface $reader );
```

Establece el analizador de anotaciones

<h1 id="annotations-adapter-apcu">Class Phalcon\Annotations\Adapter\Apcu</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Adapter/Apcu.zep)

| Namespace | Phalcon\Annotations\Adapter | | Uses | Phalcon\Annotations\Reflection | | Extends | AbstractAdapter |

Almacena las anotaciones analizadas en APCu. Este adaptador es adecuado para producción

```php
use Phalcon\Annotations\Adapter\Apcu;

$annotations = new Apcu();
```

## Propiedades

```php
/**
 * @var string
 */
protected prefix = ;

/**
 * @var int
 */
protected ttl = 172800;

```

## Métodos

```php
public function __construct( array $options = [] );
```

```php
public function read( string $key ): Reflection | bool;
```

Lee anotaciones analizadas desde APCu

```php
public function write( string $key, Reflection $data ): bool;
```

Escribe anotaciones analizadas en APCu

<h1 id="annotations-adapter-memory">Class Phalcon\Annotations\Adapter\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Adapter/Memory.zep)

| Namespace | Phalcon\Annotations\Adapter | | Uses | Phalcon\Annotations\Reflection | | Extends | AbstractAdapter |

Almacena anotaciones analizadas en memoria. Este adaptador es el adecuado para desarrollo/pruebas

## Propiedades

```php
/**
 * @var mixed
 */
protected data;

```

## Métodos

```php
public function read( string $key ): Reflection | bool;
```

Lee anotaciones analizadas desde memoria

```php
public function write( string $key, Reflection $data ): void;
```

Escribe anotaciones analizadas en memoria

<h1 id="annotations-adapter-stream">Class Phalcon\Annotations\Adapter\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Adapter/Stream.zep)

| Namespace | Phalcon\Annotations\Adapter | | Uses | Phalcon\Annotations\Reflection, Phalcon\Annotations\Exception, RuntimeException | | Extends | AbstractAdapter |

Almacena las anotaciones analizadas en ficheros. Este adaptador es adecuado para producción

```php
use Phalcon\Annotations\Adapter\Stream;

$annotations = new Stream(
    [
        "annotationsDir" => "app/cache/annotations/",
    ]
);
```

## Propiedades

```php
/**
 * @var string
 */
protected annotationsDir = ./;

```

## Métodos

```php
public function __construct( array $options = [] );
```

```php
public function read( string $key ): Reflection | bool | int;
```

Lee anotaciones analizadas desde ficheros

```php
public function write( string $key, Reflection $data ): void;
```

Escribe anotaciones analizadas en ficheros

<h1 id="annotations-annotation">Class Phalcon\Annotations\Annotation</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Annotation.zep)

| Namespace | Phalcon\Annotations |

Representa a una sola anotación dentro de una colección de anotaciones

## Propiedades

```php
/**
 * Annotation Arguments
 *
 * @var array
 */
protected arguments;

/**
 * Annotation ExprArguments
 *
 * @var array
 */
protected exprArguments;

/**
 * Annotation Name
 *
 * @var string|null
 */
protected name;

```

## Métodos

```php
public function __construct( array $reflectionData );
```

Constructor Phalcon\Annotations\Annotation

```php
public function getArgument( mixed $position ): mixed | null;
```

Devuelve un argumento en una posición específica

```php
public function getArguments(): array;
```

Devuelve los argumentos de la expresión

```php
public function getExprArguments(): array;
```

Devuelve los argumentos de la expresión sin resolver

```php
public function getExpression( array $expr ): mixed;
```

Resuelve una expresión de anotación

```php
public function getName(): null | string;
```

Devuelve el nombre de la anotación

```php
public function getNamedArgument( string $name ): mixed | null;
```

Devuelve el argumento nombrado

```php
public function getNamedParameter( string $name ): mixed;
```

Devuelve el parámetro nombrado

```php
public function hasArgument( mixed $position ): bool;
```

Devuelve un argumento en una posición específica

```php
public function numberArguments(): int;
```

Devuelve el número de argumentos que tiene la anotación

<h1 id="annotations-annotationsfactory">Class Phalcon\Annotations\AnnotationsFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/AnnotationsFactory.zep)

| Namespace | Phalcon\Annotations | | Uses | Phalcon\Annotations\Adapter\AdapterInterface, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr | | Extends | AbstractFactory |

Fábrica para crear componentes de anotaciones

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor AdapterFactory.

```php
public function load( mixed $config ): mixed;
```

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```

Los adaptadores disponibles

<h1 id="annotations-collection">Class Phalcon\Annotations\Collection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Collection.zep)

| Namespace | Phalcon\Annotations | | Uses | Countable, Iterator | | Implements | Iterator, Countable |

Representa una colección de anotaciones. Esta clase permite recorrer fácilmente un grupo de anotaciones

```php
// Traverse annotations
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}

// Check if the annotations has a specific
var_dump($classAnnotations->has("Cacheable"));

// Get an specific annotation in the collection
$annotation = $classAnnotations->get("Cacheable");
```

## Propiedades

```php
/**
 * @var array
 */
protected annotations;

/**
 * @var int
 */
protected position = 0;

```

## Métodos

```php
public function __construct( array $reflectionData = [] );
```

Constructor Phalcon\Annotations\Collection

```php
public function count(): int;
```

Devuelve el número de anotaciones en la colección

```php
public function current(): Annotation | bool;
```

Devuelve la anotación actual en el iterador

```php
public function get( string $name ): Annotation;
```

Devuelve la primera anotación que coincide con un nombre

```php
public function getAll( string $name ): Annotation[];
```

Devuelve todas las anotaciones que coinciden con un nombre

```php
public function getAnnotations(): Annotation[];
```

Devuelve las anotaciones internas como un vector

```php
public function has( string $name ): bool;
```

Comprobar si existe una anotación en una colección

```php
public function key(): int;
```

Devuelve la clave/posición actual en el iterador

```php
public function next(): void;
```

Mueve el puntero de iteración interno a la siguiente posición

```php
public function rewind(): void;
```

Rebobina el iterador interno

```php
public function valid(): bool;
```

Verifica si la anotación actual del iterador es válida

<h1 id="annotations-exception">Class Phalcon\Annotations\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Exception.zep)

| Namespace | Phalcon\Annotations | | Extends | \Phalcon\Exception |

Clase para excepciones lanzadas por Phalcon\Annotations

<h1 id="annotations-reader">Class Phalcon\Annotations\Reader</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Reader.zep)

| Namespace | Phalcon\Annotations | | Uses | ReflectionClass | | Implements | ReaderInterface |

Analiza los docblocks para devolver un vector con las anotaciones encontradas

## Métodos

```php
public function parse( string $className ): array;
```

Lee las anotaciones de la clase docblocks, sus métodos y/o propiedades

```php
public static function parseDocBlock( string $docBlock, mixed $file = null, mixed $line = null ): array;
```

Procesa un bloque doc en bruto devolviendo las anotaciones encontradas

<h1 id="annotations-readerinterface">Interface Phalcon\Annotations\ReaderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/ReaderInterface.zep)

| Namespace | Phalcon\Annotations |

Analiza los docblocks para devolver un vector con las anotaciones encontradas

## Métodos

```php
public function parse( string $className ): array;
```

Lee las anotaciones de la clase docblocks, sus métodos y/o propiedades

```php
public static function parseDocBlock( string $docBlock, mixed $file = null, mixed $line = null ): array;
```

Procesa un bloque doc en bruto devolviendo las anotaciones encontradas

<h1 id="annotations-reflection">Class Phalcon\Annotations\Reflection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Annotations/Reflection.zep)

| Namespace | Phalcon\Annotations |

Permite manipular la reflexión de las anotaciones en una forma Orientada a Objectos

```php
use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

// Parse the annotations in a class
$reader = new Reader();
$parsing = $reader->parse("MyComponent");

// Create the reflection
$reflection = new Reflection($parsing);

// Get the annotations in the class docblock
$classAnnotations = $reflection->getClassAnnotations();
```

## Propiedades

```php
//
protected classAnnotations;

//
protected methodAnnotations;

//
protected propertyAnnotations;

/**
 * @var array
 */
protected reflectionData;

```

## Métodos

```php
public function __construct( array $reflectionData = [] );
```

Constructor Phalcon\Annotations\Reflection

```php
public function getClassAnnotations(): Collection | bool;
```

Devuelve las anotaciones encontradas en la clase docblock

```php
public function getMethodsAnnotations(): Collection[] | bool;
```

Devuelve las anotaciones encontradas en los métodos de docblocks

```php
public function getPropertiesAnnotations(): Collection[] | bool;
```

Devuelve las anotaciones encontradas en las propiedades de docblocks

```php
public function getReflectionData(): array;
```

Devuelve las definiciones intermedias del análisis en bruto usadas para construir la reflexión
