* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Frontend\Output'

* * *

# Class **Phalcon\Cache\Frontend\Output**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/output.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

Allows to cache output fragments captured with ob_* functions

```php <?php

* * use Phalcon\Tag; * use Phalcon\Cache\Backend\File; * use Phalcon\Cache\Frontend\Output; * * // Create an Output frontend. Cache the files for 2 days * $frontCache = new Output( * [ * "lifetime" => 172800, * ] * ); * * // Create the component that will cache from the "Output" to a "File" backend * // Set the cache file directory - it's important to keep the "/" at the end of * // the value for the folder * $cache = new File( * $frontCache, * [ * "cacheDir" => "../app/cache/", * ] * ); * * // Get/Set the cache file to ../app/cache/my-cache.html * $content = $cache->start("my-cache.html"); * * // If $content is null then the content will be generated for the cache * if (null === $content) { * // Print date and time * echo date("r"); * * // Generate a link to the sign-up action * echo Tag::linkTo( * [ * "user/signup", * "Sign Up", * "class" => "signup-button", * ] * ); * * // Store the output into the cache file * $cache->save(); * } else { * // Echo the cached output * echo $content; * }

*```

## メソッド

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Output constructor

public **getLifetime** ()

キャッシュの有効期間を返します。

public **isBuffering** ()

フロントエンドが出力をバッファリングするかどうかチェックします。

public **start** ()

Starts output frontend. Currently, does nothing

public *string* **getContent** ()

キャッシュしたコンテンツを返します。

public **stop** ()

フロントエンドの出力を停止します。

public **beforeStore** (*mixed* $data)

保存する前にデータをシリアライズします。

public **afterRetrieve** (*mixed* $data)

取得後にデータのシリアライズ化を戻します。