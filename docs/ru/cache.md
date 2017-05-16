<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Улучшение производительности с помощью кэширования</a> <ul>
        <li>
          <a href="#implementation">Где применять кэширование?</a>
        </li>
        <li>
          <a href="#caching-behavior">Поведение системы кэширования</a>
        </li>
        <li>
          <a href="#output-fragments">Кэширование выходных фрагментов</a>
        </li>
        <li>
          <a href="#arbitrary-data">Кэширование произвольных данных</a> <ul>
            <li>
              <a href="#backend-file-example">Пример файлового бэкенда</a>
            </li>
            <li>
              <a href="#backend-memcached-example">Пример использования Memcached бэкенда</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#read">Запрос данных из кэша</a>
        </li>
        <li>
          <a href="#delete">Удаление данных из кэша</a>
        </li>
        <li>
          <a href="#exists">Проверяем наличие кэша</a>
        </li>
        <li>
          <a href="#lifetime">Время жизни</a>
        </li>
        <li>
          <a href="#multi-level">Многоуровневое кэширование</a>
        </li>
        <li>
          <a href="#adapters-frontend">Фронтенд адаптеры</a> <ul>
            <li>
              <a href="#adapters-frontend-custom">Реализация собственных фронтэнд адаптеров</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#adapters-backend">Бэкенд адаптеры</a> <ul>
            <li>
              <a href="#adapters-backend-custom">Реализация собственных бэкенд адаптеров</a>
            </li>
            <li>
              <a href="#adapters-backend-file">Опции файлового бэкенда</a>
            </li>
            <li>
              <a href="#adapters-backend-memcached">Опции Memcached бэкенда</a>
            </li>
            <li>
              <a href="#adapters-backend-apc">Опции APC бэкенда</a>
            </li>
            <li>
              <a href="#adapters-backend-mongo">Опции Mongo бэкенда</a>
            </li>
            <li>
              <a href="#adapters-backend-xcache">Опции XCache бэкенда</a>
            </li>
            <li>
              <a href="#adapters-backend-redis">Опции Redis бэкенда</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Улучшение производительности с помощью кэширования

Phalcon предоставляет класс `Phalcon\Cache`, дающий быстрый доступ к часто используемым или уже сгенерированным данным. `Phalcon\Cache` написан на языке C, поэтому он предоставляет высокую производительность и пониженный расход ресурсов. Этот класс использует два компонента: frontend и backend. Frontend компонент является входным источником или интерфейсом, в то время как backend предоставляет опции хранения данных.

<a name='implementation'></a>

## Где применять кэширование?

Несмотря на то, что этот компонент очень быстрый, его использование в случаях, где он не нужен, может привести к потери производительности. Мы рекомендуем проверить эти ситуации, прежде, чем использовать кэширование:

- Вы делаете сложные расчеты, которые каждый раз возвращают один и тот же результат (или результат редко изменяется)
- Вы используете много хелперов и результат генерации почти всегда одинаковый
- Вы постоянно обращаетесь к базе данных и редко изменяете эти данные

##### *Примечание* Даже после реализации кэширования, вы должны проверить коэффициент попадания запросов в кэш (hit). Это можно легко проверить, особенно используя Memcache или Apc, с помощью соответствующих инструментов, предоставляемыми этими приложениями. {.alert.alert-warning}

<a name='caching-behavior'></a>

## Поведение системы кэширования

Процесс кэширования разделена в 2 части:

- **Frontend**: Эта часть отвечает за проверку времени жизни ключа и выполняет дополнительные преобразования над данными, до операции сохранения или извлечения их из backend
- **Backend**: Эта часть отвечает за коммуникацию, запись/чтение данных по запросу frontend.

<a name='output-fragments'></a>

## Кэширование выходных фрагментов

ыходные фрагменты — это части HTML или текста, которые кэшируются “как есть” и возвращаются “как есть”. Выходные данные автоматически захватываются из ob_* функции или из выходного потока PHP и сохраняются в кэш. Следующий пример демонстрирует такое использование. Он получает сгенерированные выходные данные и сохраняет их в файл. Кэш обновляется каждые 172800 секунд (двое суток).

Реализация этого механизма позволяет нам повысить производительность за счет исключения работы помощника `Phalcon\Tag::linkTo()`, который вызывается каждый раз в этом участке кода.

```php
<?php

use Phalcon\Tag;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Create an Output frontend. Cache the files for 2 days
$frontCache = new FrontOutput(
    [
        'lifetime' => 172800,
    ]
);

// Create the component that will cache from the 'Output' to a 'File' backend
// Set the cache file directory - it's important to keep the '/' at the end of
// the value for the folder
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

// Get/Set the cache file to ../app/cache/my-cache.html
$content = $cache->start('my-cache.html');

// If $content is null then the content will be generated for the cache
if ($content === null) {
    // Print date and time
    echo date('r');

    // Generate a link to the sign-up action
    echo Tag::linkTo(
        [
            'user/signup',
            'Sign Up',
            'class' => 'signup-button',
        ]
    );

    // Store the output into the cache file
    $cache->save();
} else {
    // Echo the cached output
    echo $content;
}
```

##### *NOTE* In the example above, our code remains the same, echoing output to the user as it has been doing before. Our cache component transparently captures that output and stores it in the cache file (when the cache is generated) or it sends it back to the user pre-compiled from a previous call, thus avoiding expensive operations. {.alert.alert-warning}

<a name='arbitrary-data'></a>

## Кэширование произвольных данных

Caching just data is equally important for your application. Caching can reduce database load by reusing commonly used (but not updated) data, thus speeding up your application.

<a name='backend-file-example'></a>

### Пример файлового бэкенда

One of the caching adapters is 'File'. The only key area for this adapter is the location of where the cache files will be stored. This is controlled by the cacheDir option which *must* have a backslash at the end of it.

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache the files for 2 days using a Data frontend
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Create the component that will cache 'Data' to a 'File' backend
// Set the cache file directory - important to keep the '/' at the end of
// the value for the folder
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

$cacheKey = 'robots_order_id.cache';

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null because of cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<a name='backend-memcached-example'></a>

### Пример использования Memcached бэкенда

The above example changes slightly (especially in terms of configuration) when we are using a Memcached backend.

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

// Cache data for one hour
$frontCache = new FrontData(
    [
        'lifetime' => 3600,
    ]
);

// Create the component that will cache 'Data' to a 'Memcached' backend
// Memcached connection settings
$cache = new BackMemCached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => '11211',
                'weight' => '1',
            ]
        ]
    ]
);

$cacheKey = 'robots_order_id.cache';

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null because of cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<a name='read'></a>

## Запрос данных из кэша

The elements added to the cache are uniquely identified by a key. In the case of the File backend, the key is the actual filename. To retrieve data from the cache, we just have to call it using the unique key. If the key does not exist, the get method will return null.

```php
<?php

// Retrieve products by key 'myProducts'
$products = $cache->get('myProducts');
```

If you want to know which keys are stored in the cache you could call the queryKeys method:

```php
<?php

// Query all keys used in the cache
$keys = $cache->queryKeys();

foreach ($keys as $key) {
    $data = $cache->get($key);

    echo 'Key=', $key, ' Data=', $data;
}

// Query keys in the cache that begins with 'my-prefix'
$keys = $cache->queryKeys('my-prefix');
```

<a name='delete'></a>

## Удаление данных из кэша

There are times where you will need to forcibly invalidate a cache entry (due to an update in the cached data). The only requirement is to know the key that the data have been stored with.

```php
<?php

// Delete an item with a specific key
$cache->delete('someKey');

$keys = $cache->queryKeys();

// Delete all items from the cache
foreach ($keys as $key) {
    $cache->delete($key);
}
```

<a name='exists'></a>

## Проверяем наличие кэша

It is possible to check if a cache already exists with a given key:

```php
<?php

if ($cache->exists('someKey')) {
    echo $cache->get('someKey');
} else {
    echo 'Cache does not exists!';
}
```

<a name='implementation'></a>

0## Время жизни

A 'lifetime' is a time in seconds that a cache could live without expire. By default, all the created caches use the lifetime set in the frontend creation. You can set a specific lifetime in the creation or retrieving of the data from the cache:

Setting the lifetime when retrieving:

```php
<?php

$cacheKey = 'my.cache';

// Setting the cache when getting a result
$robots = $cache->get($cacheKey, 3600);

if ($robots === null) {
    $robots = 'some robots';

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}
```

Настройка времени жизни при сохранении:

```php
<?php

$cacheKey = 'my.cache';

$robots = $cache->get($cacheKey);

if ($robots === null) {
    $robots = 'some robots';

    // Setting the cache when saving data
    $cache->save($cacheKey, $robots, 3600);
}
```

<a name='implementation'></a>

1## Многоуровневое кэширование

This feature of the cache component, allows the developer to implement a multi-level cache. This new feature is very useful because you can save the same data in several cache locations with different lifetimes, reading first from the one with the faster adapter and ending with the slowest one until the data expires:

```php
<?php

use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\File as FileCache;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;

$ultraFastFrontend = new DataFrontend(
    [
        'lifetime' => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        'lifetime' => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        'lifetime' => 604800,
    ]
);

// Бэкенды от самого быстрого до самого медленного
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                'prefix' => 'cache',
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                'prefix' => 'cache',
                'host'   => 'localhost',
                'port'   => '11211',
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                'prefix'   => 'cache',
                'cacheDir' => '../app/cache/',
            ]
        ),
    ]
);

// Сохраняем, сохраняется сразу во все бэкенды
$cache->save('my-key', $data);
```

<a name='implementation'></a>

2## Фронтенд адаптеры

The available frontend adapters that are used as interfaces or input sources to the cache are:

| Адаптер                              | Описание                                                                                                                                                       |
| ------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Cache\Frontend\Output`   | Read input data from standard PHP output                                                                                                                       |
| `Phalcon\Cache\Frontend\Data`     | It's used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized before stored in the backend.                                     |
| `Phalcon\Cache\Frontend\Base64`   | It's used to cache binary data. The data is serialized using base64_encode before be stored in the backend.                                                    |
| `Phalcon\Cache\Frontend\Json`     | Data is encoded in JSON before be stored in the backend. Decoded after be retrieved. This frontend is useful to share data with other languages or frameworks. |
| `Phalcon\Cache\Frontend\Igbinary` | It's used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized using IgBinary before be stored in the backend.                   |
| `Phalcon\Cache\Frontend\None`     | It's used to cache any kind of PHP data without serializing them.                                                                                              |

<a name='implementation'></a>

3### Реализация собственных фронтэнд адаптеров

The `Phalcon\Cache\FrontendInterface` interface must be implemented in order to create your own frontend adapters or extend the existing ones.

<a name='implementation'></a>

4## Бэкенд адаптеры

The backend adapters available to store cache data are:

| Адаптер                                 | Описание                                       | Информация                                | Необходимые расширения                             |
| --------------------------------------- | ---------------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Stores data to the Alternative PHP Cache (APC) | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\File`         | Stores data to local plain files               |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | Stores data to a memcached server              | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | Stores data to a memcache server               | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Mongo`        | Stores data to Mongo Database                  | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Stores data in Redis                           | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | Stores data in XCache                          | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |

<a name='implementation'></a>

5### Реализация собственных бэкенд адаптеров

The `Phalcon\Cache\BackendInterface` interface must be implemented in order to create your own backend adapters or extend the existing ones.

<a name='implementation'></a>

6### Опции файлового бэкенда

This backend will store cached content into files in the local server. The available options for this backend are:

| Параметр   | Описание                                                   |
| ---------- | ---------------------------------------------------------- |
| `prefix`   | A prefix that is automatically prepended to the cache keys |
| `cacheDir` | A writable directory on which cached files will be placed  |

<a name='implementation'></a>

7### Опции Memcached бэкенда

This backend will store cached content on a memcached server. The available options for this backend are:

| Параметр     | Описание                                                   |
| ------------ | ---------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys |
| `host`       | memcached host                                             |
| `port`       | memcached port                                             |
| `persistent` | create a persistent connection to memcached?               |

<a name='implementation'></a>

8### Опции APC бэкенда

This backend will store cached content on Alternative PHP Cache ([APC](http://php.net/apc)). The available options for this backend are:

| Параметр | Описание                                                   |
| -------- | ---------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys |

<a name='implementation'></a>

9### Опции Mongo бэкенда

This backend will store cached content on a MongoDB server ([MongoDB](http://mongodb.org/)). The available options for this backend are:

| Параметр     | Описание                                                   |
| ------------ | ---------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys |
| `server`     | A MongoDB connection string                                |
| `db`         | Mongo database name                                        |
| `collection` | Mongo collection in the database                           |

<a name='caching-behavior'></a>

0### Опции XCache бэкенда

This backend will store cached content on XCache ([XCache](http://xcache.lighttpd.net/)). The available options for this backend are:

| Параметр | Description                                              |
| -------- | -------------------------------------------------------- |
| `prefix` | Префикс, который автоматически добавляется к ключам кэша |

<a name='caching-behavior'></a>

1### Опции Redis бэкенда

This backend will store cached content on a Redis server ([Redis](http://redis.io/)). The available options for this backend are:

| Параметр     | Описание                                                      |
| ------------ | ------------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys    |
| `host`       | Redis host                                                    |
| `port`       | Redis port                                                    |
| `auth`       | Password to authenticate to a password-protected Redis server |
| `persistent` | Create a persistent connection to Redis                       |
| `index`      | The index of the Redis database to use                        |

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)