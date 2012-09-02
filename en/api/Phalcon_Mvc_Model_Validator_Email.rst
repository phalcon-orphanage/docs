Class **Phalcon\\Mvc\\Model\\Validator\\Email**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Allows to validate if email fields has correct values  

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

*boolean* public **validate** (*unknown* $record)

Executes the validator



public **__construct** (*unknown* $options)

protected **appendMessage** ()

public **getMessages** ()

protected **getOptions** ()

protected **getOption** ()

protected **isSetOption** ()

