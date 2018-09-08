<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Введение</a> 
      <ul>
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

<div class="alert alert-warning">
    <p>
       Метод <code>initialize()</code> вызывается только в том случае, если событие <code>beforeExecuteRoute</code> выполнено успешно. Это позволяет избежать ситуации, когда логика приложения в инициализаторе не может быть выполнена без авторизации.
    </p>
</div>

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

<div class='alert alert-warning'>
    <p>
        Имейте в виду, что метод <code>onConstruct()</code> выполняется, даже если действие, которое должно быть выполнено, не существует в контроллере, или пользователь не имеет к нему доступа (контроль доступа обеспечивает разработчик).
    </p>
</div>

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

Если вы используете все возможности Phalcon, прочитайте о сервисах используемых [по умолчанию](/[[language]]/[[version]]/di).

<a name='request-response'></a>

## Запрос и ответ

Давайте предположим, что фреймворк предоставляет набор предварительно зарегистрированных сервисов. В этом примере будет показано как работать с HTTP окружением. Сервис `request` содержит экземпляр `Phalcon\Http\Request`, а `response` — экземпляр `Phalcon\Http\Response`, являющийся тем, что должно быть отправлено клиенту.

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

Узнать больше о работе с HTTP окружением можно в соответствующих статьях [request](/[[language]]/[[version]]/request) и [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Данные сессий

Сессии позволяют сохранять данные между запросами. Вы можете получить доступ к `Phalcon\Session\Bag` из любого контроллера, чтобы сохранить данные, которые должны быть постоянными:

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

Контроллеры автоматически выступают в роли слушателей событий [диспетчера](/[[language]]/[[version]]/dispatcher), реализация методов с названиями событий позволяет выполнять какой-либо код до или после выполнения действия:

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