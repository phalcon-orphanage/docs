Class **Phalcon\\DI\\Service**
==============================

Phalcon\\DI  Represents a service in the services container


Methods
---------

public  **__construct** (*string* $name, *mixed* $definition, *boolean* $shared)





public  **getName** ()

Returns the service's name



public  **setShared** (*boolean* $shared)

Sets if the service is shared or not



public *boolean*  **getShared** ()

Check whether the service is shared or not



public  **setDefinition** (*mixed* $definition)

Set the service definition



public *mixed*  **getDefinition** ()

Returns the service definition



public *mixed*  **resolve** (*unknown* $parameters)

Resolves the service



public static *Phalcon_DI_Service*  **__set_state** (*array* $attributes)

Restore the interal state of a service



