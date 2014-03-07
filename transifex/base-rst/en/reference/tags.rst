%{tags_c3144b8ef940c1ebff02551da1193039}%
============
%{tags_26fe4984f9926a35133255f4c1ed5fb8}%

%{tags_97e74baff8001359e1323244c3c485b2}%

.. highlights::
    This guide is not intended to be a complete documentation of available helpers and their arguments. Please visit
    the :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` page in the API for a complete reference.


%{tags_a05301caf81de2b012d3bcc32aadf8d1}%
------------------------
%{tags_306666c1bdfab58d2a111c8245c7d5e9}%

%{tags_b9f573d409350f9ad0b4b4431e38898e}%

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

%{tags_3ec97a9123bae742ac913d408397293e}%

.. code-block:: php

    <?php $this->tag->setDoctype(\Phalcon\Tag::HTML401_STRICT); ?>

%{tags_745b00594b4893899ed2d060be8eea7a}%

.. code-block:: html+php

    <?= $this->tag->getDoctype() ?>
    <html>
    <!-- your HTML code -->
    </html>

%{tags_a913248b009b9ce67a2e616972b49e9e}%

.. code-block:: html

    <!DOCTYPE html PUBLIC "-//{%tags_addde1f388bfd384d461b352d0146aeb%}
            "http://{%tags_ed32e12c95a9410e0f495bc5380cda76%}
    <html>
    <!-- your HTML code -->
    </html>

%{tags_85e055ff09040f1f1797f06641d93389}%

.. code-block:: html+jinja

    {{ get_doctype() }}
    <html>
    <!-- your HTML code -->
    </html>

%{tags_ebe7861f32b5b88f1adc5867bd84d41a}%
----------------
%{tags_6fed5e5e83eff83835948f2a3633d97b}%

.. code-block:: html+php

    <!-- for the default route -->
    <?= $this->tag->linkTo("products/search", "Search") ?>

    <!-- with CSS attributes -->
    <?= $this->tag->linkTo(array('products/edit/10', 'Edit', 'class' => 'edit-btn')) ?>

    <!-- for a named route -->
    <?= $this->tag->linkTo(array(array('for' => 'show-product', 'title' => 123, 'name' => 'carrots'), 'Show')) ?>

%{tags_5fff0e2c5e8c35e7d396d640174ca309}%

%{tags_27a89fa6a2d3db6cdb4d3ed5af1e0d93}%

.. code-block:: html+jinja

    <!-- for the default route -->
    {{ link_to("products/search", "Search") }}

    <!-- for a named route -->
    {{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Show') }}

    <!-- for a named route with class -->
    {{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Show','class'=>'edit-btn') }}

%{tags_d80e3bdaef8244040a542f67fcd04075}%
--------------
%{tags_da11624fa19e8cda2e99e676ea2e41e3}%

.. code-block:: html+php

    <!-- Sending the form by method POST -->
    <?= $this->tag->form("products/search") ?>
        <label for="q">Search:</label>
        <?= $this->tag->textField("q") ?>
        <?= $this->tag->submitButton("Search") ?>
    </form>

    <!-- Specifying another method or attributes for the FORM tag -->
    <?= $this->tag->form(array("products/search", "method" => "get")); ?>
        <label for="q">Search:</label>
        <?= $this->tag->textField("q"); ?>
        <?= $this->tag->submitButton("Search"); ?>
    </form>

%{tags_d27e4aae0aae3fac6c653f7cb2b03c28}%

.. code-block:: html

    <form action="/store/products/search/" method="get">
         <label for="q">Search:</label>
         <input type="text" id="q" value="" name="q" />
         <input type="submit" value="Search" />
    </endform>

%{tags_06a36510fed4747629d50856f444a826}%

.. code-block:: html+jinja

    <!-- Specifying another method or attributes for the FORM tag -->
    {{ form("products/search", "method": "get") }}
        <label for="q">Search:</label>
        {{ text_field("q") }}
        {{ submit_button("Search") }}
    </form>

%{tags_acb82f62c8bdc466dfa1f8efbbc35409}%

%{tags_f78e5a2f28f870991d16a021368871dc}%
---------------------------------
%{tags_76edb8ec0dcb4c5d496f53dcb6f6b8b3}%

.. code-block::  html+php

    <?php echo $this->tag->textField("username") ?>

    <?php echo $this->tag->textArea(array(
        "comment",
        "This is the content of the text-area",
        "cols" => "6",
        "rows" => 20
    )) ?>

    <?php echo $this->tag->passwordField(array(
        "password",
        "size" => 30
    )) ?>

    <?php echo $this->tag->hiddenField(array(
        "parent_id",
        "value"=> "5"
    )) ?>

%{tags_85e055ff09040f1f1797f06641d93389}%

.. code-block::  html+jinja

    {{ text_field("username") }}

    {{ text_area("comment", "This is the content", "cols": "6", "rows": 20) }}

    {{ password_field("password", "size": 30) }}

    {{ hidden_field("parent_id", "value": "5") }}

%{tags_9d358ff3057e3a6fa9c7e6b31c120392}%
-------------------
%{tags_abfc004a0ef802ba25505abf41857949}%

.. code-block:: php

    <?php

    // {%tags_593e894d72a9c17f82834fb178282e10%}
    echo $this->tag->select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name")
        )
    );

    // {%tags_fc9f87deb8feffec031d70d96cf85553%}
    echo $this->tag->selectStatic(
        array(
            "status",
            array(
                "A" => "Active",
                "I" => "Inactive",
            )
        )
    );

%{tags_9c02c8367d177c1f294065a3edecfdd2}%

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

%{tags_2942cd92191a7671ed47ae8e39c6fe4c}%

.. code-block:: php

    <?php

    // {%tags_f298c863c1906cf5c321226577ad23d8%}
    echo $this->tag->select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name"),
            "useEmpty" => true
        )
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

    // {%tags_4314ad10978d6e5295430fcaddb76476%}
    echo $this->tag->select(
        array(
            'productId',
            Products::find("type = 'vegetables'"),
            'using' => array('id', "name"),
            'useEmpty' => true,
            'emptyText' => 'Please, choose one...',
            'emptyValue' => '@'
        )
    );

.. code-block:: html

    <select id="productId" name="productId">
        <option value="@">Please, choose one..</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

%{tags_0c04dce33fdd9d575e3ae484205cd477}%

.. code-block:: jinja

    {# Creating a Select Tag with an empty option with default text #}
    {{ select('productId', products, 'using': ['id', 'name'],
        'useEmpty': true, 'emptyText': 'Please, choose one...', 'emptyValue': '@') }}

%{tags_d7b369e25a0fd32a072012ae2eac6dff}%
-------------------------
%{tags_96133c6dea59a8e21c1dd8830d7d77d4}%

.. code-block:: html+php

    <?php $this->tag->textField(
        array(
            "price",
            "size"        => 20,
            "maxlength"   => 30,
            "placeholder" => "Enter a price",
        )
    ) ?>

%{tags_f1cc9e4206867580dc22af76768cc7c5}%

.. code-block:: jinja

    {{ text_field("price", "size": 20, "maxlength": 30, "placeholder": "Enter a price") }}

%{tags_2dee12a8009caf9941e26e95aa5529e9}%

.. code-block:: html

    <input type="text" name="price" id="price" size="20" maxlength="30"
        placeholder="Enter a price" />

%{tags_90680a0d6ea8d96ae9c3d278eee75491}%
---------------------
%{tags_d41d8cd98f00b204e9800998ecf8427e}%

%{tags_d1f65b9d28d406d8c7cf83f5775c49e1}%
^^^^^^^^^^^^^^^^
%{tags_ee6a94af060dc0d282ab7dc0ea202ca0}%

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            $this->tag->setDefault("color", "Blue");
        }

    }

%{tags_3a082c1e05df761cc8022226bfc86488}%

.. code-block:: php

    <?php

    echo $this->tag->selectStatic(
        array(
            "color",
            array(
                "Yellow" => "Yellow",
                "Blue"   => "Blue",
                "Red"    => "Red"
            )
        )
    );

%{tags_be7e6e74365b955a1bc65b29d77f1561}%

.. code-block:: html

    <select id="color" name="color">
        <option value="Yellow">Yellow</option>
        <option value="Blue" selected="selected">Blue</option>
        <option value="Red">Red</option>
    </select>

%{tags_6ac76522c00c412a4fbb903ea19d6032}%
^^^^^^^^^^^^^^^^
%{tags_a4c4d2b129dc240a15408fa1a7606e48}%

%{tags_30b618a7301fb8d8b32e47c2a8be084f}%
^^^^^^^^^^^^^^^^^^^^^^^^^^
%{tags_f8114bbc24aaa6312eb398a26ea2066a}%

%{tags_f8c9fc84fa74d911f322224af7074c29}%
---------------------------------------
%{tags_910b594f8c82327d21d73614dd2c72c6}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
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

%{tags_9c02c8367d177c1f294065a3edecfdd2}%

.. code-block:: html+php

    <html>
        <head>
            <title>Index of Posts - Your Website</title>
        </head>
          <body>

          </body>
    </html>

%{tags_11fa3ca18323c73cebd6841cd4dcaafe}%
----------------------
%{tags_8b872a9b81bce0e4f64179a652555204}%

%{tags_d7e6e0ce3a4102593931f158735cde7a}%
^^^^^^
%{tags_0c1c21e9be8e382368436e64c0ec5299}%

%{tags_85e055ff09040f1f1797f06641d93389}%

.. code-block:: jinja

    {# Generate <img src="/your-app/img/hello.gif"> #}
    {{ image("img/hello.gif") }}

    {# Generate <img alt="alternative text" src="/your-app/img/hello.gif"> #}
    {{ image("img/hello.gif", "alt": "alternative text") }}

%{tags_693fb39361177ed6925aa84de2b9e7d3}%
^^^^^^^^^^^
%{tags_77dc31151d7cfc1fcd3f2a3f0800949f}%

%{tags_85e055ff09040f1f1797f06641d93389}%

.. code-block:: jinja

    {# Generate <link rel="stylesheet" href="http://{%tags_9e78f902697eeb6bedcdcb0883215e92%}
    {{ stylesheet_link("http://{%tags_cf68bb2dedfa37e577f0f9f69b7b3b4d%}

    {# Generate <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css"> #}
    {{ stylesheet_link("css/styles.css") }}

%{tags_39404202e17269c2366ceb1a4c9caf3f}%
^^^^^^^^^^
%{tags_4fa17e43d71ae1d2de4c6c26d74f669d}%

%{tags_85e055ff09040f1f1797f06641d93389}%

.. code-block:: jinja

    {# Generate <script src="http://{%tags_be7ba5686121df0cebfd766b926ba664%}
    {{ javascript_include("http://{%tags_4baa9b794a54c1bc8cbab56d43e5cbb7%}

    {# Generate <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script> #}
    {{ javascript_include("javascript/jquery.min.js") }}

%{tags_70a9b234bde9b99d278cdf4eddefc89b}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{tags_98a764ec8520f16e70ae318adaa88522}%

.. code-block:: php

    <?php

    // {%tags_32b919d18cfaca89383f6000dcc9c031%}
    // {%tags_b76450a52dc43274830b299ffdf5abbc%}
    // {%tags_e338f861bd877b46f1df36aaeada2cad%}
    // {%tags_f75bfd31238d957b9712bdc1be2d77b7%}
    echo $this->tag->tagHtml("canvas", array("id" => "canvas1", "width" => "300", "class" => "cnvclass"), false, true, true);
    echo "This is my canvas";
    echo $this->tag->tagHtmlClose("canvas");

%{tags_85e055ff09040f1f1797f06641d93389}%

.. code-block:: html+jinja

    {# Generate
    <canvas id="canvas1" width="300" class="cnvclass">
    This is my canvas
    </canvas> #}
    {{ tag_html("canvas", ["id": "canvas1", width": "300", "class": "cnvclass"], false, true, true) }}
        This is my canvas
    {{ tag_html_close("canvas") }}


%{tags_5240a19e8081f79e65b6199ffe9897b9}%
-----------
%{tags_a8481a14be068e60748f0e6ead523064}%

.. code-block:: php

    <?php echo $this->tag->linkTo('pages/about', 'About') ?>

%{tags_3ca9c99957e6c6ec9f86e78e21a79362}%

.. code-block:: php

    <?php

    class MyTags extends \Phalcon\Tag
    {
        //...

        //{%tags_f966ce4e181e49ba9d6fe934973cfe5c%}
        static public function myAmazingHelper($parameters)
        {
            //...
        }

        //{%tags_6fd0cb7fb64538c542262c9f78e75e69%}
        static public function textField($parameters)
        {
            //...
        }
    }

%{tags_859b2f6f2834e80ef6e97f2a196af08b}%

.. code-block:: php

    <?php

    $di['tag'] = function() {
        return new MyTags();
    };

%{tags_0df7dba379145f570f6ddc01d9fe58f4}%
-------------------------
%{tags_c7e9e5f23cbef8182b99090172b248c9}%

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
        static public function audioField($parameters)
        {

            // {%tags_82e5133b47aff3dff8db1618e0d02fde%}
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            // {%tags_5b61a84694979fe52641a07dd1e7f588%}
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

            // {%tags_90e92b9aab56703491b18c329c1b14f6%}
            // {%tags_b86a822c4cf76cc90cfa038245f5c71f%}
            if (isset($parameters["value"])) {
                $value = $parameters["value"];
                unset($parameters["value"]);
            } else {
                $value = self::getValue($id);
            }

            // {%tags_bef75aee935f560f9eb31732710d1d5e%}
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

%{tags_2db6c35c6ecf455bd52455a38f5e72fe}%

.. code-block:: php

    <?php

    try {

        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers',
            '../app/models',
            '../app/customhelpers' // {%tags_bcdc4f4ee80e6a76b92dedcef33a115f%}
        ))->register();

        $di = new Phalcon\DI\FactoryDefault();

        // {%tags_40d58c968eee754cd56b2edcc365e93e%}
        $di->set('MyTags',  function()
        {
            return new MyTags();
        });

        $application = new \Phalcon\Mvc\Application($di);
        echo $application->handle()->getContent();

        } catch(\Phalcon\Exception $e) {
             echo "PhalconException: ", $e->getMessage();
        }

    }


%{tags_250b8998fa225422145c1c8c5c0bfc85}%

.. code-block:: php

    <body>

        <?php
        echo MyTags::audioField(array(
            'name' => 'test',
            'id' => 'audio_test',
            'src' => '/path/to/audio.mp3'
            ));
        ?>

    </body>


