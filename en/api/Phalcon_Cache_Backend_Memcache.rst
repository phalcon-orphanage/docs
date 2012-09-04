Class **Phalcon\Cache\Backend\Memcache**
========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Methods
---------

public **__construct** (*unknown* $frontendObject, *unknown* $backendOptions)

protected **_connect** ()

public **get** (*unknown* $keyName, *unknown* $lifetime)

public **save** (*unknown* $keyName, *unknown* $content, *unknown* $lifetime, *unknown* $stopBuffer)

public **delete** (*unknown* $keyName)

public **queryKeys** (*unknown* $prefix)

public **__destruct** ()

public **start** (*unknown* $keyName)

public **getFrontend** ()

public **isFresh** ()

public **isStarted** ()

public **getLastKey** ()

