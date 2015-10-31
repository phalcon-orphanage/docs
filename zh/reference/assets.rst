资源文件管理（Assets Management）
=================================

:code:`Phalcon\Assets` 是一个让开发者管理静态资源的组件，如管理CSS，JavaScript等。

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` 存在于DI容器中，所以我们可以在服务容器存在的
任何地方使用它来添加/管理资源。

添加资源（Adding Resources）
----------------------------
Assets支持两个内置的资源管理器：css和javascripts.我们可以根据需要创建其它的资源。资源管理器内部保存了两类资源集合一为
JavaScript另一为CSS.

我们可以非常简单的向这两个集合里添加资源，如下：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function index()
        {
            // 添加本地CSS资源
            $this->assets
                ->addCss('css/style.css')
                ->addCss('css/index.css');

            // 添加本地JavaScript资源
            $this->assets
                ->addJs('js/jquery.js')
                ->addJs('js/bootstrap.min.js');
        }
    }

然后我们可以在视图中输出资源：

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>
            <?php $this->assets->outputCss() ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs() ?>
        </body>
    <html>

Volt语法：

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

本地与远程资源（Local/Remote resources）
----------------------------------------
本地资源是同一应用中的资源，这些资源存在于应用的根目录中。 :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` 用来生成
本地的url.

远程资源即是一种存在于CDN或其它远程服务器上的资源，比如常用的jQuery, Bootstrap等资源。

The second parameter of :code:`addCss()` and :code:`addJs()` says whether the resource is local or not (:code:`true` is local, :code:`false` is remote). By default, the assets manager will assume the resource is local:

.. code-block:: php

    <?php

    public function indexAction()
    {
        // 添加远程及本地资源
        $this->assets
            ->addCss('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css', false)
            ->addCss('css/style.css', true)
            ->addCss('css/extra.css');
    }

集合（Collections）
-------------------
集合即是把一同类的资源放在一些，资源管理器隐含的创建了两个集合：css和js. 当然我们可以创建其它的集合以归类其它的资源， 这样我们可以很容易的
在视图里显示：

.. code-block:: php

    <?php

    // HTML 头部的js资源
    $this->assets
        ->collection('header')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

    // HTML尾部的js资源
    $this->assets
        ->collection('footer')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

然后在视图中如下使用：

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>
            <?php $this->assets->outputJs('header') ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs('footer') ?>
        </body>
    <html>

Volt语法：

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>
            {{ assets.outputCss('header') }}
        </head>
        <body>

            <!-- ... -->

            {{ assets.outputJs('footer') }}
        </body>
    <html>

前缀（URL Prefixes）
--------------------
集合可以添加前缀，这可以实现非常简单的更换服务器：

.. code-block:: php

    <?php

    $scripts = $this->assets->collection('footer');

    if ($config->environment == 'development') {
        $scripts->setPrefix('/');
    } else {
        $scripts->setPrefix('http:://cdn.example.com/');
    }

    $scripts->addJs('js/jquery.js')
            ->addJs('js/bootstrap.min.js');

我们也可以使用链式语法，如下：

.. code-block:: php

    <?php

    $scripts = $assets
        ->collection('header')
        ->setPrefix('http://cdn.example.com/')
        ->setLocal(false)
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

压缩与过滤（Minification/Filtering）
------------------------------------
:code:`Phalcon\Assets` 提供了内置的js及css压缩工具。 开发者可以设定资源管理器以确定对哪些资源进行压缩啊些资源不进行压缩。除了上面这些之外
我们还可以使用Douglas Crockford书写的Jsmin压缩工具，及Ryan Day提供的CSSMin来对js及css文件进行压缩.
下面的例子中展示了如何使用集合对资源文件进行压缩：

.. code-block:: php

    <?php

    $manager

        // 这些javascript资源位于html文件的底部
        ->collection('jsFooter')

        // 最终输出名
        ->setTargetPath('final.js')

        // 使用此uri显示资源
        ->setTargetUri('production/final.js')

        // 添加远程资源但不压缩
        ->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false)

        // 这些资源必须要压缩
        ->addJs('common-functions.js')
        ->addJs('page-functions.js')

        // 把这些资源放入一个文件内
        ->join(true)

        // 使用内置的JsMin过滤器
        ->addFilter(new Phalcon\Assets\Filters\Jsmin())

        // 使用自定义过滤器
        ->addFilter(new MyApp\Assets\Filters\LicenseStamper());

开始部分我们通过资源管理器取得了一个命名的集合，集合中可以包含JavaScript或CSS资源但不能同时包含两个。一些资源可能位于远程的服务器上
这上结资源我们可以通过http取得。为了提高性能建议把远程的资源取到本地来，以减少加载远程资源的开销。

As seen above, the :code:`addJs()` method is used to add resources to the collection, the second parameter indicates
whether the resource is external or not and the third parameter indicates whether the resource should
be filtered or left as is:

.. code-block:: php

    <?php

    // 这些Javscript文件放在页面的底端
    $js = $manager->collection('jsFooter');

    // 添加远程资源但不压缩
    $js->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false);

    // These are local resources that must be filtered
    // 添加本地资源并压缩
    $js->addJs('common-functions.js');
    $js->addJs('page-functions.js');

过滤器被注册到集合内，我们可以注册我个过滤器，资源内容被过滤的顺序和过滤器注册的顺序是一样的。

.. code-block:: php

    <?php

    // 使用内置的Jsmin过滤器
    $js->addFilter(new Phalcon\Assets\Filters\Jsmin());

    // 使用自定义的过滤器
    $js->addFilter(new MyApp\Assets\Filters\LicenseStamper());

注意：不管是内置的还是自定义的过滤器对集合来说他们都是透明的。最后一步用来确定所有写到同一个文件中还是分开保存。如果要让集合中所有的文件合成
一个文件只需要使用join函数.

If resources are going to be joined, we need also to define which file will be used to store the resources
and which URI will be used to show it. These settings are set up with :code:`setTargetPath()` and :code:`setTargetUri()`:

.. code-block:: php

    <?php

    $js->join(true);

    // 设置最终输出文件
    $js->setTargetPath('public/production/final.js');

    // 使用此uri引用js
    $js->setTargetUri('production/final.js');

如果资源写入同一文件，则我们需要定义使用哪一个文件来保存要写入的资源数据，及使用一个ur来展示资源。这两个设置可以使用 :code:`setTargetPath()`
和 :code:`setTargetUri()` 两个函数来配置。

内置过滤器（Built-In Filters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Phalcon内置了两个过滤器以分别实现对JavaScript及CSS的压缩，由于二者是使用c实现的故极大的减少了性能上的开销：

+---------------------------------------------------------------------------------+----------------------------------------------------------------+
| 过滤器                                                                          | 说明                                                           |
+=================================================================================+================================================================+
| :doc:`Phalcon\\Assets\\Filters\\Jsmin <../api/Phalcon_Assets_Filters_Jsmin>`    | 压缩JavaScript文件即去除掉JavaScript解释器/编译器忽略的一些字符|
+---------------------------------------------------------------------------------+----------------------------------------------------------------+
| :doc:`Phalcon\\Assets\\Filters\\Cssmin <../api/Phalcon_Assets_Filters_Cssmin>`  | 压缩CSS文件即去除掉浏览器在渲染CSS时不需要的一些字符           |
+---------------------------------------------------------------------------------+----------------------------------------------------------------+

自定义过滤器（Custom Filters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
除了使用Phalcon内置的过滤器外，开发者还可以创建自己的过滤器。这样我们就可以使用 YUI_, Sass_, Closure_, 等。

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * 使用YUI过滤CSS内容
     *
     * @param string $contents
     * @return string
     */
    class CssYUICompressor implements FilterInterface
    {
        protected $_options;

        /**
         * CssYUICompressor 构造函数
         *
         * @param array $options
         */
        public function __construct($options)
        {
            $this->_options = $options;
        }

        /**
         * 执行过滤
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {
            // 保存字符吕内容到临时文件中
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

            // 返回文件内容
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }

用法:

.. code-block:: php

    <?php

    // 取CSS集合
    $css = $this->assets->get('head');

    // 添加/启用YUI压缩器
    $css->addFilter(
        new CssYUICompressor(
            array(
                'java-bin'      => '/usr/local/bin/java',
                'yui'           => '/some/path/yuicompressor-x.y.z.jar',
                'extra-options' => '--charset utf8'
            )
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

自定义输出（Custom Output）
---------------------------
:code:`outputJs()` 及 :code:`outputCss()` 方法可以依据不同的资源类来创建需要的HTML代码。我们可以重写这个方法或是手动的输出这些资源方法如下：

.. code-block:: php

    <?php

    use Phalcon\Tag;

    foreach ($this->assets->collection('js') as $resource) {
        echo Tag::javascriptInclude($resource->getPath());
    }

.. _YUI: http://yui.github.io/yuicompressor/
.. _Closure: https://developers.google.com/closure/compiler/?hl=fr
.. _Sass: http://sass-lang.com/
