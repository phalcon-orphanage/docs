Class **Phalcon\\Filter**
=========================

*implements* :doc:`Phalcon\\FilterInterface <Phalcon_FilterInterface>`

Methods
---------

public  **__construct** ()

Phalcon\\Filter constructor



public :doc:`Phalcon\\Filter <Phalcon_Filter>`  **add** (*string* $name, *callable* $handler)

Adds a user-defined filter



public *mixed*  **sanitize** (*mixed* $value, *mixed* $filters)

Sanitizes a value with a specified single or set of filters



protected *mixed*  **_sanitize** ()

Internal sanitize wrapper to filter_var



public *object[]*  **getFilters** ()

Return the user-defined filters in the instance



