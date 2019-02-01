---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Assets\Manager'
---
# Class **Phalcon\Assets\Manager**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/manager.zep)

مجموعه ای از دارایی های CSS/جاوا اسکریپت را مدیریت می کند

## روش ها

عمومی **__ ساخت** ([*آرایه* $options])

public **setOptions** (*array* $options)

گزینه های مدیر را تنظیم می کند

عمومی **دریافت نام** ()

گزینه های مدیر را برمی گرداند

public **useImplicitOutput** (*mixed* $implicitOutput)

Sets if the HTML generated must be directly printed or returned

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Adds a Css resource to the 'css' collection

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline Css to the 'css' collection

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Adds a javascript resource to the 'js' collection

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline javascript to the 'js' collection

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Adds a resource by its type

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Adds an inline code by its type

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Adds a raw resource to the manager

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Adds a raw inline code to the manager

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

Sets a collection in the Assets Manager

```php
<?php

$assets->set("js", $collection);

```

public **get** (*mixed* $id)

یک مجموعه را با شناسه آن باز می گرداند.

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

مجموعۀ دارایی های CSS را بازمی گرداند

public **getJs** ()

مجموعۀ دارایی های CSS را بازمی گرداند

public **collection** (*mixed* $name)

مجموعه ای از منابع را ایجاد/بازگشت می کند

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

یک مجموعه را فراخوانی می کند که فراخوانی مجدد را برای ایجاد HTML انجام می دهد

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

یک مجموعه را مرور می کند و HTML آن را تولید می کند

public **outputCss** ([*string* $collectionName])

HTML برای منابع CSS را چاپ می کند

public **outputInlineCss** ([*string* $collectionName])

HTML را برای CSS درون خطی چاپ می کند

public **outputJs** ([*string* $collectionName])

HTML برای منابع JS را چاپ می کند

public **outputInlineJs** ([*string* $collectionName])

HTML را برای JS درون خطی چاپ می کند

عمومی **دریافت حاشیه نویسی** ()

مجموعه های موجود را در مدیر باز می گرداند

public **exists** (*mixed* $id)

اگر مجموعه موجود باشد، درست یا غلط را دریافت می کند.

```php
<?php

if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}

```