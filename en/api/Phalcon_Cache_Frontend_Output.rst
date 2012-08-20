Class **Phalcon_Cache_Frontend_Output**
=======================================

Allows to cache output fragments captured with ob_* functions

Methods
---------

**__construct** (array $frontendOptions)

Phalcon_Cache_Frontend_Output constructor

**integer** **getLifetime** ()

Returns the cache lifetime

**isBuffering** ()

Checks whether the frontend is buffering output

**start** ()

Starts the output frontend

**string** **getContent** ()

Returns the output cached content

**stop** ()

Stops the output frontend

**beforeStore** (mixed $data)

Prepares data to be stored

**afterRetrieve** (mixed $data)

Prepares data to be retrieved to user

