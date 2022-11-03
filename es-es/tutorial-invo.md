---
layout: default
title: 'Tutorial - INVO'
keywords: 'tutorial, tutorial invo, paso a paso, mvc'
---

# Tutorial - INVO
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[INVO][github_invo] is a small application that allows users to generate invoices, manage customers and products as well as sign up and log in. Muestra como se gestionan ciertas tareas por Phalcon. On the client side, [Bootstrap][bootstrap] is used for the UI. La aplicación no genera facturas reales, sino que sirve como ejemplo de cómo se implementan estas tareas usando Phalcon.

> **NOTE**: It is recommended that you open the application in your favorite editor so that you can follow this tutorial easier. 
> 
> {: .alert .alert-info }

> **NOTE**: Note the code below has been formatted to increase readability 
> 
> {: .alert .alert-warning }

## Estructura
You can clone the repository to your machine (or download it) from [GitHub][github_invo]. Una vez clonado (o descargado y descomprimido) terminará con la siguiente estructura de directorios:

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
Ya que Phalcon no impone una estructura de directorios en particular, la estructura particular es sólo nuestra implementación. Necesita configurar su servidor web con instrucciones de la página [configuración del servidor web](webserver-setup).

Una vez que la aplicación está configurada, puede abrirla en su navegador navegando a la siguiente URL `https://localhost/invo`. Verá una pantalla similar a la siguiente:

![](/assets/images/content/tutorial-invo-1.png)

La aplicación está dividida en dos partes: un *frontend* y un *backend*. El *frontend* es un área pública donde los visitantes pueden recibir información sobre INVO y solicitar información de contacto. El *backend* es un área administrativa donde los usuarios registrados pueden gestionar sus productos y clientes.

## Ruteo
INVO usa la ruta estándar que está integrada en el componente [Router](routing). Estas rutas coinciden con el siguiente patrón:

```
/:controller/:action/:params
```

La ruta personalizada `/session/register` ejecuta el controlador `SessionController` y su acción `registerAction`.

## Configuración
## Autocargador
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

### Proveedores
We will need to register all the services we need for the application in a DI container. The framework provides a variant of [Phalcon\Di\Di](di) called [Phalcon\Di\FactoryDefault](di#factory-default). Esta clase tiene servicios preregistrados para adaptarse a una aplicación MVC de pila completa. We therefore create a new `Phalcon\Di\FactoryDefault` object and then call the provider classes  to load the necessary services including the configuration of the application. They are all under the `Providers` folder.

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

[Phalcon\Config\Config](config) allows us to manipulate the file in an object-oriented way. El fichero de configuración tiene los siguientes ajustes:

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

Phalcon no tiene una convención para definir los ajustes. Las secciones nos ayudan a organizar las opciones basadas en grupos que tienen sentido para nuestra aplicación. In our file there are two sections that will be used later on: `application` and `database`.


## Gestión de Petición
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

## Inyección de Dependencias
En la primera línea del bloque de código anterior, el constructor de la clase [Application](application) recibe la variable `$container` como argumento.

Ya que Phalcon es altamente desacoplado, necesitamos el contenedor para ser capaces de acceder a los servicios registrados desde él en diferentes partes de la aplicación. The component in question is [Phalcon\Di\Di](di). Es un contenedor de servicios, también permite realizar inyección de dependencias y localización de servicios, instanciando todos los componentes que se necesitan por la aplicación.

Hay muchas maneras disponibles para registrar servicios en el contenedor. En INVO, la mayoría de servicios se han registrado usando funciones anónimas/clausuras. Gracias a esto, los objetos se cargan perezosamente, reduciendo los recursos requeridos por la aplicación al mínimo.

For instance, in the following excerpt the `Providers\SessionProvider` service is registered. La función anónima solo se llamará cuando la aplicación requiera el acceso a los datos de sesión:

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

Aquí, tenemos la libertad de cambiar el adaptador, realizar una inicialización adicional y mucho más. Tenga en cuenta que el servicio se registró usando el nombre `session`. This is a convention that will allow the framework to identify the active service in the DI container.

## Inicio de Sesión
Una página `de inicio de sesión` nos permitirá trabajar con los controladores del *backend*. La separación entre controladores del *backend* y los del *frontend* es arbitraria. All controllers are located in the same directory (`src/Controllers/`).

![](/assets/images/content/tutorial-invo-2.png)

Para entrar al sistema, los usuarios deben tener un nombre de usuario y contraseña válidos. Los datos de usuario están almacenados en la tabla `users` en la base de datos `invo`.

Ahora necesitamos configurar la conexión a la base de datos. Está configurado un servicio llamado `db` en el contenedor de servicios con la información de conexión. Con el autocargador, otra vez tomamos parámetros desde el fichero de configuración para poder configurar el servicio:

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

Here, we return an instance of the MySQL connection adapter, because the `$dbConfig['adapter']` setting is `Mysql`. También podemos añadir funcionalidad adicional, como añadir un [logger](logger), un [profiler](db-models-events#profiling-sql-statements) para medir tiempos de ejecución o incluso cambiar el adaptador a un RMBMS diferente.

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

Estamos usando [Volt](volt) como nuestro motor de plantillas en lugar de PHP. This is a built-in template engine inspired by [Jinja][jinja] providing a simple and user-friendly syntax to create templates. If you have worked with [Jinja][jinja] or [Twig][twig] in the past, you will see many similarities.

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

En la primera inspección del código, observará que se accede a varias propiedades públicas en el controlador, como `$this->flash`, `$this->request` o `$this->session`. [Controllers](controllers) in Phalcon are automatically tied to the [Phalcon\Di\Di](di) container and as a result, all the services registered in the container are present in each controller as properties with the same name as the name of each service. Si el servicio se accede por primera vez, será automáticamente instanciado y devuelto a la persona que lo invoca. Additionally, these services are set as _shared_ so the same instance will be returned, no matter how many times we access the property/service in the same request. These are services defined in the services container from earlier (`Providers` folder) and you can of course change this behavior when setting up these services.

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

`startAction` primero comprueba si los datos se han enviado usando `POST`. Si no, el usuario será redirigido otra vez al mismo formulario. Comprobamos si el formulario se ha enviado vía `POST` usando el método `isPost()` en el objeto `request`.

```php
<?php

if ($this->request->isPost()) {
    // ...
}
```

A continuación, recuperamos los datos enviados desde la petición. Hay cajas de texto que se han usado para enviar al formulario cuando el usuario hace click en `Log In`. Usamos el objeto `request` y el método `getPost()`.

```php
<?php

$email    = $this->request->getPost('email');
$password = $this->request->getPost('password');
```

Ahora, tenemos que comprobar si tenemos un usuario activo con el email y contraseña enviados:

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
> **NOTE**: Note, the use of 'bound parameters', placeholders `:email:` and `:password:` are placed where values should be, then the values are _bound_ using the parameter `bind`. Esto reemplaza con seguridad los valores para esas columnas sin correr el riesgo de una inyección SQL.

Cuando buscamos al usuario en la base de datos, no estamos buscando la contraseña directamente usando texto plano. The application stores passwords as hashes, using the [sha1][sha1] method. Aunque esta metodología es adecuada para un tutorial, podría considerar usar un algoritmo diferente para una aplicación en producción. The [Phalcon\Encryption\Security](encryption-security) component offers convenience methods to strengthen the algorithm used for your hashes.

Si se encuentra el usuario, entonces registramos el usuario en la sesión (el usuario inicia sesión) y lo reenviamos al panel de control (controlador `Invoices`, acción `index`) mostrando un mensaje de bienvenida.

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

Si el usuario no se encuentra, lo redirigimos a la página de inicio de sesión con un mensaje `Wrong email/password` en pantalla.

```php
<?php

return $this->dispatcher->forward(
    [
        'controller' => 'session',
        'action'     => 'index',
    ]
);
```

## Seguridad del *Backend*
El *backend* es un área privada donde sólo tienen acceso los usuarios registrados. Por lo tanto, hay que comprobar que sólo los usuarios registrados tienen acceso a esos controladores. If you are not logged in and try to access a _private_ area you will see a message like the one below:

Cada vez que un usuario intenta acceder a un controlador/acción, la aplicación verifica que el rol actual (almacenado en sesión) tiene acceso a él, de lo contrario mostrará un mensaje como el mostrado anteriormente y reenviará el flujo a la página de inicio.

Para poder lograr esto, necesitamos usar el componente [Despachador](dispatcher). Cuando el usuario solicita una página o URL, la aplicación primero identifica la página solicitada usando el componente [Enrutador](routing). Una vez que se ha identificado la ruta y encaja con un controlador y acción válidos, esta información se delega al [Despachador](dispatcher) que después carga el controlador y ejecuta la acción.

Normalmente, el framework crea el Despachador automáticamente. En nuestro caso, necesitamos verificar que el usuario se conecta antes de que se despache la ruta. As such we need to replace the default component in the DI container and set a new one in (`Providers\DispatchProvider.php`). Lo hacemos cuando iniciamos la aplicación:

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

Al crear un [Gestor de Eventos](events) y adjuntar código específico a los eventos del `despachador`, ahora tenemos mucha más flexibilidad y podemos adjuntar nuestro código al bucle u operación del despachador.

### Eventos
El [Gestor de Eventos](events) nos permite adjuntar oyentes a un tipo de evento particular. El tipo de evento al que nos adjuntamos es `dispatch`. El código siguiente adjunta oyentes a los eventos `beforeExecuteRoute` y `beforeException`. Usamos estos eventos para comprobar páginas 404 y también realizar comprobaciones de acceso permitido en nuestra aplicación.

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

Cuando se dispara un evento llamado `beforeExecuteRoute` se notifica al plugin `SecurityPlugin`:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeExecuteRoute',
    new SecurityPlugin()
);
```

Cuando se dispara `beforeException` entonces se notifica a `NotFoundPlugin`:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

`SecurityPlugin` is a class located in the `Plugins` directory (`src/Plugins/SecurityPlugin.php`). Esta clase implementa el método `beforeExecuteRoute`. Este es el mismo nombre que el de los eventos producidos en el Despachador:

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
    }
}
```
Los métodos de eventos siempre reciben el evento actual como primer parámetro. This is a [Phalcon\Events\Event][events-event] object which will contain information regarding the event such as its type and other related information. Para este evento particular, el segundo parámetro será el objeto que ha producido el propio evento (`$containerspatcher`). It is not mandatory that plugins classes extend the class [Phalcon\Di\Injectable][di-injectable], but by doing this they gain easier access to the services available in the application.

Ahora tenemos la estructura para empezar a verificar el rol en la sesión actual. Podemos comprobar si el usuario tiene acceso al usar la [ACL](acl). Si el usuario no tiene acceso, le redirigiremos a la pantalla de inicio.

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
Primero obtenemos el valor `auth` del servicio `session`. Si estamos conectados, entonces ya se ha establecido por nosotros durante el proceso de inicio de sesión. Si no, somos sólo un invitado.

A continuación, obtenemos el nombre del controlador y la acción, y también recuperamos la Lista de Control de Acceso (ACL). Comprobamos si el usuario `isAllowed` usando la combinación `rol` - `controlador` - `acción`. En caso afirmativo, el método terminará el proceso.

Si no tenemos acceso, entonces el método devolverá `false` parando la ejecución, justo después de reenviar al usuario a la página de inicio.

### ACL
En el ejemplo anterior hemos obtenido la ACL usando el método `$this->getAcl()`. Para construir la ACL necesitamos hacer lo siguiente:

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
Primero creamos un nuevo objeto `Phalcon\Acl\Adapter\Memory`. Aunque el acceso predeterminado es `DENY` todavía lo establecemos en nuestra lista usando `setDefaultAction()`. Después de eso, necesitamos configurar nuestros roles. Para INVO tenemos `guests` (usuarios que no han iniciado sesión) y `users`. Registramos esos roles usando `addRole` en la lista.

Ahora que los roles están definidos, necesitamos configurar los componentes para la lista. Los componentes ACL mapean a las áreas de nuestra aplicación (controlador/acción). Al hacerlo, podemos controlar qué rol puede acceder a qué componente.

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
Como hemos visto arriba, primero registramos las áreas privadas de nuestra aplicación (*backend*) y luego las públicas (*frontend*). Los vectores creados tienen la clave como nombre del controlador mientras que los valores son las acciones correspondientes. Hacemos lo mismo con los componentes públicos.

Ahora que los roles y componentes están registrados, necesitamos enlazarlos para que la ACL esté completa. El rol `Users` tiene acceso a los componentes públicos (*frontend*) y privados (*backend*), mientras que `Guests` sólo tiene acceso a los componentes públicos (*frontend*).

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
La porción de *backend* de una aplicación es el código que proporciona formularios y lógica, permitiendo a los usuarios manipular datos, es decir, realizar operaciones CRUD. Exploraremos cómo INVO gestiona esta tarea y también mostraremos el uso de formularios, validadores, paginadores y más.

We have a simple [CRUD][crud] (Create, Read, Update and Delete) implementation in INVO, to manipulate data (companies, products, types of products). Para los productos se usan los siguientes ficheros:


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
Para otras áreas (como compañías por ejemplo), los ficheros correspondientes (prefijados con `Company`) se pueden encontrar en los mismos directorios que los mostrados arriba.

Cada controlador tiene las siguientes acciones:

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

| Acción         | Descripción                                                                                                |
| -------------- | ---------------------------------------------------------------------------------------------------------- |
| `createAction` | Crea un producto basado en los datos introducidos en la acción `new`                                       |
| `deleteAction` | Elimina un producto existente                                                                              |
| `editAction`   | Muestra la vista para `editar` un producto existente                                                       |
| `indexAction`  | La acción inicial, muestra la vista `search`                                                               |
| `newAction`    | Muestra la vista para crear un producto `nuevo`                                                            |
| `saveAction`   | Actualiza un producto basado en los datos introducidos en la acción `edit`                                 |
| `searchAction` | Ejecuta `search` basado en los criterios enviados desde `index`. Devuelve un paginador para los resultados |

## Formulario de Búsqueda
Nuestras operaciones CRUD empiezan con el formulario de búsqueda. Este formulario muestra cada campo que tiene la tabla (`products`), permitiendo al usuario introducir los criterios de búsqueda para cada campo. La tabla `products` tiene una relación con la tabla `products_types`. En este caso, previamente hemos consultado los registros de la tabla `product_types` para ofrecer criterios de búsqueda para este campo:

```php
<?php

public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```
An instance of the `ProductsForm` form (`src/Forms/ProductsForm.php`) is passed to the view. Este formulario define los campos que son visibles para el usuario:

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

El formulario se declara usando un esquema orientado a objetos basado en los elementos proporcionados por el componente [Phalcon\Forms\Form](forms). Cada elemento definido sigue caso la misma configuración:

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
Primero creamos el elemento. Luego le adjuntamos una etiqueta, adjuntamos filtros, para poder realizar el saneado de los datos. Following that we apply a validators on the element and finally add the element to the form.

Se usan también otros elementos en este formulario:

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
En el fragmento de código anterior, añadimos un campo HTML oculto que contiene el `id` del producto, si es aplicable. También obtenemos todos los tipos de productos usando `ProductTypes::find()` y luego usamos ese conjunto de resultados para rellenar el elemento HTML `select` usando el componente [Phalcon\Tag](tag) y su método `select()`. Una vez que el formulario se pasa a la vista, se puede renderizar y mostrar al usuario:

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

Esto produce el siguiente HTML:

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

Cuando se envía el formulario, se ejecuta la acción `search` en el controlador realizando la búsqueda basada en los datos introducidos por el usuario.

## Búsqueda
La acción `search` tiene dos operaciones. Cuando accede usando el método HTTP `POST`, realiza la búsqueda basada en los datos enviados desde el formulario. Cuando se accede usando el método HTTP `GET`, se mueve a la página actual en el paginador. Para comprobar qué método HTTP se ha usado, usamos el componente [Request](request):

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

Este método verifica qué valores son diferentes de '' (cadena vacía) y `null` y los tiene en cuenta para crear los criterios de búsqueda:

* If the field data type is `text` or similar (`char`, `varchar`, `text`, etc.) It uses an SQL `like` operator to filter the results.
* Si el tipo de datos no es `text` o similar, usará el operador `=`.

Además, `Criteria` ignora todas las variables `$_POST` que no coinciden con ningún campo de la tabla. Los valores se escapan automáticamente usando `parámetros vinculados`.

Ahora, almacenamos los parámetros producidos en la bolsa de sesión del controlador:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

Una bolsa de sesión, (propiedad `persistent`) es un atributo especial en un controlador que persiste los datos entre peticiones usando el servicio sesión. Cuando se accede, este atributo inyecta una instancia [Phalcon\Session\Bag](session#persistent-data) que depende de cada controlador.

Luego, basándonos en los parámetros construidos realizamos la consulta:

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

Si la búsqueda no devuelve ningún producto, redirigiremos al usuario a la acción `index` otra vez. Si la búsqueda devuelve resultados, los pasamos a un objeto paginador para que podamos navegar a través de fragmentos del conjunto de resultados:

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
El objeto [paginator](pagination) recibe los resultados obtenidos por la búsqueda. También establecemos un límite (resultados por página) así como el número de página. Finally, we call `paginate()` to get the appropriate chunk of the resultset back.

A continuación, pasamos la página devuelta a la vista:

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

Al mirar el código anterior, cabe mencionar:

Los elementos activos de la página actual se recorren usando un `for` de Volt. Volt proporciona una sintaxis más simple para un `foreach` de PHP.

```twig
{% raw %}
{% for product in page.items %}
{% endraw %}
```

Que en PHP es lo mismo que:

```php
<?php foreach ($page->items as $product) { ?>
```

El bloque `for` completo es:

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

- `1` - Ejecutado antes del primer producto en el bucle
- `2` - Ejecutado para cada producto de page.items
- `3` - Ejecutado después del último producto en el bucle
- `4` - Ejecutado si page.items no tiene ningún producto


Ahora puede volver a la vista y averiguar qué hace cada bloque. Cada campo de `product` se imprime respectivamente:

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

As we have seen before using `product.id` is the same as in PHP as doing: `$product->id`, we made the same with `product.name` and so on. Other fields are rendered differently, for instance, let's focus in `product.getProductTypes().name`. Para comprender esta parte, tenemos que comprobar el modelo *Products* (`app/models/Products.php`):

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

A model can have a method called `initialize()`, this method is called once per request, and it serves the ORM to initialize a model. En este caso, `Products` se inicializa definiendo que este modelo tiene una relación uno-a-muchos con otro modelo llamado `ProductTypes`.

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
Which means, the local attribute `product_types_id` in `Products` has a one-to-many relation to the `ProductTypes` model in its attribute `id`. Al definir esta relación, podemos acceder al nombre del tipo de producto usando:

```twig
{% raw %}
<td>{{ product.getProductTypes().name }}</td>
{% endraw %}
```

El campo `price` se imprime con su formato usando el filtro de Volt:

```twig
{% raw %}
<td>{{ '%.2f' | format(product.price) }}</td>
{% endraw %}
```

En PHP plano, esto sería:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

Imprimir si el producto está activo o no usa un método ayudante:

```php
{% raw %}
<td>{{ product.getActiveDetail() }}</td>
{% endraw %}
```

Este método se implementa en el modelo.

## Crear/Actualizar
Cuando creamos y actualizamos registros, usamos las vistas `new` y `edit`. The data entered by the user is sent to the `create` and `save` actions that perform actions of _creating_ and _updating_ products, respectively.

En la página de creación, obtenemos los datos enviados y los asignamos a una nueva instancia `Products`:

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
Como se ha visto anteriormente, cuando estábamos creando el formulario, había algunos filtros asignados a los elementos pertinentes. When the data is passed to the form, these filters are invoked, and they sanitize the supplied input. Aunque este filtrado es opcional, siempre es una buena práctica. Como añadido, el ORM también escapa los datos proporcionados y realiza una conversión de tipos adicional según los tipos de columna:

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

Llamar a `$form->isValid()` invoca todos los validadores establecidos en el formulario. Si no se pasa la validación, la variable `$messages` contendrá los mensajes relevantes de las validaciones fallidas.

Si no hay errores de validación, podemos guardar el registro:

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

Estamos comprobando los resultados del método `save()` en el modelo y si ocurren errores, estarán presentes en la variable `$messages` y el usuario será devuelto a la acción `products/new` con los mensajes de error mostrados. Si todo es OK, el formulario se limpiará y el usuario será redirigido a `products/inde` con el mensaje de éxito correspondiente.

En el caso de actualizar un producto, primero debemos obtener el registro correspondiente desde la base de datos y luego rellenar el formulario con los datos existentes:

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

Los datos encontrados se enlazan al formulario pasando el modelo como primer parámetro. Debido a esto, el usuario puede cambiar cualquier valor y luego enviarlo de vuelta a la base de datos a través de la acción `save`:

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

## Títulos Dinámicos
Cuando navega por la aplicación, verá que el título cambia dinámicamente indicando dónde estamos trabajando actualmente. Esto se consigue en cada controlador (método `initialize()`):

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

Tenga en cuenta, que también se llama al método `parent::initialize()`, que añade más datos al título:

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
El código anterior antepone el nombre de la aplicación al título

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
