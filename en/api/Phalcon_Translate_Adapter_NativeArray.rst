Class **Phalcon\\Translate\\Adapter\\NativeArray**
==================================================

*extends* :doc:`Phalcon\\Translate <Phalcon_Translate>`

*implements* ArrayAccess

Methods
---------

public **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



*string* public **query** (*string* $index, *array* $placeholders)

Returns the translation related to the given key



*bool* public **exists** (*string* $index)

Check whether is defined a translation key in the internal array



public **_** (*unknown* $translateKey, *unknown* $placeholders)

public **offsetSet** (*unknown* $offset, *unknown* $value)

public **offsetExists** (*unknown* $translateKey)

public **offsetUnset** (*unknown* $offset)

public **offsetGet** (*unknown* $traslateKey)

