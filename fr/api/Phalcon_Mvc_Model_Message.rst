Class **Phalcon\\Mvc\\Model\\Message**
======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`

Encapsulates validation info generated before save/delete records fails  

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Message as Message;
    
      class Robots extends \Phalcon\Mvc\Model
      {
    
        public function beforeSave()
        {
          if (this->name == 'Peter') {
            text = "A robot cannot be named Peter";
            field = "name";
            type = "InvalidValue";
            message = new Message(text, field, type);
            this->appendMessage(message);
         }
       }
    
     }



Methods
-------

public  **__construct** (*unknown* $message, [*unknown* $field], [*unknown* $type], [*unknown* $model])

Phalcon\\Mvc\\Model\\Message constructor



public  **setType** (*unknown* $type)

Sets message type



public  **getType** ()

Returns message type



public  **setMessage** (*unknown* $message)

Sets verbose message



public  **getMessage** ()

Returns verbose message



public  **setField** (*unknown* $field)

Sets field name related to message



public  **getField** ()

Returns field name related to message



public  **setModel** (*unknown* $model)

Set the model who generates the message



public  **getModel** ()

Returns the model that produced the message



public  **__toString** ()

Magic __toString method returns verbose message



public static  **__set_state** (*unknown* $message)

Magic __set_state helps to re-build messages variable exporting



