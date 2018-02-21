# Class **Phalcon\\Assets\\Resource**

*uygulamalar* [Phalcon\Varlıklar\Kaynak Arayüz](/en/3.2/api/Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/resource.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Represents an asset resource

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## Methods

public **getType** ()

herkese açık **Yol bul** ()

herkese açık **Yerel ol** ()

herkese açık **Filtreyi al** ()

herkese açık **Özellikleri al** ()

herkese açık **Kaynak Yolu al** ()

...

herkese açık **Hedef Yolu al** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\\varlıklar\\Kaynak Okuyucu

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