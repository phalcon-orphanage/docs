Class **Phalcon\\Mvc\\Model\\Validator\\Uniqueness**
====================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Phalcon\\Mvc\\Model\\Validator\\Uniqueness   Validates that a field or a combination of a set of fields are not  present more than once in the existing records of the related table  

.. code-block:: php

    <?php

    
    use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
      public function validation()
      {
          $this->validate(new UniquenessValidator(array(
              'field' => 'email'
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

