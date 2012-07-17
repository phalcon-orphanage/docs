Tutorial: Let’s learn by example
================================

Throughout this tutorial, we’ll walk you through the creation of a simple registration form from scratch. Also we'll explain the basic aspects of the framework behavior. If you like more code generators stuff can also read about `developer tools <tools.html>`_. 

Checking your installation
--------------------------
We’ll assume you have Phalcon installed already. Check your phpinfo() output for something talking about "Phalcon" or execute the next code snippet: 

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Phalcon extension should appear as part of the output: 

.. code-block:: php

    Array
    (
        [0] => Core
        [1] => libxml
        [2] => filter
        [3] => SPL
        [4] => standard
        [5] => phalcon
        [6] => mysql
        [7] => mysqli
    )

Creating a project
------------------
The best way to use this guide is to follow each step as it happens, no code or step needed to make this example application has been left out, and so you can literally follow along step by step. You can get the complete code `here <tutorial.html>`_.     

File structure
^^^^^^^^^^^^^^
You are not forced to implement a pre-defined file structure for your projects. The Phalcon loosely coupled nature gives you the freedom to choose the file structure you like. For academic purposes we suggest you to use the next structure: 

.. code-block:: php

    test/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/

Note that you don't need any "library" directory related to Phalcon. The framework is available at any place without copy or load additional files.  

Pretty URLs
^^^^^^^^^^^
We'll use pretty urls for this tutorial. Friendly URLs are better for search engine SEO. Phalcon supports rewrite engines provided by most popular web servers. Also you can write the application without a rewrite engine. In this example we'll use the rewrite engine for Apache. Let's create a couple of rewrite rules in the /.htaccess file: 

.. code-block:: apacheconf

    #/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>

All requests to the project directory will rewrite to the public/ directory making this as document root. It will also that internal project directories will be hidden from the public. Our second rules will check if the requested file exists doesn't be rewritten by the engine: 

.. code-block:: apacheconf

    #/public/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=$1 [QSA,L]
    </IfModule>    

Bootstrap
^^^^^^^^^
The first file you need to create is the bootstrap file. This file is very important; it will give you all the project control. In that file you can implement the application behavior and integrate the components of your choice.

Now we'll use the tools provided by the framework to implement MVC architecture with Phalcon. The `Phalcon_Controller_Front <../api/Phalcon_Controller_Front.html>`_ will easily allow us to orquest the MVC flow. This class automatically will instantiate Phalcon classes required to make the MVC work. The public/index.php file should look like:

.. code-block:: php

    <?php

    try {

     $front = Phalcon_Controller_Front::getInstance();

     //Setting directories
     $front->setControllersDir("../app/controllers/");
     $front->setModelsDir("../app/models/");
     $front->setViewsDir("../app/views/");

     //Printing view output
     echo $front->dispatchLoop()->getContent();

    } catch(Phalcon_Exception $e) {
     echo "PhalconException: ", $e->getMessage();
    }

The `Phalcon_Controller_Front <../api/Phalcon_Controller_Front.html>`_ purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete. The file is very simple, keep in mind we do not need include any file or register an autoloader. 

Creating a Controller
^^^^^^^^^^^^^^^^^^^^^
By default Phalcon will look for a controller named "Index". It will be the starting point when no controller or action was given. The index controller (app/controllers/IndexController.php) looks like: 

.. code-block:: php

    <?php

    class IndexController extends Phalcon_Controller
    {

    	function indexAction()
    	{
    		echo "<h1>Hello!</h1>";
    	}

    }

The controller classes should have the suffix "Controller" and controller actions have the suffix "Action". Now access the application from your browser, it will show something like this: 

.. figure:: ../_static/img/tutorial-1.png
	:align: center

Congratulations, you’re flying with Phalcon!

Moving output to a view
^^^^^^^^^^^^^^^^^^^^^^^
But doing output inside actions it's ugly for MVC lovers. Let's move it to a related view. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";

Our controller (app/controllers/IndexController.php) now has an empty action definition: 

.. code-block:: php

    <?php

    class IndexController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

    }

The browser output should remain the same. The `Phalcon_View <../api/Phalcon_View.html>`_ static component is automatically created when the action execution has ended. Learn more about views usage `here <views.html>`_ .

Designing a sign up form
^^^^^^^^^^^^^^^^^^^^^^^^
Now we will change the index.phtml view to add a link to a new controller named "signup". Its goal is to allow users to sign up in some application.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo Phalcon_Tag::linkTo("signup", "Sign Up Here!");

The generated HTML code brings an "A" html tag linking to a new controller:

.. code-block:: html

    <h1>Hello!</h1> <a href="/test/signup" >Sign Up Here!</a>

As you saw, the class `Phalcon_Tag <../api/Phalcon_Tag.html>`_ has made its entrance. Its purpose it's to help us to build HTML tags with framework conventions in mind. A deeper article about HTML generation can be found `here <tags.html>`_    

.. figure:: ../_static/img/tutorial-2.png
	:align: center

Here is the controller Signup (app/controllers/SignupController.php): 

.. code-block:: php

    <?php

    class SignupController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

    }

The empty index action gives the clean pass to a view with the form definition: 

.. code-block:: html+php

    <h2>Sign using this form</h2>

    <?= Phalcon_Tag::form("signup/register") ?>

     <p>
        <label for="name">Name</label>
        <?= Phalcon_Tag::textField("name") ?>
     </p>

     <p>
        <label for="name">E-Mail</label>
        <?= Phalcon_Tag::textField("email") ?>
     </p>

     <p>
        <?= Phalcon_Tag::submitButton("Register") ?>
     </p>

    </form>

Viewing the form in your browser will show something like this:

.. figure:: ../_static/img/tutorial-3.png
	:align: center

As you can see Phalcon_Tag also provides useful methods to build form elements.

The Phalcon_Tag::form method receives only one parameter in the example. A relative uri to a controller/action in the application. By doing click in the "Send" button will throw an exception from the framework indicating that we are missing the "register" action in the controller "signup": 	

    PhalconException: Action "register" was not found on controller "signup"

Implementing that method will solve the exception:      

.. code-block:: php

    <?php

    class SignupController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function registerAction()
        {

        }

    }

Now make click in the "Send" button will show you a blank page. The name and email input provided by the user should be stored on a database. The MVC suggests us to use the models part to manage database tables in an object oriented way.

Creating a Model
^^^^^^^^^^^^^^^^
Phalcon brings to us the first ORM for PHP entirely written in C-language. Far from increasing the complexity of development, simplifies it. Before of creating our first model, we need a database table to map it.
A simple table to store registered users can be defined like this:

.. code-block:: sql

    CREATE TABLE `users` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(70) NOT NULL,
      `email` varchar(70) NOT NULL,
      PRIMARY KEY (`id`)
    );

A model should be located in the app/models directory. The model mapping to "users" table: 

.. code-block:: php

    <?php

    class Users extends Phalcon_Model_Base
    {

    }

Setting a Database Connection
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
There is not complexity about using models. But we forgot one small detail. We need to tell Phalcon which connection database parameters users class needs to successfully map table with it. The `Phalcon_Controller_Front <../api/Phalcon_Controller_Front.html>`_ config in the bootstrap file should be modified to add the new configuration settings: 

.. code-block:: php

    <?php

    try {

     $front = Phalcon_Controller_Front::getInstance();

     //Setting up framework config
     $config = new Phalcon_Config(array(
       "database" => array(
         "adapter" => "Mysql",
         "host" => "localhost",
         "username" => "scott",
         "password" => "cheetah",
         "name" => "test_db"
       ),
       "phalcon" => array(
         "controllersDir" => "../app/controllers/",
         "modelsDir" => "../app/models/",
         "viewsDir" => "../app/views/"
       )
     ));
     $front->setConfig($config);

     //Printing view output
     echo $front->dispatchLoop()->getContent();

    } catch(Phalcon_Exception $e) {
     echo "PhalconException: ", $e->getMessage();
    }

We previously replaced defined settings on a new `Phalcon_Config <../api/Phalcon_Config.html>`_ object with database configuration. Also you may define settings on a file by separate using ini or other formats.

With database parameters our models are ready to work and interact.

Storing data using models
^^^^^^^^^^^^^^^^^^^^^^^^^
Receiving data from the form and storing them in the table will be our next step. 

.. code-block:: php

    <?php

    class SignupController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function registerAction()
        {

            //Request variables from html form
            $name = $this->request->getPost("name", "string");
            $email = $this->request->getPost("email", "email");

            $user = new Users();
            $user->name = $name;
            $user->email = $email;

            //Store and check for errors
            if ($user->save() == true) {
                echo "Thanks for register!";
            } else {
                echo "Sorry, the next problems was generated: ";
                foreach ($user->getMessages() as $message){
                    echo $message->getMessage(), "<br/>";
                }
            }
        }

    }

When you receive a variable from input you can optionally apply a filter to `validate/sanizite <filter.html>`_ the values. This will make your application more secure because it's avoiding common attacks like SQL injections. In the example we apply "string" to the "name" variable to ensure that user typed no malicious chars. The component `Phalcon_Filter <../api/Phalcon_Filter.html>`_ makes the work in an implicit way.

Then instantiates Users class will give us the possibility to assign values to public members with the same name as the fields in the table. The save method finishes the storing process. The returning true value tells us if saving was successful or not. If we don't type any of the required files our screen will look like this:     

.. figure:: ../_static/img/tutorial-4.png
	:align: center

Conclusion
----------
This is a very simple tutorial and as you can see, it's easy to start developing an application using Phalcon. The fact that is an extension has not removed the ease of developing. We invite you to continue reading the manual to know the other features the framework provides.

Sample Applications
-------------------
The following applications are also available to provide more complete examples to create applications with Phalcon:

* `INVO application`_: A simple application to generate invoices. Allows to create products, companies, product types. etc.
* `PHP Alternative website`_: This sample application explains how to create a multi-lingual application, also shows how to implement advanced routes.

.. _INVO application: http://blog.phalconphp.com/post/20928554661/invo-a-sample-application
.. _PHP Alternative website: http://blog.phalconphp.com/post/24622423072/sample-application-php-alternative-site

