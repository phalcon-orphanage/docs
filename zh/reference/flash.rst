发送消息(Flashing Messages)
==================================
发送消息被用于向用户发送请求状态或用户行为等。使用此组件可以生成消息。

适配器(Adapters)
---------------------------
此组件使用适配器来决定使用哪种行为向用户发送消息：

+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Adapter | Description                                                                                   | API                                                                        |
+=========+===============================================================================================+============================================================================+
| Direct  | Directly outputs the messages passed to the flasher                                           | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Temporarily stores the messages in session, then messages can be printed in the next request  | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

使用方法(Usage)
---------------------------
通常情况下，消息发送这个服务被注册到服务容器中，如果你使用  :doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon_DI_FactoryDefault>`,那么默认将自动注册 "flash"服务为类型 :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`：

.. code-block:: php

    <?php

    //Set up the flash service
    $di->set('flash', function() {
        return new \Phalcon\Flash\Direct();
    });

通过这种方式，你可以直接在控制器或视图文件中访问此服务：

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {
            $this->flash->success("The post was correctly saved!");
        }

    }

内置支持的消息类型有：

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");
    $this->flash->success("yes!, everything went very smoothly");
    $this->flash->notice("this a very important information");
    $this->flash->warning("best check yo self, you're not looking too good.");

你也可以增加你自己的消息类型：

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

输出消息
-----------------
消息发送到客户端会自动转化为HTML：

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>
    <div class="successMessage">yes!, everything went very smoothly</div>
    <div class="noticeMessage">this a very important information</div>
    <div class="warningMessage">best check yo self, you're not looking too good.</div>

可以看出，有一些CSS的类名被自动添加到DIV上。这些CSS类允许你自定义在浏览器中的显示形式。CSS类可以被覆盖，例如，如果你使用 Twitter bootstrap，CSS类需这样定义：

.. code-block:: php

    <?php

    //Register the flash service with custom CSS classes
    $di->set('flash', function(){
        $flash = new \Phalcon\Flash\Direct(array(
            'error' => 'alert alert-error',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
        ));
        return $flash;
    });

上例将输出以下HTML：

.. code-block:: html

    <div class="alert alert-error">too bad! the form had errors</div>
    <div class="alert alert-success">yes!, everything went very smoothly</div>
    <div class="alert alert-info">this a very important information</div>

适配器选型(Implicit Flush vs. Session)
-------------------------------------------------------
根据选用的适配器类型，它可以直接输出消息，也可以暂时存储到用户会话中，稍后再显示。应该选用哪种适配器？这通常取决于发送消息在页面重定向之前还是之后。例如，如果你对页面做了一个"forward"类型的重定向，那么就没有必要把消息存储到用户会话中，但是如果你做了一个HTTP重定向，你需要把消息存储到用户会话中：

.. code-block:: php

    <?php

    class ContactController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            //store the post

            //Using direct flash
            $this->flash->success("Your information were stored correctly!");

            //Forward to the index action
            return $this->dispatcher->forward(array("action" => "index"));
        }

    }

或使用HTTP重定向：

.. code-block:: php

    <?php

    class ContactController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            //store the post

            //Using session flash
            $this->flashSession->success("Your information were stored correctly!");

            //Make a full HTTP redirection
            return $this->response->redirect("contact/index");
        }

    }

在这种情况下，你需要手工设置消息在相应视图中的显示位置：

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

属性  'flashSession' 是之前注册'flash'服务到容器中时产生的。
