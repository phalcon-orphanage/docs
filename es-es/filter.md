---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#filter'
title: 'Filtro'
keywords: 'filter, sanitize'
---

# Filtro

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Controladores

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327)

Sanitizing content can be achieved using the [Phalcon\Filter](api/phalcon_filter#filter) and [Phalcon\Filter\FilterFactory](api/phalcon_filter#filter-filterfactory) classes.

## FilterFactory

This component creates a new locator with predefined filters attached to it. Each filter is lazy loaded for maximum performance. To instantiate the factory and retrieve the [Phalcon\Filter](api/phalcon_filter#filter) with the preset sanitizers you need to call `newInstance()`

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();
```

You can now use the locator wherever you need and sanitize content as per the needs of your application.

## Filtro

The [Phalcon\Filter](api/phalcon_filter#filter) component implements a locator service and can be used as a stand alone component, without initializing the built-in filters.

```php
<?php

use MyApp\Sanitizers\HelloSanitizer;
use Phalcon\Filter;

$services = [
    'hello' => HelloSanitizer::class,
];

$locator = new Filter($services);

$text = $locator->hello('World');
```

> **NOTE**: The [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container already has a [Phalcon\Filter](api/phalcon_filter#filter) object loaded with the predefined sanitizers. Se puede acceder al componente utilizando el nombre del filtro (`filter`).
{: .alert .alert-info }

## Built-in

> **NOTE**: Where appropriate, the sanitizers will cast the value to the type expected. For example the `absint` sanitizer will remove all non numeric characters from the input, cast the input to an integer and return its absolute value.
{: .alert .alert-warning }

A continuación se enlistan los filtros predeterminados del componente. (N. del T.: se preserva la palabra inglesa *mixed* [mixto], para definir que el filtro acepta como entrada [`$input`] tanto cadenas de caracteres [`string`] como matrices [`array`]):

#### `absint`

```php
AbsInt( mixed $input ): int
```

Elimina todos los caracteres no numéricos, convierte el valor a íntegro y devuelve su valor absoluto. Internally it uses [`filter_var`] for the integer part, [`intval`](https://secure.php.net/manual/en/function.intval.php) for casting and [`absint`](https://secure.php.net/manual/en/function.absint.php).

#### `alnum`

```php
Alnum( mixed $input ): string | array
```

Elimina todos los caracteres que no son números o que no pertenecen al alfabeto. It uses [`preg_replace`](https://secure.php.net/manual/en/function.preg-replace.php) which can also accept arrays of strings as the parameters.

#### `alpha`

```php
Alpha( mixed $input ): string | array
```

Elimina todos los caracteres que no pertenecen al alfabeto. Se utiliza [preg_replace](https://secure.php.net/manual/es/function.preg-replace.php), que acepta cadenas y matrices como parámetros.

#### `bool`

```php
BoolVal( mixed $input ): bool
```

Convierte el valor a "booleano" (verdadero o falso).

Devuelve `true` (verdadero) si el valor es:

* `true`
* `on (encendido)`
* `yes (sí)`
* `y`
* `1`

Devuelve `false` (falso) si el valor es:

* `false`
* `off (apagado)`
* `no`
* `n`
* `0`

#### `email`

```php
Email( mixed $input ): string
```

Elimina todos los caracteres excepto letras, digitos y los caracteres ``!#$%&*+-/=?^_`{\|}~@.[]``. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php) with `FILTER_FLAG_EMAIL_UNICODE`.

#### `float`

```php
FloatVal( mixed $input ): float
```

Elimina todos los caracteres excepto dígitos, punto, signos más y menos, y convierte el valor a `double` (número con coma flotante de doble precisión). Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php) and `(double)`.

#### `int`

```php
IntVal( mixed $input ): int
```

Elimina todos los caracteres excepto digitos, signos más y menos, y convierte el valor a íntegro. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php) and `(int)`.

#### `lower`

```php
Lower( mixed $input ): string
```

Convierte todos los caracteres a minúscula. If the [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) extension is loaded, it will use [mb_convert_case](https://secure.php.net/manual/en/function.mb-convert-case.php) to perform the transformation. As a fallback it uses the [`strtolower`](https://secure.php.net/manual/en/function.strtolower.php) PHP function, with [utf8_decode](https://secure.php.net/manual/en/function.utf8-decode.php).

#### `lowerFirst`

```php
LowerFirst( mixed $input ): string
```

Convierte el primer carácter de la entrada a minúscula. Internally it uses [`lcfirst`](https://secure.php.net/manual/en/function.lcfirst.php).

#### `regex`

```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```

Realiza una operación de remplazo regex utilizando un patrón (`$pattern`) y texto de remplazo (`$replace`) como parámetros. Internally it uses [`preg_replace`](https://secure.php.net/manual/en/function.preg-replace.php).

#### `remove`

```php
Remove( mixed $input, mixed $replace ): string
```

Elimina contenido de la entrada sustituyendo el parámetro de remplazo (`$remove`) con una cadena vacía. Internally it uses [`str_replace`](https://secure.php.net/manual/en/function.str-replace.php).

#### `replace`

```php
Replace( mixed $input, mixed $from, mixed $to ): string
```

Remplaza en la entrada el parámetro `$from` con el parámetro `$to`. Internally it uses [`str_replace`](https://secure.php.net/manual/en/function.str-replace.php).

#### `special`

```php
Special( mixed $input ): string
```

Escapa los caracteres HTML, `'"<>&` y ASCII con valor inferior a 32 de la entrada. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php).

#### `specialFull`

```php
SpecialFull( mixed $input ): string
```

Convierte todos los caracteres especiales de la entrada a entidades HTML (incluidos comillas y apóstrofes). Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php).

#### `string`

```php
StringVal( mixed $input ): string
```

Elimina las etiquetas y codifica las entidades HTML, incluyendo las comillas y apóstrofes. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php).

#### `striptags`

```php
StripTags( mixed $input ): int
```

Elimina todas las etiquetas HTML y PHP de la entrada. Internally it uses [`strip_tags`](https://www.php.net/manual/en/function.strip-tags.php).

#### `trim`

```php
Trim( mixed $input ): string
```

Elimina los espacios en blanco al inicio y final de la entrada. Internally it uses [`trim`](https://www.php.net/manual/en/function.trim.php).

#### `upper`

```php
Upper( mixed $input ): string
```

Capitaliza todos los caracteres. If the [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) extension is loaded, it will use [`mb_convert_case`](https://secure.php.net/manual/en/function.mb-convert-case.php) to perform the transformation. As a fallback it uses the [`strtoupper`](https://secure.php.net/manual/en/function.strtoupper.php) PHP function, with [`utf8_decode`](https://secure.php.net/manual/en/function.utf8-decode.php).

#### `upperFirst`

```php
UpperFirst( mixed $input ): string
```

Capitaliza el primer carácter de la entrada. Internally it uses [`ucfirst`](https://secure.php.net/manual/en/function.ucfirst.php).

#### `upperWords`

```php
UpperWords( mixed $input ): string
```

Capitaliza la primera letra de cada palabra. Internally it uses [`ucwords`](https://secure.php.net/manual/en/function.ucwords.php).

#### `url`

```php
Url( mixed $input ): string
```

Listado resumido de constantes disponibles para definir el tipo de limpieza a realizar:

```php
<?php

const FILTER_ABSINT      = 'absint';
const FILTER_ALNUM       = 'alnum';
const FILTER_ALPHA       = 'alpha';
const FILTER_BOOL        = 'bool';
const FILTER_EMAIL       = 'email';
const FILTER_FLOAT       = 'float';
const FILTER_INT         = 'int';
const FILTER_LOWER       = 'lower';
const FILTER_LOWERFIRST  = 'lowerFirst';
const FILTER_REGEX       = 'regex';
const FILTER_REMOVE      = 'remove';
const FILTER_REPLACE     = 'replace';
const FILTER_SPECIAL     = 'special';
const FILTER_SPECIALFULL = 'specialFull';
const FILTER_STRING      = 'string';
const FILTER_STRIPTAGS   = 'striptags';
const FILTER_TRIM        = 'trim';
const FILTER_UPPER       = 'upper';
const FILTER_UPPERFIRST  = 'upperFirst';
const FILTER_UPPERWORDS  = 'upperWords';
const FILTER_URL         = 'url';
```

## Sanitizing Data

Es el proceso de desinfección o saneamiento que elimina caracteres específicos de un valor, bien por ser innecesarios o bien por ser indeseados por el usuario o aplicación. Al desinfectar la entrada nos aseguramos que la integridad de las aplicaciones permanecerá intacta.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();
$locator = $factory->newInstance();

// 'someone@example.com'
$locator->sanitize('some(one)@exa\mple.com', 'email');

// 'hello'
$locator->sanitize('hello<<', 'string');

// '100019'
$locator->sanitize('!100a019', 'int');

// '100019.01'
$locator->sanitize('!100a019.01a', 'float');
```

## Controladores

You can access the [Phalcon\Filter](api/phalcon_filter#filter) object from your controllers when accessing `GET` or `POST` input data (through the request object). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro que se desea aplicar. El segundo parámetro también puede ser una matriz con todos los limpiadores a utilizar.

```php
<?php

use Phalcon\Filter;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Request $request
 */
class ProductsController extends Controller
{
    public function saveAction()
    {
        if (true === $this->request->isPost()) {
            $price = $this->request->getPost('price', 'double');

            $email = $this->request->getPost(
                'customerEmail',
                Filter::FILTER_EMAIL
            );
        }
    }
}
```

## Action Parameters

If you have used the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) as your DI container, the [Phalcon\Filter](api/phalcon_filter#filter) is already registered for you with the default sanitizers. Para emplearlo se utiliza la palabra clave `filter`. If you do not use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, you will need to set the service up in it, so that it can be accessible in your controllers.

A continuación un ejemplo de cómo limpiar los valores pasados a las acciones del controlador:

```php
<?php

use Phalcon\Filter;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Filter $filter
 */
class ProductsController extends Controller
{
    public function showAction($productId)
    {
        $productId = $this->filter->sanitize($productId, 'absint');
    }
}
```

## Filtering Data

The [Phalcon\Filter](api/phalcon_filter#filter) both filters and sanitizes data, depending on the sanitizers used. Por ejemplo, el limpiador `trim` eliminará todos los espacios antes y después de la entrada sin afectar su contenido. The description of each sanitizer (see [Built-in Sanitizers](#built-in-sanitizers)) can help you to understand and use the sanitizers according to your needs.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

// 'Hello'
$locator->sanitize('<h1>Hello</h1>', 'striptags');

// 'Hello'
$locator->sanitize('  Hello   ', 'trim');
```

## Adding Sanitizers

You can add your own sanitizers to [Phalcon\Filter](api/phalcon_filter#filter). El nuevo limpiador puede ser una función anónima cuando se inicializa el localizador:

```php
<?php

use Phalcon\Filter;

$services = [
    'md5' => function ($input) {
        return md5($input);
    },
];

$locator = new Filter($services);

$sanitized = $locator->sanitize($value, 'md5');
```

If you already have an instantiated filter locator object (for instance if you have used the [Phalcon\Filter\FilterFactory](api/phalcon_filter#filter-filterfactory) and `newInstance()`), then you can simply add the custom filter:

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$sanitized = $locator->sanitize($value, 'md5');
```

O, si lo prefiere, puede implementar el filtro en una clase:

```php
<?php

use Phalcon\Filter\FilterFactory;

class IPv4
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Sanitize with the 'ipv4' filter
$filteredIp = $locator->sanitize('127.0.0.1', 'ipv4');
```

## Combinación de limpiadores

Hay ocasiones en las que usar un solo limpiador no es suficiente para sanear los datos. Un caso muy común, por ejemplo, es el uso de los limpiadores `striptags` y `trim` para las entradas de texto. The [Phalcon\Filter](api/phalcon_filter#filter) component offers the ability to accept an array of names for sanitizers to be applied on the input value. Por ejemplo:

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

// Returns 'Hello'
$locator->sanitize(
    '   <h1> Hello </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

Esta cualidad también se puede utilizar con el objeto [Phalcon\Http\Request](api/Phalcon_Http_Request), cuando se utilizan los métodos `getQuery()` y `getPost()` para procesar las entradas `GET` y `POST`. Por ejemplo:

```php
<?php

use Phalcon\Filter;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Request $request
 */
class ProductsController extends Controller
{
    public function saveAction()
    {
        if (true === $this->request->isPost()) {
            $message =  $this->request->getPost(
                '   <h1> Hello </h1>   ',
                [
                    'striptags',
                    'trim',
                ]
            );

        }
    }
}
```

## Custom Sanitizer

Se puede implementar un limpiador personalizado como función anónima. Sin embargo, si prefieres usar una clase como limpiador, todo lo que necesitas hacer es hacerlo de una manera llamable, implementando el método [__invoke](https://secure.php.net/manual/en/language.oop5.magic.php#object.invoke) con los parámetros relevantes.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$sanitized = $locator->sanitize($value, 'md5');
```

O también se puede implementar el limpiador en una clase:

```php
<?php

use Phalcon\Filter\FilterFactory;

class IPv4
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Sanitize with the 'ipv4' filter
$filteredIp = $locator->sanitize('127.0.0.1', 'ipv4');
```