<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Przegląd</a> 
      <ul>
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
          <a href="#services">Korzystanie z Serwisów jako Kontrolerów</a>
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

W takim przypadku `PostsController` obsłuży to żądanie. Nie istnieje specjalna lokalizacja w której należy umieszczać kontrolery aplikacji, mogą być one załadowane za pomocą `Phalcon\Loader`, więc możesz organizować Twoje kontrolery tak, jak potrzebujesz.

Kontrolery muszą mieć sufiks `Controller`, podczas gdy akcje sufiks `Action`. Przykładowy kontroler wygląda następująco:

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

Jeżeli użytkownicy nie mają pozwolenia na dostęp do pewnej akcji, to zostaną przekierowani do akcji `signin` w `UsersController`.

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

W Twojej aplikacji nie ma limitu dla `przekazywań` tak długo, jak nie prowadzą do odwołań cyklicznych, co skutkuje zatrzymaniem programu. Jeżeli nie ma więcej akcji do wyekspediowania poprzez Pętle Komunikacyjną (ang. Dispatch Loop), Dyspozytor automatycznie wywoła warstwę widoku MVC, która jest zarządzana przez `Phalcon\Mvc\View`.

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

<div class="alert alert-warning">
    <p>
       Metoda <code>initialize()</code> jest wywołana tylko wtedy, gdy zdarzenie <code>beforeExecuteRoute</code> zostało wykonane z powodzeniem. To powoduje, że logika aplikacji podczas inicjowania nie może zostać wykonana bez autoryzacji.
    </p>
</div>

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

<div class='alert alert-warning'>
    <p>
        Zwróć szczególną uwagę na to, że metoda <code>onConstruct()</code> jest wykonywana nawet wtedy, gdy akcja do realizacji nie istnieje w kontrolerze lub gdy użytkownik nie ma do niej dostępu (odnosząc się do niestandardowej kontroli dostępu dostarczonej przez Dewelopera).
    </p>
</div>

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

Jeżeli używasz Phalcona jako pełnowartościowego frameworka, możesz odczytywać serwisy dostarczone [domyślnie](/[[language]]/[[version]]/di) w jego ramach.

<a name='request-response'></a>

## Żądanie i Odpowiedź

Przy założeniu, że framework dostarcza zestaw wstępnie zarejestrowanych serwisów, wyjaśnimy jak przeprowadzać interakcję ze środowiskiem HTTP. Usługa `request` zawiera instancję `Phalcon\Http\Request` oraz `response` zawiera `Phalcon\Http\Response` reprezentującą to, co jest do wysłania z powrotem do klienta.

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

Dowiedz się więcej na temat środowiska HTTP w ich dedykowanych artykułach [request](/[[language]]/[[version]]/request) i [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Dane Sesji

Sesje pomagają nam zarządzać trwałymi danymi pomiędzy żądaniami. Możesz się dostać do `Phalcon\Session\Bag` z każdego kontrolera do hermetyzowania danych, które mają być trwałe:

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

## Korzystanie z Serwisów jako Kontrolerów

Serwisy mogą zachowywać się jak kontrolery, klasy kontrolerów są zawsze pobierane z kontenera serwisów. Odpowiednio każda inna klasa zarejestrowana z jej nazwą, może łatwo zastąpić kontroler:

```php
<?php

// Zarejestruj kontroler jako serwis
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Zarejestruj kontroler z przestrzenią nazw jako serwis
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='events'></a>

## Zdarzenia w Kontrolerach

Controllers automatically act as listeners for [dispatcher](/[[language]]/[[version]]/dispatcher) events, implementing methods with those event names allow you to implement hook points before/after the actions are executed:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // Wykonywane przed każdą znalezioną akcją
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "Nie posiadasz uprawnień do zapisywania postów"
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
        // Wykonywane po każdej znalezionej akcji
    }
}
```