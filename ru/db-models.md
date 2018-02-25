<div class='article-menu'>
  <ul>
    <li>
      <a href="#working-with">Работа с моделями</a> <ul>
        <li>
          <a href="#creating">Создание моделей</a> <ul>
            <li>
              <a href="#properties-setters-getters">Публичные свойства или геттеры/сеттеры</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#records-to-objects">Понимание записей в объектах</a>
        </li>
        <li>
          <a href="#finding-records">Поиск записей</a> <ul>
            <li>
              <a href="#resultsets">Возвращение результатов моделью</a>
            </li>
            <li>
              <a href="#filters">Фильтрация результатов</a>
            </li>
            <li>
              <a href="#binding-parameters">Привязка параметров</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#preparing-records">Инициализация/изменение полученных записей</a>
        </li>
        <li>
          <a href="#calculations">Использование расчетов</a>
        </li>
        <li>
          <a href="#create-update-records">Создание/обновление записей</a> <ul>
            <li>
              <a href="#create-update-with-confidence">Создание/обновление с уверенностью</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#delete-records">Удаление записей</a>
        </li>
        <li>
          <a href="#hydration-modes">Режимы гидрации</a>
        </li>
        <li>
          <a href="#identity-columns">Автоматически генерируемый столбец</a>
        </li>
        <li>
          <a href="#skipping-columns">Пропуск столбцов</a>
        </li>
        <li>
          <a href="#dynamic-updates">Динамические обновления</a>
        </li>
        <li>
          <a href="#column-mapping">Независимое сопоставление столбцов</a>
        </li>
        <li>
          <a href="#record-snapshots">Запись снимков</a>
        </li>
        <li>
          <a href="#different-schemas">Ссылка на другую схему</a>
        </li>
        <li>
          <a href="#multiple-databases">Настройка нескольких баз данных</a>
        </li>
        <li>
          <a href="#injecting-services-into-models">Внедрение сервисов в модели</a>
        </li>
        <li>
          <a href="#disabling-enabling-features">Отключение/включение возможностей</a>
        </li>
        <li>
          <a href="#stand-alone-component">Самостоятельный компонент</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='working-with'></a>

# Работа с моделями

Модель представляет собой информацию (данные) приложения и правила для манипуляции этими данными. Модели в основном используется для управления соответствующей таблицей базы данных и правил взаимодействия с ней. В большинстве случаев, каждая таблица в вашей базе данных соответствует одной модели в вашем приложении. Большая часть всей бизнес-логики вашего приложения будет сосредоточена в моделях.

`Phalcon\Mvc\Model` является базовым классом для всех моделей в Phalcon-приложении. Он обеспечивает независимость данных от вашей базы, основные CRUD операции, расширенные поисковые возможности, а также возможность построения зависимостей между моделями. `Phalcon\Mvc\Model` исключает необходимость использования SQL запросов, потому как данный класс динамически переводит методы на соответствующие им операции СУБД.

<h5 class='alert alert-warning'>Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the <code>Phalcon\Db</code> component documentation.</h5>

<a name='creating'></a>

## Создание модели

Модель — это класс, который унаследован от `Phalcon\Mvc\Model`. Имя класса должно быть записано в CamelCase стиле:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{

}
```

<h5 class='alert alert-warning'>If you're using PHP 5.4/5.5 it is recommended you declare each column that makes part of the model in order to save memory and reduce the memory allocation. </h5>

По умолчанию модель `Store\Toys\RobotParts` будет ссылаться на таблицу `robot_parts`. Если вы хотите вручную указать другое имя для таблицы, вы можете использовать метод `setSource()`:

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

Теперь модель `RobotParts` отображается на таблицу `toys_robot_parts`. Метод `initialize()` обеспечивает возможность применять пользовательские настройки, например, название таблицы.

Метод `initialize()` вызывается только один раз во время запроса. Этот метод предназначен для инициализации экземпляров модели в приложении. Если вам необходимо произвести некоторые настройки экземпляра объекта после того, как он создан, вы можете использовать метод `onConstruct()`:

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

<a name='properties-setters-getters'></a>

### Публичные свойства или геттеры/сеттеры

Модели могут быть реализованы с помощью публичных свойств, при этом свойства модели доступны для чтения/изменения из любой части кода без ограничений:

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

<h5 class='alert alert-warning'>Underscores in property names can be problematic when using getters and setters. </h5>

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use with magic methods. (e.g. `$model->getPropertyName` instead of `$model->getProperty_name`, `$model->findByPropertyName` instead of `$model->findByProperty_name`, etc.). As much of the system expects camel case, and underscores are commonly removed, it is recommended to name your properties in the manner shown throughout the documentation. You can use a column map (as described above) to ensure proper mapping of your properties to their database counterparts.

<a name='records-to-objects'></a>

## Понимание записей в объектах

Каждый экземпляр объекта модели представляет собой строку таблицы базы данных. Вы можете легко получить доступ к любой записи, считывая свойство объекта. К примеру, для таблицы “robots” с записями:

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

Вы можете найти определенную запись по ее первичному ключу и напечатать её имя:

```php
<?php

use Store\Toys\Robots;

// Поиск записи с id = 3
$robot = Robots::findFirst(3);

// Вывод 'Terminator'
echo $robot->name;
```

Как только запись будет зарезервирована в памяти, мы можете производить изменения ее данных, а затем сохранить изменения:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(3);

$robot->name = 'RoboCop';

$robot->save();
```

Как вы можете видеть, нет никакой необходимости в использовании необработанных SQL запросов. `Phalcon\Mvc\Model` предоставляет высший уровень абстракции базы данных для веб-приложений.

<a name='finding-records'></a>

## Поиск записей

`Phalcon\Mvc\Model` также предлагает несколько методов для выборки записей. В следующем примере мы покажем вам как запросить одну или несколько записей из модели:

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

<h5 class='alert alert-warning'>If you want find record by external data (such as user input) or variable data you must use <a href="#binding-parameters">Binding Parameters</a>`.</h5>

Вы также можете использовать метод `findFirst()`, чтобы получить только первую запись для данного критерия:

```php
<?php

use Store\Toys\Robots;

// Первый робот в таблице роботов
$robot = Robots::findFirst();
echo 'Название робота: ', $robot->name, "\n";

// Первый механический робот в таблице роботов
$robot = Robots::findFirst("type = 'mechanical'");
echo 'Название первого механического робота: ', $robot->name, "\n";

// Получим первого виртуального робота, упорядочив результат по имени
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);

echo 'Название первого виртуального робота: ', $robot->name, "\n";
```

Оба метода `find()` и `findFirst()` принимают ассоциативный массив, определяющий критерии поиска:

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

Доступные параметры запроса:

| Параметр      | Описание                                                                                                                                                                                                      | Пример                                                               |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | Условие поиска. Используется для выделения только тех записей, которые полностью удовлетворяют условиям поиска. По умолчанию `Phalcon\Mvc\Model` предполагает что первый параметр является условием поиска. | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | Используется для указания списка столбцов возвращаемого в модели. Объект будет не полным при использовании этого параметра.                                                                                   | `'columns' => 'id, name'`                                         |
| `bind`        | Используется вместе с условием поиска для подстановки значений вместо соответствующих псевдопеременных и экранирования значений для увеличения безопасности.                                                  | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | При использовании подстановки значений вместо псевдопеременных, вы можете использовать этот параметр, для указания типа данных, что еще больше увеличит безопасность.                                         | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | Используется для сортировки результатов. Можно использовать несколько полей через запятую.                                                                                                                    | `'order' => 'name DESC, status'`                                  |
| `limit`       | Ограничивает результаты запроса.                                                                                                                                                                              | `'limit' => 10`                                                   |
| `offset`      | Смещает результаты запроса на определенное значение.                                                                                                                                                          | `'offset' => 5`                                                   |
| `group`       | Позволяет выбирать данные используя несколько записей и группировать результат по одному или нескольким столбцам.                                                                                             | `'group' => 'name, status'`                                       |
| `for_update`  | С этой опцией, `Phalcon\Mvc\Model` читает последние доступные данные и устанавливает исключительные блокировки (Exclusive Lock) на каждую прочтенную запись.                                                | `'for_update' => true`                                            |
| `shared_lock` | С этой опцией, `Phalcon\Mvc\Model` читает последние доступные данные и устанавливает общие блокировки (Shared Lock) на каждую прочтенную запись.                                                            | `'shared_lock' => true`                                           |
| `cache`       | Кэширует результаты, уменьшая нагрузку на реляционную систему.                                                                                                                                                | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | Устанавливает режим гидратации для представления каждой записи в результате.                                                                                                                                  | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

Существует еще один вариант записи запросов поиска, в объектно-ориентированном стиле:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::query()
    ->where('type = :type:')
    ->andWhere('year < 2000')
    ->bind(['type' => 'mechanical'])
    ->order('name')
    ->execute();
```

Статический метод `query()` возвращает объект `Phalcon\Mvc\Model\Criteria`, который дружественен к автокомплиту для среды разработки.

Все запросы внутри обрабатываются как [PHQL](/[[language]]/[[version]]/db-phql) запросы. PHQL это высокоуровневый, объектно-ориентированный, SQL подобный язык. Этот язык предоставляет вам больше возможностей для выполнения запросов, таких как объединение с другими моделями, определение группировок, добавление агрегации и т.д.

Наконец, имеется метод `findFirstBy<property-name>()`. Данный метод расширяет упомянутый ранее `findFirst()`. Он позволяет вам выполнять поиск по таблице, используя название свойства в самом методе, и, передавая ему параметр, содержащий информацию по которой вы хотите произвести поиск в столбце. В качестве примера возьмем упомянутую ранее модель Robots:

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

Мы имеем три свойства, с которыми можно работать: `$id`, `$name` и `$price`. Допустим, вы хотите получить первую запись с именем ‘Terminator’. Можно сделать это следующим образом:

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

Заметьте, что мы используем 'Name' в вызове метода, а также передаем ему переменную `$name`, содержащую имя, которое мы ищем в таблице. Также обратите внимание, что если по запросу была найдена запись, то и все остальные свойства тоже доступны.

<a name='resultsets'></a>

### Возвращение результатов моделью

В то время как `findFirst()` возвращает непосредственно экземпляр вызванного класса (когда это возвращаемые данные), метод `find()` возвращает `Phalcon\Mvc\Model\Resultset\Simple`. Этот объект инкапсулирует в себя весь функционал такой как, итерирование, поиск определенных записей, подсчёт и прочее.

Эти объекты являются более мощными, чем стандартные массивы. Одной из важнейших особенностей `Phalcon\Mvc\Model\Resultset` является то, что в любой момент времени в памяти содержится только одна запись. Это очень помогает в управлении памятью, особенно при работе с большими объемами данных.

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

Набор результатов в Phalcon эмулирует перемещаемый курсор, вы можете получить любую строку по её позиции, или установив внутренний указатель в конкретную позицию. Обратите внимание, что некоторые системы баз данных не поддерживают курсоры с прокруткой, это заставляет базу данных повторно выполнять запрос для того, чтобы перемотать курсор в начало и получить запись в запрашиваемой позиции. Аналогично, если набор результатов вызывается несколько раз, то и запрос должен быть выполнен такое же количество раз.

Хранение больших результатов запроса в памяти может потребовать много ресурсов, из-за этого наборы результатов получаются из базы данных блоками по 32 строки, снижая потребность в повторном выполнении запроса, в ряде случаев экономя память.

Обратите внимание, что наборы результатов могут быть сериализованы и храниться в кэше бэкэнда. `Phalcon\Cache` может помочь с этой задачей. Тем не менее, сериализация данных заставляет `Phalcon\Mvc\Model` получить все данные из базы данных в массив, таким образом, в процессе потребляя больше памяти.

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

<a name='custom-resultsets'></a>

### Custom Resultsets

There are times that the application logic requires additional manipulation of the data as it is retrieved from the database. Previously, we would just extend the model and encapsulate the functionality in a class in the model or a trait, returning back to the caller usually an array of transformed data.

With custom resultsets, you no longer need to do that. The custom resultset will encapsulate the functionality that otherwise would be in the model and can be reused by other models, thus keeping the code [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself). This way, the `find()` method will no longer return the default `Phalcon\Mvc\Model\Resultset`, but instead the custom one. Phalcon allows you to do this by using the `getResultsetClass()` in your model.

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
    public function getSource()
    {
        return 'robots';
    }

    public function getResultsetClass()
    {
    return 'Application\Mvc\Model\Resultset\Custom';
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
        'order'      => 'date'
    ]
);

/**
 * Pass the data to the view
 */
$this->view->mydata = $robots->getSomeData();
```

<a name='filters'></a>

### Фильтрация результатов

Самый эффективный способ фильтрации данных — задание поисковых критериев. База данных сможет использовать индексирование, чтобы быстрее вернуть результат. В дополнение, Phalcon позволяет вам производить фильтрацию данных с помощью PHP, расширяя тем самым возможности базы данных:

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

<a name='binding-parameters'></a>

### Привязка параметров

Также, в `Phalcon\Mvc\Model` поддерживается привязка параметров. Использование привязки параметров рекомендуется, чтобы исключить возможность SQL инъекции. Привязка параметров поддерживает строки и числа. Связывание параметров может быть легко достигнуто следующим образом:

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

При использовании цифровых указателей, необходимо определить их как целые числа, то есть `1` or `2`. В этом случае `'1'` или `'2'` считаются строками, а не числами, поэтому псевдопеременная не может быть заменена.

Строки автоматически экранируются используя [PDO](http://php.net/manual/en/pdo.prepared-statements.php). Эта функция принимает во внимание кодировку подключения, поэтому рекомендуется определить корректную кодировку в параметрах подключения или в конфигурации сервера баз данных, так как ошибочная кодировка приведет к неожиданным эффектам при сохранении или извлечении данных.

Кроме того, вы можете установить параметр `bindTypes`, что позволит определить, каким образом параметры должны быть связаны в соответствии с их типами данных:

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

<h5 class='alert alert-warning'>Since the default bind-type is <code>Phalcon\Db\Column::BIND_PARAM_STR</code>, there is no need to specify the 'bindTypes' parameter if all of the columns are of that type.</h5>

Если вы связываете массивы с параметрами, то помните, что нумерация ключей должна начинаться с нуля:

```php
<?php

use Store\Toys\Robots;

$array = ['a','b','c']; // $array: [[0] => 'a', [1] => 'b', [2] => 'c']

unset($array[1]); // $array: [[0] => 'a', [2] => 'c']

// Теперь необходимо перенумеровать ключи
$array = array_values($array); // $array: [[0] => 'a', [1] => 'c']

$robots = Robots::find(
    [
        'letter IN ({letter:array})',
        'bind' => [
            'letter' => $array
        ]
    ]
);
```

<h5 class='alert alert-warning'>Bound parameters are available for all query methods such as <code>find()</code> and <code>findFirst()</code> but also the calculation methods like <code>count()</code>, <code>sum()</code>, <code>average()</code> etc. </h5>

If you're using 'finders', bound parameters are automatically used:

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

<a name='preparing-records'></a>

## Инициализация/изменение полученных записей

Бывают случаи, что после получения записи из базы данных необходимо инициализировать данные перед их использованием остальной частью приложения. Вы можете определить в модели метод `afterFetch()`. Этот метод будет выполнен сразу после создания экземпляра записи и получения им данных:

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

Независимо от того, используете вы геттеры/сеттеры или публичные свойства, вы можете реализовать обработку поля при получении доступа к последнему:

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

<a name='calculations'></a>

## Использование расчетов

Расчеты (или агрегатные функции) являются помощниками для часто используемых функций СУБД, таких как `COUNT`, `SUM`, `MAX`, `MIN` или `AVG`. `Phalcon\Mvc\Model` позволяет использовать эти функции непосредственно с доступными методами.

Пример подсчёта:

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
    'area = 'Testing''
);

// Посчитать сотрудников, сгруппировав результаты по сфере деятельности
$group = Employees::count(
    [
        'group' => 'area',
    ]
);
foreach ($group as $row) {
   echo $row->rowcount, ' сотрудников в ', $row->area;
}

// Посчитать сотрудников, сгруппировав результаты по сфере деятельности, и упорядочив их по количеству
$group = Employees::count(
    [
        'group' => 'area',
        'order' => 'rowcount',
    ]
);

// Избегайте SQL инъекции, используя связанные параметры
$group = Employees::count(
    [
        'type > ?0',
        'bind' => [
            $type
        ],
    ]
);
```

Пример суммы:

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

// Группирует заработные платы по каждой сфере деятельности
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
    ]
);
foreach ($group as $row) {
   echo 'Сумма заработной платы ', $row->area, ' составляет ', $row->sumatory;
}

// Группирует заработные платы по каждой сферы деятельности
// и упорядочивает их от большего к меньшему
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
        'order'  => 'sumatory DESC',
    ]
);

// Избегайте SQL инъекции, используя связанные параметры
$group = Employees::sum(
    [
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

Пример поиска среднего:

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

// Избегайте SQL инъекции, используя связанные параметры
$average = Employees::average(
    [
        'column'     => 'age',
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

Пример нахождения максимального/минимального:

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

<a name='create-update-records'></a>

## Создание/обновление записей

Метод `Phalcon\Mvc\Model::save()` позволяет создавать/обновлять записи в зависимости от того, существуют ли они уже в таблице, связанной с моделью. Метод save вызывается методами create и update класса `Phalcon\Mvc\Model`. Для этого необходимо иметь в таблице должным образом установленный первичный ключ, чтобы можно было определить, должна ли запись быть обновлена или создана.

Также метод выполняет связанные валидаторы, виртуальные внешние ключи и события, которые определены в модели:

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

В метод `save` может быть передан массив, чтобы избежать назначения каждого столбца вручную. `Phalcon\Mvc\Model` проверит, есть ли сеттеры, реализованные для столбцов, для значений переданных в массиве, отдавая приоритет им, вместо непосредственно назначения значений свойствам:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save(
    [
        'type' => 'mechanical',
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

Значения, назначеные непосредственно через атрибуты или через массив, экранируются/проверяются в соответствии с типом данных атрибута. Таким образом, вы можете передать ненадежный массив, не беспокоясь о возможных SQL инъекциях:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save($_POST);
```

<h5 class='alert alert-warning'>Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted form. </h5>

Вы можете передать дополнительный параметр в метод `save`, чтобы установить список полей, которые должны быть прининяты во внимание при массовом присваивании:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save(
    $_POST,
    [
        'name',
        'type',
    ]
);
```

<a name='create-update-with-confidence'></a>

### Создание/обновление с уверенностью

При разработке мы можем столкнуться с ситуацией, когда две идентичные записи происходят одновременно. Это может произойти, если мы используем `Phalcon\Mvc\Model::save()` для сохранения элемента в БД. Если мы хотим быть абсолютно уверены, что запись будет создана или обновлена, мы можем заменить `save()` на вызов `create()` или `update()`:

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

Методы `create` и 'update' также принимают массив значений в качестве параметра.

<a name='delete-records'></a>

## Удаление записей

Метод `Phalcon\Mvc\Model::delete()` позволяет удалить запись. Вы можете использовать его следующим образом:

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

Вы также можете удалить несколько записей путем обхода набора результатов в цикле foreach:

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

Следующие события, доступные для определения пользовательской бизнес-логики, вызываются при выполнении операции удаления:

| Операция | Название     | Можно остановить операцию? | Пояснение                                |
| -------- | ------------ |:--------------------------:| ---------------------------------------- |
| Удаление | beforeDelete |            Yes             | Runs before the delete operation is made |
| Удаление | afterDelete  |             No             | Runs after the delete operation was made |

В событиях, указанных выше, также можно определять бизнес-логику модели:

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

<a name='hydration-modes'></a>

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

Hydration mode can also be passed as a parameter of 'find':

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

<a name='identity-columns'></a>

## Автоматически генерируемый столбец

Some models may have identity columns. These columns usually are the primary key of the mapped table. `Phalcon\Mvc\Model` can recognize the identity column omitting it in the generated SQL `INSERT`, so the database system can generate an auto-generated value for it. Always after creating a record, the identity field will be registered with the value generated in the database system for it:

```php
<?php

$robot->save();

echo 'The generated id is: ', $robot->id;
```

`Phalcon\Mvc\Model` is able to recognize the identity column. Depending on the database system, those columns may be serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

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

<a name='skipping-columns'></a>

## Пропуск столбцов

To tell `Phalcon\Mvc\Model` that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

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

<h5 class='alert alert-warning'>Never use a <code>Phalcon\Db\RawValue</code> to assign external data (such as user input) or variable data. The value of these fields is ignored when binding parameters to the query. So it could be used to attack the application injecting SQL. </h5>

<a name='dynamic-updates'></a>

## Динамические обновления

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

<a name='column-mapping'></a>

## Независимое сопоставление столбцов

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

- References to attributes in relationships/validators must use the new names
- Refer the real column names will result in an exception by the ORM

The independent column map allows you to:

- Write applications using your own conventions
- Eliminate vendor prefixes/suffixes in your code
- Change column names without change your application code

<a name='record-snapshots'></a>

## Запись снимков

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

<a name='different-schemas'></a>

## Ссылка на другую схему

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

<a name='multiple-databases'></a>

## Настройка нескольких баз данных

In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when `Phalcon\Mvc\Model` needs to connect to the database it requests the `db` service in the application's services container. You can overwrite this service setting it in the `initialize()` method:

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

<a name='injecting-services-into-models'></a>

## Внедрение сервисов в модели

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

<a name='disabling-enabling-features'></a>

## Отключение/включение возможностей

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

| Option             | Description                                                                               | По умолчанию |
| ------------------ | ----------------------------------------------------------------------------------------- |:------------:|
| events             | Enables/Disables callbacks, hooks and event notifications from all the models             |    `true`    |
| columnRenaming     | Enables/Disables the column renaming                                                      |    `true`    |
| notNullValidations | The ORM automatically validate the not null columns present in the mapped table           |    `true`    |
| virtualForeignKeys | Enables/Disables the virtual foreign keys                                                 |    `true`    |
| phqlLiterals       | Enables/Disables literals in the PHQL parser                                              |    `true`    |
| lateStateBinding   | Enables/Disables late state binding of the `Phalcon\Mvc\Model::cloneResultMap()` method |   `false`    |

<a name='stand-alone-component'></a>

## Самостоятельный компонент

Using `Phalcon\Mvc\Model` in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

$di = new Di();

// Setup a connection
$di->set(
    'db',
    new Connection(
        [
            'dbname' => 'sample.db',
        ]
    )
);

// Set a models manager
$di->set(
    'modelsManager',
    new ModelsManager()
);

// Use the memory meta-data adapter or other
$di->set(
    'modelsMetadata',
    new MetaData()
);

// Create a model
class Robots extends Model
{

}

// Use the model
echo Robots::count();
```