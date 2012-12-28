数据分页
===============
当有一大组数据需要呈现时，我们需要用到数据分页。Phalcon\\Paginator 提供了一个快捷，方便的方法对大组数据进行分割，以达到分页浏览的效果。

Data Adapters
-------------
这个组件使用不同的适配器来封装不同的数据源：

+--------------+-------------------------------------------------------+
| Adapter      | Description                                           |
+==============+=======================================================+
| NativeArray  | Use a PHP array as source data                        |
+--------------+-------------------------------------------------------+
| Model        | Use a Phalcon\\Model\\Resultset object as source data |
+--------------+-------------------------------------------------------+

Using Paginators
----------------
在下面的例子中，paginator将从model中读取数据作为其数据源，并限制每页显示10条记录：

.. code-block:: php

    <?php

    // Current page to show
    // In a controller this can be:
    // $this->request->getQuery('page', 'int'); // GET
    // $this->request->getPost('page', 'int'); // POST
    $currentPage = (int) $_GET["page"];

    // The data set to paginate
    $robots = Robots::find();

    // Create a Model paginator, show 10 rows by page starting from $currentPage
    $paginator = new Phalcon\Paginator\Adapter\Model(
        array(
            "data" => $robots,
            "limit"=> 10,
            "page" => $currentPage
        )
    );

    // Get the paginated results
    $page = $paginator->getPaginate();

变量 $currentPage 控制将显示哪一页。 $paginator->getPaginate() 返回一个包含分页数据的 $page 对象，它将用于生成分页：

.. code-block:: html+php

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Type</th>
        </tr>
        <?php foreach($page->items as $item) { ?>
        <tr>
            <td><?php echo $item->id; ?></td>
            <td><?php echo $item->name; ?></td>
            <td><?php echo $item->type; ?></td>
        </tr>
        <?php } ?>
    </table>

$page对象还包含以下数据：

.. code-block:: html+php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Last</a>

    <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>

Page 属性
---------------
$page对象包含以下一些属性：

+---------+--------------------------------------------------------+
| Adapter | Description                                            |
+=========+========================================================+
| items   | The set of records to be displayed at the current page |
+---------+--------------------------------------------------------+
| before  | The previous page to the current one                   |
+---------+--------------------------------------------------------+
| next    | The next page to the current one                       |
+---------+--------------------------------------------------------+
| last    | The last page in the set of records                    |
+---------+--------------------------------------------------------+

实现自定义的分页适配器
------------------------------
The :doc:`Phalcon\\Paginator\\AdapterInterface <../api/Phalcon_Paginator_AdapterInterface>` interface must be implemented in order to create your own paginator adapters or extend the existing ones:

.. code-block:: php

    <?php

    class MyPaginator implements Phalcon\Paginator\AdapterInterface  {

        /**
         * Adapter constructor
         *
         * @param array $config
         */
        public function __construct($config);

        /**
         * Set the current page number
         *
         * @param int $page
         */
        public function setCurrentPage($page);

        /**
         * Returns a slice of the resultset to show in the pagination
         *
         * @return stdClass
         */
        public function getPaginate();

    }