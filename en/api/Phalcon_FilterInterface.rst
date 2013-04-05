Interface **Phalcon\\FilterInterface**
======================================

Methods
---------

abstract public :doc:`Phalcon\\FilterInterface <Phalcon_FilterInterface>`  **add** (*string* $name, *callable* $handler)

Adds a user-defined filter



abstract public *mixed*  **sanitize** (*mixed* $value, *mixed* $filters)

Sanizites a value with a specified single or set of filters



abstract public *object[]*  **getFilters** ()

Return the user-defined filters in the instance



