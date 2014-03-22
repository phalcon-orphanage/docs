Interface **Phalcon\\Cache\\FrontendInterface**
===============================================

Phalcon\\Cache\\FrontendInterface initializer


Methods
-------

abstract public *int*  **getLifetime** ()

Returns the cache lifetime



abstract public *boolean*  **isBuffering** ()

Check whether if frontend is buffering output



abstract public  **start** ()

Starts the frontend



abstract public *string*  **getContent** ()

Returns output cached content



abstract public  **stop** ()

Stops the frontend



abstract public  **beforeStore** (*mixed* $data)

Serializes data before storing it



abstract public  **afterRetrieve** (*mixed* $data)

Unserializes data after retrieving it



