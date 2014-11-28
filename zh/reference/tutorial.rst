教程 1：让我们通过例子来学习（Tutorial 1: Let's learn by example）
==================================
通过这第一个教程，我们将引导您从基础完成创建简单的带有注册表单的应用。
我们也将解释框架行为的基本方面。如果您对Phalcon的自动代码生成工具有兴趣，
您可以查看 :doc:`developer tools <tools>`。

确认安装（Checking your installation）
--------------------------
我们假设你已经安装了Phalcon。请检查你的phpinfo()输出了一个"Phalcon"部分引用或者执行以下代码片段:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Phalcon 拓展应该作为输出的一部分出现:

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
使用本指南的最好方法就是依次按照每一步来做。你可以得到完整的代码 `点击这里 <https://github.com/phalcon/tutorial>`_.

文件结构（File structure）
^^^^^^^^^^^^^^
Phalcon不会强制要求应用程序的开发遵循特定的文件结构。因为它是松散耦合的，你可以实现Phalcon驱动的应用程序，以及使用对你来说最舒服的文件结构。

本教程的目的以此为起点，我们建议使用以下结构：

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

需要注意的是，你不需要任何有关Phalcon的 "library" 目录。该框架已经被加载到内存中，供您使用。

优美的 URL（Beautiful URLs）
^^^^^^^^^^^^^^
在本教程中，我们将使用相当（友好）URL。友好的URL不但利于SEO而且便于用户记忆。Phalcon支持一些最流行的Web服务器提供重写模块。让你的应用程序的URL友好不是必要的，没有它们你可以同样轻松地开发。

在这个例子中，我们将使用Apache的重写模块。 让我们在 /tutorial/.htaccess 文件中创建几个重写规则:

.. code-block:: apacheconf

    #/tutorial/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>

对该项目的所有请求都将被重定向到为public/文档根目录。此步骤可确保内部项目的文件夹仍然对公共访客隐藏，从而消除了一些安全威胁。

第二组规则将检查是否存在所请求的文件，如果存在所要请求的文件，就不需要Web服务器模块来重写：

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
你需要创建的第一个文件是引导文件。这个文件很重要; 因为它作为你的应用程序的基础，用它来控制应用程序的各个方面。
在这个文件中，你可以实现组件的初始化和应用程序的行为。

这个引导文件 tutorial/public/index.php 文件应该看起来像:

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
我们可以看出，引导程序的第一部分是注册一个自动加载器。在这个应用程序里，它将用于加载控制器和模型类。例如，我们可以为控制器注册一个或多个目录来增加应用程序的灵活性的。在我们的例子中，我们使用了 Phalcon\\Loader 组件。

有了它，我们可以加载使用各种策略类，但在这个例子中，我们选择了在预定义的目录中查找类：

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
在使用Phalcon时必须理解的一个非常重要的概念是 :doc:`依赖注入容器(dependency injection container) <di>`. 这听起来复杂,但实际上非常简单实用。

服务容器是一个全局存储的将要被使用的应用程序功能包。每次框架需要的一个组件时，会请求这个使用协定好名称的服务容器。因为Phalcon是一个高度解耦的框架，Phalcon\\DI 作为黏合剂，促使不同组件的集成，以一个透明的方式实现他们一起进行工作。

.. code-block:: php

    <?php

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

:doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon\_DI_FactoryDefault>` 是 Phalcon\\DI 的一个变体。为了让事情变得更容易，它已注册了Phalcon的大多数组件。
因此，我们不需要一个一个注册这些组件。在以后更换工厂服务的时候也不会有什么问题。

在接下来的部分，我们注册了“视图(view)”服务，指示框架将去指定的目录寻找视图文件。由于视图并非PHP类，它们不能被自动加载器加载。

服务可以通过多种方式进行登记，但在我们的教程中，我们将使用一个匿名函数 `anonymous function`_:

.. code-block:: php

    <?php

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });
    
接下来，我们注册一个基础URI，这样通过Phalcon生成包括我们之前设置的“tutorial”文件夹在内的所有的URI。
我们使用类  :doc:`\Phalcon\\Tag <../api/Phalcon_Tag>`  生成超链接，这将在本教程后续部分很重要。

.. code-block:: php

    <?php

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/tutorial/');
        return $url;
    });   

在这个文件的最后部分，我们发现 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`。其目的是初始化请求环境，并接收路由到来的请求，接着分发任何发现的动作；收集所有的响应，并在过程完成后返回它们。

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

正如你所看到的，引导文件很短，我们并不需要引入任何其他文件。在不到30行的代码里，我们已经为自己设定一个灵活的MVC应用程序。

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
