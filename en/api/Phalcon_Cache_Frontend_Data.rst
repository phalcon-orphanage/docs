Class **Phalcon\\Cache\\Frontend\\Data**
========================================

Allows to cache native PHP data in a serialized form


Methods
---------

public **__construct** (*array* $frontendOptions)

Phalcon\\Cache\\Frontend\\Data constructor



*integer* public **getLifetime** ()

Returns cache lifetime



public **isBuffering** ()

Check whether if frontend is buffering output



public **start** ()

Starts output frontend. Actually, does nothing



*string* public **getContent** ()

Returns output cached content



public **stop** ()

Stops output frontend



public **beforeStore** (*mixed* $data)

Serializes data before storing it



public **afterRetrieve** (*mixed* $data)

Unserializes data after retrieving it



