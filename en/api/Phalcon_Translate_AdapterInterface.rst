Interface **Phalcon\\Translate\\AdapterInterface**
==================================================

Phalcon\\Translate\\AdapterInterface initializer


Methods
---------

abstract public  **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



abstract public *string*  **_** (*string* $translateKey, *array* $placeholders)

Returns the translation string of the given key



abstract public *string*  **query** (*string* $index, *array* $placeholders)

Returns the translation related to the given key



abstract public *bool*  **exists** (*string* $index)

Check whether is defined a translation key in the internal array



