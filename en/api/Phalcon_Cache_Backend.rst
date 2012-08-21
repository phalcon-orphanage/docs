Class **Phalcon_Cache_Backend**
===============================

This class implements common functionality for backend adapters. All the backend cache adapters must extend this class.

Methods
---------

**__construct** (mixed $frontendObject, array $backendOptions)

Phalcon_Cache_Backend constructor

**mixed** **start** (int|string $keyName)

Starts a cache. The $keyname allow to identify the created fragment

**mixed** **getFrontend** ()

Returns front-end instance adapter related to the back-end

**boolean** **isFresh** ()

Checks whether the last cache is fresh or cached

**boolean** **isStarted** ()

Checks whether the cache has started buffering or not

**string** **getLastKey** ()

Gets the last key stored by the cache

