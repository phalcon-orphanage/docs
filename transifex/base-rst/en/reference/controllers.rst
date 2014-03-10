%{controllers_25b1751e51f4db9e5adb7a2a78f803ca}%
=================
%{controllers_bf4b085e9456222c0343205ea7a36664}%

%{controllers_ed9480fd88e3f7f8cb2bba7f34ebb212}%

+------------------------+----------------+
| **Phalcon Directory**  | blog           |
+------------------------+----------------+
| **Controller**         | posts          |
+------------------------+----------------+
| **Action**             | show           |
+------------------------+----------------+
| **Parameter**          | 2012           |
+------------------------+----------------+
| **Parameter**          | the-post-title |
+------------------------+----------------+


%{controllers_e367e952dc3cb43e7fc9fe886a1ddb50|:doc:`autoloaders <loader>`}%

%{controllers_5459cfd2ccc38bd6690cb33742588851}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {

        }

    }


%{controllers_b22bf738f3e4113b72498abf8df6a355|:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`}%

%{controllers_02d3b405399bc826fc484d3addd149f3}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($year=2012, $postTitle='some default title')
        {

        }

    }


%{controllers_2c21b67becef8f013925ae48e42ab023}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction()
        {
            $year = $this->dispatcher->getParam('year');
            $postTitle = $this->dispatcher->getParam('postTitle');
        }

    }



%{controllers_19a6c1d67b16bca3fdadab09b2393db7}%
-------------
%{controllers_e91e55a308d6c96d2b485677dcd94a5c}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {
            $this->flash->error("You don't have permission to access this area");

            // {%controllers_cc817334bbec5ea9ce6dbef2709beeaf%}
            $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "signin"
            ));
        }

    }


%{controllers_6ff855eda40562b45266d5cca8c4304b}%

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function signinAction()
        {

        }

    }


%{controllers_3691a17f2697dcb44b08c104f391dda6|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{controllers_fccdec87b5a034198b1461f90176d44d}%
------------------------
%{controllers_d34f232d22a05969120164f8a0929b27|:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public $settings;

        public function initialize()
        {
            $this->settings = array(
                "mySetting" => "value"
            );
        }

        public function saveAction()
        {
            if ($this->settings["mySetting"] == "value") {
                //...
            }
        }

    }

.. highlights::

    Method 'initialize' is only called if the event 'beforeExecuteRoute' is executed with success. This avoid
    that application logic in the initializer cannot be executed without authorization.


%{controllers_6b19a0bf2864067a1e6a0085e7052eec}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function onConstruct()
        {
            //...
        }
    }

.. highlights::

    Be aware that method 'onConstruct' is executed even if the action to be executed not exists
    in the controller or the user does not have access to it (according to custom control access
    provided by developer).


%{controllers_411652177b013fea3c5a63ab616d098f}%
------------------
%{controllers_c79117ca927b44a5930b2df6b750ddeb|:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`}%

.. code-block:: php

    <?php

    $di = new Phalcon\DI();

    $di->set('storage', function() {
        return new Storage('/some/directory');
    }, true);


%{controllers_94459506819f88b2a2ac838eba03c79d}%

.. code-block:: php

    <?php

    class FilesController extends \Phalcon\Mvc\Controller
    {

        public function saveAction()
        {

            //{%controllers_b2208cf876b040c0187766d57bfc1255%}
            $this->storage->save('/some/file');

            //{%controllers_181d6542bb8f71757774650a3b5f8ebe%}
            $this->di->get('storage')->save('/some/file');

            //{%controllers_2e08bddf2d28443f6981d0ebac2e1933%}
            $this->di->getStorage()->save('/some/file');

            //{%controllers_2e08bddf2d28443f6981d0ebac2e1933%}
            $this->getDi()->getStorage()->save('/some/file');

            //{%controllers_5d153ad04010e51b3b558a93314486c4%}
            $this->di['storage']->save('/some/file');
        }

    }


%{controllers_aac2efc260d88f42bec7fa4d3c0cf2d0|:doc:`by default <di>`}%

%{controllers_feb531e6a51594e44fe697f022410250}%
--------------------
%{controllers_78b818902e26bdd57e13cdd9f1c27419|:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`|:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`}%

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {
            // {%controllers_eeef46c52d2f8fda1b6593681b414c9f%}
            if ($this->request->isPost() == true) {
                // {%controllers_7bc4b7c3a07971acba3c23c3ae0de905%}
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }

    }


%{controllers_576579805e31f7288878eba1be8ac44c}%

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // {%controllers_c749472b7adc3814922c76d471990109%}
            $this->response->setStatusCode(404, "Not Found");
        }

    }


%{controllers_1723e79963b9d5cbfdb220ead5c2ff5f|:doc:`request <request>`|:doc:`response <response>`}%

%{controllers_0e5d8f24b3a76c0a332a39078578993b}%
------------
%{controllers_9af1ea6757c3ffe81059d7807e7aff96|:doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`}%

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            $this->persistent->name = "Michael";
        }

        public function welcomeAction()
        {
            echo "Welcome, ", $this->persistent->name;
        }

    }


%{controllers_289076e758f9ec58874175d1848fef0a}%
-----------------------------
%{controllers_383734707de80ee854c1540332570694}%

.. code-block:: php

    <?php

    //{%controllers_488248aa224f04bf34e44796a2a8c3f9%}
    $di->set('IndexController', function() {
        $component = new Component();
        return $component;
    });

    //{%controllers_75c4233f2ddc0eea12e9d70201865ffa%}
    $di->set('Backend\Controllers\IndexController', function() {
        $component = new Component();
        return $component;
    });


%{controllers_95181cdd38a7d3718cd1ea894b8ea8ba}%
--------------------------
%{controllers_51fedd99fe59a5bf8cac3855adce33cc|DRY_}%

%{controllers_277976e04abafe373f2f0cd83bc81a1f}%

.. code-block:: php

    <?php

    require "../app/controllers/ControllerBase.php";


%{controllers_439861a197b139299f3790be82d52147}%

.. code-block:: php

    <?php

    class ControllerBase extends \Phalcon\Mvc\Controller
    {

      /**
       * This action is available for multiple controllers
       */
      public function someAction()
      {

      }

    }


%{controllers_f81751d69164a318d542be4710e6541e}%

.. code-block:: php

    <?php

    class UsersController extends ControllerBase
    {

    }


%{controllers_281b6889c8920b0f05e770706f719a10}%
---------------------
%{controllers_37e837df535716a756662358b9e8f390|:doc:`dispatcher <dispatching>`}%

