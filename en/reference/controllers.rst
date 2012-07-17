
Using Controllers
=================
The controllers provide a number of methods that are called actions. Actions are methods on a controller that handle requests. By default all public methods on a controller are an action, and accessible from a URL. Actions are responsible for interpreting the request and creating the response. Usually responses are in the form of a rendered view, but there are other ways to create responses as well.

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

In this case, the PostsController will handle this request. The controller file will be looked up in the controllers directory. Controllers should have the suffix "Controller" while actions the suffix "Action". It would be like: 

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

As you can see, additional URI parameters become method parameters. So you can access it easily as local variables. 

Dispatch Loop
-------------
The dispatch loop will be executed within the Dispatcher until there are not pendent actions for execution. In the previous example only once action was executed. Now we'll see how forward the execution flow to another controller/action. 

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
         //Forward flow to another action
         $this->_forward("users/signin");
      }

    }

If users don't have permissions to access a certain action then will be forwarded to another controller. 

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

You may do many "forwards" as you require. If there are not pendent action the dispatch loop will reach the end, and automatically will pull down the view part of MVC managed by Phalcon_View.

Initializing Controllers
------------------------
When you implement the "initialize" method on any controller, it will be executed the first time an action requests to a certain controller. The use of the "__construct" method is not recommended. 

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

      function saveAction(){
        if ($this->config["mySetting"] == "value") {
          //...
        }
      }

    }

Dispatch Events
---------------
Events enable controllers to run shared pre- and post- processing code for its actions. Every time a controller action is executed, two events are provided to check security conditions or modify the application control flow. Those events are "beforeDispatch" and "afterDispatch". The first one is executed before the controller action is dispatched, developers can change the control flow by using a forward in that event. The second one is the "afterDispatch" event, this one is executed after the controller action. 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

      function beforeDispatch()
      {
        if (Phalcon_Session::get("hasAuth") == false) {
          //Check whether user is authenticated and forwards him to login if not
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
In every controller there are two public properties pointing to the request and the response objects associated with the request cycle that is currently in execution. The "request" attribute contains an instance of Phalcon_Request and the "response" attribute contains a Phalcon_Response representing what is going to be sent back to the client. 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

      function indexAction()
      {

      }

      function saveAction()
      {

        //Check if request has made with POST
        if ($this->request->isPost() == true) {

          //Access POST data
          $customerName = $this->request->getPost("name");
          $customerBorn = $this->request->getPost("born");

        }

      }

    }

Moreover, the response object is not usually used directly, but is built up before the execution of the action, sometimes - like in an afterDispatch event - it can be useful to access the response directly: 

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

      function indexAction()
      {

      }

      function notFoundAction()
      {
        //Send a HTTP 404 response header
        $this->response->setStatusCode(404, "Not Found");
      }

    }

Learn more about the request environment in its documentation article.

Session Data
------------
Sessions help us to maintain persistent data between requests. You could access a Phalcon_Session_Namespace	from any controller to encapsulate data that should be persistent.

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
Phalcon_Controller provide you some useful public attributes to interact with other active parts of the framework. Checking out the API of those components will give you the knowledge to access important information you could need while executing an action: 

+-----------------------+---------------------------------------------------------------------------------------------------------------------------+-------------------+
| Component             | Description 	                                                                                                            | Attribute         |
+=======================+===========================================================================================================================+===================+
| Phalcon_Request       | Encapsulate the request information, such as HTTP method, POST and GET variables, POST files, languages, charsets, etc    | $this->request    |
+-----------------------+---------------------------------------------------------------------------------------------------------------------------+-------------------+
| Phalcon_Response      | Encapsulate the response information, such as response headers, response body, etc. 	                                    | $this->response   |
+-----------------------+---------------------------------------------------------------------------------------------------------------------------+-------------------+
| Phalcon_View 	        | Encapsulate the view that will be displayed to the used                                                                   | $this->view       |
+-----------------------+---------------------------------------------------------------------------------------------------------------------------+-------------------+
| Phalcon_Dispatcher    | Encapsulate details of the dispatching process                                                                            | $this->dispatcher |
+-----------------------+---------------------------------------------------------------------------------------------------------------------------+-------------------+
| Phalcon_Model_Manager | Encapsulate the models initialization, meta-data, etc                                                                     | $this->model      |
+-----------------------+---------------------------------------------------------------------------------------------------------------------------+-------------------+


Creating a Base Controller
--------------------------
Some application features like access control, translation, cache, and template engines are often common to multiple controllers. In those cases create a "base controller" could be useful. A base controller is simply a class that should be inherited by the controllers instead of directly inheriting Phalcon_Controller.
This class could be located at any place, but for organizational conventions we recommend to put it into the controllers directory, by example: apps/controllers/ControllerBase.php. The bootstrap file must include this class: 

.. code-block:: php

    <?php

    require "../app/controllers/ControllerBase.php";

The implementation of common actions and method is now easy when defining them here: 

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

The controllers now inherit from ControllerBase: 

.. code-block:: php

    <?php

    class UsersController extends ControllerBase
    {

    }

This class could be located at any place, but for organizational conventions we recommend to put it into the controllers directory, by example: apps/controllers/ControllerBase.php 

    