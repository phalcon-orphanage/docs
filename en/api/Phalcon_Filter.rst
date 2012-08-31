Class **Phalcon\\Filter**
=========================

Phalcon\\Filter   The Phalcon_Filter component provides a set of commonly needed data filters. It provides  object oriented wrappers to the php filter extension  

.. code-block:: php

    <?php

    
    $filter = new Phalcon\Filter();
    $filter->sanitize("some(one)@exa\\mple.com", "email"); // returns "someone@example.com"
    $filter->sanitize("hello<<", "string"); // returns "hello"
    $filter->sanitize("!100a019", "int"); // returns "100019"
    $filter->sanitize("!100a019.01a", "float"); // returns "100019.01"
    





Methods
---------

**__construct** ()

**add** (*unknown* **$name**, *unknown* **$handler**)

*mixed* **sanitize** (*mixed* **$value**, *mixed* **$filters**)

*mixed* **_sanitize** ()

**getFilters** ()

