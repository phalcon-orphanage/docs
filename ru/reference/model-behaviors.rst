Поведение модели
================

Поведение - общий алгоритм, по которому могут работать несколько моделей, позволяющий повторно использовать код. ORM предоставляет API для реализации
поведения в вашей модели. Кроме того, вы можете использовать события и функции обратного вызова, как видели раньше, в качестве альтернативы для более свободной реализации поведения.

Поведение должно быть добавлено при инициализации модели, модель может иметь ноль или более поведений:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Behavior\Timestampable;

    class Users extends Model
    {
        public $id;

        public $name;

        public $created_at;

        public function initialize()
        {
            $this->addBehavior(
                new Timestampable(
                    [
                        "beforeCreate" => [
                            "field"  => "created_at",
                            "format" => "Y-m-d",
                        ]
                    ]
                )
            );
        }
    }

Фреймворком предоставлены следующие встроенные поведения:

+----------------+---------------------------------------------------------------------------------------------------------------------+
| Название       | Описание                                                                                                            |
+================+=====================================================================================================================+
| Timestampable  | Позволяет автоматически обновлять атрибут модели, сохраняя дату и время, когда запись создается или обновляется     |
+----------------+---------------------------------------------------------------------------------------------------------------------+
| SoftDelete     | Вместо окончательного удаления записи, измением значения флага столбца она помечается как удаленная                 |
+----------------+---------------------------------------------------------------------------------------------------------------------+

Timestampable
-------------
Это поведение в качестве аргумента принимает массив, ключи которого являются названиями событий, указывающих на то, когда должно происходить присваивание:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior\Timestampable;

    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    "beforeCreate" => [
                        "field"  => "created_at",
                        "format" => "Y-m-d",
                    ]
                ]
            )
        );
    }

Каждое событие может иметь свои собственные настройки. 'field' -  имя столбца, который необходимо обновить. Если 'format' является строкой, то будет использоваться
в качестве формата PHP функции date_, format также может быть анонимной функцией, позволяющей вам свободно создавать любые виды временных меток:

.. code-block:: php

    <?php

    use DateTime;
    use DateTimeZone;
    use Phalcon\Mvc\Model\Behavior\Timestampable;

    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    "beforeCreate" => [
                        "field"  => "created_at",
                        "format" => function () {
                            $datetime = new Datetime(
                                new DateTimeZone("Europe/Stockholm")
                            );

                            return $datetime->format("Y-m-d H:i:sP");
                        }
                    ]
                ]
            )
        );
    }

Если опция 'format' опущена, то будет использованна временная метка PHP функции time_.

SoftDelete
----------
Это поведение может быть использовано следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Behavior\SoftDelete;

    class Users extends Model
    {
        const DELETED = "D";

        const NOT_DELETED = "N";



        public $id;

        public $name;

        public $status;



        public function initialize()
        {
            $this->addBehavior(
                new SoftDelete(
                    [
                        "field" => "status",
                        "value" => Users::DELETED,
                    ]
                )
            );
        }
    }

Это поведение принимает две опции: 'field' и 'value'. 'field' указывает поле, которое должно быть обновлено, и 'value' - значение, которым будут помечаться удаленные записи.
Давайте представим, что таблица 'users' имеет следующие данные:

.. code-block:: bash

    mysql> select * from users;
    +----+---------+--------+
    | id | name    | status |
    +----+---------+--------+
    |  1 | Lana    | N      |
    |  2 | Brandon | N      |
    +----+---------+--------+
    2 rows in set (0.00 sec)

Если мы удалим любую из двух записей, изменится status вместо удаления записи:

.. code-block:: php

    <?php

    Users::findFirst(2)->delete();

Операция приводит к следующим данным в таблице:

.. code-block:: bash

    mysql> select * from users;
    +----+---------+--------+
    | id | name    | status |
    +----+---------+--------+
    |  1 | Lana    | N      |
    |  2 | Brandon | D      |
    +----+---------+--------+
    2 rows in set (0.01 sec)

Обратите внимание, что вам необходимо самостоятельно указывать в запросах условие удаления записи для того, чтобы игнорировать их как удаленные. Подобная логика не поддерживается поведением.

Создание собственных поведений
------------------------------
ORM предоставляет API для создания собственного поведения. Поведение должно быть классом, реализующим :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <../api/Phalcon_Mvc_Model_BehaviorInterface>`.
Кроме того, :doc:`Phalcon\\Mvc\\Model\\Behavior <../api/Phalcon_Mvc_Model_Behavior>` предоставляет большую часть методов, необходимых для простой реализации поведения.

В качестве примера приведем следующее поведение, оно реализует поведение Blameable, которое помогает идентифицировать пользователя,
выполняющего операции с моделью:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior;
    use Phalcon\Mvc\Model\BehaviorInterface;

    class Blameable extends Behavior implements BehaviorInterface
    {
        public function notify($eventType, $model)
        {
            switch ($eventType) {

                case "afterCreate":
                case "afterDelete":
                case "afterUpdate":

                    $userName = // ... получаем текущего пользователя из сессии

                    // Сохраняем в логах имя пользователя, тип события и идентификатор записи
                    file_put_contents(
                        "logs/blamable-log.txt",
                        $userName . " " . $eventType . " " . $model->id
                    );

                    break;

                default:
                    /* игнорируем остальные события */
            }
        }
    }

Пример выше довольно прост, но он показывает, как создать поведение. Теперь давайте добавим его в модель:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Profiles extends Model
    {
        public function initialize()
        {
            $this->addBehavior(
                new Blameable()
            );
        }
    }

Поведение также может перехватывать отсутствующие методы ваших моделей:

.. code-block:: php

    <?php

    use Phalcon\Tag;
    use Phalcon\Mvc\Model\Behavior;
    use Phalcon\Mvc\Model\BehaviorInterface;

    class Sluggable extends Behavior implements BehaviorInterface
    {
        public function missingMethod($model, $method, $arguments = [])
        {
            // Если метод - 'getSlug', то преобразуем заголовок
            if ($method === "getSlug") {
                return Tag::friendlyTitle($model->title);
            }
        }
    }

Вызов этого метода у модели, реализующей Sluggable, возвращает SEO-оптимизированный заголовок:

.. code-block:: php

    <?php

    $title = $post->getSlug();

Использование трейтов, как поведение
------------------------------------
Начиная с PHP 5.4 вы можете использовать трейты, чтобы повторно использовать код в ваших классах. Это еще один способ для реализации
пользовательского поведения. Следующий трейт реализует простой вариант поведения Timestampable:

.. code-block:: php

    <?php

    trait MyTimestampable
    {
        public function beforeCreate()
        {
            $this->created_at = date("r");
        }

        public function beforeUpdate()
        {
            $this->updated_at = date("r");
        }
    }

Затем вы можете использовать его в вашей модели следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Products extends Model
    {
        use MyTimestampable;
    }

.. _date: http://php.net/manual/ru/function.date.php
.. _time: http://php.net/manual/ru/function.time.php
.. _Traits: http://php.net/manual/ru/language.oop5.traits.php
