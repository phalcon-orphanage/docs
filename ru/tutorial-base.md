<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Урок: Основы</a> <ul>
        <li>
          <a href="#file-structure">Структура файлов</a>
        </li>
        <li>
          <a href="#bootstrap">Начальная загрузка</a> <ul>
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

В этом примере рассмотрим создание приложения с простой формой регистрации “с нуля”. Также рассмотрим основные аспекты поведения фреймворка. Если вы заинтересованы в автоматических инструментах поколения кода для Phalcon, то вы можете проверить наше [developer tools](/[[language]]/[[version]]/developer-tools).

Лучше всего следовать данному руководству шаг за шагом. Полный код можно посмотреть [здесь](https://github.com/phalcon/tutorial).

<a name='file-structure'></a>

## Структура файлов

Phalcon не обязывает использовать определенную структуру каталогов. Ввиду слабой связанности фреймворка, вы можете использовать любую удобную структуру.

В качестве отправной точки для данного урока мы предлагаем следующую структуру:

```bash
tutorial/
  app/
    controllers/
    models/
    views/
  public/
    css/
    img/
    js/
```

Обратите внимание на то, что вам не нужны директории с библиотеками, относящимися к фреймворку. Он полностью находится в памяти и все время готов к использованию.

Прежде чем продолжить, пожалуйста, убедитесь, что вы успешно [installed Phalcon](/[[language]]/[[version]]/installation) и установка [nginX](/[[language]]/[[version]]/setup#nginx), [Apache](/[[language]]/[[version]]/setup#apache) or [Cherokee](/[[language]]/[[version]]/setup#cherokee).

<a name='bootstrap'></a>

## Начальная загрузка

The first file you need to create is the bootstrap file. Этот файл очень важен, так как он служит основой вашего приложения, давая вам контроль над всеми его аспектами. В этом файле можно реализовать инициализацию компонентов, а также поведение приложения.

В конечном счете, он отвечает за выполнение 3 вещей:

- Настройка автозаполнителя.
- Настройка инжектора зависимостей.
- Обработка запроса приложения.

<a name='autoloaders'></a>

### Автозагрузка

Первая часть, которую мы находим в bootstrap-это Регистрация автозагрузчика. Это будет использоваться для загрузки классов в качестве контроллеров и моделей в приложении. Например, мы можем зарегистрировать один или несколько каталогов контроллеров, повышающих гибкость приложения. В нашем примере мы использовали компонент`Phalcon\Loader`.

С его помощью мы можем загружать классы, используя различные стратегии, но для этого примера мы выбрали, чтобы найти классы на основе предопределенных каталогов:

```php
<?php

use Phalcon\Loader;

// ...

$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
    ]
);

$loader->register();
```

<a name='dependency-management'></a>

### Управление зависимостями

Очень важным понятием, которое необходимо понимать при работе с Phalcon, является его `контейнер для инъекций зависимостей <di>`. Это может показаться сложным, но на самом деле очень простой и практичный.

Контейнер службы-это мешок, в котором мы глобально храним службы, которые наше приложение будет использовать для работы. Каждый раз, когда Платформа требует компонент, он будет запрашивать контейнер с использованием согласованного имени для службы. Так как Phalcon является высоко развязанные рамки, `Phalcon\Di` действует как клей облегчая интеграцию различных компонентов достигая их работы совместно в прозрачном образе.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` is a variant of `Phalcon\Di`. Чтобы сделать вещи проще, он зарегистрировал большинство компонентов, которые поставляются с Phalcon. Поэтому мы не должны регистрировать их по одному. Позже не будет никаких проблем в замене заводской службы.

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

Услуги могут быть зарегистрированы несколькими способами, но для нашего урока мы будем использовать функцию [anonymous](http://php.net/manual/en/functions.anonymous.php):

```php
<?php

use Phalcon\Mvc\View;

// ...

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

Далее мы регистрируем базовый URI, так что все URI генерируется "Фэлкон" включить папку "учебник" мы настроили ранее. This will become important later on in this tutorial when we use the class `Phalcon\Tag` to generate a hyperlink.

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

        return $url;
    }
);
```

<a name='request'></a>

### Обработка входящих запросов

In the last part of this file, we find `Phalcon\Mvc\Application`. Its purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete.

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

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
    ]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

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

Как видите, загрузочный файл занимает очень короткий и нам не нужно включать какие-либо дополнительные файлы. Мы установили себе гибкое приложение MVC в менее чем 30 строк кода.

<a name='controller'></a>

## Создание контроллера

По умолчанию Phalcon будет искать контроллер с именем "Index". Это-начальная точка, когда никакой контроллер или действие не были переданы в запросе. Контроллер индекса (`App/controllers/IndexController.php`) выглядит так:

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

The controller classes must have the suffix "Controller" and controller actions must have the suffix "Action". If you access the application from your browser, you should see something like this:

![](/images/content/tutorial-basic-1.png)

Congratulations, you're phlying with Phalcon!

<a name='view'></a>

## Отправка результатов в представление

Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (`app/views/index/index.phtml`):

```php
<?php echo "<h1>Привет!</h1>";
```

Our controller (`app/controllers/IndexController.php`) now has an empty action definition:

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

The browser output should remain the same. The `Phalcon\Mvc\View` static component is automatically created when the action execution has ended. Подробнее об использовании представлений `здесь <views>`.

<a name='signup-form'></a>

## Проектирование формы регистрации

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    "signup",
    "Sign Up Here!"
);
```

The generated HTML code displays an anchor ("a") HTML tag linking to a new controller:

```html
<h1>Hello!</h1>

<a href="/tutorial/signup">Sign Up Here!</a>
```

To generate the tag we use the class `Phalcon\Tag`. This is a utility class that allows us to build HTML tags with framework conventions in mind. Поскольку этот класс также является сервисом, зарегистрированным в DI, мы используем `$this>tag` обращаться к нему.

Более подробная статья о генерации HTML может быть :doc:`found here <tags>`.

![](/images/content/tutorial-basic-2.png)

Here is the Signup controller (`app/controllers/SignupController.php`):

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

```php
<h2>
    Sign up using this form
</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">
            Name
        </label>

        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">
            E-Mail
        </label>

        <?php echo $this->tag->textField("email"); ?>
    </p>



    <p>
        <?php echo $this->tag->submitButton("Register"); ?>
    </p>

</form>
```

Viewing the form in your browser will show something like this:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` also provides useful methods to build form elements.

The :code:`Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementing that method will remove the exception:

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

## Creating a Model

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Прежде чем создавать нашу первую модель, нам нужно создать таблицу базы данных за пределами Phalcon, чтобы сопоставить ее. Простая Таблица для хранения зарегистрированных пользователей может быть определена следующим образом:

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

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

## Setting a Database Connection

Для того, чтобы иметь возможность использовать подключение к базе данных и затем получить доступ к данным через наши модели, мы должны уточнить его в процессе начальной загрузки. A database connection is just another service that our application has that can be used for several components:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Setup the database service
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'test_db',
            ]
        );
    }
);
```

With the correct database parameters, our models are ready to work and interact with the rest of the application.

<a name='storing-data'></a>

## Storing data using models

Следующим шагом является получение данных из формы и их хранение в таблице.

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
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

Затем мы создаем экземпляр класса Users, который соответствует записи Пользователя. Открытые свойства класса сопоставляются с полями записи в таблице пользователи. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Дополнительная проверка выполняется автоматически для полей, которые определены как not null (обязательно). Если мы не введем ни одно из обязательных полей в форме регистрации, наш экран будет выглядеть так:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Заключение

На этом очень простом руководстве можно увидеть, как легко начать создавать приложения с помощью Phalcon. То, что Phalcon является расширением, никак не влияет на сложность разработки и доступные возможности. Мы приглашаем вас продолжить читать данное руководство для изучения дополнительных возможностей, которые предоставляет Phalcon!