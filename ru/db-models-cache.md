<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Кэширование в ORM</a> 
      <ul>
        <li>
          <a href="#caching-resultsets">Кэширование наборов данных</a>
        </li>
        <li>
          <a href="#forcing-cache">Форсирование кэша</a>
        </li>
        <li>
          <a href="#caching-phql-queries">Кэширование PHQL запросов</a>
        </li>
        <li>
          <a href="#reusable-related-records">Многократное использование связанных записей</a>
        </li>
        <li>
          <a href="#caching-related-records">Кэширование связанных записей</a>
        </li>
        <li>
          <a href="#caching-related-records-recursively">Рекурсивное кэшировоние связанных записей</a>
        </li>
        <li>
          <a href="#caching-based-on-conditions">Кэширование на основе условий</a>
        </li>
        <li>
          <a href="#caching-phql-execution-plan">Кэширования плана выполнения PHQL</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='orm-caching'></a>

# Кэширование в ORM

Каждое приложение уникально. В большинстве приложений, однако, есть данные, которые меняются редко. Одним из наиболее распространенных узких мест в плане производительности является доступ к базе данных. Это связано со сложными процессами подключения/коммуникации, которые PHP должен выполнять при каждом запросе к базе данных для получения требуемых данных. Поэтому, если мы хотим добиться хорошей производительности, нам нужно добавить несколько уровней кэширования, где это требуется приложению.

В этой главе описываются потенциальные области, в которых можно реализовать кэширование для повышения производительности. Phalcon предоставляет разработчикам инструменты, необходимые для реализации кэширования там, где это необходимо их приложению.

<a name='caching-resultsets'></a>

## Кэширование наборов данных

Хорошо устоявшийся метод, чтобы избежать постоянного доступа к базе данных, заключается в кэшировании результирующих наборов, которые не меняются часто, используя систему с более быстрым доступом (обычно память).

Когда для `Phalcon\Mvc\Model` потребуется сервис для кэширования результирующих наборов, будет запрошена соответствующая служба из контейнера внедрения зависимостей. Название запрашиваемого сервиса — `modelsCache`. Фреймворк предоставлет компонент [cache](/[[language]]/[[version]]/cache), который можно использовать для хранения данных любого типа. Теперь мы посмотрим, как мы можем интегрировать его с нашими моделями.

Во-первых, нам нужно будет зарегистрировать компонент кэша как сервис в контейнере DI.

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Memcache as BackendMemcache;

// Регистрация сервиса кэша моделей
$di->set(
    'modelsCache',
    function () {
        // По умолчанию данные кэша хранятся один день
        $frontCache = new FrontendData(
            [
                'lifetime' => 86400,
            ]
        );

        // Настройки соединения с memcached
        $cache = new BackendMemcache(
            $frontCache,
            [
                'host' => 'localhost',
                'port' => '11211',
            ]
        );

        return $cache;
    }
);
```

Вы имеете полный контроль в создании и настройке компонента кэша перед его регистрацией в качестве службы в контейнере DI. После того, как компонент кэш настроен правильно, результирующие наборы могут быть кэшированы следующим образом:

```php
<?php

// Получение продукта без использования кэша
$products = Products::find();

// Используем кэширование наборов данных. Кэш остается в памяти в течении 1 часа (3600 секунд).
$products = Products::find(
    [
        'cache' => [
            'key' => 'my-cache',
        ],
    ]
);

// Кэш набора данных хранится всего 5 минут
$products = Products::find(
    [
        'cache' => [
            'key'      => 'my-cache',
            'lifetime' => 300,
        ],
    ]
);

// Мы используем сервис 'cache' из DI вместо 'modelsCache'
$products = Products::find(
    [
        'cache' => [
            'key'     => 'my-cache',
            'service' => 'cache',
        ],
    ]
);
```

Кэширование также может быть применено к результирующим наборам, созданным с использованием связей:

```php
<?php

// Запрос некоторого сообщения
$post = Post::findFirst();

// Получаем комментарии, относящиеся к сообщению, и кэшируем их
$comments = $post->getComments(
    [
        'cache' => [
            'key' => 'my-key',
        ],
    ]
);

// Получаем комментарии, относящиеся к сообщению и устанавливаем срок их хранения
$comments = $post->getComments(
    [
        'cache' => [
            'key'      => 'my-key',
            'lifetime' => 3600,
        ],
    ]
);
```

Когда кэшированный результирующий набор должен быть признан недействительным, его можно просто удалить из кэша с помощью ключа, указанного выше.

Какие наборы данных кэшировать и на какое время, решает разработчик, после оценки потребностей приложения. Данные, которые меняют свои значения очень часто, не следует кэшировать, так как они становятся не действительными очень быстро, и кэширование в этом случаи отрицательно влияет на производительность приложения. Кроме того, большие наборы данных, которые не часто меняют свои значения, могут располагаться в кэше, но для реализации этой идеи необходимо оценить имеющиеся механизмы кэширования и влияния на производительность, так как это не всегда будет способствовать увеличению производительности приложения. Для минимизации взаимодействия с базой данных необходимо кэшировать нечасто изменяющиеся результирующие наборы. Решение о том, где использовать кэширование и как долго продиктовано потребностями приложения.

<a name='forcing-cache'></a>

## Форсирование кэша

Ранее мы видели, как `Phalcon\Mvc\Model` имеет встроенную интеграцию с компонентом кэширования, предоставленного фреймворком. Чтобы сделать запись/результирующий набор кэшируемым, мы передаем ключ `cache` в массиве параметров:

```php
<?php

// Кэшируем результирующий набор всего на 5 минут
$products = Products::find(
    [
        'cache' => [
            'key'      => 'my-cache',
            'lifetime' => 300,
        ],
    ]
);
```

Это дает нам свободу для кэширования конкретных запросов. Однако если мы хотим кэшировать глобально все запросы, выполняемые моделью, мы можем переопределить метод `find()`/`findFirst()`, чтобы заставить кэшировать каждый запрос:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * Реализация метода, который возвращает
     * строковый ключ на основе параметров запроса
     */
    protected static function _createKey($parameters)
    {
        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (is_array($value)) {
                $uniqueKey[] = $key . ':[' . self::_createKey($value) . ']';
            }
        }

        return join(',', $uniqueKey);
    }

    public static function find($parameters = null)
    {
        // Преобразование параметров в массив
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Проверяем, что ключ кэша не был передан
        // и создаем параметры кэша
        if (!isset($parameters['cache'])) {
            $parameters['cache'] = [
                'key'      => self::_createKey($parameters),
                'lifetime' => 300,
            ];
        }

        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        // ...
    }
}
```

Доступ к базе данных в несколько раз медленнее, чем вычисление ключа кэша. Вы вольны в реализации стратегии генерации ключа, которая лучше подходит для ваших задач. Следует отметить, что хороший ключ позволяет избежать конфликтов, насколько это возможно, это означает, что разные ключи возвращают при поиске независимые наборы записей.

Это дает вам полный контроль над тем, как кэши должны быть реализованы для каждой модели, эта стратегия может быть общей для нескольких моделей, которую можно вынести в отдельный базовый класс для всех подобных классов:

```php
<?php

use Phalcon\Mvc\Model;

class CacheableModel extends Model
{
    protected static function _createKey($parameters)
    {
        // ... Создание ключа кэша на основе параметров
    }

    public static function find($parameters = null)
    {
        // ... Некоторая произвольная стратегия кэширования
    }

    public static function findFirst($parameters = null)
    {
        // ... Некоторая произвольная стратегия кэширования
    }
}
```

Затем используйте этот класс в качестве базового класса для каждой модели `Cacheable`:

```php
<?php

class Robots extends CacheableModel
{

}
```

<a name='caching-phql-queries'></a>

## Кэширование PHQL запросов

Независимо от синтаксиса, который мы использовали для их создания, все запросы в ORM обрабатываются внутренне с помощью PHQL. Этот язык дает гораздо больше свободы для создания всех видов запросов. Конечно, эти запросы могут кэшироваться:

```php
<?php

$phql = 'SELECT * FROM Cars WHERE name = :name:';

$query = $this->modelsManager->createQuery($phql);

$query->cache(
    [
        'key'      => 'cars-by-name',
        'lifetime' => 300,
    ]
);

$cars = $query->execute(
    [
        'name' => 'Audi',
    ]
);
```

<a name='reusable-related-records'></a>

## Многократное использование связанных записей

Некоторые модели могут иметь отношения с другими моделями. Это позволяет легко проверять записи, относящиеся к экземплярам в памяти:

```php
<?php

// Get some invoice
$invoice = Invoices::findFirst();

// Get the customer related to the invoice
$customer = $invoice->customer;

// Print his/her name
echo $customer->name, "\n";
```

Этот пример очень прост, клиент запрашивается и может использоваться по мере необходимости, например, для отображения его имени. Это также применяется, если мы извлекаем набор счетов-фактур для отображения клиентов, которые соответствуют этим счетам-фактурам:

```php
<?php

// Get a set of invoices
// SELECT * FROM invoices;
$invoices = Invoices::find();

foreach ($invoices as $invoice) {
    // Get the customer related to the invoice
    // SELECT * FROM customers WHERE id = ?;
    $customer = $invoice->customer;

    // Print his/her name
    echo $customer->name, "\n";
}
```

A customer may have one or more bills so, in this example, the same customer record may be unnecessarily queried several times. To avoid this, we could mark the relationship as reusable; by doing so, we tell the ORM to automatically reuse the records from memory instead of re-querying them again and again:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'customers_id',
            'Customer',
            'id',
            [
                'reusable' => true,
            ]
        );
    }
}
```

Note that this type of cache works in memory only, this means that cached data are released when the request is terminated.

<a name='caching-related-records'></a>

## Кэширование связанных записей

When a related record is queried, the ORM internally builds the appropriate condition and gets the required records using `find()`/`findFirst()` in the target model according to the following table:

| Тип        | Описание                                                        | Implicit Method |
| ---------- | --------------------------------------------------------------- | --------------- |
| Belongs-To | Returns a model instance of the related record directly         | `findFirst()`   |
| Has-One    | Returns a model instance of the related record directly         | `findFirst()`   |
| Has-Many   | Returns a collection of model instances of the referenced model | `find()`        |

This means that when you get a related record you could intercept how the data is obtained by implementing the corresponding method:

```php
<?php

// Get some invoice
$invoice = Invoices::findFirst();

// Get the customer related to the invoice
$customer = $invoice->customer; // Invoices::findFirst('...');

// Same as above
$customer = $invoice->getCustomer(); // Invoices::findFirst('...');
```

Accordingly, we could replace the `findFirst()` method in the Invoices model and implement the cache we consider most appropriate:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function findFirst($parameters = null)
    {
        // ... Custom caching strategy
    }
}
```

<a name='caching-related-records-recursively'></a>

## Рекурсивное кэшировоние связанных записей

In this scenario, we assume that every time we query a result we also retrieve their associated records. If we store the records found together with their related entities perhaps we could reduce a bit the overhead required to obtain all entities:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    protected static function _createKey($parameters)
    {
        // ... Create a cache key based on the parameters
    }

    protected static function _getCache($key)
    {
        // Returns data from a cache
    }

    protected static function _setCache($key, $results)
    {
        // Stores data in the cache
    }

    public static function find($parameters = null)
    {
        // Create a unique key
        $key = self::_createKey($parameters);

        // Check if there are data in the cache
        $results = self::_getCache($key);

        // Valid data is an object
        if (is_object($results)) {
            return $results;
        }

        $results = [];

        $invoices = parent::find($parameters);

        foreach ($invoices as $invoice) {
            // Query the related customer
            $customer = $invoice->customer;

            // Assign it to the record
            $invoice->customer = $customer;

            $results[] = $invoice;
        }

        // Store the invoices in the cache + their customers
        self::_setCache($key, $results);

        return $results;
    }

    public function initialize()
    {
        // Add relations and initialize other stuff
    }
}
```

Getting the invoices from the cache already obtains the customer data in just one hit, reducing the overall overhead of the operation. Note that this process can also be performed with PHQL following an alternative solution:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        // Add relations and initialize other stuff
    }

    protected static function _createKey($conditions, $params)
    {
        // ... Create a cache key based on the parameters
    }

    public function getInvoicesCustomers($conditions, $params = null)
    {
        $phql = 'SELECT Invoices.*, Customers.* FROM Invoices JOIN Customers WHERE ' . $conditions;

        $query = $this->getModelsManager()->executeQuery($phql);

        $query->cache(
            [
                'key'      => self::_createKey($conditions, $params),
                'lifetime' => 300,
            ]
        );

        return $query->execute($params);
    }

}
```

<a name='caching-based-on-conditions'></a>

## Кэширование на основе условий

В этом сценарии кэширование реализуется по-разному в зависимости от полученных условий. Мы можем решить, что выбор сервера для кэша должен быть обусловлен первичным ключом:

| Тип           | Кэширующий сервер |
| ------------- | ----------------- |
| 1 - 10000     | mongo1            |
| 10000 - 20000 | mongo2            |
| > 20000       | mongo3            |

Самый простой способ добиться этого — добавить статический метод в модель, которая выбирает правильный кэш для использования:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public static function queryCache($initial, $final)
    {
        if ($initial >= 1 && $final < 10000) {
            $service = 'mongo1';
        } elseif ($initial >= 10000 && $final <= 20000) {
            $service = 'mongo2';
        } elseif ($initial > 20000) {
            $service = 'mongo3';
        }

        return self::find(
            [
                'id >= ' . $initial . ' AND id <= ' . $final,
                'cache' => [
                    'service' => $service,
                ],
            ]
        );
    }
}
```

Этот подход решает проблему, однако, если мы хотим добавить другие параметры выборки, например тип сортировки или различные условия для выборки, нам придется создать более сложный метод. Кроме того, этот подход не работает, если данные получены с помощью связанных записей или `find()`/`findFirst()`:

```php
<?php

$robots = Robots::find('id < 1000');
$robots = Robots::find("id > 100 AND type = 'A'");
$robots = Robots::find("(id > 100 AND type = 'A') AND id < 2000");

$robots = Robots::find(
    [
        "(id > ?0 AND type = 'A') AND id < ?1",
        'bind'  => [100, 2000],
        'order' => 'type',
    ]
);
```

Для этого нам необходимо перехватить промежуточное представление (IR), генерируемое парсером PHQL и реализовать логику кэширования для всех возможных условий выборки:

Для начала нам понадобится реализовать пользовательский конструктор запросов, чтобы иметь возможность перехватывать и генерировать полностью сформированный запрос:

```php
<?php

use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;

class CustomQueryBuilder extends QueryBuilder
{
    public function getQuery()
    {
        $query = new CustomQuery($this->getPhql());

        $query->setDI($this->getDI());

        if ( is_array($this->_bindParams) ) {
            $query->setBindParams($this->_bindParams);
        }

        if ( is_array($this->_bindTypes) ) {
            $query->setBindTypes($this->_bindTypes);
        }

        if ( is_array($this->_sharedLock) ) {
            $query->setSharedLock($this->_sharedLock);
        }

        return $query;
    }
}
```

Instead of directly returning a `Phalcon\Mvc\Model\Query`, our custom builder returns a CustomQuery instance, this class looks like:

```php
<?php

use Phalcon\Mvc\Model\Query as ModelQuery;

class CustomQuery extends ModelQuery
{
    /**
     * The execute method is overridden
     */
    public function execute($params = null, $types = null)
    {
        // Parse the intermediate representation for the SELECT
        $ir = $this->parse();

        if ( is_array($this->_bindParams) ) {
            $params = array_merge($this->_bindParams, (array)$params);
        }

        if ( is_array($this->_bindTypes) ) {
            $types = array_merge($this->_bindTypes, (array)$types);
        }

        // Check if the query has conditions
        if (isset($ir['where'])) {
            // The fields in the conditions can have any order
            // We need to recursively check the conditions tree
            // to find the info we're looking for
            $visitor = new CustomNodeVisitor();

            // Recursively visits the nodes
            $visitor->visit($ir['where']);

            $initial = $visitor->getInitial();
            $final   = $visitor->getFinal();

            // Select the cache according to the range
            // ...

            // Check if the cache has data
            // ...
        }

        // Execute the query
        $result = $this->_executeSelect($ir, $params, $types);
        $result = $this->_uniqueRow ? $result->getFirst() : $result;

        // Cache the result
        // ...

        return $result;
    }
}
```

Реализация хелпера (`CustomNodeVisitor`), который рекурсивно проверяет условия выборки и формирует возможный диапазон для использования его в кэше:

```php
<?php

class CustomNodeVisitor
{
    protected $_initial = 0;

    protected $_final = 25000;

    public function visit($node)
    {
        switch ($node['type']) {
            case 'binary-op':
                $left  = $this->visit($node['left']);
                $right = $this->visit($node['right']);

                if (!$left || !$right) {
                    return false;
                }

                if ($left === 'id') {
                    if ($node['op'] === '>') {
                        $this->_initial = $right;
                    }

                    if ($node['op'] === '=') {
                        $this->_initial = $right;
                    }

                    if ($node['op'] === '>=') {
                        $this->_initial = $right;
                    }

                    if ($node['op'] === '<') {
                        $this->_final = $right;
                    }

                    if ($node['op'] === '<=') {
                        $this->_final = $right;
                    }
                }

                break;

            case 'qualified':
                if ($node['name'] === 'id') {
                    return 'id';
                }

                break;

            case 'literal':
                return $node['value'];

            default:
                return false;
        }
    }

    public function getInitial()
    {
        return $this->_initial;
    }

    public function getFinal()
    {
        return $this->_final;
    }
}
```

Наконец, мы можем заменить метод find в модели Robots, чтобы использовать наши классы, которые мы создали:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public static function find($parameters = null)
    {
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        $builder = new CustomQueryBuilder($parameters);

        $builder->from(get_called_class());

        $query = $builder->getQuery();

        if (isset($parameters['bind'])) {
            return $query->execute($parameters['bind']);
        } else {
            return $query->execute();
        }
    }
}
```

<a name='caching-phql-execution-plan'></a>

## Кэширования плана выполнения PHQL

As well as most moderns database systems PHQL internally caches the execution plan, if the same statement is executed several times PHQL reuses the previously generated plan improving performance, for a developer to take better advantage of this is highly recommended build all your SQL statements passing variable parameters as bound parameters:

```php
<?php

for ($i = 1; $i <= 10; $i++) {
    $phql = 'SELECT * FROM Store\Robots WHERE id = ' . $i;

    $robots = $this->modelsManager->executeQuery($phql);

    // ...
}
```

In the above example, ten plans were generated increasing the memory usage and processing in the application. Rewriting the code to take advantage of bound parameters reduces the processing by both ORM and database system:

```php
<?php

$phql = 'SELECT * FROM Store\Robots WHERE id = ?0';

for ($i = 1; $i <= 10; $i++) {
    $robots = $this->modelsManager->executeQuery(
        $phql,
        [
            $i,
        ]
    );

    // ...
}
```

Performance can be also improved reusing the PHQL query:

```php
<?php

$phql = 'SELECT * FROM Store\Robots WHERE id = ?0';

$query = $this->modelsManager->createQuery($phql);

for ($i = 1; $i <= 10; $i++) {
    $robots = $query->execute(
        $phql,
        [
            $i,
        ]
    );

    // ...
}
```

Execution plans for queries involving [prepared statements](http://en.wikipedia.org/wiki/Prepared_statement) are also cached by most database systems reducing the overall execution time, also protecting your application against [SQL Injections](http://en.wikipedia.org/wiki/SQL_injection).