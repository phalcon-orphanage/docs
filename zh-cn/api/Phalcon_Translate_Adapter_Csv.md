* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Translate\Adapter\Csv'

* * *

# Class **Phalcon\Translate\Adapter\Csv**

*extends* abstract class [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/translate/adapter/csv.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Allows to define translation lists using CSV file

## 方法

public **__construct** (*array* $options)

Phalcon\Translate\Adapter\Csv constructor

private **_load** (*string* $file, *int* $length, *string* $delimiter, *string* $enclosure)

Load translates from file

public **query** (*mixed* $index, [*mixed* $placeholders])

Returns the translation related to the given key

public **exists** (*mixed* $index)

Check whether is defined a translation key in the internal array

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Returns the translation string of the given key

public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Returns the translation string of the given key (alias of method 't')

public **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Sets a translation value

public **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Check whether a translation key exists

public **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Unsets a translation from the dictionary

public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Returns the translation related to the given key

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Replaces placeholders by the values passed