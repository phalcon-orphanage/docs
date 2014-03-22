Abstract class **Phalcon\\Translate\\Adapter**
==============================================

*implements* ArrayAccess, :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`

Base class for Phalcon\\Translate adapters


Methods
-------

public  **__construct** ()

Class constructore



public *string*  **_** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key



public  **offsetSet** (*unknown* $property, *string* $value)

Sets a translation value



public *boolean*  **offsetExists** (*unknown* $property)

Check whether a translation key exists



public  **offsetUnset** (*unknown* $property)

Unsets a translation from the dictionary



public *string*  **offsetGet** (*unknown* $property)

Returns the translation related to the given key



abstract public *string*  **query** (*string* $index, [*array* $placeholders]) inherited from Phalcon\\Translate\\AdapterInterface

Returns the translation related to the given key



abstract public *bool*  **exists** (*string* $index) inherited from Phalcon\\Translate\\AdapterInterface

Check whether is defined a translation key in the internal array



