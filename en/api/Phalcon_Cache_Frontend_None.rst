Class **Phalcon_Cache_Frontend_None**
=====================================

Discards any kind of frontend data input. This frontend does not have expiration time or any other options

Methods
---------

**__construct** (unknown $frontendOptions)

Phalcon_Cache_Frontend_None constructor

**getLifetime** ()

Returns cache lifetime, always one second expiring content

**isBuffering** ()

Check whether if frontend is buffering output, always false

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

