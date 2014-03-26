Class **Phalcon\\Debug\\Dump**
==============================

Dumps information about a variable


Methods
-------

public  **__construct** ([*unknown* $styles])

Phalcon\\Debug\\Dump constructor



public *string*  **vars** ()

Returns an HTML string of debugging information about any number of variables, each wrapped in a "pre" tag. 

.. code-block:: php

    <?php

    echo (new \Phalcon\Debug\Dump())->vars($foo, $bar, $baz);




public *string*  **dump** (*unknown* $variable, [*unknown* $name])

Returns an HTML string of information about a single variable. 

.. code-block:: php

    <?php

    echo (new \Phalcon\Debug\Dump())->dump($foo, "foo");




public *string*  **output** (*unknown* $variable, [*unknown* $name], [*unknown* $tab])

Prepare an HTML string of information about a single variable.



public  **setStyles** (*unknown* $styles)

...


public *string*  **getStyle** (*unknown* $type)

Get style for type



