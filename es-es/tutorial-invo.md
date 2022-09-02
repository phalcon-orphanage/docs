---
layout: default
language: 'es-es'
version: '4.0'
title: 'Tutorial - INVO'
keywords: 'tutorial, tutorial invo, paso a paso, mvc'
---

# Tutorial - INVO

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-intermediate.svg)

## Resumen

[INVO](https://github.com/phalcon/invo) es una aplicación pequeña que permite a los usuarios generar facturas, gestionar clientes y productos así como registro e inicio de sesión. Muestra como se gestionan ciertas tareas por Phalcon. En la parte del cliente, se usa [Bootstrap](https://getbootstrap.com) para el UI (Interfaz de Usuario). La aplicación no genera facturas reales, sino que sirve como ejemplo de cómo se implementan estas tareas usando Phalcon.

> **NOTA**: Se recomienda que abra la aplicación en su editor favorito para poder seguir este tutorial más fácilmente. 
{: .alert .alert-info }

> 
> **NOTA**: Tenga en cuenta que el código siguiente se ha formateado para aumentar la legibilidad
{: .alert .alert-warning }

## Estructura

Puede clonar el repositorio en su máquina (o descargarlo) desde [GitHub](https://github.com/phalcon/invo). Una vez clonado (o descargado y descomprimido) terminará con la siguiente estructura de directorios:

```bash
└── invo
    ├── app
    │   ├── config
    │   ├── controllers
    │   ├── forms
    │   ├── library
    │   ├── logs
    │   ├── models
    │   ├── plugins
    │   └── views
    ├── cache
    │   └── volt
    ├── docs
    │── public
    │   ├── css
    │   ├── img
    │   ├── index.php
    │   └── js
    └── schemas
```

Ya que Phalcon no impone una estructura de directorios en particular, la estructura particular es sólo nuestra implementación. Necesita configurar su servidor web con instrucciones de la página [configuración del servidor web](webserver-setup).

Una vez que la aplicación está configurada, puede abrirla en su navegador navegando a la siguiente URL `https://localhost/invo`. Verá una pantalla similar a la siguiente:

![](/assets/images/content/tutorial-invo-1.png)

La aplicación está dividida en dos partes: un *frontend* y un *backend*. El *frontend* es un área pública donde los visitantes pueden recibir información sobre INVO y solicitar información de contacto. El *backend* es un área administrativa donde los usuarios registrados pueden gestionar sus productos y clientes.

## Enrutamiento

INVO usa la ruta estándar que está integrada en el componente [Router](routing). Estas rutas coinciden con el siguiente patrón:

    /:controller/:action/:params
    

La ruta personalizada `/session/register` ejecuta el controlador `SessionController` y su acción `registerAction`.

## Configuración

INVO tiene un fichero de configuración que establece parámetros generales de la aplicación. Este fichero se localiza en `app/config/config.ini` y se carga en las líneas iniciales del arranque de la aplicación (`public/index.php`):

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

// ...

$config = new ConfigIni(
    APP_PATH . 'app/config/config.ini'
);

```

La [Configuración de Phalcon](config) nos permite manipular el fichero de una forma orientada a objetos. En este ejemplo, estamos usando un fichero `ini` para la configuración. El objeto [Phalcon\Config](config) tiene un adaptador adicional que carga ficheros de configuración de diferentes fuentes. El fichero de configuración tiene los siguientes ajustes:

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

Phalcon no tiene una convención para definir los ajustes. Las secciones nos ayudan a organizar las opciones basadas en grupos que tienen sentido para nuestra aplicación. En nuestro fichero hay dos cuestiones que se usarán más tarde en: `application` y `database`.

## Autocargador

La segunda parte que aparece en el fichero de arranque (`public/index.php`) es el autocargador:

```php
<?php

require APP_PATH . 'app/config/loader.php';
```

El autocargador registra un conjunto de directorios, en los cuales, la aplicación buscará las clases que necesitamos.

```php
<?php

$loader = new Phalcon\Loader();
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

> **NOTA**: El código anterior ha registrado los directorios que fueron definidos en el fichero de configuración. El único directorio que no se ha registrado es `viewsDir` porque contiene ficheros HTML + PHP pero sin clases. 
{: .alert .alert-info }

> 
> **NOTA**: Usamos una constante llamada `APP_PATH`. Esta constante se define en el arranque (`public/index.php`) para permitirnos tener una referencia a la raíz de nuestro proyecto:
{: .alert .alert-info }

```php
<?php

// ...

define('APP_PATH', realpath('..') . '/');
```

## Servicios

Otro fichero requerido en el arranque es (`app/config/services.php`). Este fichero nos permite organizar los servicios que usa INVO y los registra en el contenedor DI.

```php
<?php

require APP_PATH . 'app/config/services.php';
```

Para el registro de servicios, usamos clausuras para cargar perezosamente los componentes requeridos:

```php
<?php

use Phalcon\Url;

$container->set(
    'url',
    function () use ($config) {
        $url = new Url();

        $url->setBaseUri(
            $config->application->baseUri
        );

        return $url;
    }
);
```

## Gestión de Petición

Si saltamos al final del fichero (`public/index.php`), la petición se gestiona finalmente por [Phalcon\Mvc\Application](application), que inicializa todos los servicios necesarios para ejecutar la aplicación.

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($container);

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

$response->send();
```

## Inyección de Dependencias

En la primera línea del bloque de código anterior, el constructor de la clase [Application](application) recibe la variable `$container` como argumento.

Ya que Phalcon es altamente desacoplado, necesitamos el contenedor para ser capaces de acceder a los servicios registrados desde él en diferentes partes de la aplicación. El componente en cuestión es [Phalcon\Di](di). Es un contenedor de servicios, también permite realizar inyección de dependencias y localización de servicios, instanciando todos los componentes que se necesitan por la aplicación.

Hay muchas maneras disponibles para registrar servicios en el contenedor. En INVO, la mayoría de servicios se han registrado usando funciones anónimas/clausuras. Gracias a esto, los objetos se cargan perezosamente, reduciendo los recursos requeridos por la aplicación al mínimo.

Por ejemplo, en el siguiente fragmento se registra el servicio de sesión. La función anónima solo se llamará cuando la aplicación requiera el acceso a los datos de sesión:

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files   = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);

        $session->start();

        return $session;
    }
);
```

Aquí, tenemos la libertad de cambiar el adaptador, realizar una inicialización adicional y mucho más. Tenga en cuenta que el servicio se registró usando el nombre `session`. Es una convención que permitirá al framework identificar el servicio activo en el contenedor de servicios.

Una petición puede usar muchos servicios y registrar cada servicio individualmente puede ser una tarea engorrosa. Por esa razón, el framework proporciona una variante de [Phalcon\Di](di) llamada [Phalcon\Di\FactoryDefault](di#factory-default)`. Esta clase tiene servicios preregistrados para adaptarse a una aplicación MVC de pila completa.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

$container = new FactoryDefault();
```

Si es necesario sobrescribir algún servicio, podríamos configurarlo de nuevo como lo hicimos anteriormente con `session` o `url`. Esta es la razón de la existencia de la variable `$container`.

## Inicio de Sesión

Una página `de inicio de sesión` nos permitirá trabajar con los controladores del *backend*. La separación entre controladores del *backend* y los del *frontend* es arbitraria. Todos los controladores se localizan en el mismo directorio (`app/controllers/`).

![](/assets/images/content/tutorial-invo-2.png)

Para entrar al sistema, los usuarios deben tener un nombre de usuario y contraseña válidos. Los datos de usuario están almacenados en la tabla `users` en la base de datos `invo`.

Ahora necesitamos configurar la conexión a la base de datos. Está configurado un servicio llamado `db` en el contenedor de servicios con la información de conexión. Con el autocargador, otra vez tomamos parámetros desde el fichero de configuración para poder configurar el servicio:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// ...

$container->set(
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

Aquí, devolvemos una instancia del adaptador de conexión MySQL. También podemos añadir funcionalidad adicional, como añadir un <logger>, un [profiler](db-models-events#profiling-sql-statements) para medir tiempos de ejecución o incluso cambiar el adaptador a un RMBMS diferente.

El siguiente formulario simple (`app/views/session/index.volt`) produce el HTML necesario para que los usuarios puedan enviar la información de inicio de sesión. Parte del código HTML se ha eliminado para mejorar la legibilidad:

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

Estamos usando [Volt](volt) como nuestro motor de plantillas en lugar de PHP. Este es un motor de plantillas integrado inspirado en [Jinja](https://jinja.palletsprojects.com/en/2.10.x/) que proporciona una sintaxis simple y amigable con el usuario para crear plantillas. Si ha trabajado con [Jinja](https://jinja.palletsprojects.com/en/2.10.x/) o [Twig](https://twig.symfony.com/) en el pasado, verá muchas similitudes.

La función `SessionController::startAction` (`app/controllers/SessionController.php`) valida los datos enviados desde el formulario, y también comprueba que el usuario sea válido en la base datos:

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

    public function startAction()
    {
        if (true === $this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

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

            if (null !== $user) {
                $this->_registerSession($user);

                $this->flash->success(
                    'Welcome ' . $user->name
                );

                return $this->dispatcher->forward(
                    [
                        'controller' => 'invoices',
                        'action'     => 'index',
                    ]
                );
            }

            $this->flash->error(
                'Wrong email/password'
            );
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }
}
```

En la primera inspección del código, observará que se accede a varias propiedades públicas en el controlador, como `$this->flash`, `$this->request` o `$this->session`. Los [controladores](controllers) en Phalcon se vinculan automáticamente al contenedor [Phalcon\Di](di) y como resultado, todos los servicios registrados están presentes en cada controlador como propiedades con el mismo nombre que el nombre de cada servicio. Si el servicio se accede por primera vez, será automáticamente instanciado y devuelto a la persona que lo invoca. Adicionalmente, estos servicios se establecen como *compartidos* para que se devuelva la misma instancia, no importa cuantas veces accedamos a la propiedad/servicio en la misma petición. Hay servicios definidos en el contenedor de servicios desde antes (`app/config/services.php`) y, por supuesto, puede cambiar este comportamiento al configurar estos servicios.

Por ejemplo, aquí invocamos el servicio `session` y luego almacenamos la identidad del usuario en la variable `auth`:

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

> **NOTA**: Para más información sobre servicios Di, consulte el documento [Inyección de Dependencias](di).
{: .alert .alert-info }

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

> **NOTA**: Tenga en cuenta, el uso de 'parámetros vinculados', marcadores de posición `:email:` y `:password:` se colocan donde deberían estar los valores, luego los valores se *enlazan* usando el parámetro `bind`. Esto reemplaza con seguridad los valores para esas columnas sin correr el riesgo de una inyección SQL.

Cuando buscamos al usuario en la base de datos, no estamos buscando la contraseña directamente usando texto plano. La aplicación almacena contraseñas como *hashes*, usando el método [sha1](https://php.net/manual/en/function.sha1.php). Aunque esta metodología es adecuada para un tutorial, podría considerar usar un algoritmo diferente para una aplicación en producción. El componente [Phalcon\Security](security) ofrece métodos apropiados para reforzar el algoritmo usado para sus *hashes*.

Si se encuentra el usuario, entonces registramos el usuario en la sesión (el usuario inicia sesión) y lo reenviamos al panel de control (controlador `Invoices`, acción `index`) mostrando un mensaje de bienvenida.

```php
<?php

if (null !== $user) {
    $this->_registerSession($user);

    $this->flash->success(
        'Welcome ' . $user->name
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'invoices',
            'action'     => 'index',
        ]
    );
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

El *backend* es un área privada donde sólo tienen acceso los usuarios registrados. Por lo tanto, hay que comprobar que sólo los usuarios registrados tienen acceso a esos controladores. Si no ha iniciado sesión e intenta acceder a un área *privada* verá un mensaje similar al siguiente:

![](/assets/images/content/tutorial-invo-3.png)

Cada vez que un usuario intenta acceder a un controlador/acción, la aplicación verifica que el rol actual (almacenado en sesión) tiene acceso a él, de lo contrario mostrará un mensaje como el mostrado anteriormente y reenviará el flujo a la página de inicio.

Para poder lograr esto, necesitamos usar el componente [Despachador](dispatcher). Cuando el usuario solicita una página o URL, la aplicación primero identifica la página solicitada usando el componente [Enrutador](routing). Una vez que se ha identificado la ruta y encaja con un controlador y acción válidos, esta información se delega al [Despachador](dispatcher) que después carga el controlador y ejecuta la acción.

Normalmente, el framework crea el Despachador automáticamente. En nuestro caso, necesitamos verificar que el usuario se conecta antes de que se despache la ruta. Como tal, necesitamos reemplazar el componente predeterminado en el contenedor DI y establecer uno nuevo. Lo hacemos cuando iniciamos la aplicación:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...

$container->set(
    'dispatcher',
    function () {
        // ...

        $containerspatcher = new Dispatcher();

        return $containerspatcher;
    }
);
```

Ahora que el despachador está registrado, necesitamos aprovechar la ventaja de un *hook* disponible para interceptar el flujo de ejecución y ejecutar nuestras comprobaciones de verificación. Los *Hooks* se llaman *Eventos* en Phalcon y para poder acceder o habilitarlos, necesitamos registrar un componente [Gestor de Eventos](events) en nuestra aplicación para que pueda *disparar* esos eventos en nuestra aplicación.

Al crear un [Gestor de Eventos](events) y adjuntar código específico a los eventos del `despachador`, ahora tenemos mucha más flexibilidad y podemos adjuntar nuestro código al bucle u operación del despachador.

### Eventos

El [Gestor de Eventos](events) nos permite adjuntar oyentes a un tipo de evento particular. El tipo de evento al que nos adjuntamos es `dispatch`. El código siguiente adjunta oyentes a los eventos `beforeExecuteRoute` y `beforeException`. Usamos estos eventos para comprobar páginas 404 y también realizar comprobaciones de acceso permitido en nuestra aplicación.

```php
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        $eventsManager->attach(
            'dispatch:beforeException',
            new NotFoundPlugin()
        );

        $containerspatcher = new Dispatcher();

        $containerspatcher->setEventsManager($eventsManager);

        return $containerspatcher;
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

`SecurityPlugin` es una clase localizada en el directorio `plugins` (`app/plugins/SecurityPlugin.php`). Esta clase implementa el método `beforeExecuteRoute`. Este es el mismo nombre que el de los eventos producidos en el Despachador:

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

Los métodos de eventos siempre reciben el evento actual como primer parámetro. Este es un objeto [Phalcon\Events\Event](api/phalcon_events#events-event) que contendrá información sobre el evento como su tipo y otra información relacionada. Para este evento particular, el segundo parámetro será el objeto que ha producido el propio evento (`$containerspatcher`). No es obligatorio que las clases de plugins extiendan la clase [Phalcon\Di\Injectable](api/phalcon_di#di-injectable), pero al hacerlo ganan un acceso más fácil a los servicios disponibles en la aplicación.

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

        $controller = $containerspatcher->getControllerName();
        $action     = $containerspatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);
        if (true !== $allowed) {
            $this->flash->error(
                "You do not have access to this module"
            );

            $containerspatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            return false;
        }
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

$acl->setDefaultAction(
    Enum::DENY
);

$roles = [
    'users'  => new Role('Users'),
    'guests' => new Role('Guests'),
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

foreach ($roles as $role) {
    foreach ($publicComponents as $resource => $actions) {
        $acl->allow(
            $role->getName(),
            $resource,
            '*'
        );
    }
}

foreach ($privateComponents as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow(
            'Users',
            $resource,
            $action
        );
    }
}
```

## CRUD

La porción de *backend* de una aplicación es el código que proporciona formularios y lógica, permitiendo a los usuarios manipular datos, es decir, realizar operaciones CRUD. Exploraremos cómo INVO gestiona esta tarea y también mostraremos el uso de formularios, validadores, paginadores y más.

Tenemos una implementación [CRUD](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete) (*Create*, *Read*, *Update* y *Delete*) simple en INVO, para manipular datos (empresas, productos y tipos de productos). Para los productos se usan los siguientes ficheros:

```bash
└── invo
    └── app
        ├── controllers
        │   └── ProductsController.php
        ├── forms
        │   └── ProductsForm.php
        ├── models
        │   └── Products.php
        └── views
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
    public function indexAction();

    public function searchAction();

    public function newAction();

    public function editAction();

    public function createAction();

    public function saveAction();

    public function deleteAction($id);
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

Se pasa a la vista una instancia del formulario `ProductsForm` (`app/forms/ProductsForm.php`). Este formulario define los campos que son visibles para el usuario:

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
                        'message' => 'Name is required',
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
                        'message' => 'Price is required',
                    ]
                ),
                new Numericality(
                    [
                        'message' => 'Price is required',
                    ]
                ),
            ]
        );
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

Primero creamos el elemento. Luego le adjuntamos una etiqueta, adjuntamos filtros, para poder realizar el saneado de los datos. A continuación, aplicamos los validadores sobre el elemento y finalmente añadimos el elemento al formulario.

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

Esto produce el siguiente HTML:

```html
<form action='/invo/products/search' method='post'>

    <h2>
        Search products
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

Con la ayuda de [Phalcon\Mvc\Model\Criteria](api/phalcon_mvc#mvc-model-criteria), podemos crear las condiciones de búsqueda basadas en el tipo de datos y valores enviados desde el formulario:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

Este método verifica qué valores son diferentes de '' (cadena vacía) y `null` y los tiene en cuenta para crear los criterios de búsqueda:

- Si el tipo de datos del campo es `text` o similar (`char`, `varchar`, `text`, etc.) Usa un operador SQL `like` para filtrar los resultados.
- Si el tipo de datos no es `text` o similar, usará el operador `=`.

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

El objeto [paginator](pagination) recibe los resultados obtenidos por la búsqueda. También establecemos un límite (resultados por página) así como el número de página. Finalmente, llamamos `paginate()` para obtener de vuelta el fragmento del conjunto de resultados correspondiente.

A continuación, pasamos la página devuelta a la vista:

```php
<?php

$this->view->page = $page;
```

En la vista (`app/views/products/search.volt`), recorremos los resultados correspondientes a la vista actual, mostrando cada fila de la página actual al usuario:

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
                            {{ 
                                link_to(
                                    'products/search', 
                                    'First'
                                ) 
                            }}
                            {{ 
                                link_to(
                                    'products/search?page=' ~ page.previous, 
                                    'Previous'
                                ) 
                            }}
                            {{ 
                                link_to(
                                    'products/search?page=' ~ page.next, 
                                    'Next'
                                ) 
                            }}
                            {{ 
                                link_to(
                                    'products/search?page=' ~ page.last, 
                                    'Last'
                                ) 
                            }}
                            <span class='help-inline'>
                                {{ page.current }} of 
                                {{ page.total_pages }}
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

Como hemos visto antes, usar `product.id` es lo mismo que en PHP haciendo: `$product->id`, hemos hecho lo mismo con `product.name` y así sucesivamente. Otros campos se renderizan de forma diferente, por ejemplo, prestemos atención a `product.productTypes.name`. Para comprender esta parte, tenemos que comprobar el modelo *Products* (`app/models/Products.php`):

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

Un modelo puede tener un método llamado `initialize()`, este método se llama una vez por petición y sirve al ORM para inicializar un modelo. En este caso, `Products` se inicializa definiendo que este modelo tiene una relación uno-a-muchos con otro modelo llamado `ProductTypes`.

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

Lo que significa, el atributo local `product_types_id` en `Products` tiene una relación uno-a-muchos con el modelo `ProductTypes` en su atributo `id`. Al definir esta relación, podemos acceder al nombre del tipo de producto usando:

```twig
{% raw %}
<td>{{ product.productTypes.name }}</td>
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

Cuando creamos y actualizamos registros, usamos las vistas `new` y `edit`. Los datos introducidos por el usuario se envían a las acciones `create` y `save` que realizan las acciones de *crear* y *actualizar* productos, respectivamente.

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

Como se ha visto anteriormente, cuando estábamos creando el formulario, había algunos filtros asignados a los elementos pertinentes. Cuando los datos se pasan al formulario, se invocan estos filtros que sanean la entrada proporcionada. Aunque este filtrado es opcional, siempre es una buena práctica. Como añadido, el ORM también escapa los datos proporcionados y realiza una conversión de tipos adicional según los tipos de columna:

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

Al guardar los datos, sabremos si las reglas de negocio y los validadores implementados en `ProductsForm` se superan (`app/forms/ProductsForm.php`):

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

## Componentes

La UI (Interfaz de Usuario) se ha creado con la librería [Bootstrap](https://getbootstrap.com). Algunos elementos, como la barra de navegación cambia según el estado de la aplicación. Por ejemplo, en la esquina superior derecha, el enlace `Log in / Sign Up` cambia a `Log out` si un usuario ha iniciado sesión en la aplicación.

Esta parte de la aplicación se implementa en el componente `Elements` (`app/library/Elements.php`).

```php
<?php

use Phalcon\Di\Injectable;

class Elements extends Injectable
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

Esta clase extiende [Phalcon\Di\Injectable](api/phalcon_di#di-injectable). No es necesario hacerlo, pero extender este componente nos permite acceder a todos los servicios de la aplicación. Vamos a registrar este componente de usuario en el contenedor de servicios:

```php
<?php

$container->set(
    'elements',
    function () {
        return new Elements();
    }
);
```

Ya que este componente esta registrado en el contenedor DI, podemos acceder a él directamente en la vista, usando una propiedad con el mismo nombre que el usado para registrar el servicio:

```twig
{% raw %}
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
        <div class='container'>
            <a class='btn btn-navbar' 
               data-toggle='collapse' 
               data-target='.nav-collapse'>
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
        <p>&copy; Company {{ date('Y') }}</p>
    </footer>
</div>
{% endraw %}
```

La parte importante es:

```twig
{% raw %}
{{ elements.getMenu() }}
{% endraw %}
```

## Títulos Dinámicos

Cuando navega por la aplicación, verá que el título cambia dinámicamente indicando dónde estamos trabajando actualmente. Esto se consigue en cada controlador (método `initialize()`):

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle(
            'Manage your product types'
        );

        parent::initialize();
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
        $this->tag->prependTitle('INVO | ');
    }

    // ...
}
```

El código anterior antepone el nombre de la aplicación al título

Finalmente, el título se prime en la vista principal (`app/views/index.volt`):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```
