Работа с моделями (дополнительно)
=================================

Режимы гидрации
---------------
Как упоминалось ранее, наборы результатов (resultsets) являются коллекцией конечных объектов, это означает, что каждый возвращенный результат является объектом,
представляющим собой строку в базе данных. Эти объекты могут быть изменены и сохранены снова:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::find();

    // Изменение и сохранение полученных обектов модели роботов
    foreach ($robots as $robot) {
        $robot->year = 2000;

        $robot->save();
    }

Иногда записи могут быть представлены пользователю в режиме только для чтения, в таких случаях может быть полезно
изменить способ представления записей, для облегчения их обработки. Способ, используемый для представления объектов,
возвращаемых в наборе результатов называется 'режим гидрации':

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;
    use Store\Toys\Robots;

    $robots = Robots::find();

    // Вернёт каждого робота в виде массива
    $robots->setHydrateMode(
        Resultset::HYDRATE_ARRAYS
    );

    foreach ($robots as $robot) {
        echo $robot["year"], PHP_EOL;
    }

    // Вернёт каждого робота в stdClass
    $robots->setHydrateMode(
        Resultset::HYDRATE_OBJECTS
    );

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

    // Вернёт каждого робота как экземпляр класса Robots
    $robots->setHydrateMode(
        Resultset::HYDRATE_RECORDS
    );

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

Режим гидрации также может быть передан в качестве параметра в 'find':

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;
    use Store\Toys\Robots;

    $robots = Robots::find(
        [
            "hydration" => Resultset::HYDRATE_ARRAYS,
        ]
    );

    foreach ($robots as $robot) {
        echo $robot["year"], PHP_EOL;
    }

Автоматически генерируемый столбец идентификаторов
--------------------------------------------------
Некоторые модели могут иметь столбцы идентификаторов. Эти столбцы, обычно, являются первичными ключами таблицы. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
может распознать столбец идентификаторов, исключая его из сгенерированного SQL INSERT, так как СУБД может генерировать значение для него автоматически.
Всегда после создания записи в поле идентификатора будет установлено значение, сгенерированое в СУБД:

.. code-block:: php

    <?php

    $robot->save();

    echo "Сгенерированный идентификатор: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` может распознать столбец идентификаторов. В зависимости от системы баз данных, это могут быть столбцы
serial, как в PostgreSQL, или auto_increment, в случае MySQL.

PostgreSQL использует последовательности для создания автонумерации значений, Phalcon пытается получить сгенерированное значение из последовательности "table_field_seq",
например: robots_id_seq, если эта последовательность имеет другое имя, то должен быть реализован метод :code:`getSequenceName()`:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function getSequenceName()
        {
            return "robots_sequence_name";
        }
    }

Пропуск столбцов
----------------
Можно указать :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` пропускать некоторые поля при создании и/или обновлении записей для того,
чтобы делегировать базе данных установку значений триггерами или по умолчанию:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            // Пропуск поля/столбца при всех INSERT/UPDATE операциях
            $this->skipAttributes(
                [
                    "year",
                    "price",
                ]
            );

            // Пропуск только при вставке
            $this->skipAttributesOnCreate(
                [
                    "created_at",
                ]
            );

            // Пропуск только при обновлении
            $this->skipAttributesOnUpdate(
                [
                    "modified_in",
                ]
            );
        }
    }

Эти поля будут игнорироваться при каждой операции INSERT/UPDATE во всем приложении.
Принудительно присваивание значения по умолчанию может быть достигнуто
следующим образом:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    use Phalcon\Db\RawValue;

    $robot = new Robots();

    $robot->name       = "Bender";
    $robot->year       = 1999;
    $robot->created_at = new RawValue("default");

    $robot->create();

События также могут использоваться для условного присваивания значений по умолчанию:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Db\RawValue;

    class Robots extends Model
    {
        public function beforeCreate()
        {
            if ($this->price > 10000) {
                $this->type = new RawValue("default");
            }
        }
    }

.. highlights::

    Никогда не используйте :doc:`Phalcon\\Db\\RawValue <../api/Phalcon_Db_RawValue>` при работе с внешними данными (такими как ввод пользователя)
    или изменяющимися данными. Значение таких полей игнорируется при связывании параметров в запросе.
    Таким образом, это может использоваться для взлома с помощью SQL инъекции.

Динамическое обновление
^^^^^^^^^^^^^^^^^^^^^^^
SQL операторы UPDATE по умолчанию включают в себя каждый столбец, определенный в модели.
Вы можете изменить определенную модель, включив динамическое обновление. В этом случае только измененные поля
попадут в окончательный SQL запрос.

В некоторых случаях это может улучшить производительность за счет снижения трафика между приложением и сервером базы данных,
это особенно помогает, когда таблица имеет BLOB/TEXT поля:

.. code-block:: php

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

Независимое сопоставление столбцов
----------------------------------
ORM поддерживает независимую карту столбцов, позволяющую разработчику использовать различные именования в модели
и таблице. Phalcon зарегистрирует новые имена и будет переименовывать их при запросах к базе соответственно указанным значениям.
Это отличная возможность, если нужно переименовать поля в базе данных без необходимости беспокоиться о запросах
в коде. Достаточно изменить карту столбцов, Phalcon позаботится об остальном. Например:

.. code-block:: php

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
            // Ключи - реальные имена в таблице и
            // значения - их имена в приложении
            return [
                "id"       => "code",
                "the_name" => "theName",
                "the_type" => "theType",
                "the_year" => "theYear",
            ];
        }
    }

Затем вы можете использовать новые переменные в вашем коде:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Найти робота по имени
    $robot = Robots::findFirst(
        "theName = 'Voltron'"
    );

    echo $robot->theName, "\n";

    // Получить роботов, сгруппированных по типу
    $robot = Robots::find(
        [
            "order" => "theType DESC",
        ]
    );

    foreach ($robots as $robot) {
        echo "Code: ", $robot->code, "\n";
    }

    // Создать робота
    $robot = new Robots();

    $robot->code    = "10101";
    $robot->theName = "Bender";
    $robot->theType = "Industrial";
    $robot->theYear = 2999;

    $robot->save();

При переименовании столбцов примите во внимание следующее:

* Ссылки на атрибуты в отношениях/валидаторах должны использовать новые имена
* Ссылка на реальное имя столбца приведет к выбросу исключения в ORM

Независимая карта столбцов позволит вам:

* Писать приложения, используя ваши собственные правила именования
* Ликвидировать префиксы/суффиксы вендоров в вашем коде
* Изменить имена столбцов без изменения кода приложения

Запись снимков
--------------
В определенных моделях может быть установленно сохранение снимков, когда они вызываются. Вы можете использовать эту функцию для осуществления аудита или просто для того, чтобы знать то,
какие поля были изменены в соответствии с запросом данных из дампа.

.. code-block:: php

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

При активации этой функции приложение потребляет немного больше памяти, чтобы следить за исходными значениями, полученных из дампа.
В моделях, которые используют эту функцию, вы можете увидеть, какие поля изменились:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Получаем запись из базы данных
    $robot = Robots::findFirst();

    // Изменяем столбец
    $robot->name = "Other name";

    var_dump($robot->getChangedFields()); // ["name"]

    var_dump($robot->hasChanged("name")); // true

    var_dump($robot->hasChanged("type")); // false

Ссылка на другую схему
----------------------
Если модель отображает таблицу, которая находится в схеме/базе данных, отличной от заданной по умолчанию, то вы можете использовать метод :code:`setSchema()`, чтобы определить это:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setSchema("toys");
        }
    }

Установка нескольких баз данных
-------------------------------
В Phalcon все модели могут принадлежать к одному и тому же соединению с базой данных или иметь индивидуальное. На самом деле, когда классу
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` необходимо подключиться к базе данных, он запрашивает сервис "db"
в контейнере сервисов приложения. Вы можете переопределить этот сервис, установив его в методе :code:`initialize()`:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
    use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

    // Этот сервис возвращает базу данных MySQL
    $di->set(
        "dbMysql",
        function () {
            return new MysqlPdo(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    );

    // Этот сервис возвращает базу данных PostgreSQL
    $di->set(
        "dbPostgres",
        function () {
            return new PostgreSQLPdo(
                [
                    "host"     => "localhost",
                    "username" => "postgres",
                    "password" => "",
                    "dbname"   => "invo",
                ]
            );
        }
    );

Затем в методе :code:`initialize()`, определим сервис соединения для модели:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setConnectionService("dbPostgres");
        }
    }

Но Phalcon предлагает вам больше гибкости: вы можете указать, какое соединение использовать для чтения, а какое для записи. Это особенно полезно
для балансировки нагрузки ваших баз данных, реализующих архитектуру master-slave:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setReadConnectionService("dbSlave");

            $this->setWriteConnectionService("dbMaster");
        }
    }

ORM также предоставляет возможность горизонтального масштабирования, позволяя вам реализовать выбор шардов (shard)
в соответствии с текущего условиями запроса:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        /**
         * Динамически выбирает шарды
         *
         * @param array $intermediate
         * @param array $bindParams
         * @param array $bindTypes
         */
        public function selectReadConnection($intermediate, $bindParams, $bindTypes)
        {
            // Проверяем, есть ли  'where' в select
            if (isset($intermediate["where"])) {
                $conditions = $intermediate["where"];

                // Выбираем возможный шард в соответствии с условиями
                if ($conditions["left"]["name"] === "id") {
                    $id = $conditions["right"]["value"];

                    if ($id > 0 && $id < 10000) {
                        return $this->getDI()->get("dbShard1");
                    }

                    if ($id > 10000) {
                        return $this->getDI()->get("dbShard2");
                    }
                }
            }

            // Используем стандартный шард
            return $this->getDI()->get("dbShard0");
        }
    }

Метод :code:`selectReadConnection()` вызывается для выбора правильного соединения, этот метод перехватывает выполнение любого нового
запроса:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst('id = 101');

Инъекция сервисов в модели
--------------------------
Вам может потребоваться доступ к службам приложений в рамках модели. Следующий пример объясняет, как его получить:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function notSaved()
        {
            // Получаем сервис flash из контейнера DI
            $flash = $this->getDI()->getFlash();

            $messages = $this->getMessages();

            // Показываем сообщения проверки
            foreach ($messages as $message) {
                $flash->error($message);
            }
        }
    }

Событие "notSaved" срабатывает каждый раз, когда не удаются действия "create" или "update". Соответственно, мы показываем сообщения проверки,
получая сервис "flash" из контейнера DI. Таким образом, нам не нужно выводить сообщения после каждого сохранения.

Отключение/включение возможностей
---------------------------------
Мы внедрили в ORM механизм, который позволяет вам на лету включать/отключать конкретные особенности или глобальные опции.
Поэтому, когда вы используете ORM, можете отключить то, что вы не используете. Эти параметры также могут быть временно отключены, если требуется:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    Model::setup(
        [
            "events"         => false,
            "columnRenaming" => false,
        ]
    );

Доступные опции:

+---------------------+-------------------------------------------------------------------------------------------------+---------------+
| Опция               | Описание                                                                                        | По умолчанию  |
+=====================+=================================================================================================+===============+
| events              | Включает/выключает функции обратного вызова, хуки и уведомления о событиях из всех моделей      | :code:`true`  |
+---------------------+-------------------------------------------------------------------------------------------------+---------------+
| columnRenaming      | Включает/выключает переименование столбцов                                                      | :code:`true`  |
+---------------------+-------------------------------------------------------------------------------------------------+---------------+
| notNullValidations  | ORM автоматически проверяет NOT NULL столбцы, присутствующие в таблице                          | :code:`true`  |
+---------------------+-------------------------------------------------------------------------------------------------+---------------+
| virtualForeignKeys  | Включает/выключает виртуальные внешние ключи                                                    | :code:`true`  |
+---------------------+-------------------------------------------------------------------------------------------------+---------------+
| phqlLiterals        | Включает/выключает литералы в PHQL парсере                                                      | :code:`true`  |
+---------------------+-------------------------------------------------------------------------------------------------+---------------+
| lateStateBinding    | Включает/выключает позднее статическое связывание метода :code:`Mvc\Model::cloneResultMap()`    | :code:`false` |
+---------------------+-------------------------------------------------------------------------------------------------+---------------+

Автономный компонент
--------------------
Ниже показано, как можно использовать :doc:`Phalcon\\Mvc\\Model <models>` в автономном режиме:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Manager as ModelsManager;
    use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
    use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

    $di = new Di();

    // Настраиваем соединение
    $di->set(
        "db",
        new Connection(
            [
                "dbname" => "sample.db",
            ]
        )
    );

    // Устанавливаем менеджер модели
    $di->set(
        "modelsManager",
        new ModelsManager()
    );

    // Используем адаптер памяти мета-данных или любой другой
    $di->set(
        "modelsMetadata",
        new MetaData()
    );

    // Создаем модель
    class Robots extends Model
    {

    }

    // Используем модель
    echo Robots::count();
