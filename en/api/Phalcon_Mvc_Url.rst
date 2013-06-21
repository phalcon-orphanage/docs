Class **Phalcon\\Mvc\\Url**
===========================

*implements* :doc:`Phalcon\\Mvc\\UrlInterface <Phalcon_Mvc_UrlInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This components aids in the generation of: URIs, URLs and Paths  

.. code-block:: php

    <?php

     //Generate a URL appending the URI to the base URI
     echo $url->get('products/edit/1');
    
     //Generate a URL for a predefined route
     echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2012'));



Methods
---------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setBaseUri** (*string* $baseUri)

Sets a prefix for all the URIs to be generated 

.. code-block:: php

    <?php

    $url->setBaseUri('/invo/');
    $url->setBaseUri('/invo/index.php/');




public *string*  **getBaseUri** ()

Returns the prefix for all the generated urls. By default /



public  **setBasePath** (*string* $basePath)

Sets a base path for all the generated paths 

.. code-block:: php

    <?php

    $url->setBasePath('/var/www/htdocs/');




public *string*  **getBasePath** ()

Returns the base path



public *string*  **get** ([*string|array* $uri])

Generates a URL 

.. code-block:: php

    <?php

     //Generate a URL appending the URI to the base URI
     echo $url->get('products/edit/1');
    
     //Generate a URL for a predefined route
     echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2012'));




public *string*  **path** ([*string* $path])

Generates a local path



