---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Translate'
---

* [Phalcon\Translate\Adapter\AbstractAdapter](#translate-adapter-abstractadapter)
* [Phalcon\Translate\Adapter\AdapterInterface](#translate-adapter-adapterinterface)
* [Phalcon\Translate\Adapter\Csv](#translate-adapter-csv)
* [Phalcon\Translate\Adapter\Gettext](#translate-adapter-gettext)
* [Phalcon\Translate\Adapter\NativeArray](#translate-adapter-nativearray)
* [Phalcon\Translate\Exception](#translate-exception)
* [Phalcon\Translate\Interpolator\AssociativeArray](#translate-interpolator-associativearray)
* [Phalcon\Translate\Interpolator\IndexedArray](#translate-interpolator-indexedarray)
* [Phalcon\Translate\Interpolator\InterpolatorInterface](#translate-interpolator-interpolatorinterface)
* [Phalcon\Translate\InterpolatorFactory](#translate-interpolatorfactory)
* [Phalcon\Translate\TranslateFactory](#translate-translatefactory)

<h1 id="translate-adapter-abstractadapter">Abstract Class Phalcon\Translate\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Implements | AdapterInterface |

Phalcon\Translate\Adapter

Clase base para adaptadores Phalcon\Translate

## Propiedades

```php
/**
 * @var string
 */
protected defaultInterpolator = ;

/**
    * @var InterpolatorFactory
    */
protected interpolatorFactory;

```

## Métodos

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```

```php
public function _( string $translateKey, array $placeholders = [] ): string;
```

Devuelve la cadena de traducción de la clave dada (alias del método 't')

```php
public function offsetExists( mixed $translateKey ): bool;
```

Comprueba si existe una clave de traducción

```php
public function offsetGet( mixed $translateKey ): mixed;
```

Devuelve la traducción relacionada con la clave proporcionada

```php
public function offsetSet( mixed $offset, mixed $value ): void;
```

Establece un valor de traducción

```php
public function offsetUnset( mixed $offset ): void;
```

Anula una traducción del diccionario

```php
public function t( string $translateKey, array $placeholders = [] ): string;
```

Devuelve la cadena de traducción de la clave dada

```php
protected function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Reemplaza los marcadores de posición por los valores pasados

<h1 id="translate-adapter-adapterinterface">Interface Phalcon\Translate\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Translate\Adapter |

Phalcon\Translate\Adapter\AdapterInterface

Interfaz para adaptadores Phalcon\Translate

## Métodos

```php
public function exists( string $index ): bool;
```

Comprueba si una clave de traducción está definida en el vector interno

```php
public function query( string $translateKey, array $placeholders = [] ): string;
```

Devuelve la traducción relacionada con la clave proporcionada

```php
public function t( string $translateKey, array $placeholders = [] ): string;
```

Devuelve la cadena de traducción de la clave dada

<h1 id="translate-adapter-csv">Class Phalcon\Translate\Adapter\Csv</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/Csv.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | ArrayAccess |

Phalcon\Translate\Adapter\Csv

Permite definir listas de traducciones usando un fichero CSV

## Propiedades

```php
/**
 * @var array
 */
protected translate;

```

## Métodos

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```

Constructor Phalcon\Translate\Adapter\Csv

```php
public function exists( string $index ): bool;
```

Comprueba si una clave de traducción está definida en el vector interno

```php
public function query( string $index, array $placeholders = [] ): string;
```

Devuelve la traducción relacionada con la clave proporcionada

<h1 id="translate-adapter-gettext">Class Phalcon\Translate\Adapter\Gettext</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/Gettext.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | ArrayAccess |

Phalcon\Translate\Adapter\Gettext

```php
use Phalcon\Translate\Adapter\Gettext;

$adapter = new Gettext(
    [
        "locale"        => "de_DE.UTF-8",
        "defaultDomain" => "translations",
        "directory"     => "/path/to/application/locales",
        "category"      => LC_MESSAGES,
    ]
);
```

Permite traducir usando gettext

## Propiedades

```php
/**
 * @var int
 */
protected category;

/**
 * @var string
 */
protected defaultDomain;

/**
 * @var string|array
 */
protected directory;

/**
 * @var string
 */
protected locale;

```

## Métodos

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```

Constructor Phalcon\Translate\Adapter\Gettext

```php
public function exists( string $index ): bool;
```

Comprueba si una clave de traducción está definida en el vector interno

```php
public function getCategory(): int
```

```php
public function getDefaultDomain(): string
```

```php
public function getDirectory(): string|array
```

```php
public function getLocale(): string
```

```php
public function nquery( string $msgid1, string $msgid2, int $count, array $placeholders = [], string $domain = null ): string;
```

La versión plural de gettext(). Algunos idiomas tienen mas de una forma para los mensajes en plural y dependen del contador.

```php
public function query( string $index, array $placeholders = [] ): string;
```

Devuelve la traducción relacionada con la clave dada.

```php
$translator->query("你好 %name%！", ["name" => "Phalcon"]);
```

```php
public function resetDomain(): string;
```

Establece el dominio por defecto

```php
public function setDefaultDomain( string $domain ): void;
```

Establece el dominio por defecto para buscar dentro de él cuando se realicen llamadas a gettext()

```php
public function setDirectory( mixed $directory ): void;
```

Establece la ruta para un dominio

```php
// Set the directory path
$gettext->setDirectory("/path/to/the/messages");

// Set the domains and directories path
$gettext->setDirectory(
    [
        "messages" => "/path/to/the/messages",
        "another"  => "/path/to/the/another",
    ]
);
```

```php
public function setDomain( mixed $domain ): string;
```

Cambia el dominio actual (es decir, el archivo de traducción)

```php
public function setLocale( int $category, string $locale ): string | bool;
```

Establece la información de configuración regional

```php
// Set locale to Dutch
$gettext->setLocale(LC_ALL, "nl_NL");

// Try different possible locale names for German
$gettext->setLocale(LC_ALL, "de_DE@euro", "de_DE", "de", "ge");
```

```php
protected function getOptionsDefault(): array;
```

Devuelve las opciones por defecto

```php
protected function prepareOptions( array $options ): void;
```

Validador para el constructor

<h1 id="translate-adapter-nativearray">Class Phalcon\Translate\Adapter\NativeArray</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/NativeArray.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | ArrayAccess |

Phalcon\Translate\Adapter\NativeArray

Permite definir listas de traducción usando vectores PHP

## Propiedades

```php
/**
 * @var array
 */
private translate;

/**
 * @var bool
 */
private triggerError = false;

```

## Métodos

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```

Constructor Phalcon\Translate\Adapter\NativeArray

```php
public function exists( string $index ): bool;
```

Comprueba si una clave de traducción está definida en el vector interno

```php
public function notFound( string $index ): string;
```

Siempre que no se encuentre una clave, se llamará a este método

```php
public function query( string $index, array $placeholders = [] ): string;
```

Devuelve la traducción relacionada con la clave proporcionada

<h1 id="translate-exception">Class Phalcon\Translate\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Exception.zep)

| Namespace | Phalcon\Translate | | Extends | \Phalcon\Exception |

Phalcon\Translate\Exception

Clase para excepciones lanzadas por Phalcon\Translate

<h1 id="translate-interpolator-associativearray">Class Phalcon\Translate\Interpolator\AssociativeArray</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Interpolator/AssociativeArray.zep)

| Namespace | Phalcon\Translate\Interpolator | | Implements | InterpolatorInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Reemplaza los marcadores de posición por los valores pasados

<h1 id="translate-interpolator-indexedarray">Class Phalcon\Translate\Interpolator\IndexedArray</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Interpolator/IndexedArray.zep)

| Namespace | Phalcon\Translate\Interpolator | | Implements | InterpolatorInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Reemplaza los marcadores de posición por los valores pasados

<h1 id="translate-interpolator-interpolatorinterface">Interface Phalcon\Translate\Interpolator\InterpolatorInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Interpolator/InterpolatorInterface.zep)

| Namespace | Phalcon\Translate\Interpolator |

Phalcon\Translate\InterpolatorInterface

Interfaz para interpoladores Phalcon\Translate

## Métodos

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Reemplaza los marcadores de posición por los valores pasados

<h1 id="translate-interpolatorfactory">Class Phalcon\Translate\InterpolatorFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/InterpolatorFactory.zep)

| Namespace | Phalcon\Translate | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Translate\Interpolator\InterpolatorInterface | | Extends | AbstractFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor AdapterFactory.

```php
public function newInstance( string $name ): InterpolatorInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```

<h1 id="translate-translatefactory">Class Phalcon\Translate\TranslateFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/TranslateFactory.zep)

| Namespace | Phalcon\Translate | | Uses | Phalcon\Config, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr, Phalcon\Translate\Adapter\AdapterInterface | | Extends | AbstractFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Propiedades

```php
/**
 * @var InterpolatorFactory
 */
private interpolator;

```

## Métodos

```php
public function __construct( InterpolatorFactory $interpolator, array $services = [] );
```

Constructor AdapterFactory.

```php
public function load( mixed $config ): mixed;
```

Factoría para crear una instancia desde un objeto Config

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```
