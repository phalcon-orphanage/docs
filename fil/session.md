<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Storing data in the Session</a> 
      <ul>
        <li>
          <a href="#start">Starting the Session</a>
          <ul>
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

* You can easily isolate session data across applications on the same domain
* Intercept where session data is set/get in your application
* Change the session adapter according to the application needs

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

Mula sa isang kontroler, isang pananaw o anumang iba pang komponent na pinapaliwig sa `Phalcon\Di\Injectable` maaari mong ma-akses ang serbisyo ng sesyon at mag-imbak ng mga aytem at mabawi ang mga ito sa sumusunod na paraan:

```php
<?php

gamitin ang Phalcon\Mvc\Controller;

ang klaseng UserController ay pinapalawak ng Controller
{
    public function indexAction()
    {
        // Magtakda ng isang sesyon na variable
        $this->session->set('user-name', 'Michael');
    }

    public function welcomeAction()
    {
        // Suriin kung ang variable ay naka-define
        if ($this->session->has('user-name')) {
            // I-retrieve ang halaga nito
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## Removing/Destroying Sessions

Ito ay posible rin na tanggalin ang mga tukoy na variable o sirain ang buong sesyon:

```php
<?php

gamitin ang Phalcon\Mvc\Controller;

ang klaseng UserController ay pinapalawak ng Controller
{
    public function removeAction()
    {
        // Tanggalin ang isang sesyon na variable
        $this->session->remove('user-name');
    }

    public function logoutAction()
    {
        // Sirain ang buong sesyon
        $this->session->destroy();
    }
}
```

<a name='data-isolation'></a>

## Isolating Session Data between Applications

Paminsan-minsan ang user ay maaaring gumamit ng dalawang beses ng parehong aplikasyon, sa parehong serber, sa parehong sesyon. Sigurado, kung gagamit tayo ng mga variable sa sesyon, gusto namin na ang bawat aplikasyon ay may hiwalay na datos ng sesyon (kahit na pareho ang code at parehong mga pangalan ng variable). Para masagot ito, maaari mong dagdagan ng prefix para sa bawat variable ng sesyon na nilikha sa isang tiyak na aplikasyon:

```php
<?php

gamitin ang Phalcon\Session\Adapter\Files bilang Session;

// Paghihiwalay ng datos ng sesyon
$di->set(
    'session',
    function () {
        // Lahat ng mga variable na ginawa ay magiging prefix sa 'my-app-1'
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

Ang pagdagdag ng isang kakaibang ID ay hindi kinakailangan.

<a name='bags'></a>

## Session Bags

`Phalcon\Sesyon\Bag` ay isang komponent na tumutulong sa paghihiwalay ng datos ng sesyon sa `namespaces`. Pagtatrabaho sa pamamagitan ng ganitong paraan maaaring madaling mong malikha ang mga grupo ng mga variable ng sesyon sa aplikasyon. Sa pamamagitan ng pagtatakda lamang ng mga variable sa `bag`, ito'y awtomatikong naka-imbak sa sesyon:

```php
<?php

gamitin ang Phalcon\Session\Bag bilang SessionBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
```

<a name='data-persistency'></a>

## Persistent Data in Components

Kontroler, mga komponent at mga klase na pinapalawig sa `Phalcon\Di\Injectable` ay maaaring mag-injek ng `Phalcon\Sesyon\Bag`. Ang klase na ito ay pinaghihiwalay ang mga variable para sa bawat klase. Salamat dito maaari mong ipagpumilit ang datos sa pagitan ng mga kahilingan sa bawat klase sa isang malayang paraan.

```php
<?php

gamitin ang Phalcon\Mvc\Controller;

ang klaseng UserController ay pinapalawak ng Controller
{
    public function indexAction()
    {
        // Gumawa ng isang patuloy na variable na 'pangalan'
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

Sa isang komponent:

```php
<?php

gamitin ang Phalcon\Mvc\User\Component;

ang klaseng Security ay pinapalawak ng Component
{
    public function auth()
    {
        // Gumawa ng isang patuloy na variable na 'pangalan'
        $this->persistent->name = 'Laura';
    }

    public function getAuthName()
    {
        return $this->persistent->name;
    }
}
```

Ang idinagdag na datos sa sesyon (`$this->sesyon`) ay magagamit sa buong aplikasyon, habang ang paulit-ulit (`$this->persistent`) ay maaari lamang ma-akses sa saklaw ng kasalukuyang klase.

<a name='custom-adapters'></a>

## Implementing your own adapters

Ang `Phalcon\Sesyon\AdapterInterface` na interface ay dapat na ipatupad para makalikha ng iyong sariling mga adapter na sesyon o palawigin pa ang mga umiiral na.

May mas marami pang mga adapter na magagamit para sa mga komponent na ito sa [Phalcon Inkubador](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter)