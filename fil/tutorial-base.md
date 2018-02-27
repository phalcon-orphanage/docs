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

The best way to use this guide is to follow along and try to have fun. You can get the complete code [here](https://github.com/phalcon/tutorial). If you get hung-up on something please visit us on [Discord](https://phalcon.link/discord) or in our [Forum](https://phalcon.link/forum)

<a name='file-structure'></a>

## File structure

A key feature of Phalcon is it's **loosely coupled**, you can build a Phalcon project with a directory structure that is convenient for your specific application. That said some uniformity is helpful when collaborating with others, so this tutorial will use a "Standard" structure where you should feel at home if you have worked with other MVC's in the past.   


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

Note: You will not see a **vendor** directory as all of Phalcon's core dependencies are loaded into memory via the Phalcon extension you should have installed. If you missed that part have not installed the Phalcon extension [please go back](/[[language]]/[[version]]/installation) and finish the installation before continuing.

If this is all brand new it is recommended that you install the [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/[[language]]/[[version]]/webserver-setup#nginx)

Apache can also be used with these additional setup [here](/[[language]]/[[version]]/webserver-setup#apache)

Finally, if you flavor is Cherokee use the setup [here](/[[language]]/[[version]]/webserver-setup#cherokee)

<a name='bootstrap'></a>

## Bootstrap

The first file you need to create is the bootstrap file. This file acts as the entry-point and configuration for your application. In this file, you can implement initialization of components as well as application behavior.

This file handles 3 things: - Registration of component autoloaders. - Configuring **Services** and registering them with the **Dependency Injection** context. - Resolving the application's HTTP requests.

<a name='autoloaders'></a>

### Autoloaders

Autoloaders leverage a [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon C extension. Common things that should be added to the Autoloader are your **Controllers** and **Models**. You can register **directories** which will search for files within the application's namespace. (If you want to read about other ways that you can use Autoloaders head [here](/[[language]]/[[version]]/loader#overview))

To start, lets register our app's **controllers** and **models** directories. Don't forget to include the loader from `Phalcon\Loader`.

**public/index.php**

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

Dahil ang Phalcon ay **maluwag na pares** na serbisyo ito ay nakarehistro sa balangkas ng Dependency Manager kaya ito ay maaring automatikong maipapasok sa mga bahagi at serbisyo na nakalagay sa **loC** na lagayan. Madalas kang makakatagpo ng kataga na **DI** na ang ibig sabihin ay Dependency Injection. Ang Dependency Injection at Inversion of Control (IoC) ay maaring komplikado na katangian ngunit sa Phalcon ang gamit nito ay napakasimple at praktikal. Ang lagayan ng Phalcon IoC ay binubuo ng mga sumusunod na konsepto: -Lagayan ng Serbisyo: isang 'supot' kung saan dito pangkalahatang nilalagay ang mga serbisyo na kailangan ng ating aplikasyon para gumana. -Serbisyo o Mga Bahagi: Ang mga bagay para sa pagproseso ng data na ilalagay sa mga bahagi

Kung ikaw ay interesado sa mga detalye maaring tingnan ang artikulo na ito ayun kay [Martin Fowler](https://martinfowler.com/articles/injection.html)

Kung ang balangkas ay nangangailangan ng isang sangap o serbisyo, hihilingin nito ang lagayan gamit ang nasang-ayunan na pangalan para sa serbisyo. Wag kalimutang isali ang `Phalcon\Di` sa pag set-up ng lagayan ng serbisyo.

Ang mga serbisyo ay maaring i-rehistro sa maraming paraan, pero sa ating tyutoryal tayo ay gagamit ng [dikilala na kabisa](http://php.net/manual/en/functions.anonymous.php):

### Factory Default

`Phalcon\Di\FactoryDefault` is a variant of `Phalcon\Di`. Upang maging madali, ito ay awtomatikong magrerehistro ng mga sangkap na kasama sa Phalcon. Iminumungkahi namin na i-rehistro ang iyong mga serbisyo ng mano-mano ngnuit ito kay kasali na para makatulong maiwasan ang mga hadlang sa pagpasok ng paggamit ng Dependcy Managrment. Kalaunan, maaring palaging tukuyinang mga bagay kung ikaw ay komportable na sa konsepto.

**public/index.php**

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

**public/index.php**

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

Susunod, i -rehistro ang pangunahing URL upang ang lahat na URL na nilikha ng Phalcon ay maisama ang "tyutoryal" na folder na i-setup kanina. This will become important later on in this tutorial when we use the class `Phalcon\Tag` to generate a hyperlink.

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

### Handling the application request

In the last part of this file, we find `Phalcon\Mvc\Application`. Its purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete.

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

### Putting everything together

The `tutorial/public/index.php` file should look like:

**public/index.php**

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

Kagaya ng makikita mo, ang bootstrap file ay napaikli at hindi na kailangang isali ang kahit na anong karagdagan na mga files. **Congratulations** ikaw ay papunta na sa pagkakaroon ng isang makunat na MVC na aplikasyon sa loob lamang ng 30 na linya ng palahudyatan.

<a name='controller'></a>

## Creating a Controller

Ayun sa default ang Phalcon ay maghahanap ng isang kontroler na nagngangalang **IndexController**. Ito ang simula na kung saan walang kontroler o aksyon ang naidagdag sa kahilingan. (eg. http://localhost:8000/) Ang **IndexController** at ang **IndexAction** ay dapat magkahawig sa sumusunod na halimbawa:

**app/controllers/IndexController.php**

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

**app/views/index/index.phtml**

```php
<?php echo "<h1>Hello!</h1>";
```

Our controller (`app/controllers/IndexController.php`) now has an empty action definition:

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

The browser output should remain the same. The `Phalcon\Mvc\View` static component is automatically created when the action execution has ended. Learn more about views usage [here](/[[language]]/[[version]]/views).

<a name='signup-form'></a>

## Designing a sign-up form

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

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

The generated HTML code displays an anchor ("a") HTML tag linking to a new controller:

**app/views/index/index.phtml Rendered**

```html
<h1>Hello!</h1>

<a href="/signup">Sign Up Here!</a>
```

To generate the tag we use the class `Phalcon\Tag`. This is a utility class that allows us to build HTML tags with framework conventions in mind. Ang klase din na ito ay isang serbisyo na nakarehistro sa DI at ginagamit namin ang `$this->tag` upang mapasok ito.

Isang detalyadong artikulo tungkol sa HTML na henerasyon ay makikita [dito<tags>](/[[language]]/[[version]]/tag).

![](/images/content/tutorial-basic-2.png)

Here is the Signup controller (`app/controllers/SignupController.php`):

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

The empty index action gives the clean pass to a view with the form definition (`app/views/signup/index.phtml`):

**app/views/signup/index.phtml**

```php
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

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` also provides useful methods to build form elements.

The `Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementing that method will remove the exception:

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

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

<a name='model'></a>

## Creating a Model

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Bago nilikha ang ating unang modelo, kailangan nating lumikha ng database na talaan sa labas ng Phalcon para ma-mapa ito. Ang simple na talaan kung saan i-impok ang mga nakarehistro na tagagamit ay puweding gawin katulad nito:

**create_users_table.sql**

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

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

## Setting a Database Connection

Upang magamit ang isang koneksyon ng database at sunod-sunod na pag-abot ng mga data gamit ang mga modelo, kailangan nating i-uriin ito sa ating bootstrap na proseso. A database connection is just another service that our application has that can be used for several components:

**public/index.php**

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

Sa simula ng **registerAction** tayo ay gagawa ng isang walang laman na bagay ng tagagamit galing sa klase ng Tagagamit, kung saan ito ay namamahal ng mga talaan ng Tagagamit. Ang klase ng publiko na mga katangian ng mapa sa paligid ng `users` na talaan ay nasa ating database. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Mga karagdagang pagpapatunay ay awtomatikong mangyayari sa paligid na nangangahulugang ito ay hindi null (kinakailangan). Kung hindi nating ipapasok ang mga kailangan na paligid sa sign-up na form ang ating eskrin ay magaging ganito:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

Tulad ng nakikita mo, madaling mag umpisang gumawa ng aplikasyon gamit ang Phalcon. Ang katunayan na ang Phalcon ay nagpapatakbo galing sa isang ekstinsyon ay makabuluhang nagbabawas ng mga bakas ng proyekto pati na rin ang pagbibigay ng mahalagang tulong sa pagganap nito.

Kung ikaw ay handa nang matuto ng marami pa siyasatin ang [Natitirang Tutorial](/[[language]]/[[version]]/tutorial-rest) sa susunod.