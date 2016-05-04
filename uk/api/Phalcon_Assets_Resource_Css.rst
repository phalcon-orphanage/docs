Class **Phalcon\\Assets\\Resource\\Css**
========================================

*extends* class :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/resource/css.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Represents CSS resources


Methods
-------

public  **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])





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


public  **setType** (*unknown* $type) inherited from Phalcon\\Assets\\Resource

Sets the resource's type



public  **setPath** (*unknown* $path) inherited from Phalcon\\Assets\\Resource

Sets the resource's path



public  **setLocal** (*unknown* $local) inherited from Phalcon\\Assets\\Resource

Sets if the resource is local or external



public  **setFilter** (*unknown* $filter) inherited from Phalcon\\Assets\\Resource

Sets if the resource must be filtered or not



public  **setAttributes** (*array* $attributes) inherited from Phalcon\\Assets\\Resource

Sets extra HTML attributes



public  **setTargetUri** (*unknown* $targetUri) inherited from Phalcon\\Assets\\Resource

Sets a target uri for the generated HTML



public  **setSourcePath** (*unknown* $sourcePath) inherited from Phalcon\\Assets\\Resource

Sets the resource's source path



public  **setTargetPath** (*unknown* $targetPath) inherited from Phalcon\\Assets\\Resource

Sets the resource's target path



public  **getContent** ([*unknown* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the content of the resource as an string Optionally a base path where the resource is located can be set



public  **getRealTargetUri** () inherited from Phalcon\\Assets\\Resource

Returns the real target uri for the generated HTML



public  **getRealSourcePath** ([*unknown* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the complete location where the resource is located



public  **getRealTargetPath** ([*unknown* $basePath]) inherited from Phalcon\\Assets\\Resource

Returns the complete location where the resource must be written



