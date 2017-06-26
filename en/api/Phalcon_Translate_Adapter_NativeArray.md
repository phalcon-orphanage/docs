# Class **Phalcon\\Translate\\Adapter\\NativeArray**

*extends* abstract class [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](/en/3.1.2/api/Phalcon_Translate_AdapterInterface), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/translate/adapter/nativearray.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to define translation lists using PHP arrays


## Methods
public  **__construct** (*array* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



public  **query** (*mixed* $index, [*mixed* $placeholders])

Returns the translation related to the given key



public  **exists** (*mixed* $index)

Check whether is defined a translation key in the internal array



public  **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](/en/3.1.2/api/Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

...


public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Returns the translation string of the given key



public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Sets a translation value



public  **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Check whether a translation key exists



public  **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Unsets a translation from the dictionary



public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Returns the translation related to the given key



protected  **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](/en/3.1.2/api/Phalcon_Translate_Adapter)

Replaces placeholders by the values passed



