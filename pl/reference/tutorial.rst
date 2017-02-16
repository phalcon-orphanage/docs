Tutorial 1: Nauczmy się przez przykład
======================================
W naszym pierwszym tutorialu, przeprowadzimy Cię przez  tworzenie aplikacji z prostym formularzem rejestracyjnym od podstaw.
Wyjaśnimy również podstawowe aspekty działania frameworka. Jeżeli jesteś zainteresowany narzędziami do automatycznego generowania kodu,
możesz sprawdzić nasze :doc:`developer tools <tools>`.

Najlepszym sposobem na skorzystanie z tego tutoriala jest jego śledzenie krok po kroku. Możesz uzyskać kompletny kod
`tutaj <https://github.com/phalcon/tutorial>`_.

Struktura plików
----------------
Phalcon nie narzuca konkretnej struktury plików do tworzenia aplikacji. Ze względu na fakt, że jest ona dowolna,
możesz zaimplementować aplikacje ze strukturą plików, która najbardziej Tobie odpowiada.

Na potrzeby tego tutoriala i jako punkt startowy, proponujemy następującą strukturę:

.. code-block:: php

    tutorial/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/

Zauważ, że nie potrzebujesz żadnych folderów "bibliotek" związanych z Phalconem. Framework jest dostępny w pamięci,
gotowy do użycia.

Before continuing, please be sure you've successfully :doc:`installed Phalcon <install>` and have setup either :doc:`Nginx <nginx>`, :doc:`Apache <apache>` or :doc:`Cherokee <cherokee>`.

Bootstrap
---------
Pierwszym plikiem, który musisz stworzyć jest plik Bootstrap. Ten plik jest bardzo ważny; ponieważ służy
jako baza Twojej aplikacji, dając Ci kontrolę nad wszystkimi jego aspektami. W tym pliku możesz zaimplementować
inicjalizację komponentów, jak również zachowań aplikacji.

Ultimately, it is responsible for doing 3 things:

1. Setting up the autoloader.
2. Configuring the Dependency Injector.
3. Handling the application request.

Autoloadery
^^^^^^^^^^^
Pierwszą częścią, którą znajdziemy w naszym pliku bootstrap jest rejestracja autoloadera. Autoloader ten będzie użyty do załadowania klas w aplikacji jako kontrolery i modele. Na przykład, możemy zarejestrować jeden lub więcej folderów kontrolerów, zwiększając elastyczność aplikacji. W naszym przykładzie użyliśmy komponentu :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`.

Dzięki niemu, możemy załadować klasy z zastosowaniem różnych strategii, jednak w tym przykładzie zdecydowaliśmy się zlokalizować klasy w oparciu o predefiniowane katalogi:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // ...

    $loader = new Loader();

    $loader->registerDirs(
        [
            "../app/controllers/",
            "../app/models/",
        ]
    );

    $loader->register();

Zarządzanie zależnościami
^^^^^^^^^^^^^^^^^^^^^^^^^
Bardzo ważnym pojęciem, które musi być zrozumiane podczas pracy z Phalconem jest jego :doc:`dependency injection container <di>`. Może to brzmieć bardzo skomplikowanie, ale jest bardzo proste i praktyczne.

Kontener Zależności jest zbiorem, który globalnie przechowuje wszelkie serwisy, z których korzysta nasza aplikacja. Za każdym razem gdy Framework wymaga któregoś komponentu, zapyta Kontener o uzgodnioną nazwę danego serwisu. Od kiedy Phalcon jest wysoce rozłączonym Frameworkiem, Kontener Zależności pełni rolę kleju, który łączy różne komponenty osiągając ich synergię.  

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    // ...

    // Stwórz DI
    $di = new FactoryDefault();

:doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` jest odmianą :doc:`Phalcon\\Di <../api/Phalcon_Di>`. Aby ułatwić pracę, Kontener Zależności automatycznie rejestruje większość użytecznych komponentów Phalcona od razu, dzięki temu nie musimy rejestrować ich każdy z osobna. W późniejszym czasie nie będzie także problemu z podmianą fabrycznie wbudowanego serwisu.  

W następnej części Tutoriala rejestrujemy serwis "Widoku" wskazujący ścieżkę w aplikacji, skąd Framework pobierze pliki widoków. Przyjęte jest, że widoki nie odnoszą się do klas, więc nie mogą być wczytane za pomocą Autoloadera. 

Serwisy mogą być zarejestrowane na kilka sposobów, ale na potrzeby naszego Tutoriala zostanie użyta `anonimowa funkcja`_:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // ...

    // Ustaw komponent widoku
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../app/views/");

            return $view;
        }
    );

Następnie rejestrujemy podstawowy URI, aby wszystkie URI wygenerowane przez Phalcona uwzględniały folder "tutorial", który ustawiliśmy wcześniej.
Okaże się to ważne dopiero później w tym tutorialu, gdy będziemy używać klasę :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`
do generowania hiperłącza.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url as UrlProvider;

    // ...

    // Ustaw podstawowy URI, aby wszystkie wygenerowane URI uwzględniały folder "tutorial"
    $di->set(
        "url",
        function () {
            $url = new UrlProvider();

            $url->setBaseUri("/tutorial/");

            return $url;
        }
    );

Obsługa aplikacyjnego żądania 
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
W ostatniej części tego pliku widzimy :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. Celem tej klasy jest
zainicjowanie żądanego środowiska i trasy nadchodzącego żądania, a następnie wyekspediowanie każdych odkrytych akcji;
agreguje ona każde odpowiedzi i zwraca je, gdy cały proces zostanie zakończony.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // ...

    $application = new Application($di);

    $response = $application->handle();

    $response->send();

Ujmując wszystko w całość
^^^^^^^^^^^^^^^^^^^^^^^^^^^
Plik tutorial/public/index.php powinien wyglądać następująco:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Mvc\Url as UrlProvider;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;



    // Rejestruj autoloader
    $loader = new Loader();

    $loader->registerDirs(
        [
            "../app/controllers/",
            "../app/models/",
        ]
    );

    $loader->register();



    // Stwórz DI
    $di = new FactoryDefault();

    // Ustaw komponent widoku
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../app/views/");

            return $view;
        }
    );

    // Ustaw podstawowy URI, aby wszystkie wygenerowane URI uwzględniały folder "tutorial"
    $di->set(
        "url",
        function () {
            $url = new UrlProvider();

            $url->setBaseUri("/tutorial/");

            return $url;
        }
    );



    $application = new Application($di);

    try {
        // Obsłuż żądanie
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Jak widać plik 'bootstrap' jest bardzo oszczędny i nie potrzebujemy uwzględniać w nim żadnych dodatkowych plików. Samodzielnie
napisaliśmy elastyczną aplikację MVC w mniej, niż 30-tu linijkach kodu.

Tworzenie Kontrolera
---------------------
Domyślnie Phalcon będzie szukał kontrolera o nazwie "Index". To punkt startowy w sytuacji, gdy żaden kontroler lub
akcja nie zostały przesłane w żądaniu. Kontroler "Index" (app/controllers/IndexController.php) wygląda następująco:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {
            echo "<h1>Hello!</h1>";
        }
    }

Klasy kontrolera muszą zawierać sufiks "Controller" oraz akcje kontrolera wymagają przyrostka "Action". Jeżeli uruchomisz aplikację poprzez przeglądarkę, powinieneś zobaczyć coś takiego:

.. figure:: ../_static/img/tutorial-1.png
    :align: center

Gratulacje, latasz z Phalconem!

Sending output to a view
------------------------
Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";

Our controller (app/controllers/IndexController.php) now has an empty action definition:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {

        }
    }

The browser output should remain the same. The :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` static component is automatically created when the action execution has ended. Learn more about :doc:`views usage here <views>`.

Designing a sign up form
------------------------
Now we will change the index.phtml view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo PHP_EOL;

    echo PHP_EOL;

    echo $this->tag->linkTo(
        "signup",
        "Sign Up Here!"
    );

The generated HTML code displays an anchor ("a") HTML tag linking to a new controller:

.. code-block:: html

    <h1>Hello!</h1>

    <a href="/tutorial/signup">Sign Up Here!</a>

To generate the tag we use the class :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`. This is a utility class that allows
us to build HTML tags with framework conventions in mind. As this class is a also a service registered in the DI
we use :code:`$this->tag` to access it.

A more detailed article regarding HTML generation can be :doc:`found here <tags>`.

.. figure:: ../_static/img/tutorial-2.png
    :align: center

Here is the Signup controller (app/controllers/SignupController.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }
    }

The empty index action gives the clean pass to a view with the form definition (app/views/signup/index.phtml):

.. code-block:: html+php

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

Viewing the form in your browser will show something like this:

.. figure:: ../_static/img/tutorial-3.png
    :align: center

:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` also provides useful methods to build form elements.

The :code:`Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in
the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our public/index.php file throws this exception:

    Exception: Action "register" was not found on handler "signup"

Implementing that method will remove the exception:

.. code-block:: php

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

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

Creating a Model
----------------
Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be defined like this:

.. code-block:: sql

    CREATE TABLE `users` (
        `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
        `name`  varchar(70)          NOT NULL,
        `email` varchar(70)          NOT NULL,

        PRIMARY KEY (`id`)
    );

A model should be located in the app/models directory (app/models/Users.php). The model maps to the "users" table:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Users extends Model
    {
        public $id;

        public $name;

        public $email;
    }

Setting a Database Connection
-----------------------------
In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. A database connection is just another service that our application has that can be used for several components:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // Setup the database service
    $di->set(
        "db",
        function () {
            return new DbAdapter(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "test_db",
                ]
            );
        }
    );

With the correct database parameters, our models are ready to work and interact with the rest of the application.

Storing data using models
-------------------------
Receiving data from the form and storing them in the table is the next step.

.. code-block:: php

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

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields
of the record in the users table. Setting the relevant values in the new record and calling :code:`save()` will store the data in the database for that record. The :code:`save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the :code:`save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign up form our screen will look like this:

.. figure:: ../_static/img/tutorial-4.png
    :align: center

Conclusion
----------
This is a very simple tutorial and as you can see, it's easy to start building an application using Phalcon.
The fact that Phalcon is an extension on your web server has not interfered with the ease of development or
features available. We invite you to continue reading the manual so that you can discover additional features offered by Phalcon!

.. _anonimowa funkcja: http://php.net/manual/en/functions.anonymous.php
