# Phalcon sınıfı\\Önbellek\\Başlangıç aşaması\\çıktı</strong>

*implements* [Phalcon\Cache\FrontendInterface](/en/3.2/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/output.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache output fragments captured with ob_* functions

```php <?php

* * use Phalcon\Tag; * use Phalcon\Cache\Backend\File; * use Phalcon\Cache\Frontend\Output; * * // Create an Output frontend. Cache the files for 2 days * $frontCache = new Output( * [ * "lifetime" => 172800, * ] * ); * * // Create the component that will cache from the "Output" to a "File" backend * // Set the cache file directory - it's important to keep the "/" at the end of * // the value for the folder * $cache = new File( * $frontCache, * [ * "cacheDir" => "../app/cache/", * ] * ); * * // Get/Set the cache file to ../app/cache/my-cache.html * $content = $cache->start("my-cache.html"); * * // If $content is null then the content will be generated for the cache * if (null === $content) { * // Print date and time * echo date("r"); * * // Generate a link to the sign-up action * echo Tag::linkTo( * [ * "user/signup", * "Sign Up", * "class" => "signup-button", * ] * ); * * // Store the output into the cache file * $cache->save(); * } else { * // Echo the cached output * echo $content; * }

*```

## Methods

public **__construct** ([*array* $frontendOptions])

Phalcon\\Önbellek\\Başlangıç aşaması\\çıktı üreticisi

public **getLifetime** ()

Önbellek ömrünü çevirir

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Currently, does nothing

public *string* **getContent** ()

Returns output cached content

public **stop** ()

Stops output frontend

public **beforeStore** (*mixed* $data)

Verileri saklamadan önce seri hale getirir

public **afterRetrieve** (*mixed* $data)

Alınan verileri sonradan sırayı bozar