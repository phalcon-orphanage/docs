Flashing Messages
=================
Flash messages are used to notify the user about the state of actions he/she made or simply show information to the users. This kind of
messages can be generated using

Adapters
--------
This component makes use of adapters to define the behavior of the messages after being passed to the Flasher:

+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Adapter | Description                                                                                   | API                                                                        |
+=========+===============================================================================================+============================================================================+
| Direct  | Directly outputs the messages passed to the flasher                                           | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Temporarily stores the messages in session, then messages can be printed in the next request  | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

Usage
-----
Usually the Flash Messaging service is requested from the services container,
if you're using :doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon_DI_FactoryDefault>`
then :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>` is automatically registered as "flash" service:

.. code-block:: php

    <?php

    //Set up the flash service
    $di->set('flash', function() {
        return new \Phalcon\Flash\Direct();
    });

This way, you can use it in controllers or views by injecting the service in the required scope:

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

There are four built-in message types supported:

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");
    $this->flash->success("yes!, everything went very smoothly");
    $this->flash->notice("this a very important information");
    $this->flash->warning("best check yo self, you're not looking too good.");

You can add messages with your own types:

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

Printing Messages
-----------------
Messages sent to the flasher are automatically formatted with html:

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>
    <div class="successMessage">yes!, everything went very smoothly</div>
    <div class="noticeMessage">this a very important information</div>
    <div class="warningMessage">best check yo self, you're not looking too good.</div>

As can be seen, also some CSS classes are added automatically to the DIVs. These classes allow you to define the graphical presentation
of the messages in the browser. The CSS classes can be overridden, for example, if you're using Twitter bootrstrap, classes can be configured as:

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

Then the messages would be printed as follows:

.. code-block:: html

    <div class="alert alert-error">too bad! the form had errors</div>
    <div class="alert alert-success">yes!, everything went very smoothly</div>
    <div class="alert alert-info">this a very important information</div>

Implicit Flush vs. Session
--------------------------
Depending on the adapter used to send the messages, it could be producing output directly, or be temporarily storing the messages in session to be shown later.
When should you use each? That usually depends on the type of redirection you do after sending the messages. For example if you make a "forward"
is not necessary to store the messages in session, but if you do a HTTP redirect then they need to be stored in session:

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

Or using a HTTP redirection:

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

In this case you need to print manually the messages in the corresponding view:

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

The attribute 'flashSession' is how the flash was previously set into the dependency injector.
