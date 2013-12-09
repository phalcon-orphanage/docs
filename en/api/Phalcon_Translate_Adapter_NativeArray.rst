Class **Phalcon\\Translate\\Adapter\\NativeArray**
==================================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* ArrayAccess, :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`

Allows to define translation lists using PHP arrays


Methods
---------

public  **__construct** (*array* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



public *string*  **query** (*string* $index, [*array* $placeholders])

Returns the translation related to the given key



public *bool*  **exists** (*string* $index)

Check whether is defined a translation key in the internal array



public *string*  **_** (*string* $translateKey, [*array* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key



public  **offsetSet** (*string* $offset, *string* $value) inherited from Phalcon\\Translate\\Adapter

Sets a translation value



public *boolean*  **offsetExists** (*string* $translateKey) inherited from Phalcon\\Translate\\Adapter

Check whether a translation key exists



public  **offsetUnset** (*string* $offset) inherited from Phalcon\\Translate\\Adapter

Unsets a translation from the dictionary



public *string*  **offsetGet** (*string* $translateKey) inherited from Phalcon\\Translate\\Adapter

Returns the translation related to the given key



