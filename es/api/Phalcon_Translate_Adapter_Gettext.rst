Class **Phalcon\\Translate\\Adapter\\Gettext**
==============================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`, ArrayAccess

Class Gettext


Methods
-------

public  **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\Gettext constructor



public *string*  **query** (*unknown* $index, [*unknown* $placeholders])

Returns the translation related to the given key



public  **exists** (*unknown* $index)

Check whether is defined a translation key in the internal array



public *string*  **nquery** (*unknown* $msgid1, *unknown* $msgid2, *unknown* $count, [*unknown* $placeholders], [*unknown* $domain])

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.



public *string Returns the new current domain.*  **setDomain** (*unknown* $domain)

Changes the current domain (i.e. the translation file). The passed domain must be one of those passed to the constructor.



public *string Returns the new current domain.*  **resetDomain** ()

Sets the default domain



public  **setDefaultDomain** (*unknown* $domain)

Sets the domain default to search within when calls are made to gettext()



public  **getDefaultDomain** ()

Gets the default domain



public  **setDirectory** (*unknown* $directory)

Sets the path for a domain



public  **getDirectory** (*unknown* $directory)

Gets the path for a domain



public  **setLocale** (*unknown* $category, *unknown* $locale)

Sets locale information



public  **getLocale** ()

Gets locale



public  **getCategory** ()

Gets locale category



protected  **prepareOptions** (*unknown* $options)

Validator for constructor



protected  **getOptionsDefault** ()

Gets default options



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



