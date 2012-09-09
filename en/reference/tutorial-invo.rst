Tutorial 2: Explaining INVO
===========================

In this second tutorial, we'll explain a more complete application in order to deepen the development with Phalcon. INVO is one of the applications we have created as samples. INVO is a small website that allows their users to generate invoices, and do other tasks as manage their customers and products. You can clone its code from Github_.

Also, INVO was made with Twitter Bootstrap as client-side framework. Although the application does not generate invoices still it serves as an example to understand how the framework works.

Project Structure
------------------
Once you clone the project in your document root you'll see the following structure:

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

As you know, Phalcon does not impose a particular file structure for application development. This project provides a simple MVC
structure and a public document root.

Once you open the application in your browser http://localhost/invo you'll something like this:

.. figure:: ../_static/img/invo-1.png
   :align: center

The application is divided in two parts a frontend, that is a public part where visitors can receive information about INVO and request contact information. The second part is the backend, is an administrative area where a registered user can manage his products and customers.

Routing
-------
INVO uses the standard route that is builtin with the Router component. This routes matches the following pattern: /:controller/:action/:params. This means that the first part of the url is the controller, the second the action and so on.

The following route /session/register will execute the controller SessionController and its action registerAction.

Configuration
-------------
INVO has a configuration file which sets general parameters of the application. This file is read in the first lines
of the bootstrap file (public/index.php):

.. code-block:: php

    <?php

    //Read the configuration
    $config = new Phalcon\Config\Adapter\Ini(__DIR__.'/../app/config/config.ini');

Phalcon\Config allows us to manipulate the file in an object oriented way. The configuration file contains the following
settings:

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [app]
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

Phalcon has no defined any convention settings. Sections help us organize the options as appropriate. In this file there are three sections to use later.

Autoloaders
-----------
A second part that appears in the boostrap file (public/index.php) is the autoloader. The autoloader registers a set of directories where the application will look for the classes that it eventually will need.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            __DIR__.$config->app->controllersDir,
            __DIR__.$config->app->pluginsDir,
            __DIR__.$config->app->libraryDir,
            __DIR__.$config->app->modelsDir,
        )
    )->register();

Note that what has been done is to register the directories that were in the configuration file. The only directory that is not registered is the viewsDir, because it contains no classes but html + php files.

Handling the Request
--------------------
Let's go much further, at the end of the file, the request is finally handled by Phalcon\\Mvc\\Application, this class initializes and executes all the necesary to make the application run:

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();

Dependency Injection
--------------------
Look at the second line of the code block above, the variable $application is receiving another variable $di. What is the purpose of that variable? Phalcon is a highly decoupled framework, so we need a component that act as glue to make everything work together. That component is Phalcon\\DI. It is a service container that also performs dependency injection, instantiating all components as they are needed by the application.

There are many ways of registering in the container services. In INVO most services have been registered using anonymous functions. Thanks to this the objects are instantiated in a lazy way, reducing the resources needed by the application.

For instance, in the following excerpt is registered the session service, the anonymous function will only be called when the application requires access to the session data:

.. code-block:: php

    <?php

    //Start the session the first time some component request the session service
    $di->set('session', function(){
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

Here we have the freedom to change the adapter, perform additional initialization and much more. Note that the service was registered using the name "session". This is a convention that will allow the framework to identify the active service in the service container.

A request can use many services, register each service one to one can be a cumbersome task. For this reason, the framework provides a variant of Phalcon\\DI called Phalcon\\DI\\FactoryDefault.

.. code-block:: php

    <?php

    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full stack framework
    $di = new \Phalcon\DI\FactoryDefault();

It registers the majority of services with components provided by the framework as standard. If we need to override the definition of some it could be done as above with "session". Now we know the origin of the variable $di.

Log into the Application
------------------------
Log in will allow us to work on backend controllers. The separation between the controllers of the backend and frontend is only logical. All controllers are located in the same directory. To enter the system, we must have a valid username and password. The users are the  stored in the table "users" of the database "invo".

Before we can log in, we need to configure the connection to the database in the application. A service called "db" will be applied to the service container for this information. As with the autoloader, this time we are also taking parameters from the configuration file to configure a service:

.. code-block:: php

    <?php

    // Database connection is created based in the parameters defined in the configuration file
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

Here we return an instance of the MySQL connection adapter. If needed, you could do extra actions such as adding a logger, a profiler or change the adapter, or setup it as you want.

Back then, the following simple form (app/views/session/index.phtml) requests the logon information. We've removed some HTML code to make the example more concise:

.. code-block:: html+php

    <?php echo Tag::form('session/start') ?>

        <label for="email">Username/Email</label>
        <?php echo Tag::textField(array("email", "size" => "30")) ?>

        <label for="password">Password</label>
        <?php echo Tag::passwordField(array("password", "size" => "30")) ?>

        <?php echo Tag::submitButton(array('Login')) ?>

    </form>

The SessionController::startAction (app/controllers/SessionController.phtml) have the task of validate the entered data checking for a valid user in the database:

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

                //Taking the variables sent by POST
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                //Find for the user in the database
                $user = Users::findFirst("email='$email' AND password='$password' AND active='Y'");
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome '.$user->name);

                    //Forward to the invoices controller if the user is valid
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            //Forward to the login form again
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'index'
            ));

        }

    }

Note that multiple public attributes are accessed in the controller like: $this->flash, $this->request or $this->session.
These are services defined in dependency injector from earlier. When accessed the first time, they are injected as part of the controller.

These services are shared, which means that we will always be accessing the same instance regardless of the place where we invoke them.

For instance, here we invoke the "session" service and them we store the user identity in the "auth" variable:

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

Securing the Backend
--------------------
The backend is a private area where only registered users have access. Therefore it is necessary to check that only registered users have access to these controllers. If you aren't logged in the application and you try to access by example the products controller (that is private) you'll see a screen like this:

.. figure:: ../_static/img/invo-2.png
   :align: center

Every time someone try to access any controller and action, the application verifies that the current role has access to it, otherwise it displays a message like the above and forwards the flow to the home page.

Now let's find out how the application accomplishes this. The first thing to know is that there is a component called Dispatcher. He is informed of the route found by the component Router and then is responsible for loading the appropriate controller and execute the corresponding action method.

Normally, the Dispatcher is created automatically by the framework. In our case, we want to make a special action that is check before executing the required action if the user has access to it or not. To achieve this we replace the component by creating a function defined by us in the bootstrap:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

We now have total control of the Dispatcher used by the application. Now, many components of the framework launch events that allow us to modify the internal flow of operation. As the dependency Injector component acts as glue for components, a new component called EventsManager helps us to bring the events produced by some component to the objects that require them.

Events Management
^^^^^^^^^^^^^^^^^
A EventsManager allows us to attach listeners to a particular type of event. The type that interests us now is "dispatch" that filters all events produced by the Dispatcher:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {

        //Obtain the standard eventsManager from the DI
        $eventsManager = $di->getShared('eventsManager');

        //Instantiate the Security plugin
        $security = new Security($di);

        //Listen for events produced in the dispatcher using the Security plugin
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        //Bind the EventsManager to the Dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

The Security plugin is a class located at (app/plugins/Security.php). This class implements the method "beforeExecuteRoute". This is the same
name as one of the events produced in the Dispatcher:

.. code-block:: php

    <?php

    class Security extends Phalcon\Mvc\User\Plugin
    {

        // ...

        public function beforeExecuteRoute(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher)
        {
            // ...
        }

    }

The hooks events always receive a first paramter that contains contextual information of the event produced and a second that is the
object that produced the event itself. Plugins should not extend the class Phalcon\Mvc\User\Plugin, but by doing it they gain easier access to the services of the application.

Now, we're verifying the role in the current session, check to see if he has access using the ACL list. If he does not have access we redirect hom to the home screen as explained:

.. code-block:: php

    <?php

    class Security extends Phalcon\Mvc\User\Plugin
    {

        // ...

        public function beforeExecuteRoute(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher)
        {

            //Check whether the "auth" variable exists in session to define the active role
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            //Take the active controller/action from the dispatcher
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            //Obtain the ACL list
            $acl = $this->_getAcl();

            //Check if the Role have access to the controller (resource)
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Phalcon\Acl::ALLOW) {

                //If he doesn't have access forward him to the index controller
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                //Returning "false" we tell to the dispatcher to stop the current operation
                return false;
            }

        }

    }

Providing an ACL list
^^^^^^^^^^^^^^^^^^^^^
In the previous example we obtain the ACL using the method $this->_getAcl(). This method is also implemented in the Plugin.
Now explain step by step how we built the access control list:

.. code-block:: php

    <?php

    //Create the ACL
    $acl = new Phalcon\Acl\Adapter\Memory();

    //The default action is DENY access
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    //Register two roles, Users is registered users
    //and guests are users without a defined identity
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach($roles as $role){
        $acl->addRole($role);
    }

Now we define the respective resources of each area. Controller names are resources and their actions are the accesses in
the resources:

.. code-block:: php

    <?php

    //Private area resources (backend)
    $privateResources = array(
        'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
        'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
        'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
        'invoices' => array('index', 'profile')
    );
    foreach($privateResources as $resource => $actions){
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    //Public area resources (frontend)
    $publicResources = array(
        'index' => array('index'),
        'about' => array('index'),
        'session' => array('index', 'register', 'start', 'end'),
        'contact' => array('index', 'send')
    );
    foreach($publicResources as $resource => $actions){
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

The ACL now have knowledge of the existing controllers and their related actions. The role "Users" have access to all the resources of both the frontend and the backend. The role "Guests" only have access to the public area:

.. code-block:: php

    <?php

    //Grant access to public areas to both users and guests
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    //Grant access to private area only to role Users
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

Hooray!, the ACL is now complete.

User Components
---------------
All the UI elements and visual style of the application has been achieved mostly through Twitter Boostrap. Some elements, such as the navigation bar change according to the state of the application. For example, in the upper right corner, the link "Log in / Sign Up" changes to "Log out" if a user is logged into the application.

This part of the application is implemented in the component "Elements" (app/library/Elements.php).

.. code-block:: php

    <?php

    class Elements extends Phalcon\Mvc\User\Component
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

This class extends the Phalcon\Mvc\User\Component, it is not imposed to extend a component with this class, but if it helps to more quickly access the application services. Now, we register this class in the Dependency Injector Container:

.. code-block:: php

    <?php

    //Register an user component
    $di->set('elements', function(){
        return new Elements();
    });

As controllers, plugins or components within a view also can access the services registered in the container just accessing an attribute by name:

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

The important part is:

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

Working with the CRUD
---------------------



.. _Github: https://github.com/phalcon/invo
