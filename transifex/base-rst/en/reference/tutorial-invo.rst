%{tutorial-invo_7f678843ac2d35108253ef04bcf88ddb}%

===========================
%{tutorial-invo_28c87f3f9c6f429bc7d90c5c7ede0254}%


%{tutorial-invo_ac3ab2c91385234f4e6ff0ab6e00dd9f}%

%{tutorial-invo_3709570c902e1a2ffa6c5fba641e54c6}%

-----------------
%{tutorial-invo_3595f28c91fe068a1929221da9da0b1f}%


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

%{tutorial-invo_75908b9dde1d89de02a927f9f76ffa2d}%

%{tutorial-invo_6e14d8418b95f3a464b13f043e60823c}%

.. figure:: ../_static/img/invo-1.png
   :align: center


%{tutorial-invo_fa6a84822536f4cbe05b457b2cc3889e}%

%{tutorial-invo_476a8980062af9e778f675c1bc4f73ef}%

-------
%{tutorial-invo_d7b7bba4cbcbb48d2596f87e32f1c450}%


%{tutorial-invo_5c32f015aa0d105ddec5444b5185b6b6}%

%{tutorial-invo_577e542402540b811d7f352af537ba5b}%

-------------
%{tutorial-invo_0f64b3448ec641451739dbeb43924bd0}%


.. code-block:: php

    <?php

    //{%tutorial-invo_b4d7f51ad0fa394bbe43700f43672ce5%}
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

:doc:`Phalcon\\Config <config>` allows us to manipulate the file in an object-oriented way. The configuration file
%{tutorial-invo_cedd34fb9d17470ea65834728f1e26fd}%

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

%{tutorial-invo_588f03a27c4c29f99bed53ee23b0025a}%

%{tutorial-invo_adfc9fa0f9bf18986bec56424adfc389}%

-----------
%{tutorial-invo_12beceff46c93213f99a13d60b70ac77}%


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

%{tutorial-invo_137ec25fc74fb514ac12ab593b829ff4}%

%{tutorial-invo_02b8283e2b5e81cef94cd2a9e239e791}%

--------------------
%{tutorial-invo_fc0446f7b7e5aadf1071f94bea6efb6f}%


.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle()->getContent();

%{tutorial-invo_e287a0208a30ff5691eec26a26f4053f}%

--------------------
%{tutorial-invo_3ec6f2564704e630120e116745184575}%


%{tutorial-invo_a8fb6fc5ad16bcd173179410158ff3a1}%

%{tutorial-invo_9c2337296eba2c2cc99ed9dbcb8f1d9f}%

.. code-block:: php

    <?php

    //{%tutorial-invo_a53ecd6d59ae8e71e9c509c31fad61f4%}
    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

%{tutorial-invo_91c3fc975a1658e292ecac25e55fc970}%

%{tutorial-invo_708c7328d83cde6ff62a3cacc6b28de9}%

.. code-block:: php

    <?php

    // {%tutorial-invo_83a2afdf8653199f242fc72420d594b4%}
    // {%tutorial-invo_d1a71d84103a9d4b6d8ba6bcce6b9f93%}
    $di = new \Phalcon\DI\FactoryDefault();

%{tutorial-invo_a787ad22760b1f73e9cda20f50d5c344}%

%{tutorial-invo_5b97780299ed550071e7955b0517768a}%

------------------------
%{tutorial-invo_322e594cab612f0c807bacfaee7406a6}%


%{tutorial-invo_95f9d3b98ad50727cfe19a6f922de35b}%

%{tutorial-invo_f36053e45a4135190a5fbe3a2e761548}%

.. code-block:: php

    <?php

    // {%tutorial-invo_b93b3566ee61b9b153fb8a20c91b6bc1%}
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

%{tutorial-invo_e0578ace1f9cd8cacb5b476d51cafd0d}%

%{tutorial-invo_abb08affd2830c36019591cee0d408e0}%

.. code-block:: html+php

    <?php echo $this->tag->form('session/start') ?>

        <label for="email">Username/Email</label>
        <?php echo $this->tag->textField(array("email", "size" => "30")) ?>

        <label for="password">Password</label>
        <?php echo $this->tag->passwordField(array("password", "size" => "30")) ?>

        <?php echo $this->tag->submitButton(array('Login')) ?>

    </form>

%{tutorial-invo_b729f426196bb65221a48821be88864a}%

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

                //{%tutorial-invo_7629e660109c94f016c45e89d657ca33%}
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                //{%tutorial-invo_e189c36be6ca20f2b7d227aaa8761db1%}
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);

                    //{%tutorial-invo_63fb26bc4d9c7ab8bf81502da870e512%}
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            //{%tutorial-invo_c33aa491286ca250046f8a93cfd687e8%}
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'index'
            ));

        }

    }

%{tutorial-invo_a6a7455d565fbce3058220eb66e73a93}%

%{tutorial-invo_6dacbb6b00b1e8395f607c3934435e81}%

%{tutorial-invo_e2c9b701c0e9e94a581b2d2986ea9b74}%

%{tutorial-invo_0ab5be587254263ea652f29c1eb8edd3}%

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

%{tutorial-invo_aef0bb1a5d3d66a8332cef8e6a94b36b}%

--------------------
%{tutorial-invo_7ff4f2f6d194c678c5b2a677ad52b0ca}%


.. figure:: ../_static/img/invo-2.png
   :align: center


%{tutorial-invo_4530981ad58b22a504c8538bb2ba1c1a}%

%{tutorial-invo_daa7e05e103410eb401a91faef00621d}%

%{tutorial-invo_3e0157a6079d73b316fe4f72545941b8}%

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

%{tutorial-invo_3c588d3feb3bfd79325b3f94f222b046}%

%{tutorial-invo_c9f4b22767d8d72f8d8f7c31ef2e8f39}%

^^^^^^^^^^^^^^^^^
%{tutorial-invo_de1c934fd8d84c13a7af25f3c5976e50}%


.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {

        //{%tutorial-invo_f4d9a2e02e14cc0acafaa042c1a85a33%}
        $eventsManager = $di->getShared('eventsManager');

        //{%tutorial-invo_dfd6fe9068ad78c81e62a83693421bd8%}
        $security = new Security($di);

        //{%tutorial-invo_a80818b6ed36ce329c3f05566a104c64%}
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        //{%tutorial-invo_14ed8db418ae27c9461874df48e65089%}
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

%{tutorial-invo_49945e223fac5fff337e28082f473b56}%

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
	    Phalcon\Mvc\User\Plugin,
	    Phalcon\Mvc\Dispatcher,
	    Phalcon\Acl;

    class Security extends Plugin
    {

        // ...

        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }

    }

%{tutorial-invo_abbbb05b3359e05192b20ea78670538d}%

%{tutorial-invo_d91b1e0723209030c21df36ca0546361}%

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
	    Phalcon\Mvc\User\Plugin,
	    Phalcon\Mvc\Dispatcher,
	    Phalcon\Acl;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {

            //{%tutorial-invo_61890578f73112f18e21cbc1c54d5233%}
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            //{%tutorial-invo_d71df499ae6087485fdf76c17c4fe5e5%}
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            //{%tutorial-invo_84e64d27d45cc985b15fcfe4f4368d18%}
            $acl = $this->getAcl();

            //{%tutorial-invo_91e1a311fe450061f625e66a7e0e53aa%}
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Acl::ALLOW) {

                //{%tutorial-invo_223b2be953d2a6535350d55f547bffab%}
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                //{%tutorial-invo_77e7f5fb0cc4657a13957948354e36fe%}
                return false;
            }

        }

    }

%{tutorial-invo_9cea4724960c835baa2852b846dd6016}%

^^^^^^^^^^^^^^^^^^^^^
%{tutorial-invo_bee07cbc99e3a264008d9ed852f41c71}%


.. code-block:: php

    <?php

    //{%tutorial-invo_24fdb2fe8ae69a7e3dd95739aa21609d%}
    $acl = new Phalcon\Acl\Adapter\Memory();

    //{%tutorial-invo_142985241bac55e61f67b3f8df1b2d3b%}
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    //{%tutorial-invo_540e48a3dcfa4ad701652cdf74c37733%}
    //{%tutorial-invo_1bb51fb376980fe00d07697d579e918e%}
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

%{tutorial-invo_7026c3b77198230256acb465f3a9c2f4}%

.. code-block:: php

    <?php

    //{%tutorial-invo_db7b9266f48492d4019507f9bc43f0ef%}
    $privateResources = array(
      'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    //{%tutorial-invo_cd4d3ce711c8db1b1f18a3a315420722%}
    $publicResources = array(
      'index' => array('index'),
      'about' => array('index'),
      'session' => array('index', 'register', 'start', 'end'),
      'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

%{tutorial-invo_c07226da143bc2c3f942a0848decadcc}%

.. code-block:: php

    <?php

    //{%tutorial-invo_d7e8f62a25954bc85f63c86ed94f1be4%}
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    //{%tutorial-invo_1e19fec469d8ac4bdf7a077cd03ef0f1%}
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

%{tutorial-invo_e9dbb0059898c51f12006f932f8c1dd5}%

%{tutorial-invo_344fc05aa62dcb9673334da792893b93}%

---------------
%{tutorial-invo_57e2b48b089d9d2f96f0f9e6d3a0b9b5}%


%{tutorial-invo_ced89705bbf6110384fbd0acf9fda9c2}%

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

%{tutorial-invo_9531e943076090778f9c27bde71c4471}%

.. code-block:: php

    <?php

    //{%tutorial-invo_97a543993153e65120d2f152d0644545%}
    $di->set('elements', function(){
        return new Elements();
    });

%{tutorial-invo_3298ad06f43c0854b544871881d467fb}%

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

%{tutorial-invo_f6fceb057eb0510f64c434de3c040a62}%

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

%{tutorial-invo_d6159fee9dcdb02f83a84e5963335e0c}%

---------------------
%{tutorial-invo_9ee5803894783396314a436a4cb0106a}%


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

%{tutorial-invo_4acb74ee1cce36f3fbebc37e5621a553}%

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

%{tutorial-invo_004196ab227c39c85765e52a45bbe66e}%

^^^^^^^^^^^^^^^
%{tutorial-invo_5227de8e3efb5114e3fc9a1d26df81bd}%


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

%{tutorial-invo_ba1e50925dfae3c5dd6293072ca8c965}%

.. code-block:: html+php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo $this->tag->select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

%{tutorial-invo_c593bd8013467e104dd0642ebaaeffad}%

%{tutorial-invo_878b6c9b94eecff7d42c40c0a88f17fc}%

^^^^^^^^^^^^^^^^^^^
%{tutorial-invo_4bdf622ba4b8df6bea1a3fe56c2a7eef}%


.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            //{%tutorial-invo_540375dd31a0814ecfd754d945897e44%}
        } else {
            //{%tutorial-invo_22c40cca3e11b36e34a4fe9d587303db%}
        }

        //...

    }

%{tutorial-invo_873f0b1a86c8883b91fdc7b2d1784af5}%

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

%{tutorial-invo_d1186bc6648b7a474a9cf8ec6f717938}%

* {%tutorial-invo_5e90ae02ef6aaa4078321b45f7366a82%}
* {%tutorial-invo_ff43286f549da031945d2ef610eb239a%}

%{tutorial-invo_f16803e5e4e4781ab80b5e3af828d753}%

%{tutorial-invo_6caf2bedd153027659b27aac568be957}%

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

%{tutorial-invo_e5bf9dd94d8dcd7bec5fae63ccd182b8}%

%{tutorial-invo_c338b2537f1f16b3ca021730bbdd2a14}%

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

%{tutorial-invo_2ac0ffc01b2e7a5127175e85f1df122a}%

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    //{%tutorial-invo_14d76d54ab3780f362707c0c1a6aa341%}
        "limit" => 5,           //{%tutorial-invo_3995e76cfbc85dea7472c8a1aa627244%}
        "page" => $numberPage   //{%tutorial-invo_37dda05f52e43d78e8a236067e4f3a6f%}
    ));

    //{%tutorial-invo_d3f60f2e030e7abb46c7b667f889dd88%}
    $page = $paginator->getPaginate();

%{tutorial-invo_4f82dd83f8b26b62f125100bf36329dc}%

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

%{tutorial-invo_e34ffd22274b86356c4d1be9f9683881}%

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= $this->tag->linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= $this->tag->linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

%{tutorial-invo_aa52b2b622e15d091d9cc395b0f14db8}%

^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{tutorial-invo_78e83a0627fcaf60669852c539e75834}%


%{tutorial-invo_498ec53e4e2584b114f9af6eae419474}%

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

%{tutorial-invo_d100834542c3422f40ed6487d235b62c}%

%{tutorial-invo_b32e8a40b7344f7cb1fe0ebb7ec3dc11}%

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        //...

        if (!$products->create()) {

            //{%tutorial-invo_565702a96de97f534f750ff24ec7240e%}
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

%{tutorial-invo_45eed66953916c4823a5a774ef5bdc14}%

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        //...

        $product = Products::findFirstById($id);

        $this->tag->setDefault("id", $product->id);
        $this->tag->setDefault("product_types_id", $product->product_types_id);
        $this->tag->setDefault("name", $product->name);
        $this->tag->setDefault("price", $product->price);
        $this->tag->setDefault("active", $product->active);

    }

%{tutorial-invo_34bb04a68cd7071e63e0532e69dfd5cb}%

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        //...

        //{%tutorial-invo_18d0cfa0302d0892b52b2f31cae98c00%}
        $id = $this->request->getPost("id");
        $product = Products::findFirstById($id);
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        //{%tutorial-invo_1870ec2d65eb717be0cd826df7b226fa%}

    }

%{tutorial-invo_d3e60867c9d627bfaa7532c66363a4b4}%

------------------------------
%{tutorial-invo_3d8283201c2745d21e667cb1c6c849c0}%


.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        public function initialize()
        {
            //{%tutorial-invo_e40f3f04296994421b72cd0ebe40983c%}
            $this->tag->setTitle('Manage your product types');
            parent::initialize();
        }

        //...

    }

%{tutorial-invo_2a146b29effa81a28c1281d71026db93}%

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon\Mvc\Controller
    {

        protected function initialize()
        {
            //{%tutorial-invo_ced1d5f8a71cc3b20eb5edd43467ca9c%}
            $this->tag->prependTitle('INVO | ');
        }

        //...
    }

%{tutorial-invo_f363a6391b33a732adff55762bd3fb44}%

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle() ?>
        </head>
        <!-- ... -->
    </html>

%{tutorial-invo_ee50f1d496b9cd00d5955f10f6dc7517}%

----------
%{tutorial-invo_2e7acbb8a1808a4356beef6e2c853ba9}%


