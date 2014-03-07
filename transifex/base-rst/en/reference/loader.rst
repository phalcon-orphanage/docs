%{loader_c8f48d17ec17f73c71701dbefa922bbe}%
======================
%{loader_e9efafebf4cb67840a64a80aff0daf0c}%

%{loader_e4c6f8515974b8349488fe3d89d75280}%

%{loader_6e14a95cb826e28080486414b346a683}%

%{loader_334d1d8c943955240927884d0cd43b58}%

%{loader_f0d1ea6f8ecdc3c9be68760b4db0bb54}%
----------------------
%{loader_e1df98f6943b181da25c4f0cd238e04c}%

.. code-block:: php

    <?php

    // {%loader_4b4ba81e5d13f4105da1c536c17e790e%}
    $loader = new \Phalcon\Loader();

    //{%loader_b365b3098f8bada9ada29235f6405308%}
    $loader->registerNamespaces(
        array(
           "Example\Base"    => "vendor/example/base/",
           "Example\Adapter" => "vendor/example/adapter/",
           "Example"         => "vendor/example/",
        )
    );

    // {%loader_974a6d2fc8d2eda86afedcbe99ba9670%}
    $loader->register();

    // {%loader_4d55139683b97606adab8b179f54f916%}
    // {%loader_e90d8097da0b4e429f30d55a2d335eff%}
    $some = new Example\Adapter\Some();

%{loader_9fc168b6855cd7b997409068c74c496a}%
--------------------
%{loader_bf8461fb6eccab1951e194ec636657d3}%

.. code-block:: php

    <?php

    // {%loader_4b4ba81e5d13f4105da1c536c17e790e%}
    $loader = new \Phalcon\Loader();

    //{%loader_80d81894c6ec279f72c8925ed3b552a8%}
    $loader->registerPrefixes(
        array(
           "Example_Base"     => "vendor/example/base/",
           "Example_Adapter"  => "vendor/example/adapter/",
           "Example_"         => "vendor/example/",
        )
    );

    // {%loader_974a6d2fc8d2eda86afedcbe99ba9670%}
    $loader->register();

    // {%loader_4d55139683b97606adab8b179f54f916%}
    // {%loader_e90d8097da0b4e429f30d55a2d335eff%}
    $some = new Example_Adapter_Some();

%{loader_f9a1bb9e4166386c8996631599b15b81}%
-----------------------
%{loader_d6e445d6d41140c51fb599b42816e741}%

.. code-block:: php

    <?php

    // {%loader_4b4ba81e5d13f4105da1c536c17e790e%}
    $loader = new \Phalcon\Loader();

    // {%loader_2ca87035b51a0efda122b88cce1f8d6a%}
    $loader->registerDirs(
        array(
            "library/MyComponent/",
            "library/OtherComponent/Other/",
            "vendor/example/adapters/",
            "vendor/example/"
        )
    );

    // {%loader_974a6d2fc8d2eda86afedcbe99ba9670%}
    $loader->register();

    // {%loader_d530bf9509e078b10e089a8336c504e7%}
    // {%loader_02f3bb1b6cbd25185a722f86d5c645c6%}
    // {%loader_e642de17f8ef58b01d672536783d18a5%}
    $some = new Some();

%{loader_3fb81c3fa5af1fb24fa95ce3a29a1546}%
-------------------
%{loader_ffa6e96687b518bb06e47a1dbba4c2e8}%

.. code-block:: php

    <?php

    // {%loader_4b4ba81e5d13f4105da1c536c17e790e%}
    $loader = new \Phalcon\Loader();

    // {%loader_d44269b3d8851f6b1e0fccf6afa06506%}
    $loader->registerClasses(
        array(
            "Some"         => "library/OtherComponent/Other/Some.php",
            "Example\Base" => "vendor/example/adapters/Example/BaseClass.php",
        )
    );

    // {%loader_974a6d2fc8d2eda86afedcbe99ba9670%}
    $loader->register();

    // {%loader_19b41511f55c0eda2a991fcf351d377b%}
    // {%loader_d142b7f8a10d00c5f0ca4482e7a181eb%}
    // {%loader_e642de17f8ef58b01d672536783d18a5%}
    $some = new Some();

%{loader_681e56350f1db61e293841bb6d7b4c06}%
--------------------------
%{loader_5973661d6bf969480e9ce6961b9ef4e2}%

.. code-block:: php

    <?php

     // {%loader_4b4ba81e5d13f4105da1c536c17e790e%}
    $loader = new \Phalcon\Loader();

    //{%loader_9f6cb2e9ce681cf0eaf7326cc9978301%}
    $loader->setExtensions(array("php", "inc", "phb"));

%{loader_9bb8905b56939f589ab60a39a3f7cad3}%
----------------------------
%{loader_69b2ab1eaa9b57f73f1c7f307e98c253}%

.. code-block:: php

    <?php

    // {%loader_36353d5e937e32a21b483c820274d1d6%}
    $loader->registerDirs(
        array(
            "../app/library/",
            "../app/plugins/"
        ),
        true
    );

%{loader_d90de01f4d9134715969c2aa6bae6174}%

%{loader_d946d4fc503cdc77e799865f0f0ec045}%
--------------
%{loader_01ac6473cbf5b4105e52ec38365236bc}%

.. code-block:: php

    <?php

    //{%loader_9f09a50d5ff20f231536e64a5470f34a%}
    spl_autoload_register(function($className) {
        if (file_exists($className . '.php')) {
            require $className . '.php';
        }
    });

%{loader_e13269138f9f39bec8a393a4055d5c07}%

.. code-block:: php

    <?php

    //{%loader_5394a579ea762ea2fbc3743172498043%}
    $className = '../processes/important-process';

    //{%loader_bff05a46e9a8ac0538aa324add0c506d%}
    if (class_exists($className)) {
        //...
    }

%{loader_1724c47e8b4eab6cf91921fe9df7ea59}%

%{loader_45fd426d2bb6952a4b325897f7a59b40}%

%{loader_b6386395fed27ad94fc2fc7a570fe221}%
------------------
%{loader_ec0aafc547f07550a41c144843c6af14}%

.. code-block:: php

    <?php

    $eventsManager = new \Phalcon\Events\Manager();

    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces(array(
       'Example\\Base' => 'vendor/example/base/',
       'Example\\Adapter' => 'vendor/example/adapter/',
       'Example' => 'vendor/example/'
    ));

    //{%loader_300862db2c4124e3da5ab44ceb465f6b%}
    $eventsManager->attach('loader', function($event, $loader) {
        if ($event->getType() == 'beforeCheckPath') {
            echo $loader->getCheckedPath();
        }
    });

    $loader->setEventsManager($eventsManager);

    $loader->register();

%{loader_b35fc09e5f2a9209956905e3f7a9f1e0}%

+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| Event Name       | Triggered                                                                                                           | Can stop operation? |
+==================+=====================================================================================================================+=====================+
| beforeCheckClass | Triggered before starting the autoloading process                                                                   | Yes                 |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| pathFound        | Triggered when the loader locate a class                                                                            | No                  |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| afterCheckClass  | Triggered after finish the autoloading process. If this event is launched the autoloader didn't find the class file | No                  |
+------------------+-----------------------------------------------------------+---------------------------------------------------------+---------------------+

%{loader_f07747c719e154f6ba1384e010ddc59e}%
---------------
%{loader_1a3657a13f35fe1e1963850259869e36}%

%{loader_bbe24be5c2cdda53e9de9551de186ff0}%

