---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Componente Filtro

* * *

## Filtrado y Limpieza

Una tarea fundamental en el desarrollo de software es la limpieza o saneamiento de datos enviados por los usuarios. Descuidar esta tarea o simplemente confiar en dichos datos sin sanearlos puede facilitar el acceso no autorizado al contenido de la aplicación, a los datos de otros usuarios, o incluso al servidor donde se encuentra alojada la aplicación.

![](/assets/images/content/filter-sql.png)

[Imagen original en [XKCD](https://xkcd.com/327)](https://xkcd.com/327)

En Phalcon hay dos clases para limpiar datos: [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) y [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory).

## FilterLocatorFactory

Este componente crea un localizador con filtros predefinidos. Cada filtro se carga solo cuando es necesario ("lazy loading" en inglés) para lograr el máximo rendimiento. Para instanciar la clase [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) con los limpiadores preconfigurados se utiliza `newInstance()`

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();
```

Una vez instanciado, el localizador se puede utilizar en cualquier parte para limpiar el contenido (según las necesidades de la aplicación).

## FilterLocator

El filtro localizador (`FilterLocator`) también se puede utilizar como componente autónomo y sin necesidad de inicializar los filtros predeterminados.

```php
<?php

use MiApp\Limpiadores\HolaLimpiador;
use Phalcon\Filter\FilterLocator;

$servicios = [
    'hola' => HolaLimpiador::class,
];
$localizador = new FilterLocator($servicios);
$texto = $localizador->hola('Mundo');
```

> El contenedor `Phalcon\Di` trae de manera predeterminada el objeto `Phalcon\Filter\FilterLocator` junto con los demás limpiadores predefinidos. Se puede acceder al componente utilizando el nombre del filtro (`filter`).
{: .alert .alert-info }


## Limpiadores predeterminados

> Cuando sea apropiado, los limpiadores convertirán el valor al tipo esperado. Por ejemplo, el limpiador [absint](https://secure.php.net/manual/en/function.absint.php) removerá todos los caracteres no numéricos de la entrada, los convertirá a un número íntegro y devolverá su valor absoluto.
{: .alert .alert-warning }

A continuación se enlistan los filtros predeterminados del componente. (N. del T.: se preserva la palabra inglesa *mixed* [mixto], para definir que el filtro acepta como entrada [`$input`] tanto cadenas de caracteres [`string`] como matrices [`array`]):

#### absint

```php
AbsInt( mixed $input ): int
```

Elimina todos los caracteres no numéricos, convierte el valor a íntegro y devuelve su valor absoluto. De manera interna utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php) para el íntegro, [intval](https://secure.php.net/manual/es/function.intval.php) para la conversión y [absint](https://secure.php.net/manual/es/function.absint.php) para el valor absoluto.

#### alnum

```php
Alnum( mixed $input ): string | array
```

Elimina todos los caracteres que no son números o que no pertenecen al alfabeto. Se utiliza [preg_replace](https://secure.php.net/manual/es/function.preg-replace.php), que acepta cadenas y matrices como parámetros.

#### alpha

```php
Alpha( mixed $input ): string | array
```

Elimina todos los caracteres que no pertenecen al alfabeto. Se utiliza [preg_replace](https://secure.php.net/manual/es/function.preg-replace.php), que acepta cadenas y matrices como parámetros.

#### bool

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

#### email

```php
Email( mixed $input ): string
```

Elimina todos los caracteres excepto letras, digitos y los caracteres ``!#$%&*+-/=?^_`{\|}~@.[]``. El código interno utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php)

#### float

```php
FloatVal( mixed $input ): float
```

Elimina todos los caracteres excepto dígitos, punto, signos más y menos, y convierte el valor a `double` (número con coma flotante de doble precisión). De manera interna utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php) y `(double)`.

#### int

```php
IntVal( mixed $input ): int
```

Elimina todos los caracteres excepto digitos, signos más y menos, y convierte el valor a íntegro. De manera interna utiliza `(int)` y [filter_var](https://secure.php.net/manual/es/function.filter-var.php).

#### lower

```php
Lower( mixed $input ): string
```

Convierte todos los caracteres a minúscula. Si está cargada la extensión [mbstring](https://secure.php.net/manual/es/book.mbstring.php), utilizará la función [mb_convert_case](https://secure.php.net/manual/es/function.mb-convert-case.php) para ejecutar la transformación. Si no, empleará en su lugar la función estándar de PHP [strtolower](https://secure.php.net/manual/es/function.strtolower.php) con [utf8_decode](https://secure.php.net/manual/es/function.utf8-decode.php)

#### lowerFirst

```php
LowerFirst( mixed $input ): string
```

Convierte el primer carácter de la entrada a minúscula. De manera interna utiliza la función [lcfirst](https://secure.php.net/manual/es/function.lcfirst.php).

#### regex

```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```

Realiza una operación de remplazo regex utilizando un patrón (`$pattern`) y texto de remplazo (`$replace`) como parámetros. De manera interna utiliza la función [preg_replace](https://secure.php.net/manual/ea/function.preg-replace.php).

#### remove

```php
Remove( mixed $input, mixed $remove ): string
```

Elimina contenido de la entrada sustituyendo el parámetro de remplazo (`$remove`) con una cadena vacía. De manera interna utiliza la función [str_replace](https://secure.php.net/manual/es/function.str-replace.php)

#### replace

```php
Replace( mixed $input, mixed $from, mixed $to ): string
```

Remplaza en la entrada el parámetro `$from` con el parámetro `$to`. De manera interna utiliza la función [str_replace](https://secure.php.net/manual/es/function.str-replace.php)

#### special

```php
Special( mixed $input ): string
```

Escapa los caracteres HTML, `'"<>&` y ASCII con valor inferior a 32 de la entrada. El código interno utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php)

#### specialFull

```php
SpecialFull( mixed $input ): string
```

Convierte todos los caracteres especiales de la entrada a entidades HTML (incluidos comillas y apóstrofes). El código interno utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php)

#### string

```php
StringVal( mixed $input ): string
```

Elimina las etiquetas y codifica las entidades HTML, incluyendo las comillas y apóstrofes. El código interno utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php)

#### striptags

```php
StripTags( mixed $input ): int
```

Elimina todas las etiquetas HTML y PHP de la entrada. De manera interna utiliza la función [strip_tags](https://www.php.net/manual/es/function.strip-tags.php)

#### trim

```php
Trim( mixed $input ): string
```

Elimina los espacios en blanco al inicio y final de la entrada. De manera interna utiliza la función [trim](https://www.php.net/manual/es/function.trim.php).

#### upper

```php
Upper( mixed $input ): string
```

Capitaliza todos los caracteres. Si está cargada la extensión [mbstring](https://secure.php.net/manual/es/book.mbstring.php), utilizará la función [mb_convert_case](https://secure.php.net/manual/es/function.mb-convert-case.php) para ejecutar la transformación. En su defecto, utilizará la función estándar de PHP [strtoupper](https://secure.php.net/manual/es/function.strtoupper.php) con [utf8_decode](https://secure.php.net/manual/es/function.utf8-decode.php).

#### upperFirst

```php
UpperFirst( mixed $input ): string
```

Capitaliza el primer carácter de la entrada. De manera interna utiliza la función [ucfirst](https://secure.php.net/manual/es/function.ucfirst.php).

#### upperWords

```php
UpperWords( mixed $input ): string
```

Capitaliza la primera letra de cada palabra. De manera interna utiliza la función [ucwords](https://secure.php.net/manual/es/function.ucwords.php)

#### url

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

## Limpieza de datos

Es el proceso de desinfección o saneamiento que elimina caracteres específicos de un valor, bien por ser innecesarios o bien por ser indeseados por el usuario o aplicación. Al desinfectar la entrada nos aseguramos que la integridad de las aplicaciones permanecerá intacta.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

// devuelve 'alguien@ejemplo.com'
$localizador->sanitize('alg(uie)n@ejemp\lo.com', 'email');

// devuelve 'hola'
$localizador->sanitize('hola<<', 'string');

// devuelve '100019'
$localizador->sanitize('!100a019', 'int');

// devuelve '100019.01'
$localizador->sanitize('!100a019.01a', 'float');
```

## Limpieza en controladores

Los controladores pueden emplear el objeto [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) con los datos de usuario que llegan mediante `GET` o `POST` (a través del objeto de petición). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro que se desea aplicar. El segundo parámetro también puede ser una matriz con todos los limpiadores a utilizar.

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductosController
 * 
 * @property Request $request
 */
class ProductosController extends Controller
{
    public function guardarAction()
    {
        if (true === $this->request->isPost()) {
            // Limpiar el precio
            $precio = $this->request->getPost('precio', 'double');

            // Limpiar la dirección de correo electrónico
            $emilio = $this->request->getPost('emilioUsuario', FilterLocator::FILTER_EMAIL);
        }
    }
}
```

## Limpieza de los parámetros de la acción

Si se utiliza la "fábrica por defecto" [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) como contenedor de DI (Inyector de dependencias), el [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) ya se encuentra incluido, al igual que todos los limpiadores predeterminados. Para emplearlo se utiliza la palabra clave `filter`. Cuando no se utiliza el contenedor [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) es necesario definirlo como servicio, de tal manera que sea accessible por los controladores.

A continuación un ejemplo de cómo limpiar los valores pasados a las acciones del controlador:

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Mvc\Controller;

/**
 * Class ProductosController
 * 
 * @property FilterLocator $filter
 */
class ProductosController extends Controller
{
    public function mostrarAction($productoId)
    {
        $productoId = $this->filter->sanitize($productoId, 'absint');
    }
}
```

## Filtrado de datos

Con la clase [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) se pueden limpiar y filtrar datos --dependiendo de cuáles limpiadores y filtros se utilicen. Por ejemplo, el limpiador `trim` eliminará todos los espacios antes y después de la entrada sin afectar su contenido. La descripción de cada limpiador (véase [Limpiadores predeterminados](https://docs.phalconphp.com/4.0/es-es/filter-sanitizers)) es útil para comprender y saber cuándo utilizarlo.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

// Devuelve 'Hola'
$localizador->sanitize('<h1>Hola</h1>', 'striptags');

// Devuelve 'Hola'
$localizador->sanitize('  Hola   ', 'trim');
```

## Creación de limpiadores

Se pueden añadir nuevos limpiadores a [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator). El nuevo limpiador puede ser una función anónima cuando se inicializa el localizador:

```php
<?php

use Phalcon\Filter\FilterLocator;

$servicios = [
    'md5' => function ($input) {
        return md5($input);
    },
];

$localizador   = new FilterLocator($servicios);
$limpio = $localizador->sanitize($valor, 'md5');
```

Ahora bien, si ya hay una instancia de `FilterLocator` (p.e. si se ha usado [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory) y `newInstance()`), basta con agregar el nuevo filtro:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

$localizador->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$limpio = $localizador->sanitize($valor, 'md5');
```

O, si lo prefiere, puede implementar el filtro en una clase:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

class IPv4
{
    public function __invoke($valor)
    {
        return filter_var($valor, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

$localizador->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Limpieza con el filtro 'ipv4' 
$IpFiltrada = $localizador->sanitize('127.0.0.1', 'ipv4');
```

## Combinación de limpiadores

Hay ocasiones en las que usar un solo limpiador no es suficiente para sanear los datos. Un caso muy común, por ejemplo, es el uso de los limpiadores `striptags` y `trim` para las entradas de texto. En estos casos, [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) puede recibir una matriz de nombres de limpiadores a utilizar con los datos de entrada. Por ejemplo:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

// Devuelve 'Hola'
$localizador->sanitize(
    '   <h1> Hola </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

Esta cualidad también se puede utilizar con el objeto [Phalcon\Http\Request](api/Phalcon_Http_Request), cuando se utilizan los métodos `getQuery()` y `getPost()` para procesar las entradas `GET` y `POST`. Por ejemplo:

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductosController
 * 
 * @property Request $request
 */
class ProductosController extends Controller
{
    public function guardarAction()
    {
        if (true === $this->request->isPost()) {
            $mensaje =  $this->request->getPost(
                '   <h1> Hola </h1>   ',
                [
                    'striptags',
                    'trim',
                ]
            );

        }
    }
}
```

## Filtrado y limpieza complejas

PHP ofrece una extensión excelente para filtrado de datos que por supuesto también se puede utilizar con Phalcon; véase [Filtrado de datos](https://www.php.net/manual/es/book.filter.php) en el manual oficial.

## Cómo implementar un limpiador propio

Se puede implementar un limpiador personalizado como función anónima. Sin embargo, si prefieres usar una clase como limpiador, todo lo que necesitas hacer es hacerlo de una manera llamable, implementando el método [__invoke](https://secure.php.net/manual/en/language.oop5.magic.php#object.invoke) con los parámetros relevantes.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

$localizador->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$limpio = $localizador->sanitize($valor, 'md5');
```

O también se puede implementar el limpiador en una clase:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

class IPv4
{
    public function __invoke($valor)
    {
        return filter_var($valor, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

$localizador->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Limpieza con el filtro 'ipv4' 
$IpFiltrada = $localizador->sanitize('127.0.0.1', 'ipv4');
```