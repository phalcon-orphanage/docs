<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-micro-application">创建一个微型的应用程序</a>
    </li>
    <li>
      <a href="#routing">路由</a> <ul>
        <li>
          <a href="#routing-setup">安装程序</a> <ul>
            <li>
              <a href="#routing-setup-application">应用程序对象</a>
            </li>
            <li>
              <a href="#routing-setup-router">路由对象</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#rewrite-rules">重定向规则</a>
        </li>
        <li>
          <a href="#routing-handlers">Handlers</a> <ul>
            <li>
              <a href="#routing-handlers-definitions">定义</a> <ul>
                <li>
                  <a href="#routing-handlers-anonymous-function">匿名函数</a>
                </li>
                <li>
                  <a href="#routing-handlers-function">函数</a>
                </li>
                <li>
                  <a href="#routing-handlers-static-method">静态方法</a>
                </li>
                <li>
                  <a href="#routing-handlers-object-method">对象中的方法</a>
                </li>
                <li>
                  <a href="#routing-handlers-controllers">控制器</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-controllers-lazy-loading">延迟加载</a> <ul>
                <li>
                  <a href="#routing-handlers-controllers-lazy-loading-use-case">使用案例</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-not-found">未找到 (404)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#routing-verbs">方法-动词</a> <ul>
            <li>
              <a href="#routing-verb-delete">delete</a>
            </li>
            <li>
              <a href="#routing-verb-get">get</a>
            </li>
            <li>
              <a href="#routing-verb-head">head</a>
            </li>
            <li>
              <a href="#routing-verb-map">map</a>
            </li>
            <li>
              <a href="#routing-verb-options">options</a>
            </li>
            <li>
              <a href="#routing-verb-patch">patch</a>
            </li>
            <li>
              <a href="#routing-verb-post">post</a>
            </li>
            <li>
              <a href="#routing-verb-put">put</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#routing-collections">集合</a>
        </li>
        <li>
          <a href="#routing-parameters">参数</a>
        </li>
        <li>
          <a href="#routing-redirections">重定向</a>
        </li>
        <li>
          <a href="#routing-urls-for-routes">用于路由的 Url</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#dependency-injector">依赖注入</a>
    </li>
    <li>
      <a href="#responses">响应</a> <ul>
        <li>
          <a href="#responses-direct-output">直接输出</a>
        </li>
        <li>
          <a href="#responses-include">包括其他文件</a>
        </li>
        <li>
          <a href="#responses-direct-output-json">直接输出 JSON</a>
        </li>
        <li>
          <a href="#responses-new-response-object">新响应对象</a>
        </li>
        <li>
          <a href="#responses-application-response">应用程序响应</a>
        </li>
        <li>
          <a href="#responses-return-application-response">返回应用程序响应</a>
        </li>
        <li>
          <a href="#responses-json">JSON</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#events">事件</a> <ul>
        <li>
          <a href="#events-available-events">可用的事件</a> <ul>
            <li>
              <a href="#events-available-events-authentication">身份验证示例</a>
            </li>
            <li>
              <a href="#events-available-events-not-found">未找到 示例</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#middleware">中间件</a> <ul>
        <li>
          <a href="#middleware-attached-events">附加的事件</a> <ul>
            <li>
              <a href="#middleware-attached-events-before">before</a>
            </li>
            <li>
              <a href="#middleware-attached-events-after">after</a>
            </li>
            <li>
              <a href="#middleware-attached-events-finish">finish</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#middleware-implementation">实现</a>
        </li>
        <li>
          <a href="#middleware-setup">设置</a>
        </li>
        <li>
          <a href="#middleware-events">在中间件中的事件</a> <ul>
            <li>
              <a href="#middleware-events-api">API 的示例</a> <ul>
                <li>
                  <a href="#middleware-events-api-firewall">防火墙中间件</a>
                </li>
                <li>
                  <a href="#middleware-events-api-not-found">找不到中间件</a>
                </li>
                <li>
                  <a href="#middleware-events-api-redirect">重定向中间件</a>
                </li>
                <li>
                  <a href="#middleware-events-api-cors">CORS 中间件</a>
                </li>
                <li>
                  <a href="#middleware-events-api-request">请求中间件</a>
                </li>
                <li>
                  <a href="#middleware-events-api-response">响应中间件</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#models">模型</a>
    </li>
    <li>
      <a href="#model-instances">注入模型实例</a>
    </li>
    <li>
      <a href="#views">视图</a>
    </li>
    <li>
      <a href="#error-handling">错误处理</a>
    </li>
  </ul>
</div>

# 微型应用

Phalcon 提供一个非常 '轻' 的应用，因此您可以用很少的的 PHP 代码创建 'Micro' 应用。

微应用程序，适合小的应用，这样会有很低的资源开销。 此类应用程序例如在我们的 [网站](https://github.com/phalcon/website)，这个网站 ([文档](https://github.com/phalcon/docs))、 我们 [存储](https://github.com/phalcon/store) Api，原型等。

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);

$app->handle();
```

<a name='creating-micro-applications'></a>

## 创建一个微型的应用程序

`Phalcon\Mvc\Micro` 类是负责创建一个微型的应用程序。

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>

## 路由

`Phalcon\Mvc\Micro` 应用程序中定义路由是很容易的。路由的定义如下：

```text
   Application -> (method/verb) -> (route url/regex, callable PHP function)
```

<a name='routing-setup'></a>

### 设置

路由是由 `Phalcon\Mvc\Router` 对象处理的。[[info](/[[language]]/[[version]]/routing)]

<h5 class='alert alert-warning'>路由必须总是以 <code>/</code> 开头</h5>

通常情况下，起始应用程序中是路线 `/`，并在大多数情况下它通过获取 HTTP 方法访问：

```php
<?php

// This is the start route
$app->get(
    '/',
    function () {
        echo '<h1>Welcome!</h1>';
    }
);
```

<a name='routing-setup-application'></a>

### 应用程序对象

可以按如下方式使用 `Phalcon\Mvc\Micro` 应用程序对象设置路由：

```php
use Phalcon\Mvc\Micro;

$app = new Micro();

// Matches a GET request
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

<a name='routing-setup-router'></a>

### 路由对象

您还可以创建 `Phalcon\Mvc\Router` 对象，那里设置路由，然后注射的依赖注入容器中。

```php
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Router;

$router = new Router();

$router->addGet(
    '/orders/display/{name}',
    'OrdersClass::display';
    }
);


$app = new Micro();
$app->setService('router', $router, true);
```

设置你的路由使用 `Phalcon\Mvc\Micro` 应用谓词方法 （`get`、 `post`、 等） 是比设置路由器对象与相关路路由，然后注射它在应用中容易得多。

每个方法有其优点和缺点。这一切取决于您的应用程序需求与设计。

<a name='rewrite-rules'></a>

## 伪静态规则

让路由正常工作，需要在您的 web 服务器配置为特定的站点配置特定的选项。

Those changes are outlined in the [rewrite rules](/[[language]]/[[version]]/rewrite-rules).

<a name='routing-handlers'></a>

## 处理程序

处理程序是代码的可调用段，得到附加到路由。 路由匹配匹配时，该处理程序执行已定义的所有参数。 处理程序是代码的任何可调用的 PHP 中存在。

<a name='routing-handlers-definitions'></a>

### 定义

Phalcon提供几种方法可以将处理程序附加到路由。您的应用需求和设计，以及编码风格会影响您选择的执行的因素。

<a name='routing-handlers-anonymous-function'></a>

#### 匿名函数

最后我们可以使用匿名函数 （如上图所示） 来处理该请求

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

访问匿名函数内部的 `$app` 对象可以通过注射它，如下所示：

```php
$app->get(
    '/orders/display/{name}',
    function ($name) use ($app) {
        $context = "<h1>This is order: {$name}!</h1>";
        $app->response->setContext($context);
        $app->response->send();
    }
);
```

<a name='routing-handlers-function'></a>

#### 函数

我们可以定义一个函数作为我们的处理程序并将其附加到 a 的特定路由。

```php
// With a function
function order_display($name) {
    echo "<h1>This is order: {$name}!</h1>";
}

$app->get(
    '/orders/display/{name}',
    'orders_display'
);
```

<a name='routing-handlers-static-method'></a>

#### 静态方法

如下，我们也可以使用静态方法作为我们的处理程序：

```php
class OrdersClass
{
    public static function display($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
}

$app->get(
    '/orders/display/{name}',
    'OrdersClass::display'
);
```

<a name='routing-handlers-object-method'></a>

#### 对象中的方法

我们还可以在对象中使用一种方法：

```php
class OrdersClass
{
    public function display($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
}

$orders = new OrdersClass();
$app->get(
    '/orders/display/{name}',
    [
        $orders,
        'display',
    ]
);
```

<a name='routing-handlers-controllers'></a>

#### 控制器

与 `Phalcon\Mvc\Micro`，您可以创建微型或介质的应用程序。 中小型应用程序使用微体系结构，但扩大上它能利用更多微但小于完整的应用程序。

在中小型应用程序中，您可以组织中控制器的处理程序。

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();

// Set the main handler. ie。 a controller instance
$orders->setHandler(new OrdersController());

// Set a common prefix for all routes
$orders->setPrefix('/orders');

// Use the method 'index' in OrdersController
$orders->get('/', 'index');

// Use the method 'show' in OrdersController
$orders->get('/display/{slug}', 'show');

$app->mount($orders);
```

`OrdersController` 可能如下所示：

```php
<?php

use Phalcon\Mvc\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        // ...
    }

    public function show($name)
    {
        // ...
    }
}
```

Since our controllers extend the `Phalcon\Mvc\Controller`, all the dependency injection services are available with their respective registration names. For example:

```php
<?php

use Phalcon\Mvc\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        // ...
    }

    public function show($name)
    {
        $context = "<h1>This is order: {$name}!</h1>";
        $this->response->setContext($context);

        return $this->response;
    }
}
```

<a name='routing-handlers-controllers-lazy-loading'></a>

### 延迟加载

In order to increase performance, you might consider implementing lazy loading for your controllers (handlers). The controller will be loaded only if the relevant route is matched.

时在你的 `Phalcon\Mvc\Micro\Collection` 中设置您的处理程序，就很容易实现延迟加载：

```php
$orders->setHandler('OrdersController', true);
$orders->setHandler('Blog\Controllers\OrdersController', true);
```

<a name='routing-handlers-controllers-lazy-loading-use-case'></a>

#### 使用案例

我们正在开发一个 API 的在线商店。 终结点是 `/ 用户`，`/ 订单` 和 `/ 产品`。 Each of those endpoints are registered using handlers, and each handler is a controller with relevant actions.

The controllers that we use as handlers are as follows:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function get($id)
    {
        // ...
    }

    public function add($payload)
    {
        // ...
    }
}

class OrdersController extends Controller
{
    public function get($id)
    {
        // ...
    }

    public function add($payload)
    {
        // ...
    }
}

class ProductsController extends Controller
{
    public function get($id)
    {
        // ...
    }

    public function add($payload)
    {
        // ...
    }
}
```

We register the handlers:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Users handler
$users = new MicroCollection();
$users->setHandler(new UsersController());
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Orders handler
$orders = new MicroCollection();
$orders->setHandler(new OrdersController());
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Products handler
$products = new MicroCollection();
$products->setHandler(new ProductsController());
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

This implementation loads each handler in turn and mounts it in our application object. The issue with this approach is that each request will result to only one endpoint and therefore one class method executed. The remaining methods/handlers will just remain in memory without being used.

Using lazy loading we reduce the number of objects loaded in memory and as a result our application uses less memory.

The above implementation changes if we want to use lazy loading as follows:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Users handler
$users = new MicroCollection();
$users->setHandler(new UsersController(), true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Orders handler
$orders = new MicroCollection();
$orders->setHandler(new OrdersController(), true);
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Products handler
$products = new MicroCollection();
$products->setHandler(new ProductsController(), true);
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

Using this simple change in implementation, all handlers remain uninstantiated until requested by a caller. Therefore whenever a caller requests `/orders/get/2`, our application will instantiate the `OrdersController` and call the `get` method in it. Our application now uses less resources than before.

<a name='routing-handlers-not-found'></a>

### Not found (404)

Any route that has not been matched in our `Phalcon\Mvc\Micro` application will cause it to try and execute the handler defined with the `notFound` method. Similar to other methods/verbs (`get`, `post` etc.), you can register a handler in the `notFound` method which can be any callable PHP function.

```php
<?php

$app->notFound(
    function () use ($app) {
        $app->response->setStatusCode(404, 'Not Found');
        $app->response->sendHeaders();

        $message = 'Nothing to see here. Move along....';
        $app->response->setContent($message);
        $app->response->send();
    }
);
```

You can also handle routes that have not been matched (404) with Middleware discussed below.

<a name='routing-verbs'></a>

## Methods - Verbs

The `Phalcon\Mvc\Micro` application provides a set of methods to bind the HTTP method with the route it is intended to.

<a name='routing-verbs-delete'></a>

### delete

Matches if the HTTP method is `DELETE` and the route is `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

<a name='routing-verbs-get'></a>

### get

Matches if the HTTP method is `GET` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-head'></a>

### head

Matches if the HTTP method is `HEAD` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-map'></a>

### map

Map allows you to attach the same endpoint to more than one HTTP method. The example below matches if the HTTP method is `GET` or `POST` and the route is `/repos/store/refs`

```php
    $app
        ->map(
            '/repos/store/refs',
            'action_product'
        )
        ->via(
            [
                'GET',
                'POST',
            ]
        );
```

<a name='routing-verbs-options'></a>

### options

Matches if the HTTP method is `OPTIONS` and the route is `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

<a name='routing-verbs-patch'></a>

### patch

Matches if the HTTP method is `PATCH` and the route is `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-verbs-post'></a>

### post

Matches if the HTTP method is `POST` and the route is `/api/products/add`

```php
    $app->post(
        '/api/products',
        'add_product'
    );
```

<a name='routing-verbs-put'></a>

### put

Matches if the HTTP method is `PUT` and the route is `/api/products/update/{id}`

```php
    $app->put(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-collections'></a>

## Collections

Collections are a handy way to group collections attached to a handler and a common prefix (if needed). For a hypothetical `/orders` endpoint we could have the following endpoints:

    /orders/get/{id}
    /orders/add/{payload}
    /orders/update/{id}
    /orders/delete/{id}
    

All of those routes are handled by our `OrdersController`. We set up our routes with a collection as follows:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();
$orders->setHandler(new OrdersController());

$orders->setPrefix('/orders');

$orders->get('/get/{id}', 'displayAction');
$orders->get('/add/{payload}', 'addAction');
$orders->get('/update/{id}', 'updateAction');
$orders->get('/delete/{id}', 'deleteAction');

$app->mount($orders);
```

<h5 class='alert alert-warning'>The name that we bind each route has a suffix of <code>Action</code>. This is not necessary, your method can be called anything you like.</h5>

<a name='routing-parameters'></a>

## Parameters

We have briefly seen above how parameters are defined in the routes. Parameters are set in a route string by enclosing the name of the parameter in brackets.

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

We can also enforce certain rules for each parameter by using regular expressions. The regular expression is set after the name of the parameter, separating it with `:`.

```php
// Match the order id
$app->get(
    '/orders/display/{id:[0-9]+}',
    function ($id) {
        echo "<h1>This is order: #{$id}!</h1>";
    }
);

// Match a numeric (4) year and a title (alpha)
$app->get(
    '/posts/{year:[0-9][4]}/{title:[a-zA-Z\-]+}',
    function ($year, $title) {
        echo '<h1>Title: $title</h1>';
        echo '<h2>Year: $year</h2>';
    }
);
```

Additional information: `Phalcon\Mvc\Router` [Info](/[[language]]/[[version]]/routing)

<a name='routing-redirections'></a>

## Redirections

You can redirect one matched route to another using the `Phalcon\Http\Response` object, just like in a full application.

```php
$app->post('/old/url',
    function () use ($app) {
        $app->response->redirect('new/url');
        $app->response->sendHeaders();
    }
);

$app->post('/new/welcome',
    function () use ($app) {
        echo 'This is the new Welcome';
    }
);
```

**Note** we have to pass the `$app` object in our anonymous function to have access to the `request` object.

When using controllers as handlers, you can perform the redirect just as easy:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function oldget($id)
    {
        return $this->response->redirect('users/get/' . $id);
    }

    public function get($id)
    {
        // ...
    }
}
```

Finally, you can perform redirections in your middleware (if you are using it). An example is below in the relevant section.

<a name='routing-urls-for-routes'></a>

## URLs for Routes

Another feature of the routes is setting up named routes and generating URLs for those routes. This is a two step process. * First we need to name our route. This can be achieved with the `setName()` method that is exposed from the methods/verbs in our application (`get`, `post`, etc.);

```php
// Set a route with the name 'show-order'
$app
    ->get(
        '/orders/display/{id}',
        function ($id) use ($app) {
            // ... Find the order and show it
        }
    )
    ->setName('show-order');
```

- We need to use the `Phalcon\Mvc\Url` component to generate URLs for the named routes.

```php
// Use the named route and produce a URL from it
$app->get(
    '/',
    function () use ($app) {
        $url = sprintf(
            '<a href="%s">Show the order</a>',
            $app->url->get(
                [
                    'for' => 'show-order',
                    'id'  => 1234,
                ]
            )
        );

        echo $url;
    }
);
```

<a name='dependency-injector'></a>

# Dependency Injector

When a micro application is created, a `Phalcon\Di\FactoryDefault` services container is create implicitly.

```php
<?php

use Phalcon\Mvc\Micro;
$app = new Micro();

$app->get(
    '/',
    function () use ($app) {
        $app->response->setContent('Hello!!');
        $app->response->send();
    }
);
```

You can also create a Di container yourself, and assign it to the micro application, therefore manipulating the services depending on the needs of your application.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Config\Adapter\Ini as IniConfig;

$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        return new IniConfig('config.ini');
    }
);

$app = new Micro();

$app->setDI($di);

$app->get(
    '/',
    function () use ($app) {
        // Read a setting from the config
        echo $app->config->app_name;
    }
);

$app->post(
    '/contact',
    function () use ($app) {
        $app->flash->success('What are you doing Dave?');
    }
);
```

You can also use the array syntax to register services in the dependency injection container from the application object:

```php
<br /><?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

$app = new Micro();

// Setup the database service
$app['db'] = function () {
    return new MysqlAdapter(
        [
            'host'     => 'localhost',
            'username' => 'root',
            'password' => 'secret',
            'dbname'   => 'test_db',
        ]
    );
};

$app->get(
    '/blog',
    function () use ($app) {
        $news = $app['db']->query('SELECT * FROM news');

        foreach ($news as $new) {
            echo $new->title;
        }
    }
);
```

<a name='responses'></a>

# Responses

A micro application can return many different types of responses. Direct output, use a template engine, calculated data, view based data, JSON etc.

Handlers may return raw responses using plain text, `Phalcon\Http\Response` object or a custom built component that implements the `Phalcon\Http\ResponseInterface`.

<a name='responses-direct-output'></a>

## Direct output

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

<a name='responses-include'></a>

## Including another file

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        require 'views/results.php';
    }
);
```

<a name='responses-direct-output-json'></a>

## Direct output JSON

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo json_encode(
            [
                'code' => 200,
                'name' => $name,
            ]
        );
    }
);
```

<a name='responses-new-response-object'></a>

## New Response object

You can use the `setContent` method of the response object to return the response back:

```php
$app->get(
    '/show/data',
    function () {
        // Create a response
        $response = new Phalcon\Http\Response();

        // Set the Content-Type header
        $response->setContentType('text/plain');

        // Pass the content of a file
        $response->setContent(file_get_contents('data.txt'));

        // Return the response
        return $response;
    }
);
```

<a name='responses-application-response'></a>

## Application Response

You can also use the `Phalcon\Http\Response` object to return responses to the caller. The response object has a lot of useful methods that make returning respones much easier.

```php
$app->get(
    '/show/data',
    function () use ($app) {
        // Set the Content-Type header
        $app->response->setContentType('text/plain');
        $app->response->sendHeaders();

        // Print a file
        readfile('data.txt');
    }
);
```

<a name='responses-return-application-response'></a>

## Return Application Response

A different approach returning data back to the caller is to return the response object directly from the application. When responses are returned by handlers they are automatically sent by the application.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$app = new Micro();

// Return a response
$app->get(
    '/welcome/index',
    function () {
        $response = new Response();

        $response->setStatusCode(401, 'Unauthorized');
        $response->setContent('Access is not authorized');

        return $response;
    }
);
```

<a name='responses-json'></a>

## JSON

JSON can be sent back just as easy using the `Phalcon\Http\Response` object:

```php
$app->get(
    '/welcome/index',
    function () use ($app) {

        $data = [
            'code'    => 401,
            'status'  => 'error',
            'message' => 'Unauthorized access',
            'payload' => [],
        ];

        $response->setJsonContent($data);

        return $response;
    }
);
```

<a name='events'></a>

# Events

A `Phalcon\Mvc\Micro` application works closely with a `Phalcon\Events\Manager` if it is present, to trigger events that can be used throughout our application. The type of those events is `micro`. These events trigger in our application and can be attached to relevant handlers that will perform actions needed by our application.

<a name='events-available-events'></a>

## Available events

The following events are supported:

| Event Name         | Triggered                                                         | Can stop operation? |
| ------------------ | ----------------------------------------------------------------- |:-------------------:|
| beforeHandleRoute  | Main method called; Routes have not been checked yet              |         Yes         |
| beforeExecuteRoute | Route matched, Handler valid, Handler has not been executed yet   |         Yes         |
| afterExecuteRoute  | Handler just finished running                                     |         No          |
| beforeNotFound     | Route has not been found                                          |         Yes         |
| afterHandleRoute   | Route just finished executing                                     |         Yes         |
| afterBinding       | Triggered after models are bound but before executing the handler |         Yes         |

<a name='events-available-events-authentication'></a>

### Authentication example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Create a events manager
$eventsManager = new EventsManager();

$eventsManager->attach(
    'micro:beforeExecuteRoute',
    function (Event $event, $app) {
        if ($app->session->get('auth') === false) {
            $app->flashSession->error("The user isn't authenticated");

            $app->response->redirect('/');
            $app->response->sendHeaders();

            // Return (false) stop the operation
            return false;
        }
    }
);

$app = new Micro();

// Bind the events manager to the app
$app->setEventsManager($eventsManager);
```

<a name='events-available-events-not-found'></a>

### Not found example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Create a events manager
$eventsManager = new EventsManager();

$eventsManager->attach(
    'micro:beforeNotFound',
    function (Event $event, $app) {
        $app->response->redirect('/404');
        $app->response->sendHeaders();

        return $app->response;
    }
);

$app = new Micro();

// Bind the events manager to the app
$app->setEventsManager($eventsManager);
```

<a name='middleware'></a>

# Middleware

Middleware are classes that can be attached to your application and introduce another layer where business logic can exist. They run sequentially, according to the order they are registered and not only improve mainainability, by encapsulating specific functionality, but also performance. A middleware class can stop execution when a particular business rule has not been satisfied, thus allowing the application to exit early without executing the full cycle of a request.

The presence of a `Phalcon\Events\Manager` is essential for middleware to operate, so it has to be registered in our Di container.

<a name='middleware-attached-events'></a>

## Attached events

Middleware can be attached to a micro application in 3 different events. Those are:

| Event  | Description                                    |
| ------ | ---------------------------------------------- |
| before | Before the handler has been executed           |
| after  | After the handler has been executed            |
| final  | After the response has been sent to the caller |

<h5 class='alert alert-warning'>You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.</h5>

<a name='middleware-attached-events-before'></a>

### before

This event is perfect for stopping execution of the application if certain criteria is not met. In the below example we are checking if the user has been authenticated and stop execution with the necessary redirect.

```php
<?php

$app = new Phalcon\Mvc\Micro();

// Executed before every route is executed
// Return false cancels the route execution
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("The user isn't authenticated");

            $app['response']->redirect('/error');

            // Return false stops the normal execution
            return false;
        }

        return true;
    }
);
```

<a name='middleware-attached-events-after'></a>

### after

This event can be used to manipulate data or perform actions that are needed after the handler has finished executing. In the example below, we manipulate our response to send JSON back to the caller.

```php
$app->map(
    '/api/robots',
    function () {
        return [
            'status' => 'OK',
        ];
    }
);

$app->after(
    function () use ($app) {
        // This is executed after the route is executed
        echo json_encode($app->getReturnedValue());
    }
);
```

<a name='middleware-attached-events-finish'></a>

### finish

This even will fire up when the whole request cycle has been completed. In the example below, we use it to clean up some cache files.

```php
$app->finish(
    function () use ($app) {
        if (true === file_exists('/tmp/processing.cache')) {
            unlink('/tmp/processing.cache');
        }
    }
);
```

<a name='middleware-setup'></a>

## Setup

Attaching middleware to your application is very easy as shown above, with the `before`, `after` and `finish` method calls.

```php
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("The user isn't authenticated");

            $app['response']->redirect('/error');

            // Return false stops the normal execution
            return false;
        }

        return true;
    }
);

$app->after(
    function () use ($app) {
        // This is executed after the route is executed
        echo json_encode($app->getReturnedValue());
    }
);
```

Attaching middleware to your application as classes and having it listen to events from the events manager can be achieved as follows:

```php
<?php

use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;

use Website\Middleware\CacheMiddleware;
use Website\Middleware\NotFoundMiddleware;
use Website\Middleware\ResponseMiddleware;

/**
 * Create a new Events Manager.
 */
$eventsManager = new Manager();
$application   = new Micro();

/**
 * Attach the middleware both to the events manager and the application
 */
$eventsManager->attach('micro', new CacheMiddleware());
$application->before(new CacheMiddleware());

$eventsManager->attach('micro', new NotFoundMiddleware());
$application->before(new NotFoundMiddleware());

/**
 * This one needs to listen on the `after` event
 */
$eventsManager->attach('micro', new ResponseMiddleware());
$application->after(new ResponseMiddleware());

/**
 * Make sure our events manager is in the DI container now
 */
$application->setEventsManager($eventsManager);

```

We need a `Phalcon\Events\Manager` object. This can be a newly instantiated object or we can get the one that exists in our DI container (if you have used the `FactoryDefault` one).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

We then attach the middleware class in our application on one of the three listening events discussed above (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Implementation

Middleware can be any kind of PHP callable functions. You can organize your code whichever way you like it to implement middleware. If you choose to use classes for your middleware, you will need them to implement the `Phalcon\Mvc\Micro\MiddlewareInterface`

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CacheMiddleware
 *
 * Caches pages to reduce processing
 */
class CacheMiddleware implements MiddlewareInterface
{
    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        $cache  = $application['cache'];
        $router = $application['router'];

        $key = preg_replace('/^[a-zA-Z0-9]/', '', $router->getRewriteUri());

        // Check if the request is cached
        if ($cache->exists($key)) {
            echo $cache->get($key);

            return false;
        }

        return true;
    }
}
```

<a name='middleware-events'></a>

## Events in Middleware

The [events](#events) that are triggered for our application also trigger inside a class that implements the `Phalcon\Mvc\Micro\MiddlewareInterface`. This offers great flexibility and power for developers since we can interact with the request process.

<a name='middleware-events-api'></a>

### API example

Assume that we have an API that we have implemented with the Micro application. We will need to attach different Middleware classes in the application so that we can better control the execution of the application.

The middleware that we will use are: * Firewall * NotFound * Redirect * CORS * Request * Response

<a name='middleware-events-api-firewall'></a>

#### Firewall Middleware

This middleware is attached to the `before` event of our Micro application. The purpose of this middleware is to check who is calling our API and based on a whitelist, allow them to proceed or not

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * FirewallMiddleware
 *
 * Checks the whitelist and allows clients or not
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        $whitelist = [
            '10.4.6.1',
            '10.4.6.2',
            '10.4.6.3',
            '10.4.6.4',
        ];
        $ipAddress = $application->request->getClientAddress();

        if (true !== array_key_exists($ipAddress, $whitelist)) {
            $this->response->redirect('/401');
            $this->response->send();

            return false;
        }

        return true;
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

<a name='middleware-events-api-not-found'></a>

#### Not Found Middleware

When this middleware is processed, this means that the requesting IP is allowed to access our application. The application will try and match the route and if not found the `beforeNotFound` event will fire. We will stop the processing then and send back to the user the relevant 404 response. This middleware is attached to the `before` event of our Micro application

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * NotFoundMiddleware
 *
 * Processes the 404s
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * The route has not been found
     *
     * @returns bool
     */
    public function beforeNotFound()
    {
        $this->response->redirect('/404');
        $this->response->send();

        return false;
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

<a name='middleware-events-api-redirect'></a>

#### Redirect Middleware

We attach this middleware again to the `before` event of our Micro application because we don't want the request to proceed if the requested endpoint needs to be redirected.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RedirectMiddleware
 *
 * Checks the request and redirects the user somewhere else if need be
 */
class RedirectMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        if ('github' === $application->request->getURI()) {
            $application->response->redirect('https://github.com');
            $application->response->send();

            return false;
        }

        return true;
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

<a name='middleware-events-api-cors'></a>

#### CORS Middleware

Again this middleware is attached to the `before` event of our Micro application. We need to ensure that it fires before anything happens with our application

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CORSMiddleware
 *
 * CORS checking
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        if ($application->request->getHeader('ORIGIN')) {
            $origin = $application->request->getHeader('ORIGIN');
        } else {
            $origin = '*';
        }

        $application
            ->response
            ->setHeader('Access-Control-Allow-Origin', $origin)
            ->setHeader(
                'Access-Control-Allow-Methods',
                'GET,PUT,POST,DELETE,OPTIONS'
            )
            ->setHeader(
                'Access-Control-Allow-Headers',
                'Origin, X-Requested-With, Content-Range, ' .
                'Content-Disposition, Content-Type, Authorization'
            )
            ->setHeader('Access-Control-Allow-Credentials', 'true');
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

<a name='middleware-events-api-request'></a>

#### Request Middleware

This middleware is receiving a JSON payload and checks it. If the JSON payload is not valid it will stop execution.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RequestMiddleware
 *
 * Check incoming payload
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * Before the route is executed
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeExecuteRoute(Event $event, Micro $application)
    {
        json_decode($application->request->getRawBody());
        if (JSON_ERROR_NONE !== json_last_error()) {
            $application->response->redirect('/malformed');
            $application->response->send();

            return false;
        }

        return true;

    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

<a name='middleware-events-api-response'></a>

#### Response Middleware

This middleware is responsible for manipulating our response and sending it back to the caller as a JSON string. Therefore we need to attach it to the `after` event of our Micro application.

<h5 class='alert alert-warning'>We are going to be using the <code>call</code> method for this middleware, since we have nearly executed the whole request cycle.</h5>

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
* ResponseMiddleware
*
* Manipulates the response
*/
class ResponseMiddleware implements MiddlewareInterface
{
     /**
      * Before anything happens
      *
      * @param Micro $application
      *
      * @returns bool
      */
    public function call(Micro $application)
    {
        $payload = [
            'code'    => 200,
            'status'  => 'success',
            'message' => '',
            'payload' => $application->getReturnedValue(),
        ];

        $application->response->setJsonContent($payload);
        $application->response->send();

        return true;
    }
}
```

<a name='models'></a>

# Models

Models can be used in Micro applications, so long as we instruct the application how it can find the relevant classes with an autoloader.

<h5 class='alert alert-warning'>The relevant <code>db</code> service must be registered in your Di container.</h5>

```php
<?php

$loader = new \Phalcon\Loader();
$loader
    ->registerDirs(
        [
            __DIR__ . '/models/',
        ]
    )
    ->register();

$app = new \Phalcon\Mvc\Micro();

$app->get(
    '/products/find',
    function () {
        $products = \MyModels\Products::find();

        foreach ($products as $product) {
            echo $product->name, '<br>';
        }
    }
);

$app->handle();
```

<a name='model-instances'></a>

# Inject model instances

By using the `Phalcon\Mvc\Model\Binder` class you can inject model instances into your routes:

```php
<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        __DIR__ . '/models/',
    ]
)->register();

$app = new \Phalcon\Mvc\Micro();
$app->setModelBinder(new \Phalcon\Mvc\Model\Binder());

$app->get(
    "/products/{product:[0-9]+}",
    function (Products $product) {
        // do anything with $product object
    }
);

$app->handle();
```

Since Binder object is using internally Reflection Api which can be heavy, there is ability to set a cache so as to speed up the process. This can be done by using the second argument of `setModelBinder()` which can also accept a service name or just by passing a cache instance to the `Binder` constructor.

Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/products/1`.

<a name='views'></a>

# Views

`Phalcon\Mvc\Micro` does not have inherently a view service. We can however use the `Phalcon\Mvc\View\Simple` component to render views.

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();

    $view->setViewsDir('app/views/');

    return $view;
};

// Return a rendered view
$app->get(
    '/products/show',
    function () use ($app) {
        // Render app/views/products/show.phtml passing some variables
        echo $app['view']->render(
            'products/show',
            [
                'id'   => 100,
                'name' => 'Artichoke',
            ]
        );
    }
);
```

<h5 class='alert alert-warning'>The above example uses the <code>Phalcon\Mvc\View\Simple</code> component, which uses relative paths instead of controllers and actions. You can use the <code>Phalcon\Mvc\View</code> component instead, but to do so you will need to change the parameters passed to <code>render()</code></h5>

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View();

    $view->setViewsDir('app/views/');

    return $view;
};

// Return a rendered view
$app->get(
    '/products/show',
    function () use ($app) {
        // Render app/views/products/show.phtml passing some variables
        echo $app['view']->render(
            'products',
            'show',
            [
                'id'   => 100,
                'name' => 'Artichoke',
            ]
        );
    }
);
```

<a name='error-handling'></a>

# Error Handling

The `Phalcon\Mvc\Micro` application also has an `error` method, which can be used to trap any errors that originate from exceptions. The following code snippet shows basic usage of this feature:

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app->get(
    '/',
    function () {
        throw new \Exception('Some error happened', 401);
    }
);

$app->error(
    function ($exception) {
        echo json_encode(
            [
                'code'    => $exception->getCode(),
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]
        );
    }
);
```