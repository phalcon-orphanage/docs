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

Wysyłanie danych wyjściowych do widoku
------------------------
Wysyłanie danych wyjściowych na ekran z kontrolera jest czasami konieczne, ale niepożądane jako, że większość purystów ze społeczności MVC tego nie zatwierdzi. Wszystko co jest odpowiedzialne za wyświetlanie danych na ekranie musi być przekazane do widoku. Phalcon będzie szukał widoku o takiej samej nazwie jak wykonywana akcja w katalogu nazwanym tak, jak ostatni wykonywany kontroler. W naszym przypadku (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";

Nasz kontroler (app/controllers/IndexController.php) obecnie posiada pustą definicję akcji:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {

        }
    }

Ekran przeglądarki powinien pozostać niezmieniony. Statyczny komponent widoku :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` jest automatycznie tworzony, gdy wykonywanie akcji zostaje zakończone. Dowiedz się więcej o :doc:`używaniu widoków tutaj <views>`.

Projektowanie rejestracyjnego formularza
------------------------
Teraz zmienimy plik widoku index.phtml, aby dodać odsyłacz do nowego kontrolera o nazwie "signup". Celem jest umożliwienie użytkownikom rejestracji w naszej aplikacji.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo PHP_EOL;

    echo PHP_EOL;

    echo $this->tag->linkTo(
        "signup",
        "Sign Up Here!"
    );

Wygenerowany kod HTML wyświetla HTML-owy znacznik odsyłacza ("a"), który wskazuje na nowy kontroler:

.. code-block:: html

    <h1>Hello!</h1>

    <a href="/tutorial/signup">Sign Up Here!</a>

Do wygenerowania wspomnianego znacznika użyliśmy klasy :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`. Jest to klasa użytkowa, która pozwala nam budować znaczniki HTML zgodnie z zachowaniem framework'owej konwencji. Jako, że ta klasa jest również serwisem zarejestrowanym w Kontenerze Zależności, aby mieć do niej dostęp używamy :code:`$this->tag`.

Bardziej szczegółowy artykuł odnoszący się do generowania znaczników HTML można :doc:`znaleźć tutaj <tags>`.

.. figure:: ../_static/img/tutorial-2.png
    :align: center

Tak wygląda kontroler Signup (app/controllers/SignupController.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }
    }

Pusta akcja index umożliwia czyste przejście do widoku z definicją formularza (app/views/signup/index.phtml):

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

Przeglądanie formularza w Twojej przeglądarce wyświetli coś takiego:

.. figure:: ../_static/img/tutorial-3.png
    :align: center

:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` dostarcza również użytecznych metod do budowania elementów formularza.

Metoda :code:`Phalcon\Tag::form()` odbiera tylko jeden parametr od razu - relatywny URI do kontrolera/akcji w aplikacji.

Klikając przycisk "Send", zaobserwujesz wyjątek pochodzący z framework'a, wskazujący, że brakuje nam akcji "register" w kontrolerze "signup". Nasz plik public/index.php wyrzuca taki wyjątek:

    Exception: Action "register" was not found on handler "signup"

Implementacja takiej metody usunie wspomniany wyjątek:

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

Jeżeli klikniesz przycisk "Send" ponownie, zobaczysz pustą stronę. Wprowadzone przez użytkownika imię oraz e-mail powinny być zapisane w bazie danych. Zgodnie z wytycznymi MVC, interakcje bazodanowe muszą odbywać się poprzez modele po to, by zagwarantować przejrzysty obiektowo-zorientowany kod.

Tworzenie Modelu
----------------
Phalcon wprowadza pierwsze ORM (mapowanie obiektowo-relacyjne) dla PHP w całości napisane w języku C. Zamiast zwiększenia kompleksowości rozwoju aplikacji, upraszcza ją.

Zanim utworzymy nasz pierwszy model, potrzebujemy przygotować tabelę bazodanową poza Phalconem, aby zmapować ją z modelem. Prosta tabela do przechowywania zarejestrowanych użytkowników może być zdefiniowana na przykład tak:

.. code-block:: sql

    CREATE TABLE `users` (
        `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
        `name`  varchar(70)          NOT NULL,
        `email` varchar(70)          NOT NULL,

        PRIMARY KEY (`id`)
    );

Model powienien być położony w katalogu app/models (app/models/Users.php). Poniższy model mapuje do tabeli "users":

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Users extends Model
    {
        public $id;

        public $name;

        public $email;
    }

Ustawienie połączenia z bazą danych
-----------------------------
W celu umożliwienia używania połączenia z bazą danych i następnie dostępu do danych poprzez nasz model, potrzebujemy określenia połączenia w naszym bootstrapowym procesie. Połączenie z bazą danych to po prostu kolejny serwis, który nasza aplikacja posiada i który może być użyty przez kilka komponentów:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // Ustawienie serwisu bazy danych
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

Z poprawnymi parametrami dostępu do bazy danych, nasze modele są gotowe do pracy i interakcji z resztą aplikacji.

Przechowywanie danych używając modeli
-------------------------
Otrzymywanie danych z formularza i gromadzenie ich w tabeli jest następnym krokiem.

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

            // Zachowaj i sprawdź czy nie ma błędów
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

Następnie inicjujemy klasę Users, która odnosi się do rekordu User. Publiczne atrybuty klasy mapują do pól rekordu w tabeli Users. Ustawienie stosownych wartości w nowym rekordzie oraz wywołanie metody :code:`save()` zachowa dane w bazie danych dla tego rekordu. Metoda :code:`save()` zwraca wartość boolean, która wskazuje czy zapis danych był zakończony sukcesem, czy nie.

ORM domyślnie oczyszcza dane wejściowe chroniąc przed wstrzykiwaniem kodu SQL, więc musimy tylko przesłać dane do metody :code:`save()`.

Dodatkowa walidacja działa automatycznie dla pól, które są zdefiniowane jako niepuste (wymagane). Jeżeli nie wprowadzimy dowolnego z wymaganych pól w formularzu rejestracyjnym, nasz ekran będzie wyglądał tak:

.. figure:: ../_static/img/tutorial-4.png
    :align: center

Reasumując
----------
To bardzo prosty tutorial i jak możesz zauważyć, nie ma nic trudnego w budowaniu aplikacji używając Phalcona.
Fakt, że Phalcon jest dodatkiem do Twojego Web Servera nie ingeruje w łatwość rozwoju lub dostępne cechy.
Zapraszamy Cię do kontynuowania czytania podręcznika, abyś mógł/mogła odkryć dodatkowe cechy, które oferuje Phalcon!

.. _anonimowa funkcja: http://php.net/manual/en/functions.anonymous.php
