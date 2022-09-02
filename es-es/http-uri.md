---
layout: default
language: 'es-es'
version: '4.0'
title: 'HTTP Uri (PSR-7)'
keywords: 'psr-7, http, http uri'
---

# HTTP Uri (PSR-7)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

[Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) es una implementación de la interfaz de mensajería HTTP [PSR-7](https://www.php-fig.org/psr/psr-7/) definida por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

[Phalcon\Http\Message\Uri](api/phalcon_http#http-message-uri) devuelve un objeto que representa una URI. El objeto representa una URI definida en [RFC 3986](https://datatracker.ietf.org/doc/html/rfc3986), que provee métodos para la mayoría de operaciones comunes. El uso principal de este componente es para peticiones HTTP pero puede ser usado en otros contextos.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getHost(); // 'd.phalcon.ld'
```

El objeto [Uri](api/phalcon_http#http-message-uri) creado es inmutable, lo que significa que nunca va a cambiar. Cualquier llamada a métodos con prefijo `with*` devolverán un clon del objeto para mantener la inmutabilidad, según el estándar.

## Constructor

```php
public function __construct(
    [string $uri = ''] 
)
```
El constructor acepta una cadena opcional, que representa la URI. Si se especifica, la URI será procesada y dividida internamente en las partes que sean necesarias.

## Getters

### `__toString()`

Devuelve la representación de la URI como cadena. Dependiendo de qué componentes de la URI están presentes, la cadena resultante es una URI completa o una referencia relativa según [RFC 3986](https://datatracker.ietf.org/doc/html/rfc3986), Sección 4.1. El método concatena los diversos componentes de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo (string) $uri; 
// 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag'
```

### `getAuthority()`

Devuelve una cadena que representa la autoridad de la URI. Si no hay autoridad, se retorna una cadena vacía. El formato de la autoridad es:

```php
[user-info@]host[:port]
```

Si el puerto no está definido, o es uno de los estándar del esquema, no será devuelto

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getAuthority(); // 'usr:pass@d.phalcon.ld:8080'
```

### `getFragment()`

Devuelve una cadena que representa el fragmento de la URI. Si no hay fragmento, se devuelve cadena vacía. El valor devuelto no contendrá el valor inicial `#` y se codificará por porcentaje.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getFragment(); // 'frag'
```

### `getHost()`

Devuelve una cadena que representa el nombre de servidor de la URI. Si no hay servidor, se devuelve cadena vacía. El valor devuelto se convertirá a minúsculas.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getHost(); // 'd.phalcon.ld'
```

### `getPath()`

Devuelve una cadena que representa la ruta de la URI. La ruta puede estar vacía o ser absoluta (empezando con una barra) o sin raíz (no empieza con una barra). Normalmente, la ruta vacía "" y la ruta absoluta `/` se consideran iguales pero este método no hará esta normalización automáticamente. El valor devuelto se codificará por porcentaje.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getPath(); // '/action'
```

### `getPort()`

Devuelve un entero que representa el puerto de la URI. Si el puerto está presente y no es estándar para el protocolo actual, será devuelto. Sin embargo, si es un puerto estándar para el protocolo especificado, se devolverá `null`. Además, si no está el puerto ni el protocolo entonces se devolverá `null`.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getPort(); // 8080
```

### `getQuery()`

Devuelve una cadena que representa los parámetros de la URI. Si no hay parámetros, se devuelve cadena vacía. El valor devuelto no contendrá el valor inicial `?` y se codificará por porcentaje.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getQuery(); // '/par=val'
```

### `getScheme()`

Devuelve una cadena que representa el protocolo de la URI. Si el protocolo no está presente, se devuelve cadena vacía. El valor devuelto se convierte a minúsculas.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getScheme(); // 'https'
```

### `getUserInfo()`

Devuelve una cadena que representa la información del usuario de la URI. Si no está presente la información del usuario, se devuelve cadena vacía. Si tanto el usuario como la contraseña están presentes, se devolverán juntos unidos por dos puntos (`:`) separando los valores.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getUserInfo(); // 'usr:pass'
```

## With
El objeto Request es inmutable. Sin embargo, hay una serie de métodos en los que se permite inyectar datos. El objeto devuelto es un clon del original.

### `withFragment()`

Devuelve una instancia con el nuevo fragmento. Introducir un fragmento vacío eliminará el fragmento de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getFragment(); // 'frag'

$clone = $uri->withFragment('newfrag');

echo $clone->getFragment(); // 'newfrag'
```

### `withHost()`

Devuelve una instancia con el nuevo servidor. Introducir un servidor vacío eliminará el servidor de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getHost(); // 'd.phalcon.ld'

$clone = $uri->withHost('a.phalcon.ld');

echo $clone->getHost(); // 'a.phalcon.ld'
```

### `withPath()`

Devuelve una instancia con la nueva ruta. Introducir una ruta vacía eliminará la ruta de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getPath(); // '/action'

$clone = $uri->withPath('/create');

echo $clone->getPath(); // '/create'
```

### `withPort()`

Devuelve una instancia con el nuevo puerto. Introducir un puerto `null` eliminará el puerto de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getPort(); // 8080

$clone = $uri->withPort(8081);

echo $clone->getPort(); // 8081
```

### `withQuery()`

Devuelve una instancia con los nuevos parámetros. Introducir unos parámetros vacíos eliminará los parámetros de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getQuery(); // 'par=val'

$clone = $uri->withQuery('one=two');

echo $clone->getQuery(); // 'one=two'
```

### `withScheme()`

Devuelve una instancia con el nuevo protocolo. Introducir un protocolo vacío eliminará el protocolo de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getScheme(); // 'https'

$clone = $uri->withScheme('http');

echo $clone->getScheme(); // 'http'
```

### `withUserInfo()`

Devuelve una instancia con la nueva información del usuario. La contraseña es opcional. Si se introduce un usuario vacío, se eliminará la información del usuario de la URI.

```php
<?php

use Phalcon\Http\Message\Uri;

$query = 'https://usr:pass@d.phalcon.ld:8080/action?par=val#frag';
$uri   = new Uri($query);

echo $uri->getUserInfo(); // 'usr:pass'

$clone = $uri->withUserInfo('phalcon', 'notsecret');

echo $clone->getUserInfo(); // 'phalcon:notsecret'
```
