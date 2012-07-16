

Data Pagination
===============
The process of pagination takes place when we need to present big groups of arbitrary data gradually.is a fast way to split sets of data into browsable pages.

Data Adapters
-------------
This component makes use of adapters to encapsulate the different sources of data for the paginator

Using Paginators
----------------
The method Phalcon_Paginator::factory allows us to create an instance of a paginator adapter.That method receives two parameters. The first is the name of the adapter and second is a group of options to pass to it. In the below example, the paginator will use as its source data the result of a query from a model: 

.. code-block:: php

    <?php
    
    //Number page to paginate
    $numberPage = (int) $_GET["page"];
    
    //The data set to paginate
    $robots = Robots::find();
    
    //Create a model paginator, show 10 rows by page starting from $numberPage
    $paginator = Phalcon_Paginator::factory("Model", array(
      "data" => $robots,
      "limit"=> 10,
      "page" => $numberPage
    ));
    
    //Get the pagination
    $page = $paginator->getPaginate();

Variable $numberPage controls the page to be displayed.The $paginator->getPaginate() returns a $page object that have the pagination data. It can be used for generating the pagination: 

.. code-block:: php

    <table>
      <tr>
       <th>Id</th>
       <th>Name</th>
       <th>Type</th>
     </tr>
     <?php foreach($page->items as $item){ ?>
      <tr>
       <td><?php echo $item->id ?></td>
       <td><?php echo $item->name ?></td>
       <td><?php echo $item->type ?></td>
      </tr>
     <?php } ?>
    </table>

Also, the page $object contain the navigation data:

.. code-block:: php

    <a href="/robots/search">First</a>
    <a href="/robots/search?page=<?= $page->before ?>">Previous</a>
    <a href="/robots/search?page=<?= $page->next ?>">Next</a>
    <a href="/robots/search?page=<?= $page->last ?>">Last</a>
    
    <?php echo "You are in page ", $page->current, " of ", $page->total_pages ?>



Page Attributes
---------------
The page object has the following attributes: