<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Přehled</a> <ul>
        <li>
          <a href="#using">Použití controllerů / řadičů</a>
        </li>
        <li>
          <a href="#dispatch-loop">Dispatch Loop</a>
        </li>
        <li>
          <a href="#initializing">Inicializace controllerů</a>
        </li>
        <li>
          <a href="#injecting-services">Aplikace služeb</a>
        </li>
        <li>
          <a href="#request-response">Požadavek a odpověď</a>
        </li>
        <li>
          <a href="#session-data">Relační data (session)</a>
        </li>
        <li>
          <a href="#services">Používání služeb jako controllerů</a>
        </li>
        <li>
          <a href="#events">Události v controllerech</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Overview

<a name='using'></a>

## Using Controllers

Akce jsou metody v controllerech, které zpracovávají požadavky. Ve výchozím nastavení jsou všechny veřejné metody mapované jako akce na controllerech a přístupné pomocí URL adresy. Akce jsou zodpovědné za interpretaci požadavku a vytvoření odpovědi. Odpovědi jsou obvykle ve formě vykreslených šablon, ale existují i jiné způsoby, jak vytvořit odpovědi.

Například při přístupu k URL, jako je: `http://localhost/blog/posts/show/2015/the-post-title` Phalcon ve výchozím nastavení rozloží každou část takto:

| Description         | Slug           |
| ------------------- | -------------- |
| **Phalcon adresář** | blog           |
| **Controller**      | posts          |
| **Akce**            | show           |
| **Parametr**        | 2015           |
| **Parameter**       | the-post-title |

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

Další parametry URI jsou definovány jako parametry akce, které mohou být snadno přístupné pomocí lokální proměnné. Controller může libovolně rozšířit třídu `Phalcon\Mvc\Controller`. Tímto způsobem může mít Controller snadný přístup k aplikačním službám.

Parametry bez výchozí hodnoty jsou zpracovány podle potřeby. Nastavení hodnot pro parametry se provádí obvykle v PHP:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year = 2015, $postTitle = 'some default title')
    {

    }
}
```

Parametry jsou přiřazeny ve stejném pořadí, jak byly předány v požadavku. Můžete získat libovolný parametr z názvu následujícím způsobem:

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

"dispatch loop" bude spuštěn v rámci dispečeru pokud nejsou provedeny žádné další akce. V předchozím příkladu byla provedena pouze jedna akce. V následujícím příkladu můžeme vidět, jak metoda `forward()` může poskytnout "flow of operation" v "dispatch loop", a to předáním jinému controlleru / akci.

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
            "You don't have permission to access this area"
        );

        // Forward flow to another action
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

There is no limit on the `forwards` you can have in your application, so long as they do not result in circular references, at which point your application will halt. Pokud neexistují žádné další akce, které by měly být odeslány, dispečer automaticky vyvolá vrstvu zobrazení MVC, která je spravována například: `Phalcon\Mvc\View`.

<a name='initializing'></a>

## Initializing Controllers

`Phalcon\Mvc\Controller` nabízí metodu `initialize()`, která bude vykonána jako první, před provedením jakékoli akce v controlleru. Použití metody `__construct()` se nedoporučuje.

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

Pokud chcete provést některé inicializace logiky hned, jak je vytvořen objekt controlleru můžete implementovat metodu `onConstruct()`:

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

Pokud controller rozšiřuje třídu `Phalcon\Mvc\Controller` tak máme snadný přístup do kontejneru služeb v aplikaci. Například, pokud jsme zaregistrovali službu jako následující příklad:

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

Poté můžeme přístupovat ke službě několika způsoby:

```php
<?php

use Phalcon\Mvc\Controller;

class FilesController extends Controller
{
    public function saveAction()
    {
        // Injecting the service by just accessing the property with the same name
        $this->storage->save('/some/file');

        // Accessing the service from the DI
        $this->di->get('storage')->save('/some/file');

        // Another way to access the service using the magic getter
        $this->di->getStorage()->save('/some/file');

        // Another way to access the service using the magic getter
        $this->getDi()->getStorage()->save('/some/file');

        // Using the array-syntax
        $this->di['storage']->save('/some/file');
    }
}
```

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/[[language]]/[[version]]/di) in the framework.

<a name='request-response'></a>

## Request and Response

Za předpokladu, že framework poskytuje sadu předem registrovaných služeb. Vysvětlíme si, jak pracovat s prostředím HTTP. The `request` service contains an instance of `Phalcon\Http\Request` and the `response` contains a `Phalcon\Http\Response` representing what is going to be sent back to the client.

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
        // Check if request has made with POST
        if ($this->request->isPost()) {
            // Access POST data
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

Objekt odpovědi se nepoužívá obvykle přímo, ale je proveden před spuštění akce, někdy - jako v případě `afterDispatch` - to může být užitečné pro přímý přístup k odpovědi:

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
        // Send a HTTP 404 response header
        $this->response->setStatusCode(404, 'Not Found');
    }
}
```

Learn more about the HTTP environment in their dedicated articles [request](/[[language]]/[[version]]/request) and [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Session Data

Relace nám pomáhají udržovat data mezi požadavky. Můžete přistupovat k objektu `Phalcon\Session\Bag` z libovolnému controlleru za účelem zapouzdření dat:

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

Služby mohou jednat jako controllery, třídy controlleru jsou vždy požadovány z kontejneru služeb. Každá jiná třida registrovaná se správným názvem může jednoduše nahradit controller:

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

Controllery automaticky působí jako listenery pro události z [dispečeru](/en/[[versopm]]/dispatcher), implementační metody s těmito názvy eventů umožňují implementovat hooky před nebo po provedení akcí:

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