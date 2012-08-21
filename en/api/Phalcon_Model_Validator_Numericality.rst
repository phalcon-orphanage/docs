Class **Phalcon_Model_Validator_Numericality**
==============================================

Allows to validate if a field has a valid numeric format  

.. code-block:: php

    <?php
    
    class Posts extends Phalcon_Model_Base 
    {
    
        public function validation()
        {
            $this->validate(
                'Numericality', 
                array('field' => 'year')
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

