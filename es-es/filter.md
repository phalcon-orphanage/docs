* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Filtrado y Limpieza

Limpiar o desinfectar la entrada del usuario es una parte crítica del desarrollo de software. Confiar o dejar de desinfectar la entrada del usuario podría conducir a un acceso no autorizado al contenido de la aplicación, principalmente datos de los usuarios, o incluso al servidor de la aplicación donde está alojada.

![](/assets/images/content/filter-sql.png)

[Imagen completa en XKCD](http://xkcd.com/327)

The [Phalcon\Filter](api/Phalcon_Filter) component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension.

<a name='types'></a>

## Tipos de filtros incorporados

Los siguientes filtros están incorporados en este componente:

| Nombre    | Descripción                                                                                                          |
| --------- | -------------------------------------------------------------------------------------------------------------------- |
| absint    | Clasifica el valor como un número entero y devuelve el valor absoluto del mismo.                                     |
| alphanum  | Quita todos los caracteres excepto [a-zA-Z0-9]                                                                       |
| email     | Quita todos los caracteres excepto letras, números y `` !#$%&*+-/=?^_{\|}~@.[]` ``.                             |
| float     | Quita todos los caracteres excepto dígitos, puntos y los signos más y menos.                                         |
| float!    | Quite todos los caracteres excepto dígitos, puntos, signos positivo y negativo y convierte el resultado en un float. |
| int       | Quita todos los caracteres excepto dígitos y los signos más y menos.                                                 |
| int!      | Quite todos los caracteres excepto dígitos, signos positivo y negativo y convierte el resultado en un entero.        |
| lower     | Se aplica la función [strtolower](http://www.php.net/manual/en/function.strtolower.php)                              |
| string    | Elimina etiquetas y codifica entidades HTML, incluyendo comillas simples y dobles.                                   |
| striptags | Se aplica la función [strip_tags](http://www.php.net/manual/en/function.strip-tags.php)                              |
| trim      | Se aplica la función [trim](http://www.php.net/manual/en/function.trim.php)                                          |
| upper     | Se aplica la función [strtoupper](http://www.php.net/manual/en/function.strtoupper.php)                              |

Please note that the component uses the [filter_var](https://secure.php.net/manual/en/function.filter-var.php) PHP function internally.

Constants are available and can be used to define the type of filtering required:

```php
<?php
const FILTER_ABSINT     = "absint";
const FILTER_ALPHANUM   = "alphanum";
const FILTER_EMAIL      = "email";
const FILTER_FLOAT      = "float";
const FILTER_FLOAT_CAST = "float!";
const FILTER_INT        = "int";
const FILTER_INT_CAST   = "int!";
const FILTER_LOWER      = "lower";
const FILTER_STRING     = "string";
const FILTER_STRIPTAGS  = "striptags";
const FILTER_TRIM       = "trim";
const FILTER_UPPER      = "upper";
```

<a name='sanitizing'></a>

## Limpieza de datos

Es el proceso de desinfección que elimina caracteres específicos de un valor, los cuales no son necesarios o deseados por el usuario o aplicación. Al desinfectar la entrada nos aseguramos que la integridad de las aplicaciones estará intacta.

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Retorna 'someone@example.com'
$filter->sanitize('some(one)@exa\mple.com', 'email');

// Retorna 'hello'
$filter->sanitize('hello<<', 'string');

// Retorna '100019'
$filter->sanitize('!100a019', 'int');

// Retorna '100019.01'
$filter->sanitize('!100a019.01a', 'float');
```

<a name='sanitizing-from-controllers'></a>

## Limpiando desde controladores

You can access a [Phalcon\Filter](api/Phalcon_Filter) object from your controllers when accessing `GET` or `POST` input data (through the request object). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro a aplicar sobre ella.

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Limpiando el precio desde POST
        $price = $this->request->getPost('price', 'double');

        // Limpiando el email desde POST
        $email = $this->request->getPost('customerEmail', 'email');
    }
}
```

<a name='filtering-action-parameters'></a>

## Filtrando parámetros de acciones

En el ejemplo siguiente se muestra cómo desinfectar los parámetros de una acción dentro de un controlador:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($productId)
    {
        $productId = $this->filter->sanitize($productId, 'int');
    }
}
```

<a name='filtering-data'></a>

## Filtrando datos

In addition to sanitizing, [Phalcon\Filter](api/Phalcon_Filter) also provides filtering by removing or modifying input data to the format we expect.

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Retorna 'Hello'
$filter->sanitize('<h1>Hello</h1>', 'striptags');

// Retorna 'Hello'
$filter->sanitize('  Hello   ', 'trim');
```

<a name='combining-filters'></a>

## Combinando filtros

Es posible ejecutar varios filtros en una cadena al mismo tiempo, pasando una matriz de identificadores de filtro como segundo parámetro:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Retorna 'Hello'
$filter->sanitize(
    '   <h1> Hello </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

<a name='adding-filters'></a>

## Agregando filtros

You can add your own filters to [Phalcon\Filter](api/Phalcon_Filter). The filter function could be an anonymous function:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Usando una función anónima
$filter->add(
    'md5',
    function ($value) {
        return preg_replace('/[^0-9a-f]/', '', $value);
    }
);

// Desinfectando con el filtro 'md5' recién creado
$filtered = $filter->sanitize($possibleMd5, 'md5');
```

O si lo prefiere, puede implementar el filtro en una clase:

```php
<?php

use Phalcon\Filter;

class IPv4Filter
{
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$filter = new Filter();

// Usando un objeto
$filter->add(
    'ipv4',
    new IPv4Filter()
);

// Limpiando con el filtro 'ipv4'
$filteredIp = $filter->sanitize('127.0.0.1', 'ipv4');
```

<a name='complex-sanitization-filtering'></a>

## Filtrado y limpieza complejas

PHP itself provides an excellent filter extension you can use. Check out its documentation: [Data Filtering at PHP Documentation](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## Implementar tus propios filtros

The [Phalcon\FilterInterface](api/Phalcon_FilterInterface) interface must be implemented to create your own filtering service replacing the one provided by Phalcon.