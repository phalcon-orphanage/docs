---
layout: default
language: 'es-es'
version: '4.0'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Asset.zep)

| Namespace | Phalcon\Assets | | Implements | AssetInterface |

Representa un recurso

```php
$asset = new \Phalcon\Assets\Asset("js", "javascripts/jquery.js");
```

## Propiedades

```php
/**
 * @var array | null
 */
protected attributes;

/**
 * @var bool
 */
protected autoVersion = false;

/**
 * @var bool
 */
protected filter;

/**
 * @var bool
 */
protected local;

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
     * @var string
     */
protected version;

```

## Métodos

```php
public function __construct( string $type, string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```

Constructor Phalcon\Assets\Asset

```php
public function getAssetKey(): string;
```

Obtiene la clave del recurso.

```php
public function getAttributes(): array | null
```

```php
public function getContent( string $basePath = null ): string;
```

Devuelve el contenido del recurso como una cadena Opcionalmente se puede establecer una ruta base donde localizar el recurso

```php
public function getFilter(): bool
```

```php
public function getLocal(): bool
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
public function getVersion():   string
```

```php
public function isAutoVersion(): bool;
```

Comprueba si el recurso está usando la versión automática

```php
public function setAttributes( array $attributes ): AssetInterface;
```

Establece atributos HTML extra

```php
public function setAutoVersion( bool $autoVersion )
```

```php
public function setFilter( bool $filter ): AssetInterface;
```

Establece si el recurso se debe filtrar o no

```php
public function setLocal( bool $local ): AssetInterface;
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
public function setVersion(     string $version )
```

<h1 id="assets-asset-css">Class Phalcon\Assets\Asset\Css</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Asset/Css.zep)

| Namespace | Phalcon\Assets\Asset | | Uses | Phalcon\Assets\Asset | | Extends | AssetBase |

Representa recursos CSS

## Métodos

```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```

Constructor Phalcon\Assets\Asset\Css

<h1 id="assets-asset-js">Class Phalcon\Assets\Asset\Js</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Asset/Js.zep)

| Namespace | Phalcon\Assets\Asset | | Uses | Phalcon\Assets\Asset | | Extends | AssetBase |

Representa recursos JavaScript

## Métodos

```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```

Phalcon\Assets\Asset\Js constructor

<h1 id="assets-assetinterface">Interface Phalcon\Assets\AssetInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/AssetInterface.zep)

| Namespace | Phalcon\Assets |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Collection.zep)

| Namespace | Phalcon\Assets | | Uses | Countable, Iterator, Phalcon\Assets\Asset\Css, Phalcon\Assets\Asset\Js, Phalcon\Assets\Inline\Js, Phalcon\Assets\Inline\Css | | Implements | Countable, Iterator |

Representa una colección de recursos

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
 * @var array
 */
protected includedAssets;

/**
 * @var bool
 */
protected join = true;

/**
 * @var bool
 */
protected local = true;

/**
 * @var string
 */
protected prefix;

/**
 * @var int
 */
protected position = 0;

/**
 * @var string
 */
protected sourcePath;

/**
 * @var bool
 */
protected targetLocal = true;

/**
 * @var string
 */
protected targetPath;

/**
 * @var string
 */
protected targetUri;

/**
     * Version of resource
     * @var string
     */
protected version;

```

## Métodos

```php
public function __construct();
```

Constructor Phalcon\Assets\Collection

```php
public function add( AssetInterface $asset ): Collection;
```

Añade un recurso a la colección

```php
public function addCss( string $path, mixed $local = null, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Collection;
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
public function addInlineCss( string $content, bool $filter = bool, mixed $attributes = null ): Collection;
```

Añade un CSS en línea a la colección

```php
public function addInlineJs( string $content, bool $filter = bool, mixed $attributes = null ): Collection;
```

Añade un JavaScript en línea a la colección

```php
public function addJs( string $path, mixed $local = null, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Collection;
```

Añade un recurso JavaScript a la colección

```php
public function count(): int;
```

Devuelve el número de elementos en la colección

```php
public function current(): Asset;
```

Devuelve el recurso actual en el iterador

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
public function getJoin(): bool
```

```php
public function getLocal(): bool
```

```php
public function getPosition(): int
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
public function getTargetLocal(): bool
```

```php
public function getTargetPath(): string
```

```php
public function getTargetUri(): string
```

```php
public function getVersion():   string
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
public function join( bool $join ): Collection;
```

Establece si todos los recursos filtrados de la colección se deben unir en un sólo fichero resultante

```php
public function key(): int;
```

Devuelve la clave/posición actual del iterador

```php
public function next(): void;
```

Mueve el puntero interno de iteración a la siguiente posición

```php
public function rewind(): void;
```

Rebobina el iterador interno

```php
public function setAttributes( array $attributes ): Collection;
```

Establece atributos HTML extra

```php
public function setAutoVersion(     bool $autoVersion )
```

```php
public function setFilters( array $filters ): Collection;
```

Establece un vector de filtros en la colección

```php
public function setLocal( bool $local ): Collection;
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
public function setTargetLocal( bool $targetLocal ): Collection;
```

Establece el destino local

```php
public function setTargetPath( string $targetPath ): Collection;
```

Establece la ruta destino del fichero para la salida filtrada/unida

```php
public function setTargetUri( string $targetUri ): Collection;
```

Establece una uri destino para el HTML generado

```php
public function setVersion(     string $version )
```

```php
public function valid(): bool;
```

Comprueba si el elemento actual en el iterador es válido

```php
final protected function addAsset( AssetInterface $asset ): bool;
```

Añade un recurso o código-en-línea a la colección

<h1 id="assets-exception">Class Phalcon\Assets\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Exception.zep)

| Namespace | Phalcon\Assets | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Assets usarán esta clase

<h1 id="assets-filterinterface">Interface Phalcon\Assets\FilterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/FilterInterface.zep)

| Namespace | Phalcon\Assets |

Interfaz para filtros de Phalcon\Assets personalizados

## Métodos

```php
public function filter( string $content ): string;
```

Filtran el contenido devolviendo una cadena con el contenido filtrado

<h1 id="assets-filters-cssmin">Class Phalcon\Assets\Filters\Cssmin</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Filters/CssMin.zep)

| Namespace | Phalcon\Assets\Filters | | Uses | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Minimiza el CSS - elimina comentarios, elimina las líneas nuevas y los avances de línea que se mantienen, elimina el punto y coma de la última propiedad

## Métodos

```php
public function filter( string $content ): string;
```

Filtra el contenido usando CSSMIN NOTA: Esta funcionalidad no está disponible actualmente

<h1 id="assets-filters-jsmin">Class Phalcon\Assets\Filters\Jsmin</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Filters/JsMin.zep)

| Namespace | Phalcon\Assets\Filters | | Uses | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Elimina los caracteres que son insignificantes para JavaScript. Se eliminarán los comentarios. Las tabulaciones se reemplazarán con espacios. Los retornos de carro se reemplazarán con saltos de línea. La mayoría de saltos de línea y espacios se eliminarán.

## Métodos

```php
public function filter( string $content ): string;
```

Filtra el contenido usando JSMIN NOTA: Esta funcionalidad no está disponible actualmente

<h1 id="assets-filters-none">Class Phalcon\Assets\Filters\None</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Filters/None.zep)

| Namespace | Phalcon\Assets\Filters | | Uses | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Devuelve el contenido sin hacer ninguna modificación sobre la fuente original

## Métodos

```php
public function filter( string $content ): string;
```

Devuelve el contenido tal cual

<h1 id="assets-inline">Class Phalcon\Assets\Inline</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Inline.zep)

| Namespace | Phalcon\Assets | | Implements | AssetInterface |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Inline/Css.zep)

| Namespace | Phalcon\Assets\Inline | | Uses | Phalcon\Assets\Inline | | Extends | InlineBase |

Representa un CSS en línea

## Métodos

```php
public function __construct( string $content, bool $filter = bool, mixed $attributes = null );
```

Constructor Phalcon\Assets\Inline\Css

<h1 id="assets-inline-js">Class Phalcon\Assets\Inline\Js</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Inline/Js.zep)

| Namespace | Phalcon\Assets\Inline | | Uses | Phalcon\Assets\Inline | | Extends | InlineBase |

Representa un JavaScript en línea

## Métodos

```php
public function __construct( string $content, bool $filter = bool, mixed $attributes = null );
```

Constructor Phalcon\Assets\Inline\Js

<h1 id="assets-manager">Class Phalcon\Assets\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Assets/Manager.zep)

| Namespace | Phalcon\Assets | | Uses | Phalcon\Tag, Phalcon\Assets\Asset\Js, Phalcon\Assets\Asset\Css, Phalcon\Assets\Inline\Css, Phalcon\Assets\Inline\Js, Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware | | Extends | AbstractInjectionAware |

Phalcon\Assets\Manager

Gestiona colecciones de recursos CSS/JavaScript

## Propiedades

```php
//
protected collections;

/**
 * Options configure
 * @var array
 */
protected options;

/**
 * @var bool
 */
protected implicitOutput = true;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Constructor Phalcon\Assets\Manager

```php
public function addAsset( Asset $asset ): Manager;
```

Añade un recurso en bruto al gestor

```php
$assets->addAsset(
    new Phalcon\Assets\Asset("css", "css/style.css")
);
```

```php
public function addAssetByType( string $type, Asset $asset ): Manager;
```

Añade un recurso por su tipo

```php
$assets->addAssetByType(
    "css",
    new \Phalcon\Assets\Asset\Css("css/style.css")
);
```

```php
public function addCss( string $path, mixed $local = bool, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Manager;
```

Añade un recurso CSS a la colección 'css'

   ```php
   $assets->addCss("css/bootstrap.css");
   $assets->addCss("http://bootstrap.my-cdn.com/style.css", false);
   ```

```php
public function addInlineCode( Inline $code ): Manager;
```

Añade un código en línea en bruto al gestor

```php
public function addInlineCodeByType( string $type, Inline $code ): Manager;
```

Añade un código en línea por su tipo

```php
public function addInlineCss( string $content, mixed $filter = bool, mixed $attributes = null ): Manager;
```

Añade un CSS en línea a la colección 'css'

```php
public function addInlineJs( string $content, mixed $filter = bool, mixed $attributes = null ): Manager;
```

Añade un JavaScript en línea a la colección 'js'

```php
public function addJs( string $path, mixed $local = bool, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Manager;
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
public function exists( string $id ): bool;
```

Devuelve `true` o `false` si existe la colección.

```php
if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}
```

```php
public function get( string $id ): Collection;
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

Devuelve la colección de recursos CSS

```php
public function getJs(): Collection;
```

Devuelve la colección de recursos JavaScript

```php
public function getOptions(): array;
```

Devuelve las opciones del gestor

```php
public function output( Collection $collection, mixed $callback, mixed $type ): string | null;
```

Recorre una colección llamando a la función de retorno para generar su HTML

```php
public function outputCss( string $collectionName = null ): string;
```

Imprime el HTML para los recursos CSS

```php
public function outputInline( Collection $collection, mixed $type ): string;
```

Recorre una colección y genera su HTML

```php
public function outputInlineCss( string $collectionName = null ): string;
```

Imprime el HTML para CSS en línea

```php
public function outputInlineJs( string $collectionName = null ): string;
```

Imprime el HTML para JS en línea

```php
public function outputJs( string $collectionName = null ): string;
```

Imprime el HTML para recursos JS

```php
public function set( string $id, Collection $collection ): Manager;
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
