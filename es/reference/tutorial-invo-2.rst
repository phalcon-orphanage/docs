Tutorial 3: Securing INVO
==========================
In this chapter, we continue explaining how INVO is structured, we'll talk
about the implementation of authentication, authorization using events and plugins and
an access control list (ACL) managed by Phalcon.

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
    $di->set('db', function () use ($config) {
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

                // Recibir los datos ingresados por el usuario
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                // Buscar el usuario en la base de datos
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);
                    // Redireccionar la ejecución si el usuario es valido
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            // Redireccionar a el forma de login nuevamente
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
verificar que solo usuarios registrados tengan acceso a esos controladores. Si no estás autenticado en la aplicación y
tratas, por ejemplo de acceder al controlador 'products' (que es privado) entonces verás una pantalla como esta:

.. figure:: ../_static/img/invo-2.png
   :align: center

Cada vez que alguien intente acceder a cualquier controlador/acción, la aplicación verifica si el perfil actual (en sesión)
tiene acceso a él, en caso contrario visualiza un mensaje como el anterior y redirecciona el usuario al inicio de la página.

Ahora, descubramos como la aplicación logra esto. Lo primero que debemos saber es que hay un componente llamado
:doc:`Dispatcher <dispatching>`. Este es informado sobre la ruta encontrada por componente el :doc:`Router <routing>`.
Luego es responsable de cargar el controlador apropiado y ejecutar la acción correspondiente.

Normalmente, el framework crea el despachador (dispatcher) automáticamente. En nuestro caso como debemos verificar
antes de ejecutar las acciones y revisar si el usuario tiene acceso a ellas. Para lograr esto reemplazaremos
la creación automática y crearemos una función en el bootstrap.

.. code-block:: php

    <?php

    $di->set('dispatcher', function () use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

Ahora tenemos total control sobre como el Dispatcher es inicializado y usado en la aplicación. Muchos componentes
del framework lanzan eventos que nos permiten cambiar el funcionamiento interno o su operación. Así como el inyector
de dependencias funciona como intermedario de componentes, un nuevo componente llamado :doc:`EventsManager <events>`
nos ayuda a interceptar eventos producidos por un componente enrutando los eventos a los escuchadores.

Administración de Events
^^^^^^^^^^^^^^^^^^^^^^^^
Un :doc:`EventsManager <events>` nos permite agregar escuchadores (listeners) a un tipo particular de evento. El tipo que
nos interesa ahora es "dispatch", el siguiente código filtra todos los eventos producidos por Dispatcher:

.. code-block:: php

    <?php

    $di->set('dispatcher', function () use ($di) {

        // Crear un administrador de eventos
        $eventsManager = new Phalcon\Events\Manager();

        // Instanciar el plugin de seguridad
        $security = new Security($di);

        // Enviar todos los eventos producidos en el Dispatcher al plugin Security
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        // Asignar el administrador de eventos al dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

El plugin Security es una clase úbicada en (app/plugins/Security.php). Esta clase implementa
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

Los escuchadores de eventos siempre reciben un primer parámetro que contiene información contextual del evento producido
y un segundo que es el objeto que produjo el evento como tal ($dispatcher). No es obligatorio que los plugins extiendan
la clase Phalcon\\Mvc\\User\\Plugin, pero haciendo esto, ellos ganan acceso de forma simple a los servicios disponibles
en la aplicación.

Ahora, verificamos si el pérfil (role) actual en sesión tiene acceso usando una lista de control de acceso ACL.
Si no tiene acceso lo redireccionamos a la pantalla de inicio como explicamos anteriormente:

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

            // Verificar si la variable de sesión 'auth' está definida, esto indica si hay un usuario autenticado
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            // Obtener el controlador y acción actual desde el Dispatcher
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            // Obtener la lista ACL
            $acl = $this->_getAcl();

            // Verificar si el pérfil (role) tiene acceso al controlador/acción
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Phalcon\Acl::ALLOW) {

                // Si no tiene acceso mostramos un mensaje y lo redireccionamos al inicio
                $this->flash->error("No tienes acceso a este módulo.");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                // Devolver "false" le indica al Dispatcher que debe detener la operación
                // y evitar que la acción se ejecute
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

    // Crear el ACL
    $acl = new Phalcon\Acl\Adapter\Memory();

    // La acción por defecto es denegar (DENY)
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    // Registrar dos roles, 'users' son usuarios registrados
    // y 'guests' son los usuarios sin un pérfil definido (invitados)
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

Ahora definiremos los recursos para cada área respectívamente. Los nombres de controladores son recursos y
sus acciones son accesos a los recursos:

.. code-block:: php

    <?php

    // Recursos del área privada (backend)
    $privateResources = array(
      'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    // Recursos del área pública (frontend)
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

    // Permitir acceso al área pública tanto a usuarios como a invitados
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    // Permitir acceso al área privada solo al pérfil "Users"
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

Super!, la ACL está ahora completa. In next chapter, we will see how a CRUD is implemented in Phalcon and how you
can customize it.

.. _jinja: http://jinja.pocoo.org/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
