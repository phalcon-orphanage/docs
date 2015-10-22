Interface **Phalcon\\Cache\\BackendInterface**
==============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backendinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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


