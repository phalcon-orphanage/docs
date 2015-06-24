Class **Phalcon\\Assets\\Resource**
===================================

Represents an asset resource  

.. code-block:: php

    <?php

     $resource = new \Phalcon\Assets\Resource('js', 'javascripts/jquery.js');



Methods
-------

public  **getType** ()

...


public  **getPath** ()

...


public  **getLocal** ()

...


public  **getFilter** ()

...


public  **getAttributes** ()

...


public  **getSourcePath** ()

...


public  **getTargetPath** ()

...


public  **getTargetUri** ()

...


public  **__construct** (*unknown* $type, *unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])

Phalcon\\Assets\\Resource constructor



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setType** (*unknown* $type)

Sets the resource's type



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setPath** (*unknown* $path)

Sets the resource's path



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setLocal** (*unknown* $local)

Sets if the resource is local or external



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setFilter** (*unknown* $filter)

Sets if the resource must be filtered or not



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setAttributes** (*unknown* $attributes)

Sets extra HTML attributes



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetUri** (*unknown* $targetUri)

Sets a target uri for the generated HTML



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setSourcePath** (*unknown* $sourcePath)

Sets the resource's source path



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **setTargetPath** (*unknown* $targetPath)

Sets the resource's target path



public *string*  **getContent** ([*unknown* $basePath])

Returns the content of the resource as an string Optionally a base path where the resource is located can be set



public *string*  **getRealTargetUri** ()

Returns the real target uri for the generated HTML



public *string*  **getRealSourcePath** ([*unknown* $basePath])

Returns the complete location where the resource is located



public *string*  **getRealTargetPath** ([*unknown* $basePath])

Returns the complete location where the resource must be written



