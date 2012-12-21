视图助手(View Helpers)
===================================
编写和维护HTML标记是一项繁琐的任务，因为有许多命名约定及属性需要考虑。Phalcon提供了 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 来处理这种复杂性，然后 Phalcon 会把视图助手编写的代码又生成HTML标记，用于正常显示HTML。

此组件同时可用于 HTML＋ PHP 的模板文件中，也可以用于  :doc:`Volt <volt>` 模板引擎：

.. highlights::
    本指南不是一个完整的文档，只讲述了视图助手及其参数使用的其中一部分。完整的API参考，请访问：:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 。

使用别名
-------------------
你可以对类进行别名定义以获取更短的名称，在这种情况下，Tag可以代替  :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 。

.. code-block:: php

    <?php use \Phalcon\Tag as Tag; ?>

Document Type of Content
------------------------
Phalcon中，使用 Phalcon\\Tag::setDoctype() 助手可以设置HTML文档类型，文档类型的定义可能会影响其他 HTML 标签的输出。
例如，如果你设置为XHTML的文档类型，所有标签必须闭合，也就是说开始标签要有相应的结束标签。

Phalcon\\Tag 命名空间定义了以下一些文档类型常量：

+----------------------+------------------------+
| Constant             | Document type          |
+======================+========================+
| HTML32               | HTML 3.2               |
+----------------------+------------------------+
| HTML401_STRICT       | HTML 4.01 Strict       |
+----------------------+------------------------+
| HTML401_TRANSITIONAL | HTML 4.01 Transitional |
+----------------------+------------------------+
| HTML401_FRAMESET     | HTML 4.01 Frameset     |
+----------------------+------------------------+
| HTML5                | HTML 5                 |
+----------------------+------------------------+
| XHTML10_STRICT       | XHTML 1.0 Strict       |
+----------------------+------------------------+
| XHTML10_TRANSITIONAL | XHTML 1.0 Transitional |
+----------------------+------------------------+
| XHTML10_FRAMESET     | XHTML 1.0 Frameset     |
+----------------------+------------------------+
| XHTML11              | XHTML 1.1              |
+----------------------+------------------------+
| XHTML20              | XHTML 2.0              |
+----------------------+------------------------+
| XHTML5               | XHTML 5                |
+----------------------+------------------------+

设置文档类型.

.. code-block:: php

    <?php \Phalcon\Tag::setDoctype(\Phalcon\Tag::HTML401_STRICT); ?>

获取文档类型.

.. code-block:: html+php

    <?= \Phalcon\Tag::getDoctype() ?>
    <html>
    <!-- your HTML code -->
    </html>

下面是编译后的HTML代码：

.. code-block:: html

    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
            "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <!-- your HTML code -->
    </html>

Generating Links
----------------
在任何Web应用程序或网站中，连接是非常重要的，它能使我们从一个页面跳转到另一个页面。
我们可以通过以下方式创建内部连接：

.. code-block:: html+php

    <!-- for the default route -->
    <?= Tag::linkTo("products/search") ?>

    <!-- for a named route -->
    <?= Tag::linkTo(array('for' => 'show-product', 'id' => 123, 'name' => 'carrots')) ?>

其实，文档中所有的URLs都是通过组件 :doc:`Phalcon\\Mvc\\Url <url>` (or service "url" failing) 生成的。

创建表单
--------------
在Web应用程序中，从表单中获取用户输入是一个应用程序或网站的重要组成部分。下面的示例演示如何使用视图助手创建一个简单的搜索表单：

.. code-block:: html+php

    <?php use \Phalcon\Tag as Tag; ?>

    <!-- Sending the form by method POST -->
    <?= Tag::form("products/search") ?>
        <label for="q">Search:</label>
        <?= Tag::textField("q") ?>
        <?= Tag::submitButton("Search") ?>
    </form>

    <!-- Specyfing another method or attributes for the FORM tag -->
    <?= Tag::form(array("products/search", "method" => "get")); ?>
        <label for="q">Search:</label>
        <?= Tag::textField("q"); ?>
        <?= Tag::submitButton("Search"); ?>
    </form>

上面的助手代码将生成下面的HTML代码：

.. code-block:: html+php

    <form action="/store/products/search/" method="get">
         <label for="q">Search:</label>
         <input type="text" id="q" value="" name="q" />
         <input type="submit" value="Search" />
    </endform>

创建表单元素
---------------------------------
Phalcon 提供了一系列的助手用于生成表单元素，比如：文本框，按钮等。助手的第一个参数是要生成的表单的名称，当提交表单时，这个名字被当做数据传递。在控制器中，你可以使用 request对象($this->request)的 getPost()和 getQuery()方法，用这个名字得到用户提交的数据。

.. code-block::  html+php

    <?php echo Phalcon\Tag::textField(array(
        "parent_id",
        "value"=> "5"
    )) ?>

    <?php echo Phalcon\Tag::textArea(array(
        "comment",
        "This is the content of the text-area",
        "cols" => "6",
        "rows" => 20
    )) ?>

    <?php echo Phalcon\Tag::passwordField("password") ?>

    <?php echo Phalcon\Tag::hiddenField(array(
        "parent_id",
        "value"=> "5"
    )) ?>

生成选择菜单
-------------------
生成选择框是容易的，特别是相关的数据已经存储到PHP数组中时。生成选择框可以使用 Phalcon\\Tag::select() 和 Phalcon\\Tag::selectStatic(). Phalcon\\Tag::select() 是专门设计与 :doc:`Phalcon\\Mvc\\Model <models>` 一起使用，而  Phalcon\\Tag::selectStatic() 则是与PHP数组一起使用。

.. code-block:: php

    <?php

    // Using data from a resultset
    echo Phalcon\Tag::select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name")
        )
    );

    // Using data from an array
    echo Phalcon\Tag::selectStatic(
        array(
            "status",
            array(
                "A" => "Active",
                "I" => "Inactive",
            )
        )
    );

下面是生成的HTML代码:

.. code-block:: html

    <select id="productId" name="productId">
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

    <select id="status" name="status">
        <option value="A">Active</option>
        <option value="I">Inactive</option>
    </select>

有时，为了显示的需要，你想要添加一个空值的option项：

.. code-block:: php

    <?php

    // Creating a Select Tag with an empty option
    echo Phalcon\Tag::select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name")
        ),
        'useEmpty' => true
    );

.. code-block:: html

    <select id="productId" name="productId">
        <option value="">Choose..</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

.. code-block:: php

    <?php

    // Creating a Select Tag with an empty option with default text
    echo Phalcon\Tag::select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name")
        ),
        'useEmpty' => true,
        'emptyText' => 'Please, choose one...',
        'emptyValue' => '@'
    );

.. code-block:: html

    <select id="productId" name="productId">
        <option value="@">Please, choose one..</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

Assigning HTML attributes
-------------------------
所有的助手都接收一个数组，数组的第一个参数作为名称，其他的用于生成额外的HTML属性。

.. code-block:: html+php

    <?php \Phalcon\Tag::textField(
        array(
            "price",
            "size"        => 20,
            "maxlength"   => 30,
            "placeholder" => "Enter a price",
        )
    ) ?>

会产生下面的HTML代码：

.. code-block:: html

    <input type="text" name="price" id="price" size="20" maxlength="30"
        placeholder="Enter a price" />

Setting Helper Values
---------------------

From Controllers
^^^^^^^^^^^^^^^^
在视图中对表单元素设置特定值是一个良好的用户体验，你可以在控制器中通过 Phalcon\\Tag::setDefaultValue() 设置默认值。

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            Phalcon\Tag::setDefaultValue("color", "Blue");
        }

    }

在视图文件中，使用 selectStatic 助手提供一些预设值，名称为 "color"：

.. code-block:: php

    <?php

    echo \Phalcon\Tag::selectStatic(
        array(
            "color",
            array(
                "Yellow" => "Yellow",
                "Blue"   => "Blue",
                "Red"    => "Red"
            )
        )
    );

下面是生成的HTML代码，同时值为 "Blue" 的option选项被默认选中：

.. code-block:: html

    <select id="color" name="color">
        <option value="Yellow">Yellow</option>
        <option value="Blue" selected="selected">Blue</option>
        <option value="Red">Red</option>
    </select>

From the Request
^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 助手的一个重要的功能是，它能在请求时保持提交的数据。这样，你就可以轻松的显示验证信息，而不会丢失输入的数据。

Specifying values directly
^^^^^^^^^^^^^^^^^^^^^^^^^^
Every form helper supports the parameter "value". With it you can specify a value for the helper directly.
When this parameter is present, any preset value using setDefaultValue() or via request will be ignored.

Changing dynamically the Document Title
---------------------------------------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 助手还提供了可以在控制器中动态修改标题的功能。下面的例子演示了这一点：

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function initialize()
        {
            Phalcon\Tag::setTitle(" Your Website");
        }

        public function indexAction()
        {
            Phalcon\Tag::prependTitle("Index of Posts - ");
        }

    }

.. code-block:: html+php

    <html>
        <head>
            <title><?php \Phalcon\Tag::getTitle(); ?></title>
        </head>
        <body>

        </body>
    </html>

下面是生成的HTML代码：

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
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 助手还提供了生成 script,link, img 这些标签的功能。它能帮助你在你的应用程序中快速的生成静态资源文件。

Images
^^^^^^

.. code-block:: php

    <?php

    // Generate <img src="/your-app/img/hello.gif">
    echo \Phalcon\Tag::image("img/hello.gif");

    // Generate <img alt="alternative text" src="/your-app/img/hello.gif">
    echo \PhalconTag::image(
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
    echo \Phalcon\Tag::stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);

    // Generate <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css">
    echo \Phalcon\Tag::stylesheetLink("css/styles.css");

Javascript
^^^^^^^^^^

.. code-block:: php

    <?php

    // Generate <script src="http://localhost/javascript/jquery.min.js" type="text/javascript"></script>
    echo \Phalcon\Tag::javascriptInclude("http://localhost/javascript/jquery.min.js", false);

    // Generate <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script>
    echo \Phalcon\Tag::javascriptInclude("javascript/jquery.min.js");

创建自定义助手
-------------------------
你可以通过继承 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 创建你自己的自定义助手，下面是一个简单的例子：

.. code-block:: php

    <?php

    class MyTags extends \Phalcon\Tag
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
            // \Phalcon\Tag::setDefault() allows to set the widget value
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

在下一章中，我们将讨论 :doc:`Volt <volt>` ，一个更快的PHP模板引擎，在那里你可以使用由  Phalcon\Tag 提供的一种更友好的语法来使用助手工具。