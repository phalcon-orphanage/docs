---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Inline\Css'
---
# Class **Phalcon\Assets\Inline\Css**

*extends* class [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline/css.zep)

表示内联的 CSS

## 方法

public **__construct** (*string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline\Css Constructor

public *string* **getType** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets the resource's type.

public *string* **getContent** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets the content.

public *boolean* **getFilter** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets if the resource must be filtered or not.

public *array* **getAttributes** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets extra HTML attributes.

public [*self*](Phalcon_Assets_Inline_Css) **setType** (*string* $type) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

设置内联的类型

public [*self*](Phalcon_Assets_Inline_Css) **setFilter** (*boolean* $filter) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

如果该资源必须过滤或不，设置

public [*self*](Phalcon_Assets_Inline_Css) **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

设置额外的 HTML 属性

public *string* **getResourceKey** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

获取资源的键。