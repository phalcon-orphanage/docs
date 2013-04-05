Class **Phalcon\\Mvc\\Url**
===========================

*implements* :doc:`Phalcon\\Mvc\\UrlInterface <Phalcon_Mvc_UrlInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

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



