* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Resource'

* * *

# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](/4.0/en/api/Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/resource.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Represents an asset resource

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## Methods

public **getType** ()

public **getPath** ()

public **getLocal** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

public **setType** (*mixed* $type)

Sets the resource's type

public **setPath** (*mixed* $path)

Sets the resource's path

public **setLocal** (*mixed* $local)

Sets if the resource is local or external

public **setFilter** (*mixed* $filter)

Sets if the resource must be filtered or not

public **setAttributes** (*array* $attributes)

Sets extra HTML attributes

public **setTargetUri** (*mixed* $targetUri)

Sets a target uri for the generated HTML

public **setSourcePath** (*mixed* $sourcePath)

Sets the resource's source path

public **setTargetPath** (*mixed* $targetPath)

Sets the resource's target path

public **getContent** ([*mixed* $basePath])

Returns the content of the resource as an string Optionally a base path where the resource is located can be set

public **getRealTargetUri** ()

Returns the real target uri for the generated HTML

public **getRealSourcePath** ([*mixed* $basePath])

Returns the complete location where the resource is located

public **getRealTargetPath** ([*mixed* $basePath])

Returns the complete location where the resource must be written

public **getResourceKey** ()

Gets the resource's key.