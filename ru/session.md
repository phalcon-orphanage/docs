<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Хранение данных в сессии</a> <ul>
        <li>
          <a href="#start">Запуск сессии</a> <ul>
            <li>
              <a href="#start-factory">Фабрика</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#store">Получение и хранение данных в сессии</a>
        </li>
        <li>
          <a href="#remove-destroy">Удаление/очистка сессий</a>
        </li>
        <li>
          <a href="#data-isolation">Изоляция данных сеанса между приложениями</a>
        </li>
        <li>
          <a href="#bags">Наборы сессий</a>
        </li>
        <li>
          <a href="#data-persistency">Сохранение данных в компонентах</a>
        </li>
        <li>
          <a href="#custom-adapters">Реализация собственных адаптеров</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Хранение данных в сессии

Компонент сессии предоставляет объектно-ориентированный интерфейс для работы с сессиями.

Причины использования этого компонента, а не обычных сессий:

- Вы можете легко изолировать сессии данных в различных приложениях на одном домене
- Можно перехватить места установки/получения данных в приложении
- Использование адаптера сессий, оптимального для текущего приложения

<a name='start'></a>

## Запуск сессии

Некоторые приложения активно используют в своей работе сессии, используя их в каждом действии. Другие наоборот, используют сессии мало и не часто. Благодаря использованию контейнера сервисов, мы можем гарантировать, что запуск сессий будет произведён только по необходимости:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Сессии запустятся один раз, при первом обращении к объекту
$di->setShared(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

<a name='start-factory'></a>

## Фабрика

Загружает адаптер используя параметр `adapter`.

```php
<?php

use Phalcon\Session\Factory;

$options = [
    'uniqueId'   => 'my-private-app',
    'host'       => '127.0.0.1',
    'port'       => 11211,
    'persistent' => true,
    'lifetime'   => 3600,
    'prefix'     => 'my_',
    'adapter'    => 'memcache',
];

$session = Factory::load($options);
```

<a name='store'></a>

## Получение и хранение данных в сессии

From a controller, a view or any other component that extends `Phalcon\Di\Injectable` you can access the session service and store items and retrieve them in the following way:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->session->set('user-name', 'Michael');
    }

    public function welcomeAction()
    {
        // Check if the variable is defined
        if ($this->session->has('user-name')) {
            // Retrieve its value
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## Удаление/очистка сессий

It's also possible remove specific variables or destroy the whole session:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function removeAction()
    {
        // Remove a session variable
        $this->session->remove('user-name');
    }

    public function logoutAction()
    {
        // Destroy the whole session
        $this->session->destroy();
    }
}
```

<a name='data-isolation'></a>

## Изоляция данных сеанса между приложениями

Sometimes a user can use the same application twice, on the same server, in the same session. Surely, if we use variables in session, we want that every application have separate session data (even though the same code and same variable names). To solve this, you can add a prefix for every session variable created in a certain application:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Isolating the session data
$di->set(
    'session',
    function () {
        // All variables created will prefixed with 'my-app-1'
        $session = new Session(
            [
                'uniqueId' => 'my-app-1',
            ]
        );

        $session->start();

        return $session;
    }
);
```

Adding a unique ID is not necessary.

<a name='bags'></a>

## Наборы сессий

`Phalcon\Session\Bag` is a component that helps separating session data into `namespaces`. Working by this way you can easily create groups of session variables into the application. By only setting the variables in the `bag`, it's automatically stored in session:

```php
<?php

use Phalcon\Session\Bag as SessionBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
```

<a name='data-persistency'></a>

## Сохранение данных в компонентах

Controller, components and classes that extends `Phalcon\Di\Injectable` may inject a `Phalcon\Session\Bag`. This class isolates variables for every class. Thanks to this you can persist data between requests in every class in an independent way.

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Create a persistent variable 'name'
        $this->persistent->name = 'Laura';
    }

    public function welcomeAction()
    {
        if (isset($this->persistent->name)) {
            echo 'Welcome, ', $this->persistent->name;
        }
    }
}
```

In a component:

```php
<?php

use Phalcon\Mvc\User\Component;

class Security extends Component
{
    public function auth()
    {
        // Create a persistent variable 'name'
        $this->persistent->name = 'Laura';
    }

    public function getAuthName()
    {
        return $this->persistent->name;
    }
}
```

The data added to the session (`$this->session`) are available throughout the application, while persistent (`$this->persistent`) can only be accessed in the scope of the current class.

<a name='custom-adapters'></a>

## Реализация собственных адаптеров

The `Phalcon\Session\AdapterInterface` interface must be implemented in order to create your own session adapters or extend the existing ones.

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter)