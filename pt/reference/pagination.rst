Paginação
==========

O processo de paginação ocorre quando precisamos apresentar grandes grupos de dados arbitrários gradualmente :code:`Phalcon\Paginator` oferece uma maneira rápida e conveniente de dividir esses conjuntos de dados em páginas navegáveis.

Adaptadores de dados
-------------
Este componente faz uso de adaptadores para encapsular diferentes fontes de dados:

+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Adapter                                                             | Descrição                                                                                                                                                                                                              |
+=====================================================================+===========================================================================================================================================================================================================================+
| :doc:`NativeArray <../api/Phalcon_Paginator_Adapter_NativeArray>`   | Use a PHP array as source data                                                                                                                                                                                            |
+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Model <../api/Phalcon_Paginator_Adapter_Model>`               | Use a :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>` object as source data. Since PDO doesn't support scrollable cursors this adapter shouldn't be used to paginate a large number of records |
+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`QueryBuilder <../api/Phalcon_Paginator_Adapter_QueryBuilder>` | Use a :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <../api/Phalcon_Mvc_Model_Query_Builder>` object as source data                                                                                                           |
+---------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Exemplos
--------
No exemplo abaixo, o paginador usará o resultado de uma consulta a partir de um modelo de como a sua fonte de dados, e limitar os dados exibidos a 10 registros por página:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;

    // Current page to show
    // Em um controlador este pode ser:
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

O :code:`$currentPage` variável controla a página a ser exibida. O :code:`$paginator->getPaginate()` retorna uma :code:`$page`
objeto que contém os dados paginados. Ele pode ser usado para gerar a paginação:

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

The :code:`$page` objeto também contém dados de navegação:

.. code-block:: html+php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Last</a>

    <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>

Adapters Usage
--------------
Um exemplo da fonte de dados que devem ser usados para cada adapter:

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
O :code:`$page` objeto tem os seguintes atributos:

+-------------+--------------------------------------------------------+
| Atibuto   | Descrição                                            |
+=============+========================================================+
| items       | O conjunto de registros a serem exibidos na página atual |
+-------------+--------------------------------------------------------+
| atual    | A página atual                                  |
+-------------+--------------------------------------------------------+
| anterior      | A página anterior à atual                 |
+-------------+--------------------------------------------------------+
| proxima        | A proxima página à atual                   |
+-------------+--------------------------------------------------------+
| ultimo      | A última página do conjunto de registros                  |
+-------------+--------------------------------------------------------+
| total_pages | O número de páginas                                  |
+-------------+--------------------------------------------------------+
| total_items | O número de itens nos dados de origem             |
+-------------+--------------------------------------------------------+

Implementar seus próprios adaptadores
------------------------------
O :doc:`Phalcon\\Paginator\\AdapterInterface <../api/Phalcon_Paginator_AdapterInterface>` interface devem ser implementados a fim de criar seus próprios adaptadores de paginação ou ampliar os já existentes:

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
