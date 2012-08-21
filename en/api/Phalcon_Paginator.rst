Class **Phalcon_Paginator**
===========================

Phalcon_Paginator is designed to simplify building of pagination on views   

.. code-block:: php

    <?php
     
    // Use an alias for Phalcon_Tag
    use Tag as Phalcon_Tag;

    // Gets the active page number
    $numberPage = (int) $_GET['page'];

    // Create a Model paginator
    $paginator = Phalcon_Paginator::factory(
        'Model', 
        array(
            'data'  => $robots,
            'limit' => 10,
            'page'  => $numberPage,
        )
    );

    // Get the active page
    $page = $paginator->getPaginate();

    ?>

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

    <table>
    <tr>
        <td><?php echo Tag::linkTo("robots/search", "First"); ?></td>
        <td><?php echo Tag::linkTo("robots/search?page=".$page->before, "Previous"); ?></td>
        <td><?php echo Tag::linkTo("robots/search?page=".$page->next, "Next"); ?></td>
        <td><?php echo Tag::linkTo("robots/search?page=".$page->last, "Last"); ?></td>
        <td><?php echo $page->current, "/", $page->total_pages; ?></td>
    </tr>
    </table>

Methods
---------

**Object** **factory** (string $adapterName, array $options)

Factories a paginator adapter

