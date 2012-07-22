
Using Controllers
=================
The controllers provide a number of methods that are called actions. Actions are methods on a controller that handle requests. By default all public methods on a controller map to actions and are accessible by a URL. Actions are responsible for interpreting the request and creating the response. Usually responses are in the form of a rendered view, but there are other ways to create responses as well.

For instance, when you access a URL like this: http://localhost/blog/posts/show/2012/the-post-title Phalcon by default will decompose each part like this:

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

In this case, the PostsController will handle this request. The controller file will be located in the controllers directory. Controllers must have the suffix "Controller" while actions the suffix "Action". A sample of a controller is as follows: 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function showAction($year, $postTitle)
        {

        }

    }

Additional URI parameters are defined as action parameters, so that they can be easily accessed using local variables. 

Dispatch Loop
-------------
The dispatch loop will be executed within the Dispatcher until there are no actions left to be executed. In the previous example only one action was executed. Now we'll see how _forward can provide a more complex flow of operation in the dispatch loop, by forwarding execution to a different controller/action. 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function showAction($year, $postTitle)
        {
            Phalcon_Flash::error("You don't have permission to access this area");

            // Forward flow to another action
            $this->_forward("users/signin");
        }

    }

If users don't have permissions to access a certain action then will be forwarded to the Users controller, signin action. 

.. code-block:: php

    <?php

    class UsersController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function signinAction()
        {

        }

    }    

There is no limit on the "forwards" you can have in your application, so long as they do not result in circular references, at which point your application will halt. If there are no other actions to be dispatched by the dispatch loop, the dispatcher will automatically invoke the view layer of the MVC which is managed by :doc:`Phalcon_View <../api/Phalcon_View>`.

Initializing Controllers
------------------------
:doc:`Phalcon_Controller <../api/Phalcon_Controller>` offers the initialize method, which is executed first, before any action is executed on a controller. The use of the "__construct" method is not recommended. 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function initialize()
        {
            $this->config = array(
                "mySetting" => "value"
            );
        }

        function saveAction()
        {
            if ($this->config["mySetting"] == "value") {
                //...
            }
        }

    }

Dispatch Events
---------------
Events enable controllers to run shared pre- and post- processing code for their actions. Every time a controller action is executed, two events are executed to check security conditions, modify application control flow or data. These events are "beforeDispatch" and "afterDispatch". The first one is executed before the controller action is dispatched. Developers can change the control flow by using a forward in that event. The second one is the "afterDispatch" event, which is executed after the controller action. 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function beforeDispatch()
        {
            if (Phalcon_Session::get("hasAuth") == false) {
                // Check whether user is authenticated and forwards him to login if not
                $this->_forward("session/login");
                return false;
            }
        }

        function indexAction()
        {

        }

    }

Request and Response
--------------------
In every controller there are two public properties pointing to the request and the response objects associated with the request cycle that is currently in execution. The "request" attribute contains an instance of :doc:`Phalcon_Request <../api/Phalcon_Request>` and the "response" attribute contains a :doc:`Phalcon_Response <../api/Phalcon_Response>` representing what is going to be sent back to the client. 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function saveAction()
        {

            // Check if request has made with POST
            if ($this->request->isPost() == true) {
                // Access POST data
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }

    }

The response object is not usually used directly, but is built up before the execution of the action, sometimes - like in an afterDispatch event - it can be useful to access the response directly: 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function notFoundAction()
        {
            // Send a HTTP 404 response header
            $this->response->setStatusCode(404, "Not Found");
        }

    }

Learn more about the request environment in its `documentation article <request.html>`_.

Session Data
------------
Sessions help us maintain persistent data between requests. You could access a :doc:`Phalcon_Session_Namespace <../api/Phalcon_Session_Namespace>` from any controller to encapsulate data that need to be persistent.

.. code-block:: php

    <?php

    class UserController extends Phalcon_Controller
    {

        function indexAction()
        {
            $this->session->name = "Michael";
        }

        function welcomeAction()
        {
            echo "Welcome, ", $this->session->name;
        }

    }

Controller Environment
----------------------
:doc:`Phalcon_Controller <../api/Phalcon_Controller>` provides some useful public attributes to interact with other active parts of the framework. Check out the API to understand and use all the available properties related to each component, so that you can use them in your actions: 

+-------------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------+-------------------+
| Component                                                   | Description                                                                                                             | Attribute         |
+=============================================================+=========================================================================================================================+===================+
| :doc:`Phalcon_Request <../api/Phalcon_Request>`             | Encapsulate the request information, such as HTTP method, POST and GET variables, POST files, languages, charsets, etc. | $this->request    |
+-------------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------+-------------------+
| :doc:`Phalcon_Response <../api/Phalcon_Response>`           | Encapsulate the response information, such as response headers, response body, etc.                                     | $this->response   |
+-------------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------+-------------------+
| :doc:`Phalcon_View <../api/Phalcon_View>`                   | Encapsulate the view that will be displayed to the used                                                                 | $this->view       |
+-------------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------+-------------------+
| :doc:`Phalcon_Dispatcher <../api/Phalcon_Dispatcher>`       | Encapsulate details of the dispatching process                                                                          | $this->dispatcher |
+-------------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------+-------------------+
| :doc:`Phalcon_Model_Manager <../api/Phalcon_Model_Manager>` | Encapsulate the models initialization, meta-data, etc                                                                   | $this->model      |
+-------------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------+-------------------+


Creating a Base Controller
--------------------------
Some application features like access control lists, translation, cache, and template engines are often common to many controllers. In cases like these the creation of a "base controller" is encouraged to ensure your code stays DRY_. A base controller is simply a class that extends the :doc:`Phalcon_Controller <../api/Phalcon_Controller>` and encapsulates the common functionality that all controllers must have. In turn, your controllers extend the "base controller" and have access to the common functionality.

This class could be located anywhere, but for organizational conventions we recommend it to be in the controllers folder, e.g. apps/controllers/ControllerBase.php. The bootstrap file must include this class: 

.. code-block:: php

    <?php

    require "../app/controllers/ControllerBase.php";

The implementation of common components (actions, methods, properties etc.) resides in this file: 

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon_Controller
    {

      /**
       * This action is available for multiple controllers
       */
      function someAction()
      {

      }

    }

Any other controller now inherits from ControllerBase, automatically gaining access to the common components (discussed above): 

.. code-block:: php

    <?php

    class UsersController extends ControllerBase
    {

    }

.. _DRY: http://en.wikipedia.org/wiki/Don't_repeat_yourself

