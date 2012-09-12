Class **Phalcon\\Translate\\Adapter\\NativeArray**
==================================================

*extends* :doc:`Phalcon\\Translate <Phalcon_Translate>`

*implements* ArrayAccess

Allows to define translation lists using PHP arrays


Methods
---------

public **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



*string* public **query** (*string* $index, *array* $placeholders)

Returns the translation related to the given key



*bool* public **exists** (*string* $index)

Check whether is defined a translation key in the internal array



*string* public **_** (*string* $translateKey, *array* $placeholders) inherited from Phalcon_Translate

Returns the translation string of the given key



public **offsetSet** (*string* $offset, *string* $value) inherited from Phalcon_Translate

Sets a translation value



*boolean* public **offsetExists** (*string* $translateKey) inherited from Phalcon_Translate

Check whether a translation key exists



public **offsetUnset** (*string* $offset) inherited from Phalcon_Translate

Elimina un indice del diccionario



*string* public **offsetGet** (*string* $traslateKey) inherited from Phalcon_Translate

Returns the translation related to the given key



