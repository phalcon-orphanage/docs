Annotations Parser
==================
It is the first time that an annotations parser component is written in C for the PHP world. Phalcon\\Annotations is
a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

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

In the above example we find some annotations in the comments, an annotation has the following syntax:

@Annotation-Name[(param1, param2, ...)]

Also, an annotation could be placed at any part of a docblock:

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

The parser is highly flexible, the following docblock is valid:

.. code-block:: php

    <?php

    /**
     * This a property with a special feature @SpecialFeature({
    someParameter="the value", false

     })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
     **/

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     * More comments
     *
     * @SpecialFeature({someParameter="the value", false})
     * @AnotherSpecialFeature(true)
     */

Reading Annotations
-------------------
A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

.. code-block:: php

    <?php

    $reader = new \Phalcon\Annotations\Adapter\Memory();

    // Reflect the annotations in the class Example
    $reflector = $reader->get('Example');

    // Read the annotations in the class' docblock
    $annotations = $reflector->getClassAnnotations();

    // Traverse the annotations
    foreach ($annotations as $annotation) {

        // Print the annotation name
        echo $annotation->getName(), PHP_EOL;

        // Print the number of arguments
        echo $annotation->numberArguments(), PHP_EOL;

        // Print the arguments
        print_r($annotation->getArguments());
    }

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter.
Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

:doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` was used in the above example. This adapter
only caches the annotations while the request is running, for this reason th adapter is more suitable for development. There are
other adapters to swap out when the application is in production stage.

Types of Annotations
--------------------
Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

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
     *        "foo1": "bar1", "foo2": "bar2", {1, 2, 3},
     * }})
     */

    /**
     * Nested Annotations
     *
     * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
     */

Practical Usage
---------------
Let's pretend we've the following controller and the developer wants to create a plugin that automatically starts the
cache if the latest action executed is marked as cacheable. First off all we register a plugin in the Dispatcher service
to be notified when a route is executed:

.. code-block:: php

    <?php

    $di['dispatcher'] = function () {

        $eventsManager = new \Phalcon\Events\Manager();

        // Attach the plugin to 'dispatch' events
        $eventsManager->attach('dispatch', new CacheEnablerPlugin());

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    };

CacheEnablerPlugin is a plugin that intercepts every action executed in the dispatcher enabling the cache if needed:

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

            // Parse the annotations in the method currently executed
            $annotations = $this->annotations->getMethod(
                $dispatcher->getActiveController(),
                $dispatcher->getActiveMethod()
            );

            // Check if the method has an annotation 'Cache'
            if ($annotations->has('Cache')) {

                // The method has the annotation 'Cache'
                $annotation = $annotations->get('Cache');

                // Get the lifetime
                $lifetime = $annotation->getNamedParameter('lifetime');

                $options = array('lifetime' => $lifetime);

                // Check if there is a user defined cache key
                if ($annotation->hasNamedParameter('key')) {
                    $options['key'] = $annotation->getNamedParameter('key');
                }

                // Enable the cache for the current method
                $this->view->cache($options);
            }

        }

    }

Now, we can use the annotation in a controller:

.. code-block:: php

    <?php

    class NewsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        /**
         * This is comment
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


