Class **Phalcon_Paginator**
===========================

Phalcon_Paginator is designed to simplify building of pagination on views   

.. code-block:: php

    <?php

    
    
     
    //Use an alias for Phalcon_Tag
     use Tag as Phalcon\Tag;
    
    //Gets the active page number
     $numberPage = (int) $_GET['page'];
    
    //Create a Model paginator
     $paginator = Phalcon\Paginator::factory('Model', array(
       'data' => $robots,
       'limit' => 10,
       'page' => $numberPage
     ));
    
    //Get the active page
     $page = $paginator->getPaginate();
    
    ?>
    
    <table>
     <tr>
       <th>Id</th>
       <th>Name</th>
       <th>Type</th>
     </tr>
      foreach($page->items as $item){ ?>
      <tr>
       <td> echo $item->id ?></td>
       <td> echo $item->name ?></td>
       <td> echo $item->type ?></td>
      </tr>
      } ?>
    </table>
    
    <table>
      <tr>
        <td><?= Tag::linkTo("robots/search", "First") ?></td>
        <td><?= Tag::linkTo("robots/search?page=".$page->before, "Previous") ?></td>
        <td><?= Tag::linkTo("robots/search?page=".$page->next, "Next") ?></td>
        <td><?= Tag::linkTo("robots/search?page=".$page->last, "Last") ?></td>
        <td> echo $page->current, "/", $page->total_pages ?></td>
      </tr>
     </table>

Methods
---------

**Object** **factory** (string $adapterName, array $options)

Factories a paginator adapter

