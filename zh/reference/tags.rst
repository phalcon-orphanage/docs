视图助手 (Tags)（View Helpers (Tags)）
======================================

因为HTML标签的命名方式和很多标签属性，让书写HTML标签变成一项超级沉闷的工作。Phalcon提供 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 类来处理这些复杂而无趣的事情。

.. highlights::

    这个简单的指导不是一个完整的关于视图助手的文档，请查看 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 以获得视图助手的完整说明。

文档类型（Document Type of Content）
------------------------------------
Phalcon 提供 :code:`Phalcon\Tag::setDoctype()` 方法可以设置输出内容的文档类型。此类型设置可能被其他的tag方法影响。

+----------------------+------------------------+
| 常量                 | 对应的文档类型         |
+======================+========================+
| HTML32               | HTML 3.2               |
+----------------------+------------------------+
| HTML401_STRICT       | HTML 4.01 严格模式     |
+----------------------+------------------------+
| HTML401_TRANSITIONAL | HTML 4.01 过渡模式     |
+----------------------+------------------------+
| HTML401_FRAMESET     | HTML 4.01 Frameset     |
+----------------------+------------------------+
| HTML5                | HTML 5                 |
+----------------------+------------------------+
| XHTML10_STRICT       | XHTML 1.0 严格模式     |
+----------------------+------------------------+
| XHTML10_TRANSITIONAL | XHTML 1.0 过渡模式     |
+----------------------+------------------------+
| XHTML10_FRAMESET     | XHTML 1.0 Frameset     |
+----------------------+------------------------+
| XHTML11              | XHTML 1.1              |
+----------------------+------------------------+
| XHTML20              | XHTML 2.0              |
+----------------------+------------------------+
| XHTML5               | XHTML 5                |
+----------------------+------------------------+

设置文档类型:

.. code-block:: php

    <?php

    use Phalcon\Tag;

    $this->tag->setDoctype(Tag::HTML401_STRICT);

    ?>

获取文档类型:

.. code-block:: html+php

    <?= $this->tag->getDoctype() ?>
    <html>
    <!-- your HTML code -->
    </html>

如下的html代码将被生成:

.. code-block:: html

    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
            "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <!-- your HTML code -->
    </html>

Volt 语法:

.. code-block:: html+jinja

    {{ get_doctype() }}
    <html>
    <!-- your HTML code -->
    </html>

生成链接（Generating Links）
----------------------------
每一个普通的web应用都需要生成超链接去让我们在不同的页面之间进行导航。我们可以使用如下的方法创建指向我们站内的超链接：

.. code-block:: html+php

    <!-- for the default route -->
    <?= $this->tag->linkTo("products/search", "Search") ?>

    <!-- with CSS attributes -->
    <?= $this->tag->linkTo(["products/edit/10", "Edit", "class" => "edit-btn"]) ?>

    <!-- for a named route -->
    <?= $this->tag->linkTo([["for" => "show-product", "title" => 123, "name" => "carrots"], "Show"]) ?>

事实上，上例所有URL都是被 :doc:`Phalcon\\Mvc\\Url <url>` 生成的。

使用Volt生成超链接的例子:

.. code-block:: html+jinja

    <!-- for the default route -->
    {{ link_to("products/search", "Search") }}

    <!-- for a named route -->
    {{ link_to(["for": "show-product", "id": 123, "name": "carrots"], "Show") }}

    <!-- for a named route with a HTML class -->
    {{ link_to(["for": "show-product", "id": 123, "name": "carrots"], "Show", "class": "edit-btn") }}

创建表单（Creating Forms）
--------------------------
在Web应用中，表单是获取用户输入的重要工具，下面的例子显示了使用视图助手(tag)如何去生成一个简单的form表单。

.. code-block:: html+php

    <!-- Sending the form by method POST -->
    <?= $this->tag->form("products/search") ?>
        <label for="q">Search:</label>

        <?= $this->tag->textField("q") ?>

        <?= $this->tag->submitButton("Search") ?>
    <?= $this->tag->endForm() ?>

    <!-- Specifying another method or attributes for the FORM tag -->
    <?= $this->tag->form(["products/search", "method" => "get"]); ?>
        <label for="q">Search:</label>

        <?= $this->tag->textField("q"); ?>

        <?= $this->tag->submitButton("Search"); ?>
    <?= $this->tag->endForm() ?>

以上代码会生成如下的html:

.. code-block:: html

    <form action="/store/products/search/" method="get">
        <label for="q">Search:</label>

        <input type="text" id="q" value="" name="q" />

        <input type="submit" value="Search" />
    </form>

使用Volt生成表单:

.. code-block:: html+jinja

    <!-- Specifying another method or attributes for the FORM tag -->
    {{ form("products/search", "method": "get") }}
        <label for="q">Search:</label>

        {{ text_field("q") }}

        {{ submit_button("Search") }}
    {{ endForm() }}

Phalcon也提供了 :doc:`form builder <forms>` 类去以面向对象的风格去生成这样的表单。

使用助手生成表单控件（Helpers to Generate Form Elements）
---------------------------------------------------------
Phalcon 提供了一系列的方法去生成例如文本域(text)，按钮(button)和其他的一些form表单元素。提供给所有方法(helper)的第一个参数都是需要创建的表单元素的名称(name属性)。当提交表单的时候，这个名称将被和form表单数据一起传输。在控制器中，你可以使用request对象 (:code:`$this->request`) 的 :code:`getPost()` 和 :code:`getQuery()` 方法结合之前定义的名字(name属性)来获取到这些值。

.. code-block::  html+php

    <?php echo $this->tag->textField("username") ?>

    <?php echo $this->tag->textArea(
        [
            "comment",
            "This is the content of the text-area",
            "cols" => "6",
            "rows" => 20,
        ]
    ) ?>

    <?php echo $this->tag->passwordField(
        [
            "password",
            "size" => 30,
        ]
    ) ?>

    <?php echo $this->tag->hiddenField(
        [
            "parent_id",
            "value" => "5",
        ]
    ) ?>

Volt 的语法:

.. code-block::  html+jinja

    {{ text_field("username") }}

    {{ text_area("comment", "This is the content", "cols": "6", "rows": 20) }}

    {{ password_field("password", "size": 30) }}

    {{ hidden_field("parent_id", "value": "5") }}

使用选择框（Making Select Boxes）
---------------------------------
生成选择框(select)很简单,特别是当你已经把相关的数据存储在了PHP的关联数组中。生成select的方法是 :code:`Phalcon\Tag::select()` 和 :code:`Phalcon\Tag::selectStatic()` 。方法 :code:`Phalcon\Tag::select()` 与 :doc:`Phalcon\\Mvc\\Model <models>` 一起使用会更好。当然 :code:`Phalcon\Tag::selectStatic()` 也可以和PHP的数组一起工作。

.. code-block:: php

    <?php

    $products = Products::find("type = 'vegetables'");

    // Using data from a resultset
    echo $this->tag->select(
        [
            "productId",
            $products,
            "using" => [
                "id",
                "name",
            ]
        ]
    );

    // Using data from an array
    echo $this->tag->selectStatic(
        [
            "status",
            [
                "A" => "Active",
                "I" => "Inactive",
            ]
        ]
    );

以下HTML代码将会被生成:

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

你可以添加一个空的选项(option)到被生成的HTML页面中:

.. code-block:: php

    <?php

    $products = Products::find("type = 'vegetables'");

    // Creating a Select Tag with an empty option
    echo $this->tag->select(
        [
            "productId",
            $products,
            "using"    => [
                "id",
                "name",
            ],
            "useEmpty" => true,
        ]
    );

生成的HTML如下:

.. code-block:: html

    <select id="productId" name="productId">
        <option value="">Choose..</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

.. code-block:: php

    <?php

    $products = Products::find("type = 'vegetables'");

    // Creating a Select Tag with an empty option with default text
    echo $this->tag->select(
        [
            "productId",
            $products,
            "using"      => [
                "id",
                "name",
            ],
            "useEmpty"   => true,
            "emptyText"  => "Please, choose one...",
            "emptyValue" => "@",
        ]
    );

.. code-block:: html

    <select id="productId" name="productId">
        <option value="@">Please, choose one..</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

以Volt的语法生成以上的select选择框

.. code-block:: jinja

    {# Creating a Select Tag with an empty option with default text #}
    {{ select('productId', products, 'using': ['id', 'name'],
        'useEmpty': true, 'emptyText': 'Please, choose one...', 'emptyValue': '@') }}

设置 HTML 属性（Assigning HTML attributes）
-------------------------------------------
所有的方法的第一个参数可以是一个数组，这个数组包含了这个被生成的HTML元素额外的属性。

.. code-block:: html+php

    <?php $this->tag->textField(
        [
            "price",
            "size"        => 20,
            "maxlength"   => 30,
            "placeholder" => "Enter a price",
        ]
    ) ?>

Volt语法:

.. code-block:: jinja

    {{ text_field("price", "size": 20, "maxlength": 30, "placeholder": "Enter a price") }}

以下的HTML代码将被生成。

.. code-block:: html

    <input type="text" name="price" id="price" size="20" maxlength="30"
        placeholder="Enter a price" />

设置助手的值（Setting Helper Values）
-------------------------------------

通过控制器（From Controllers）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
使用MVC框架编程时的一个好习惯是给form元素在视图中设定一个明确的值。你可以直接使用 :code:`Phalcon\Tag::setDefault()` 在控制器中设置这个值。这个方法为所有的视图助手的方法预先设定了一个值，如果任意一个视图助手方法有一个和此预设值相匹配的名字，这个值将会被使用，除非那个视图方法明确的指定了这个值。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {
            $this->tag->setDefault("color", "Blue");
        }
    }

例如，在视图中一个选择框助手方法(select helper)匹配到了这个之前被预设的值"color"

.. code-block:: php

    <?php

    echo $this->tag->selectStatic(
        [
            "color",
            [
                "Yellow" => "Yellow",
                "Blue"   => "Blue",
                "Red"    => "Red",
            ]
        ]
    );

当这个选择框被生成的时候，"Blue"将被默认选中。

.. code-block:: html

    <select id="color" name="color">
        <option value="Yellow">Yellow</option>
        <option value="Blue" selected="selected">Blue</option>
        <option value="Red">Red</option>
    </select>

通过请求（From the Request）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 助手有一个特性，它可以在用户请求的时候保持表单的值。这个特性让你在不损失任何输入数据的情况下显示一些确认信息。

直接设置值（Specifying values directly）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
所有的表单方法都支持参数"value"。你可以直接设置一个明确的值给表单方法。当这个值被明确设定的时候，任何通过 setDefault() 或者通过 请求(request) 所设置的值将被直接忽略。

动态设置文档标题（Changing dynamically the Document Title）
-----------------------------------------------------------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 类提供了一些方法，让我们可以在控制器中动态地设置HTML文档的标题(title)。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function initialize()
        {
            $this->tag->setTitle("Your Website");
        }

        public function indexAction()
        {
            $this->tag->prependTitle("Index of Posts - ");
        }
    }

.. code-block:: html+php

    <html>
        <head>
            <?php echo $this->tag->getTitle(); ?>
        </head>

        <body>

        </body>
    </html>

以下的HTML代码将会被生成:

.. code-block:: html+php

    <html>
        <head>
            <title>Index of Posts - Your Website</title>
        </head>

        <body>

        </body>
    </html>

静态内容助手（Static Content Helpers）
--------------------------------------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 也提供一些其他的方法去生成一些其他的标签，例如脚本(script),超链接(link)或者图片(img)。它可以帮助你很快的生成一些你应用中的静态资源

图片（Images）
^^^^^^^^^^^^^^
.. code-block:: php

    <?php

    // Generate <img src="/your-app/img/hello.gif">
    echo $this->tag->image("img/hello.gif");

    // Generate <img alt="alternative text" src="/your-app/img/hello.gif">
    echo $this->tag->image(
        [
           "img/hello.gif",
           "alt" => "alternative text",
        ]
    );

Volt 语法:

.. code-block:: jinja

    {# Generate <img src="/your-app/img/hello.gif"> #}
    {{ image("img/hello.gif") }}

    {# Generate <img alt="alternative text" src="/your-app/img/hello.gif"> #}
    {{ image("img/hello.gif", "alt": "alternative text") }}

样式表（Stylesheets）
^^^^^^^^^^^^^^^^^^^^^
.. code-block:: php

    <?php

    // Generate <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rosario" type="text/css">
    echo $this->tag->stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);

    // Generate <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css">
    echo $this->tag->stylesheetLink("css/styles.css");

Volt 语法:

.. code-block:: jinja

    {# Generate <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rosario" type="text/css"> #}
    {{ stylesheet_link("http://fonts.googleapis.com/css?family=Rosario", false) }}

    {# Generate <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css"> #}
    {{ stylesheet_link("css/styles.css") }}

脚本（Javascript）
^^^^^^^^^^^^^^^^^^
.. code-block:: php

    <?php

    // Generate <script src="http://localhost/javascript/jquery.min.js" type="text/javascript"></script>
    echo $this->tag->javascriptInclude("http://localhost/javascript/jquery.min.js", false);

    // Generate <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script>
    echo $this->tag->javascriptInclude("javascript/jquery.min.js");

Volt 语法：

.. code-block:: jinja

    {# Generate <script src="http://localhost/javascript/jquery.min.js" type="text/javascript"></script> #}
    {{ javascript_include("http://localhost/javascript/jquery.min.js", false) }}

    {# Generate <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script> #}
    {{ javascript_include("javascript/jquery.min.js") }}

HTML5 对象（HTML5 elements - generic HTML helper）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Phalcon 提供了一个通用的方法去生成任何HTML的元素。在这个方法中，需要开发者将有效的HTML元素标签传给此方法。

.. code-block:: php

    <?php

    // Generate
    // <canvas id="canvas1" width="300" class="cnvclass">
    // This is my canvas
    // </canvas>
    echo $this->tag->tagHtml("canvas", ["id" => "canvas1", "width" => "300", "class" => "cnvclass"], false, true, true);
    echo "This is my canvas";
    echo $this->tag->tagHtmlClose("canvas");

Volt 语法：

.. code-block:: html+jinja

    {# Generate
    <canvas id="canvas1" width="300" class="cnvclass">
    This is my canvas
    </canvas> #}
    {{ tag_html("canvas", ["id": "canvas1", width": "300", "class": "cnvclass"], false, true, true) }}
        This is my canvas
    {{ tag_html_close("canvas") }}

标签服务（Tag Service）
-----------------------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 类可以通过 'tag' 服务来使用，这意味着你可以在服务容器被加载的任何地方访问到它。

.. code-block:: php

    <?php echo $this->tag->linkTo("pages/about", "About") ?>

在服务容器中我们可以很容易的添加一个新的组件去替换'tag'组件。

.. code-block:: php

    <?php

    use Phalcon\Tag;

    class MyTags extends Tag
    {
        // ...

        // Create a new helper
        public static function myAmazingHelper($parameters)
        {
            // ...
        }

        // Override an existing method
        public static function textField($parameters)
        {
            // ...
        }
    }

然后改变'tag'标签的定义：

.. code-block:: php

    <?php

    $di["tag"] = function () {
        return new MyTags();
    };

创建助手（Creating your own helpers）
-------------------------------------
你可以简单地创建你自己的方法。首先，在你的控制器和模型的同级目录下创建一个新的文件夹，给此文件夹起一个和它功能相关的名字。在这里，叫它"customhelpers"好了。接下来我们在此文件夹下创建一个新的文件命名为 ``MyTags.php`` 这时，我们有一个类似于 ``/app/customhelpers/MyTags.php`` 的结构，我们将扩展(extend)  :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 并且实现(implement)这个类。下面是一个自定义的助手(helper)类：

.. code-block:: php

    <?php

    use Phalcon\Tag;

    class MyTags extends Tag
    {
        /**
         * Generates a widget to show a HTML5 audio tag
         *
         * @param array
         * @return string
         */
        public static function audioField($parameters)
        {
            // Converting parameters to array if it is not
            if (!is_array($parameters)) {
                $parameters = [$parameters];
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
            $code = '<audio id="' . $id . '" value="' . $value . '" ';

            foreach ($parameters as $key => $attributeValue) {
                if (!is_integer($key)) {
                    $code.= $key . '="' . $attributeValue . '" ';
                }
            }

            $code.=" />";

            return $code;
        }
    }

在我们创建了自定义的助手(helper)类之后，我们要在我们的public目录下的"index.php"中自动加载那个包含我们自定义助手类的目录。

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault();
    use Phalcon\Exception as PhalconException;

    try {
        $loader = new Loader();

        $loader->registerDirs(
            [
                "../app/controllers",
                "../app/models",
                "../app/customhelpers", // Add the new helpers folder
            ]
        );

        $loader->register();

        $di = new FactoryDefault();

        // Assign our new tag a definition so we can call it
        $di->set(
            "MyTags",
            function () {
                return new MyTags();
            }
        );

        $application = new Application($di);

        $response = $application->handle();

        $response->send();
    } catch (PhalconException $e) {
        echo "PhalconException: ", $e->getMessage();
    }

现在，你就可以在你的视图中使用你的新助手类了。

.. code-block:: php

    <body>

        <?php

        echo MyTags::audioField(
            [
                "name" => "test",
                "id"   => "audio_test",
                "src"  => "/path/to/audio.mp3",
            ]
        );

        ?>

    </body>

在下一节中，我们将讨论关于 :doc:`Volt <volt>` 的内容，它是PHP的一个速度很快的模板引擎，在 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 中你将得到更多关于视图助手的友好的提示。
