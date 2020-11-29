---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'HTML Link (PSR-13)'
keywords: 'psr-13, http, link, evolvable link'
---

# HTML Link (PSR-13)
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要
[Phalcon\Html\Link\EvolvableLink](api/phalcon_html#html-link-evolvablelink), [Phalcon\Html\Link\EvolvableLinkProvider](api/phalcon_html#html-link-evolvablelinkprovider), [Phalcon\Html\Link\Link](api/phalcon_html#html-link-link) and [Phalcon\Html\Link\LinkProvider](api/phalcon_html#html-link-linkprovider) are classes that implement the interfaces as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--13-blue.svg)

These components aid in creating Link objects as defined by the [PSR-13](https://www.php-fig.org/psr/psr-13/) standard.

> **NOTE**: This component does not generate any HTML links. It just stores the links and offers methods as defined by the [PSR-13](https://www.php-fig.org/psr/psr-13/) standard. You will need to create your own serializers that will parse these objects and generate the necessary output. The [Phalcon\Html\Link\Serializer\Header](api/phalcon_html#html-link-serializer-header) serializer is available for you to use. 
> 
> {: .alert .alert-info }

## Link
The [Phalcon\Html\Link\Link](api/phalcon_html#html-link-link) is used to create a link and assign attributes to it upon construction.

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
The [Phalcon\Html\Link\LinkProvider](api/phalcon_html#html-link-linkprovider) is used as a container of [Phalcon\Html\Link\Link](api/phalcon_html#html-link-link) objects. You can add them in the provider and then access them as a whole or retrieve them by `rel`.

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
Link objects are immutable. However, there is a need to manipulate them based on your application needs. The [Phalcon\Html\Link\EvolvableLink](api/phalcon_html#html-link-evolvablelink) is available, allowing you to manipulate the link.

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
The [Phalcon\Html\Link\LinkProvider](api/phalcon_html#html-link-linkprovider) is used as a container of [Phalcon\Html\Link\EvolvableLink](api/phalcon_html#html-link-evolvablelink) objects. You can add them in the provider and then access them as a whole or retrieve them by `rel`.

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

## Serializers
### Header
You can use a serializer to parse the `Phalcon\Html\Links` objects and create the necessary headers. Phalcon comes with the [Phalcon\Html\Link\Serializer\Header](api/phalcon_html#html-link-serializer-header) serializer, to help with the task of serializing links for the headers:

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

### Custom
You can create your own serializers for relevant links by extending the [Phalcon\Html\Link\Serializer\SerializerInterface](api/phalcon_html#html-link-serializer-serializerinterface)

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
