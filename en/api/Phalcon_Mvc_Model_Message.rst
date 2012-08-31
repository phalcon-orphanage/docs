Class **Phalcon\\Mvc\\Model\\Message**
======================================

Phalcon\\Mvc\\Model\\Message   Encapsulates validation info generated before save/delete records fails   

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

**__construct** (*string* **$message**, *string* **$field**, *string* **$type**)

**setType** (*string* **$type**)

*string* **getType** ()

**setMessage** (*string* **$message**)

*string* **getMessage** ()

**setField** (*string* **$field**)

*string* **getField** ()

*string* **__toString** ()

:doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>` **__set_state** (*array* **$message**)

