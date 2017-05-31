Работа с моделями
=================

Отношения между моделями
------------------------
Существует четыре типа отношений: один-к-одному, один-ко-многим, многие-к-одному и многие-ко-многим. Отношения могут быть
однонаправленными или двунаправленными, и каждое может быть простым (один модель к одной) или более сложные (комбинация моделей).
Менеджер моделей управляет ограничением внешних ключей для этих отношений, их определение помогает ссылочной целостности,
а также обеспечивает легкий и быстрый доступ к соответствующей записи в модели. Благодаря реализации отношений,
легко получить доступ к данным в связных моделях для любой выбранной записи(-ей).

Однонаправленные отношения
^^^^^^^^^^^^^^^^^^^^^^^^^^
Однонаправленные отношения это те отношения, которые генерируются в отношении от одной к другой, но не наоборот.

Двунаправленные отношения
^^^^^^^^^^^^^^^^^^^^^^^^^
Двунаправленные отношения создают отношения в обеих моделях, и каждая модель определяет обратную связь от другой.

Определение отношений
^^^^^^^^^^^^^^^^^^^^^
В Phalcon отношения должны быть определены в методе :code:`initialize()` модели. Методы :code:`belongsTo()`, :code:`hasOne()`,
:code:`hasMany()` и :code:`hasManyToMany()` определяют отношения между одним или несколькими полями из текущей модели в поля
другой модели. Каждый из этих методов требует 3 параметра: поля текущей модели, модель, на которую ссылаются, и ее поля.

+---------------+--------------------------+
| Метод         | Описание                 |
+===============+==========================+
| hasMany       | Определяет 1-n отношения |
+---------------+--------------------------+
| hasOne        | Определяет 1-1 отношения |
+---------------+--------------------------+
| belongsTo     | Определяет n-1 отношения |
+---------------+--------------------------+
| hasManyToMany | Определяет n-n отношения |
+---------------+--------------------------+

Следующая схема показывает 3 таблицы, чьи отношения будут служить нам в качестве примера, касающиеся отношений:

.. code-block:: sql

    CREATE TABLE `robots` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        `type` varchar(32) NOT NULL,
        `year` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    );

    CREATE TABLE `robots_parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `robots_id` int(10) NOT NULL,
        `parts_id` int(10) NOT NULL,
        `created_at` DATE NOT NULL,
        PRIMARY KEY (`id`),
        KEY `robots_id` (`robots_id`),
        KEY `parts_id` (`parts_id`)
    );

    CREATE TABLE `parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        PRIMARY KEY (`id`)
    );

* Модель "Robots" имеет несколько "RobotsParts".
* Модель "Parts" имеет несколько "RobotsParts".
* Модель "RobotsParts" принадлежит обоим "Robots" и "Parts" моделям как многие-к-одному.
* Модель "Robots" имеет отношение многие-ко-многим к "Parts" через "RobotsParts".

Посмотрим EER схему, чтобы лучше понять отношения:

.. figure:: ../_static/img/eer-1.png
    :align: center

Модели с их отношениями могут быть реализованы следующим образом:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany(
                "id",
                "RobotsParts",
                "robots_id"
            );
        }
    }

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Parts extends Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany(
                "id",
                "RobotsParts",
                "parts_id"
            );
        }
    }

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class RobotsParts extends Model
    {
        public $id;

        public $robots_id;

        public $parts_id;

        public function initialize()
        {
            $this->belongsTo(
                "robots_id",
                "Store\\Toys\\Robots",
                "id"
            );

            $this->belongsTo(
                "parts_id",
                "Parts",
                "id"
            );
        }
    }

Первый параметр указывает локальные поля модели, используемые в отношениях; второй указывает имя
модели, на которую ссылаются; и третий - имя поля в указанной модели. Вы также можете использовать массивы для определения нескольких полей в отношениях.

Отношение "многие-ко-многим" требуют 3 модели и определение атрибутов, участвующих в отношениях:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasManyToMany(
                "id",
                "RobotsParts",
                "robots_id", "parts_id",
                "Parts",
                "id"
            );
        }
    }

Преимущества отношений
^^^^^^^^^^^^^^^^^^^^^^
При явном определении отношений между моделями, легко найти относящиеся записи для конкретной записи.

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(2);

    foreach ($robot->robotsParts as $robotPart) {
        echo $robotPart->parts->name, "\n";
    }

Phalcon использует магические методы :code:`__set`/:code:`__get`/:code:`__call` для сохранения или извлечения связанных данных, используя отношения.

По доступу к атрибуту с таким же именем, что и отношения, будем получать все связанные с ней записи.

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst();

    // все связанные записи в RobotsParts
    $robotsParts = $robot->robotsParts;

Кроме того, вы можете использовать магические геттеры:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst();

    // все связанные записи в RobotsParts
    $robotsParts = $robot->getRobotsParts();

    // передача параметров
    $robotsParts = $robot->getRobotsParts(
        [
            "limit" => 5,
        ]
    );

Если вызываемый метод имеет "get" префикс, то :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` вернет
:code:`findFirst()`/:code:`find()`. В следующем примере сравниваются получение соответствующих результатов с использованием магических методов
и без:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(2);

    // Модель Robots имеет отношение 1-n (hasMany)
    // к RobotsParts
    $robotsParts = $robot->robotsParts;

    // Только те, которые соответствуют условию
    $robotsParts = $robot->getRobotsParts(
        [
            "created_at = :date:",
            "bind" => [
                "date" => "2015-03-15"
            ]
        ]
    );

    $robotPart = RobotsParts::findFirst(1);

    // Модель RobotsParts имеет отношение n-1 (belongsTo)
    // к Robots
    $robot = $robotPart->robots;

Получение связанных записей вручную:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(2);

    // Модель Robots имеет отношение 1-n (hasMany)
    // к  RobotsParts
    $robotsParts = RobotsParts::find(
        [
            "robots_id = :id:",
            "bind" => [
                "id" => $robot->id,
            ]
        ]
    );

    // Только те, которые соответствуют условиям
    $robotsParts = RobotsParts::find(
        [
            "robots_id = :id: AND created_at = :date:",
            "bind" => [
                "id"   => $robot->id,
                "date" => "2015-03-15",
            ]
        ]
    );

    $robotPart = RobotsParts::findFirst(1);

    // Модель RobotsParts имеет отношение n-1 (belongsTo)
    // к RobotsParts
    $robot = Robots::findFirst(
        [
            "id = :id:",
            "bind" => [
                "id" => $robotPart->robots_id,
            ]
        ]
    );


Префикс "get" используется для поиска связанных записей. В зависимости от типа отношений будет использоваться
:code:`find()` или :code:`findFirst()`:

+--------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Тип                | Описание                                                                                                                                               | Неявный метод       |
+====================+========================================================================================================================================================+=====================+
| Belongs-To         | Возвращает экземпляр модели взаимосвязанной записи                                                                                                     | findFirst           |
+--------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Has-One            | Возвращает экземпляр модели взаимосвязанной записи                                                                                                     | findFirst           |
+--------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Has-Many           | Возвращает коллекцию экземпляров модели, на которую ссылается данная модель                                                                            | find                |
+--------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Has-Many-to-Many   | Возвращает коллекцию экземпляров модели, на которую ссылается данная модель, неявно выполняются внутренние соединения (inner join) с зависимой моделью | составной запрос    |
+--------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+

Вы можете также использовать префикс "count" для подсчета количества связанных записей:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(2);

    echo "У робота ", $robot->countRobotsParts(), " частей\n";

Алиасы отношений
^^^^^^^^^^^^^^^^
Чтобы лучше объяснить, как алиасы работают, давайте рассмотрим следующий пример:

В таблице "robots_similar" есть функция, для определения, что роботы похожи на других:

.. code-block:: bash

    mysql> desc robots_similar;
    +-------------------+------------------+------+-----+---------+----------------+
    | Field             | Type             | Null | Key | Default | Extra          |
    +-------------------+------------------+------+-----+---------+----------------+
    | id                | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | robots_id         | int(10) unsigned | NO   | MUL | NULL    |                |
    | similar_robots_id | int(10) unsigned | NO   |     | NULL    |                |
    +-------------------+------------------+------+-----+---------+----------------+
    3 rows in set (0.00 sec)

И "robots_id" и "similar_robots_id" имеют отношение к модели Robots:

.. figure:: ../_static/img/eer-2.png
   :align: center

Модель, которая отображает эту таблицу и ее отношения выглядит так:

.. code-block:: php

    <?php

    class RobotsSimilar extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->belongsTo(
                "robots_id",
                "Store\\Toys\\Robots",
                "id"
            );

            $this->belongsTo(
                "similar_robots_id",
                "Store\\Toys\\Robots",
                "id"
            );
        }
    }

Так как отношения указывают на ту же модель (Robots), получить записи, относящиеся к взаимосвязи корректно нельзя:

.. code-block:: php

    <?php

    $robotsSimilar = RobotsSimilar::findFirst();

    // Возвращает связанную запись на основе столбца (robots_id)
    // Потому как имеется отношение belongsTo, то возвращается только одна запись,
    // но название 'getRobots' подразумевает, что вернётся больше одной записи
    $robot = $robotsSimilar->getRobots();

    // но, как получить соответствующую запись на основании столбца (similar_robots_id)
    // если оба отношения имеют одно и то же имя?

Алиасы позволяют переименовать оба отношения для решения этих проблем:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class RobotsSimilar extends Model
    {
        public function initialize()
        {
            $this->belongsTo(
                "robots_id",
                "Store\\Toys\\Robots",
                "id",
                [
                    "alias" => "Robot",
                ]
            );

            $this->belongsTo(
                "similar_robots_id",
                "Store\\Toys\\Robots",
                "id",
                [
                    "alias" => "SimilarRobot",
                ]
            );
        }
    }

С алиасами мы можем легко получить соответствующие записи:

.. code-block:: php

    <?php

    $robotsSimilar = RobotsSimilar::findFirst();

    // Возвращает связанную запись на основе столбца (robots_id)
    $robot = $robotsSimilar->getRobot();
    $robot = $robotsSimilar->robot;

    // Возвращает связанную запись на основе столбца (similar_robots_id)
    $similarRobot = $robotsSimilar->getSimilarRobot();
    $similarRobot = $robotsSimilar->similarRobot;

Магические методы против явных
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Большинство сред IDE и редакторов с автодополнением не могут определить корректные типы при использовании магических методов,
вместо этого вы можете при желании задать эти методы явно с соответствующими
doc-блоками, помогая IDE лучше выполнять автодополнение:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany(
                "id",
                "RobotsParts",
                "robots_id"
            );
        }

        /**
         * Возвращает соответствующие "robots parts"
         *
         * @return \RobotsParts[]
         */
        public function getRobotsParts($parameters = null)
        {
            return $this->getRelated("RobotsParts", $parameters);
        }
    }

Виртуальные внешние ключи
-------------------------
По умолчанию отношения не ведут себя как внешние ключи базы данных, то есть, если вы пытаетесь вставить/обновить значение, не имея действительного
значения в модели, на которую ссылаетесь, то Phalcon не выведет никаких сообщений валидации. Вы можете изменить данное поведение, добавив четвертый параметр
при определении отношения.

Модель RobotsPart может быть изменена, чтобы продемонстрировать эту функцию:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class RobotsParts extends Model
    {
        public $id;

        public $robots_id;

        public $parts_id;

        public function initialize()
        {
            $this->belongsTo(
                "robots_id",
                "Store\\Toys\\Robots",
                "id",
                [
                    "foreignKey" => true
                ]
            );

            $this->belongsTo(
                "parts_id",
                "Parts",
                "id",
                [
                    "foreignKey" => [
                        "message" => "part_id не существует в модели Parts"
                    ]
                ]
            );
        }
    }

Если вы изменяете отношение :code:`belongsTo()`, включая foreignKey, то значения, вставленные/обновленные в тех полях, будут проверяться
на корректность. Аналогичным образом, если изменяется :code:`hasMany()`/:code:`hasOne()`, будет проверяться, то что записи не могут быть удалены,
если используются в зависимой модели.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Parts extends Model
    {
        public function initialize()
        {
            $this->hasMany(
                "id",
                "RobotsParts",
                "parts_id",
                [
                    "foreignKey" => [
                        "message" => "Деталь не может быть удалена, поскольку другие роботы используют ее",
                    ]
                ]
            );
        }
    }

Виртуальный внешний ключ может быть установлен, чтобы позволить работать с :code:`null` значениями:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class RobotsParts extends Model
    {
        public $id;

        public $robots_id;

        public $parts_id;

        public function initialize()
        {
            $this->belongsTo(
                "parts_id",
                "Parts",
                "id",
                [
                    "foreignKey" => [
                        "allowNulls" => true,
                        "message"    => "part_id нет в модели Parts",
                    ]
                ]
            );
        }
    }

Cascade/restrict действия
^^^^^^^^^^^^^^^^^^^^^^^^^
Отношения, которые задействуют виртуальные внешние ключи, по умолчанию ограничивают создание/обновление/удаление записей
для поддержания целостности данных:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Relation;

    class Robots extends Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany(
                "id",
                "Parts",
                "robots_id",
                [
                    "foreignKey" => [
                        "action" => Relation::ACTION_CASCADE,
                    ]
                ]
            );
        }
    }

Код выше удалит все относящиеся записи (parts), если основная запись (robot) удаляется.

Связаное сохранение записей
---------------------------
Магические свойства могут быть использованы для хранения записей и связанных с ними свойств:

.. code-block:: php

    <?php

    // Создать артиста
    $artist = new Artists();

    $artist->name    = "Shinichi Osawa";
    $artist->country = "Japan";

    // Создать альбом
    $album = new Albums();

    $album->name   = "The One";
    $album->artist = $artist; // Назначить артиста
    $album->year   = 2008;

    // Сохранить обе записи
    $album->save();

Сохранение записи и связанных с ней записей в has-many соотношении:

.. code-block:: php

    <?php

    // Получить существующего артиста
    $artist = Artists::findFirst(
        "name = 'Shinichi Osawa'"
    );

    // Создать альбом
    $album = new Albums();

    $album->name   = "The One";
    $album->artist = $artist;

    $songs = [];

    // Создать первую песню
    $songs[0]           = new Songs();
    $songs[0]->name     = "Star Guitar";
    $songs[0]->duration = "5:54";

    // Создать вторую песню
    $songs[1]           = new Songs();
    $songs[1]->name     = "Last Days";
    $songs[1]->duration = "4:29";

    // Связать массив песен
    $album->songs = $songs;

    // Сохранить альбом + эти песни
    $album->save();

При сохранении альбома и группы неявно используются транзакции, так что если что-то
пойдет не так с сохранением соответствующих записей, то родитель не будет сохранен. Пользователю
будут переданы собщения с информацией об ошибках.

Обратите внимание: добавление связанных записей с помощью перегрузки следующих методов невозможно:

 - :code:`Phalcon\Mvc\Model::beforeSave()`
 - :code:`Phalcon\Mvc\Model::beforeCreate()`
 - :code:`Phalcon\Mvc\Model::beforeUpdate()`

Для этого вам необходимо перегрузить метод :code:`Phalcon\Mvc\Model::save()`.

Операции над набором результатов
--------------------------------
Если набор результатов состоит из конечных объектов, то может гораздо проще производить операции над записями:

Обновление связанных записей
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Вместо того, чтобы делать так:

.. code-block:: php

    <?php

    $parts = $robots->getParts();

    foreach ($parts as $part) {
        $part->stock      = 100;
        $part->updated_at = time();

        if ($part->update() === false) {
            $messages = $part->getMessages();

            foreach ($messages as $message) {
                echo $message;
            }

            break;
        }
    }

Вы можете делать так:

.. code-block:: php

    <?php

    $robots->getParts()->update(
        [
            "stock"      => 100,
            "updated_at" => time(),
        ]
    );

'update' также принимает анонимную функцию, чтобы отфильтровать записи, которые должны быть обновлены:

.. code-block:: php

    <?php

    $data = [
        "stock"      => 100,
        "updated_at" => time(),
    ];

    // Обновить все части, кроме тех, чей тип базовый
    $robots->getParts()->update(
        $data,
        function ($part) {
            if ($part->type === Part::TYPE_BASIC) {
                return false;
            }

            return true;
        }
    );

Удаление связанных записей
^^^^^^^^^^^^^^^^^^^^^^^^^^
Вместо того, чтобы делать так:

.. code-block:: php

    <?php

    $parts = $robots->getParts();

    foreach ($parts as $part) {
        if ($part->delete() === false) {
            $messages = $part->getMessages();

            foreach ($messages as $message) {
                echo $message;
            }

            break;
        }
    }

Вы можете делать так:

.. code-block:: php

    <?php

    $robots->getParts()->delete();

:code:`delete()` также принимает анонимную функцию, чтобы отфильтровать записи, которые должны быть удалены:

.. code-block:: php

    <?php

    // Удалить только те, у которых поле stock больше или равно нулю
    $robots->getParts()->delete(
        function ($part) {
            if ($part->stock < 0) {
                return false;
            }

            return true;
        }
    );
