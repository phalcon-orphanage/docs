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



public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`  **setType** (*unknown* $type)

Sets message type



public *string*  **getType** ()

Returns message type



public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`  **setMessage** (*unknown* $message)

Sets verbose message



public *string*  **getMessage** ()

Returns verbose message



public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`  **setField** (*unknown* $field)

Sets field name related to message



public *string*  **getField** ()

Returns field name related to message



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setModel** (*unknown* $model)

Set the model who generates the message



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getModel** ()

Returns the model that produced the message



public *string*  **__toString** ()

Magic __toString method returns verbose message



public static :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`  **__set_state** (*unknown* $message)

Magic __set_state helps to re-build messages variable exporting



