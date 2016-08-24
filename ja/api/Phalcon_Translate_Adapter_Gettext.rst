Class **Phalcon\\Translate\\Adapter\\Gettext**
==============================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`, ArrayAccess

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/translate/adapter/gettext.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows translate using gettext


Methods
-------

public  **getDirectory** ()





public  **getDefaultDomain** ()





public  **getLocale** ()





public  **getCategory** ()





public  **__construct** (*array* $options)

Phalcon\\Translate\\Adapter\\Gettext constructor



public *string*  **query** (*string* $index, [*array* $placeholders])

Returns the translation related to the given key



public  **exists** (*mixed* $index)

Check whether is defined a translation key in the internal array



public *string*  **nquery** (*string* $msgid1, *string* $msgid2, *int* $count, [*array* $placeholders], [*string* $domain])

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.



public  **setDomain** (*mixed* $domain)

Changes the current domain (i.e. the translation file)



public  **resetDomain** ()

Sets the default domain



public  **setDefaultDomain** (*mixed* $domain)

Sets the domain default to search within when calls are made to gettext()



public  **setDirectory** (*mixed* $directory)

Sets the path for a domain 

.. code-block:: php

    <?php

     // Set the directory path
     $gettext->setDirectory("/path/to/the/messages");
    
     // Set the domains and directories path
     $gettext->setDirectory([
        "messages" => "/path/to/the/messages",
        "another" => "/path/to/the/another"
     ]);




public  **setLocale** (*mixed* $category, *mixed* $locale)

Sets locale information 

.. code-block:: php

    <?php

     // Set locale to Dutch
     $gettext->setLocale(LC_ALL, 'nl_NL');
    
     // Try different possible locale names for german
     $gettext->setLocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');




protected  **prepareOptions** (*array* $options)

Validator for constructor



private  **getOptionsDefault** ()

Gets default options



public  **setInterpolator** (:doc:`Phalcon\\Translate\\InterpolatorInterface <Phalcon_Translate_InterpolatorInterface>` $interpolator) inherited from Phalcon\\Translate\\Adapter

...


public *string*  **t** (*string* $translateKey, [*array* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key



public *string*  **_** (*string* $translateKey, [*array* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*string* $offset, *string* $value) inherited from Phalcon\\Translate\\Adapter

Sets a translation value



public  **offsetExists** (*mixed* $translateKey) inherited from Phalcon\\Translate\\Adapter

Check whether a translation key exists



public  **offsetUnset** (*string* $offset) inherited from Phalcon\\Translate\\Adapter

Unsets a translation from the dictionary



public *string*  **offsetGet** (*string* $translateKey) inherited from Phalcon\\Translate\\Adapter

Returns the translation related to the given key



protected  **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from Phalcon\\Translate\\Adapter

Replaces placeholders by the values passed



