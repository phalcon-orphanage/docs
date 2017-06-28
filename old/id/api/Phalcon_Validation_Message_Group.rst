Class **Phalcon\\Validation\\Message\\Group**
=============================================

*implements* `Countable <http://php.net/manual/en/class.countable.php>`_, `ArrayAccess <http://php.net/manual/en/class.arrayaccess.php>`_, `Iterator <http://php.net/manual/en/class.iterator.php>`_, `Traversable <http://php.net/manual/en/class.traversable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/message/group.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Represents a group of validation messages


Methods
-------

public  **__construct** ([*array* $messages])

Phalcon\\Validation\\Message\\Group constructor



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>` **offsetGet** (*int* $index)

Gets an attribute a message using the array syntax

.. code-block:: php

    <?php

    print_r(
        $messages[0]
    );




public  **offsetSet** (*int* $index, :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>` $message)

Sets an attribute using the array-syntax

.. code-block:: php

    <?php

    $messages[0] = new \Phalcon\Validation\Message("This is a message");




public *boolean* **offsetExists** (*int* $index)

Checks if an index exists

.. code-block:: php

    <?php

    var_dump(
        isset($message["database"])
    );




public  **offsetUnset** (*mixed* $index)

Removes a message from the list

.. code-block:: php

    <?php

    unset($message["database"]);




public  **appendMessage** (:doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>` $message)

Appends a message to the group

.. code-block:: php

    <?php

    $messages->appendMessage(
        new \Phalcon\Validation\Message("This is a message")
    );




public  **appendMessages** (:doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>`\ [] $messages)

Appends an array of messages to the group

.. code-block:: php

    <?php

    $messages->appendMessages($messagesArray);




public *array* **filter** (*string* $fieldName)

Filters the message group by field name



public  **count** ()

Returns the number of messages in the list



public  **rewind** ()

Rewinds the internal iterator



public  **current** ()

Returns the current message in the iterator



public  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public  **valid** ()

Check if the current message in the iterator is valid



public static :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>` **__set_state** (*array* $group)

Magic __set_state helps to re-build messages variable when exporting



