---
layout: default
upgrade: '#filter'
title: 'Filtro'
keywords: 'filtro, sanear'
---

# Filtro
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
Sanear la entrada del usuario es una parte crítica del desarrollo de software. Confiar o descuidar el saneamiento de la entrada del usuario podría provocar un acceso no autorizado al contenido de su aplicación, principalmente a los datos de usuarios, o incluso al servidor donde su aplicación se aloja.

![](/assets/images/content/filter-sql.png)

[Imagen completa en XKCD](https://xkcd.com/327)

Sanitizing content can be achieved using the [Phalcon\Filter][filter-filter] and [Phalcon\Filter\FilterFactory][filter-filterfactory] classes.

## FilterFactory
Este componente crea un nuevo localizador con filtros predefinidos adjuntos a él. Cada filtro se carga perezosamente para un rendimiento máximo. To instantiate the factory and retrieve the [Phalcon\Filter][filter-filter] with the preset sanitizers you need to call `newInstance()`

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();
```

Ahora puede usar el localizador donde lo necesite y sanear el contenido según las necesidades de su aplicación.

## Filtro
The [Phalcon\Filter][filter-filter] component implements a locator service and can be used as a stand alone component, without initializing the built-in filters.

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

> **NOTE**: The [Phalcon\Di\FactoryDefault][factorydefault] container already has a [Phalcon\Filter][filter-filter] object loaded with the predefined sanitizers. Se puede acceder al componente utilizando el nombre del filtro (`filter`). 
> 
> {: .alert .alert-info }

## Incorporado

> **NOTE**: Where appropriate, the sanitizers will cast the value to the type expected. Por ejemplo el saneador `absint` eliminará cualquier carácter no numérico de la entrada, la convertirá a entero y devolverá su valor absoluto. 
> 
> {: .alert .alert-warning }

A continuación se enlistan los filtros predeterminados del componente. (N. del T.: se preserva la palabra inglesa *mixed* [mixto], para definir que el filtro acepta como entrada [`$input`] tanto cadenas de caracteres [`string`] como matrices [`array`]):

#### `absint`
```php
AbsInt( mixed $input ): int
```
Elimina todos los caracteres no numéricos, convierte el valor a íntegro y devuelve su valor absoluto. Internally it uses [`filter_var`] for the integer part, [`intval`][intval] for casting and [`absint`][absint].

#### `alnum`
```php
Alnum( mixed $input ): string | array
```
Elimina todos los caracteres que no son números o que no pertenecen al alfabeto. It uses [`preg_replace`][preg_replace] which can also accept arrays of strings as the parameters.

#### `alpha`
```php
Alpha( mixed $input ): string | array
```
Elimina todos los caracteres que no pertenecen al alfabeto. It uses [preg_replace][preg_replace] which can also accept arrays of strings as the parameters.

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
Elimina todos los caracteres excepto letras, digitos y los caracteres  ``!#$%&*+-/=?^_`{\|}~@.[]``. Internally it uses [`filter_var`][filter_var] with `FILTER_FLAG_EMAIL_UNICODE`.

#### `float`
```php
FloatVal( mixed $input ): float
```
Elimina todos los caracteres excepto dígitos, punto, signos más y menos, y convierte el valor a `double` (número con coma flotante de doble precisión). Internally it uses [`filter_var`][filter_var] and `(double)`.

#### `int`
```php
IntVal( mixed $input ): int
```
Elimina todos los caracteres excepto dígitos, signos más y menos y convierte el valor a entero. Internally it uses [`filter_var`][filter_var] and `(int)`.

#### `lower`
```php
Lower( mixed $input ): string
```
Convierte todos los caracteres a minúscula. If the [`mbstring`][mbstring] extension is loaded, it will use [mb_convert_case][mb_convert_case] to perform the transformation. As a fallback it uses the [`strtolower`][strtolower] PHP function, with [utf8_decode][utf8_decode].

#### `lowerFirst`
```php
LowerFirst( mixed $input ): string
```
Convierte el primer carácter de la entrada a minúscula. Internally it uses [`lcfirst`][lcfirst].

#### `regex`
```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```
Realiza una operación de remplazo regex utilizando un patrón (`$pattern`) y texto de remplazo (`$replace`) como parámetros. Internally it uses [`preg_replace`][preg_replace].

#### `remove`
```php
Remove( mixed $input, mixed $replace ): string
```
Elimina contenido de la entrada sustituyendo el parámetro de remplazo (`$remove`) con una cadena vacía. Internally it uses [`str_replace`][str_replace].

#### `replace`
```php
Replace( mixed $input, mixed $from, mixed $to ): string
```
Remplaza en la entrada el parámetro `$from` con el parámetro `$to`. Internally it uses [`str_replace`][str_replace].

#### `special`
```php
Special( mixed $input ): string
```
Escapa los caracteres HTML, `'"<>&` y ASCII con valor inferior a 32 de la entrada. Internally it uses [`filter_var`][filter_var].

#### `specialFull`
```php
SpecialFull( mixed $input ): string
```
Convierte todos los caracteres especiales de la entrada a entidades HTML (incluidos comillas y apóstrofes). Internally it uses [`filter_var`][filter_var].

#### `string`
```php
StringVal( mixed $input ): string
```
Elimina las etiquetas y codifica las entidades HTML, incluyendo las comillas y apóstrofes. Internally it uses [`filter_var`][filter_var].

#### `striptags`
```php
StripTags( mixed $input ): int
```
Elimina todas las etiquetas HTML y PHP de la entrada. Internally it uses [`strip_tags`][strip_tags].

#### `trim`
```php
Trim( mixed $input ): string
```
Elimina los espacios en blanco al inicio y final de la entrada. Internally it uses [`trim`][trim].

#### `upper`
```php
Upper( mixed $input ): string
```
Capitaliza todos los caracteres. If the [`mbstring`][mbstring] extension is loaded, it will use [`mb_convert_case`][mb_convert_case] to perform the transformation. As a fallback it uses the [`strtoupper`][strtoupper] PHP function, with [`utf8_decode`][utf8_decode].

#### `upperFirst`
```php
UpperFirst( mixed $input ): string
```
Capitaliza el primer carácter de la entrada. Internally it uses [`ucfirst`][ucfirst].

#### `upperWords`
```php
UpperWords( mixed $input ): string
```
Capitaliza la primera letra de cada palabra. Internally it uses [`ucwords`][ucwords].

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

## Saneamiento de Datos
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
You can access the [Phalcon\Filter][filter-filter] object from your controllers when accessing `GET` or `POST` input data (through the request object). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro que se desea aplicar. El segundo parámetro también puede ser una matriz con todos los limpiadores a utilizar.

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

## Parámetros de la Acción
If you have used the [Phalcon\Di\FactoryDefault][factorydefault] as your DI container, the [Phalcon\Filter][filter-filter] is already registered for you with the default sanitizers. Para emplearlo se utiliza la palabra clave `filter`. If you do not use the [Phalcon\Di\FactoryDefault][factorydefault] container, you will need to set the service up in it, so that it can be accessible in your controllers.

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

## Filtrado de Datos
The [Phalcon\Filter][filter-filter] both filters and sanitizes data, depending on the sanitizers used. Por ejemplo, el limpiador `trim` eliminará todos los espacios antes y después de la entrada sin afectar su contenido. La descripción de cada saneador (ver [Saneadores Incorporados](#built-in-sanitizers)) puede ayudarle a entender y usar los saneadores acorde a sus necesidades.

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


## Añadir Saneadores
You can add your own sanitizers to [Phalcon\Filter][filter-filter]. El nuevo limpiador puede ser una función anónima cuando se inicializa el localizador:

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

If you already have an instantiated filter locator object (for instance if you have used the [Phalcon\Filter\FilterFactory][filter-filterfactory] and `newInstance()`), then you can simply add the custom filter:

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
    new Ipv4()
);

// Sanitize with the 'ipv4' filter
$filteredIp = $locator->sanitize('127.0.0.1', 'ipv4');
```


## Combinación de limpiadores
Hay ocasiones en las que usar un solo limpiador no es suficiente para sanear los datos. Un caso muy común, por ejemplo, es el uso de los limpiadores `striptags` y `trim` para las entradas de texto. The [Phalcon\Filter][filter-filter] component offers the ability to accept an array of names for sanitizers to be applied on the input value. Por ejemplo:

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

## Saneador Personalizado
Se puede implementar un limpiador personalizado como función anónima. If however you prefer to use a class per sanitizer, all you need to do is make it a callable by implementing the [__invoke][invoke] method with the relevant parameters.

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

[absint]: https://www.php.net/manual/en/function.absint.php
[filter_var]: https://www.php.net/manual/en/function.filter-var.php
[intval]: https://www.php.net/manual/en/function.intval.php
[invoke]: https://www.php.net/manual/en/language.oop5.magic.php#object.invoke
[lcfirst]: https://www.php.net/manual/en/function.lcfirst.php
[mb_convert_case]: https://www.php.net/manual/en/function.mb-convert-case.php
[mb_convert_case]: https://www.php.net/manual/en/function.mb-convert-case.php
[mbstring]: https://www.php.net/manual/en/book.mbstring.php
[preg_replace]: https://www.php.net/manual/en/function.preg-replace.php
[preg_replace]: https://www.php.net/manual/en/function.preg-replace.php
[strip_tags]: https://www.php.net/manual/en/function.strip-tags.php
[str_replace]: https://www.php.net/manual/en/function.str-replace.php
[strtolower]: https://www.php.net/manual/en/function.strtolower.php
[strtoupper]: https://www.php.net/manual/en/function.strtoupper.php
[trim]: https://www.php.net/manual/en/function.trim.php
[ucfirst]: https://www.php.net/manual/en/function.ucfirst.php
[ucwords]: https://www.php.net/manual/en/function.ucwords.php
[utf8_decode]: https://www.php.net/manual/en/function.utf8-decode.php
[utf8_decode]: https://www.php.net/manual/en/function.utf8-decode.php
[filter-filter]: api/phalcon_filter#filter
[filter-filterfactory]: api/phalcon_filter#filter-filterfactory
[factorydefault]: api/phalcon_di#di-factorydefault
