Class **Phalcon_Cache_Frontend_Data**
=====================================

Allows to cache native PHP data in a serialized form

Methods
---------

**__construct** (array $frontendOptions)

Phalcon_Cache_Frontend_Data constructor

**integer** **getLifetime** ()

Returns the cache lifetime

**isBuffering** ()

Check whether the frontend is buffering output

**start** ()

Starts output frontend.

**string** **getContent** ()

Returns the output cached content

**stop** ()

Stops the output frontend

**beforeStore** (mixed $data)

Serializes data before storing it

**afterRetrieve** (mixed $data)

Unserializes data after retrieving it

