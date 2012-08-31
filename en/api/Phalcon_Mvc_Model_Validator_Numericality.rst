Class **Phalcon\\Mvc\\Model\\Validator\\Numericality**
======================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Phalcon\\Mvc\\Model\\Validator\\Numericality   Allows to validate if a field has a valid numeric format  

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

*boolean* **validate** (*unknown* **$record**)

**__construct** (*unknown* **$options**)

**appendMessage** ()

**getMessages** ()

**getOptions** ()

**getOption** ()

**isSetOption** ()

