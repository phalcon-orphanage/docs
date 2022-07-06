---
layout: default
language: 'es-es'
version: '5.0'
title: 'Phalcon\Assets'
---

* [Phalcon\Assets\Asset](#assets-asset)
* [Phalcon\Assets\Asset\Css](#assets-asset-css)
* [Phalcon\Assets\Asset\Js](#assets-asset-js)
* [Phalcon\Assets\AssetInterface](#assets-assetinterface)
* [Phalcon\Assets\Collection](#assets-collection)
* [Phalcon\Assets\Exception](#assets-exception)
* [Phalcon\Assets\FilterInterface](#assets-filterinterface)
* [Phalcon\Assets\Filters\CssMin](#assets-filters-cssmin)
* [Phalcon\Assets\Filters\JsMin](#assets-filters-jsmin)
* [Phalcon\Assets\Filters\None](#assets-filters-none)
* [Phalcon\Assets\Inline](#assets-inline)
* [Phalcon\Assets\Inline\Css](#assets-inline-css)
* [Phalcon\Assets\Inline\Js](#assets-inline-js)
* [Phalcon\Assets\Manager](#assets-manager)

<h1 id="assets-asset">Class Phalcon\Assets\Asset</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset.zep)

| Namespace  | Phalcon\Assets | | Implements | AssetInterface |

Represents an asset

```php
$asset = new \Phalcon\Assets\Asset("js", "js/jquery.js");
```

@property array       $attributes @property bool        $isAutoVersion @property bool        $filter @property bool        $isLocal @property string      $path @property string      $sourcePath @property string      $targetPath @property string      $targetUri @property string      $type @property string|null $version



## Propiedades
```php
/**
 * @var array
 */
protected attributes;

/**
 * @var bool
 */
protected isAutoVersion = false;

/**
 * @var bool
 */
protected filter;

/**
 * @var bool
 */
protected isLocal;

/**
 * @var string
 */
protected path;

/**
 * @var string
 */
protected sourcePath;

/**
 * @var string
 */
protected targetPath;

/**
 * @var string
 */
protected targetUri;

/**
 * @var string
 */
protected type;

/**
 * Version of resource
 *
 * @var string|null
 */
protected version;

```

## Métodos

```php
public function __construct( string $type, string $path, bool $isLocal = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $isAutoVersion = bool );
```
Asset constructor.


```php
public function getAssetKey(): string;
```
Obtiene la clave del recurso.


```php
public function getAttributes(): array;
```
Obtiene los atributos HTML extra.


```php
public function getContent( string $basePath = null ): string;
```
Devuelve el contenido del recurso como una cadena Opcionalmente se puede establecer una ruta base donde localizar el recurso


```php
public function getFilter(): bool
```

```php
public function getPath(): string
```

```php
public function getRealSourcePath( string $basePath = null ): string;
```
Devuelve la ubicación completa donde se localiza el recurso


```php
public function getRealTargetPath( string $basePath = null ): string;
```
Devuelve la ubicación completa donde se debe escribir el recurso


```php
public function getRealTargetUri(): string;
```
Devuelve la uri destino real para el HTML generado


```php
public function getSourcePath(): string
```

```php
public function getTargetPath(): string
```

```php
public function getTargetUri(): string
```

```php
public function getType(): string
```

```php
public function getVersion(): string|null
```

```php
public function isAutoVersion(): bool;
```
Checks if the asset is using auto version


```php
public function isLocal(): bool;
```
Checks if the asset is local or not


```php
public function setAttributes( array $attributes ): AssetInterface;
```
Establece atributos HTML extra


```php
public function setAutoVersion( bool $flag ): AssetInterface;
```

```php
public function setFilter( bool $filter ): AssetInterface;
```
Establece si el recurso se debe filtrar o no


```php
public function setIsLocal( bool $flag ): AssetInterface;
```
Establece si el recurso es local o externo


```php
public function setPath( string $path ): AssetInterface;
```
Establece la ruta del recurso


```php
public function setSourcePath( string $sourcePath ): AssetInterface;
```
Establece la ruta origen del recurso


```php
public function setTargetPath( string $targetPath ): AssetInterface;
```
Establece la ruta destino del recurso


```php
public function setTargetUri( string $targetUri ): AssetInterface;
```
Establece una uri destino para el HTML generado


```php
public function setType( string $type ): AssetInterface;
```
Establece el tipo de recurso


```php
public function setVersion( string $version ): AssetInterface;
```
Sets the asset's version


```php
protected function phpFileExists( string $filename ): bool;
```
@todo to be removed when we get traits


```php
protected function phpFileGetContents( string $filename );
```





<h1 id="assets-asset-css">Class Phalcon\Assets\Asset\Css</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset/Css.zep)

| Namespace  | Phalcon\Assets\Asset | | Uses       | Phalcon\Assets\Asset | | Extends    | AssetBase |

Representa recursos CSS


## Métodos

```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```
Constructor Phalcon\Assets\Asset\Css




<h1 id="assets-asset-js">Class Phalcon\Assets\Asset\Js</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset/Js.zep)

| Namespace  | Phalcon\Assets\Asset | | Uses       | Phalcon\Assets\Asset | | Extends    | AssetBase |

Representa recursos JavaScript


## Métodos

```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```
Phalcon\Assets\Asset\Js constructor




<h1 id="assets-assetinterface">Interface Phalcon\Assets\AssetInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/AssetInterface.zep)

| Namespace  | Phalcon\Assets |

Interfaz para recursos Phalcon\Assets personalizados


## Métodos

```php
public function getAssetKey(): string;
```
Obtiene la clave del recurso.


```php
public function getAttributes(): array | null;
```
Obtiene los atributos HTML extra.


```php
public function getFilter(): bool;
```
Obtiene si el recurso se debe filtrar o no.


```php
public function getType(): string;
```
Obtiene el tipo de recurso.


```php
public function setAttributes( array $attributes ): AssetInterface;
```
Establece los atributos HTML extra.


```php
public function setFilter( bool $filter ): AssetInterface;
```
Establece si el recurso se debe filtrar o no.


```php
public function setType( string $type ): AssetInterface;
```
Establece el tipo de recurso.




<h1 id="assets-collection">Class Phalcon\Assets\Collection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Collection.zep)

| Namespace  | Phalcon\Assets | | Uses       | ArrayIterator, Countable, IteratorAggregate | | Implements | Countable, IteratorAggregate |

Collection of asset objects

@property array  $assets @property array  $attributes @property bool   $autoVersion @property array  $codes @property array  $filters @property bool   $join @property bool   $isLocal @property string $prefix @property string $sourcePath @property bool   $targetIsLocal @property string $targetPath @property string $targetUri @property string $version


## Propiedades
```php
/**
 * @var array
 */
protected assets;

/**
 * @var array
 */
protected attributes;

/**
 * Should version be determined from file modification time
 *
 * @var bool
 */
protected autoVersion = false;

/**
 * @var array
 */
protected codes;

/**
 * @var array
 */
protected filters;

/**
 * @var bool
 */
protected join = true;

/**
 * @var bool
 */
protected isLocal = true;

/**
 * @var string
 */
protected prefix = ;

/**
 * @var string
 */
protected sourcePath = ;

/**
 * @var bool
 */
protected targetIsLocal = true;

/**
 * @var string
 */
protected targetPath = ;

/**
 * @var string
 */
protected targetUri = ;

/**
 * @var string
 */
protected version = ;

```

## Métodos

```php
public function add( AssetInterface $asset ): Collection;
```
Adds an asset to the collection


```php
public function addCss( string $path, mixed $isLocal = null, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Collection;
```
Añade un recurso CSS a la colección


```php
public function addFilter( FilterInterface $filter ): Collection;
```
Añade un filtro a la colección


```php
public function addInline( Inline $code ): Collection;
```
Añade un código en línea a la colección


```php
public function addInlineCss( string $content, bool $filter = bool, array $attributes = [] ): Collection;
```
Añade un CSS en línea a la colección


```php
public function addInlineJs( string $content, bool $filter = bool, array $attributes = [] ): Collection;
```
Añade un JavaScript en línea a la colección


```php
public function addJs( string $path, mixed $isLocal = null, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Collection;
```
Añade un recurso JavaScript a la colección


```php
public function count(): int;
```
Return the count of the assets


```php
public function getAssets(): array
```

```php
public function getAttributes(): array
```

```php
public function getCodes(): array
```

```php
public function getFilters(): array
```

```php
public function getIterator(): \Traversable;
```
Returns the generator of the class

@link https://php.net/manual/en/iteratoraggregate.getiterator.php


```php
public function getJoin(): bool
```

```php
public function getPrefix(): string
```

```php
public function getRealTargetPath( string $basePath ): string;
```
Devuelve la ubicación completa donde la colección unida/filtrada se debe escribir


```php
public function getSourcePath(): string
```

```php
public function getTargetIsLocal(): bool
```

```php
public function getTargetPath(): string
```

```php
public function getTargetUri(): string
```

```php
public function getVersion(): string
```

```php
public function has( AssetInterface $asset ): bool;
```
Comprueba si este recurso está añadido a la colección.

```php
use Phalcon\Assets\Asset;
use Phalcon\Assets\Collection;

$collection = new Collection();

$asset = new Asset("js", "js/jquery.js");

$collection->add($asset);
$collection->has($asset); // true
```


```php
public function isAutoVersion(): bool;
```
Comprueba si la colección está usando versión automática


```php
public function isLocal(): bool;
```

```php
public function join( bool $flag ): Collection;
```
Establece si todos los recursos filtrados de la colección se deben unir en un sólo fichero resultante


```php
public function setAttributes( array $attributes ): Collection;
```
Establece atributos HTML extra


```php
public function setAutoVersion( bool $flag ): Collection;
```

```php
public function setFilters( array $filters ): Collection;
```
Establece un vector de filtros en la colección


```php
public function setIsLocal( bool $flag ): Collection;
```
Establece si la colección usa recursos locales por defecto


```php
public function setPrefix( string $prefix ): Collection;
```
Establece un prefijo común para todos los recursos


```php
public function setSourcePath( string $sourcePath ): Collection;
```
Establece una ruta de origen base para todos los recursos de esta colección


```php
public function setTargetIsLocal( bool $flag ): Collection;
```
Sets if the target local or not


```php
public function setTargetPath( string $targetPath ): Collection;
```
Establece la ruta destino del fichero para la salida filtrada/unida


```php
public function setTargetUri( string $targetUri ): Collection;
```
Establece una uri destino para el HTML generado


```php
public function setVersion( string $version ): Collection;
```
Sets the version


```php
final protected function addAsset( AssetInterface $asset ): bool;
```
Adds an asset or inline-code to the collection




<h1 id="assets-exception">Class Phalcon\Assets\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Exception.zep)

| Namespace  | Phalcon\Assets | | Extends    | \Exception |

Las excepciones lanzadas en Phalcon\Assets usarán esta clase



<h1 id="assets-filterinterface">Interface Phalcon\Assets\FilterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/FilterInterface.zep)

| Namespace  | Phalcon\Assets |

Interfaz para filtros de Phalcon\Assets personalizados


## Métodos

```php
public function filter( string $content ): string;
```
Filtran el contenido devolviendo una cadena con el contenido filtrado




<h1 id="assets-filters-cssmin">Class Phalcon\Assets\Filters\Cssmin</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/CssMin.zep)

| Namespace  | Phalcon\Assets\Filters | | Uses       | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Minimiza el CSS - elimina comentarios, elimina las líneas nuevas y los avances de línea que se mantienen, elimina el punto y coma de la última propiedad


## Métodos

```php
public function filter( string $content ): string;
```
Filtra el contenido usando CSSMIN NOTA: Esta funcionalidad no está disponible actualmente




<h1 id="assets-filters-jsmin">Class Phalcon\Assets\Filters\Jsmin</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/JsMin.zep)

| Namespace  | Phalcon\Assets\Filters | | Uses       | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Elimina los caracteres que son insignificantes para JavaScript. Se eliminarán los comentarios. Las tabulaciones se reemplazarán con espacios. Los retornos de carro se reemplazarán con saltos de línea. La mayoría de saltos de línea y espacios se eliminarán.


## Métodos

```php
public function filter( string $content ): string;
```
Filtra el contenido usando JSMIN NOTA: Esta funcionalidad no está disponible actualmente




<h1 id="assets-filters-none">Class Phalcon\Assets\Filters\None</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/None.zep)

| Namespace  | Phalcon\Assets\Filters | | Uses       | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Devuelve el contenido sin hacer ninguna modificación sobre la fuente original


## Métodos

```php
public function filter( string $content ): string;
```
Devuelve el contenido tal cual




<h1 id="assets-inline">Class Phalcon\Assets\Inline</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline.zep)

| Namespace  | Phalcon\Assets | | Implements | AssetInterface |

Representa un recurso en línea

```php
$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");
```


## Propiedades
```php
/**
 * @var array | null
 */
protected attributes;

/**
 * @var string
 */
protected content;

/**
 * @var bool
 */
protected filter;

/**
 * @var string
 */
protected type;

```

## Métodos

```php
public function __construct( string $type, string $content, bool $filter = bool, array $attributes = [] );
```
Constructor Phalcon\Assets\Inline


```php
public function getAssetKey(): string;
```
Obtiene la clave del recurso.


```php
public function getAttributes(): array | null
```

```php
public function getContent(): string
```

```php
public function getFilter(): bool
```

```php
public function getType(): string
```

```php
public function setAttributes( array $attributes ): AssetInterface;
```
Establece atributos HTML extra


```php
public function setFilter( bool $filter ): AssetInterface;
```
Establece si el recurso se debe filtrar o no


```php
public function setType( string $type ): AssetInterface;
```
Establece el tipo en línea




<h1 id="assets-inline-css">Class Phalcon\Assets\Inline\Css</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline/Css.zep)

| Namespace  | Phalcon\Assets\Inline | | Uses       | Phalcon\Assets\Inline | | Extends    | InlineBase |

Representa un CSS en línea


## Métodos

```php
public function __construct( string $content, bool $filter = bool, array $attributes = [] );
```
Constructor Phalcon\Assets\Inline\Css




<h1 id="assets-inline-js">Class Phalcon\Assets\Inline\Js</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline/Js.zep)

| Namespace  | Phalcon\Assets\Inline | | Uses       | Phalcon\Assets\Inline | | Extends    | InlineBase |

Representa un JavaScript en línea


## Métodos

```php
public function __construct( string $content, bool $filter = bool, array $attributes = [] );
```
Constructor Phalcon\Assets\Inline\Js




<h1 id="assets-manager">Class Phalcon\Assets\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Manager.zep)

| Namespace  | Phalcon\Assets | | Uses       | Phalcon\Assets\Asset\Css, Phalcon\Assets\Asset\Js, Phalcon\Assets\Inline\Css, Phalcon\Assets\Inline\Js, Phalcon\Di\AbstractInjectionAware, Phalcon\Html\Helper\Element, Phalcon\Html\Helper\Link, Phalcon\Html\Helper\Script, Phalcon\Html\TagFactory | | Extends    | AbstractInjectionAware |

Gestiona colecciones de recursos CSS/JavaScript

@property array      $collections @property bool       $implicitOutput @property array      $options @property TagFactory $tagFactory


## Propiedades
```php
/**
 * @var array
 */
protected collections;

/**
 * @var bool
 */
protected implicitOutput = true;

/**
 * @var array
 */
protected options;

/**
 * @var TagFactory
 */
protected tagFactory;

```

## Métodos

```php
public function __construct( TagFactory $tagFactory, array $options = [] );
```
Constructor del gestor.


```php
public function addAsset( Asset $asset ): Manager;
```
Añade un recurso en bruto al gestor


```php
public function addAssetByType( string $type, Asset $asset ): Manager;
```
Añade un recurso por su tipo


```php
public function addCss( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Manager;
```
Añade un recurso CSS a la colección 'css'


```php
public function addInlineCode( Inline $code ): Manager;
```
Añade un código en línea en bruto al gestor


```php
public function addInlineCodeByType( string $type, Inline $code ): Manager;
```
Añade un código en línea por su tipo


```php
public function addInlineCss( string $content, bool $filter = bool, array $attributes = [] ): Manager;
```
Añade un CSS en línea a la colección 'css'


```php
public function addInlineJs( string $content, bool $filter = bool, array $attributes = [] ): Manager;
```
Añade un JavaScript en línea a la colección 'js'


```php
public function addJs( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Manager;
```
Añade un recurso JavaScript a la colección 'js'

```php
$assets->addJs("scripts/jquery.js");
$assets->addJs("http://jquery.my-cdn.com/jquery.js", false);
```


```php
public function collection( string $name ): Collection;
```
Crea/Devuelve una colección de recursos


```php
public function collectionAssetsByType( array $assets, string $type ): array;
```
Crea/Devuelve una colección de recursos por tipo


```php
public function exists( string $name ): bool;
```
Devuelve `true` o `false` si existe la colección.

```php
if ($manager->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $manager->get("jsHeader");
}
```


```php
public function get( string $name ): Collection;
```
Devuelve una colección por su id.

```php
$scripts = $assets->get("js");
```


```php
public function getCollections(): Collection[];
```
Devuelve las colecciones existentes en el gestor


```php
public function getCss(): Collection;
```
Devuelve la colección de recursos JavaScript


```php
public function getJs(): Collection;
```
Devuelve la colección de recursos JavaScript


```php
public function getOptions(): array;
```
Devuelve las opciones del gestor


```php
public function has( string $name ): bool;
```
Devuelve `true` o `false` si existe la colección.

```php
if ($manager->has("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $manager->get("jsHeader");
}
```


```php
public function output( Collection $collection, string $type ): string | null;
```
Recorre una colección llamando a la función de retorno para generar su HTML


```php
public function outputCss( string $name = null ): string;
```
Imprime el HTML para los recursos CSS


```php
public function outputInline( Collection $collection, mixed $type ): string;
```
Recorre una colección y genera su HTML


```php
public function outputInlineCss( string $name = null ): string;
```
Imprime el HTML para CSS en línea


```php
public function outputInlineJs( string $name = null ): string;
```
Imprime el HTML para JS en línea


```php
public function outputJs( string $name = null ): string;
```
Imprime el HTML para recursos JS


```php
public function set( string $name, Collection $collection ): Manager;
```
Establece una colección en el Gestor de Recursos

```php
$assets->set("js", $collection);
```


```php
public function setOptions( array $options ): Manager;
```
Establece las opciones del gestor


```php
public function useImplicitOutput( bool $implicitOutput ): Manager;
```
Establece si el HTML generado debe ser impreso directamente o devuelto


