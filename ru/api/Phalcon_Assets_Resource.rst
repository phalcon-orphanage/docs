Class **Phalcon\\Assets\\Resource**
===================================

Represents an asset resource  

.. code-block:: php

    <?php

     $resource = new Phalcon\Assets\Resource('js', 'javascripts/jquery.js');



Methods
-------

public  **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\\Assets\\Resource constructor



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setType** (*string* $type)

Sets the resource's type



public *string*  **getType** ()

Returns the type of resource



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setPath** (*string* $path)

Sets the resource's path



public *string*  **getPath** ()

Returns the URI/URL path to the resource



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setLocal** (*boolean* $local)

Sets if the resource is local or external



public *boolean*  **getLocal** ()

Returns whether the resource is local or external



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setFilter** (*boolean* $filter)

Sets if the resource must be filtered or not



public *boolean*  **getFilter** ()

Returns whether the resource must be filtered or not



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setAttributes** (*array* $attributes)

Sets extra HTML attributes



public *array*  **getAttributes** ()

Returns extra HTML attributes set in the resource



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetUri** (*string* $targetUri)

Sets a target uri for the generated HTML



public *string*  **getTargetUri** ()

Returns the target uri for the generated HTML



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setSourcePath** (*string* $sourcePath)

Sets the resource's source path



public *string*  **getSourcePath** ()

Returns the resource's target path



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetPath** (*string* $targetPath)

Sets the resource's target path



public *string*  **getTargetPath** ()

Returns the resource's target path



public *string*  **getContent** ([*string* $basePath])

Returns the content of the resource as an string Optionally a base path where the resource is located can be set



public *string*  **getRealTargetUri** ()

Returns the real target uri for the generated HTML



public *string*  **getRealSourcePath** ([*string* $basePath])

Returns the complete location where the resource is located



public *string*  **getRealTargetPath** ([*string* $basePath])

Returns the complete location where the resource must be written



