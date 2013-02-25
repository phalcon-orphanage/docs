Class **Phalcon\\Cache\\Multiple**
==================================

Allows to read to chained backends writing to multiple backends


Methods
---------

public  **__construct** ([*Phalcon\\Cache\\BackendInterface[]* $backends])

Phalcon\\Cache\\Multiple constructor



public :doc:`Phalcon\\Cache\\Multiple <Phalcon_Cache_Multiple>`  **push** (*Phalcon\\Cache\\BackendInterface* $backend)

Adds a backend



public *mixed*  **get** (*string* $keyName, [*long* $lifetime])

Returns a cached content reading the internal backends



public *mixed*  **start** (*int|string* $keyName, [*long* $lifetime])

Starts every backend



public  **save** ([*string* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the APC backend and stops the frontend



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from each backend



public *boolean*  **exists** ([*string* $keyName], [*long* $lifetime])

Checks if cache exists in at least one backend



