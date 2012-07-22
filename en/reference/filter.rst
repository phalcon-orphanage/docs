Filtering and Sanitizing
========================
Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted. 

.. figure:: ../_static/img/sql.png
   :align: center

Full image (from xkcd)

The :doc:`Phalcon_Filter <../api/Phalcon_Filter>` component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension. 

Sanitizing data
---------------
Sanitizing is the process which removes specific characters from a value, that are not required or desired by the user or application. By sanitizing input we ensure that application integrity will be intact. 

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
You can access a :doc:`Phalcon_Filter <../api/Phalcon_Filter>` object from your controllers when accessing GET or POST input data (through the request object). The first parameter is the name of the variable to be obtained; the second is the filter to be applied on it. 

.. code-block:: php

    <?php
    
    class ProductsController extends Phalcon_Controller
    {
    
        function indexAction()
        {

        }

        function saveAction()
        {

            // Sanitizing price from input
            $price = $this->request->getPost("price", "double");

            // Sanitizing email from input
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
In addition to sanitizing, :doc:`Phalcon_Filter <../api/Phalcon_Filter>` also provides filtering by removing or modifying input data to the format we expect. 

.. code-block:: php

    <?php
    
    $filter = new Phalcon_Filter();
    
    // returns "Hello"
    $filter->filter("<h1>Hello</h1>", "striptags");
    
    // returns "Hello"
    $filter->filter("  Hello   ", "extraspaces");



Complex Sanitizing and Filtering
--------------------------------
PHP itself provides an excellent filter extension you can use. Check out its documentation: `Data Filtering at PHP Documentation`_ 

.. _Data Filtering at PHP Documentation: http://www.php.net/manual/en/book.filter.php