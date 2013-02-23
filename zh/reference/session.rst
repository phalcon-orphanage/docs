把数据存储到Session(Storing data in Session)
=====================================================================

:doc:`Phalcon\\Session <../api/Phalcon_Session>` 组件提供了一种面象对象的方式访问session数据。

初始化Session
--------------------
有一些应用程序是会话密集型的，几乎所有的操作都需要访问Session数据。还有一些则不太需要用户会话。有了服务容器，我们可以确保只有在需要它的时候，就可以访问它：

.. code-block:: php

    <?php

    //Start the session the first time when some component request the session service
    $di->setShared('session', function(){
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

存储/获取 Session数据
----------------------------------
你可以在控制器，视图文件，以及只要继承自 :doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>` 的组件中方便的访问session服务，并且可方便的存储或获取它们的值。请看示例：

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            //Set a session variable
            $this->session->set("user-name", "Michael");
        }

        public function welcomeAction()
        {

            //Check if the variable is defined
            if ($this->session->has("user-name"))
            {

                //Retrieve its value
                $name = $this->session->get("user-name");
            }
        }

    }

移除/销毁 Session数据
----------------------------
你可以移除指定的session数据，也可销毁整个session:

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function removeAction()
        {
            //Remove a session variable
            $this->session->remove("user-name");
        }

        public function logoutAction()
        {
            //Destroy the whole session
            $this->session->destroy();
        }

    }

Isolating Session Data between Applications
-------------------------------------------
有时，我们可能部署相同的应用程序在同一台服务器上两次，而使用相同的会话。当然，如果我们在会话中使用变量，我们希望每个应用程序都有其单独的会话数据(即使相同代码和相同的变量名称)。为了解决这个问题，你可以在某个应用程序中为每个会话创建的变量添加一个前辍：

.. code-block:: php

    <?php

    //Isolating the session data
    $di->set('session', function(){

        //All variables created will prefixed with "my-app-1"
        $session = new Phalcon\Session\Adapter\Files(
            array(
                'uniqueId' => 'my-app-1'
            )
        );

        $session->start();

        return $session;
    });

Session Bags
------------
:doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` 组件帮助把session数据导入到 "namespaces"。通过这种方式，你可以轻松的创建一组会话变量到应用程序中，只需设置变量为 "bag",它会自动存储为session数据：

.. code-block:: php

    <?php

    $user       = new Phalcon\Session\Bag();
    $user->name = "Kimbra Johnson";
    $user->age  = 22;


Persistent Data in Components
-----------------------------
控制器，组件，或者其他继承自  :doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>` 的类都可以注入到  :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`.使用这个类的会话数据在每个类中的变量是隔离开的，基于此，你可以隔离每个请求持久化数据。

译者注： 我曾在翻译tutorial invo章节时测试过此属性，并添加了注释。可以查阅 :doc:`tutorial-invo <../reference/tutorial-invo>`，搜索 '译者注'查看

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            // Create a persistent variable "name"
            $this->persistent->name = "Laura";
        }

        public function welcomeAction()
        {
            if (isset($this->persistent->name))
            {
                echo "Welcome, ", $this->persistent->name;
            }
        }

    }

In a component:

.. code-block:: php

    <?php

    class Security extends Phalcon\Mvc\User\Component
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

通过 ($this->session) 添加的变量，可在整个应用程序进行访问。而通过 ($this->persistent) 添加的变量，只能在当前类访问。

实现自定义适配器
------------------------------
The :doc:`Phalcon\\Session\\AdapterInterface <../api/Phalcon_Session_AdapterInterface>` interface must be implemented in order to create your own translate adapters or extend the existing ones:

.. code-block:: php

    <?php

    class MySessionHandler implements Phalcon\Session\AdapterInterface
    {

        /**
         * MySessionHandler construtor
         *
         * @param array $options
         */
        public function __construct($options=null)
        {
        }

        /**
         * Starts session, optionally using an adapter
         *
         * @param array $options
         */
        public function start()
        {
        }

        /**
         * Sets session options
         *
         * @param array $options
         */
        public function setOptions($options)
        {
        }

        /**
         * Get internal options
         *
         * @return array
         */
        public function getOptions()
        {
        }

        /**
         * Gets a session variable from an application context
         *
         * @param string $index
         */
        public function get($index)
        {
        }

        /**
         * Sets a session variable in an application context
         *
         * @param string $index
         * @param string $value
         */
        public function set($index, $value)
        {
        }

        /**
         * Check whether a session variable is set in an application context
         *
         * @param string $index
         */
        public function has($index)
        {
        }

        /**
         * Removes a session variable from an application context
         *
         * @param string $index
         */
        public function remove($index)
        {
        }

        /**
         * Returns active session id
         *
         * @return string
         */
        public function getId()
        {
        }

        /**
         * Check whether the session has been started
         *
         * @return boolean
         */
        public function isStarted()
        {
        }

        /**
         * Destroys the active session
         *
         * @return boolean
         */
        public function destroy()
        {
        }

    }

