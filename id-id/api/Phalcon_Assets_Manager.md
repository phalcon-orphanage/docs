---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Assets\Manager'
---
# Class **Phalcon\Assets\Manager**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/manager.zep)

Mengelola koleksi aset CSS/Javascript

## Metode

umum **__membangun** ([*array* $options])

public **setOptions** (*array* $options)

Menetapkan pilihan manajer

public **getOptions** ()

Mengembalikan opsi manajer

public **useImplicitOutput** (*mixed* $implicitOutput)

Mengatur jika HTML yang dihasilkan harus langsung dicetak atau dikembalikan

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*dicampur* $attributes])

Menambahkan sumber daya Css ke koleksi 'css'

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

public **addInlineCss** (*campuran* $content, [*mixed* $filter], [*mixed* $attributes])

Menambahkan inline Css ke koleksi 'css'

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*dicampur* $attributes])

Menambahkan sumber javascript ke koleksi 'js'

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Menambahkan javascript inline ke koleksi 'js'

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Menambahkan sumber daya menurut jenisnya

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Menambahkan kode inline menurut jenisnya

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Menambahkan sumber daya mentah ke pengelola

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Menambahkan kode inline mentah ke pengelola

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

Menetapkan koleksi di Asset Manager

```php
<?php

$assets->set("js", $collection);

```

publik **dapatkan** (*campuran* $id)

Mengembalikan koleksi dengan idnya.

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

Mengembalikan koleksi aset CSS

public **getJs** ()

Mengembalikan koleksi aset CSS

public **collection** (*mixed* $name)

Membuat/Mengembalikan koleksi sumber daya

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

Melacak koleksi yang memanggil yang kembali untuk menghasilkan HTML-nya

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

Melacak koleksi dan menghasilkan HTML-nya

public **outputCss** ([*string* $collectionName])

Mencetak sumber HTML untuk CSS

public **outputInlineCss** ([*string* $collectionName])

Mencetak HTML untuk CSS sebaris

public **outputJs** ([*string* $collectionName])

Mencetak sumber HTML untuk JS

public **outputInlineJs** ([*string* $collectionName])

Mencetak HTML untuk inline JS

public **getCollections** ()

Mengembalikan koleksi yang ada di manajer

public **exists** (*mixed* $id)

Mengembalikan true atau false jika ada koleksi.

```php
<?php

jika ($assets->exist ("jsHeader")) {
     // \ Phalcon\Assets\Collection
     $collection = $assets->get("jsHeader");
}

```