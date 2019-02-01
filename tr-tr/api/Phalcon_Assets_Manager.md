---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Assets\Manager'
---
# Class **Phalcon\Assets\Manager**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/manager.zep)

CSS/Javascript varlıklarının koleksiyonlarını yönetir

## Metodlar

herkese açık **__düzenle**([* sıra* $seçenekler])

public **setOptions** (*array* $options)

Yönetici seçeneklerini ayarlar

public **getOptions** ()

Yönetici seçeneklerini döndürür

public **useImplicitOutput** (*mixed* $implicitOutput)

Oluşturulan HTML'in doğrudan yazdırılması ve veya döndürülmesi gerekip gerekmediğin ayarlar

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

'css' koleksiyonuna bir Css kaynağı ekler

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

herkese açık **SatıriçiCssekle** (*karışık* $content, [*karışık* $filter], [*karışık* $attributes])

"css" koleksiyonuna bir satıriçi Css ekler

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

'js' koleksiyonuna bir javascript kaynağı ekler

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

"js" koleksiyonuna bir satıriçi javascript ekler

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Türüne göre bir kaynak ekler

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Kendi türüne göre satır içi kod ekler

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Yönteciye bir ham kaynak ekler

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Yöneticiye işlenmemiş satır içi kod ekler

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

Varlık Yönetcisine bir koleksiyon ekler

```php
<?php

$assets->set("js", $collection);

```

public **get** (*mixed* $id)

Kimliğe göre bir koleksiyon döndürür.

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

Varlıkların CSS koleksiyonunu döndürür

public **getJs** ()

Varlıkların CSS koleksiyonunu döndürür

public **collection** (*mixed* $name)

Bir kaynak koleksiyonu oluşturur/döndürür

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

HTML geri dönüşünü çağıran bir koleksiyonu dolaşıma sokar

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

Bir koleksiyon geçirir ve onun HTML'ini oluşturur

public **outputCss** ([*string* $collectionName])

CSS kaynakları için HTML'i bastırır

public **outputInlineCss** ([*string* $collectionName])

Satıriçi CSS için HTML'yi yazdırır

public **outputJs** ([*string* $collectionName])

JS kaynakları için HTML'yi yazdırır

public **outputInlineJs** ([*string* $collectionName])

Satır içi JS için HTML'yi yazdırır

public **getCollections** ()

Yöneticide varolan koleksiyonları döner

public **exists** (*mixed* $id)

Koleksiyon varsa, doğru ya da yanlış döndürür.

```php
<?php

if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}

```