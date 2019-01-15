* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='basic'></a>

# Tutorial - basic

Throughout this tutorial, we'll walk you through the creation of an application with a simple registration form from the ground up. The following guide is to provided to introduce you to Phalcon framework's design aspects.

This tutorial covers the implementation of a simple MVC application, showing how fast and easy it can be done with Phalcon. This tutorial will get you started and help create an application that you can extend to address many needs. The code in this tutorial can also be used as a playground to learn other Phalcon specific concepts and ideas.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

If you just want to get started you can skip this and create a Phalcon project automatically with our [developer tools](/4.0/en/devtools-usage). (It is recommended that if you have not had experience with to come back here if you get stuck)

The best way to use this guide is to follow along and try to have fun. You can get the complete code [here](https://github.com/phalcon/tutorial). If you get hung-up on something please visit us on [Discord](https://phalcon.link/discord) or in our [Forum](https://phalcon.link/forum).

<a name='file-structure'></a>

## Struktura souborů

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
        Note: You will not see a `vendor` directory as all of Phalcon's core dependencies are loaded into memory via the Phalcon extension you should have installed. If you missed that part have not installed the Phalcon extension [please go back](/4.0/en/installation) and finish the installation before continuing.
    </p>
</div>

If this is all brand new it is recommended that you install the [Phalcon Devtools](/4.0/en/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/4.0/en/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/4.0/en/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/4.0/en/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Bootstrap

The first file you need to create is the bootstrap file. This file acts as the entry-point and configuration for your application. In this file, you can implement initialization of components as well as application behavior.

This file handles 3 things: - Registration of component autoloaders - Configuring Services and registering them with the Dependency Injection context - Resolving the application's HTTP requests

<a name='autoloaders'></a>

### Autoloaders

Autoloaders leverage a [PSR-4](https://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon. Common things that should be added to the autoloader are your controllers and models. You can register directories which will search for files within the application's namespace. If you want to read about other ways that you can use autoloaders head [here](/4.0/en/loader#overview).

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

Each time the framework requires a component or service, it will ask the container using an agreed upon name for the service. Don't forget to include `Phalcon\Di` with setting up the service container.

<div class='alert alert-warning'>
    <p>
        If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html). Also we have [a great tutorial](/4.0/en/di) covering many use cases.
    </p>
</div>

### Factory Default

The [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) is a variant of [Phalcon\Di](api/Phalcon_Di). To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](https://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

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

Next, we register a base URI so that all URIs generated by Phalcon match the application's base path of "/". This will become important later on in this tutorial when we use the class `Phalcon\Tag` to generate a hyperlink.

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

### Putting everything together

The `tutorial/public/index.php` file should look like:

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

By default Phalcon will look for a controller named `IndexController`. It is the starting point when no controller or action has been added in the request (eg. `https://localhost:8000/`). An `IndexController` and its `IndexAction` should resemble the following example:

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

![](/assets/images/content/tutorial-basic-1.png)

Congratulations, you're phlying with Phalcon!

<a name='view'></a>

## Sending output to a view

Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (`app/views/index/index.phtml`):

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hello!</h1>";
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

## Designing a sign-up form

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

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

To generate the tag we use the class `Phalcon\Tag`. This is a utility class that allows us to build HTML tags with framework conventions in mind. As this class is also a service registered in the DI we use `$this->tag` to access it.

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

Viewing the form in your browser will show something like this:

![](/assets/images/content/tutorial-basic-3.png)

[Phalcon\Tag](api/Phalcon_Tag) also provides useful methods to build form elements.

The `Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the `register` action in the controller `signup`. Our `public/index.php` file throws this exception:

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

## Creating a Model

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

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

## Setting a Database Connection

In order to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. A database connection is just another service that our application has that can be used for several components:

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

With the correct database parameters, our models are ready to work and interact with the rest of the application.

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

At the beginning of the `registerAction` we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

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

## Conclusion

As you can see, it's easy to start building an application using Phalcon. The fact that Phalcon runs from an extension significantly reduces the footprint of projects as well as giving it a considerable performance boost.

If you are ready to learn more check out the [Rest Tutorial](/4.0/en/tutorial-rest) next.