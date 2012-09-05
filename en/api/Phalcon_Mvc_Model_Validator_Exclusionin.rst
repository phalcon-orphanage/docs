Class **Phalcon\\Mvc\\Model\\Validator\\Exclusionin**
=====================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

Phalcon\\Mvc\\Model\\Validator\\ExclusionIn Check if a value is not included into a list of values 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionInValidator;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
    	public function validation()
    	{
    		$this->validate(new ExclusionInValidator(array(
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

Executes the validator



public **__construct** (*unknown* $options)

protected **appendMessage** ()

public **getMessages** ()

protected **getOptions** ()

protected **getOption** ()

protected **isSetOption** ()

