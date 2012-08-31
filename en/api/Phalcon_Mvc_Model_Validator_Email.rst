Class **Phalcon_Model_Validator_Email**
=======================================

Allows to validate if email fields has correct values  

.. code-block:: php

    <?php
    
    class Subscriptors extends Phalcon\Model\Base 
    {

        public function validation()
        {
            $this->validate(
                'Email', 
                array('field' => 'electronic_mail')
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

