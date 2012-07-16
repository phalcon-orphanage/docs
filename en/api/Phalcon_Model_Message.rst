Class **Phalcon_Model_Message**
===============================

Encapsulates validation info generated before save/delete records fails   

.. code-block:: php

    <?php

    
     class Robots extends Phalcon\Model\Base 
    {
    
       public function beforeSave()
       {
         if (this->name == 'Peter') {
            $text = "A robot cannot be named Peter";
            $field = "name";
            $type = "InvalidValue";
            $message = new Phalcon\Model\Message($text, $field, $type);
            $this->appendMessage($message);
         }
       }
    
     }

Methods
---------

**__construct** (string $message, string $field, string $type)

Phalcon_Model\Message message

**setType** (string $type)

Sets message type

**string** **getType** ()

Returns message type

**setMessage** (string $message)

Sets verbose message

**string** **getMessage** ()

Returns verbose message

**setField** (string $field)

Sets field name related to message

**string** **getField** ()

Returns field name related to message

**string** **__toString** ()

Magic __toString method returns verbose message

**Phalcon\Model\Message** **__set_state** (array $message)

Magic __set_state helps to recover messsages from serialization

