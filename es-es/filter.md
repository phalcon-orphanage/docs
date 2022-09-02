---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#filter'
title: 'Filtro'
keywords: 'filtro, sanear'
---

# Filtro

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Sanear la entrada del usuario es una parte crítica del desarrollo de software. Confiar o descuidar el saneamiento de la entrada del usuario podría provocar un acceso no autorizado al contenido de su aplicación, principalmente a los datos de usuarios, o incluso al servidor donde su aplicación se aloja.

![](/assets/images/content/filter-sql.png)

[Imagen completa en XKCD](https://xkcd.com/327)

Se puede lograr el saneado del contenido usando las clases [Phalcon\Filter](api/phalcon_filter#filter) y [Phalcon\Filter\FilterFactory](api/phalcon_filter#filter-filterfactory).

## FilterFactory

Este componente crea un nuevo localizador con filtros predefinidos adjuntos a él. Cada filtro se carga perezosamente para un rendimiento máximo. Para instanciar la fábrica y recuperar [Phalcon\Filter](api/phalcon_filter#filter) con los saneadores establecidos necesita llamar a `newInstance()`

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();
```

Ahora puede usar el localizador donde lo necesite y sanear el contenido según las necesidades de su aplicación.

## Filtro

El componente [Phalcon\Filter](api/phalcon_filter#filter) implementa un servicio de localización y se puede usar como componente independiente, sin tener que inicializar los filtros incorporados.

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

> **NOTA**: El contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) ya tiene un objeto [Phalcon\Filter](api/phalcon_filter#filter) cargado con los saneadores predefinidos. Se puede acceder al componente utilizando el nombre del filtro (`filter`).
{: .alert .alert-info }

## Incorporado

> **NOTA**: Cuando sea apropiado, los saneadores convertirán el valor al tipo apropiado. Por ejemplo el saneador `absint` eliminará cualquier carácter no numérico de la entrada, la convertirá a entero y devolverá su valor absoluto.
{: .alert .alert-warning }

A continuación se enlistan los filtros predeterminados del componente. (N. del T.: se preserva la palabra inglesa *mixed* [mixto], para definir que el filtro acepta como entrada [`$input`] tanto cadenas de caracteres [`string`] como matrices [`array`]):

#### `absint`

```php
AbsInt( mixed $input ): int
```

Elimina todos los caracteres no numéricos, convierte el valor a íntegro y devuelve su valor absoluto. Internamente usa [`filter_var`] para la parte entera, [`intval`](https://www.php.net/manual/en/function.intval.php) para la conversión de tipos y [`absint`](https://www.php.net/manual/en/function.absint.php).

#### `alnum`

```php
Alnum( mixed $input ): string | array
```

Elimina todos los caracteres que no son números o que no pertenecen al alfabeto. Usa [`preg_replace`](https://www.php.net/manual/en/function.preg-replace.php) que también admite vectores de cadenas como parámetros.

#### `alpha`

```php
Alpha( mixed $input ): string | array
```

Elimina todos los caracteres que no pertenecen al alfabeto. Usa [preg_replace](https://www.php.net/manual/en/function.preg-replace.php) que también admite vectores de cadenas como parámetros.

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

Elimina todos los caracteres excepto letras, digitos y los caracteres ``!#$%&*+-/=?^_`{\|}~@.[]``. Internamente usa [`filter_var`](https://www.php.net/manual/en/function.filter-var.php) con `FILTER_FLAG_EMAIL_UNICODE`.

#### `float`

```php
FloatVal( mixed $input ): float
```

Elimina todos los caracteres excepto dígitos, punto, signos más y menos, y convierte el valor a `double` (número con coma flotante de doble precisión). Internamente usa [`filter_var`](https://www.php.net/manual/en/function.filter-var.php) y `(double)`.

#### `int`

```php
IntVal( mixed $input ): int
```

Elimina todos los caracteres excepto dígitos, signos más y menos y convierte el valor a entero. Internamente usa [`filter_var`](https://www.php.net/manual/en/function.filter-var.php) y `(int)`.

#### `lower`

```php
Lower( mixed $input ): string
```

Convierte todos los caracteres a minúscula. Si está cargada la extensión [`mbstring`](https://www.php.net/manual/en/book.mbstring.php), usará [mb_convert_case](https://www.php.net/manual/en/function.mb-convert-case.php) para realizar la transformación. Como alternativa usa la función PHP [`strtolower`](https://www.php.net/manual/es/function.strtolower.php), con [utf8_decode](https://www.php.net/manual/es/function.utf8-decode.php).

#### `lowerFirst`

```php
LowerFirst( mixed $input ): string
```

Convierte el primer carácter de la entrada a minúscula. Internamente usa [`lcfirst`](https://www.php.net/manual/en/function.lcfirst.php).

#### `regex`

```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```

Realiza una operación de remplazo regex utilizando un patrón (`$pattern`) y texto de remplazo (`$replace`) como parámetros. Internamente usa [`preg_replace`](https://www.php.net/manual/en/function.preg-replace.php).

#### `remove`

```php
Remove( mixed $input, mixed $replace ): string
```

Elimina contenido de la entrada sustituyendo el parámetro de remplazo (`$remove`) con una cadena vacía. Internamente usa [`str_replace`](https://www.php.net/manual/en/function.str-replace.php).

#### `replace`

```php
Replace( mixed $input, mixed $from, mixed $to ): string
```

Remplaza en la entrada el parámetro `$from` con el parámetro `$to`. Internamente usa [`str_replace`](https://www.php.net/manual/en/function.str-replace.php).

#### `special`

```php
Special( mixed $input ): string
```

Escapa los caracteres HTML, `'"<>&` y ASCII con valor inferior a 32 de la entrada. Internamente usa [`filter_var`](https://www.php.net/manual/en/function.filter-var.php).

#### `specialFull`

```php
SpecialFull( mixed $input ): string
```

Convierte todos los caracteres especiales de la entrada a entidades HTML (incluidos comillas y apóstrofes). Internamente usa [`filter_var`](https://www.php.net/manual/en/function.filter-var.php).

#### `string`

```php
StringVal( mixed $input ): string
```

Elimina las etiquetas y codifica las entidades HTML, incluyendo las comillas y apóstrofes. Internamente usa [`filter_var`](https://www.php.net/manual/en/function.filter-var.php).

#### `striptags`

```php
StripTags( mixed $input ): int
```

Elimina todas las etiquetas HTML y PHP de la entrada. Internamente usa [`strip_tags`](https://www.php.net/manual/en/function.strip-tags.php).

#### `trim`

```php
Trim( mixed $input ): string
```

Elimina los espacios en blanco al inicio y final de la entrada. Internamente usa [`trim`](https://www.php.net/manual/en/function.trim.php).

#### `upper`

```php
Upper( mixed $input ): string
```

Capitaliza todos los caracteres. Si está cargada la extensión [`mbstring`](https://www.php.net/manual/en/book.mbstring.php), usará [`mb_convert_case`](https://www.php.net/manual/en/function.mb-convert-case.php) para realizar la transformación. Como alternativa usa la función PHP [`strtoupper`](https://www.php.net/manual/es/function.strtoupper.php), con [`utf8_decode`](https://www.php.net/manual/es/function.utf8-decode.php).

#### `upperFirst`

```php
UpperFirst( mixed $input ): string
```

Capitaliza el primer carácter de la entrada. Internamente usa [`ucfirst`](https://www.php.net/manual/en/function.ucfirst.php).

#### `upperWords`

```php
UpperWords( mixed $input ): string
```

Capitaliza la primera letra de cada palabra. Internamente usa [`ucwords`](https://www.php.net/manual/en/function.ucwords.php).

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

Puede acceder al objeto [Phalcon\Filter](api/phalcon_filter#filter) desde sus controladores al acceder a los datos de la entrada `GET` o `POST` (a través del objeto de la petición). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro que se desea aplicar. El segundo parámetro también puede ser una matriz con todos los limpiadores a utilizar.

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

Si usa [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) como contenedor DI, [Phalcon\Filter](api/phalcon_filter#filter) está registrado con los saneadores por defecto. Para emplearlo se utiliza la palabra clave `filter`. Si no usa el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), necesita configurar el servicio, para que esté accesible en sus controladores.

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

[Phalcon\Filter](api/phalcon_filter#filter) filtra y sanea los datos, dependiendo de los saneadores usados. Por ejemplo, el limpiador `trim` eliminará todos los espacios antes y después de la entrada sin afectar su contenido. La descripción de cada saneador (ver [Saneadores Incorporados](#built-in-sanitizers)) puede ayudarle a entender y usar los saneadores acorde a sus necesidades.

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

Puede añadir sus propios saneadores a [Phalcon\Filter](api/phalcon_filter#filter). El nuevo limpiador puede ser una función anónima cuando se inicializa el localizador:

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

Si ya tiene un objeto localizador de filtro instanciado (si ha usado [Phalcon\Filter\FilterFactory](api/phalcon_filter#filter-filterfactory) y `newInstance()` por ejemplo), entonces puede simplemente añadir el filtro personalizado:

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

Hay ocasiones en las que usar un solo limpiador no es suficiente para sanear los datos. Un caso muy común, por ejemplo, es el uso de los limpiadores `striptags` y `trim` para las entradas de texto. El componente [Phalcon\Filter](api/phalcon_filter#filter) ofrece la habilidad de aceptar un vector con el nombre de los saneadores a aplicar sobre los valores de la entrada. Por ejemplo:

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

Se puede implementar un limpiador personalizado como función anónima. Sin embargo, si prefieres usar una clase como saneador, todo lo que necesitas hacer es hacerlo de una manera invocable, implementando el método [__invoke](https://www.php.net/manual/en/language.oop5.magic.php#object.invoke) con los parámetros relevantes.

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
