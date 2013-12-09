Class **Phalcon\\Tag**
======================

Phalcon\\Tag is designed to simplify building of HTML tags. It provides a set of helpers to generate HTML in a dynamic way. This component is an abstract class that you can extend to add more helpers.


Constants
---------

*integer* **HTML32**

*integer* **HTML401_STRICT**

*integer* **HTML401_TRANSITIONAL**

*integer* **HTML401_FRAMESET**

*integer* **HTML5**

*integer* **XHTML10_STRICT**

*integer* **XHTML10_TRANSITIONAL**

*integer* **XHTML10_FRAMESET**

*integer* **XHTML11**

*integer* **XHTML20**

*integer* **XHTML5**

Methods
---------

public static  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector container.



public static :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Internally gets the dependency injector



public static :doc:`Phalcon\\Mvc\\UrlInterface <Phalcon_Mvc_UrlInterface>`  **getUrlService** ()

Return a URL service from the default DI



public static :doc:`Phalcon\\EscaperInterface <Phalcon_EscaperInterface>`  **getEscaperService** ()

Returns an Escaper service from the default DI



public static *bool*  **getAutoescape** ()

Get current autoescape mode



public static  **setAutoescape** (*boolean* $autoescape)

Set autoescape mode in generated html



public static  **setDefault** (*string* $id, *string* $value)

Assigns default values to generated tags by helpers 

.. code-block:: php

    <?php

     //Assigning "peter" to "name" component
     Phalcon\Tag::setDefault("name", "peter");
    
     //Later in the view
     echo Phalcon\Tag::textField("name"); //Will have the value "peter" by default




public static  **setDefaults** (*array* $values)

Assigns default values to generated tags by helpers 

.. code-block:: php

    <?php

     //Assigning "peter" to "name" component
     Phalcon\Tag::setDefaults(array("name" => "peter"));
    
     //Later in the view
     echo Phalcon\Tag::textField("name"); //Will have the value "peter" by default




public static  **displayTo** (*string* $id, *string* $value)

Alias of Phalcon\\Tag::setDefault



public static *boolean*  **hasValue** (*string* $name)

Check if a helper has a default value set using Phalcon\\Tag::setDefault or value from $_POST



public static *mixed*  **getValue** (*string* $name, [*array* $params])

Every helper calls this function to check whether a component has a predefined value using Phalcon\\Tag::setDefault or value from $_POST



public static  **resetInput** ()

Resets the request and internal values to avoid those fields will have any default value



public static *string*  **linkTo** (*array|string* $parameters, [*string* $text])

Builds a HTML A tag using framework conventions 

.. code-block:: php

    <?php

    echo Phalcon\Tag::linkTo('signup/register', 'Register Here!');
    echo Phalcon\Tag::linkTo(array('signup/register', 'Register Here!'));
    echo Phalcon\Tag::linkTo(array('signup/register', 'Register Here!', 'class' => 'btn-primary'));




protected static *string*  **_inputField** ()

Builds generic INPUT tags



protected static *string*  **_inputFieldChecked** ()

Builds INPUT tags that implements the checked attribute



public static *string*  **colorField** (*array* $parameters)

Builds a HTML input[type="color"] tag



public static *string*  **textField** (*array* $parameters)

Builds a HTML input[type="text"] tag 

.. code-block:: php

    <?php

    echo Phalcon\Tag::textField(array("name", "size" => 30));




public static *string*  **numericField** (*array* $parameters)

Builds a HTML input[type="number"] tag 

.. code-block:: php

    <?php

    echo Phalcon\Tag::numericField(array("price", "min" => "1", "max" => "5"));




public static *string*  **rangeField** (*array* $parameters)

Builds a HTML input[type="range"] tag



public static *string*  **emailField** (*array* $parameters)

Builds a HTML input[type="email"] tag 

.. code-block:: php

    <?php

    echo Phalcon\Tag::emailField("email");




public static *string*  **dateField** (*array* $parameters)

Builds a HTML input[type="date"] tag 

.. code-block:: php

    <?php

    echo Phalcon\Tag::dateField(array("born", "value" => "14-12-1980"))




public static *string*  **dateTimeField** (*array* $parameters)

Builds a HTML input[type="datetime"] tag



public static *string*  **dateTimeLocalField** (*array* $parameters)

Builds a HTML input[type="datetime-local"] tag



public static *string*  **monthField** (*array* $parameters)

Builds a HTML input[type="month"] tag



public static *string*  **timeField** (*array* $parameters)

Builds a HTML input[type="time"] tag



public static *string*  **weekField** (*array* $parameters)

Builds a HTML input[type="week"] tag



public static *string*  **passwordField** (*array* $parameters)

Builds a HTML input[type="password"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::passwordField(array("name", "size" => 30));




public static *string*  **hiddenField** (*array* $parameters)

Builds a HTML input[type="hidden"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::hiddenField(array("name", "value" => "mike"));




public static *string*  **searchField** (*array* $parameters)

Builds a HTML input[type="search"] tag



public static *string*  **telField** (*array* $parameters)

Builds a HTML input[type="tel"] tag



public static *string*  **urlField** (*array* $parameters)

Builds a HTML input[type="url"] tag



public static *string*  **fileField** (*array* $parameters)

Builds a HTML input[type="file"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::fileField("file");




public static *string*  **checkField** (*array* $parameters)

Builds a HTML input[type="check"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::checkField(array("terms", "value" => "Y"));




public static *string*  **radioField** (*array* $parameters)

Builds a HTML input[type="radio"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::radioField(array("wheather", "value" => "hot"))

Volt syntax: 

.. code-block:: php

    <?php

     {{ radio_field('Save') }}




public static *string*  **imageInput** (*array* $parameters)

Builds a HTML input[type="image"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::imageInput(array("src" => "/img/button.png"));

Volt syntax: 

.. code-block:: php

    <?php

     {{ image_input('src': '/img/button.png') }}




public static *string*  **submitButton** (*array* $parameters)

Builds a HTML input[type="submit"] tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::submitButton("Save")

Volt syntax: 

.. code-block:: php

    <?php

     {{ submit_button('Save') }}




public static *string*  **selectStatic** (*array* $parameters, [*array* $data])

Builds a HTML SELECT tag using a PHP array for options 

.. code-block:: php

    <?php

    echo Phalcon\Tag::selectStatic("status", array("A" => "Active", "I" => "Inactive"))




public static *string*  **select** (*array* $parameters, [*array* $data])

Builds a HTML SELECT tag using a Phalcon\\Mvc\\Model resultset as options 

.. code-block:: php

    <?php

    echo Phalcon\Tag::select(array(
    	"robotId",
    	Robots::find("type = 'mechanical'"),
    	"using" => array("id", "name")
     	));

Volt syntax: 

.. code-block:: php

    <?php

     {{ select("robotId", robots, "using": ["id", "name"]) }}




public static *string*  **textArea** (*array* $parameters)

Builds a HTML TEXTAREA tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::textArea(array("comments", "cols" => 10, "rows" => 4))

Volt syntax: 

.. code-block:: php

    <?php

     {{ text_area("comments", "cols": 10, "rows": 4) }}




public static *string*  **form** ([*array* $parameters])

Builds a HTML FORM tag 

.. code-block:: php

    <?php

     echo Phalcon\Tag::form("posts/save");
     echo Phalcon\Tag::form(array("posts/save", "method" => "post"));

Volt syntax: 

.. code-block:: php

    <?php

     {{ form("posts/save") }}
     {{ form("posts/save", "method": "post") }}




public static *string*  **endForm** ()

Builds a HTML close FORM tag



public static  **setTitle** (*string* $title)

Set the title of view content 

.. code-block:: php

    <?php

     Phalcon\Tag::setTitle('Welcome to my Page');




public static  **setTitleSeparator** (*unknown* $separator)

Set the title separator of view content 

.. code-block:: php

    <?php

     Phalcon\Tag::setTitleSeparator('-');




public static  **appendTitle** (*string* $title)

Appends a text to current document title



public static  **prependTitle** (*string* $title)

Prepends a text to current document title



public static *string*  **getTitle** ([*unknown* $tags])

Gets the current document title 

.. code-block:: php

    <?php

     	echo Phalcon\Tag::getTitle();

.. code-block:: php

    <?php

     	{{ get_title() }}




public static *string*  **getTitleSeparator** ()

Gets the current document title separator 

.. code-block:: php

    <?php

     	echo Phalcon\Tag::getTitleSeparator();

.. code-block:: php

    <?php

     	{{ get_title_separator() }}




public static *string*  **stylesheetLink** ([*array* $parameters], [*boolean* $local])

Builds a LINK[rel="stylesheet"] tag 

.. code-block:: php

    <?php

     	echo Phalcon\Tag::stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);
     	echo Phalcon\Tag::stylesheetLink("css/style.css");

Volt Syntax: 

.. code-block:: php

    <?php

     	{{ stylesheet_link("http://fonts.googleapis.com/css?family=Rosario", false) }}
     	{{ stylesheet_link("css/style.css") }}




public static *string*  **javascriptInclude** ([*array* $parameters], [*boolean* $local])

Builds a SCRIPT[type="javascript"] tag 

.. code-block:: php

    <?php

     	echo Phalcon\Tag::javascriptInclude("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false);
     	echo Phalcon\Tag::javascriptInclude("javascript/jquery.js");

Volt syntax: 

.. code-block:: php

    <?php

     {{ javascript_include("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false) }}
     {{ javascript_include("javascript/jquery.js") }}




public static *string*  **image** ([*array* $parameters], [*boolean* $local])

Builds HTML IMG tags 

.. code-block:: php

    <?php

     	echo Phalcon\Tag::image("img/bg.png");
     	echo Phalcon\Tag::image(array("img/photo.jpg", "alt" => "Some Photo"));

Volt Syntax: 

.. code-block:: php

    <?php

     	{{ image("img/bg.png") }}
     	{{ image("img/photo.jpg", "alt": "Some Photo") }}
     	{{ image("http://static.mywebsite.com/img/bg.png", false) }}




public static *text*  **friendlyTitle** (*string* $text, [*string* $separator], [*boolean* $lowercase])

Converts texts into URL-friendly titles 

.. code-block:: php

    <?php

     echo Phalcon\Tag::friendlyTitle('These are big important news', '-')




public static  **setDocType** (*string* $doctype)

Set the document type of content



public static *string*  **getDocType** ()

Get the document type declaration of content



public static *string*  **tagHtml** (*string* $tagName, [*array* $parameters], [*boolean* $selfClose], [*boolean* $onlyStart], [*boolean* $useEol])

Builds a HTML tag 

.. code-block:: php

    <?php

    echo Phalcon\Tag::tagHtml($name, $parameters, $selfClose, $onlyStart, $eol);




public static *string*  **tagHtmlClose** (*string* $tagName, [*boolean* $useEol])

Builds a HTML tag closing tag 

.. code-block:: php

    <?php

    echo Phalcon\Tag::tagHtmlClose('script', true)




