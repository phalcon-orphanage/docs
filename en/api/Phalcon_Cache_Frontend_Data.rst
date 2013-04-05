Class **Phalcon\\Cache\\Frontend\\Data**
========================================

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Methods
---------

public  **__construct** ([*array* $frontendOptions])

Phalcon\\Cache\\Frontend\\Data constructor



public *int*  **getLifetime** ()

Returns cache lifetime



public *boolean*  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend. Actually, does nothing



public *string*  **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*mixed* $data)

Serializes data before storing it



public  **afterRetrieve** (*mixed* $data)

Unserializes data after retrieving it



