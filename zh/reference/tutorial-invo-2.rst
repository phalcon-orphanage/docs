教程 3: 保护INVO(Tutorial 3: Securing INVO)
===========================================

在这一章, 我们将继续解释INVO是如何构成的, 我们将讨论认证的实施, 使用事件和插件的认证和一个由Phalcon管理的访问控制列表.

登录应用(Log into the Application)
----------------------------------
一个 "log in" 功能将允许我们在后台控制器中工作. 后台控制器和前台之前的分离是合乎逻辑的. 所有加载的控制器都位于相同的目录 (app/controllers/).

为了进入系统, 用户必须有一个有效的用户名和密码. 用户存储在数据库 "invo" 里面的 "users" 表里面.

在我们开始会话之前, 我们需要在数据库配置数据库的连接. 一个 "db" 服务在服务容器中设置连接信息. 就自动加载器来说, 我们再一次从配置文件中读取参数来配置一个服务:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // ...

    // 数据库连接是基于配置文件已经定义的参数创建的
    $di->set(
        "db",
        function () use ($config) {
            return new DbAdapter(
                [
                    "host"     => $config->database->host,
                    "username" => $config->database->username,
                    "password" => $config->database->password,
                    "dbname"   => $config->database->name,
                ]
            );
        }
    );

这里, 我们将会返回一个MySQL连接适配器的一个实例. 如果需要, 你可以做一些额外的操作比如添加一个日志记录, 一个分析器或者改变适配器, 设置你想要的.

下列表单(app/views/session/index.volt) 请求登录信息. 我们已经删除了一些 HTML 代码来让例子更加简洁:

.. code-block:: html+jinja

    {{ form("session/start") }}
        <fieldset>
            <div>
                <label for="email">
                    Username/Email
                </label>

                <div>
                    {{ text_field("email") }}
                </div>
            </div>

            <div>
                <label for="password">
                    Password
                </label>

                <div>
                    {{ password_field("password") }}
                </div>
            </div>



            <div>
                {{ submit_button("Login") }}
            </div>
        </fieldset>
    {{ endForm() }}

使用原生的PHP作为以前的教程, 我们开始使用 :doc:`Volt <volt>`. 这是一个内置的模板引擎受 Jinja_ 的影响而提供简单而又友好的语法来创建模板. 在你熟悉 Volt 之前, 它将不会花费你太多的时间.

:code:`SessionController::startAction` 方法 (app/controllers/SessionController.php) 有验证表单中输入的数据包括检查在数据库中是否为有效用户的任务:

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {
        // ...

        private function _registerSession($user)
        {
            $this->session->set(
                "auth",
                [
                    "id"   => $user->id,
                    "name" => $user->name,
                ]
            );
        }

        /**
         * 这个方法检验和记录一个用户到应用中
         */
        public function startAction()
        {
            if ($this->request->isPost()) {
                // 从用户获取数据
                $email    = $this->request->getPost("email");
                $password = $this->request->getPost("password");

                // 在数据库中查找用户
                $user = Users::findFirst(
                    [
                        "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                        "bind" => [
                            "email"    => $email,
                            "password" => sha1($password),
                        ]
                    ]
                );

                if ($user !== false) {
                    $this->_registerSession($user);

                    $this->flash->success(
                        "Welcome " . $user->name
                    );

                    // 如果用户是有效的, 转发到'invoices'控制器
                    return $this->dispatcher->forward(
                        [
                            "controller" => "invoices",
                            "action"     => "index",
                        ]
                    );
                }

                $this->flash->error(
                    "Wrong email/password"
                );
            }

            // 再一次转发到登录表单
            return $this->dispatcher->forward(
                [
                    "controller" => "session",
                    "action"     => "index",
                ]
            );
        }
    }

为简单起见, 我们使用 "sha1_" 在数据库中存储密码散列, 然而, 在实际应用中不建议采用此算法, 使用 ":doc:`bcrypt <security>`" 代替.

请注意, 多个公共属性在控制器访问, 像: :code:`$this->flash`, :code:`$this->request` 或者 :code:`$this->session`. 这些是先前在服务容器中定义的服务 (app/config/services.php). 当它们第一次访问的时候, 它们被注入作为控制器的一部分.

这些服务是"共享"的, 这意味着我们总是访问相同的地方, 无论我们在哪里调用它们.

例如, 这里我们调用 "session" 服务然后我们在变量 "auth" 中存储用户身份:

.. code-block:: php

    <?php

    $this->session->set(
        "auth",
        [
            "id"   => $user->id,
            "name" => $user->name,
        ]
    );

本节的另外一个重要方面是如何验证用户为有效的, 首先我们验证是否使用的是POST请求的:

.. code-block:: php

    <?php

    if ($this->request->isPost()) {

然后, 我们接收表单中的参数:

.. code-block:: php

    <?php

    $email    = $this->request->getPost("email");
    $password = $this->request->getPost("password");

现在, 我们需要检查是否存在一个相同的用户名或邮箱和密码的用户:

.. code-block:: php

    <?php

    $user = Users::findFirst(
        [
            "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
            "bind" => [
                "email"    => $email,
                "password" => sha1($password),
            ]
        ]
    );

注意, '绑定参数'的使用, 占位符 :email: 和 :password: 要放置在替换的值的位置, 然后值的'绑定'使用参数 'bind'. 安全的替换列的值而没有SQL注入的危险.

如果用户是有效的, 我们将会在session中注册它, 并且转发到dashboard:

.. code-block:: php

    <?php

    if ($user !== false) {
        $this->_registerSession($user);

        $this->flash->success(
            "Welcome " . $user->name
        );

        return $this->dispatcher->forward(
            [
                "controller" => "invoices",
                "action"     => "index",
            ]
        );
    }

如果用户不存在,再一次转发到登录表单让用户再次操作:

.. code-block:: php

    <?php

    return $this->dispatcher->forward(
        [
            "controller" => "session",
            "action"     => "index",
        ]
    );

后端安全(Securing the Backend)
--------------------
后端是一个私有区域，只有已经注册的人可以访问. 因此, 只有注册用户才能访问控制器这样的检验是有必要的. 如果你没有登录到应用中并试图访问, 例如, products 控制器 (这是私有的)
你将会看到如下屏幕:

.. figure:: ../_static/img/invo-2.png
   :align: center

每次有人试图访问任何controller/action, 应用将会验证当前角色(在session中)是否能够访问它, 否则就会显示一个像上面那样的消息并转发到首页.

现在, 让我们看看应用程序是如何实现的. 首先我们知道有个组件叫做 :doc:`Dispatcher <dispatching>`. 通过 :doc:`Routing <routing>` 组件来找到路由. 然后, 它负责加载合适的控制器和执行相应的动作方法.

正常情况下, 框架会自动创建分发器. 对我们而言, 我们想在执行请求的方法之前执行一个验证, 校验用户是否可以访问它. 要做到这一点, 我们需要在启动文件中创建一个方法来替换组件:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // ...

    /**
     * MVC 分发器
     */
    $di->set(
        "dispatcher",
        function () {
            // ...

            $dispatcher = new Dispatcher();

            return $dispatcher;
        }
    );

我们现在使用完全控制的分发器用于应用程序. 在框架中需要多组件的触发事件, 允许我们能够修改内部的操作流. 依赖注入组件作为胶水的一部分, 一个新的叫做  :doc:`EventsManager <events>` 的组件允许我们拦截由组件产生的事件, 路由事件到监听.

事件管理(Events Management)
^^^^^^^^^^^^^^^^^^^^^^^^^^^
一个 :doc:`EventsManager <events>` 允许我们为一个特定类型的事件添加监听. 现在我们感兴趣的类型是 "dispatch". 下列代码过滤了由分发器产生的所有事件:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // 创建一个事件管理器
            $eventsManager = new EventsManager();

            // 监听分发器中使用安全插件产生的事件
            $eventsManager->attach(
                "dispatch:beforeExecuteRoute",
                new SecurityPlugin()
            );

            // 处理异常和使用 NotFoundPlugin 未找到异常
            $eventsManager->attach(
                "dispatch:beforeException",
                new NotFoundPlugin()
            );

            $dispatcher = new Dispatcher();

            // 分配事件管理器到分发器
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

当一个叫做 "beforeExecuteRoute" 的事件触发以下插件将会被通知:

.. code-block:: php

    <?php

    /**
     * 检验用户是否允许使用 SecurityPlugin 访问某些方法
     */
    $eventsManager->attach(
        "dispatch:beforeExecuteRoute",
        new SecurityPlugin()
    );

当一个 "beforeException" 被触发然后其他插件通知:

.. code-block:: php

    <?php

    /**
     * 处理异常和使用 NotFoundPlugin 未找到异常
     */
    $eventsManager->attach(
        "dispatch:beforeException",
        new NotFoundPlugin()
    );

SecurityPlugin 是一个类位于(app/plugins/SecurityPlugin.php). 这个类实现了 "beforeExecuteRoute" 方法. 这是一个相同的名字在分发器中产生的事件中的一个:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;

    class SecurityPlugin extends Plugin
    {
        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }
    }

钩子事件始终接收第一个包含上下文信息所产生的事件(:code:`$event`)的参数和第二个包含事件本身所产生的对象(:code:`$dispatcher`)的参数. 这不是一个强制性的插件扩展类 :doc:`Phalcon\\Mvc\\User\\Plugin <../api/Phalcon_Mvc_User_Plugin>`, 但通过这样做, 它们更容易获得应用程序中可用的服务.

现在, 我们验证当前 session 中的角色, 验证用户是否可以通过ACL列表访问.如果用户没有权限, 我们将会重定向到如上所述的主页中去:

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;

    class SecurityPlugin extends Plugin
    {
        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // 检查session中是否存在"auth"变量来定义当前活动的角色
            $auth = $this->session->get("auth");

            if (!$auth) {
                $role = "Guests";
            } else {
                $role = "Users";
            }

            // 从分发器获取活动的 controller/action
            $controller = $dispatcher->getControllerName();
            $action     = $dispatcher->getActionName();

            // 获得ACL列表
            $acl = $this->getAcl();

            // 检验角色是否允许访问控制器 (resource)
            $allowed = $acl->isAllowed($role, $controller, $action);

            if (!$allowed) {
                // 如果没有访问权限则转发到 index 控制器
                $this->flash->error(
                    "You don't have access to this module"
                );

                $dispatcher->forward(
                    [
                        "controller" => "index",
                        "action"     => "index",
                    ]
                );

                // 返回 "false" 我们将告诉分发器停止当前操作
                return false;
            }
        }
    }

提供 ACL 列表(Providing an ACL list)
^^^^^^^^^^^^^^^^^^^^^
在上面的例子中我们已经获得了ACL的使用方法 :code:`$this->getAcl()`. 这个方法也是在插件中实现的. 现在我们要逐步解释如何建立访问控制列表(ACL):

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Acl\Role;
    use Phalcon\Acl\Adapter\Memory as AclList;

    // 创建一个 ACL
    $acl = new AclList();

    // 默认行为是 DENY(拒绝) 访问
    $acl->setDefaultAction(
        Acl::DENY
    );

    // 注册两个角色, 用户是已注册用户和没有定义身份的来宾用户
    $roles = [
        "users"  => new Role("Users"),
        "guests" => new Role("Guests"),
    ];

    foreach ($roles as $role) {
        $acl->addRole($role);
    }

现在, 我们分别为每个区域定义资源. 控制器名称是资源它们的方法是对资源的访问:

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // ...

    // 私有区域资源 (后台)
    $privateResources = [
        "companies"    => ["index", "search", "new", "edit", "save", "create", "delete"],
        "products"     => ["index", "search", "new", "edit", "save", "create", "delete"],
        "producttypes" => ["index", "search", "new", "edit", "save", "create", "delete"],
        "invoices"     => ["index", "profile"],
    ];

    foreach ($privateResources as $resourceName => $actions) {
        $acl->addResource(
            new Resource($resourceName),
            $actions
        );
    }

    // 公共区域资源 (前台)
    $publicResources = [
        "index"    => ["index"],
        "about"    => ["index"],
        "register" => ["index"],
        "errors"   => ["show404", "show500"],
        "session"  => ["index", "register", "start", "end"],
        "contact"  => ["index", "send"],
    ];

    foreach ($publicResources as $resourceName => $actions) {
        $acl->addResource(
            new Resource($resourceName),
            $actions
        );
    }

ACL现在了解现有的控制器和它们相关的操作. 角色 "Users" 由权限访问前台和后台的所有资源. 角色 "Guests" 仅允许访问公共区域:

.. code-block:: php

    <?php

    // 授权user和Grant访问公共区域
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow(
                $role->getName(),
                $resource,
                "*"
            );
        }
    }

    // 授权仅角色Users 访问私有区域
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow(
                "Users",
                $resource,
                $action
            );
        }
    }

万岁!, ACL现在终于完成了. 在下一章, 我们将会看到Phalcon中的CRUD是如何实现的并且你如何自定义它.

.. _jinja: http://jinja.pocoo.org/
.. _sha1: http://php.net/manual/zh/function.sha1.php
