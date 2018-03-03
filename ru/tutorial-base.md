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

Если вы хотели бы сразу начать писать код, не останавливаясь на создании структуры приложения, обратитесь к разделу "[Инструменты разработчика Phalcon](/[[language]]/[[version]]/devtools-usage)" для автоматической генерации этой структуры. Однако, если вы взялись за инструменты разработчика и застряли, не имяя опыта работы с ними, рекомендуется вернуться назад, к этим строкам.

Лучше всего следовать данному руководству шаг за шагом. Финальный пример можно посмотреть [здесь](https://github.com/phalcon/tutorial). Тем не менее, если вы запутаетесь, вы всегда можете обратиться за помощью в [Discord чат](https://phalcon.link/discord) или [задать вопрос на форуме](https://phalcon.link/forum).

<a name='file-structure'></a>

## Структура файлов

Ключевой особенностью фреймворка является слабая связанность. Он не обязывает использовать определенную структуру каталогов. Вы можете использовать любую удобную структуру проекта. Тем не менее, некоторая "узнаваемость" полезна когда вы работаете в команде По этой причине в этом руководстве будет использоваться некая "стандартная" структура, с которой вы должны себя чувствовать комфортно, если вы работали с другими MVC-приложениями в прошлом.   


```text
┗ tutorial
   ┣ app
   ┇ ┣ controllers
   ┇ ┇ ┣ IndexController.php
   ┇ ┇ ┗ SignupController.php
   ┇ ┣ models
   ┇ ┇ ┗ Users.php
   ┇ ┗ views
   ┗ public
      ┣ css
      ┣ img
      ┣ js
      ┗ index.php
```

Примечание: Вы не видите директорию **vendor**, поскольку все основные зависимости фреймворка загружаются в память расширением Phalcon, которое вы должны были установить к этому моменту. Если вы пропустили этап установки и расширение Phalcon у вас отсутствует, [вернитесь назад и завершите установку](/[[language]]/[[version]]/installation) перед продолжением работы с этим руководством.

Если всё это совершенно в новинку для вас и вы испытываете затруднения с некоторыми базовыми аспектами, рекомендуется установить [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation), поскольку этот инструмент использует встроенный в PHP веб-вервер и помогает сделать вам быстрый старт, без необходимости установки дополнительного программного обеспечения.

В противном случае, если вы хотите использовать Nginx, у нас есть [руководство по настройке Nginx для Phalcon проектов](/[[language]]/[[version]]/webserver-setup#nginx).

Вы также можете использовать Apache. Советуем обратится к [соответствующему разделу по его настройке](/[[language]]/[[version]]/webserver-setup#apache).

Наконец, если вы предпочитаете Cherokee, обратитесь к нашему [руководству по его настройке](/[[language]]/[[version]]/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Начальная загрузка

Первый файл, который необходимо создать - bootstrap-файл. Он крайне важен, так как является основой вашего приложения и дает вам контроль над всеми его аспектами. В данном файле вы можете реализовать как инициализацию компонентов, так и поведение приложения.

В общем случае, bootstrap-файл отвечает за следующие вещи: - Настройка автозагрузчика - Конфигурирование сервисов и регистрация их контейнере зависимостей DI - Обработка запроса к приложению

<a name='autoloaders'></a>

### Автозагрузка

Phalcon предоставляет [PSR-4](http://www.php-fig.org/psr/psr-4/)-совместимый автозагручик. Основными вещами, которые должны быть в него добавлены являются ваши директории с контроллерами и моделями. Вы зарегистрировать директории, которые будут использоваться для поиска классов использующих пространство имён приложения. Если вы хотите ознакомится с другими стратегиями, которые вы можете использовать с автозагрузчиком, обратитесь к руководству по [Phalcon Autoloader](/[[language]]/[[version]]/loader#overview).

Для начала, давайте зарегистрируем директории **controllers** и **models** нашего приложения. Для этого нам понадобится воспользоваться компонентом `Phalcon\Loader`.

  
**public/index.php**

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

Since Phalcon is **loosely coupled** services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the **IoC** container. Frequently you will encounter the term **DI** which stands for Dependency Injection. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts: - Service Container: a "bag" where we globally store the services that our application needs to function. - Service or Component: Data processing object which will be injected into components

If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html)

Each time the framework requires a component or service, it will ask the container using an agreed upon name for the service. Don't forget to include `Phalcon\Di` with setting up the service container.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

### Настройки по умолчанию

`Phalcon\Di\FactoryDefault` является вариантом `Phalcon\Di`. To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

  
**public/index.php**

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Создаём контейнер DI
$di = new FactoryDefault();
```

  


На следующем шаге мы регистрируем сервис “view”, указав директорию, где фреймворк будет искать представления. Так как данные файлы не относятся к классам, они не могут быть подгружены автозагрузчиком.

  
**public/index.php**

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

  


Next, we register a base URI so that all URIs generated by Phalcon include the "tutorial" folder we setup earlier. Это пригодится нам позднее в данном уроке, когда будем использовать класс `Phalcon\Tag` для генерации ссылок.

  
**public/index.php**

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI so that all generated URIs include the "tutorial" folder
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

  
**public/index.php**

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

  
**public/index.php**

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Define some absolute path constants to aid in locating resources
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

// Setup a base URI so that all generated URIs include the "tutorial" folder
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

  
As you can see, the bootstrap file is very short and we do not need to include any additional files. **Congratulations** you are well on your to having created a flexible MVC application in less than 30 lines of code.

<a name='controller'></a>

## Создание контроллера

By default Phalcon will look for a controller named **IndexController**. It is the starting point when no controller or action has been added in the request. (eg. http://localhost:8000/) An **IndexController** and its **IndexAction** should resemble the following example:

  
**app/controllers/IndexController.php**

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

Классы контроллеров должны заканчиваться суффиксом “Controller”, чтобы автозагрузчик смог загрузить их, а их методы должны заканчиваться суффиксом “Action”. Теперь можно открыть браузер и увидеть результат:

  
![](/images/content/tutorial-basic-1.png)

  
Поздравляем! Вы готовы к полёту с Phalcon!

<a name='view'></a>

## Отправка результатов в представление

Отображение вывода напрямую из контроллера иногда бывает необходимым решением, но нежелательно, и сторонники шаблона MVC это подтвердят. Данные должны передаваться представлению, ответственному за отображение данных. Phalcon ищет файл представления с именем, совпадающим с именем действия внутри папки, носящей имя последнего запущенного контроллера. В нашем случае это будет выглядеть так (`app/views/index/index.phtml`):

  
**app/views/index/index.phtml**

```php
<?php echo "<h1>Привет!</h1>";
```

  


В нашем контроллере (`app/controllers/IndexController.php`) сейчас существует пустое действие:

  
**app/controllers/IndexController.php**

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

  


Вывод браузера останется прежним. Когда метод контроллера завершит свою работу, будет автоматически создан статический компонент `Phalcon\Mvc\View`. Узнать больше о представлениях Узнать больше о представлениях `можно обратившись к соответствующему разделу <views>`.

<a name='signup-form'></a>

## Проектирование формы регистрации

Давайте теперь изменим файл представления `index.phtml`, добавив ссылку на новый контроллер “signup”. Идея проста — позволить пользователям регистрироваться в нашем приложении.

  
**app/views/index/index.phtml**

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

  


Сгенерированный HTML-код будет выводить ссылку ("a"), указывающую на наш новый контроллер:

  
**app/views/index/index.phtml Rendered**

```html
<h1>Привет!</h1>

<a href="/signup">Регистрируйся!</a>
```

  


Для генерации тэга мы воспользовались встроенным классом `Phalcon\Tag`. Это служебный класс, позволяющий конструировать HTML-разметку в Phalcon-подобном стиле. As this class is also a service registered in the DI we use `$this->tag` to access it.

A more detailed article regarding HTML generation can be found [here <tags>](/[[language]]/[[version]]/tag).

  
![](/images/content/tutorial-basic-2.png)

  
Контроллер Signup (`app/controllers/SignupController.php`):

  
**app/controllers/SignupController.php**

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

  
**app/views/signup/index.phtml**

```php
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

```bash
Exception: Action "register" was not found on handler "signup"
```

Реализация этого метода предотвратит выброс исключения:

  
**app/controllers/SignupController.php**

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

  


Снова жмем на кнопку “Регистрация” и видим пустую страницу. Поля name и email, введенные пользователем, должны сохраниться в базе данных. В соответствии с принципами MVC, все взаимодействие с БД должно вестись через модели, таким образом, следуя традициям ООП-стиля.

<a name='model'></a>

## Создание модели

Phalcon предоставляет первый ORM для PHP полностью написанный на языке C. Вместо увеличения сложности разработки, он её упрощает.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be created like this:

  
**create_users_table.sql**

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

  


Модель должна быть размещена в папке `app/models` (`app/models/Users.php`). Модель относится к таблице "users":

  
**app/models/Users.php**

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

  
**public/index.php**

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

  
**app/controllers/SignupController.php**

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

  


At the beginning of the **registerAction** we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. Установка соответствующих значений в новой записи и вызов метода `save()` сохранит данные в базе данных. Метод `save()` возвращает булево значение, указывающее, успешно ли были сохранены данные в таблице или нет (true и false, соответственно).

ORM автоматически экранирует ввод для предотвращения SQL-инъекций, так что мы можем передавать тело HTTP-запроса напрямую методу `save()`.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

  
![](/images/content/tutorial-basic-4.png)

  
<a name='conclusion'></a>

## Заключение

As you can see, it's easy to start building an application using Phalcon. The fact that Phalcon runs from an extension significantly reduces the footprint of projects as well as giving it a considerable performance boost.

If you are ready to learn more check out the [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) next.