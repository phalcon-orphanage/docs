<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Tutorial - basic</a> 
      <ul>
        <li>
          <a href="#file-structure">File structure</a>
        </li>
        <li>
          <a href="#bootstrap">Bootstrap</a> 
          <ul>
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

Throughout this tutorial, we'll walk you through the creation of an application with a simple registration form from the ground up. The following guide is to provided to introduce you to Phalcon framework's design aspects.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

If you just want to get started you can skip this and create a Phalcon project automatically with our [developer tools](/[[language]]/[[version]]/devtools-usage). (It is recommended that if you have not had experience with to come back here if you get stuck)

The best way to use this guide is to follow along and try to have fun. You can get the complete code [here](https://github.com/phalcon/tutorial). If you get hung-up on something please visit us on [Discord](https://phalcon.link/discord) or in our [Forum](https://phalcon.link/forum).

<a name='file-structure'></a>

## File structure

A key feature of Phalcon is it's loosely coupled, you can build a Phalcon project with a directory structure that is convenient for your specific application. That said some uniformity is helpful when collaborating with others, so this tutorial will use a "Standard" structure where you should feel at home if you have worked with other MVC's in the past.   


```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

<div class='alert alert-warning'>
    <p>
        Note: You will not see a `vendor` directory as all of Phalcon's core dependencies are loaded into memory via the Phalcon extension you should have installed. If you missed that part have not installed the Phalcon extension [please go back](/[[language]]/[[version]]/installation) and finish the installation before continuing.
    </p>
</div>

If this is all brand new it is recommended that you install the [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/[[language]]/[[version]]/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/[[language]]/[[version]]/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/[[language]]/[[version]]/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Bootstrap

فایل اولی که شما باید ایجاد کنید، فایل خودراه انداز است. This file acts as the entry-point and configuration for your application. In this file, you can implement initialization of components as well as application behavior.

This file handles 3 things: - Registration of component autoloaders - Configuring Services and registering them with the Dependency Injection context - Resolving the application's HTTP requests

<a name='autoloaders'></a>

### Autoloaders

Autoloaders leverage a [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon. Common things that should be added to the autoloader are your controllers and models. You can register directories which will search for files within the application's namespace. If you want to read about other ways that you can use Autoloaders head [here](/[[language]]/[[version]]/loader#overview).

To start, lets register our app's `controllers` and `models` directories. Don't forget to include the loader from `Phalcon\Loader`.

`public/index.php`

```php
<?php

use Phalcon\Loader;

// Define some absolute path constants to aid in locating resources
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

### Dependency Management

Since Phalcon is loosely coupled, services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the [IoC](https://en.wikipedia.org/wiki/Inversion_of_control) container. Frequently you will encounter the term DI which stands for Dependency Injection. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts: - Service Container: a "bag" where we globally store the services that our application needs to function. - Service or Component: Data processing object which will be injected into components

If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html)

Each time the framework requires a component or service, it will ask the container using an agreed upon name for the service. Don't forget to include `Phalcon\Di` with setting up the service container.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

### Factory Default

The `Phalcon\Di\FactoryDefault` is a variant of `Phalcon\Di`. To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

در بخش بعدی، ما سروی "نمایه" را ثبت می کنیم که نشان دهنده دایرکتوری است که در آن چارچوب فایل های قابل نمایش را پیدا می کند. همانطور که فایل های قابل نمایش با دسته ها مطابقت ندارند، با بارگیری خودکار قابل بارگذاری نیستند.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

Next, we register a base URI so that all URIs generated by Phalcon match the application's base path of "/". از این پس در این تمرین، زمانی که ما از دسته`فالکون/برچسب` برای ایجاد یک ابر پیوند استفاده کنیم مهم خواهد بود.

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

### Handling the application request

در قسمت آخر این فایل، ما را پیدا می کنیم`فالکون/ام وی سی/برنامه`. هدف آن این است که محیط درخواستی را مقدار دهی اولیه کرده، مسیر درخواست ورودی راه را تعیین و سپس هر گونه فعالیت شناسایی شده را مخابره نماید؛ هر پاسخی را جمع آوری می کند و زمانی که فرآیند کامل می شود، آنها را بازمی گرداند.

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

### Putting everything together

فایل `آموزش/عمومی/فهرست`باید به این شکل باشد:

`public/index.php`

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
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

As you can see, the bootstrap file is very short and we do not need to include any additional files. Congratulations you are well on your to having created a flexible MVC application in less than 30 lines of code.

<a name='controller'></a>

## Creating a Controller

By default Phalcon will look for a controller named `IndexController`. It is the starting point when no controller or action has been added in the request (eg. `http://localhost:8000/`). An `IndexController` and its `IndexAction` should resemble the following example:

`app/controllers/IndexController.php`

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

The controller classes must have the suffix `Controller` and controller actions must have the suffix `Action`. If you access the application from your browser, you should see something like this:

![](/images/content/tutorial-basic-1.png)

تبریک می گوییم، شما با فالکون همکاری می کنید!

<a name='view'></a>

## Sending output to a view

در مواقع ضروری خروجی از کنترلر به صفحه نمایش ارسال می شود، اما این مطلوب نیست، زیرا بیشتر متخصصان در انجمن ام وی سی این را تایید می کنند. داده نمایه های ورودی باعث ایجاد داده های خروجی که در صفحه نمایش هستند می شوند. فالکون یک نمایه با همان نام با عنوان آخرین عمل انجام شده در داخل یک پوشه به نام آخرین کنترل انجام شده، را جستجو می کند. در مورد ما (`app/views/index/index.phtml`):

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hello!</h1>";
```

کنترلر ما (`app/controllers/IndexController.php`) در حال حاضر یک تعریف عمل تهی دارد:

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

خروجی مرورگر باید همانطور باقی بماند. `فالکون/ام وی سی/نمایش`مولفه های ثابت هنگامی که اجرای عملیات به پایان رسید، به طور خودکار ایجاد می شوند. Learn more about views usage [here](/[[language]]/[[version]]/views).

<a name='signup-form'></a>

## Designing a sign-up form

حالا ما فایل نمایه `شاخص.پی اچ تی ام ال` را تغییر خواهیم داد تا یک پیوند به یک کنترلر جدید با نام "ثبت نام" اضافه کنیم. هدف این است که کاربران اجازه ثبت نام در برنامه خود را داشته باشند.

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Sign Up Here!'
);
```

The generated HTML code displays an anchor (`<a>`) HTML tag linking to a new controller:

`app/views/index/index.phtml` (rendered)

```html
<h1>Hello!</h1>

<a href="/signup">Sign Up Here!</a>
```

برای تولید تگ، ما از دسته استفاده می کنیم`فالکون/تگ`. این یک دسته ابزار است که ما را قادر به ساخت تگ های اچ تی ام ال با قوانین چارچوب می کند. As this class is also a service registered in the DI we use `$this->tag` to access it.

A more detailed article regarding HTML generation [can be found here](/[[language]]/[[version]]/tag).

![](/images/content/tutorial-basic-2.png)

اینجا کنترل کننده ثبت نام است (`app/controllers/SignupController.php`):

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

عملکردهای بی نتیجه، گذرگاه پاکسازی شده خالی را برای یک نمایه ی تعیین فرم شده می دهد (`app/views/signup/index.phtml`):

`app/views/signup/index.phtml`

```html
<h2>Sign up using this form</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Name</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Register"); ?>
    </p>

</form>
```

مشاهده فرم در مرورگر شما چیزی شبیه به این را نشان می دهد:

![](/images/content/tutorial-basic-3.png)

`فالکون/تگ`همچنین روش های مفید برای ساخت عناصر فرم را فراهم می کند.

The `Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the `register` action in the controller `signup`. فایل `عمومی/شاخص` ما این استثنا را سبب می شود:

    Exception: Action "register" was not found on handler "signup"
    

پیاده سازی این روش، استثنا را حذف خواهد کرد:

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

اگر دوباره روی "ارسال" کلیک کنید، یک صفحه خالی خواهید دید. نام و ایمیل ورودی ارائه شده توسط کاربر باید در پایگاه داده ها ذخیره شود. با توجه به دستورالعمل ام وی سی، تعاملات پایگاه داده باید از طریق مدل ها انجام شود تا از پاک شدن کد شی گرا اطمینان حاصل شود.

<a name='model'></a>

## Creating a Model

فالکون نخستین ارم برای پی اچ پی را به طور کامل در زبان سی به ارمغان می آورد. به جای افزایش پیچیدگی سیر تکاملی، آن را ساده می کند.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be created like this:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

یک مدل باید در دایرکتوری `برنامه/مدلها`دایرکتوری (`برنامه/مدلها/کاربران`) قرار گیرد. این مدل به جدول "کاربران" می پردازد:

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

## Setting a Database Connection

In order to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. یک اتصال پایگاه داده فقط سرویس دیگری است که برنامه ما می تواند آن را برای چندین قسمت استفاده کند:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Setup the database service
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

با پارامترهای پایگاه داده صحیح، مدل ما آماده کار و تعامل با بقیه برنامه است.

<a name='storing-data'></a>

## Storing data using models

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

At the beginning of the `registerAction` we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. تنظیمات مقادیر مربوط به سابقه جدید و تماس های `ذخیره شده()` بعنوان داده در پایگاه داده ها برای آن سابقه ذخیره خواهد شد. روش `ذخیره()` یک مقدار بولین درست یا غلط را نشان می دهد که نشان دهنده اینست که آیا ذخیره سازی داده موفق بوده یا خیر.

ارم به طور خودکار ورودی را بعلت پیشگیری از تزریق اسکیوال خارج میکند بنابراین ما فقط باید درخواست را به روش`ذخیره() `منتقل کنیم.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

As you can see, it's easy to start building an application using Phalcon. The fact that Phalcon runs from an extension significantly reduces the footprint of projects as well as giving it a considerable performance boost.

If you are ready to learn more check out the [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) next.