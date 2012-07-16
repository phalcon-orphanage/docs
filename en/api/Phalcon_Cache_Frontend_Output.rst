Class **Phalcon_Cache_Frontend_Output**
=======================================

Allows to cache output fragments captured with ob_* functions

Methods
---------

**__construct** (array $frontendOptions)

Phalcon_Cache_Frontend_Output constructor

**integer** **getLifetime** ()

Returns cache lifetime

**isBuffering** ()

Check whether if frontend is buffering output

**start** ()

Starts output frontend

**string** **getContent** ()

Returns output cached content

**stop** ()

Stops output frontend

**beforeStore** (mixed $data)

Prepare data to be stored

**afterRetrieve** (mixed $data)

Prepares data to be retrieved to user

