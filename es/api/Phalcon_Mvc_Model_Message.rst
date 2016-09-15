Class **Phalcon\\Mvc\\Model\\Message**
======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/message.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Encapsulates validation info generated before save/delete records fails  

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Message as Message;
    
      class Robots extends \Phalcon\Mvc\Model
      {
    
        public function beforeSave()
        {
          if ($this->name == 'Peter') {
            $text = "A robot cannot be named Peter";
            $field = "name";
            $type = "InvalidValue";
            $message = new Message($text, $field, $type);
            $this->appendMessage($message);
         }
       }
    
     }



Methods
-------

public  **__construct** (*string* $message, [*string|array* $field], [*string* $type], [:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model], [*int|null* $code])

Phalcon\\Mvc\\Model\\Message constructor



public  **setType** (*mixed* $type)

Sets message type



public  **getType** ()

Returns message type



public  **setMessage** (*mixed* $message)

Sets verbose message



public  **getMessage** ()

Returns verbose message



public  **setField** (*mixed* $field)

Sets field name related to message



public  **getField** ()

Returns field name related to message



public  **setModel** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Set the model who generates the message



public  **setCode** (*mixed* $code)

Sets code for the message



public  **getModel** ()

Returns the model that produced the message



public  **getCode** ()

Returns the message code



public  **__toString** ()

Magic __toString method returns verbose message



public static  **__set_state** (*array* $message)

Magic __set_state helps to re-build messages variable exporting



