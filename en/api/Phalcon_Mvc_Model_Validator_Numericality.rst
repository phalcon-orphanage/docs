Class **Phalcon\\Mvc\\Model\\Validator\\Numericality**
======================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Allows to validate if a field has a valid numeric format 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;
    
    class Products extends Phalcon\Mvc\Model
    {
    
      public function validation()
      {
          $this->validate(new NumericalityValidator(array(
              'field' => 'price'
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

