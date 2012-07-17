Filtering and Sanitizing
========================
Sanitizing user input is a critical part of secure software development,Neglecting to sanitize user input that may subsequently be passed to system-level functions could allow attackers to do massive internal damage to the information store and operating system, deface or delete Web files, and otherwise gain unrestricted access to the server. 

.. figure:: ../_static/img/sql.png
   :align: center

Full image (from xkcd)

The component provides a set of commonly needed data filters and sanitizes helpers. It provides object-oriented wrappers for the mature PHP filter extension. 

Sanitizing data
---------------
Sanitize is the process to remove the characters that are not required from a certain value.This lets us know that the values will not have unexpected values damaging the integrity of applications. 

.. code-block:: php

    <?php
    
    $filter = new Phalcon_Filter();
    
    // returns "someone@example.com"
    $filter->sanitize("some(one)@exa\mple.com", "email");
    
    // returns "hello"
    $filter->sanitize("hello<<", "string");
    
    // returns "100019"
    $filter->sanitize("!100a019", "int");
    
    // returns "100019.01"
    $filter->sanitize("!100a019.01a", "float");



Sanitizing from Controllers
---------------------------
You can access a Phalcon_Filter object from the controllers also when accessing POST or GET input data.First parameter is the name of the variable to be obtained; the second is the filter to be applied. 

.. code-block:: php

    <?php
    
    class ProductsController extends Phalcon_Controller
    {
    
      function indexAction()
      {
    
      }
    
      function saveAction()
      {
    
        //Sanitizing price from input
        $price = $this->request->getPost("price", "double");
    
        //Sanitizing email from input
        $email = $this->request->getPost("customerEmail", "email");
    
      }
    
    }

Filtering Action Parameters
---------------------------
The next example shows you how to sanitize the action parameters within a controller action:

.. code-block:: php

    <?php
    
    class ProductsController extends Phalcon_Controller
    {
    
      function indexAction()
      {
    
      }
    
      function showAction($productId)
      {
        $productId = $this->filter->sanitize($productId, "int");
      }
    
    }

Filtering data
--------------
Additional to sanitizing, this component provides filtering. Filtering processalso removes or modifies input data to adjust it to the format we expect. 

.. code-block:: php

    <?php
    
    $filter = new Phalcon_Filter();
    
    // returns "Hello"
    $filter->filter("<h1>Hello</h1>", "striptags");
    
    // returns "Hello"
    $filter->filter("  Hello   ", "extraspaces");



Complex Sanitizing and Filtering
--------------------------------
PHP itself provides an excellent filter extension you can use. Check out its documentation:`Data Filtering at PHP Documentation <http://www.php.net/manual/en/book.filter.php>`_ 
