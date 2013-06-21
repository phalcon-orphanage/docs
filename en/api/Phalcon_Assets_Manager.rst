Class **Phalcon\\Assets\\Manager**
==================================

Manages collections of CSS/Javascript assets


Methods
---------

public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **useImplicitOutput** (*boolean* $implicitOutput)

Sets if the HTML generated must be directly printed or returned



public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addCss** (*string* $path, [*boolean* $local])

Adds a Css resource to the 'css' collection 

.. code-block:: php

    <?php

    $assets->addCss('css/bootstrap.css');
    $assets->addCss('http://bootstrap.my-cdn.com/style.css', false);




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addJs** (*string* $path, [*boolean* $local])

Adds a javascript resource to the 'js' collection 

.. code-block:: php

    <?php

    $assets->addJs('scripts/jquery.js');
    $assets->addJs('http://jquery.my-cdn.com/jquery.js', true);




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addResourceByType** (*string* $type, :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>` $resource)

Adds a resource by its type 

.. code-block:: php

    <?php

    $assets->addResourceByType('css', new Phalcon\Assets\Resource\Css('css/style.css'));




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **addResource** (:doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>` $resource)

Adds a raw resource to the manager 

.. code-block:: php

    <?php

     $assets->addResource(new Phalcon\Assets\Resource('css', 'css/style.css'));




public :doc:`Phalcon\\Assets\\Manager <Phalcon_Assets_Manager>`  **set** (*string* $id, :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>` $collection)

Sets a collection in the Assets Manager 

.. code-block:: php

    <?php

     $assets->get('js', $collection);




public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **get** (*string* $id)

Returns a collection by its id 

.. code-block:: php

    <?php

     $scripts = $assets->get('js');




public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **getCss** ()

Returns the CSS collection of assets



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **getJs** ()

Returns the CSS collection of assets



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **collection** (*string* $name)

Creates/Returns a collection of resources



public  **outputCss** ([*string* $collectionName])

Prints the HTML for CSS resources



public  **outputJs** ([*string* $collectionName])

Prints the HTML for JS resources



