---
layout: default
language: 'es-es'
version: '4.0'
title: 'Enlace HTML (PSR-13)'
keywords: 'psr-13, http, enlace, enlace evolutivo'
---

# Enlace HTML (PSR-13)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Html\Link\EvolvableLink](api/phalcon_html#html-link-evolvablelink), [Phalcon\Html\Link\EvolvableLinkProvider](api/phalcon_html#html-link-evolvablelinkprovider), [Phalcon\Html\Link\Link](api/phalcon_html#html-link-link) y [Phalcon\Html\Link\LinkProvider](api/phalcon_html#html-link-linkprovider) son clases que implementan las interfaces definidas por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--13-blue.svg)

Estos componentes ayudan a crear objetos `Link` según el estándar definido por [PSR-13](https://www.php-fig.org/psr/psr-13/).

> **NOTA**: Este componente no genera ningún enlace HTML. Sólo almacena los enlaces y ofrece métodos definidos según el estándar [PSR-13](https://www.php-fig.org/psr/psr-13/). Necesitará crear sus propios serializadores que analizarán estos objetos y generarán la salida necesaria. Se puede usar el serializador [Phalcon\Html\Link\Serializer\Header](api/phalcon_html#html-link-serializer-header). 
> 
> {: .alert .alert-info }

## Link
[Phalcon\Html\Link\Link](api/phalcon_html#html-link-link) se usa para crear un enlace y asignarle atributos durante su construcción.

```php
<?php

use Phalcon\Html\Link\Link;

$href       = 'https://dev.phalcon.ld';
$attributes = [
    'one'   => true,
    'two'   => 123,
    'three' => 'four',
    'five'  => [
        'six',
        'seven',
    ],
];

$link = new Link('payment', $href, $attributes);
```

## LinkProvider
[Phalcon\Html\Link\LinkProvider](api/phalcon_html#html-link-linkprovider) se usa como contenedor de objetos [Phalcon\Html\Link\Link](api/phalcon_html#html-link-link). Puede añadirlos al proveedor y luego acceder a ellos en su conjunto o recuperarlos mediante `rel`.

```php
<?php

use Phalcon\Html\Link\Link;
use Phalcon\Html\Link\LinkProvider;

$links = [
    new Link('canonical', 'https://dev.phalcon.ld'),
    new Link('cite-as', 'https://test.phalcon.ld'),
];
$link  = new LinkProvider($links);


var_dump(
    $link->getLinksByRel('cite-as')
);

// [
//     Link('cite-as', 'https://test.phalcon.ld'),
// ]
```

## EvolvableLink
Los objetos enlace son inmutables. Sin embargo, hay necesidad de manipularlos en función de las necesidades de su aplicación. [Phalcon\Html\Link\EvolvableLink](api/phalcon_html#html-link-evolvablelink) está disponible, permitiéndole manipular el enlace.

```php
<?php

use Phalcon\Html\Link\EvolvableLink;

$href       = 'https://dev.phalcon.ld';
$attributes = ['one' => true];

$link = new EvolvableLink('payment', $href, $attributes);

$newInstance = $link->withAttribute('two', 'three');

var_dump(
    $newInstance->getAttributes()
);

//  [
//      'one' => true,
//      'two' => 'three',
//  ];
```

## EvolvableLinkProvider
[Phalcon\Html\Link\LinkProvider](api/phalcon_html#html-link-linkprovider) se usa como contenedor de objetos [Phalcon\Html\Link\EvolvableLink](api/phalcon_html#html-link-evolvablelink). Puede añadirlos al proveedor y luego acceder a ellos en su conjunto o recuperarlos mediante `rel`.

```php
<?php

use Phalcon\Html\Link\EvolvableLink;
use Phalcon\Html\Link\EvolvableLinkProvider;

$links = [
    new Link('canonical', 'https://dev.phalcon.ld'),
    new Link('cite-as', 'https://test.phalcon.ld'),
];
$link  = new EvolvableLinkProvider($links);


var_dump(
    $link->getLinksByRel('cite-as')
);

// [
//     Link('cite-as', 'https://test.phalcon.ld'),
// ]
```

## Serializadores
### Header
Puede usar un serializador para analizar los objetos `Phalcon\Html\Links` y crear las cabeceras necesarias. Phalcon viene con el serializador [Phalcon\Html\Link\Serializer\Header](api/phalcon_html#html-link-serializer-header), para ayudar con la tarea de serializar enlaces para las cabeceras:

```php
<?php

use Phalcon\Html\Link\EvolvableLink;
use Phalcon\Html\Link\Serializer\Header;

$serializer = new Header();

$link = new EvolvableLink('prefetch', '/images/apple-icon-114.png');

echo $serializer->serialize([$link]);
// </images/apple-icon-114.png>; rel="prefetch"';


$links = [
    (new EvolvableLink('preload', '/1'))
        ->withAttribute('as', 'image')
        ->withAttribute('nopush', true),
    (new EvolvableLink('alternate', '/2'))
        ->withRel('next')
        ->withAttribute('hreflang', ['en', 'es'])
];

echo $serializer->serialize([$link]);
// </1>; rel="preload"; as="image"; nopush,
//     </2>; rel="alternate next"; hreflang="en"; hreflang="es"
;
```

### Personalizado
Puede crear sus propios serializadores relevantes para enlaces extendiendo [Phalcon\Html\Link\Serializer\SerializerInterface](api/phalcon_html#html-link-serializer-serializerinterface)

```php
<?php

namespace MyApp\Html\Serializers;

use Phalcon\Html\Link\Serializer\SerializerInterface;

class Custom implements SerializerInterface 
{
    public function serialize(array $links): ?string
    {
        // ....
    }
}
```
