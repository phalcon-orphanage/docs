Class **Phalcon\\Db\\RawValue**
===============================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/rawvalue.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class allows to insert/update raw data without quoting or formatting.

The next example shows how to use the MySQL now() function as a field value.

.. code-block:: php

    <?php

    $subscriber = new Subscribers();

    $subscriber->email     = "andres@phalconphp.com";
    $subscriber->createdAt = new \Phalcon\Db\RawValue("now()");

    $subscriber->save();



Methods
-------

public  **getValue** ()

Raw value without quoting or formatting



public  **__toString** ()

Raw value without quoting or formatting



public  **__construct** (*mixed* $value)

Phalcon\\Db\\RawValue constructor



