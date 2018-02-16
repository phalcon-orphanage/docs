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
          <a href="#conclusion">Conclusion</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Tutorial - basic

В этом примере рассмотрим создание приложения с простой формой регистрации “с нуля”. Также рассмотрим основные аспекты поведения фреймворка. Если вы заинтересованы в автоматических инструментах поколения кода для Phalcon, то вы можете проверить наше [developer tools](/[[language]]/[[version]]/developer-tools).

Лучше всего следовать данному руководству шаг за шагом. Полный код можно посмотреть [здесь](https://github.com/phalcon/tutorial).

<a name='file-structure'></a>

## File structure

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

## Bootstrap

Первый файл нужно создать файл bootstrap. Этот файл очень важен, так как он служит основой вашего приложения, давая вам контроль над всеми его аспектами. В этом файле можно реализовать инициализацию компонентов, а также поведение приложения.

В конечном счете, он отвечает за выполнение 3 вещей:

- Настройка автозаполнителя.
- Настройка инжектора зависимостей.
- Обработка запроса приложения.

<a name='autoloaders'></a>

### Autoloaders

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

### Dependency Management

Очень важным понятием, которое необходимо понимать при работе с Phalcon, является его `контейнер для инъекций зависимостей <di>`. Это может показаться сложным, но на самом деле очень простой и практичный.

Контейнер службы-это мешок, в котором мы глобально храним службы, которые наше приложение будет использовать для работы. Каждый раз, когда Платформа требует компонент, он будет запрашивать контейнер с использованием согласованного имени для службы. Так как Phalcon является высоко развязанные рамки, `Phalcon\Di` действует как клей облегчая интеграцию различных компонентов достигая их работы совместно в прозрачном образе.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`в phalcon\Ди\FactoryDefault` вариант `в phalcon\Ди`. Чтобы сделать вещи проще, он зарегистрировал большинство компонентов, которые поставляются с Phalcon. Поэтому мы не должны регистрировать их по одному. Позже не будет никаких проблем в замене заводской службы.

В следующей части мы регистрируем сервис "просмотр", указывающий каталог, в котором Платформа найдет файлы представлений. Поскольку представления не соответствуют классам, их нельзя заряжать с помощью автозаполнителя.

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

Далее мы регистрируем базовый URI, так что все URI генерируется "Фэлкон" включить папку "учебник" мы настроили ранее. Это станет важным позже в этом руководстве, когда мы используем класс `Phalcon\Tag` для создания гиперссылки.

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

В последней части этого файла, мы находим `в phalcon\Mvc в\приложения`. Его целью является инициализация среды запроса, маршрутизация входящего запроса, а затем отправка любых обнаруженных действий; он агрегирует любые ответы и возвращает их, когда процесс будет завершен.

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

В `учебник/общественных/индекс.php` файл должен выглядеть так:

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

## Creating a Controller

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

Классы контроллеров должны иметь суффикс "контроллер" и действия регулятора должны иметь суффикс "действие". Если вы получаете доступ к приложению из браузера, вы должны увидеть что-то подобное:

![](/images/content/tutorial-basic-1.png)

Поздравляю, ты phlying с помощью phalcon!

<a name='view'></a>

## Sending output to a view

Отправка вывода на экран с контроллера иногда необходима, но не желательна, так как большинство пуристов в сообществе MVC будут подтверждать. Все должно быть передано представлению, отвечающему за вывод данных на экран. Phalcon будет искать представление с тем же именем, что и последнее выполненное действие в каталоге с именем последнего выполненного контроллера. В нашем случае (`приложение/Просмотры/индекс/индекс.html`):

```php
<?php echo "<h1>Привет!</h1>";
```

Наш контроллер (`приложение/контроллеры/IndexController.php`) теперь имеет пустое определение действия:

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

## Creating a Model

Фэлкон приносит первые orm для PHP и полностью написана на языке Си. Вместо того, чтобы увеличивать сложность разработки, она упрощает ее.

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

## Setting a Database Connection

Для того, чтобы иметь возможность использовать подключение к базе данных и затем получить доступ к данным через наши модели, мы должны уточнить его в процессе начальной загрузки. Подключение к базе данных - это еще одна услуга, которую имеет наше приложение и которая может использоваться для нескольких компонентов:

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

Затем мы создаем экземпляр класса Users, который соответствует записи Пользователя. Открытые свойства класса сопоставляются с полями записи в таблице пользователи. Установка соответствующих значений в новой записи и вызов `save()` будут хранить данные в базе данных для этой записи. Метод `save()` возвращает логическое значение, указывающее, было ли штурм данных успешным или нет.

ORM автоматически экранирует входные данные, предотвращая инъекции SQL, поэтому нам нужно только передать запрос методу `save ()`.

Дополнительная проверка выполняется автоматически для полей, которые определены как not null (обязательно). Если мы не введем ни одно из обязательных полей в форме регистрации, наш экран будет выглядеть так:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

На этом очень простом руководстве можно увидеть, как легко начать создавать приложения с помощью Phalcon. То, что Phalcon является расширением, никак не влияет на сложность разработки и доступные возможности. Мы приглашаем вас продолжить читать данное руководство для изучения дополнительных возможностей, которые предоставляет Phalcon!