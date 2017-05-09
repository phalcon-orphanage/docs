# Class **Phalcon\\Cache\\Frontend\\Json**

*implements* [Phalcon\Cache\FrontendInterface](/en/3.1.2/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/json.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache data converting/deconverting them to JSON.

This adapter uses the json_encode/json_decode PHP's functions

As the data is encoded in JSON other systems accessing the same backend could
process them

```php
<?php

<?php

// Cache the data for 2 days
$frontCache = new \Phalcon\Cache\Frontend\Json(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```


## Methods
public  **__construct** ([*array* $frontendOptions])

Phalcon\\Cache\\Frontend\\Base64 constructor



public  **getLifetime** ()

Returns the cache lifetime



public  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend. Actually, does nothing



public *string* **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*mixed* $data)

Serializes data before storing them



public  **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval



