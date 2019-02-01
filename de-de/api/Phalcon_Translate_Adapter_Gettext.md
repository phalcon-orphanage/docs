---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Translate\Adapter\Gettext'
---
# Class **Phalcon\Translate\Adapter\Gettext**

*extends* abstract class [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/gettext.zep)

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

## Methoden

public **getDirectory** ()

public **getDefaultDomain** ()

public **getLocale** ()

public **getCategory** ()

public **__construct** (*array* $options)

Phalcon\Translate\Adapter\Gettext constructor

public **query** (*mixed* $index, [*mixed* $placeholders])

Returns the translation related to the given key.

```php
<?php

$translator->query("你好 %name%！", ["name" => "Phalcon"]);

```

public **exists** (*mixed* $index)

Überprüft, ob ein Übersetzungsschlüssel im internen Array existiert

public **nquery** (*mixed* $msgid1, *mixed* $msgid2, *mixed* $count, [*mixed* $placeholders], [*mixed* $domain])

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.

public **setDomain** (*mixed* $domain)

Changes the current domain (i.e. the translation file)

public **resetDomain** ()

Sets the default domain

public **setDefaultDomain** (*mixed* $domain)

Sets the domain default to search within when calls are made to gettext()

public **setDirectory** (*mixed* $directory)

Sets the path for a domain

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

Sets locale information

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

Gets default options

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück (Alias der Methode ' t ')

public **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Legt einen Wert der Übersetzung fest

public **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Check whether a translation key exists

public **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Entfernt eine Übersetzung aus dem Wörterbuch wieder

public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Ersetzt Platzhalter durch die übergebenen Werte