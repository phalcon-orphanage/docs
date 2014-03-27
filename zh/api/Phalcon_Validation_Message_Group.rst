Class **Phalcon\\Validation\\Message\\Group**
=============================================

*implements* Countable, ArrayAccess, Iterator, Traversable

Represents a group of validation messages


Methods
-------

public  **__construct** ([*array* $messages])

Phalcon\\Validation\\Message\\Group constructor



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **offsetGet** (*string* $index)

Gets an attribute a message using the array syntax 

.. code-block:: php

    <?php

     print_r($messages[0]);




public  **offsetSet** (*string* $index, :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>` $message)

Sets an attribute using the array-syntax 

.. code-block:: php

    <?php

     $messages[0] = new Phalcon\Validation\Message('This is a message');




public *boolean*  **offsetExists** (*string* $index)

Checks if an index exists 

.. code-block:: php

    <?php

     var_dump(isset($message['database']));




public  **offsetUnset** (*string* $index)

Removes a message from the list 

.. code-block:: php

    <?php

     unset($message['database']);




public  **appendMessage** (:doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>` $message)

Appends a message to the group 

.. code-block:: php

    <?php

     $messages->appendMessage(new Phalcon\Validation\Message('This is a message'));




public  **appendMessages** (*Phalcon\\Validation\\MessageInterface[]* $messages)

Appends an array of messages to the group 

.. code-block:: php

    <?php

     $messages->appendMessages($messagesArray);




public *array*  **filter** (*string* $fieldName)

Filters the message group by field name



public *int*  **count** ()

Returns the number of messages in the list



public  **rewind** ()

Rewinds the internal iterator



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **current** ()

Returns the current message in the iterator



public *int*  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public *boolean*  **valid** ()

Check if the current message in the iterator is valid



public static *Phalcon\\Mvc\\Model\\Message\\Group*  **__set_state** (*array* $group)

Magic __set_state helps to re-build messages variable when exporting



