<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Tutorial: INVO</a> <ul>
        <li>
          <a href="#structure">Estructura del proyecto</a>
        </li>
        <li>
          <a href="#routing">Enrutamiento</a>
        </li>
        <li>
          <a href="#configuration">Configuración</a>
        </li>
        <li>
          <a href="#autoloaders">Cargadores automáticos</a>
        </li>
        <li>
          <a href="#services">Registro de servicios</a>
        </li>
        <li>
          <a href="#handling-requests">Gestionando la solicitud</a>
        </li>
        <li>
          <a href="#dependency-injection">Inyección de Dependencias</a>
        </li>
        <li>
          <a href="#log-in">Inicie sesión en la aplicación</a>
        </li>
        <li>
          <a href="#securing-backend">Asegurando el backend</a> <ul>
            <li>
              <a href="#events-manager">Gestión de Eventos</a>
            </li>
            <li>
              <a href="#acl">Obteniendo la lista ACL</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#working-with-crud">Trabajando con el CRUD</a>
        </li>
        <li>
          <a href="#search-form">Formulario de búsqueda</a>
        </li>
        <li>
          <a href="#performing-searches">Realizando una búsqueda</a>
        </li>
        <li>
          <a href="#creating-updating-records">Creación y actualización de registros</a>
        </li>
        <li>
          <a href="#user-components">Componentes de usuario</a>
        </li>
        <li>
          <a href="#dynamic-titles">Cambiando dinámicamente el título</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Tutorial: INVO

En este segundo tutorial vamos a explicar una aplicación más completa para obtener un conocimiento más profundo del desarrollo con Phalcon. INVO es una de las aplicaciones de ejemplo que hemos creado. INVO es un pequeño sitio web que permite a los usuarios generar facturas y hacer otras tareas como gestión de clientes y productos. Puede clonar su código desde [Github](https://github.com/phalcon/invo).

INVO fue hecha con el framework [Bootstrap](http://getbootstrap.com/) del lado del cliente. Aunque la aplicación no genera facturas reales, nos sirve como un ejemplo para mostrar cómo funciona el framework.

<a name='structure'></a>

## Estructura del proyecto

Una vez clonado el proyecto en la raíz de tu documento, podrá ver la siguiente estructura:

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

Como usted sabe, Phalcon no impone una estructura de archivos en particular para el desarrollo de aplicaciones. Este proyecto tiene una estructura simple de MVC y una raíz de documento público.

Una vez que usted abra la aplicación en su navegador `http://localhost/invo` verás algo como esto:

![](/images/content/tutorial-invo-1.png)

La aplicación se divide en dos partes: un frontend y un backend. El frontend es un espacio público donde los visitantes pueden recibir información acerca de INVO y solicitar información de contacto. El backend es un área administrativa donde los usuarios registrados pueden gestionar sus productos y clientes.

<a name='routing'></a>

## Enrutamiento

INVO utiliza la ruta estándar que es integrada con el componente [Router](/[[language]]/[[version]]/routing). Estas rutas coinciden con el siguiente patrón: `/:controlador/:acción/:params`. Esto significa que la primera parte de un URI es el controlador, el segundo que la acción del controlador y el resto son los parámetros.

La ruta siguiente `/session/register` ejecuta el controlador `SessionController` y su acción `registerAction`.

<a name='configuration'></a>

## Configuración

INVO tiene un archivo de configuración que establece los parámetros generales en la aplicación. Este archivo se encuentra en `app/config/config.ini` y se carga en las primeras líneas del arranque de la aplicación (`public/index.php`):

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

// ...

// Leer la configuración
$config = new ConfigIni(
    APP_PATH . 'app/config/config.ini'
);

```

[La configuración de Phalcon](/[[language]]/[[version]]/config) (`Phalcon\Config`) nos permite manipular el archivo de una manera orientada a objetos. En este ejemplo, estamos utilizando un archivo ini para la configuración pero Phalcon tiene [adaptadores](/[[language]]/[[version]]/config) para otros tipos de archivos. El archivo de configuración contiene las siguientes opciones:

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

Phalcon no tiene ningún convenio de ajustes predefinidos. Las secciones nos ayudan a organizar las opciones según sea el caso. En este archivo hay dos secciones para utilizar más adelante: `application` y `database`.

<a name='autoloaders'></a>

## Cargadores automáticos

La segunda parte que aparece en el archivo bootstrap (`public/index.php`) es el auto cargador:

```php
<?php

/**
 * Configuración del Auto cargador
 */
require APP_PATH . 'app/config/loader.php';
```

El cargador automático registra un conjunto de directorios en los que la aplicación buscará las clases que eventualmente serían necesarias.

```php
<?php

$loader = new Phalcon\Loader();

// Registramos un conjunto de directorios tomados desde el archivo de configuración
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

Tenga en cuenta que el código anterior ha registrado los directorios definidos en el archivo de configuración. El único directorio que no está registrado es el viewsDir ya que contiene archivos HTML + PHP pero no hay clases. También, observe que utilizamos una constante llamada APP_PATH. Esta constante está definida en el bootstrap (`public/index.php`) que nos permiten tener una referencia a la raíz de nuestro proyecto:

```php
<?php

// ...

define(
    'APP_PATH',
    realpath('..') . '/'
);
```

<a name='services'></a>

## Registro de servicios

Otro archivo que se requiere en el bootstrap es (`app/config/services.php`). Este archivo nos permite organizar los servicios que utiliza INVO.

```php
<?php

/**
 * Cargar servicios de la aplicación
 */
require APP_PATH . 'app/config/services.php';
```

El registro de servicios se logra con clausulas para la carga perezosa de los componentes necesarios:

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

/**
 * El componente URL es utilizado para generar todas las URL's en la aplicación
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

Hablaremos de este archivo en profundidad más adelante.

<a name='handling-requests'></a>

## Gestionando la solicitud

Si nos saltamos al final del archivo (`public/index.php`), la solicitud finalmente es manejada por `Phalcon\Mvc\Application` que inicializa y ejecuta todo lo necesario para hacer correr la aplicación:

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);

$response = $application->handle();

$response->send();
```

<a name='dependency-injection'></a>

## Inyección de Dependencias

En la primera línea del bloque de código anterior, el constructor de la clase de aplicación recibe la variable `$di` como argumento. ¿Cuál es el propósito de esa variable? Phalcon es un framework muy desacoplado por lo que necesitamos un componente que actúe como pegamento para que todo funcione en conjunto. Ese componente es `Phalcon\Di`. Es un contenedor de servicios que también realiza la inyección de dependencias y la localización de servicios, instanciando todos los componentes que son necesarios para la aplicación.

Hay muchas maneras de registrar servicios en el contenedor. En INVO, la mayoría de los servicios se han registrado mediante funciones anónimas. Gracias a esto, se crean instancias de los objetos de una manera perezosa, reduciendo los recursos necesarios para la aplicación.

Por ejemplo, en el siguiente fragmento el servicio de sesión es registrado. Sólo se llamará a la función anónima cuando la aplicación requiere acceso a los datos de sesión:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// ...

// Iniciar la sesión la primera vez que un componente solicite el servicio de sesión
$di->set(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

Aquí, tenemos la libertad para cambiar el adaptador, realizar una inicialización adicional y mucho más. Tenga en cuenta que el servicio se registró con el nombre de `session`. Se trata de un convenio que permitirá al framework identificar el servicio activo en el contenedor de servicios.

Una solicitud puede utilizar muchos servicios y registrar individualmente cada servicio puede ser una tarea engorrosa. Por esa razón, el framework ofrece una variante de `Phalcon\Di` llamada `Phalcon\Di\FactoryDefault`, cuya tarea es registrar todos los servicios proporcionados por el framework.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// El inyector de dependencias FactoryDefault automáticamente registra
// todos los servicios provistos por el framework
$di = new FactoryDefault();
```

Registra la mayoría de los servicios con componentes proporcionados por defecto por el framework como estándar. Si necesitamos reemplazar la definición de algún servicio podríamos definirlo otra vez como los hicimos anteriormente con `session` o `url`. Esta es la razón de la existencia de la variable `$di`.

<a name='log-in'></a>

## Inicie sesión en la aplicación

Un `inicio de sesión` nos permitirá trabajar en los controladores del backend. La separación entre controladores de backend y frontend es solo por lógica. Todos los controladores se encuentran en el mismo directorio (`app/controladores/`).

Para entrar en el sistema, los usuarios deben tener un nombre de usuario válido y una contraseña. Los usuarios se almacenan en la tabla `users` en la base de datos `invo`.

Antes de que podamos iniciar una sesión, tenemos que configurar la conexión a la base de datos en la aplicación. Un servicio llamado `db` está configurado en el contenedor de servicios con la información de conexión. Con el autocargador, estamos otra vez tomando parámetros del archivo de configuración para configurar un servicio:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// ...

// La conexión a la base de datos es creada basada en los
// parámetros de configuración del archivo de configuración
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

Aquí, nos devuelve una instancia del adaptador de conexión MySQL. Si es necesario, puedes realizar acciones adicionales como la adición de un registrador, un perfilador o cambiar el adaptador, configurándolos como desees.

El siguiente formulario (`app/views/session/index.volt`) solicita la información de inicio de sesión. Hemos quitado algo de código HTML para hacer el ejemplo más conciso:

```twig
{{ form('session/start') }}
    <fieldset>
        <div>
            <label for='email'>
                Nombre de usuario / Email
            </label>

            <div>
                {{ text_field('email') }}
            </div>
        </div>

        <div>
            <label for='password'>
                Contraseña
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
```

En lugar de utilizar PHP crudo como en el anterior tutorial, empezamos a usar [Volt](/[[language]]/[[version]]/volt). Se trata de un motor incorporado inspirado en Jinja, el cual proporciona una sintaxis más simple y amigable para crear plantillas. No tomará mucho tiempo antes que te familiarices con volt.

La función `SessionController::startAction` (`app/controllers/SessionController.php`) tiene la tarea de validar los datos introducidos en el formulario, incluyendo la comprobación de un usuario válido en la base de datos:

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
     * Esta acción autentica y registra a un usuario dentro de la aplicación
     */
    public function startAction()
    {
        if ($this->request->isPost()) {
            // Obtener datos desde el usuario
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Buscar el usuario en la base de datos
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
                    'Bienvenido ' . $user->name
                );

                // Enviar al controlador 'invoices' si el usuario es válido
                return $this->dispatcher->forward(
                    [
                        'controller' => 'invoices',
                        'action'     => 'index',
                    ]
                );
            }

            $this->flash->error(
                'Email/Contraseña incorrectos'
            );
        }

        // Enviar al formulario de inicio de sesión nuevamente
        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }
}
```

Por simplicidad, hemos utilizado [sha1](http://php.net/manual/en/function.sha1.php) para almacenar el hash de las contraseñas en la base de datos, sin embargo, este algoritmo no se recomienda en aplicaciones reales, usar [bcrypt](/[[language]]/[[version]]/security) en su lugar.

Tenga en cuenta que varios atributos públicos son accedidos en el controlador como: `$this->flash`, `$this->request` o `$this->session`. Estos son los servicios definidos en el contenedor de servicios, como vimos anteriormente (`app/config/services.php`). Cuando se acceden por primera vez, ellos se inyectan como parte del controlador. Estos servicios son `compartidos`, lo que significa que siempre estamos accediendo a la misma instancia independientemente del lugar donde se les invocan. Por ejemplo, aquí se invoca el servicio `session` y luego guardamos la identidad del usuario en la variable `auth`:

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

Otro aspecto importante de esta sección es cómo el usuario se valida como válido, primero validamos si la solicitud se ha hecho usando el método `POST`:

```php
<?php

if ($this->request->isPost()) {
    // ...
}
```

Después, recibimos los parámetros desde el formulario:

```php
<?php

$email    = $this->request->getPost('email');
$password = $this->request->getPost('password');
```

Ahora, tenemos que comprobar si hay un usuario con el mismo nombre de usuario o correo electrónico y contraseña:

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

Tenga en cuenta, el uso de 'parámetros enlazados', los marcadores `:email:` y `:password:` se colocan donde los valores deben estar, entonces se 'enlazan' los valores usando el parámetro `bind`. Esto reemplaza de manera segura los valores de esas columnas sin tener el riesgo de una inyección SQL.

Si el usuario es válido, registrarlo en la sesión y enviarlo al panel principal:

```php
<?php

if ($user !== false) {
    $this->_registerSession($user);

    $this->flash->success(
        'Bienvenido ' . $user->name
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'invoices',
            'action'     => 'index',
        ]
    );
}
```

Si el usuario no existe, lo enviamos nuevamente a la acción donde se muestra el formulario:

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

## Asegurando el backend

El backend es un área privada donde sólo los usuarios registrados tienen acceso. Por lo tanto, es necesario comprobar que sólo los usuarios registrados tienen acceso a estos controladores. Si usted no ha iniciado sesión en la aplicación y trata de acceder, por ejemplo, al controlador de productos (que es privado), verá una pantalla como esta:

![](/images/content/tutorial-invo-2.png)

Cada vez que alguien intenta acceder a cualquier controlador y acción, la aplicación verifica que el rol actual (en sesión) tenga acceso a ellos, de lo contrario muestra un mensaje como el de arriba y remite el flujo a la página principal.

Ahora vamos a averiguar cómo la aplicación logra esto. Lo primero a saber es que hay un componente llamado [Dispatcher](/[[language]]/[[version]]/dispatcher). Se informa sobre la ruta encontrada por el componente de [Ruteo](/[[language]]/[[version]]/routing). Entonces, es el responsable de cargar el controlador adecuado y ejecutar el método correspondiente de la acción.

Normalmente, el framework crea automáticamente el despachador. En nuestro caso, queremos realizar una verificación antes de ejecutar la acción requerida, comprobando si el usuario tiene acceso a ella o no. Para lograr esto, hemos sustituido el componente mediante la creación de una función en el sistema de arranque:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...

/**
 * Despachador MVC
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

Ahora tenemos control total sobre el despachador utilizado en la aplicación. Muchos componentes en el framework desencadenan eventos que nos permiten modificar su flujo interno de operación. Como el componente Inyector de dependencias actúa como pegamento para los componentes, un nuevo componente llamado [EventsManager](/[[language]]/[[version]]/events) nos permite interceptar los eventos producidos por un componente, enrutando los eventos a los oyentes.

<a name='events-manager'></a>

### Gestión de Eventos

El [EventsManager](/[[language]]/[[version]]/events) o gestor de eventos, permite adjuntar oyentes a un tipo particular de evento. El tipo que nos interesa ahora es 'dispatch'. El siguiente código filtra todos los eventos producidos por el despachador:

```php
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Crear un gestor de eventos
        $eventsManager = new EventsManager();

        // Oír los eventos producidos por el despachador utizando el plugin Security
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        // Gestionar excepciones y no encontrados "not-found" utilizando el plugin NotFoundPlugin
        $eventsManager->attach(
            'dispatch:beforeException',
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();

        // Agregar los eventos del gestor del despachador
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

Cuando se desencadena un evento denominado `beforeExecuteRoute` se notificará al siguiente plugin:

```php
<?php

/**
 * Comprobar si el usuario tiene acceso permitido a una determinada acción utilizando el plugin SecurityPlugin
 */
$eventsManager->attach(
    'dispatch:beforeExecuteRoute',
    new SecurityPlugin()
);
```

Cuando se dispara un `beforeException`, otro plugin es notificado:

```php
<?php

/**
 * Gestionar excepciones y no encontrados "not-found" utilizando el plugin NotFoundPlugin
 */
$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

El plugin SecurityPlugin es una clase que se encuentra en (`app/plugins/SecurityPlugin.php`). Esta clase implementa el método `beforeExecuteRoute`. Este es el mismo nombre que uno de los eventos producidos en el despachador:

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

Los eventos enganchados siempre reciben un primer parámetro que contiene información contextual del evento producido (`$event`) y un segundo que es el objeto que produjo el evento en sí (`$dispatcher`). No es obligatorio que los plugins extiendan de la clase `Phalcon\Mvc\User\Plugin`, pero al hacerlo, obtienen un acceso más fácil a los servicios disponibles en la aplicación.

Ahora, estamos verificando el rol en la sesión actual, verificando si el usuario tiene acceso utilizando la lista ACL. Si el usuario no tiene acceso nos redireccionara a la pantalla de inicio como se ha explicado antes:

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
        // Compruebe si la variable 'auth' existe en sesión para definir el rol activo
        $auth = $this->session->get('auth');

        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // Tomar el controlador/acción activos desde el despachador
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // Obtener la lista ACL
        $acl = $this->getAcl();

        // Comprobar si el rol tiene acceso al controlador (recurso)
        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            // Si no tiene acceso, redirigir al controlador Index
            $this->flash->error(
                "Ud. no tiene acceso a este módulo"
            );

            $dispatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            // Regresando 'false' le decimos al despachador que detenga la acción actual
            return false;
        }
    }
}
```

<a name='acl'></a>

### Obteniendo la lista ACL

En el ejemplo anterior hemos obtenido una ACL mediante el método `$this->getAcl()`. Este método también se implementa en el Plugin. Ahora vamos a explicar paso a paso cómo construimos la lista de control de acceso (ACL):

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;

// Crear la ACL
$acl = new AclList();

// La acción de acceso por defecto es DENY (denegar)
$acl->setDefaultAction(
    Acl::DENY
);

// Registrar dos roles, Users es para los usuarios registrados
// y guests (invitados) son usuarios sin una identidad definida
$roles = [
    'users'  => new Role('Users'),
    'guests' => new Role('Guests'),
];

foreach ($roles as $role) {
    $acl->addRole($role);
}
```

Ahora, definimos los recursos para cada área respectivamente. Los nombres de los controladores son los recursos y sus acciones son los accesos a los recursos:

```php
<?php

use Phalcon\Acl\Resource;

// ...

// Recursos del área privada (backend)
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

// Recursos del área pública (frontend)
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

La ACL ahora sabe acerca de los controladores existentes y sus acciones relacionadas. El rol `Users` tiene acceso a todos los recursos del frontend y backend. El rol `Guests` sólo tiene acceso a la zona pública:

```php
<?php

// Permitir acceso a áreas públicas para ambos roles
foreach ($roles as $role) {
    foreach ($publicResources as $resource => $actions) {
        $acl->allow(
            $role->getName(),
            $resource,
            '*'
        );
    }
}

// Permitir acceso al área privada solo para el rol Users
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

## Trabajando con el CRUD

Los Backends generalmente proporcionan formularios para permitir a los usuarios manipular los datos. Continuando con la explicación del INVO, abordamos ahora la creación de CRUDs, una tarea muy común que Phalcon facilitará a través de formularios, validaciones, paginadores y más.

La mayoría de las opciones que manipulan datos en INVO (empresas, productos y tipos de productos) se desarrollan usando un simple [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete) (Create, Read, Update y Delete) o en español Crear, Leer, Actualizar y Borrar. Cada CRUD contiene los siguientes archivos:

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

Cada controlador tiene las siguientes acciones:

```php
<?php

class ProductsController extends ControllerBase
{
    /**
     * Acción inicial, muestra la vista de busqueda
     */
    public function indexAction()
    {
        // ...
    }

    /**
     * Ejecuta la búsqueda basada en los criterios enviados desde el 'Index'
     * Retornando resultados paginados
     */
    public function searchAction()
    {
        // ...
    }

    /**
     * Muestra una vista para crear un nuevo producto
     */
    public function newAction()
    {
        // ...
    }

    /**
     * Muestra una vista para editar un producto existente
     */
    public function editAction()
    {
        // ...
    }

    /**
     * Crea un producto basado en los datos ingresados en la acción 'new'
     */
    public function createAction()
    {
        // ...
    }

    /**
     * Actualiza un producto basado en los datos ingresados en la acción 'edit'
     */
    public function saveAction()
    {
        // ...
    }

    /**
     * Elimina un producto existente
     */
    public function deleteAction($id)
    {
        // ...
    }
}
```

<a name='search-form'></a>

## Formulario de búsqueda

Cada CRUD comienza con un formulario de búsqueda. Este formulario muestra cada campo que tiene la tabla productos (products), lo que permite al usuario crear una búsqueda de criterios para cualquier campo. La tabla de `products` tiene una relación con la tabla `products_types`. En este caso, nos consulta previamente los registros de esta tabla con el fin de facilitar la búsqueda de ese campo:

```php
<?php

/**
 * La acción inicial, muestra la vista de búsqueda
 */
public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```

Una instancia del formulario `ProductsForm` (`app/forms/ProductsForm.php`) se pasa a la vista. Este formulario define los campos que son visibles para el usuario:

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
     * Inicializar formulario de productos
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
        $name->setLabel('Nombre');
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
                        'message' => 'El nombre es requerido',
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
        $price->setLabel('Precio');
        $price->setFilters(
            [
                'float',
            ]
        );
        $price->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'El precio es requerido',
                    ]
                ),
                new Numericality(
                    [
                        'message' => 'El precio debe ser un número',
                    ]
                ),
            ]
        );
        $this->add($price);
    }
}
```

El formulario se declara mediante un esquema orientado a objetos basado en los elementos proporcionados por el componente [forms](/[[language]]/[[version]]/forms). Cada elemento sigue casi la misma estructura:

```php
<?php

// Crear el elemento
$name = new Text('name');

// Configurar una etiqueta
$name->setLabel('Nombre');

// Antes de validar el elemento aplicar estos filtros
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// Aplicar estos validadores
$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'El nombre es requerido',
            ]
        )
    ]
);

// Agregar el elemento al formulario
$this->add($name);
```

Otros elementos también se utilizan en este formulario:

```php
<?php

// Agregar un input oculto al formulario
$this->add(
    new Hidden('id')
);

// ...

$productTypes = ProductTypes::find();

// Agregar una lista (HTML Select) al formulario
// y completar los datos desde 'product_types'
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

Observe que `ProductTypes::find()` contiene los datos necesarios para completar la etiqueta SELECT usando `Phalcon\Tag::select()`. Una vez que el formulario se pasa a la vista, se puede procesar y presentar al usuario:

```twig
{{ form('products/search') }}

    <h2>
        Buscar productos
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
            {{ submit_button('Buscar', 'class': 'btn btn-primary') }}
        </div>

    </fieldset>

{{ endForm() }}
```

Esto produce el siguiente código HTML:

```html
<form action='/invo/products/search' method='post'>

    <h2>
        Buscar productos
    </h2>

    <fieldset>

        <div class='control-group'>
            <label for='id' class='control-label'>Id</label>

            <div class='controls'>
                <input type='text' id='id' name='id' />
            </div>
        </div>

        <div class='control-group'>
            <label for='name' class='control-label'>Nombre</label>

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
            <label for='price' class='control-label'>Precio</label>

            <div class='controls'>
                <input type='text' id='price' name='price' />
            </div>
        </div>

        <div class='control-group'>
            <input type='submit' value='Buscar' class='btn btn-primary' />
        </div>

    </fieldset>

</form>
```

Cuando se envía el formulario, se ejecuta en el controlador la acción `search` realizando la búsqueda basada en los datos introducidos por el usuario.

<a name='performing-searches'></a>

## Realizando una búsqueda

La acción `search` tiene dos comportamientos. Cuando se accede a través del método POST, realiza una búsqueda basada en los datos enviados desde el formulario pero cuando se accede a través de GET se mueve la página actual en el paginator. Para distinguir los métodos HTTP, utilizamos el componente [request](/[[language]]/[[version]]/request):

```php
<?php

/**
 * Ejecutar la busqueda basada en los criterios enviados desde el 'index'
 * Regresando un paginador para los resultados
 */
public function searchAction()
{
    if ($this->request->isPost()) {
        // Crear las condiciones de consulta
    } else {
        // Paginar utilizando las condiciones existentes
    }

    // ...
}
```

Con la ayuda de `Phalcon\Mvc\Model\Criteria`, podemos crear las condiciones de búsqueda de forma inteligente, basadas en los tipos de datos y los valores enviados desde el formulario:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

Este método comprueba que los valores son diferentes de `''` (cadena vacía) y `nulo`. Teniendo en cuenta para crear los criterios de búsqueda los siguientes puntos:

- Si el tipo de datos de campo es texto o similar (char, varchar, text, etcetera). Utiliza un operador `like` de SQL para filtrar los resultados.
- Si el tipo de datos no es texto o similar, usara el operador `=`.

Además, `Criteria` ignora todas las variables de `$_POST` que no corresponden a ningún campo de la tabla. Los valores se escapan automáticamente utilizando `parámetros enlazados`.

Ahora, guardamos los parámetros producidos en la bolsa de sesión del controlador:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

La bolsa de sesión, es un atributo especial en un controlador que persiste entre las solicitudes utilizando el servicio de sesión. Cuando se accede, este atributo inyecta una instancia de `Phalcon\Session\Bag` que es independiente en cada controlador.

Entonces, basado en los parámetros construidos, realizamos la consulta:

```php
<?php

$products = Products::find($parameters);

if (count($products) === 0) {
    $this->flash->notice(
        'La búsqueda no encontró ningún producto'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

Si la búsqueda no devuelve ningún producto, remitimos al usuario a la acción del índice otra vez. Supongamos que la búsqueda devuelve resultados, entonces creamos un paginator para navegar fácilmente a través de ellos:

```php
<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

// ...

$paginator = new Paginator(
    [
        'data'  => $products,   // Datos a paginar
        'limit' => 5,           // Filas por página
        'page'  => $numberPage, // Página activa o actual
    ]
);

// Obtener la página activa en el paginador
$page = $paginator->getPaginate();
```

Finalmente pasamos la página retornada a la vista:

```php
<?php

$this->view->page = $page;
```

En la vista (`app/views/products/search.volt`), recorremos los resultados correspondientes a la página actual, mostrando cada fila de la página actual al usuario:

```twig
{% for product in page.items %}
    {% if loop.first %}
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tipo de producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Activo</th>
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
            {{ link_to('products/edit/' ~ product.id, 'Editar') }}
        </td>

        <td width='7%'>
            {{ link_to('products/delete/' ~ product.id, 'Borrar') }}
        </td>
    </tr>

    {% if loop.last %}
            </tbody>
            <tbody>
                <tr>
                    <td colspan='7'>
                        <div>
                            {{ link_to('products/search', 'Primera') }}
                            {{ link_to('products/search?page=' ~ page.before, 'Anterior') }}
                            {{ link_to('products/search?page=' ~ page.next, 'Siguiente') }}
                            {{ link_to('products/search?page=' ~ page.last, 'Última') }}
                            <span class='help-inline'>{{ page.current }} de {{ page.total_pages }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    {% endif %}
{% else %}
    No se registraron productos
{% endfor %}
```

Hay muchas cosas en el ejemplo anterior que vale la pena detallar. En primer lugar, los elementos activos de la página actual son recorridos utilizando un `for` de Volt. Volt proporciona una sintaxis más simple para un `foreach` de PHP.

```twig
{% for product in page.items %}
```

En PHP es lo mismo que:

```php
<?php foreach ($page->items as $product) { ?>
```

El bloque entero `for` proporciona lo siguiente:

```twig
{% for product in page.items %}
    {% if loop.first %}
        Ejecutado antes del primer producto en el ciclo
    {% endif %}

    Ejecutado para cada producto de page.items

    {% if loop.last %}
        Ejecutado después del último producto en el ciclo
    {% endif %}
{% else %}
    Ejecutado si page.items no tiene ningún producto
{% endfor %}
```

Ahora puede volver a la vista y averiguar lo que cada bloque está haciendo. Cada campo en `products` se imprime en consecuencia:

```twig
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
        {{ link_to('products/edit/' ~ product.id, 'Editar') }}
    </td>

    <td width='7%'>
        {{ link_to('products/delete/' ~ product.id, 'Borrar') }}
    </td>
</tr>
```

Como hemos visto antes usando `product.id` es igual que hacer en PHP: `$product->id`, hicimos lo mismo con `product.name` y así sucesivamente. Otros campos se procesan diferente, por ejemplo, enfoquémonos en `product.productTypes.name`. Para entender esta parte, tenemos que revisar el modelo de productos (`app/models/Products.php`):

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Productos
 */
class Products extends Model
{
    // ...

    /**
     * Inicializador de productos
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

Un modelo puede tener un método llamado `initialize()`, se llama a este método una vez por petición y sirve al ORM para inicializar un modelo. En este caso, 'Products' se inicializa al definir que este modelo tiene una relación de uno a muchos con otro modelo llamado 'ProductTypes'.

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

Esto significa que el atributo local `product_types_id` en `Products` tiene una relación uno a muchos con el modelo de `ProductTypes` en su atributo `id`. Definiendo esta relación podemos acceder el nombre del tipo de producto utilizando:

```twig
<td>{{ product.productTypes.name }}</td>
```

El campo `price` es impreso mediante su formato utilizando un filtro de Volt:

```twig
<td>{{ '%.2f'|format(product.price) }}</td>
```

En PHP plano, sería:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

Al imprimir si el producto está activo o no, se utiliza un ayudante implementado en el modelo:

```php
<td>{{ product.getActiveDetail() }}</td>
```

Este método se define en el modelo.

<a name='creating-updating-records'></a>

## Creación y actualización de registros

Ahora vamos a ver cómo el CRUD crea y actualiza los registros. Desde las vistas `new` y `edit`, los datos introducidos por el usuario son enviados a las acciones `create` y `save` que realizan las acciones de `creación` y `actualización` de productos, respectivamente.

En el caso de la creación, recuperamos los datos enviados y los asignarlos a una nueva instancia de `Products`:

```php
<?php

/**
 * Crear un producto basado en los datos ingresados en la acción 'new'
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

¿Recuerda los filtros que definimos en el formulario de productos? Los datos se filtran antes de ser asignados al objeto `$product`. Este filtrado es opcional; el ORM también escapa los datos de entrada y realiza casting adicional según los tipos de columna:

```php
<?php

// ...

$name = new Text('name');

$name->setLabel('Nombre');

// Filtros para el nombre
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// Validadores para el nombre
$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'El nombre es requerido',
            ]
        )
    ]
);

$this->add($name);
```

Al guardar, sabremos si los datos se ajustan a las reglas de negocio y las validaciones del formulario `ProductsForm` (`app/forms/ProductsForm.php`):

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

// Validar los datos enviados
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

Finalmente, si el formulario no devuelve ningún mensaje de validación podemos guardar la instancia de producto:

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
    'El producto fue creado correctamente'
);

return $this->dispatcher->forward(
    [
        'controller' => 'products',
        'action'     => 'index',
    ]
);
```

Ahora, en el caso de actualización de un producto, primero debemos presentar al usuario los datos que se encuentran actualmente en el registro editado:

```php
<?php

/**
 * Editar un producto basado en su ID
 */
public function editAction($id)
{
    if (!$this->request->isPost()) {
        $product = Products::findFirstById($id);

        if (!$product) {
            $this->flash->error(
                'Producto no encontrado'
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

Los datos está ligados al formulario pasando el modelo como primer parámetro. Gracias a esto, el usuario puede cambiar cualquier valor y luego enviarlo a la base de datos a través de la acción de `save`:

```php
<?php

/**
 * Actualizar un producto basado en los datos ingresados en la acción 'edit'
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
            'El producto no existe'
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
        'El producto fue actualizado correctamente'
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

## Componentes de usuario

Todos los elementos de la interfaz y estilos visuales de la aplicación se han logrado principalmente a través de [Bootstrap](http://getbootstrap.com/). Algunos elementos, como barra de navegación, cambian según el estado de la aplicación. Por ejemplo, en la esquina superior derecha, el enlace `Iniciar sesión / Registrarse` cambia a `Cerrar sesión` si un usuario está logueado en la aplicación.

Esta parte de la aplicación se implementa en el componente `Elements` (`app/library/Elements.php`).

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

Esta clase extiende de `Phalcon\Mvc\User\Component`. No esta impuesto extender un componente con esta clase, pero esto ayuda para acceder más rápidamente a los servicios de aplicación. Ahora, vamos a registrar nuestro primer componente de usuario en el contenedor de servicios:

```php
<?php

// Registrar un componente de usuario
$di->set(
    'elements',
    function () {
        return new Elements();
    }
);
```

Al igual que los controladores, plugins o componentes de una vista, este componente también tiene acceso a los servicios registrados en el contenedor y al acceder a un atributo con el mismo nombre de un servicio previamente registrado:

```twig
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
        <p>&copy; Compañia 2017</p>
    </footer>
</div>
```

La parte importante es:

```twig
{{ elements.getMenu() }}
```

<a name='dynamic-titles'></a>

## Cambiando dinámicamente el título

Cuando se navega entre una opción y otra, veremos que el título cambia dinámicamente, lo que indica donde estamos trabajando. Esto se logra en cada inicializador de controlador:

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        // Configurar el título del documento
        $this->tag->setTitle(
            'Gestor de tipos de producto'
        );

        parent::initialize();
    }

    // ...
}
```

Nota, que también se llama al método `parent::initialize()`, que agrega más datos en el título:

```php
<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        // Anteponer el nombre de la aplicación al título
        $this->tag->prependTitle('INVO | ');
    }

    // ...
}
```

Finalmente, el título se imprime en la vista principal (app/views/index.volt):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```