Class **Phalcon_Tag**
=====================

Phalcon_Tag is designed to simplify building of HTML tags. It provides a set of helpers to generate HTML in a dynamic way.  This component is an abstract class that you can extend to add more helpers.

Methods
---------

**setDispatcher** (Phalcon_Dispatcher $dispatcher)

Sets the request dispatcher. A valid dispatcher is required to generate absolute paths

**Phalcon_Dispatcher** **_getDispatcher** ()

Internally gets the request dispatcher

**setDefault** (string $id, string $value)

Assigns default values to generated tags by helpers  

.. code-block:: php

    <?php
    	 
    // Assigning "peter" to "name" component
    Phalcon_Tag::setDefault("name", "peter");
    
    // Later in the view
    echo Phalcon_Tag::textField("name"); //Will have the value "peter" by default
     
**displayTo** (string $id, string $value)

Alias of Phalcon_Tag::setDefault

**mixed** **getValue** (string $name)

Every helper calls this function to check whether a component has a predefined value using Phalcon_Tag::setDefault or value from $_POST

**resetInput** ()

Resets the request and internal values to avoid those fields will have any default value

**string** **linkTo** (array $parameters, unknown $text)

Builds a HTML A tag using framework conventions  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::linkTo('signup/register', 'Register Here!');

**string** **_inputField** (string $type, array $parameters)

Builds generic INPUT tags

**string** **textField** (array $parameters)

Builds a HTML input[type="text"] tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::textField(array("name", "size" => 30));

**string** **passwordField** (array $parameters)

Builds a HTML input[type="password"] tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::passwordField(array("name", "size" => 30));

**string** **hiddenField** (array $parameters)

Builds a HTML input[type="hidden"] tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::hiddenField(array("name", "value" => "mike"));

**string** **fileField** (array $parameters)

Builds a HTML input[type="file"] tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::fileField("file");

**string** **checkField** (array $parameters)

Builds a HTML input[type="check"] tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::checkField(array("name", "size" => 30));

**string** **submitButton** (unknown $parameters)

Builds a HTML input[type="submit"] tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::submitButton("Save");

**string** **selectStatic** (array $parameters, unknown $data)

Builds a HTML SELECT tag using a PHP array for options  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::selectStatic(
        "status", 
        array("A" => "Active", "I" => "Inactive")
    );

**string** **select** (unknown $parameters, unknown $data)

Builds a HTML SELECT tag using a Phalcon_Model resultset as options  

.. code-block:: php

    <?php

    echo Phalcon_Tag::selectStatic(
        array(
    	   "robotId",
    	   Robots::find("type = 'mechanical'"),
    	   "using" => array("id", "name"),
        )
    );

**string** **textArea** (array $parameters)

Builds a HTML TEXTAREA tag  

.. code-block:: php

    <?php 

    echo Phalcon_Tag::textArea(
        array(
            "comments", 
            "cols" => 10, 
            "rows" => 4,
        )
    );

**string** **form** (array $parameters)

Builds a HTML FORM tag  

.. code-block:: php

    <?php
    
    echo Phalcon_Tag::form("posts/save");
    echo Phalcon_Tag::form(array("posts/save", "method" => "post"));
     
**string** **endForm** ()

Builds a HTML close FORM tag

**setTitle** (string $title)

Set the title of view content

**appendTitle** (string $title)

Add to title of view content

**prependTitle** (string $title)

Add before the title of view content

**string** **getTitle** ()

Get the title of view content

**string** **stylesheetLink** (array $parameters, boolean $local)

Builds a LINK[rel="stylesheet"] tag  

.. code-block:: php

    <?php
    
    echo Phalcon_Tag::stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);
    echo Phalcon_Tag::stylesheetLink("css/style.css");
     
**string** **javascriptInclude** (array $parameters, boolean $local)

Builds a SCRIPT[type="javascript"] tag  

.. code-block:: php

    <?php

    echo Phalcon_Tag::javascriptInclude("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false);
    echo Phalcon_Tag::javascriptInclude("javascript/jquery.js");
     
**string** **image** (array $parameters)

Builds HTML IMG tags

