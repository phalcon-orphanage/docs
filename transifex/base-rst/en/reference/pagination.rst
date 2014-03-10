%{pagination_60deaacce0f1f3cc4e94b46e35691696}%

==========
%{pagination_799fb5780c1b0529974833d16211798b}%


%{pagination_23053199ed34e8dc893947624d563fe4}%

-------------
%{pagination_0a355558f3d14bbc0f7654611acd11fa}%


+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Adapter      | Description                                                                                                                                                                   |
+==============+===============================================================================================================================================================================+
| NativeArray  | Use a PHP array as source data                                                                                                                                                |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Model        | Use a Phalcon\\Mvc\\Model\\Resultset object as source data. Since PDO doesn't support scrollable cursors this adapter shouldn't be used to paginate a large number of records |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| QueryBuilder | Use a Phalcon\\Mvc\\Model\\Query\\Builder object as source data                                                                                                               |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

%{pagination_3482ed7db8c97c78ab45723816e21818}%

--------
%{pagination_7c4638677d770640bb9b67cfd532d297}%


.. code-block:: php

    <?php

    // {%pagination_f95c5f9340bd0ebb39c000195d0f6c12%}
    // {%pagination_8df2863da0e367967d74af7b1638136c%}
    // $this->request->getQuery('page', 'int'); // {%pagination_7528035a93ee69cedb1dbddb2f0bfcc8%}
    // $this->request->getPost('page', 'int'); // {%pagination_a02439ec229d8be0e74b0c1602392310%}
    $currentPage = (int) $_GET["page"];

    // {%pagination_4ddbeca7bae6f55c7a824cfee8681109%}
    $robots = Robots::find();

    // {%pagination_baa3cc342b3b7c5519509d895fff0a0d%}
    $paginator = new \Phalcon\Paginator\Adapter\Model(
        array(
            "data" => $robots,
            "limit"=> 10,
            "page" => $currentPage
        )
    );

    // {%pagination_2b3eb2def0da7d6ee05b4fe4b867fa17%}
    $page = $paginator->getPaginate();

%{pagination_0dda7a9eb9896cd0d29e6cdc6aa5cf41}%

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

%{pagination_2307615c1ae9cb8d43842f1d27a74209}%

.. code-block:: html+php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Last</a>

    <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>

%{pagination_7adb3af83be2dd478bded6e721c5ede7}%

--------------
%{pagination_0454adfc71c34584645b430c7f2774e8}%


.. code-block:: php

    <?php

    //{%pagination_ff06a5dcaeaa18f9a45a230208187d78%}
    $paginator = new \Phalcon\Paginator\Adapter\Model(
        array(
            "data"  => Products::find(),
            "limit" => 10,
            "page"  => $currentPage
        )
    );

    //{%pagination_33b04729090d87478135ac4d33177b70%}
    $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
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

    //{%pagination_8bafd6c18ec1d78c3a1cfef140d8d3ae%}

    $builder = $this->modelsManager->createBuilder()
        ->columns('id, name')
        ->from('Robots')
        ->orderBy('name');

    $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
        "builder" => $builder,
        "limit"=> 20,
        "page" => 1
    ));


%{pagination_52875227488d1bdeb8d30f3af376835d}%

---------------
%{pagination_69242c86723cb0a67eade45edb11be0e}%


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

%{pagination_206bd6266ccc781d8844f3db2de5d557}%

------------------------------
%{pagination_dfa3370ad9d0b28d5450f90541639ca0}%


