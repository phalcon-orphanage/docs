Парсер аннотаций
================

Это первый прецедент для мира PHP, когда компонент парсера аннотаций написан на C. :code:`Phalcon\Annotations` - компонент
общего назначения, обеспечивающий простоту анализа и кэширования аннотаций для PHP классов используемых в приложениях.

Аннотации читаются из блоков комментариев docblock в классах, его методах и свойствах. Аннотации могут быть помещены в любое место блока документации docblock:

.. code-block:: php

    <?php

    /**
     * Это описание класса
     *
     * @AmazingClass(true)
     */
    class Example
    {
        /**
         * Это свойство с особенностью
         *
         * @SpecialFeature
         */
        protected $someProperty;

        /**
         * Это метод
         *
         * @SpecialFeature
         */
        public function someMethod()
        {
            // ...
        }
    }

В примере выше мы показали аннотации в комментариях, имеющие следующий синтаксис:

.. code-block:: php

    /**
     * @Annotation-Name
     * @Annotation-Name(param1, param2, ...)
     */

Аннотации также могут быть помещены в любую часть блока документации:

.. code-block:: php

    <?php

    /**
     * Это свойство с особенностью
     *
     * @SpecialFeature
     *
     * Еще комментарии
     *
     * @AnotherSpecialFeature(true)
     */

Парсер является очень гибким инструментом, поэтому следующий блок документации также является правильным:

.. code-block:: php

    <?php

    /**
     * Это свойство с особенностью @SpecialFeature({
    someParameter="the value", false

     })  Еще комментарии @AnotherSpecialFeature(true) @MoreAnnotations
     **/

Тем не менее, рекомендуется помещать аннотации в конце блоков документации, чтобы сделать код более понятным и удобным для поддержки:

.. code-block:: php

    <?php

    /**
     * Это свойство с особенностью
     * Еще комментарии
     *
     * @SpecialFeature({someParameter="the value", false})
     * @AnotherSpecialFeature(true)
     */

Чтение аннотаций
----------------
Для простого получения аннотаций класса с использованием объектно-ориентированного интерфейса, реализован рефлектор:

.. code-block:: php

    <?php

    use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

    $reader = new MemoryAdapter();

    // Отразить аннотации в классе Example
    $reflector = $reader->get("Example");

    // Прочесть аннотации в блоке документации класса
    $annotations = $reflector->getClassAnnotations();

    // Произвести обход всех аннотаций
    foreach ($annotations as $annotation) {
        // Вывести название аннотации
        echo $annotation->getName(), PHP_EOL;

        // Вывести количество аргументов
        echo $annotation->numberArguments(), PHP_EOL;

        // Вывести аргументы
        print_r($annotation->getArguments());
    }

Процесс чтения аннотаций является очень быстрым. Тем не менее, по причинам производительности, мы рекомендуем использовать адаптер для хранения обработанных аннотаций. Адаптеры кэшируют обработанные аннотации, избегая необходимости в их разборе снова и снова.

:doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` был использован в примере выше. Этот адаптер
кэширует аннотации только в процессе работы, поэтому он более подходит для разработки. Существуют и другие адаптеры,
которые можно использовать, когда приложение используется в продакшене.

Типы аннотаций
--------------
Аннотации могут иметь или не иметь параметров. Параметры могут быть простыми литералам (строкой, числом, булевым типом, null), массивом,
хешированным списком или другими аннотациями:

.. code-block:: php

    <?php

    /**
     * Простая аннотация
     *
     * @SomeAnnotation
     */

    /**
     * Аннотация с параметрами
     *
     * @SomeAnnotation("hello", "world", 1, 2, 3, false, true)
     */

    /**
     * Аннотация с именованными параметрами
     *
     * @SomeAnnotation(first="hello", second="world", third=1)
     * @SomeAnnotation(first: "hello", second: "world", third: 1)
     */

    /**
     * Передача массива
     *
     * @SomeAnnotation([1, 2, 3, 4])
     * @SomeAnnotation({1, 2, 3, 4})
     */

    /**
     * Передача хеша в качестве параметра
     *
     * @SomeAnnotation({first=1, second=2, third=3})
     * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
     * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
     * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
     */

    /**
     * Вложенные массивы/хеши
     *
     * @SomeAnnotation({"name"="SomeName", "other"={
     *     "foo1": "bar1", "foo2": "bar2", {1, 2, 3},
     * }})
     */

    /**
     * Вложенные аннотации
     *
     * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
     */

Практическое использование
--------------------------
Далее мы разберем несколько примеров по использованию аннотаций в PHP приложениях:

Кэширование с помощью аннотаций
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Давайте представим, что у нас есть контроллер и разработчик хочет сделать плагин, который автоматически запускает
кэширование если последнее запущенное действие было помечено как имеющее возможность кэширования. Прежде всего,
мы зарегистрируем плагин в сервисе Dispatcher, чтобы получать уведомление при выполнении маршрута:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di["dispatcher"] = function () {
        $eventsManager = new EventsManager();

        // Привязать плагин к событию 'dispatch'
        $eventsManager->attach(
            "dispatch",
            new CacheEnablerPlugin()
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    };

CacheEnablerPlugin это плагин, который перехватывает каждое запущенное действие в диспетчере, включая кэш если необходимо:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\User\Plugin;

    /**
     * Включение кэша для представления, если
     * последнее запущенное действие имело аннотацию @Cache
     */
    class CacheEnablerPlugin extends Plugin
    {
        /**
         * Это событие запускается перед запуском каждого маршрута в диспетчере
         */
        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // Разбор аннотаций в текущем запущенном методе
            $annotations = $this->annotations->getMethod(
                $dispatcher->getControllerClass(),
                $dispatcher->getActiveMethod()
            );

            // Проверить, имеет ли метод аннотацию 'Cache'
            if ($annotations->has("Cache")) {
                // Метод имеет аннотацию 'Cache'
                $annotation = $annotations->get("Cache");

                // Получить время жизни кэша
                $lifetime = $annotation->getNamedParameter("lifetime");

                $options = [
                    "lifetime" => $lifetime,
                ];

                // Проверить, есть ли определенный пользователем ключ кэша
                if ($annotation->hasNamedParameter("key")) {
                    $options["key"] = $annotation->getNamedParameter("key");
                }

                // Включить кэш для текущего метода
                $this->view->cache($options);
            }
        }
    }

Теперь мы можем использовать аннотации в контроллере:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class NewsController extends Controller
    {
        public function indexAction()
        {

        }

        /**
         * Это комментарий
         *
         * @Cache(lifetime=86400)
         */
        public function showAllAction()
        {
            $this->view->article = Articles::find();
        }

        /**
         * Это комментарий
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

Адаптеры аннотация
------------------
Компонент поддерживает адаптеры с возможностью кэширования проанализированных аннотаций. Это позволяет увеличивать производительность
в боевом режиме и моментальное обновление данных при разработке и тестировании.

+------------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Class                                                                                    | Описание                                                                                                                                                                         |
+==========================================================================================+==================================================================================================================================================================================+
| :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` | Аннотации в этом случае хранятся в памяти до завершения запроса. При перезагрузке страницы разбор будет осуществлён заново. Идеально для стадии разработки.                      |
+------------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Files <../api/Phalcon_Annotations_Adapter_Files>`   | Разобранные аннотации хранятся в PHP-файлах, увеличивая производительность без необходимости постоянно анализа. Рекомендуется совместное использование с кэшированием байт-кода. |
+------------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Apc <../api/Phalcon_Annotations_Adapter_Apc>`       | Разобранные аннотации хранятся в APC-кэше, самый быстрый адаптер.                                                                                                                |
+------------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Xcache <../api/Phalcon_Annotations_Adapter_Xcache>` | Разобранные аннотации хранятся в XCache-кэше. Также является быстрым адаптером.                                                                                                  |
+------------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Создание собственных адаптеров
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Для создания адаптера необходимо реализовать интерфейс  :doc:`Phalcon\\Annotations\\AdapterInterface <../api/Phalcon_Annotations_AdapterInterface>`

Внешние источники
-----------------
* `Обучение: Creating a custom model's initializer with Annotations <https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer>`_
