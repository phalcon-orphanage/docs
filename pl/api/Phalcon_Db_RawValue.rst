Class **Phalcon\\Db\\RawValue**
===============================

This class allows to insert/update raw data without quoting or formating.  The next example shows how to use the MySQL now() function as a field value.  

.. code-block:: php

    <?php

    $subscriber = new Subscribers();
    $subscriber->email = 'andres@phalconphp.com';
    $subscriber->createdAt = new \Phalcon\Db\RawValue('now()');
    $subscriber->save();



Methods
-------

public  **getValue** ()

Raw value without quoting or formating



public  **__toString** ()

Raw value without quoting or formating



public  **__construct** (*unknown* $value)

Phalcon\\Db\\RawValue constructor



