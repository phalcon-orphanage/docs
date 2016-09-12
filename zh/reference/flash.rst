闪存消息（Flashing Messages）
=============================

闪存消息用于通知用户关于他/她产生的动作状态，或者简单地为用户显示一此信息。
这类消息可以使用这个组件来生成。

适配器（Adapters）
------------------
这个组件使用了适配器来定义消息传递给Flasher后的行为：

+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| 适配器  | 描述                                                                                          | API                                                                        |
+=========+===============================================================================================+============================================================================+
| Direct  | 直接输出传递给flasher的消息                                                                   | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | 将消息临时存放于会话中，以便消息可以在后面的请求中打印出来                                    | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

使用（Usage）
-------------
通常闪存消息都是来自服务容器的请求.
如果你正在使用 :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` ，
那么 :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>` 将会作为 "flash" 服务自动注册 和
:doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>` 将会作为 "flashSession" 服务自动注册.
You can also manually register it:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;
    use Phalcon\Flash\Session as FlashSession;

    // 建立flash服务
    $di->set(
        "flash",
        function () {
            return new FlashDirect();
        }
    );

    // 建立flashSession服务
    $di->set(
        "flashSession",
        function () {
            return new FlashSession();
        }
    );

这样的话，你便可以在控制器或者视图中通过在必要的片段中注入此服务来使用它：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            $this->flash->success("The post was correctly saved!");
        }
    }

目前已支持的有四种内置消息类型：

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");

    $this->flash->success("yes!, everything went very smoothly");

    $this->flash->notice("this a very important information");

    $this->flash->warning("best check yo self, you're not looking too good.");

你可以用你自己的类型来添加消息：

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

输出信息（Printing Messages）
-----------------------------
发送给flash服务的消息将会自动格式成html：

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>

    <div class="successMessage">yes!, everything went very smoothly</div>

    <div class="noticeMessage">this a very important information</div>

    <div class="warningMessage">best check yo self, you're not looking too good.</div>

正如你看到的，CSS的类将会自动添加到:code:`<div>`中。这些类允许你定义消息在浏览器上的图形表现。
此CSS类可以被重写，例如，如果你正在使用Twitter的Bootstrap，对应的类可以这样配置：

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;

    // 利用自定义的CSS类来注册flash服务
    $di->set(
        "flash",
        function () {
            $flash = new FlashDirect(
                [
                    "error"   => "alert alert-danger",
                    "success" => "alert alert-success",
                    "notice"  => "alert alert-info",
                    "warning" => "alert alert-warning",
                ]
            );

            return $flash;
        }
    );

然后消息会是这样输出：

.. code-block:: html

    <div class="alert alert-danger">too bad! the form had errors</div>

    <div class="alert alert-success">yes!, everything went very smoothly</div>

    <div class="alert alert-info">this a very important information</div>

    <div class="alert alert-warning">best check yo self, you're not looking too good.</div>

绝对刷送与会话（Implicit Flush vs. Session）
--------------------------------------------
依赖于发送消息的适配器，它可以立即产生输出，也可以先临时将消息存放于会话中随后再显示。
你何时应该使用哪个？这通常依赖于你在发送消息后重定向的类型。例如，
如果你用了“转发”则不需要将消息存放于会话中，但如果你用的是一个HTTP重定向，那么则需要存放于会话中：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // 存储POST

            // 使用直接闪存
            $this->flash->success("Your information was stored correctly!");

            // 转发到index动作
            return $this->dispatcher->forward(
                [
                    "action" => "index"
                ]
            );
        }
    }

或者使用一个HTTP重定向：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // 存储POST

            // 使用会话闪存
            $this->flashSession->success("Your information was stored correctly!");

            // 返回一个完整的HTTP重定向
            return $this->response->redirect("contact/index");
        }
    }

在这种情况下，你需要手动在交互的视图上打印消息：

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

"flashSession"属性是先前在依赖注入容器中设置的闪存。
为了能成功使用flashSession消息者，你需要先启动 :doc:`session <session>` 。
