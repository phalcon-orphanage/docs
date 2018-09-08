<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-micro-applications">Создание микроприложения</a>
    </li>
    <li>
      <a href="#routing">Маршрутизация</a> 
      <ul>
        <li>
          <a href="#routing-setup">Настройка</a> 
          <ul>
            <li>
              <a href="#routing-setup-application">Объект приложения</a>
            </li>
            <li>
              <a href="#routing-setup-router">Объект Router</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#rewrite-rules">Правила перезаписи</a>
        </li>
        <li>
          <a href="#routing-handlers">Обработчики</a> <ul>
            <li>
              <a href="#routing-handlers-definitions">Определения</a> 
              <ul>
                <li>
                  <a href="#routing-handlers-anonymous-function">Анонимная функция</a>
                </li>
                <li>
                  <a href="#routing-handlers-function">Функция</a>
                </li>
                <li>
                  <a href="#routing-handlers-static-method">Статический метод</a>
                </li>
                <li>
                  <a href="#routing-handlers-object-method">Метод объекта</a>
                </li>
                <li>
                  <a href="#routing-handlers-controllers">Контроллеры</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-controllers-lazy-loading">Загрузка по требованию</a> 
              <ul>
                <li>
                  <a href="#routing-handlers-controllers-lazy-loading-use-case">Сценарий использования</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-not-found">Не найдено (404)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#routing-verbs">Методы-глаголы</a> 
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
          <a href="#routing-collections">Коллекции</a>
        </li>
        <li>
          <a href="#routing-parameters">Параметры</a>
        </li>
        <li>
          <a href="#routing-redirections">Перенаправления</a>
        </li>
        <li>
          <a href="#routing-urls-for-routes">Адреса для маршрутов</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#dependency-injector">Внедрение зависимостей</a>
    </li>
    <li>
      <a href="#responses">Ответы</a> 
      <ul>
        <li>
          <a href="#responses-direct-output">Прямой вывод</a>
        </li>
        <li>
          <a href="#responses-include">Подключение внешнего файла</a>
        </li>
        <li>
          <a href="#responses-direct-output-json">Возврат JSON</a>
        </li>
        <li>
          <a href="#responses-new-response-object">Новый объект Response</a>
        </li>
        <li>
          <a href="#responses-application-response">Общий объект Response</a>
        </li>
        <li>
          <a href="#responses-return-application-response">Объект Response как возвращаемое значение</a>
        </li>
        <li>
          <a href="#responses-json">JSON</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#events">События</a> 
      <ul>
        <li>
          <a href="#events-available-events">Доступные события</a> <ul>
            <li>
              <a href="#events-available-events-authentication">Пример: Аутентификация</a>
            </li>
            <li>
              <a href="#events-available-events-not-found">Пример: Страница не найдена</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#middleware">Middleware</a> <ul>
        <li>
          <a href="#middleware-attached-events">Прикреплённые события</a> 
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
          <a href="#middleware-implementation">Реализация</a>
        </li>
        <li>
          <a href="#middleware-setup">Настройка</a>
        </li>
        <li>
          <a href="#middleware-events">События в Middleware</a> 
          <ul>
            <li>
              <a href="#middleware-events-api">Пример API</a> 
              <ul>
                <li>
                  <a href="#middleware-events-api-firewall">Firewall</a>
                </li>
                <li>
                  <a href="#middleware-events-api-not-found">Не найдено</a>
                </li>
                <li>
                  <a href="#middleware-events-api-redirect">Перенаправление</a>
                </li>
                <li>
                  <a href="#middleware-events-api-cors">CORS</a>
                </li>
                <li>
                  <a href="#middleware-events-api-request">Запрос</a>
                </li>
                <li>
                  <a href="#middleware-events-api-response">Ответ</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#models">Модели</a>
    </li>
    <li>
      <a href="#model-instances">Внедрение моделей</a>
    </li>
    <li>
      <a href="#views">Представления</a>
    </li>
    <li>
      <a href="#error-handling">Обработка ошибок</a>
    </li>
  </ul>
</div>

# Микроприложения

С помощью Phalcon можно создавать приложения по типу “Микрофреймворк”. Для этого, необходимо написать всего лишь несколько строк кода.

Микроприложения подходят для небольших приложений, которые будут иметь очень низкие накладные расходы. Например, [наш веб-сайт](https://github.com/phalcon/website), [документация по фреймворку](https://github.com/phalcon/docs), которую вы сейчас читаете, наш [магазин](https://github.com/phalcon/store), API, прототипы и т.д.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);

$app->handle();
```

<a name='creating-micro-applications'></a>

## Создание микроприложения

Класс `Phalcon\Mvc\Micro` является ответственным за создание микроприложения.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>

## Маршрутизация (роутинг)

Defining routes in a `Phalcon\Mvc\Micro` application is very easy. Routes are defined as follows:

```text
Приложение -> (метод/глагол) -> (url адрес/регулярное выражение, вызываемая функция PHP)
```

<a name='routing-setup'></a>

### Настройка

Routing is handled by the `Phalcon\Mvc\Router` object. [[Info](/[[language]]/[[version]]/routing)]

<div class="alert alert-danger">
    <p>
        Маршруты всегда должны начинаться с <code>/</code>
    </p>
</div>

Обычно, `/` является стартовым маршрутом приложения, и в большинстве случаев осуществляется через метод GET протокола HTTP:

```php
<?php

// Это стартовый маршрут
$app->get(
    '/',
    function () {
        echo '<h1>Welcome!</h1>';
    }
);
```

<a name='routing-setup-application'></a>

### Объект Application

Маршруты можно задать используя экземпляр объекта-приложения `Phalcon\Mvc\Micro` следующим образом:

```php
use Phalcon\Mvc\Micro;

$app = new Micro();

// Соответствия для GET запроса
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

<a name='routing-setup-router'></a>

### Объект Router

Вы также можете задать маршруты создав экземпляр объекта `Phalcon\Mvc\Router`, настроив с его помощью маршруты, а затем добавив его в контейнер зависимостей (инъекция).

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

Настройка ваших маршрутов с помощью методов глаголов (`get`, `post` и т.д.) объекта-приложения `Phalcon\Mvc\Micro` гораздо проще, чем создание объекта маршрутизатора с соответствующими маршрутами и затем инъекцией в приложение.

Each method has its advantages and disadvantages. It all depends on the design and needs of your application.

<a name='rewrite-rules'></a>

## Rewrite правила

Для того чтобы маршруты работали необходимо также внести изменения в конфигурацию, вашего, веб-сервера для, вашего, конкретного сайта.

Эти изменения описаны в [Apache Rewrite Rules](http://httpd.apache.org/docs/current/rewrite/) и [NGINX Rewrite Rules](https://www.nginx.com/blog/creating-nginx-rewrite-rules/).

<a name='routing-handlers'></a>

## Обработчики

Обработчик — это вызываемая часть кода, которая "привязана" к маршруту. При совпадении с маршрутом, его обработчик выполняется с заданными параметрами. Обработчиком может быть любая вызываемая часть кода, которая существует в PHP.

<a name='routing-handlers-definitions'></a>

### Определения

Phalcon offers several ways to attach a handler to a route. Your application needs and design as well as coding style will be the factors influencing your choice of implementation.

<a name='routing-handlers-anonymous-function'></a>

#### Анонимная Функция

Мы можем использовать анонимные функции (как показано ниже) для обработки запроса

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

Доступ к объекту `$app`, внутри анонимной функции может достигаться путем инъекций переменой следующим образом:

```php
$app->get(
    '/orders/display/{name}',
    function ($name) use ($app) {
        $content = "<h1>Это заказ: {$name}!</h1>";
        $app->response->setContext($content);
        $app->response->send();
    }
);
```

<a name='routing-handlers-function'></a>

#### Функция

Мы можем определить функцию как обработчик и прикрепить её к определенному маршруту.

```php
// Определение функции
function order_display($name) {
    echo "<h1>Это заказа: {$name}!</h1>";
}

$app->get(
    '/orders/display/{name}',
    'orders_display'
);
```

<a name='routing-handlers-static-method'></a>

#### Статический метод

Также возможно использовать статический метод класса в качестве обработчика:

```php
class OrdersClass
{
    public static function display($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
}

$app->get(
    '/orders/display/{name}',
    'OrdersClass::display'
);
```

<a name='routing-handlers-object-method'></a>

#### Метод объекта

Мы также можем использовать метод экземпляра объекта:

```php
class OrdersClass
{
    public function display($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
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

#### Контроллеры

С `Phalcon\Mvc\Micro` вы можете создавать как микроприложения, так и средне-сложные приложения. Средне-сложные приложения используют микро-архитектуру, но расширяют её, таким образом являясь компромиссом между микро- и полноценными приложениями.

В средне-сложных приложениях вы можете организовывать обработчики в контроллеры.

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();

// Установка главного обработчика, т.е. экземпляра контроллера
$orders->setHandler(new OrdersController());

// Установка основного префикса для всех маршрутов
$orders->setPrefix('/orders');

// Использовать метод 'index' контроллера OrdersController
$orders->get('/', 'index');

// Использовать метод 'show' контроллера OrdersController
$orders->get('/display/{slug}', 'show');

$app->mount($orders);
```

Контроллер `OrdersController` может выглядеть следующим образом:

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
        $content = "<h1>Это заказ: {$name}!</h1>";
        $this->response->setContext($content);

        return $this->response;
    }
}
```

<a name='routing-handlers-controllers-lazy-loading'></a>

### Загрузка по требованию

In order to increase performance, you might consider implementing lazy loading for your controllers (handlers). The controller will be loaded only if the relevant route is matched.

Отложенная загрузка может быть легко реализована если использовать `Phalcon\Mvc\Micro\Collection` для настройки обработчиков:

```php
$orders->setHandler('OrdersController', true);
$orders->setHandler('Blog\Controllers\OrdersController', true);
```

<a name='routing-handlers-controllers-lazy-loading-use-case'></a>

#### Пример использования

Предположим мы занимаемся разработкой API для интернет-магазина. Конечные точки `/users`, `/orders` и `/products`. Каждая из этих конечных точек зарегистрирована с использованием обработчиков, каждый обработчик это контроллер с соответствующими действиями.

Контроллеры, которые мы используем, как обработчики, выглядят следующим образом:

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

Мы зарегистрировать обработчики:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Обработчик Users
$users = new MicroCollection();
$users->setHandler(new UsersController());
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Обработчик Orders
$orders = new MicroCollection();
$orders->setHandler(new OrdersController());
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Обработчик Products
$products = new MicroCollection();
$products->setHandler(new ProductsController());
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

Эта реализация загружает каждый обработчик по очереди и монтирует их в наш объект приложения. Проблема этого подхода в том, что каждый запрос приведет только в одну конечную точку, и будет выполнен только один метод класса. Остальные методы/обработчики просто останутся в памяти и не будут использованы.

Используя загрузку по запросу мы уменьшаем количество загруженных в память объектов, и в результате наше приложение использует меньше памяти.

Реализация выше изменяется, если мы желаем использовать загрузку по запросу, и будет выглядеть следующим образом:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Обработчик Users
$users = new MicroCollection();
$users->setHandler('UsersController', true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Обработчик Orders
$orders = new MicroCollection();
$orders->setHandler('OrdersController', true);
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Обработчик Products
$products = new MicroCollection();
$products->setHandler('ProductsController', true);
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

Используя это простое изменение в реализации, все обработчики остаются не созданными, пока не будут запрошены вызывающим. Поэтому когда вызывающий запрашивает `/orders/get/2`, наше приложение создаст экземпляр `OrdersController` и вызовет в нем метод `get`. Теперь наше приложение использует меньше ресурсов, чем прежде.

<a name='routing-handlers-not-found'></a>

### Не найдено (404)

Любой маршрут, который не сопоставлен в нашем `Phalcon\Mvc\Micro` приложении, приведет к попытке выполнить обработчик определенный с помощью метода `notFound`. Аналогично для других методов/действий (`get`, `post` и т. д.), Вы можете зарегистрировать обработчик с помощью метода `notFound`, который может быть любой вызываемой PHP функцией.

```php
<?php

$app->notFound(
    function () use ($app) {
        $app->response->setStatusCode(404, 'Не найдено');
        $app->response->sendHeaders();

        $message = 'Не на что здесь смотреть. Продолжаем....';
        $app->response->setContent($message);
        $app->response->send();
    }
);
```

Также, вы можете обрабатывать маршруты, которые не были сопоставлены (404) с помощью middleware, обсуждаемых ниже.

<a name='routing-verbs'></a>

## Методы-глаголы

Объект-приложение `Phalcon\Mvc\Micro` предоставляет следующий перечень методов для связки HTTP-метода с маршрутом.

<a name='routing-verbs-delete'></a>

### delete

Пример ниже сработает если HTTP-метод будет `DELETE` и маршрут соответствовать `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

<a name='routing-verbs-get'></a>

### get

Пример ниже сработает если HTTP-метод будет `GET`, а маршрут равен `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-head'></a>

### head

Сработает, если HTTP метод будет `HEAD`, а маршурт `/api/products`

```php
    $app->head(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-map'></a>

### map

Map позволяет назначить одну и ту же конечную точку для более чем одного HTTP метода. Пример ниже сработает, если HTTP метод будет `GET` или `POST`, а маршрут `/repos/store/refs`

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

Сработает, если HTTP метод будет `OPTIONS`, а маршрут `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

<a name='routing-verbs-patch'></a>

### patch

Сработает, если HTTP методбудет `PATCH`, а маршрут `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-verbs-post'></a>

### post

Сработает, есди HTTP метод будет `POST`, а маршрут `/api/products/add`

```php
    $app->post(
        '/api/products',
        'add_product'
    );
```

<a name='routing-verbs-put'></a>

### put

Сработает, если HTTP метод будет `PUT`, а маршрут`/api/products/update/{id}`

```php
    $app->put(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-collections'></a>

## Коллекции

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

## Параметры

We have briefly seen above how parameters are defined in the routes. Parameters are set in a route string by enclosing the name of the parameter in brackets.

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

We can also enforce certain rules for each parameter by using regular expressions. The regular expression is set after the name of the parameter, separating it with `:`.

```php
// Сопоставить order id
$app->get(
    '/orders/display/{id:[0-9]+}',
    function ($id) {
        echo "<h1>This is order: #{$id}!</h1>";
    }
);

// Сопоставить год (4 числа) и заголовок (буквы)
$app->get(
    '/posts/{year:[0-9][4]}/{title:[a-zA-Z\-]+}',
    function ($year, $title) {
        echo '<h1>Заголовок: $title</h1>';
        echo '<h2>Год: $year</h2>';
    }
);
```

Дополнительно: `Phalcon\Mvc\Router`. [[Подробнее](/[[language]]/[[version]]/routing)]

<a name='routing-redirections'></a>

## Перенаправления

Вы можете перенаправить один маршрут в другой с помощью объекта `Phalcon\Http\Response`, также, как в полном приложении.

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

**Примечание** мы должны передать объект `$app` в нашу анонимную функцию, чтобы иметь доступ к объекту `request`.

Когда контроллеры используются в качестве обработчиков, Вы можете выполнить перенаправление очень просто:

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

## URL-адреса для маршрутов

Другая возможность маршрутизации — настройка именованных маршрутов и генерация URL-адресов для этих маршрутов. Это двухшаговый процесс.

* First we need to name our route. Это может быть достигнуто с помощью метода `setName()`, который доступен из методов-глаголов в нашем приложении (`get`, `post`, и т. д.);

```php
// Задать маршрут с именем 'show-order'
$app
    ->get(
        '/orders/display/{id}',
        function ($id) use ($app) {
            // ... Найти заказ и показать его
        }
    )
    ->setName('show-order');
```

* Нам нужно использовать компонент `Phalcon\Mvc\Url` для получения URL-адреса на основе определенных маршрутов.

```php
// Используем именованный маршрут и создаем URL от него
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

# Внедрение зависимостей

Когда микро приложение создано, неявно создается контейнер сервисов `Phalcon\Di\FactoryDefault`.

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

Кроме того, вы можете создать Di контейнер самостоятельно, и назначить его микроприложению. Таким образом, манипуляция сервисами полностью будет зависеть от нужд вашего приложения.

```php
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
        // Читаем настройки из конфига
        echo $app->config->app_name;
    }
);

$app->post(
    '/contact',
    function () use ($app) {
        $app->flash->success('Что ты делаешь Дэйв?');
    }
);
```

Также вы можете использовать синтаксис массивов, чтобы зарегистрировать сервисы в контейнере зависимостей из объекта приложения:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

$app = new Micro();

// Настройка сервиса базы данных
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

# Ответы

A micro application can return many different types of responses. Direct output, use a template engine, calculated data, view based data, JSON etc.

Обработчики могут возвращать raw ответ используя plain text, объект `Phalcon\Http\Response` или пользовательский компонент реализующий интерфейс `Phalcon\Http\ResponseInterface`.

<a name='responses-direct-output'></a>

## Прямой вывод

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

<a name='responses-include'></a>

## Подключение внешнего файла

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        require 'views/results.php';
    }
);
```

<a name='responses-direct-output-json'></a>

## Прямой вывод JSON

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

## Новый объект Response

Вы можете использовать метод `setContent` объекта Response, чтобы вернуть ответ:

```php
$app->get(
    '/show/data',
    function () {
        // Создание ответа
        $response = new Phalcon\Http\Response();

        // Установка заголовка Content-Type
        $response->setContentType('text/plain');

        // Передача контента из файла
        $response->setContent(file_get_contents('data.txt'));

        // Возврат ответа
        return $response;
    }
);
```

<a name='responses-application-response'></a>

## Ответ приложения

You can also use the `Phalcon\Http\Response` object to return responses to the caller. The Response object has a lot of useful methods that make returning responses much easier.

```php
$app->get(
    '/show/data',
    function () use ($app) {
        // Установка заголовка Content-Type
        $app->response->setContentType('text/plain');
        $app->response->sendHeaders();

        // Вывод файла
        readfile('data.txt');
    }
);
```

<a name='responses-return-application-response'></a>

## Возврат ответа приложения

Другим подходом возврата данных обратно вызывающей стороне является возвращения объекта Response напрямую из приложения. Когда ответы возвращаются обработчиками они автоматически отправляются приложением.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$app = new Micro();

// Возврат объекта Response
$app->get(
    '/welcome/index',
    function () {
        $response = new Response();

        $response->setStatusCode(401, 'Не авторизован');
        $response->setContent('Доступ не авторизован');

        return $response;
    }
);
```

<a name='responses-json'></a>

## JSON

При использовании `Phalcon\Http\Response`, JSON-ответ может быть сформирован с такой же лёгкостью:

```php
$app->get(
    '/welcome/index',
    function () use ($app) {

        $data = [
            'code'    => 401,
            'status'  => 'error',
            'message' => 'Не авторизированный доступ',
            'payload' => [],
        ];

        $response->setJsonContent($data);

        return $response;
    }
);
```

<a name='events'></a>

# События

`Phalcon\Mvc\Micro` приложение тесно работает с `Phalcon\Events\Manager`, если он представлен, чтобы вызывать события, которые могут быть использованы на протяжении работы нашего приложения. Тип этих событий — `micro`. Эти события вызываются в нашем приложение и могут быть прикреплены к соответствующим обработчикам, которые будут выполнять действия необходимые нашему приложению.

<a name='events-available-events'></a>

## Доступные события

Поддерживаются следующие события:

| Название события   | Срабатывает                                                                  | Может остановить операцию? |
| ------------------ | ---------------------------------------------------------------------------- |:--------------------------:|
| beforeHandleRoute  | Основной метод вызван; Маршруты ее не проверены                              |             Да             |
| beforeExecuteRoute | Маршрут сопоставлен, обработчик верный, но еще не выполнен                   |             Да             |
| afterExecuteRoute  | Обработчик только что закончил работать                                      |            Нет             |
| beforeNotFound     | Маршрут не найден                                                            |             Да             |
| afterHandleRoute   | Маршрут только что закончил выполнение                                       |             Да             |
| afterBinding       | Срабатывает после того, как модели связаны, но перед выполнением обработчика |             Да             |

<a name='events-available-events-authentication'></a>

### Пример: Аутентификация

Вы легко можете проверить был ли пользователь аутентифицирован или нет используя событие `beforeExecuteRoute`. В следующем примере, мы рассмотрим как контролировать безопасность приложения используя событийную модель:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Создаем менеджер событий
$eventsManager = new EventsManager();

$eventsManager->attach(
    'micro:beforeExecuteRoute',
    function (Event $event, $app) {
        if ($app->session->get('auth') === false) {
            $app->flashSession->error("The user isn't authenticated");

            $app->response->redirect('/');
            $app->response->sendHeaders();

            // Возврат (false) останавливает операцию
            return false;
        }
    }
);

$app = new Micro();

// Привязываем менеджер событий к приложению
$app->setEventsManager($eventsManager);
```

<a name='events-available-events-not-found'></a>

### Пример: Страница не найдена

Another built-in event that you can subscribe to implement business logic is `beforeNotFound`. The following example shows one of the ways to handle requests for a non-existent address:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Создаем менеджер событий
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

// Привязываем менеджер событий к приложению
$app->setEventsManager($eventsManager);
```

<a name='middleware'></a>

# Middleware

Middleware — это классы, которые могут быть прикреплены к вашему приложению, с целью ввести ещё один слой, для обработки бизнес-логики. Они запускаются последовательно, в соответствии с порядком регистрации и не только улучшают гибкость, путем инкапсуляции специфичной функциональности, но также повышают производительность. Middleware может остановить выполнение, когда конкретное бизнес-правило не было удовлетворенно. Это дает возможность приложению завершить работу на ранней стадии, без выполнения полного цикла запроса.

Наличие `Phalcon\Events\Manager` необходимо для работы middleware, поэтому он должен быть зарегистрирован в нашем Di контейнере.

<a name='middleware-attached-events'></a>

## Прикреплённые события

Middleware can be attached to a micro application in 3 different events. Those are:

| Событие | Описание                                        |
| ------- | ----------------------------------------------- |
| before  | Перед выполнением обработчика                   |
| after   | После выполнения обработчика                    |
| final   | После того, как был отправлен ответ вызывающему |

<div class="alert alert-warning">
    <p>
        You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.
    </p>
</div>

<a name='middleware-attached-events-before'></a>

### before

Это событие идеально для остановки выполнения приложения, когда определенный критерий не соблюден. В примере ниже, мы проверяем был ли пользователь авторизован и останавливаем выполнение с необходимым перенаправлением.

```php
<?php

$app = new Phalcon\Mvc\Micro();

// Вызывается перед выполнением каждого маршрута
// Возврат false отменяет выполнение маршрута
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("Пользователь не авторизован");

            $app['response']->redirect('/error');

            // Возврат false останавливает нормальное выполнение
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
        // Выполняется после выполнения маршрута
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

## Настройка

Прикрепление middleware к вашему приложению происходит очень легко, как показано выше, с помощью вызова методов `before`, `after` и `finish`.

```php
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("Пользователь не авторизован");

            $app['response']->redirect('/error');

            // Возврат false останавливает нормальное выполнение
            return false;
        }

        return true;
    }
);

$app->after(
    function () use ($app) {
        // Выполняется после выполнения маршрута
        echo json_encode($app->getReturnedValue());
    }
);
```

Прикрепление middleware к вашему приложению, как классов прослушивающих события из менеджера событий, может быть достигнуто следующим образом:

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
 * Прикрепляем middleware к менеджеру событий и приложению 
*/
$eventsManager->attach('micro', new CacheMiddleware());
$application->before(new CacheMiddleware());

$eventsManager->attach('micro', new NotFoundMiddleware());
$application->before(new NotFoundMiddleware());

/**
 * Этот нужен, чтобы слушать событие `after`
 */
$eventsManager->attach('micro', new ResponseMiddleware());
$application->after(new ResponseMiddleware());

/**
 * Убедимся, что наш менеджер событий теперь находится в DI контейнере
 */
$application->setEventsManager($eventsManager);

```

Нам нужен объект `Phalcon\Events\Manager`. Это может быть вновь созданный экземпляр, или мы можем получить один из существующих в нашем DI контейнере (если вы использовали `FactoryDefault`).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

Затем мы прикрепляем класс middleware в наше приложение на одно из трех прослушиваемых событий, описанных выше (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Реализация

Middleware может быть любой вызываемой PHP функцией. Вы можете организовать код любым путем, который вам нравится, для реализации middleware. Если вы решили использовать классы для middleware, Вам понадобится реализовать интерфейс `Phalcon\Mvc\Micro\MiddlewareInterface`

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CacheMiddleware
 *
 * Кэширует страницы, чтобы сократить обработку
 */
class CacheMiddleware implements MiddlewareInterface
{
    /**
     * Вызывает middleware
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

        // Проверяет закэширован ли запрос
        if ($cache->exists($key)) {
            echo $cache->get($key);

            return false;
        }

        return true;
    }
}
```

<a name='middleware-events'></a>

## События в Middleware

[События](#events), вызываемые для нашего приложения, также вызываются внутри класса реализующего интерфейс `Phalcon\Mvc\Micro\MiddlewareInterface`. Это обеспечивает большую гибкость и более широкие возможности для разработчиков, поскольку можем взаимодействовать с обработкой запроса.

<a name='middleware-events-api'></a>

### Пример API

Предположим, у нас есть API, которое мы реализовали с помощью Micro приложения. Нам необходимо прикрепить различные Middleware классы к приложению, чтобы иметь возможность лучше контролировать его выполнение.

The middleware that we will use are:

* Firewall
* NotFound
* Redirect
* CORS
* Request
* Response

<a name='middleware-events-api-firewall'></a>

#### Firewall Middleware

Этот middleware прикрепляется к событию `before` нашего микроприложения. Цель этого middleware проверить, кто вызывает наше API, и опираясь на белый список, разрешает ему продолжить или нет

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * FirewallMiddleware
 *
 * Проверяет белый список и допускает клиентов или нет
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
     * Вызывает middleware
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

Когда этот middleware обработан, это означает, что запрашивающему IP разрешен доступ к нашему приложению. Приложение попытается сопоставить маршрут, и если он не будет найден сработает событие `beforeNotFound`. Тогда мы прекратим обработку и вернем пользователю соответствующий ответ 404. Этот middleware прикреплен к событию `before` нашего Micro приложения

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * NotFoundMiddleware
 *
 * Обрабатывает 404
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * Маршрут не был найден
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
     * Вызывает middleware
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

Мы прикрепляем этот middleware снова к событию `before` нашего Micro приложения, потому что мы не хотим, чтобы запрос продолжал обрабатываться, если запрашиваемая конечная точка должна быть перенаправлена.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RedirectMiddleware
 *
 * Проверяет запрос и перенаправляет пользователя куда-нибудь еще, если необходимо
 */
class RedirectMiddleware implements MiddlewareInterface
{
    /**
     * Прежде чем что-то произойдет
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
     * Вызывает middleware
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
 * Проверка CORS
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * Прежде, чем что-нибудь случится
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
 * Проверяет входящие данные
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * Перед выполнением маршрута
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
     * Вызывает middleware
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

Этот middleware отвечает за изменение нашего ответа и его отправку вызывающему в виде JSON строки. Следовательно, мы должны прикрепить его к событию `after` нашего Micro приложения.

<div class='alert alert-warning'>
    <p>
        Мы будем использовать метод <code>call</code> для этого middleware, так как мы выполнили почти весь цикл запроса.
    </p>
</div>

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
* ResponseMiddleware
*
* Изменяет ответ
*/
class ResponseMiddleware implements MiddlewareInterface
{
     /**
      * Прежде, чем что-нибудь случится
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

# Модели

Модели могут быть использованы в Micro приложениях, до тех пор, пока мы инструктируем приложение, как оно может найти соответствующие классы с помощью автозагрузчика.

<div class="alert alert-warning">
    <p>
        Соответствующий<code>db</code> сервис должен быть зарегистрирован в Ваше DI контейнере.
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

# Внедрение моделей

Используя класс `Phalcon\Mvc\Model\Binder` Вы можете внедрять экземпляры моделей в Ваши маршруты:

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
        // делаем что-нибудь с объектом $product
    }
);

$app->handle();
```

Так как объект Binder использует внутренний Reflection Api, который может быть тяжелым, есть возможность установить кэш, чтобы ускорить этот процесс. Это можно выполнить используя второй аргумент метода `setModelBinder()`, который также может принимать имя сервиса, или просто передав экземпляр кэша в конструктор класса `Binder`.

Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/products/1`.

<a name='views'></a>

# Представления

`Phalcon\Mvc\Micro` does not inherently have a view service. We can however use the `Phalcon\Mvc\View\Simple` component to render views.

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();

    $view->setViewsDir('app/views/');

    return $view;
};

// Вернуть отображенный вид
$app->get(
    '/products/show',
    function () use ($app) {
        // Отобразить app/views/products/show.phtml с передачей некоторых переменных
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
        Приведенный выше пример использует компонент <a href="/[[language]]/[[version]]/Phalcon_Mvc_View_Simple">Phalcon\Mvc\View\Simple</a>, который использует относительные пути вместо контроллеров и действий. Вместо этого Вы можете использовать компонент <a href="/[[language]]/[[version]]/Phalcon_Mvc_View">Phalcon\Mvc\View</a>, но чтобы это сделать, необходимо изменить параметры передаваемые в <code>render()</code>
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
        echo $app['view']->start()->render(
            'products',
            'show',
            [
                'id'   => 100,
                'name' => 'Artichoke',
            ]
        )->finish()->getContent();
    }
);
```

<a name='error-handling'></a>

# Обработка ошибок

Также, `Phalcon\Mvc\Micro` приложение имеет метод `error`, который может быть использован для перехвата ошибок порождённых исключениями. Следующий фрагмент кода показывает основное использование этой возможности:

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app->get(
    '/',
    function () {
        throw new \Exception('Произошла ошибка', 401);
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