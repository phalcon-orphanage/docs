Class **Phalcon\\Assets\\Collection**
=====================================

*implements* Countable, Iterator, Traversable

Represents a collection of resources


Methods
---------

public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **add** (:doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>` $resource)

Adds a resource to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addCss** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Adds a CSS resource to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Adds a javascript resource to the collection



public :doc:`Phalcon\\Assets\\Resource <Phalcon_Assets_Resource>` [] **getResources** ()

Returns the resources as an array



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



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setName** (*string* $name)

Sets the name of the file for the filtered/join output



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setPrefix** (*string* $prefix)

Sets a common prefix for all the resources



public *string*  **getPrefix** ()

Returns the prefix



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setLocal** (*boolean* $local)

Sets if the collection uses local resources by default



public *boolean*  **getLocal** ()

Returns if the collection uses local resources by default



public *$this*  **setAttributes** (*array* $attributes)

Sets extra HTML attributes



public *array*  **getAttributes** ()

Returns extra HTML attributes



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **addFilter** (*Phalcon\\Assets\\FilterInterface* $filter)

Adds a filter to the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **setFilters** (*array* $filters)

Sets an array of filters in the collection



public *array*  **getFilters** ()

Returns the filters set in the collection



public :doc:`Phalcon\\Assets\\Collection <Phalcon_Assets_Collection>`  **join** (*boolean* $join)

Sets if all filtered resources in the collection must be joined in a single result file



