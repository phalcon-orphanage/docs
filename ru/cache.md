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
          <a href="#factory">Фабрика</a>
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
              <a href="#adapters-backend-factory">Фабрика</a>
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
              <a href="#adapters-backend-mongo">Параметры Mongo бэкэнда</a>
            </li>
            <li>
              <a href="#adapters-backend-xcache">Параметры XCache бэкэнда</a>
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

# Улучшение производительности с помощью кэширования

Phalcon предоставляет класс `Phalcon\Cache`, дающий быстрый доступ к часто используемым или уже сгенерированным данным. `Phalcon\Cache` написан на языке C, поэтому он предоставляет высокую производительность и пониженный расход ресурсов. Этот класс использует два компонента: frontend и backend. Frontend компонент является входным источником или интерфейсом, в то время как backend предоставляет опции хранения данных.

<a name='implementation'></a>

## Где применять кэширование?

Несмотря на то, что этот компонент очень быстрый, его использование в случаях, где он не нужен, может привести к потери производительности. Мы рекомендуем проверить эти ситуации, прежде, чем использовать кэширование:

* Вы делаете сложные расчеты, которые каждый раз возвращают один и тот же результат (или результат редко изменяется)
* Вы используете много хелперов и результат генерации почти всегда одинаковый
* Вы постоянно обращаетесь к базе данных и редко изменяете эти данные

<div class='alert alert-warning'>
    <p>
        <strong>Примечание</strong> Даже после реализации кэширования, вы должны проверить коэффициент попадания запросов в кэш. Это можно легко проверить, особенно используя Memcache или Apc, с помощью соответствующих инструментов, предоставляемыми этими приложениями.
    </p>
</div>

<a name='caching-behavior'></a>

## Поведение системы кэширования

Процесс кэширования разделена в 2 части:

* **Frontend**: Эта часть отвечает за проверку времени жизни ключа и выполняет дополнительные преобразования над данными, до операции сохранения или извлечения их из backend
* **Backend**: Эта часть отвечает за коммуникацию, запись/чтение данных по запросу frontend.

<a name='factory'></a>

## Factory

Создание фронтэнд и бэкэнд адаптеров может быть достигнуто двумя способами:

Традиционный путь

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Создание frontend для выходных данных. Кэширование файлов на 2 дня
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Создаем компонент, который будем кэшировать из "Выходных данных" в "Файл"
// Устанавливаем папку для кэшируемых файлов - важно указать символ "/" в конце пути
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);
```

или используя объект Factory, следующим образом:

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

## Кэширование выходных фрагментов

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
        <strong>Примечание</strong> В этом примере наш код остается таким же и выводит те же данные пользователю. Наш компонент кэширования прозрачно перехватывает вывод и сохраняет его в кэшируемый файл (когда кэш сгенерирован) или он отправляет уже готовые данные обратно к пользователю, а это естественно позволяет экономить на выполнении операций.
    </p>
</div>

<a name='arbitrary-data'></a>

## Кэширование произвольных данных

Кэширование различных данных, не менее важно для вашего приложения. Кэширование может уменьшить нагрузку базы данных за счет повторного использования сгенерированных данных (но не обновленных), что и увеличивает скорость выполнения вашего приложения.

<a name='backend-file-example'></a>

### Пример файлового бэкенда

Существует файловый адаптер кэширования (`File`). Единственным параметром для него является место, где будут храниться закэшированные файлы. Это контролируется параметром `cacheDir`, который *должен* содержать завершающий слеш.

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

### Пример использования бэкэнда Memcache

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
        <strong>ПРИМЕЧАНИЕ</strong> Вызов <code>save()</code> возвращает логическое значение, указывающее успех (<code>true</code>) или сбой (<code>false</code>). В зависимости от бэкэнда, который вы используете, вам понадобится обратится к соответствующим логам, для выявления сбоев.
    </p>
</div>

<a name='read'></a>

## Запрос данных из кэша

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

## Удаление данных из кэша

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

## Проверка существования кэша

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

## Время жизни

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

## Многоуровневое кэширование

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

## Фронтэнд адаптеры

Доступные фронтэнд адаптеры приведены в таблице:

| Адаптер                              | Описание                                                                                                                                                          |
| ------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Cache\Frontend\Output`   | Считывает данные из стандартного PHP вывода.                                                                                                                      |
| `Phalcon\Cache\Frontend\Data`     | Используется для кэширования любых данных в PHP (большие массивы, объекты, тексты и т.д.). Прежде чем сохранить данные, адаптер сериализирует их.                 |
| `Phalcon\Cache\Frontend\Base64`   | Используется для кэширования бинарных данных. Данные сериализируется с использованием `base64_encode`.                                                            |
| `Phalcon\Cache\Frontend\Json`     | Данные перед кэширование сериализуются в JSON. Можно использовать для обмена данными с другими фреймворками.                                                      |
| `Phalcon\Cache\Frontend\Igbinary` | Он используется для кэширования любых данных PHP (большие массивы, объекты, тексты и т.д.). Данные сериализуются c помощью `Igbinary` перед сохранением в бэкэнд. |
| `Phalcon\Cache\Frontend\None`     | Используется для кэширования любых типов данных без сериализации.                                                                                                 |

<a name='adapters-frontend-custom'></a>

### Реализация собственных фронтэнд адаптеров

Для создания фронтэнд адаптера необходимо реализовать интерфейс `Phalcon\Cache\FrontendInterface`.

<a name='adapters-backend'></a>

## Бэкенд адаптеры

Доступные бэкэнд адаптеры приведены в таблице:

| Адаптер                                 | Описание                                                                     | Информация                                | Необходимые расширения                             |
| --------------------------------------- | ---------------------------------------------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Сохраняет данные в Alternative PHP Cache (APC).                              | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`         | Сохраняет данные в APCu (APC без кеширования опкода).                        | [APCu](http://php.net/apcu)               | [APCu](http://pecl.php.net/package/APCu)           |
| `Phalcon\Cache\Backend\File`         | Сохраняет данные в локальный текстовый файл.                                 |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | Сохраняет данные на memcached сервере с использованием memcached расширения. | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | Сохраняет данные на memcached сервере.                                       | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Memory`       | Stores data in memory                                                        |                                           |                                                    |
| `Phalcon\Cache\Backend\Mongo`        | Сохраняет данные в базе данных Mongo.                                        | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Сохраняет данные в Redis.                                                    | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | Сохраняет данные в XCache.                                                   | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |

<a name='adapters-backend-factory'></a>

### Фабрика

Существует множество бэкенд адаптеров (см. [Бэкенд адаптеры](#adapters-backend)). Используемый вами, будет зависеть от нужд вашего приложения. Следующий пример демонстрирует инициализацию бэкенд адаптера с использованием опции `adapter`. Если опция frontend будет представлена в виде массива, фронтэнд адаптер будет инициализирован при помощи соответствующей фабрики.

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

| Параметр   | Описание                                                                 |
| ---------- | ------------------------------------------------------------------------ |
| `prefix`   | Префикс, который будет автоматически добавляться к ключам кэша.          |
| `cacheDir` | Папка с правами на запись, в которую будут сохраняться кэшируемые файлы. |

<a name='adapters-backend-libmemcached'></a>

### Параметры Libmemcached бэкэнда

Данные будут сохранены на Memcached сервере. По умолчанию используется пулл постоянных соединений. Доступные опции:

**Общие параметры**

| Параметр        | Описание                                                                                                                                                      |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `statsKey`      | Используется для отслеживания ключей кэша.                                                                                                                    |
| `prefix`        | Префикс, который будет автоматически добавляться к ключам кэша.                                                                                               |
| `persistent_id` | Для создания экземпляра, который сохраняется между запросами, необходимо использовать `persistent_id`, чтобы указать уникальный идентификатор для экземпляра. |

**Параметры сервера**

| Параметр | Описание                                                                                   |
| -------- | ------------------------------------------------------------------------------------------ |
| `host`   | Хост memcached сервера.                                                                    |
| `port`   | Порт memcached сервера.                                                                    |
| `weight` | Весовой коэффициент для заданного сервера по отношению к общему весу всех серверов в пуле. |

**Параметры клиента**

Используется для настройки параметров Memcached. За подробной информацией обратитесь к документации по [Memcached::setOptions](http://php.net/manual/en/memcached.setoptions.php).

**Пример**

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

| Параметр     | Описание                                                        |
| ------------ | --------------------------------------------------------------- |
| `prefix`     | Префикс, который будет автоматически добавляться к ключам кэша. |
| `host`       | Хост memcached сервера.                                         |
| `port`       | Порт memcached сервера.                                         |
| `persistent` | Использовать постоянное соединение к серверу Memcached.         |

<a name='adapters-backend-apc'></a>

### Параметры APC бэкэнда

Данные будут сохранены в Alternative PHP Cache ([APC](http://php.net/apc)). Доступна лишь одна опция:

| Параметр | Описание                                                        |
| -------- | --------------------------------------------------------------- |
| `prefix` | Префикс, который будет автоматически добавляться к ключам кэша. |

<a name='adapters-backend-apcu'></a>

### APCU Backend Options

This backend will store cached content on Alternative PHP Cache ([APCU](http://php.net/apcu)). The available options for this backend are:

| Параметр | Описание                                                        |
| -------- | --------------------------------------------------------------- |
| `prefix` | Префикс, который будет автоматически добавляться к ключам кэша. |

<a name='adapters-backend-mongo'></a>

### Параметры Mongo бэкэнда

Этот бэкэнд будет хрнаить закэшированный контент на MongoDB сервере ([MongoDB](http://mongodb.org/)). Доступные опции:

| Параметр     | Описание                                                        |
| ------------ | --------------------------------------------------------------- |
| `prefix`     | Префикс, который будет автоматически добавляться к ключам кэша. |
| `server`     | Строка подключения к MongoDB.                                   |
| `db`         | Название базы данных.                                           |
| `collection` | Коллекция в базе данных.                                        |

<a name='adapters-backend-xcache'></a>

### Параметры XCache бэкэнда

This backend will store cached content on XCache ([XCache](http://xcache.lighttpd.net/)). The available options for this backend are:

| Параметр | Описание                                                        |
| -------- | --------------------------------------------------------------- |
| `prefix` | Префикс, который будет автоматически добавляться к ключам кэша. |

<a name='adapters-backend-redis'></a>

### Redis Backend Options

This backend will store cached content on a Redis server ([Redis](http://redis.io/)). The available options for this backend are:

| Параметр     | Описание                                                        |
| ------------ | --------------------------------------------------------------- |
| `prefix`     | Префикс, который будет автоматически добавляться к ключам кэша. |
| `host`       | Хост Redis сервера.                                             |
| `port`       | Порт Redis сервера.                                             |
| `auth`       | Пароль для авторизации на защищенном паролем Redis сервере.     |
| `persistent` | Создавать постоянное соединение к Redis серверу.                |
| `index`      | Индекс для использования в базе данных Redis.                   |

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)