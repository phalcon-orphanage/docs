Кэширование в ORM
=================

Каждое приложение уникально: у нас могут быть модели c часто изменяемыми данными, так и модели с данными,
которые редко  изменяют свои значения. Обращение к базе данных часто является одним из наиболее распространенных
узких мест в плане производительности приложения. Это связано со сложными процессами подключения/коммуникации,
которые PHP должен выполнять при каждом запросе к базе данных для получения требуемых данных. Поэтому, если мы
хотим добиться хорошей производительности, мы должны добавить несколько слоев кэширования, когда приложение в
этом нуждается.

В этой главе рассматриваются места, где можно реализовать кэширование для повышения производительности. Фреймворк
дает вам инструмент для реализации кэша, в тех местах, где вам нужно в соответствии с архитектурой приложения.

Кэширование наборов данных
--------------------------
Существует методика, позволяющая избежать постоянного обращения к базе данных. Это - кэширование редко изменяемых
наборов данных, используя систему с более быстрым доступом (обычно это память).

Когда :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` требуется сервис для кэша набоов данных, он будет
запрашивать у контейнера зависимостей этот сервис с именем «modelsCache».

Phalcon предоставляет компонент :doc:`cache <cache>` для кэширования любых данных, мы объясним как интегрировать
его с моделями. Во-первых, вы должны зарегистрировать его в качестве сервиса в контейнере зависимостей:

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Data as FrontendData;
    use Phalcon\Cache\Backend\Memcache as BackendMemcache;

    // Регистрация сервиса кэша моделей
    $di->set(
        "modelsCache",
        function () {
            // По умолчанию данные кэша хранятся один день
            $frontCache = new FrontendData(
                [
                    "lifetime" => 86400,
                ]
            );

            // Настройки соединения с memcached
            $cache = new BackendMemcache(
                $frontCache,
                [
                    "host" => "localhost",
                    "port" => "11211",
                ]
            );

            return $cache;
        }
    );

Вы имеете полный контроль в создании и настройке кэша перед его использованием путем регистрации сервиса в
качестве анонимной функции. После того, как настройка кэша правильно определена, можно кэшировать наборы данных:

.. code-block:: php

    <?php

    // Получить продукта без кэширования
    $products = Products::find();

    // Используем кэширование наборов данных. Кэш остается в памяти в течении 1 часа (3600 секунд).
    $products = Products::find(
        [
            "cache" => [
                "key" => "my-cache",
            ],
        ]
    );

    // Кэш набора данных хранится всего 5 минут
    $products = Products::find(
        [
            "cache" => [
                "key"      => "my-cache",
                "lifetime" => 300,
            ],
        ]
    );

    // Мы используем сервис 'cache' из DI вместо 'modelsCache'
    $products = Products::find(
        [
            "cache" => [
                "key"     => "my-cache",
                "service" => "cache",
            ],
        ]
    );

Кэш может быть также применен к набору данных, генерируемых с помощью отношений:

.. code-block:: php

    <?php

    // Запрос некоторого сообщения
    $post = Post::findFirst();

    // Получаем комментарии, относящиеся к сообщению, и кэшируем их
    $comments = $post->getComments(
        [
            "cache" => [
                "key" => "my-key",
            ],
        ]
    );

    // Получаем комментарии, относящиеся к сообщению и устанавливаем срок их хранения
    $comments = $post->getComments(
        [
            "cache" => [
                "key"      => "my-key",
                "lifetime" => 3600,
            ],
        ]
    );

Когда кэшируемые наборы данных должны быть признаны недействительными, вы можете просто удалить их из кэша с
использованием ранее указанного ключа.

Обратите внимание, что не все наборы данных должны быть в кэше. Данные, которые меняют свои значения очень
часто, не следует кэшировать, так как они становятся не действительными очень быстро, и кэширование в этом случаи
отрицательно влияет на производительность приложения. Кроме того, большие наборы данных, которые не часто
меняют свои значения, могут располагаться в кэше, но для реализации этой идеи необходимо оценить имеющиеся
механизмы кэширования  и влияния на производительность, так как это не всегда будет способствовать увеличению
производительности приложения.

Форсирование кэша
-----------------
Ранее мы видели, как :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` имеет встроенную интеграцию с компонентом
кэширования, предоставленного фреймворком. Чтобы сделать запись/результирующий набор кэшируемым,
мы передаем ключ 'cache' в массиве параметров:

.. code-block:: php

    <?php

    // Кэшируем результирующий набор всего на 5 минут
    $products = Products::find(
        [
            "cache" => [
                "key"      => "my-cache",
                "lifetime" => 300,
            ],
        ]
    );

Это дает нам свободу для кэширования конкретных запросов, поэтому, если мы хотим кэшировать
глобально все запросы, выполняемые моделью, мы можем переопределить метод :code:`find()`/:code:`findFirst()`,
чтобы заставить кэшировать каждый запрос.

.. code-block:: php

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
                    $uniqueKey[] = $key . ":" . $value;
                } elseif (is_array($value)) {
                    $uniqueKey[] = $key . ":[" . self::_createKey($value) . "]";
                }
            }

            return join(",", $uniqueKey);
        }

        public static function find($parameters = null)
        {
            // Преобразование параметров в массив
            if (!is_array($parameters)) {
                $parameters = [$parameters];
            }

            // Проверяем, что ключ кэша не был передан
            // и создаем параметры кэша
            if (!isset($parameters["cache"])) {
                $parameters["cache"] = [
                    "key"      => self::_createKey($parameters),
                    "lifetime" => 300,
                ];
            }

            return parent::find($parameters);
        }

        public static function findFirst($parameters = null)
        {
            // ...
        }
    }

Доступ к базе данных в несколько раз медленнее, чем вычисление ключа кэша, вы свободны в
реализации стратегии генерации ключа, которая лучше подходит для ваших задач.  Следует
отметить, что хороший ключ позволяет избежать конфликтов, насколько это возможно, это
означает, что разные ключи возвращают при поиске независимые наборы записей.

Это дает вам полный контроль над тем, как кэши должны быть реализованы для
каждой модели, эта стратегия может быть общей для нескольких моделей,
которую можно вынести в отдельный базовый класс для всех подобных классов:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class CacheableModel extends Model
    {
        protected static function _createKey($parameters)
        {
            // ... создание ключа кэширования на основе параметров
        }

        public static function find($parameters = null)
        {
            // ... какая-то стратегия кэширования
        }

        public static function findFirst($parameters = null)
        {
            // ... какая-то стратегия кэширования
        }
    }

Затем используйте этот класс в качестве базового класса для каждой модели 'Cacheable':

.. code-block:: php

    <?php

    class Robots extends CacheableModel
    {

    }

Кэширование PHQL запросов
-------------------------
Все запросы в ORM, независимо от того, насколько высокоуровневый синтаксис
мы использовали для их создания, обрабатываются внутри с помощью PHQL. Этот
язык дает гораздо больше свободы для создания запросов всех видов. Конечно,
эти запросы могут кэшироваться:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE name = :name:";

    $query = $this->modelsManager->createQuery($phql);

    $query->cache(
        [
            "key"      => "cars-by-name",
            "lifetime" => 300,
        ]
    );

    $cars = $query->execute(
        [
            "name" => "Audi",
        ]
    );

Многократное использование связанных записей
--------------------------------------------
Некоторые модели могут иметь связи с другими моделями. Это позволяет нам легко проверить записи,
которые относятся к экземплярам в памяти:

.. code-block:: php

    <?php

    // Получаем некоторый счет
    $invoice = Invoices::findFirst();

    // Получаем клиента, связанного со счетом
    $customer = $invoice->customer;

    // Выводим его/ее имя
    echo $customer->name, "\n";

Этот очень простой пример. Клиент был получен при помощи запроса в базу данных и он может
быть использован при необходимости, например, для вывода имени владельца счета. Это также
касается случаев, когда мы извлекаем наборы счетов и хотим вывести владельцев этих счетов:

.. code-block:: php

    <?php

    // Получаем набор счетов
    // SELECT * FROM invoices;
    $invoices = Invoices::find();

    foreach ($invoices as $invoice) {
        // Получаем клиента связанного с заказом
        // SELECT * FROM customers WHERE id = ?;
        $customer = $invoice->customer;

        // Выводим имя клиента
        echo $customer->name, "\n";
    }

В этом примере клиент может иметь один или несколько счетов. Это означает, что клиент
может быть запрошен из базы данных более одного раза. Чтобы избежать этого, мы можем
отметить связь как многоразовую , таким образом, мы говорим ORM автоматически использовать
прошлые записи вместо того, чтобы вновь и вновь выполнять одни и те же запросы:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Invoices extends Model
    {
        public function initialize()
        {
            $this->belongsTo(
                "customers_id",
                "Customer",
                "id",
                [
                    "reusable" => true,
                ]
            );
        }
    }

Этот кэш работает только в памяти, это означает, что кэшированные данные
предоставляются, когда запрос уже был выполнен.

Кэширование связанных записей
-----------------------------
Когда запрашиваются связанные запись, внутри ORM строится соответствующие состояние,
и передаются необходимые записи с помощью Find / FindFirst в целевую модель в
соответствии со следующей таблицей:

+------------+----------------------------------------------------------------------+---------------------+
| Тип        | Описание                                                             | Вызываемый метод    |
+============+======================================================================+=====================+
| Belongs-To | Возвращает непосредственно экземпляр модели, взаимосвязанной записи  | :code:`findFirst()` |
+------------+----------------------------------------------------------------------+---------------------+
| Has-One    | Возвращает непосредственно экземпляр модели, взаимосвязанной записи  | :code:`findFirst()` |
+------------+----------------------------------------------------------------------+---------------------+
| Has-Many   | Возвращает коллекцию экземпляров модели, которые ссылаются на модель | :code:`find()`      |
+------------+----------------------------------------------------------------------+---------------------+

Это означает, что когда вы получаете связанные записи, вы можете изменить способ
получения данных путем реализации соответствующего метода:

.. code-block:: php

    <?php

    // Получаем счет
    $invoice = Invoices::findFirst();

    // Получаем владельца счета
    $customer = $invoice->customer; // Invoices::findFirst("...");

    // То же самое
    $customer = $invoice->getCustomer(); // Invoices::findFirst("...");

Соответственно, мы могли бы заменить метод FindFirst в моделе счетов и осуществлять кэширование наиболее подходящим способом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Invoices extends Model
    {
        public static function findFirst($parameters = null)
        {
            // ... здесь реализуем кэширование данных
        }
    }

Рекурсивное кэшировоние связанных записей
-----------------------------------------
В этом сценарии мы предполагаем, что каждый раз, когда мы запрашиваем набор данных, мы также получаем
все связанные записи для данного набора. Если мы будем хранить записи, найденные вместе с их связанными
сущностями, возможно, мы сможем немного уменьшить накладные расходы для получения всех сущностей:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Invoices extends Model
    {
        protected static function _createKey($parameters)
        {
            // ... создаем ключ кэша на основе параметров
        }

        protected static function _getCache($key)
        {
            // ... возвращаем данные из кэша
        }

        protected static function _setCache($key, $results)
        {
            // ... сохраняет данные в кэше
        }

        public static function find($parameters = null)
        {
            // Создать уникальный ключ
            $key = self::_createKey($parameters);

            // Проверяем наличие данных в кэше
            $results = self::_getCache($key);

            // Полученные данные должны быть объектом
            if (is_object($results)) {
                return $results;
            }

            $results = [];

            $invoices = parent::find($parameters);

            foreach ($invoices as $invoice) {
                // Получение соответствующего клиента
                $customer = $invoice->customer;

                // Помещаем его в запись
                $invoice->customer = $customer;

                $results[] = $invoice;
            }

            // Сохраняем счета и их клиентов в кэше
            self::_setCache($key, $results);

            return $results;
        }

        public function initialize()
        {
            // ... добавляем связи и инициализируем другие вещи
        }
    }

Получение из кэша счетов, уже содержащих данные о клиентах, выполняется всего за одно
действие, что снижает общую нагрузку на данную операцию. Следует отметить, что этот
процесс можно также проводить с PHQL с помощью следующего альтернативного решения:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Invoices extends Model
    {
        public function initialize()
        {
            // ... добавляем связи и инициализируем другие вещи
        }

        protected static function _createKey($conditions, $params)
        {
            // ... создаем ключ кэша на основе параметров
        }

        public function getInvoicesCustomers($conditions, $params = null)
        {
            $phql = "SELECT Invoices.*, Customers.* FROM Invoices JOIN Customers WHERE " . $conditions;

            $query = $this->getModelsManager()->executeQuery($phql);

            $query->cache(
                [
                    "key"      => self::_createKey($conditions, $params),
                    "lifetime" => 300,
                ]
            );

            return $query->execute($params);
        }

    }

Кэширование на основе условий
-----------------------------
В этом случае, кэш реализуется  в соответствии с текущими полученными условиями.
В соответствии с областью, куда попадает первичный ключ, выбирается соответствующий способ кэширования.

+---------------------+--------------------+
| Значение            | Способ кэширования |
+=====================+====================+
| 1 - 10000           | mongo1             |
+---------------------+--------------------+
| 10000 - 20000       | mongo2             |
+---------------------+--------------------+
| > 20000             | mongo3             |
+---------------------+--------------------+

Самый простой способ - это добавление статического метода к модели, который выбирает правильный кэш для использования:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public static function queryCache($initial, $final)
        {
            if ($initial >= 1 && $final < 10000) {
                $service = "mongo1";
            } elseif ($initial >= 10000 && $final <= 20000) {
                $service = "mongo2";
            } elseif ($initial > 20000) {
                $service = "mongo3";
            }

            return self::find(
                [
                    "id >= " . $initial . " AND id <= " . $final,
                    "cache" => [
                        "service" => $service,
                    ],
                ]
            );
        }
    }

Такой подход решает проблему, однако, если мы хотим добавить другие параметры,
такие как сортировка или условия, мы должны были бы создать более сложный метод.
Кроме того, этот метод не работает, если данные получаются с использованием
связанных записей или :code:`find()`/:code:`findFirst()`:

.. code-block:: php

    <?php

    $robots = Robots::find("id < 1000");
    $robots = Robots::find("id > 100 AND type = 'A'");
    $robots = Robots::find("(id > 100 AND type = 'A') AND id < 2000");

    $robots = Robots::find(
        [
            "(id > ?0 AND type = 'A') AND id < ?1",
            "bind"  => [100, 2000],
            "order" => "type",
        ]
    );

Для достижения этой цели мы должны перехватить промежуточное представление (IR),
порожденную PHQL анализатором и таким образом получить возможность настроить
способы кэширования:

Для начала, необходимо реализовать пользовательский конструктор запросов,
в котором мы сможем генерировать полностью настраиваемые запросы к базе данных:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;

    class CustomQueryBuilder extends QueryBuilder
    {
        public function getQuery()
        {
            $query = new CustomQuery($this->getPhql());

            $query->setDI($this->getDI());

            return $query;
        }
    }

Вместо того, чтобы непосредственно возвращать :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>`,
наш конструктор возвращает экземпляр класса CustomQuery, этот класс выглядит
следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Query as ModelQuery;

    class CustomQuery extends ModelQuery
    {
        /**
         * Переопределение метода execute
         */
        public function execute($params = null, $types = null)
        {
            // Разбор промежуточных представлений для SELECT
            $ir = $this->parse();

            // Проверяем, что наш запрос имеет условия
            if (isset($ir["where"])) {
                // Поля в условии могут иметь любой порядок
                // Нам нужно рекурсивно проверить дерево условий,
                // чтобы найти информацию, которую мы ищем
                $visitor = new CustomNodeVisitor();

                // Рекурсивно просматриваем узлы
                $visitor->visit($ir["where"]);

                $initial = $visitor->getInitial();
                $final   = $visitor->getFinal();

                // Выбираем кэш в зависимости от диапазона
                // ...

                // Проверяем, что кэш имеет данные
                // ...
            }

            // Выполняем запрос
            $result = $this->_executeSelect($ir, $params, $types);

            // Сохраняем результат в кэш
            // ...

            return $result;
        }
    }

Реализация помощника (CustomNodeVisitor), который рекурсивно проверяет
условия на наличие полей, которые передают диапазон возможных значений,
который будет использоваться при кэшировании:

.. code-block:: php

    <?php

    class CustomNodeVisitor
    {
        protected $_initial = 0;

        protected $_final = 25000;

        public function visit($node)
        {
            switch ($node["type"]) {
                case "binary-op":
                    $left  = $this->visit($node["left"]);
                    $right = $this->visit($node["right"]);

                    if (!$left || !$right) {
                        return false;
                    }

                    if ($left === "id") {
                        if ($node["op"] === ">") {
                            $this->_initial = $right;
                        }

                        if ($node["op"] === "=") {
                            $this->_initial = $right;
                        }

                        if ($node["op"] === ">=") {
                            $this->_initial = $right;
                        }

                        if ($node["op"] === "<") {
                            $this->_final = $right;
                        }

                        if ($node["op"] === "<=") {
                            $this->_final = $right;
                        }
                    }

                    break;

                case "qualified":
                    if ($node["name"] === "id") {
                        return "id";
                    }

                    break;

                case "literal":
                    return $node["value"];

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

Наконец, мы можем заменить поисковый метод в модели Robots и использовать пользовательские классы, которые мы создали:

.. code-block:: php

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

            if (isset($parameters["bind"])) {
                return $query->execute($parameters["bind"]);
            } else {
                return $query->execute();
            }
        }
    }

Caching of PHQL planning
------------------------
As well as most moderns database systems PHQL internally caches the execution plan,
if the same statement is executed several times PHQL reuses the previously generated plan
improving performance, for a developer to take better advantage of this is highly recommended
build all your SQL statements passing variable parameters as bound parameters:

.. code-block:: php

    <?php

    for ($i = 1; $i <= 10; $i++) {
        $phql = "SELECT * FROM Store\Robots WHERE id = " . $i;

        $robots = $this->modelsManager->executeQuery($phql);

        // ...
    }

In the above example, ten plans were generated increasing the memory usage and processing in the application.
Rewriting the code to take advantage of bound parameters reduces the processing by both ORM and database system:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";

    for ($i = 1; $i <= 10; $i++) {
        $robots = $this->modelsManager->executeQuery(
            $phql,
            [
                $i,
            ]
        );

        // ...
    }

Performance can be also improved reusing the PHQL query:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";

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

Execution plans for queries involving `prepared statements`_ are also cached by most database systems
reducing the overall execution time, also protecting your application against `SQL Injections`_.

.. _`prepared statements`: http://en.wikipedia.org/wiki/Prepared_statement
.. _`SQL Injections`: http://en.wikipedia.org/wiki/SQL_injection
