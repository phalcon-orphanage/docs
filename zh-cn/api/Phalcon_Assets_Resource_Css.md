---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Resource\Css'
---
# Class **Phalcon\Assets\Resource\Css**

*extends* class [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource/css.zep)

它表示 CSS 资源

## 方法

public **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

public **getType** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getLocal** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getFilter** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getAttributes** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getSourcePath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **setType** (*mixed* $type) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

设置资源的类型

public **setPath** (*mixed* $path) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

设置资源的路径

public **setLocal** (*mixed* $local) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

如果该资源是本地或外部，设置

public **setFilter** (*mixed* $filter) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

如果该资源必须过滤或不，设置

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

设置额外的 HTML 属性

public **setTargetUri** (*mixed* $targetUri) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

为生成的 HTML 设置目标 uri

public **setSourcePath** (*mixed* $sourcePath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

设置资源的源路径

public **setTargetPath** (*mixed* $targetPath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

设置资源的目标路径

public **getContent** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

返回的资源的内容，如可以设置字符串可以选择一个基路径资源所在的位置

public **getRealTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

真正的目标 uri 返回为生成的 HTML

public **getRealSourcePath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

返回资源所在的位置的完整位置

public **getRealTargetPath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

返回完整的位置必须在其中写入资源

public **getResourceKey** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

获取资源的键。