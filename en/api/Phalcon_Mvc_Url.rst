Class **Phalcon\\Mvc\\Url**
===========================

*implements* :doc:`Phalcon\\Mvc\\UrlInterface <Phalcon_Mvc_UrlInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/url.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This components helps in the generation of: URIs, URLs and Paths  

.. code-block:: php

    <?php

     //Generate a URL appending the URI to the base URI
     echo $url->get('products/edit/1');
    
     //Generate a URL for a predefined route
     echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2012'));



Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **setBaseUri** (*unknown* $baseUri)

Sets a prefix for all the URIs to be generated 

.. code-block:: php

    <?php

    $url->setBaseUri('/invo/');
    $url->setBaseUri('/invo/index.php/');




public  **setStaticBaseUri** (*unknown* $staticBaseUri)

Sets a prefix for all static URLs generated 

.. code-block:: php

    <?php

    $url->setStaticBaseUri('/invo/');




public  **getBaseUri** ()

Returns the prefix for all the generated urls. By default /



public  **getStaticBaseUri** ()

Returns the prefix for all the generated static urls. By default /



public  **setBasePath** (*unknown* $basePath)

Sets a base path for all the generated paths 

.. code-block:: php

    <?php

    $url->setBasePath('/var/www/htdocs/');




public  **getBasePath** ()

Returns the base path



public  **get** ([*unknown* $uri], [*unknown* $args], [*unknown* $local], [*unknown* $baseUri])

Generates a URL 

.. code-block:: php

    <?php

     //Generate a URL appending the URI to the base URI
     echo $url->get('products/edit/1');
    
     //Generate a URL for a predefined route
     echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2015'));




public  **getStatic** ([*unknown* $uri])

Generates a URL for a static resource 

.. code-block:: php

    <?php

     // Generate a URL for a static resource
     echo $url->getStatic("img/logo.png");
    
     // Generate a URL for a static predefined route
     echo $url->getStatic(array('for' => 'logo-cdn'));




public  **path** ([*unknown* $path])

Generates a local path



