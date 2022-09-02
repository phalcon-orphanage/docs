---
layout: default
title: 'HTML Link'
keywords: 'http, link, evolvable link'
---

# HTML Link
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Overview
[Phalcon\Html\Link\EvolvableLink][html-link-evolvablelink], [Phalcon\Html\Link\EvolvableLinkProvider][html-link-evolvablelinkprovider], [Phalcon\Html\Link\Link][html-link-link] and [Phalcon\Html\Link\LinkProvider][html-link-linkprovider] are classes that implement the interfaces based on [PSR-13][psr-13], but with much stricter types

> **NOTE**: This component does not generate any HTML links. It just stores the links. You will need to create your own serializers that will parse these objects and generate the necessary output. The [Phalcon\Html\Link\Serializer\Header][html-link-serializer-header] serializer is available for you to use. 
> 
> {: .alert .alert-info }

### Operations
The `Phalcon\Html\Link\*` components implement methods that are inline with [PSR-13][psr-13], but do not implement the particular interface. A package that implements [PSR-13][psr-13] is available, that uses the `Phalcon\Html\Link\*` components. The package is located [here][proxy-psr13]. To use it, you will need to have Phalcon installed and then using composer you can install the proxy package.

```sh
composer require phalcon/proxy-psr13
```

Using the proxy classes allows you to follow [PSR-13][psr-13] and use it with any other package that needs that interface.

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
The [Phalcon\Html\Link\LinkProvider][html-link-linkprovider] is used as a container of [Phalcon\Html\Link\Link][html-link-link] objects. You can add them in the provider and then access them as a whole or retrieve them by `rel`.

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
Link objects are immutable. However, there is a need to manipulate them based on your application needs. The [Phalcon\Html\Link\EvolvableLink][html-link-evolvablelink] is available, allowing you to manipulate the link.

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
The [Phalcon\Html\Link\LinkProvider][html-link-linkprovider] is used as a container of [Phalcon\Html\Link\EvolvableLink][html-link-evolvablelink] objects. You can add them in the provider and then access them as a whole or retrieve them by `rel`.

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
You can use a serializer to parse the `Phalcon\Html\Link\*` objects and create the necessary headers. Phalcon comes with the [Phalcon\Html\Link\Serializer\Header][html-link-serializer-header] serializer, to help with the task of serializing links for the headers:

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
    } }
```

[proxy-psr13]: https://github.com/phalcon/proxy-psr13
[psr-13]: https://www.php-fig.org/psr/psr-13/
[html-link-evolvablelink]: api/phalcon_html#html-link-evolvablelink
[html-link-evolvablelinkprovider]: api/phalcon_html#html-link-evolvablelinkprovider
[html-link-link]: api/phalcon_html#html-link-link
[html-link-linkprovider]: api/phalcon_html#html-link-linkprovider
[html-link-serializer-header]: api/phalcon_html#html-link-serializer-header
[html-link-serializer-serializerinterface]: api/phalcon_html#html-link-serializer-serializerinterface
