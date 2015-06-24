Class **Phalcon\\Assets\\Resource\\Css**
========================================

*extends* class :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Represents CSS resources


Methods
-------

public  **__construct** (*unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])





public  **getType** () inherited from Phalcon\\Assets\\Resource

...


public  **getPath** () inherited from Phalcon\\Assets\\Resource

...


public  **getLocal** () inherited from Phalcon\\Assets\\Resource

...


public  **getFilter** () inherited from Phalcon\\Assets\\Resource

...


public  **getAttributes** () inherited from Phalcon\\Assets\\Resource

...


public  **getSourcePath** () inherited from Phalcon\\Assets\\Resource

...


public  **getTargetPath** () inherited from Phalcon\\Assets\\Resource

...


public  **getTargetUri** () inherited from Phalcon\\Assets\\Resource

...


public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setType** (*unknown* $type) inherited from Phalcon\\Assets\\Resource

Sets the resource's type



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setPath** (*unknown* $path) inherited from Phalcon\\Assets\\Resource

Sets the resource's path



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setLocal** (*unknown* $local) inherited from Phalcon\\Assets\\Resource

Sets if the resource is local or external



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setFilter** (*unknown* $filter) inherited from Phalcon\\Assets\\Resource

Sets if the resource must be filtered or not



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setAttributes** (*unknown* $attributes) inherited from Phalcon\\Assets\\Resource

Sets extra HTML attributes



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetUri** (*unknown* $targetUri) inherited from Phalcon\\Assets\\Resource

Sets a target uri for the generated HTML



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setSourcePath** (*unknown* $sourcePath) inherited from Phalcon\\Assets\\Resource

Sets the resource's source path



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetPath** (*unknown* $targetPath) inherited from Phalcon\\Assets\\Resource

Sets the resource's target path



public *string*  **getContent** ([*unknown* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the content of the resource as an string Optionally a base path where the resource is located can be set



public *string*  **getRealTargetUri** () inherited from Phalcon\\Assets\\Resource

Returns the real target uri for the generated HTML



public *string*  **getRealSourcePath** ([*unknown* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the complete location where the resource is located



public *string*  **getRealTargetPath** ([*unknown* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the complete location where the resource must be written



