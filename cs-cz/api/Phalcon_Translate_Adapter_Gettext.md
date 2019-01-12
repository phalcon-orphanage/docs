* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Translate\Adapter\Gettext'

* * *

# Class **Phalcon\Translate\Adapter\Gettext**

*extends* abstract class [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](/4.0/en/api/Phalcon_Translate_AdapterInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/translate/adapter/gettext.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

## Methods

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

Check whether is defined a translation key in the internal array

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

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](/4.0/en/api/Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Returns the translation string of the given key

public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Returns the translation string of the given key (alias of method 't')

public **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Sets a translation value

public **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Check whether a translation key exists

public **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Unsets a translation from the dictionary

public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Returns the translation related to the given key

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](/4.0/en/api/Phalcon_Translate_Adapter)

Replaces placeholders by the values passed