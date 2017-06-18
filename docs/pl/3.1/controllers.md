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

# Overview

<a name='using'></a>

## Using Controllers

Akcje to metody w kontrolerze, które obsługują żądania. Domyślnie wszystkie publiczne metody w kontrolerze mapują do akcji i są dostępne za pomocą adresu URL. Akcje są odpowiedzialne za interpretację żądania i utworzenie odpowiedzi. Zwykle odpowiedzi są w formie renderowanego widoku, chociaż są również inne sposoby ich tworzenia.

Na przykład, kiedy wchodzisz na adres URL jak ten: `http://localhost/blog/posts/show/2015/the-post-title` Phalcon domyślnie rozłoży każdą część adresu w następujący sposób:

| Description          | Fragment URL   |
| -------------------- | -------------- |
| **Katalog Phalcona** | blog           |
| **Kontroler**        | posts          |
| **Akcja**            | show           |
| **Parametr**         | 2015           |
| **Parameter**        | the-post-title |

In this case, the `PostsController` will handle this request. There is no a special location to put controllers in an application, they could be loaded using `Phalcon\Loader`, so you're free to organize your controllers as you need.

Controllers must have the suffix `Controller` while actions the suffix `Action`. A sample of a controller is as follows:

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

## Dispatch Loop

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

If users don't have permission to access a certain action then they will be forwarded to the `signin` action in the `UsersController`.

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

There is no limit on the `forwards` you can have in your application, so long as they do not result in circular references, at which point your application will halt. Jeżeli nie ma więcej akcji do wyekspediowania poprzez Pętle Komunikacyjną (ang. Dispatch Loop), Dyspozytor automatycznie wywoła warstwę widoku MVC, która jest zarządzana przez `Phalcon\Mvc\View`.

<a name='initializing'></a>

## Initializing Controllers

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

<h5 class='alert alert-warning'>The <code>initialize()</code> method is only called if the <code>beforeExecuteRoute</code> event is executed with success. This avoid that application logic in the initializer cannot be executed without authorization.</h5>

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

<h5 class='alert alert-warning'>Be aware that <code>onConstruct()</code> method is executed even if the action to be executed doesn't exist in the controller or the user does not have access to it (according to custom control access provided by the developer).</h5>

<a name='injecting-services'></a>

## Injecting Services

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

## Request and Response

Przy założeniu, że framework dostarcza zestaw wstępnie zarejestrowanych serwisów, wyjaśnimy jak przeprowadzać interakcję ze środowiskiem HTTP. The `request` service contains an instance of `Phalcon\Http\Request` and the `response` contains a `Phalcon\Http\Response` representing what is going to be sent back to the client.

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

## Session Data

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

<a name='events'></a>

## Events in Controllers

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