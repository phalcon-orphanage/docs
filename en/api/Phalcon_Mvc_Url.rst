Class **Phalcon\\Mvc\\Url**
===========================

*implements* :doc:`Phalcon\\Mvc\\UrlInterface <Phalcon_Mvc_UrlInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This components aids in the generation of: URIs, URLs and Paths  

.. code-block:: php

    <?php

     //Generate a url appending a uri to the base Uri
     echo $url->get('products/edit/1');
    
     //Generate a url for a predefined route
     echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2012'));



Methods
---------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setBaseUri** (*string* $baseUri)

Sets a prefix to all the urls generated 

.. code-block:: php

    <?php

    $url->setBaseUri('/invo/');




public *string*  **getBaseUri** ()

Returns the prefix for all the generated urls. By default /



public  **setBasePath** (*string* $basePath)

Sets a base paths for all the generated paths 

.. code-block:: php

    <?php

    $url->setBasePath('/var/www/');




public *string*  **getBasePath** ()

Returns a base path



public *string*  **get** ([*string|array* $uri])

Generates a URL



public *string*  **path** ([*string* $path])

Generates a local path



