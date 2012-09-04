Class **Phalcon\\Cache\\Backend\\Apc**
======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Methods
---------

*mixed* public **get** (*string* $keyName, *long* $lifetime)

Returns a cached content



public **save** (*string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



*boolean* public **delete** (*string* $keyName)

Deletes a value from the cache by its key



*array* public **queryKeys** (*string* $prefix)

Query the existing cached keys



public **__construct** (*unknown* $frontendObject, *unknown* $backendOptions)

public **start** (*unknown* $keyName)

public **getFrontend** ()

public **isFresh** ()

public **isStarted** ()

public **getLastKey** ()

