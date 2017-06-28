Parser Anotasi
==============

Ini kali pertama sebuah komponen parser anotasi ditulis dalam C untuk dunia PHP. :code:`Phalcon\Annotations` adalah komponen umum yang menyediakan parsing dan caching anotasi dalam kelas PHP untuk digunakan dalam aplikasi.

Anotasi dibaca dari docblocks dalam kelas, metode dan properti. Sebuah anotasi dapat ditempatkan di sembarang posisi dalam docblock:

.. code-block:: php

    <?php

    /**
     * Ini deskripsi kelas
     *
     * @AmazingClass(true)
     */
    class Example
    {
        /**
         * Ini properti dengan fitur spesial
         *
         * @SpecialFeature
         */
        protected $someProperty;

        /**
         * Ini metode
         *
         * @SpecialFeature
         */
        public function someMethod()
        {
            // ...
        }
    }

Sebuah anotasi memiliki sintaks berikut:

.. code-block:: php

    /**
     * @Annotation-Name
     * @Annotation-Name(param1, param2, ...)
     */

sebuah anotasi dapat juga ditempatkan di sembarang bagian di sebuah docblock:

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

Parser nya sangat fleksibel, docblock berikut adalah sah:

.. code-block:: php

    <?php

    /**
     * This a property with a special feature @SpecialFeature({
    someParameter="the value", false

     })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
     **/

Namun untuk membuat kode lebih mudah dirawat dan dipahami, disarankan untuk menempatkan anotasi di akhir docblock:

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     * More comments
     *
     * @SpecialFeature({someParameter="the value", false})
     * @AnotherSpecialFeature(true)
     */

Membaca Anotasi
---------------
Sebuah reflector diimplementasi untuk mendapatkan anotasi yang didefinisi dalam sebuah kelas secara mudah menggunakan interface berorientasi objek:

.. code-block:: php

    <?php

    use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

    $reader = new MemoryAdapter();

    // Reflect the annotations in the class Example
    $reflector = $reader->get("Example");

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

Proses pembacaan anotasi sangat cepat, namun, untuk alasan performa diarankan untuk menyimpan anotasi yang sudah diparsing menggunakan adapter.
Adapter menyimpan anotasi yang sudah diproses sehingga menghindari kebutuhan untuk melakukan parsing anotasi terus menerus.

:doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` dgunakan untuk contoh di atas. Adapter ini hanya menyimpan anotasi selama request berjalan
dan untuk alasan ini, adapter ini hanya cocok untuk tahap pengembangan. Ada adapter lain untuk ditukar ketika aplikasi berada dalam tahap produksi.

Jenis Anotasi
-------------
Anotasi dapat memiliki parameter atau tidak. Sebuah parameter dapat berupa nilai literal sederhana (string, angka, boolean, null), array, hashed list atau anotasi lain:

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
     *     "foo1": "bar1", "foo2": "bar2", {1, 2, 3},
     * }})
     */

    /**
     * Nested Annotations
     *
     * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
     */

Penggunaan Praktis
------------------
Berikutnya kita akan menjelaskan contoh praktis penggunaan anotasi di aplikasi PHP:

Cache Enabler dengan Anotasi
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Anggap kita ptelah menciptakan controller berikut dan anda ingin menciptakan plugin yang otomatis memulai cache ketika
aksi terakhir yang dieksekusi ditandai sebagai datap di cache. Pertama, kita daftarkan sebuah plugin ke layanan Dispatcher
untuk diberi thau ketika sebuah route dieksekusi:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di["dispatcher"] = function () {
        $eventsManager = new EventsManager();

        // Attach the plugin to 'dispatch' events
        $eventsManager->attach(
            "dispatch",
            new CacheEnablerPlugin()
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    };

CacheEnablerPlugin adalah plugin yang menyadap tiap aksi yang dieksekusi dispatcher dan menghidupkan cache jika diperlukan:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\User\Plugin;

    /**
     * Enables the cache for a view if the latest
     * executed action has the annotation @Cache
     */
    class CacheEnablerPlugin extends Plugin
    {
        /**
         * This event is executed before every route is executed in the dispatcher
         */
        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // Parse the annotations in the method currently executed
            $annotations = $this->annotations->getMethod(
                $dispatcher->getControllerClass(),
                $dispatcher->getActiveMethod()
            );

            // Check if the method has an annotation 'Cache'
            if ($annotations->has("Cache")) {
                // The method has the annotation 'Cache'
                $annotation = $annotations->get("Cache");

                // Get the lifetime
                $lifetime = $annotation->getNamedParameter("lifetime");

                $options = [
                    "lifetime" => $lifetime,
                ];

                // Check if there is a user defined cache key
                if ($annotation->hasNamedParameter("key")) {
                    $options["key"] = $annotation->getNamedParameter("key");
                }

                // Enable the cache for the current method
                $this->view->cache($options);
            }
        }
    }

Kita dapat menggunakan anotasi dalam sebuah kontroller:

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

Private/Public area dengan Anotasi
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Anda dapat menggunakan anotasi untuk memberitahu ACL kontroller mana yang termasuk area adiminstratif:

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

Adapter Anotasi
---------------
Komponen ini menggunakan adapter untuk cache atau tidak anotasi yang terproses sehingga meningkatkan performa dan menyediakan fasilitas untuk pengembangan/pengujian:

+------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Class                                                                                    | Keterangan                                                                                                                                                          |
+==========================================================================================+=====================================================================================================================================================================+
| :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` | Anotasi ini dicache di moemori saja. Ketika request berakhir cache dibersihkan dan memuat ulang anotasi di tiap request. Adapter ini cocok untuk tahap pengembangan |
+------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Files <../api/Phalcon_Annotations_Adapter_Files>`   | Anotasi yang sudah diparsing dan diproses disimpan permanent di file PHP untuk menaikkan performa. Adapter ini harus digunakan bersama bytecode cache.              |
+------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Apc <../api/Phalcon_Annotations_Adapter_Apc>`       | Anotasi yang sudah diparsing dan diproses disimpan permanent di APC cache untuk menaikkan performa. Ini adalah adapter yang lebih cepat                             |
+------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Xcache <../api/Phalcon_Annotations_Adapter_Xcache>` | Anotasi yang sudah diparsing dan diproses disimpan permanent di XCache cache untuk menaikkan performa. Ini adalah adapter yang lebih cepat                          |
+------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Implementasi adapter Anda
^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Annotations\\AdapterInterface <../api/Phalcon_Annotations_AdapterInterface>` harus diimplementasi untuk bisa menciptakan adapter anotasi anda sendiri atau mengembangkan yang sudah ada.

Sumber Luar
-----------
* `Tutorial: Creating a custom model's initializer with Annotations <https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer>`_
