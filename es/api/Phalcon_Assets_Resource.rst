Class **Phalcon\\Assets\\Resource**
===================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/resource.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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


public  **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\\Assets\\Resource constructor



public  **setType** (*unknown* $type)

Sets the resource's type



public  **setPath** (*unknown* $path)

Sets the resource's path



public  **setLocal** (*unknown* $local)

Sets if the resource is local or external



public  **setFilter** (*unknown* $filter)

Sets if the resource must be filtered or not



public  **setAttributes** (*unknown* $attributes)

Sets extra HTML attributes



public  **setTargetUri** (*unknown* $targetUri)

Sets a target uri for the generated HTML



public  **setSourcePath** (*unknown* $sourcePath)

Sets the resource's source path



public  **setTargetPath** (*unknown* $targetPath)

Sets the resource's target path



public  **getContent** ([*unknown* $basePath])

Returns the content of the resource as an string Optionally a base path where the resource is located can be set



public  **getRealTargetUri** ()

Returns the real target uri for the generated HTML



public  **getRealSourcePath** ([*unknown* $basePath])

Returns the complete location where the resource is located



public  **getRealTargetPath** ([*unknown* $basePath])

Returns the complete location where the resource must be written



