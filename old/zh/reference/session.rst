使用 Session 存储数据（Storing data in Session）
================================================

会话组件组件提供了一种面向对象的方式访问session数据。

使用这个组件替代原生session的原因如下:

* 在相同域名下的不同应用程序之间，你可以非常容易的隔离session数据
* Intercept where session data is set/get in your application
* 根据应用程序的需要，可以非常方便的更换session适配器

启动会话（Starting the Session）
--------------------------------
Some applications are session-intensive, almost any action that performs requires access to session data. There are others who access session data casually.
Thanks to the service container, we can ensure that the session is accessed only when it's clearly needed:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // Start the session the first time when some component request the session service
    $di->setShared(
        "session",
        function () {
            $session = new Session();

            $session->start();

            return $session;
        }
    );

Session 的存储与读取（Storing/Retrieving data in Session）
----------------------------------------------------------
控制器，视图或者任何继承于 :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` 的组件，都可以访问session服务。
如下示例介绍了session的存储与读取操作:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            // 设置一个session变量
            $this->session->set("user-name", "Michael");
        }

        public function welcomeAction()
        {
            // 检查session变量是否已定义
            if ($this->session->has("user-name")) {
                // 获取session变量的值
                $name = $this->session->get("user-name");
            }
        }

    }

Sessions 的删除和销毁（Removing/Destroying Sessions）
-----------------------------------------------------
你也可以删除某个session变量，或者销毁全部session会话:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function removeAction()
        {
            // 删除session变量
            $this->session->remove("user-name");
        }

        public function logoutAction()
        {
            // 销毁全部session会话
            $this->session->destroy();
        }
    }

隔离不同应用的会话数据（Isolating Session Data between Applications）
---------------------------------------------------------------------
Sometimes a user can use the same application twice, on the same server, in the same session. Surely, if we use variables in session,
we want that every application have separate session data (even though the same code and same variable names). To solve this, you can add a
prefix for every session variable created in a certain application:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // Isolating the session data
    $di->set(
        "session",
        function () {
            // All variables created will prefixed with "my-app-1"
            $session = new Session(
                [
                    "uniqueId" => "my-app-1",
                ]
            );

            $session->start();

            return $session;
        }
    );

Adding a unique ID is not necessary.

会话袋（Session Bags）
----------------------
:doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` is a component that helps separating session data into "namespaces".
Working by this way you can easily create groups of session variables into the application. By only setting the variables in the "bag",
it's automatically stored in session:

.. code-block:: php

    <?php

    use Phalcon\Session\Bag as SessionBag;

    $user = new SessionBag("user");

    $user->setDI($di);

    $user->name = "Kimbra Johnson";
    $user->age  = 22;


组件的持久数据（Persistent Data in Components）
-----------------------------------------------
Controller, components and classes that extends :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` may inject
a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`. This class isolates variables for every class.
Thanks to this you can persist data between requests in every class in an independent way.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            // Create a persistent variable "name"
            $this->persistent->name = "Laura";
        }

        public function welcomeAction()
        {
            if (isset($this->persistent->name)) {
                echo "Welcome, ", $this->persistent->name;
            }
        }
    }

In a component:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class Security extends Component
    {
        public function auth()
        {
            // Create a persistent variable "name"
            $this->persistent->name = "Laura";
        }

        public function getAuthName()
        {
            return $this->persistent->name;
        }
    }

The data added to the session (:code:`$this->session`) are available throughout the application, while persistent (:code:`$this->persistent`)
can only be accessed in the scope of the current class.

自定义适配器（Implementing your own adapters）
----------------------------------------------
The :doc:`Phalcon\\Session\\AdapterInterface <../api/Phalcon_Session_AdapterInterface>` interface must be implemented in order to create your own session adapters or extend the existing ones.

There are more adapters available for this components in the `Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter>`_
