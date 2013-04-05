Interface **Phalcon\\Translate\\AdapterInterface**
==================================================

Methods
---------

abstract public  **__construct** (*array* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



abstract public *string*  **_** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key



abstract public *string*  **query** (*string* $index, [*array* $placeholders])

Returns the translation related to the given key



abstract public *bool*  **exists** (*string* $index)

Check whether is defined a translation key in the internal array



