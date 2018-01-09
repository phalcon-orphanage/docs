<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Filtrado y Limpieza</a> 
      <ul>
        <li>
          <a href="#types">Tipos de filtros incorporados</a>
        </li>
        <li>
          <a href="#sanitizing">Limpieza de datos</a>
        </li>
        <li>
          <a href="#sanitizing-from-controllers">Limpiando desde controladores</a>
        </li>
        <li>
          <a href="#filtering-action-parameters">Filtrando parámetros de acciones</a>
        </li>
        <li>
          <a href="#filtering-data">Filtrando datos</a>
        </li>
        <li>
          <a href="#combining-filters">Combinando filtros</a>
        </li>
        <li>
          <a href="#adding-filters">Agregando filtros</a>
        </li>
        <li>
          <a href="#complex-sanitization-filtering">Filtrado y limpieza complejas</a>
        </li>
        <li>
          <a href="#custom">Implementar tus propios filtros</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Filtrado y Limpieza

Limpiar o desinfectar la entrada del usuario es una parte crítica del desarrollo de software. Confiar o dejar de desinfectar la entrada del usuario podría conducir a un acceso no autorizado al contenido de la aplicación, principalmente datos de los usuarios, o incluso al servidor de la aplicación donde está alojada.

![](/images/content/filter-sql.png)

[Imagen completa en XKCD](http://xkcd.com/327)

El componente `Phalcon\Filter` proporciona un conjunto de filtros y ayudantes de desinfección de datos de uso común. Proporciona contenedores orientados a objetos de la extensión de filtro de PHP.

<a name='types'></a>

## Tipos de filtros incorporados

Los siguientes filtros están incorporados en este componente:

| Nombre    | Descripción                                                                              |
| --------- | ---------------------------------------------------------------------------------------- |
| string    | Elimina etiquetas y codifica entidades HTML, incluyendo comillas simples y dobles.       |
| email     | Quita todos los caracteres excepto letras, números y `` !#$%&*+-/=?^_{\|}~@.[]` ``. |
| int       | Quita todos los caracteres excepto dígitos y los signos más y menos.                     |
| float     | Quita todos los caracteres excepto dígitos, puntos y los signos más y menos.             |
| alphanum  | Quita todos los caracteres excepto [a-zA-Z0-9]                                           |
| striptags | Se aplica la función [strip_tags](http://www.php.net/manual/en/function.strip-tags.php)  |
| trim      | Se aplica la función [trim](http://www.php.net/manual/en/function.trim.php)              |
| lower     | Se aplica la función [strtolower](http://www.php.net/manual/en/function.strtolower.php)  |
| url       | Remove all characters except letters, digits and `|`$-_.+!*'(),{}[]<>#%";/?:@&=.^~\\` |
| upper     | Se aplica la función [strtoupper](http://www.php.net/manual/en/function.strtoupper.php)  |

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

Se puede acceder al objeto `Phalcon\Filter` desde los controladores cuando se accede a los datos de entrada `GET` o `POST` (a través del objeto request). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro a aplicar sobre ella.

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

Además de desinfectar, `Phalcon\Filter` proporciona filtrado, mediante la eliminación o modificación de los datos de entrada llevandolos al formato que esperamos.

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

Usted puede agregar sus propios filtros a `Phalcon\Filter`. La función del filtro puede ser una función anónima:

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

PHP proporciona una extensión excelente de filtro que puede utilizar. Revisa su documentación: [Filtrado de datos en la documentación oficial de PHP](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## Implementar tus propios filtros

Debe implementar la interfaz `Phalcon\FilterInterface` para crear su propio servicio de filtrado reemplazando el proporcionado por Phalcon.