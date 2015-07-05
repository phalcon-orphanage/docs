Abstract class **Phalcon\\Translate\\Adapter**
==============================================

Base class for Phalcon\\Translate adapters


Methods
-------

public *string*  **t** (*unknown* $translateKey, [*unknown* $placeholders])

Returns the translation string of the given key



public *string*  **_** (*unknown* $translateKey, [*unknown* $placeholders])

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*unknown* $offset, *unknown* $value)

Sets a translation value



public  **offsetExists** (*unknown* $translateKey)

Check whether a translation key exists



public  **offsetUnset** (*unknown* $offset)

Unsets a translation from the dictionary



public *string*  **offsetGet** (*unknown* $translateKey)

Returns the translation related to the given key



protected  **replacePlaceholders** (*unknown* $translation, [*unknown* $placeholders])

Replaces placeholders by the values passed



