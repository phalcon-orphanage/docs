Abstract class **Phalcon\\Translate\\Adapter**
==============================================

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/translate/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Base class for Phalcon\\Translate adapters


Methods
-------

public  **__construct** (*array* $options)

...


public  **setInterpolator** (:doc:`Phalcon\\Translate\\InterpolatorInterface <Phalcon_Translate_InterpolatorInterface>` $interpolator)

...


public *string* **t** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key



public *string* **_** (*string* $translateKey, [*array* $placeholders])

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*string* $offset, *string* $value)

Sets a translation value



public  **offsetExists** (*mixed* $translateKey)

Check whether a translation key exists



public  **offsetUnset** (*string* $offset)

Unsets a translation from the dictionary



public *string* **offsetGet** (*string* $translateKey)

Returns the translation related to the given key



protected  **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders])

Replaces placeholders by the values passed



abstract public  **query** (*mixed* $index, [*mixed* $placeholders]) inherited from :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`

...


abstract public  **exists** (*mixed* $index) inherited from :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`

...


