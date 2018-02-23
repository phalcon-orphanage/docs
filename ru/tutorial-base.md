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

Перед тем как продолжить, пожалуйста убедитесь, что вы успешно [установили Phalcon](/[[language]]/[[version]]/installation) и у вас установлен [Nginx](/[[language]]/[[version]]/setup#nginx), [Apache](/[[language]]/[[version]]/setup#apache) или [Cherokee](/[[language]]/[[version]]/setup#cherokee).

<a name='bootstrap'></a>

## Начальная загрузка

Первый файл, который необходимо создать - bootstrap-файл. Этот файл является очень важным, поскольку он служит основой вашего приложения давая вам контроль над всеми его аспектами. В данном файле вы можете реализовать как инициализацию компонентов, так и поведение приложения.

В целом, он отвечает за 3 вещи:

- Настройка автозагрузчика.
- Настройка внедрений зависимостей (dependency injector).
- Обработка входящих запросов приложения.

<a name='autoloaders'></a>

### Автозагрузка

Первое, что происходит в bootstrap-файле — это регистрация автозагрузчика. Он будет использоваться для загрузки классов проекта, таких как контроллеры и модели. Например, мы можем зарегистрировать одну или более директорий для контроллеров, увеличив гибкость приложения. В нашем примере мы использовали компонент `Phalcon\Loader`.

Он позволяет использовать разные стратегии загрузки классов, но в данном примере мы решили расположить классы в определенных директориях:

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
Важная концепция, которую стоит понять при использовании Phalcon — это `контейнер внедрения зависимостей <di>`. Это может показаться сложным, но на самом деле это очень простой и практичный шаблон проектирования.

DI представляет из себя глобальный контейнер для сервисов, необходимых нашему приложению. Каждый раз, когда фреймворку необходим какой-то компонент, он будет обращаться за ним к контейнеру, используя определенное имя компонента. Так как Phalcon является слабосвязанным фреймворком, `Phalcon\Di` выступает в роли клея, помогающего разным компонентам прозрачно взаимодействовать друг с другом.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Создаём контейнер DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` является вариантом `Phalcon\Di`. Он берет на себя функции регистрации большинства компонентов из состава Phalcon. Поэтому нам не придется регистрировать их вручную один за другим. При необходимости можно без проблем заменить реализацию данного сервиса на другую.

На следующем шаге мы регистрируем сервис “view”, указав директорию, где фреймворк будет искать представления. Так как данные файлы не относятся к классам, они не могут быть подгружены автозагрузчиком.

Существует несколько способов регистрации сервисов, но в нашем примере мы используем [анонимную функцию](http://php.net/manual/en/functions.anonymous.php):

```php
<?php

use Phalcon\Mvc\View;

// ...

// Настраиваем компонент представлений
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

Затем мы регистрируем базовый URI так, чтобы все URI, которые генерирует Phalcon, содержали директорию “tutorial”. Это пригодится нам позднее в данном уроке, когда будем использовать класс `Phalcon\Tag` для генерации ссылок.

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Настраиваем базовый URI так, чтобы все генерируемые URI
// содержали директорию "tutorial"
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
На последнем этапе мы используем `Phalcon\Mvc\Application`. Данный компонент служит для инициализации окружения входящих запросов, их перенаправления и обслуживания относящихся к ним действий. После отработки всех доступных действий, компонент возвращает полученные ответы.

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

Файл `tutorial/public/index.php` имеет следующее содержимое:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Регистрируем автозагрузчик
$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
    ]
);

$loader->register();

// Создаём DI
$di = new FactoryDefault();

// Настраиваем компонент представлений
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);

// Настраиваем базовый URI так, чтобы все генерируемые URI
// содержали директорию "tutorial"
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
    // Обрабатываем запрос
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

Как можно увидеть, bootstrap-файл очень короткий, нам нет необходимости подключать какие-либо дополнительные файлы. Таким образом, мы настроили гибкую структуру MVC-приложения менее чем за 30 строк кода.

<a name='controller'></a>

## Создание контроллера

По умолчанию Phalcon будет искать контроллер с именем “Index”. Как и во многих других фреймворках он является исходной точкой, когда ни один другой контроллер или действие не были запрошены. Наш index-контроллер (`app/controllers/IndexController.php`) выглядит так:

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

```php
<?php echo "<h1>Привет!</h1>";
```

В нашем контроллере (`app/controllers/IndexController.php`) сейчас существует пустое действие:

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

Вывод браузера должен оставаться тем же. В `в phalcon\Mvc, о\вид` статический компонент создается автоматически при выполнении действия закончился. Подробнее об использовании представлений `здесь <views>`.

<a name='signup-form'></a>

## Проектирование формы регистрации

Теперь мы изменим индекс `index.phtml`, чтобы добавить ссылку на новый контроллер с именем "Регистрация". Цель состоит в том, чтобы позволить пользователям зарегистрироваться в нашем приложении.

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

Созданный HTML-код отображает привязку ("a") HTML-тег, связывающий с новым контроллером:

```html
<h1>Hello!</h1>

<a href="/tutorial/signup">Sign Up Here!</a>
```

Для генерации тега используется класс `Phalcon\Tag`. Это служебный класс, который позволяет нам создавать HTML-теги с учетом рамочных соглашений. Поскольку этот класс также является сервисом, зарегистрированным в DI, мы используем `$this>tag` обращаться к нему.

Более подробная статья о генерации HTML может быть :doc:`found here <tags>`.

![](/images/content/tutorial-basic-2.png)

Вот контроллер регистрации (`App/controllers/SignupController.php`):

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

Пустое действие индекса дает чистый проход к представлению с определением формы (`app/views/signup/index.phtml`):

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

Просмотр формы в вашем браузере покажет что-то подобное:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` также предоставляет полезные методы для построения элементов формы.

The :code:`Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

Нажав кнопку "Отправить", Вы заметите исключение, выбрасываемое из фреймворка, указывающее, что в контроллере отсутствует действие" Регистрация". Наши `общественные/индекс.php` файл выдает это исключение:

```bash
Exception: Action "register" was not found on handler "signup"
```

Реализация этого метода удалит исключение:

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

Если нажать кнопку "Отправить" еще раз, вы увидите пустую страницу. Имя и email, введенные пользователей должны храниться в базе данных. В соответствии с руководящими принципами MVC, взаимодействие с базой данных должно осуществляться с помощью моделей, чтобы обеспечить чистый объектно-ориентированный код.

<a name='model'></a>

## Создание модели

Phalcon предоставляет первый ORM для PHP полностью написанный на языке C. Вместо увеличения сложности разработки, он ее упрощает.

Прежде чем создавать нашу первую модель, нам нужно создать таблицу базы данных за пределами Phalcon, чтобы сопоставить ее. Простая Таблица для хранения зарегистрированных пользователей может быть определена следующим образом:

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

Модель должна быть расположена в `приложение/модели` каталог (`модели приложение//пользователей.php`). Модель сопоставляется с таблицей " пользователи:

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

In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. Соединение с базой данных — это всего лишь ещё один сервис нашего приложения, который может быть использован для различных компонентов:

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

С правильными параметрами базы данных, наши модели готовы работать и взаимодействовать с остальной частью приложения.

<a name='storing-data'></a>

## Сохранение данных при работе с моделями

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

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields of the record in the users table. Установка соответствующих значений в новой записи и вызов метода `save()` сохранит данные в базе данных. Метод `save()` возвращает булево значение, указывающее, успешно ли были сохранены данные в таблице или нет (true и false, соответственно).

ORM автоматически экранирует ввод для предотвращения SQL-инъекций, так что мы можем передавать тело HTTP-запроса напрямую методу `save()`.

Дополнительная проверка выполняется автоматически для полей, которые определены как not null (обязательно). Если мы не введем ни одно из обязательных полей в форме регистрации, наш экран будет выглядеть так:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Заключение

Это очень простое руководство, и, как можно увидеть, начать создавать приложения с помощью Phalcon достаточно просто. То, что Phalcon является расширением, никак не влияет на сложность разработки и доступные возможности. Мы приглашаем вас продолжить читать данное руководство для изучения дополнительных возможностей, которые предоставляет Phalcon!