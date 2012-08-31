Class **Phalcon\\Mvc\\Model\\Validator\\Inclusionin**
=====================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Validator <Phalcon_Mvc_Model_Validator>`

InclusionInValidator   Check if a value is included into a list of values  

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

*boolean* **validate** (*unknown* **$record**)

**__construct** (*unknown* **$options**)

**appendMessage** ()

**getMessages** ()

**getOptions** ()

**getOption** ()

**isSetOption** ()

