Class **Phalcon\\Mvc\\Model\\Validator\\Regex**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Allows to validate if the value of a field matches a regular expression 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\Regex as RegexValidator;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
      public function validation()
      {
          $this->validate(new RegexValidator(array(
              'field' => 'created_at',
              'pattern' => '/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/'
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

