Abstract class **Phalcon\\Cache\\Backend**
==========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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


public  **__construct** (:doc:`\\Phalcon\\Cache\\FrontendInterface <_Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options])

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName, [*int* $lifetime])

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*unknown* $stopBuffer])

Stops the frontend without store any cached content



public  **isFresh** ()

Checks whether the last cache is fresh or cached



public  **isStarted** ()

Checks whether the cache has starting buffering or not



public *int*  **getLifetime** ()

Gets the last lifetime set



