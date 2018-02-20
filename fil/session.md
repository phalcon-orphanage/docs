<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang-ideya">Pag-iimbak ng datos sa Sesyon</a> <ul>
        <li>
          <a href="#magsimula">Pagsisimula ng Sesyon</a>
        </li>
        <li>
          <a href="#imbak">Pag-iimbak/Pagbawi ng datos sa Sesyon</a>
        </li>
        <li>
          <a href="#tanggalin-sirain">Pagtatanggal/Pagsira ng mga Sesyon</a>
        </li>
        <li>
          <a href="#datos-paghihiwalay">Paghihiwalay ng Sesyon na Datos sa pagitan ng mga Aplikasyon</a>
        </li>
        <li>
          <a href="#mgabag">Mga Bag ng Sesyon</a>
        </li>
        <li>
          <a href="#datos-paulit-ulit">Paulit-ulit na Datos sa mga Komponent</a>
        </li>
        <li>
          <a href="#kustom-adapter">Pagpapatupad ng iyong sariling mga adapter</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Pag-iimbak ng datos sa Sesyon

Ang sesyon na komponent ay nagbibigay ng object-oriented na mga wrapper para i-akses ang sesyon na datos.

Mga dahilan para gamitin ang komponent na ito sa halip ng mga raw-sesyon:

- Madali mong ihiwalay ang datos ng sesyon sa kabuuan ng mga aplikasyon sa parehong domain
- Humarang kung saan ang sesyon na datos ay natakda/nakuha sa iyong aplikasyon
- Baguhin ang sesyon na adapter ayon sa kinakailangan ng aplikasyon

<a name='start'></a>

## Pagsisimula ng Sesyon

Ilang mga aplikasyon ay masinsinan sa sesyon, halos anumang aksyon na gumaganap ay nangangailangan ng akses sa sesyon na datos. Mayroong iba na nag-a-akses ng sesyon na datos nang kaswal. Salamat sa serbisyo na container, maaari nating siguraduhin na ang sesyon ay naka-akses lamang kung ito ay malinaw na kinakailangan:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Simulan ang sesyon sa unang pagkakataon kapag ang ilang komponent ay humiling sa sesyon na serbisyo
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

## Pag-iimbak/Pagbawi ng datos sa Sesyon

Mula sa isang controller, isang view o anumang iba pang komponent na umaabot sa `Phalcon\Di\Injectable` maaari mong ma-akses ang serbisyo ng sesyon at mga item sa store at mabawi ang mga ito sa sumusunod na paraan:

```php
<?php

gamitin ang Phalcon\Mvc\Kontroler;

ang klaseng UserController ay pinapalawak ng Kontroler
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
            // Retrieve its value
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## Pagtatanggal/Pagsira ng mga Sesyon

Posible rin na tanggalin ang mga tukoy na variable o sirain ang buong sesyon:

```php
<?php

gamitin ang Phalcon\Mvc\Kontroler;

ang klaseng UserController ay pinapalawak ng Kontroler
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

## Paghihiwalay ng Sesyon na Datos sa pagitan ng mga Aplikasyon

Minsan ang user ay maaaring gumamit ng parehong aplikasyon ng dalawang beses, sa parehong serber, sa parehong sesyon. Sigurado, kung gagamitin natin ang mga variable sa sesyon, nais namin na ang bawat aplikasyion ay may hiwalay na datos ng sesyon (kahit na ang parehong code at parehong mga pangalan ng variable). Para malutas ito, maaari kang magdagdag ng prefix para sa bawat sesyon na variable na nilikha sa isang tiyak na aplikasyon:

```php
<?php

gamitin ang Phalcon\Sesyon\Adapter\MgaFile bilang Sesyon;

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

Ang pagdagdag ng isang natatanging ID ay hindi kinakailangan.

<a name='bags'></a>

## Mga Bag ng Sesyon

`Phalcon\Sesyon\Bag` ay isang bahagi na tumutulong sa paghihiwalay ng datos ng sesyon sa `namespaces`. Pagtatrabaho sa pamamagitan ng ganitong paraan maaari mong madaling lumikha ng mga grupo ng mga variable ng sesyon sa aplikasyon. Sa pamamagitan lamang ng pagtatakda ng mga variable sa `bag`, ito'y awtomatikong naka-imbak sa sesyon:

```php
<?php

gamitin ang Phalcon\Sesyon\Bag bilang SesyonBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
```

<a name='data-persistency'></a>

## Paulit-ulit na Datos sa mga Komponent

Kontroler, mga komponent at mga klase na umaabot sa `Phalcon\Di\Injectable` ay maaaring mag-injek ng `Phalcon\Sesyon\Bag`. Ang klase na ito ay hinhiwalay ang mga variable para sa bawat klase. Salamat sa mga ito maaari mong ipagpumilit ang datos sa pagitan ng mga kahilingan sa bawat klase sa isang malayang paraan.

```php
<?php

gamitin ang Phalcon\Mvc\Kontroler;

ang klaseng UserController ay pinapalawak ng Kontroler
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

gamitin ang Phalcon\Mvc\User\Komponent;

ang klaseng Security ay pinapalawak ng Komponent
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

Ang datos na idinagdag sa sesyon (`$this->sesyon`) ay magagamit sa buong aplikasyon, habang ang paulit-ulit (`$this->persistent`) ay maaari lamang ma-akses sa saklaw ng kasalukuyang klase.

<a name='custom-adapters'></a>

## Pagpapatupad ng iyong sariling mga adapter

Ang `Phalcon\Sesyon\AdapterInterface` na interface ay dapat na ipatupad para maglikha ng iyong sariling mga adapter na sesyon o palawigin ang mga umiiral na.

Mayroong higit pang mga adapter na magagamit para sa mga komponent na ito sa [Phalcon Inkubador](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter)