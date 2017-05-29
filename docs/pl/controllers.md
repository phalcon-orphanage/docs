<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Przegląd</a> <ul>
        <li>
          <a href="#using">Używanie kontrolerów</a>
        </li>
        <li>
          <a href="#dispatch-loop">Pętla Komunikacyjna (ang. Dispatch Loop)</a>
        </li>
        <li>
          <a href="#initializing">Inicjowanie kontrolerów</a>
        </li>
        <li>
          <a href="#injecting-services">Wstrzykiwanie serwisów</a>
        </li>
        <li>
          <a href="#request-response">Żądanie i Odpowiedź</a>
        </li>
        <li>
          <a href="#session-data">Dane Sesji</a>
        </li>
        <li>
          <a href="#services">Using Services as Controllers</a>
        </li>
        <li>
          <a href="#events">Zdarzenia w Kontrolerach</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Przegląd

<a name='using'></a>

## Używanie kontrolerów

Akcje to metody w kontrolerze, które obsługują żądania. Domyślnie wszystkie publiczne metody w kontrolerze mapują do akcji i są dostępne za pomocą adresu URL. Akcje są odpowiedzialne za interpretację żądania i utworzenie odpowiedzi. Zwykle odpowiedzi są w formie renderowanego widoku, chociaż są również inne sposoby ich tworzenia.

Na przykład, kiedy wchodzisz na adres URL jak ten: `http://localhost/blog/posts/show/2015/the-post-title` Phalcon domyślnie rozłoży każdą część adresu w następujący sposób:

| Opis                 | Fragment URL   |
| -------------------- | -------------- |
| **Katalog Phalcona** | blog           |
| **Kontroler**        | posts          |
| **Akcja**            | show           |
| **Parametr**         | 2015           |
| **Parametr**         | the-post-title |

W takim przypadku PostsController obsłuży żądanie. Nie ma narzuconej lokalizacji w której należy umieszczać kontrolery w aplikacji, mogą być one dołączane za pomocą :doc:`autoloaders <loader>`, więc masz wolną rękę w organizowaniu kontrolerów według Twoich potrzeb.

Kontrolery muszą mieć sufiks 'Controller' podczas gdy akcje przyrostek 'Action'. Przykładowy kontroler wygląda następująco:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {

    }
}
```

Dodatkowe parametry URI są zdefiniowane jako parametry akcji, więc mogą być łatwo dostępne poprzez użycie lokalnych zmiennych. Kontroler może opcjonalnie rozszerzać `Phalcon\Mvc\Controller`. W ten sposób kontroler może mieć łatwy dostęp do aplikacyjnych serwisów.

Parametry bez domyślnej wartości są obsługiwane jako wymagane. Ustawianie opcjonalnych wartości dla parametrów odbywa się tak, jak zazwyczaj w PHP:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year = 2015, $postTitle = 'przykładowy tytuł')
    {

    }
}
```

Parametry są przypisane w tej samej kolejności, jak zostały przesłane w ścieżce Url. Możesz pobrać dowolny parametr korzystając z jego nazwy w następujący sposób:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        $year      = $this->dispatcher->getParam('year');
        $postTitle = $this->dispatcher->getParam('postTitle');
    }
}
```

<a name='dispatch-loop'></a>

## Pętla Komunikacyjna (ang. Dispatch Loop)

Pętla Komunikacyjna (ang. Dispatch Loop) będzie realizowana w ramach Dyspozytora, dopóki nie będzie już żadnych akcji do wykonania. W poprzednim przykładzie wykonano tylko jedną akcję. Teraz zobaczmy jak metoda `forward()`może dostarczyć bardziej złożony przepływ operacji w Pętli Komunikacyjnej, poprzez przekierowanie wykonania do innego kontrolera/akcji.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {
        $this->flash->error(
            "Nie masz dostępu do tego zasobu"
        );

        // Przekazanie przepływu operacji do innej akcji
        $this->dispatcher->forward(
            [
                'controller' => 'users',
                'action'     => 'signin',
            ]
        );
    }
}
```

Jeżeli użytkownicy nie mają pozwolenia na dostęp do pewnej akcji, zostają wyekspediowani do akcji 'signin' w kontrolerze 'Users'.

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function signinAction()
    {

    }
}
```

W Twojej aplikacji nie ma limitu dla 'ekspediowań' tak długo, jak nie prowadzą do odwołań cyklicznych, co skutkuje zatrzymaniem programu. Jeżeli nie ma więcej akcji do wyekspediowania poprzez Pętle Komunikacyjną (ang. Dispatch Loop), Dyspozytor automatycznie wywoła warstwę widoku MVC, która jest zarządzana przez `Phalcon\Mvc\View`.

<a name='initializing'></a>

## Inicjowanie kontrolerów

`Phalcon\Mvc\Controller` oferuje metodę `initialize()`, która jest wykonywana jako pierwsza, przed realizowaniem każdej innej akcji kontrolera. Używanie metody `__construct()` nie jest zalecane.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public $settings;

    public function initialize()
    {
        $this->settings = [
            'mySetting' => 'value',
        ];
    }

    public function saveAction()
    {
        if ($this->settings['mySetting'] === 'value') {
            // ...
        }
    }
}
```

<h5 class='alert alert-warning'>Metoda <code>initialize()</code> jest wywołana tylko wtedy, gdy zdarzenie <code>beforeExecuteRoute</code> zostało wykonane z powodzeniem. To powoduje, że logika aplikacji podczas inicjowania nie może zostać wykonana bez autoryzacji.</h5>

Jeżeli chcesz wykonać jakąś logikę podczas inicjowania, zaraz po utworzeniu obiektu kontrolera, możesz zaimplementować metodę `onConstruct()`:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function onConstruct()
    {
        // ...
    }
}
```

<h5 class='alert alert-warning'>Zwróć szczególną uwagę na to, że metoda <code>onConstruct()</code> jest wykonywana nawet wtedy, gdy akcja do realizacji nie istnieje w kontrolerze lub gdy użytkownik nie ma do niej dostępu (odnosząc się do niestandardowej kontroli dostępu dostarczonej przez Dewelopera).</h5>

<a name='injecting-services'></a>

## Wstrzykiwanie serwisów

Jeżeli kontroler rozszerza `Phalcon\Mvc\Controller`, wtedy posiada łatwy dostęp do kontenera serwisów w aplikacji. Na przykład, jeśli zarejestrowaliśmy serwis wyglądający tak:

```php
<?php

use Phalcon\Di;

$di = new Di();

$di->set(
    'storage',
    function () {
        return new Storage(
            '/some/directory'
        );
    },
    true
);
```

Wtedy mamy dostęp do tego serwisu na kilka różnych sposobów:

```php
<?php

use Phalcon\Mvc\Controller;

class FilesController extends Controller
{
    public function saveAction()
    {
        // Wstrzyknięcie serwisu poprzez dostęp do zmiennej o takiej samej nazwie
        $this->storage->save('/some/file');

        // Dostęp do serwisu z Kontenera Zależności
        $this->di->get('storage')->save('/some/file');

        // Kolejny sposób na dostęp do serwisu używając magicznego Akcesora
        $this->di->getStorage()->save('/some/file');

        // I jeszcze inny sposób na dostęp do serwisu używając magicznego Akcesora
        $this->getDi()->getStorage()->save('/some/file');

        // Użycie tablicowej składni
        $this->di['storage']->save('/some/file');
    }
}
```

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/[[language]]/[[version]]/di) in the framework.

<a name='request-response'></a>

## Żądanie i Odpowiedź

Przy założeniu, że framework dostarcza zestaw wstępnie zarejestrowanych serwisów, wyjaśnimy jak przeprowadzać interakcję ze środowiskiem HTTP. Serwis 'request' zawiera instancję klasy `Phalcon\Http\Request` oraz usługa 'response' obejmuje instancję klasy `Phalcon\Http\Response` reprezentując to, co ma być zwrócone do klienta.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Sprawdź czy żądanie zostało wykonane za pomocą metody POST
        if ($this->request->isPost()) {
            // Dostęp do danych z POST
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

Zwracany obiekt nie jest zazwyczaj używany bezpośrednio, ale jest zbudowany przed wykonaniem akcji, niekiedy jednak, jak w zdarzeniu `afterDispatch` - dostęp do bezpośredniej odpowiedzi może być użyteczny:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function notFoundAction()
    {
        // Wyślij nagłówek odpowiedzi HTTP 404
        $this->response->setStatusCode(404, 'Not Found');
    }
}
```

Learn more about the HTTP environment in their dedicated articles [request](/[[language]]/[[version]]/request) and [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Dane Sesji

Sessions help us maintain persistent data between requests. You can access a `Phalcon\Session\Bag` from any controller to encapsulate data that needs to be persistent:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Michael';
    }

    public function welcomeAction()
    {
        echo 'Welcome, ', $this->persistent->name;
    }
}
```

<a name='services'></a>

## Using Services as Controllers

Services may act as controllers, controllers classes are always requested from the services container. Accordingly, any other class registered with its name can easily replace a controller:

```php
<?php

// Register a controller as a service
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Register a namespaced controller as a service
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='using'></a>

0## Events in Controllers

Controllers automatically act as listeners for [dispatcher](/en/[[versopm]]/dispatcher) events, implementing methods with those event names allow you to implement hook points before/after the actions are executed:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // This is executed before every found action
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "You don't have permission to save posts"
            );

            $this->dispatcher->forward(
                [
                    'controller' => 'home',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        // Executed after every found action
    }
}
```