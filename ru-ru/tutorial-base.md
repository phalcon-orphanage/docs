* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='basic'></a>

# Урок: Основы

В этом примере рассмотрим создание приложения с простой формой регистрации "с нуля". Также рассмотрим основные аспекты поведения фреймворка.

This tutorial covers the implementation of a simple MVC application, showing how fast and easy it can be done with Phalcon. This tutorial will get you started and help create an application that you can extend to address many needs. The code in this tutorial can also be used as a playground to learn other Phalcon specific concepts and ideas.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

If you just want to get started you can skip this and create a Phalcon project automatically with our [developer tools](/4.0/en/devtools-usage). Однако, если вы взялись за инструменты разработчика и застряли, не имяя опыта работы с ними, рекомендуется вернуться назад, к этим строкам.

Лучше всего следовать данному руководству шаг за шагом. Финальный пример можно посмотреть [здесь](https://github.com/phalcon/tutorial). Тем не менее, если вы запутаетесь, вы всегда можете обратиться за помощью в [Discord чат](https://phalcon.link/discord) или [задать вопрос на форуме](https://phalcon.link/forum).

<a name='file-structure'></a>

## Структура файлов

Ключевой особенностью фреймворка является слабая связанность. Он не обязывает использовать определенную структуру каталогов. Вы можете использовать любую удобную структуру проекта. Тем не менее, некоторая "узнаваемость" полезна когда вы работаете в команде По этой причине в этом руководстве будет использоваться некая "стандартная" структура, с которой вы должны себя чувствовать комфортно, если вы работали с другими MVC-приложениями в прошлом.   


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
        Примечание: Вы не видите директорию `vendor`, поскольку все основные зависимости фреймворка загружаются в память расширением Phalcon, которое вы должны были установить к этому моменту. If you missed that part have not installed the Phalcon extension [please go back](/4.0/en/installation) and finish the installation before continuing.
    </p>
</div>

If this is all brand new it is recommended that you install the [Phalcon Devtools](/4.0/en/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/4.0/en/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/4.0/en/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/4.0/en/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Начальная загрузка

The first file you need to create is the bootstrap file. Он крайне важен, так как является основой вашего приложения и дает вам контроль над всеми его аспектами. В данном файле вы можете реализовать как инициализацию компонентов, так и поведение приложения.

В общем случае, bootstrap-файл отвечает за следующие вещи: - Регистрация автозагрузчика - Конфигурирование сервисов и регистрация их в контейнере внедрения зависимостей - Обработка запросов к приложению

<a name='autoloaders'></a>

### Автозагрузка

Autoloaders leverage a [PSR-4](https://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon. Основными вещами, которые должны быть добавлены в автозагрузчик являются ваши контроллеры и модели. Вы можете зарегистрировать директории, которые будут использоваться для поиска классов использующих пространство имён приложения. If you want to read about other ways that you can use autoloaders head [here](/4.0/en/loader#overview).

Для начала, давайте зарегистрируем директории `controllers` и `models` нашего приложения. Для этого нам понадобится воспользоваться компонентом `Phalcon\Loader`.

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

Так как Phalcon является слабосвязанным фреймворком, сервисы регистриуются в контейнере внедрения зависимостей. Таким образом сервисы могут быть автоматически внедрены в компоненты и другие сервисы использующие [IoC](https://en.wikipedia.org/wiki/Inversion_of_control). Вы часто будете сталкиваться с термином DI, который и выступает в качестве контейнера внедрения зависимостей. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts: - Service Container: a "bag" where we globally store the services that our application needs to function. - Service or Component: Data processing object which will be injected into components

Каждый раз, когда фреймворку необходим какой-то компонент, он будет обращаться за ним к контейнеру, используя определенное имя компонента. Помните о том, что вам необходимо настроить и включить в ваше приложение `Phalcon\Di`.

<div class='alert alert-warning'>
    <p>
        Если вам по прежнему не хватает деталей, для понимания общей картины, обратитесь к статье [Martin Fowler](https://martinfowler.com/articles/injection.html). Also we have [a great tutorial](/4.0/en/di) covering many use cases.
    </p>
</div>

### Настройки по умолчанию

The [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) is a variant of [Phalcon\Di](api/Phalcon_Di). Он берет на себя функции регистрации большинства компонентов из состава Phalcon, поэтому нам не придется регистрировать их вручную один за другим. Обычно, мы рекомендуем регистрировать сервисы вручную, однако в целях данного рукводства мы будем использовать FactoryDefault в целях обеспечения более низкого порога вхождения. Позже вы всегда сможете указать конкретные сервисы вручную, самостоятельно, после того как вы будете себя чувствовать более комфортно с этой концепцией.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](https://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Создаём контейнер DI
$di = new FactoryDefault();
```

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

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

Затем мы регистрируем базовый URI так, чтобы все URI, которые генерирует Phalcon, совпадали с базовым путём приложения "/". This will become important later on in this tutorial when we use the class `Phalcon\Tag` to generate a hyperlink.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI
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

In the last part of this file, we find [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application). Its purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete.

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

### Соберём все компоненты вместе

The `tutorial/public/index.php` file should look like:

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

// Setup a base URI
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
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

Как вы можете видеть bootstrap-файл очень короткий нам не нужно подключать какие либо дополнительные файлы. Поздравляем, вы только что создали гибкое MVC-приложение, используя менее чем 30 строк кода.

<a name='controller'></a>

## Создание контроллера

По умолчанию Phalcon будет искать контроллер с именем `IndexController`. Он является исходной точкой, когда ни один другой контроллер или действие не были запрошены (например `https://localhost:8000/`). `IndexController` и его `IndexAction` должны выглядеть следующим образом:

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

![](/assets/images/content/tutorial-basic-1.png)

Congratulations, you're phlying with Phalcon!

<a name='view'></a>

## Отправка выходных данных в представление

Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (`app/views/index/index.phtml`):

`app/views/index/index.phtml`

```php
<?php echo "<h1>Привет!</h1>";
```

Our controller (`app/controllers/IndexController.php`) now has an empty action definition:

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

The browser output should remain the same. The `Phalcon\Mvc\View` static component is automatically created when the action execution has ended. Learn more about views usage [here](/4.0/en/views).

<a name='signup-form'></a>

## Проектирование формы регистрации

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

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

To generate the tag we use the class `Phalcon\Tag`. This is a utility class that allows us to build HTML tags with framework conventions in mind. Этот класс также является сервисом, зарегистрированным в DI, таким образом, мы используем `$this->tag` для доступа к нему.

A more detailed article regarding HTML generation [can be found here](/4.0/en/tag).

![](/images/content/tutorial-basic-2.png)

Here is the Signup controller (`app/controllers/SignupController.php`):

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

The empty index action gives the clean pass to a view with the form definition (`app/views/signup/index.phtml`):

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

Viewing the form in your browser will show something like this:

![](/assets/images/content/tutorial-basic-3.png)

[Phalcon\Tag](api/Phalcon_Tag) also provides useful methods to build form elements.

Метод `Phalcon\Tag::form()` принимает единственный аргумент, например, относительный URI контроллера/действия приложения.

При нажатии на кнопку "Регистрация" мы увидим исключение, вызванное фреймворком. Оно говорит нам о том, что у нашего контроллера "signup" отсутствует действие "register". Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementing that method will remove the exception:

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

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

<a name='model'></a>

## Создание модели

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

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

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

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

Чтобы использовать подключение к базе данных и затем получить доступ к данным через наши модели, нам нужно указать его в процессе начальной загрузки. A database connection is just another service that our application has that can be used for several components:

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

With the correct database parameters, our models are ready to work and interact with the rest of the application.

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

В начале метода `registerAction` мы создаем экземпляр модели Users, отвечающий за записи пользователей. Публичные свойства класса указывают на их одноименные названия полей в таблице `users` нашей базы данных. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Для полей, у которых установлен параметр not null (обязательные), вызывается дополнительная валидация. Если мы ничего не введем в форме регистрации, то получим что-то вроде этого:

![](/assets/images/content/tutorial-basic-4.png)

<a name='list-of-users'></a>

## List of users

Now let's see how to obtain and see the users that we have registered in the database.

The first thing that we are going to do in our `indexAction` of the`IndexController` is to show the result of the search of all the users, which is done simply in the following way `Users::find()`. Let's see how our `indexAction` would look

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Welcome and user list
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

Now, in our view file `views/index/index.phtml` we will have access to the users found in the database. These will be available in the variable `$users`. This variable has the same name as the one we use in `$this->view->users`.

The view will look like this:

`views/index/index.phtml`

```html
<?php

echo "<h1>Hello!</h1>";

echo $this->tag->linkTo(["signup", "Sign Up Here!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">Users quantity: <?php echo $users->count(); ?></td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->email; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
```

As you can see our variables `$users` can be iterated and counted, this we will see in depth later on when viewing the [models](/4.0/en/db-models).

![](/images/content/tutorial-basic-5.png)

<a name='adding-style'></a>

## Adding Style

To give a design touch to our first application we will add bootstrap and a small template that will be used in all views.

We will add an `index.phtml` file in the`views` folder, with the following content:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

The most important thing to highlight in our template is the function `getContent()` which will give us the content generated by the view. Now, our application will be something like this:

![](/images/content/tutorial-basic-6.png)

<a name='conclusion'></a>

## Заключение

На этом очень простом руководстве можно увидеть, как легко начать создавать приложения с помощью Phalcon. Тот факт, что Phalcon поставляется расширением значительно уменьшает объем проектов, а также значительно добавляет им производительности.

If you are ready to learn more check out the [Rest Tutorial](/4.0/en/tutorial-rest) next.