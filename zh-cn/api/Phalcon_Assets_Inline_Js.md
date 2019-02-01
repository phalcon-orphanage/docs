---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Inline\Js'
---
# Class **Phalcon\Assets\Inline\Js**

*extends* class [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline/js.zep)

表示一个内联 Javascript

## 方法

public **__construct** (*string* $content, [*boolean* $filter], [*array* $attributes])

public **getType** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

...

public **getContent** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

...

public **getFilter** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

...

public **getAttributes** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

...

public **setType** (*mixed* $type) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

设置内联的类型

public **setFilter** (*mixed* $filter) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

如果该资源必须过滤或不，设置

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

设置额外的 HTML 属性

public **getResourceKey** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

获取资源的键。