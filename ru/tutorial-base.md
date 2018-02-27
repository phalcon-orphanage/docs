<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Урок: Основы</a> 
      <ul>
        <li>
          <a href="#file-structure">Структура файлов</a>
        </li>
        <li>
          <a href="#bootstrap">Начальная загрузка</a> 
          <ul>
            <li>
              <a href="#autoloaders">Автозагрузка</a>
            </li>
            <li>
              <a href="#dependency-management">Управление зависимостями</a>
            </li>
            <li>
              <a href="#request">Обработка входящих запросов</a>
            </li>
            <li>
              <a href="#full-example">Соберём все компоненты вместе</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">Создание контроллера</a>
        </li>
        <li>
          <a href="#view">Отправка выходных данных в представление</a>
        </li>
        <li>
          <a href="#signup-form">Проектирование формы регистрации</a>
        </li>
        <li>
          <a href="#model">Создание модели</a>
        </li>
        <li>
          <a href="#database-connection">Настройка соединения с базой данных</a>
        </li>
        <li>
          <a href="#storing-data">Сохранение данных при работе с моделями</a>
        </li>
        <li>
          <a href="#conclusion">Заключение</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Урок: Основы

В этом примере рассмотрим создание приложения с простой формой регистрации "с нуля". Также рассмотрим основные аспекты поведения фреймворка.

This tutorial covers the implementation of a simple MVC application, showing how fast and easy it can be done with Phalcon. This tutorial will get you started and help create an application that you can extend to address many needs. The code in this tutorial can also be used as a playground to learn other Phalcon specific concepts and ideas.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

Если вы хотели бы сразу начать писать код, не останавливаясь на создании структуры приложения, обратитесь к разделу "[Инструменты разработчика Phalcon](/[[language]]/[[version]]/devtools-usage)" для автоматической генерации этой структуры. Однако, если вы взялись за инструменты разработчика и застряли, не имяя опыта работы с ними, рекомендуется вернуться назад, к этим строкам.

Лучше всего следовать данному руководству шаг за шагом. Финальный пример можно посмотреть [здесь](https://github.com/phalcon/tutorial). If you get hung-up on something please visit us on [Discord](https://phalcon.link/discord) or in our [Forum](https://phalcon.link/forum).

<a name='file-structure'></a>

## Структура файлов

A key feature of Phalcon is it's loosely coupled, you can build a Phalcon project with a directory structure that is convenient for your specific application. Тем не менее, некоторая "узнаваемость" полезна когда вы работаете в команде По этой причине в этом руководстве будет использоваться некая "стандартная" структура, с которой вы должны себя чувствовать комфортно, если вы работали с другими MVC-приложениями в прошлом.   


```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

<div class='alert alert-warning'>
    <p>
        Примечание: Вы не видите директорию `vendor`, поскольку все основные зависимости фреймворка загружаются в память расширением Phalcon, которое вы должны были установить к этому моменту. Если вы пропустили этап установки и расширение Phalcon у вас отсутствует, <a href="/[[language]]/[[version]]/installation">вернитесь назад и завершите установку</a> перед продолжением работы с этим руководством.
    </p>
</div>

Если всё это совершенно в новинку для вас и вы испытываете затруднения с некоторыми базовыми аспектами, рекомендуется установить [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation), поскольку этот инструмент использует встроенный в PHP веб-вервер и помогает сделать вам быстрый старт, без необходимости установки дополнительного программного обеспечения.

Otherwise if you want to use Nginx here are some additional setup [here](/[[language]]/[[version]]/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/[[language]]/[[version]]/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/[[language]]/[[version]]/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Начальная загрузка

Первый файл, который необходимо создать - bootstrap-файл. Он крайне важен, так как является основой вашего приложения и дает вам контроль над всеми его аспектами. В данном файле вы можете реализовать как инициализацию компонентов, так и поведение приложения.

This file handles 3 things: - Registration of component autoloaders - Configuring Services and registering them with the Dependency Injection context - Resolving the application's HTTP requests

<a name='autoloaders'></a>

### Автозагрузка

Autoloaders leverage a [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon. Common things that should be added to the autoloader are your controllers and models. You can register directories which will search for files within the application's namespace. If you want to read about other ways that you can use autoloaders head [here](/[[language]]/[[version]]/loader#overview).

To start, lets register our app's `controllers` and `models` directories. Don't forget to include the loader from `Phalcon\Loader`.

`public/index.php`

```php
<?php

use Phalcon\Loader;

// Определяем некоторые константы с абсолютными путями
// для использования с локальными ресурасами
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();
```

<a name='dependency-management'></a>

### Управление зависимостями

Since Phalcon is loosely coupled, services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the [IoC](https://en.wikipedia.org/wiki/Inversion_of_control) container. Frequently you will encounter the term DI which stands for Dependency Injection. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts: - Service Container: a "bag" where we globally store the services that our application needs to function. - Service or Component: Data processing object which will be injected into components

Каждый раз, когда фреймворку необходим какой-то компонент, он будет обращаться за ним к контейнеру, используя определенное имя компонента. Помните о том, что вам необходимо настроить и включить в ваше приложение `Phalcon\Di`.

<div class='alert alert-warning'>
    <p>
        If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html). Also we have [a great tutorial](/[[language]]/[[version]]/di) covering many use cases.
    </p>
</div>

### Настройки по умолчанию

The `Phalcon\Di\FactoryDefault` is a variant of `Phalcon\Di`. To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Создаём контейнер DI
$di = new FactoryDefault();
```

На следующем шаге мы регистрируем сервис “view”, указав директорию, где фреймворк будет искать представления. Так как данные файлы не относятся к классам, они не могут быть подгружены автозагрузчиком.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

// Настраиваем компонент представлений
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

Затем мы регистрируем базовый URI так, чтобы все URI, которые генерирует Phalcon, совпадали с базовым путём приложения "/". Это пригодится нам позднее в данном уроке, когда будем использовать класс `Phalcon\Tag` для генерации ссылок.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Настраиваем базовый URI
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);
```

<a name='request'></a>

### Обработка входящих запросов

На последнем этапе мы используем `Phalcon\Mvc\Application`. Данный компонент служит для инициализации окружения входящих запросов, их перенаправления и обслуживания относящихся к ним действий. После отработки всех доступных действий, компонент возвращает полученные ответы.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);
$response = $application->handle();
$response->send();
```

<a name='full-example'></a>

### Соберём все вместе

Файл `tutorial/public/index.php` имеет следующее содержимое:

`public/index.php`

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;

// Определяем некоторые константы с абсолютными путями
// для использования с локальными ресурасами
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Регистрируем автозагрузчик
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

// Создаём контейнер DI
$di = new FactoryDefault();

// астраиваем компонент представлений
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

// Настраиваем базовый URI
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($di);

try {
    // Обрабатываем запрос
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Ошибка: ', $e->getMessage();
}
```

Как вы можете видеть bootstrap-файл очень короткий нам не нужно подключать какие либо дополнительные файлы. Поздравляем, вы только что создали гибкое MVC-приложение, используя менее чем 30 строк кода.

<a name='controller'></a>

## Создание контроллера

По умолчанию Phalcon будет искать контроллер с именем `IndexController`. Он является исходной точкой, когда ни один другой контроллер или действие не были запрошены (например `http://localhost:8000/`). `IndexController` и его `IndexAction` должны выглядеть следующим образом:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Привет!</h1>';
    }
}
```

Классы контроллеров должны заканчиваться суффиксом `Controller`, чтобы автозагрузчик смог загрузить их, а методы контроллеров должны заканчиваться суффиксом `Action`. Теперь можно открыть браузер и увидеть похожий результат:

![](/images/content/tutorial-basic-1.png)

Поздравляем! Вы готовы к полёту с Phalcon!

<a name='view'></a>

## Отправка результатов в представление

Отображение вывода напрямую из контроллера иногда бывает необходимым решением, но нежелательно, и сторонники шаблона MVC это подтвердят. Данные должны передаваться представлению, ответственному за отображение данных. Phalcon ищет файл представления с именем, совпадающим с именем действия внутри папки, носящей имя последнего запущенного контроллера. В нашем случае это будет выглядеть так (`app/views/index/index.phtml`):

`app/views/index/index.phtml`

```php
<?php echo "<h1>Привет!</h1>";
```

В нашем контроллере (`app/controllers/IndexController.php`) сейчас существует пустое действие:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

    }
}
```

Вывод браузера останется прежним. Когда метод контроллера завершит свою работу, будет автоматически создан статический компонент `Phalcon\Mvc\View`. Узнать больше о использовании представлений [можно здесь](/[[language]]/[[version]]/views).

<a name='signup-form'></a>

## Проектирование формы регистрации

Давайте теперь изменим файл представления `index.phtml`, добавив ссылку на новый контроллер “signup”.

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Привет!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Регистрируйся!'
);
```

Сгенерированный HTML-код будет выводить ссылку (тэг `<a>`), указывающую на наш новый контроллер:

`app/views/index/index.phtml` (сгенерированный)

```html
<h1>Привет!</h1>

<a href="/signup">Регистрируйся!</a>
```

Для генерации тэга мы воспользовались встроенным классом `Phalcon\Tag`. Это служебный класс, позволяющий конструировать HTML-разметку в Phalcon-подобном стиле. Этот класс также является сервисом, зарегистрированным в DI, таким образом, мы используем `$this->tag` для доступа к нему.

Более подробно о генерации HTML можно [узнать здесь](/[[language]]/[[version]]/tag).

![](/images/content/tutorial-basic-2.png)

Контроллер Signup (`app/controllers/SignupController.php`):

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }
}
```

Пустое действие index говорит нам о том, что будет использоваться одноименный файл представления с нашей формой для регистрации (`app/views/signup/index.phtml`):

`app/views/signup/index.phtml`

```html
<h2>Зарегистрируйтесь, используя эту форму</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Имя</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Регистрация"); ?>
    </p>

</form>
```

В браузере это будет выглядеть так:

![](/images/content/tutorial-basic-3.png)

Класс `Phalcon\Tag` также содержит полезные методы для работы с формами.

Метод `Phalcon\Tag::form()` принимает единственный аргумент, например, относительный URI контроллера/действия приложения.

При нажатии на кнопку "Регистрация" мы увидим исключение, вызванное фреймворком. Оно говорит нам о том, что у нашего контроллера "signup" отсутствует действие "register". Наш `public/index.php` файл выбросит исколючение:

    Exception: Action "register" was not found on handler "signup"
    

Реализация этого метода предотвратит выброс исключения:

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {

    }
}
```

Если вы снова нажмёте на кнопку "Регистрация", вы увидите пустую страницу. Поля name и email, введенные пользователем, должны сохраниться в базе данных. В соответствии с принципами MVC, все взаимодействие с БД должно вестись через модели, таким образом, следуя традициям ООП-стиля.

<a name='model'></a>

## Создание модели

Phalcon предоставляет первый ORM для PHP полностью написанный на языке C. Вместо увеличения сложности разработки, он её упрощает.

Перед созданием нашей первой модели, нам нужно создать таблицу базы данных за пределами Phalcon и сопоставить их. Простая таблица для хранения зарегистрированных пользователей может быть создана следующим образом:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

Модель должна быть размещена в папке `app/models` (`app/models/Users.php`). Модель относится к таблице "users":

`app/models/Users.php`

```php
<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
}
```

<a name='database-connection'></a>

## Настройка соединения с базой данных

Чтобы использовать подключение к базе данных и затем получить доступ к данным через наши модели, нам нужно указать его в процессе начальной загрузки. Соединение с базой данных — это всего лишь ещё один сервис нашего приложения, который может быть использован для различных компонентов:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Настраиваем сервис для работы с БД
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial1',
            ]
        );
    }
);
```

При правильных настройках подключения наши модели будут готовы к работе и взаимодействию с остальными частями приложения.

<a name='storing-data'></a>

## Сохранение данных при работе с моделями

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new Users();

        // Store and check for errors
        $success = $user->save(
            $this->request->getPost(),
            [
                "name",
                "email",
            ]
        );

        if ($success) {
            echo "Спасибо за регистрацию!";
        } else {
            echo "К сожалению, возникли следующие проблемы: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

В начале метода `registerAction` мы создаем экземпляр модели Users, отвечающий за записи пользователей. Публичные свойства класса указывают на их одноименные названия полей в таблице `users` нашей базы данных. Установка соответствующих значений в новой записи и вызов метода `save()` сохранит данные в базе данных. Метод `save()` возвращает булево значение, указывающее, успешно ли были сохранены данные в таблице или нет (true и false, соответственно).

ORM автоматически экранирует ввод для предотвращения SQL-инъекций, так что мы можем передавать тело HTTP-запроса напрямую методу `save()`.

Для полей, у которых установлен параметр not null (обязательные), вызывается дополнительная валидация. Если мы ничего не введем в форме регистрации, то получим что-то вроде этого:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Заключение

На этом очень простом руководстве можно увидеть, как легко начать создавать приложения с помощью Phalcon. Тот факт, что Phalcon поставляется расширением значительно уменьшает объем проектов, а также значительно добавляет им производительности.

[Продолжайте читать](/[[language]]/[[version]]/tutorial-rest) дальше, если вы готовы узнать больше.