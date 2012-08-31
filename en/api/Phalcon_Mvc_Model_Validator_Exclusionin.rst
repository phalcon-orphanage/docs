Class **Phalcon_Model_Validator_Exclusionin**
=============================================

Checks if a value is not included into a list of values  

.. code-block:: php

    <?php

    
    class Subscriptors extends Phalcon_Model_Base 
    {

        public function validation()
        {
            $this->validate(
                'ExclusionIn', 
                array(
                    'field'  => 'status',
                    'domain' => array('A', 'I'),
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

