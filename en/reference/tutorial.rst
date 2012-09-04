Tutorial: Let's learn by example
================================

Throughout this tutorial, we'll walk you through the creation of an application with a simple registration form from the ground up. We will also explain the basic aspects of the framework's behavior. If you are interested in automatic code generation tools for Phalcon, you can check our `developer tools`_.

Checking your installation
--------------------------
We'll assume you have Phalcon installed already. Check your phpinfo() output for a section referencing "Phalcon" or execute the code snippet below:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

The Phalcon extension should appear as part of the output:

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
The best way to use this guide is to follow each step in turn. You can get the complete code here_.

File structure
^^^^^^^^^^^^^^
Phalcon does not impose a particular file structure for application development. Due to the fact that it is loosely coupled, you can implement Phalcon powered applications with a file structure you are most comfortable using.

For the purposes of this tutorial and as a starting point, we suggest the following structure:

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

Note that you don't need any "library" directory related to Phalcon. The framework is available in memory, ready for you to use.

Beautiful URLs
^^^^^^^^^^^^^^
We'll use pretty (friendly) urls for this tutorial. Friendly URLs are better for SEO as well as they are easy for users to remember. Phalcon supports rewrite modules provided by the most popular web servers. Making your application's URLs friendly is not a requirement and you can just as easy develop without them.

In this example we'll use the rewrite module for Apache. Let's create a couple of rewrite rules in the /.htaccess file:

.. code-block:: apacheconf

    #/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>

All requests to the project will be rewritten to the public/ directory making it the document root. This step ensures that the internal project folders remain hidden from public viewing and thus posing security threats.

The second set of rules will check if the requested file exists, and if it does it doesn't have to be rewitten by the web server module:

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
The first file you need to create is the bootstrap file. This file is very important; since it serves as the base of your application, giving you control of all aspects of it. In this file you can implement initialization of components as well as application behavior.

Now we'll use the tools provided by the framework to implement MVC architecture with Phalcon. The :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` will easily allow us to request the MVC flow. This class automatically will instantiate Phalcon classes required to initialize the MVC. The public/index.php file should look like:

.. code-block:: php

    <?php

    try {

         $front = Phalcon_Controller_Front::getInstance();

         // Setting directories
         $front->setControllersDir("../app/controllers/");
         $front->setModelsDir("../app/models/");
         $front->setViewsDir("../app/views/");

         // Printing view output
         echo $front->dispatchLoop()->getContent();

    } catch(Phalcon_Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }

The :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete. As you can see, the file is very simple and we do not need to include any additional files or register autoloaders.

Creating a Controller
^^^^^^^^^^^^^^^^^^^^^
By default Phalcon will look for a controller named "Index". It is the starting point when no controller or action has been passed in the request. The index controller (app/controllers/IndexController.php) looks like:

.. code-block:: php

    <?php

    class IndexController extends Phalcon_Controller
    {

    	function indexAction()
    	{
    		echo "<h1>Hello!</h1>";
    	}

    }

The controller classes must have the suffix "Controller" and controller actions must have the suffix "Action". If you access the application from your browser, you should see something like this:

.. figure:: ../_static/img/tutorial-1.png
	:align: center

Congratulations, you're flying with Phalcon!

Sending output to a view
^^^^^^^^^^^^^^^^^^^^^^^^
Sending output on the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view which is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (app/views/index/index.phtml):

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

The browser output should remain the same. The :doc:`Phalcon_View <../api/Phalcon_View>` static component is automatically created when the action execution has ended. Learn more about views usage `here <views.html>`_ .

Designing a sign up form
^^^^^^^^^^^^^^^^^^^^^^^^
Now we will change the index.phtml view file, to add a link to a new controller named "signup". The goal is to allow users to sign up in our application.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo Phalcon_Tag::linkTo("signup", "Sign Up Here!");

The generated HTML code displays an "A" html tag linking to a new controller:

.. code-block:: html

    <h1>Hello!</h1> <a href="/test/signup" >Sign Up Here!</a>

To generate the tag we use the class :doc:`Phalcon_Tag <../api/Phalcon_Tag>`. This is a utility class that allows us to build HTML tags with framework conventions in mind. A more detailed article regarding HTML generation can be found `here <tags.html>`_

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
        <label for="email">E-Mail</label>
        <?= Phalcon_Tag::textField("email") ?>
     </p>

     <p>
        <?= Phalcon_Tag::submitButton("Register") ?>
     </p>

    </form>

*NOTE*: If you have short_open_tag = Off in your php.ini file, you can modify the view as such:

.. code-block:: html+php

    <h2>Sign using this form</h2>

    <?php echo Phalcon_Tag::form("signup/register"); ?>

     <p>
        <label for="name">Name</label>
        <?php echo Phalcon_Tag::textField("name"); ?>
     </p>

     <p>
        <label for="name">E-Mail</label>
        <?php echo Phalcon_Tag::textField("email"); ?>
     </p>

     <p>
        <?php echo Phalcon_Tag::submitButton("Register"); ?>
     </p>

    </form>


Viewing the form in your browser will show something like this:

.. figure:: ../_static/img/tutorial-3.png
	:align: center

:doc:`Phalcon_Tag <../api/Phalcon_Tag>` also provides useful methods to build form elements.

The Phalcon_Tag::form method receives only one parameter for instance, a relative uri to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". This exception is thrown by our public/index.php file:

    PhalconException: Action "register" was not found on controller "signup"

Implementing that method will remove the exception:

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

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object oriented code.

Creating a Model
^^^^^^^^^^^^^^^^
Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need a database table to map it to. A simple table to store registered users can be defined like this:

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
In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. The :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` config in the bootstrap file should be modified to add the database configuration settings:

.. code-block:: php

    <?php

    try {

        $front = Phalcon_Controller_Front::getInstance();

        //Setting up framework config
        $config = new Phalcon_Config(
            array(
                "database" => array(
                    "adapter"  => "Mysql",
                    "host"     => "localhost",
                    "username" => "scott",
                    "password" => "cheetah",
                    "name"     => "test_db",
                    ),
                "phalcon" => array(
                    "controllersDir" => "../app/controllers/",
                    "modelsDir"      => "../app/models/",
                    "viewsDir"       => "../app/views/",
                )
            )
        );
        $front->setConfig($config);

        //Printing view output
        echo $front->dispatchLoop()->getContent();

    } catch(Phalcon_Exception $e) {
        echo "PhalconException: ", $e->getMessage();
    }

You will notice that we have replaced the calls to setControllersDir, setModelsDir and setViewsDir on the controller with a configuration array which handles all this for us. This way the code is much cleaner and easier to maintain.

The :doc:`Phalcon_Config <../api/Phalcon_Config>` object used, can hold a number of information essential to the application and can be stored as an array on a different file or as an INI file.

With the correct database parameters, our models are ready to work and interact with the rest of the application.

Storing data using models
^^^^^^^^^^^^^^^^^^^^^^^^^
Receiving data from the form and storing them in the table is the next step.

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
                foreach ($user->getMessages() as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        }

    }

We can never trust data sent from a user. Variables passed into our application, from user input, need to have a filter applied to them so as to :doc:`validate/sanizite <filter>` their contents. This makes the application more secure because it avoids common attacks like SQL injections. In our tutorial we apply "string" to the "name" variable to ensure that user did not sent us any malicious characters. The component :doc:`Phalcon_Filter <../api/Phalcon_Filter>` makes this task trivial, since it is incorporated in the getPost call.

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields of the record in the users table. Setting the relevant values in the new record and calling save() will store the data in the database for that record. The save() method returns a boolean value which informs us on whether the storing of the data was successful or not.

Additional validation happens automatically on fields that are not null (required). If we don't type any of the required files our screen will look like this:

.. figure:: ../_static/img/tutorial-4.png
	:align: center

Conclusion
----------
This is a very simple tutorial and as you can see, it's easy to start building an application using Phalcon. The fact that Phalcon is an extension on your web server has not interfered with the ease of development or features available. We invite you to continue reading the manual so that you can discover additional features offered by Phalcon!

Sample Applications
-------------------
The following Phalcon powered applications are also available, providing more complete examples:

* `INVO application`_: Invoice generation application. Allows for management of products, companies, product types. etc.
* `PHP Alternative website`_: Multilingual and advanced routing application.

.. _developer tools: tools
.. _here: tutorial
.. _INVO application: http://blog.phalconphp.com/post/20928554661/invo-a-sample-application
.. _PHP Alternative website: http://blog.phalconphp.com/post/24622423072/sample-application-php-alternative-site

