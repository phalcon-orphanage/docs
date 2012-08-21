Class **Phalcon_Translate**
===========================

*implements* ArrayAccess

Translate component allows the creation of multi-language applications using different adapters for translation lists.

Methods
---------

**__construct** (string $adapter, array $options)

Phalcon_Translate constructor

**string** **_** (string $translateKey, array $placeholders)

Returns the translation string of the given key

**offsetSet** (string $offset, string $value)

Sets a translation value

**boolean** **offsetExists** (string $translateKey)

Check whether a translation key exists

**offsetUnset** (string $offset)

Remove an index based on a given key

**string** **offsetGet** (string $traslateKey)

Returns the translation related to the given key

