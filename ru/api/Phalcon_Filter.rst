Class **Phalcon\\Filter**
=========================

*implements* :doc:`Phalcon\\FilterInterface <Phalcon_FilterInterface>`

The Phalcon\\Filter component provides a set of commonly needed data filters. It provides object oriented wrappers to the php filter extension. Also allows the developer to define his/her own filters  

.. code-block:: php

    <?php

    $filter = new \Phalcon\Filter();
    $filter->sanitize("some(one)@exa\\mple.com", "email"); // returns "someone@example.com"
    $filter->sanitize("hello<<", "string"); // returns "hello"
    $filter->sanitize("!100a019", "int"); // returns "100019"
    $filter->sanitize("!100a019.01a", "float"); // returns "100019.01"



Methods
-------

public :doc:`Phalcon\\Filter <Phalcon_Filter>`  **add** (*unknown* $name, *unknown* $handler)

Adds a user-defined filter



public *mixed*  **sanitize** (*unknown* $value, *unknown* $filters, [*unknown* $noRecursive])

Sanitizes a value with a specified single or set of filters



protected *mixed*  **_sanitize** (*mixed* $value, *string* $filter)

Internal sanitize wrapper to filter_var



public *object[]*  **getFilters** ()

Return the user-defined filters in the instance



