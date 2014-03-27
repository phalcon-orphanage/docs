Class **Phalcon\\Db\\RawValue**
===============================

This class allows to insert/update raw data without quoting or formating.  The next example shows how to use the MySQL now() function as a field value.  

.. code-block:: php

    <?php

    $subscriber = new Subscribers();
    $subscriber->email = 'andres@phalconphp.com';
    $subscriber->created_at = new Phalcon\Db\RawValue('now()');
    $subscriber->save();



Methods
-------

public  **__construct** (*string* $value)

Phalcon\\Db\\RawValue constructor



public *string*  **getValue** ()

Returns internal raw value without quoting or formating



public  **__toString** ()

Magic method __toString returns raw value without quoting or formating



