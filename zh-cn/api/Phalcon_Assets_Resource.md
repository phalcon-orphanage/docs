---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Resource'
---
# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource.zep)

表示一个静态资源资源

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## 方法

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

设置资源的类型

public **setPath** (*mixed* $path)

设置资源的路径

public **setLocal** (*mixed* $local)

如果该资源是本地或外部，设置

public **setFilter** (*mixed* $filter)

如果该资源必须过滤或不，设置

public **setAttributes** (*array* $attributes)

设置额外的 HTML 属性

public **setTargetUri** (*mixed* $targetUri)

为生成的 HTML 设置目标 uri

public **setSourcePath** (*mixed* $sourcePath)

设置资源的源路径

public **setTargetPath** (*mixed* $targetPath)

设置资源的目标路径

public **getContent** ([*mixed* $basePath])

返回的资源的内容，如可以设置字符串可以选择一个基路径资源所在的位置

public **getRealTargetUri** ()

真正的目标 uri 返回为生成的 HTML

public **getRealSourcePath** ([*mixed* $basePath])

返回资源所在的位置的完整位置

public **getRealTargetPath** ([*mixed* $basePath])

返回完整的位置必须在其中写入资源

public **getResourceKey** ()

获取资源的键。