Class **Phalcon\\Mvc\\Model\\Message**
======================================

<<<<<<< HEAD
Encapsulates validation info generated before save/delete records fails 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`

Encapsulates validation info generated before save/delete records fails  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     use Phalcon\Mvc\Model\Message as Message;
    
     class Robots extends Phalcon\Mvc\Model
    {
    
       public function beforeSave()
       {
         if (this->name == 'Peter') {
            $text = "A robot cannot be named Peter";
            $field = "name";
            $type = "InvalidValue";
            $message = new Message($text, $field, $type);
            $this->appendMessage($message);
         }
       }
    
     }



Methods
---------

public  **__construct** (*string* $message, *string* $field, *string* $type)

Phalcon\\Mvc\\Model\\Message constructor



<<<<<<< HEAD
public  **setType** (*string* $type)
=======
public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setType** (*string* $type)
>>>>>>> 0.7.0

Sets message type



public *string*  **getType** ()

Returns message type



<<<<<<< HEAD
public  **setMessage** (*string* $message)
=======
public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setMessage** (*string* $message)
>>>>>>> 0.7.0

Sets verbose message



public *string*  **getMessage** ()

Returns verbose message



<<<<<<< HEAD
public  **setField** (*string* $field)
=======
public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setField** (*string* $field)
>>>>>>> 0.7.0

Sets field name related to message



public *string*  **getField** ()

Returns field name related to message



public *string*  **__toString** ()

Magic __toString method returns verbose message



public static :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **__set_state** (*array* $message)

Magic __set_state helps to recover messsages from serialization



