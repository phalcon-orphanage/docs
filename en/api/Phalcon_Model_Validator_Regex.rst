Class **Phalcon_Model_Validator_Regex**
=======================================

Allows to validate if the value of a field matches a regular expression  

.. code-block:: php

    <?php
    
    class Subscriptors extends Phalcon_Model_Base 
    {
    
        public function validation()
        {
            $this->validate(
                'Regex', 
                array(
                    'field'   => 'created_at',
                    'pattern' => '/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/',
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

Check that the options are correct

**boolean** **validate** ()

Executes the validator

