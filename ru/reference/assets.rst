Управление ресурсами (Assets Management)
========================================
Phalcon\\Assets - это компонент позволяющий разработчику управлять статичными ресурсами в веб-приложении,
такими как каскадные таблицы стилей или javascript'ы.

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` доступен в контейнере сервисов,
т.ч. вы можете добавлять ресурсы из любой части приложения, где он доступен.

Добавление ресурсов
-------------------
Поддерживаются ресурсы двух типов: каскадные таблицы стилей и javascript'ы, но при необходимости,
можете создать и другие. Внутренний механизм менеджера ресурсов хранит две коллекции, одну
для javascript'ов, а другую для каскадных таблиц стилей.

Добавить ресурсы в эти коллекции очень просто:

.. code-block:: php

    <?php

    class IndexController extends Phalcon\Mvc\Controller
    {
        public function index()
        {

            // Добавляем некоторые локальные таблицы стилей
            $this->assets
                ->addCss('css/style.css')
                ->addCss('css/index.css');

            // и javascript'ы
            $this->assets
                ->addJs('js/jquery.js')
                ->addJs('js/bootstrap.min.js');

        }
    }

Далее, добавленные ресурсы могут быть отображены в представлениях:

.. code-block:: html+php

    <html>
        <head>
            <title>Некоторый удивительный веб-сайт</title>
            <?php $this->assets->outputCss() ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs() ?>
        </body>
    <html>

Локальные/удаленные ресурсы
---------------------------
Локальные ресурсы это те, которые предоставляются вами в том же приложении.
Ссылки на локальные ресурсы генерируются с помощью сервиса 'url', чаще
с применением :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`.

Удаленные ресурсы, такие как общие библиотеки, на подобии jquery, bootstrap или пр. предоставляемые посредством CDN.

.. code-block:: php

    <?php

    // Добавляем некоторые локальные и удаленные ресурсы
    $this->assets
        ->addCss('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css', false)
        ->addCss('css/style.css', true);

Коллекции
---------
В коллекциях группируются однотипные ресурсы. Менеджер ресурсов безоговорочно создает две: css и js.
Для группирования специфичных ресурсов вы можете создавать дополнительные:

.. code-block:: php

    <?php

    // Javascript'ы в заголовке
    $this->assets
        ->collection('header')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

    // Javascript'ы в "подвале"
    $this->assets
        ->collection('footer')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

затем в представлении:

.. code-block:: html+php

    <html>
        <head>
            <title>Некоторый удивительный веб-сайт</title>
            <?php $this->assets->outputJs('header') ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs('footer') ?>
        </body>
    <html>

Префиксы
--------
К коллекциям могут применяться URL префиксы, это позволит в любой момент легко изменить расположение ресурсов с одного сервера на другой:

.. code-block:: php

    <?php

    $scripts = $this->assets->collection('footer');

    if ($config->enviroment == 'development') {
        $scripts->setPrefix('/');
    } else {
        $scripts->setPrefix('http:://cdn.example.com/');
    }

    $scripts->addJs('js/jquery.js')
            ->addJs('js/bootstrap.min.js');

Также, доступен синтаксис цепочки (chainable):

.. code-block:: php

    <?php

    $scripts = $assets
        ->collection('header')
        ->setPrefix('http://cdn.example.com/')
        ->setLocal(false)
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');


Минимизация/ Фильтрация
-----------------------
Phalcon\Assets предоставляет встроенную возможность минимизации javascript и CSS. 
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
        ->collection('jsFooter')

        //Название получаемого файла
        ->setTargetPath('final.js')

        // С таким URI генерируется тэг html
        ->setTargetUri('production/final.js')

        // Это удаленный ресурс, не нуждающийся в фильтрации
        ->addJs('code.jquery.com/jquery-1.10.0.min.js', true, false)

        // Это локальные ресурсы, к которым необходимо применить фильтры 
        ->addJs('common-functions.js')
        ->addJs('page-functions.js')

        // Объединяем все ресурсы в один файл
        ->join(true)

        // Используем встроенный фильтр Jsmin
        ->addFilter(new Phalcon\Assets\Filters\Jsmin())

        // Используем пользовательский фильтр
        ->addFilter(new MyApp\Assets\Filters\LicenseStamper());

Менеджер начинает получать набор ресурсов от Assets Manager, который может содержать либо javascript, 
либо CSS, но не оба типа ресурсов. Некоторые ресурсы могут быть удаленными, то есть, полученными с 
помощью HTTP запроса для дальнейшей фильтрации. Преобразования внешних ресурсов рекомендуется для 
устранения накладных расходов на их получение.

.. code-block:: php

    <?php

    // Этот javascript расположен внизу
    $js = $manager->collection('jsFooter');

Как показано выше, метод addJs используется для добавления ресурсов в коллекцию, второй параметр 
указывает, является ли ресурс внешних или нет, и третий параметр указывает, должен ли ресурс быть 
отфильтрован или нет:

.. code-block:: php

    <?php

    // Это удаленный ресурс, не нуждающийся в фильтрации 
    $js->addJs('code.jquery.com/jquery-1.10.0.min.js', true, false);

    // Это локальные ресурсы, к которым необходимо применить фильтры
    $js->addJs('common-functions.js');
    $js->addJs('page-functions.js');

Фильтры регистрируются в коллекции, допускается регистрировать несколько фильтров. Ресурсы в наборе 
фильтруются в том же порядке, в каком были зарегистрированы фильтры:

.. code-block:: php

    <?php

    // Используем встроенный фильтр Jsmin
    $js->addFilter(new Phalcon\Assets\Filters\Jsmin());

    // Используем пользовательский фильтр
    $js->addFilter(new MyApp\Assets\Filters\LicenseStamper());

Заметим, что встроенные и пользовательские фильтры могут сразу применяться к набору ресурсов. 
Последний шаг, определяет, стоит ли объединять все ресурсы набора в один файл, или использовать 
каждый по отдельности. Если все ресурсы набора должны объединяться в один файл, вы можете использовать 
метод 'join':

.. code-block:: php

    <?php

    // Объединяем все ресурсы в один файл
    $js->join(true);

    // Название получаемого файла
    $js->setTargetPath('public/production/final.js');

    // С таким URI генерируется тэг html
    $js->setTargetUri('production/final.js');

Если ресурсы должны быть объединены, то вы должны также определить какой файл будет использоваться для 
хранения ресурсов и по какому URI он будет доступен. Эти параметры настраиваются с помощью методов 
setTargetPath() и setTargetUri().

Встроенные фильтры
^^^^^^^^^^^^^^^^^^
Phalcon имеет два встроенных фильтра минимизации javascript и CSS, их реализация на C обеспечивает 
минимальные накладные расходы для решения подобной задачи:

+-----------------------------------+--------------------------------------------------------------------------------------------------------------+
| Фильтр                            | Описание                                                                                                     |
+===================================+==============================================================================================================+
| Phalcon\\Assets\\Filters\\Jsmin   | Минимизирует JavaScript удаляя не нужны символы, которые игнорируются интерпретатором/компилятором JavaScript|
+-----------------------------------+--------------------------------------------------------------------------------------------------------------+
| Phalcon\\Assets\\Filters\\Cssmin  | Минимизирует CSS удаляя ненужные символы, которые игнорируются браузерами                                    |
+-----------------------------------+--------------------------------------------------------------------------------------------------------------+

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
        public function __construct($options)
        {
            $this->_options = $options;
        }

        /**
         * Do the filtering
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {

            //Write the string contents into a temporal file
            file_put_contents('temp/my-temp-1.css', $contents);

            system(
                $this->_options['java-bin'] .
                ' -jar ' .
                $this->_options['yui'] .
                ' --type css '.
                'temp/my-temp-file-1.css ' .
                $this->_options['extra-options'] .
                ' -o temp/my-temp-file-2.css'
            );

            //Return the contents of file
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }

Применение:

.. code-block:: php

    <?php

    //Get some CSS collection
    $css = $this->assets->get('head');

    //Add/Enable the YUI compressor filter in the collection
    $css->addFilter(new CssYUICompressor(array(
         'java-bin' => '/usr/local/bin/java',
         'yui' => '/some/path/yuicompressor-x.y.z.jar',
         'extra-options' => '--charset utf8'
    )));

Пользовательский вывод
----------------------
Методы outputJs и outputCss создают требуемую HTML-разметку в соответствии с каждым типом ресурсов, но
вы можете переопределить эти методы и создать разметку вручную:

.. code-block:: php

    <?php

    foreach ($this->assets->collection('js') as $resource) {
        echo \Phalcon\Tag::javascriptInclude($resource->getPath());
    }

.. _YUI : http://yui.github.io/yuicompressor/
.. _Closure : https://developers.google.com/closure/compiler/?hl=fr
.. _Sass : http://sass-lang.com/
