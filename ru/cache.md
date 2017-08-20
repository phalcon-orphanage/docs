<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Улучшение производительности с помощью кэширования</a> 
      <ul>
        <li>
          <a href="#implementation">Где применять кэширование?</a>
        </li>
        <li>
          <a href="#caching-behavior">Поведение системы кэширования</a>
        </li>
        <li>
          <a href="#factory">Factory</a>
        </li>
        <li>
          <a href="#output-fragments">Кэширование выходных фрагментов</a>
        </li>
        <li>
          <a href="#arbitrary-data">Кэширование произвольных данных</a> 
          <ul>
            <li>
              <a href="#backend-file-example">Пример файлового бэкэнда</a>
            </li>
            <li>
              <a href="#backend-memcached-example">Пример использования бэкэнда Memcache</a>
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
          <a href="#adapters-frontend">Фронтэнд адаптеры</a> 
          <ul>
            <li>
              <a href="#adapters-frontend-custom">Реализация собственных фронтэнд адаптеров</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters-backend">Бэкэнд адаптеры</a> 
          <ul>
            <li>
              <a href="#adapters-backend-factory">Factory</a>
            </li>
            <li>
              <a href="#adapters-backend-custom">Реализация собственных бэкэнд адаптеров</a>
            </li>
            <li>
              <a href="#adapters-backend-file">Параметры файлового бэкэнда</a>
            </li>
            <li>
              <a href="#adapters-backend-libmemcached">Параметры Libmemcached бэкэнда</a>
            </li>
            <li>
              <a href="#adapters-backend-memcache">Параметры Memcache бэкэнда</a>
            </li>
            <li>
              <a href="#adapters-backend-apc">Параметры APC бэкэнда</a>
            </li>
            <li>
              <a href="#adapters-backend-apcu">APCU Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-mongo">Mongo Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-xcache">XCache Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-redis">Redis Backend Options</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Improving Performance with Cache

Phalcon предоставляет класс `Phalcon\Cache`, дающий быстрый доступ к часто используемым или уже сгенерированным данным. `Phalcon\Cache` написан на языке C, поэтому он предоставляет высокую производительность и пониженный расход ресурсов. Этот класс использует два компонента: frontend и backend. Frontend компонент является входным источником или интерфейсом, в то время как backend предоставляет опции хранения данных.

<a name='implementation'></a>

## When to implement cache?

Несмотря на то, что этот компонент очень быстрый, его использование в случаях, где он не нужен, может привести к потери производительности. Мы рекомендуем проверить эти ситуации, прежде, чем использовать кэширование:

* Вы делаете сложные расчеты, которые каждый раз возвращают один и тот же результат (или результат редко изменяется)
* Вы используете много хелперов и результат генерации почти всегда одинаковый
* Вы постоянно обращаетесь к базе данных и редко изменяете эти данные

<div class='alert alert-warning'>
    <p>
        <strong>NOTE</strong> Even after implementing the cache, you should check the hit ratio of your cache over a period of time. Это можно легко проверить, особенно используя Memcache или Apc, с помощью соответствующих инструментов, предоставляемыми этими приложениями.
    </p>
</div>

<a name='caching-behavior'></a>

## Caching Behavior

Процесс кэширования разделена в 2 части:

* **Frontend**: Эта часть отвечает за проверку времени жизни ключа и выполняет дополнительные преобразования над данными, до операции сохранения или извлечения их из backend
* **Backend**: Эта часть отвечает за коммуникацию, запись/чтение данных по запросу frontend.

<a name='factory'></a>

## Factory

Instantiating frontend or backend adapters can be achieved by two ways:

Traditional way

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Create an Output frontend. Cache the files for 2 days
$frontCache = new FrontData(
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
```

or using the Factory object as follows:

```php
<?php

use Phalcon\Cache\Frontend\Factory as FFactory;
use Phalcon\Cache\Backend\Factory as BFactory;

 $options = [
     'lifetime' => 172800,
     'adapter'  => 'data',
 ];
 $frontendCache = FFactory::load($options);


$options = [
    'cacheDir' => '../app/cache/',
    'prefix'   => 'app-data',
    'frontend' => $frontendCache,
    'adapter'  => 'file',
];

$backendCache = BFactory::load($options);
```

<a name='output-fragments'></a>

## Caching Output Fragments

Выходные фрагменты — это части HTML или текста, которые кэшируются “как есть” и возвращаются “как есть”. Выходные данные автоматически захватываются из `ob_*` функции или из выходного потока PHP и сохраняются в кэш. Следующий пример демонстрирует такое использование. Он получает сгенерированные выходные данные и сохраняет их в файл. Кэш обновляется каждые 172800 секунд (двое суток).

Реализация этого механизма позволяет нам повысить производительность за счет исключения работы помощника `Phalcon\Tag::linkTo()`, который вызывается каждый раз в этом участке кода.

```php
<?php

use Phalcon\Tag;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Создание frontend для выходных данных. Кэшируем файлы на двое суток
$frontCache = new FrontOutput(
    [
        'lifetime' => 172800,
    ]
);

// Создаем компонент, который будем кэшировать из "Выходных данных"
// в файловый бэкэнд.
// Устанавливаем папку для кэшируемых файлов - важно указать символ '/'
// в конце пути
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

// Получить/Создать кэшируемый файл ../app/cache/my-cache.html
$content = $cache->start('my-cache.html');

// Если $content является значением NULL,
// значит данных в кэше нет и их надо сгенерировать
if ($content === null) {
    // Выводим дату и время
    echo date('r');

    // Генерируем ссылку на "регистрацию"
    echo Tag::linkTo(
        [
            'user/signup',
            'Sign Up',
            'class' => 'signup-button',
        ]
    );

    // Сохраняем вывод в кэш
    $cache->save();
} else {
    // Ввыводим кэшируемые данные
    echo $content;
}
```

<div class='alert alert-warning'>
    <p>
        <strong>NOTE</strong> In the example above, our code remains the same, echoing output to the user as it has been doing before. Наш компонент кэширования прозрачно перехватывает вывод и сохраняет его в кэшируемый файл (когда кэш сгенерирован) или он отправляет уже готовые данные обратно к пользователю, а это естественно позволяет экономить на выполнении операций.
    </p>
</div>

<a name='arbitrary-data'></a>

## Caching Arbitrary Data

Кэширование различных данных, не менее важно для вашего приложения. Кэширование может уменьшить нагрузку базы данных за счет повторного использования сгенерированных данных (но не обновленных), что и увеличивает скорость выполнения вашего приложения.

<a name='backend-file-example'></a>

### File Backend Example

One of the caching adapters is `File`. Единственным параметром для него является место, где будут храниться закэшированные файлы. Это контролируется параметром `cacheDir`, который *должен* содержать завершающий слеш.

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Кэшируем данные на двое суток
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Создаем компонент, который будем кэшировать из "Выходных данных" в "Файл"
// Устанавливаем папку для кэшируемых файлов
// Важно сохранить символ "/" в конце пути
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

$cacheKey = 'robots_order_id.cache';

// Пробуем получить закэшированные записи
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots может иметь значение NULL из-за того, что истекло время жизни
    // или данных просто не существует. Получим данные из БД
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Сохраняем их в кэше
    $cache->save($cacheKey, $robots);
}

// Используем $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<a name='backend-memcached-example'></a>

### Memcached Backend Example

Для этого нам достаточно немного изменить вышестоящий пример. В частности изменится конфигурация.

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

// Кэшируем данные на 1 час
$frontCache = new FrontData(
    [
        'lifetime' => 3600,
    ]
);

// Создаем компонент, который будет кэшировать данные в Memcache
// Настройки подключения к Memcache
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

// Пробуем получить закэшированные записи
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots может иметь значение NULL из-за того, что истекло время жизни
    // или данных просто не существует. Получим данные из БД
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Сохраняем их в кэше
    $cache->save($cacheKey, $robots);
}

// Используем $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<div class='alert alert-warning'>
    <p>
        <strong>NOTE</strong> Calling <code>save()</code> will return a boolean, indicating success (<code>true</code>) or failure (<code>false</code>). В зависимости от бэкэнда, который вы используете, вам понадобится обратится к соответствующим логам, для выявления сбоев.
    </p>
</div>

<a name='read'></a>

## Querying the cache

Все элементы добавляемые в кэш идентифицируются по ключам. В случае с файловым бэкэндом, ключом является название файла. Для получения данных из кэша нам необходимо выполнить запрос к кэшу с указанием уникального ключа. Если ключа не существует, метод вернет значение NULL.

```php
<?php

// Получаем продукты по ключу "myProducts"
$products = $cache->get('myProducts');
```

Для того чтобы узнать какие ключи сейчас хранятся можно выполнить метод `queryKeys`:

```php
<?php

// Получаем все ключи, которые хранятся в кэше
$keys = $cache->queryKeys();

foreach ($keys as $key) {
    $data = $cache->get($key);

    echo 'Key=', $key, ' Data=', $data;
}

// Получаем все ключи, которые начинаются с префикса "my-prefix"
$keys = $cache->queryKeys('my-prefix');
```

<a name='delete'></a>

## Deleting data from the cache

Могут возникнуть ситуации, когда вам необходимо принудительно инвалидировать данные в кэше. Единственным требованием для этого является знание необходимого ключа по которому хранятся данные.

```php
<?php

// Удаляем элемент по определенному ключу
$cache->delete('someKey');

$keys = $cache->queryKeys();

// Удаляем все из кэша
foreach ($keys as $key) {
    $cache->delete($key);
}
```

<a name='exists'></a>

## Checking cache existence

Существует возможность проверить наличие данных в кэше:

```php
<?php

if ($cache->exists('someKey')) {
    echo $cache->get('someKey');
} else {
    echo 'Данных в кэше не существует!';
}
```

<a name='lifetime'></a>

## Lifetime

`lifetime` — это время, исчисляемое в секундах, которое означает, сколько будут храниться данные в бэкэнде. По умолчанию все данные получают “время жизни”, которое было указано при создании фронтэнд компонента. Вы можете указать другое значение при сохранении или получении данных из кэша:

Задаем время жизни при получении:

```php
<?php

$cacheKey = 'my.cache';

// Получаем кэш и задаем время жизни
$robots = $cache->get($cacheKey, 3600);

if ($robots === null) {
    $robots = 'some robots';

    // Сохраняем в кэше
    $cache->save($cacheKey, $robots);
}
```

Задаем время жизни при сохранении:

```php
<?php

$cacheKey = 'my.cache';

$robots = $cache->get($cacheKey);

if ($robots === null) {
    $robots = 'some robots';

    // Задаем время жизни, сохраняя данные
    $cache->save($cacheKey, $robots, 3600);
}
```

<a name='multi-level'></a>

## Multi-Level Cache

Эта возможность компонента кэширования позволяет разработчику осуществлять кэш в несколько уровней. Возможность будет полезна при сохранении кэша в нескольких системах кэширования, с разным временем жизни и последующим поочерёдным чтением из них, начиная с самого быстрого (в порядке регистрации) и заканчивая самым медленным, пока срок жизни во всех них не истечет:

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

// Бэкэнды от самого быстрого до самого медленного
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

// Сохраняем, сохраняется сразу во все бэкэнды
$cache->save('my-key', $data);
```

<a name='adapters-frontend'></a>

## Frontend Adapters

Доступные фронтэнд адаптеры приведены в таблице:

| Адаптер                              | Description                                                                                                                                                       |
| ------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Cache\Frontend\Output`   | Считывает данные из стандартного PHP вывода.                                                                                                                      |
| `Phalcon\Cache\Frontend\Data`     | Используется для кэширования любых данных в PHP (большие массивы, объекты, тексты и т.д.). Прежде чем сохранить данные, адаптер сериализирует их.                 |
| `Phalcon\Cache\Frontend\Base64`   | Используется для кэширования бинарных данных. Данные сериализируется с использованием `base64_encode`.                                                            |
| `Phalcon\Cache\Frontend\Json`     | Данные перед кэширование сериализуются в JSON. Можно использовать для обмена данными с другими фреймворками.                                                      |
| `Phalcon\Cache\Frontend\Igbinary` | Он используется для кэширования любых данных PHP (большие массивы, объекты, тексты и т.д.). Данные сериализуются c помощью `Igbinary` перед сохранением в бэкэнд. |
| `Phalcon\Cache\Frontend\None`     | Используется для кэширования любых типов данных без сериализации.                                                                                                 |

<a name='adapters-frontend-custom'></a>

### Implementing your own Frontend adapters

Для создания фронтэнд адаптера необходимо реализовать интерфейс `Phalcon\Cache\FrontendInterface`.

<a name='adapters-backend'></a>

## Backend Adapters

Доступные бэкэнд адаптеры приведены в таблице:

| Adapter                                 | Description                                                                  | Информация                                | Необходимые расширения                             |
| --------------------------------------- | ---------------------------------------------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Сохраняет данные в Alternative PHP Cache (APC).                              | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`         | Сохраняет данные в APCu (APC без кеширования опкода).                        | [APCu](http://php.net/apcu)               | [APCu](http://pecl.php.net/package/APCu)           |
| `Phalcon\Cache\Backend\File`         | Сохраняет данные в локальный текстовый файл.                                 |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | Сохраняет данные на memcached сервере с использованием memcached расширения. | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | Stores data to a memcached server.                                           | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Mongo`        | Сохраняет данные в базе данных Mongo.                                        | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Сохраняет данные в Redis.                                                    | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | Сохраняет данные в XCache.                                                   | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |

<div class='alert alert-warning'>
    <p>
        <strong>NOTE</strong> In PHP 7 to use phalcon <code>apc</code> based adapter classes you needed to install <code>apcu</code> and <code>apcu_bc</code> package from pecl. Now in Phalcon 3.2.0 you can switch your <code>*\Apc</code> classes to <code>*\Apcu</code> and remove <code>apcu_bc</code>. Keep in mind that in Phalcon 4 we will most likely remove all `*\Apc` classes.
    </p>
</div>

<a name='adapters-backend-factory'></a>

### Factory

There are many backend adapters (see [Backend Adapters](#adapters-backend)). The one you use will depend on the needs of your application. The following example loads the Backend Cache Adapter class using `adapter` option, if frontend will be provided as array it will call Frontend Cache Factory

```php
<?php

use Phalcon\Cache\Backend\Factory;
use Phalcon\Cache\Frontend\Data;

$options = [
    'prefix'   => 'app-data',
    'frontend' => new Data(),
    'adapter'  => 'apc',
];
$backendCache = Factory::load($options);
```

<a name='adapters-backend-custom'></a>

### Реализация собственных бэкэнд адаптеров

Для создания бэкэнд адаптера необходимо реализовать интерфейс `Phalcon\Cache\BackendInterface`.

<a name='adapters-backend-file'></a>

### Параметры файлового бэкэнда

Этот бэкэнд сохраняет данные в локальный текстовый файл. Доступные опции:

| Параметр   | Description                                                              |
| ---------- | ------------------------------------------------------------------------ |
| `prefix`   | Префикс, который будет автоматически добавляться к ключам кэша.          |
| `cacheDir` | Папка с правами на запись, в которую будут сохраняться кэшируемые файлы. |

<a name='adapters-backend-libmemcached'></a>

### Параметры Libmemcached бэкэнда

Данные будут сохранены на Memcached сервере. По умолчанию используется пулл постоянных соединений. Доступные опции:

**Общие параметры**

| Option          | Description                                                                                                                                                   |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `statsKey`      | Используется для отслеживания ключей кэша.                                                                                                                    |
| `prefix`        | A prefix that is automatically prepended to the cache keys.                                                                                                   |
| `persistent_id` | Для создания экземпляра, который сохраняется между запросами, необходимо использовать `persistent_id`, чтобы указать уникальный идентификатор для экземпляра. |

**Параметры сервера**

| Option   | Description                                                                                |
| -------- | ------------------------------------------------------------------------------------------ |
| `host`   | Хост memcached сервера.                                                                    |
| `port`   | Порт memcached сервера.                                                                    |
| `weight` | Весовой коэффициент для заданного сервера по отношению к общему весу всех серверов в пуле. |

**Параметры клиента**

Используется для настройки параметров Memcached. За подробной информацией обратитесь к документации по [Memcached::setOptions](http://php.net/manual/en/memcached.setoptions.php).

**Example**

```php
<?php
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// Кэшируем данные на двое суток
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Инициализация Libmemcached бэкэнда
$cache = new Libmemcached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => 11211,
                'weight' => 1,
            ],
        ],
        'client' => [
            \Memcached::OPT_HASH       => \Memcached::HASH_MD5,
            \Memcached::OPT_PREFIX_KEY => 'prefix.',
        ],
        'persistent_id' => 'my_app_cache',
    ]
);
```

<a name='adapters-backend-memcache'></a>

### Параметры Memcache бэкэнда

Данные будут сохранены на Memcached сервере. Доступные опции:

| Option       | Description                                                 |
| ------------ | ----------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys. |
| `host`       | Хост memcached сервера.                                     |
| `port`       | Порт memcached сервера.                                     |
| `persistent` | Использовать постоянное соединение к серверу Memcached.     |

<a name='adapters-backend-apc'></a>

### Параметры APC бэкэнда

Данные будут сохранены в Alternative PHP Cache ([APC](http://php.net/apc)). Доступна лишь одна опция:

| Option   | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-apcu'></a>

### APCU Backend Options

This backend will store cached content on Alternative PHP Cache ([APCU](http://php.net/apcu)). The available options for this backend are:

| Option   | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-mongo'></a>

### Mongo Backend Options

This backend will store cached content on a MongoDB server ([MongoDB](http://mongodb.org/)). The available options for this backend are:

| Option       | Description                                                 |
| ------------ | ----------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys. |
| `server`     | A MongoDB connection string.                                |
| `db`         | Mongo database name.                                        |
| `collection` | Mongo collection in the database.                           |

<a name='adapters-backend-xcache'></a>

### XCache Backend Options

This backend will store cached content on XCache ([XCache](http://xcache.lighttpd.net/)). The available options for this backend are:

| Option   | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-redis'></a>

### Redis Backend Options

This backend will store cached content on a Redis server ([Redis](http://redis.io/)). The available options for this backend are:

| Option       | Description                                                    |
| ------------ | -------------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys.    |
| `host`       | Redis host.                                                    |
| `port`       | Redis port.                                                    |
| `auth`       | Password to authenticate to a password-protected Redis server. |
| `persistent` | Create a persistent connection to Redis.                       |
| `index`      | The index of the Redis database to use.                        |

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)