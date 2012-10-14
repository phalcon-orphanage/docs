Volt: Template Engine
=====================

Volt is an ultra-fast and designer friendly templating language written in C for PHP. It provides you a set of
helpers to write views in an easy way. Volt is highly integrated with other components of Phalcon,
just as you can use it as a stand-alone component in your applications.

Volt is inspired on Twig_, originally created by Armin Ronacher. which in turn is inspired in Jinja_.
Therefore many developers will be in familiar ground using the same syntax they have been using
with Twig. Volt’s syntax and features have been enhanced with more elements and of course
with the performance that developers have been accustomed to while working with Phalcon.

Volt views are compiled to pure PHP code, so basically they save the effort of writing PHP code manually.

Activating Volt
---------------
As other template engines, you may register Volt in the view component, using a new extension or
reusing the standard .phtml:

.. code-block:: php

    <?php

    //Registering Volt as template engine
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => 'Phalcon\Mvc\View\Engine\Volt'
        ));

        return $view;
    });

Use the standard ".phtml" extension:

.. code-block:: php

    <?php

    $view->registerEngines(array(
        ".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
    ));

Basic Usage
-----------
A view consists on Volt code, PHP and HTML. A set of special delimiters are available to enter in
Volt mode. {% ... %} is used to execute statements such as for-loops or assign values and {{ ... }}.
prints the result of a expression to the template.

Below is a minimal template that illustrates a few basics:

.. code-block:: html+jinja

    {# app/views/posts/show.phtml #}
    <!DOCTYPE html>
    <html>
        <head>
            <title>{{ title }} - A example blog</title>
        </head>
        <body>

            {% if show_navigation %}
                <ul id="navigation">
                {% for item in menu %}
                    <li><a href="{{ item.href }}">{{ item.caption }}</a></li>
                {% endfor %}
                </ul>
            {% endif %}

            <h1>{{ post.title }}</h1>

            <div class="content">
                {{ post.content }}
            </div>

        </body>
    </html>

Using Phalcon\\Mvc\\View::setVar you can pass variables from the controller to the views.
In the previous example, three variables were passed to the view: title, menu and post:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function showAction()
        {

            $post = Post::findFirst();

            $this->view->setVar("title", $post->title);
            $this->view->setVar("post", $post);
            $this->view->setVar("menu", Menu::find());
            $this->view->setVar("show_navigation", true);

        }

    }

Variables
---------
Variables may have attributes, those can be accessed using the syntax: foo.bar. If you are
passing arrays, you can access using the curly braces syntax: foo['bar']

.. code-block:: jinja

    {{ post.title }}
    {{ post['title'] }}

Filters
-------
Variables can be formatted or modified using filters. The pipe operator | is used to apply filters to
variables:

.. code-block:: jinja

    {{ post.title|e }}
    {{ post.content|striptags }}
    {{ name|capitalize|trim }}

The following is the list of available built-in filters in Volt:

+----------------------+------------------------------------------------------------------------------+
| Filter               | Description                                                                  |
+======================+==============================================================================+
| e                    | Applies Phalcon\\Escaper->escapeHtml to the value                            |
+----------------------+------------------------------------------------------------------------------+
| escape               | Applies Phalcon\\Escaper->escapeHtml to the value                            |
+----------------------+------------------------------------------------------------------------------+
| trim                 | Applies the trim_ PHP function to the value. Removing extra spaces           |
+----------------------+------------------------------------------------------------------------------+
| striptags            | Applies the striptags_ PHP function to the value. Removing HTML tags         |
+----------------------+------------------------------------------------------------------------------+
| slashes              | Applies the slashes_ PHP function to the value. Escaping values              |
+----------------------+------------------------------------------------------------------------------+
| stripslashes         | Applies the stripslashes_ PHP function to the value. Removing escaped quotes |
+----------------------+------------------------------------------------------------------------------+
| capitalize           | Capitalizes a string by applying the ucwords_ PHP function to the value      |
+----------------------+------------------------------------------------------------------------------+
| lowercase            | Change the case of a string to lowercase                                     |
+----------------------+------------------------------------------------------------------------------+
| uppercase            | Change the case of a string to uppercase                                     |
+----------------------+------------------------------------------------------------------------------+

Comments
--------
Comments may also be added to a template using the {# ... #} delimiters. All text inside them is just ignored in the final output:

.. code-block:: jinja

    {# note: this is a comment
        {% set price = 100; %}
    #}

.. _Twig: https://github.com/vito/chyrp/wiki/Twig-Reference
.. _Jinja: http://jinja.pocoo.org/
.. _trim: http://php.net/manual/en/function.trim.php
.. _striptags: http://php.net/manual/en/function.striptags.php
.. _slashes: http://php.net/manual/en/function.slashes.php
.. _stripslashes: http://php.net/manual/en/function.stripslashes.php
.. _ucwords: http://php.net/manual/en/function.capitalize.php