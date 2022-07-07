---
layout: default
language: 'es-es'
version: '5.0'
title: 'Enlace HTML (PSR-13)'
keywords: 'psr-13, http, enlace, enlace evolutivo'
---

# Enlace HTML (PSR-13)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Html\Link\EvolvableLink][html-link-evolvablelink], [Phalcon\Html\Link\EvolvableLinkProvider][html-link-evolvablelinkprovider], [Phalcon\Html\Link\Link][html-link-link] and [Phalcon\Html\Link\LinkProvider][html-link-linkprovider] are classes that implement the interfaces as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--13-blue.svg)

These components aid in creating Link objects as defined by the [PSR-13][psr-13] standard.

> **NOTA**: Este componente no genera ningún enlace HTML. It just stores the links and offers methods as defined by the [PSR-13][psr-13] standard. Necesitará crear sus propios serializadores que analizarán estos objetos y generarán la salida necesaria. The [Phalcon\Html\Link\Serializer\Header][html-link-serializer-header] serializer is available for you to use. 
> 
> {: .alert .alert-info }

## Link
The [Phalcon\Html\Link\Link][html-link-link] is used to create a link and assign attributes to it upon construction.

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
The [Phalcon\Html\Link\LinkProvider][html-link-linkprovider] is used as a container of [Phalcon\Html\Link\Link][html-link-link] objects. Puede añadirlos al proveedor y luego acceder a ellos en su conjunto o recuperarlos mediante `rel`.

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
Los objetos enlace son inmutables. Sin embargo, hay necesidad de manipularlos en función de las necesidades de su aplicación. The [Phalcon\Html\Link\EvolvableLink][html-link-evolvablelink] is available, allowing you to manipulate the link.

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
The [Phalcon\Html\Link\LinkProvider][html-link-linkprovider] is used as a container of [Phalcon\Html\Link\EvolvableLink][html-link-evolvablelink] objects. Puede añadirlos al proveedor y luego acceder a ellos en su conjunto o recuperarlos mediante `rel`.

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
Puede usar un serializador para analizar los objetos `Phalcon\Html\Links` y crear las cabeceras necesarias. Phalcon comes with the [Phalcon\Html\Link\Serializer\Header][html-link-serializer-header] serializer, to help with the task of serializing links for the headers:

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
You can create your own serializers for relevant links by extending the [Phalcon\Html\Link\Serializer\SerializerInterface][html-link-serializer-serializerinterface]

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

[php-fig]: https://www.php-fig.org/
[psr-13]: https://www.php-fig.org/psr/psr-13/
[html-link-evolvablelink]: api/phalcon_html#html-link-evolvablelink
[html-link-evolvablelinkprovider]: api/phalcon_html#html-link-evolvablelinkprovider
[html-link-link]: api/phalcon_html#html-link-link
[html-link-linkprovider]: api/phalcon_html#html-link-linkprovider
[html-link-serializer-header]: api/phalcon_html#html-link-serializer-header
[html-link-serializer-serializerinterface]: api/phalcon_html#html-link-serializer-serializerinterface
