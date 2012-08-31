Class **Phalcon\\Db\\RawValue**
===============================

Phalcon\\Db\\RawValue   This class allows to insert/update raw data without quoting or formating.  <example>  The next example shows how to use the MySQL now() function as a field value.  

.. code-block:: php

    <?php

    
    $subscriber = new Subscribers();
    $subscriber->email = 'andres@phalconphp.com';
    $subscriber->created_at = new Phalcon\Db\RawValue('now()');
    $subscriber->save();
     



  </example>

Methods
---------

**__construct** (*string* **$value**)

*string* **getValue** ()

**__toString** ()

