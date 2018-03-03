<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-micro-application">Creating a Micro Application</a>
    </li>
    <li>
      <a href="#routing">Routing</a> 
      <ul>
        <li>
          <a href="#routing-setup">Setup</a> 
          <ul>
            <li>
              <a href="#routing-setup-application">Application object</a>
            </li>
            <li>
              <a href="#routing-setup-router">Router object</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#rewrite-rules">Rewrite Rules</a>
        </li>
        <li>
          <a href="#routing-handlers">Handlers</a> <ul>
            <li>
              <a href="#routing-handlers-definitions">Definitions</a> 
              <ul>
                <li>
                  <a href="#routing-handlers-anonymous-function">Anonymous Function</a>
                </li>
                <li>
                  <a href="#routing-handlers-function">Function</a>
                </li>
                <li>
                  <a href="#routing-handlers-static-method">Static Method</a>
                </li>
                <li>
                  <a href="#routing-handlers-object-method">Method in an Object</a>
                </li>
                <li>
                  <a href="#routing-handlers-controllers">Controllers</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-controllers-lazy-loading">Lazy Loading</a> 
              <ul>
                <li>
                  <a href="#routing-handlers-controllers-lazy-loading-use-case">Use case</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-not-found">Not Found (404)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#routing-verbs">Methods - Verbs</a> 
          <ul>
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
          <a href="#routing-collections">Collections</a>
        </li>
        <li>
          <a href="#routing-parameters">Parameters</a>
        </li>
        <li>
          <a href="#routing-redirections">Redirections</a>
        </li>
        <li>
          <a href="#routing-urls-for-routes">URLs for Routes</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#dependency-injector">Dependency Injector</a>
    </li>
    <li>
      <a href="#responses">Responses</a> 
      <ul>
        <li>
          <a href="#responses-direct-output">Direct output</a>
        </li>
        <li>
          <a href="#responses-include">Including another file</a>
        </li>
        <li>
          <a href="#responses-direct-output-json">Direct output JSON</a>
        </li>
        <li>
          <a href="#responses-new-response-object">New Response object</a>
        </li>
        <li>
          <a href="#responses-application-response">Application Response</a>
        </li>
        <li>
          <a href="#responses-return-application-response">Return Application Response</a>
        </li>
        <li>
          <a href="#responses-json">JSON</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#events">Events</a> 
      <ul>
        <li>
          <a href="#events-available-events">Available events</a> <ul>
            <li>
              <a href="#events-available-events-authentication">Authentication example</a>
            </li>
            <li>
              <a href="#events-available-events-not-found">Not found example</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#middleware">Middleware</a> <ul>
        <li>
          <a href="#middleware-attached-events">Attached events</a> 
          <ul>
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
          <a href="#middleware-implementation">Implementation</a>
        </li>
        <li>
          <a href="#middleware-setup">Setup</a>
        </li>
        <li>
          <a href="#middleware-events">Events in Middleware</a> 
          <ul>
            <li>
              <a href="#middleware-events-api">API example</a> 
              <ul>
                <li>
                  <a href="#middleware-events-api-firewall">Firewall Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-not-found">Not Found Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-redirect">Redirect Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-cors">CORS Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-request">Request Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-response">Response Middleware</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#models">Models</a>
    </li>
    <li>
      <a href="#model-instances">Injecting Model Instances</a>
    </li>
    <li>
      <a href="#views">Views</a>
    </li>
    <li>
      <a href="#error-handling">Error Handling</a>
    </li>
  </ul>
</div>

# Micro Applications

Phalcon offers a very 'thin' application, so that you can create 'Micro' applications with minimal PHP code.

Micro applications are suitable for small applications that will have very low overhead. Such applications are for instance our [website](https://github.com/phalcon/website), this website ([docs](https://github.com/phalcon/docs)), our [store](https://github.com/phalcon/store), APIs, prototypes etc.

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

## Creating a Micro Application

The `Phalcon\Mvc\Micro` class is the one responsible for creating a Micro application.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>

## Routing

Defining routes in a `Phalcon\Mvc\Micro` application is very easy. Routes are defined as follows:

```text
   Application -> (method/verb) -> (route url/regex, callable PHP function)
```

<a name='routing-setup'></a>

### Setup

Routing is handled by the `Phalcon\Mvc\Router` object. [[Info](/[[language]]/[[version]]/routing)]

<div class="alert alert-danger">
    <p>
        مسیرها همیشه باید با شروع شوند<code>/</code>
    </p>
</div>

معمولا، مسیر شروع در یک نرم افزار، نشانه ی `/`می باشد، و در بیشتر موارد، با روش گت اچ تی تی پی قابل دسترسی است:

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

### Application object

مسیرها را میتوان با استفاده از `phalcon/Mvc/Micro`در برنامه مورد نظر تنظیم کرد همانند زیر:

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

### Router object

شما همچنین میتوانید یک هدف `Phalcon\Mvc\Router`ایجاد کنید، مسیرها را در آن مشخص کنید و سپس آن را به مخزن اماله وابستگی انتقال دهید.

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

تنظیم کردن مسیرها با استفاده از `Phalcon\Mvc\Micro` و روش های فعلی برنامه ها (`دریافت<code> ،`پست</code> و غیره) بسیار آسان تر است از آنکه یک جسم مسیریاب با مسیر های مربوطه تنظیم کنیم و سپس آن را به برنامه انتقال دهیم.

هر روشی مزایا و معایب خود را دارد. این بستگی به طراحی و نیازهای نرم افزار شما دارد.

<a name='rewrite-rules'></a>

## Rewrite Rules

برای کارآیی مسیرها، باید تغییرات پیکر بندی مشخصی در پیکر بندی وب سرور برای سایت مخصوص خود ایجاد کنید.

Those changes are outlined in the [Apache Rewrite Rules](http://httpd.apache.org/docs/current/rewrite/) and [NGINX Rewrite Rules](https://www.nginx.com/blog/creating-nginx-rewrite-rules/).

<a name='routing-handlers'></a>

## Handlers

هندلرها، قطعات قابل خواندن از کدی هستند که به مسیر ضمیمه شده است. هنگامیکه مسیر مطابقت میکند، هندلر با همه ی پارامتر های تعریف شده، عمل میکند. هندلر هر قطعه قابل خواندن است که در پی اچ پی وجود دارد.

<a name='routing-handlers-definitions'></a>

### Definitions

فالکون چندین راه را برای ضمیمه کردن هندلر به یک مسیر پیشنهاد می دهد. نیاز ها و طراحی نرم افزار شما همچنین سبک برنامه نویسی که دارید فاکتور هایی هستند که بر انتخاب اجرایی شما تاثیر گذارند.

<a name='routing-handlers-anonymous-function'></a>

#### Anonymous Function

نهایتا ما میتوانیم از یک عملکرد مبهم (همانطور که در بالا دیدید) برای رسیدگی به درخواست استفاده کنیم

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

دسترسی به `$app` در درون یک عملکرد مبهم می تواند با انتقال آن به ترتیبی که در زیر گفته میشود، به دست آید:

```php
$app->get(
    '/orders/display/{name}',
    function ($name) use ($app) {
        $content = "<h1>This is order: {$name}!</h1>";
        $app->response->setContent($content);
        $app->response->send();
    }
);
```

<a name='routing-handlers-function'></a>

#### Function

ما می توانیم عملکردی را به عنوان هندلر تعریف کنیم و آن را به مسیر خاص ضمیمه کنیم.

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

#### Static Method

همچنین می توانیم از متد ایستایی به عنوان هندلر خود به صورت زیر استفاده کنیم:

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

#### Method in an Object

همچنین می توانیم برای رسیدن به هدف از یک روش استفاده کنیم:

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

#### Controllers

با `Phalcon\Mvc\Micro` می توانید نرم افزار های کوچک یا متوسط بوجود آورید. برنامه های متوسط از معماری میکرو استفاده می کنند اما آن را گسترش می دهند تا از آن بیشتر از میکرو و کمتر از نرم افزار کامل استفاده کنند.

در نرم افزار های متوسط شما میتوانید هندلر ها را در کنترل کننده ها سازمان دهی کنید.

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();

// Set the main handler. ie. a controller instance
$orders->setHandler(new OrdersController());

// Set a common prefix for all routes
$orders->setPrefix('/orders');

// Use the method 'index' in OrdersController
$orders->get('/', 'index');

// Use the method 'show' in OrdersController
$orders->get('/display/{slug}', 'show');

$app->mount($orders);
```

در`کنترل کننده سفارشات`ممکن است شبیه این باشند:

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

از آنجا که کنترل کننده ها `Phalcon\Mvc\Controller` را گسترش می دهند همه ی سرویس های انتقال وابستگی با نام های مربوطه برای ثبت نام در دسترس هستند. برای مثال:

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
        $content = "<h1>This is order: {$name}!</h1>";
        $this->response->setContent($content);

        return $this->response;
    }
}
```

<a name='routing-handlers-controllers-lazy-loading'></a>

### Lazy Loading

به منظور افزایش کارایی ممکن است شما از بارگذاری کم سرعت برای کنترل کننده ها (هندلرها) استفاده کنید. کنترل کننده تنها زمانی بارگذاری میشود که مسیر مربوطه همسان سازی شود.

بارگذاری آهسته، هنگامی که هندلر خود را در `Phalcon\Mvc\Micro\Collection`تنظیم میکنید، به راحتی بدست می آید:

```php
$orders->setHandler('OrdersController', true);
$orders->setHandler('Blog\Controllers\OrdersController', true);
```

<a name='routing-handlers-controllers-lazy-loading-use-case'></a>

#### Use case

ما یک API برای فروشگاه آنلاین داریم. نقاط انتهایی `/کاربران<0/> و <code>/سفارشات` و `/محصولات` هستند. هر کدام از این نقطه های پایانی با استفاده از کنترل کننده ها ثبت می شوند، و هر کنترل کننده یک کنترل کننده با اقدامات مربوطه است.

کنترل کننده هایی که ما به عنوان دستگیر کننده ها استفاده می کنیم به شرح زیر است:

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

ما هندلر ها را ثبت نام می کنیم:

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

این پیاده سازی هر هندلر را به نوبت بارگذاری می کند و در اشیا نرم افزار ما ثبت میکند. مسئله ی این رویکرد این است که هر درخواست تنها به یک نقطه پایانی منجر میشود و به این ترتیب تنها یک روش کلاسی اجرا می شود. روش ها/هندلرها باقی مانده بدون استفاده در حافظه می مانند.

با استفاده از بارگذاری کم سرعت ما تعداد اشیا بارگذاری شده در حافظه را کاهش می دهیم در نتیجه، نرم افزار ها از حجم کمتری از حافظه استفاده می کند.

اجرای فوق اگر بخواهیم از بارگذاری کم سرعت استفاده کنیم به صورت زیر تغییر می کند:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Users handler
$users = new MicroCollection();
$users->setHandler('UsersController', true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Orders handler
$orders = new MicroCollection();
$orders->setHandler('OrdersController', true);
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Products handler
$products = new MicroCollection();
$products->setHandler('ProductsController', true);
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

با استفاده از این تغییر ساده در اجرا تا زمانی که درخواستی از گوینده نباشد همه ی هندلر ها نمونه سازی نشده باقی می مانند. به این ترتیب، هرگاه گوینده ای درخواست کند `/orders/get/2` نرم افزار ما از `کنترل کننده های سفارش`نمونه سازی می کند و روش `گرفتن`را در آن فرا می خواند. حال نرم افزار ما از منابع کمتری نسبت به قبل استفاده می کند.

<a name='routing-handlers-not-found'></a>

### Not found (404)

هر مسیری که در `Phalcon\Mvc\Micro` نرم افزار ما همسان سازی نشده باشد، باعث می شود که آن روش `یافت نشد` را که تعریف شده است را امتحان کند و انجام دهد. مشابه سایر روش ها/فعل ها (و`گرفتن<0/>و <code>پست`وغیره)، شما می توانید یک هندلر را در روش `یافت نشد`قرار دهید که بتواند به هر عملکرد پی اچ پی قابل خواندن تبدیل شود.

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

شما همچنین میتوانید مسیر هایی را که همسان سازی نشده اند 404)) را با میان افزاری که در ذیل توضیح داده شده است، با دست انجام دهید.

<a name='routing-verbs'></a>

## Methods - Verbs

در `Phalcon\Mvc\Micro` نرم افزار، مجموعه ای از روش ها را برای چسباندن روش اچ تی تی پی با مسیری که برای آن در نظر گرفته شده است، مهیا می کند.

<a name='routing-verbs-delete'></a>

### delete

مسابقات اگر روش اچ تی تی پی `حذف` باشد و مسیر است `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

<a name='routing-verbs-get'></a>

### get

مسابقات اگر روش اچ تی تی پی `دریافت` باشد و مسیر است `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-head'></a>

### head

مسابقات اگر روش اچ تی تی پی `عنوان` باشد و مسیر است `/api/products`

```php
    $app->head(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-map'></a>

### map

طراح به شما اجازه می دهد که همان نقطه پایانی را به بیشتر از یک روش اچ تی تی پی ضمیمه کنید. مثال زیر منطبق است اگر روش اچ تی تی پی`دریافت ` یا `پست` باشد و مسیر `/repos/store/refs`

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

مسابقات اگر روش اچ تی تی پی`گزینه ها` باشد و مسیر است `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

<a name='routing-verbs-patch'></a>

### patch

مسابقات اگر روش اچ تی تی پی`وصله` باشد و مسیر است `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-verbs-post'></a>

### post

مسابقات اگر روش اچ تی تی پی`پست` باشد و مسیر است `/api/products/options`

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

<div class='alert alert-warning'>
    <p>
        The name that we bind each route has a suffix of <code>Action</code>. This is not necessary, your method can be called anything you like.
    </p>
</div>

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

اطلاعات اضافی `Phalcon\Mvc\Router` [اطلاعات](/[[language]]/[[version]]/routing)

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

Another feature of the routes is setting up named routes and generating URLs for those routes. This is a two step process.

* First we need to name our route. This can be achieved with the `setName()` method that is exposed from the methods/verbs in our application (`get`, `post`, etc.);

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

* We need to use the `Phalcon\Mvc\Url` component to generate URLs for the named routes.

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
<?php

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

You can use the `setContent` method of the Response object to return the response back:

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

You can also use the `Phalcon\Http\Response` object to return responses to the caller. The Response object has a lot of useful methods that make returning responses much easier.

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

A different approach returning data back to the caller is to return the Response object directly from the application. When responses are returned by handlers they are automatically sent by the application.

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

Another built-in event that you can subscribe to implement business logic is `beforeNotFound`. The following example shows one of the ways to handle requests for a non-existent address:

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

<div class="alert alert-warning">
    <p>
        You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.
    </p>
</div>

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

ما نیاز به شی `Phalcon\Events\Manager`. این می تواند شیئی باشد که تازه نمونه گیری شده یا ما می توانیم آن یکی که در ذخیره گاه دی آی Diوجود دارد را دریافت کنیم. (اگر شما از `پیش فرض کارخانه` استفاده کرده باشید).

ما هر کلاس میان افزار را در `کوچک` هوک در مدیریت رویداد ضمیمه می کنیم. ما می توانیم بیشتر مشخص باشیم و آن را ضمیمه کنیم تا رویداد `میکرو: قبل از اجرای مسیر` را بیان کنیم.

پس میان افزار را به نرم افزار خود طبق سر رویداد شنیداری که در بالا مورد بحث قرار گرفت، پیوست کنیم (`قبل`،`بعد`،`پایان`).

<a name='middleware-implementation'></a>

## Implementation

میان افزار می تواند هر نوع عملکرد پی اچ پی قابل خواندن باشد. شما می توانید که خود را به هر گونه ای که دوست دارید میان افزار عمل کند، سازمان دهی کنید. اگر شما بخواهید از کلاس ها برای میان افزار خود استفاده کنید، احتیاج دارید که آنها را طبق اجرا کنید `Phalcon\Mvc\Micro\MiddlewareInterface`

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

[رویداد هایی](#events) که برای نرم افزار ما استفاده می شوند،در درون کلاسی که `Phalcon\Mvc\Micro\MiddlewareInterface` را اجرا میکند نیز استفاده می شود. از آنجایی که می توانیم با پروسه ی درخواست فعل و انفعال داخلی داشته باشیم، این انعطاف پذیری و قدرت بسیاری را برای توسعه دهندگان پیشنهاد می کند.

<a name='middleware-events-api'></a>

### API example

فرض کنید که ما یک ای پی آی داریم که آن را با نرم افزار میکرو ایجاد کرده ایم. ما نیاز داریم برای کنترل بهتر اجرای نرم افزار، کلاس های میان افزار بسیاری را به نرم افزار خود ضمیمه کنیم.

میان افزار که ما استفاده خواهیم کرد: * دیواره آتش * پیدا نشد * تغییر مسیر * کورس * درخواست * واکنش

<a name='middleware-events-api-firewall'></a>

#### Firewall Middleware

این میان افزار به رویداد `قبل از`در نرم افزار میکرو ما، ضمیمه شده است. هدف این میان افزار این است که بررسی کنیم چه کسی ای پی ای ما را میخواند و بر اساس یک لیست سفید، به آنها اجازه میدهد که ادامه دهند یا خیر

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

هنگامی که این میان افزار پردازش می شود، این بدان معنا است که درخواست ای پی برای برنامه ما مجاز شده است. نرم افزار مسیر را امتحان و همسان سازی می کند و اگر موفق نشد، رویداد `قبل از این پیدا نشد` فعال می شود. سپس ما پردازش را متوقف خواهیم کرد و پاسخ 404 مربوط به کاربر را به آن باز بفرستیم. میان افزار به رویداد `قبل از` در نرم افزار میکرو ما ضمیمه شده است

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

ما دوباره میان افزار را به رویداد `قبل از`نرم افزار خود پیوست می کنیم زیرا اگر نقطه پایانی درخواست نیاز به تغییر جهت داشته باشد، نمی خواهیم که درخواست ادامه پیدا کند.

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

دوباره این میان افزار باید به رویداد `قبل از` نرم افزار میکرو ما ضمیمه شود. ما باید اطمینان حاصل کنیم که قبل از اینکه هر چیزی در نرم افزار ما اتفاق افتد آن کار می کند

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

<a name='middleware-events-api-request'></a>

#### Request Middleware

این میان افزار، حداکثر بار جی سون را دریافت می کند و به بررسی آن می پردازد. اگر حداکثر بار جی سون معتبر نباشد آن عملیات اجرا را متوقف می کند.

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

این میان افزار برای دستکاری پاسخ آن و باز فرستادن آن به خواننده به عنوان یک رشته جی سون مسئول است. به این ترتیب، ما باید آن را به رویداد `بعد از` در نرم افزار خود ضمیمه کنیم.

<div class='alert alert-warning'>
    <p>
        ما قصد استفاده از روش <code>فرا خوانی</code> را برای این میان افزار داریم؛ زیرا تقریبا تمام چرخه ی درخواست را اجرا کرده ایم.
    </p>
</div>

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

تا زمانی که ما برنامه را آموزش می دهیم که چگونه می تواند کلاس های مربوطه را با ابزار نیمه خودکار پیدا کند. مدل ها می توانند در نرم افزار های میکرو مورد استفاده قرار گیرند.

<div class="alert alert-warning">
    <p>
        خدمات <code>پایگاه داده</code> مربوطه، باید در ذخیره گاه Di شما ثبت شوند.
    </p>
</div>

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

با استفاده از کلاس `Phalcon\Mvc\Model\Binder` شما می توانید مدل های مثالی را به مسیرهای خود انتقال دهید:

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

از آنجا که شیئ بایندر در حال استفاده داخلی از رفلکشن آپی ای است که می تواند بسیار سنگین باشد، توانایی تنظیم ذخیره گاهی که این روند را سرعت بخشد وجود دارد. این می تواند با استفاده از شناسه دوم`مجموعه مدل بایندر() ` انجام شود. همچنین میتواند نام یک سرویس را قبول کند یا فقط با عبور یک نمونه کش به سازنده `بایندر` انجام شود.

در حال حاضر، اتصال دهنده تنها از کلید اصلی مدل برای انجام`پیدا کردن اول()` استفاده می کند. یک مثال از مسیر برای توضیح بالا `/محصولات/1` می باشد.

<a name='views'></a>

# Views

`Phalcon\Mvc\Micro` به صورت ذاتی سرویس مشاهده ندارد؛ با این حال، ما می توانیم از `Phalcon\Mvc\View\Simple` برای استرداد مشاهدات استفاده کنیم.

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

<div class='alert alert-warning'>
    <p>
        The above example uses the <a href="/[[language]]/[[version]]/Phalcon_Mvc_View_Simple">Phalcon\Mvc\View\Simple</a> component, which uses relative paths instead of controllers and actions. You can use the <a href="/[[language]]/[[version]]/Phalcon_Mvc_View">Phalcon\Mvc\View</a> component instead, but to do so you will need to change the parameters passed to <code>render()</code>
    </p>
</div>

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

نرم افزار 0>Phalcon\Mvc\Micro</code> روش `خطا` را نیز دارد که می تواند مورد استفاده قرار گیرد تا هرگونه اشتباهی را که از استثنائات حاصل می شود تضمین کند. قطعه کد زیر، استفاده اساسی از این ویژگی را نشان می دهد:

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