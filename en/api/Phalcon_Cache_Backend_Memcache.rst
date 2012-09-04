Class **Phalcon\\Cache\\Backend\\Memcache**
===========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Methods
---------

public **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Backend\\Adapter\\Memcache constructor



protected **_connect** ()

Create internal connection to memcached



*mixed* public **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



*boolean* public **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



*array* public **queryKeys** (*string* $prefix)

Query the existing cached keys



public **__destruct** ()

Destructs the backend closing the memcached connection



public **start** (*unknown* $keyName)

public **getFrontend** ()

public **isFresh** ()

public **isStarted** ()

public **getLastKey** ()

