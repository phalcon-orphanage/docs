---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Collection'
---
# Class **Phalcon\Assets\Collection**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

表示资源的集合

## 方法

public **getPrefix** ()

...

public **getLocal** ()

...

public **getResources** ()

...

public **getCodes** ()

...

public **getPosition** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

public **__construct** ()

Phalcon\Assets\Collection constructor

public **add** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

向集合中添加资源

public **addInline** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

向集合中添加内联代码

public **has** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

检查此资源添加到集合。

```php
<?php

use Phalcon\Assets\Resource;
use Phalcon\Assets\Collection;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // true

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

向集合中添加 CSS 资源

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

向集合中添加内联 CSS

public [Phalcon\Assets\Collection](Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

向集合中添加一个 javascript 资源

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

向集合中添加内联 javascript

public **count** ()

在窗体中返回的元素的数目

public **rewind** ()

倒带内部迭代器

public **current** ()

在迭代器返回当前资源

public *int* **key** ()

在迭代器中返回每个该项当前的位置

public **next** ()

将内部迭代指针移动到下一个位置

public **valid** ()

检查迭代器中的当前元素是否有效

public **setTargetPath** (*mixed* $targetPath)

设置过滤的联接输出文件的目标路径

public **setSourcePath** (*mixed* $sourcePath)

此集合中设置的所有资源基地源路径

public **setTargetUri** (*mixed* $targetUri)

为生成的 HTML 设置目标 uri

public **setPrefix** (*mixed* $prefix)

设置所有资源的公共前缀

public **setLocal** (*mixed* $local)

如果该集合使用本地资源，默认情况下，设置

public **setAttributes** (*array* $attributes)

设置额外的 HTML 属性

public **setFilters** (*array* $filters)

在集合中设置筛选器的数组

public **setTargetLocal** (*mixed* $targetLocal)

设置目标本地

public **join** (*mixed* $join)

设置是否在集合中的资源的所有已筛选必须加入单个结果文件中

public **getRealTargetPath** (*mixed* $basePath)

返回完整的位置必须在其中写入的加入进行筛选的集合

public **addFilter** ([Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface) $filter)

Adds a filter to the collection

final protected **addResource** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

向集合中添加资源或内联代码