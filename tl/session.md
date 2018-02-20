<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Pagtatago ng data sa Sesyon</a> <ul>
        <li>
          <a href="#start">Pagsisimula ng Sesyon</a>
        </li>
        <li>
          <a href="#store">Pagtatago/Pagkuha ng data sa Sesyon</a>
        </li>
        <li>
          <a href="#remove-destroy">Pagtanggal/Pagwasak ng mga Sesyon</a>
        </li>
        <li>
          <a href="#data-isolation">Paghihiwalay sa Data ng Sesyon sa pagitan ng mga Aplikasyon</a>
        </li>
        <li>
          <a href="#bags">Mga Bag ng Sesyon</a>
        </li>
        <li>
          <a href="#data-persistency">Paulit-ulit na Data sa mga Bahagi</a>
        </li>
        <li>
          <a href="#custom-adapters">Maipapatupad ang iyong mga adaptor</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Pagtatago ng Data sa Sesyon

Ang bahagi ng sesyon na nagbibigay na bagay-oriented na tagawrap upang mabuksan ang data ng sesyon.

Mga rason na gumamit na bahagi sa halip na mga hilaw-mga sesyon:

- Madaling mahiwalay ang sesyon sa pagitan ng data sa mga aplikasyon sa parehong domain
- Marahan kung saan ang sesyonay na-set/kunin sa iyong aplikasyon
- Baguhin ang adaptor ng sesyon ayon sa mga pangangailangan ng aplikasyon

<a name='start'></a>

## Pagsisimula ng Sesyon

Ilan sa mga aplikasyon ay sesyon-masinsinan, halos kahit anong aksyon na naganap ay nangangailangan na mabuksan sa data ng sesyon. May dalawang ibang paraan na bubukas sa caswal na data. Salamat sa mga lalagyan ng serbisyo, tayo ay makakasigurado na ang mga sesyon ay nabubukas lamang kapag malinaw na kinakailangan:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Start the session the first time when some component request the session service
$di->setShared(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

<a name='store'></a>

## Pagtatago/Pagkuha ng data ng Sesyon

Galing sa tagkontrol, ang isang tanawin o kahit anong bahagi na nagpapalawig `Phalcon\Di\Injectable` pwede mong mabuksan ang serbisyo ng sesyon at pagtago ng mga bagay at kunin sila sa sumusunod na paraan:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->session->set('user-name', 'Michael');
    }

    public function welcomeAction()
    {
        // Check if the variable is defined
        if ($this->session->has('user-name')) {
            // Retrieve its value
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## Pagtanggal/Pagwasak ng mga Sesyon

Posible din itong matanggal ang tiyak na mga varyabol o wasakin ang buong sesyon:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function removeAction()
    {
        // Remove a session variable
        $this->session->remove('user-name');
    }

    public function logoutAction()
    {
        // Destroy the whole session
        $this->session->destroy();
    }
}
```

<a name='data-isolation'></a>

## Paghihiwalay sa Data sa pagitan ng mga Apliksyon

Minsan ang isang gumagamit ay pwedeng gumamit ng parehong aplikasyon sa pangalawa, sa parehong server, sa parehong sesyon. Sigurado, kung tayu ay gagamit ng mga varyabol sa sesyon, gusto natin na bawat aplikasyon na magkaroon ng hiwalay na data ng sesyon (kahit na ang parehong code at parehong pangalan ng mga varyabol). Para malutas ito, pwede kang magdagdag ng prefix para sa bawat sesyon na varyabol sa isang siguradong aplikasyon:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Isolating the session data
$di->set(
    'session',
    function () {
        // All variables created will prefixed with 'my-app-1'
        $session = new Session(
            [
                'uniqueId' => 'my-app-1',
            ]
        );

        $session->start();

        return $session;
    }
);
```

Magdadagdag ng isang walang kaparehong ID ay hindi kailangan.

<a name='bags'></a>

## Session Bags

`Phalcon\Session\Bag` is a component that helps separating session data into `namespaces`. Working by this way you can easily create groups of session variables into the application. By only setting the variables in the `bag`, it's automatically stored in session:

```php
<?php

use Phalcon\Session\Bag as SessionBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
```

<a name='data-persistency'></a>

## Persistent Data in Components

Controller, components and classes that extends `Phalcon\Di\Injectable` may inject a `Phalcon\Session\Bag`. This class isolates variables for every class. Thanks to this you can persist data between requests in every class in an independent way.

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Create a persistent variable 'name'
        $this->persistent->name = 'Laura';
    }

    public function welcomeAction()
    {
        if (isset($this->persistent->name)) {
            echo 'Welcome, ', $this->persistent->name;
        }
    }
}
```

In a component:

```php
<?php

use Phalcon\Mvc\User\Component;

class Security extends Component
{
    public function auth()
    {
        // Create a persistent variable 'name'
        $this->persistent->name = 'Laura';
    }

    public function getAuthName()
    {
        return $this->persistent->name;
    }
}
```

The data added to the session (`$this->session`) are available throughout the application, while persistent (`$this->persistent`) can only be accessed in the scope of the current class.

<a name='custom-adapters'></a>

## Implementing your own adapters

The `Phalcon\Session\AdapterInterface` interface must be implemented in order to create your own session adapters or extend the existing ones.

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter)