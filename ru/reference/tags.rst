Помощники представлений
=======================
Написание и хранение HTML разметки может быстро надоесть из-за многочисленных элементов с разными именами и аттрибутами, зависимостями
которые должны быть всегда учтены. Phalcon облегчает эти сложности предлагая для работы компонент :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`,
предоставляющий помощников (helpers) для работы с элементами и формирования готовой HTML разметки.

Компонент может быть использован в шаблонах представлений из HTML+PHP или в шаблонизаторе :doc:`Volt <volt>`.

.. highlights::
    Это руководство не отображает все возможности помощников представлений и их аргументов. Для получения полной актуальной информации
    ознакомьтесь с документацией по API :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`.

Типы документов
---------------
Phalcon содержит помощника Phalcon\\Tag::setDoctype() для установки типа документа. Установка типа документа влияет на формирование компонентом
HTML разметки. Например, при указании любого типа из вариантов XHTML Phalcon будет добавлять в HTML код элементов закрывающие тэги, именно так
как того требует стандарт XHTML.

Рарешёнными константами для Phalcon\\Tag яявляются:

+----------------------+------------------------+
| Константа            | Тип документа          |
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

Установка типа документа:

.. code-block:: php

    <?php $this->tag->setDoctype(\$this->tag->HTML401_STRICT); ?>

Вывод типа документа:

.. code-block:: html+php

    <?= $this->tag->getDoctype() ?>
    <html>
    <!-- your HTML code -->
    </html>

Из кода выше сформируется такой HTML результат:

.. code-block:: html

    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
            "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <!-- your HTML code -->
    </html>

Синтаксис Volt:

.. code-block:: html+jinja

    {{ get_doctype() }}
    <html>
    <!-- your HTML code -->
    </html>

Создание ссылок
---------------
Наиболее частая задача в работе любого веб-приложение - формирование ссылок для перехода на другие страницы. Если ссылки внутренние (для этого же приложения),
то их можно формировать следующим образом:

.. code-block:: html+php

    <!-- для стандартных путей -->
    <?= $this->tag->linkTo("products/search", "Search") ?>

    <!-- используя CSS -->
    <?= $this->tag->linkTo(array('products/edit/10', 'Edit', 'class' => 'edit-btn')) ?>

    <!-- для именованных маршрутов -->
    <?= $this->tag->linkTo(array(array('for' => 'show-product', 'title' => 123, 'name' => 'carrots'), 'Show')) ?>

На самом деле, все такие ссылки формируются с использованием компонент :doc:`Phalcon\\Mvc\\Url <url>` (или другого используемого для "url" сервиса )

Аналогично ссылки формируются в Volt:

.. code-block:: html+jinja

    <!-- for the default route -->
    {{ link_to("products/search", "Search") }}

    <!-- for a named route -->
    {{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Show') }}

Создание форм
--------------
Формы веб-приложений играют важную роль для получение данных, введённых пользователем. Пример ниже показывает вариант реализации формы
поиска с использованием помощников представлений.

.. code-block:: html+php

    <!-- Отправка формы методом POST -->
    <?= $this->tag->form("products/search") ?>
        <label for="q">Search:</label>
        <?= $this->tag->textField("q") ?>
        <?= $this->tag->submitButton("Search") ?>
    </form>

    <!-- Использование специфичного для элемента FORM тега - метода отправки данных -->
    <?= $this->tag->form(array("products/search", "method" => "get")); ?>
        <label for="q">Search:</label>
        <?= $this->tag->textField("q"); ?>
        <?= $this->tag->submitButton("Search"); ?>
    </form>

Из кода выше сформируется такой HTML результат:

.. code-block:: html

    <form action="/store/products/search/" method="get">
         <label for="q">Search:</label>
         <input type="text" id="q" value="" name="q" />
         <input type="submit" value="Search" />
    </endform>

Аналогичную форму можно сгенерировать в Volt:

.. code-block:: html+jinja

    <!-- Specyfing another method or attributes for the FORM tag -->
    {{ form("products/search", "method": "get") }}
        <label for="q">Search:</label>
        {{ text_field("q") }}
        {{ submit_button("Search") }}
    </form>

Phalcon так же содержит :doc:`сборщик форм<forms>` для создания форм с использованием объектно-ориентированного подхода.

Помощники создания элементов форм
---------------------------------
Phalcon предоставляет ряд помощников для создания элементов формы, такие как текстовые поля, кнопки и многие другие. Первый параметр в таких методах
это всегда имя элемента. При отправке формы это имя будет передаваться вместе со значениями формы. В контроллере вы можете получить значение элемента
используя это же имя элемента и методы getPost() и getQuery() объекта запроса ($this->request).

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

Синтаксис Volt:

.. code-block::  html+jinja

    {{ text_field("username") }}

    {{ text_area("comment", "This is the content", "cols": "6", "rows": 20) }}

    {{ password_field("password", "size": 30) }}

    {{ hidden_field("parent_id", "value": "5") }}

Создание выпадающих списков
---------------------------
Работать с выпадающими списками легко при хранении данных для их формирования в виде ассоциативных массивов PHP. У Phalcon имеется два помощника
для работы с такими списками - Phalcon\\Tag::select() и Phalcon\\Tag::selectStatic(). Метод Phalcon\\Tag::select() был специально разработан для
работы с :doc:`Phalcon\\Mvc\\Model <models>`, а Phalcon\\Tag::selectStatic() с PHP массивами.

.. code-block:: php

    <?php

    // Используем данные из resultset
    echo $this->tag->select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name")
        )
    );

    // Используем данные из массива
    echo $this->tag->selectStatic(
        array(
            "status",
            array(
                "A" => "Active",
                "I" => "Inactive",
            )
        )
    );

Сформируется такой HTML:

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

Так же можно добавить пустой - "empty" блок в HTML:

.. code-block:: php

    <?php

    // Формирование выпадающего списка с пустым элементом
    echo $this->tag->select(
        array(
            "productId",
            Products::find("type = 'vegetables'"),
            "using" => array("id", "name"),
            "useEmpty" => true
        )
    );

Получится HTML

.. code-block:: html

    <select id="productId" name="productId">
        <option value="">Choose..</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

.. code-block:: php

    <?php

    // Указание параметров пустого элемента
    echo $this->tag->select(
        array(
            'productId',
            Products::find("type = 'vegetables'"),
            'using' => array('id', "name"),
            'useEmpty' => true,
            'emptyText' => 'Выберите значение...',
            'emptyValue' => '@'
        ),

    );

.. code-block:: html

    <select id="productId" name="productId">
        <option value="@">Выберите значение...</option>
        <option value="101">Tomato</option>
        <option value="102">Lettuce</option>
        <option value="103">Beans</option>
    </select>

Аналогичный пример для Volt:

.. code-block:: jinja

    {# Creating a Select Tag with an empty option with default text #}
    {{ select('productId', products, 'using': ['id', 'name'],
        'useEmpty': true, 'emptyText': 'Please, choose one...', 'emptyValue': '@') }}

Установка HTML аттрибутов
-------------------------
Все помощники (helpers) могут принимать в качестве первого параметра массив, в котором можно указывать аттрибуты для формирования HTML кода элемента:

.. code-block:: html+php

    <?php \$this->tag->textField(
        array(
            "price",
            "size"        => 20,
            "maxlength"   => 30,
            "placeholder" => "Введите цену",
        )
    ) ?>

так же и в Volt:

.. code-block:: jinja

    {{ text_field("price", "size": 20, "maxlength": 30, "placeholder": "Enter a price") }}

Сформированный HTML:

.. code-block:: html

    <input type="text" name="price" id="price" size="20" maxlength="30"
        placeholder="Enter a price" />

Установка значений помощников
-----------------------------

Из контроллера
^^^^^^^^^^^^^^
Установка значений форм в контроллерах является хорошей практикой в парадигме MVC. Вы можете устанавливать значения в контроллерах
используя метод Phalcon\\Tag::setDefault(). Этот помощник устанавливает значения по умолчанию для элементов форм используемых в представлениях.
При выводе формы производится проверка на предустановленные значения, и если значение не указано напрямую в помощнике, то будет использовано указанное в контроллере.

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            $this->tag->setDefault("color", "Blue");
        }

    }

В представлении помощник selectStatic сделает активным установленный индекс. В данном случае это "цвет":

.. code-block:: php

    <?php

    echo \$this->tag->selectStatic(
        array(
            "color",
            array(
                "Yellow" => "Yellow",
                "Blue"   => "Blue",
                "Red"    => "Red"
            )
        )
    );

В результате будет сформирован HTML код выпадающего списка с выбранным значением "Blue":

.. code-block:: html

    <select id="color" name="color">
        <option value="Yellow">Yellow</option>
        <option value="Blue" selected="selected">Blue</option>
        <option value="Red">Red</option>
    </select>

Из запроса (Request)
^^^^^^^^^^^^^^^^^^^^
Одна из волшебных функций Phalcon реализованной в компоненте :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` позволяет хранить данные, введённые в формы,
между запросами. Таким образом, вы можете легко выводить сообщения об ошибках и правильности заполнения формы без потери введенных пользователем данных.


Установка значений напрямую
^^^^^^^^^^^^^^^^^^^^^^^^^^^
Каждый помощник форм поддерживает параметр "value", с помощью него указываются конечные значения элемента. При указании этого параметра
все остальные предустановленные методом setDefault() значения будут проигнорированы.

Изменение title документа
-------------------------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` содержит так же помощника для динамического изменения названия (title) документа в контроллерах.
Использование такого варианта показано в примере.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function initialize()
        {
            $this->tag->setTitle(" Суперсайт");
        }

        public function indexAction()
        {
            $this->tag->prependTitle("Главная страница - ");
        }

    }

.. code-block:: html+php

    <html>
        <head>
            <?php echo \$this->tag->getTitle(); ?>
        </head>
        <body>

        </body>
    </html>

Результат:

.. code-block:: html+php

    <html>
        <head>
            <title>Главная страница - Суперсайт</title>
        </head>
          <body>

          </body>
    </html>

Помошники работы со статичными элементами
-----------------------------------------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` так же содержит помощников для генерации тегов script, link и img. Они помогают в быстрой и простой
генерации тегов подключения статичных ресурсов.

Изображения
^^^^^^^^^^^
.. code-block:: php

    <?php

    // Сформируется <img src="/your-app/img/hello.gif">
    echo \$this->tag->image("img/hello.gif");

    // Сформируется <img alt="alternative text" src="/your-app/img/hello.gif">
    echo \$this->tag->image(
        array(
           "img/hello.gif",
           "alt" => "alternative text"
        )
    );

Использование в Volt:

.. code-block:: jinja

    {# Сформируется <img src="/your-app/img/hello.gif"> #}
    {{ image("img/hello.gif") }}

    {# Сформируется <img alt="alternative text" src="/your-app/img/hello.gif"> #}
    {{ image("img/hello.gif", "alt": "alternative text") }}

Таблицы стилей (Stylesheets)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. code-block:: php

    <?php

    // Сформируется <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rosario" type="text/css">
    echo \$this->tag->stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);

    // Сформируется <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css">
    echo \$this->tag->stylesheetLink("css/styles.css");

Аналогично в Volt:

.. code-block:: jinja

    {# Сформируется <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rosario" type="text/css"> #}
    {{ stylesheet_link("http://fonts.googleapis.com/css?family=Rosario", false) }}

    {# Сформируется <link rel="stylesheet" href="/your-app/css/styles.css" type="text/css"> #}
    {{ stylesheet_link("css/styles.css") }}

Javascript
^^^^^^^^^^
.. code-block:: php

    <?php

    // Сформируется <script src="http://localhost/javascript/jquery.min.js" type="text/javascript"></script>
    echo \$this->tag->javascriptInclude("http://localhost/javascript/jquery.min.js", false);

    // Сформируется <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script>
    echo \$this->tag->javascriptInclude("javascript/jquery.min.js");

То же самое в Volt:

.. code-block:: jinja

    {# Сформируется <script src="http://localhost/javascript/jquery.min.js" type="text/javascript"></script> #}
    {{ javascript_include("http://localhost/javascript/jquery.min.js", false) }}

    {# Сформируется <script src="/your-app/javascript/jquery.min.js" type="text/javascript"></script> #}
    {{ javascript_include("javascript/jquery.min.js") }}

Элементы HTML5 - общий HTML помощник
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Фалкон содержит HTML помощник, позволяющий генерировать любой HTML элемент. Он полностью зависит от разработчика, необходимо лишь название элемента.

.. code-block:: php

    <?php

    // Generate
    // <canvas id="canvas1" width="300" class="cnvclass">
    // This is my canvas
    // </canvas>
    echo \$this->tag->tagHtml("canvas", array("id" => "canvas1", "width" => "300", "class" => "cnvclass", false, true, true));
    echo "This is my canvas";
    echo \$this->tag->tagHtmlClose("canvas");

Синтаксис Volt:

.. code-block:: jinja

    {# Generate #}
    {# <canvas id="canvas1" width="300" class="cnvclass"> #}
    {# This is my canvas #}
    {# </canvas> #}
    {{ tag_html("canvas", ["id":"canvas1", width":"300", "class":"cnvclass"], false, true, true) }}
    This is my canvas
    {{ tag_html_close("canvas") }}

Tag Service
-----------
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` is available via the 'tag' service, this means you can access it from any part
of the application where the services container is located:

.. code-block:: php

    <?php echo $this->tag->linkTo('pages/about', 'About') ?>

You can easily add new helpers to a custom component replacing the service 'tag' in the services container:

.. code-block:: php

    <?php

    class MyTags extends \Phalcon\Tag
    {
        //...

        //Create a new helper
        static public function myAmazingHelper($parameters)
        {
            //...
        }

        //Override an existing method
        static public function textField($parameters)
        {
            //...
        }
    }

Then change the definition of the service 'tag':

.. code-block:: php

    <?php

    $di['tag'] = function() {
        return new MyTags();
    };

Создание собственных помощников
-------------------------------
Вы можете с лёгкостью создавать своих помощников расширяя :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` и реализуя собственных помощников. Пример ниже
отображает вариант такой реализации:

.. code-block:: php

    <?php

    class MyTags extends \Phalcon\Tag
    {

        /**
         * Соаздёт виджет вывода тега HTML5 audio
         *
         * @param array
         * @return string
         */
        static public function audioField($parameters)
        {

            // Приведение к массиву
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            // Определение аттрибутов "id" и "name"
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

            // Определение значения элемента
            // \$this->tag->setDefault() позволяет установить значение элемента
            if (isset($parameters["value"])) {
                $value = $parameters["value"];
                unset($parameters["value"]);
            } else {
                $value = self::getValue($id);
            }

            // Генерация кода
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

Так же предлагаем вам ознакомиться с :doc:`Volt <volt>` - очень быстрым шаблонизатором для PHP. В нём вы же можете использовать
возможности Phalcon\\Tag в более дружественном синтаксисе.
