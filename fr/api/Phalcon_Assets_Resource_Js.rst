Class **Phalcon\\Assets\\Resource\\Js**
=======================================

*extends* class :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/resource/js.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Represents Javascript resources


Methods
-------

public  **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])





public  **getType** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`





public  **getPath** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`





public  **getLocal** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`





public  **getFilter** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`





public  **getAttributes** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`





public  **getSourcePath** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

...


public  **getTargetPath** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

...


public  **getTargetUri** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

...


public  **setType** (*mixed* $type) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets the resource's type



public  **setPath** (*mixed* $path) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets the resource's path



public  **setLocal** (*mixed* $local) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets if the resource is local or external



public  **setFilter** (*mixed* $filter) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets if the resource must be filtered or not



public  **setAttributes** (*array* $attributes) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets extra HTML attributes



public  **setTargetUri** (*mixed* $targetUri) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets a target uri for the generated HTML



public  **setSourcePath** (*mixed* $sourcePath) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets the resource's source path



public  **setTargetPath** (*mixed* $targetPath) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Sets the resource's target path



public  **getContent** ([*mixed* $basePath]) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Returns the content of the resource as an string
Optionally a base path where the resource is located can be set



public  **getRealTargetUri** () inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Returns the real target uri for the generated HTML



public  **getRealSourcePath** ([*mixed* $basePath]) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Returns the complete location where the resource is located



public  **getRealTargetPath** ([*mixed* $basePath]) inherited from :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`

Returns the complete location where the resource must be written



