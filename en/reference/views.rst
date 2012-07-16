

Using Views
===========
Views represent the user interface of your application. Views are often HTML files with embeddedPHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. The is responsible for the managing of the standard way to generate thefinal presentation to the browser. A hierarchy of files is supported by the component allowing reducing the codingby creating common points for the application, controllers or by implementing templates. 

Integrating Views with Controllers
----------------------------------
Phalcon automatically pulls down the execution flow to the view component when the controller has ended its work.View component will look in the views directory for another directory named as the last controller executed. For instance, a request is made to the next URL *http://127.0.0.1/blog/posts/show/301* , by default Phalconwill split the URL as is follows: 

+-------------------+-----------+
| Server Address    | 127.0.0.1 | 
+-------------------+-----------+
| Phalcon Directory | blog      | 
+-------------------+-----------+
| Controller        | posts     | 
+-------------------+-----------+
| Action            | show      | 
+-------------------+-----------+
| Parameter         | 301       | 
+-------------------+-----------+

The dispatcher will look for a "PostsController" and its action "showAction". A simple controller file for this example:

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
      function indexAction()
      {
    
      }
    
      function showAction($postId)
      {
        //Pass the $postId parameter to the view
        $this->view->setVar("postId", $postId);
      }
    
    }

The setVar lets to create variables on the fly for each view executed in the current request. The above exampleshows how to pass the $postId parameter to the views with the same name. By default the View component uses PHP itself as template engine. In this case views should have the .phtml extension.If the views directory is  *app/views* then view component will find automatically for these 3 view files.

+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Name              | File                          | Description                                                                                                                                                                                                           | 
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Action View       | app/views/posts/show.phtml    | This is the view related to the action. It only will be shown when the "show" action was executed.                                                                                                                    | 
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Controller Layout | app/views/layouts/posts.phtml | This is the view related to the controller. It only will be shown for every action executed within the controller "posts". All the code implemented in the layout will reused for all the actions in this controller. | 
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Main Layout       | app/views/index.phtml         | This is main action it will be shown for every controller or action executed within the application.                                                                                                                  | 
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

You are not required to implement all of the files mentioned above. simply will pass to next view level in the hierarchy of files.If 3 view files will implement, they could be looked as follows: 

.. code-block:: php

    <!-- app/views/posts/show.phtml -->
    
    <h3>This is show view!</h3>
    
    <p>I have received the parameter <?= $postId ?></p>



.. code-block:: php

    <!-- app/views/layouts/posts.phtml -->
    
    <h2>This is the "posts" controller layout!</h2>
    
    <?= $this->getContent() ?>



.. code-block:: php

    <!-- app/views/index.phtml -->
    <html>
     <head>
      <title>Example</title>
     </head>
     <body>
    
       <h1>This is main layout!</h1>
    
       <?= $this->getContent() ?>
    
     </body>
    </html>

Note the lines where the method *$this->getContent()* was called out.It tells to View where to embed the content of the previous view executed in the hierarchy. As above, the final output sent to the browser will: 

.. figure:: ../_static/img/views-1.png
   :align: center

The generated HTML by the request will be:

.. code-block:: php

    <!-- app/views/index.phtml -->
    <html>
     <head>
      <title>Example</title>
     </head>
     <body>
    
       <h1>This is main layout!</h1>
    
       <!-- app/views/layouts/posts.phtml -->
    
       <h2>This is the "posts" controller layout!</h2>
    
         <!-- app/views/posts/show.phtml -->
    
         <h3>This is show view!</h3>
    
         <p>I have received the parameter 101</p>
    
     </body>
    </html>



Using Partials
--------------
Partial templates are another way of breaking the rendering processinto simpler chunks. With a partial, you can move the code for rendering a particular piece of a response to its own file. One way to use partials is to treat them as the equivalent of subroutines: as a way to move details out of aview so that you can grasp what's going on more easily. For example, you might have a view that looked like this: 

.. code-block:: php

    <?php $this->partial("shared/ad_banner") ?>
    
    <h1>Robots</h1>
    
    <p>Check out our specials for robots:</p>
    ...
    
    <?php $this->partial("shared/footer") ?>



Transfer values from the controller to views
--------------------------------------------
You may need to pass values from the action to the view to be presented or visualized on them. In this caseyou can access the view component within the controller and use the method setVar: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function indexAction()
       {
    
       }
    
       function showAction()
       {
          //Pass all the posts to the views
          $this->view->setVar("posts", Posts:find());
       }
    
    }

Magically a variable with the name of the first parameter become available. You can use it as you want.

.. code-block:: php

    <div class="post">
    <?php
    
      foreach($posts as $post){
        echo "<h1>", $post->title, "</h1>";
      }
    
    ?>
    </div>



Control Rendering Levels
------------------------
As seen above, there is a view hierarchy. It may also be needed to control the level of rendering producedfinally by the view component. The method Phalcon_View::setRenderLevel provides this functionality. This method can be invoked from the controller or from a superior view layer to prevent that others are presented.

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function indexAction()
       {
    
       }
    
       function findAction()
       {
    
         //This is an Ajax response so don't generate any kind of view
         $this->view->setRenderLevel(Phalcon_View::LEVEL_NO_RENDER);
    
         //...
       }
    
       function showAction($postId)
       {
         //Shows only the view related to the
         $this->view->setRenderLevel(Phalcon_View::LEVEL_ACTION_VIEW);
       }
    
    }

The available render levels are:

+-----------------------+--------------------------------------------------------------------------+
| Class Constant        | Description                                                              | 
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_NO_RENDER       | Indicates to avoid generating any kind of presentation.                  | 
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_ACTION_VIEW     | Generates the presentation to the view associated to the action.         | 
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_BEFORE_TEMPLATE | Generates presentation templates prior to the controller layout.         | 
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_LAYOUT          | Generates the presentation to the controller layout.                     | 
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_AFTER_TEMPLATE  | Generates the presentation to the templates after the controller layout. | 
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_MAIN_LAYOUT     | Generates the presentation to the main layout. File views/index.phtml    | 
+-----------------------+--------------------------------------------------------------------------+



Using models at presentation
----------------------------
Application models are always available at the presentation. Autoloader automatically will instantiate them at runtime:

.. code-block:: php

    <div class="categories">
    <?php
    
    foreach (Catergories::find("status=1") as $category) {
       echo "<span class='category'>", $category->name, "</span>";
    }
    
    ?>
    </div>

Although you may perform insert or update operations at views, we only recommendreading records at them because is not possible to forward the execution flow to another controller in case of errors. 

Picking Views
-------------
As mentioned above, when Phalcon_View is managed by the view rendered is the one related with the last controller and action executed. You couldoverride this by using the Phalcon_View::pick method: 

.. code-block:: php

    <?php
    
    class ProductsController extends Phalcon_Controller
    {
    
       function listAction()
       {
          //Pick "views-dir/products/search" as view to render
          $this->view->pick("products/search");
       }
    
    }



Caching View Fragments
^^^^^^^^^^^^^^^^^^^^^^
Sometimes when you develop dynamic websites and they arenât updated very often,the output of some pages are exactly the same between requests. Phalcon_View allows caching a part of the rendered output or the entire one. Basically, Phalcon_View is integrated with the component to provide an easier way to cache output fragments. You could manually set the cachehandler or set a global handler: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller {
    
        function initialize(){
    
           //Cache data for one day by default
           $frontendOptions = array(
              "lifetime" => 86400
           );
    
           //File cache settings
           $backendOptions = array(
              "cacheDir" => "../app/cache/"
           );
    
           //Create a memcached cache
           $cache = Phalcon_Cache::factory("Output", "Memcached", $frontendOptions, $backendOptions);
    
           //Set the cache to the view component
           $this->view->setCache($cache);
        }
    
        function showAction(){
        	//Cache the view using the default settings
            $this->view->cache(true);
        }
    
        function showArticleAction(){
        	//Cache this view for 1 hour
            $this->view->cache(array("lifetime" => 3600));
        }
    
        function resumeAction(){
        	//Cache this view for 1 day with the key "resume-cache"
            $this->view->cache(array("lifetime" => 86400, "key" => "resume-cache"));
        }
    
    }

The example above a cache was implemented in the initialize method, this only appliesto the current controller. If you want to create a cache for all drivers it's better to set options in the configuration file of the application: 

.. code-block:: php

    [views]
    cache.adapter = "File"
    cache.cacheDir = "cacheDir"
    cache.lifetime = 86400



Template Engines
----------------
From version 0.4.0, Phalcon_View allows you to use other template engines instead of plain PHP.This helps non-developers create and design views with less effort. Actually, only `Mustache <https://github.com/bobthecow/mustache.php>`_ and`Twig <http://twig.sensiolabs.org/>`_ are supported.Other template engines different than PHP require complex text parsing using external PHP librariesin order to generate the final view, this could increase the resources that your application is currently using. If an external template engine is used, Phalcon_View provide you exactly thesame view hierarchy and it's still possible to access the API inside these templates. 

Changing the Template Engine
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can replace or add more template engines from the controller as follows:

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function indexAction()
       {
         //Changing PHP engine by Mustache
         $this->view->registerEngines(array(
           ".mhtml" => "Mustache"
         ));
       }
    
       function showAction()
       {
         //Using both PHP and Mustache engines
         $this->view->registerEngines(array(
           ".phtml" => "Php",
           ".mhtml" => "Mustache"
         ));
       }
    
    }

It is possible to completely replace template engines or using more than one at the same time.Phalcon_View::registerEngines receives an array with template engines. The key of each engine is an extension that helps to differentiate one from another. Templates related to that engines must have those extensions. The order in which templates are registered means more relevance than others. If Phalcon_Viewfinds two views with the same name but different extension only the first one will render. 

Using Mustache
^^^^^^^^^^^^^^
`Mustache <http://mustache.github.com/>`_ is a logic-less template engine available for many platforms and languages.A PHP implementation is available  `here <https://github.com/bobthecow/mustache.php>`_ .You need to manually load the Mustache library before use its engine adapter. This could be doneby making a require instruction or registering an autoload function first. 

.. code-block:: php

    <?php

    require "path/to/Mustache.php";

Then, in the controller it's necessary to replace or add the Mustache adapter to theview component. If all of your actions will use this engine register it in the initialize method of the controller. 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function initialize()
       {
         //Changing PHP engine by Mustache
         $this->view->registerEngines(array(
           ".mhtml" => "Mustache"
         ));
       }
    
       function showAction()
       {
    
         $this->view->setVar("showPost", true);
         $this->view->setVar("title", "some title");
         $this->view->setVar("body", "a cool content");
    
       }
    
    }

A related view (views-dir/posts/show.mhtml) could be defined using the Mustache syntax:

.. code-block:: php

    <?php

    {{#showPost}}
      <h1>{{title}}</h1>
      <p>{{body}}</p>
    {{/showPost}}

Additionally, as seen above, you must call the method $this->getContent() inside a view to include the contentsof a view at a higher level. In Moustache, this can be done as follows: 

.. code-block:: php

    <div class="some-menu">
      <! -- the menu -->
    </div>
    
    <div class="some-main-content">
      {{getContent}}
    </div>

Finally, if you need more power, it's possible define your own Mustache instance instead ofthe implicitly created by the adapter: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function showAction()
       {
    
         //Instancing a mustache object or a sub-class of Mustache
         $presenter = new CustomMustache();
    
         // ... make some mustache stuff
    
         //Registering the object as an option
         $this->view->registerEngines(array(
           ".mhtml" => array("Mustache", array(
              "mustache" => $presenter
           ))
         ));
       }
    
    }



Using Twig
^^^^^^^^^^
`Twig <http://twig.sensiolabs.org/>`_ is a modern template engine for PHP.You need to manually load the Twig library before use its engine adapter. This could be doneby registering its autoloader: 

.. code-block:: php

    <?php

    require "path/to/twig.php";
    Twig_Autoloader::register();

As seen above, it's necessary to replace the default engine by twig or use it together with other.

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function initialize()
       {
         //Changing PHP engine by Twig
         $this->view->registerEngines(array(
           ".twig" => "Twig"
         ));
       }
    
       function showAction()
       {
    
         $this->view->setVar("showPost", true);
         $this->view->setVar("title", "some title");
         $this->view->setVar("body", "a cool content");
    
       }
    
    }

In this case, the related view will be views-dir/posts/show.twig, this is a file that contains Twig code:

.. code-block:: php

    <?php

    {{% if showPost %}}
      <h1>{{ title }}</h1>
      <p>{{ body }}</p>
    {{% endif %}}

To include the contents of a view at a higher level, the "content" variable is available to do that:

.. code-block:: php

    <div class="some-messages">
      {{ content }}
    </div>

Phalcon implicitly creates a twig object as follows:

.. code-block:: php

    <?php

    $loader = new Twig_Loader_Filesystem($viewsDirectory);
    $twig = new Twig_Environment($loader);

If you want to modify any of those variables before render the views,you can pre-build and pass them as options: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
       function showAction()
       {
    
         //Creating manually the Twig object
         $loader = new Twig_Loader_Filesystem($this->view->getViewsDir());
    	 $twig = new Twig_Environment($loader, array(
            "cache" => "/path/to/compilation_cache",
         ));
    
         //Registering the object as an option
         $this->view->registerEngines(array(
           ".twig" => array("Mustache", array(
              "twig" => $twig
           ))
         ));
    
       }
    
    }



Creating your own Template Engine
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
There are many template engines out there, you might want to integrate one of them or create your own.In this section we will explain how to do this. A template adapter is only instantiated once across the execution of the request. Normally, it onlyneed to implement two methods: __construct and render. The first one receives the Phalcon_View instance which creates the engine adapter and the options passed when the engine was registered. By the other hand, render receives an absolute path to the view file and the view-paramsset using $this->view->setVar(). You could read or require it whether it's necessary. 

.. code-block:: php

    <?php
    
    class MyTemplateAdapter extends Phalcon_View_Engine
    {
    
        /**
         * Adapter constructor
         *
         * @param Phalcon_View $view
         * @param array $options
         */
        function __construct($view, $options)
        {
           parent::__construct($view, $options);
        }
    
        /**
         * Renders a view using the template engine
         *
         * @param string $path
         * @param array $params
         */
        function render($path, $params)
        {
    
            //Access view
            $view = $this->_view;
    
            //Access options
            $options = $this->_options;
    
        }
    
    }

When registering the engine, a instance of your template adapter must be passed along with the desired extension:

.. code-block:: php

    <?php
    
    class SomeController extends Phalcon_Controller
    {
    
       function someAction()
       {
    
         //Registering the object as an engine
         $this->view->registerEngines(array(
           ".my-html" => new MyTemplateAdapter()
         ));
    
       }
    
    }



View Environment
----------------
Every view executed is included inside a instance so you can have access to its environmentallowing getting useful information you can apply in your own developments. The following example shows how to write a Jquery `ajax request <http://api.jquery.com/jQuery.ajax/>`_ using an url with the framework conventions. The method url is called from a $this instance that makesreference to a Phalcon_View object: 

.. code-block:: php

    <?php

    $.ajax({
      url: "<?= $this->url("cities/get") ?>"
    }).done(function() {
      alert("Done!");
    });



Stand-Alone Component
---------------------
All components of the framework can be used individually by being loose coupled to each other.Phalcon_View is not the exception, the following shows how to use it stand alone: 

.. code-block:: php

    <?php
    
    $view = new Phalcon_View();
    $view->setViewsDir("../app/views/");
    
    //Passing variables to the views, these will be created as local variables
    $view->setVar("someProducts", $products);
    $view->setVar("someFeatureEnabled", true);
    
    $view->start();
    $view->render("products", "list");
    $view->finish();
    
    echo $view->getContent();

