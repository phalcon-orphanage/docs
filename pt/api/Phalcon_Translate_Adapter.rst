Abstract class **Phalcon\\Translate\\Adapter**
==============================================

Base class for Phalcon\\Translate adapters


Methods
-------

public *string*  **t** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key



public *string*  **_** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*string* $offset, *string* $value)

Sets a translation value



public  **offsetExists** (*unknown* $translateKey)

Check whether a translation key exists



public  **offsetUnset** (*string* $offset)

Unsets a translation from the dictionary



public *string*  **offsetGet** (*string* $translateKey)

Returns the translation related to the given key



protected  **replacePlaceholders** (*unknown* $translation, [*unknown* $placeholders])

Replaces placeholders by the values passed



