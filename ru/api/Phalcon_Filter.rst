Class **Phalcon\\Filter**
=========================

The Phalcon\\Filter component provides a set of commonly needed data filters. It provides object oriented wrappers to the php filter extension. Also allows the developer to define his/her own filters 

.. code-block:: php

    <?php

    $filter = new Phalcon\Filter();
    $filter->sanitize("some(one)@exa\\mple.com", "email"); // returns "someone@example.com"
    $filter->sanitize("hello<<", "string"); // returns "hello"
    $filter->sanitize("!100a019", "int"); // returns "100019"
    $filter->sanitize("!100a019.01a", "float"); // returns "100019.01"



Methods
---------

public  **__construct** ()

...


public  **add** (*unknown* $name, *unknown* $handler)

...


public *mixed*  **sanitize** (*mixed* $value, *mixed* $filters)

Sanizites a value with a specified single or set of filters



protected *mixed*  **_sanitize** ()

Internal sanizite wrapper to filter_var



public *object[]*  **getFilters** ()

Return the user-defined filters in the instance



