%{tutorial_9abbbf47909e7ad733fa62e85cb0db75}%
==================================
%{tutorial_dd40a0d83c2ebb146c6f7c9dde793992|:doc:`developer tools <tools>`}%

%{tutorial_37ce9f89b0b1cb6b762c7196bc18ec5f}%
--------------------------
%{tutorial_1b7c81bdd8889e1c836ffb605111f96e}%

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>


%{tutorial_2254c8131756bb51a2ecac8179a78b7b}%

.. code-block:: php

    Array
    (
        [0] => Core
        [1] => libxml
        [2] => filter
        [3] => SPL
        [4] => standard
        [5] => phalcon
        [6] => pdo_mysql
    )


%{tutorial_bcd21c14594d49fe915b68d70495a843}%
------------------
%{tutorial_dcc8e4dbd5d5aeff407c940493e85a5f|`here <https://github.com/phalcon/tutorial>`_}%

%{tutorial_e43ba4039b13f24962a8c6077d982e4b}%
^^^^^^^^^^^^^^
%{tutorial_61cd3d35ca698a2955d9cb11fa63ca24}%

%{tutorial_e213c33711b80713e577d9c25337c509}%

.. code-block:: php

    tutorial/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/


%{tutorial_d69fe7a293029155d4f8eb9706d65cc1}%

%{tutorial_c9201f5cc910e6fa29ca3304fee066a1}%
^^^^^^^^^^^^^^
%{tutorial_1fec206e257daffc0d5b007cdfd72e72}%

%{tutorial_0a2bafae2f2945e3d51e54c2cb96a16c}%

.. code-block:: apacheconf

    #/tutorial/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>


%{tutorial_01919fda1bcf16efef7a53cd304cef25}%

%{tutorial_8c4cb378ab50e4fb92587f3b8459b2fb}%

.. code-block:: apacheconf

    #/tutorial/public/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>


%{tutorial_e942a5f80992ee93b462ea2482b2afc5}%
^^^^^^^^^
%{tutorial_aebd8b2ff258a0ae81307e715cb76197}%

%{tutorial_4e04bc143fc46769f56e4ce0ad9bcfd2}%

.. code-block:: php

    <?php

    try {

        //{%tutorial_a03eb182a7972d89257df899a9e4893e%}
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers/',
            '../app/models/'
        ))->register();

        //{%tutorial_446a265dc67feeb5747918302f071767%}
        $di = new Phalcon\DI\FactoryDefault();

        //{%tutorial_b2c341141b8e4ea7f05673ec24bc33a4%}
        $di->set('view', function(){
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../app/views/');
            return $view;
        });
        
        //{%tutorial_dde6aea21ee4354fac975e3a53f8c93e%}
        $di->set('url', function(){
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/tutorial/');
            return $url;
        });        

        //{%tutorial_6e390072cbe16eea871f567953e9ed8f%}
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch(\Phalcon\Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }


%{tutorial_adfc9fa0f9bf18986bec56424adfc389}%
^^^^^^^^^^^
%{tutorial_308de505979c88301dc76dab7905de5b}%

%{tutorial_bea35d534246978a6e020a6d7f5803f3}%

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/'
        )
    )->register();


%{tutorial_f0f4e1a66ec21c03b055d8e501cb4fa7}%
^^^^^^^^^^^^^^^^^^^^^
%{tutorial_f9818f8386628eac38abefc92be953c2|:doc:`dependency injection container <di>`}%

%{tutorial_35de02fc6f0f765eb64a8c213b2695dd}%

.. code-block:: php

    <?php

    //{%tutorial_446a265dc67feeb5747918302f071767%}
    $di = new Phalcon\DI\FactoryDefault();

:doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon\_DI_FactoryDefault>` is a variant of Phalcon\\DI. To make things easier, it has registered most of the components that come with Phalcon. Thus we should not register them one by one. Later there will be no problem in replacing a factory service.


%{tutorial_b10343867d5a38ecabb698a8d89077c2}%

%{tutorial_6ce1339f303460d63d9ed11e7e3abbee|`anonymous function`_}%

.. code-block:: php

    <?php

    //{%tutorial_b2c341141b8e4ea7f05673ec24bc33a4%}
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });
    

%{tutorial_0943a524b31c7b5f592c4ea71d758716|:doc:`\Phalcon\\Tag <../api/Phalcon_Tag>`}%

.. code-block:: php

    <?php

    //{%tutorial_dde6aea21ee4354fac975e3a53f8c93e%}
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/tutorial/');
        return $url;
    });   


%{tutorial_f7544311601cc8dca79d56981de1e5ec|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();


%{tutorial_ea446940ef9793df0a8c379dccd7e357}%

%{tutorial_8ca989fe8012615fbfff3eae4fa94e0e}%
^^^^^^^^^^^^^^^^^^^^^
%{tutorial_c20772bfe84aac26eb561e3cbb13d636}%

.. code-block:: php

    <?php

    class IndexController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            echo "<h1>Hello!</h1>";
        }

    }


%{tutorial_87a0fd97020586b8d3ea50d9a80b5966}%

.. figure:: ../_static/img/tutorial-1.png
    :align: center



%{tutorial_a0eaaf846c3bcd2d9077c39874eaf46d}%

%{tutorial_cf5eb363412ee2010ef114fd5786aa7e}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{tutorial_339029b02b632c371d94ba2aebd0756e}%

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";


%{tutorial_acc613471f1f1f8c8d40573a8655a821}%

.. code-block:: php

    <?php

    class IndexController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }


%{tutorial_c9b58198f3b1febd4deca7288442a77b|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`views usage here <views>`}%

%{tutorial_c60c8e77213c05815057aebb475194ec}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{tutorial_55841a53ac2ee2c9420c8d664a04df95}%

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo Phalcon\Tag::linkTo("signup", "Sign Up Here!");


%{tutorial_00c68781ce1f57f729e14511d21210e0}%

.. code-block:: html

    <h1>Hello!</h1> <a href="/tutorial/signup">Sign Up Here!</a>


%{tutorial_131c513275dc0f4c31d0977565ef2ef6|:doc:`\Phalcon\\Tag <../api/Phalcon_Tag>`|:doc:`found here <tags>`}%

.. figure:: ../_static/img/tutorial-2.png
    :align: center



%{tutorial_96c5338c6359b3dd55fb6e81befe2739}%

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }


%{tutorial_974c0b1cc84d10d4fdf4f0c71a705e97}%

.. code-block:: html+php

    <?php use Phalcon\Tag; ?>

    <h2>Sign up using this form</h2>

    <?php echo Tag::form("signup/register"); ?>

     <p>
        <label for="name">Name</label>
        <?php echo Tag::textField("name") ?>
     </p>

     <p>
        <label for="email">E-Mail</label>
        <?php echo Tag::textField("email") ?>
     </p>

     <p>
        <?php echo Tag::submitButton("Register") ?>
     </p>

    </form>


%{tutorial_f037b090c33d60731430464d96e62e07}%

.. figure:: ../_static/img/tutorial-3.png
    :align: center

:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` also provides useful methods to build form elements.



%{tutorial_025dbc566325d89aca099fac244edae7}%

%{tutorial_61b7c804bb7efcfcabdcaeff61da855d}%

%{tutorial_ddde1aec1f283152d2b26374920da4ca}%

%{tutorial_50b8655eb688bc4fd616fe4cd490c7d3}%

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

        }

    }


%{tutorial_a485ff15835fc97acf6d435e9dc2c714}%

%{tutorial_0199fa0781bc2af2736301fc88a34dff}%
^^^^^^^^^^^^^^^^
%{tutorial_d83190abfc28016cd871726d2d6a760b}%

%{tutorial_c9a7ff2f489fe74a934e87905cf1053a}%

.. code-block:: sql

    CREATE TABLE `users` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(70) NOT NULL,
      `email` varchar(70) NOT NULL,
      PRIMARY KEY (`id`)
    );


%{tutorial_8bf8e13170a848eba43fd0cbd1f511ea}%

.. code-block:: php

    <?php

    class Users extends \Phalcon\Mvc\Model
    {

    }


%{tutorial_862828392de7bf95c93884e331aeb4c9}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{tutorial_113f938008170c70ac87517a5716d95b}%

.. code-block:: php

    <?php

    try {

        //{%tutorial_a03eb182a7972d89257df899a9e4893e%}
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers/',
            '../app/models/'
        ))->register();

        //{%tutorial_446a265dc67feeb5747918302f071767%}
        $di = new Phalcon\DI\FactoryDefault();

        //{%tutorial_748cc1e41c403cd76458fba2c9792f85%}
        $di->set('db', function(){
            return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "test_db"
            ));
        });

        //{%tutorial_b2c341141b8e4ea7f05673ec24bc33a4%}
        $di->set('view', function(){
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../app/views/');
            return $view;
        });
        
        //{%tutorial_dde6aea21ee4354fac975e3a53f8c93e%}
        $di->set('url', function(){
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/tutorial/');
            return $url;
        });       

        //{%tutorial_6e390072cbe16eea871f567953e9ed8f%}
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch(Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }


%{tutorial_1437da6e511407a3142304855b3e3fb2}%

%{tutorial_5d444f51481baf36231e6a4e185a8158}%
^^^^^^^^^^^^^^^^^^^^^^^^^
%{tutorial_8f44876d9d106d13cbeda0fd65a260d5}%

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

            $user = new Users();

            //{%tutorial_165a70665697d1966f0c513b23093766%}
            $success = $user->save($this->request->getPost(), array('name', 'email'));

            if ($success) {
                echo "Thanks for registering!";
            } else {
                echo "Sorry, the following problems were generated: ";
                foreach ($user->getMessages() as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
            
            $this->view->disable();
        }

    }



%{tutorial_2b27fa2286c04daecdf3262e3d65d3b4}%

%{tutorial_4eeecf37adf3f1d3d88107a6e24c97d8}%

%{tutorial_f2796cda2b6284d9e5dc8902fac3a87c}%

.. figure:: ../_static/img/tutorial-4.png
    :align: center



%{tutorial_ee50f1d496b9cd00d5955f10f6dc7517}%
----------
%{tutorial_ac62b9a74c27c662143e17d4072c0e4c}%

%{tutorial_caf1e6f2f68b381886575c075f1fb61b}%
-------------------
%{tutorial_e69c20c6aafef23fa8314a4414be15b7}%

* {%tutorial_13c48a3520e73500c89eb4aaabd09a3f%}
* {%tutorial_1261ccd6ea25d52a8f6c637a0e3d2549%}
* {%tutorial_cf514cdca0a5aff7b5b75a2a6d507303%}
* {%tutorial_44bb83952b52b0f98f6a6fdfbf534a90%}

