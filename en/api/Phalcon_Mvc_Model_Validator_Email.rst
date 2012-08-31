Class **Phalcon\\Mvc\\Model\\Validator\\Email**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Phalcon\\Mvc\\Model\\Validator\\Email   Allows to validate if email fields has correct values  

.. code-block:: php

    <?php

    
    use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
      public function validation()
      {
          $this->validate(new EmailValidator(array(
              'field' => 'electronic_mail'
          )));
          if ($this->validationHasFailed() == true) {
              return false;
          }
      }
    
    }
    





Methods
---------

*boolean* **validate** (*unknown* **$record**)

**__construct** (*unknown* **$options**)

**appendMessage** ()

**getMessages** ()

**getOptions** ()

**getOption** ()

**isSetOption** ()

