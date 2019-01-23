---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Inline'
---
# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

表示内联资源

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");

```

## 方法

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

设置内联的类型

public **setFilter** (*mixed* $filter)

如果该资源必须过滤或不，设置

public **setAttributes** (*array* $attributes)

设置额外的 HTML 属性

public **getResourceKey** ()

获取资源的键。