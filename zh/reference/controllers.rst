
控制器
=================
控制器提供了一些方法，他们被叫做actions。Actions是控制器用来处理用户请求的方法。默认情况下，控制器的所有公有的方法都映射到一个可访问的ＵＲＬ。Actions是负责解释请求以及创建用户响应的。通过的反应是一个渲染视图的形式，但也有其他的形式来处理用户请求。

例如，当你访问一个这样的URL时 http://localhost/blog/posts/show/2012/the-post-title ，默认情况下，Phalcon是这样对URL进行分解的：

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

在这个例子中，PostController控制器用于来接收用户请求。由于在应用程序中没有对controllers的存放指定存放位置，他们可以通过 :doc:`autoloaders <loader>` 来自动加载你的controllers目录。

所有的控制器都必须以“Controller”为结尾，所有的Actions都是以“Action”结尾。下面是一个控制器的示例：

译者注：也并非所有的控制器都必须以“Controller”为结尾的，比如我们一般会写一个名为 “ContollerBase”,让他继承自　\Phalcon\Mvc\Controller.　同时我们自己应用程序中的其他控制器都再继承自 ContollerBase.这么来做的话，则控制器ContollerBase就不是以 “Controller”为结尾了。如果严谨一点来讲可以这么说，所以用于用户请求的控制器必须以“Controller”为结尾

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

其他的URI参数将被定义为Action参数，因此你可以很容易的使用局部变量来访问这些参数。控制器继承自 :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` 。 这样一来，你的控制器就很方便的提供应用服务了

Dispatch Loop
-------------
其他的URI参数将被定义为Action参数，因此你可以很容易的使用局部变量来访问这些参数。控制器继承自 :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` 。 这样一来，你的控制器就很方便的访问应用程序中的其他服务了

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

            // Forward flow to another action
            $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "signin"
            ));
        }

    }

如果用户没有权限访问某个特定的动作，然后将被转发到UsersController控制器的signinAction

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

应用程序中并没有限制分发器的跳转次数，只要他们不导致死循环，可以正常停止即可。如果程序逻辑中再没有跳转到其他的Action,程序将自动调用MVC的视图层 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`.

初始化控制器
------------------------
:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` 提供初始化的方法，它最先执行，注意："__construct" 的初始化方法在这里不推荐使用。

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

访问注入服务
------------------
如果控制器继承自 :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` ，那么它将可以很方便的访问应用程序容器中的其他服务。例如，我们注册了一个这样的服务：

.. code-block:: php

    <?php

    $di = new Phalcon\DI();

    $di->set('storage', function(){
        return new Storage('/some/directory');
    }, true);

然后，我们可以通过以下方式访问那些服务：

.. code-block:: php

    <?php

    class FilesController extends \Phalcon\Mvc\Controller
    {

        public function saveAction()
        {

            //Injecting the service by just accessing the property with the same name
            $this->storage->save('/some/file');

            //Accessing the service from the DI
            $this->di->get('storage')->save('/some/file');

            //Another way to access the service using the magic getter
            $this->di->getStorage()->save('/some/file');

            //Another way to access the service using the magic getter
            $this->getDi()->getStorage()->save('/some/file');
        }

    }

如果你正在使用Phalcon框架，你可以阅读一下DI :doc:`by default <di>`

请求和响应
--------------------
假设，该框架已经提供了一组预置的服务。我们将解释他们如何与http相互协调工作。"request"服务是 :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` 的一个实例对象， "response"是 :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`  的一个实例对象，它负责向客户端发送响应内容。

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // Check if request has made with POST
            if ($this->request->isPost() == true) {
                // Access POST data
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }

    }

The response object is not usually used directly, but is built up before the execution of the action, sometimes - like in
an afterDispatch event - it can be useful to access the response directly:

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // Send a HTTP 404 response header
            $this->response->setStatusCode(404, "Not Found");
        }

    }

学习更多的关于HTTP环境相关的文章，请查阅 :doc:`request <request>` 以及 :doc:`response <response>`.

Session 数据
------------
Sessions help us maintain persistent data between requests. You could access a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
from any controller to encapsulate data that need to be persistent.

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

注入服务替代控制器
-----------------------------
控制器可以注册成为服务，这样的话，用户的请求都会从注册的控制器获得。因此，用此种办法可以很容易的取代其他控制器。

.. code-block:: php

    <?php

    //Register a controller as a service
    $di->set('IndexController', function() {
        $component = new Component();
        return $component;
    });

译者注：

以上例来说明，如果要访问 /index/index 的话，则需要在类 Component 中编写 indexAction() 方法。即和控制器中的action写法是相同的。同时，即使控制器目录存在 IndexController，也将不再访问。而是直接输出 Component中indexAction()的内容

创建一个基础控制器类
--------------------------
在应用程序的控制器中经常会需要访问控制列表，多语言，缓存，模板引擎等。在这种情况下，我们一般建议你创建一个 “base controller”,以防重复造轮子，保持代码 DRY_ .控制器只是一个简单的类文件，他要继承自 :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` ，其他的控制器再继承自 "base controller"，这样就可以拥有基类控制器中的通用功能了，你的代码就会更整洁一些。

这个类可以放到任何目录下，但按照一般的规则来讲，我们推荐你把它放到控制器文件夹中，比如 apps/controllers/ControllerBase.php 。我们可能会需要这个文件，你可以直接在程序中引入，或者通过Phalcon的autoloader引入：

.. code-block:: php

    <?php

    require "../app/controllers/ControllerBase.php";

一般通用的功能组件，我们可以写到这个文件中，比如 (actions,methods, properties等)：

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

其他继承自ControllerBase的控制器，会自动获得通用组件。

译者注： 只要明白类继承是怎么回事，这块就非常好理解了。

.. code-block:: php

    <?php

    class UsersController extends ControllerBase
    {

    }
    
译者补充：

我在这里多加一个例子，你就可以很容易的明白 base controller的用处了。

比如，我们一般会在控制器中做跳转操作，一般会用到 dispatcher的 forward方法。但这个forward方法的参数是一个数组，需要这样写：

.. code-block:: php

    <?php
    class UsersController extends ControllerBase
    {
        public function authAction()
        {
            ..... //valiate code 
            $this->dispatcher->forward(array(
                  'controller' => 'users',
                  'action' => 'login'
               )
            );
        }
    }
    
以上面示例中的写法来说，会有些麻烦。那么我们需要在 base controller中加入一个自定义的 forward 方法。

.. code-block:: php

    <?php
    class ControllerBase extends \Phalcon\Mvc\Controller
    {
       protected function forward($uri){
         $uriParts = explode('/', $uri);
         return $this->dispatcher->forward(
            array(
               'controller' => $uriParts[0], 
               'action' => $uriParts[1]
            )
         );
       }
    }
    
再次来修改 UsersController中的authAction方法：

.. code-block:: php

    <?php
    class UsersController extends ControllerBase
    {
        public function authAction()
        {
            ..... //valiate code 
            
            $this->forward('users/login');
        }
    }
    
是不是非常方便了？

控制器中的事件
---------------------
控制器本身也可以充当监听的身份，通过 :doc:`dispatcher <dispatching>` 事件，在控制器中实现 dispatcher的事件方法，控制器的方法名要与事件名相同。这样的话，你就可以很方便的在actions执行前后通过钩点执行其他内容：

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function beforeExecuteRoute($dispatcher)
        {
            // This is executed before every found action

            if ($dispatcher->getActionName() == 'save') {
                $this->flash->error("You don't have permission to save posts");
                return false;
            }
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Executed after every found action
        }

    }

.. _DRY: http://en.wikipedia.org/wiki/Don't_repeat_yourself
