Pagination
==========

The process of pagination takes place when we need to present big groups of arbitrary data gradually. :code:`Phalcon\Paginator` offers a
fast and convenient way to split these sets of data into browsable pages.

Data Adapters
-------------
This component makes use of adapters to encapsulate different sources of data:

+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Adapter                                                             | Description                                                                                                                                                                                                               |
+=====================================================================+===========================================================================================================================================================================================================================+
| :doc:`NativeArray <../api/Phalcon_Paginator_Adapter_NativeArray>`   | Use a PHP array as source data                                                                                                                                                                                            |
+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Model <../api/Phalcon_Paginator_Adapter_Model>`               | Use a :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>` object as source data. Since PDO doesn't support scrollable cursors this adapter shouldn't be used to paginate a large number of records |
+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`QueryBuilder <../api/Phalcon_Paginator_Adapter_QueryBuilder>` | Use a :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <../api/Phalcon_Mvc_Model_Query_Builder>` object as source data                                                                                                           |
+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Examples
--------
In the example below, the paginator will use the result of a query from a model as its source data, and limit the displayed data to 10 records per page:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;

    // Current page to show
    // In a controller this can be:
    // $this->request->getQuery('page', 'int'); // GET
    // $this->request->getPost('page', 'int'); // POST
    $currentPage = (int) $_GET["page"];

    // The data set to paginate
    $robots      = Robots::find();

    // Create a Model paginator, show 10 rows by page starting from $currentPage
    $paginator   = new PaginatorModel(
        array(
            "data"  => $robots,
            "limit" => 10,
            "page"  => $currentPage
        )
    );

    // Get the paginated results
    $page = $paginator->getPaginate();

The :code:`$currentPage` variable controls the page to be displayed. The :code:`$paginator->getPaginate()` returns a :code:`$page`
object that contains the paginated data. It can be used for generating the pagination:

.. code-block:: html+php

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Type</th>
        </tr>
        <?php foreach ($page->items as $item) { ?>
        <tr>
            <td><?php echo $item->id; ?></td>
            <td><?php echo $item->name; ?></td>
            <td><?php echo $item->type; ?></td>
        </tr>
        <?php } ?>
    </table>

The :code:`$page` object also contains navigation data:

.. code-block:: html+php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Last</a>

    <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>

Adapters Usage
--------------
An example of the source data that must be used for each adapter:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;
    use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
    use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

    // Passing a resultset as data
    $paginator = new PaginatorModel(
        array(
            "data"  => Products::find(),
            "limit" => 10,
            "page"  => $currentPage
        )
    );

    // Passing an array as data
    $paginator = new PaginatorArray(
        array(
            "data"  => array(
                array('id' => 1, 'name' => 'Artichoke'),
                array('id' => 2, 'name' => 'Carrots'),
                array('id' => 3, 'name' => 'Beet'),
                array('id' => 4, 'name' => 'Lettuce'),
                array('id' => 5, 'name' => '')
            ),
            "limit" => 2,
            "page"  => $currentPage
        )
    );

    // Passing a QueryBuilder as data

    $builder = $this->modelsManager->createBuilder()
        ->columns('id, name')
        ->from('Robots')
        ->orderBy('name');

    $paginator = new PaginatorQueryBuilder(
        array(
            "builder" => $builder,
            "limit"   => 20,
            "page"    => 1
        )
    );

Page Attributes
---------------
The :code:`$page` object has the following attributes:

+-------------+--------------------------------------------------------+
| Attribute   | Description                                            |
+=============+========================================================+
| items       | The set of records to be displayed at the current page |
+-------------+--------------------------------------------------------+
| current     | The current page                                       |
+-------------+--------------------------------------------------------+
| before      | The previous page to the current one                   |
+-------------+--------------------------------------------------------+
| next        | The next page to the current one                       |
+-------------+--------------------------------------------------------+
| last        | The last page in the set of records                    |
+-------------+--------------------------------------------------------+
| total_pages | The number of pages                                    |
+-------------+--------------------------------------------------------+
| total_items | The number of items in the source data                 |
+-------------+--------------------------------------------------------+

Implementing your own adapters
------------------------------
The :doc:`Phalcon\\Paginator\\AdapterInterface <../api/Phalcon_Paginator_AdapterInterface>` interface must be implemented in order to create your own paginator adapters or extend the existing ones:

.. code-block:: php

    <?php

    use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

    class MyPaginator implements PaginatorInterface
    {
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
