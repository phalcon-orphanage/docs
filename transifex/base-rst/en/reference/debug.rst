%{debug_4eface2a7de663488d577e631a23894c}%
======================
%{debug_d41d8cd98f00b204e9800998ecf8427e}%

.. figure:: ../_static/img/xdebug-1.jpg
    :align: center


%{debug_c6e61d0ed51257a83ac8eaeb5f14ebff}%

%{debug_210c8aebc2022b155df5c183bb5cb17f}%

%{debug_73f8f95e13a4d7741a9512277b7c4d7f}%
-------------------
%{debug_523cc31a1df32a41cce5d95b2c0715e8}%

.. code-block:: php

    <?php

    try {

        //{%debug_3712839acd032789c6e0543d9ffbb3b8%}

    } catch(\Exception $e) {

    }

%{debug_22849b339431bce03f0835fc32fb96f2}%

%{debug_ff7c8cba77174e8b62a1422d036000c9}%

.. code-block:: php

    <?php

    class Exception
    {

        /* Properties */
        protected string $message;
        protected int $code;
        protected string $file;
        protected int $line;

        /* Methods */
        public __construct ([ string $message = "" [, int $code = 0 [, Exception $previous = NULL ]]])
        final public string getMessage ( void )
        final public Exception getPrevious ( void )
        final public mixed getCode ( void )
        final public string getFile ( void )
        final public int getLine ( void )
        final public array getTrace ( void )
        final public string getTraceAsString ( void )
        public string __toString ( void )
        final private void __clone ( void )

    }

%{debug_34812fc23abd0aa6627bef42421964f1}%

.. code-block:: php

    <?php

    try {

        //{%debug_f36f4e4ca08d1a24df7acfd497195a50%}

    } catch(\Exception $e) {
        echo get_class($e), ": ", $e->getMessage(), "\n";
        echo " File=", $e->getFile(), "\n";
        echo " Line=", $e->getLine(), "\n";
        echo $e->getTraceAsString();
    }

%{debug_dd49308420b07ae1c4378aae66682c09}%

.. code-block:: html

    PDOException: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost'
        (using password: NO)
     File=/Applications/MAMP/htdocs/invo/public/index.php
     Line=74
    #0 [internal function]: PDO->__construct('mysql:host=loca...', 'root', '', Array)
    #1 [internal function]: Phalcon\Db\Adapter\Pdo->connect(Array)
    #2 /Applications/MAMP/htdocs/invo/public/index.php(74):
        Phalcon\Db\Adapter\Pdo->__construct(Array)
    #3 [internal function]: {closure}()
    #4 [internal function]: call_user_func_array(Object(Closure), Array)
    #5 [internal function]: Phalcon\DI->_factory(Object(Closure), Array)
    #6 [internal function]: Phalcon\DI->get('db', Array)
    #7 [internal function]: Phalcon\DI->getShared('db')
    #8 [internal function]: Phalcon\Mvc\Model->getConnection()
    #9 [internal function]: Phalcon\Mvc\Model::_getOrCreateResultset('Users', Array, true)
    #10 /Applications/MAMP/htdocs/invo/app/controllers/SessionController.php(83):
        Phalcon\Mvc\Model::findFirst('email='demo@pha...')
    #11 [internal function]: SessionController->startAction()
    #12 [internal function]: call_user_func_array(Array, Array)
    #13 [internal function]: Phalcon\Mvc\Dispatcher->dispatch()
    #14 /Applications/MAMP/htdocs/invo/public/index.php(114): Phalcon\Mvc\Application->handle()
    #15 {main}

%{debug_072141f2639a9394589c5183686392f0}%

%{debug_6815edaaedecedc259ccc2bf3bc9a8ab}%
---------------
%{debug_34bf6cfe26a83342319188f04ea2a32b}%

%{debug_e5db5bbfbd5738ab0936ea57d5410a0d}%

.. raw:: html

    <div align="center">
        <iframe src="http://player.vimeo.com/video/68893840" width="500" height="313" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>


%{debug_bf2492c60695469d81765ce32b7d132a}%

.. code-block:: php

    <?php

    $debug = new \Phalcon\Debug();
    $debug->listen();

%{debug_3f66fbeb4a21fd9a31b32e75e9a6f51b}%

%{debug_3876e10bb15f5eb320587acd70db3601}%
-----------------------------
%{debug_0a2715f107ac2b7b5c8c256d6a7384af}%

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    print_r($router);

%{debug_01a46a264a9d32cbe26455af4cb3f7db}%

.. code-block:: html

    Phalcon\Mvc\Router Object
    (
        [_dependencyInjector:protected] =>
        [_module:protected] =>
        [_controller:protected] =>
        [_action:protected] =>
        [_params:protected] => Array
            (
            )
        [_routes:protected] => Array
            (
                [0] => Phalcon\Mvc\Router\Route Object
                    (
                        [_pattern:protected] => #^/([a-zA-Z0-9\_]+)[/]{0,1}$#
                        [_compiledPattern:protected] => #^/([a-zA-Z0-9\_]+)[/]{0,1}$#
                        [_paths:protected] => Array
                            (
                                [controller] => 1
                            )

                        [_methods:protected] =>
                        [_id:protected] => 0
                        [_name:protected] =>
                    )

                [1] => Phalcon\Mvc\Router\Route Object
                    (
                        [_pattern:protected] => #^/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#
                        [_compiledPattern:protected] => #^/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#
                        [_paths:protected] => Array
                            (
                                [controller] => 1
                                [action] => 2
                                [params] => 3
                            )
                        [_methods:protected] =>
                        [_id:protected] => 1
                        [_name:protected] =>
                    )
            )
        [_matchedRoute:protected] =>
        [_matches:protected] =>
        [_wasMatched:protected] =>
        [_defaultModule:protected] =>
        [_defaultController:protected] =>
        [_defaultAction:protected] =>
        [_defaultParams:protected] => Array
            (
            )
    )


%{debug_73ed294323e5fd47b34d920d3ad4e48d}%
------------
%{debug_6f164c8227eee5c2e705532bdeea1ab4}%

%{debug_3178da61cc3ae187bf088906d7a25306}%

.. raw:: html

    <div align="center">
        <iframe src="http://player.vimeo.com/video/69867342" width="500" height="313" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>


%{debug_ae74bd6270e7f30b07d3ee763d6ea7e9}%

.. highlights::

    We highly recommend use at least XDebug 2.2.3 for a better compatibility with Phalcon


%{debug_0a9948cd276e0d53c835519557be16f9}%

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

            // {%debug_5075bcdc88feaddacaeb503556b2d272%}
            $name  = $this->request->getPost("name", "string");
            $email = $this->request->getPost("email", "email");

            // {%debug_5bc40121d68374829702a4cae1d6561f%}
            return xdebug_print_function_stack("stop here!");

            $user        = new Users();
            $user->name  = $name;
            $user->email = $email;

            // {%debug_165a70665697d1966f0c513b23093766%}
            $user->save();
        }

    }

%{debug_6410c830e5acbec2b28846e176751584}%

.. code-block:: html

    Xdebug: stop here! in /Applications/MAMP/htdocs/tutorial/app/controllers/SignupController.php
        on line 19

    Call Stack:
        0.0383     654600   1. {main}() /Applications/MAMP/htdocs/tutorial/public/index.php:0
        0.0392     663864   2. Phalcon\Mvc\Application->handle()
            /Applications/MAMP/htdocs/tutorial/public/index.php:37
        0.0418     738848   3. SignupController->registerAction()
            /Applications/MAMP/htdocs/tutorial/public/index.php:0
        0.0419     740144   4. xdebug_print_function_stack()
            /Applications/MAMP/htdocs/tutorial/app/controllers/SignupController.php:19

%{debug_f2d045974b2e64a0c299b91b3448ffda}%

