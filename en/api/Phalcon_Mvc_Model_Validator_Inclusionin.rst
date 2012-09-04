Class **Phalcon\\Mvc\\Model\\Validator\\Inclusionin**
=====================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Phalcon\\Mvc\\Model\\Validator\\InclusionIn Check if a value is included into a list of values 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\InclusionIn as InclusionInValidator;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
    	public function validation()
    	{
    		$this->validate(new InclusionInValidator(array(
    			'field' => 'status',
    			'domain' => array('A', 'I')
    		)));
    		if ($this->validationHasFailed() == true) {
    			return false;
    		}
    	}
    
    }



Methods
---------

*boolean* public **validate** (*unknown* $record)

Executes validator



public **__construct** (*unknown* $options)

protected **appendMessage** ()

public **getMessages** ()

protected **getOptions** ()

protected **getOption** ()

protected **isSetOption** ()

