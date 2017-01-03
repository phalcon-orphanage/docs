Class **Phalcon\\Assets\\Collection**
=====================================

*implements* `Countable <http://php.net/manual/en/class.countable.php>`_, `Iterator <http://php.net/manual/en/class.iterator.php>`_, `Traversable <http://php.net/manual/en/class.traversable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/collection.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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


public  **add** (:doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>` $resource)

Adds a resource to the collection



public  **addInline** (:doc:`Phalcon\\Assets\\Inline <Phalcon_Assets_Inline>` $code)

Adds an inline code to the collection



public  **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Adds a CSS resource to the collection



public  **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline CSS to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>` **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Adds a javascript resource to the collection



public  **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline javascript to the collection



public  **count** ()

Returns the number of elements in the form



public  **rewind** ()

Rewinds the internal iterator



public  **current** ()

Returns the current resource in the iterator



public *int* **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public  **valid** ()

Check if the current element in the iterator is valid



public  **setTargetPath** (*mixed* $targetPath)

Sets the target path of the file for the filtered/join output



public  **setSourcePath** (*mixed* $sourcePath)

Sets a base source path for all the resources in this collection



public  **setTargetUri** (*mixed* $targetUri)

Sets a target uri for the generated HTML



public  **setPrefix** (*mixed* $prefix)

Sets a common prefix for all the resources



public  **setLocal** (*mixed* $local)

Sets if the collection uses local resources by default



public  **setAttributes** (*array* $attributes)

Sets extra HTML attributes



public  **setFilters** (*array* $filters)

Sets an array of filters in the collection



public  **setTargetLocal** (*mixed* $targetLocal)

Sets the target local



public  **join** (*mixed* $join)

Sets if all filtered resources in the collection must be joined in a single result file



public  **getRealTargetPath** (*mixed* $basePath)

Returns the complete location where the joined/filtered collection must be written



public  **addFilter** (:doc:`Phalcon\\Assets\\FilterInterface <Phalcon_Assets_FilterInterface>` $filter)

Adds a filter to the collection



