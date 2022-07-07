---
layout: default
language: 'es-es'
version: '5.0'
title: 'Phalcon\Support'
---

* [Phalcon\Support\Collection](#support-collection)
* [Phalcon\Support\Collection\CollectionInterface](#support-collection-collectioninterface)
* [Phalcon\Support\Collection\Exception](#support-collection-exception)
* [Phalcon\Support\Collection\ReadOnlyCollection](#support-collection-readonlycollection)
* [Phalcon\Support\Debug](#support-debug)
* [Phalcon\Support\Debug\Dump](#support-debug-dump)
* [Phalcon\Support\Debug\Exception](#support-debug-exception)
* [Phalcon\Support\Exception](#support-exception)
* [Phalcon\Support\Helper\Arr\AbstractArr](#support-helper-arr-abstractarr)
* [Phalcon\Support\Helper\Arr\Blacklist](#support-helper-arr-blacklist)
* [Phalcon\Support\Helper\Arr\Chunk](#support-helper-arr-chunk)
* [Phalcon\Support\Helper\Arr\Filter](#support-helper-arr-filter)
* [Phalcon\Support\Helper\Arr\First](#support-helper-arr-first)
* [Phalcon\Support\Helper\Arr\FirstKey](#support-helper-arr-firstkey)
* [Phalcon\Support\Helper\Arr\Flatten](#support-helper-arr-flatten)
* [Phalcon\Support\Helper\Arr\Get](#support-helper-arr-get)
* [Phalcon\Support\Helper\Arr\Group](#support-helper-arr-group)
* [Phalcon\Support\Helper\Arr\Has](#support-helper-arr-has)
* [Phalcon\Support\Helper\Arr\IsUnique](#support-helper-arr-isunique)
* [Phalcon\Support\Helper\Arr\Last](#support-helper-arr-last)
* [Phalcon\Support\Helper\Arr\LastKey](#support-helper-arr-lastkey)
* [Phalcon\Support\Helper\Arr\Order](#support-helper-arr-order)
* [Phalcon\Support\Helper\Arr\Pluck](#support-helper-arr-pluck)
* [Phalcon\Support\Helper\Arr\Set](#support-helper-arr-set)
* [Phalcon\Support\Helper\Arr\SliceLeft](#support-helper-arr-sliceleft)
* [Phalcon\Support\Helper\Arr\SliceRight](#support-helper-arr-sliceright)
* [Phalcon\Support\Helper\Arr\Split](#support-helper-arr-split)
* [Phalcon\Support\Helper\Arr\ToObject](#support-helper-arr-toobject)
* [Phalcon\Support\Helper\Arr\ValidateAll](#support-helper-arr-validateall)
* [Phalcon\Support\Helper\Arr\ValidateAny](#support-helper-arr-validateany)
* [Phalcon\Support\Helper\Arr\Whitelist](#support-helper-arr-whitelist)
* [Phalcon\Support\Helper\Exception](#support-helper-exception)
* [Phalcon\Support\Helper\File\Basename](#support-helper-file-basename)
* [Phalcon\Support\Helper\Json\Decode](#support-helper-json-decode)
* [Phalcon\Support\Helper\Json\Encode](#support-helper-json-encode)
* [Phalcon\Support\Helper\Number\IsBetween](#support-helper-number-isbetween)
* [Phalcon\Support\Helper\Str\AbstractStr](#support-helper-str-abstractstr)
* [Phalcon\Support\Helper\Str\Camelize](#support-helper-str-camelize)
* [Phalcon\Support\Helper\Str\Concat](#support-helper-str-concat)
* [Phalcon\Support\Helper\Str\CountVowels](#support-helper-str-countvowels)
* [Phalcon\Support\Helper\Str\Decapitalize](#support-helper-str-decapitalize)
* [Phalcon\Support\Helper\Str\Decrement](#support-helper-str-decrement)
* [Phalcon\Support\Helper\Str\DirFromFile](#support-helper-str-dirfromfile)
* [Phalcon\Support\Helper\Str\DirSeparator](#support-helper-str-dirseparator)
* [Phalcon\Support\Helper\Str\Dynamic](#support-helper-str-dynamic)
* [Phalcon\Support\Helper\Str\EndsWith](#support-helper-str-endswith)
* [Phalcon\Support\Helper\Str\FirstBetween](#support-helper-str-firstbetween)
* [Phalcon\Support\Helper\Str\Friendly](#support-helper-str-friendly)
* [Phalcon\Support\Helper\Str\Humanize](#support-helper-str-humanize)
* [Phalcon\Support\Helper\Str\Includes](#support-helper-str-includes)
* [Phalcon\Support\Helper\Str\Increment](#support-helper-str-increment)
* [Phalcon\Support\Helper\Str\Interpolate](#support-helper-str-interpolate)
* [Phalcon\Support\Helper\Str\IsAnagram](#support-helper-str-isanagram)
* [Phalcon\Support\Helper\Str\IsLower](#support-helper-str-islower)
* [Phalcon\Support\Helper\Str\IsPalindrome](#support-helper-str-ispalindrome)
* [Phalcon\Support\Helper\Str\IsUpper](#support-helper-str-isupper)
* [Phalcon\Support\Helper\Str\KebabCase](#support-helper-str-kebabcase)
* [Phalcon\Support\Helper\Str\Len](#support-helper-str-len)
* [Phalcon\Support\Helper\Str\Lower](#support-helper-str-lower)
* [Phalcon\Support\Helper\Str\PascalCase](#support-helper-str-pascalcase)
* [Phalcon\Support\Helper\Str\Prefix](#support-helper-str-prefix)
* [Phalcon\Support\Helper\Str\Random](#support-helper-str-random)
* [Phalcon\Support\Helper\Str\ReduceSlashes](#support-helper-str-reduceslashes)
* [Phalcon\Support\Helper\Str\SnakeCase](#support-helper-str-snakecase)
* [Phalcon\Support\Helper\Str\StartsWith](#support-helper-str-startswith)
* [Phalcon\Support\Helper\Str\Suffix](#support-helper-str-suffix)
* [Phalcon\Support\Helper\Str\Ucwords](#support-helper-str-ucwords)
* [Phalcon\Support\Helper\Str\Uncamelize](#support-helper-str-uncamelize)
* [Phalcon\Support\Helper\Str\Underscore](#support-helper-str-underscore)
* [Phalcon\Support\Helper\Str\Upper](#support-helper-str-upper)
* [Phalcon\Support\HelperFactory](#support-helperfactory)
* [Phalcon\Support\Registry](#support-registry)
* [Phalcon\Support\Version](#support-version)

<h1 id="support-collection">Class Phalcon\Support\Collection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Collection.zep)

| Namespace  | Phalcon\Support | | Uses       | ArrayAccess, ArrayIterator, Countable, IteratorAggregate, InvalidArgumentException, JsonSerializable, Phalcon\Support\Collection\CollectionInterface, Serializable, Traversable | | Implements | ArrayAccess, CollectionInterface, Countable, IteratorAggregate, JsonSerializable, Serializable |

`Phalcon\Support\Collection` is a supercharged object oriented array. Implementa:
- [ArrayAccess](https://www.php.net/manual/es/class.arrayaccess.php)
- [Countable](https://www.php.net/manual/es/class.countable.php)
- [IteratorAggregate](https://www.php.net/manual/es/class.iteratoraggregate.php)
- [JsonSerializable](https://www.php.net/manual/es/class.jsonserializable.php)
- [Serializable](https://www.php.net/manual/es/class.serializable.php)

Se puede usar como parte de la aplicación que necesite recolección de datos. Tales implementaciones están por ejemplo al acceder a los globales `$_GET`, `$_POST`, etc.


## Propiedades
```php
/**
 * @var array
 */
protected data;

/**
 * @var bool
 */
protected insensitive = true;

/**
 * @var array
 */
protected lowerKeys;

```

## Métodos

```php
public function __construct( array $data = [], bool $insensitive = bool );
```
Constructor de la colección.


```php
public function __get( string $element ): mixed;
```
*Getter* mágico para obtener un elemento de la colección


```php
public function __isset( string $element ): bool;
```
*Isset* mágico para comprobar si un elemento existe o no


```php
public function __serialize(): array;
```

```php
public function __set( string $element, mixed $value ): void;
```
*Setter* mágico para asignar valores a un elemento


```php
public function __unserialize( array $data ): void;
```

```php
public function __unset( string $element ): void;
```
*Unset* mágico para eliminar un elemento de la colección


```php
public function clear(): void;
```
Limpia la colección interna


```php
public function count(): int;
```
Cuenta los elementos de un objeto. Ver [count](https://php.net/manual/en/countable.count.php)


```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```
Obtiene el elemento de la colección


```php
public function getIterator(): Traversable;
```
Devuelve el iterador de la clase


```php
public function getKeys( bool $insensitive = bool ): array;
```
Return the keys as an array


```php
public function getValues(): array;
```
Return the values as an array


```php
public function has( string $element ): bool;
```
Determina si un elemento está presente en la colección.


```php
public function init( array $data = [] ): void;
```
Inicializa el vector interno


```php
public function jsonSerialize(): array;
```
Especifica los datos que deberían se serializados a JSON. Ver [jsonSerialize](https://php.net/manual/en/jsonserializable.jsonserialize.php)


```php
public function offsetExists( mixed $element ): bool;
```
Indica si existe un desplazamiento. Ver [offsetExists](https://php.net/manual/en/arrayaccess.offsetexists.php)


```php
public function offsetGet( mixed $element ): mixed;
```
Desplazamiento a obtener. Ver [offsetGet](https://php.net/manual/en/arrayaccess.offsetget.php)


```php
public function offsetSet( mixed $element, mixed $value ): void;
```
Desplazamiento a establecer. Ver [offsetSet](https://php.net/manual/en/arrayaccess.offsetset.php)


```php
public function offsetUnset( mixed $element ): void;
```
Desplazamiento a eliminar. Ver [offsetUnset](https://php.net/manual/en/arrayaccess.offsetunset.php)


```php
public function remove( string $element ): void;
```
Elimina el elemento de la colección


```php
public function serialize(): string;
```
Representación del objeto como cadena. Ver [serialize](https://php.net/manual/en/serializable.serialize.php)


```php
public function set( string $element, mixed $value ): void;
```
Establece un elemento en la colección


```php
public function toArray(): array;
```
Devuelve el objeto en un formato vector


```php
public function toJson( int $options = int ): string;
```
Devuelve el objeto en un formato JSON

La cadena predeterminada usa las siguientes opciones para *json_encode*

`JSON_HEX_TAG`, `JSON_HEX_APOS`, `JSON_HEX_AMP`, `JSON_HEX_QUOT`, `JSON_UNESCAPED_SLASHES`

Ver [rfc4627](https://www.ietf.org/rfc/rfc4627.txt)


```php
public function unserialize( string $serialized ): void;
```
Construye el objeto. Ver [unserialize](https://php.net/manual/en/serializable.unserialize.php)


```php
protected function phpJsonEncode( mixed $value, int $flags = int, int $depth = int );
```
@todo to be removed when we get traits


```php
protected function processKey( string $element ): string;
```
Checks if we need insensitive keys and if so, converts the element to lowercase


```php
protected function setData( string $element, mixed $value ): void;
```
Método interno para establecer datos




<h1 id="support-collection-collectioninterface">Interface Phalcon\Support\Collection\CollectionInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Collection/CollectionInterface.zep)

| Namespace  | Phalcon\Support\Collection |

Phalcon\Support\Collection\CollectionInterface

Interface for Phalcon\Support\Collection class


## Métodos

```php
public function __get( string $element ): mixed;
```

```php
public function __isset( string $element ): bool;
```

```php
public function __set( string $element, mixed $value ): void;
```

```php
public function __unset( string $element ): void;
```

```php
public function clear(): void;
```

```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```

```php
public function getKeys( bool $insensitive = bool ): array;
```

```php
public function getValues(): array;
```

```php
public function has( string $element ): bool;
```

```php
public function init( array $data = [] ): void;
```

```php
public function remove( string $element ): void;
```

```php
public function set( string $element, mixed $value ): void;
```

```php
public function toArray(): array;
```

```php
public function toJson( int $options = int ): string;
```





<h1 id="support-collection-exception">Class Phalcon\Support\Collection\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Collection/Exception.zep)

| Namespace  | Phalcon\Support\Collection | | Uses       | Throwable | | Extends    | \Exception |

Excepciones para el objeto *Collection*



<h1 id="support-collection-readonlycollection">Class Phalcon\Support\Collection\ReadOnlyCollection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Collection/ReadOnlyCollection.zep)

| Namespace  | Phalcon\Support\Collection | | Uses       | Phalcon\Support\Collection | | Extends    | Collection |

A read only Collection object


## Métodos

```php
public function remove( string $element ): void;
```
Elimina el elemento de la colección


```php
public function set( string $element, mixed $value ): void;
```
Establece un elemento en la colección




<h1 id="support-debug">Class Phalcon\Support\Debug</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Debug.zep)

| Namespace  | Phalcon\Support | | Uses       | ErrorException, Phalcon\Support\Debug\Exception, ReflectionClass, ReflectionException, ReflectionFunction, Throwable |

Proporciona capacidades de depuración para aplicaciones Phalcon


## Propiedades
```php
/**
 * @var array
 */
protected blacklist;

/**
 * @var array
 */
protected data;

/**
 * @var bool
 */
protected hideDocumentRoot = false;

/**
 * @var bool
 */
protected static isActive = false;

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
protected uri = https://assets.phalcon.io/debug/5.0.x/;

```

## Métodos

```php
public function clearVars(): Debug;
```
Elimina las variables añadidas previamente


```php
public function debugVar( mixed $varz ): Debug;
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

@throws Exception


```php
public function listen( bool $exceptions = bool, bool $lowSeverity = bool ): Debug;
```
Listen for uncaught exceptions and non silent notices or warnings


```php
public function listenExceptions(): Debug;
```
Escucha excepciones no capturadas


```php
public function listenLowSeverity(): Debug;
```
Listen for non silent notices or warnings


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
Render exception to html format.


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
protected function escapeString( string $value ): string;
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




<h1 id="support-debug-dump">Class Phalcon\Support\Debug\Dump</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Debug/Dump.zep)

| Namespace  | Phalcon\Support\Debug | | Uses       | InvalidArgumentException, Phalcon\Di\Di, Reflection, ReflectionClass, ReflectionProperty, stdClass |

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




<h1 id="support-debug-exception">Class Phalcon\Support\Debug\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Debug/Exception.zep)

| Namespace  | Phalcon\Support\Debug | | Extends    | \Exception |

Las excepciones lanzadas en Phalcon\Debug usarán esta clase



<h1 id="support-exception">Class Phalcon\Support\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Exception.zep)

| Namespace  | Phalcon\Support | | Extends    | \Exception |

Phalcon\Support\Exception



<h1 id="support-helper-arr-abstractarr">Abstract Class Phalcon\Support\Helper\Arr\AbstractArr</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/AbstractArr.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Abstract class offering methods to help with the Arr namespace. This can be moved to a trait once Zephir supports it.

@todo move to trait when there is support for it


## Métodos

```php
protected function toFilter( array $collection, mixed $method = null ): array;
```
Método ayudante para filtrar la colección




<h1 id="support-helper-arr-blacklist">Class Phalcon\Support\Helper\Arr\Blacklist</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Blacklist.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Filtro de lista negra por clave: excluye elementos de un vector por las claves obtenidas de los elementos de una lista negra


## Métodos

```php
public function __invoke( array $collection, array $blackList ): array;
```





<h1 id="support-helper-arr-chunk">Class Phalcon\Support\Helper\Arr\Chunk</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Chunk.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Trocea un vector en vectores más pequeños de un determinado tamaño.


## Métodos

```php
public function __invoke( array $collection, int $size, bool $preserveKeys = bool ): array;
```





<h1 id="support-helper-arr-filter">Class Phalcon\Support\Helper\Arr\Filter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Filter.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Filters a collection using array_filter and using the callable (if defined)


## Métodos

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-first">Class Phalcon\Support\Helper\Arr\First</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/First.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Devuelve el primer elemento de la colección. Si se pasa una invocable, el elemento devuelto es el primero que valida a `true`


## Métodos

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-firstkey">Class Phalcon\Support\Helper\Arr\FirstKey</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/FirstKey.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Devuelve la clave del primer elemento de la colección. Si se indica una invocable, el elemento devuelto es el primero que valida a `true`


## Métodos

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-flatten">Class Phalcon\Support\Helper\Arr\Flatten</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Flatten.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Flattens an array up to the one level depth, unless `$deep` is set to `true`


## Métodos

```php
public function __invoke( array $collection, bool $deep = bool ): array;
```





<h1 id="support-helper-arr-get">Class Phalcon\Support\Helper\Arr\Get</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Get.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Gets an array element by key and if it does not exist returns the default. It also allows for casting the returned value to a specific type using `settype` internally


## Métodos

```php
public function __invoke( array $collection, mixed $index, mixed $defaultValue = null, string $cast = null ): mixed;
```





<h1 id="support-helper-arr-group">Class Phalcon\Support\Helper\Arr\Group</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Group.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Agrupa los elementos de un vector según el invocable pasado


## Métodos

```php
public function __invoke( array $collection, mixed $method ): array;
```





<h1 id="support-helper-arr-has">Class Phalcon\Support\Helper\Arr\Has</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Has.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Checks an array if it has an element with a specific key and returns `true`/`false` accordingly


## Métodos

```php
public function __invoke( array $collection, mixed $index ): bool;
```





<h1 id="support-helper-arr-isunique">Class Phalcon\Support\Helper\Arr\IsUnique</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/IsUnique.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Comprueba valores duplicados en una lista plana. Devuelve `true` si existen valores duplicados y `false` si todos los valores son únicos.


## Métodos

```php
public function __invoke( array $collection ): bool;
```





<h1 id="support-helper-arr-last">Class Phalcon\Support\Helper\Arr\Last</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Last.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Devuelve el último elemento de la colección. Si se pasa una invocable, el elemento devuelto es el primero que valida a `true`


## Métodos

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-lastkey">Class Phalcon\Support\Helper\Arr\LastKey</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/LastKey.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Devuelve la clave del último elemento de la colección. Si se indica una invocable, el elemento devuelto es el primero que valida a `true`


## Métodos

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-order">Class Phalcon\Support\Helper\Arr\Order</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Order.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Sorts a collection of arrays or objects by an attribute of the object. It supports ascending/descending sorts but also flags that are identical to the ones used by `ksort` and `krsort`


## Constantes
```php
const ORDER_ASC = 1;
const ORDER_DESC = 2;
```

## Métodos

```php
public function __invoke( array $collection, mixed $attribute, int $order = static-constant-access, int $flags = int ): array;
```





<h1 id="support-helper-arr-pluck">Class Phalcon\Support\Helper\Arr\Pluck</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Pluck.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns a subset of the collection based on the values of the collection


## Métodos

```php
public function __invoke( array $collection, string $element ): array;
```





<h1 id="support-helper-arr-set">Class Phalcon\Support\Helper\Arr\Set</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Set.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Sets an array element. Using a key is optional


## Métodos

```php
public function __invoke( array $collection, mixed $value, mixed $index = null ): array;
```





<h1 id="support-helper-arr-sliceleft">Class Phalcon\Support\Helper\Arr\SliceLeft</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/SliceLeft.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Devuelve un nuevo vector con n elementos eliminados desde la izquierda.


## Métodos

```php
public function __invoke( array $collection, int $elements = int ): array;
```





<h1 id="support-helper-arr-sliceright">Class Phalcon\Support\Helper\Arr\SliceRight</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/SliceRight.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Devuelve un nuevo vector con n elementos eliminados desde la derecha.


## Métodos

```php
public function __invoke( array $collection, int $elements = int ): array;
```





<h1 id="support-helper-arr-split">Class Phalcon\Support\Helper\Arr\Split</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Split.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns a new array with keys of the collection as one element and values as another


## Métodos

```php
public function __invoke( array $collection ): array;
```





<h1 id="support-helper-arr-toobject">Class Phalcon\Support\Helper\Arr\ToObject</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/ToObject.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns the passed array as an object.


## Métodos

```php
public function __invoke( array $collection ): object;
```





<h1 id="support-helper-arr-validateall">Class Phalcon\Support\Helper\Arr\ValidateAll</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/ValidateAll.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns `true` if the provided function returns `true` for all elements of the collection, `false` otherwise.


## Métodos

```php
public function __invoke( array $collection, mixed $method ): bool;
```





<h1 id="support-helper-arr-validateany">Class Phalcon\Support\Helper\Arr\ValidateAny</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/ValidateAny.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns `true` if the provided function returns `true` for at least one element of the collection, `false` otherwise.


## Métodos

```php
public function __invoke( array $collection, mixed $method ): bool;
```





<h1 id="support-helper-arr-whitelist">Class Phalcon\Support\Helper\Arr\Whitelist</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Arr/Whitelist.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

White list filter by key: obtain elements of an array filtering by the keys obtained from the elements of a whitelist


## Métodos

```php
public function __invoke( array $collection, array $whiteList ): array;
```





<h1 id="support-helper-exception">Class Phalcon\Support\Helper\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Exception.zep)

| Namespace  | Phalcon\Support\Helper | | Extends    | \Exception |

* Phalcon\Support\Exception */


<h1 id="support-helper-file-basename">Class Phalcon\Support\Helper\File\Basename</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/File/Basename.zep)

| Namespace  | Phalcon\Support\Helper\File |

Gets the filename from a given path, Same as PHP's `basename()` but has non-ASCII support. PHP's `basename()` does not properly support streams or filenames beginning with a non-US-ASCII character.


## Métodos

```php
public function __invoke( string $uri, string $suffix = null ): string;
```
@see https://bugs.php.net/bug.php?id=37738




<h1 id="support-helper-json-decode">Class Phalcon\Support\Helper\Json\Decode</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Json/Decode.zep)

| Namespace  | Phalcon\Support\Helper\Json | | Uses       | InvalidArgumentException |

Decodifica una cadena usando `json_decode` y lanza una excepción si los datos JSON no se han podido decodificar


## Métodos

```php
public function __invoke( string $data, bool $associative = bool, int $depth = int, int $options = int );
```





<h1 id="support-helper-json-encode">Class Phalcon\Support\Helper\Json\Encode</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Json/Encode.zep)

| Namespace  | Phalcon\Support\Helper\Json | | Uses       | JsonException |

Codifica una cadena usando `json_encode` y lanza una excepción si los datos JSON no se han podido codificar

The following options are used if none specified for json_encode

JSON_HEX_TAG, JSON_HEX_APOS, JSON_HEX_AMP, JSON_HEX_QUOT, JSON_UNESCAPED_SLASHES, JSON_THROW_ON_ERROR

@see  https://www.ietf.org/rfc/rfc4627.txt


## Métodos

```php
public function __invoke( mixed $data, int $options = int, int $depth = int ): string;
```





<h1 id="support-helper-number-isbetween">Class Phalcon\Support\Helper\Number\IsBetween</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Number/IsBetween.zep)

| Namespace  | Phalcon\Support\Helper\Number |

Checks if a number is within a range


## Métodos

```php
public function __invoke( int $value, int $start, int $end ): bool;
```





<h1 id="support-helper-str-abstractstr">Abstract Class Phalcon\Support\Helper\Str\AbstractStr</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/AbstractStr.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Abstract class offering methods to help with the Str namespace. This can be moved to a trait once Zephir supports it.

@todo move to trait when there is support for it


## Métodos

```php
protected function toEndsWith( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```
Comprueba si una cadena termina con una cadena dada


```php
protected function toInterpolate( string $input, array $context = [], string $left = string, string $right = string ): string;
```
Interpola los valores de contexto dentro de los marcadores de posición del mensaje

@see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message


```php
protected function toLower( string $text, string $encoding = string ): string;
```
Lowercases a string using mbstring


```php
protected function toStartsWith( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```
Comprueba si una cadena empieza con una cadena dada


```php
protected function toUpper( string $text, string $encoding = string ): string;
```
Uppercases a string using mbstring




<h1 id="support-helper-str-camelize">Class Phalcon\Support\Helper\Str\Camelize</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Camelize.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | PascalCase |

Converts strings to upperCamelCase or lowerCamelCase


## Métodos

```php
public function __invoke( string $text, string $delimiters = null, bool $lowerFirst = bool ): string;
```





<h1 id="support-helper-str-concat">Class Phalcon\Support\Helper\Str\Concat</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Concat.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Uses       | Phalcon\Support\Helper\Exception | | Extends    | AbstractStr |

Concatena cadenas usando el separador sólo una vez sin duplicación en los lugares de la concatenación


## Métodos

```php
public function __invoke(): string;
```





<h1 id="support-helper-str-countvowels">Class Phalcon\Support\Helper\Str\CountVowels</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/CountVowels.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Devuelve el número de vocales de la cadena indicada. Usa una expresión regular para contar el número de vocales (A, E, I, O, U) en una cadena.


## Métodos

```php
public function __invoke( string $text ): int;
```





<h1 id="support-helper-str-decapitalize">Class Phalcon\Support\Helper\Str\Decapitalize</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Decapitalize.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Decapitaliza la primera letra de una cadena y luego la añade con el resto de la cadena. Omita el parámetro `upperRest` para mantener el resto de la cadena intacta, o establezcalo a `true` para convertir a mayúsculas.


## Métodos

```php
public function __invoke( string $text, bool $upperRest = bool, string $encoding = string ): string;
```





<h1 id="support-helper-str-decrement">Class Phalcon\Support\Helper\Str\Decrement</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Decrement.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Removes a number from the end of a string or decrements that number if it is already defined


## Métodos

```php
public function __invoke( string $text, string $separator = string ): string;
```





<h1 id="support-helper-str-dirfromfile">Class Phalcon\Support\Helper\Str\DirFromFile</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/DirFromFile.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Acepta un nombre de fichero (sin extensión) y devuelve una estructura de directorios calculada con el nombre del fichero al final


## Métodos

```php
public function __invoke( string $file ): string;
```





<h1 id="support-helper-str-dirseparator">Class Phalcon\Support\Helper\Str\DirSeparator</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/DirSeparator.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Acepta un nombre de directorio y se asegura que termina con DIRECTORY_SEPARATOR


## Métodos

```php
public function __invoke( string $directory ): string;
```





<h1 id="support-helper-str-dynamic">Class Phalcon\Support\Helper\Str\Dynamic</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Dynamic.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Uses       | RuntimeException |

Generates random text in accordance with the template. The template is defined by the left and right delimiter and it can contain values separated by the separator


## Métodos

```php
public function __invoke( string $text, string $leftDelimiter = string, string $rightDelimiter = string, string $separator = string ): string;
```





<h1 id="support-helper-str-endswith">Class Phalcon\Support\Helper\Str\EndsWith</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/EndsWith.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Comprueba si una cadena termina con una cadena dada


## Métodos

```php
public function __invoke( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```





<h1 id="support-helper-str-firstbetween">Class Phalcon\Support\Helper\Str\FirstBetween</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/FirstBetween.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Devuelve la primera cadena que hay entre las cadenas desde el parámetro `start` y `end`.


## Métodos

```php
public function __invoke( string $text, string $start, string $end ): string;
```





<h1 id="support-helper-str-friendly">Class Phalcon\Support\Helper\Str\Friendly</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Friendly.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Uses       | Phalcon\Support\Helper\Exception | | Extends    | AbstractStr |

Changes a text to a URL friendly one. Replaces commonly known accented characters with their Latin equivalents. If a `replace` string or array is passed, it will also be used to replace those characters with a space.


## Métodos

```php
public function __invoke( string $text, string $separator = string, bool $lowercase = bool, mixed $replace = null ): string;
```





<h1 id="support-helper-str-humanize">Class Phalcon\Support\Helper\Str\Humanize</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Humanize.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Makes an underscored or dashed text human-readable


## Métodos

```php
public function __invoke( string $text ): string;
```





<h1 id="support-helper-str-includes">Class Phalcon\Support\Helper\Str\Includes</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Includes.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Determines whether a string includes another string or not.


## Métodos

```php
public function __invoke( string $haystack, string $needle ): bool;
```





<h1 id="support-helper-str-increment">Class Phalcon\Support\Helper\Str\Increment</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Increment.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Adds a number to the end of a string or increments that number if it is already defined


## Métodos

```php
public function __invoke( string $text, string $separator = string ): string;
```





<h1 id="support-helper-str-interpolate">Class Phalcon\Support\Helper\Str\Interpolate</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Interpolate.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Interpolates context values into the message placeholders. By default, the right and left tokens are `%`

@see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message


## Métodos

```php
public function __invoke( string $message, array $context = [], string $leftToken = string, string $rightToken = string ): string;
```





<h1 id="support-helper-str-isanagram">Class Phalcon\Support\Helper\Str\IsAnagram</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/IsAnagram.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Compare two strings and returns `true` if both strings are anagram, `false` otherwise.


## Métodos

```php
public function __invoke( string $first, string $second ): bool;
```





<h1 id="support-helper-str-islower">Class Phalcon\Support\Helper\Str\IsLower</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/IsLower.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Returns `true` if the given string is in lower case, `false` otherwise.


## Métodos

```php
public function __invoke( string $text, string $encoding = string ): bool;
```





<h1 id="support-helper-str-ispalindrome">Class Phalcon\Support\Helper\Str\IsPalindrome</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/IsPalindrome.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Devuelve `true` si la cadena dada es un palíndromo, `false` en caso contrario.


## Métodos

```php
public function __invoke( string $text ): bool;
```





<h1 id="support-helper-str-isupper">Class Phalcon\Support\Helper\Str\IsUpper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/IsUpper.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Returns `true` if the given string is in upper case, `false` otherwise.


## Métodos

```php
public function __invoke( string $text, string $encoding = string ): bool;
```





<h1 id="support-helper-str-kebabcase">Class Phalcon\Support\Helper\Str\KebabCase</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/KebabCase.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | PascalCase |

Converts strings to kebab-case style


## Métodos

```php
public function __invoke( string $text, string $delimiters = null ): string;
```





<h1 id="support-helper-str-len">Class Phalcon\Support\Helper\Str\Len</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Len.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Calculates the length of the string using `mb_strlen`


## Métodos

```php
public function __invoke( string $text, string $encoding = string ): int;
```





<h1 id="support-helper-str-lower">Class Phalcon\Support\Helper\Str\Lower</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Lower.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Converts a string to lowercase using mbstring


## Métodos

```php
public function __invoke( string $text, string $encoding = string ): string;
```





<h1 id="support-helper-str-pascalcase">Class Phalcon\Support\Helper\Str\PascalCase</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/PascalCase.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Converts strings to PascalCase style


## Métodos

```php
public function __invoke( string $text, string $delimiters = null ): string;
```

```php
protected function processArray( string $text, string $delimiters = null ): array;
```





<h1 id="support-helper-str-prefix">Class Phalcon\Support\Helper\Str\Prefix</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Prefix.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Prefixes the text with the supplied prefix


## Métodos

```php
public function __invoke( mixed $text, string $prefix ): string;
```





<h1 id="support-helper-str-random">Class Phalcon\Support\Helper\Str\Random</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Random.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Genera una cadena aleatoria basada en el tipo dado. El tipo es una de las constantes RANDOM_*


## Constantes
```php
const RANDOM_ALNUM = 0;
const RANDOM_ALPHA = 1;
const RANDOM_DISTINCT = 5;
const RANDOM_HEXDEC = 2;
const RANDOM_NOZERO = 4;
const RANDOM_NUMERIC = 3;
```

## Métodos

```php
public function __invoke( int $type = static-constant-access, int $length = int ): string;
```





<h1 id="support-helper-str-reduceslashes">Class Phalcon\Support\Helper\Str\ReduceSlashes</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/ReduceSlashes.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Reduce múltiples barras de una cadena a sólo una barra


## Métodos

```php
public function __invoke( string $text ): string;
```





<h1 id="support-helper-str-snakecase">Class Phalcon\Support\Helper\Str\SnakeCase</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/SnakeCase.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | PascalCase |

Converts strings to snake_case style


## Métodos

```php
public function __invoke( string $text, string $delimiters = null ): string;
```





<h1 id="support-helper-str-startswith">Class Phalcon\Support\Helper\Str\StartsWith</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/StartsWith.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Comprueba si una cadena empieza con una cadena dada


## Métodos

```php
public function __invoke( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```





<h1 id="support-helper-str-suffix">Class Phalcon\Support\Helper\Str\Suffix</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Suffix.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Suffixes the text with the supplied suffix


## Métodos

```php
public function __invoke( mixed $text, string $suffix ): string;
```





<h1 id="support-helper-str-ucwords">Class Phalcon\Support\Helper\Str\Ucwords</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Ucwords.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Capitalizes the first letter of each word


## Métodos

```php
public function __invoke( string $text, string $encoding = string ): string;
```





<h1 id="support-helper-str-uncamelize">Class Phalcon\Support\Helper\Str\Uncamelize</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Uncamelize.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Converts strings to non camelized style


## Métodos

```php
public function __invoke( string $text, string $delimiter = string ): string;
```





<h1 id="support-helper-str-underscore">Class Phalcon\Support\Helper\Str\Underscore</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Underscore.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Makes a text underscored instead of spaced


## Métodos

```php
public function __invoke( string $text ): string;
```





<h1 id="support-helper-str-upper">Class Phalcon\Support\Helper\Str\Upper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Helper/Str/Upper.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Converts a string to uppercase using mbstring


## Métodos

```php
public function __invoke( string $text, string $encoding = string ): string;
```





<h1 id="support-helperfactory">Class Phalcon\Support\HelperFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/HelperFactory.zep)

| Namespace  | Phalcon\Support | | Uses       | Phalcon\Factory\AbstractFactory | | Extends    | AbstractFactory |

ServiceLocator implementation for helpers

@method array  blacklist(array $collection, array $blackList) @method array  chunk(array $collection, int $size, bool $preserveKeys = false) @method mixed  first(array $collection, callable $method = null) @method mixed  firstKey(array $collection, callable $method = null) @method array  flatten(array $collection, bool $deep = false) @method mixed  get(array $collection, $index, $defaultValue = null, string $cast = null) @method array  group(array $collection, $method) @method bool   has(array $collection, $index) @method bool   isUnique(array $collection) @method mixed  last(array $collection, callable $method = null) @method mixed  lastKey(array $collection, callable $method = null) @method array  order(array $collection, $attribute, string $order = 'asc') @method array  pluck(array $collection, string $element) @method array  set(array $collection, $value, $index = null) @method array  sliceLeft(array $collection, int $elements = 1) @method array  sliceRight(array $collection, int $elements = 1) @method array  split(array $collection) @method object toObject(array $collection) @method bool   validateAll(array $collection, callable $method) @method bool   validateAny(array $collection, callable $method) @method array  whitelist(array $collection, array $whiteList) @method string basename(string $uri, string $suffix = null) @method string decode(string $data, bool $associative = false, int $depth = 512, int $options = 0) @method string encode($data, int $options = 0, int $depth = 512) @method bool   between(int $value, int $start, int $end) @method string camelize(string $text, string $delimiters = null, bool $lowerFirst = false) @method string concat(string $delimiter, string $first, string $second, string ...$arguments) @method int    countVowels(string $text) @method string decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8') @method string decrement(string $text, string $separator = '_') @method string dirFromFile(string $file) @method string dirSeparator(string $directory) @method bool   endsWith(string $haystack, string $needle, bool $ignoreCase = true) @method string firstBetween(string $text, string $start, string $end) @method string friendly(string $text, string $separator = '-', bool $lowercase = true, $replace = null) @method string humanize(string $text) @method bool   includes(string $haystack, string $needle) @method string increment(string $text, string $separator = '_') @method bool   isAnagram(string $first, string $second) @method bool   isLower(string $text, string $encoding = 'UTF-8') @method bool   isPalindrome(string $text) @method bool   isUpper(string $text, string $encoding = 'UTF-8') @method string kebabCase(string $text, string $delimiters = null) @method int    len(string $text, string $encoding = 'UTF-8') @method string lower(string $text, string $encoding = 'UTF-8') @method string pascalCase(string $text, string $delimiters = null) @method string prefix($text, string $prefix) @method string random(int $type = 0, int $length = 8) @method string reduceSlashes(string $text) @method bool   startsWith(string $haystack, string $needle, bool $ignoreCase = true) @method string snakeCase(string $text, string $delimiters = null) @method string suffix($text, string $suffix) @method string ucwords(string $text, string $encoding = 'UTF-8') @method string uncamelize(string $text, string $delimiters = '_') @method string underscore(string $text) @method string upper(string $text, string $encoding = 'UTF-8')


## Métodos

```php
public function __call( string $name, array $arguments );
```

```php
public function __construct( array $services = [] );
```
FactoryTrait constructor.


```php
public function newInstance( string $name );
```

```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Devuelve los adaptadores disponibles




<h1 id="support-registry">Final Class Phalcon\Support\Registry</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Registry.zep)

| Namespace  | Phalcon\Support | | Uses       | Phalcon\Support\Collection, Traversable | | Extends    | Collection |

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

Though Phalcon\Registry exposes methods like __get(), offsetGet(), count() etc, it is not recommended to invoke them manually (these methods exist mainly to match the interfaces the registry implements): $registry->__get("property") is several times slower than $registry->property.

Internamente todos los métodos mágicos (e interfaces excepto JsonSerializable) se implementan utilizando manejadores de objetos o técnicas similares: esto permite eludir llamadas a métodos relativamente lentas.


## Métodos

```php
final public function __construct( array $data = [] );
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




<h1 id="support-version">Class Phalcon\Support\Version</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Support/Version.zep)

| Namespace  | Phalcon\Support |

Esta clase permite obtener la versión instalada del framework


## Constantes
```php
const VERSION_MAJOR = 0;
const VERSION_MEDIUM = 1;
const VERSION_MINOR = 2;
const VERSION_SPECIAL = 3;
const VERSION_SPECIAL_NUMBER = 4;
```

## Métodos

```php
public function get(): string;
```
Devuelve la versión activa (cadena)

```php
echo (new Phalcon\Version())->get();
```


```php
public function getId(): string;
```
Devuelve la versión activa en formato numérico

```php
echo (new Phalcon\Version())->getId();
```


```php
public function getPart( int $part ): string;
```
Devuelve una parte específica de la versión. Si se pasa el parámetro incorrecto devolverá la versión completa

```php
echo (new Phalcon\Version())->getPart(Phalcon\Version::VERSION_MAJOR);
```


```php
protected function getVersion(): array;
```
Área donde se encuentra el número de versión. El formato es el siguiente: ABBCCDE

A - Major version B - Med version (two digits) C - Min version (two digits) D - Special release: 1 = alpha, 2 = beta, 3 = RC, 4 = stable E - Special release version i.e. RC1, Beta2 etc.


