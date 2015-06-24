Abstract class **Phalcon\\Cache\\Backend**
==========================================

This class implements common functionality for backend adapters. A backend cache adapter may extend this class


Methods
-------

public  **getFrontend** ()

...


public  **setFrontend** (*unknown* $frontend)

...


public  **getOptions** ()

...


public  **setOptions** (*unknown* $options)

...


public  **getLastKey** ()

...


public  **setLastKey** (*unknown* $lastKey)

...


public  **__construct** (*unknown* $frontend, [*unknown* $options])

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*unknown* $keyName, [*unknown* $lifetime])

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*unknown* $stopBuffer])

Stops the frontend without store any cached content



public *boolean*  **isFresh** ()

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** ()

Checks whether the cache has starting buffering or not



public *int*  **getLifetime** ()

Gets the last lifetime set



