Class **Phalcon\\Debug\\Dump**
==============================

Dumps information about a variable(s)  

.. code-block:: php

    <?php

    $foo = 123;
    echo (new \Phalcon\Debug\Dump())->var($foo, "foo");

.. code-block:: php

    <?php

    $foo = "string";
    $bar = ["key" => "value"];
    $baz = new stdClass();
    echo (new \Phalcon\Debug\Dump())->vars($foo, $bar, $baz);



Methods
-------

public  **getDetailed** ()

...


public  **setDetailed** (*unknown* $detailed)

...


public  **__construct** ([*unknown* $styles], [*unknown* $detailed])

Phalcon\\Debug\\Dump constructor



public *string*  **all** ()

Alias of vars() method



protected *string*  **getStyle** (*unknown* $type)

Get style for type



public *array*  **setStyles** ([*unknown* $styles])

Set styles for vars type



public *string*  **one** (*unknown* $variable, [*unknown* $name])

Alias of var() method



protected *string*  **output** (*unknown* $variable, [*unknown* $name], [*unknown* $tab])

Prepare an HTML string of information about a single variable.



public *string*  **var** (*unknown* $variable, [*unknown* $name])

Returns an HTML string of information about a single variable. 

.. code-block:: php

    <?php

    echo (new \Phalcon\Debug\Dump())->var($foo, "foo");




public *string*  **vars** ()

Returns an HTML string of debugging information about any number of variables, each wrapped in a "pre" tag. 

.. code-block:: php

    <?php

    $foo = "string";
    $bar = ["key" => "value"];
    $baz = new stdClass();
    echo (new \Phalcon\Debug\Dump())->vars($foo, $bar, $baz);




