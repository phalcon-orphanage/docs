%{volt_571e8bcd0fb45cbd5ba7b65afb1874a2}%
=====================
%{volt_602887edfcc45bcce944deb9fc2309be}%

.. figure:: ../_static/img/volt.jpg
   :align: center



%{volt_4ffa38c581ba232c17d737d5a4985f71|`Armin Ronacher`_}%

%{volt_c8e0e36307fcd2c5d61b48c9de3d7d94}%
------------
%{volt_c8992cedade57d4cdf29fc2cf9404563}%

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


%{volt_45c981f6cfc4e37497fa4e9d7a255133}%
---------------
%{volt_a127ba45d4a8a8a2e9eef9430542b4fe}%

.. code-block:: php

    <?php

    //{%volt_b07ce86350d76294ba3e305d1c6dbe6e%}
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => 'Phalcon\Mvc\View\Engine\Volt'
        ));

        return $view;
    });


%{volt_aa14eeb59161107bfd919103ba9240e1}%

.. code-block:: php

    <?php

    $view->registerEngines(array(
        ".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
    ));


%{volt_b0320f4a950d93f7f09a91c29ce5132b}%
-----------
%{volt_2f1b5c2f3534c62a3dc3282196b93263}%

%{volt_4ffce81a2b7bfd57689e79503f201ae4}%

.. code-block:: html+jinja

    {# app/views/posts/show.phtml #}
    <!DOCTYPE html>
    <html>
        <head>
            <title>{{ title }} - An example blog</title>
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


%{volt_9f7a29f9d928321ecd5a6eac0b6ba071}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function showAction()
        {

            $post = Post::findFirst();

            $this->view->title = $post->title;
            $this->view->post = $post;
            $this->view->menu = Menu::find();
            $this->view->show_navigation = true;

        }

    }


%{volt_c9019da4d8972191e60b297477584b75}%
---------
%{volt_96bbf01a97ca80f6c209236a02ad816c}%

.. code-block:: jinja

    {{ post.title }} {# for $post->title #}
    {{ post['title'] }} {# for $post['title'] #}


%{volt_c3240673b53669364a902ccbcbbb8ad4}%
-------
%{volt_ef577735d02c61904e0eb113bc49bcf2}%

.. code-block:: jinja

    {{ post.title|e }}
    {{ post.content|striptags }}
    {{ name|capitalize|trim }}


%{volt_23ce658cfe3c5c78e1766cd593ec2dbc}%

+----------------------+------------------------------------------------------------------------------+
| Filter               | Description                                                                  |
+======================+==============================================================================+
| e                    | Applies Phalcon\\Escaper->escapeHtml to the value                            |
+----------------------+------------------------------------------------------------------------------+
| escape               | Applies Phalcon\\Escaper->escapeHtml to the value                            |
+----------------------+------------------------------------------------------------------------------+
| escape_css           | Applies Phalcon\\Escaper->escapeCss to the value                             |
+----------------------+------------------------------------------------------------------------------+
| escape_js            | Applies Phalcon\\Escaper->escapeJs to the value                              |
+----------------------+------------------------------------------------------------------------------+
| escape_attr          | Applies Phalcon\\Escaper->escapeHtmlAttr to the value                        |
+----------------------+------------------------------------------------------------------------------+
| trim                 | Applies the trim_ PHP function to the value. Removing extra spaces           |
+----------------------+------------------------------------------------------------------------------+
| left_trim            | Applies the ltrim_ PHP function to the value. Removing extra spaces          |
+----------------------+------------------------------------------------------------------------------+
| right_trim           | Applies the rtrim_ PHP function to the value. Removing extra spaces          |
+----------------------+------------------------------------------------------------------------------+
| striptags            | Applies the striptags_ PHP function to the value. Removing HTML tags         |
+----------------------+------------------------------------------------------------------------------+
| slashes              | Applies the slashes_ PHP function to the value. Escaping values              |
+----------------------+------------------------------------------------------------------------------+
| stripslashes         | Applies the stripslashes_ PHP function to the value. Removing escaped quotes |
+----------------------+------------------------------------------------------------------------------+
| capitalize           | Capitalizes a string by applying the ucwords_ PHP function to the value      |
+----------------------+------------------------------------------------------------------------------+
| lower                | Change the case of a string to lowercase                                     |
+----------------------+------------------------------------------------------------------------------+
| upper                | Change the case of a string to uppercase                                     |
+----------------------+------------------------------------------------------------------------------+
| length               | Counts the string length or how many items are in an array or object         |
+----------------------+------------------------------------------------------------------------------+
| nl2br                | Changes newlines \\n by line breaks (<br />). Uses the PHP function nl2br_   |
+----------------------+------------------------------------------------------------------------------+
| sort                 | Sorts an array using the PHP function asort_                                 |
+----------------------+------------------------------------------------------------------------------+
| keys                 | Returns the array keys using array_keys_                                     |
+----------------------+------------------------------------------------------------------------------+
| join                 | Joins the array parts using a separator join_                                |
+----------------------+------------------------------------------------------------------------------+
| format               | Formats a string using sprintf_.                                             |
+----------------------+------------------------------------------------------------------------------+
| json_encode          | Converts a value into its JSON_ representation                               |
+----------------------+------------------------------------------------------------------------------+
| json_decode          | Converts a value from its JSON_ representation to a PHP representation       |
+----------------------+------------------------------------------------------------------------------+
| abs                  | Applies the abs_ PHP function to a value.                                    |
+----------------------+------------------------------------------------------------------------------+
| url_encode           | Applies the urlencode_ PHP function to the value                             |
+----------------------+------------------------------------------------------------------------------+
| default              | Sets a default value in case that the evaluated expression is empty          |
|                      | (is not set or evaluates to a falsy value)                                   |
+----------------------+------------------------------------------------------------------------------+
| convert_encoding     | Converts a string from one charset to another                                |
+----------------------+------------------------------------------------------------------------------+


%{volt_8ff6794184cb8a0dd75df124bfe57a9d}%

.. code-block:: jinja

    {# e or escape filter #}
    {{ "<h1>Hello<h1>"|e }}
    {{ "<h1>Hello<h1>"|escape }}

    {# trim filter #}
    {{ "   hello   "|trim }}

    {# striptags filter #}
    {{ "<h1>Hello<h1>"|striptags }}

    {# slashes filter #}
    {{ "'this is a string'"|slashes }}

    {# stripslashes filter #}
    {{ "\'this is a string\'"|stripslashes }}

    {# capitalize filter #}
    {{ "hello"|capitalize }}

    {# lower filter #}
    {{ "HELLO"|lower }}

    {# upper filter #}
    {{ "hello"|upper }}

    {# length filter #}
    {{ "robots"|length }}
    {{ [1, 2, 3]|length }}

    {# nl2br filter #}
    {{ "some\ntext"|nl2br }}

    {# sort filter #}
    {% set sorted=[3, 1, 2]|sort %}

    {# keys filter #}
    {% set keys=['first': 1, 'second': 2, 'third': 3]|keys %}

    {# json_encode filter #}
    {% robots|json_encode %}

    {# json_decode filter #}
    {% set decoded='{"one":1,"two":2,"three":3}'|json_decode %}

    {# url_encode filter #}
    {{ post.permanent_link|url_encode }}

    {# convert_encoding filter #}
    {{ "désolé"|convert_encoding('utf8', 'latin1') }}


%{volt_5c081d944e6f7f7f6c61bcc0a639b48b}%
--------
%{volt_673b07a8a673a0b45de959a524696e33}%

.. code-block:: jinja

    {# note: this is a comment
        {% set price = 100; %}
    #}


%{volt_9db4deeb03e5d2de7f9212d5572d19a4}%
--------------------------
%{volt_27cd8b5b276dd4e9a96ddeb9af448d47}%

%{volt_62fd3f87581663e4371e40eb51d66e76}%
^^^
%{volt_dfc11531e4c6065af6db90c0bf559a7a}%

.. code-block:: html+jinja

    <h1>Robots</h1>
    <ul>
    {% for robot in robots %}
      <li>{{ robot.name|e }}</li>
    {% endfor %}
    </ul>


%{volt_584c8e0a99a6c2347bd93aeca5a2f01e}%

.. code-block:: html+jinja

    <h1>Robots</h1>
    {% for robot in robots %}
      {% for part in robot.parts %}
      Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br/>
      {% endfor %}
    {% endfor %}


%{volt_3dad995a8e74e1a64a73ff4064626122}%

.. code-block:: html+jinja

    {% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

    {% for name, value in numbers %}
      Name: {{ name }} Value: {{ value }}
    {% endfor %}


%{volt_c979b0ff23a64c329e6020e79670ae50}%

.. code-block:: html+jinja

    {% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

    {% for value in numbers if value < 2 %}
      Name: {{ name }} Value: {{ value }}
    {% endfor %}

    {% for name, value in numbers if name != 'two' %}
      Name: {{ name }} Value: {{ value }}
    {% endfor %}


%{volt_f39e582b74ae7b0fae814cf758560d1c}%

.. code-block:: html+jinja

    <h1>Robots</h1>
    {% for robot in robots %}
        Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br/>
    {% else %}
        There are no robots to show
    {% endfor %}


%{volt_26514764d360f711f12be795a5f242c9}%

.. code-block:: html+jinja

    <h1>Robots</h1>
    {% for robot in robots %}
        Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br/>
    {% elsefor %}
        There are no robots to show
    {% endfor %}


%{volt_6e74bbba1b7f688edbce902f37ef8f5c}%
^^^^^^^^^^^^^
%{volt_cb6f33544183d282801d26f19ccb1502}%

.. code-block:: html+jinja

    {# skip the even robots #}
    {% for index, robot in robots %}
        {% if index is even %}
            {% continue %}
        {% endif %}
        ...
    {% endfor %}

.. code-block:: html+jinja

    {# exit the foreach on the first even robot #}
    {% for index, robot in robots %}
        {% if index is even %}
            {% break %}
        {% endif %}
        ...
    {% endfor %}


%{volt_959076d2b0beff36ddd17662b927b4f9}%
^^
%{volt_f3cbad907c4b8aee67692607530a21b2}%

.. code-block:: html+jinja

    <h1>Cyborg Robots</h1>
    <ul>
    {% for robot in robots %}
      {% if robot.type == "cyborg" %}
      <li>{{ robot.name|e }}</li>
      {% endif %}
    {% endfor %}
    </ul>


%{volt_ff2dc016aa61ec8ac0ae29caa27a6ed5}%

.. code-block:: html+jinja

    <h1>Robots</h1>
    <ul>
    {% for robot in robots %}
      {% if robot.type == "cyborg" %}
      <li>{{ robot.name|e }}</li>
      {% else %}
      <li>{{ robot.name|e }} (not a cyborg)</li>
      {% endif %}
    {% endfor %}
    </ul>


%{volt_ebb7aa5d020ceb3e406fd124cce8637a}%

.. code-block:: html+jinja

    {% if robot.type == "cyborg" %}
        Robot is a cyborg
    {% elseif robot.type == "virtual" %}
        Robot is virtual
    {% elseif robot.type == "mechanical" %}
        Robot is mechanical
    {% endif %}


%{volt_efa793b5e2da5b64c56a613af1dc1bc8}%
^^^^^^^^^^^^
%{volt_8d914b2dc5f95fcf2fc984a83379ce92}%

+----------------------+------------------------------------------------------------------------------+
| Variable             | Description                                                                  |
+======================+==============================================================================+
| loop.index           | The current iteration of the loop. (1 indexed)                               |
+----------------------+------------------------------------------------------------------------------+
| loop.index0          | The current iteration of the loop. (0 indexed)                               |
+----------------------+------------------------------------------------------------------------------+
| loop.revindex        | The number of iterations from the end of the loop (1 indexed)                |
+----------------------+------------------------------------------------------------------------------+
| loop.revindex0       | The number of iterations from the end of the loop (0 indexed)                |
+----------------------+------------------------------------------------------------------------------+
| loop.first           | True if in the first iteration.                                              |
+----------------------+------------------------------------------------------------------------------+
| loop.last            | True if in the last iteration.                                               |
+----------------------+------------------------------------------------------------------------------+
| loop.length          | The number of items to iterate                                               |
+----------------------+------------------------------------------------------------------------------+


.. code-block:: html+jinja

    {% for robot in robots %}
        {% if loop.first %}
            <table>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Name</th>
            </tr>
        {% endif %}
            <tr>
                <td>{{ loop.index }}</td>
                <td>{{ robot.id }}</td>
                <td>{{ robot.name }}</td>
            </tr>
        {% if loop.last %}
            </table>
        {% endif %}
    {% endfor %}


%{volt_e65acd0fd0d03ec2e02d25835e130176}%
-----------
%{volt_90654b2689e90206e2e44e780e2e7e58}%

.. code-block:: html+jinja

    {% set fruits = ['Apple', 'Banana', 'Orange'] %}
    {% set name = robot.name %}


%{volt_77922ab3b532acd27ea1577e8fa7b1b1}%

.. code-block:: html+jinja

    {% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}


%{volt_ac7eb0e28ebbd2970e0bc5decd9b856f}%

.. code-block:: html+jinja

    {% set price += 100.00 %}
    {% set age *= 5 %}


%{volt_b3bb52efc0f44e398f3704c2d355f296}%

+----------------------+------------------------------------------------------------------------------+
| Operator             | Description                                                                  |
+======================+==============================================================================+
| =                    | Standard Assignment                                                          |
+----------------------+------------------------------------------------------------------------------+
| +=                   | Addition assignment                                                          |
+----------------------+------------------------------------------------------------------------------+
| -=                   | Subtraction assignment                                                       |
+----------------------+------------------------------------------------------------------------------+
| *=                   | Multiplication assignment                                                    |
+----------------------+------------------------------------------------------------------------------+
| /=                   | Division assignment                                                          |
+----------------------+------------------------------------------------------------------------------+


%{volt_9d0fb94a51e6c917886df9148183fca6}%
-----------
%{volt_4b639c382d4725994e39c335c6d5b213}%

%{volt_ee8dd2766fcb8a457d5b26d2cd68f8a3}%

.. code-block:: html+jinja

    {{ (1 + 1) * 2 }}


%{volt_67bb9f27cd3e7e4de99a74c9b6b6a549}%

.. code-block:: html+jinja

    {% do (1 + 1) * 2 %}


%{volt_c1c360db85a10f0534261b4002a0a18b}%
^^^^^^^^
%{volt_8975fdee3cfb0570bd8678b75f6946e8}%

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


%{volt_71eee481a6c8310dcec0dc7189151d35}%
^^^^^^
%{volt_6f40ab5ad99ce887bfbdee755f00a03d}%

.. code-block:: html+jinja

    {# Simple array #}
    {{ ['Apple', 'Banana', 'Orange'] }}

    {# Other simple array #}
    {{ ['Apple', 1, 2.5, false, null] }}

    {# Multi-Dimensional array #}
    {{ [[1, 2], [3, 4], [5, 6]] }}

    {# Hash-style array #}
    {{ ['first': 1, 'second': 4/2, 'third': '3'] }}


%{volt_4ca697d91e15bb1a10700cd579067f49}%

.. code-block:: html+jinja

    {% set myArray = {'Apple', 'Banana', 'Orange'} %}
    {% set myHash = {'first': 1, 'second': 4/2, 'third': '3'} %}


%{volt_f71cfaa0f29dcbf3329bfee182f80554}%
^^^^
%{volt_4608f8c719712039f57eecfdfc0ab6ad}%

+----------------------+------------------------------------------------------------------------------+
| Operator             | Description                                                                  |
+======================+==============================================================================+
| \+                   | Perform an adding operation. {{ 2 + 3 }} returns 5                           |
+----------------------+------------------------------------------------------------------------------+
| \-                   | Perform a substraction operation {{ 2 - 3 }} returns -1                      |
+----------------------+------------------------------------------------------------------------------+
| \*                   | Perform a multiplication operation {{ 2 * 3 }} returns 6                     |
+----------------------+------------------------------------------------------------------------------+
| \/                   | Perform a division operation {{ 10 / 2 }} returns 5                          |
+----------------------+------------------------------------------------------------------------------+
| \%                   | Calculate the remainder of an integer division {{ 10 % 3 }} returns 1        |
+----------------------+------------------------------------------------------------------------------+


%{volt_8daa7d30f3cd9a3a4f4be23c9bd7ed9a}%
^^^^^^^^^^^
%{volt_c22664d2a7b40f64b246cb233d00664f}%

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


%{volt_4fe4081cffeaece4d9aecd74b4eb8914}%
^^^^^
%{volt_162d2ac97f013d264a84a07365114a80}%

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


%{volt_93435309515deb73fce1c3d1b568bc92}%
^^^^^^^^^^^^^^^
%{volt_0b2bd9c764cd885c45e7a6c0858eb036}%

+----------------------+----------------------------------------------------------------------------------------------+
| Operator             | Description                                                                                  |
+======================+==============================================================================================+
| \~                   | Concatenates both operands {{ "hello " \~ "world" }}                                         |
+----------------------+----------------------------------------------------------------------------------------------+
| \|                   | Applies a filter in the right operand to the left {{ "hello"\|uppercase }}                   |
+----------------------+----------------------------------------------------------------------------------------------+
| \.\.                 | Creates a range {{ 'a'..'z' }} {{ 1..10 }}                                                   |
+----------------------+----------------------------------------------------------------------------------------------+
| is                   | Same as == (equals), also performs tests                                                     |
+----------------------+----------------------------------------------------------------------------------------------+
| in                   | To check if an expression is contained into other expressions if "a" in "abc"                |
+----------------------+----------------------------------------------------------------------------------------------+
| is not               | Same as != (not equals)                                                                      |
+----------------------+----------------------------------------------------------------------------------------------+
| 'a' ? 'b' : 'c'      | Ternary operator. The same as the PHP ternary operator                                       |
+----------------------+----------------------------------------------------------------------------------------------+
| ++                   | Increments a value                                                                           |
+----------------------+----------------------------------------------------------------------------------------------+
| --                   | Decrements a value                                                                           |
+----------------------+----------------------------------------------------------------------------------------------+


%{volt_20749e95ee2310631ad2e86488a301b8}%

.. code-block:: html+jinja

    {% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

    {% for index in 0..robots|length %}
        {% if robots[index] is defined %}
            {{ "Name: " ~ robots[index] }}
        {% endif %}
    {% endfor %}


%{volt_6a2499b69a7e0589ed54afa226c18861}%
-----
%{volt_b0c360ed172ceffde393b0b4988e8755}%

.. code-block:: html+jinja

    {% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

    {% for position, name in robots %}
        {% if position is odd %}
            {{ value }}
        {% endif %}
    {% endfor %}


%{volt_8792d66d989effba55c2a8029f73e1ac}%

+----------------------+----------------------------------------------------------------------------------------------+
| Test                 | Description                                                                                  |
+======================+==============================================================================================+
| defined              | Checks if a variable is defined (isset)                                                      |
+----------------------+----------------------------------------------------------------------------------------------+
| empty                | Checks if a variable is empty                                                                |
+----------------------+----------------------------------------------------------------------------------------------+
| even                 | Checks if a numeric value is even                                                            |
+----------------------+----------------------------------------------------------------------------------------------+
| odd                  | Checks if a numeric value is odd                                                             |
+----------------------+----------------------------------------------------------------------------------------------+
| numeric              | Checks if value is numeric                                                                   |
+----------------------+----------------------------------------------------------------------------------------------+
| scalar               | Checks if value is scalar (not an array or object)                                           |
+----------------------+----------------------------------------------------------------------------------------------+
| iterable             | Checks if a value is iterable. Can be traversed by a "for" statement                         |
+----------------------+----------------------------------------------------------------------------------------------+
| divisibleby          | Checks if a value is divisible by other value                                                |
+----------------------+----------------------------------------------------------------------------------------------+
| sameas               | Checks if a value is identical to other value                                                |
+----------------------+----------------------------------------------------------------------------------------------+
| type                 | Checks if a value is of the specified type                                                   |
+----------------------+----------------------------------------------------------------------------------------------+


%{volt_8ebd1e2cfafc15872b017437f8917eb2}%

.. code-block:: html+jinja

    {% if robot is defined %}
        The robot variable is defined
    {% endif %}

    {% if robot is empty %}
        The robot is null or isn't defined
    {% endif }

    {% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
        {% if key is even %}
            {{ name }}
        {% endif }
    {% endfor %}

    {% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
        {% if key is odd %}
            {{ name }}
        {% endif }
    {% endfor %}

    {% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 'third': 'Bender'] %}
        {% if key is numeric %}
            {{ name }}
        {% endif }
    {% endfor %}

    {% set robots = [1: 'Voltron', 2: 'Astroy Boy'] %}
    {% if robots is iterable %}
        {% for robot in robots %}
            ...
        {% endfor %}
    {% endif %}

    {% set world = "hello" %}
    {% if world is sameas("hello") %}
        {{ "it's hello" }}
    {% endif %}

    {% set external = false %}
    {% if external is type('boolean') %}
        {{ "external is false or true" }}
    {% endif %}


%{volt_83958ae729519ff5491ec0dd9fe759df}%
------
%{volt_9ac27aedade0d502a3d25ace895b506d}%

.. code-block:: html+jinja

    {%- macro related_bar(related_links) %}
        <ul>
            {%- for rellink in related_links %}
                <li><a href="{{ url(link.url) }}" title="{{ link.title|striptags }}">{{ link.text }}</a></li>
            {%- endfor %}
        </ul>
    {%- endmacro %}

    {# Print related links #}
    {{ related_bar(links) }}

    <div>This is the content</div>

    {# Print related links again #}
    {{ related_bar(links) }}


%{volt_96292b255db8dd893f2454d9d404d0ef}%

.. code-block:: html+jinja

    {%- macro error_messages(message, field, type) %}
        <div>
            <span class="error-type">{{ type }}</span>
            <span class="error-field">{{ field }}</span>
            <span class="error-message">{{ message }}</span>
        </div>
    {%- endmacro %}

    {# Call the macro #}
    {{ error_messages('type': 'Invalid', 'message': 'The name is invalid', 'field': 'name') }}


%{volt_1722014db38e343cdceaa1fa29ce9a8f}%

.. code-block:: html+jinja

    {%- macro my_input(name, class) %}
        {% return text_field(name, 'class': class) %}
    {%- endmacro %}

    {# Call the macro #}
    {{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}


%{volt_3efedb9100e7169c8d720e7c72d7c789}%

.. code-block:: html+jinja

    {%- macro my_input(name, class="input-text") %}
        {% return text_field(name, 'class': class) %}
    {%- endmacro %}

    {# Call the macro #}
    {{ '<p>' ~ my_input('name') ~ '</p>' }}
    {{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}


%{volt_37bc16dc011e098a69b4c1ca892ddb12}%
-----------------
%{volt_0daeace05b6a62ebbf941d68f76269e9|:doc:`Phalcon\\Tag <tags>`}%

.. code-block:: html+jinja

    {{ javascript_include("js/jquery.js") }}

    {{ form('products/save', 'method': 'post') }}

        <label>Name</label>
        {{ text_field("name", "size": 32) }}

        <label>Type</label>
        {{ select("type", productTypes, 'using': ['id', 'name']) }}

        {{ submit_button('Send') }}

    </form>


%{volt_6d029ed559ecc66fe449e9d1476653a0}%

.. code-block:: html+php

    <?php echo Phalcon\Tag::javascriptInclude("js/jquery.js") ?>

    <?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

        <label>Name</label>
        <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

        <label>Type</label>
        <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

        <?php echo Phalcon\Tag::submitButton('Send'); ?>

    </form>


%{volt_1b3b99f66306629b2e21ef3384dec973}%

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
| Phalcon\\Tag::dateField            | date_field            |
+------------------------------------+-----------------------+
| Phalcon\\Tag::emailField           | email_field           |
+------------------------------------+-----------------------+
| Phalcon\\Tag::numberField          | number_field          |
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


%{volt_800dd778c0248873014b5d46b6bf8de9}%
---------
%{volt_8da62e4de22c35c5145389c947a3836e}%

+----------------------+------------------------------------------------------------------------------+
| Name                 | Description                                                                  |
+======================+==============================================================================+
| content              | Includes the content produced in a previous rendering stage                  |
+----------------------+------------------------------------------------------------------------------+
| get_content          | Same as 'content'                                                            |
+----------------------+------------------------------------------------------------------------------+
| partial              | Dynamically loads a partial view in the current template                     |
+----------------------+------------------------------------------------------------------------------+
| super                | Render the contents of the parent block                                      |
+----------------------+------------------------------------------------------------------------------+
| time                 | Calls the PHP function with the same name                                    |
+----------------------+------------------------------------------------------------------------------+
| date                 | Calls the PHP function with the same name                                    |
+----------------------+------------------------------------------------------------------------------+
| dump                 | Calls the PHP function 'var_dump'                                            |
+----------------------+------------------------------------------------------------------------------+
| version              | Returns the current version of the framework                                 |
+----------------------+------------------------------------------------------------------------------+
| constant             | Reads a PHP constant                                                         |
+----------------------+------------------------------------------------------------------------------+
| url                  | Generate a URL using the 'url' service                                       |
+----------------------+------------------------------------------------------------------------------+


%{volt_e06179c3e64394a27a5d1a1957a16f83}%
----------------
%{volt_9b4f0cfb2fc37d32dd8c03d263003ef0|:doc:`Phalcon\\Mvc\\View <views>`}%

.. code-block:: html+php

    {{ content() }}

    <!-- Simple include of a partial -->
    <div id="footer">{{ partial("partials/footer") }}</div>

    <!-- Passing extra variables -->
    <div id="footer">{{ partial("partials/footer", ['links': $links]) }}</div>


%{volt_a53a19d535a9faa21843c6cf3748ad7d}%

.. code-block:: html+jinja

    {# Simple include of a partial #}
    <div id="footer">{% include "partials/footer" %}</div>

    {# Passing extra variables #}
    <div id="footer">{% include "partials/footer" with ['links': links] %}</div>


%{volt_28a7b018cd0d249f86423536e06961c9}%
^^^^^^^
%{volt_f227a9159a2de6cdf144f05ad35836f9}%

.. code-block:: html+jinja

    {# The contents of 'partials/footer.volt' is compiled and inlined #}
    <div id="footer">{% include "partials/footer.volt" %}</div>


%{volt_bf76ea164e27de7336aaa9146ea1ea05}%
--------------------
%{volt_452075260d726282b3506d29ab4dc91e}%

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


%{volt_e27605de512c4520ba4cff8c2360dd7c}%

.. code-block:: jinja

    {% extends "templates/base.volt" %}

    {% block title %}Index{% endblock %}

    {% block head %}<style type="text/css">.important { color: #336699; }</style>{% endblock %}

    {% block content %}
        <h1>Index</h1>
        <p class="important">Welcome on my awesome homepage.</p>
    {% endblock %}


%{volt_bb229e12234771d6175e4c357d806936}%

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


%{volt_6be2debfc1f89c4307f563a5985f71a6}%
^^^^^^^^^^^^^^^^^^^^
%{volt_171554bc64b2ea7ab5a3c6b34e8f10fe}%

.. code-block:: html+jinja

    {# main.volt #}
    <!DOCTYPE html>
    <html>
        <head>
            <title>Title</title>
        </head>
        <body>
            {% block content %}{% endblock %}
        </body>
    </html>


%{volt_ebae95d6169b5a402e916720cfce3725}%

.. code-block:: html+jinja

    {# layout.volt #}
    {% extends "main.volt" %}

    {% block content %}

        <h1>Table of contents</h1>

    {% endblock %}


%{volt_6f881fe0de2acd261c7325233fac3e6b}%

.. code-block:: html+jinja

    {# index.volt #}
    {% extends "layout.volt" %}

    {% block content %}

        {{ super() }}

        <ul>
            <li>Some option</li>
            <li>Some other option</li>
        </ul>

    {% endblock %}


%{volt_5a40902b0cbd394774f14fc165ad04a1}%

.. code-block:: html

    <!DOCTYPE html>
    <html>
        <head>
            <title>Title</title>
        </head>
        <body>

            <h1>Table of contents</h1>

            <ul>
                <li>Some option</li>
                <li>Some other option</li>
            </ul>

        </body>
    </html>


%{volt_d5ea84676990edc8a9ff87ee9616866a}%

%{volt_1530c1d48a32cccf6aee30317cb62004}%

.. highlights::

    By default, and for performance reasons, Volt only checks for changes in the children templates
    to know when to re-compile to plain PHP again, so it is recommended initialize Volt with the option
    'compileAlways' => true. Thus, the templates are compiled always taking into account changes in
    the parent templates.



%{volt_33fc9d5ccdfdac6f9b3a6b198c182701}%
---------------
%{volt_825823aba16d331414c4b6212399156d}%

.. code-block:: html+jinja

    Manually escaped: {{ robot.name|e }}

    {% autoescape true %}
        Autoescaped: {{ robot.name }}
        {% autoescape false %}
            No Autoescaped: {{ robot.name }}
        {% endautoescape %}
    {% endautoescape %}


%{volt_b8c97bce4488a1fb733ae5e45de2fb72}%
--------------------------
%{volt_a6e9dbf514ed4b3c2091a71de327231b}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\View,
        Phalcon\Mvc\View\Engine\Volt;

    //{%volt_6eb1b0275db340abd7417f83e40fece8%}
    $di->set('voltService', function($view, $di) {

        $volt = new Volt($view, $di);

        $volt->setOptions(array(
            "compiledPath" => "../app/compiled-templates/",
            "compiledExtension" => ".compiled"
        ));

        return $volt;
    });

    //{%volt_4cc0afe773f64be53a0dec14d4d624fd%}
    $di->set('view', function() {

        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => 'voltService'
        ));

        return $view;
    });


%{volt_b7967d27f624e9c7b4b5b7b66f0cc467}%

.. code-block:: php

    <?php

    //{%volt_7c198915869603e8c84a190009dacfef%}
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => function($view, $di) {
                $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

                //{%volt_3df2a4fc37af7f679704f2fe71b4ebf8%}

                return $volt;
            }
        ));

        return $view;
    });



%{volt_ce5773f862cbab6b15b61a824f19da36}%

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
| prefix            | Allows to prepend a prefix to the templates in the compilation path                                                            | null    |
+-------------------+--------------------------------------------------------------------------------------------------------------------------------+---------+


%{volt_54ea27e9f7cbb9f7f499526bc0b33dd3}%

.. code-block:: php

    <?php

    // {%volt_4db4ebd567bd7d18ce0179d999e588ac%}
    // {%volt_8dab661ce06ac7e9d9fa79268f69238b%}
    $volt->setOptions(array(
        'compiledPath' => function($templatePath) {
            return $templatePath . '.php';
        }
    ));

    // {%volt_f61b07b90556714f2a151dd18c8c47cc%}
    $volt->setOptions(array(
        'compiledPath' => function($templatePath) {
            $dirName = dirname($templatePath);
            if (!is_dir('cache/' . $dirName)) {
                mkdir('cache/' . $dirName);
            }
            return 'cache/' . $dirName . '/'. $templatePath . '.php';
        }
    ));


%{volt_c35aaed9c35a2d5e1e7949c14f87d7da}%
--------------
%{volt_4f614d2e98c02937485f28e55de1ff48}%

%{volt_3d5f4485a2f56b1d388425052b976315}%

%{volt_800dd778c0248873014b5d46b6bf8de9}%
^^^^^^^^^
%{volt_eff81ebb2e4622502c2770ff681205ca}%

.. code-block:: php

    <?php

    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

    $compiler = $volt->getCompiler();

    //{%volt_f1a88763bba2b44f9c25a709a778aa18%}
    $compiler->addFunction('shuffle', 'str_shuffle');


%{volt_fd1e231592832bc2a5107f9e237d4f61}%

.. code-block:: php

    <?php

    $compiler->addFunction('widget', function($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    });


%{volt_bdb996fcd57717bf161fc97f8b78e04d}%

.. code-block:: php

    <?php

    $compiler->addFunction('repeat', function($resolvedArgs, $exprArgs) use ($compiler) {

        //{%volt_382b3658a3599ee7466e05218e9ec485%}
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        //{%volt_1752d6ce4e2c6de86227a395c77c3fd8%}
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            //{%volt_160a920bc4968e3cfd622231dde174bc%}
            $secondArgument = '10';
        }

        return 'str_repeat(' . $firstArgument . ', ' . $secondArgument . ')';
    });


%{volt_6f0da7753f00daf5999a4495d6f86816}%

.. code-block:: php

    <?php

    $compiler->addFunction('contains_text', function($resolvedArgs, $exprArgs) {
        if (function_exists('mb_stripos')) {
            return 'mb_stripos(' . $resolvedArgs . ')';
        } else {
            return 'stripos(' . $resolvedArgs . ')';
        }
    });


%{volt_bb8fbd3e074da81e65b6f174515447a2}%

.. code-block:: php

    <?php

    //{%volt_72c544dbccfac5627f854622d434647a%}
    $compiler->addFunction('dump', 'print_r');


%{volt_c3240673b53669364a902ccbcbbb8ad4}%
^^^^^^^
%{volt_701b73703153b72f1241fb6f987d7971}%

.. code-block:: php

    <?php

    //{%volt_3c9486de45f5822473603d9b4d40a5cb%}
    $compiler->addFilter('hash', 'md5');

.. code-block:: php

    <?php

    $compiler->addFilter('int', function($resolvedArgs, $exprArgs) {
        return 'intval(' . $resolvedArgs . ')';
    });


%{volt_a94bf3d5a19e65a73be6d782a90bced2}%

.. code-block:: php

    <?php

    //{%volt_a7eb88ca5044727dd80b6c2c0a109680%}
    $compiler->addFilter('capitalize', 'lcfirst');


%{volt_b3579f83bd62b25c9709fdbca3bf6161}%
^^^^^^^^^^
%{volt_7bff1818d33f6c3e4ae5bac1041258c1}%

%{volt_0a168806eb5241d25a16d987d09e9510}%

%{volt_b132dbd03fdf508b2f1d210f9a385708}%

.. code-block:: php

    <?php

    class PhpFunctionExtension
    {
        /**
         * This method is called on any attempt to compile a function call
         */
        public function compileFunction($name, $arguments)
        {
            if (function_exists($name)) {
                return $name . '('. $arguments . ')';
            }
        }
    }


%{volt_d5a6d98c9404a6720bce0f4380ef5077}%

%{volt_29ef643fc01fb50deb0745843ae0df21}%

+-------------------+------------------------------------------------------------------------------------------------------------+
| Event/Method      | Description                                                                                                |
+===================+============================================================================================================+
| compileFunction   | Triggered before trying to compile any function call in a template                                         |
+-------------------+------------------------------------------------------------------------------------------------------------+
| compileFilter     | Triggered before trying to compile any filter call in a template                                           |
+-------------------+------------------------------------------------------------------------------------------------------------+
| resolveExpression | Triggered before trying to compile any expression. This allows the developer to override operators         |
+-------------------+------------------------------------------------------------------------------------------------------------+
| compileStatement  | Triggered before trying to compile any expression. This allows the developer to override any statement     |
+-------------------+------------------------------------------------------------------------------------------------------------+


%{volt_c53d1abf62ee18eb0b40402445443bb6}%

.. code-block:: php

    <?php

    //{%volt_1716b775e668aa844892030c0180b1d2%}
    $compiler->addExtension(new PhpFunctionExtension());


%{volt_e2809b8367f23b279052a0c57a34b5ac}%
----------------------
%{volt_a9ac5104121ee701d914b8a21f4295e7}%

.. code-block:: html+jinja

    {% cache "sidebar" %}
        <!-- generate this content is slow so we are going to cache it -->
    {% endcache %}


%{volt_b129e2652902c73176aff8e8886377b5}%

.. code-block:: html+jinja

    {# cache the sidebar by 1 hour #}
    {% cache "sidebar" 3600 %}
        <!-- generate this content is slow so we are going to cache it -->
    {% endcache %}


%{volt_e9f47d31e2ad5021e1f9bca72ff49aa9}%

.. code-block:: html+jinja

    {% cache ("article-" ~ post.id) 3600 %}

        <h1>{{ post.title }}</h1>

        <p>{{ post.content }}</p>

    {% endcache %}


%{volt_211d0d2b80edaa6983fde0e67e623758|:doc:`Phalcon\\Cache <cache>`|:doc:`"Caching View Fragments" <views>`}%

%{volt_c45c12e738f6cb287f117d8bac15285b}%
-------------------------------
%{volt_ebd73ba8f93a225dbf5dfd764d03ba90}%

.. code-block:: html+jinja

    {# Inject the 'flash' service #}
    <div id="messages">{{ flash.output() }}</div>

    {# Inject the 'security' service #}
    <input type="hidden" name="token" value="{{ security.getToken() }}">


%{volt_d3e54f7c04408d6d1a884897bca4169e}%
---------------------
%{volt_f060f739765fe9b113aa46c2df47a2d2}%

.. code-block:: php

    <?php

    //{%volt_d35206c45f85ed1c51d60b6eeb1788c6%}
    $compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();

    //{%volt_1713c75f8f2dc85950bd4f351d4c8526%}
    $compiler->setOptions(array(
        //...
    ));

    //{%volt_4036fad262b5149ba792d4e0a2fff044%}
    echo $compiler->compileString('{{ "hello" }}');

    //{%volt_ba9d724e56a24793fa15b9dda9ac73cf%}
    $compiler->compileFile('layouts/main.volt', 'cache/layouts/main.volt.php');

    //{%volt_b6769e95cd189feb2dc467a58d4e1c5e%}
    $compiler->compile('layouts/main.volt');

    //{%volt_7914c55377d1cd19e405d298b74750ed%}
    require $compiler->getCompiledTemplatePath();


%{volt_b0492394b589b5ff8f6fb98048d65d8f}%
------------------
* A bundle for Sublime/Textmate is available :1:
* :1:, is another sample application that use Volt, [:2:]
* `Our website <http://phalconphp.com>`_ is running using Volt as template engine, [`Github <https://github.com/phalcon/website>`_]
* `Phosphorum <http://forum.phalconphp.com>`_, the Phalcon's forum, also uses Volt, [`Github <https://github.com/phalcon/forum>`_]
* `Vökuró <http://vokuro.phalconphp.com>`_, is another sample application that use Volt, [`Github <https://github.com/phalcon/vokuro>`_]

