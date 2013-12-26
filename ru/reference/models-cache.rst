Кэширование в ORM
=================

Каждое приложение уникально: у нас могут быть модели c часто изменяемыми данными, так и модели с данными, 
которые редко  изменяют свои значения. Обращение к базе данных часто является одним из наиболее распространенных 
узких мест в плане производительности приложения. Это связано со сложными процессами подключения/коммуникации, 
которые PHP должен выполнять при каждом запросе к базе данных для получения требуемых данных. Поэтому, если мы 
хотим добиться хорошей производительности, мы должны добавить несколько слоев кэширования, когда приложение в 
этом нуждается.

В этой главе рассматриваются места, где можно реализовать кэширование для повышения производительности. Фреймворк 
дает вам инструмент для реализации кэша, в тех местах где вам нужно в соответствии с архитектурой приложения.

Кэширование наборов данных
--------------------------

Имеется методика позволяющая избежать постоянного обращения к базе данных, это кэширование редко изменяемых 
наборов данных, используя систему с более быстрым доступом (обычно это память).

Когда :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` требуется сервис для кэша набоов данных, он будет 
запрашивать у контейнера зависимостей этот сервис с именем «modelsCache».

Phalcon предоставляет компонент :doc:`cache <cache>` для кэширования любых данных, мы объясним как интегрировать 
его с моделями. Во-первых, вы должны зарегистрировать его в качестве сервиса в контейнере зависимостей:

.. code-block:: php

    <?php

    // Регистрация сервиса кэша моделей 
    $di->set('modelsCache', function() {

        //По умолчанию данные кэша хранятся один день
        $frontCache = new \Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 86400
        ));

        // Настройки соединения с memcached
        $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

Вы имеете полный контроль в создании и настройке кэша перед его использованием путем регистрации сервиса в 
качестве анонимной функции. После того, как настройка кэша правильно определена, можно кэшировать наборы данных:

.. code-block:: php

    <?php

    // Получить продукта без кэширования
    $products = Products::find();

    // Используем кэширование наборов данных. Кэзш остается в памяти в течении 1 часа (3600 секунд).
    $products = Products::find(array(
        "cache" => array("key" => "my-cache")
    ));

    // Кэш набора данных хранится всего 5 минут
    $products = Products::find(array(
        "cache" => array("key" => "my-cache", "lifetime" => 300)
    ));

    // Использование пользовательского кэша
    $products = Products::find(array("cache" => $myCache));

Кэш может быть также применен к набору данных, генерируемых с помощью отношений:

.. code-block:: php

    <?php

    // Запрос некоторого сообщения
    $post = Post::findFirst();

    // Получаем комментарии, относящиеся к сообщению, и кэшируем их
    $comments = $post->getComments(array(
        "cache" => array("key" => "my-key")
    ));

    // Получаем комментарии относящиеся к сообщению и устанавливаем срок их хранения
    $comments = $post->getComments(array(
        "cache" => array("key" => "my-key", "lifetime" => 3600)
    ));

Когда кэшируемые наборы данных должны быть признаны недействительными, вы можете просто удалить их из кэша с 
использованием ранее указанного ключа.

Обратите внимание, что не все наборы данных должны быть в кэше. Данные, которые меняют свои значения очень 
часто не следует кэшировать, так как они становятся не действительными очень быстро, и кэширование в этом случаи 
отрицательно влияет на производительность приложения. Кроме того, большие наборы данных, которые не часто 
меняют свои значения, могут располагаться в кэше, но для реализации этой идеи необходимо оценить имеющиеся 
механизмы кэширования  и влияния на производительность, так как это не всегда будет способствовать увеличению 
производительности приложения.

Переопределение find/findFirst
------------------------------

Как показано выше, эти методы доступны в моделях, которые наследуют :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        public static function find($parameters=null)
        {
            return parent::find($parameters);
        }

        public static function findFirst($parameters=null)
        {
            return parent::findFirst($parameters);
        }

    }

Сделав это, вы будите перехватывать все вызовы этих методов, таким образом, вы можете добавить 
кэширующий слой или запускать запросы к базе данных, если кэша нет. Например, очень простой 
реализацией кэша является использование статического свойства, чтобы избежать того, что запись 
будет запрашиваться несколько раз в одной и том же запросе:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        protected static $_cache = array();

        /**
         * Реализация метода, который возвращает 
         * строковый ключ на основе параметров запроса
         */
        protected static function _createKey($parameters)
        {
            $uniqueKey = array();
            foreach ($parameters as $key => $value) {
                if (is_scalar($value)) {
                    $uniqueKey[] = $key . ':' . $value;
                } else {
                    if (is_array($value)) {
                        $uniqueKey[] = $key . ':[' . self::_createKey($value) .']';
                    }
                }
            }
            return join(',', $uniqueKey);
        }

        public static function find($parameters=null)
        {

            // Создание уникального ключа на основе параметров
            $key = self::_createKey($parameters);

            if (!isset(self::$_cache[$key])) {
                //Store the result in the memory cache
                self::$_cache[$key] = parent::find($parameters);
            }

            // Вернуть результат в кэше
            return self::$_cache[$key];
        }

        public static function findFirst($parameters=null)
        {
            // ...
        }

    }

Доступ к базе данных в несколько раз медленнее, чем вычисление ключа кэша, вы свободны в 
реализации стратегии генерации ключа, которая лучше подходит для ваших задач.  Следует 
отметить, что хороший ключ позволяет избежать конфликтов, насколько это возможно, это 
означает, что разные ключи возвращают unrelated records to the find parameters.

В приведенном выше примере мы использовали кэш в памяти, он полезен в качестве первого 
уровня кэша. Как только у нас есть кэш в памяти, мы можем реализовать слой кэша второго
уровня с помощью APC / XCache или базы данных NoSQL:

.. code-block:: php

    <?php

    public static function find($parameters=null)
    {

        // Создание уникального ключа на основе параметров
        $key = self::_createKey($parameters);

        if (!isset(self::$_cache[$key])) {

            //Мы используем APC как кэш второго уровня
            if (apc_exists($key)) {

                $data = apc_fetch($key);

                //Сохраните результат в кэш памяти
                self::$_cache[$key] = $data;

                return $data;
            }

            //Если нет кэша в памяти или в APC
            $data = parent::find($parameters);

            //Сохраните результат в кэш памяти
            self::$_cache[$key] = $data;

            //Сохраните результат в APC
            apc_store($key, $data);

            return $data;
        }

        //Вернуть результат в кэше
        return self::$_cache[$key];
    }

Это дает вам полный контроль над тем, как кэши должны быть реализованы для 
каждой модели, эта стратегия может быть общей для нескольких моделей, 
которую можно вынести в отдельный базовый класс для всех подобных классов:


.. code-block:: php

    <?php

    class CacheableModel extends Phalcon\Mvc\Model
    {

        protected static function _createKey($parameters)
        {
            // .. create a cache key based on the parameters
        }

        public static function find($parameters=null)
        {
            //.. custom caching strategy
        }

        public static function findFirst($parameters=null)
        {
            //.. custom caching strategy
        }
    }

Затем используйте этот класс в качестве базового класса для каждой модели 'Cacheable':

.. code-block:: php

    <?php

    class Robots extends CacheableModel
    {

    }

Форсирование кэша
-----------------

Ранее мы видели, как Phalcon\\Mvc\\Model имеет встроенную интеграцию с компонентом 
кэширования, предоставленного фреймворком. Чтобы сделать запись/результирующий набор кэшируемым, 
мы передаем ключ 'cache' в массиве параметров:

.. code-block:: php

    <?php

    // Кэшируем результирующий набор всего на 5 минут
    $products = Products::find(array(
        "cache" => array("key" => "my-cache", "lifetime" => 300)
    ));

Это дает нам свободу для кэширования конкретных запросов, поэтому если мы хотим кэшировать 
глобально все запросы, выполняемые моделью, мы можем переопределить метод find/findFirst,
чтобы заставить кэшировать каждый запрос.

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        protected static function _createKey($parameters)
        {
            // .. создаем ключ кэша на основе параметров
        }

        public static function find($parameters=null)
        {

            // Преобразование параметров в массив
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            // Проверяем, что ключ кэша не был передан
            //и создаем параметры кэша
            if (!isset($parameters['cache'])) {
                $parameters['cache'] = array(
                    "key" => self::_createKey($parameters),
                    "lifetime" => 300
                );
            }

            return parent::find($parameters);
        }

        public static function findFirst($parameters=null)
        {
            //...
        }

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

    $query->setCache(array(
        "key" => "cars-by-name",
        "lifetime" => 300
    ));

    $cars = $query->execute(array(
        'name' => 'Audi'
    ));

Если вы не хотите использовать неявный кэш, просто сохраните результирующий набор 
в предпочтительный для вас серверный кэш:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE name = :name:";

    $cars = $this->modelsManager->executeQuery($phql, array(
        'name' => 'Audi'
    ));

    apc_store('my-cars', $cars);

Многократное использование связанных записей
--------------------------------------------

Некоторые модели могут иметь связи с другими моделями. Это позволяет нам легко проверить записи, 
которые относятся к экземплярам в памяти:

.. code-block:: php

    <?php

    // Получаем некоторый счет
    $invoice = Invoices::findFirst();

    // Получаем клиента связанного со счетом
    $customer = $invoice->customer;

    // Выводим его/ее имя
    echo $customer->name, "\n";

Этот пример очень простой, клиент получает запрос и который может быть использован при 
необходимости, например, чтобы показать свое имя. Это также касается случаев если мы 
извлекаем наборы счетов, чтобы показать клиентам, которые являются владельцами этих счетов:

.. code-block:: php

    <?php

    // Получаем набор счетов
    // SELECT * FROM invoices
    foreach (Invoices::find() as $invoice) {

        // Получаем клиента связанного с заказом
        // SELECT * FROM customers WHERE id = ?
        $customer = $invoice->customer;

        // Выводим его/ее имя
        echo $customer->name, "\n";
    }

Клиент может иметь один или несколько счетов, это означает, что клиент может быть 
вызван вызван более одного раза. Чтобы избежать этого, мы можем отметить связь как 
многоразовую , таким образом, мы говорим ORM автоматически использовать прошлые 
записи вместо того, чтобы вновь и вновь выполнять один и тот же запросы:

.. code-block:: php

    <?php

    class Invoices extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo("customers_id", "Customer", "id", array(
                'reusable' => true
            ));
        }

    }

Этот кэш работает только в памяти, это означает, что кэшированные данные 
предоставляются, когда запрос уже был выполнен. Вы можете добавить более сложные 
кэш для этого сценария, переопределив менеджер модели:

.. code-block:: php

    <?php

    class CustomModelsManager extends \Phalcon\Mvc\Model\Manager
    {

        /**
         * Возвращает многократно используемый объект из кэша
         *
         * @param string $modelName
         * @param string $key
         * @return object
         */
        public function getReusableRecords($modelName, $key){

            // Если модель Products использует кэш APC
            if ($modelName == 'Products'){
                return apc_fetch($key);
            }

            // Для остальных, использовать кэш памяти
            return parent::getReusableRecords($modelName, $key);
        }

        /**
         * Сохраняет повторно используемый запись в кэше
         *
         * @param string $modelName
         * @param string $key
         * @param mixed $records
         */
        public function setReusableRecords($modelName, $key, $records){

            // Если модель Products использует кэш APC
            if ($modelName == 'Products'){
                apc_store($key, $records);
                return;
            }

            // Для остальных, использовать кэш памяти
            parent::setReusableRecords($modelName, $key, $records);
        }
    }

Не забудьте зарегистрировать свой менеджер моделей в DI:

.. code-block:: php

    <?php

    $di->setShared('modelsManager', function() {
        return new CustomModelsManager();
    });

Кэширование связанных записей
-----------------------------

Когда запрашиваются связанные запись, внутри ORM строится соответствующие состояние, 
и передаются необходимые записи с помощью Find / FindFirst в целевую модель в 
соответствии со следующей таблицей:

+---------------------+--------------------------------------------------------------------------------------+---------------------------+
| Тип                 | Описание                                                                             | Вызываемый метод          |
+=====================+======================================================================================+===========================+
| Belongs-To          | Возвращает непосредственно экземпляр модели взаимосвязанной записи                   | findFirst                 |
+---------------------+--------------------------------------------------------------------------------------+---------------------------+
| Has-One             | Возвращает непосредственно экземпляр модели взаимосвязанной записи                   | findFirst                 |
+---------------------+--------------------------------------------------------------------------------------+---------------------------+
| Has-Many            | Возвращает коллекцию экземпляров модели которые ссылаются на модель                  | find                      |
+---------------------+--------------------------------------------------------------------------------------+---------------------------+

Это означает, что когда вы получаете связанные записи, вы можете изменить способ 
получения данных путем реализации соответствующего метода:

.. code-block:: php

    <?php

    // Получаем счет
    $invoice = Invoices::findFirst();

    // Получаем владельца счета 
    $customer = $invoice->customer; // Invoices::findFirst('...');

    // То же самое
    $customer = $invoice->getCustomer(); // Invoices::findFirst('...');

Соответственно, мы могли бы заменить метод FindFirst в моделе счетов и осуществлять 
кэширование наиболее подходящим способом:

.. code-block:: php

    <?php

    class Invoices extends Phalcon\Mvc\Model
    {

        public static function findFirst($parameters=null)
        {
            //.. здесь реализуем кэширование данных
        }
    }

Caching Related Records Recursively
-----------------------------------
In this scenario, we assume that everytime we query a result we also retrieve their associated records.
If we store the records found together with their related entities perhaps we could reduce a bit the overhead required
to obtain all entities:

.. code-block:: php

    <?php

    class Invoices extends Phalcon\Mvc\Model
    {

        protected static function _createKey($parameters)
        {
            // .. create a cache key based on the parameters
        }

        protected static function _getCache($key)
        {
            // returns data from a cache
        }

        protected static function _setCache($key)
        {
            // stores data in the cache
        }

        public static function find($parameters=null)
        {
            //Create a unique key
            $key = self::_createKey($parameters);

            //Check if there are data in the cache
            $results = self::_getCache($key);

            // Valid data is an object
            if (is_object($results)) {
                return $results;
            }

            $results = array();

            $invoices = parent::find($parameters);
            foreach ($invoices as $invoice) {

                //Query the related customer
                $customer = $invoice->customer;

                //Assign it to the record
                $invoice->customer = $customer;

                $results[] = $invoice;
            }

            //Store the invoices in the cache + their customers
            self::_setCache($key, $results);

            return $results;
        }

        public function initialize()
        {
            // add relations and initialize other stuff
        }
    }

Getting the invoices from the cache already obtains the customer data in just one hit, reducing the overall overhead of the operation.
Note that this process can also be performed with PHQL following an alternative solution:

.. code-block:: php

    <?php

    class Invoices extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            // add relations and initialize other stuff
        }

        protected static function _createKey($conditions, $params)
        {
            // .. create a cache key based on the parameters
        }

        public function getInvoicesCustomers($conditions, $params=null)
        {
            $phql = "SELECT Invoices.*, Customers.*
            FROM Invoices JOIN Customers WHERE " . $conditions;

            $query = $this->getModelsManager()->executeQuery($phql);

            $query->setCache(array(
                "key" => self::_createKey($conditions, $params),
                "lifetime" => 300
            ));

            return $query->execute($params);
        }

    }

Caching based on Conditions
---------------------------
In this scenario, the cache is implemented conditionally according to current conditions received.
According to the range where the primary key is located we choose a different cache backend:

+---------------------+--------------------+
| Type                | Cache Backend      |
+=====================+====================+
| 1 - 10000           | mongo1             |
+---------------------+--------------------+
| 10000 - 20000       | mongo2             |
+---------------------+--------------------+
| > 20000             | mongo3             |
+---------------------+--------------------+

The easiest way is adding an static method to the model that chooses the right cache to be used:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public static function queryCache($initial, $final)
        {
            if ($initial >= 1 && $final < 10000) {
                return self::find(array(
                    'id >= ' . $initial . ' AND id <= '.$final,
                    'cache' => array('service' => 'mongo1')
                ));
            }
            if ($initial >= 10000 && $final <= 20000) {
                return self::find(array(
                    'id >= ' . $initial . ' AND id <= '.$final,
                    'cache' => array('service' => 'mongo2')
                ));
            }
            if ($initial > 20000) {
                return self::find(array(
                    'id >= ' . $initial,
                    'cache' => array('service' => 'mongo3')
                ));
            }
        }

    }

This approach solves the problem, however, if we want to add other parameters such orders or conditions we would have to create
a more complicated method. Additionally, this method does not work if the data is obtained using related records or a find/findFirst:

.. code-block:: php

    <?php

    $robots = Robots::find('id < 1000');
    $robots = Robots::find('id > 100 AND type = "A"');
    $robots = Robots::find('(id > 100 AND type = "A") AND id < 2000');

    $robots = Robots::find(array(
        '(id > ?0 AND type = "A") AND id < ?1',
        'bind' => array(100, 2000),
        'order' => 'type'
    ));

To achieve this we need to intercept the intermediate representation (IR) generated by the PHQL parser and
thus customize the cache everything possible:

The first is create a custom builder, so we can generate a totally customized query:

.. code-block:: php

    <?php

    class CustomQueryBuilder extends Phalcon\Mvc\Model\Query\Builder
    {

        public function getQuery()
        {
            $query = new CustomQuery($this->getPhql());
            $query->setDI($this->getDI());
            return $query;
        }

    }

Instead of directly returning a Phalcon\\Mvc\\Model\\Query, our custom builder returns a CustomQuery instance,
this class looks like:

.. code-block:: php

    <?php

    class CustomQuery extends Phalcon\Mvc\Model\Query
    {

        /**
         * The execute method is overrided
         */
        public function execute($params=null, $types=null)
        {
            //Parse the intermediate representation for the SELECT
            $ir = $this->parse();

            //Check if the query has conditions
            if (isset($ir['where'])) {

                //The fields in the conditions can have any order
                //We need to recursively check the conditions tree
                //to find the info we're looking for
                $visitor = new CustomNodeVisitor();

                //Recursively visits the nodes
                $visitor->visit($ir['where']);

                $initial = $visitor->getInitial();
                $final = $visitor->getFinal();

                //Select the cache according to the range
                //...

                //Check if the cache has data
                //...
            }

            //Execute the query
            $result = $this->_executeSelect($ir, $params, $types);

            //cache the result
            //...

            return $result;
        }

    }

Implementing a helper (CustomNodeVisitor) that recursively checks the conditions looking for fields that
tell us the possible range to be used in the cache:

.. code-block:: php

    <?php

    class CustomNodeVisitor
    {

        protected $_initial = 0;

        protected $_final = 25000;

        public function visit($node)
        {
            switch ($node['type']) {

                case 'binary-op':

                    $left = $this->visit($node['left']);
                    $right = $this->visit($node['right']);
                    if (!$left || !$right) {
                        return false;
                    }

                    if ($left=='id') {
                        if ($node['op'] == '>') {
                            $this->_initial = $right;
                        }
                        if ($node['op'] == '=') {
                            $this->_initial = $right;
                        }
                        if ($node['op'] == '>=')    {
                            $this->_initial = $right;
                        }
                        if ($node['op'] == '<') {
                            $this->_final = $right;
                        }
                        if ($node['op'] == '<=')    {
                            $this->_final = $right;
                        }
                    }
                    break;

                case 'qualified':
                    if ($node['name'] == 'id') {
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

Finally, we can replace the find method in the Robots model to use the custom classes we've created:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public static function find($parameters=null)
        {

            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            $builder = new CustomQueryBuilder($parameters);
            $builder->from(get_called_class());

            if (isset($parameters['bind'])) {
                return $builder->getQuery()->execute($parameters['bind']);
            } else {
                return $builder->getQuery()->execute();
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

        //...
    }

In the above example, ten plans were generated increasing the memory usage and processing in the application.
Rewriting the code to take advantage of bound parameters reduces the processing by both ORM and database system:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";

    for ($i = 1; $i <= 10; $i++) {

        $robots = $this->modelsManager->executeQuery($phql, array($i));

        //...
    }

Performance can be also improved reusing the PHQL query:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";
    $query = $this->modelsManager->createQuery($phql);

    for ($i = 1; $i <= 10; $i++) {

        $robots = $query->execute($phql, array($i));

        //...
    }

Execution plans for queries involving `prepared statements`_ are also cached by most database systems
reducing the overall execution time, also protecting your application against `SQL Injections`_.

.. _`prepared statements` : http://en.wikipedia.org/wiki/Prepared_statement
.. _`SQL Injections` : http://en.wikipedia.org/wiki/SQL_injection
