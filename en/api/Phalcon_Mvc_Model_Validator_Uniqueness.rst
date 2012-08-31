Class **Phalcon\\Mvc\\Model\\Validator\\Uniqueness**
====================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Validates that a field or a combination of a set of fields are not present more than once in the existing records of the related table  

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

*boolean* public **validate** (*unknown* $record)

Executes the validator



public **__construct** (*unknown* $options)

protected **appendMessage** ()

public **getMessages** ()

protected **getOptions** ()

protected **getOption** ()

protected **isSetOption** ()

