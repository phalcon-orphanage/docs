View Helpers
============
Writing and maintaining HTML markup can quickly become a tedious task because of the naming conventions and numerous attributes that have to be taken into consideration. Phalcon deals with this complexity by offering :doc:`Phalcon_Tag <../api/Phalcon_Tag>`, which in turn offers view helpers to generate HTML markup.

.. highlights::
    This guide is not intended to be a complete documentation of available helpers and their arguments. Please visit the :doc:`Phalcon_Tag <../api/Phalcon_Tag>` page in the API for a complete reference.

Using Name Aliasing
-------------------
You could use name aliasing to get short names for classes. In this case, a Tag name can be used to alias the :doc:`Phalcon_Tag <../api/Phalcon_Tag>` class.

.. code-block:: php

    <?php use Phalcon_Tag as Tag; ?>

Creating Forms
--------------
Forms in web applications play an essential part in retrieving user input. The following example shows how to implement a simple search form using view helpers:

.. code-block:: html+php

    <?php use Phalcon_Tag as Tag; ?>

    <?php Tag::form(array("products/search", "method" => "get")); ?>
        <label for="q">Search:</label>
        <?php Tag::textField("q"); ?>
        <?php Tag::submitButton("Search"); ?>
    </form>

This will generate the following HTML:

.. code-block:: html+php

    <form action="/phalconphp/products/search/" method="get">
         <label for="q">Search:</label>
         <input type="text" id="q" value="" name="q" />
         <input type="submit" value="Search" />
    </endform>

Helpers to Generate Form Elements
---------------------------------
Phalcon provides a series of helpers to generate form elements such as text fields, buttons and more. The first parameter of each helper is always the name of the element to be generated. When the form is submitted, the name will be passed along with the form data. In a controller you can get these values using the same name by using the getPost() and getQuery() methods on the request object ($this->request).

.. code-block::  html+php

    <?php echo Phalcon_Tag::textField(array("parent_id", "value"=> "5")) ?>
    <?php echo Phalcon_Tag::textArea(array("comment" "Nice article", "cols" => "6", "rows" => 20)) ?>
    <?php echo Phalcon_Tag::passwordField("password") ?>
    <?php echo Phalcon_Tag::hiddenField(array("parent_id", "value"=> "5") ?>

Making Select Boxes
-------------------
Generating select boxes (select box) is easy, especially if the related data is stored in PHP associative arrays. The helpers for select elements are Phalcon_Tag::select() and Phalcon_Tag::selectStatic(). Phalcon_Tag::selectStatic() has been was specifically designed to work with Phalcon_Model_Base, while Phalcon_Tag::selectStatic() can with PHP arrays.

.. code-block:: php

    <?php

    // Using data from a resultset
    echo Phalcon_Tag::select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name")
        )
    );

    // Using data from an array
    echo Phalcon_Tag::selectStatic(
        array(
            "status",
            array(
                "A" => "Active",
                "I" => "Inactive",
            )
        )
    );

The following HTML will generated:

.. code-block:: html

    <select id="productsd" name="productId">
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

    <select id="status" name="status">
        <option value="A">Active</option>
        <option value="I">Inactive</option>
    </select>

Assigning HTML attributes
-------------------------
All the helpers accept an array as their first parameter which can contain additional HTML attributes for the element generated.

.. code-block:: html+php

    <?php Phalcon_Tag::textField(
        array(
            "price",
            "size"        => 20,
            "maxlength"   => 30,
            "placeholder" => "Enter a price",
        )
    ) ?>

The following HTML will generated:

.. code-block:: html

    <input type="text" name="price" id="price" size="20" maxlength="30" placeholder="Enter a price" />

Setting Helper Values
---------------------

From Controllers
^^^^^^^^^^^^^^^^
It is a good programming principle for MVC frameworks to set specific values for form elements in the view. You can set those values directly from the controller using Phalcon_Tag::setDefaultValue(). This helper preloads a value for any helpers present in the view. If any helper in the view has a name that matches the preloaded value, it will use it, unless a value is directly assigned on the helper in the view.

.. code-block:: php

    <?php

    class ProductsController extends Phalcon_Controller
    {

        function indexAction()
        {
            Phalcon_Tag::setDefaultValue("color", "Blue");
        }

    }

At the view, a selectStatic helper matches the same index used to preset the value. In this case "color":

.. code-block:: php

    <?php

    echo Phalcon_Tag::selectStatic(
        array(
            "color",
            array(
                "Yellow" => "Yellow",
                "Blue"   => "Blue",
                "Red"    => "Red"
            )
        )
    );

This will generate the following select tag with the value "Blue" selected:

.. code-block:: html

    <select id="color" name="color">
        <option value="Yellow">Yellow</option>
        <option value="Blue" selected="selected">Blue</option>
        <option value="Red">Red</option>
    </select>

From the Request
^^^^^^^^^^^^^^^^
A special feature that the :doc:`Phalcon_Tag <../api/Phalcon_Tag>` helpers have is that they keep the values of form helpers between requests. This way you can easily show validation messages without losing entered data.

Specifying values directly
^^^^^^^^^^^^^^^^^^^^^^^^^^
Every form helper supports the parameter "value". With it you can specify a value for the helper directly. When this parameter is present, any preset value using setDefaultValue() or via request will be ignored.

Changing dynamically the Document Title
---------------------------------------
:doc:`Phalcon_Tag <../api/Phalcon_Tag>` offers helpers to change dynamically the document title from the controller. The following example demonstrates just that:

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function initialize()
        {
            Phalcon_Tag::setTitle(" Your Website");
        }

        function indexAction()
        {
            Phalcon_Tag::prependTitle("Index of Posts - ");
        }

    }

.. code-block:: html+php

    <html>
        <head>
            <title><?php Phalcon_Tag::getTitle() ?></title>
        </head>
        <body>

        </body>
    </html>

The following HTML will generated:

.. code-block:: html+php

    <html>
        <head>
            <title>Index of Posts - Your Website</title>
        </head>
          <body>

          </body>
    </html>

Static Content Helpers
----------------------
:doc:`Phalcon_Tag <../api/Phalcon_Tag>` also provide helpers to generate tags such as script, link or img. They aid in quick and easy generation of the static resources of your application

Images
^^^^^^

.. code-block:: php

    <?php

    // Generate <img src="/your-app/img/hello.gif">
    echo Phalcon_Tag::image("img/hello.gif");

    // Generate <img alt="alternative text" src="/your-app/img/hello.gif">
    echo Phalcon_Tag::image(
        array(
    	   "img/hello.gif",
    	   "alt" => "alternative text"
        )
    );

Stylesheets
^^^^^^^^^^^

.. code-block:: php

    <?php

    // Generate <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rosario" type="text/css">
    echo Phalcon_Tag::stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);

    // Generate <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css">
    echo Phalcon_Tag::stylesheetLink("css/styles.css");

Javascript
^^^^^^^^^^

.. code-block:: php

    <?php

    // Generate <script src="http://localhost/javascript/jquery.min.js" type="text/javascript"></script>
    echo Phalcon_Tag::javascriptInclude("http://localhost/javascript/jquery.min.js", false);

    // Generate <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script>
    echo Phalcon_Tag::javascriptInclude("javascript/jquery.min.js");

Creating your own helpers
-------------------------
You can easily create your own helpers by extending the :doc:`Phalcon_Tag <../api/Phalcon_Tag>` and implementing your own helper. Below is a simple example of a custom helper:

.. code-block:: php

    <?php

    class MyTags extends Phalcon_Tag
    {

        /**
        * Generates a widget to show a HTML5 audio tag
        *
        * @param array
        * @return string
        */
        static function audioField($parameters)
        {

            // Converting parameters to array if it is not
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            // Determining attributes "id" and "name"
            if (!isset($parameters[0])) {
                $parameters[0] = $parameters["id"];
            }

            $id = $parameters[0];
            if (!isset($parameters["name"])) {
                $parameters["name"] = $id;
            } else {
                if (!$parameters["name"]) {
                    $parameters["name"] = $id;
                }
            }

            // Determining widget value,
            // Phalcon_Tag::setDefault() allows to set the widget value
            if (isset($parameters["value"])) {
                $value = $parameters["value"];
                unset($parameters["value"]);
            } else {
                $value = self::getValue($id);
            }

            // Generate the tag code
            $code = '<audio id="'.$id.'" value="'.$value.'" ';
            foreach ($parameters as $key => $attributeValue) {
                if (!is_integer($key)) {
                    $code.= $key.'="'.$attributeValue.'" ';
                }
            }
            $code.=" />";

            return $code;
        }

    }
