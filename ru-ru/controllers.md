* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Введение

<a name='using'></a>

## Использование контроллеров

Контроллеры содержат в себе ряд методов, называемых действиями (в англоязычной литературе — actions). Действия контроллеров занимаются непосредственно обработкой запросов. По умолчанию все публичные методы контролеров доступны для доступа по URL. Действия отвечают за разбор запросов (request) и создание ответов (response). Как правило, результаты работы действий используются для представлений, но так же возможно их иное использование.

For instance, when you access a URL like this: `https://localhost/blog/posts/show/2015/the-post-title` Phalcon by default will decompose each part like this:

| Описание                     | Часть URL-адреса |
| ---------------------------- | ---------------- |
| **Директория с приложением** | blog             |
| **Контроллер**               | posts            |
| **Действие**                 | show             |
| **Параметр**                 | 2015             |
| **Параметр**                 | the-post-title   |

Для этого случая запрос будет отправлен для обработки в контроллер `PostsController`. There is no a special location to put controllers in an application, they could be loaded using [Phalcon\Loader](api/Phalcon_Loader), so you're free to organize your controllers as you need.

Контроллеры должны иметь суффикс `Controller`, а действия, соответственно, `Action`. Пример контроллера:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {

    }
}
```

Дополнительные URI-параметры передаются в качестве параметров действия, таким образом, они легко могут быть получены как локальные переменные. A controller can optionally extend [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). В таком случае он получает доступ к сервисам приложения.

Параметры без значений по умолчанию являются обязательными. Установка значений по умолчанию производится обычным для PHP способом:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year = 2015, $postTitle = 'некоторое значение по умолчанию')
    {

    }
}
```

Параметры присваиваются в том же порядке, в каком и были переданы. Получить доступ к произвольному параметру можно следующим образом:

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
        $year      = $this->dispatcher->getParam('year');
        $postTitle = $this->dispatcher->getParam('postTitle');
    }
}
```

<a name='dispatch-loop'></a>

## Цикл работы

Цикл работы диспетчера выполняется до тех пор, пока не останется действий для обработки. В примере выше выполняется лишь одно действие. Пример ниже показывает, как с использованием метода `forward()` можно обеспечить более сложный процесс диспетчеризации путём перенаправления потока выполнения на другой контроллер/действие.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {
        $this->flash->error(
            "У вас недостаточно прав для выполнения этого действия"
        );

        // еренаправляем на другое действие
        $this->dispatcher->forward(
            [
                'controller' => 'users',
                'action'     => 'signin',
            ]
        );
    }
}
```

Если у пользователя недостаточно прав, он будет перенаправлен в контроллер `UsersController` для выполнения авторизации (действие `signin`).

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function signinAction()
    {

    }
}
```

Метод `forwards` может быть вызван неограниченное количество раз, приложение будет выполняться, пока не появится явный сигнал для завершения. If there are no other actions to be dispatched by the dispatch loop, the dispatcher will automatically invoke the view layer of the MVC that is managed by [Phalcon\Mvc\View](api/Phalcon_Mvc_View).

<a name='initializing'></a>

## Инициализация контроллеров

[Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller) offers the `initialize()` method, which is executed first, before any action is executed on a controller. Использование метода `__construct()` не рекомендуется.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public $settings;

    public function initialize()
    {
        $this->settings = [
            'mySetting' => 'value',
        ];
    }

    public function saveAction()
    {
        if ($this->settings['mySetting'] === 'value') {
            // ...
        }
    }
}
```

<h5 class='alert alert-warning'>The <code>initialize()</code> method is only called if the <code>beforeExecuteRoute</code> event is executed with success. This avoid that application logic in the initializer cannot be executed without authorization.</h5>

Если вы все же хотите выполнить некоторую инициализацию после создания объекта контроллера, то можете реализовать метод `onConstruct()`:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function onConstruct()
    {
        // ...
    }
}
```

<h5 class='alert alert-warning'>Be aware that <code>onConstruct()</code> method is executed even if the action to be executed doesn't exist in the controller or the user does not have access to it (according to custom control access provided by the developer).</h5>

<a name='injecting-services'></a>

## Внедрение сервисов

If a controller extends [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller) then it has easy access to the service container in application. For example, if we have registered a service like this:

```php
<?php

use Phalcon\Di;

$di = new Di();

$di->set(
    'storage',
    function () {
        return new Storage(
            '/some/directory'
        );
    },
    true
);
```

Доступ к этому сервису можно получить несколькими способами:

```php
<?php

use Phalcon\Mvc\Controller;

class FilesController extends Controller
{
    public function saveAction()
    {
        // Внедрение сервиса по имени, используя его как свойство
        $this->storage->save('/some/file');

        // Доступ к сервису с использованием DI
        $this->di->get('storage')->save('/some/file');

        // Ещё один способ — используя магический метод
        $this->di->getStorage()->save('/some/file');

        // Ещё больше магических методов для получения всей цепочки
        $this->getDi()->getStorage()->save('/some/file');

        // Используя синтаксис работы с массивами
        $this->di['storage']->save('/some/file');
    }
}
```

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/4.0/en/di) in the framework.

<a name='request-response'></a>

## Запрос и ответ

Давайте предположим, что фреймворк предоставляет набор предварительно зарегистрированных сервисов. В этом примере будет показано как работать с HTTP окружением. The `request` service contains an instance of [Phalcon\Http\Request](api/Phalcon_Http_Request) and the `response` contains a [Phalcon\Http\Response](api/Phalcon_Http_Response) representing what is going to be sent back to the client.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Проверяем, что данные пришли методом POST
        if ($this->request->isPost()) {
            // Получаем POST данные
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

Объект ответа обычно не используется напрямую и создается до выполнения действия, но иногда, например, в событии `afterDispatch` может быть полезно работать с ответом напрямую:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function notFoundAction()
    {
        // Отправляем статус HTTP 404
        $this->response->setStatusCode(404, 'Not Found');
    }
}
```

Learn more about the HTTP environment in their dedicated articles [request](/4.0/en/request) and [response](/4.0/en/response).

<a name='session-data'></a>

## Данные сессий

Sessions help us maintain persistent data between requests. You can access a [Phalcon\Session\Bag](api/Phalcon_Session_Bag) from any controller to encapsulate data that needs to be persistent:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Михаил';
    }

    public function welcomeAction()
    {
        echo 'Добро пожаловать, ', $this->persistent->name;
    }
}
```

<a name='services'></a>

## Использование сервисов как контроллеров

Сервисы могут работать в качестве контроллеров, классы контроллеров первым делом запрашиваются у сервиса контейнеров. Соответственно любой класс, зарегистрированный под именем контроллера, легко может его заменить:

```php
<?php

// Регистрируем контроллер как сервис
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Регистрируем контроллер как сервис с использованием пространства имён
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='events'></a>

## События контроллеров

Controllers automatically act as listeners for [dispatcher](/4.0/en/dispatcher) events, implementing methods with those event names allow you to implement hook points before/after the actions are executed:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // Это выполняется перед каждым обнаруженным действием
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "У вас нет разрешения на сохранение постов"
            );

            $this->dispatcher->forward(
                [
                    'controller' => 'home',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        // Выполняется после каждого действия
    }
}
```