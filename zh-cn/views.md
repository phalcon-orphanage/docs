---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# 使用视图

Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application.

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) and [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) are responsible for the managing the view layer of your MVC application.

<a name='integrating-views-with-controllers'></a>

## 与控制器集成视图

Phalcon automatically passes the execution to the view component as soon as a particular controller has completed its cycle. The view component will look in the views folder for a folder named as the same name of the last controller executed and then for a file named as the last action executed. For instance, if a request is made to the URL *https://127.0.0.1/blog/posts/show/301*, Phalcon will parse the URL as follows:

| Server Address | 127.0.0.1 |
| -------------- | --------- |
| Phalcon 目录     | blog      |
| 控制器            | posts     |
| 操作             | show      |
| 参数             | 301       |

The dispatcher will look for a `PostsController` and its action `showAction`. A simple controller file for this example:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($postId)
    {
        // Pass the $postId parameter to the view
        $this->view->postId = $postId;
    }
}
```

The `setVar()` method allows us to create view variables on demand so that they can be used in the view template. The example above demonstrates how to pass the `$postId` parameter to the respective view template.

<a name='hierarchical-rendering'></a>

## 分层渲染

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) supports a hierarchy of files and is the default component for view rendering in Phalcon. This hierarchy allows for common layout points (commonly used views), as well as controller named folders defining respective view templates.

This component uses by default PHP itself as the template engine, therefore views should have the `.phtml` extension. If the views directory is *app/views* then view component will find automatically for these 3 view files.

| 名称                       | File                          | 描述                                                                                                |
| ------------------------ | ----------------------------- | ------------------------------------------------------------------------------------------------- |
| Action View（方法布局）        | app/views/posts/show.phtml    | This is the view related to the action. It only will be shown when the `show` action is executed. |
| Controller Layout（控制器布局） | app/views/layouts/posts.phtml | 这个视图于控制器相关联。 仅仅会在"posts"控制器中任何一个方法被触发后显现。 所有在这层布局中的代码实现会给在这个控制器下的所有方法重复使用。                        |
| Main Layout（主布局）         | app/views/index.phtml         | 这个视图于你的应用所关联。会在所有的控制器和方法执行后显现。                                                                    |

You are not required to implement all of the files mentioned above. [Phalcon\Mvc\View](api/Phalcon_Mvc_View) will simply move to the next view level in the hierarchy of files. If all three view files are implemented, they will be processed as follows:

```php
<!-- app/views/posts/show.phtml -->

<h3>This is show view!</h3>

<p>I have received the parameter <?php echo $postId; ?></p>
```

```php
<!-- app/views/layouts/posts.phtml -->

<h2>This is the "posts" controller layout!</h2>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Example</title>
    </head>
    <body>

        <h1>This is main layout!</h1>

        <?php echo $this->getContent(); ?>

    </body>
</html>
```

Note the lines where the method `$this->getContent()` was called. This method instructs [Phalcon\Mvc\View](api/Phalcon_Mvc_View) on where to inject the contents of the previous view executed in the hierarchy. For the example above, the output will be:

.. figure:: ../_static/img/views-1.png :align: center

The generated HTML by the request will be:

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Example</title>
    </head>
    <body>

        <h1>This is main layout!</h1>

        <!-- app/views/layouts/posts.phtml -->

        <h2>This is the "posts" controller layout!</h2>

        <!-- app/views/posts/show.phtml -->

        <h3>This is show view!</h3>

        <p>I have received the parameter 101</p>

    </body>
</html>
```

<a name='using-templates'></a>

### 使用模板

Templates are views that can be used to share common view code. They act as controller layouts, so you need to place them in the layouts directory.

Templates can be rendered before the layout (using `$this->view->setTemplateBefore()`) or they can be rendered after the layout (using `this->view->setTemplateAfter()`). In the following example the template (`layouts/common.phtml`) is rendered after the main layout (`layouts/posts.phtml`):

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('common');
    }

    public function lastAction()
    {
        $this->flash->notice(
            'These are the latest posts'
        );
    }
}
```

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Blog's title</title>
    </head>
    <body>
        <?php echo $this->getContent(); ?>
    </body>
</html>
```

```php
<!-- app/views/layouts/common.phtml -->

<ul class='menu'>
    <li><a href='/'>Home</a></li>
    <li><a href='/articles'>Articles</a></li>
    <li><a href='/contact'>Contact us</a></li>
</ul>

<div class='content'><?php echo $this->getContent(); ?></div>
```

```php
<!-- app/views/layouts/posts.phtml -->

<h1>Blog Title</h1>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/posts/last.phtml -->

<article>
    <h2>This is a title</h2>
    <p>This is the post content</p>
</article>

<article>
    <h2>This is another title</h2>
    <p>This is another post content</p>
</article>
```

The final output will be the following:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Blog's title</title>
    </head>
    <body>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Home</a></li>
            <li><a href='/articles'>Articles</a></li>
            <li><a href='/contact'>Contact us</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/layouts/posts.phtml -->

            <h1>Blog Title</h1>

            <!-- app/views/posts/last.phtml -->

            <article>
                <h2>This is a title</h2>
                <p>This is the post content</p>
            </article>

            <article>
                <h2>This is another title</h2>
                <p>This is another post content</p>
            </article>

        </div>

    </body>
</html>
```

If we had used `$this->view->setTemplateBefore('common')`, this would be the final output:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Blog's title</title>
    </head>
    <body>

        <!-- app/views/layouts/posts.phtml -->

        <h1>Blog Title</h1>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Home</a></li>
            <li><a href='/articles'>Articles</a></li>
            <li><a href='/contact'>Contact us</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/posts/last.phtml -->

            <article>
                <h2>This is a title</h2>
                <p>This is the post content</p>
            </article>

            <article>
                <h2>This is another title</h2>
                <p>This is another post content</p>
            </article>

        </div>

    </body>
</html>
```

<a name='control-rendering-levels'></a>

### 控制渲染等级

As seen above, [Phalcon\Mvc\View](api/Phalcon_Mvc_View) supports a view hierarchy. You might need to control the level of rendering produced by the view component. The method `Phalcon\Mvc\View::setRenderLevel()` offers this functionality.

This method can be invoked from the controller or from a superior view layer to interfere with the rendering process.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function findAction()
    {
        // 这是一个Ajax请求所以不去生成任何视图
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );

        // ...
    }

    public function showAction($postId)
    {
        // 仅展示于方法所关联的视图
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }
}
```

The available render levels are:

| 类常量                     | 描述                                                                    | 顺序 |
| ----------------------- | --------------------------------------------------------------------- |:--:|
| `LEVEL_NO_RENDER`       | 不生成任何视图                                                               |    |
| `LEVEL_ACTION_VIEW`     | 生成到于方法所关联的视图停止。                                                       | 1  |
| `LEVEL_BEFORE_TEMPLATE` | 生成到控制器布局之前的视图部分停止。                                                    | 2  |
| `LEVEL_LAYOUT`          | 生成到控制器布局停止。                                                           | 3  |
| `LEVEL_AFTER_TEMPLATE`  | 生成到控制器布局之后停止。                                                         | 4  |
| `LEVEL_MAIN_LAYOUT`     | Generates the presentation to the main layout. File views/index.phtml | 5  |

<a name='disabling-render-levels'></a>

### 禁用渲染等级

You can permanently or temporarily disable render levels. A level could be permanently disabled if it isn't used at all in the whole application:

```php
<?php

use Phalcon\Mvc\View;

$di->set(
    'view',
    function () {
        $view = new View();

        // 禁用多个层级
        $view->disableLevel(
            [
                View::LEVEL_LAYOUT      => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]
        );

        return $view;
    },
    true
);
```

Or disable temporarily in some part of the application:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function findAction()
    {
        $this->view->disableLevel(
            View::LEVEL_MAIN_LAYOUT
        );
    }
}
```

<a name='picking-views'></a>

### 选择视图

As mentioned above, when [Phalcon\Mvc\View](api/Phalcon_Mvc_View) is managed by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) the view rendered is the one related with the last controller and action executed. You could override this by using the `Phalcon\Mvc\View::pick()` method:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function listAction()
    {
        // 选择'views-dir/products/search'做为视图进行渲染
        $this->view->pick('products/search');

        // 选择'views-dir/books/list'做为视图进行渲染
        $this->view->pick(
            [
                'books',
            ]
        );

        // 选择'views-dir/products/search'做为视图进行渲染
        $this->view->pick(
            [
                1 => 'search',
            ]
        );
    }
}
```

<a name='disabling-view'></a>

### 禁用视图

If your controller does not produce any output in the view (or not even have one) you may disable the view component avoiding unnecessary processing:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // 关闭  sessino
        // ...

        // 禁用视图避免不必要的渲染
        $this->view->disable();
    }
}
```

Alternatively, you can return `false` to produce the same effect:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // ...

        // 禁用视图避免不必要的渲染
        return false;
    }
}
```

You can return a `response` object to avoid disable the view manually:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // 关闭  sessino
        // ...

        // HTTP重定向
        return $this->response->redirect('index/index');
    }
}
```

<a name='simple-rendering'></a>

## 简单渲染

[Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) is an alternative component to [Phalcon\Mvc\View](api/Phalcon_Mvc_View). It keeps most of the philosophy of [Phalcon\Mvc\View](api/Phalcon_Mvc_View) but lacks of a hierarchy of files which is, in fact, the main feature of its counterpart.

This component allows the developer to have control of when a view is rendered and its location. In addition, this component can leverage of view inheritance available in template engines such as `Volt` and others.

The default component must be replaced in the service container:

```php
<?php

use Phalcon\Mvc\View\Simple as SimpleView;

$di->set(
    'view',
    function () {
        $view = new SimpleView();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

Automatic rendering must be disabled in [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) (if needed):

```php
<?php

use Exception;
use Phalcon\Mvc\Application;

try {
    $application = new Application($di);

    $application->useImplicitView(false);

    $response = $application->handle();

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

To render a view it's necessary to call the render method explicitly indicating the relative path to the view you want to display:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {
        // 渲染'views-dir/index.phtml'
        echo $this->view->render('index');

        //  渲染'views-dir/posts/show.phtml'
        echo $this->view->render('posts/show');

        // 渲染'views-dir/index.phtml'并传递变量
        echo $this->view->render(
            'index',
            [
                'posts' => Posts::find(),
            ]
        );

        // 渲染'views-dir/posts/show.phtml'并传递变量
        echo $this->view->render(
            'posts/show',
            [
                'posts' => Posts::find(),
            ]
        );
    }
}
```

This is different to [Phalcon\Mvc\View](api/Phalcon_Mvc_View) who's `render()` method uses controllers and actions as parameters:

```php
<?php

$params = [
    'posts' => Posts::find(),
];

// Phalcon\Mvc\View
$view = new \Phalcon\Mvc\View();
echo $view->render('posts', 'show', $params);

// Phalcon\Mvc\View\Simple
$simpleView = new \Phalcon\Mvc\View\Simple();
echo $simpleView->render('posts/show', $params);
```

<a name='using-partials'></a>

## 使用层级

Partial templates are another way of breaking the rendering process into simpler more manageable chunks that can be reused by different parts of the application. With a partial, you can move the code for rendering a particular piece of a response to its own file.

One way to use partials is to treat them as the equivalent of subroutines: as a way to move details out of a view so that your code can be more easily understood. For example, you might have a view that looks like this:

```php
<div class='top'><?php $this->partial('shared/ad_banner'); ?></div>

<div class='content'>
    <h1>Robots</h1>

    <p>Check out our specials for robots:</p>
    ...
</div>

<div class='footer'><?php $this->partial('shared/footer'); ?></div>
```

The `partial()` method does accept a second parameter as an array of variables/parameters that only will exists in the scope of the partial:

```php
<?php $this->partial('shared/ad_banner', ['id' => $site->id, 'size' => 'big']); ?>
```

<a name='value-transfer'></a>

## 在控制器中把值传给视图

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) is available in each controller using the view variable (`$this->view`). You can use that object to set variables directly to the view from a controller action by using the `setVar()` method.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        $user  = Users::findFirst();
        $posts = $user->getPosts();

        // 传递username和posts到视图中
        $this->view->setVar('username', $user->username);
        $this->view->setVar('posts', $posts);

        // 使用魔法setter
        $this->view->username = $user->username;
        $this->view->posts    = $posts;

        // 一次传递多个变量
        $this->view->setVars(
            [
                'username' => $user->username,
                'posts'    => $posts,
            ]
        );
    }
}
```

A variable with the name of the first parameter of `setVar()` will be created in the view, ready to be used. The variable can be of any type, from a simple string, integer etc. variable to a more complex structure such as array, collection etc.

```php
<h1>
    {{ username }}'s Posts
</h1>

<div class='post'>
<?php

    foreach ($posts as $post) {
        echo '<h2>', $post->title, '</h2>';
    }

?>
</div>
```

<a name='caching-fragments'></a>

## 缓存视图片段

Sometimes when you develop dynamic websites and some areas of them are not updated very often, the output is exactly the same between requests. [Phalcon\Mvc\View](api/Phalcon_Mvc_View) offers caching a part or the whole rendered output to increase performance.

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) integrates with `Phalcon\Cache` to provide an easier way to cache output fragments. You could manually set the cache handler or set a global handler:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function showAction()
    {
        // 使用cache并为默认配置
        $this->view->cache(true);
    }

    public function showArticleAction()
    {
        // 缓存一个小时
        $this->view->cache(
            [
                'lifetime' => 3600,
            ]
        );
    }

    public function resumeAction()
    {
        // 缓存视图为1天并使用'resume-cache'做为key
        $this->view->cache(
            [
                'lifetime' => 86400,
                'key'      => 'resume-cache',
            ]
        );
    }

    public function downloadAction()
    {
        // 设置为自定义服务
        $this->view->cache(
            [
                'service'  => 'myCache',
                'lifetime' => 86400,
                'key'      => 'resume-cache',
            ]
        );
    }
}
```

When we do not define a key to the cache, the component automatically creates one using an [MD5](https://php.net/manual/en/function.md5.php) hash of the name of the controller and view currently being rendered in the format of `controller/view`. It is a good practice to define a key for each action so you can easily identify the cache associated with each view.

When the View component needs to cache something it will request a cache service from the services container. The service name convention for this service is `viewCache`:

```php
<?php

use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheBackend;

// 设置视图缓存服务
$di->set(
    'viewCache',
    function () {
        // 设置缓存数据为一天
        $frontCache = new OutputFrontend(
            [
                'lifetime' => 86400,
            ]
        );

        // memcached链接设置
        $cache = new MemcacheBackend(
            $frontCache,
            [
                'host' => 'localhost',
                'port' => '11211',
            ]
        );

        return $cache;
    }
);
```

<h5 class='alert alert-warning'>The frontend must always be <a href="api/Phalcon_Cache_Frontend_Output">Phalcon\Cache\Frontend\Output</a> and the service <code>viewCache</code> must be registered as always open (not shared) in the services container (DI). </h5>

When using views, caching can be used to prevent controllers from needing to generate view data on each request.

To achieve this we must identify uniquely each cache with a key. First we verify that the cache does not exist or has expired to make the calculations/queries to display data in the view:

```php
<?php

use Phalcon\Mvc\Controller;

class DownloadController extends Controller
{
    public function indexAction()
    {
        // 检查以'downloads'作为key的缓存是否存在或者已过期
        if ($this->view->getCache()->exists('downloads')) {
            // 查询最后的下载
            $latest = Downloads::find(
                [
                    'order' => 'created_at DESC',
                ]
            );

            $this->view->latest = $latest;
        }

        // 启用缓存并依然使用'downloads'做为key
        $this->view->cache(
            [
                'key' => 'downloads',
            ]
        );
    }
}
```

The [PHP alternative site](https://github.com/phalcon/php-site) is an example of implementing the caching of fragments.

<a name='template-engines'></a>

## 模板引擎

Template Engines help designers to create views without the use of a complicated syntax. Phalcon includes a powerful and fast templating engine called `Volt`. [Phalcon\Mvc\View](api/Phalcon_Mvc_View) allows you to use other template engines instead of plain PHP or Volt.

Using a different template engine, usually requires complex text parsing using external PHP libraries in order to generate the final output for the user. This usually increases the number of resources that your application will use.

If an external template engine is used, [Phalcon\Mvc\View](api/Phalcon_Mvc_View) provides exactly the same view hierarchy and it's still possible to access the API inside these templates with a little more effort.

This component uses adapters, these help Phalcon to speak with those external template engines in a unified way, let's see how to do that integration.

<a name='custom-template-engine'></a>

### 创建您自己的模板引擎适配器

There are many template engines, which you might want to integrate or create one of your own. The first step to start using an external template engine is create an adapter for it.

A template engine adapter is a class that acts as bridge between [Phalcon\Mvc\View](api/Phalcon_Mvc_View) and the template engine itself. Usually it only needs two methods implemented: `__construct()` and `render()`. The first one receives the [Phalcon\Mvc\View](api/Phalcon_Mvc_View) instance that creates the engine adapter and the DI container used by the application.

The method `render()` accepts an absolute path to the view file and the view parameters set using `$this->view->setVar()`. You could read or require it when it's necessary.

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Mvc\Engine;

class MyTemplateAdapter extends Engine
{
    /**
     * 构造适配器
     *
     * @param \Phalcon\Mvc\View $view
     * @param \Phalcon\Di $di
     */
    public function __construct($view, DiInterface $di)
    {
        // 初始化适配器
        parent::__construct($view, $di);
    }

    /**
     * 使用模版引擎渲染视图
     *
     * @param string $path
     * @param array $params
     */
    public function render($path, $params)
    {
        // 使用的视图
        $view = $this->_view;

        // 使用的选项
        $options = $this->_options;

        // 渲染视图
        // ...
    }
}
```

<a name='changing-template-engine'></a>

### 更改模板引擎

You can replace the template engine completely or use more than one template engine at the same time. The method `Phalcon\Mvc\View::registerEngines()` accepts an array containing data that define the template engines. The key of each engine is an extension that aids in distinguishing one from another. Template files related to the particular engine must have those extensions.

The order that the template engines are defined with `Phalcon\Mvc\View::registerEngines()` defines the relevance of execution. If [Phalcon\Mvc\View](api/Phalcon_Mvc_View) finds two views with the same name but different extensions, it will only render the first one.

If you want to register a template engine or a set of them for each request in the application. You could register it when the view service is created:

```php
<?php

use Phalcon\Mvc\View;

// 设置视图组建
$di->set(
    'view',
    function () {
        $view = new View();

        //  目录需要以/作为结尾
        $view->setViewsDir('../app/views/');

        // 设置引擎
        $view->registerEngines(
            [
                '.my-html' => 'MyTemplateAdapter',
            ]
        );

        // 设置多个引擎
        $view->registerEngines(
            [
                '.my-html' => 'MyTemplateAdapter',
                '.phtml'   => 'Phalcon\Mvc\View\Engine\Php',
            ]
        );

        return $view;
    },
    true
);
```

There are adapters available for several template engines on the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine)

<a name='injecting-services'></a>

## 在视图中注射服务

Every view executed is included inside a [Phalcon\Di\Injectable](api/Phalcon_Di_Injectable) instance, providing easy access to the application's service container.

The following example shows how to write a jQuery [ajax request](https://api.jquery.com/jQuery.ajax/) using a URL with the framework conventions. The service `url` (usually [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url)) is injected in the view by accessing a property with the same name:

```js
<script type='text/javascript'>

$.ajax({
    url: '<?php echo $this->url->get('cities/get'); ?>'
})
.done(function () {
    alert('Done!');
});

</script>
```

<a name='stand-alone'></a>

## 独立组件

All the components in Phalcon can be used as *glue* components individually because they are loosely coupled to each other:

<a name='stand-alone-hierarchical-rendering'></a>

### 分层渲染

Using [Phalcon\Mvc\View](api/Phalcon_Mvc_View) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

// 目录需要以/作为结尾
$view->setViewsDir('../app/views/');

// 给视图传递参数，它们会被作为View的属性
$view->setVar('someProducts', $products);
$view->setVar('someFeatureEnabled', true);

// 开始记录输出内容
$view->start();

// 渲染所有关于products/list.phtml的视图
$view->render('products', 'list');

// 输入记录的内容
$view->finish();

echo $view->getContent();
```

A short syntax is also available:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

echo $view->getRender(
    'products',
    'list',
    [
        'someProducts'       => $products,
        'someFeatureEnabled' => true,
    ],
    function ($view) {
        // 可以在这设置任何参数

        $view->setViewsDir('../app/views/');

        $view->setRenderLevel(
            View::LEVEL_LAYOUT
        );
    }
);
```

<a name='stand-alone-simple-rendering'></a>

### 简单渲染

Using [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View\Simple as SimpleView;

$view = new SimpleView();

// 目录需要以/作为结尾
$view->setViewsDir('../app/views/');

// 渲染一个视图并以字符串形式返回
echo $view->render('templates/welcomeMail');

// 渲染一个视图和参数并以字符串形式返回
echo $view->render(
    'templates/welcomeMail',
    [
        'email'   => $email,
        'content' => $content,
    ]
);
```

<a name='events'></a>

## 视图事件

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) and [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) are able to send events to an `EventsManager` if it is present. Events are triggered using the type `view`. 一些事件可以停止操作，当返回布尔值 false 时。 以下事件被支持︰

| 事件名称             | 触发器            | 可以停止操作吗？ |
| ---------------- | -------------- |:--------:|
| beforeRender     | 在开始渲染之前触发      |    是的    |
| beforeRenderView | 当开始渲染存在的视图之前触发 |    是的    |
| afterRenderView  | 当渲染存在的视图后触发    |    否     |
| afterRender      | 当渲染后触发         |    否     |
| notFoundView     | 当没有找到视图文件时触发   |    否     |

下面的示例演示如何将侦听器附加到此组件︰

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View;

$di->set(
    'view',
    function () {
        // 创建一个事件管理器
        $eventsManager = new EventsManager();

        // 监听'view'事件
        $eventsManager->attach(
            'view',
            function (Event $event, $view) {
                echo $event->getType(), ' - ', $view->getActiveRenderPath(), PHP_EOL;
            }
        );

        $view = new View();

        $view->setViewsDir('../app/views/');

        // 绑定管理器到视图组件
        $view->setEventsManager($eventsManager);

        return $view;
    },
    true
);
```

The following example shows how to create a plugin that cleans/repair the HTML produced by the render process using [Tidy](https://www.php.net/manual/en/book.tidy.php):

```php
<?php

use Phalcon\Events\Event;

class TidyPlugin
{
    public function afterRender(Event $event, $view)
    {
        $tidyConfig = [
            'clean'          => true,
            'output-xhtml'   => true,
            'show-body-only' => true,
            'wrap'           => 0,
        ];

        $tidy = tidy_parse_string(
            $view->getContent(),
            $tidyConfig,
            'UTF8'
        );

        $tidy->cleanRepair();

        $view->setContent(
            (string) $tidy
        );
    }
}

// 监听'view'事件
$eventsManager->attach(
    'view:afterRender',
    new TidyPlugin()
);
```