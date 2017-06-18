Filtering and Sanitizing
========================

Фильтрация пользовательского ввода является критической частью разработки приложений. Доверие или пренебрежение очисткой и
фильтрацией ввода произведенного пользователем может привести к несанкционированному доступу к контенту вашего приложения, данным или даже к серверу, где ваше приложение размещено.

.. figure:: ../_static/img/sql.png
   :align: center

`Полное изображение (с сайта xkcd)`_

Компонент :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` предоставляет набор основных фильтров для корректирования данных. Он обеспечивает объектно-ориентированную обертку вокруг PHP-фильтра.

Типы встроенных фильтров
------------------------
В таблице приведены все типы фильтров, которыми распологает компонент:

+-----------+-------------------------------------------------------------------------------------+
| Название  | Описание                                                                            |
+===========+=====================================================================================+
| string    | Очищает теги и кодирует HTML-сущности, в том числе одинарные и двойные кавычки.     |
+-----------+-------------------------------------------------------------------------------------+
| email     | Удаляет все символы, за исключением букв, цифр и !#$%&*+-/=?^_`{\|}~@.[].           |
+-----------+-------------------------------------------------------------------------------------+
| int       | Удаляет все символы, за исключением цифр и знаков плюс/минус.                       |
+-----------+-------------------------------------------------------------------------------------+
| float     | Удаляет все символы, за исключением цифр, точек и знаков плюс/минус.                |
+-----------+-------------------------------------------------------------------------------------+
| alphanum  | Удаляет все символы, за исключением [a-zA-Z0-9]                                     |
+-----------+-------------------------------------------------------------------------------------+
| striptags | Применяет strip_tags_ функцию                                                       |
+-----------+-------------------------------------------------------------------------------------+
| trim      | Применяет trim_ функцию                                                             |
+-----------+-------------------------------------------------------------------------------------+
| lower     | Применяет strtolower_ функцию                                                       |
+-----------+-------------------------------------------------------------------------------------+
| upper     | Применяет strtoupper_ функцию                                                       |
+-----------+-------------------------------------------------------------------------------------+

Очистка данных
--------------
Очистка - это процесс, который удаляет определенный символ из значения, которое было введено пользователем.
С помощью очистки входных данных мы гарантируем, что целостность приложения не будет нарушена.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // возвращает "someone@example.com"
    $filter->sanitize("some(one)@exa\mple.com", "email");

    // возвращает "hello"
    $filter->sanitize("hello<<", "string");

    // возвращает "100019"
    $filter->sanitize("!100a019", "int");

    // возвращает "100019.01"
    $filter->sanitize("!100a019.01a", "float");


Очистка из контроллеров
-----------------------
Доступ к объекту :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` можно получить из контроллера для очистки GET или POST входных данных.
Первым параметром является название переменной, которую необходимо получить, а вторым - название фильтра, который должен быть применен относительно этой переменной.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Чистим price из ввода
            $price = $this->request->getPost("price", "double");

            // Чистим email из ввода
            $email = $this->request->getPost("customerEmail", "email");
        }
    }

Фильтруем параметры действия (Action)
-------------------------------------
Следующий пример показывает, как чистить параметры действий в контроллере:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($productId)
        {
            $productId = $this->filter->sanitize($productId, "int");
        }
    }

Фильтрация данных
-----------------
В дополнение к очистке, класс :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` так же предоставляет фильтрацию, которая изменяет или удаляет
данные в соответствии с ожидаемым форматом.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // возвращает "Hello"
    $filter->sanitize("<h1>Hello</h1>", "striptags");

    // возвращает "Hello"
    $filter->sanitize("  Hello   ", "trim");

Combining Filters
-----------------
You can also run multiple filters on a string at the same time by passing an array of filter identifiers as the second parameter:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // возвращает "Hello"
    $filter->sanitize(
        "   <h1> Hello </h1>   ",
        [
            "striptags",
            "trim",
        ]
    );

Создание собственных фильтров
-----------------------------
Вы можете добавлять свои фильтры в :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`. Функция фильтрации может быть анонимной:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Используем анонимную функцию
    $filter->add(
        "md5",
        function ($value) {
            return preg_replace("/[^0-9a-f]/", "", $value);
        }
    );

    // Используем "md5" фильтр
    $filtered = $filter->sanitize($possibleMd5, "md5");

Вы можете реализовать фильтр с помощью класса:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    class IPv4Filter
    {
        public function filter($value)
        {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }
    }

    $filter = new Filter();

    // Используем объект
    $filter->add(
        "ipv4",
        new IPv4Filter()
    );

    // Фильтруем с помощью "ipv4"
    $filteredIp = $filter->sanitize("127.0.0.1", "ipv4");

Сложная очистка и фильтрация
----------------------------
PHP предоставляет отличную фильтрацию, которой вы можете воспользоваться. Посмотрите на документацию: `Фильтрация данных в документации PHP`_

Разработка собственной системы фильтрации
-----------------------------------------
Используйте интерфейс :doc:`Phalcon\\FilterInterface <../api/Phalcon_FilterInterface>` для создания собственной системы фильтрации,
чтобы заменить существующую в Phalcon.

.. _Полное изображение (с сайта xkcd): http://xkcd.com/327/
.. _Фильтрация данных в документации PHP: http://www.php.net/manual/ru/book.filter.php
.. _strip_tags: http://www.php.net/manual/ru/function.strip-tags.php
.. _trim: http://www.php.net/manual/ru/function.trim.php
.. _strtolower: http://www.php.net/manual/ru/function.strtolower.php
.. _strtoupper: http://www.php.net/manual/ru/function.strtoupper.php
