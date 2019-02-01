---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Manager'
---
# Class **Phalcon\Assets\Manager**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/manager.zep)

管理集合的 CSS/Javascript 资产

## 方法

public **__construct** ([*array* $options])

public **setOptions** (*array* $options)

设置管理器选项

public **getOptions** ()

返回管理器选项

public **useImplicitOutput** (*mixed* $implicitOutput)

如果必须直接打印或返回生成的 HTML，设置

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

将 Css 资源添加到 css 集合

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

将内联 Css 添加到 css 集合

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

将 javascript 资源添加到 'js' 集合

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

将内联 javascript 添加到 'js' 集合

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

添加一个资源由其类型

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

添加内联代码由其类型

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

将原始资源添加到管理器

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

将原始的内联代码添加到管理器

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

在资产管理器中设置一个参数集合

```php
<?php

$assets->set("js", $collection);

```

public **get** (*mixed* $id)

按其 id 返回集合。

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

返回资产的 CSS 的集合

public **getJs** ()

返回资产的 CSS 的集合

public **collection** (*mixed* $name)

创建并返回的资源集合

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

遍历集合调用回调来生成其 HTML

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

遍历一个集合并生成其 HTML

public **outputCss** ([*string* $collectionName])

打印的 HTML，CSS 资源

public **outputInlineCss** ([*string* $collectionName])

打印为内联 CSS HTML

public **outputJs** ([*string* $collectionName])

打印的 HTML JS 资源

public **outputInlineJs** ([*string* $collectionName])

打印为内联 JS HTML

public **getCollections** ()

返回现有集合管理器中

public **exists** (*mixed* $id)

返回 true 或 false，如果集合存在

```php
<?php

if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}

```