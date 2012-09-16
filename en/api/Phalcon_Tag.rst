Class **Phalcon\\Tag**
======================

Phalcon\\Tag is designed to simplify building of HTML tags. It provides a set of helpers to generate HTML in a dynamic way. This component is an abstract class that you can extend to add more helpers.


Methods
---------

public static **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector container.



:doc:`Phalcon\\DI <Phalcon_DI>` public static **getDI** ()

Internally gets the request dispatcher



:doc:`Phalcon\\Mvc\\Url <Phalcon_Mvc_Url>` public static **getUrlService** ()

Return a URL service from the DI



:doc:`Phalcon\\Mvc\\Dispatcher <Phalcon_Mvc_Dispatcher>` public static **getDispatcherService** ()

Returns a Dispatcher service from the DI



public static **setDefault** (*string* $id, *string* $value)

Assigns default values to generated tags by helpers

.. code-block:: php

    <?php

    // Assigning "peter" to "name" component
    Phalcon\Tag::setDefault("name", "peter");

    // Later in the view
    echo Phalcon\Tag::textField("name"); //Will have the value "peter" by default



public static **displayTo** (*string* $id, *string* $value)

Alias of Phalcon\\Tag::setDefault



*mixed* public static **getValue** (*string* $name)

Every helper calls this function to check whether a component has a predefined value using Phalcon\\Tag::setDefault or value from $_POST



public static **resetInput** ()

Resets the request and internal values to avoid those fields will have any default value



*string* public static **linkTo** (*array* $parameters, *unknown* $text)

Builds a HTML A tag using framework conventions

.. code-block:: php

    <?php

    echo Phalcon\Tag::linkTo('signup/register', 'Register Here!');




*string* protected static **_inputField** ()

Builds generic INPUT tags



*string* public static **textField** (*array* $parameters)

Builds a HTML input[type="text"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::textField(array("name", "size" => 30));




*string* public static **passwordField** (*array* $parameters)

Builds a HTML input[type="password"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::passwordField(array("name", "size" => 30));




*string* public static **hiddenField** (*array* $parameters)

Builds a HTML input[type="hidden"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::hiddenField(array("name", "value" => "mike"));




*string* public static **fileField** (*array* $parameters)

Builds a HTML input[type="file"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::fileField("file");




*string* public static **checkField** (*array* $parameters)

Builds a HTML input[type="checkbox"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::checkField(array("name", "size" => 30));



*string* public static **radioField** (*array* $parameters)

Builds a HTML input[type="radio"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::radioField(array("name", "class" => 'label-important'));




*string* public static **submitButton** (*unknown* $parameters)

Builds a HTML input[type="submit"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::submitButton("Save");




*string* public static **selectStatic** (*array* $parameters, *unknown* $data)

Builds a HTML SELECT tag using a PHP array for options

.. code-block:: php

    <?php

    echo Phalcon\Tag::selectStatic("status", array("A" => "Active", "I" => "Inactive"));




*string* public static **select** (*unknown* $parameters, *unknown* $data)

Builds a HTML SELECT tag using a Phalcon_Model resultset as options

.. code-block:: php

    <?php

    echo Phalcon\Tag::selectStatic(
        array(
            "robotId",
            Robots::find("type = 'mechanical'"),
            "using" => array("id", "name")
        )
    );




*string* public static **textArea** (*array* $parameters)

Builds a HTML TEXTAREA tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::textArea(array("comments", "cols" => 10, "rows" => 4));




*string* public static **form** (*array* $parameters)

Builds a HTML FORM tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::form("posts/save");
     echo Phalcon\Tag::form(array("posts/save", "method" => "post"));




*string* public static **endForm** ()

Builds a HTML close FORM tag



public static **setTitle** (*string* $title)

Set the title of view content



public static **appendTitle** (*string* $title)

Add to title of view content



public static **prependTitle** (*string* $title)

Add before the title of view content



*string* public static **getTitle** ()

Get the title of view content



*string* public static **stylesheetLink** (*array* $parameters, *boolean* $local)

Builds a LINK[rel="stylesheet"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);
     echo Phalcon\Tag::stylesheetLink("css/style.css");




*string* public static **javascriptInclude** (*array* $parameters, *boolean* $local)

Builds a SCRIPT[type="javascript"] tag

.. code-block:: php

    <?php

     echo Phalcon\Tag::javascriptInclude("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false);
     echo Phalcon\Tag::javascriptInclude("javascript/jquery.js");




*string* public static **image** (*array* $parameters)

Builds HTML IMG tags



