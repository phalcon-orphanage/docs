Class **Phalcon\\Translate\\Adapter**
=====================================

*implements* ArrayAccess

Base class for Phalcon\\Translate adapters


Methods
---------

public *string*  **_** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key



public  **offsetSet** (*string* $offset, *string* $value)

Sets a translation value



public *boolean*  **offsetExists** (*string* $translateKey)

Check whether a translation key exists



public  **offsetUnset** (*string* $offset)

Unsets a translation from the dictionary



public *string*  **offsetGet** (*string* $translateKey)

Returns the translation related to the given key



