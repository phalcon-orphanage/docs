Class **Phalcon\\Cache\\Frontend\\None**
========================================

Discards any kind of frontend data input. This frontend does not have expiration time or any other options


Methods
---------

public **__construct** (*unknown* $frontendOptions)

Phalcon\\Cache\\Frontend\\None constructor



public **getLifetime** ()

Returns cache lifetime, always one second expiring content



public **isBuffering** ()

Check whether if frontend is buffering output, always false



public **start** ()

Starts output frontend



*string* public **getContent** ()

Returns output cached content



public **stop** ()

Stops output frontend



public **beforeStore** (*mixed* $data)

Prepare data to be stored



public **afterRetrieve** (*mixed* $data)

Prepares data to be retrieved to user



