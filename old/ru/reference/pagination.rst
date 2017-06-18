Постраничная навигация (Paginators)
===================================

Разделение данных на страницы бывает актуально при необходимости вывести большой объём данных поэтапно. Компонент :code:`Phalcon\Paginator`
предлагает простой и удобный способ для этого случая.

Адаптеры данных
---------------
Компонент имеет встроенные адаптеры для разделения данных на страницы:

+-------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------------------+
| Адаптер                                                                                                           | Описание                                                                                              |
+===================================================================================================================+=======================================================================================================+
| :doc:`Phalcon\\Paginator\\Adapter\\NativeArray (Нативные массивы) <../api/Phalcon_Paginator_Adapter_NativeArray>` | Использует стандартные PHP-массивы                                                                    |
+-------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Paginator\\Adapter\\Model (Модели) <../api/Phalcon_Paginator_Adapter_Model>`                       | Использует объекты типа :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`    |
+-------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Paginator\\Adapter\\QueryBuilder <../api/Phalcon_Paginator_Adapter_QueryBuilder>`                  | Использует объект :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <../api/Phalcon_Mvc_Model_Query_Builder>` |
+-------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------------------+

Пример
------
В примере, приведенном ниже, пагинатор будет использовать в качестве источника результат запроса данных модели, и будет выводить данные по 10 записей на странице:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;

    // Текущая страница
    // В контроллерах/component можно использовать:
    // $this->request->getQuery("page", "int"); // GET
    // $this->request->getPost("page", "int"); // POST
    $currentPage = (int) $_GET["page"];

    // Набор данных для разбивки на страницы
    $robots = Robots::find();

    // Создаём пагинатор, отображаются 10 элементов на странице, начиная с текущей - $currentPage
    $paginator = new PaginatorModel(
        [
            "data"  => $robots,
            "limit" => 10,
            "page"  => $currentPage,
        ]
    );

    // Получение результатов работы ппагинатора
    $page = $paginator->getPaginate();

Переменная :code:`$currentPage` указывает то, какая страница сейчас отображается. Метод :code:`$paginator->getPaginate()` возвращает содержащие
данные разбивки объект :code:`$page`. Он может быть использован для вывода данные с разделением на страницы:

.. code-block:: html+php

    <table>
        <tr>
            <th>Id</th>
            <th>Имя</th>
            <th>Тип</th>
        </tr>
        <?php foreach ($page->items as $item) { ?>
        <tr>
            <td><?php echo $item->id; ?></td>
            <td><?php echo $item->name; ?></td>
            <td><?php echo $item->type; ?></td>
        </tr>
        <?php } ?>
    </table>

Объект :code:`$page` также содержит данные для навигации:

.. code-block:: html+php

    <a href="/robots/search">Первая</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Предыдущая</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Следующая</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Последняя</a>

    <?php echo "Вы на странице ", $page->current, " из ", $page->total_pages; ?>

Использование адаптера
----------------------
Пример источника данных, который должен быть использован для каждого адаптера:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;
    use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
    use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

    // Передача данных модели
    $paginator = new PaginatorModel(
        [
            "data"  => Products::find(),
            "limit" => 10,
            "page"  => $currentPage,
        ]
    );

    // Передача данных из массива
    $paginator = new PaginatorArray(
        [
            "data"  => [
                ["id" => 1, "name" => "Artichoke"],
                ["id" => 2, "name" => "Carrots"],
                ["id" => 3, "name" => "Beet"],
                ["id" => 4, "name" => "Lettuce"],
                ["id" => 5, "name" => ""],
            ],
            "limit" => 2,
            "page"  => $currentPage,
        ]
    );

    // Передача данных QueryBuilder

    $builder = $this->modelsManager->createBuilder()
        ->columns("id, name")
        ->from("Robots")
        ->orderBy("name");

    $paginator = new PaginatorQueryBuilder(
        [
            "builder" => $builder,
            "limit"   => 20,
            "page"    => 1,
        ]
    );

Атрибуты страниц
----------------
Объект :code:`$page` содержит следующие атрибуты:

+-------------+----------------------------------------------+
| Атрибут     | Описание                                     |
+=============+==============================================+
| items       | Набор записей для вывода на текущей странице |
+-------------+----------------------------------------------+
| current     | Текущая страница                             |
+-------------+----------------------------------------------+
| before      | Номер предыдущей страницы                    |
+-------------+----------------------------------------------+
| next        | Номер следующей страницы                     |
+-------------+----------------------------------------------+
| last        | Номер последней страницы                     |
+-------------+----------------------------------------------+
| total_pages | Общее число страниц                          |
+-------------+----------------------------------------------+
| total_items | Число записей в источнике                    |
+-------------+----------------------------------------------+

Реализация собственных адаптеров
--------------------------------
Для создания адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Paginator\\AdapterInterface <../api/Phalcon_Paginator_AdapterInterface>` или расширить существующий:

.. code-block:: php

    <?php

    use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

    class MyPaginator implements PaginatorInterface
    {
        /**
         * Конструктор адаптера
         *
         * @param array $config
         */
        public function __construct($config);

        /**
         * Установка текущей страницы
         *
         * @param int $page
         */
        public function setCurrentPage($page);

        /**
         * Возвращает срез данных для вывода
         *
         * @return stdClass
         */
        public function getPaginate();
    }
