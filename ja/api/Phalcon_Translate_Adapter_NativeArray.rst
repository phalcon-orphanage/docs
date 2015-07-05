Class **Phalcon\\Translate\\Adapter\\NativeArray**
==================================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`, ArrayAccess

Allows to define translation lists using PHP arrays


Methods
-------

public  **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



public  **query** (*unknown* $index, [*unknown* $placeholders])

Returns the translation related to the given key



public  **exists** (*unknown* $index)

Check whether is defined a translation key in the internal array



public *string*  **t** (*unknown* $translateKey, [*unknown* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key



public *string*  **_** (*unknown* $translateKey, [*unknown* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*unknown* $offset, *unknown* $value) inherited from Phalcon\\Translate\\Adapter

Sets a translation value



public  **offsetExists** (*unknown* $translateKey) inherited from Phalcon\\Translate\\Adapter

Check whether a translation key exists



public  **offsetUnset** (*unknown* $offset) inherited from Phalcon\\Translate\\Adapter

Unsets a translation from the dictionary



public *string*  **offsetGet** (*unknown* $translateKey) inherited from Phalcon\\Translate\\Adapter

Returns the translation related to the given key



protected  **replacePlaceholders** (*unknown* $translation, [*unknown* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Replaces placeholders by the values passed



