教程 2: 解读分析 INVO 项目
===========================

在第二个教程中，我们将解读分析一个更完整的应用程序，以强化你对Phalcon的理解，INVO是我们已经创建了的作为示例程序的应用程序之一。你可以从 Github_ 获得INVO的全部代码。

此外还需要说明的是，INVO的html实现是使用 `Twitter Bootstrap <http://twitter.github.com/>`_ CSS framework来完成的，在这个示例项目中，并不真正的生成发票(这是一个类似于进销存的相关的应用)，但它作为一个例子还是可以告诉你整个框架是如何工作的。

项目目录结构
------------------
从Github上克隆了源代码后，你可以发现目录结构是这样的：

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

在前面的章节已经讲过，Phalcon并没有固定的目录结构，该项目提供了一个简单的MVC目录结构。

通过浏览器打开应用程序 http://localhost/invo 显示效果如下:

.. figure:: ../_static/img/invo-1.png
   :align: center

INVO应用程序分为两部分，即通常我们说的前台后台。前台部分，用户可以通过INVO查看一些信息，同时可以提交联系方式。后台部分，相当于管理区域，在这里面注册用户可以管理自己的产品和客户。

标准路由器
---------------
INVO使用标准的内奸路由器组件，此路由的匹配模式如下 /:controller/:action/:params  ，这意味着，URL中的第一部分是控制器，第二个是action方法。

路由 /session/register 将要执行SessionController中的RegisterAction方法

Configuration
-------------
INVO有一个配置文件，用于设置一些常用的数据，比如数据库连接参数，目录结构等。在引导文件 (public/index.php) 的第一部分，可以这样读取配置文件

.. code-block:: php

    <?php

    //Read the configuration
    $config = new Phalcon\Config\Adapter\Ini(__DIR__.'/../app/config/config.ini');

:doc:`Phalcon\\Config <config>` 使得读取配置内容是面像对象的，配置文件的定义如下：

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

Phalcon的配置文件可以分类进行定义，在这个文件中，共定义了三个部分 database,application,metadata

Autoloaders
-----------
在引导文件 (public/index.php) 的第二部分是autoloader,autoloader注册了一些目录，在这些目录中放置的是我们应用程序需要用到的类文件

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            __DIR__.$config->application->controllersDir,
            __DIR__.$config->application->pluginsDir,
            __DIR__.$config->application->libraryDir,
            __DIR__.$config->application->modelsDir,
        )
    )->register();

需要注意的是，注册的这些目录并不包括 viewsDir,因为viewsDir中并不包含classes文件，而是html+php文件

处理请求
--------------------
在引导文件的最后部分，我们使用 Phalcon\\Mvc\\Application ，这个类初始化并执行用户的请求

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();

依赖注入
--------------------
看上面代码中的第二段，变量$application通过setDI()方法接收了变量$di,该变量的目的是什么呢？

Phalcon是一个松耦合的框架，所以我们需要一个组件，把它们整合到一起，让它们一起工作，该组件便是 Phalcon\\DI

注册到容器的方法有很多，在INVO中，大都采用匿名函数的方式进行注册，因为此种方式是lazy load的加载方式，减少了应用程序请求资源控制。

例如，在下面的代码片断中的session会话服务，采用的是匿名函数的方式进行注册的，因此当使用session的时候，才会被加载。

.. code-block:: php

    <?php

    //Start the session the first time when some component request the session service
    $di->set('session', function(){
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

在这里，我们可以自由的更改适配器，以使它执行更多的初始化任务，请注意，服务注册的"session"请不要随意修改，这是一个命名约定。

译者注：更多的服务组件命名约定可见 :doc:`dependency injection container <di>`#service-name-conventions

一个请求可能使用多个服务组件，一个一个的注册这些组件是一项繁重的任务，出于这个原因，该框架提供了 Phalcon\\DI 的一个实现，就是 Phalcon\\DI\\FactoryDefault

译者注：其实 Phalcon\\DI\\FactoryDefault 就是 Phalcon\\DI 的一个子类

.. code-block:: php

    <?php

    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full stack framework
    $di = new \Phalcon\DI\FactoryDefault();

It registers the majority of services with components provided by the framework as standard. If we need to override the definition of some
it could be done as above with "session". Now we know the origin of the variable $di.

大多数的服务组件都由框架本身提供，如果我们需要覆盖一些定义的话，比如"session".(翻译的可能不对，英文部分就不去掉了)

Log into the Application
------------------------
登录将使用后端控制器，控制器前后端分离是合乎逻辑的，所有的控制器被放置到相同的目录中。要登录系统，我们必须有一个有效的用户名和密码，用户信息被存储在数据库"invo"的"users"数据表中。

在我们登录系统之前，我们需要在应用程序中配置数据库连接。一个命名为"db"的服务组件被注册，与autoloader相同，我们也从配置文件中读取相关配置连接参数

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

这时，会返回一个MySQL的连接适配器的实例，如果需要的话，你可以做一些其他额外的操作，例如，你还可以定义一个记录器，分析器或更改为其他适配器。或者设置你想要的其他东西

那么，下面的这个表单示例 (app/views/session/index.phtml) 是一个登录入口，已经删除了一些HTML代码，使这个例子更简洁：

.. code-block:: html+php

    <?php echo Tag::form('session/start') ?>

        <label for="email">Username/Email</label>
        <?php echo Tag::textField(array("email", "size" => "30")) ?>

        <label for="password">Password</label>
        <?php echo Tag::passwordField(array("password", "size" => "30")) ?>

        <?php echo Tag::submitButton(array('Login')) ?>

    </form>

The SessionController::startAction (app/controllers/SessionController.phtml) have the task of validate the entered data checking
for a valid user in the database:

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
The backend is a private area where only registered users have access. Therefore it is necessary to check that only registered users
have access to these controllers. If you aren't logged in the application and you try to access by example the products controller
(that is private) you'll see a screen like this:

.. figure:: ../_static/img/invo-2.png
   :align: center

Every time someone try to access any controller and action, the application verifies that the current role has access to it, otherwise
it displays a message like the above and forwards the flow to the home page.

Now let's find out how the application accomplishes this. The first thing to know is that there is a component called Dispatcher. It is
informed about the route found by the component Router. Based on this is responsible for loading the appropriate controller and execute
the corresponding action method.

Normally, the framework creates the Dispatcher automatically. In our case, we want to make a special action that is check before
executing the required action if the user has access to it or not. To achieve this we replace the component by creating a function
defined by us in the bootstrap:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

We now have total control of the Dispatcher used by the application. Now, many components of the framework launch events that allow us
to modify the internal flow of operation. As the dependency Injector component acts as glue for components, a new component called
EventsManager helps us to bring the events produced by some component to the objects that require them.

Events Management
^^^^^^^^^^^^^^^^^
A EventsManager allows us to attach listeners to a particular type of event. The type that interests us now is "dispatch" that filters
all events produced by the Dispatcher:

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

The hooks events always receive a first parameter that contains contextual information of the event produced and a second that is the
object that produced the event itself. Plugins should not extend the class Phalcon\\Mvc\\User\\Plugin, but by doing it they gain easier
access to the services of the application.

Now, we're verifying the role in the current session, check to see if he has access using the ACL list. If he does not have access we
redirect hom to the home screen as explained:

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

The ACL now have knowledge of the existing controllers and their related actions. The role "Users" has access to all the resources
of both the frontend and the backend. The role "Guests" only have access to the public area:

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
All the UI elements and visual style of the application has been achieved mostly through Twitter Boostrap. Some elements, such as the
navigation bar change according to the state of the application. For example, in the upper right corner, the link "Log in / Sign Up"
changes to "Log out" if a user is logged into the application.

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

This class extends the Phalcon\\Mvc\\User\\Component, it is not imposed to extend a component with this class, but if it helps to
more quickly access the application services. Now, we register this class in the Dependency Injector Container:

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
Most options that manipulate data (companies, products and types of products), were developed using a basic and common CRUD_ (Create,
Read, Update and Delete). Each CRUD contains the following files:

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

Each controller have the following actions:

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
Every CRUD starts with a search form. This form shows each field that has the table (products), allowing the user to create a search criteria from any field.
The "products" table has a relationship to the table "products_types". In this case we previously query the records in this table in order to
facilitate the search by that field:

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

All the "product types" are queried and passed to the view as a local variable "productTypes". Then in the view (app/views/index.phtml) we show a "select" tag
filled with those results:

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

Note that the $productTypes contains the data necessary to fill the SELECT tag with Phalcon\\Tag::select. Once the form is submitted, it will
execute the action "search" in the controller who will perform the search based on the data entered by the user.

Performing a Search
^^^^^^^^^^^^^^^^^^^
The action "search" has a dual behavior. When accessed via POST, it performs a search based on the data sent from the form.
But when accessed via GET it moves the current page in the paginator. To differentiate one from the other HTTP method,
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

With the help of :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, we can create the search conditions
intelligently based on the data types and values sent from the form:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

This method verifies which values are different from "" (empty string) and null and takes them into account to create the query:
If the data type of a field is text or similar (char, varchar, text, etc.) it will use a "like" operator to filter the results.
If the data type is not text or similar, it'll use the operator "=".

Additionally, "Criteria" ignores all the $_POST variables that do not match any field in the table. Also, values ​​are automatically escaped
using "bound parameters".

Now, we store the produced params in the controller's session bag:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

A session bag, is a special attribute of a controller that persists between requests. When accesed, this attribute injects
a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` service, that's independent in each controller.

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

    <?php foreach($page->items as $product){ ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= Tag::linkTo("products/edit/".$product->id, 'Edit') ?></td>
            <td><?= Tag::linkTo("products/delete/".$product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

Creating and Updating Records
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views the data entered by the user
are sent to the actions "create" and "save" that perform actions of "create" and "update" products respectively.

In the creation case, we recover the data sent and assign them to a new "products" instance:

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

Data is filtered before being assigned to the object. When saving we'll know whether the data conforms to the business rules
and validations implemented in the model Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        //...

        if (!$products->save()) {

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

Now in the case of product updating, first we must present to the user the data currently in the edited record:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        //...

        $product = Products::findFirst("id = '$id'");

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
        $id = $request->getPost("id", "int");
        $products = Products::findFirst("id='$id'");
        if ($products == false) {
            $this->flash->error("products does not exist ".$id);
            return $this->forward("products/index");
        }

        //... assign the values to the object and store it

    }

Changing the Title Dynamically
------------------------------
When you browse between one option and another will see that the title changes dynamically indicating where we are currently working.
This is achieved in each controller initializer:

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
This tutorial covers many more aspects of building applications with Phalcon, hope you have served to learn more and get more out of the framework.

.. _Github: https://github.com/phalcon/invo
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
