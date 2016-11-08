Управление ресурсами (Assets Management)
========================================

:code:`Phalcon\Assets` - это компонент позволяющий разработчику управлять статичными ресурсами в веб-приложении,
такими как каскадные таблицы стилей или javascript'ы.

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` доступен в контейнере сервисов,
т.ч. вы можете добавлять ресурсы из любой части приложения, где контейнер доступен.

Добавление ресурсов
-------------------
Поддерживаются ресурсы двух типов: каскадные таблицы стилей и JavaScript'ы, но при необходимости,
можете создать и другие. Внутренний механизм менеджера ресурсов хранит две коллекции, одну
для JavaScript'ов, а другую для каскадных таблиц стилей.

Добавить ресурсы в эти коллекции очень просто:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function index()
        {
            // Добавляем некоторые локальные таблицы стилей
            $this->assets->addCss("css/style.css");
            $this->assets->addCss("css/index.css");

            // и JavaScript'ы
            $this->assets->addJs("js/jquery.js");
            $this->assets->addJs("js/bootstrap.min.js");
        }
    }

Далее, добавленные ресурсы могут быть отображены в представлениях:

.. code-block:: html+php

    <html>
        <head>
            <title>Некоторый удивительный веб-сайт</title>

            <?php $this->assets->outputCss(); ?>
        </head>

        <body>
            <!-- ... -->

            <?php $this->assets->outputJs(); ?>
        </body>
    <html>

Volt syntax:

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>

            {{ assets.outputCss() }}
        </head>

        <body>
            <!-- ... -->

            {{ assets.outputJs() }}
        </body>
    <html>

For better pageload performance, it is recommended to place JavaScript at the end of the HTML instead of in the :code:`<head>`.

Локальные/удаленные ресурсы
---------------------------
Локальные ресурсы это те, которые предоставляются вами в том же приложении.
Ссылки на локальные ресурсы генерируются с помощью сервиса 'url', чаще
с применением :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`.

Удаленные ресурсы, такие как общие библиотеки, на подобии jquery, bootstrap или пр. предоставляемые посредством CDN.

.. code-block:: php

    <?php

    public function indexAction()
    {
        // Добавляем некоторые локальные и удаленные ресурсы
        $this->assets->addCss("//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css", false);
        $this->assets->addCss("css/style.css", true);
        $this->assets->addCss("css/extra.css");
    }

Коллекции
---------
В коллекциях группируются однотипные ресурсы. Менеджер ресурсов безоговорочно создает две: css и js.
Для группирования специфичных ресурсов вы можете создавать дополнительные:

.. code-block:: php

    <?php

    // Javascript'ы в заголовке
    $headerCollection = $this->assets->collection("header");

    $headerCollection->addJs("js/jquery.js");
    $headerCollection->addJs("js/bootstrap.min.js");

    // Javascript'ы в "подвале"
    $footerCollection = $this->assets->collection("footer");

    $footerCollection->addJs("js/jquery.js");
    $footerCollection->addJs("js/bootstrap.min.js");

затем в представлении:

.. code-block:: html+php

    <html>
        <head>
            <title>Некоторый удивительный веб-сайт</title>

            <?php $this->assets->outputJs("header"); ?>
        </head>

        <body>
            <!-- ... -->

            <?php $this->assets->outputJs("footer"); ?>
        </body>
    <html>

Volt syntax:

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>

            {{ assets.outputCss("header") }}
        </head>

        <body>
            <!-- ... -->

            {{ assets.outputJs("footer") }}
        </body>
    <html>

Префиксы
--------
К коллекциям могут применяться URL префиксы, это позволит в любой момент легко изменить расположение ресурсов с одного сервера на другой:

.. code-block:: php

    <?php

    $footerCollection = $this->assets->collection("footer");

    if ($config->environment === "development") {
        $footerCollection->setPrefix("/");
    } else {
        $footerCollection->setPrefix("http:://cdn.example.com/");
    }

    $footerCollection->addJs("js/jquery.js");
    $footerCollection->addJs("js/bootstrap.min.js");

Также, доступен синтаксис цепочки (chainable):

.. code-block:: php

    <?php

    $headerCollection = $assets
        ->collection("header")
        ->setPrefix("http://cdn.example.com/")
        ->setLocal(false)
        ->addJs("js/jquery.js")
        ->addJs("js/bootstrap.min.js");

Минимизация/ Фильтрация
-----------------------
:code:`Phalcon\Assets` предоставляет встроенную возможность минимизации JavaScript и CSS.
Разработчик может создать коллекцию ресурсов с указаниями для Assets Manager, к
каким ресурсам должны быть применены фильтры, а к каким нет. В дополнении к
вышесказанному, “Jsmin” Дугласа Крокфорда (Douglas Crockford) входит в состав ядра
минимизации javascript для увеличения производительности. Для минимизации CSS
используется “CSSMin” Райна Дэйя (Ryan Day).

Следующий пример показывает, как минимизировать набор ресурсов:

.. code-block:: php

    <?php

    $manager

        // Этот javascript расположен внизу страницы
        ->collection("jsFooter")

        // Название получаемого файла
        ->setTargetPath("final.js")

        // С таким URI генерируется тэг html
        ->setTargetUri("production/final.js")

        // Это удаленный ресурс, не нуждающийся в фильтрации
        ->addJs("code.jquery.com/jquery-1.10.0.min.js", false, false)

        // Это локальные ресурсы, к которым необходимо применить фильтры
        ->addJs("common-functions.js")
        ->addJs("page-functions.js")

        // Объединяем все ресурсы в один файл
        ->join(true)

        // Используем встроенный фильтр Jsmin
        ->addFilter(
            new Phalcon\Assets\Filters\Jsmin()
        )

        // Используем пользовательский фильтр
        ->addFilter(
            new MyApp\Assets\Filters\LicenseStamper()
        );

Менеджер начинает получать набор ресурсов от Assets Manager, который может содержать либо JavaScript,
либо CSS, но не оба типа ресурсов. Некоторые ресурсы могут быть удаленными, то есть, полученными с
помощью HTTP запроса для дальнейшей фильтрации. Преобразования внешних ресурсов рекомендуется для
устранения накладных расходов на их получение.

As seen above, the :code:`addJs()` method is used to add resources to the collection, the second parameter indicates
whether the resource is external or not and the third parameter indicates whether the resource should
be filtered or left as is:

.. code-block:: php

    <?php

    // Этот javascript расположен внизу
    $jsFooterCollection = $manager->collection("jsFooter");

    // Это удаленный ресурс, не нуждающийся в фильтрации
    $jsFooterCollection->addJs("code.jquery.com/jquery-1.10.0.min.js", false, false);

    // Это локальные ресурсы, к которым необходимо применить фильтры
    $jsFooterCollection->addJs("common-functions.js");
    $jsFooterCollection->addJs("page-functions.js");

Фильтры регистрируются в коллекции, допускается регистрировать несколько фильтров. Ресурсы в наборе
фильтруются в том же порядке, в каком были зарегистрированы фильтры:

.. code-block:: php

    <?php

    // Используем встроенный фильтр Jsmin
    $jsFooterCollection->addFilter(
        new Phalcon\Assets\Filters\Jsmin()
    );

    // Используем пользовательский фильтр
    $jsFooterCollection->addFilter(
        new MyApp\Assets\Filters\LicenseStamper()
    );

Заметим, что встроенные и пользовательские фильтры могут сразу применяться к набору ресурсов.
Последний шаг, определяет, стоит ли объединять все ресурсы набора в один файл, или использовать
каждый по отдельности. Если все ресурсы набора должны объединяться в один файл, вы можете использовать
метод :code:`join()`.

If resources are going to be joined, we need also to define which file will be used to store the resources
and which URI will be used to show it. These settings are set up with :code:`setTargetPath()` and :code:`setTargetUri()`:

.. code-block:: php

    <?php

    $jsFooterCollection->join(true);

    // Название получаемого файла
    $jsFooterCollection->setTargetPath("public/production/final.js");

    // С таким URI генерируется тэг HTML
    $jsFooterCollection->setTargetUri("production/final.js");

Если ресурсы должны быть объединены, то вы должны также определить какой файл будет использоваться для
хранения ресурсов и по какому URI он будет доступен. Эти параметры настраиваются с помощью методов
:code:`setTargetPath()` и :code:`setTargetUri()`.

Встроенные фильтры
^^^^^^^^^^^^^^^^^^
Phalcon имеет два встроенных фильтра минимизации javascript и CSS, их реализация на C обеспечивает
минимальные накладные расходы для решения подобной задачи:

+---------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------+
| Фильтр                                                                          | Описание                                                                                                      |
+=================================================================================+===============================================================================================================+
| :doc:`Phalcon\\Assets\\Filters\\Jsmin <../api/Phalcon_Assets_Filters_Jsmin>`    | Минимизирует JavaScript удаляя не нужны символы, которые игнорируются интерпретатором/компилятором JavaScript |
+---------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Assets\\Filters\\Cssmin <../api/Phalcon_Assets_Filters_Cssmin>`  | Минимизирует CSS удаляя ненужные символы, которые игнорируются браузерами                                     |
+---------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------+

Пользовательские фильтры
^^^^^^^^^^^^^^^^^^^^^^^^
Кроме использования встроенных фильтров, разработчик может создавать свои собственные фильтры. Вы можете
воспользоваться существующими более продвинутыми инструментами, такими как YUI_, Sass_, Closure_ и другие.

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * Filters CSS content using YUI
     *
     * @param string $contents
     * @return string
     */
    class CssYUICompressor implements FilterInterface
    {
        protected $_options;

        /**
         * CssYUICompressor constructor
         *
         * @param array $options
         */
        public function __construct(array $options)
        {
            $this->_options = $options;
        }

        /**
         * Do the filtering
         *
         * @param string $contents
         *
         * @return string
         */
        public function filter($contents)
        {
            // Write the string contents into a temporal file
            file_put_contents("temp/my-temp-1.css", $contents);

            system(
                $this->_options["java-bin"] .
                " -jar " .
                $this->_options["yui"] .
                " --type css " .
                "temp/my-temp-file-1.css " .
                $this->_options["extra-options"] .
                " -o temp/my-temp-file-2.css"
            );

            // Return the contents of file
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }

Применение:

.. code-block:: php

    <?php

    // Get some CSS collection
    $css = $this->assets->get("head");

    // Add/Enable the YUI compressor filter in the collection
    $css->addFilter(
        new CssYUICompressor(
            [
                "java-bin"      => "/usr/local/bin/java",
                "yui"           => "/some/path/yuicompressor-x.y.z.jar",
                "extra-options" => "--charset utf8",
            ]
        )
    );

In a previous example, we used a custom filter called :code:`LicenseStamper`:

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * Adds a license message to the top of the file
     *
     * @param string $contents
     *
     * @return string
     */
    class LicenseStamper implements FilterInterface
    {
        /**
         * Do the filtering
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {
            $license = "/* (c) 2015 Your Name Here */";

            return $license . PHP_EOL . PHP_EOL . $contents;
        }
    }

Пользовательский вывод
----------------------
Методы :code:`outputJs()` и :code:`outputCss()` создают требуемую HTML-разметку в соответствии с каждым типом ресурсов, но
вы можете переопределить эти методы и создать разметку вручную:

.. code-block:: php

    <?php

    use Phalcon\Tag;

    $jsCollection = $this->assets->collection("js");

    foreach ($jsCollection as $resource) {
        echo Tag::javascriptInclude(
            $resource->getPath()
        );
    }

.. _YUI: http://yui.github.io/yuicompressor/
.. _Closure: https://developers.google.com/closure/compiler/?hl=fr
.. _Sass: http://sass-lang.com/
