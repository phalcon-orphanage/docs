%{dispatching_c7e230188b6b2143ff84328e977f26e6}%
=======================
%{dispatching_81501364f781f7e734258d205629bc50}%

%{dispatching_9ec793769848dd36d16bc5009d090b78}%
-----------------
%{dispatching_3aa22fc3cb1379a87cf25f652dcc56b8}%

.. code-block:: php

    <?php

    //{%dispatching_36b5251b4f60f0e3ab4fdacb1a73e855%}
    while (!$finished) {

        $finished = true;

        $controllerClass = $controllerName . "Controller";

        //{%dispatching_bec792bcb607a469332561ea1f064cec%}
        $controller = new $controllerClass();

        // {%dispatching_55759812960b168ddd66320b5fd4cfc1%}
        call_user_func_array(array($controller, $actionName . "Action"), $params);

        // {%dispatching_6ea67765b812783b432096068579c7ac%}
        // {%dispatching_52975c12433d7743922548154537c9d4%}
        $finished = true;
    }

%{dispatching_b400a4664e1eb7d407d32443a5866cbb}%

%{dispatching_0d1e9546c8779eb28895ec882ed3d319}%
^^^^^^^^^^^^^^^^^^^^
%{dispatching_14eec6afae10eddb0b0e9b9376b2c5c4}%

+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| Event Name           | Triggered                                                                                                                                                                                                      | Can stop operation? | Triggered to          |
+======================+================================================================================================================================================================================================================+=====================+=======================+
| beforeDispatchLoop   | Triggered before entering in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router. | Yes                 | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeDispatch       | Triggered after entering in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router.  | Yes                 | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeExecuteRoute   | Triggered before executing the controller/action method. At this point the dispatcher has been initialized the controller and know if the action exist.                                                        | Yes                 | Listeners/Controllers |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| initialize           | Allow to globally initialize the controller in the request                                                                                                                                                     | No                  | Controllers           |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterExecuteRoute    | Triggered after executing the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                          | No                  | Listeners/Controllers |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeNotFoundAction | Triggered when the action was not found in the controller                                                                                                                                                      | Yes                 | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeException      | Triggered before the dispatcher throws any exception                                                                                                                                                           | Yes                 | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatch        | Triggered after executing the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                          | Yes                 | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatchLoop    | Triggered after exiting the dispatch loop                                                                                                                                                                      | No                  | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+

%{dispatching_69d78495a25fcaf6e4b4e9fa56d997aa}%

%{dispatching_4eb434eb37be7b4a57c178fa4af88c76}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function(){

        //{%dispatching_41b79f8cf8c0967be09fcf51a7674d17%}
        $eventsManager = new EventsManager();

        //{%dispatching_848530a8762b4940d6e8097771122109%}
        $eventsManager->attach("dispatch", function($event, $dispatcher) {
            //...
        });

        $dispatcher = new MvcDispatcher();

        //{%dispatching_bda634f6269a3a06dd0a40fb4d7ae993%}
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

%{dispatching_742e12cd23609e971d9755ddafffff6e}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function beforeExecuteRoute($dispatcher)
        {
            // {%dispatching_1ee4fe990509813017611ecf6e305c2d%}
        }

        public function afterExecuteRoute($dispatcher)
        {
            // {%dispatching_49435565b9b3e2fa5b74074d2bb70884%}
        }

    }

%{dispatching_5e377a05e8ff5174b61fbdfc1b15ccb3}%
---------------------------
%{dispatching_3b9443771cbb60480ead8f8517713ac9}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction($year, $postTitle)
        {

            // {%dispatching_a01b11a64fec929d0a6de3fb0922adcd%}

            // {%dispatching_33c7726ef2f9bff69d1c9cb8d1389c42%}
            $this->dispatcher->forward(array(
                "controller" => "post",
                "action" => "index"
            ));
        }

    }

%{dispatching_f3c62e174053901d1ba20264f5f6dfe9}%

%{dispatching_b42a3fb3e2bd1291604e00718ec1e87b}%

.. code-block:: php

    <?php

    // {%dispatching_127dad3202ffec70abfe6cf2662da3e2%}
    $this->dispatcher->forward(array(
        "action" => "search"
    ));

    // {%dispatching_127dad3202ffec70abfe6cf2662da3e2%}
    // {%dispatching_52cf0d0467fe9114e378ef9752ff0b3b%}
    $this->dispatcher->forward(array(
        "action" => "search",
        "params" => array(1, 2, 3)
    ));


%{dispatching_55bda9dcfe8251c072b7abb5c77efad6}%

+----------------+--------------------------------------------------------+
| Parameter      | Triggered                                              |
+================+========================================================+
| controller     | A valid controller name to forward to.                 |
+----------------+--------------------------------------------------------+
| action         | A valid action name to forward to.                     |
+----------------+--------------------------------------------------------+
| params         | An array of parameters for the action                  |
+----------------+--------------------------------------------------------+
| namespace      | A valid namespace name where the controller is part of |
+----------------+--------------------------------------------------------+

%{dispatching_f639eaf462e293dac25b136e656dcbf2}%
--------------------
%{dispatching_8802f0dbd05437c34f56cb0a6b8ddf81}%

%{dispatching_b371c1705a0db0cda084736e6897724c}%

%{dispatching_b89da8c819fb44b1e66adf6136530991}%

.. code-block:: php

    <?php

    use Phalcon\Dispatcher,
        Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function() {

        //{%dispatching_cc3bf7e319d25db079b9a1ecb4d7d832%}
        $eventsManager = new EventsManager();

        //{%dispatching_106eac9a28739f21d92acca480af02cc%}
        $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {

            $keyParams = array();
            $params = $dispatcher->getParams();

            //{%dispatching_f3b6b5f59d7df27ede32c771dd40a584%}
            foreach ($params as $number => $value) {
                if ($number & 1) {
                    $keyParams[$params[$number - 1]] = $value;
                }
            }

            //{%dispatching_0c2e39e72d43a7f83a11dae5abbd51c9%}
            $dispatcher->setParams($keyParams);
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

%{dispatching_cad058d0cc5381d5cc280ee62fe8253e}%

.. code-block:: php

    <?php

    use Phalcon\Dispatcher,
        Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function() {

        //{%dispatching_cc3bf7e319d25db079b9a1ecb4d7d832%}
        $eventsManager = new EventsManager();

        //{%dispatching_106eac9a28739f21d92acca480af02cc%}
        $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {

            $keyParams = array();
            $params = $dispatcher->getParams();

            //{%dispatching_c0605047051937a68961e4f308fe53bf%}
            foreach ($params as $number => $value) {
                $parts = explode(':', $value);
                $keyParams[$parts[0]] = $parts[1];
            }

            //{%dispatching_0c2e39e72d43a7f83a11dae5abbd51c9%}
            $dispatcher->setParams($keyParams);
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

%{dispatching_f70a4e022ddce861f63997cab3fab1e4}%
------------------
%{dispatching_dd6b7bcdbb4ce2aaeedd235abfe8c8d0}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // {%dispatching_f5c27d8b2e4c00a39131b93bed108b71%}
            // {%dispatching_342886fb499713c16d477b8d2b9640ca%}
            $title = $this->dispatcher->getParam("title");

            // {%dispatching_d6f92b1871c4833f57c8a7c5c2fbec22%}
            // {%dispatching_47ed99dbf80216b5654ff7b4046c6f91%}
            $year = $this->dispatcher->getParam("year", "int");
        }

    }

%{dispatching_14c198f6c9118247f026bc8e88fbaedf}%
-----------------
%{dispatching_05d8d38f4f9011a9ac4641a571f84dce}%

%{dispatching_e260ea2adfcceb079d4d4b6f1b551608}%
^^^^^^^^^^^^^^^^^^^^^
%{dispatching_67688f4ece23aa755f24f8cfb0aad718}%

.. code-block:: php

    <?php

    use Phalcon\Text,
        Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function() {

        //{%dispatching_cc3bf7e319d25db079b9a1ecb4d7d832%}
        $eventsManager = new EventsManager();

        //{%dispatching_c40e2ba20afcd811261a0381a09f54d4%}
        $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {
            $dispatcher->setActionName(Text::camelize($dispatcher->getActionName()));
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

%{dispatching_0a38dd3dddc99f184e2d2e489251cb10}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{dispatching_0dabb0181ae19b162bc80badf0a4b1cc}%

%{dispatching_7572891bc5d9c53bb5cc71ddc41eb601}%

%{dispatching_70432e530ebf2544b788be9edb18bc91}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function() {

        //{%dispatching_cc3bf7e319d25db079b9a1ecb4d7d832%}
        $eventsManager = new EventsManager();

        //{%dispatching_d79b636a02bc6255db99a1385ccf21b2%}
        $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {

            //{%dispatching_3158c8d8044dd5e43edabccb00528a46%}
            $action = preg_replace('/\.php$/', '', $dispatcher->getActionName());

            //{%dispatching_b527ebd2ac007b2d7e6d6639f89c29c9%}
            $dispatcher->setActionName($action);
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

%{dispatching_5525aa566ea8e91ed09eb57d3e25b58a}%
^^^^^^^^^^^^^^^^^^^^^^
%{dispatching_81aa760587a36f918d029250fe635836}%

%{dispatching_713b76e5d389b872cf6b91937b9a1c59}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {
        /**
         * Shows posts
         *
         * @param \Posts $post
         */
        public function showAction(Posts $post)
        {
            $this->view->post = $post;
        }
    }

%{dispatching_b08fb0962ab2d8ce37b497ca32d08713}%

.. code-block:: php

    <?php

    use Phalcon\Text,
        Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function() {

        //{%dispatching_cc3bf7e319d25db079b9a1ecb4d7d832%}
        $eventsManager = new EventsManager();

        $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {

            //{%dispatching_85c8e25bc56ae82ab59658b59a2a03ce%}
            $controllerName =   Text::camelize($dispatcher->getControllerName()) . 'Controller';

            //{%dispatching_4bca87661489db5e3089d939faf2eb58%}
            $actionName = $dispatcher->getActionName() . 'Action';

            try {

                //{%dispatching_3573d5c600b4bb192b28cf2efc093b0c%}
                $reflection = new \ReflectionMethod($controllerName, $actionName);

                //{%dispatching_76d370dc5586c35d54e28967d422908c%}
                foreach ($reflection->getParameters() as $parameter) {

                    //{%dispatching_da26f5f1a8336688ebf490bf7fe60331%}
                    $className = $parameter->getClass()->name;

                    //{%dispatching_0bebfc545740d36398a183720db0d4a2%}
                    if (is_subclass_of($className, 'Phalcon\Mvc\Model')) {

                        $model = $className::findFirstById($dispatcher->getParams()[0]);

                        //{%dispatching_53cac0999d027be3b4c7e630f66e897e%}
                        $dispatcher->setParams(array($model));
                    }
                }

            } catch (\Exception $e) {
                //{%dispatching_071dd72dde774dfd84ab6af90cd8ea5b%}
            }

        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

%{dispatching_e4002ed174de3b9843b8d2a2f8cfbd84}%

%{dispatching_a0b3073d0e9cc13f01fa8fded0cdc7ad}%
-----------------------------
%{dispatching_f4582eab6580a8e3e9d783c044d1e67e}%

.. code-block:: php

    <?php

    use Phalcon\Dispatcher,
        Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager,
        Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    $di->set('dispatcher', function() {

        //{%dispatching_cc3bf7e319d25db079b9a1ecb4d7d832%}
        $eventsManager = new EventsManager();

        //{%dispatching_106eac9a28739f21d92acca480af02cc%}
        $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

            //{%dispatching_96bb5555a4a2fd176be84f582a90d3de%}
            if ($exception instanceof DispatchException) {
                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'show404'
                ));
                return false;
            }

            //{%dispatching_2663f5f3464380864d0364daf496d4e1%}
            $dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'show503'
            ));

            return false;
        });

        $dispatcher = new MvcDispatcher();

        //{%dispatching_c5b1d51f30933dfd71e8f28646329bc7%}
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

%{dispatching_91daa9dae5570715c7059d0efbf5c64c}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher,
        Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    class ExceptionsPlugin
    {
        public function beforeException(Event $event, Dispatcher $dispatcher, $exception)
        {

            //{%dispatching_96bb5555a4a2fd176be84f582a90d3de%}
            if ($exception instanceof DispatchException) {
                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'show404'
                ));
                return false;
            }

            //{%dispatching_2663f5f3464380864d0364daf496d4e1%}
            $dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'show503'
            ));

            return false;
        }
    }

.. highlights::

    Only exceptions produced by the dispatcher and exceptions produced in the executed action
    are notified in the 'beforeException' events. Exceptions produced in listeners or
    controller events are redirected to the latest try/catch.

