---
layout: default
title: 'Tutorial - INVO'
keywords: 'tutorial, invo tutorial, step by step, mvc'
---

# Tutorial - INVO
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Overview
[INVO][github_invo] is a small application that allows users to generate invoices, manage customers and products as well as sign up and log in. It showcases how certain tasks are handled by Phalcon. On the client side, [Bootstrap][bootstrap] is used for the UI. The application does not generate actual invoices, but serves as an example on how these tasks are implemented using Phalcon.

> **NOTE**: It is recommended that you open the application in your favorite editor so that you can follow this tutorial easier. 
> 
> {: .alert .alert-info }

> **NOTE**: Note the code below has been formatted to increase readability 
> 
> {: .alert .alert-warning }

## Structure
You can clone the repository to your machine (or download it) from [GitHub][github_invo]. Once you clone it (or download and unzip it) you will end up with the following directory structure:

```bash
└── invo
    ├── config
    ├── db
    │   └── migrations
    │       └── 1.0.0
    ├── docker
    │   └── 8.0
    │   └── 8.1
    │── public
    │   ├── index.php
    │   └── js
    ├── src
    │   ├── Controllers
    │   ├── Forms
    │   ├── Models
    │   ├── Plugins
    │   ├── Providers
    ├── themes
    │   ├── about
    │   ├── companies
    │   ├── contact
    │   ├── errors
    │   ├── index
    │   ├── invoices
    │   ├── layouts
    │   ├── products
    │   ├── producttypes
    │   ├── register
    │   └── session
    └── var
        ├── cache
        └── logs
```
Since Phalcon does not impose a particular directory structure, the particular structure is just our implementation. You will need to set up your webserver with instructions from the [webserver setup](webserver-setup) page.

Once the application is set up, you can open it in your browser by navigating to the following URL `https://localhost/invo`. You will see a screen similar to the one below:

![](/assets/images/content/tutorial-invo-1.png)

The application is divided into two parts: a frontend and a backend. The frontend is a public area where visitors can receive information about INVO and request contact information. The backend is an administrative area where registered users can manage their products and customers.

## Routing
INVO uses the standard route that is built-in with the [Router](routing) component. These routes match the following pattern:

```
/:controller/:action/:params
```

The custom route `/session/register` executes the controller `SessionController` and its action `registerAction`.

## Configuration
## Autoloader
For this application, we utilize the autoloader that comes with composer. You can easily adjust the code to use the autoloader provided by Phalcon if you wish:

```php
<?php

$rootPath = realpath('..');
require_once $rootPath . '/vendor/autoload.php';
```

### `DotEnv`
INVO uses the `Dotenv\Dotenv` library to retrieve some configuration variables that are unique to each installation.

```php
<?php

/**
 * Load ENV variables
 */
Dotenv::createImmutable($rootPath)
      ->load()
;
```
The above assumes that a `.env` file is present in your root directory. There is a `.env.example` file that you can use as a reference and copy/rename it.

### Providers
We will need to register all the services we need for the application in a DI container. The framework provides a variant of [Phalcon\Di\Di](di) called [Phalcon\Di\FactoryDefault](di#factory-default). This class has pre-registered services to suit a full stack MVC application. We therefore create a new `Phalcon\Di\FactoryDefault` object and then call the provider classes  to load the necessary services including the configuration of the application. They are all under the `Providers` folder.

As an example, the `Providers\ConfigProvider.php` class loads the `config/config.php` file, which contains the configuration of the application:

```php
<?php

namespace Invo\Providers;

use Exception;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

/**
 * Read the configuration
 */
class ConfigProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $configPath = $di->offsetGet('rootPath') . '/config/config.php';
        if (!file_exists($configPath) || !is_readable($configPath)) {
            throw new Exception('Config file does not exist: ' . $configPath);
        }

        $di->setShared('config', function () use ($configPath) {
            return require_once $configPath;
        });
    }
}
```

[Phalcon\Config\Config](config) allows us to manipulate the file in an object-oriented way. The configuration file has the following settings:

```php
<?php

declare(strict_types=1);

use Phalcon\Config\Config;

return new Config([
    'database' => [
        'adapter'  => $_ENV['DB_ADAPTER'] ?? 'Mysql',
        'host'     => $_ENV['DB_HOST'] ?? 'locahost',
        'username' => $_ENV['DB_USERNAME'] ?? 'phalcon',
        'password' => $_ENV['DB_PASSWORD'] ?? 'secret',
        'dbname'   => $_ENV['DB_DBNAME'] ?? 'phalcon_invo',
        'charset'  => $_ENV['DB_CHARSET'] ?? 'utf8',
    ],
    'application' => [
        'viewsDir' => $_ENV['VIEWS_DIR'] ?? 'themes/invo',
        'baseUri'  => $_ENV['BASE_URI'] ?? '/',
    ],
]);
```

Phalcon does not have a convention for defining settings. Sections help us to organize the options based on groups that makes sense for our application. In our file there are two sections that will be used later on: `application` and `database`.


## Request Handling
At the end of the file (`public/index.php`), the request is finally handled by [Phalcon\Mvc\Application](application), which initializes all the services necessary for the application to run.

```php
<?php

use Phalcon\Mvc\Application;

// ...

/**
 * Init MVC Application and send output to client
 */
(new Application($di))
    ->handle($_SERVER['REQUEST_URI'])
    ->send()
;
```

## Dependency Injection
In the first line of the code block above, the [Application](application) class constructor receives the variable `$container` as an argument.

Since Phalcon is highly decoupled, we need the container to be able to access registered services from it in different parts of the application. The component in question is [Phalcon\Di\Di](di). It is a service container, that also performs dependency injection and service location, instantiating all components as they are needed by the application.

There are many ways available to register services in the container. In INVO, most services have been registered using anonymous functions/closures. Thanks to this, the objects are lazy loaded, reducing the resources required by the application to a bare minimum.

For instance, in the following excerpt the `Providers\SessionProvider` service is registered. The anonymous function will only be called when the application requires access to the session data:

```php
<?php

use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;

$di->setShared(
    'session', 
    function () {
        $session = new SessionManager();
        $files   = new SessionAdapter(
            [
                'savePath' => sys_get_temp_dir(),
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    }
);
```

Here, we have the freedom to change the adapter, perform additional initialization and much more. Note that the service was registered using the name `session`. This is a convention that will allow the framework to identify the active service in the DI container.

## Log in
A `log in` page will allow us to work with the backend controllers. The separation between backend controllers and frontend ones is arbitrary. All controllers are located in the same directory (`src/Controllers/`).

![](/assets/images/content/tutorial-invo-2.png)

To enter the system, users must have a valid username and password. User data is stored in the table `users` in the database `invo`.

Now we need to configure the connection to the database. A service called `db` is set up in the service container with the connection information. As with the autoloader, we are again taking parameters from the configuration file in order to configure the service:

```php
<?php

// ...

$dbConfig = $di->getShared('config')
               ->get('database')
               ->toArray()
;
$di->setShared('db', function () use ($dbConfig) {
    $dbClass = 'Phalcon\Db\Adapter\Pdo\\' . $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    return new $dbClass($dbConfig);
});
```

Here, we return an instance of the MySQL connection adapter, because the `$dbConfig['adapter']` setting is `Mysql`. We can also add extra functionality, such as adding a [Logger](logger), a [profiler](db-models-events#profiling-sql-statements) to measure query execution times or even change the adapter to a different RDBMS.

The following simple form (`themes/invo/session/index.volt`) produces the necessary HTML so that users can submit login information. Some HTML code has been removed to improve readability:

```twig
{% raw %}
        <form action="/session/start" role="form" method="post">
            <fieldset>
                <div class="form-group">
                    <label for="email">Username/Email</label>
                    <div class="controls">
                        {{ text_field('email', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="controls">
                        {{ password_field('password', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    {{ submit_button('Login', 'class': 'btn btn-primary btn-large') }}
                </div>
            </fieldset>
        </form>
    </div>

    <div class="col-md-6">
        <div class="clearfix center">
            {{ link_to('register', 'Sign Up', 'class': 'btn btn-primary btn-large btn-success') }}
        </div>
    </div>
</div>
{% endraw %}
```

We are using [Volt](volt) as our template engine instead of PHP. This is a built-in template engine inspired by [Jinja][jinja] providing a simple and user-friendly syntax to create templates. If you have worked with [Jinja][jinja] or [Twig][twig] in the past, you will see many similarities.

The `SessionController::startAction` function (`src/Controllers/SessionController.php`) validates the data submitted from the form, and also checks for a valid user in the database:

```php
<?php

use Invo\Models\Users;

class SessionController extends ControllerBase
{
    // ...

    /**
     * This action authenticate and logs a user into the application
     */
    public function startAction(): void
    {
        if ($this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            /** @var Users|null $user */
            $user = Users::findFirst([
                "(email = :email: OR username = :email:) AND "
                . "password = :password: AND active = 'Y'",
                'bind' => [
                    'email'    => $email,
                    'password' => sha1($password),
                ],
            ]);

            if ($user) {
                $this->registerSession($user);
                $this->flash->success('Welcome ' . $user->name);

                $this->dispatcher->forward(
                    [
                        'controller' => 'invoices',
                        'action'     => 'index',
                    ]
                );

                return;
            }

            $this->flash->error('Wrong email/password');
        }

        $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    private function registerSession(Users $user): void
    {
        $this->session->set(
            'auth', 
            [
                'id'   => $user->id,
                'name' => $user->name,
            ]
        );
    }
}
```

At first inspection of the code, you will note that several public properties are accessed in the controller, such as `$this->flash`, `$this->request` or `$this->session`. [Controllers](controllers) in Phalcon are automatically tied to the [Phalcon\Di\Di](di) container and as a result, all the services registered in the container are present in each controller as properties with the same name as the name of each service. If the service is accessed for the first time, it will be automatically instantiated and returned to the caller. Additionally, these services are set as _shared_ so the same instance will be returned, no matter how many times we access the property/service in the same request. These are services defined in the services container from earlier (`Providers` folder) and you can of course change this behavior when setting up these services.

For instance, here we invoke the `session` service, and then we store the user identity in the variable `auth`:

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

> **NOTE**: For more information about Di services, please check the [Dependency Injection](di) document. 
> 
> {: .alert .alert-info }

The `startAction` first checks if data has been submitted using a `POST`. If not, the user will be redirected again to the same form. We are checking if the form has been submitted via `POST` using the `isPost()` method on the request object.

```php
<?php

if ($this->request->isPost()) {
    // ...
}
```

We then retrieve posted data from the request. These are the text boxes that are used to submit the form when the user clicks `Log In`. We use the `request` object and `getPost()` method.

```php
<?php

$email    = $this->request->getPost('email');
$password = $this->request->getPost('password');
```

Now, we have to check if we have an active user with the submitted email and password:

```php
<?php

$user = Users::findFirst(
    [
        "(email = :email: OR username = :email:) " .
        "AND password = :password: " .
        "AND active = 'Y'",
        'bind' => [
            'email'    => $email,
            'password' => sha1($password),
        ]
    ]
);
```
> **NOTE**: Note, the use of 'bound parameters', placeholders `:email:` and `:password:` are placed where values should be, then the values are _bound_ using the parameter `bind`. This safely replaces the values for those columns without having the risk of a SQL injection.

When searching for the user in the database, we are not searching for the password directly using clear text. The application stores passwords as hashes, using the [sha1][sha1] method. Although this methodology is adequate for a tutorial, you might want to consider using a different algorithm for a production application. The [Phalcon\Encryption\Security](encryption-security) component offers convenience methods to strengthen the algorithm used for your hashes.

If the user is found, then we register the user in the session (log the user in) and forward them to the dashboard (`Invoices` controller, `index` action) showing a welcome message.

```php
<?php

if ($user) {
    $this->registerSession($user);
    $this->flash->success('Welcome ' . $user->name);

    $this->dispatcher->forward([
        'controller' => 'invoices',
        'action'     => 'index',
    ]);

    return;
}
```

If the user is not found, we forward them to the login page with a `Wrong email/password` message on screen.

```php
<?php

return $this->dispatcher->forward(
    [
        'controller' => 'session',
        'action'     => 'index',
    ]
);
```

## Backend Security
The backend is a private area where only registered users have access. Therefore, it is necessary to check that only registered users have access to these controllers. If you are not logged in and try to access a _private_ area you will see a message like the one below:

Every time a user attempts to access any controller/action, the application verifies that the current role (stored in the session) has access to it, otherwise it displays a message as shown above and forwards the flow to the home page.

In order to accomplish this, we need to use the [Dispatcher](dispatcher) component. When the user requests a page or URL, the application first identifies the page requested using the [Route](routing) component. Once the route has been identified and matched to a valid controller and action, this information is delegated to the [Dispatcher](dispatcher) which then loads the controller and executes the action.

Normally, the framework creates the Dispatcher automatically. In our case, we need to verify that the user is logged in before the route is dispatched. As such we need to replace the default component in the DI container and set a new one in (`Providers\DispatchProvider.php`). We do this when bootstrapping the application:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...
$di->setShared(
    'dispatcher', 
    function () {
        // ...
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Invo\Controllers');
        // ...

        return $dispatcher;
    }
);
```
Now that the dispatcher is registered, we need to take advantage of a _hook_ available to intercept the flow of execution and perform our verification checks. Hooks are called Events in Phalcon and in order to access or enable them, we need to register an [Events Manager](events) component in our application so that it can _fire_ those events in our application.

By creating an [Events Manager](events) and attaching specific code to the `dispatcher` events, we now have a lot more flexibility and can attach our code to the dispatch loop or operation.

### Events
The [Events Manager](events) allows us to attach listeners to a particular type of event. The event type that we are attaching to is `dispatch`. The code below attaches listeners to the `beforeExecuteRoute` and `beforeException` events. We utilize these events to check for 404 pages and also perform allowed access checks in our application.

```php
<?php

use Invo\Plugins\NotFoundPlugin;
use Invo\Plugins\SecurityPlugin;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;

$di->setShared(
    'dispatcher', 
    function () {
        $eventsManager = new EventsManager();

        /**
         * Check if the user is allowed to access certain action using 
         * the SecurityPlugin
         */
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute', 
            new SecurityPlugin()
        );

        /**
         * Handle exceptions and not-found exceptions using NotFoundPlugin
         */
        $eventsManager->attach(
            'dispatch:beforeException', 
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Invo\Controllers');
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

When an event called `beforeExecuteRoute` is triggered the `SecurityPlugin` plugin will be notified:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeExecuteRoute',
    new SecurityPlugin()
);
```

When a `beforeException` is triggered then the `NotFoundPlugin`  is notified:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

`SecurityPlugin` is a class located in the `Plugins` directory (`src/Plugins/SecurityPlugin.php`). This class implements the method `beforeExecuteRoute`. This is the same name as one of the events produced in the Dispatcher:

```php
<?php

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Injectable
{
    // ...

    public function beforeExecuteRoute(
        Event $event, 
        Dispatcher $containerspatcher
    ) {
        // ...
    } }
```
The event methods always receive the actual event as the first parameter. This is a [Phalcon\Events\Event][events-event] object which will contain information regarding the event such as its type and other related information. For this particular event, the second parameter will be the object that produced the event itself (`$containerspatcher`). It is not mandatory that plugins classes extend the class [Phalcon\Di\Injectable][di-injectable], but by doing this they gain easier access to the services available in the application.

We now have the structure to start verifying the role in the current session. We can check if the user has access to use the [ACL](acl). If the user does not have access, we will redirect them to the home screen.

```php
<?php

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    // ...

    public function beforeExecuteRoute(
        Event $event, 
        Dispatcher $containerspatcher
    ) {
        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        $acl = $this->getAcl();

        if (!$acl->isComponent($controller)) {
            $dispatcher->forward(
                [
                    'controller' => 'errors',
                    'action'     => 'show404',
                ]
            );

            return false;
        }

        $allowed = $acl->isAllowed($role, $controller, $action);
        if (!$allowed) {
            $dispatcher->forward(
                [
                    'controller' => 'errors',
                    'action'     => 'show401',
                ]
            );

            $this->session->destroy();

            return false;
        }

        return true;
    }
}
```
We first get the `auth` value from the `session` service. If we are logged in, then this has been already set for us during the login process. If not, we are just a guest.

Following that we get the name of the controller and the action, and also retrieve the Access Control List (ACL). We check if the user `isAllowed` using the combination `role` - `controller` - `action`. If yes, the method will finish processing.

If we do not have access, then the method will return `false` stopping the execution, right after we forward the user to the home page.

### ACL
In the above example we have obtained the ACL using the method `$this->getAcl()`. To build the ACL we need to do the following:

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

$acl->setDefaultAction(Enum::DENY);

$roles = [
    'users'  => new Role(
        'Users',
        'Member privileges, granted after sign in.'
    ),
    'guests' => new Role(
        'Guests',
        'Anyone browsing the site who is not signed in is considered to be a "Guest".'
    )
];

foreach ($roles as $role) {
    $acl->addRole($role);
}
```
First we create a new `Phalcon\Acl\Adapter\Memory` object. Although the default access is `DENY` we still set it in our list by using `setDefaultAction()`. After that we need to set up our roles. For INVO we have `guests` (users that have not been logged in) and `users`. We register those roles by using `addRole` on the list.

Now that the roles are set, we need to set the components for the list. ACL components map to the areas of our application (controller/action). Doing so we can control which role can access which component.

```php
<?php

use Phalcon\Acl\Component;

// ...

$privateComponents = [
    'companies'    => [
        'index', 
        'search', 
        'new', 
        'edit', 
        'save', 
        'create', 
        'delete',
    ],
    'products'     => [
        'index', 
        'search', 
        'new', 
        'edit', 
        'save', 
        'create', 
        'delete',
    ],
    'producttypes' => [
        'index', 
        'search', 
        'new', 
        'edit', 
        'save', 
        'create', 
        'delete',
    ],
    'invoices'     => [
        'index', 
        'profile',
    ],
];

foreach ($privateComponents as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}

$publicComponents = [
    'index'    => [
        'index',
        ],
    'about'    => [
        'index',
        ],
    'register' => [
        'index',
        ],
    'errors'   => [
        'show404', 
        'show500',
    ],
    'session'  => [
        'index', 
        'register', 
        'start', 
        'end',
    ],
    'contact'  => [
        'index', 
        'send',
    ],
];

foreach ($publicComponents as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}
```
As seen above, we first register the private areas of our application (backend) and then the public ones (frontend). The arrays created have the key as the controller name while the values are the relevant actions. We do the same thing with the public components.

Now that roles and components are registered, we need to link the two so that the ACL is complete. The `Users` role has access to public (frontend) and private (backend) components, while `Guests` only have access to the public (frontend) components.

```php
<?php

// Grant access to public areas to both users and guests
foreach ($roles as $role) {
    foreach ($publicResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow($role->getName(), $resource, $action);
        }
    }
}

// Grant access to private area to role Users
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow('Users', $resource, $action);
    }
}
```

## CRUD
A backend portion of an application is the code that provides forms and logic, allowing users to manipulate data i.e. perform CRUD operations. We will explore how INVO handles this task and also demonstrate the use of forms, validators, paginators and more.

We have a simple [CRUD][crud] (Create, Read, Update and Delete) implementation in INVO, to manipulate data (companies, products, types of products). For products the following files are used:


```bash
└── invo
    └── src
        ├── Controllers
        │   └── ProductsController.php
        ├── Forms
        │   └── ProductsForm.php
        ├── Models
        │   └── Products.php
        └── themes
            └── invo
                └── products
                    ├── edit.volt
                    ├── index.volt
                    ├── new.volt
                    └── search.volt
```
For other areas (such as companies for instance), the relevant files (prefixed with `Company`) can be found in the same directories as shown above.

Each controller has the following actions:

```php
<?php

class ProductsController extends ControllerBase
{
    public function createAction();

    public function editAction($id);

    public function deleteAction($id);

    public function indexAction();

    public function newAction();

    public function saveAction();

    public function searchAction();
}
```

| Akcja          | Description                                                                                             |
| -------------- | ------------------------------------------------------------------------------------------------------- |
| `createAction` | Creates a product based on the data entered in the `new` action                                         |
| `deleteAction` | Deletes an existing product                                                                             |
| `editAction`   | Shows the view to `edit` an existing product                                                            |
| `indexAction`  | The start action, it shows the `search` view                                                            |
| `newAction`    | Shows the view to create a `new` product                                                                |
| `saveAction`   | Updates a product based on the data entered in the `edit` action                                        |
| `searchAction` | Execute the `search` based on the criteria sent from the `index`. Returning a paginator for the results |

## Search Form
Our CRUD operations start with the search form. This form shows each field that the table has (`products`), allowing the user to enter search criteria for each field. The `products` table has a relationship with the table `products_types`. In this case, we previously queried the records in the `product_types` table to offer search criteria for this field:

```php
<?php

public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```
An instance of the `ProductsForm` form (`src/Forms/ProductsForm.php`) is passed to the view. This form defines the fields that are visible to the user:

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
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $this->add((new Text('id'))->setLabel('Id'));
        } else {
            $this->add(new Hidden('id'));
        }

        /**
         * Name text field
         */
        $name = new Text('name');
        $name->setLabel('Name');
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf(
                [
                    'message' => 'Name is required'
                ]
            ),
        ]);

        $this->add($name);

        /**
         * Product Type Id Select
         */
        $type = new Select(
            'product_types_id',
            ProductTypes::find(),
            [
                'using'      => ['id', 'name'],
                'useEmpty'   => true,
                'emptyText'  => '...',
                'emptyValue' => '',
            ]
        );
        $type->setLabel('Type');

        $this->add($type);

        /**
         * Price text field
         */
        $price = new Text('price');
        $price->setLabel('Price');
        $price->setFilters(['float']);
        $price->addValidators([
            new PresenceOf(
                [
                    'message' => 'Price is required'
                ]
            ),
            new Numericality(
                [
                    'message' => 'Price is required'
                ]
            ),
        ]);

        $this->add($price);
     }
}
```

The form is declared using an object-oriented scheme based on the elements provided by the [Phalcon\Forms\Form](forms) component. Each element defined follows almost the same setup:

```php
<?php

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
                'message' => 'Name is required',
            ]
        )
    ]
);

$this->add($name);
```
First we create the element. Then we attach a label to it, attach filters, so that we can perform sanitization of data. Following that we apply a validators on the element and finally add the element to the form.

Other elements are also used in this form:

```php
<?php

$this->add(
    new Hidden('id')
);

// ...

$productTypes = ProductTypes::find();

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
In the above code snippet, we add a hidden HTML field that holds the `id` of the product if applicable. We also get all the product types by using the `ProductTypes::find()` and then use that resultset to fill the HTML `select` element by using the [Phalcon\Tag](tag) component and its `select()` method. Once the form is passed to the view, it can be rendered and presented to the user:

```twig
{% raw %}
<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>Search products</h2>
    </div>
    <div class="col-xs-12 col-md-6 text-right">
        {{ link_to("products/new", "Create Product", "class": "btn btn-primary") }}
    </div>
</div>

<form action="/products/search" role="form" method="get">
    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label() }}
                <div class="controls">
                    {{ element.setAttribute("class", "form-control") }}
                </div>
            </div>
        {% endif %}
    {% endfor %}

    {{ submit_button("Search", "class": "btn btn-primary") }}
</form>
{% endraw %}
```

This produces the following HTML:

```html
<form action='/invo/products/search' method='post'>

    <h2>
        Search products
        <div class="col-xs-12 col-md-6 text-right">
            <a href="products/new" "class=btn btn-primary">Create Product</a>
        </div>
    </h2>

    <fieldset>

        <div class='control-group'>
            <label for='id' class='control-label'>Id</label>

            <div class='controls'>
                <input type='text' id='id' name='id' />
            </div>
        </div>

        <div class='control-group'>
            <label for='name' class='control-label'>Name</label>

            <div class='controls'>
                <input type='text' id='name' name='name' />
            </div>
        </div>

        <div class='control-group'>
            <label for='profilesId' class='control-label'>
                profilesId
            </label>

            <div class='controls'>
                <select id='profilesId' name='profilesId'>
                    <option value=''>...</option>
                    <option value='1'>Vegetables</option>
                    <option value='2'>Fruits</option>
                </select>
            </div>
        </div>

        <div class='control-group'>
            <label for='price' class='control-label'>Price</label>

            <div class='controls'>
                <input type='text' id='price' name='price' />
            </div>
        </div>

        <div class='control-group'>
            <input type='submit' 
                   value='Search' 
                   class='btn btn-primary' />
        </div>

    </fieldset>

</form>
```

When the form is submitted, the `search` action is executed in the controller performing the search based on the data entered by the user.

## Search
The `search` action has two operations. When accessed using the HTTP method `POST`, it performs the search based on the data sent from the form. When it is accessed using the HTTP method `GET`, it moves the current page in the paginator. To check which HTTP method has been used, we use the [Request](request) component:

```php
<?php

public function searchAction()
{
    if ($this->request->isPost()) {
        // POST
    } else {
        // GET
    }

    // ...
}
```

With the help of [Phalcon\Mvc\Model\Criteria][mvc-model-criteria], we can create the search conditions based on the data types and values sent from the form:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

This method verifies which values are different from '' (empty string) and `null` and takes them into account to create the search criteria:

* If the field data type is `text` or similar (`char`, `varchar`, `text`, etc.) It uses an SQL `like` operator to filter the results.
* If the data type is not `text` or similar, it will use the operator `=`.

Additionally, `Criteria` ignores all the `$_POST` variables that do not match any field in the table. Values are automatically escaped using `bound parameters`.

Now, we store the produced parameters in the controller's session bag:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

A session bag, (`persistent` property) is a special attribute in a controller that persists data between requests using the session service. When accessed, this attribute injects a [Phalcon\Session\Bag](session#persistent-data) instance that is independent in each controller.

Then, based on the built params we perform the query:

```php
<?php

$products = Products::find($parameters);

if (count($products) === 0) {
    $this->flash->notice(
        'The search did not found any products'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

If the search does not return any product, we forward the user to the `index` action again. If the search returns results, we pass them to a paginator object so that we can navigate through chunks of resultsets:

```php
<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

// ...

$paginator = new Paginator(
    [
        'data'  => $products,
        'limit' => 5,
        'page'  => $numberPage,
    ]
);

$page = $paginator->paginate();
```
The [paginator](pagination) object receives the results obtained by the search. We also set a limit (results per page) as well as the page number. Finally, we call `paginate()` to get the appropriate chunk of the resultset back.

We then pass the returned page to view:

```php
<?php

$this->view->page = $page;
```

In the view (`themes/invo/products/search.volt`), we traverse the results corresponding to the current page, showing every row in the current page to the user:

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
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
        <td>{{ product.id }}</td>
        <td>{{ product.getProductTypes().name }}</td>
        <td>{{ product.name }}</td>
        <td>${{ "%.2f"|format(product.price) }}</td>
        <td>{{ product.getActiveDetail() }}</td>
        <td width="7%">
            {{ 
                link_to(
                    "products/edit/" ~ product.id, 
                    '<i class="glyphicon glyphicon-edit"></i> Edit', 
                    "class": "btn btn-default"
                ) 
            }}
        </td>
        <td width="7%">
            {{ 
                link_to(
                    "products/delete/" ~ product.id, 
                    '<i class="glyphicon glyphicon-remove"></i> Delete', 
                    "class": "btn btn-default"
                ) 
            }}
        </td>
    </tr>
    {% if loop.last %}
        </tbody>
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ 
                        link_to(
                            "products/search", 
                            '<i class="icon-fast-backward"></i> First', 
                            "class": "btn"
                        ) 
                    }}
                    {{ 
                        link_to(
                            "products/search?page=" ~ page.before, 
                            '<i class="icon-step-backward"></i> Previous', 
                            "class": "btn"
                        ) 
                    }}
                    {{ 
                        link_to(
                            "products/search?page=" ~ page.next, 
                            '<i class="icon-step-forward"></i> Next', 
                            "class": "btn"
                        ) 
                    }}
                    {{ 
                        link_to(
                            "products/search?page=" ~ page.last, 
                            '<i class="icon-fast-forward"></i> Last', 
                            "class": "btn"
                        ) 
                    }}
                    <span class="help-inline">
                        {{ page.current }} of {{ page.total_pages }}
                    </span>
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

Looking at the code above it is worth mentioning:

The active items in the current page are traversed using a Volt's `for`. Volt provides a simpler syntax for a PHP `foreach`.

```twig
{% raw %}
{% for product in page.items %}
{% endraw %}
```

Which in PHP is the same as:

```php
<?php foreach ($page->items as $product) { ?>
```

The whole `for` block is:

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        // 1
    {% endif %}

    // 2

    {% if loop.last %}
        // 3
    {% endif %}
{% else %}
    // 4
{% endfor %}
{% endraw %}
```

- `1` - Executed before the first product in the loop
- `2` - Executed for every product of page.items
- `3` - Executed after the last product in the loop
- `4` - Executed if page.items does not have any products


Now you can go back to the view and find out what every block is doing. Every field in `product` is printed accordingly:

```twig
{% raw %}
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
{% endraw %}
```

As we have seen before using `product.id` is the same as in PHP as doing: `$product->id`, we made the same with `product.name` and so on. Other fields are rendered differently, for instance, let's focus in `product.getProductTypes().name`. To understand this part, we have to check the Products model (`app/models/Products.php`):

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Products extends Model
{
    // ...

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

A model can have a method called `initialize()`, this method is called once per request, and it serves the ORM to initialize a model. In this case, `Products` is initialized by defining that this model has a one-to-many relationship to another model called `ProductTypes`.

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
Which means, the local attribute `product_types_id` in `Products` has a one-to-many relation to the `ProductTypes` model in its attribute `id`. By defining this relationship we can access the name of the product type by using:

```twig
{% raw %}
<td>{{ product.getProductTypes().name }}</td>
{% endraw %}
```

The field `price` is printed by its formatted using a Volt filter:

```twig
{% raw %}
<td>{{ '%.2f' | format(product.price) }}</td>
{% endraw %}
```

In plain PHP, this would be:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

Printing whether the product is active or not uses a helper method:

```php
{% raw %}
<td>{{ product.getActiveDetail() }}</td>
{% endraw %}
```

This method is implemented in the model.

## Create/Update
When creating and updating records, we use the `new` and `edit` views. The data entered by the user is sent to the `create` and `save` actions that perform actions of _creating_ and _updating_ products, respectively.

In the creation case, we get the data submitted and assign them to a new `Products` instance:

```php
<?php

public function createAction()
{
    if (true !== $this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $form    = new ProductsForm();
    $product = new Products();

    $product->id = $this
        ->request
        ->getPost('id', 'int')
    ;

    $product->product_types_id = $this
        ->request
        ->getPost('product_types_id', 'int')
    ;

    $product->name = $this
        ->request
        ->getPost('name', 'striptags')
    ;

    $product->price = $this
        ->request
        ->getPost('price', 'double')
    ;

    $product->active = $this
        ->request
        ->getPost('active')
    ;

    // ...
}
```
As seen earlier, when we were creating the form, there were some filters assigned to the relevant elements. When the data is passed to the form, these filters are invoked, and they sanitize the supplied input. Although this filtering is optional, it is always a good practice. Added to this, the ORM also escapes the supplied data and performs additional casting according to the column types:

```php
<?php

// ...

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
                'message' => 'Name is required',
            ]
        )
    ]
);

$this->add($name);
```

Upon saving the data, we will know whether the business rules and validations implemented in the `ProductsForm` pass (`src/Forms/ProductsForm.php`):

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

$data = $this->request->getPost();

if (true !== $form->isValid($data, $product)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message->getMessage());
    }

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'new',
        ]
    );
}
```

Calling `$form->isValid()` invokes all the validators set in the form. If the validation does not pass, the `$messages` variable will contain the relevant messages of the failed validations.

If there are no validation errors, we can save the record:

```php
<?php

// ...

if ($product->save() === false) {
    $messages = $product->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message->getMessage());
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
    'Product was created successfully'
);

return $this->dispatcher->forward(
    [
        'controller' => 'products',
        'action'     => 'index',
    ]
);
```

We are checking the result of the `save()` method on the model and if errors occurred, they will be present in the `$messages` variable and the user will be sent back to the `products/new` action with error messages displayed. If everything is OK, the form is cleared and the user is redirected to the `products/index` with the relevant success message.

In the case of updating a product, we must first get the relevant record from the database and then populate the form with the existing data:

```php
<?php

public function editAction($id)
{
    if (true !== $this->request->isPost()) {
        $product = Products::findFirstById($id);

        if (null !== $product) {
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

The data found is bound to the form by passing the model as first parameter. Because of this, the user can change any value and then sent it back to the database through to the `save` action:

```php
<?php

public function saveAction()
{
    if (true !== $this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $id      = $this->request->getPost('id', 'int');
    $product = Products::findFirstById($id);

    if (null !== $product) {
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

    if (true !== $form->isValid($data, $product)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message->getMessage());
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'new',
            ]
        );
    }

    if (false === $product->save()) {
        $messages = $product->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message->getMessage());
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
        'Product was updated successfully'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

## Dynamic Titles
When you navigate through the application, you will see that the title changes dynamically indicating where we are currently working. This is achieved in each controller (`initialize()` method):

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->tag->title()
                  ->set('Manage your products')
        ;
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
        $this->tag->title()
                  ->prepend('INVO | ')
        ;
        $this->view->setTemplateAfter('main');
    }

    // ...
}
```
The above code prepends the application name to the title

Finally, the title is printed in the main view (`themes/invo/views/index.volt`):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```

[github_invo]: https://github.com/phalcon/invo

[github_invo]: https://github.com/phalcon/invo
[bootstrap]: https://getbootstrap.com
[sha1]: https://php.net/manual/en/function.sha1.php
[crud]: https://en.wikipedia.org/wiki/Create,_read,_update_and_delete
[jinja]: https://jinja.palletsprojects.com/en/2.10.x/
[twig]: https://twig.symfony.com/
[events-event]: api/phalcon_events#events-event
[di-injectable]: api/phalcon_di#di-injectable
[mvc-model-criteria]: api/phalcon_mvc#mvc-model-criteria
