Class **Phalcon\\Assets\\Collection**
=====================================

*implements* Countable, Iterator, Traversable

Represents a collection of resources


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


public  **add** (*unknown* $resource)

Adds a resource to the collection



public  **addInline** (*unknown* $code)

Adds a inline code to the collection



public  **addCss** (*unknown* $path, [*unknown* $local], [*unknown* $filter], [*unknown* $attributes])

Adds a CSS resource to the collection



public  **addInlineCss** (*unknown* $content, [*unknown* $filter], [*unknown* $attributes])

Adds a inline CSS to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Adds a javascript resource to the collection



public  **addInlineJs** (*unknown* $content, [*unknown* $filter], [*unknown* $attributes])

Adds a inline javascript to the collection



public  **count** ()

Returns the number of elements in the form



public  **rewind** ()

Rewinds the internal iterator



public  **current** ()

Returns the current resource in the iterator



public *int*  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public  **valid** ()

Check if the current element in the iterator is valid



public  **setTargetPath** (*unknown* $targetPath)

Sets the target path of the file for the filtered/join output



public  **setSourcePath** (*unknown* $sourcePath)

Sets a base source path for all the resources in this collection



public  **setTargetUri** (*unknown* $targetUri)

Sets a target uri for the generated HTML



public  **setPrefix** (*unknown* $prefix)

Sets a common prefix for all the resources



public  **setLocal** (*unknown* $local)

Sets if the collection uses local resources by default



public  **setAttributes** (*unknown* $attributes)

Sets extra HTML attributes



public  **setFilters** (*unknown* $filters)

Sets an array of filters in the collection



public  **setTargetLocal** (*unknown* $targetLocal)

Sets the target local



public  **join** (*unknown* $join)

Sets if all filtered resources in the collection must be joined in a single result file



public  **getRealTargetPath** (*unknown* $basePath)

Returns the complete location where the joined/filtered collection must be written



public  **addFilter** (*unknown* $filter)

Adds a filter to the collection



