* * *

layout: default language: 'en' version: '4.0' title: 'Phalcon\Assets\Inline'

* * *

# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](/3.4/en/api/Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/assets/inline.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Represents an inline asset

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");

```

## Methods

public **getType** ()

...

public **getContent** ()

...

public **getFilter** ()

...

public **getAttributes** ()

...

public **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline constructor

public **setType** (*mixed* $type)

Sets the inline's type

public **setFilter** (*mixed* $filter)

Sets if the resource must be filtered or not

public **setAttributes** (*array* $attributes)

Sets extra HTML attributes

public **getResourceKey** ()

Gets the resource's key.