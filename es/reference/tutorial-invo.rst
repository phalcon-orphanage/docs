Tutorial 2: Explicando INVO
===========================
En este segundo tutorial, explicaremos una aplicación más completa con el objetivo de profundizar en el desarrollo
con Phalcon.

INVO es una de las aplicaciones que hemos creado como ejemplo. INVO es un pequeño sitio web que permite a sus clientes
generar facturas, además de otras tareas como administrar clientes y productos. Puedes clonar su código fuente de Github_.

Adicionalmente, INVO fue creada con `Twitter Bootstrap`_ como framework en el cliente. A pesar que la aplicación
no genera facturas sirve como ejemplo para entender muchos aspectos y funcionalidades en el framework.

Estructura del Proyecto
-----------------------
Una vez clones el proyecto en tu raíz de directorios verás la siguiente estructura:

.. code-block:: bash

    invo/
        app/
            app/config/
            app/controllers/
            app/library/
            app/models/
            app/plugins/
            app/views/
        public/
            public/bootstrap/
            public/css/
            public/js/
        schemas/

Como sabes, Phalcon no te impone una estructura de directorios en particular. Este proyecto tiene una
estructura de directorios para un MVC sencillo y una raíz pública de documentos.

Una vez abres la aplicación en tu navegador: http://localhost/invo verás algo como:

.. figure:: ../_static/img/invo-1.png
   :align: center

La aplicación está dividida en dos partes, un frontend, que es la parte pública donde los visitante pueden recivir 
información además de solicitar información de contácto.

La segunda parte es el backend, un área administrativa donde un usuario registrado puede administrar
sus productos y clientes.

Enrutamiento
------------
INVO usa la forma estándar de enrutar que viene con el componente de enrutamiento. Estas rutas
usán el patrón que viene con el componente Router. El patrón es: /:controller/:action/:params.
Esto significa que la primera parte de la URI es el controlador, la segunda la acción y el resto
son los parámetros.

La ruta /session/register ejecuta el controlador "SessionController" y su acción "registerAction".

Configuración
-------------
INVO tiene un archivo de configuración que establece parametros generales en la aplicación.
Este archivo es leído en las primeras líneas del bootstrap (public/index.php):

.. code-block:: php

    <?php

    //Leer la configuración
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

:doc:`Phalcon\\Config <config>` nos permite manipular el archivo usando programación orientada a objetos.
El archivo de configuración contiene la siguiente configuración.

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = /../app/controllers/
    modelsDir      = /../app/models/
    viewsDir       = /../app/views/
    pluginsDir     = /../app/plugins/
    libraryDir     = /../app/library/
    baseUri        = /invo/

    ;[metadata]
    ;adapter = "Apc"
    ;suffix = my-suffix
    ;lifetime = 3600

Phalcon no tiene convenciones de configuración predeterminadas. Las secciones en el archivo nos ayudan a organizar la configuración
de manera apropiada. En este archivo hay trés secciones que se usarán luego.

Autocargadores
-----------
Una segunda parte que aparece en el bootstrap (public/index.php) es el autocargador (autoloader). Este registra un conjunto
de directorios que la aplicación utilizará para cargar las clases que eventualmente necesitará.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();

Lo que se ha hecho es registrar los directorios que están definidos en el archivo de configuración. El único
directorio que no está registrado es el viewsDir', porque estas no contienen clases sino HTML y PHP.

Atendiendo la petición
----------------------
Vallamos mucho más adelante, al final del archivo, la petición es finalmente atendida por Phalcon\\Mvc\\Application,
esta clase inicializa y ejecuta todo lo necesario para que la aplicación sea ejecutada:

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle()->getContent();

Inyección de Dependencias
-------------------------
En el código anterior, la variable $di es pasada al constructor de Phalcon\\Mvc\\Application.
¿Cuál es el proposito de esta variable? Como Phalcon es un framework altamente desacoplado, necesitamos un componente
que actúe como intermediario entre los distintos componentes para hacer que todo trabaje junto de una manera sencilla.
Este componente es Phalcon\\DI. Es un contenedor de servicios que también permite injeccción de dependencias,
instanciando e inicializando todos los componentes a medida que son requeridos por la aplicación.

Hay muchas formas de registrar servicios en el contenedor. En INVO, la mayoría de servicios han sido registrados
usando funciones anonimas. Gracias a esto, Los objetos son instanciados solo cuando son requeridos, reduciendo
la cantidad de recursos requeridos por la aplicación.

Por ejemplo, en el siguiente codigo, el servicio de sesión es registrado, la función anónima solo es ejecutada
si la aplicación requiere acceder a datos de sessión:

.. code-block:: php

    <?php

    //Iniciar la sesión solamente la primera vez que un componente requiera el servicio de sesión
    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

Gracias a esto, tenemos la libertad de cambiar el adaptador, ejecutar inicializaciones adicionales y mucho más.
Ten en cuenta que el servicio se registró usando el nombre "session". Esta es una convención que ayudará a los demás
componentes a solicitar el servicio correcto en el contenedor de servicios.

Una petición puede usar muchos servicios, registrar cada servicio puede ser tedioso. Por esta razón,
el framework proporciona una variante Phalcon\\DI llamada Phalcon\\DI\\FactoryDefault cuyo objetivo es registrar
todos los servicios proporcionados por un framework full-stack.

.. code-block:: php

    <?php

    // El FactoryDefault Dependency Injector registra automáticamente
    // todos los servicios proporcionando un framework full stack
    $di = new \Phalcon\DI\FactoryDefault();

Así se registran la mayoria de servicios con componentes proporcionados por el framework como estándar. Si queremos
reemplazar la definición de un servicio podemos hacerla como hicimos antes con el servicio "session". Esta es la razón
de la existencia de la variable $di.

Iniciar sesión en la Aplicación
-------------------------------
El enlace "Log In" nos permitirá trabajar en los controladores del backend. La separación entre los controladores
del backend y los del frontend es solo lógica. Todos los controladores se encuentran ubicados en el directorio
(app/controllers/).

Para ingresar al sistema, debemos tener un nombre de usuario y contraseña válidos. Los usuarios son almacenados
en la tabla "users" de la base de datos "invo".

Antes de iniciar sesión, necesitamos configurar la conexión a la base de datos de la aplicación. Un servicio
llamado "db" esta configurado en el contenedor de servicios con esta información. Así como lo hicimos con el
autocargador también vamos a tomar los parámetros del archivo de configuración.

.. code-block:: php

    <?php

    // La conexión a la base de datos es creada basada en los parámetros definidos en el archivo de configuración
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

Este servicio retorna una instancia del adaptador de conexión a MySQL. De llegar a ser requerido, puedes hacer
acciones extra como agregar un logger, un profiler, cambiar el adaptador, agregar más opciones de configuración, etc.

Retomando el login, tenemos un formulario muy sencillo (app/views/session/index.phtml) que solicita los datos de inicio de
sesión. Hemos quitado algo de HTML para hacer el ejemplo más simple:

.. code-block:: html+php

    <?php echo Tag::form('session/start') ?>

        <label for="email">Nombre de usuario/Correo electrónico</label>
        <?php echo Tag::textField(array("email", "size" => "30")) ?>

        <label for="password">Contraseña</label>
        <?php echo Tag::passwordField(array("password", "size" => "30")) ?>

        <?php echo Tag::submitButton(array('Autenticar')) ?>

    </form>

SessionController::startAction (app/controllers/SessionController.phtml) tiene la tarea de validar los
datos ingresados verificando si el usuario existe y sus credenciales son validas:

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {

        // ...

        private function _registerSession($user)
        {
            $this->session->set('auth', array(
                'id' => $user->id,
                'name' => $user->name
            ));
        }

        public function startAction()
        {
            if ($this->request->isPost()) {

                //Recibir los datos ingresados por el usuario
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                //Buscar el usuario en la base de datos
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);
                    //Redireccionar la ejecución si el usuario es valido
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            //Redireccionar a el forma de login nuevamente
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'index'
            ));

        }

    }

Por simplicidad, hemos usado "sha1_" para guardar los passwords en la base de datos, sin embargo, este
algoritmo no es recomendado para aplicaciones reales, usa mejor " :doc:`bcrypt <security>`".

Como pudiste ver, muchos atributos públicos fueron accedidos desde el controlador como: $this->flash, $this->request y $this->session.
Estos son servicios en el contenedor de servicios anteriormente. Cuando ellos son accedidos la primera vez, son injectados
como parte del controlador.

Estos servicios son compartidos, esto significa que siempre que accedamos a ellos estaremos accediendo a la misma instancia
sin importar desde donde los solicitemos.

Por ejemplo, aquí invocamos el servicio "session" y luego almacenamos la identidad del usuario logueado en la variable 'auth':

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

Asegurando el Backend
---------------------
El backend es una área privada donde solamente los usuarios registrados tienen acceso. Por lo tanto, es necesario
chequear que solo usuarios registrados tengan acceso a esos controladores. Si no estás logueado en la aplicación y
tratas, por ejemplo de acceder al controlador 'products' (que es privado) entonces verás una pantalla como esta:

.. figure:: ../_static/img/invo-2.png
   :align: center

Cada vez que alguien intente acceder a cualquier controlador/acción, la aplicación verifica si el perfil actual (en sesión)
tiene acceso a él, en caso contrario visualiza un mensaje como el anterior y redirecciona el usuario al inicio de la página.

Ahora, descubramos como la aplicación logra esto. La primera cosa a saber es que hay un componente llamado
:doc:`Dispatcher <dispatching>`. Este es informado sobre la ruta encontrada por componente el :doc:`Router <routing>`.
Luego es responsable de cargar el controlador apropiado y ejecutar la acción correspondiente.

Normalmente, el framework crea el dispatcher automaticamente. En nuestro caso como debemos verificar
antes de ejecutar las acciones y revisar si el usuario tiene acceso a ellas. Para lograr esto, debemos
reemplazar la creación automática y crear una función en el bootstrap.

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

Ahora tenemos total control sobre como el Dispatcher es inicializado y usado en la aplicación. Muchos componentes
del framework lanzan eventos que nos permiten cambiar el funcionamiento interno o su operación. Así como el inyector
de dependencias funciona como intermedario de componentes, un nuevo componente llamado :doc:`EventsManager <events>`
nos ayuda a interceptar eventos producidos por un componente enrutando los eventos a los listeners.

Administración de Events
^^^^^^^^^^^^^^^^^^^^^^^^
Un :doc:`EventsManager <events>` nos permite agregar listeners a un tipo particular de evento. El tipo que
nos interesa ahora es "dispatch", el siguiente código filtra todos los eventos producidos por Dispatcher:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {

        //Crear un administrador de eventos
        $eventsManager = new Phalcon\Events\Manager();

        //Instanciar el plugin de seguridad
        $security = new Security($di);

        //Enviar todos los eventos producidos en el Dispatcher al Security plugin
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        //Asignar el administrador de eventos al dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

El Security plugin es una clase ubicada en (app/plugins/Security.php). Esta clase implementa
el método "beforeExecuteRoute". Este tiene el mismo nombre de uno de los eventos producidos en el dispatcher.

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\User\Plugin;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }

    }

Los listeners de eventos siempre reciben un primer parámetro que contiene información contextual del evento producido
y un segundo que es el objeto que produjo el evento como tal ($dispatcher). No es obligatorio que los plugins extiendan
la clase Phalcon\\Mvc\\User\\Plugin, pero haciendo esto, ellos ganan acceso sencillo a los servicios disponibles
en la aplicación.

Ahora, verificamos si el perfil (role) actual en sesión tiene acceso usando una lista de control de acceso ACL.
Si él no tiene acceso lo redireccionamos a la pantalla de inicio como explicamos anteriormente:

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\User\Plugin;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {

            //Verificar si la variable de sessión 'auth' está definida, esto indica si hay un usuario logueado
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            //Obtener el controlador y acción actual desde el Dispatcher
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            //Obtener la lista ACL
            $acl = $this->_getAcl();

            //Verificar si el perfil (role) tiene acceso al controlador/acción
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Phalcon\Acl::ALLOW) {

                //Si no tiene acceso mostramos un mensaje y lo redireccionamos al inicio
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                //Devolver "false" le indica al Dispatcher que debe detener la operación
                //y evitar que la acción se ejecute
                return false;
            }

        }

    }

Crear una lista ACL
^^^^^^^^^^^^^^^^^^^
En el ejemplo anterior, hemos obtenido la lista ACL usando el método $this->_getAcl(). Este método
también es implementado en el plugin. Ahora, explicaremos paso a paso como construir la lista de control de acceso.

.. code-block:: php

    <?php

    //Crear el ACL
    $acl = new Phalcon\Acl\Adapter\Memory();

    //La acción por defecto es denegar (DENY)
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    //Registrar dos roles, 'users' son usuarios registrados
    //y 'guests' son los usuarios sin un perfil definido (invitados)
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

Ahora definiremos los recursos para cada área respectivamente. Los nombres de controladores son recursos y
sus acciones son accesos a los recursos:

.. code-block:: php

    <?php

    //Recursos del área privada (backend)
    $privateResources = array(
      'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    //Recursos del área pública (frontend)
    $publicResources = array(
      'index' => array('index'),
      'about' => array('index'),
      'session' => array('index', 'register', 'start', 'end'),
      'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

El ACL ahora tiene conocimiento de los controladores existentes y sus acciones. El perfil "Users"
tiene acceso tanto al backend y al frontend. El perfil "Guests" solo tiene acceso al área pública.

.. code-block:: php

    <?php

    //Darle acceso al área pública tanto a usuarios como a invitados
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    //Darle acceso al área privada solo al perfil "Users"
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

Super!, la ACL está ahora completa

Componentes de Usuario
----------------------
Todos los elementos visuales en la aplicación han sido logrados usando mayormente con `Twitter Bootstrap`_.
Algunos elementos, como la barra de navegación cambian de acuerdo al estado actual de la aplicación.
Por ejemplo, en la esquina superior derecha, el link "Log in / Sign Up" cambia a "Log out" si un
usuario se ha iniciado sesión en la aplicación.

Esta parte de la aplicación es implementada en el componente de usuario "Elements" (app/library/Elements.php).

.. code-block:: php

    <?php

    use Phalcon\Mvc\User\Component;

    class Elements extends Component
    {

        public function getMenu()
        {
            //...
        }

        public function getTabs()
        {
            //...
        }

    }

Esta clase extiende de Phalcon\\Mvc\\User\\Component, no es obligatorio que los componentes de usuario extiendan de esa clase,
sin embargo esto ayuda a que puedan acceder facilmente a los servicios de la aplicación. Ahora vamos a registrar
esta clase en el contenedor de servicios:

.. code-block:: php

    <?php

    //Registrar un componente de usuario
    $di->set('elements', function() {
        return new Elements();
    });

Así como los controladores, plugins o componentes, dentro de una vista, este componente también se puede
acceder a los servicios de la aplicación simplemente accediendo a un atributo con el mismo nombre de un
servicio previamente registrado:

.. code-block:: html+php

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">INVO</a>
                <?php echo $this->elements->getMenu() ?>
            </div>
        </div>
    </div>

    <div class="container">
        <?php echo $this->getContent() ?>
        <hr>
        <footer>
            <p>&copy; Company 2012</p>
        </footer>
    </div>

La parte relevante es:

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

Trabajando con CRUDs
--------------------
La mayor parte de opciones que manipulan datos
Most options that manipulate data (compañias, productos y tipos de productos), han sido desarrollados
usando un básico y común CRUD_ (Create, Read, Update and Delete). Cada CRUD contiene los siguientes archivos:

.. code-block:: bash

    invo/
        app/
            app/controllers/
                ProductsController.php
            app/models/
                Products.php
            app/views/
                products/
                    edit.phtml
                    index.phtml
                    new.phtml
                    search.phtml

Cada controlador implementa las siguientes acciones:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * La acción de inicio, permite buscar productos
         */
        public function indexAction()
        {
            //...
        }

        /**
         * Realiza la búsqueda basada en los parámetros de usuario
         * devolviendo un paginador
         */
        public function searchAction()
        {
            //...
        }

        /**
         * Muestra la vista de crear nuevos productos
         */
        public function newAction()
        {
            //...
        }

        /**
         * Muestra la vista para editar productos existentes
         */
        public function editAction()
        {
            //...
        }

        /**
         * Crea un nuevo producto basado en los datos ingresados en la acción "new"
         */
        public function createAction()
        {
            //...
        }

        /**
         * Actualiza un producto basado en los datos ingresados en la acción "edit"
         */
        public function saveAction()
        {
            //...
        }

        /**
         * Elimina un producto existente
         */
        public function deleteAction($id)
        {
            //...
        }

    }

Formulario de Buscar
^^^^^^^^^^^^^^^^^^^^
Cada CRUD inicia con un formulario de búsqueda. Este formulario muestra cada campo que tiene la tabla (productos),
permitiendo al usuario crear un criterio de búsqueda por cada campo. La tabla "productos" tiene una relación
a la tabla "product_types". En este caso, previamente consultamos los registros en esta tabla para facilitar al usuario
su búsqueda por este campo.

.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

Todos los tipos de productos son consultados y pasados a la vista como una variable local $productTypes. Luego,
en la vista (app/views/index.phtml) mostramos una etiqueta "select" llena con esos datos:

.. code-block:: html+php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo Tag::select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Fijate que $productTypes contiene todos los datos necesarios para llenar la etiqueta SELECT usando Phalcon\\Tag::select.
Una vez el formulario sea

Note that $productTypes contains the data necessary to fill the SELECT tag using Phalcon\\Tag::select. Once the form
is enviado, la acción "search" es ejecutada en el controlado realizando la búsqueda basada en los parámetros digitados
por el usuario.

Realizando una Búsqueda
^^^^^^^^^^^^^^^^^^^^^^^
La acción tiene "search" tiene un doble objetivo. Cuando es accedida via POST, realiza una búsqueda basada en los parámetros
ingresados por el usuario y cuando se accede via GET mueve la pagína actual en el paginador.
The action "search" has a dual behavior. When accessed via POST, it performs a search based on the data sent from the
form. But when accessed via GET it moves the current page in the paginator. Para diferenciar un método del
otro usamos el componente :doc:`Request <request>`:

.. code-block:: php

    <?php

    /**
     * Realiza la búsqueda basada en los parámetros de usuario
     * devolviendo un paginador
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            //crear las condiciones de búsqueda
        } else {
            //paginar usando las condiciones existentes
        }

        //...

    }


Con la ayuda de :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, podemos crear una búsqueda
de manera inteligente basada en los tipos de datos enviados en el formulario:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

Este método verifica que valores son diferentes a "" (cadena vacia) y nulo y los toma en cuenta para crear el criterio de búsqueda

* Si el campo tiene un tipo de dato de texto o similar (char, varchar, text, etc.) Usa un operador SQL "like" para filtrar los resultados
* Si el tipo de dato no es texto, entonces usará el operador "="

Adicionalmente, "Criteria" ignora todas las variables $_POST que no correspondan a campos en la tabla.
Los valores son automáticamente escapados usando "bound parameters" evitando inyecciones de SQL.

Ahora, almacenamos los parametros producidos in la bolsa de datos de sesión del controlador:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Una bolsa de sesión, es un atributo especial en un controlador que es persistente entre peticiones.
Al ser accedido, este atributo es inyectado con un servicio :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
que es independiente por controlador/clase.

Luego, basado en los parámetros construidos anteriormente:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

Si la búsqueda no retorna ningún producto, redireccionamos el usuario a la vista de inicio nuevamente.
Supongamos que retornó registros, entonces creamos un páginador para navegar facilmente a través de ellos:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    //Data to paginate
        "limit" => 5,           //Rows per page
        "page" => $numberPage   //Active page
    ));

    //Obtener la página activa
    $page = $paginator->getPaginate();

Finalmente pasamos la página devuelta a la vista:

.. code-block:: php

    <?php

    $this->view->page = $page;

En la vista (app/views/products/search.phtml), recorremos los resultados correspondientes de la página actual:

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= Tag::linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= Tag::linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

Creating and Updating Records
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views the data entered by the user
are sent to the actions "create" and "save" that perform actions of "creating" and "updating" products respectively.

In the creation case, we recover the data submitted and assign them to a new "products" instance:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        $products = new Products();

        $products->id = $this->request->getPost("id", "int");
        $products->product_types_id = $this->request->getPost("product_types_id", "int");
        $products->name = $this->request->getPost("name", "striptags");
        $products->price = $this->request->getPost("price", "double");
        $products->active = $this->request->getPost("active");

        //...

    }

Data is filtered before being assigned to the object. This filtering is optional, the ORM escapes the input data and
performs additional casting according to the column types.

When saving we'll know whether the data conforms to the business rules and validations implemented in the model Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        //...

        if (!$products->create()) {

            //The store failed, the following messages were produced
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

Now, in the case of product updating, first we must present to the user the data that is currently in the edited record:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        //...

        $product = Products::findFirstById($id);

        Tag::setDefault("id", $product->id);
        Tag::setDefault("product_types_id", $product->product_types_id);
        Tag::setDefault("name", $product->name);
        Tag::setDefault("price", $product->price);
        Tag::setDefault("active", $product->active);

    }

The "setDefault" helper sets a default value in the form on the attribute with the same name. Thanks to this,
the user can change any value and then sent it back to the database through to the "save" action:

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        //...

        //Find the product to update
        $product = Products::findFirstById($this->request->getPost("id"));
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        //... assign the values to the object and store it

    }

Changing the Title Dynamically
------------------------------
When you browse between one option and another will see that the title changes dynamically indicating where
we are currently working. This is achieved in each controller initializer:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        public function initialize()
        {
            //Set the document title
            Tag::setTitle('Manage your product types');
            parent::initialize();
        }

        //...

    }

Note, that the method parent::initialize() is also called, it adds more data to the title:

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon\Mvc\Controller
    {

        protected function initialize()
        {
            //Prepend the application name to the title
            Phalcon\Tag::prependTitle('INVO | ');
        }

        //...
    }

Finally, the title is printed in the main view (app/views/index.phtml):

.. code-block:: html+php

    <?php use Phalcon\Tag as Tag ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?php echo Tag::getTitle() ?>
        </head>
        <!-- ... -->
    </html>

Conclusion
----------
This tutorial covers many more aspects of building applications with Phalcon, hope you have served to
learn more and get more out of the framework.

.. _Github: https://github.com/phalcon/invo
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
.. _Twitter Bootstrap: http://bootstrap.github.com/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
