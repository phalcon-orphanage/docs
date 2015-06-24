Class **Phalcon\\Assets\\Manager**
==================================

Manages collections of CSS/Javascript assets


Methods
-------

public  **__construct** ([*unknown* $options])





public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **setOptions** (*unknown* $options)

Sets the manager options



public *array*  **getOptions** ()

Returns the manager options



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **useImplicitOutput** (*unknown* $implicitOutput)

Sets if the HTML generated must be directly printed or returned



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addCss** (*unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])

Adds a Css resource to the 'css' collection 

.. code-block:: php

    <?php

    $assets->addCss('css/bootstrap.css');
    $assets->addCss('http://bootstrap.my-cdn.com/style.css', false);




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addInlineCss** (*unknown* $content, [*unknown* $filter], [*unknown* $attributes])

Adds a inline Css to the 'css' collection



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addJs** (*unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])

Adds a javascript resource to the 'js' collection 

.. code-block:: php

    <?php

    $assets->addJs('scripts/jquery.js');
           $assets->addJs('http://jquery.my-cdn.com/jquery.js', false);




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addInlineJs** (*unknown* $content, [*unknown* $filter], [*unknown* $attributes])

Adds a inline javascript to the 'js' collection



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addResourceByType** (*unknown* $type, *unknown* $resource)

Adds a resource by its type 

.. code-block:: php

    <?php

    $assets->addResourceByType('css', new \Phalcon\Assets\Resource\Css('css/style.css'));




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addInlineCodeByType** (*unknown* $type, *unknown* $code)

Adds a inline code by its type



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addResource** (:doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>` $resource)

Adds a raw resource to the manager 

.. code-block:: php

    <?php

     $assets->addResource(new Phalcon\Assets\Resource('css', 'css/style.css'));




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addInlineCode** (*unknown* $code)

Adds a raw inline code to the manager



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **set** (*unknown* $id, *unknown* $collection)

Sets a collection in the Assets Manager 

.. code-block:: php

    <?php

     $assets->set('js', $collection);




public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **get** (*unknown* $id)

Returns a collection by its id 

.. code-block:: php

    <?php

     $scripts = $assets->get('js');




public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **getCss** ()

Returns the CSS collection of assets



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **getJs** ()

Returns the CSS collection of assets



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **collection** (*unknown* $name)

Creates/Returns a collection of resources



public  **output** (*unknown* $collection, *unknown* $callback, *unknown* $type)

Traverses a collection calling the callback to generate its HTML



public  **outputInline** (*unknown* $collection, *unknown* $type)

Traverses a collection and generate its HTML



public  **outputCss** ([*unknown* $collectionName])

Prints the HTML for CSS resources



public  **outputInlineCss** ([*unknown* $collectionName])

Prints the HTML for inline CSS



public  **outputJs** ([*unknown* $collectionName])

Prints the HTML for JS resources



public  **outputInlineJs** ([*unknown* $collectionName])

Prints the HTML for inline JS



