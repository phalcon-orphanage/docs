Class **Phalcon_Cache_Frontend_Data**
=====================================

Allows to cache native PHP data in a serialized form

Methods
---------

**__construct** (array $frontendOptions)

Phalcon_Cache_Frontend_Data constructor

**integer** **getLifetime** ()

Returns cache lifetime

**isBuffering** ()

Check whether if frontend is buffering output

**start** ()

Starts output frontend. Actually, does nothing

**string** **getContent** ()

Returns output cached content

**stop** ()

Stops output frontend

**beforeStore** (mixed $data)

Serializes data before storing it

**afterRetrieve** (mixed $data)

Unserializes data after retrieving it

