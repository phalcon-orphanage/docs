Class **Phalcon\\Assets\\Resource\\Css**
========================================

*extends* class :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Represents CSS resources


Methods
-------

public  **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])





public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setType** (*string* $type) inherited from Phalcon\\Assets\\Resource

Sets the resource's type



public *string*  **getType** () inherited from Phalcon\\Assets\\Resource

Returns the type of resource



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setPath** (*string* $path) inherited from Phalcon\\Assets\\Resource

Sets the resource's path



public *string*  **getPath** () inherited from Phalcon\\Assets\\Resource

Returns the URI/URL path to the resource



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setLocal** (*boolean* $local) inherited from Phalcon\\Assets\\Resource

Sets if the resource is local or external



public *boolean*  **getLocal** () inherited from Phalcon\\Assets\\Resource

Returns whether the resource is local or external



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setFilter** (*boolean* $filter) inherited from Phalcon\\Assets\\Resource

Sets if the resource must be filtered or not



public *boolean*  **getFilter** () inherited from Phalcon\\Assets\\Resource

Returns whether the resource must be filtered or not



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setAttributes** (*array* $attributes) inherited from Phalcon\\Assets\\Resource

Sets extra HTML attributes



public *array*  **getAttributes** () inherited from Phalcon\\Assets\\Resource

Returns extra HTML attributes set in the resource



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetUri** (*string* $targetUri) inherited from Phalcon\\Assets\\Resource

Sets a target uri for the generated HTML



public *string*  **getTargetUri** () inherited from Phalcon\\Assets\\Resource

Returns the target uri for the generated HTML



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setSourcePath** (*string* $sourcePath) inherited from Phalcon\\Assets\\Resource

Sets the resource's source path



public *string*  **getSourcePath** () inherited from Phalcon\\Assets\\Resource

Returns the resource's target path



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetPath** (*string* $targetPath) inherited from Phalcon\\Assets\\Resource

Sets the resource's target path



public *string*  **getTargetPath** () inherited from Phalcon\\Assets\\Resource

Returns the resource's target path



public *string*  **getContent** ([*string* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the content of the resource as an string Optionally a base path where the resource is located can be set



public *string*  **getRealTargetUri** () inherited from Phalcon\\Assets\\Resource

Returns the real target uri for the generated HTML



public *string*  **getRealSourcePath** ([*string* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the complete location where the resource is located



public *string*  **getRealTargetPath** ([*string* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the complete location where the resource must be written



