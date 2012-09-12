Class **Phalcon\\Cache\\Frontend\\Output**
==========================================

Allows to cache output fragments captured with ob_* functions


Methods
---------

public  **__construct** (*array* $frontendOptions)

Phalcon\\Cache\\Frontend\\Output constructor



public *integer*  **getLifetime** ()

Returns cache lifetime



public  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend



public *string*  **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*mixed* $data)

Prepare data to be stored



public  **afterRetrieve** (*mixed* $data)

Prepares data to be retrieved to user



