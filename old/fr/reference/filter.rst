Filtering and Sanitizing
========================

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized
access to the content of your application, mainly user data, or even the server your application is hosted on.

.. figure:: ../_static/img/sql.png
   :align: center

`Full image (from xkcd)`_

The :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension.

Types of Built-in Filters
-------------------------
The following are the built-in filters provided by this component:

+-----------+---------------------------------------------------------------------------+
| Name      | Description                                                               |
+===========+===========================================================================+
| string    | Strip tags and encode HTML entities, including single and double quotes.  |
+-----------+---------------------------------------------------------------------------+
| email     | Remove all characters except letters, digits and !#$%&*+-/=?^_`{\|}~@.[]. |
+-----------+---------------------------------------------------------------------------+
| int       | Remove all characters except digits, plus and minus sign.                 |
+-----------+---------------------------------------------------------------------------+
| float     | Remove all characters except digits, dot, plus and minus sign.            |
+-----------+---------------------------------------------------------------------------+
| alphanum  | Remove all characters except [a-zA-Z0-9]                                  |
+-----------+---------------------------------------------------------------------------+
| striptags | Applies the strip_tags_ function                                          |
+-----------+---------------------------------------------------------------------------+
| trim      | Applies the trim_ function                                                |
+-----------+---------------------------------------------------------------------------+
| lower     | Applies the strtolower_ function                                          |
+-----------+---------------------------------------------------------------------------+
| upper     | Applies the strtoupper_ function                                          |
+-----------+---------------------------------------------------------------------------+

Sanitizing data
---------------
Sanitizing is the process which removes specific characters from a value, that are not required or desired by the user or application.
By sanitizing input we ensure that application integrity will be intact.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Returns "someone@example.com"
    $filter->sanitize("some(one)@exa\mple.com", "email");

    // Returns "hello"
    $filter->sanitize("hello<<", "string");

    // Returns "100019"
    $filter->sanitize("!100a019", "int");

    // Returns "100019.01"
    $filter->sanitize("!100a019.01a", "float");


Sanitizing from Controllers
---------------------------
You can access a :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` object from your controllers when accessing GET or POST input data
(through the request object). The first parameter is the name of the variable to be obtained; the second is the filter to be applied on it.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
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

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($productId)
        {
            $productId = $this->filter->sanitize($productId, "int");
        }
    }

Filtering data
--------------
In addition to sanitizing, :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` also provides filtering by removing or modifying input data to
the format we expect.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Returns "Hello"
    $filter->sanitize("<h1>Hello</h1>", "striptags");

    // Returns "Hello"
    $filter->sanitize("  Hello   ", "trim");

Combining Filters
-----------------
You can also run multiple filters on a string at the same time by passing an array of filter identifiers as the second parameter:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Returns "Hello"
    $filter->sanitize(
        "   <h1> Hello </h1>   ",
        [
            "striptags",
            "trim",
        ]
    );

Creating your own Filters
-------------------------
You can add your own filters to :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`. The filter function could be an anonymous function:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Using an anonymous function
    $filter->add(
        "md5",
        function ($value) {
            return preg_replace("/[^0-9a-f]/", "", $value);
        }
    );

    // Sanitize with the "md5" filter
    $filtered = $filter->sanitize($possibleMd5, "md5");

Or, if you prefer, you can implement the filter in a class:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    class IPv4Filter
    {
        public function filter($value)
        {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }
    }

    $filter = new Filter();

    // Using an object
    $filter->add(
        "ipv4",
        new IPv4Filter()
    );

    // Sanitize with the "ipv4" filter
    $filteredIp = $filter->sanitize("127.0.0.1", "ipv4");

Complex Sanitizing and Filtering
--------------------------------
PHP itself provides an excellent filter extension you can use. Check out its documentation: `Data Filtering at PHP Documentation`_

Implementing your own Filter
----------------------------
The :doc:`Phalcon\\FilterInterface <../api/Phalcon_FilterInterface>` interface must be implemented to create your own filtering service
replacing the one provided by Phalcon.

.. _Full image (from xkcd): http://xkcd.com/327/
.. _Data Filtering at PHP Documentation: http://www.php.net/manual/en/book.filter.php
.. _strip_tags: http://www.php.net/manual/en/function.strip-tags.php
.. _trim: http://www.php.net/manual/en/function.trim.php
.. _strtolower: http://www.php.net/manual/en/function.strtolower.php
.. _strtoupper: http://www.php.net/manual/en/function.strtoupper.php
