---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Translate\Adapter\Gettext'
---
# Class **Phalcon\Translate\Adapter\Gettext**

*extends* abstract class [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/gettext.zep)

```php
<?php

use Phalcon\Translate\Adapter\Gettext;

$adapter = new Gettext(
    [
        "locale"        => "de_DE.UTF-8",
        "defaultDomain" => "translations",
        "directory"     => "/path/to/application/locales",
        "category"      => LC_MESSAGES,
    ]
);

```

Allows translate using gettext

## Metode

public **getDirectory** ()

public **getDefaultDomain** ()

public **getLocale** ()

public **getCategory** ()

public **__construct** (*array* $options)

Phalcon\Translate\Adapter\Gettext constructor

public **query** (*mixed* $index, [*mixed* $placeholders])

Mengembalikan terjemahan yang terkait dengan kunci yang diberikan.

```php
<?php

$translator->query("你好 %name%！", ["name" => "Phalcon"]);

```

public **exists** (*mixed* $index)

Periksa apakah didefinisikan kunci terjemahan dalam array internal

public **nquery** (*mixed* $msgid1, *mixed* $msgid2, *mixed* $count, [*mixed* $placeholders], [*mixed* $domain])

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.

public **setDomain** (*mixed* $domain)

Changes the current domain (i.e. the translation file)

public **resetDomain** ()

Menetapkan wilayah kegagalan

public **setDefaultDomain** (*mixed* $domain)

Menyetel wilayah kegagalan untuk dicari saat panggilan dilakukan ke mendapatkan teks()

public **setDirectory** (*mixed* $directory)

Menetapkan jalur untuk wilayah

```php
<?php

// Set the directory path
$gettext->setDirectory("/path/to/the/messages");

// Set the domains and directories path
$gettext->setDirectory(
    [
        "messages" => "/path/to/the/messages",
        "another"  => "/path/to/the/another",
    ]
);

```

public **setLocale** (*mixed* $category, *mixed* $locale)

Menyetel informasi lokal

```php
<?php

// Set locale to Dutch
$gettext->setLocale(LC_ALL, "nl_NL");

// Try different possible locale names for german
$gettext->setLocale(LC_ALL, "de_DE@euro", "de_DE", "de", "ge");

```

protected **prepareOptions** (*array* $options)

Validator for constructor

protected **getOptionsDefault** ()

Mendapatkan pilihan kegagalan

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengembalikan string terjemahan dari kunci yang diberikan

public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengembalikan string terjemahan dari kunci yang diberikan (alias metode 't')

public **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Sets a translation value

public **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Periksa apakah ada kunci terjemahan

public **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Unsets terjemahan dari kamus

public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengembalikan terjemahan yang terkait dengan kunci yang diberikan

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengganti placeholder dengan nilai yang dilewatkan