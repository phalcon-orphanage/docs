Class **Phalcon_Db_RawValue**
=============================

This class lets to insert/update raw data without quoting or formating. The next example shows how to use the MySQL now() function as a field value.  

.. code-block:: php

    <?php
    
    $subscriber             = new Subscribers();
    $subscriber->email      = 'andres@phalconphp.com';
    $subscriber->created_at = new Phalcon_Db_RawValue('NOW()');
    $subscriber->save();
     
Methods
---------

**__construct** (string $value)

Phalcon_Db_RawValue constructor

**string** **getValue** ()

Returns internal raw value without quoting or formating

**__toString** ()

Magic method __toString returns raw value without quoting or formating

