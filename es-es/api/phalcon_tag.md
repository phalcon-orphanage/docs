---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Tag'
---

* [Phalcon\Tag](#tag)
* [Phalcon\Tag\Exception](#tag-exception)
* [Phalcon\Tag\Select](#tag-select)

<h1 id="tag">Class Phalcon\Tag</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Tag.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\DiInterface, Phalcon\Escaper\EscaperInterface, Phalcon\Html\Link\Link, Phalcon\Html\Link\Serializer\Header, Phalcon\Helper\Str, Phalcon\Helper\Exception, Phalcon\Tag\Select, Phalcon\Tag\Exception, Phalcon\Url\UrlInterface |

Phalcon\Tag es diseñada para simplificar la construcción de etiquetas HTML. Esta provee un conjunto de auxiliares para generar HTML de una forma dinámica. Este componente es una clase que puede ser extendida para añadir más auxiliares (helpers).

## Constantes

```php
const HTML32 = 1;
const HTML401_FRAMESET = 4;
const HTML401_STRICT = 2;
const HTML401_TRANSITIONAL = 3;
const HTML5 = 5;
const XHTML10_FRAMESET = 8;
const XHTML10_STRICT = 6;
const XHTML10_TRANSITIONAL = 7;
const XHTML11 = 9;
const XHTML20 = 10;
const XHTML5 = 11;
```

## Propiedades

```php
//
protected static autoEscape = true;

/**
 * DI Container
 */
protected static container;

/**
 * Pre-assigned values for components
 */
protected static displayValues;

//
protected static documentAppendTitle;

//
protected static documentPrependTitle;

/**
 * HTML document title
 */
protected static documentTitle;

//
protected static documentTitleSeparator;

//
protected static documentType = 11;

//
protected static escaperService;

//
protected static urlService;

```

## Métodos

```php
public static function appendTitle( mixed $title ): void;
```

Añade un texto al final del título del documento actual

```php
public static function checkField( mixed $parameters ): string;
```

Construye una etiqueta input[type="check"] de HTML

```php
public static function colorField( mixed $parameters ): string;
```

Construye una etiqueta input[type="color"] de HTML

```php
public static function dateField( mixed $parameters ): string;
```

Construye una etiqueta input[type="date"] de HTML

```php
public static function dateTimeField( mixed $parameters ): string;
```

Construye una etiqueta input[type="datetime"] de HTML

```php
public static function dateTimeLocalField( mixed $parameters ): string;
```

Construye una etiqueta input[type="datetime-local"] de HTML

```php
public static function displayTo( string $id, mixed $value ): void;
```

Alias de Phalcon\Tag::setDefault()

```php
public static function emailField( mixed $parameters ): string;
```

Construye una etiqueta input[type="email"] de HTML

```php
public static function endForm(): string;
```

Construye una etiqueta HTML para cerrar una etiqueta FORM

```php
public static function fileField( mixed $parameters ): string;
```

Construye una etiqueta Input[type="file"] de HTML

```php
public static function form( mixed $parameters ): string;
```

Construye una etiqueta FORM de HTML

```php
public static function friendlyTitle( string $text, string $separator = string, bool $lowercase = bool, mixed $replace = null ): string;
```

Convierte textos en títulos URL-amigables

```php
public static function getDI(): DiInterface;
```

Internamente obtiene el despachador de solicitudes

```php
public static function getDocType(): string;
```

Obtiene la declaración de tipo del documento de contenido

```php
public static function getEscaper( array $params ): EscaperInterface | null;
```

Obtiene el servicio 'escaper' si es necesario

```php
public static function getEscaperService(): EscaperInterface;
```

Devuelve un servicio Escaper del DI predeterminado

```php
public static function getTitle( bool $prepend = bool, bool $append = bool ): string;
```

Devuelve el título del documento actual. El título será escapado automáticamente.

```php
public static function getTitleSeparator(): string;
```

Obtiene el separador de título del documento actual

```php
public static function getUrlService(): UrlInterface;
```

Devuelve un servicio de URL del DI predeterminado

```php
public static function getValue( mixed $name, array $params = [] );
```

Todos los ayudantes llaman a esta función para verificar si un componente tiene un valor predefinido mediante Phalcon\Tag::setDefault o un valor desde $_POST

```php
public static function hasValue( mixed $name ): bool;
```

Comprueba si un ayudante tiene un valor predeterminado establecido usando Phalcon\Tag::setDefault o un valor desde $_POST

```php
public static function hiddenField( mixed $parameters ): string;
```

Construye una etiqueta Input[type="hidden"] de HTML

```php
public static function image( mixed $parameters = null, bool $local = bool ): string;
```

Construye etiquetas IMG de HTML

```php
public static function imageInput( mixed $parameters ): string;
```

Construye una etiqueta input[type="image"] de HTML

```php
public static function javascriptInclude( mixed $parameters = null, bool $local = bool ): string;
```

Construye una etiqueta SCRIPT[type="javascript"]

```php
public static function linkTo( mixed $parameters, mixed $text = null, mixed $local = bool ): string;
```

Construye un etiqueta HTML A usando convenciones del framework

```php
public static function monthField( mixed $parameters ): string;
```

Construye una etiqueta input[type="month"] de HTML

```php
public static function numericField( mixed $parameters ): string;
```

Construye una etiqueta input[type="number"] de HTML

```php
public static function passwordField( mixed $parameters ): string;
```

Construye una etiqueta Input[type="password"] de HTML

```php
public static function preload( mixed $parameters ): string;
```

Analiza el elemento de precarga pasado y establece las cabeceras de enlace necesarias

```php
public static function prependTitle( mixed $title ): void;
```

Antepone un texto al título del documento actual

```php
public static function radioField( mixed $parameters ): string;
```

Construye una etiqueta input[type="radio"] de HTML

```php
public static function rangeField( mixed $parameters ): string;
```

Construye una etiqueta input[type="range"] de HTML

```php
public static function renderAttributes( string $code, array $attributes ): string;
```

Construye parámetros manteniendo el orden en sus atributos HTML

```php
public static function renderTitle( bool $prepend = bool, bool $append = bool ): string;
```

Renderiza el título con etiquetas de título. El título se escapa automáticamente

```php
deprecated public static function resetInput(): void;
```

Restablece los valores solicitados y los valores internos para evitar que los campos tengan cualquier valor por defecto.

@deprecated será eliminado en 4.0.0

```php
public static function searchField( mixed $parameters ): string;
```

Construye una etiqueta Input[type="search"] de HTML

```php
public static function select( mixed $parameters, mixed $data = null ): string;
```

Construye una etiqueta SELECT de HTML usando un conjunto de resultados de Phalcon\Mvc\Model como opciones

```php
public static function selectStatic( mixed $parameters, mixed $data = null ): string;
```

Construye una etiqueta SELECT de HTML usando un vector de PHP para las opciones

```php
public static function setAutoescape( bool $autoescape ): void;
```

Establece el modo autoescapado en el HTML generado

```php
public static function setDI( DiInterface $container ): void;
```

Establece el contenedor de inyección de dependencias.

```php
public static function setDefault( string $id, mixed $value ): void;
```

Asigna valores predeterminados a las etiquetas generadas por los ayudantes

```php
public static function setDefaults( array $values, bool $merge = bool ): void;
```

Asigna valores predeterminados a las etiquetas generadas por los ayudantes

```php
public static function setDocType( int $doctype ): void;
```

Establece el tipo del documento de contenido

```php
public static function setTitle( string $title ): void;
```

Establece el título del contenido de la vista

```php
public static function setTitleSeparator( string $titleSeparator ): void;
```

Establece el separador de título del contenido de la vista

```php
public static function stylesheetLink( mixed $parameters = null, bool $local = bool ): string;
```

Construye una etiqueta LINK[rel="stylesheet"]

```php
public static function submitButton( mixed $parameters ): string;
```

Construye una etiqueta input[type="submit"] de HTML

```php
public static function tagHtml( string $tagName, mixed $parameters = null, bool $selfClose = bool, bool $onlyStart = bool, bool $useEol = bool ): string;
```

Construye una etiqueta HTML

```php
public static function tagHtmlClose( string $tagName, bool $useEol = bool ): string;
```

Construye una etiqueta HTML de cierre

```php
public static function telField( mixed $parameters ): string;
```

Construye una etiqueta input[type="tel"] de HTML

```php
public static function textArea( mixed $parameters ): string;
```

Construye una etiqueta TEXTAREA de HTML

@paraym array parameters = [ 'id' => '', 'name' => '', 'value' => '', 'class' => '' ]

```php
public static function textField( mixed $parameters ): string;
```

Construye una etiqueta input[type="text"] de HTML

```php
public static function timeField( mixed $parameters ): string;
```

Construye una etiqueta Input[type="time"] de HTML

```php
public static function urlField( mixed $parameters ): string;
```

Construye una etiqueta input[type="url"] de HTML

```php
public static function weekField( mixed $parameters ): string;
```

Construye una etiqueta input[type="week"] de HTML

```php
static final protected function inputField( string $type, mixed $parameters, bool $asValue = bool ): string;
```

Construye etiquetas INPUT genéricas

```php
static final protected function inputFieldChecked( string $type, mixed $parameters ): string;
```

Construye etiquetas INPUT que implementan el atributo checked

<h1 id="tag-exception">Class Phalcon\Tag\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Tag/Exception.zep)

| Namespace | Phalcon\Tag | | Extends | \Phalcon\Exception |

Phalcon\Tag\Exception

Las excepciones lanzadas en Phalcon\Tag usarán esta clase

<h1 id="tag-select">Abstract Class Phalcon\Tag\Select</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Tag/Select.zep)

| Namespace | Phalcon\Tag | | Uses | Phalcon\Tag, Phalcon\Escaper\EscaperInterface, Phalcon\Mvc\Model\ResultsetInterface |

Phalcon\Tag\Select

Genera una etiqueta SELECT en HTML utilizando un vector estático de valores o un conjunto de resultados de Phalcon\Mvc\Model

## Métodos

```php
public static function selectField( mixed $parameters, mixed $data = null ): string;
```

Genera una etiqueta SELECT
