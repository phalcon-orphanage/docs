Class **Phalcon\\Assets\\Collection**
=====================================

*implements* Countable, Iterator, Traversable

Methods
-------

public  **getPrefix** ()

...


public  **getLocal** ()

...


public  **getResources** ()

...


public  **getCodes** ()

...


public  **getPosition** ()

...


public  **getFilters** ()

...


public  **getAttributes** ()

...


public  **getJoin** ()

...


public  **getTargetUri** ()

...


public  **getTargetPath** ()

...


public  **getTargetLocal** ()

...


public  **getSourcePath** ()

...


public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **add** (*unknown* $resource)

Adds a resource to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addInline** (*unknown* $code)

Adds a inline code to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addCss** (*unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])

Adds a CSS resource to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addInlineCss** (*unknown* $content, [*unknown* $filter], [*unknown* $attributes])

Adds a inline CSS to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addJs** (*unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])

Adds a javascript resource to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addInlineJs** (*unknown* $content, [*unknown* $filter], [*unknown* $attributes])

Adds a inline javascript to the collection



public *int*  **count** ()

Returns the number of elements in the form



public  **rewind** ()

Rewinds the internal iterator



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>`  **current** ()

Returns the current resource in the iterator



public *int*  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public *boolean*  **valid** ()

Check if the current element in the iterator is valid



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setTargetPath** (*string* $targetPath)

Sets the target path of the file for the filtered/join output



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setSourcePath** (*string* $sourcePath)

Sets a base source path for all the resources in this collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setTargetUri** (*string* $targetUri)

Sets a target uri for the generated HTML



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setPrefix** (*string* $prefix)

Sets a common prefix for all the resources



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setLocal** (*boolean* $local)

Sets if the collection uses local resources by default



public *$this*  **setAttributes** (*array* $attributes)

Sets extra HTML attributes



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setFilters** (*array* $filters)

Sets an array of filters in the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setTargetLocal** (*boolean* $targetLocal)

Sets the target local



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **join** (*unknown* $join)

Sets if all filtered resources in the collection must be joined in a single result file



public *string*  **getRealTargetPath** (*unknown* $basePath)

Returns the complete location where the joined/filtered collection must be written



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addFilter** (*unknown* $filter)

Adds a filter to the collection



public  **__construct** ()

...


