Dispatching Controllers
=======================
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 组件负责在MVC应用程序中负责实例化控制器以及执行所需操作的。了解它的具体运作方法能很好的帮助我们了解整个框架提供的服务。

The Dispatch Loop
-----------------
很多重要的过程发生在MVC工作流本身，尤其是在控制器部分。这些工作发生在控制调度度期间，控制器文件的读取，加载，初始化，以及操作的执行。如果一个action中的流程跳转到另一个控制器的controller/action上，控制调度器再次启动，为了更好的说明这一点，下面的例子将展示  :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 内部执行的过程：

.. code-block:: php

    <?php

    //Dispatch loop
    while (!$finished) {

        $finished = true;

        $controllerClass = $controllerName."Controller";

        //Instantiating the controller class via autoloaders
        $controller = new $controllerClass();

        // Execute the action
        call_user_func_array(array($controller, $actionName . "Action"), $params);

        // Finished should be reloaded to check if the flow was forwarded to another controller
        // $finished = false;

    }

上面的代码没有添加验证器，过滤器以及额外的检查，但它很好的展示了分发器在正常的调度程序中的操作流程。

分发器事件(Dispatch Loop Events)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` 也能够发送事件到  :doc:`EventsManager <events>` 。事件被触发的类型名称为 "dispatch"。其中的一些事件，返回布尔值false时，可以停止事件的运作。主要支持以下事件：

+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                                                                                                                                                                   | Can stop operation? |
+======================+=============================================================================================================================================================================================================+=====================+
| beforeDispatchLoop   | Triggered before enter in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router. | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeDispatch       | Triggered after enter in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router.  | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeExecuteRoute   | Triggered before execute the controller/action method. At this point the dispatcher has been initialized the controller and know if the action exist.                                                       | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterExecuteRoute    | Triggered after execute the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                         | No                  |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeNotFoundAction | Triggered when the action was not found in the controller                                                                                                                                                   | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeException      | Triggered before the dispatcher throws any exception                                                                                                                                                        | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterDispatch        | Triggered after execute the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                         | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterDispatchLoop    | Triggered after exit the dispatch loop                                                                                                                                                                      | No                  |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+

:doc:`INVO <tutorial-invo>` 教程中演示了如何使用分发器配合 :doc:`Acl <acl>` 实现安全认证。

下面的示例将演示如何在分发器上注册监听器事件：

.. code-block:: php

    <?php

    $di->set('dispatcher', function(){

        //Create an event manager
        $eventsManager = new Phalcon\Events\Manager();

        //Attach a listener for type "dispatch"
        $eventsManager->attach("dispatch", function($event, $dispatcher) {
            //...
        });

        $dispatcher = new \Phalcon\Mvc\Dispatcher();

        //Bind the eventsManager to the view component
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Instantiated controllers act automatically as listeners for dispatch events, so you can implement methods as callbacks:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function beforeExecuteRoute($dispatcher)
        {
            // Executed before every found action
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Executed after every found action
        }

    }

Forwarding to other actions
---------------------------
分发器允许我们从一个controller/action跳转到另一个controller/action。这是非常有用的，如果我们需要在代码中进行用户检查等事项，可以将用户重定向到其他页面。

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction($year, $postTitle)
        {

            // .. store some product and forward the user

            // Forward flow to the index action
            $this->dispatcher->forward(array(
                "controller" => "post",
                "action" => "index"
            ));
        }

    }

请记住，"forward"和HTTP重定向不一样，虽然他们显示了相同的结果。"forward"不刷新当前页面，所有的重定向都发生在一个单一的请求中，而HTTP重定向则需要完成两个请求。

更多关于forward的例子：

.. code-block:: php

    <?php

    // Forward flow to another action in the current controller
    $this->dispatcher->forward(array(
        "action" => "search"
    ));

    // Forward flow to another action in the current controller
    // passing parameters
    $this->dispatcher->forward(array(
        "action" => "search",
        "params" => array(1, 2, 3)
    ));

    // Forward flow to another action in the current controller
    // passing parameters
    $this->dispatcher->forward(array(
        "action" => "search",
        "params" => array(1, 2, 3)
    ));

跳转动作按受以下一些参数：

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

获取参数(Getting Parameters)
-----------------------------------------
当一条路由提供了命名参数，你可以在控制器，视图文件或者其他任何继承了 :doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>` 的组件中获取值。

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // Get the post's title passed in the URL as parameter
            $title = $this->dispatcher->getParam("title");

            // Get the post's year passed in the URL as parameter
            // also filtering it
            $year = $this->dispatcher->getParam("year", "int");
        }

    }

Handling Not-Found Exceptions
-----------------------------
使用  :doc:`EventsManager <events>` ，插入一个挂钩点，以使在controller/action不存在的时候，抛出一个异常信息。

.. code-block:: php

    <?php

    $di->setShared('dispatcher', function() {

        //Create/Get an EventManager
        $eventsManager = new Phalcon\Events\Manager();

        //Attach a listener
        $eventsManager->attach("dispatch", function($event, $dispatcher, $exception) {

            //The controller exists but the action not
            if ($event->getType() == 'beforeNotFoundAction') {
                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'show404'
                ));
                return false;
            }

            //Alternative way, controller or action doesn't exist
            if ($event->getType() == 'beforeException') {
                switch ($exception->getCode()) {
                    case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(array(
                            'controller' => 'index',
                            'action' => 'show404'
                        ));
                        return false;
                }
            }
        });

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        //Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

实现自定义分发器(Implementing your own Dispatcher)
------------------------------------------------------------------
通过实现 :doc:`Phalcon\\Mvc\\DispatcherInterface <../api/Phalcon_Mvc_DispatcherInterface>` 接口文件可以在Phalcon中创建一个自定义的分发器。