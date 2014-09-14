教程 1：让我们通过例子来学习（Tutorial 1: Let's learn by example）
==================================
通过这第一个教程，我们将引导您从基础完成创建简单的带有注册表单的应用。
我们也将解释框架行为的基本方面。如果您对Phalcon的自动代码生成工具有兴趣，
您可以查看 :doc:`developer tools <tools>`。

确认安装（Checking your installation）
--------------------------
We'll assume you have Phalcon installed already. Check your phpinfo() output for a section referencing "Phalcon" or execute the
code snippet below:

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
        [6] => pdo_mysql
    )

创建项目（Creating a project）
------------------
The best way to use this guide is to follow each step in turn. You can get the complete code `here <https://github.com/phalcon/tutorial>`_.

文件结构（File structure）
^^^^^^^^^^^^^^
Phalcon does not impose a particular file structure for application development. Due to the fact that it is loosely coupled, you can implement Phalcon powered applications with a file structure you are most comfortable using.

For the purposes of this tutorial and as a starting point, we suggest the following structure:

.. code-block:: php

    tutorial/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/

Note that you don't need any "library" directory related to Phalcon. The framework is available in memory, ready for you to use.

优美的 URL（Beautiful URLs）
^^^^^^^^^^^^^^
We'll use pretty (friendly) URLs for this tutorial. Friendly URLs are better for SEO as well as being easy for users to remember. Phalcon supports rewrite modules provided by the most popular web servers. Making your application's URLs friendly is not a requirement and you can just as easily develop without them.

In this example we'll use the rewrite module for Apache. Let's create a couple of rewrite rules in the /tutorial/.htaccess file:

.. code-block:: apacheconf

    #/tutorial/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>

All requests to the project will be rewritten to the public/ directory making it the document root. This step ensures that the internal project folders remain hidden from public viewing and thus eliminates security threats of this kind.

The second set of rules will check if the requested file exists and, if it does, it doesn't have to be rewritten by the web server module:

.. code-block:: apacheconf

    #/tutorial/public/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

引导程序（Bootstrap）
^^^^^^^^^
The first file you need to create is the bootstrap file. This file is very important; since it serves as the base of your application, giving you control of all aspects of it. In this file you can implement initialization of components as well as application behavior.

The tutorial/public/index.php file should look like:

.. code-block:: php

    <?php

    try {

        //Register an autoloader
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers/',
            '../app/models/'
        ))->register();

        //Create a DI
        $di = new Phalcon\DI\FactoryDefault();

        //Setup the view component
        $di->set('view', function(){
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../app/views/');
            return $view;
        });
        
        //Setup a base URI so that all generated URIs include the "tutorial" folder
        $di->set('url', function(){
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/tutorial/');
            return $url;
        });        

        //Handle the request
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch(\Phalcon\Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }

自动加载（Autoloaders）
^^^^^^^^^^^
The first part that we find in the bootstrap is registering an autoloader. This will be used to load classes as controllers and models in the application. For example we may register one or more directories of controllers increasing the flexibility of the application. In our example we have used the component Phalcon\\Loader.

With it, we can load classes using various strategies but for this example we have chosen to locate classes based on predefined directories:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/'
        )
    )->register();

依赖管理（Dependency Management）
^^^^^^^^^^^^^^^^^^^^^
A very important concept that must be understood when working with Phalcon is its :doc:`dependency injection container <di>`. It may sound complex but is actually very simple and practical.

A service container is a bag where we globally store the services that our application will use to function. Each time the framework requires a component, it will ask the container using an agreed upon name for the service. Since Phalcon is a highly decoupled framework, Phalcon\\DI acts as glue facilitating the integration of the different components achieving their work together in a transparent manner.

.. code-block:: php

    <?php

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

:doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon\_DI_FactoryDefault>` is a variant of Phalcon\\DI. To make things easier, it has registered most of the components that come with Phalcon. Thus we should not register them one by one. Later there will be no problem in replacing a factory service.

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

Services can be registered in several ways, but for our tutorial we'll use an `anonymous function`_:

.. code-block:: php

    <?php

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });
    
Next we register a base URI so that all URIs generated by Phalcon include the "tutorial" folder we setup earlier. This will become important later on in this tutorial when we use the class :doc:`\Phalcon\\Tag <../api/Phalcon_Tag>` to generate a hyperlink. 

.. code-block:: php

    <?php

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/tutorial/');
        return $url;
    });   

In the last part of this file, we find :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. Its purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete.

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

As you can see, the bootstrap file is very short and we do not need to include any additional files. We have set ourselves a flexible MVC application in less than 30 lines of code.

创建控制器（Creating a Controller）
^^^^^^^^^^^^^^^^^^^^^
By default Phalcon will look for a controller named "Index". It is the starting point when no controller or action has been passed in the request. The index controller (app/controllers/IndexController.php) looks like:

.. code-block:: php

    <?php

    class IndexController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            echo "<h1>Hello!</h1>";
        }

    }

The controller classes must have the suffix "Controller" and controller actions must have the suffix "Action". If you access the application from your browser, you should see something like this:

.. figure:: ../_static/img/tutorial-1.png
    :align: center

Congratulations, you're flying with Phalcon!

输出到视图（Sending output to a view）
^^^^^^^^^^^^^^^^^^^^^^^^
Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";

Our controller (app/controllers/IndexController.php) now has an empty action definition:

.. code-block:: php

    <?php

    class IndexController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }

The browser output should remain the same. The :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` static component is automatically created when the action execution has ended. Learn more about :doc:`views usage here <views>` .

设计注册表单（Designing a sign up form）
^^^^^^^^^^^^^^^^^^^^^^^^
Now we will change the index.phtml view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo Phalcon\Tag::linkTo("signup", "Sign Up Here!");

The generated HTML code displays an anchor ("a") HTML tag linking to a new controller:

.. code-block:: html

    <h1>Hello!</h1> <a href="/tutorial/signup">Sign Up Here!</a>

To generate the tag we use the class :doc:`\Phalcon\\Tag <../api/Phalcon_Tag>`. This is a utility class that allows us to build HTML tags with framework conventions in mind. A more detailed article regarding HTML generation can be :doc:`found here <tags>`

.. figure:: ../_static/img/tutorial-2.png
    :align: center

Here is the Signup controller (app/controllers/SignupController.php):

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }

The empty index action gives the clean pass to a view with the form definition (app/views/signup/index.phtml):

.. code-block:: html+php

    <?php use Phalcon\Tag; ?>

    <h2>Sign up using this form</h2>

    <?php echo Tag::form("signup/register"); ?>

     <p>
        <label for="name">Name</label>
        <?php echo Tag::textField("name") ?>
     </p>

     <p>
        <label for="email">E-Mail</label>
        <?php echo Tag::textField("email") ?>
     </p>

     <p>
        <?php echo Tag::submitButton("Register") ?>
     </p>

    </form>

Viewing the form in your browser will show something like this:

.. figure:: ../_static/img/tutorial-3.png
    :align: center

:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` also provides useful methods to build form elements.

The Phalcon\\Tag::form method receives only one parameter for instance, a relative uri to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our public/index.php file throws this exception:

    PhalconException: Action "register" was not found on controller "signup"

Implementing that method will remove the exception:

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

        }

    }

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

创建模型（Creating a Model）
^^^^^^^^^^^^^^^^
Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be defined like this:

.. code-block:: sql

    CREATE TABLE `users` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(70) NOT NULL,
      `email` varchar(70) NOT NULL,
      PRIMARY KEY (`id`)
    );

A model should be located in the app/models directory (app/models/Users.php). The model maps to the "users" table:

.. code-block:: php

    <?php

    class Users extends \Phalcon\Mvc\Model
    {

    }

设置数据库连接（Setting a Database Connection）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. A database connection is just another service that our application has that can be used for several components:

.. code-block:: php

    <?php

    try {

        //Register an autoloader
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers/',
            '../app/models/'
        ))->register();

        //Create a DI
        $di = new Phalcon\DI\FactoryDefault();

        //Setup the database service
        $di->set('db', function(){
            return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "test_db"
            ));
        });

        //Setup the view component
        $di->set('view', function(){
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../app/views/');
            return $view;
        });
        
        //Setup a base URI so that all generated URIs include the "tutorial" folder
        $di->set('url', function(){
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/tutorial/');
            return $url;
        });       

        //Handle the request
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch(Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }

With the correct database parameters, our models are ready to work and interact with the rest of the application.

使用模型保存数据（Storing data using models）
^^^^^^^^^^^^^^^^^^^^^^^^^
Receiving data from the form and storing them in the table is the next step.

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

            $user = new Users();

            //Store and check for errors
            $success = $user->save($this->request->getPost(), array('name', 'email'));

            if ($success) {
                echo "Thanks for registering!";
            } else {
                echo "Sorry, the following problems were generated: ";
                foreach ($user->getMessages() as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
            
            $this->view->disable();
        }

    }


We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields
of the record in the users table. Setting the relevant values in the new record and calling save() will store the data in the database for that record. The save() method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the save method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign up form our screen will look like this:

.. figure:: ../_static/img/tutorial-4.png
    :align: center

结束语（Conclusion）
----------
This is a very simple tutorial and as you can see, it's easy to start building an application using Phalcon.
The fact that Phalcon is an extension on your web server has not interfered with the ease of development or
features available. We invite you to continue reading the manual so that you can discover additional features offered by Phalcon!

一些应用（Sample Applications）
-------------------
The following Phalcon-powered applications are also available, providing more complete examples:

* `INVO application`_: Invoice generation application. Allows for management of products, companies, product types. etc.
* `PHP Alternative website`_: Multilingual and advanced routing application
* `Album O'Rama`_: A showcase of music albums, handling big sets of data with :doc:`PHQL <phql>` and using :doc:`Volt <volt>` as template engine
* `Phosphorum`_: A simple and clean forum


.. _anonymous function: http://php.net/manual/en/functions.anonymous.php
.. _INVO application: http://blog.phalconphp.com/post/20928554661/invo-a-sample-application
.. _PHP Alternative website: http://blog.phalconphp.com/post/24622423072/sample-application-php-alternative-site
.. _Album O'Rama: http://blog.phalconphp.com/post/37515965262/sample-application-album-orama
.. _Phosphorum: http://blog.phalconphp.com/post/41461000213/phosphorum-the-phalcons-forum
