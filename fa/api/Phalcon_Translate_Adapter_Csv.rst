Class **Phalcon\\Translate\\Adapter\\Csv**
==========================================

*extends* abstract class :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

*implements* :doc:`Phalcon\\Translate\\AdapterInterface <Phalcon_Translate_AdapterInterface>`, `ArrayAccess <http://php.net/manual/en/class.arrayaccess.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/translate/adapter/csv.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to define translation lists using CSV file


Methods
-------

public  **__construct** (*array* $options)

Phalcon\\Translate\\Adapter\\Csv constructor



private  **_load** (*string* $file, *int* $length, *string* $delimiter, *string* $enclosure)

Load translates from file



public  **query** (*mixed* $index, [*mixed* $placeholders])

Returns the translation related to the given key



public  **exists** (*mixed* $index)

Check whether is defined a translation key in the internal array



public  **setInterpolator** (:doc:`Phalcon\\Translate\\InterpolatorInterface <Phalcon_Translate_InterpolatorInterface>` $interpolator) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

...


public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Returns the translation string of the given key



public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Returns the translation string of the given key (alias of method 't')



public  **offsetSet** (*string* $offset, *string* $value) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Sets a translation value



public  **offsetExists** (*mixed* $translateKey) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Check whether a translation key exists



public  **offsetUnset** (*string* $offset) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Unsets a translation from the dictionary



public *string* **offsetGet** (*string* $translateKey) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Returns the translation related to the given key



protected  **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from :doc:`Phalcon\\Translate\\Adapter <Phalcon_Translate_Adapter>`

Replaces placeholders by the values passed



