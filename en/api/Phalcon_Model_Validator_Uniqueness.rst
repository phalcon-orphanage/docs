Class **Phalcon_Model_Validator_Uniqueness**
============================================

Validates that a field or a combination of a set of fields are not present more than once in the existing records of the related table

.. code-block:: php

    <?php
    
    class Subscriptors extends Phalcon_Model_Base
    {
    
        public function validation()
        {
            $this->validate(
                'Uniqueness', 
                array('field' => 'email')
            );

            if ($this->validationHasFailed() == true) {
                return false;
            }
        }
    
    }

Methods
---------

**boolean** **validate** ()

Executes the validator

