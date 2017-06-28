多语言支持（Multi-lingual Support）
===================================

The component :doc:`Phalcon\\Translate <../api/Phalcon_Translate>` aids in creating multilingual applications.
Applications using this component, display content in different languages, based on the user's chosen language supported by the application.

适配器（Adapters）
------------------
This component makes use of adapters to read translation messages from different sources in a unified way.

+------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| Adapter                                                                                        | Description                                                                             |
+================================================================================================+=========================================================================================+
| :doc:`Phalcon\\Translate\\Adapter\\NativeArray <../api/Phalcon_Translate_Adapter_NativeArray>` | Uses PHP arrays to store the messages. This is the best option in terms of performance. |
+------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+

组件的使用（Component Usage）
-----------------------------
Translation strings are stored in files. The structure of these files could vary depending of the adapter used. Phalcon gives you the freedom
to organize your translation strings. A simple structure could be:

.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

Each file contains an array of the translations in a key/value manner. For each translation file, keys are unique. The same array is used in
different files, where keys remain the same and values contain the translated strings depending on each language.

.. code-block:: php

    <?php

    // app/messages/en.php
    $messages = [
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%",
    ];

.. code-block:: php

    <?php

    // app/messages/fr.php
    $messages = [
        "hi"      => "Bonjour",
        "bye"     => "Au revoir",
        "hi-name" => "Bonjour %name%",
        "song"    => "La chanson est %song%",
    ];

Implementing the translation mechanism in your application is trivial but depends on how you wish to implement it. You can use an
automatic detection of the language from the user's browser or you can provide a settings page where the user can select their language.

A simple way of detecting the user's language is to parse the :code:`$_SERVER['HTTP_ACCEPT_LANGUAGE']` contents, or if you wish, access it
directly by calling :code:`$this->request->getBestLanguage()` from an action/controller:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;
    use Phalcon\Translate\Adapter\NativeArray;

    class UserController extends Controller
    {
        protected function getTranslation()
        {
            // Ask browser what is the best language
            $language = $this->request->getBestLanguage();

            $translationFile = "app/messages/" . $language . ".php";

            // Check if we have a translation file for that lang
            if (file_exists($translationFile)) {
                require $translationFile;
            } else {
                // Fallback to some default
                require "app/messages/en.php";
            }

            // Return a translation object
            return new NativeArray(
                [
                    "content" => $messages,
                ]
            );
        }

        public function indexAction()
        {
            $this->view->name = "Mike";
            $this->view->t    = $this->getTranslation();
        }
    }

The :code:`_getTranslation()` method is available for all actions that require translations. The :code:`$t` variable is passed to the views, and with it,
we can translate strings in that layer:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

The :code:`_()` method is returning the translated string based on the index passed. Some strings need to incorporate placeholders for
calculated data i.e. Hello %name%. These placeholders can be replaced with passed parameters in the :code:`_()` method. The passed parameters
are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-name => 'Hello %name%' -->
    <p><?php echo $t->_("hi-name", ["name" => $name]); ?></p>

Some applications implement multilingual on the URL such as http://www.mozilla.org/**es-ES**/firefox/. Phalcon can implement
this by using a :doc:`Router <routing>`.

自定义适配器（Implementing your own adapters）
----------------------------------------------
The :doc:`Phalcon\\Translate\\AdapterInterface <../api/Phalcon_Translate_AdapterInterface>` interface must be implemented
in order to create your own translate adapters or extend the existing ones:

.. code-block:: php

    <?php

    use Phalcon\Translate\AdapterInterface;

    class MyTranslateAdapter implements AdapterInterface
    {
        /**
         * Adapter constructor
         *
         * @param array $data
         */
        public function __construct($options);

        /**
         * Returns the translation string of the given key
         *
         * @param   string $translateKey
         * @param   array $placeholders
         * @return  string
         */
        public function _($translateKey, $placeholders = null);

        /**
         * Returns the translation related to the given key
         *
         * @param   string $index
         * @param   array $placeholders
         * @return  string
         */
        public function query($index, $placeholders = null);

        /**
         * Check whether is defined a translation key in the internal array
         *
         * @param   string $index
         * @return  bool
         */
        public function exists($index);
    }

There are more adapters available for this components in the `Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter>`_
