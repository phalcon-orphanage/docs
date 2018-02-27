<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Storing data in the Session</a> <ul>
        <li>
          <a href="#start">Starting the Session</a> <ul>
            <li>
              <a href="#start-factory">Factory</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#store">Storing/Retrieving data in Session</a>
        </li>
        <li>
          <a href="#remove-destroy">Removing/Destroying Sessions</a>
        </li>
        <li>
          <a href="#data-isolation">Isolating Session Data between Applications</a>
        </li>
        <li>
          <a href="#bags">Session Bags</a>
        </li>
        <li>
          <a href="#data-persistency">Persistent Data in Components</a>
        </li>
        <li>
          <a href="#custom-adapters">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Storing data in the Session

The session component provides object-oriented wrappers to access session data.

Reasons to use this component instead of raw-sessions:

- You can easily isolate session data across applications on the same domain
- Intercept where session data is set/get in your application
- Change the session adapter according to the application needs

<a name='start'></a>

## Starting the Session

Some applications are session-intensive, almost any action that performs requires access to session data. There are others who access session data casually. Thanks to the service container, we can ensure that the session is accessed only when it's clearly needed:

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

<a name='start-factory'></a>

## Factory

Loads Session Adapter class using `adapter` option

```php
<?php

use Phalcon\Session\Factory;

$options = [
    'uniqueId'   => 'my-private-app',
    'host'       => '127.0.0.1',
    'port'       => 11211,
    'persistent' => true,
    'lifetime'   => 3600,
    'prefix'     => 'my_',
    'adapter'    => 'memcache',
];

$session = Factory::load($options);
```

<a name='store'></a>

## Storing/Retrieving data in Session

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

## Removing/Destroying Sessions

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

## Isolating Session Data between Applications

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

`Phalcon\Session\Bag` ay isang bahagi na tumutulong na pahiwalayin ang mga sesyon ng data patungo `namespaces`. Sa pagtratrabaho sa ganitong paran madali kang makakagawa ng mga grupo ng mga sesyon na mga varyabol patungo sa aplikason. Sa pamamagitan ng pagset sa mga varyabol sa `bag`, ito ay awtomatikong natatago sa sesyon:

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

Tagakontrol, mga bahagi at mga klase na lumalawig `Phalcon\Di\Injectable` na pwedng magturok ng isang `Phalcon\Session\Bag`. Ang klaseng ito na ngahihiwalay sa mga varyabol sa bawat klase. Salamat dito na pwede mong ulit-ulitin ang data sa pagitan ng mga hiling sa bawat klase sa malayang paraan.

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

Sa isang bahagi:

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

Ang data na nadagdag sa sesyon (`$this->session`) ay magagamit na sa boung aplikasyon, habang ulit-ulitin ang (`$this->persistent`) na pwede lang mabuksan sa hangganan ng kasalukuyang klase.

<a name='custom-adapters'></a>

## Implementing your own adapters

Ang `Phalcon\Session\AdapterInterface` interface na dapat na maipatupad upang makagawa ng sariling mga adaptor ng sesyon o palawigin ang mga umiiral na.

Mayroong higit pa na mga adaptor na magagamit para sa bahaging ito sa[Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter)