Class **Phalcon\\Cache\\Frontend\\Output**
==========================================

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Methods
---------

public  **__construct** ([*array* $frontendOptions])

Phalcon\\Cache\\Frontend\\Output constructor



public *integer*  **getLifetime** ()

Returns cache lifetime



public *boolean*  **isBuffering** ()

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



