Class **Phalcon\\Assets\\Resource**
===================================

Represents an asset resource  

.. code-block:: php

    <?php

     $resource = new Phalcon\Assets\Resource('js', 'javascripts/jquery.js');



Methods
---------

public  **__construct** (*string* $type, *string* $path, [*boolean* $local])

Phalcon\\Assets\\Resource constructor



public *string*  **getType** ()

Returns the type of resource



public *string*  **getPath** ()

Returns the URI/URL path to the resource



public *boolean*  **getLocal** ()

Returns whether the resource is local or external



