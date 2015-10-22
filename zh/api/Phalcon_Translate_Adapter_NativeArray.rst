Class **Phalcon\\Translate\\Adapter\\NativeArray**
==================================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`, ArrayAccess

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/translate/adapter/nativearray.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to define translation lists using PHP arrays


Methods
-------

public  **__construct** (*unknown* $options)

Phalcon\\Translate\\Adapter\\NativeArray constructor



public  **query** (*unknown* $index, [*unknown* $placeholders])

Returns the translation related to the given key



public  **exists** (*unknown* $index)

Check whether is defined a translation key in the internal array



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



