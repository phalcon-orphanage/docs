Управление ресурсами (Assets Management)
========================================
Phalcon\\Assets - это компонент позволяющий разработчику управлять статичными ресурсами в веб-приложении,
такими как каскадные таблицы стилей или javascript'ы.

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` доступен в контейнере сервисов,
т.ч. вы можете добавлять ресурсы из любой части приложения где он доступен.

Добавление ресурсов
-------------------
Поддерживаются ресурсы двух типов: каскадные таблицы стилей и javascript'ы, но при необходимости,
можете создать и другие. Внтуренний механизм менеджера ресурсов хранит две коллекции, одну
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
К коллекциям могут применятся URL префиксы, это позволит в любой момент легко изменить расположение ресурсов с одного сервера на другой:

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


Minification/Filtering
----------------------
Phalcon\\Assets provides built-in minification of Javascript and CSS resources. The developer can create a collection of
resources instructing the Assets Manager which ones must be filtered and which ones must be​ left as they are.
In addition to the above, Jsmin by Douglas Crockford is part of the core extension offering minification of javascript files
for maximum performance. In the CSS land, CSSMin by Ryan Day is also available to minify CSS files:

The following example shows how to minify a collection of resources:

.. code-block:: php

    <?php

    $manager

        //These Javascripts are located in the page's bottom
        ->collection('jsFooter')

        //The name of the final output
        ->setTargetPath('final.js')

        //The script tag is generated with this URI
        ->setTargetUri('production/final.js')

        //This is a remote resource that does not need filtering
        ->addJs('code.jquery.com/jquery-1.10.0.min.js', true, false)

        //These are local resources that must be filtered
        ->addJs('common-functions.js')
        ->addJs('page-functions.js')

        //Join all the resources in a single file
        ->join(true)

        //Use the built-in Jsmin filter
        ->addFilter(new Phalcon\Assets\Filters\Jsmin())

        //Use a custom filter
        ->addFilter(new MyApp\Assets\Filters\LicenseStamper());

It starts getting a collection of resources from the assets manager, a collection can contain javascript or css
resources but not both. Some resources may be remote, that is, they're obtained by HTTP from a remote source
for further filtering. It is recommended to convert the external resources to local eliminating the overhead
of obtaining them.

.. code-block:: php

    <?php

    //These Javascripts are located in the page's bottom
    $js = $manager->collection('jsFooter');

As seen above, method addJs is used to add resources to the collection, the second parameter indicates
whether the resource is external or not and the third parameter indicates whether the resource should
be filtered or left as is:

.. code-block:: php

    <?php

    // This a remote resource that does not need filtering
    $js->addJs('code.jquery.com/jquery-1.10.0.min.js', true, false);

    // These are local resources that must be filtered
    $js->addJs('common-functions.js');
    $js->addJs('page-functions.js');

Filters are registered in the collection, multiple filters are allowed, content in resources are filtered
in the same order as filters were registered:

.. code-block:: php

    <?php

    //Use the built-in Jsmin filter
    $js->addFilter(new Phalcon\Assets\Filters\Jsmin());

    //Use a custom filter
    $js->addFilter(new MyApp\Assets\Filters\LicenseStamper());

Note that both built-in and custom filters can be transparently applied to collections.
Last step is decide if all the resources in the collection must be joined in a single file or serve each of them
individually. To tell the collection that all resources must be joined you can use the method 'join':

.. code-block:: php

    <?php

    // This a remote resource that does not need filtering
    $js->join(true);

    //The name of the final file path
    $js->setTargetPath('public/production/final.js');

    //The script html tag is generated with this URI
    $js->setTargetUri('production/final.js');

If resources are going to be joined, we need also to define which file will be used to store the resources
and which uri will be used to show it. These settings are set up with setTargetPath() and setTargetUri().

Built-In Filters
^^^^^^^^^^^^^^^^
Phalcon provides 2 built-in filters to minify both javascript and css respectively, their C-backend provide
the minimum overhead to perform this task:

+-----------------------------------+-----------------------------------------------------------------------------------------------------------+
| Filter                            | Description                                                                                               |
+===================================+===========================================================================================================+
| Phalcon\\Assets\\Filters\\Jsmin   | Minifies Javascript removing unnecessary characters that are ignored by Javascript interpreters/compilers |
+-----------------------------------+-----------------------------------------------------------------------------------------------------------+
| Phalcon\\Assets\\Filters\\Cssmin  | Minifies CSS removing unnecessary characters that are already ignored by browsers                         |
+-----------------------------------+-----------------------------------------------------------------------------------------------------------+

Custom Filters
^^^^^^^^^^^^^^
In addition to built-in filters, a developer can create his own filters. These can take advantage of existing
and more advanced tools like YUI_, Sass_, Closure_, etc.:

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

Usage:

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
