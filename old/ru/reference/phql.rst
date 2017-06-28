Язык запросов Phalcon (PHQL)
============================

Язык запросов phalcon, PhalconQL или просто PHQL — это высокоуровневый объектно-ориентированный диалект SQL, позволяющий писать запросы с использованием стандартизированного языка, похожего на SQL. PHQL реализован в виде парсера (написанного на C), который переводит синтаксис целевой СУБД.

Чтобы достигнуть максимально возможной производительности, Phalcon предоставляет парсер, используя технологию схожую с SQLite_. Эта технология предоставляет небольшой парсер, который расходует малый объем памяти и, при этом, является поточно-ориентированным.

Сначала этот парсер проверяет синтаксис переданного выражения, затем строит его промежуточное представление и, в конце концов, преобразует его в SQL-диалект, соответствующий целевой СУБД.

В PHQL мы реализовали некоторый набор фич, чтобы ваш доступ к базе данных был более безопасным:

* Связанные (bound) параметры — часть языка PHQL, помогающая вам обезопасить ваш код
* PHQL разрешает выполнить только один SQL оператор за вызов, предотвращая инъекции
* PHQL игнорирует любые SQL-комментарии, часто использующиеся в SQL-инъекциях
* PHQL разрешает выполнять только операторы работы с данными, избегая изменения или удаления таблиц/баз данных по ошибке или извне без авторизации
* PHQL реализует высокоуровневую абстракцию, позволяющую вам оперировать моделями как таблицами и атрибутами класса — как полями таблицы.

Пример использования
--------------------
Чтобы лучше объяснить, как работает PHQL, рассмотрим следующий пример. У нас есть две модели, "Автомобили" и "Марки":

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Cars extends Model
    {
        public $id;

        public $name;

        public $brand_id;

        public $price;

        public $year;

        public $style;

        /**
         * Эта модель ссылается на таблицу sample_cars
         */
        public function getSource()
        {
            return "sample_cars";
        }

        /**
         * Автомобиль может быть всего лишь одной марки,
         * в то время как одну марку могут иметь множество автомобилей
         */
        public function initialize()
        {
            $this->belongsTo("brand_id", "Brands", "id");
        }
    }

И каждый автомобиль имеет марку, в то время как у марки — множество автомобилей (в общем, "связь один ко многим")

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Brands extends Model
    {
        public $id;

        public $name;

        /**
         * Модель Brands ссылается на таблицу "sample_brands"
         */
        public function getSource()
        {
            return "sample_brands";
        }

        /**
         * Brand может иметь несколько Cars
         */
        public function initialize()
        {
            $this->hasMany("id", "Cars", "brand_id");
        }
    }

Создание PHQL запросов
----------------------
PHQL запросы могут быть созданы только как экземпляр класса :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>`:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Query;

    // Экземпляр Query
    $query = new Query(
        "SELECT * FROM Cars",
        $this->getDI()
    );

    // Выполнение запроса возвращает какой-то результат
    $cars = $query->execute();

В контроллере или в представлении их проще создавать/выполнять используя внедрённый :doc:`models manager <../api/Phalcon_Mvc_Model_Manager>`:

.. code-block:: php

    <?php

    // Исполнение простого запроса
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars");
    $cars  = $query->execute();

    // Со связыванием (bound) параметров
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars WHERE name = :name:");
    $cars  = $query->execute(
        [
            "name" => "Audi",
        ]
    );

Или еще проще:

.. code-block:: php

    <?php

    // Исполнение простого запроса
    $cars = $this->modelsManager->executeQuery(
        "SELECT * FROM Cars"
    );

    // Со связыванием (bound) параметров
    $cars = $this->modelsManager->executeQuery(
        "SELECT * FROM Cars WHERE name = :name:",
        [
            "name" => "Audi",
        ]
    );

Выборка записей
---------------
Как и в SQL, PHQL позволяет запрашивать записи используя оператор SELECT, с тем отличием, что вместо названий таблиц используются модели:

.. code-block:: php

    <?php

    $query = $manager->createQuery(
        "SELECT * FROM Cars ORDER BY Cars.name"
    );

    $query = $manager->createQuery(
        "SELECT Cars.name FROM Cars ORDER BY Cars.name"
    );

Так же разрешены неймспейсы классов:

.. code-block:: php

    <?php

    $phql  = "SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql  = "SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql  = "SELECT c.name FROM Formula\Cars c ORDER BY c.name";
    $query = $manager->createQuery($phql);

PHQL поддерживает большинство стандартов SQL, даже такие нестандартные директивы как LIMIT:

.. code-block:: php

    <?php

    $phql = "SELECT c.name FROM Cars AS c WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";

    $query = $manager->createQuery($phql);

Типы результата
^^^^^^^^^^^^^^^
Тип результата может меняться в зависимости от типа запрашиваемого нами столбца. При получении одного целого объекта, будет возвращён :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. Этот вид результата представляет собой полноценный объект модели:

.. code-block:: php

    <?php

    $phql = "SELECT c.* FROM Cars AS c ORDER BY c.name";

    $cars = $manager->executeQuery($phql);

    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

Это то же самое, что и:

.. code-block:: php

    <?php

    $cars = Cars::find(
        [
            "order" => "name"
        ]
    );

    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

Полноценные объекты могут быть изменены и пересохраненые в базе данных, потому что они представляют собой полноценную запись в связанной таблице. Есть другие типы запросов, которые не возвращают такие объекты, например:

.. code-block:: php

    <?php

    $phql = "SELECT c.id, c.name FROM Cars AS c ORDER BY c.name";

    $cars = $manager->executeQuery($phql);

    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

Тут мы запросили только некоторые поля таблицы, поэтому это не может являться объектом. Однако и в этом случае тоже возвращается :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. Но, тем не менее, каждый элемент выборки будет стандартным объектом, содержащим значения только двух запрошенных столбцов.

Такие значения, которые не представляют собой полноценного объекта, мы называем скалярами. PHQL позволяет вам запрашивать все типы скаляров: поля, функции, литералы, выражения и т.д.:

.. code-block:: php

    <?php

    $phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";

    $cars = $manager->executeQuery($phql);

    foreach ($cars as $car) {
        echo $car->id_name, "\n";
    }

Раз уж мы можем запрашивать полноценные объекты и скаляры, то мы так же можем запросить их одновременно:

.. code-block:: php

    <?php

    $phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";

    $result = $manager->executeQuery($phql);

В этом случае результатом будет объект :doc:`Phalcon\\Mvc\\Model\\Resultset\\Complex <../api/Phalcon_Mvc_Model_Resultset_Complex>`. Он позволяет получить доступ и к полноценному объекту и к скаляру одновременно:

.. code-block:: php

    <?php

    foreach ($result as $row) {
        echo "Name: ", $row->cars->name, "\n";
        echo "Price: ", $row->cars->price, "\n";
        echo "Taxes: ", $row->taxes, "\n";
    }

Скаляры представлены как свойства каждой "row", в то время как полноценные объекты — свойствами с названиями связанной модели.

Джоины (Joins)
^^^^^^^^^^^^^^
Используя PHQL очень просто запрашивать записи из нескольких моделей. Поддерживаются большинство различных джоинов. PHQL автоматически добавляет условия, которые мы определили при связывании моделей:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands";

    $rows = $manager->executeQuery($phql);

    foreach ($rows as $row) {
        echo $row->car_name, "\n";
        echo $row->brand_name, "\n";
    }

По умолчанию используется INNER JOIN. Вы можете сами определить тип JOIN в запросе:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands";
    $rows = $manager->executeQuery($phql);

Так же можно вручную задавать условия для JOIN'ов:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id";

    $rows = $manager->executeQuery($phql);

Джоины так же могут быть созданы, если в условии FROM фигурируют несколько таблиц:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id";

    $rows = $manager->executeQuery($phql);

    foreach ($rows as $row) {
        echo "Car: ", $row->cars->name, "\n";
        echo "Brand: ", $row->brands->name, "\n";
    }

Если в запросе используется алиас для переименования модели, то это имя будет использовано для именования атрибутов в каждой строке результата:

.. code-block:: php

    <?php

    $phql = "SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id";

    $rows = $manager->executeQuery($phql);

    foreach ($rows as $row) {
        echo "Car: ", $row->c->name, "\n";
        echo "Brand: ", $row->b->name, "\n";
    }

Когда присоединяемая модель имеет связь многие-ко-многим к 'from' модели, промежуточная модель неявно добавляется в сгенерированный запрос:

.. code-block:: php

    <?php

    $phql = "SELECT Artists.name, Songs.name FROM Artists " .
            "JOIN Songs WHERE Artists.genre = 'Trip-Hop'";

    $result = $this->modelsManager->executeQuery($phql);

Получаем следующий SQL в MySQL:

.. code-block:: sql

    SELECT `artists`.`name`, `songs`.`name` FROM `artists`
    INNER JOIN `albums` ON `albums`.`artists_id` = `artists`.`id`
    INNER JOIN `songs` ON `albums`.`songs_id` = `songs`.`id`
    WHERE `artists`.`genre` = 'Trip-Hop'

Аггрегаторы
^^^^^^^^^^^
Следующий пример показывает, как использовать аггрегаторы в PHQL:

.. code-block:: php

    <?php

    // Сколько стоят все машины?
    $phql = "SELECT SUM(price) AS summatory FROM Cars";
    $row  = $manager->executeQuery($phql)->getFirst();
    echo $row['summatory'];

    // Сколько машин каждой марки?
    $phql = "SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->brand_id, ' ', $row["1"], "\n";
    }

    // Сколько различных марок?
    $phql = "SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->name, ' ', $row["1"], "\n";
    }

    $phql = "SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row["maximum"], ' ', $row["minimum"], "\n";
    }

    // Сколько различных марок машин использовано?
    $phql = "SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->brandId, "\n";
    }

Условия
^^^^^^^
Условия позволяют отфильтровать необходимый нам набор записей для запроса. WHERE позволяет это сделать:

.. code-block:: php

    <?php

    // Простые условия
    $phql = "SELECT * FROM Cars WHERE Cars.name = 'Lamborghini Espada'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.price > 10000";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE TRIM(Cars.name) = 'Audi R8'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.name LIKE 'Ferrari%'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.name NOT LIKE 'Ferrari%'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.price IS NULL";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id IN (120, 121, 122)";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id NOT IN (430, 431)";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id BETWEEN 1 AND 100";
    $cars = $manager->executeQuery($phql);

Так же, как часть PHQL, в целях безопасности, входные данные, переданные в качестве параметров, будут автоматически экранированы:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE Cars.name = :name:";
    $cars = $manager->executeQuery(
        $phql,
        [
            "name" => "Lamborghini Espada"
        ]
    );

    $phql = "SELECT * FROM Cars WHERE Cars.name = ?0";
    $cars = $manager->executeQuery(
        $phql,
        [
            0 => "Lamborghini Espada"
        ]
    );

Вставка данных
--------------
С помощью PHQL можно вставлять данные используя знакомый уже оператор INSERT:

.. code-block:: php

    <?php

    // Вставка без указания столбцов
    $phql = "INSERT INTO Cars VALUES (NULL, 'Lamborghini Espada', "
          . "7, 10000.00, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // Указание конкретных столбцов для вставки
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES ('Lamborghini Espada', 7, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // Вставка с использованием плейсхолдеров
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES (:name:, :brand_id:, :year:, :style)";
    $manager->executeQuery(
        $phql,
        [
            "name"     => "Lamborghini Espada",
            "brand_id" => 7,
            "year"     => 1969,
            "style"    => "Grand Tourer",
        ]
    );

Phalcon не только преобразует PHQL выражения в SQL. Все события и бизнес-правила, определённые в модели будут выполнены, даже если мы создаём отдельные объекты вручную. Добавим правило в модель автомобилей, например, цена не может быть меньше $ 10 000:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Message;

    class Cars extends Model
    {
        public function beforeCreate()
        {
            if ($this->price < 10000) {
                $this->appendMessage(
                    new Message("A car cannot cost less than $ 10,000")
                );

                return false;
            }
        }
    }

Теперь, если мы сделаем INSERT в модель Автомобилей, то эта операция не будет выполнена, потому что цена, которую мы передаем, не удовлетворяет реализованному правилу:

.. code-block:: php

    <?php

    $phql = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2015, 'Sedan')";

    $result = $manager->executeQuery($phql);

    if ($result->success() === false) {
        foreach ($result->getMessages() as $message) {
            echo $message->getMessage();
        }
    }

Изменение данных
----------------
Изменение записей очень похоже на их вставку. Как вы знаете, для изменения данных используется UPDATE. Когда запись изменяется, события связанные с этой операцией вызываются для каждой записи.

.. code-block:: php

    <?php

    // Изменение одного столбца
    $phql = "UPDATE Cars SET price = 15000.00 WHERE id = 101";
    $manager->executeQuery($phql);

    // Изменение нескольких столбцов
    $phql = "UPDATE Cars SET price = 15000.00, type = 'Sedan' WHERE id = 101";
    $manager->executeQuery($phql);

    // Изменение нескольких строк
    $phql = "UPDATE Cars SET price = 7000.00, type = 'Sedan' WHERE brands_id > 5";
    $manager->executeQuery($phql);

    // Использование плейсхолдеров
    $phql = "UPDATE Cars SET price = ?0, type = ?1 WHERE brands_id > ?2";
    $manager->executeQuery(
        $phql,
        [
            0 => 7000.00,
            1 => 'Sedan',
            2 => 5,
        ]
    );

UPDATE выполняет изменение в два этапа:

* Сначала, если у UPDATE есть условия WHERE, извлекаются все записи подходящие под эти условия,
* Затем, на основе выбранных объектов их изменённые поля сохраняются в базе данных

Такой способ выполнения позволяет событиям, виртуальным внешним ключам и проверкам (validations) принять участие в процессе изменения данных.
В итоге, вот такой код:

.. code-block:: php

    <?php

    $phql = "UPDATE Cars SET price = 15000.00 WHERE id > 101";

    $result = $manager->executeQuery($phql);

    if ($result->success() === false) {
        $messages = $result->getMessages();

        foreach ($messages as $message) {
            echo $message->getMessage();
        }
    }

эквивалентен такому:

.. code-block:: php

    <?php

    $messages = null;

    $process = function () use (&$messages) {
        $cars = Cars::find("id > 101");

        foreach ($cars as $car) {
            $car->price = 15000;

            if ($car->save() === false) {
                $messages = $car->getMessages();

                return false;
            }
        }

        return true;
    };

    $success = $process();

Удаление данных
---------------
Когда запись удаляется, события связанные с этой операцией будут выполнены для каждой записи:

.. code-block:: php

    <?php

    // Удаление одной записи
    $phql = "DELETE FROM Cars WHERE id = 101";
    $manager->executeQuery($phql);

    // Удаление нескольких записей
    $phql = "DELETE FROM Cars WHERE id > 100";
    $manager->executeQuery($phql);

    // Использование плейсхолдеров
    $phql = "DELETE FROM Cars WHERE id BETWEEN :initial: AND :final:";
    $manager->executeQuery(
        $phql,
        [
            "initial" => 1,
            "final"   => 100,
        ]
    );

Операция DELETE выполняется так же в два этапа, как и UPDATE. To check if the deletion produces
any validation messages you should check the status code returned:

.. code-block:: php

    <?php

    // Deleting multiple rows
    $phql = "DELETE FROM Cars WHERE id > 100";

    $result = $manager->executeQuery($phql);

    if ($result->success() === false) {
        $messages = $result->getMessages();

        foreach ($messages as $message) {
            echo $message->getMessage();
        }
    }

Создание запросов с использованием Query Builder
------------------------------------------------
Есть специальный конструктор для создания PHQL-запросов, избавляющий от необходимости писать PHQL-операторы и он так же весьма IDE-дружественен:

.. code-block:: php

    <?php

    // Получение целого набора
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->join("RobotsParts")
        ->orderBy("Robots.name")
        ->getQuery()
        ->execute();

    // Получение первой записи
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->join("RobotsParts")
        ->orderBy("Robots.name")
        ->getQuery()
        ->getSingleResult();

Что то же самое, что и:

.. code-block:: php

    <?php

    $phql = "SELECT Robots.* FROM Robots JOIN RobotsParts p ORDER BY Robots.name LIMIT 20";

    $result = $manager->executeQuery($phql);

Больше примеров использования конструктора:

.. code-block:: php

    <?php

    // 'SELECT Robots.* FROM Robots';
    $builder->from("Robots");

    // 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts';
    $builder->from(
        [
            "Robots",
            "RobotsParts",
        ]
    );

    // 'SELECT * FROM Robots';
    $phql = $builder->columns("*")
                    ->from("Robots");

    // 'SELECT id FROM Robots';
    $builder->columns("id")
            ->from("Robots");

    // 'SELECT id, name FROM Robots';
    $builder->columns(["id", "name"])
            ->from("Robots");

    // 'SELECT Robots.* FROM Robots WHERE Robots.name = "Voltron"';
    $builder->from("Robots")
            ->where("Robots.name = 'Voltron'");

    // 'SELECT Robots.* FROM Robots WHERE Robots.id = 100';
    $builder->from("Robots")
            ->where(100);

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" AND Robots.id > 50';
    $builder->from("Robots")
            ->where("type = 'virtual'")
            ->andWhere("id > 50");

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" OR Robots.id > 50';
    $builder->from("Robots")
            ->where("type = 'virtual'")
            ->orWhere("id > 50");

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name';
    $builder->from("Robots")
            ->groupBy("Robots.name");

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id';
    $builder->from("Robots")
            ->groupBy(["Robots.name", "Robots.id"]);

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name';
    $builder->columns(["Robots.name", "SUM(Robots.price)"])
        ->from("Robots")
        ->groupBy("Robots.name");

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name HAVING SUM(Robots.price) > 1000';
    $builder->columns(["Robots.name", "SUM(Robots.price)"])
        ->from("Robots")
        ->groupBy("Robots.name")
        ->having("SUM(Robots.price) > 1000");

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts';
    $builder->from("Robots")
        ->join("RobotsParts");

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p';
    $builder->from("Robots")
        ->join("RobotsParts", null, "p");

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p';
    $builder->from("Robots")
        ->join("RobotsParts", "Robots.id = RobotsParts.robots_id", "p");

    // 'SELECT Robots.* FROM Robots
    // JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p
    // JOIN Parts ON Parts.id = RobotsParts.parts_id AS t';
    $builder->from("Robots")
        ->join("RobotsParts", "Robots.id = RobotsParts.robots_id", "p")
        ->join("Parts", "Parts.id = RobotsParts.parts_id", "t");

    // 'SELECT r.* FROM Robots AS r';
    $builder->addFrom("Robots", "r");

    // 'SELECT Robots.*, p.* FROM Robots, Parts AS p';
    $builder->from("Robots")
        ->addFrom("Parts", "p");

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
    $builder->from(["r" => "Robots"])
            ->addFrom("Parts", "p");

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
    $builder->from(["r" => "Robots", "p" => "Parts"]);

    // 'SELECT Robots.* FROM Robots LIMIT 10';
    $builder->from("Robots")
        ->limit(10);

    // 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5';
    $builder->from("Robots")
            ->limit(10, 5);

    // 'SELECT Robots.* FROM Robots WHERE id BETWEEN 1 AND 100';
    $builder->from("Robots")
            ->betweenWhere("id", 1, 100);

    // 'SELECT Robots.* FROM Robots WHERE id IN (1, 2, 3)';
    $builder->from("Robots")
            ->inWhere("id", [1, 2, 3]);

    // 'SELECT Robots.* FROM Robots WHERE id NOT IN (1, 2, 3)';
    $builder->from("Robots")
            ->notInWhere("id", [1, 2, 3]);

    // 'SELECT Robots.* FROM Robots WHERE name LIKE '%Art%';
    $builder->from("Robots")
            ->where("name LIKE :name:", ["name" => "%" . $name . "%"]);

    // 'SELECT r.* FROM Store\Robots WHERE r.name LIKE '%Art%';
    $builder->from(['r' => 'Store\Robots'])
            ->where("r.name LIKE :name:", ["name" => "%" . $name . "%"]);

Связанные параметры
^^^^^^^^^^^^^^^^^^^
В Query Builder можно устанавливать связанные параметры, указывать их можно непосредственно в запросе, либо в момент выполнения:

.. code-block:: php

    <?php

    // Указываем параметры в формирующих участках
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->where("name = :name:", ["name" => $name])
        ->andWhere("type = :type:", ["type" => $type])
        ->getQuery()
        ->execute();

    // Указываем параметры при выполнении запроса
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->where("name = :name:")
        ->andWhere("type = :type:")
        ->getQuery()
        ->execute(["name" => $name, "type" => $type]);

Запрет на константы в PHQL
--------------------------
Константы можно отключить в PHQL, это означает, что напрямую строки, числа или булевы значения
использовать в PHQL будет нельзя.  Если PHQL запросы создаются со встраиванием внешних данных с
помощью констант, то это может открыть приложение для потенциальных SQL-инъекций:

.. code-block:: php

    <?php

    $login = 'voltron';

    $phql = "SELECT * FROM Models\Users WHERE login = '$login'";

    $result = $manager->executeQuery($phql);

Если значение :code:`$login` заменить на :code:`' OR '' = '`, то получим следующий PHQL:

.. code-block:: sql

    SELECT * FROM Models\Users WHERE login = '' OR '' = ''

Что всегда имеет место быть, независимо от того, что логин хранится в базе данных.

Если константы запрещены, строки могут быть использованы как часть PHQL  запроса, таким образом будет
брошено исключение, заставляющее разработчика использовать связанные параметры. Этот же запрос можно
записать в безопасном виде вот так:

.. code-block:: php

    <?php

    $phql = "SELECT Robots.* FROM Robots WHERE Robots.name = :name:";

    $result = $manager->executeQuery(
        $phql,
        [
            "name" => $name,
        ]
    );

Запретить константы можно следующим способом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    Model::setup(
        [
            "phqlLiterals" => false
        ]
    );

Связанные параметры можно использовать, даже если константы разрешены. Запрет на них является еще
одним безопасным решением, которое разработчик может использовать в web-приложениях.

Экранирование зарезервированных слов
------------------------------------
У PHQL есть несколько зарезервированных слов, и если вы хотите использовать какое-то из них в качестве атрибутов или названий моделей, то вам придётся их экранировать с помощью '[' и ']':

.. code-block:: php

    <?php

    $phql   = "SELECT * FROM [Update]";
    $result = $manager->executeQuery($phql);

    $phql   = "SELECT id, [Like] FROM Posts";
    $result = $manager->executeQuery($phql);

Эти разделители будут динамически преобразованы в валидные разделители той СУБД, которая используется приложением в текущий момент.

Жизненный цикл PHQL
-------------------
Будучи высокоуровневым языком, PHQL даёт разработчикам возможность персонализировать и настраивать различные аспекты под свои нужды. Ниже представлен жизненный цикл исполнения каждого PHQL-оператора:

* PHQL разбирает и преобразует в промежуточное представление, независящее от текущей СУБД
* Это промежуточное представление преобразуется в валидный SQL, соответствующий СУБД, связанной с моделью
* Все параметры и сформированный PHQL запрос кэшируется в памяти. Повторные выполнения этого же запроса производятся в разы быстрее

Использование чистого SQL
-------------------------
СУБД могут предлагать свои специфические SQL-расширения, не поддерживаемые PHQL, в этом случае можно использовать чистый SQL:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Model
    {
        public static function findByCreateInterval()
        {
            // Выражение на чистом SQL
            $sql = "SELECT * FROM robots WHERE id > 0";

            // Модель
            $robot = new Robots();

            // Выполнение запроса
            return new Resultset(
                null,
                $robot,
                $robot->getReadConnection()->query($sql)
            );
        }
    }

Если чистые SQL-запросы являются общими для вашего приложения, то в модель можно добавить универсальный метод:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Model
    {
        public static function findByRawSql($conditions, $params = null)
        {
            // Выражение на чистом SQL
            $sql = "SELECT * FROM robots WHERE $conditions";

            // Модель
            $robot = new Robots();

            // Выполнение запроса
            return new Resultset(
                null,
                $robot,
                $robot->getReadConnection()->query($sql, $params)
            );
        }
    }

Определённый выше метод findByRawSql может быть использован следующим образом:

.. code-block:: php

    <?php

    $robots = Robots::findByRawSql(
        "id > ?",
        [
            10
        ]
    );

Поиск и исправление проблем
---------------------------
Имейте в виду следующие моменты, когда используете PHQL:

* Классы регистрозависимы, если класс не определён так, как он определён, то это может привести к неожиданному поведению.
* Чтобы успешно связывать (bind) параметры, в соединении должна быть определена правильная кодировка.
* Классы, для которых заданы алиасы не заменяются классами с неймспейсами, поскольку это происходит только в PHP коде, а не внутри строк.
* Если включено переименование колонок, избегайте использования алиасов с таким же именем, что и колонка, которую вы хотите переименовать. Иначе могут возникнуть проблемы при разрешении имен.

.. _SQLite: http://en.wikipedia.org/wiki/Lemon_Parser_Generator
