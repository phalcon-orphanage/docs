<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Метаданные модели</a> <ul>
        <li>
          <a href="#caching-metadata">Кэширование метаданных</a>
        </li>
        <li>
          <a href="#metadata-strategies">Стратегии метаданных</a> 
          <ul>
            <li>
              <a href="#strategies-database-introspection">Стратегия интроспекции базы данных</a>
            </li>
            <li>
              <a href="#strategies-annotations">Стратегия аннотаций</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#strategies-manual">Установка метаданных вручную</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='models-metadata'></a>

# Метаданные модели

Для ускорения разработки `Phalcon\Mvc\Model` позволяет запрашивать поля и ограничения из таблиц, связанных с моделями. Для этого, `Phalcon\Mvc\Model\MetaData` позволяет управлять и кэшировать метаданные таблицы.

При работе с моделями иногда возникает необходимость получения этих атрибутов. Вы можете получить экземпляр метаданных следующим образом:

```php
<?php

$robot = new Robots();

// Получаем экземпляр Phalcon\Mvc\Model\Metadata
$metadata = $robot->getModelsMetaData();

// Получаем имена полей робота
$attributes = $metadata->getAttributes($robot);
print_r($attributes);

// Получаем типы данных полей робота
$dataTypes = $metadata->getDataTypes($robot);
print_r($dataTypes);
```

<a name='caching-metadata'></a>

## Кэширование метаданных

После того как приложение переведено в продакшн режим, нет необходимости запрашивать метаданные таблицы из базы данных каждый раз, когда вы используете таблицу. В таком случае можно задействовать кэширование метаданных, используя любой из следующих адаптеров:

| Адаптер      | Описание                                                                                                                                                                                                                                                                                                                                  | API                                           |
| ------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------- |
| Apc          | Этот адаптер использует [Alternative PHP Cache (APC)](http://www.php.net/manual/en/book.apc.php) для хранения таблицы метаданных. Вы можете задать время жизни метаданных с помощью параметров. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме.                                                   | `Phalcon\Mvc\Model\MetaData\Apc`          |
| Files        | Этот адаптер использует текстовые файлы для хранения метаданных. При его использовании нагрузка на диск увеличивается, а на базу данных — снижается.                                                                                                                                                                                      | `Phalcon\Mvc\Model\MetaData\Files`        |
| Libmemcached | Этот адаптер использует [сервер Memcached](https://www.memcached.org/) для хранения таблицы метаданных. Параметры сервера, а также время жизни кэша указываются в параметрах. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме.                                                                     | `Phalcon\Mvc\Model\MetaData\Libmemcached` |
| Memcache     | Этот адаптер использует [сервер Memcached](http://php.net/manual/en/book.memcache.php) и PHP-расширение memcache для хранения таблицы метаданных. Параметры сервера, а также время жизни кэша указываются в параметрах. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме.                           | `Phalcon\Mvc\Model\MetaData\Memcache`     |
| Memory       | Это адаптер по умолчанию. Метаданные кэшируются только на время выполнения запроса. По завершении запроса память, выделенная под метаданные, освобождается. Рекомендуемый способ хранения метаданных, когда приложение находится в стадии разработки.                                                                                     | `Phalcon\Mvc\Model\MetaData\Memory`       |
| Redis        | Этот адаптер использует [сервер Redis](https://redis.io/) для хранения таблицы метаданных. Параметры сервера, а также время жизни кэша указываются в параметрах. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме.                                                                                  | `Phalcon\Mvc\Model\MetaData\Redis`        |
| Session      | Этот адаптер сохраняет метаданные в суперглобальной переменной `$_SESSION`. Данный адаптер рекомендуется использовать только при небольшом количестве моделей. Метаданные обновляются каждый раз, когда начинается новая сессия. При этом перед использованием любой модели необходимо начать сессию с помощью функции `session_start()`. | `Phalcon\Mvc\Model\MetaData\Session`      |
| XCache       | Этот адаптер использует [XCache](http://xcache.lighttpd.net/) для хранения таблицы метаданных. Вы можете задать время жизни метаданных с помощью параметров. Это один из рекомендуемых способов для хранения метаданных, когда приложение находится в продакшн режиме.                                                                    | `Phalcon\Mvc\Model\MetaData\Xcache`       |

Как и другие зависимости ORM, менеджер метаданных запрашивается из контейнера сервисов:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di['modelsMetadata'] = function () {
    // Создаём менеджер метаданных с APC
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    return $metadata;
};
```

<a name='metadata-strategies'></a>

## Стратегии метаданных

Как уже упоминалось выше, стратегией по умолчанию для получения метаданных модели является интроспекция базы данных. В этой стратегии используется информационная схема, чтобы узнать поля таблицы, ее первичный ключ, обнуляемые поля, типы данных и т. д.

Вы можете изменить стандартную интроспекцию метаданных следующим образом:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di['modelsMetadata'] = function () {
    // Создаём адаптер метаданных
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Изменяем стратегию интроспекции метаданных
    $metadata->setStrategy(
        new MyIntrospectionStrategy()
    );

    return $metadata;
};
```

<a name='strategies-database-introspection'></a>

### Стратегия интроспекции базы данных

Эта стратегия не требует какой-либо настройки и неявно используется всеми адаптерами метаданных.

<a name='strategies-annotations'></a>

### Стратегия Аннотаций

Эта стратегия позволяет использовать `аннотации <annotations>` для описания столбцов в модели:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type='integer', nullable=false)
     */
    public $id;

    /**
     * @Column(type='string', length=70, nullable=false)
     */
    public $name;

    /**
     * @Column(type='string', length=32, nullable=false)
     */
    public $type;

    /**
     * @Column(type='integer', nullable=false)
     */
    public $year;
}
```

Аннотации должны быть расположены в свойствах, которые отображаются на столбцы таблицы. Свойства без аннотации @Column обрабатываются как простые атрибуты класса.

Поддерживаются следующие аннотации:

| Название | Описание                                              |
| -------- | ----------------------------------------------------- |
| Primary  | Отмечает поле как часть первичного ключа таблицы      |
| Identity | Поле является автоинкрементным и/или идентифицирующим |
| Column   | Отмечает атрибут в качестве отображаемого столбца     |

Аннотация @Column поддерживает следующие параметры:

| Название | Описание                                                |
| -------- | ------------------------------------------------------- |
| type     | Тип столбца (строка, целое число, дробное число, булев) |
| length   | Длина столбца, если есть                                |
| nullable | Принимает ли столбец нулевые значения или нет           |

Стратегия аннотаций может быть задана таким образом:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;

$di['modelsMetadata'] = function () {
    // Создаём адаптер метаданных
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Изменяем стратегию интроспекции метаданных
    $metadata->setStrategy(
        new StrategyAnnotations()
    );

    return $metadata;
};
```

<a name='strategies-manual'></a>

## Установка метаданных вручную

Phalcon может получить метаданные для каждой модели автоматически, без необходимости их ручной установки с помощью любой из стратегий интроспекции, представленных выше.

Разработчик также имеет возможность определить метаданные вручную. Эта стратегия перекрывает любые другие, заданные в менеджере метаданных. При добавлении/изменении/удалении столбцов в связанной таблице информация о них также должна быть добавлена/изменена/удалена в модели.

Следующий пример показывает, как определить метаданные вручную:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\MetaData;

class Robots extends Model
{
    public function metaData()
    {
        return array(
            // Столбцы в отображаемой таблице
            MetaData::MODELS_ATTRIBUTES => [
                'id',
                'name',
                'type',
                'year',
            ],

            // Столбцы, являющиеся частью первичного ключа
            MetaData::MODELS_PRIMARY_KEY => [
                'id',
            ],

            // Столбцы, которые не являются частью первичного ключа
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'name',
                'type',
                'year',
            ],

            // Столбцы, которые не позволяют хранить нулевые значения
            MetaData::MODELS_NOT_NULL => [
                'id',
                'name',
                'type',
            ],

            // Все столбцы и их типы данных
            MetaData::MODELS_DATA_TYPES => [
                'id'   => Column::TYPE_INTEGER,
                'name' => Column::TYPE_VARCHAR,
                'type' => Column::TYPE_VARCHAR,
                'year' => Column::TYPE_INTEGER,
            ],

            // Стобцы, которые имеют числовые типы данных
            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'id'   => true,
                'year' => true,
            ],

            // Столбец идентификатора. Используйте логическое значение FALSE,
            // если модель не имеет столбца идентификации
            MetaData::MODELS_IDENTITY_COLUMN => 'id',

            // К какому типу приводить каждый столбец
            MetaData::MODELS_DATA_TYPES_BIND => [
                'id'   => Column::BIND_PARAM_INT,
                'name' => Column::BIND_PARAM_STR,
                'type' => Column::BIND_PARAM_STR,
                'year' => Column::BIND_PARAM_INT,
            ],

            // Поля, которые должны быть проигнорированы в INSERT SQL инструкциях
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [
                'year' => true,
            ],

            // Поля, которые должны быть проигнорированы в UPDATE SQL инструкциях
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [
                'year' => true,
            ],

            // Значения по умолчанию для столбцов
            MetaData::MODELS_DEFAULT_VALUES => [
                'year' => '2015',
            ],

            // Поля, допускающие пустые строки
            MetaData::MODELS_EMPTY_STRING_VALUES => [
                'name' => true,
            ],
        );
    }
}
```