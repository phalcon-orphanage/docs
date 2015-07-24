Class **Phalcon\\Translate\\Adapter\\Gettext**
==============================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`, ArrayAccess

Class Gettext


Methods
-------

public  **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\Gettext constructor



public *string*  **query** (*string* $index, [*array* $placeholders])

Returns the translation related to the given key



public  **exists** (*unknown* $index)

Check whether is defined a translation key in the internal array



public *string*  **nquery** (*string* $msgid1, *string* $msgid2, *int* $count, [*array* $placeholders], [*string* $domain])

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.



public *string Returns the new current domain.*  **setDomain** (*string* $domain)

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



public *string*  **t** (*string* $translateKey, [*array* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key



public *string*  **_** (*string* $translateKey, [*array* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*string* $offset, *string* $value) inherited from Phalcon\\Translate\\Adapter

Sets a translation value



public  **offsetExists** (*unknown* $translateKey) inherited from Phalcon\\Translate\\Adapter

Check whether a translation key exists



public  **offsetUnset** (*string* $offset) inherited from Phalcon\\Translate\\Adapter

Unsets a translation from the dictionary



public *string*  **offsetGet** (*string* $translateKey) inherited from Phalcon\\Translate\\Adapter

Returns the translation related to the given key



protected  **replacePlaceholders** (*unknown* $translation, [*unknown* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Replaces placeholders by the values passed



