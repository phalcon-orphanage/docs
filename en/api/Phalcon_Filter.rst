Class **Phalcon_Filter**
========================

The Phalcon_Filter component provides a set of commonly needed data filters. It provides object oriented wrappers to the php filter extension.

.. code-block:: php

    <?php
    
    $filter = new Phalcon_Filter();
    
    $filter->sanitize("some(one)@exa\\mple.com", "email"); // returns "someone@example.com"
    $filter->sanitize("hello<<", "string"); // returns "hello"
    $filter->sanitize("!100a019", "int"); // returns "100019"
    $filter->sanitize("!100a019.01a", "float"); // returns "100019.01"

Methods
---------

**mixed** **sanitize** (mixed $value, mixed $filters, boolean $silent)

Sanitizes a value with a specified single or set of filters

**mixed** **_sanitize** (mixed $value, string $filter, boolean $silent)

Internal sanitize wrapper to filter_var

