<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-micro-application">Создание микроприложения</a>
    </li>
    <li>
      <a href="#routing">Маршрутизация</a> <ul>
        <li>
          <a href="#routing-setup">Настройка</a> <ul>
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
              <a href="#routing-handlers-definitions">Определения</a> <ul>
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
              <a href="#routing-handlers-controllers-lazy-loading">Загрузка по требованию</a> <ul>
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
          <a href="#routing-verbs">Методы-глаголы</a> <ul>
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
      <a href="#responses">Ответы</a> <ul>
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
      <a href="#events">События</a> <ul>
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
          <a href="#middleware-attached-events">Прикрепленные события</a> <ul>
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
          <a href="#middleware-events">События в Middleware</a> <ul>
            <li>
              <a href="#middleware-events-api">Пример реализации</a> <ul>
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

Phalcon предлагает очень "тонкое" приложение, так что можно создавать "Микроприложения" минимальными усилиями.

Микро приложения подходят для небольших приложений, которые будут иметь очень низкие накладные расходы. Например, наш [веб-сайт](https://github.com/phalcon/website), этот веб-сайт ([документация](https://github.com/phalcon/docs)), наш [магазин](https://github.com/phalcon/store), API, прототипы и т.д.

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

## Создание микро приложения

Класс `Phalcon\Mvc\Micro` является ответственным за создание микро приложения.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>

## Маршрутизация

Указание маршрутов в приложении `Phalcon\Mvc\Micro` очень простое. Маршруты, определяются следующим образом:

```text
   Приложение -> (метод/глагол) -> (url адрес/регулярное выражение, вызываемая функция PHP)
```

<a name='routing-setup'></a>

### Настройка

Маршрутизация обрабатывается объектом `Phalcon\Mvc\Router`. [[Информация](/[[language]]/[[version]]/routing)]

<h5 class='alert alert-warning'>Маршруты всегда должны начинаться с <code>/</code></h5>

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

Каждый из приведенных методов задания маршрутов имеет свои преимущества и недостатки. Все зависит от дизайна и потребностей вашего приложения.

<a name='rewrite-rules'></a>

## Rewrite правила

Для того чтобы маршруты работали необходимо также внести изменения в конфигурацию, вашего, веб-сервера для, вашего, конкретного сайта.

Эти изменения описаны в [rewrite правилах](/[[language]]/[[version]]/rewrite-rules).

<a name='routing-handlers'></a>

## Обработчики

Обработчик — это вызываемая часть кода, которая "привязана" к маршруту. При совпадении с маршрутом, его обработчик выполняется с заданными параметрами. Обработчиком может быть любая вызываемая часть кода, которая существует в PHP.

<a name='routing-handlers-definitions'></a>

### Определения

Phalcon предлагает несколько способов задания обработчика для маршрута. Потребности и дизайн вашего приложения, а также стиль кодирования будут влиять на ваш выбор способа.

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
        $context = "<h1>Это заказ: {$name}!</h1>";
        $app->response->setContext($context);
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

Поскольку наши контроллеры расширяют `Phalcon\Mvc\Controller`, все внедряемые сервисы уже доступны по соответствующим зарегистрированным именам. Например:

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
        $context = "<h1>Это заказ: {$name}!</h1>";
        $this->response->setContext($context);

        return $this->response;
    }
}
```

<a name='routing-handlers-controllers-lazy-loading'></a>

### Загрузка по требованию

Для повышения производительности, рассмотрите возможность реализации отложенной загрузки для ваших контроллеров (обработчиков). Контроллер будет загружен только для соответствующего маршрута.

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
$users->setHandler(new UsersController(), true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Обработчик Orders
$orders = new MicroCollection();
$orders->setHandler(new OrdersController(), true);
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Обработчик Products
$products = new MicroCollection();
$products->setHandler(new ProductsController(), true);
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

Также Вы можете обрабатывать маршруты, которые не были сопоставлены (404) с помощью посредников Middleware, обсуждаемых ниже.

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

Коллекции — удобный способ группировать коллекции прикрепленные к обработчику и общему префиксу (если необходимо). Для гипотетической конечной точки `/orders` мы могли бы иметь следующие конечные точки:

    /orders/get/{id}
    /orders/add/{payload}
    /orders/update/{id}
    /orders/delete/{id}
    

Все эти маршруты обрабатываются нашим `OrdersController`. Мы установим наши маршруты с помощью коллекции следующим образом:

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

<h5 class='alert alert-warning'>Имя с которым мы связываем каждый маршрут имеет суффикс <code>Action</code>. Это не обязательно, Ваш метод может называться как угодно.</h5>

<a name='routing-parameters'></a>

## Параметры

Выше вкратце мы рассмотрели, как параметры определяются в маршрутах. Параметры задаются в строке маршрута с помощью заключения имени параметра в фигурных скобках.

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

Также мы можем применить определенные правила для каждого параметра, используя регулярные выражения. Регулярное выражение задается после имени параметра, и отделяется от него с помощью `:`.

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

## URLs for Routes

Another feature of the routes is setting up named routes and generating URLs for those routes. This is a two step process. * First we need to name our route. This can be achieved with the `setName()` method that is exposed from the methods/verbs in our application (`get`, `post`, etc.);

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

- We need to use the `Phalcon\Mvc\Url` component to generate URLs for the named routes.

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

You can also use the array syntax to register services in the dependency injection container from the application object:

```php
<br /><?php

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

# Responses

A micro application can return many different types of responses. Direct output, use a template engine, calculated data, view based data, JSON etc.

Handlers may return raw responses using plain text, `Phalcon\Http\Response` object or a custom built component that implements the `Phalcon\Http\ResponseInterface`.

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

You can use the `setContent` method of the response object to return the response back:

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

You can also use the `Phalcon\Http\Response` object to return responses to the caller. The response object has a lot of useful methods that make returning respones much easier.

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

A different approach returning data back to the caller is to return the response object directly from the application. When responses are returned by handlers they are automatically sent by the application.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$app = new Micro();

// Возврат объекта response
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

JSON can be sent back just as easy using the `Phalcon\Http\Response` object:

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

A `Phalcon\Mvc\Micro` application works closely with a `Phalcon\Events\Manager` if it is present, to trigger events that can be used throughout our application. The type of those events is `micro`. These events trigger in our application and can be attached to relevant handlers that will perform actions needed by our application.

<a name='events-available-events'></a>

## Доступные события

Поддерживаются следующие события:

| Название события   | Срабатывает                                                                  | Может остановить операцию? |
| ------------------ | ---------------------------------------------------------------------------- |:--------------------------:|
| beforeHandleRoute  | Основной метод вызван; Маршруты ее не проверены                              |             Да             |
| beforeExecuteRoute | Маршрут сопоставлен, обработчик верный, но еще не выполнен                   |             Да             |
| afterExecuteRoute  | Обработчик только что закончил работать                                      |            Нет             |
| beforeNotFound     | Маршрут не найден                                                            |             Да             |
| afterHandleRoute   | Route just finished executing                                                |             Да             |
| afterBinding       | Срабатывает после того, как модели связаны, но перед выполнением обработчика |             Да             |

<a name='events-available-events-authentication'></a>

### Authentication example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

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

### Not found example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

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

Middleware are classes that can be attached to your application and introduce another layer where business logic can exist. They run sequentially, according to the order they are registered and not only improve mainainability, by encapsulating specific functionality, but also performance. A middleware class can stop execution when a particular business rule has not been satisfied, thus allowing the application to exit early without executing the full cycle of a request.

The presence of a `Phalcon\Events\Manager` is essential for middleware to operate, so it has to be registered in our Di container.

<a name='middleware-attached-events'></a>

## Attached events

Middleware can be attached to a micro application in 3 different events. Those are:

| Событие | Описание                                        |
| ------- | ----------------------------------------------- |
| before  | Перед выполнением обработчика                   |
| after   | После выполнения обработчика                    |
| final   | После того, как был отправлен ответ вызывающему |

<h5 class='alert alert-warning'>You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.</h5>

<a name='middleware-attached-events-before'></a>

### before

This event is perfect for stopping execution of the application if certain criteria is not met. In the below example we are checking if the user has been authenticated and stop execution with the necessary redirect.

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

Attaching middleware to your application is very easy as shown above, with the `before`, `after` and `finish` method calls.

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

We need a `Phalcon\Events\Manager` object. This can be a newly instantiated object or we can get the one that exists in our DI container (if you have used the `FactoryDefault` one).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

We then attach the middleware class in our application on one of the three listening events discussed above (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Реализация

Middleware can be any kind of PHP callable functions. You can organize your code whichever way you like it to implement middleware. If you choose to use classes for your middleware, you will need them to implement the `Phalcon\Mvc\Micro\MiddlewareInterface`

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

The [events](#events) that are triggered for our application also trigger inside a class that implements the `Phalcon\Mvc\Micro\MiddlewareInterface`. This offers great flexibility and power for developers since we can interact with the request process.

<a name='middleware-events-api'></a>

### Пример API

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

When this middleware is processed, this means that the requesting IP is allowed to access our application. The application will try and match the route and if not found the `beforeNotFound` event will fire. We will stop the processing then and send back to the user the relevant 404 response. This middleware is attached to the `before` event of our Micro application

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

We attach this middleware again to the `before` event of our Micro application because we don't want the request to proceed if the requested endpoint needs to be redirected.

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

This middleware is responsible for manipulating our response and sending it back to the caller as a JSON string. Therefore we need to attach it to the `after` event of our Micro application.

<h5 class='alert alert-warning'>We are going to be using the <code>call</code> method for this middleware, since we have nearly executed the whole request cycle.</h5>

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

# Внедрение моделей

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
        // делаем что-нибудь с объектом $product
    }
);

$app->handle();
```

Since Binder object is using internally Reflection Api which can be heavy, there is ability to set a cache so as to speed up the process. This can be done by using the second argument of `setModelBinder()` which can also accept a service name or just by passing a cache instance to the `Binder` constructor.

Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/products/1`.

<a name='views'></a>

# Представления

`Phalcon\Mvc\Micro` does not have inherently a view service. We can however use the `Phalcon\Mvc\View\Simple` component to render views.

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

<h5 class='alert alert-warning'>The above example uses the <code>Phalcon\\Mvc\\View\\Simple</code> component, which uses relative paths instead of controllers and actions. You can use the <code>Phalcon\\Mvc\\View</code> component instead, but to do so you will need to change the parameters passed to <code>render()</code></h5>

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View();

    $view->setViewsDir('app/views/');

    return $view;
};

// Вернуть отображенный вид
$app->get(
    '/products/show',
    function () use ($app) {
        // Отображаем app/views/products/show.phtml с передачей некоторых переменных
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

# Обработка ошибок

The `Phalcon\Mvc\Micro` application also has an `error` method, which can be used to trap any errors that originate from exceptions. The following code snippet shows basic usage of this feature:

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