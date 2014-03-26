%{annotations_5b62537b970942c6e74522a9bac0a813}%
==================
%{annotations_4ef47a1e29a366b28e661d3c01e53776}%

%{annotations_8607b4bddce7429b9836a05cfb049643}%

.. code-block:: php

    <?php

    /**
     * This is the class description
     *
     * @AmazingClass(true)
     */
    class Example
    {

        /**
         * This a property with a special feature
         *
         * @SpecialFeature
         */
        protected $someProperty;

        /**
         * This is a method
         *
         * @SpecialFeature
         */
        public function someMethod()
        {
            // ...
        }

    }


%{annotations_1640a00bae6064c54622a8c414788eb9}%

%{annotations_7b5f373263440d6b00cce66ed3897f02}%

%{annotations_4b9121a1cbe03e1b28131cc09ab82e2d}%

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     *
     * @SpecialFeature
     *
     * More comments
     *
     * @AnotherSpecialFeature(true)
     */


%{annotations_f051f2cd8c32af61006b6b26a6b4a8a3}%

.. code-block:: php

    <?php

    /**
     * This a property with a special feature @SpecialFeature({
    someParameter="the value", false

     })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
     **/


%{annotations_f1a303ea08e74cc1885c31781c219e97}%

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     * More comments
     *
     * @SpecialFeature({someParameter="the value", false})
     * @AnotherSpecialFeature(true)
     */


%{annotations_b0492c4b8c8a5c0bd1cf3a5eac65be4e}%
-------------------
%{annotations_0bba117ba59bca6990078d40b48dd353}%

.. code-block:: php

    <?php

    $reader = new \Phalcon\Annotations\Adapter\Memory();

    //{%annotations_47438a527756cefbc23d7adedb0aadc8%}
    $reflector = $reader->get('Example');

    //{%annotations_42b762d20b4b6d4bfe9cfb054dcbf0f3%}
    $annotations = $reflector->getClassAnnotations();

    //{%annotations_4876b30905b09010b76d07e95898722e%}
    foreach ($annotations as $annotation) {

        //{%annotations_00db140955ee87d7d6ce351ad9172c5c%}
        echo $annotation->getName(), PHP_EOL;

        //{%annotations_d7223e046bc5cb1bdf3065fede6c74d3%}
        echo $annotation->numberArguments(), PHP_EOL;

        //{%annotations_2fe3777bb9cdf2d8fddc2bb932133741%}
        print_r($annotation->getArguments());
    }


%{annotations_b1925be3e508ddb8090cc414e067aa72}%

%{annotations_9ed946ff0c5927c807433adb7b0e9ee5|:doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>`}%

%{annotations_f83a38934b334d779a6d91747f24f234}%
--------------------
%{annotations_b8c4f164280d0ea40ee09419ba061366}%

.. code-block:: php

    <?php

    /**
     * Simple Annotation
     *
     * @SomeAnnotation
     */

    /**
     * Annotation with parameters
     *
     * @SomeAnnotation("hello", "world", 1, 2, 3, false, true)
     */

    /**
     * Annotation with named parameters
     *
     * @SomeAnnotation(first="hello", second="world", third=1)
     * @SomeAnnotation(first: "hello", second: "world", third: 1)
     */

    /**
     * Passing an array
     *
     * @SomeAnnotation([1, 2, 3, 4])
     * @SomeAnnotation({1, 2, 3, 4})
     */

    /**
     * Passing a hash as parameter
     *
     * @SomeAnnotation({first=1, second=2, third=3})
     * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
     * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
     * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
     */

    /**
     * Nested arrays/hashes
     *
     * @SomeAnnotation({"name"="SomeName", "other"={
     *      "foo1": "bar1", "foo2": "bar2", {1, 2, 3},
     * }})
     */

    /**
     * Nested Annotations
     *
     * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
     */


%{annotations_f741bc8c97ddb297fa5f31c8f98de0cd}%
---------------
%{annotations_919fb667c7546ab25b626125b6d77168}%

%{annotations_7d283320fd7531d8889253f5ed266522}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{annotations_a249273e53dbceb5deef37d790f32ad3}%

.. code-block:: php

    <?php

    $di['dispatcher'] = function() {

        $eventsManager = new \Phalcon\Events\Manager();

        //{%annotations_96d197a2fdcf7ba6f393dcc89284cc0a%}
        $eventsManager->attach('dispatch', new CacheEnablerPlugin());

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    };


%{annotations_588799c77202b2d2d4748719bf70bc6a}%

.. code-block:: php

    <?php

    /**
     * Enables the cache for a view if the latest
     * executed action has the annotation @Cache
     */
    class CacheEnablerPlugin extends \Phalcon\Mvc\User\Plugin
    {

        /**
         * This event is executed before every route is executed in the dispatcher
         *
         */
        public function beforeExecuteRoute($event, $dispatcher)
        {

            //{%annotations_c96cb68af4e76b1173ebbd86dcbbce5a%}
            $annotations = $this->annotations->getMethod(
                $dispatcher->getActiveController(),
                $dispatcher->getActiveMethod()
            );

            //{%annotations_afdd7046862b7a53c6c0de785c4ef771%}
            if ($annotations->has('Cache')) {

                //{%annotations_c8e8e44bdbdba89aeed039e5953e4191%}
                $annotation = $annotations->get('Cache');

                //{%annotations_a1311b1392ee702730c71383a4635db0%}
                $lifetime = $annotation->getNamedParameter('lifetime');

                $options = array('lifetime' => $lifetime);

                //{%annotations_83aa4f69e139473dc062b50930961e43%}
                if ($annotation->hasNamedParameter('key')) {
                    $options['key'] = $annotation->getNamedParameter('key');
                }

                //{%annotations_61036bedcdbfdbc453e22acd4d1e42c9%}
                $this->view->cache($options);
            }

        }

    }


%{annotations_414a26b582c57683e19a2b00bbdbbb40}%

.. code-block:: php

    <?php

    class NewsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        /**
         * This is a comment
         *
         * @Cache(lifetime=86400)
         */
        public function showAllAction()
        {
            $this->view->article = Articles::find();
        }

        /**
         * This is a comment
         *
         * @Cache(key="my-key", lifetime=86400)
         */
        public function showAction($slug)
        {
            $this->view->article = Articles::findFirstByTitle($slug);
        }

    }


%{annotations_501e20ab8ddd3a4cd24d4deac6beeb64}%
^^^^^^^^^^^^^^^^^^^^^^^^^
%{annotations_7e9e9df1430b63f01627c6ba13a1cfb3|:doc:`Phalcon\\Mvc\\View\\Simple <views>`}%

%{annotations_d53799f5a2fb02e1152ac8e975d07526}%
--------------------
%{annotations_1f3c5fb9054e5de8b9e981068a4db586}%

+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------+
| Name       | Description                                                                                                                                                                                                                          | API                                                                                      |
+============+======================================================================================================================================================================================================================================+==========================================================================================+
| Memory     | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage                                                    | :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------+
| Files      | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                                                                                | :doc:`Phalcon\\Annotations\\Adapter\\Files <../api/Phalcon_Annotations_Adapter_Files>`   |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------+
| APC        | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                                                                           | :doc:`Phalcon\\Annotations\\Adapter\\Apc <../api/Phalcon_Annotations_Adapter_Apc>`       |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------+
| XCache     | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                                                                        | :doc:`Phalcon\\Annotations\\Adapter\\Xcache <../api/Phalcon_Annotations_Adapter_Xcache>` |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------+


%{annotations_206bd6266ccc781d8844f3db2de5d557}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{annotations_4a796a3923bf7a5469b0cf40f2ec3e01|:doc:`Phalcon\\Annotations\\AdapterInterface <../api/Phalcon_Annotations_AdapterInterface>`}%

