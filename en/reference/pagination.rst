Data Pagination
===============
The process of pagination takes place when we need to present big groups of arbitrary data gradually. :doc:`Phalcon_Paginator <../api/Phalcon_Paginator>` offers a fast and convenient way to split these sets of data browsable pages.

Data Adapters
-------------
This component makes use of adapters to encapsulate different sources of data:

+---------+----------------------------------------------+
| Adapter | Description                                  | 
+=========+==============================================+
| Array   | Use a PHP array as source data               | 
+---------+----------------------------------------------+
| Model   | Use a Phalcon_Model_Resultset as source data | 
+---------+----------------------------------------------+

Using Paginators
----------------
The method Phalcon_Paginator::factory() allows us to create an instance of a paginator adapter. That factory method receives two parameters. The first is the name of the adapter and the second is a an associative array of options that control the behavior of the paginator. In the example below, the paginator will use as its source data the result of a query from a model, and limit the displayed data to 10 records per page: 

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
    $paginator = Phalcon_Paginator::factory(
        "Model", 
        array(
            "data" => $robots,
            "limit"=> 10,
            "page" => $numberPage
        )
    );
    
    // Get the paginated results
    $page = $paginator->getPaginate();

Variable $currentPage controls the page to be displayed. The $paginator->getPaginate() returns a $page object that contains the paginated data. It can be used for generating the pagination: 

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

The $page object also contains navigation data:

.. code-block:: html+php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before; ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next; ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last; ?>">Last</a>
    
    <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>

Page Attributes
---------------
The $page object has the following attributes:

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

