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

Sa buong unang bahagi ng pagtuturo na ito, ilalahad namin sa iyo ang paggawa ng isang aplikasyon na mayroong simpleng porma sa pagpaparehistro. Ipapaliwag din namin sa iyo ang pangunahing aspeto ng kaugalian ng framework na ito. Kung ikaw ay interesado sa awtomatikong paglikha ng mga tool para sa Phalcon, pwede mong tingnang ang aming [mga tool para sa mga developer](/[[language]]/[[version]]/developer-tools).

Ang pinakamaigi na paraan sa paggamit ng giyang ito ay ang pagsunod isa-isa sa lahat ng mga hakbang. Pwede mong kunin ang kompletong code [dito](https://github.com/phalcon/tutorial).

<a name='file-structure'></a>

## File structure

Ang Phalcon ay hindi ngpapatupad ng partikular na struktura para sa pagdevelop ng aplikasyon. Sa kadahilanan na bawat elemento dito ay konektado, pwede mong gawin ang isang Phalcon na aplikasyon sa struktura kung saan ka komportableng gamitin.

Para sa layunin ng pagtuturo na ito at para panimula, ito ang suhestiyon naming simpleng struktura:

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

Tandaan na hindi mo kailangan ng kahit na anong "library" na direktoryo na may kaugnayan sa Phalcon. Ang balangkas ay nasa memorya na mismo ng kompyuter, at pwede nang gamitin.

Bago magpatuloy, siguraduhin na matagumpay mong [na-install ang Phalcon](/[[language]]/[[version]]/installation) and na-setup na rin and alin man dito [nginX](/[[language]]/[[version]]/setup#nginx), [Apache](/[[language]]/[[version]]/setup#apache) or [Cherokee](/[[language]]/[[version]]/setup#cherokee).

<a name='bootstrap'></a>

## Bootstrap

Ang unang file na kailangan mong gawin ay ang bootstrap file. Ang file a ito ay napakahalaga; dahil ito ay nagsilbing basehan ng iyong aplikasyon, ito ay nagbibigay sayo ng kontrol sa lahat ng aspeto. Sa file na ito, maari mong e-implement ang pag-initialize ng mga bahagi pati na rin ang gawi ng aplikasyon.

Sa huli, ito ay responsable sa paggawa ng 3 mga bagay:

- Pagtatakda ng autoloader.
- Pagsasaayos ng Dependency Injector.
- Paghawak ng mga kahilingan ng aplikasyon.

<a name='autoloaders'></a>

### Autoloaders

Ang unang makikita natin sa bootstrap ay ang pag-rehistro ng autoloder. Ito ay gagamitin para i-load ang mga classes bilang controllers at models ng aplikasyon. Halimbawa, pwede tayong magrehistro ng isa o maraming mga direktoryo ng controllers para pataasin ang kakayahang umangkop ng aplikasyon. Sa ating halimbawa, ginagamit natin ang component `Phalcon\Loader`.

Dito, pwede nating i-load and classes gamit ang mga ibat-ibang stratehiya, pero para sa halimbawang ito, pinili natin na hanapin ang classes base sa paunang natukoy na mga direktoryo:

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
 
Context | Request Context;
```

<a name='dependency-management'></a>

### Dependency Management

Ang pinaka-importanteng konsepto na kailangang maintindihan kung magtatrabaho gamit ang Phalcon as ang `dependency injection container<di>`. Ito ay maaaring tunog komplekado pero ang totoo napakasimple lamang nitu at praktikal.

A service container ay isang bag kung saan iniimbak natin globally and mga serbisyo na gagamitin para gumana ang ating aplikasyon. Sa bawas oras na ang framework ay nangangailangan ng bahagi, tatanungin nitu ang container gamit ang napagkasunduang pangalan para sa serbisyo. Sa kadahilangan ang Phalcon ay siyang may mataas na antas bilang decoupled framework, `Phalcon\Di` ay nagsilbing pandikit na nangangasiwa sa pagsasama ng ibat-ibang bahagi para mapagtagumpayan ang kani-kanilang mga trabaho sa transparent na paraaan.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` ay isang variant ng `Phalcon\Di`. Upang mapadali ang ang mga bagay, ito ay awtomatikong mgrerehistro ng karamihan sa mga bahagi na may kinalaman sa Phalcon. Kaya hindi na natin kailangang i-rehistro pa sila isa-isa. Mamaya wala nang maaring maging problema sa pagpapaling ng factory service.

Sa susunod na bahagi, irehistro namin ang serbisyo ng "pagpakita" na nagpapahiwatig ng direktoryo kung saan makikita ng framework ang mga view na file. Tulad ng mga pagpakita ay hindi tumutugma sa mga klase, hindi sila maaaring singilin sa isang autoloader.

Ang mga serbisyo ay maaaring nakarehistro sa maraming paraan, ngunit para sa aming pagtuturo gagamitin namin ang isang [anonymous na punsyon](http://php.net/manual/en/functions.anonymous.php):

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

Ang susunod ay magparehistro kami ng base URI upang ang lahat ng mga URI na nabuo ni Phalcon ay kasama ang folder na "pagtuturo" na aming na-setup kanina. Ito ay magiging importanti mamaya sa pagtuturo na ito kapag ginagamit namin ang klase `Phalcon\Tag` upang bumuo ng isang hyperlink.

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

Sa huling bahagi ng file na ito, nahanap namin ang `Phalcon\ Mvc\Application`. Ang layunin nito ay upang simulan ang kahilingan sa kapaligiran, ruta ang parating na kahilingan, at pagkatapos ay magpadala ng anumang natuklasang mga aksyon; pinagsasama nito ang anumang mga tugon at ibinabalik ang mga ito kapag kumpleto na ang proseso.

```php
// ...

$application = new Application($di);

$response = $application->handle();

$response->send();
 
Context | Edit Context;
```

<a name='full-example'></a>

### Putting everything together

Ang `tutorial/public/index.php` na file ay dapat magmumukhang:

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

Tulad ng iyong nakikita, ang bootstrap file ay masyadong maikli at hindi namin kailangang isama ang anumang karagdagang mga file. Naitakda namin ang aming sarili ng malumanay na aplikasyon ng MVC sa mas mababa sa 30 linya ng code.

<a name='controller'></a>

## Creating a Controller

Bilang default ang Phalcon ay maghanap ng isang controller na may pangalang "Index". Ito ang panimulang punto kung wala nang controller o aksyon ang naipasa sa kahilingan. Ang index controller (`app/controllers/IndexController.php`) ay parang ganito:

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

Ang mga klase ng controller ay dapat magkaroon ng hulapi na "Controller" at mga aksyon ng controller ay dapat may hulapi na "Action". Kung na-access mo ang aplikasyon mula sa iyong browser, dapat mong makita ang isang bagay tulad nito:

![](/images/content/tutorial-basic-1.png)

Binabati kita! Ikaw ngayon ay naka-phlying gamit ang Phalcon!

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

The browser output should remain the same. The `Phalcon\Mvc\View` static component is automatically created when the action execution has ended. Learn more about `views usage here <views>`.

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

To generate the tag we use the class `Phalcon\Tag`. This is a utility class that allows us to build HTML tags with framework conventions in mind. As this class is a also a service registered in the DI we use `$this->tag` to access it.

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

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be defined like this:

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

In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. A database connection is just another service that our application has that can be used for several components:

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

Receiving data from the form and storing them in the table is the next step.

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

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields of the record in the users table. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign up form our screen will look like this:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

This is a very simple tutorial and as you can see, it's easy to start building an application using Phalcon. The fact that Phalcon is an extension on your web server has not interfered with the ease of development or features available. We invite you to continue reading the manual so that you can discover additional features offered by Phalcon!