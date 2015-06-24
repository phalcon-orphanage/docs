Interface **Phalcon\\Cache\\BackendInterface**
==============================================

Methods
-------

abstract public  **start** (*unknown* $keyName, [*unknown* $lifetime])

...


abstract public  **stop** ([*unknown* $stopBuffer])

...


abstract public  **getFrontend** ()

...


abstract public  **getOptions** ()

...


abstract public  **isFresh** ()

...


abstract public  **isStarted** ()

...


abstract public  **setLastKey** (*unknown* $lastKey)

...


abstract public  **getLastKey** ()

...


abstract public  **get** (*unknown* $keyName, [*unknown* $lifetime])

...


abstract public  **save** ([*unknown* $keyName], [*unknown* $content], [*unknown* $lifetime], [*unknown* $stopBuffer])

...


abstract public  **delete** (*unknown* $keyName)

...


abstract public  **queryKeys** ([*unknown* $prefix])

...


abstract public  **exists** ([*unknown* $keyName], [*unknown* $lifetime])

...


