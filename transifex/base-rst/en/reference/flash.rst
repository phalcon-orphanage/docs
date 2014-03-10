%{flash_24bf1b02e73f28fcfe0a3cfb8a8df9c2}%
=================
%{flash_e3fd22485cfee69f0c7b84235597dd2b}%

%{flash_59016d3191a4f3dbf5870903d350a278}%
--------
%{flash_26523ff7e237b9b44f2f6a4d8cdf51d1}%

+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Adapter | Description                                                                                   | API                                                                        |
+=========+===============================================================================================+============================================================================+
| Direct  | Directly outputs the messages passed to the flasher                                           | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Temporarily stores the messages in session, then messages can be printed in the next request  | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+


%{flash_8674ea60087629c4dc1584b943b9f3cb}%
-----
%{flash_c490f7b344b4148068d275ad02ed2f03|:doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon_DI_FactoryDefault>`|:doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`}%

.. code-block:: php

    <?php

    //{%flash_616e07cf12ad4cad9aedbf7e3ff01344%}
    $di->set('flash', function() {
        return new \Phalcon\Flash\Direct();
    });


%{flash_2cafaa0fe3b8d1d500b1d4de40b4738f}%

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


%{flash_f284e5c118cc9dbafe4f7c5c07efda91}%

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");
    $this->flash->success("yes!, everything went very smoothly");
    $this->flash->notice("this a very important information");
    $this->flash->warning("best check yo self, you're not looking too good.");


%{flash_ac7b67e2edf59d5dbf49f3f9fbe58660}%

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");


%{flash_8d671ad3d163a29878137ba0df2b301f}%
-----------------
%{flash_a8b76fcc8f705adb8e3ef447841db2d2}%

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>
    <div class="successMessage">yes!, everything went very smoothly</div>
    <div class="noticeMessage">this a very important information</div>
    <div class="warningMessage">best check yo self, you're not looking too good.</div>


%{flash_6fe0988ed7aa5d53c4898b0b0bd2556f}%

.. code-block:: php

    <?php

    //{%flash_f0934c34bad1c49f0b868d4d254769a9%}
    $di->set('flash', function(){
        $flash = new \Phalcon\Flash\Direct(array(
            'error' => 'alert alert-error',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
        ));
        return $flash;
    });


%{flash_a9fe6b2c668a23e2ad0372966691f278}%

.. code-block:: html

    <div class="alert alert-error">too bad! the form had errors</div>
    <div class="alert alert-success">yes!, everything went very smoothly</div>
    <div class="alert alert-info">this a very important information</div>


%{flash_6396fb6f64233e5575a7a38ec61d2847}%
--------------------------
%{flash_958b592fffaf8cde8cc19a76f3557de6}%

.. code-block:: php

    <?php

    class ContactController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            //{%flash_cf31033a61a260b2b68a74ba7b72d6de%}

            //{%flash_dd261f7f644d78383877a5b558214b93%}
            $this->flash->success("Your information was stored correctly!");

            //{%flash_6886476139e90617ec3c6d43a7bce8f5%}
            return $this->dispatcher->forward(array("action" => "index"));
        }

    }


%{flash_58a33ab2f976320a9421ce5c79d78fc7}%

.. code-block:: php

    <?php

    class ContactController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            //{%flash_cf31033a61a260b2b68a74ba7b72d6de%}

            //{%flash_d436f590ca17a94ffc26002660e830fa%}
            $this->flashSession->success("Your information was stored correctly!");

            //{%flash_ee327ed3b5e26839e2c68fc457b9ba2e%}
            return $this->response->redirect("contact/index");
        }

    }


%{flash_d8065aa66a808eed7fc42303f97620db}%

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>


