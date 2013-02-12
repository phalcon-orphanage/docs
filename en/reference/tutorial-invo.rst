Tutorial 2: Explaining INVO
===========================

In this second tutorial, we'll explain a more complete application in order to deepen the development with Phalcon.
INVO is one of the applications we have created as samples. INVO is a small website that allows their users to
generate invoices, and do other tasks as manage their customers and products. You can clone its code from Github_.

Also, INVO was made with `Twitter Bootstrap <http://twitter.github.com/>`_ as client-side framework. Although the application does not generate
invoices still it serves as an example to understand how the framework works.

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

As you know, Phalcon does not impose a particular file structure for application development. This project
provides a simple MVC structure and a public document root.

Once you open the application in your browser http://localhost/invo you'll something like this:

.. figure:: ../_static/img/invo-1.png
   :align: center

The application is divided in two parts, a frontend, that is a public part where visitors can receive information
about INVO and request contact information. The second part is the backend, an administrative area where a
registered user can manage his/her products and customers.

Routing
-------
INVO uses the standard route that is built-in with the Router component. These routes matches the following
pattern: /:controller/:action/:params. This means that the first part of a URI is the controller, the second the
action and the rest are the parameters.

The following route /session/register executes the controller SessionController and its action registerAction.

Configuration
-------------
INVO has a configuration file that sets general parameters in the application. This file is read in the first lines
of the bootstrap file (public/index.php):

.. code-block:: php

    <?php

    //Read the configuration
    $config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/../app/config/config.ini');

:doc:`Phalcon\\Config <config>` allows us to manipulate the file in an object oriented way. The configuration file
contains the following settings:

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

Phalcon hasn't any pre-defined convention settings. Sections help us to organize the options as appropriate. In this file
there are three sections to be used later.

Autoloaders
-----------
A second part that appears in the boostrap file (public/index.php) is the autoloader. The autoloader registers a set
of directories where the application will look for the classes that it eventually will need.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            __DIR__ . $config->application->controllersDir,
            __DIR__ . $config->application->pluginsDir,
            __DIR__ . $config->application->libraryDir,
            __DIR__ . $config->application->modelsDir,
        )
    )->register();

Note that what has been done is registing the directories that were defined in the configuration file. The only
directory that is not registered is the viewsDir, because it contains no classes but html + php files.

Handling the Request
--------------------
Let's go much further, at the end of the file, the request is finally handled by Phalcon\\Mvc\\Application,
this class initializes and executes all the necessary to make the application run:

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();

Dependency Injection
--------------------
Look at the second line of the code block above, the variable $application is receiving another variable $di.
What is the purpose of that variable? Phalcon is a highly decoupled framework, so we need a component that acts as glue
to make everything work together. That component is Phalcon\\DI. It is a service container that also performs
dependency injection, instantiating all components, as they are needed by the application.

There are many ways of registering services in the container. In INVO most services have been registered using
anonymous functions. Thanks to this, the objects are instantiated in a lazy way, reducing the resources needed
by the application.

For instance, in the following excerpt is registered the session service, the anonymous function will only be
called when the application requires access to the session data:

.. code-block:: php

    <?php

    //Start the session the first time when some component request the session service
    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

Here we have the freedom to change the adapter, perform additional initialization and much more. Note that the service
was registered using the name "session". This is a convention that will allow the framework to identify the active
service in the services container.

A request can use many services, register each service one to one can be a cumbersome task. For that reason,
the framework provides a variant of Phalcon\\DI called Phalcon\\DI\\FactoryDefault whose task is to register
all services providing a full-stack framework.

.. code-block:: php

    <?php

    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full stack framework
    $di = new \Phalcon\DI\FactoryDefault();

It registers the majority of services with components provided by the framework as standard. If we need to override
the definition of some service we could just set it again as we did above with "session". This is the reason for the
existence of the variable $di.

Log into the Application
------------------------
Log in will allow us to work on backend controllers. The separation between backend's controllers and the frontend ones
is only logical. All controllers are located in the same directory.

To enter into the system, we must have a valid username and password. Users are stored in the table "users"
in the database "invo".

Before we can start session, we need to configure the connection to the database in the application. A service
called "db" is set up in the service container with that information. As with the autoloader, this time we are
also taking parameters from the configuration file to configure a service:

.. code-block:: php

    <?php

    // Database connection is created based on the parameters defined in the configuration file
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

Here we return an instance of the MySQL connection adapter. If needed, you could do extra actions such as adding a
logger, a profiler or change the adapter, setting up it as you want.

Back then, the following simple form (app/views/session/index.phtml) requests the logon information. We've removed
some HTML code to make the example more concise:

.. code-block:: html+php

    <?php echo Tag::form('session/start') ?>

        <label for="email">Username/Email</label>
        <?php echo Tag::textField(array("email", "size" => "30")) ?>

        <label for="password">Password</label>
        <?php echo Tag::passwordField(array("password", "size" => "30")) ?>

        <?php echo Tag::submitButton(array('Login')) ?>

    </form>

The SessionController::startAction (app/controllers/SessionController.phtml) has the task of validate the
data entered checking for a valid user in the database:

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
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome '.$user->name);

                    //Forward to the 'invoices' controller if the user is valid
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

For simplicity, we have used "sha1_" to store the password hashes in the database, however, this algorithm is
not recommended in real applications, use " :doc:`bcrypt <security>`" instead.

Note that multiple public attributes are accessed in the controller like: $this->flash, $this->request or $this->session.
These are services defined in services container from earlier. When they're accessed the first time, are injected as part
of the controller.

These services are shared, which means that we always are accessing the same instance regardless of the place
where we invoke them.

For instance, here we invoke the "session" service and then we store the user identity in the "auth" variable:

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

Securing the Backend
--------------------
The backend is a private area where only registered users have access. Therefore it is necessary to check that only
registered users have access to these controllers. If you aren't logged in the application and you try to access,
for example, the products controller (that is private) you'll see a screen like this:

.. figure:: ../_static/img/invo-2.png
   :align: center

Every time someone attempts to access any controller/action, the application verifies that the current role (in session)
has access to it, otherwise it displays a message like the above and forwards the flow to the home page.

Now let's find out how the application accomplishes this. The first thing to know is that there is a component called
:doc:`Dispatcher <dispatching>`. It is informed about the route found by the :doc:`Routing <routing>` component. Then
it is responsible for loading the appropriate controller and execute the corresponding action method.

Normally, the framework creates the Dispatcher automatically. In our case, we want to perform a verification
before executing the required action, checking if the user has access to it or not. To achieve this, we have
replaced the component by creating a function in the bootstrap:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

We now have total control over the Dispatcher used in the application. Many components in the framework launch
events that allow us to modify the internal flow of operation. As the dependency Injector component acts as glue
for components, a new component called :doc:`EventsManager <events>` aids us to intercept the events produced
by a component routing the events to listeners.

Events Management
^^^^^^^^^^^^^^^^^
A :doc:`EventsManager <events>` allows us to attach listeners to a particular type of event. The type that
interest us now is "dispatch", the following code filters all events produced by the Dispatcher:

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

The Security plugin is a class located at (app/plugins/Security.php). This class implements the method
"beforeExecuteRoute". This is the same name as one of the events produced in the Dispatcher:

.. code-block:: php

    <?php

    use \Phalcon\Events\Event;
    use \Phalcon\Mvc\Dispatcher;

    class Security extends Phalcon\Mvc\User\Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }

    }

The hooks events always receive a first parameter that contains contextual information of the event produced and a
second one that is the object that produced the event itself. It is not mandatory that plugins extend the class
Phalcon\\Mvc\\User\\Plugin, but by doing it they gain easier access to the services in the application.

Now, we're verifying the role in the current session, check to see if he/she has access using the ACL list.
If he/she does not have access we redirect him/her to the home screen as explained before:

.. code-block:: php

    <?php

    use \Phalcon\Events\Event;
    use \Phalcon\Mvc\Dispatcher;

    class Security extends Phalcon\Mvc\User\Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
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
In the previous example we have obtained the ACL using the method $this->_getAcl(). This method is also
implemented in the Plugin. Now we going to explain step by step how we built the access control list:

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
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

Now we define the resources for each area respectively. Controller names are resources and their actions are
accesses for the resources:

.. code-block:: php

    <?php

    //Private area resources (backend)
    $privateResources = array(
        'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
        'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
        'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
        'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    //Public area resources (frontend)
    $publicResources = array(
        'index' => array('index'),
        'about' => array('index'),
        'session' => array('index', 'register', 'start', 'end'),
        'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

The ACL now have knowledge of the existing controllers and their related actions. Role "Users" has access to
all the resources of both frontend and backend. The role "Guests" only has access to the public area:

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
All the UI elements and visual style of the application has been achieved mostly through `Twitter Boostrap`_.
Some elements, such as the navigation bar changes according to the state of the application. For example, in the
upper right corner, the link "Log in / Sign Up" changes to "Log out" if a user is logged into the application.

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

This class extends the Phalcon\\Mvc\\User\\Component, it is not imposed to extend a component with this class, but
if it helps to more quickly access the application services. Now, we register this class in the services container:

.. code-block:: php

    <?php

    //Register an user component
    $di->set('elements', function(){
        return new Elements();
    });

As controllers, plugins or components within a view, this component also has access to the services registered
in the container and by just accessing an attribute with the same name as a previously registered service:

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
Most options that manipulate data (companies, products and types of products), were developed using a basic and
common CRUD_ (Create, Read, Update and Delete). Each CRUD contains the following files:

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

Each controller has the following actions:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * The start action, it shows the "search" view
         */
        public function indexAction()
        {
            //...
        }

        /**
         * Execute the "search" based on the criteria sent from the "index"
         * Returning a paginator for the results
         */
        public function searchAction()
        {
            //...
        }

        /**
         * Shows the view to create a "new" product
         */
        public function newAction()
        {
            //...
        }

        /**
         * Shows the view to "edit" an existing product
         */
        public function editAction()
        {
            //...
        }

        /**
         * Creates a product based on the data entered in the "new" action
         */
        public function createAction()
        {
            //...
        }

        /**
         * Updates a product based on the data entered in the "edit" action
         */
        public function saveAction()
        {
            //...
        }

        /**
         * Deletes an existing product
         */
        public function deleteAction($id)
        {
            //...
        }

    }

The Search Form
^^^^^^^^^^^^^^^
Every CRUD starts with a search form. This form shows each field that has the table (products), allowing the user
creating a search criteria from any field. The "products" table has a relationship to the table "products_types".
In this case we previously query the records in this table in order to facilitate the search by that field:

.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->setVar("productTypes", ProductTypes::find());
    }

All the "product types" are queried and passed to the view as a local variable "productTypes". Then in the view
(app/views/index.phtml) we show a "select" tag filled with those results:

.. code-block:: php

    <?php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo Tag::select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Note that $productTypes contains the data necessary to fill the SELECT tag using Phalcon\\Tag::select. Once the form
is submitted, the action "search" is executed in the controller performing the search based on the data entered by
the user.

Performing a Search
^^^^^^^^^^^^^^^^^^^
The action "search" has a dual behavior. When accessed via POST, it performs a search based on the data sent from the
form. But when accessed via GET it moves the current page in the paginator. To differentiate one from another HTTP method,
we check it using the :doc:`Request <request>` component:

.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            //create the query conditions
        } else {
            //paginate using the existing conditions
        }

        //...

    }

With the help of :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, we can create the search
conditions intelligently based on the data types and values sent from the form:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

This method verifies which values are different from "" (empty string) and null and takes them into account to create
the query:

* If the field data type is text or similar (char, varchar, text, etc.) It use a SQL "like" operator to filter the results.
* If the data type is not text or similar, it'll use the operator "=".

Additionally, "Criteria" ignores all the $_POST variables that do not match any field in the table.
Values are automatically escaped using "bound parameters".

Now, we store the produced parameters in the controller's session bag:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

A session bag, is a special attribute in a controller that persists between requests. When accesed, this attribute injects
a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` service, that is independent in each controller.

Then, based on the built params we perform the query:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the
search returned results, then we create a paginator to navigate easily through them:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    //Data to paginate
        "limit" => 5,           //Rows per page
        "page" => $numberPage   //Active page
    ));

    //Get active page in the paginator
    $page = $paginator->getPaginate();

Finally we pass the returned page to view:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

In the view (app/views/products/search.phtml), we traverse the results corresponding to the current page:

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
        $products->id = $request->getPost("id", "int");
        $products->product_types_id = $request->getPost("product_types_id", "int");
        $products->name = $request->getPost("name", "striptags");
        $products->price = $request->getPost("price", "double");
        $products->active = $request->getPost("active");

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

        $product = Products::findFirst(array(
            'id = ?0',
            'bind' => array($id)
        ));

        Tag::displayTo("id", $product->id);
        Tag::displayTo("product_types_id", $product->product_types_id);
        Tag::displayTo("name", $product->name);
        Tag::displayTo("price", $product->price);
        Tag::displayTo("active", $product->active);

    }

The displayTo helper sets a default value in the form on the attribute with the same name. Thanks to this,
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
        $product = Products::findFirst(array(
            'id = ?0',
            'bind' => array($this->request->getPost("id"))
        ));
        if (!$product) {
            $this->flash->error("products does not exist ".$id);
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
.. _Twitter Boostrap: http://bootstrap.github.com/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php