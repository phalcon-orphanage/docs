Paginação
=========

The process of pagination takes place when we need to present big groups of arbitrary data gradually. :code:`Phalcon\Paginator` oferece uma maneira rápida e conveniente de dividir esses conjuntos de dados em páginas navegáveis.

Adaptadores de Dados
--------------------
Este componente faz uso de adaptadores para encapsular diferentes fontes de dados:

+--------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Adapter                                                                                          | Description                                                                                                                                                                                                               |
+==================================================================================================+===========================================================================================================================================================================================================================+
| :doc:`Phalcon\\Paginator\\Adapter\\NativeArray <../api/Phalcon_Paginator_Adapter_NativeArray>`   | Use a PHP array as source data                                                                                                                                                                                            |
+--------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Paginator\\Adapter\\Model <../api/Phalcon_Paginator_Adapter_Model>`               | Use a :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>` object as source data. Since PDO doesn't support scrollable cursors this adapter shouldn't be used to paginate a large number of records |
+--------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Paginator\\Adapter\\QueryBuilder <../api/Phalcon_Paginator_Adapter_QueryBuilder>` | Use a :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <../api/Phalcon_Mvc_Model_Query_Builder>` object as source data                                                                                                           |
+--------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Exemplos
--------
No exemplo abaixo, o paginador usará o resultado de uma consulta de um modelo como seus dados de origem e limitará os dados exibidos a 10 registros por página:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;

    // Current page to show
    // In a controller/component this can be:
    // $this->request->getQuery("page", "int"); // GET
    // $this->request->getPost("page", "int"); // POST
    $currentPage = (int) $_GET["page"];

    // The data set to paginate
    $robots = Robots::find();

    // Create a Model paginator, show 10 rows by page starting from $currentPage
    $paginator = new PaginatorModel(
        [
            "data"  => $robots,
            "limit" => 10,
            "page"  => $currentPage,
        ]
    );

    // Get the paginated results
    $page = $paginator->getPaginate();

A variável :code:`$currentPage` controla a página a ser exibida. :code:`$paginator->getPaginate()` retorna um objeto :code:`$page`
que contém os dados paginados. Ele pode ser usado para gerar a paginação:

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

O objeto :code:`$page` também contém dados de navegação:

.. code-block:: html+php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Last</a>

    <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>

Uso de Adaptadores
------------------
Um exemplo dos dados de origem que devem ser usados para cada adaptador:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as PaginatorModel;
    use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
    use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

    // Passing a resultset as data
    $paginator = new PaginatorModel(
        [
            "data"  => Products::find(),
            "limit" => 10,
            "page"  => $currentPage,
        ]
    );

    // Passing an array as data
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

    // Passing a QueryBuilder as data

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

Atributos de Página
-------------------
O objeto :code:`$page` possui os seguintes atributos

+-------------+--------------------------------------------------------+
| Atributo    | Descrição                                              |
+=============+========================================================+
| items       | O conjunto de registros a ser exibido na página atual  |
+-------------+--------------------------------------------------------+
| current     | A página atual                                         |
+-------------+--------------------------------------------------------+
| before      | A página anterior à atual                              |
+-------------+--------------------------------------------------------+
| next        | A próxima página para a atual                          |
+-------------+--------------------------------------------------------+
| last        | A última página no conjunto de registros               |
+-------------+--------------------------------------------------------+
| total_pages | O número de páginas                                    |
+-------------+--------------------------------------------------------+
| total_items | O número de itens nos dados de origem                  |
+-------------+--------------------------------------------------------+

Implementando seus próprios adaptadores
---------------------------------------
A interface :doc:`Phalcon\\Paginator\\AdapterInterface <../api/Phalcon_Paginator_AdapterInterface>` deve ser implementada para criar seus próprios adaptadores, paginadores ou estender os existentes:

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
