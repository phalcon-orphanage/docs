Class **Phalcon\\Tag**
======================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/tag.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Tag is designed to simplify building of HTML tags.
It provides a set of helpers to generate HTML in a dynamic way.
This component is an abstract class that you can extend to add more helpers.


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
-------

public static *EscaperInterface* **getEscaper** (*array* $params)

Obtains the 'escaper' service if required



public static  **renderAttributes** (*mixed* $code, *array* $attributes)

Renders parameters keeping order in their HTML attributes



public static  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector container.



public static  **getDI** ()

Internally gets the request dispatcher



public static  **getUrlService** ()

Returns a URL service from the default DI



public static  **getEscaperService** ()

Returns an Escaper service from the default DI



public static  **setAutoescape** (*mixed* $autoescape)

Set autoescape mode in generated html



public static  **setDefault** (*string* $id, *string* $value)

Assigns default values to generated tags by helpers

.. code-block:: php

    <?php

    // Assigning "peter" to "name" component
    Phalcon\Tag::setDefault("name", "peter");

    // Later in the view
    echo Phalcon\Tag::textField("name"); // Will have the value "peter" by default




public static  **setDefaults** (*array* $values, [*mixed* $merge])

Assigns default values to generated tags by helpers

.. code-block:: php

    <?php

    // Assigning "peter" to "name" component
    Phalcon\Tag::setDefaults(
        [
            "name" => "peter",
        ]
    );

    // Later in the view
    echo Phalcon\Tag::textField("name"); // Will have the value "peter" by default




public static  **displayTo** (*string* $id, *string* $value)

Alias of Phalcon\\Tag::setDefault



public static *boolean* **hasValue** (*string* $name)

Check if a helper has a default value set using Phalcon\\Tag::setDefault or value from $_POST



public static *mixed* **getValue** (*string* $name, [*array* $params])

Every helper calls this function to check whether a component has a predefined
value using Phalcon\\Tag::setDefault or value from $_POST



public static  **resetInput** ()

Resets the request and internal values to avoid those fields will have any default value.



public static  **linkTo** (*array* | *string* $parameters, [*string* $text], [*boolean* $local])

Builds a HTML A tag using framework conventions

.. code-block:: php

    <?php

    echo Phalcon\Tag::linkTo("signup/register", "Register Here!");

    echo Phalcon\Tag::linkTo(
        [
            "signup/register",
            "Register Here!"
        ]
    );

    echo Phalcon\Tag::linkTo(
        [
            "signup/register",
            "Register Here!",
            "class" => "btn-primary",
        ]
    );

    echo Phalcon\Tag::linkTo("http://phalconphp.com/", "Phalcon", false);

    echo Phalcon\Tag::linkTo(
        [
            "http://phalconphp.com/",
            "Phalcon Home",
            false,
        ]
    );

    echo Phalcon\Tag::linkTo(
        [
            "http://phalconphp.com/",
            "Phalcon Home",
            "local" => false,
        ]
    );

    echo Phalcon\Tag::linkTo(
        [
            "action" => "http://phalconphp.com/",
            "text"   => "Phalcon Home",
            "local"  => false,
            "target" => "_new"
        ]
    );




final protected static *string* **_inputField** (*string* $type, *array* $parameters, [*boolean* $asValue])

Builds generic INPUT tags



final protected static *string* **_inputFieldChecked** (*string* $type, *array* $parameters)

Builds INPUT tags that implements the checked attribute



public static *string* **colorField** (*array* $parameters)

Builds a HTML input[type="color"] tag



public static *string* **textField** (*array* $parameters)

Builds a HTML input[type="text"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::textField(
        [
            "name",
            "size" => 30,
        ]
    );




public static *string* **numericField** (*array* $parameters)

Builds a HTML input[type="number"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::numericField(
        [
            "price",
            "min" => "1",
            "max" => "5",
        ]
    );




public static *string* **rangeField** (*array* $parameters)

Builds a HTML input[type="range"] tag



public static *string* **emailField** (*array* $parameters)

Builds a HTML input[type="email"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::emailField("email");




public static *string* **dateField** (*array* $parameters)

Builds a HTML input[type="date"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::dateField(
        [
            "born",
            "value" => "14-12-1980",
        ]
    );




public static *string* **dateTimeField** (*array* $parameters)

Builds a HTML input[type="datetime"] tag



public static *string* **dateTimeLocalField** (*array* $parameters)

Builds a HTML input[type="datetime-local"] tag



public static *string* **monthField** (*array* $parameters)

Builds a HTML input[type="month"] tag



public static *string* **timeField** (*array* $parameters)

Builds a HTML input[type="time"] tag



public static *string* **weekField** (*array* $parameters)

Builds a HTML input[type="week"] tag



public static *string* **passwordField** (*array* $parameters)

Builds a HTML input[type="password"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::passwordField(
        [
            "name",
            "size" => 30,
        ]
    );




public static *string* **hiddenField** (*array* $parameters)

Builds a HTML input[type="hidden"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::hiddenField(
        [
            "name",
            "value" => "mike",
        ]
    );




public static *string* **fileField** (*array* $parameters)

Builds a HTML input[type="file"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::fileField("file");




public static *string* **searchField** (*array* $parameters)

Builds a HTML input[type="search"] tag



public static *string* **telField** (*array* $parameters)

Builds a HTML input[type="tel"] tag



public static *string* **urlField** (*array* $parameters)

Builds a HTML input[type="url"] tag



public static *string* **checkField** (*array* $parameters)

Builds a HTML input[type="check"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::checkField(
        [
            "terms",
            "value" => "Y",
        ]
    );

Volt syntax:

.. code-block:: php

    <?php

    {{ check_field("terms") }}




public static *string* **radioField** (*array* $parameters)

Builds a HTML input[type="radio"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::radioField(
        [
            "weather",
            "value" => "hot",
        ]
    );

Volt syntax:

.. code-block:: php

    <?php

    {{ radio_field("Save") }}




public static *string* **imageInput** (*array* $parameters)

Builds a HTML input[type="image"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::imageInput(
        [
            "src" => "/img/button.png",
        ]
    );

Volt syntax:

.. code-block:: php

    <?php

    {{ image_input("src": "/img/button.png") }}




public static *string* **submitButton** (*array* $parameters)

Builds a HTML input[type="submit"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::submitButton("Save")

Volt syntax:

.. code-block:: php

    <?php

    {{ submit_button("Save") }}




public static *string* **selectStatic** (*array* $parameters, [*array* $data])

Builds a HTML SELECT tag using a PHP array for options

.. code-block:: php

    <?php

    echo Phalcon\Tag::selectStatic(
        "status",
        [
            "A" => "Active",
            "I" => "Inactive",
        ]
    );




public static *string* **select** (*array* $parameters, [*array* $data])

Builds a HTML SELECT tag using a Phalcon\\Mvc\\Model resultset as options

.. code-block:: php

    <?php

    echo Phalcon\Tag::select(
        [
            "robotId",
            Robots::find("type = "mechanical""),
            "using" => ["id", "name"],
        ]
    );

Volt syntax:

.. code-block:: php

    <?php

    {{ select("robotId", robots, "using": ["id", "name"]) }}




public static *string* **textArea** (*array* $parameters)

Builds a HTML TEXTAREA tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::textArea(
        [
            "comments",
            "cols" => 10,
            "rows" => 4,
        ]
    );

Volt syntax:

.. code-block:: php

    <?php

    {{ text_area("comments", "cols": 10, "rows": 4) }}




public static *string* **form** (*array* $parameters)

Builds a HTML FORM tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::form("posts/save");

    echo Phalcon\Tag::form(
        [
            "posts/save",
            "method" => "post",
        ]
    );

Volt syntax:

.. code-block:: php

    <?php

    {{ form("posts/save") }}
    {{ form("posts/save", "method": "post") }}




public static  **endForm** ()

Builds a HTML close FORM tag



public static  **setTitle** (*mixed* $title)

Set the title of view content

.. code-block:: php

    <?php

    Phalcon\Tag::setTitle("Welcome to my Page");




public static  **setTitleSeparator** (*mixed* $titleSeparator)

Set the title separator of view content

.. code-block:: php

    <?php

    Phalcon\Tag::setTitleSeparator("-");




public static  **appendTitle** (*mixed* $title)

Appends a text to current document title



public static  **prependTitle** (*mixed* $title)

Prepends a text to current document title



public static  **getTitle** ([*mixed* $tags])

Gets the current document title.
The title will be automatically escaped.

.. code-block:: php

    <?php

    echo Phalcon\Tag::getTitle();

.. code-block:: php

    <?php

    {{ get_title() }}




public static  **getTitleSeparator** ()

Gets the current document title separator

.. code-block:: php

    <?php

    echo Phalcon\Tag::getTitleSeparator();

.. code-block:: php

    <?php

    {{ get_title_separator() }}




public static *string* **stylesheetLink** ([*array* $parameters], [*boolean* $local])

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




public static *string* **javascriptInclude** ([*array* $parameters], [*boolean* $local])

Builds a SCRIPT[type="javascript"] tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::javascriptInclude("http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js", false);
    echo Phalcon\Tag::javascriptInclude("javascript/jquery.js");

Volt syntax:

.. code-block:: php

    <?php

    {{ javascript_include("http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js", false) }}
    {{ javascript_include("javascript/jquery.js") }}




public static *string* **image** ([*array* $parameters], [*boolean* $local])

Builds HTML IMG tags

.. code-block:: php

    <?php

    echo Phalcon\Tag::image("img/bg.png");

    echo Phalcon\Tag::image(
        [
            "img/photo.jpg",
            "alt" => "Some Photo",
        ]
    );

Volt Syntax:

.. code-block:: php

    <?php

    {{ image("img/bg.png") }}
    {{ image("img/photo.jpg", "alt": "Some Photo") }}
    {{ image("http://static.mywebsite.com/img/bg.png", false) }}




public static  **friendlyTitle** (*mixed* $text, [*mixed* $separator], [*mixed* $lowercase], [*mixed* $replace])

Converts texts into URL-friendly titles

.. code-block:: php

    <?php

    echo Phalcon\Tag::friendlyTitle("These are big important news", "-")




public static  **setDocType** (*mixed* $doctype)

Set the document type of content



public static  **getDocType** ()

Get the document type declaration of content



public static  **tagHtml** (*mixed* $tagName, [*mixed* $parameters], [*mixed* $selfClose], [*mixed* $onlyStart], [*mixed* $useEol])

Builds a HTML tag



public static  **tagHtmlClose** (*mixed* $tagName, [*mixed* $useEol])

Builds a HTML tag closing tag

.. code-block:: php

    <?php

    echo Phalcon\Tag::tagHtmlClose("script", true);




