<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Хранение данных в сессии</a> 
      <ul>
        <li>
          <a href="#start">Запуск сессии</a>
          <ul>
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

* Вы можете легко изолировать сессии данных в различных приложениях на одном домене
* Можно перехватить места установки/получения данных в приложении
* Использование адаптера сессий, оптимального для текущего приложения

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

Из контроллера, представления или другого компонента расширяющего `Phalcon\Di\Injectable` можно получить доступ к сессиям и работать с ними следующим образом:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Установка значения сессии
        $this->session->set('user-name', 'Michael');
    }

    public function welcomeAction()
    {
        // Проверка наличия переменной сессии
        if ($this->session->has('user-name')) {
            // Получение значения
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## Удаление/очистка сессий

Таким же способом можно удалить переменную сессии, или целиком очистить сессию:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function removeAction()
    {
        // Удаление переменной сессии
        $this->session->remove('user-name');
    }

    public function logoutAction()
    {
        // Полная очистка сессии
        $this->session->destroy();
    }
}
```

<a name='data-isolation'></a>

## Изоляция данных сеанса между приложениями

Иногда пользователь может запускать одно и тоже приложение несколько раз, на одном и том же сервере, в одно время. Естественно, используя переменные сессий нам бы хотелось, чтобы все приложения получали доступ к разным сессиям (хотя в одинаковых приложениях и код одинаковый и названия переменных). Для решения этой проблемы можно использовать префикс для переменных сессий, разный для разных приложений:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Изоляция данных сессий
$di->set(
    'session',
    function () {
        // Все переменные этого приложения будет иметь префикс "my-app-1"
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

Добавлять префикс вручную во время установки или чтения сессий не обязательно.

<a name='bags'></a>

## Наборы сессий

Компонент `Phalcon\Session\Bag` (Sessions Bags, дословно "Мешки с сессиями") позволяет работать с сессиями разделяя их по пространствам имён. Работая таким образом, вы можете легко создавать группы переменных сессии в приложении. Установив значение переменной в сессионном объекте, это значение автоматически сохранится в сессии:

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

Контроллеры, компоненты и классы расширяющие `Phalcon\Di\Injectable` могут работать с `Phalcon\Session\Bag` напрямую. Компонент в таком случае изолирует данные для каждого класса. Благодаря этому вы можете сохранять данные между запросами, используя их как обычные переменные.

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Создаётся постоянная (persistent) переменная "name"
        $this->persistent->name = 'Laura';
    }

    public function welcomeAction()
    {
        if (isset($this->persistent->name)) {
            echo 'Привет, ', $this->persistent->name;
        }
    }
}
```

И в компоненте:

```php
<?php

use Phalcon\Mvc\User\Component;

class Security extends Component
{
    public function auth()
    {
        // Создаётся постоянная (persistent) переменная "name"
        $this->persistent->name = 'Laura';
    }

    public function getAuthName()
    {
        return $this->persistent->name;
    }
}
```

Данные, добавленные непосредственно в сессию (`$this->session`) доступны во всём приложении, в то время как persistent (`$this->persistent`) переменные доступны только внутри своего текущего класса.

<a name='custom-adapters'></a>

## Реализация собственных адаптеров

Для создания адаптера необходимо реализовать интерфейс `Phalcon\Session\AdapterInterface`, или использовать наследование от готового с доработкой необходимой логики.

Существует еще несколько типов адаптеров для работы с сессиями. Их можно получить в "Инкубаторе" — [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter).