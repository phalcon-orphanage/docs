* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Manager'

* * *

# Class **Phalcon\Assets\Manager**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/manager.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Manages collections of CSS/Javascript assets

## Métodos

public **__construct** ([*array* $options])

public **setOptions** (*array* $options)

Sets the manager options

public **getOptions** ()

Returns the manager options

public **useImplicitOutput** (*mixed* $implicitOutput)

Sets if the HTML generated must be directly printed or returned

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Adds a Css resource to the 'css' collection

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline Css to the 'css' collection

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Adds a javascript resource to the 'js' collection

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline javascript to the 'js' collection

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Adds a resource by its type

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Adds an inline code by its type

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Adds a raw resource to the manager

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Adds a raw inline code to the manager

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

Sets a collection in the Assets Manager

```php
<?php

$assets->set("js", $collection);

```

public **get** (*mixed* $id)

Returns a collection by its id.

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

Returns the CSS collection of assets

public **getJs** ()

Returns the CSS collection of assets

public **collection** (*mixed* $name)

Creates/Returns a collection of resources

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

Traverses a collection calling the callback to generate its HTML

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

Traverses a collection and generate its HTML

public **outputCss** ([*string* $collectionName])

Prints the HTML for CSS resources

public **outputInlineCss** ([*string* $collectionName])

Prints the HTML for inline CSS

public **outputJs** ([*string* $collectionName])

Prints the HTML for JS resources

public **outputInlineJs** ([*string* $collectionName])

Prints the HTML for inline JS

public **getCollections** ()

Returns existing collections in the manager

public **exists** (*mixed* $id)

Returns true or false if collection exists.

```php
<?php

if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}

```