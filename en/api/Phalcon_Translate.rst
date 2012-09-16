Class **Phalcon\\Translate**
============================

*implements* ArrayAccess

Translate component allows the creation of multi-language applications using different adapters for translation lists.


Methods
---------

public *string*  **_** (*string* $translateKey, *array* $placeholders)

Returns the translation string of the given key



public  **offsetSet** (*string* $offset, *string* $value)

Sets a translation value



public *boolean*  **offsetExists** (*string* $translateKey)

Check whether a translation key exists



public  **offsetUnset** (*string* $offset)

Elimina un indice del diccionario



public *string*  **offsetGet** (*string* $traslateKey)

Returns the translation related to the given key



