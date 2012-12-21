Volt模板引擎
=====================

Volt是一个超快速和设计者友好的模板语言，C语言编写的PHP。它为您提供了一套
助理写一个简单的方法的意见。伏法尔康与其他组件的高度集成，
就像你可以使用它作为一个独立的组件在你的应用程序中。

Volt是一种用C语言编写的超快速并且设计友好的PHP模板引擎，它为你提供了一套很方便的视图助手。Volt与其他的组件高度集成，就像你可以在应用程序中单独使用它一样。

.. figure:: ../_static/img/volt.jpg
   :align: center

Volt的灵感来源于 Twig_ 。最初由Armin Ronacher创建，而它则是受 Jinja_ 的启发。
因此，许多已经在使用Twig的开发人员将熟练的使用相同的语法。Volt的语法和功能更为强大，更多的元素以及更强的性能。

Volt被编译成PHP代码，因此基本上省却了手动编写PHP代码，实现了业务逻辑与视图分离：

.. code-block:: html+jinja

    {# app/views/products/show.volt #}

    {% block last_products %}

    {% for product in products %}
        * Name: {{ product.name|e }}
        {% if product.status == "Active" %}
           Price: {{ product.price + product.taxes/100 }}
        {% endif  %}
    {% endfor  %}

    {% endblock %}

激活 Volt
---------------
作为一种模板引擎，你需要把Volt注册到视图组件，并设置一个扩展名称或者使用默认的扩展名 .phtml ：

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

使用默认的 ".phtml" 作为扩展名称：

.. code-block:: php

    <?php

    $view->registerEngines(array(
        ".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
    ));

基本使用方法
-----------------------
Volt的代码是由PHP和HTML构成。Volt中有一组特殊的分隔符，{% ... %} 用来执行循环语句或条件判断等，赋值语句使用 {{ ... }}。

下面是一个小示例，用于说明一些基本的功能：

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

你可以使用 Phalcon\\Mvc\\View::setVar 把控制器中的变量传递到视图中。在前面的例子中，有三个变量传递到视图中：title, menu 和 post ：

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

变量
---------
变量可以有属性，可以通过使用语法访问他们，如：foo.bar。如果它们是数组，你可以使用 foo['bar'] 的方式访问：

.. code-block:: jinja

    {{ post.title }}
    {{ post['title'] }}

过滤器
-------
变量可以使用过滤器格式化或修改，管道操作符 "|" 用于接收过滤器过滤变量：

.. code-block:: jinja

    {{ post.title|e }}
    {{ post.content|striptags }}
    {{ name|capitalize|trim }}

以下列表是Volt内置的过滤器：

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
| length               | Counts the string length or how many items are in an array or object         |
+----------------------+------------------------------------------------------------------------------+
| nl2br                | Changes newlines \\n by line breaks (<br />). Uses the PHP function nl2br_   |
+----------------------+------------------------------------------------------------------------------+
| sort                 | Sorts an array using the PHP function asort_                                 |
+----------------------+------------------------------------------------------------------------------+
| json_encode          | Converts a value into its JSON_ representation                               |
+----------------------+------------------------------------------------------------------------------+

注释
--------
在Volt模板中可以使用 {# ... #} 分隔符添加注释，他们内部的所有文字将被忽略：

.. code-block:: jinja

    {# note: this is a comment
        {% set price = 100; %}
    #}

List of Control Structures
--------------------------
Volt提供了一组基本的但功能强大的控制结构：

For
^^^
Loop over each item in a sequence. The following example shows how to traverse a set of "robots" and print his/her name:

.. code-block:: html+jinja

    <h1>Robots</h1>
    <ul>
    {% for robot in robots %}
      <li>{{ robot.name|e }}</li>
    {% endfor %}
    </ul>

for循环嵌套:

.. code-block:: html+jinja

    <h1>Robots</h1>
    {% for robot in robots %}
      {% for part in robot.parts %}
      Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br/>
      {% endfor %}
    {% endfor %}

If
^^
As PHP, a if statement checks if an expression is evaluated as true or false:

.. code-block:: html+jinja

    <h1>Cyborg Robots</h1>
    <ul>
    {% for robot in robots %}
      {% if robot.type = "cyborg" %}
      <li>{{ robot.name|e }}</li>
      {% endif %}
    {% endfor %}
    </ul>

The else clause is also supported:

.. code-block:: html+jinja

    <h1>Robots</h1>
    <ul>
    {% for robot in robots %}
      {% if robot.type = "cyborg" %}
      <li>{{ robot.name|e }}</li>
      {% else %}
      <li>{{ robot.name|e }} (not a cyborg)</li>
      {% endif %}
    {% endfor %}
    </ul>

变量赋值
-----------
在模板文件中，可以使用 "set" 设置或改变变量的值：

.. code-block:: html+jinja

    {% set fruits = ['Apple', 'Banana', 'Orange'] %}
    {% set name = robot.name %}

Expressions
-----------
Volt对表达式提供了一组基本的支持，包括字符串以及常用的操作：

+----------------------+------------------------------------------------------------------------------+
| Filter               | Description                                                                  |
+======================+==============================================================================+
| “this is a string”   | Text between double quotes or single quotes are handled as strings           |
+----------------------+------------------------------------------------------------------------------+
| 100.25               | Numbers with a decimal part are handled as doubles/floats                    |
+----------------------+------------------------------------------------------------------------------+
| 100                  | Numbers without a decimal part are handled as integers                       |
+----------------------+------------------------------------------------------------------------------+
| false                | Constant "false" is the boolean false value                                  |
+----------------------+------------------------------------------------------------------------------+
| true                 | Constant "true" is the boolean true value                                    |
+----------------------+------------------------------------------------------------------------------+
| null                 | Constant "null" is the Null value                                            |
+----------------------+------------------------------------------------------------------------------+

Arrays
^^^^^^
无论你使用PHP 5.3 或 5.4，你都可以用 "[ ]" 括起来的形式来创建数组：

译者注：如果在PHP文件中想用这种方式创建数组，PHP最低版本应该为PHP 5.4

.. code-block:: html+jinja

    {# Simple array #}
    {{ ['Apple', 'Banana', 'Orange'] }}

    {# Other simple array #}
    {{ ['Apple', 1, 2.5, false, null] }}

    {# Multi-Dimensional array #}
    {{ [[1, 2], [3, 4], [5, 6]] }}

    {# Hash-style array #}
    {{ ['first': 1, 'second': 4/2, 'third': '3'] }}

数学计算(Math)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
你可以在模板文件中直接使用以下操作符进行计算：

+----------------------+------------------------------------------------------------------------------+
| Operator             | Description                                                                  |
+======================+==============================================================================+
| \+                   | Perform an adding operation. {{ 2+3 }} returns 5                             |
+----------------------+------------------------------------------------------------------------------+
| \-                   | Perform a substraction operation {{ 2-3 }} returns -1                        |
+----------------------+------------------------------------------------------------------------------+
| \*                   | Perform a multiplication operation {{ 2*3 }} returns 6                       |
+----------------------+------------------------------------------------------------------------------+
| \/                   | Perform a division operation {{ 10/2 }} returns 5                            |
+----------------------+------------------------------------------------------------------------------+
| \%                   | Calculate the remainder of an integer division {{ 10%3 }} returns 1          |
+----------------------+------------------------------------------------------------------------------+

比较运算符(Comparisions)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
下面是在模板中可用的比较运算符：

+----------------------+------------------------------------------------------------------------------+
| Operator             | Description                                                                  |
+======================+==============================================================================+
| ==                   | Check whether both operands are equal                                        |
+----------------------+------------------------------------------------------------------------------+
| !=                   | Check whether both operands aren't equal                                     |
+----------------------+------------------------------------------------------------------------------+
| \<\>                 | Check whether both operands aren't equal                                     |
+----------------------+------------------------------------------------------------------------------+
| \>                   | Check whether left operand is greater than right operand                     |
+----------------------+------------------------------------------------------------------------------+
| \<                   | Check whether left operand is less than right operand                        |
+----------------------+------------------------------------------------------------------------------+
| <=                   | Check whether left operand is less or equal than right operand               |
+----------------------+------------------------------------------------------------------------------+
| >=                   | Check whether left operand is greater or equal than right operand            |
+----------------------+------------------------------------------------------------------------------+
| ===                  | Check whether both operands are identical                                    |
+----------------------+------------------------------------------------------------------------------+
| !==                  | Check whether both operands aren't identical                                 |
+----------------------+------------------------------------------------------------------------------+

逻辑运算符(Logic)
^^^^^^^^^^^^^^^^^
Logic operators are useful in the "if" expression evaluation to combine multiple tests:

+----------------------+------------------------------------------------------------------------------+
| Operator             | Description                                                                  |
+======================+==============================================================================+
| or                   | Return true if the left or right operand is evaluated as true                |
+----------------------+------------------------------------------------------------------------------+
| and                  | Return true if both left and right operands are evaluated as true            |
+----------------------+------------------------------------------------------------------------------+
| not                  | Negates an expression                                                        |
+----------------------+------------------------------------------------------------------------------+
| ( expr )             | Parenthesis groups expressions                                               |
+----------------------+------------------------------------------------------------------------------+

其他操作符(Other Operators)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Additional operators seen the following operators are available:

+----------------------+----------------------------------------------------------------------------------------------+
| Operator             | Description                                                                                  |
+======================+==============================================================================================+
| \~                   | Concatenates both operands {{ "hello " \~ "world" }}                                         |
+----------------------+----------------------------------------------------------------------------------------------+
| \|                   | Applies a filter in the right operand to the left {{ "hello"\|uppercase }}                   |
+----------------------+----------------------------------------------------------------------------------------------+
| \.\.                 | Creates a range {{ 'a'..'z' }} {{ 1..10 }}                                                   |
+----------------------+----------------------------------------------------------------------------------------------+
| is                   | Same as == (equals)                                                                          |
+----------------------+----------------------------------------------------------------------------------------------+
| is not               | Same as != (not equals)                                                                      |
+----------------------+----------------------------------------------------------------------------------------------+

The following example shows how to use operators:

.. code-block:: html+jinja

    {% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

    {% for index in 0..robots|length %}
        {% if isset robots[index] %}
            {{ "Name: " ~ robots[index] }}
        {% endif %}
    {% endfor %}

Using Tag Helpers
-----------------
Volt 高度集成  :doc:`Phalcon\\Tag <tags>`,因此你可以在Volt模板中方便的使用它们：

.. code-block:: html+jinja

    {{ javascript_include("js/jquery.js") }}

    {{ form('products/save', 'method': 'post') }}

        <label>Name</label>
        {{ text_field("name", "size": 32) }}

        <label>Type</label>
        {{ select("type", productTypes, 'using': ['id', 'name']) }}

        {{ submit_button('Send') }}

    </form>

下面是生成的PHP代码：

.. code-block:: html+php

    <?php echo Phalcon\Tag::javascriptInclude("js/jquery.js") ?>

    <?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

        <label>Name</label>
        <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

        <label>Type</label>
        <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

        <?php echo Phalcon\Tag::submitButton('Send'); ?>

    </form>

要想在Volt模板中调用  Phalcon\Tag 助手，你只需要使用它们在Volt中对应的缩写版本即可：

+------------------------------------+-----------------------+
| Method                             | Volt function         |
+====================================+=======================+
| Phalcon\\Tag::linkTo               | link_to               |
+------------------------------------+-----------------------+
| Phalcon\\Tag::textField            | text_field            |
+------------------------------------+-----------------------+
| Phalcon\\Tag::passwordField        | password_field        |
+------------------------------------+-----------------------+
| Phalcon\\Tag::hiddenField          | hidden_field          |
+------------------------------------+-----------------------+
| Phalcon\\Tag::fileField            | file_field            |
+------------------------------------+-----------------------+
| Phalcon\\Tag::checkField           | check_field           |
+------------------------------------+-----------------------+
| Phalcon\\Tag::radioField           | radio_field           |
+------------------------------------+-----------------------+
| Phalcon\\Tag::submitButton         | submit_button         |
+------------------------------------+-----------------------+
| Phalcon\\Tag::selectStatic         | select_static         |
+------------------------------------+-----------------------+
| Phalcon\\Tag::select               | select                |
+------------------------------------+-----------------------+
| Phalcon\\Tag::textArea             | text_area             |
+------------------------------------+-----------------------+
| Phalcon\\Tag::form                 | form                  |
+------------------------------------+-----------------------+
| Phalcon\\Tag::endForm              | end_form              |
+------------------------------------+-----------------------+
| Phalcon\\Tag::getTitle             | get_title             |
+------------------------------------+-----------------------+
| Phalcon\\Tag::stylesheetLink       | stylesheet_link       |
+------------------------------------+-----------------------+
| Phalcon\\Tag::javascriptInclude    | javascript_include    |
+------------------------------------+-----------------------+
| Phalcon\\Tag::image                | image                 |
+------------------------------------+-----------------------+
| Phalcon\\Tag::friendlyTitle        | friendly_title        |
+------------------------------------+-----------------------+

视图集成(View Integration)
-------------------------------
Volt 模板集成了 :doc:`Phalcon\\Mvc\\View <views>`, 你的模板层次结构和默认的层次结构一样，你可以这样使用 partials ：

.. code-block:: html+jinja

    {{ content() }}

    {{ partial("partials/footer.volt") }}

模板继承(Template Inheritance)
-------------------------------------------
模板继承：你可以创建一个基础模板，其他模板继承自这个基础模板，可提高模板文件的复用性。基础模板使用 *blocks* 定义一个块，这个块可以是可以被子模板覆盖的。现在让我们假设，我们有以下的基础模板：

.. code-block:: html+jinja

    {# templates/base.volt #}
    <!DOCTYPE html>
    <html>
        <head>
            {% block head %}
                <link rel="stylesheet" href="style.css" />
            {% endblock %}
            <title>{% block title %}{% endblock %} - My Webpage</title>
        </head>
        <body>
            <div id="content">{% block content %}{% endblock %}</div>
            <div id="footer">
                {% block footer %}&copy; Copyright 2012, All rights reserved.{% endblock %}
            </div>
        </body>
    </html>

其他的模板可以继承自这个基础模板，同时替换掉基础模板中的 block:

.. code-block:: jinja

    {% extends "templates/base.volt" %}

    {% block title %}Index{% endblock %}

    {% block head %}<style type="text/css">.important { color: #336699; }</style>{% endblock %}

    {% block content %}
        <h1>Index</h1>
        <p class="important">Welcome on my awesome homepage.</p>
    {% endblock %}

并非所有的 block 都需要在子模板中进行替换(意思是，你可以替换需要的那一部分)。上面的示例最终输出结果如下：

.. code-block:: html

    <!DOCTYPE html>
    <html>
        <head>
            <style type="text/css">.important { color: #336699; }</style>
            <title>Index - My Webpage</title>
        </head>
        <body>
            <div id="content">
                <h1>Index</h1>
                <p class="important">Welcome on my awesome homepage.</p>
            </div>
            <div id="footer">
                &copy; Copyright 2012, All rights reserved.
            </div>
        </body>
    </html>

作为一个片断，"extends" 后跟的路径是一个相对于视图存放目录的相对路径(即 app/views).

.. highlights::

    默认情况下，出于对性能的考虑，Volt只检查子模板是否有修改。因为建议在开发阶段初始时使用 'compileAlways' => true。这样的话，模板始终检查父模板是否有修改。

Setting up the Volt Engine
--------------------------
Volt是可以通过配置改变默认的行为的，下面的例子说明如何做到这一点：

.. code-block:: php

    <?php

    //Register Volt as a service
    $di->set('voltService', function($view, $di) {

        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

        $volt->setOptions(array(
            "compiledPath" => "../app/compiled-templates/",
            "compiledExtension" => ".compiled"
        ));

        return $volt;
    });

    //Register Volt as template engine
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => 'voltService'
        ));

        return $view;
    });

如果你不重用 Volt，你可以不把它作为一个服务，而是在注册 view 服务的时候，用匿名函数的方式注册Volt模板引擎：

.. code-block:: php

    <?php

    //Register Volt as template engine with an anonymous function
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => function($view, $di) {
                $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

                //set some options here

                return $volt;
            }
        ));

        return $view;
    });

Volt 配置选项：

+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+
| Option            | Description                                                                                                                    | Default |
+===================+================================================================================================================================+=========+
| compiledPath      | A writable path where the compiled PHP templates will be placed                                                                | ./      |
+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+
| compiledExtension | An additional extension appended to the compiled PHP file                                                                      | .php    |
+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+
| compiledSeparator | Volt replaces the directory separators / and \\ by this separator in order to create a single file in the compiled directory   | %%      |
+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+
| stat              | Whether Phalcon must check if exists differences between the template file and its compiled path                               | true    |
+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+
| compileAlways     | Tell Volt if the templates must be compiled in each request or only when they change                                           | false   |
+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+

相关资源
------------------

* A bundle for Sublime/Textmate is available `here <https://github.com/phalcon/volt-sublime-textmate>`_
* Our website is running using Volt as template engine, check out its code on `github <https://github.com/phalcon/website>`_

.. _Twig: https://github.com/vito/chyrp/wiki/Twig-Reference
.. _Jinja: http://jinja.pocoo.org/
.. _trim: http://php.net/manual/en/function.trim.php
.. _striptags: http://php.net/manual/en/function.striptags.php
.. _slashes: http://php.net/manual/en/function.slashes.php
.. _stripslashes: http://php.net/manual/en/function.stripslashes.php
.. _ucwords: http://php.net/manual/en/function.ucwords.php
.. _nl2br: http://php.net/manual/en/function.nl2br.php
.. _asort: http://php.net/manual/en/function.asort.php
.. _JSON: http://php.net/manual/en/function.json-encode.php