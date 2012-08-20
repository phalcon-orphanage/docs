Class **Phalcon_Cache_Frontend_None**
=====================================

Discards any kind of frontend data input. This frontend does not have expiration time or any other options.

Methods
---------

**__construct** (unknown $frontendOptions)

Phalcon_Cache_Frontend_None constructor

**getLifetime** ()

Returns cache lifetime, always one second expiring content.

**isBuffering** ()

Check whether if frontend is buffering output, always false.

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

