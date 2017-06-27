# Abstract class **Phalcon\\Cache\\Backend**

*implements* [Phalcon\Cache\BackendInterface](/en/3.1.2/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class implements common functionality for backend adapters. A backend cache adapter may extend this class

## Methods

public **getFrontend** ()

...

public **setFrontend** (*mixed* $frontend)

...

public **getOptions** ()

...

public **setOptions** (*mixed* $options)

...

public **getLastKey** ()

...

public **setLastKey** (*mixed* $lastKey)

...

public **__construct** ([Phalcon\Cache\FrontendInterface](/en/3.1.2/api/Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\\Cache\\Backend constructor

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime])

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer])

Stops the frontend without store any cached content

public **isFresh** ()

Checks whether the last cache is fresh or cached

public **isStarted** ()

Checks whether the cache has starting buffering or not

public *int* **getLifetime** ()

Gets the last lifetime set

abstract public **get** (*mixed* $keyName, [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](/en/3.1.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **save** ([*mixed* $keyName], [*mixed* $content], [*mixed* $lifetime], [*mixed* $stopBuffer]) inherited from [Phalcon\Cache\BackendInterface](/en/3.1.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **delete** (*mixed* $keyName) inherited from [Phalcon\Cache\BackendInterface](/en/3.1.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **queryKeys** ([*mixed* $prefix]) inherited from [Phalcon\Cache\BackendInterface](/en/3.1.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **exists** ([*mixed* $keyName], [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](/en/3.1.2/api/Phalcon_Cache_BackendInterface)

...