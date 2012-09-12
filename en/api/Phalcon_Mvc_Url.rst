Class **Phalcon\\Mvc\\Url**
===========================

This components aids in the generation off: URIs, URLs and Paths 

.. code-block:: php

    <?php

     //Generate a url appending a uri to the base Uri
     echo $url->get('products/edit/1');
    
     //Generate a url for a predefined route
     echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2012'));



Methods
---------

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the DependencyInjector container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the DependencyInjector container



public **setBaseUri** (*string* $baseUri)

Sets a prefix to all the urls generated 

.. code-block:: php

    <?php

    $url->setBasePath('/invo/');




*string* public **getBaseUri** ()

Returns the prefix for all the generated urls. By default /



*string $basePath* public **setBasePath** (*unknown* $basePath)

Sets a base paths for all the generated paths 

.. code-block:: php

    <?php

    $url->setBasePath('/var/www/');




*string* public **getBasePath** ()

Returns a base path



*string* public **get** (*string|array* $uri)

Generates a URL



*string* public **path** (*unknown* $path)

Generates a local path



