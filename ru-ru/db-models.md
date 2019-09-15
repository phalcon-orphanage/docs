---
layout: default
language: 'ru-ru'
version: '4.0'
upgrade: '#models'
---

# Models

* * *

![](/assets/images/document-status-under-review-red.svg)

## Overview

Модель представляет собой информацию (данные) приложения и правила для манипуляции этими данными. Модели в основном используется для управления соответствующей таблицей базы данных и правил взаимодействия с ней. В большинстве случаев, каждая таблица в вашей базе данных соответствует одной модели в вашем приложении. Большая часть всей бизнес-логики вашего приложения будет сосредоточена в моделях.

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is the base for all models in a Phalcon application. It provides database independence, basic CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) avoids the need of having to use SQL statements because it translates methods dynamically to the respective database engine operations.

> Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the [Phalcon\Db](api/Phalcon_Db) component documentation.
{: .alert .alert-warning }

## Creating Models

A model is a class that extends from [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). Its class name should be in camel case notation:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{

}
```

By default, the model `Store\Toys\RobotParts` will map to the table `robot_parts`. If you want to manually specify another name for the mapped table, you can use the `setSource()` method:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{
    public function initialize()
    {
        $this->setSource('toys_robot_parts');
    }
}
```

The model `RobotParts` now maps to `toys_robot_parts` table. The `initialize()` method helps with setting up this model with a custom behavior i.e. a different table.

The `initialize()` method is only called once during the request. This method is intended to perform initializations that apply for all instances of the model created within the application. If you want to perform initialization tasks for every instance created you can use the `onConstruct()` method:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{
    public function onConstruct()
    {
        // ...
    }
}
```

### Public properties vs. Setters/Getters

Models can be implemented public properties, meaning that each property can be read/updated from any part of the code that has instantiated that model class:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $price;
}
```

Another implementation is to use getters and setter functions, which control which properties are publicly available for that model. The benefit of using getters and setters is that the developer can perform transformations and validation checks on the values set for the model, which is impossible when using public properties. Additionally getters and setters allow for future changes without changing the interface of the model class. So if a field name changes, the only change needed will be in the private property of the model referenced in the relevant getter/setter and nowhere else in the code.

```php
<?php

namespace Store\Toys;

use InvalidArgumentException;
use Phalcon\Mvc\Model;

class Robots extends Model
{
    protected $id;

    protected $name;

    protected $price;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        // The name is too short?
        if (strlen($name) < 10) {
            throw new InvalidArgumentException(
                'The name is too short'
            );
        }

        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        // Negative prices aren't allowed
        if ($price < 0) {
            throw new InvalidArgumentException(
                "Price can't be negative"
            );
        }

        $this->price = $price;
    }

    public function getPrice()
    {
        // Convert the value to double before be used
        return (double) $this->price;
    }
}
```

Public properties provide less complexity in development. However getters/setters can heavily increase the testability, extensibility and maintainability of applications. Developers can decide which strategy is more appropriate for the application they are creating, depending on the needs of the application. The ORM is compatible with both schemes of defining properties.

> Underscores in property names can be problematic when using getters and setters.
{: .alert .alert-warning }

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use with magic methods. (e.g. `$model->getPropertyName` instead of `$model->getProperty_name`, `$model->findByPropertyName` instead of `$model->findByProperty_name`, etc.). As much of the system expects camel case, and underscores are commonly removed, it is recommended to name your properties in the manner shown throughout the documentation. You can use a column map (as described above) to ensure proper mapping of your properties to their database counterparts.

## Understanding Records To Objects

Every instance of a model represents a row in the table. You can easily access record data by reading object properties. For example, for a table 'robots' with the records:

```sql
mysql> select * from robots;
+----+------------+------------+------+
| id | name       | type       | year |
+----+------------+------------+------+
|  1 | Robotina   | mechanical | 1972 |
|  2 | Astro Boy  | mechanical | 1952 |
|  3 | Terminator | cyborg     | 2029 |
+----+------------+------------+------+
3 rows in set (0.00 sec)
```

You could find a certain record by its primary key and then print its name:

```php
<?php

use Store\Toys\Robots;

// Поиск записи с id = 3
$robot = Robots::findFirst(3);

// Вывод 'Terminator'
echo $robot->name;
```

Once the record is in memory, you can make modifications to its data and then save changes:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(3);

$robot->name = 'RoboCop';

$robot->save();
```

As you can see, there is no need to use raw SQL statements. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides high database abstraction for web applications.

## Finding Records

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) also offers several methods for querying records. The following examples will show you how to query one or more records from a model:

```php
<?php

use Store\Toys\Robots;

// Сколько роботов есть?
$robots = Robots::find();
echo 'Найдено роботов: ', count($robots), "\n";

// Сколько существует механических роботов?
$robots = Robots::find("type = 'mechanical'");
echo 'Найдено роботов: ', count($robots), "\n";

// Получить и распечатать виртуальных роботов упорядоченные по имени
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Получить первые 100 виртуальных роботов упорядоченных по имени
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
        'limit' => 100,
    ]
);
foreach ($robots as $robot) {
   echo $robot->name, "\n";
}
```

> If you want find record by external data (such as user input) or variable data you must use [Binding Parameters](#binding-parameters)`.
{: .alert .alert-warning }

You could also use the `findFirst()` method to get only the first record matching the given criteria:

```php
<?php

use Store\Toys\Robots;

// Первый робот в таблице роботов
$robot = Robots::findFirst();
echo 'Название робота: ', $robot->name, "\n";

// Первый механический робот в таблице роботов
$robot = Robots::findFirst("type = 'mechanical'");

echo 'The first mechanical robot name is ', $robot->name, "\n";

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);

echo 'The first virtual robot name is ', $robot->name, "\n";
```

Both `find()` and `findFirst()` methods accept an associative array specifying the search criteria:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name DESC',
        'limit' => 30,
    ]
);

$robots = Robots::find(
    [
        'conditions' => 'type = ?1',
        'bind'       => [
            1 => 'virtual',
        ]
    ]
);
```

The available query options are:

| Параметр      | Описание                                                                                                                                                                                                                | Пример                                                               |
| ------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | Условие поиска. Используется для выделения только тех записей, которые полностью удовлетворяют условиям поиска. By default [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) assumes the first parameter are the conditions. | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | Return specific columns instead of the full columns in the model. When using this option an incomplete object is returned                                                                                               | `'columns' => 'id, name'`                                         |
| `bind`        | Используется вместе с условием поиска для подстановки значений вместо соответствующих псевдопеременных и экранирования значений для увеличения безопасности.                                                            | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | При использовании подстановки значений вместо псевдопеременных, вы можете использовать этот параметр, для указания типа данных, что еще больше увеличит безопасность.                                                   | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                                              | `'order' => 'name DESC, status'`                                  |
| `limit`       | Ограничивает результаты запроса.                                                                                                                                                                                        | `'limit' => 10`                                                   |
| `offset`      | Смещает результаты запроса на определенное значение.                                                                                                                                                                    | `'offset' => 5`                                                   |
| `group`       | Позволяет выбирать данные используя несколько записей и группировать результат по одному или нескольким столбцам.                                                                                                       | `'group' => 'name, status'`                                       |
| `for_update`  | With this option, [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) reads the latest available data, setting exclusive locks on each row it reads                                                                            | `'for_update' => true`                                            |
| `shared_lock` | With this option, [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) reads the latest available data, setting shared locks on each row it reads                                                                               | `'shared_lock' => true`                                           |
| `cache`       | Кэширует результаты, уменьшая нагрузку на реляционную систему.                                                                                                                                                          | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | Устанавливает режим гидратации для представления каждой записи в результате.                                                                                                                                            | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

If you prefer, there is also available a way to create queries in an object-oriented way, instead of using an array of parameters:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::query()
    ->where('type = :type:')
    ->andWhere('year < 2000')
    ->bind(['type' => 'mechanical'])
    ->orderBy('name')
    ->execute();
```

The static method `query()` returns a [Phalcon\Mvc\Model\Criteria](api/Phalcon_Mvc_Model_Criteria) object that is friendly with IDE autocompleters.

All the queries are internally handled as [PHQL](db-phql) queries. PHQL is a high-level, object-oriented and SQL-like language. This language provide you more features to perform queries like joining other models, define groupings, add aggregations etc.

Lastly, there is the `findFirstBy<property-name>()` method. This method expands on the `findFirst()` method mentioned earlier. It allows you to quickly perform a retrieval from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column. An example is in order, so taking our Robots model mentioned earlier:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $price;
}
```

We have three properties to work with here: `$id`, `$name` and `$price`. So, let's say you want to retrieve the first record in the table with the name 'Terminator'. This could be written like:

```php
<?php

use Store\Toys\Robots;

$name = 'Terminator';

$robot = Robots::findFirstByName($name);

if ($robot) {
    echo 'Первый робот с именем ' . $name . ' стоит ' . $robot->price . '.';
} else {
    echo 'В нашей таблице не найдено роботов с именем ' . $name . '.';
}
```

Notice that we used 'Name' in the method call and passed the variable `$name` to it, which contains the name we are looking for in our table. Notice also that when we find a match with our query, all the other properties are available to us as well.

### Model Resultsets

While `findFirst()` returns directly an instance of the called class (when there is data to be returned), the `find()` method returns a [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). This is an object that encapsulates all the functionality a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset) is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

```php
<?php

use Store\Toys\Robots;

// Получить всех роботов
$robots = Robots::find();

// Обход в foreach
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Обход в while
$robots->rewind();

while ($robots->valid()) {
    $robot = $robots->current();

    echo $robot->name, "\n";

    $robots->next();
}

// Посчитать количество роботов
echo count($robots);

// Альтернативный способ посчитать количество записей
echo $robots->count();

// Перемещение внутреннего курсора к третьему роботу
$robots->seek(2);

$robot = $robots->current();

// Получить робота по его позиции в наборе результатов
$robot = $robots[5];

// Проверка существования записи с соответствующим индексом
if (isset($robots[3])) {
   $robot = $robots[3];
}

// Получить первую запись в наборе результатов
$robot = $robots->getFirst();

// Получить последнюю запись
$robot = $robots->getLast();
```

Phalcon's resultsets emulate scrollable cursors, you can get any row just by accessing its position, or seeking the internal pointer to a specific position. Note that some database systems don't support scrollable cursors, this forces to re-execute the query in order to rewind the cursor to the beginning and obtain the record at the requested position. Similarly, if a resultset is traversed several times, the query must be executed the same number of times.

As storing large query results in memory could consume many resources, resultsets are obtained from the database in chunks of 32 rows - reducing the need to re-execute the request in several cases.

Note that resultsets can be serialized and stored in a cache backend. [Phalcon\Cache](api/Phalcon_Cache) can help with that task. However, serializing data causes [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) to retrieve all the data from the database in an array, thus consuming more memory while this process takes place.

```php
<?php

// Запрос всех записей из модели Parts
$parts = Parts::find();

// Сериализуем  результат и сохраняем в файл
file_put_contents(
    'cache.txt',
    serialize($parts)
);

// Достаём parts из файла
$parts = unserialize(
    file_get_contents('cache.txt')
);

// Обходим parts в foreach
foreach ($parts as $part) {
    echo $part->id;
}
```

### Custom Resultsets

There are times that the application logic requires additional manipulation of the data as it is retrieved from the database. Previously, we would just extend the model and encapsulate the functionality in a class in the model or a trait, returning back to the caller usually an array of transformed data.

With custom resultsets, you no longer need to do that. The custom resultset will encapsulate the functionality that otherwise would be in the model and can be reused by other models, thus keeping the code [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself). This way, the `find()` method will no longer return the default [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset), but instead the custom one. Phalcon allows you to do this by using the `getResultsetClass()` in your model.

First we need to define the resultset class:

```php
<?php

namespace Application\Mvc\Model\Resultset;

use \Phalcon\Mvc\Model\Resultset\Simple;

class Custom extends Simple
{
    public function getSomeData() {
        /** CODE */
    }
}
```

In the model, we set the class in the `getResultsetClass()` as follows:

```php
<?php

namespace Phalcon\Test\Models\Statistics;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setSource('robots');
    }

    public function getResultsetClass()
    {
        return \Application\Mvc\Model\Resultset\Custom::class;
    }
}
```

and finally in your code you will have something like this:

```php
<?php

/**
 * Find the robots 
 */
$robots = Robots::find(
    [
        'conditions' => 'date between "2017-01-01" AND "2017-12-31"',
        'order'      => 'date',
    ]
);

/**
 * Pass the data to the view
 */
$this->view->mydata = $robots->getSomeData();
```

### Filtering Resultsets

The most efficient way to filter data is setting some search criteria, databases will use indexes set on tables to return data faster. Phalcon additionally allows you to filter the data using PHP using any resource that is not available in the database:

```php
<?php

$customers = Customers::find();

$customers = $customers->filter(
    function ($customer) {
        // Вернуть клиентов только с корректным e-mail адресом
        if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return $customer;
        }
    }
);
```

### Binding Parameters

Bound parameters are also supported in [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). You are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and integer placeholders are supported. Связывание параметров может быть легко достигнуто следующим образом:

```php
<?php

use Store\Toys\Robots;

// Запрос роботов с параметрами, привязанными к строковым псевдопеременным
// Параметры с ключами, идентичными псевдопеременным
$robots = Robots::find(
    [
        'name = :name: AND type = :type:',
        'bind' => [
            'name' => 'Robotina',
            'type' => 'maid',
        ],
    ]
);

// Запрос роботов с параметрами, привязанными к числовым псевдопеременным
$robots = Robots::find(
    [
        'name = ?1 AND type = ?2',
        'bind' => [
            1 => 'Robotina',
            2 => 'maid',
        ],
    ]
);

// Запрос роботов с параметрами, привязанными к строковым и числовым псевдопеременным
// Параметры с ключами, идентичными псевдопеременным
$robots = Robots::find(
    [
        'name = :name: AND type = ?1',
        'bind' => [
            'name' => 'Robotina',
            1      => 'maid',
        ],
    ]
);
```

When using numeric placeholders, you will need to define them as integers i.e. `1` or `2`. In this case `'1'` or `'2'` are considered strings and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using [PDO](https://php.net/manual/en/pdo.prepared-statements.php). This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Additionally you can set the parameter `bindTypes`, this allows defining how the parameters should be bound according to its data type:

```php
<?php

use Phalcon\Db\Column;
use Store\Toys\Robots;

// Привязка параметров
$parameters = [
    'name' => 'Robotina',
    'year' => 2008,
];

// Приведение типов
$types = [
    'name' => Column::BIND_PARAM_STR,
    'year' => Column::BIND_PARAM_INT,
];

// Запрос роботов с параметрами, привязанными к строковым псевдопеременным и их типам
$robots = Robots::find(
    [
        'name = :name: AND year = :year:',
        'bind'      => $parameters,
        'bindTypes' => $types,
    ]
);
```

> Since the default bind-type is `Phalcon\Db\Column::BIND_PARAM_STR`, there is no need to specify the 'bindTypes' parameter if all of the columns are of that type.
{: .alert .alert-warning }

If you bind arrays in bound parameters, keep in mind, that keys must be numbered from zero:

```php
<?php

use Store\Toys\Robots;

$array = ['a', 'b', 'c']; // $array: [[0] => 'a', [1] => 'b', [2] => 'c']

unset($array[1]); // $array: [[0] => 'a', [2] => 'c']

// Now we have to renumber the keys
$array = array_values($array); // $array: [[0] => 'a', [1] => 'c']

$robots = Robots::find(
    [
        'letter IN ({letter:array})',
        'bind' => [
            'letter' => $array,
        ],
    ]
);
```

Bound parameters are available for all query methods such as `find()` and `findFirst()` but also the calculation methods like `count()`, `sum()`, `average()` etc.
{: .alert .alert-warning }

If you're using "finders" e.g. `find()`, `findFirst()`, etc., bound parameters are automatically used:

```php
<?php

use Store\Toys\Robots;

// Запрос с явной привязкой параметров
$robots = Robots::find(
    [
        'name = ?0',
        'bind' => [
            'Ultron',
        ],
    ]
);

// Запрос с неявной привязкой параметров
$robots = Robots::findByName('Ultron');
```

## Initializing/Preparing fetched records

May be the case that after obtaining a record from the database is necessary to initialise the data before being used by the rest of the application. You can implement the `afterFetch()` method in a model, this event will be executed just after create the instance and assign the data to it:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $status;

    public function beforeSave()
    {
        // Преобразуем массив в строку
        $this->status = join(',', $this->status);
    }

    public function afterFetch()
    {
        // Преобразуем строку в массив
        $this->status = explode(',', $this->status);
    }

    public function afterSave()
    {
        // Преобразуем строку в массив
        $this->status = explode(',', $this->status);
    }
}
```

If you use getters/setters instead of/or together with public properties, you can initialize the field once it is accessed:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $status;

    public function getStatus()
    {
        return explode(',', $this->status);
    }
}
```

## Generating Calculations

Calculations (or aggregations) are helpers for commonly used functions of database systems such as `COUNT`, `SUM`, `MAX`, `MIN` or `AVG`. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) allows to use these functions directly from the exposed methods.

Count examples:

```php
<?php

// Сколько сотрудников работает?
$rowcount = Employees::count();

// Сколько уникальных сфер деятельности сотрудников?
$rowcount = Employees::count(
    [
        'distinct' => 'area',
    ]
);

// Сколько сотрудников работает в сфере тестирования?
$rowcount = Employees::count(
    'area = "Testing"'
);

// Count employees grouping results by their area
$group = Employees::count(
    [
        'group' => 'area',
    ]
);
foreach ($group as $row) {
   echo 'There are ', $row->rowcount, ' in ', $row->area;
}

// Count employees grouping by their area and ordering the result by count
$group = Employees::count(
    [
        'group' => 'area',
        'order' => 'rowcount',
    ]
);

// Avoid SQL injections using bound parameters
$group = Employees::count(
    [
        'type > ?0',
        'bind' => [
            $type,
        ],
    ]
);
```

Sum examples:

```php
<?php

// Какая заработная плата всех сотрудников?
$total = Employees::sum(
    [
        'column' => 'salary',
    ]
);

// Какая заработная плата всех сотруднииков в сфере продаж?
$total = Employees::sum(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// Generate a grouping of the salaries of each area
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
    ]
);

foreach ($group as $row) {
   echo 'The sum of salaries of the ', $row->area, ' is ', $row->sumatory;
}

// Generate a grouping of the salaries of each area ordering
// salaries from higher to lower
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
        'order'  => 'sumatory DESC',
    ]
);

// Avoid SQL injections using bound parameters
$group = Employees::sum(
    [
        'conditions' => 'area > ?0',
        'bind'       => [
            $area,
        ],
    ]
);
```

Average examples:

```php
<?php

// Какая средняя зарплата среди всех сотрудников?
$average = Employees::average(
    [
        'column' => 'salary',
    ]
);

// Какая средняя зарплата среди сотрудников сферы продаж?
$average = Employees::average(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// Avoid SQL injections using bound parameters
$average = Employees::average(
    [
        'column'     => 'age',
        'conditions' => 'area > ?0',
        'bind'       => [
            $area,
        ],
    ]
);
```

Max/Min examples:

```php
<?php

// Какой максимальный возраст среди всех сотрудников?
$age = Employees::maximum(
    [
        'column' => 'age',
    ]
);

// Какой максимальный возраст среди сотрудников сферы продаж?
$age = Employees::maximum(
    [
        'column'     => 'age',
        'conditions' => "area = 'Sales'",
    ]
);

// Какая минимальная зарплата среди сотрудников?
$salary = Employees::minimum(
    [
        'column' => 'salary',
    ]
);
```

## Creating/Updating Records

The `Phalcon\Mvc\Model::save()` method allows you to create/update records according to whether they already exist in the table associated with a model. The save method is called internally by the create and update methods of [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Мы не можем сохранить робота прямо сейчас: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Отлично, новый робот был успешно сохранен!';
}
```

An array could be passed to `assign()` to avoid assign every column manually. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will check if there are setters implemented for the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->assign(
    [
        'type' => 'mechanical',
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);

$robots->save();
```

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass an insecure array without worrying about possible SQL injections:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->assign($_POST);

$robot->save();
```

> Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted form.
{: .alert .alert-warning }

You can set an additional parameter in `save` to set a whitelist of fields that only must taken into account when doing the mass assignment:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->assign(
    $_POST,
    [
        'name',
        'type',
    ]
);

$robot->save();
```

### Create/Update with Confidence

When an application has a lot of competition, we could be expecting create a record but it is actually updated. This could happen if we use `Phalcon\Mvc\Model::save()` to persist the records in the database. If we want to be absolutely sure that a record is created or updated, we can change the `save()` call with `create()` or `update()`:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

// Эта запись только должна быть создана
if ($robot->create() === false) {
    echo "Мы не можем сохранить робота прямо сейчас: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Отлично, новый робот был успешно создан!';
}
```

The methods `create` and `update` also accept an array of values as parameter.

## Deleting Records

The `Phalcon\Mvc\Model::delete()` method allows to delete a record. You can use it as follows:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(11);

if ($robot !== false) {
    if ($robot->delete() === false) {
        echo "К сожалению, мы не можем удалить робота прямо сейчас: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'Робот был успешно удален!';
    }
}
```

You can also delete many records by traversing a resultset with a `foreach`:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find(
    "type = 'mechanical'"
);

foreach ($robots as $robot) {
    if ($robot->delete() === false) {
        echo "К сожалению, мы не можем удалить робота прямо сейчас: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'Робот был успешно удален!';
    }
}
```

The following events are available to define custom business rules that can be executed when a delete operation is performed:

| Операция | Название       | Можно остановить операцию? | Пояснение                                |
| -------- | -------------- |:--------------------------:| ---------------------------------------- |
| Удаление | `afterDelete`  |            Нет             | Runs after the delete operation was made |
| Удаление | `beforeDelete` |             Да             | Runs before the delete operation is made |

With the above events can also define business rules in the models:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function beforeDelete()
    {
        if ($this->status === 'A') {
            echo "Робот активен, он не может быть удален";

            return false;
        }

        return true;
    }
}
```

## Hydration Modes

As mentioned previously, resultsets are collections of complete objects, this means that every returned result is an object representing a row in the database. These objects can be modified and saved again to persistence:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find();

// Manipulating a resultset of complete objects
foreach ($robots as $robot) {
    $robot->year = 2000;

    $robot->save();
}
```

Sometimes records are obtained only to be presented to a user in read-only mode, in these cases it may be useful to change the way in which records are represented to facilitate their handling. The strategy used to represent objects returned in a resultset is called 'hydration mode':

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find();

// Return every robot as an array
$robots->setHydrateMode(
    Resultset::HYDRATE_ARRAYS
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}

// Return every robot as a stdClass
$robots->setHydrateMode(
    Resultset::HYDRATE_OBJECTS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}

// Return every robot as a Robots instance
$robots->setHydrateMode(
    Resultset::HYDRATE_RECORDS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}
```

Hydration mode can also be passed as a parameter of `find`:

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find(
    [
        'hydration' => Resultset::HYDRATE_ARRAYS,
    ]
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}
```

## Table prefixes

If you want all your tables to have certain prefix and without setting source in all models you can use the `Phalcon\Mvc\Model\Manager` and the method `setModelPrefix()`:

```php
<?php

use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model;

class Robots extends Model
{

}

$manager = new Manager();

$manager->setModelPrefix('wp_');

$robots = new Robots(null, null, $manager);

echo $robots->getSource(); // will return wp_robots
```

## Auto-generated identity columns

Some models may have identity columns. These columns usually are the primary key of the mapped table. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) can recognize the identity column omitting it in the generated SQL `INSERT`, so the database system can generate an auto-generated value for it. Always after creating a record, the identity field will be registered with the value generated in the database system for it:

```php
<?php

$robot->save();

echo 'The generated id is: ', $robot->id;
```

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is able to recognize the identity column. Depending on the database system, those columns may be serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence `table_field_seq`, for example: `robots_id_seq`, if that sequence has a different name, the `getSequenceName()` method needs to be implemented:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getSequenceName()
    {
        return 'robots_sequence_name';
    }
}
```

## Skipping Columns

To tell [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        // Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(
            [
                'year',
                'price',
            ]
        );

        // Skips only when inserting
        $this->skipAttributesOnCreate(
            [
                'created_at',
            ]
        );

        // Skips only when updating
        $this->skipAttributesOnUpdate(
            [
                'modified_in',
            ]
        );
    }
}
```

This will ignore globally these fields on each `INSERT`/`UPDATE` operation on the whole application. If you want to ignore different attributes on different `INSERT`/`UPDATE` operations, you can specify the second parameter (boolean) - `true` for replacement. Forcing a default value can be done as follows:

```php
<?php

use Store\Toys\Robots;

use Phalcon\Db\RawValue;

$robot = new Robots();

$robot->name       = 'Bender';
$robot->year       = 1999;
$robot->created_at = new RawValue('default');

$robot->create();
```

A callback also can be used to create a conditional assignment of automatic default values:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Db\RawValue;

class Robots extends Model
{
    public function beforeCreate()
    {
        if ($this->price > 10000) {
            $this->type = new RawValue('default');
        }
    }
}
```

Never use a [Phalcon\Db\RawValue](api/Phalcon_Db_RawValue) to assign external data (such as user input) or variable data. The value of these fields is ignored when binding parameters to the query. So it could be used to attack the application injecting SQL.
{: .alert .alert-warning }

## Dynamic Updates

SQL `UPDATE` statements are by default created with every column defined in the model (full all-field SQL update). You can change specific models to make dynamic updates, in this case, just the fields that had changed are used to create the final SQL statement.

In some cases this could improve the performance by reducing the traffic between the application and the database server, this specially helps when the table has blob/text fields:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
```

## Independent Column Mapping

The ORM supports an independent column map, which allows the developer to use different column names in the model to the ones in the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database. This is a great feature when one needs to rename fields in the database without having to worry about all the queries in the code. A change in the column map in the model will take care of the rest. For example:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $code;

    public $theName;

    public $theType;

    public $theYear;

    public function columnMap()
    {
        // Keys are the real names in the table and
        // the values their names in the application
        return [
            'id'       => 'code',
            'the_name' => 'theName',
            'the_type' => 'theType',
            'the_year' => 'theYear',
        ];
    }
}
```

Then you can use the new names naturally in your code:

```php
<?php

use Store\Toys\Robots;

// Find a robot by its name
$robot = Robots::findFirst(
    "theName = 'Voltron'"
);

echo $robot->theName, "\n";

// Get robots ordered by type
$robot = Robots::find(
    [
        'order' => 'theType DESC',
    ]
);

foreach ($robots as $robot) {
    echo 'Code: ', $robot->code, "\n";
}

// Create a robot
$robot = new Robots();

$robot->code    = '10101';
$robot->theName = 'Bender';
$robot->theType = 'Industrial';
$robot->theYear = 2999;

$robot->save();
```

Consider the following when renaming your columns:

* References to attributes in relationships/validators must use the new names
* Refer the real column names will result in an exception by the ORM

The independent column map allows you to:

* Write applications using your own conventions
* Eliminate vendor prefixes/suffixes in your code
* Change column names without change your application code

## Record Snapshots

Specific models could be set to maintain a record snapshot when they're queried. You can use this feature to implement auditing or just to know what fields are changed according to the data queried from the persistence:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}
```

When activating this feature the application consumes a bit more of memory to keep track of the original values obtained from the persistence. In models that have this feature activated you can check what fields changed as follows:

```php
<?php

use Store\Toys\Robots;

// Get a record from the database
$robot = Robots::findFirst();

// Change a column
$robot->name = 'Other name';

var_dump($robot->getChangedFields()); // ['name']

var_dump($robot->hasChanged('name')); // true

var_dump($robot->hasChanged('type')); // false
```

Snapshots are updated on model creation/update. Using `hasUpdated()` and `getUpdatedFields()` can be used to check if fields were updated after a create/save/update but it could potentially cause problems to your application if you execute `getChangedFields()` in `afterUpdate()`, `afterSave()` or `afterCreate()`.

You can disable this functionality by using:

```php
Phalcon\Mvc\Model::setup(
    [
        'updateSnapshotOnSave' => false,
    ]
);
```

or if you prefer set this in your `php.ini`

```ini
phalcon.orm.update_snapshot_on_save = 0
```

Using this functionality will have the following effect:

```php
<?php

use Phalcon\Mvc\Model;

class User extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}

$user = new User();

$user->name = 'Test User';

$user->create();

var_dump(
    $user->getChangedFields()
);

$user->login = 'testuser';

var_dump(
    $user->getChangedFields()
);

$user->update();

var_dump(
    $user->getChangedFields()
);
```

On Phalcon 4.0.0 and later it is:

    array(0) {
    }
    array(1) {
    [0]=> 
        string(5) "login"
    }
    array(0) {
    }
    

`getUpdatedFields()` will properly return updated fields or as mentioned above you can go back to the previous behavior by setting the relevant ini value.

## Pointing to a different schema

If a model is mapped to a table that is in a different schemas/databases than the default. You can use the `setSchema()` method to define that:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setSchema('toys');
    }
}
```

## Setting multiple databases

In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) needs to connect to the database it requests the `db` service in the application's services container. You can overwrite this service setting it in the `initialize()` method:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

// This service returns a MySQL database
$di->set(
    'dbMysql',
    function () {
        return new MysqlPdo(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
);

// This service returns a PostgreSQL database
$di->set(
    'dbPostgres',
    function () {
        return new PostgreSQLPdo(
            [
                'host'     => 'localhost',
                'username' => 'postgres',
                'password' => '',
                'dbname'   => 'invo',
            ]
        );
    }
);
```

Then, in the `initialize()` method, we define the connection service for the model:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setConnectionService('dbPostgres');
    }
}
```

But Phalcon offers you more flexibility, you can define the connection that must be used to `read` and for `write`. This is specially useful to balance the load to your databases implementing a master-slave architecture:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setReadConnectionService('dbSlave');

        $this->setWriteConnectionService('dbMaster');
    }
}
```

The ORM also provides Horizontal Sharding facilities, by allowing you to implement a 'shard' selection according to the current query conditions:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * Dynamically selects a shard
     *
     * @param array $intermediate
     * @param array $bindParams
     * @param array $bindTypes
     */
    public function selectReadConnection($intermediate, $bindParams, $bindTypes)
    {
        // Check if there is a 'where' clause in the select
        if (isset($intermediate['where'])) {
            $conditions = $intermediate['where'];

            // Choose the possible shard according to the conditions
            if ($conditions['left']['name'] === 'id') {
                $id = $conditions['right']['value'];

                if ($id > 0 && $id < 10000) {
                    return $this->getDI()->get('dbShard1');
                }

                if ($id > 10000) {
                    return $this->getDI()->get('dbShard2');
                }
            }
        }

        // Use a default shard
        return $this->getDI()->get('dbShard0');
    }
}
```

The `selectReadConnection()` method is called to choose the right connection, this method intercepts any new query executed:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst('id = 101');
```

## Injecting services into Models

You may be required to access the application services within a model, the following example explains how to do that:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function notSaved()
    {
        // Obtain the flash service from the DI container
        $flash = $this->getDI()->getFlash();

        $messages = $this->getMessages();

        // Show validation messages
        foreach ($messages as $message) {
            $flash->error($message);
        }
    }
}
```

The `notSaved` event is triggered every time that a `create` or `update` action fails. So we're flashing the validation messages obtaining the `flash` service from the DI container. By doing this, we don't have to print messages after each save.

## Disabling/Enabling Features

In the ORM we have implemented a mechanism that allow you to enable/disable specific features or options globally on the fly. According to how you use the ORM you can disable that you aren't using. These options can also be temporarily disabled if required:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'events'         => false,
        'columnRenaming' => false,
    ]
);
```

The available options are:

| Параметр              | Описание                                                                                         | По умолчанию |
| --------------------- | ------------------------------------------------------------------------------------------------ |:------------:|
| astCache              | Enables/Disables callbacks, hooks and event notifications from all the models                    |    `null`    |
| cacheLevel            | Устанавливает уровень кэширования в ORM                                                          |     `3`      |
| castOnHydrate         |                                                                                                  |   `false`    |
| columnRenaming        | Включает/выключает переименование столбцов                                                       |    `true`    |
| disableAssignSetters  | Позволяет выключение сеттеров в вашей модели                                                     |   `false`    |
| enableImplicitJoins   |                                                                                                  |    `true`    |
| enableLiterals        |                                                                                                  |    `true`    |
| escapeIdentifiers     |                                                                                                  |    `true`    |
| events                | Enables/Disables callbacks, hooks and event notifications from all the models                    |    `true`    |
| exceptionOnFailedSave | Включает/выключает выброс исключения если вызов `save()` завершился неудачей                     |   `false`    |
| forceCasting          |                                                                                                  |   `false`    |
| ignoreUnknownColumns  | Включает/выключает игнорирование нераспознанных колонок модели                                   |   `false`    |
| lateStateBinding      | Включает/выключает позднее статическое связывание метода `Phalcon\Mvc\Model::cloneResultMap()` |   `false`    |
| notNullValidations    | ORM автоматически проверяет NOT NULL столбцы, присутствующие в таблице                           |    `true`    |
| parserCache           |                                                                                                  |    `null`    |
| phqlLiterals          | Включает/выключает литералы в PHQL парсере                                                       |    `true`    |
| uniqueCacheId         |                                                                                                  |     `3`      |
| updateSnapshotOnSave  | Включает/выключает обновление снимка при вызове метода `save()`                                  |    `true`    |
| virtualForeignKeys    | Включает/выключает виртуальные внешние ключи                                                     |    `true`    |

> **NOTE** `Phalcon\Mvc\Model::assign()` (which is used also when creating/updating/saving model) is always using setters if they exist when have data arguments passed, even when it's required or necessary. This will add some additional overhead to your application. You can change this behavior by adding `phalcon.orm.disable_assign_setters = 1` to your ini file, it will just simply use `$this->property = value`.
{: .alert .alert-warning }

## Stand-Alone component

Using [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

$di = new Di();

// Настраиваем соединение
$di->set(
    'db',
    new Connection(
        [
            'dbname' => 'sample.db',
        ]
    )
);

// Устанавливаем менеджер модели
$di->set(
    'modelsManager',
    new ModelsManager()
);

// Используем адаптер памяти мета-данных или любой другой
$di->set(
    'modelsMetadata',
    new MetaData()
);

// Создаем модель
class Robots extends Model
{

}

// Используем модель
echo Robots::count();
```