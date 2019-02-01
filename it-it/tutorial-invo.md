---
layout: article
language: 'it-it'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Tutorial: INVO

In this second tutorial, we'll explain a more complete application in order to gain a deeper understanding of developing with Phalcon. INVO is one of the sample applications we have created. INVO is a small website that allows users to generate invoices and do other tasks such as manage customers and products. You can clone its code from [GitHub](https://github.com/phalcon/invo).

INVO was made with the client-side framework [Bootstrap](https://getbootstrap.com/). Although the application does not generate actual invoices, it still serves as an example showing how the framework works.

<a name='structure'></a>

## Struttura del progetto

Una volta che cloni il progetto nella tua directory principale, vedrai la seguente struttura:

```bash
invo/
    app/
        config/
        controllers/
        forms/
        library/
        logs/
        models/
        plugins/
        views/
    cache/
        volt/
    docs/
    public/
        css/
        fonts/
        js/
    schemas/
```

As you know, Phalcon does not impose a particular file structure for application development. This project has a simple MVC structure and a public document root.

Once you open the application in your browser `https://localhost/invo` you'll see something like this:

![](/assets/images/content/tutorial-invo-1.png)

The application is divided into two parts: a frontend and a backend. The frontend is a public area where visitors can receive information about INVO and request contact information. The backend is an administrative area where registered users can manage their products and customers.

<a name='routing'></a>

## Inoltro (Routing)

INVO uses the standard route that is built-in with the [Router](/4.0/en/routing) component. These routes match the following pattern: `/:controller/:action/:params`. This means that the first part of a URI is the controller, the second the controller action and the rest are the parameters.

The following route `/session/register` executes the controller `SessionController` and its action `registerAction`.

<a name='configuration'></a>

## Configuration

INVO has a configuration file that sets general parameters in the application. This file is located at `app/config/config.ini` and is loaded in the very first lines of the application bootstrap (`public/index.php`):

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

// ...

// Read the configuration
$config = new ConfigIni(
    APP_PATH . 'app/config/config.ini'
);

```

[Phalcon Config](/4.0/en/config) ([Phalcon\Config](api/Phalcon_Config)) allows us to manipulate the file in an object-oriented way. In this example, we're using an ini file for configuration but Phalcon has [adapters](/4.0/en/config) for other file types as well. The configuration file contains the following settings:

```ini
[database]
host     = localhost
username = root
password = secret
name     = invo

[application]
controllersDir = app/controllers/
modelsDir      = app/models/
viewsDir       = app/views/
pluginsDir     = app/plugins/
formsDir       = app/forms/
libraryDir     = app/library/
baseUri        = /invo/
```

Phalcon doesn't have any pre-defined settings convention. Sections help us to organize the options as appropriate. In this file there are two sections to be used later: `application` and `database`.

<a name='autoloaders'></a>

## Caricatori automatici (Autoloaders)

The second part that appears in the bootstrap file (`public/index.php`) is the autoloader:

```php
<?php

/**
 * Auto-loader configuration
 */
require APP_PATH . 'app/config/loader.php';
```

The autoloader registers a set of directories in which the application will look for the classes that it will eventually need.

```php
<?php

$loader = new Phalcon\Loader();

// Noi registriamo un insieme di directories prese dal file di configurazione
$loader->registerDirs(
    [
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->pluginsDir,
        APP_PATH . $config->application->libraryDir,
        APP_PATH . $config->application->modelsDir,
        APP_PATH . $config->application->formsDir,
    ]
);

$loader->register();
```

Note that the above code has registered the directories that were defined in the configuration file. The only directory that is not registered is the viewsDir because it contains HTML + PHP files but no classes. Also, note that we use a constant called APP_PATH. This constant is defined in the bootstrap (`public/index.php`) to allow us to have a reference to the root of our project:

```php
<?php

// ...

define(
    'APP_PATH',
    realpath('..') . '/'
);
```

<a name='services'></a>

## Registrazione dei servizi

Another file that is required in the bootstrap is (`app/config/services.php`). This file allows us to organize the services that INVO uses.

```php
<?php

/**
 * Load application services
 */
require APP_PATH . 'app/config/services.php';
```

Service registration is achieved with closures for lazy loading the required components:

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

/**
 * Il componente URL è usato per generare tutti i tipi di URLs dell'applicazione
 */
$di->set(
    'url',
    function () use ($config) {
        $url = new UrlProvider();

        $url->setBaseUri(
            $config->application->baseUri
        );

        return $url;
    }
);
```

We will discuss this file in depth later.

<a name='handling-requests'></a>

## Gestione della richiesta

If we skip to the end of the file (`public/index.php`), the request is finally handled by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) which initializes and executes all that is necessary to make the application run:

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);

$response = $application->handle();

$response->send();
```

<a name='dependency-injection'></a>

## Dependency Injection

In the first line of the code block above, the Application class constructor is receiving the variable `$di` as an argument. What is the purpose of that variable? Phalcon is a highly decoupled framework so we need a component that acts as glue to make everything work together. That component is [Phalcon\Di](api/Phalcon_Di). It's a service container that also performs dependency injection and service location, instantiating all components as they are needed by the application.

There are many ways of registering services in the container. In INVO, most services have been registered using anonymous functions/closures. Thanks to this, the objects are instantiated in a lazy way, reducing the resources needed by the application.

For instance, in the following excerpt the session service is registered. The anonymous function will only be called when the application requires access to the session data:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// ...

// Avvia la sessione la prima volta che un componente fa richiesta del servizio sessione 
$di->set(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

Here, we have the freedom to change the adapter, perform additional initialization and much more. Note that the service was registered using the name `session`. This is a convention that will allow the framework to identify the active service in the services container.

A request can use many services and registering each service individually can be a cumbersome task. For that reason, the framework provides a variant of [Phalcon\Di](api/Phalcon_Di) called [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) whose task is to register all services providing a full-stack framework.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// The FactoryDefault Dependency Injector automatically registers the
// right services providing a full-stack framework
$di = new FactoryDefault();
```

It registers the majority of services with components provided by the framework as standard. If we need to override the definition of some service we could just set it again as we did above with `session` or `url`. This is the reason for the existence of the variable `$di`.

<a name='log-in'></a>

## Accesso all'applicazione

A `log in` facility will allow us to work on backend controllers. The separation between backend controllers and frontend ones is only logical. All controllers are located in the same directory (`app/controllers/`).

To enter the system, users must have a valid username and password. Users are stored in the table `users` in the database `invo`.

Before we can start a session, we need to configure the connection to the database in the application. A service called `db` is set up in the service container with the connection information. As with the autoloader, we are again taking parameters from the configuration file in order to configure a service:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// ...

// La connessione al database è creata sulla base dei parametri definiti nel file di configurazione
$di->set(
    'db',
    function () use ($config) {
        return new DbAdapter(
            [
                'host'     => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname'   => $config->database->name,
            ]
        );
    }
);
```

Here, we return an instance of the MySQL connection adapter. If needed, you could do extra actions such as adding a logger, a profiler or change the adapter, setting it up as you want.

The following simple form (`app/views/session/index.volt`) requests the login information. We've removed some HTML code to make the example more concise:

```twig
{% raw %}
{{ form('session/start') }}
    <fieldset>
        <div>
            <label for='email'>
                Username/Email
            </label>

            <div>
                {{ text_field('email') }}
            </div>
        </div>

        <div>
            <label for='password'>
                Password
            </label>

            <div>
                {{ password_field('password') }}
            </div>
        </div>

        <div>
            {{ submit_button('Login') }}
        </div>
    </fieldset>
{{ endForm() }}
{% endraw %}
```

Instead of using raw PHP as the previous tutorial, we started to use [Volt](/4.0/en/volt). This is a built-in template engine inspired by Jinja_ providing a simpler and friendly syntax to create templates. It will not take too long before you become familiar with Volt.

The `SessionController::startAction` function (`app/controllers/SessionController.php`) has the task of validating the data entered in the form including checking for a valid user in the database:

```php
<?php

class SessionController extends ControllerBase
{
    // ...

    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            [
                'id'   => $user->id,
                'name' => $user->name,
            ]
        );
    }

    /**
     * Questa azione autentica e "logga" un utente nell'applicazione
     */
    public function startAction()
    {
        if ($this->request->isPost()) {
            // Recupera i dati dell'utente
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Trova l'utente nel database
            $user = Users::findFirst(
                [
                    "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                    'bind' => [
                        'email'    => $email,
                        'password' => sha1($password),
                    ]
                ]
            );

            if ($user !== false) {
                $this->_registerSession($user);

                $this->flash->success(
                    'Benvenuto ' . $user->name
                );

                // Inoltra al controllore 'invoices' se è un utente valido
                return $this->dispatcher->forward(
                    [
                        'controller' => 'invoices',
                        'action'     => 'index',
                    ]
                );
            }

            $this->flash->error(
                'Email/password errati'
            );
        }

        // Inoltro nuovamente al login form
        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }
}
```

For the sake of simplicity, we have used [sha1](https://php.net/manual/en/function.sha1.php) to store the password hashes in the database, however, this algorithm is not recommended in real applications, use [bcrypt](/4.0/en/security) instead.

Note that multiple public attributes are accessed in the controller like: `$this->flash`, `$this->request` or `$this->session`. These are services defined in the services container from earlier (`app/config/services.php`). When they're accessed the first time, they are injected as part of the controller. These services are `shared`, which means that we are always accessing the same instance regardless of the place where we invoke them. For instance, here we invoke the `session` service and then we store the user identity in the variable `auth`:

```php
<?php

$this->session->set(
    'auth',
    [
        'id'   => $user->id,
        'name' => $user->name,
    ]
);
```

Another important aspect of this section is how the user is validated as a valid one, first we validate whether the request has been made using method `POST`:

```php
<?php

if ($this->request->isPost()) {
    // ...
}
```

Then, we receive the parameters from the form:

```php
<?php

$email    = $this->request->getPost('email');
$password = $this->request->getPost('password');
```

Now, we have to check if there is one user with the same username or email and password:

```php
<?php

$user = Users::findFirst(
    [
        "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
        'bind' => [
            'email'    => $email,
            'password' => sha1($password),
        ]
    ]
);
```

Note, the use of 'bound parameters', placeholders `:email:` and `:password:` are placed where values should be, then the values are 'bound' using the parameter `bind`. This safely replaces the values for those columns without having the risk of a SQL injection.

If the user is valid we register it in session and forwards him/her to the dashboard:

```php
<?php

if ($user !== false) {
    $this->_registerSession($user);

    $this->flash->success(
        'Benvenuto ' . $user->name
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'invoices',
            'action'     => 'index',
        ]
    );
}
```

If the user does not exist we forward the user back again to action where the form is displayed:

```php
<?php

return $this->dispatcher->forward(
    [
        'controller' => 'session',
        'action'     => 'index',
    ]
);
```

<a name='securing-backend'></a>

## Protezione del back-end

The backend is a private area where only registered users have access. Therefore, it is necessary to check that only registered users have access to these controllers. If you aren't logged into the application and you try to access, for example, the products controller (which is private) you will see a screen like this:

![](/assets/images/content/tutorial-invo-2.png)

Every time someone attempts to access any controller/action, the application verifies that the current role (in session) has access to it, otherwise it displays a message like the above and forwards the flow to the home page.

Now let's find out how the application accomplishes this. The first thing to know is that there is a component called [Dispatcher](/4.0/en/dispatcher). It is informed about the route found by the [Routing](/4.0/en/routing) component. Then, it is responsible for loading the appropriate controller and execute the corresponding action method.

Normally, the framework creates the Dispatcher automatically. In our case, we want to perform a verification before executing the required action, checking if the user has access to it or not. To achieve this, we have replaced the component by creating a function in the bootstrap:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...

/**
 * MVC dispatcher
 */
$di->set(
    'dispatcher',
    function () {
        // ...

        $dispatcher = new Dispatcher();

        return $dispatcher;
    }
);
```

We now have total control over the Dispatcher used in the application. Many components in the framework trigger events that allow us to modify their internal flow of operation. As the Dependency Injector component acts as glue for components, a new component called [EventsManager](/4.0/en/events) allows us to intercept the events produced by a component, routing the events to listeners.

<a name='events-manager'></a>

### Gestione degli Eventi

The [EventsManager](/4.0/en/events) allows us to attach listeners to a particular type of event. The type that interests us now is 'dispatch'. The following code filters all events produced by the Dispatcher:

```php
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Crea una gestione eventi
        $eventsManager = new EventsManager();

        // Ascolta per gli eventi prodotti dal dispatcher usando il SecurityPlugin
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        // Gestione delle eccezioni e l'eccezione not-found usando NotFoundPlugin
        $eventsManager->attach(
            'dispatch:beforeException',
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();

        // Assegna il gestore eventi al dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

When an event called `beforeExecuteRoute` is triggered the following plugin will be notified:

```php
<?php

/**
 * Controlla se l'utente è autorizzato ad accerete a certe azioni usando SecurityPlugin
 */
$eventsManager->attach(
    'dispatch:beforeExecuteRoute',
    new SecurityPlugin()
);
```

When a `beforeException` is triggered then other plugin is notified:

```php
<?php

/**
 * Gestione delle eccezioni e l'eccezione not-found usando NotFoundPlugin
 */
$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

SecurityPlugin is a class located at (`app/plugins/SecurityPlugin.php`). This class implements the method `beforeExecuteRoute`. This is the same name as one of the events produced in the Dispatcher:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    // ...

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // ...
    }
}
```

The hook events always receive a first parameter that contains contextual information of the event produced (`$event`) and a second one that is the object that produced the event itself (`$dispatcher`). It is not mandatory that plugins extend the class [Phalcon\Mvc\User\Plugin](api/Phalcon_Mvc_User_Plugin), but by doing this they gain easier access to the services available in the application.

Now, we're verifying the role in the current session, checking if the user has access using the ACL list. If the user does not have access we redirect to the home screen as explained before:

```php
<?php

use Phalcon\Acl;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    // ...

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Controllo se la variabile 'auth' esiste nella sessione per definire il ruolo attivo
        $auth = $this->session->get('auth');

        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // Prendo il controllore/azione attivo dal dispatcher
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // Ottengo la lista ACL
        $acl = $this->getAcl();

        // Controllo se il ruolo ha accesso al controllore (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            // Se non ha l'accesso lo inoltro al controllore index
            $this->flash->error(
                "Tu non hai accetto a questo modulo"
            );

            $dispatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            // Restituisco 'false' per dire al dispatcher di interrompere l'operazione corrente
            return false;
        }
    }
}
```

<a name='acl'></a>

### Ottenere la lista ACL

In the above example we have obtained the ACL using the method `$this->getAcl()`. This method is also implemented in the Plugin. Now we are going to explain step-by-step how we built the access control list (ACL):

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;

// Crea l'ACL
$acl = new AclList();

// L'azione predefinita è NEGARE l'accesso
$acl->setDefaultAction(
    Acl::DENY
);

// Registriamo 2 ruoli, Users sono gli utenti registrati
// e guests sono gli utenti senza una identità definita
$roles = [
    'users'  => new Role('Users'),
    'guests' => new Role('Guests'),
];

foreach ($roles as $role) {
    $acl->addRole($role);
}
```

Now, we define the resources for each area respectively. Controller names are resources and their actions are accesses for the resources:

```php
<?php

use Phalcon\Acl\Resource;

// ...

// Risorse area privata (backend)
$privateResources = [
    'companies'    => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
    'products'     => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
    'producttypes' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
    'invoices'     => ['index', 'profile'],
];

foreach ($privateResources as $resourceName => $actions) {
    $acl->addResource(
        new Resource($resourceName),
        $actions
    );
}



// Risorse area publica (frontend)
$publicResources = [
    'index'    => ['index'],
    'about'    => ['index'],
    'register' => ['index'],
    'errors'   => ['show404', 'show500'],
    'session'  => ['index', 'register', 'start', 'end'],
    'contact'  => ['index', 'send'],
];

foreach ($publicResources as $resourceName => $actions) {
    $acl->addResource(
        new Resource($resourceName),
        $actions
    );
}
```

The ACL now knows about the existing controllers and their related actions. Role `Users` has access to all the resources of both frontend and backend. The role `Guests` only has access to the public area:

```php
<?php

// Autorizza l'accesso alle aree pubbliche per entrambi gli utenti: users e guests
foreach ($roles as $role) {
    foreach ($publicResources as $resource => $actions) {
        $acl->allow(
            $role->getName(),
            $resource,
            '*'
        );
    }
}

// Autorizza l'accesso all'aree privata solo al ruolo users
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow(
            'Users',
            $resource,
            $action
        );
    }
}
```

<a name='working-with-crud'></a>

## Lavorando con il CRUD

Backends usually provide forms to allow users to manipulate data. Continuing the explanation of INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you using forms, validations, paginators and more.

Most options that manipulate data in INVO (companies, products and types of products) were developed using a basic and common [CRUD](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete) (Create, Read, Update and Delete). Each CRUD contains the following files:

```bash
invo/
    app/
        controllers/
            ProductsController.php
        models/
            Products.php
        forms/
            ProductsForm.php
        views/
            products/
                edit.volt
                index.volt
                new.volt
                search.volt
```

Each controller has the following actions:

```php
<?php

class ProductsController extends ControllerBase
{
    /**
     * Avvia l'azione, che mostra la vista 'search'
     */
    public function indexAction()
    {
        // ...
    }

    /**
     * Esegue la 'ricerca' 'search' basata sui criteri inviati da 'index'
     * Restituisce il paginatore per i risultati
     */
    public function searchAction()
    {
        // ...
    }

    /**
     * Mostra la vista 'new' per creare un nuovo prodotto
     */
    public function newAction()
    {
        // ...
    }

    /**
     * Mostra la vista 'edit' per modificare un prodotto esistente
     */
    public function editAction()
    {
        // ...
    }

    /**
     * Crea un prodotto in base ai dati inseriti nell'azione 'new' 
     */
    public function createAction()
    {
        // ...
    }

    /**
     * Aggiorna un prodotto in base ai dati inseriti nell'azione 'edit' 
     */
    public function saveAction()
    {
        // ...
    }

    /**
     * Cancella un prodotto esistente
     */
    public function deleteAction($id)
    {
        // ...
    }
}
```

<a name='search-form'></a>

## Il modulo di ricerca

Every CRUD starts with a search form. This form shows each field that the table has (products), allowing the user to create a search criteria for any field. The `products` table has a relationship with the table `products_types`. In this case, we previously queried the records in this table in order to facilitate the search by that field:

```php
<?php

/**
 * avvia l'azione, che mostra la vista 'search'
 */
public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```

An instance of the `ProductsForm` form (`app/forms/ProductsForm.php`) is passed to the view. This form defines the fields that are visible to the user:

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class ProductsForm extends Form
{
    /**
     * Inizializza il modulo (form) prodotti
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text('id');
            $element->setLabel('Id');
            $this->add($element);
        } else {
            $this->add(new Hidden('id'));
        }

        $name = new Text('name');
        $name->setLabel('Name');
        $name->setFilters(
            [
                'striptags',
                'string',
            ]
        );
        $name->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'Il nome è richiesto',
                    ]
                )
            ]
        );
        $this->add($name);

        $type = new Select(
            'profilesId',
            ProductTypes::find(),
            [
                'using'      => [
                    'id',
                    'name',
                ],
                'useEmpty'   => true,
                'emptyText'  => '...',
                'emptyValue' => '',
            ]
        );

        $this->add($type);

        $price = new Text('price');
        $price->setLabel('Price');
        $price->setFilters(
            [
                'float',
            ]
        );
        $price->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'Il prezzo è richiesto',
                    ]
                ),
                new Numericality(
                    [
                        'message' => 'Il prezzo è richiesto',
                    ]
                ),
            ]
        );
        $this->add($price);
    }
}
```

The form is declared using an object-oriented scheme based on the elements provided by the [forms](/4.0/en/forms) component. Every element follows almost the same structure:

```php
<?php

// Crea l'elemento
$name = new Text('name');

// Imposta l'etichetta
$name->setLabel('Name');

// Prima della validazione l'elemento applica questi filtri
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// Applica questi validatori 
$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'Il nome è richiesto',
            ]
        )
    ]
);

// Aggiunge l'elemento al modulo (form)
$this->add($name);
```

Other elements are also used in this form:

```php
<?php

// Aggiunge un campo nascosto al modulo (form)
$this->add(
    new Hidden('id')
);

// ...

$productTypes = ProductTypes::find();

// Aggiunge una lista Select HTML al modulo (form)
// e lo riempie con i dati da 'product_types'
$type = new Select(
    'profilesId',
    $productTypes,
    [
        'using'      => [
            'id',
            'name',
        ],
        'useEmpty'   => true,
        'emptyText'  => '...',
        'emptyValue' => '',
    ]
);
```

Note that `ProductTypes::find()` contains the data necessary to fill the SELECT tag using `Phalcon\Tag::select()`. Once the form is passed to the view, it can be rendered and presented to the user:

```twig
{% raw %}
{{ form('products/search') }}

    <h2>
        Search products
    </h2>

    <fieldset>

        {% for element in form %}
            <div class='control-group'>
                {{ element.label(['class': 'control-label']) }}

                <div class='controls'>
                    {{ element }}
                </div>
            </div>
        {% endfor %}



        <div class='control-group'>
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </fieldset>

{{ endForm() }}
{% endraw %}
```

This produces the following HTML:

```html
<form action='/invo/products/search' method='post'>

    <h2>
        Ricerca prodotti
    </h2>

    <fieldset>

        <div class='control-group'>
            <label for='id' class='control-label'>Id</label>

            <div class='controls'>
                <input type='text' id='id' name='id' />
            </div>
        </div>

        <div class='control-group'>
            <label for='name' class='control-label'>Nome</label>

            <div class='controls'>
                <input type='text' id='name' name='name' />
            </div>
        </div>

        <div class='control-group'>
            <label for='profilesId' class='control-label'>profilesId</label>

            <div class='controls'>
                <select id='profilesId' name='profilesId'>
                    <option value=''>...</option>
                    <option value='1'>Vegetables</option>
                    <option value='2'>Fruits</option>
                </select>
            </div>
        </div>

        <div class='control-group'>
            <label for='price' class='control-label'>Prezzo</label>

            <div class='controls'>
                <input type='text' id='price' name='price' />
            </div>
        </div>

        <div class='control-group'>
            <input type='submit' value='Search' class='btn btn-primary' />
        </div>

    </fieldset>

</form>
```

When the form is submitted, the `search` action is executed in the controller performing the search based on the data entered by the user.

<a name='performing-searches'></a>

## Eseguire una ricerca

The `search` action has two behaviors. When accessed via POST, it performs a search based on the data sent from the form but when accessed via GET it moves the current page in the paginator. To differentiate HTTP methods, we check it using the [Request](/4.0/en/request) component:

```php
<?php

/**
 * Esegue la ricerca 'search' in base ai criteri inviati dal 'index'
 * Restituisce un paginatore per i risultati
 */
public function searchAction()
{
    if ($this->request->isPost()) {
        // Crea le condizioni della query
    } else {
        // Pagina usando le condizioni esistenti
    }

    // ...
}
```

With the help of [Phalcon\Mvc\Model\Criteria](api/Phalcon_Mvc_Model_Criteria), we can create the search conditions intelligently based on the data types and values sent from the form:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

This method verifies which values are different from '' (empty string) and null and takes them into account to create the search criteria:

* Se il tipo di dati del campo è testo o simili (char, varchar, text, ecc.) lui utilizza un operatore `like` di SQL per filtrare i risultati.
* Se il tipo di dati non è testo o simili, viene utilizzato l'operatore di `=`.

Additionally, `Criteria` ignores all the `$_POST` variables that do not match any field in the table. Values are automatically escaped using `bound parameters`.

Now, we store the produced parameters in the controller's session bag:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

A session bag, is a special attribute in a controller that persists between requests using the session service. When accessed, this attribute injects a [Phalcon\Session\Bag](api/Phalcon_Session_Bag) instance that is independent in each controller.

Then, based on the built params we perform the query:

```php
<?php

$products = Products::find($parameters);

if (count($products) === 0) {
    $this->flash->notice(
        'La ricerca non ha trovato alcun prodotto'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the search returned results, then we create a paginator to navigate easily through them:

```php
<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

// ...

$paginator = new Paginator(
    [
        'data'  => $products,   // Dati da paginare
        'limit' => 5,           // Righe per pagina
        'page'  => $numberPage, // Pagina attiva
    ]
);

// Get active page in the paginator
$page = $paginator->getPaginate();
```

Finally we pass the returned page to view:

```php
<?php

$this->view->page = $page;
```

In the view (`app/views/products/search.volt`), we traverse the results corresponding to the current page, showing every row in the current page to the user:

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Product Type</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
    {% endif %}

    <tr>
        <td>
            {{ product.id }}
        </td>

        <td>
            {{ product.getProductTypes().name }}
        </td>

        <td>
            {{ product.name }}
        </td>

        <td>
            {{ '%.2f'|format(product.price) }}
        </td>

        <td>
            {{ product.getActiveDetail() }}
        </td>

        <td width='7%'>
            {{ link_to('products/edit/' ~ product.id, 'Edit') }}
        </td>

        <td width='7%'>
            {{ link_to('products/delete/' ~ product.id, 'Delete') }}
        </td>
    </tr>

    {% if loop.last %}
            </tbody>
            <tbody>
                <tr>
                    <td colspan='7'>
                        <div>
                            {{ link_to('products/search', 'First') }}
                            {{ link_to('products/search?page=' ~ page.before, 'Previous') }}
                            {{ link_to('products/search?page=' ~ page.next, 'Next') }}
                            {{ link_to('products/search?page=' ~ page.last, 'Last') }}
                            <span class='help-inline'>{{ page.current }} of {{ page.total_pages }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    {% endif %}
{% else %}
    No products are recorded
{% endfor %}
{% endraw %}
```

There are many things in the above example that worth detailing. First of all, active items in the current page are traversed using a Volt's `for`. Volt provides a simpler syntax for a PHP `foreach`.

```twig
{% raw %}
{% for product in page.items %}
{% endraw %}
```

Which in PHP is the same as:

```php
<?php foreach ($page->items as $product) { ?>
```

The whole `for` block provides the following:

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        Executed before the first product in the loop
    {% endif %}

    Executed for every product of page.items

    {% if loop.last %}
        Executed after the last product is loop
    {% endif %}
{% else %}
    Executed if page.items does not have any products
{% endfor %}
{% endraw %}
```

Now you can go back to the view and find out what every block is doing. Every field in `product` is printed accordingly:

```twig
{% raw %}
<tr>
    <td>
        {{ product.id }}
    </td>

    <td>
        {{ product.productTypes.name }}
    </td>

    <td>
        {{ product.name }}
    </td>

    <td>
        {{ '%.2f'|format(product.price) }}
    </td>

    <td>
        {{ product.getActiveDetail() }}
    </td>

    <td width='7%'>
        {{ link_to('products/edit/' ~ product.id, 'Edit') }}
    </td>

    <td width='7%'>
        {{ link_to('products/delete/' ~ product.id, 'Delete') }}
    </td>
</tr>
{% endraw %}
```

As we seen before using `product.id` is the same as in PHP as doing: `$product->id`, we made the same with `product.name` and so on. Other fields are rendered differently, for instance, let's focus in `product.productTypes.name`. To understand this part, we have to check the Products model (`app/models/Products.php`):

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Products extends Model
{
    // ...

    /**
     * Inizializzatore Prodotti
     */
    public function initialize()
    {
        $this->belongsTo(
            'product_types_id',
            'ProductTypes',
            'id',
            [
                'reusable' => true,
            ]
        );
    }

    // ...
}
```

A model can have a method called `initialize()`, this method is called once per request and it serves the ORM to initialize a model. In this case, 'Products' is initialized by defining that this model has a one-to-many relationship to another model called 'ProductTypes'.

```php
<?php

$this->belongsTo(
    'product_types_id',
    'ProductTypes',
    'id',
    [
        'reusable' => true,
    ]
);
```

Which means, the local attribute `product_types_id` in `Products` has an one-to-many relation to the `ProductTypes` model in its attribute `id`. By defining this relationship we can access the name of the product type by using:

```twig
{% raw %}
<td>{{ product.productTypes.name }}</td>
{% endraw %}
```

The field `price` is printed by its formatted using a Volt filter:

```twig
{% raw %}
<td>{{ '%.2f'|format(product.price) }}</td>
{% endraw %}
```

In plain PHP, this would be:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

Printing whether the product is active or not uses a helper implemented in the model:

```php
{% raw %}
<td>{{ product.getActiveDetail() }}</td>
{% endraw %}
```

This method is defined in the model.

<a name='creating-updating-records'></a>

## Creazione e aggiornamento di record

Now let's see how the CRUD creates and updates records. From the `new` and `edit` views, the data entered by the user is sent to the `create` and `save` actions that perform actions of `creating` and `updating` products, respectively.

In the creation case, we recover the data submitted and assign them to a new `Products` instance:

```php
<?php

/**
 * Crea un prodotto basato sui dati inseriti dall'azione 'new' 
 */
public function createAction()
{
    if (!$this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $form = new ProductsForm();

    $product = new Products();

    $product->id               = $this->request->getPost('id', 'int');
    $product->product_types_id = $this->request->getPost('product_types_id', 'int');
    $product->name             = $this->request->getPost('name', 'striptags');
    $product->price            = $this->request->getPost('price', 'double');
    $product->active           = $this->request->getPost('active');

    // ...
}
```

Remember the filters we defined in the Products form? Data is filtered before being assigned to the object `$product`. This filtering is optional; the ORM also escapes the input data and performs additional casting according to the column types:

```php
<?php

// ...

$name = new Text('name');

$name->setLabel('Name');

// Filtra per Nome
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// Validatori per Nome
$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'Il nome è richiesto',
',
            ]
        )
    ]
);

$this->add($name);
```

When saving, we'll know whether the data conforms to the business rules and validations implemented in the form `ProductsForm` form (`app/forms/ProductsForm.php`):

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

// Valida l'input
$data = $this->request->getPost();

if (!$form->isValid($data, $product)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message);
    }

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'new',
        ]
    );
}
```

Finally, if the form does not return any validation message we can save the product instance:

```php
<?php

// ...

if ($product->save() === false) {
    $messages = $product->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message);
    }

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'new',
        ]
    );
}

$form->clear();

$this->flash->success(
    'Il prodotto è stato creato con successo'
);

return $this->dispatcher->forward(
    [
        'controller' => 'products',
        'action'     => 'index',
    ]
);
```

Now, in the case of updating a product, we must first present the user with the data that is currently in the edited record:

```php
<?php

/**
 * Modifica il prodotto basato sul suo id
 */
public function editAction($id)
{
    if (!$this->request->isPost()) {
        $product = Products::findFirstById($id);

        if (!$product) {
            $this->flash->error(
                'Product was not found'
            );

            return $this->dispatcher->forward(
                [
                    'controller' => 'products',
                    'action'     => 'index',
                ]
            );
        }

        $this->view->form = new ProductsForm(
            $product,
            [
                'edit' => true,
            ]
        );
    }
}
```

The data found is bound to the form by passing the model as first parameter. Thanks to this, the user can change any value and then sent it back to the database through to the `save` action:

```php
<?php

/**
 * Aggiona un prodotto basato sui dati inseriti dall'azione 'edit'
 */
public function saveAction()
{
    if (!$this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $id = $this->request->getPost('id', 'int');

    $product = Products::findFirstById($id);

    if (!$product) {
        $this->flash->error(
            'Product does not exist'
        );

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $form = new ProductsForm();

    $data = $this->request->getPost();

    if (!$form->isValid($data, $product)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message);
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'new',
            ]
        );
    }

    if ($product->save() === false) {
        $messages = $product->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message);
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'new',
            ]
        );
    }

    $form->clear();

    $this->flash->success(
        'Il prodotto è stato aggiornato con successo'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

<a name='user-components'></a>

## Componenti dell'utente

All the UI elements and visual style of the application has been achieved mostly through [Bootstrap](https://getbootstrap.com/). Some elements, such as the navigation bar changes according to the state of the application. For example, in the upper right corner, the link `Log in / Sign Up` changes to `Log out` if a user is logged into the application.

This part of the application is implemented in the component `Elements` (`app/library/Elements.php`).

```php
<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{
    public function getMenu()
    {
        // ...
    }

    public function getTabs()
    {
        // ...
    }
}
```

This class extends the [Phalcon\Mvc\User\Component](api/Phalcon_Mvc_User_Component). It is not imposed to extend a component with this class, but it helps to get access more quickly to the application services. Now, we are going to register our first user component in the services container:

```php
<?php

// Registra un componente dell'utente
$di->set(
    'elements',
    function () {
        return new Elements();
    }
);
```

As controllers, plugins or components within a view, this component also has access to the services registered in the container and by just accessing an attribute with the same name as a previously registered service:

```twig
{% raw %}
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
        <div class='container'>
            <a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
            </a>

            <a class='brand' href='#'>INVO</a>

            {{ elements.getMenu() }}
        </div>
    </div>
</div>

<div class='container'>
    {{ content() }}

    <hr>

    <footer>
        <p>&copy; Company 2017</p>
    </footer>
</div>
{% endraw %}
```

The important part is:

```twig
{% raw %}
{{ elements.getMenu() }}
{% endraw %}
```

<a name='dynamic-titles'></a>

## Cambiare il titolo dinamicamente

When you browse between one option and another will see that the title changes dynamically indicating where we are currently working. This is achieved in each controller initializer:

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        // Imposta il titolo del documento
        $this->tag->setTitle(
            'Gestisci i tuoi tipi prodotti'
        );

        parent::initialize();
    }

    // ...
}
```

Note, that the method `parent::initialize()` is also called, it adds more data to the title:

```php
<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        // Mandare il nome dell'applicazione al titolo
        $this->tag->prependTitle('INVO | ');
    }

    // ...
}
```

Finally, the title is printed in the main view (app/views/index.volt):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```