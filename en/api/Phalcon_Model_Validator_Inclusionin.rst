Class **Phalcon_Model_Validator_Inclusionin**
=============================================

Check if a value is included into a list of values  

.. code-block:: php

    <?php
    
    class Subscriptors extends Phalcon_Model_Base 
    {

        public function validation()
        {
            $this->validate(
                'InclusionIn', 
                array(
                'field' => 'status',
                'domain' => array('P', 'I'),
                )
            );
            
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }

Methods
---------

**checkOptions** ()

Check that the options are valid

**boolean** **validate** ()

Executes validator

