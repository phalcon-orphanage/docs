<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Введение</a> <ul>
        <li>
          <a href="#using">Использование контроллеров</a>
        </li>
        <li>
          <a href="#dispatch-loop">Цикл работы</a>
        </li>
        <li>
          <a href="#initializing">Инициализация контроллеров</a>
        </li>
        <li>
          <a href="#injecting-services">Внедрение сервисов</a>
        </li>
        <li>
          <a href="#request-response">Запрос и ответ</a>
        </li>
        <li>
          <a href="#session-data">Данные сессий</a>
        </li>
        <li>
          <a href="#services">Использование сервисов как контроллеров</a>
        </li>
        <li>
          <a href="#events">События контроллеров</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Введение

<a name='using'></a>

## Использование контроллеров

Контроллеры содержат в себе ряд методов, называемых действиями (в англоязычной литературе — actions). Действия контроллеров занимаются непосредственно обработкой запросов. По умолчанию все публичные методы контролеров доступны для доступа по URL. Действия отвечают за разбор запросов (request) и создание ответов (response). Как правило, результаты работы действий используются для представлений, но так же возможно их иное использование.

Например, при обращении по ссылке: `http://localhost/blog/posts/show/2015/the-post-title` Phalcon разберёт её и получит следующие части:

| Описание                     | Часть URL-адреса |
| ---------------------------- | ---------------- |
| **Директория с приложением** | blog             |
| **Контроллер**               | posts            |
| **Действие**                 | show             |
| **Параметр**                 | 2015             |
| **Параметр**                 | the-post-title   |

Для этого случая запрос будет отправлен для обработки в контроллер `PostsController`. Для контроллеров нет какого-то специального места в приложении, они загружаются с помощью автозагрузки (например `Phalcon\Loader`), поэтому вы можете организовать их так, как вам необходимо.

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

Дополнительные URI-параметры передаются в качестве параметров действия, таким образом, они легко могут быть получены как локальные переменные. Контроллер может наследоваться от `Phalcon\Mvc\Controller`, но это не обязательно. В таком случае он получает доступ к сервисам приложения.

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

Метод `forwards` может быть вызван неограниченное количество раз, приложение будет выполняться, пока не появится явный сигнал для завершения. Если действия, которые должны быть выполнены, в цикле диспетчера завершены, то диспетчер автоматически вызовет MVC слой отображения (View), управляемый компонентом `Phalcon\Mvc\View`.

<a name='initializing'></a>

## Инициализация контроллеров

`Phalcon\Mvc\Controller` предлагает метод `initialize()`, который автоматически выполняется первым, перед любым другим действием контроллера. Использование метода `__construct()` не рекомендуется.

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

<h5 class='alert alert-warning'>Метод `initialize()` вызывается только в том случае, если событие `beforeExecuteRoute` было успешно выполнено. Это позволяет избежать выполнения логики приложения без авторизации.</h5>

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

<h5 class='alert alert-warning'>Имейте в виду, что метод `onConstruct()` выполняется, даже если действие, которое должно быть выполнено, не существует в контроллере, или пользователь не имеет к нему доступа (контроль доступа обеспечивает разработчик).</h5>

<a name='injecting-services'></a>

## Внедрение сервисов

Если контроллер наследует `Phalcon\Mvc\Controller`, то он автоматически получает доступ к контейнеру сервисов приложения. Например, если мы зарегистрируем некий сервис следующим образом:

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
        // Injecting the service by just accessing the property with the same name
        $this->storage->save('/some/file');

        // Accessing the service from the DI
        $this->di->get('storage')->save('/some/file');

        // Another way to access the service using the magic getter
        $this->di->getStorage()->save('/some/file');

        // Another way to access the service using the magic getter
        $this->getDi()->getStorage()->save('/some/file');

        // Using the array-syntax
        $this->di['storage']->save('/some/file');
    }
}
```

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/[[language]]/[[version]]/di) in the framework.

<a name='request-response'></a>

## Запрос и ответ

Assuming that the framework provides a set of pre-registered services. We explain how to interact with the HTTP environment. The `request` service contains an instance of `Phalcon\Http\Request` and the `response` contains a `Phalcon\Http\Response` representing what is going to be sent back to the client.

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
        // Check if request has made with POST
        if ($this->request->isPost()) {
            // Access POST data
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

The response object is not usually used directly, but is built up before the execution of the action, sometimes - like in an `afterDispatch` event - it can be useful to access the response directly:

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
        // Send a HTTP 404 response header
        $this->response->setStatusCode(404, 'Not Found');
    }
}
```

Learn more about the HTTP environment in their dedicated articles [request](/[[language]]/[[version]]/request) and [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Данные сессий

Sessions help us maintain persistent data between requests. You can access a `Phalcon\Session\Bag` from any controller to encapsulate data that needs to be persistent:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Michael';
    }

    public function welcomeAction()
    {
        echo 'Welcome, ', $this->persistent->name;
    }
}
```

<a name='services'></a>

## Использование сервисов как контроллеров

Services may act as controllers, controllers classes are always requested from the services container. Accordingly, any other class registered with its name can easily replace a controller:

```php
<?php

// Register a controller as a service
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Register a namespaced controller as a service
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='using'></a>

0## События контроллеров

Controllers automatically act as listeners for [dispatcher](/en/[[versopm]]/dispatcher) events, implementing methods with those event names allow you to implement hook points before/after the actions are executed:

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