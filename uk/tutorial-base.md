<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Tutorial - basic</a> <ul>
        <li>
          <a href="#file-structure">File structure</a>
        </li>
        <li>
          <a href="#bootstrap">Bootstrap</a> <ul>
            <li>
              <a href="#autoloaders">Autoloaders</a>
            </li>
            <li>
              <a href="#dependency-management">Dependency Management</a>
            </li>
            <li>
              <a href="#request">Handling the application request</a>
            </li>
            <li>
              <a href="#full-example">Putting everything together</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">Creating a Controller</a>
        </li>
        <li>
          <a href="#view">Sending output to a view</a>
        </li>
        <li>
          <a href="#signup-form">Designing a sign up form</a>
        </li>
        <li>
          <a href="#model">Creating a Model</a>
        </li>
        <li>
          <a href="#database-connection">Setting a Database Connection</a>
        </li>
        <li>
          <a href="#storing-data">Storing data using models</a>
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

У цьому уроці ми будемо ходити вас через створення програми з простою формою реєстрації "з нуля". Також ми розглянемо основні аспекти поведінки фреймворка. Якщо Вас цікавлять автоматичні засоби генерації коду для Фелкон, ви можете перевірити наш [інструменти розробника](/[[language]]/[[version]]/developer-tools).

Кращий спосіб використовувати цей посібник, щоб стежити за кожним кроком в свою чергу. Ви можете отримати повний код [](https://github.com/phalcon/tutorial).

<a name='file-structure'></a>

## File structure

Фелкон не нав'язує певну структуру файлу для розробки додатків. З-за того, що він є слабосвязанной, ви можете реалізувати Фелкон пристроїв зі структурою файлу, який ви найбільш комфортно, використовуючи.

Для цілей цього підручника та у якості відправної точки, ми пропонуємо наступну структуру:

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

Зверніть увагу, що вам не потрібні ніякі "каталог бібліотеки, що відносяться до Фреймворку. Ця структура знаходиться в пам'яті, готове до використання.

Перш ніж продовжити, будь ласка, переконайтеся, що ви успішно [встановлено Фелкон](/[[language]]/[[version]]/installation) і установки [з nginx](/[[language]]/[[version]]/setup#nginx), [Апач](/[[language]]/[[version]]/setup#apache) або [Черокі](/[[language]]/[[version]]/setup#cherokee).

<a name='bootstrap'></a>

## Bootstrap

The first file you need to create is the bootstrap file. Цей файл є дуже важливим, оскільки він служить в якості базової програми, даючи вам контроль над усіма аспектами. У цьому файлі можна реалізувати ініціалізацію компонентів, а також поведінку програми.

У кінцевому рахунку, він відповідає за робить 3 речі:

- Установка автозавантажувач.
- Налаштування інжектора залежностей.
- Обробці запиту програми.

<a name='autoloaders'></a>

### Autoloaders

Перша частина, яку ми знаходимо в bootstrap-це Реєстрація автозавантажувач. Це буде використовуватися для завантаження класів контролерів і моделі в додатку. Наприклад, ми можемо зареєструвати один або декілька каталогів контролерів підвищує гнучкість застосування. У нашому прикладі ми використовували компонент `phalcon\Loader`.

З його допомогою ми можемо завантажувати класи, використовуючи різні стратегії, але для цього прикладу ми вибрали, щоб знайти класи на основі визначених директоріях:

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

Важлива концепція, яку слід розуміти при використанні phalcon-це `контейнера впровадження залежностей <di>`. Це може здатися складним, але насправді дуже простий і практичний.

Контейнер-сервіс-це мішок, де ми зберігаємо глобально послуг, що наше додаток буде використовувати для роботи. Кожен раз, коли Платформа вимагає компонент, він буде просити контейнер, використовуючи певне ім'я сервісу. З phalcon є слабосвязанным бази, `phalcon\di` діє як клей, що сприяють інтеграції різних компонентів, досягаючи їх спільно в прозорій манері.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` is a variant of `Phalcon\Di`. Щоб зробити речі простіше, зареєстровано більшість компонентів, які приходять за допомогою phalcon. Таким чином, ми не повинні реєструвати їх один за одним. Потім не буде жодних проблем в заміні службі заводу.

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

Сервіси можуть бути зареєстровані в кількох напрямках, але для нашого уроку ми будемо використовувати [анонімні функції](http://php.net/manual/en/functions.anonymous.php):

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

Далі ми реєструємо базовий URI, так що всі URI генерується "Фелкон" додати папку "підручник" ми налаштували раніше. This will become important later on in this tutorial when we use the class `Phalcon\Tag` to generate a hyperlink.

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

### Handling the application request

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

### Putting everything together

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

Як бачите, завантажувальний файл займає дуже короткий і нам не потрібно включати додаткові файли. Ми поставили перед собою гнучке застосування MVC в менш ніж 30 рядків коду.

<a name='controller'></a>

## Creating a Controller

За замовчуванням phalcon буде шукати контролер з ім'ям "index". Це відправна точка, коли немає контролер або дія був переданий у запиті. The index controller (`app/controllers/IndexController.php`) looks like:

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Hello!</h1>';
    }
}
```

The controller classes must have the suffix "Controller" and controller actions must have the suffix "Action". If you access the application from your browser, you should see something like this:

![](/images/content/tutorial-basic-1.png)

Congratulations, you're phlying with Phalcon!

<a name='view'></a>

## Sending output to a view

Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (`app/views/index/index.phtml`):

```php
<?php echo "<h1>Hello!</h1>";
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

The browser output should remain the same. The `Phalcon\Mvc\View` static component is automatically created when the action execution has ended. Дізнайтеся більше про `тут використання подання <views>`.

<a name='signup-form'></a>

## Designing a sign up form

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

To generate the tag we use the class `Phalcon\Tag`. This is a utility class that allows us to build HTML tags with framework conventions in mind. Цей клас є також зареєстровано ді ми використовуємо `$цьому-і GT;тег`, щоб відкрити його.

A more detailed article regarding HTML generation can be :doc:`found here <tags>`.

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

Перед створенням нашої першої моделі нам потрібно створити таблиці бази даних за межами "Фелкон", щоб зіставити його. Проста Таблиця для реєстрації користувачів можуть бути визначені так:

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

Для того, щоб мати можливість використовувати підключення до бази даних і потім отримати доступ до даних через наші моделі, ми повинні уточнити його в процесі початкового завантаження. A database connection is just another service that our application has that can be used for several components:

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

Отримання даних з форми і зберігати їх у таблиці-це наступний крок.

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

Потім ми створюємо екземпляр класу користувачів, що відповідає запису Користувача. Публічні властивості класу на карті поля запису в таблиці користувачів. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Додаткова перевірка відбувається автоматично на поля, які визначені як не Null (обов'язково). Якщо ми не Вводимо будь-якого з необхідних полів у формі реєстрації, буде виглядати наступним чином:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

Це дуже простий підручник, і як ви можете бачити, це легко почати створювати додаток з допомогою phalcon. Той факт, що в phalcon розширення на ваш веб-сервер не заважали простота розробки і доступні. Ми запрошуємо вас, щоб продовжити читання цієї інструкції, так що ви можете відкрити для себе додаткові можливості в phalcon!