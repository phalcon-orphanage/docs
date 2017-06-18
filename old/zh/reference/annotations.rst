注释解析器（Annotations Parser）
================================

这是第一个为PHP用C语言写的注释解析器。
:code:`Phalcon\Annotations` 是一个通用组件，为应用中的PHP类提供易于解析和缓存注释的功能。

注释内容是读自类，方法和属性的注释区域。一个注释单元可以放在注释区域的任何位置。

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

在上面的例子中，我们发现注释块中除了注释单元，还可以有注释内容，一个注释单元语法如下：

.. code-block:: php

    /**
     * @Annotation-Name
     * @Annotation-Name(param1, param2, ...)
     */

当然，一个注释单元可以放在注释内容里的任意位置：

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

这个解析器是高度灵活的，下面这样的注释单元是合法可解析的：

.. code-block:: php

    <?php

    /**
     * This a property with a special feature @SpecialFeature({
    someParameter="the value", false

     })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
     **/

然而，为了使代码更容易维护和理解，我们推荐把注释单元放在注释块的最后：

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     * More comments
     *
     * @SpecialFeature({someParameter="the value", false})
     * @AnotherSpecialFeature(true)
     */

读取注释（Reading Annotations）
-------------------------------
实现反射器（Reflector）可以轻松获取被定义在类中的注释，使用一个面向对象的接口即可：

.. code-block:: php

    <?php

    use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

    $reader = new MemoryAdapter();

    // 反射在Example类的注释
    $reflector = $reader->get("Example");

    // 读取类中注释块中的注释
    $annotations = $reflector->getClassAnnotations();

    // 遍历注释
    foreach ($annotations as $annotation) {
        // 打印注释名称
        echo $annotation->getName(), PHP_EOL;

        // 打印注释参数个数
        echo $annotation->numberArguments(), PHP_EOL;

        // 打印注释参数
        print_r($annotation->getArguments());
    }

虽然这个注释的读取过程是非常快速的，然而，出于性能原因，我们建议使用一个适配器储存解析后的注释内容。
适配器把处理后的注释内容缓存起来，避免每次读取都需要解析一遍注释。

:doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` 被用在上面的例子中。这个适配器只在请求过程中缓存注释（译者注：请求完成后缓存将被清空），因为这个原因，这个适配器非常适合用于开发环境中。当应用跑在生产环境中还有其他适配器可以替换。

注释类型（Types of Annotations）
--------------------------------
注释单元可以有参数也可以没有。参数可以为简单的文字(strings, number, boolean, null)，数组，哈希列表或者其他注释单元：

.. code-block:: php

    <?php

    /**
     * 简单的注释单元
     *
     * @SomeAnnotation
     */

    /**
     * 带参数的注释单元
     *
     * @SomeAnnotation("hello", "world", 1, 2, 3, false, true)
     */

    /**
     * 带名称限定参数的注释单元
     *
     * @SomeAnnotation(first="hello", second="world", third=1)
     * @SomeAnnotation(first: "hello", second: "world", third: 1)
     */

    /**
     * 数组参数
     *
     * @SomeAnnotation([1, 2, 3, 4])
     * @SomeAnnotation({1, 2, 3, 4})
     */

    /**
     * 哈希列表参数
     *
     * @SomeAnnotation({first=1, second=2, third=3})
     * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
     * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
     * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
     */

    /**
     * 嵌套数组/哈希列表
     *
     * @SomeAnnotation({"name"="SomeName", "other"={
     *     "foo1": "bar1", "foo2": "bar2", {1, 2, 3},
     * }})
     */

    /**
     * 嵌套注释单元
     *
     * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
     */

实际使用（Practical Usage）
---------------------------
接下来我们将解释PHP应用程序中的注释的一些实际的例子：

注释开启缓存（Cache Enabler with Annotations）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
我们假设一下，假设我们接下来的控制器和开发者想要建一个插件，如果被执行的方法被标记为可缓存的话，这个插件可以自动开启缓存。首先，我们先注册这个插件到Dispatcher服务中，这样这个插件将被通知当控制器的路由被执行的时候：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di["dispatcher"] = function () {
        $eventsManager = new EventsManager();

        // 添加插件到dispatch事件中
        $eventsManager->attach(
            "dispatch",
            new CacheEnablerPlugin()
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    };

CacheEnablerPlugin 这个插件拦截每一个被dispatcher执行的action，检查如果需要则启动缓存：

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\User\Plugin;

    /**
     * 为视图启动缓存，如果被执行的action带有@Cache 注释单元。
     */
    class CacheEnablerPlugin extends Plugin
    {
        /**
         * 这个事件在dispatcher中的每个路由被执行前执行
         */
        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // 解析目前访问的控制的方法的注释
            $annotations = $this->annotations->getMethod(
                $dispatcher->getControllerClass(),
                $dispatcher->getActiveMethod()
            );

            // 检查是否方法中带有注释名称‘Cache’的注释单元
            if ($annotations->has("Cache")) {
                // 这个方法带有‘Cache’注释单元
                $annotation = $annotations->get("Cache");

                // 获取注释单元的‘lifetime’参数
                $lifetime = $annotation->getNamedParameter("lifetime");

                $options = [
                    "lifetime" => $lifetime,
                ];

                // 检查注释单元中是否有用户定义的‘key’参数
                if ($annotation->hasNamedParameter("key")) {
                    $options["key"] = $annotation->getNamedParameter("key");
                }

                // 为当前dispatcher访问的方法开启cache
                $this->view->cache($options);
            }
        }
    }

现在，我们可以使用注释单元在控制器中：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class NewsController extends Controller
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

Private/Public areas with Annotations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can use annotations to tell the ACL which controllers belong to the administrative areas:

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Acl\Role;
    use Phalcon\Acl\Resource;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Acl\Adapter\Memory as AclList;

    /**
     * This is the security plugin which controls that users only have access to the modules they're assigned to
     */
    class SecurityAnnotationsPlugin extends Plugin
    {
        /**
         * This action is executed before execute any action in the application
         *
         * @param Event $event
         * @param Dispatcher $dispatcher
         */
        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            // Possible controller class name
            $controllerName = $dispatcher->getControllerClass();

            // Possible method name
            $actionName = $dispatcher->getActiveMethod();

            // Get annotations in the controller class
            $annotations = $this->annotations->get($controllerName);

            // The controller is private?
            if ($annotations->getClassAnnotations()->has("Private")) {
                // Check if the session variable is active?
                if (!$this->session->get("auth")) {

                    // The user is no logged redirect to login
                    $dispatcher->forward(
                        [
                            "controller" => "session",
                            "action"     => "login",
                        ]
                    );

                    return false;
                }
            }

            // Continue normally
            return true;
        }
    }

注释适配器（Annotations Adapters）
----------------------------------
这些组件利用了适配器去缓存或者不缓存已经解析和处理过的注释内容，从而提升了性能或者为开发环境提供了开发/测试的适配器：

+------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| Class                                                                                    | Description                                                                                                |
+==========================================================================================+============================================================================================================+
| :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` | 这个注释只缓存在内存中。当请求结束时缓存将被清空，每次请求都重新解析注释内容. 这个适配器适合用于开发环境中 |
+------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Files <../api/Phalcon_Annotations_Adapter_Files>`   | 已解析和已处理的注释将被永久保存在PHP文件中提高性能。这个适配器必须和字节码缓存一起使用。                  |
+------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Apc <../api/Phalcon_Annotations_Adapter_Apc>`       | 已解析和已处理的注释将永久保存在APC缓存中提升性能。 这是一个速度非常快的适配器。                           |
+------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Xcache <../api/Phalcon_Annotations_Adapter_Xcache>` | 已解析和已处理的注释将永久保存在XCache缓存中提升性能. 这也是一个速度非常快的适配器。                       |
+------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+

自定义适配器（Implementing your own adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
为了建立自己的注释适配器或者继承一个已存在的适配器，这个 :doc:`Phalcon\\Annotations\\AdapterInterface <../api/Phalcon_Annotations_AdapterInterface>` 接口都必须实现。

外部资源（External Resources）
------------------------------
* `Tutorial: Creating a custom model's initializer with Annotations <https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer>`_
