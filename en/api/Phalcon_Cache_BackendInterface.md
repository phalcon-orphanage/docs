# Interface **Phalcon\\Cache\\BackendInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backendinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **start** (*mixed* $keyName, [*mixed* $lifetime])

...

abstract public  **stop** ([*mixed* $stopBuffer])

...

abstract public  **getFrontend** ()

...

abstract public  **getOptions** ()

...

abstract public  **isFresh** ()

...

abstract public  **isStarted** ()

...

abstract public  **setLastKey** (*mixed* $lastKey)

...

abstract public  **getLastKey** ()

...

abstract public  **get** (*mixed* $keyName, [*mixed* $lifetime])

...

abstract public  **save** ([*mixed* $keyName], [*mixed* $content], [*mixed* $lifetime], [*mixed* $stopBuffer])

...

abstract public  **delete** (*mixed* $keyName)

...

abstract public  **queryKeys** ([*mixed* $prefix])

...

abstract public  **exists** ([*mixed* $keyName], [*mixed* $lifetime])

...

