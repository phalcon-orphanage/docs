%{translate_98c9d4681c477ea707d4970e7778f6a8}%

=====================
%{translate_4cbdb893e5aec7e8a38b05616613ecd8}%


%{translate_59016d3191a4f3dbf5870903d350a278}%

--------
%{translate_db2308e32b86da819830c6c2e5abd251}%


+-------------+-----------------------------------------------------------------------------------------+
| Adapter     | Description                                                                             |
+=============+=========================================================================================+
| NativeArray | Uses PHP arrays to store the messages. This is the best option in terms of performance. |
+-------------+-----------------------------------------------------------------------------------------+

%{translate_8a2060f36ca4f202fdf743f442c4474a}%

---------------
%{translate_52e146ffe8d9422a0563efc4216170b8}%


.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

%{translate_5f21c2607542fbb7686ddd3b43fa3682}%

.. code-block:: php

    <?php

    //{%translate_8b0b12a88ef5128b39666de8b788b264%}
    $messages = array(
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%"
    );

.. code-block:: php

    <?php

    //{%translate_cc3b719c877ead78d454923a5e5d7420%}
    $messages = array(
        "hi"      => "Bonjour",
        "bye"     => "Au revoir",
        "hi-name" => "Bonjour %name%",
        "song"    => "La chanson est %song%"
    );

%{translate_8a5da1e9769e7aef5ff07e8ee18d8f46}%

%{translate_b0a1958fe3562413949683b75c11bb9b}%

.. code-block:: php

    <?php

    class UserController extends \Phalcon\Mvc\Controller
    {

      protected function _getTranslation()
      {

        //{%translate_c0f47784dfc36ca54240ce06646e7ccd%}
        $language = $this->request->getBestLanguage();

        //{%translate_567208363f055f6525775a8bb47210ff%}
        if (file_exists("app/messages/".$language.".php")) {
           require "app/messages/".$language.".php";
        } else {
           // {%translate_d95196f5979412387168a9a2b0c5d6cf%}
           require "app/messages/en.php";
        }

        //{%translate_8cc0522120c34ed36d85b89756eed0b7%}
        return new \Phalcon\Translate\Adapter\NativeArray(array(
           "content" => $messages
        ));

      }

      public function indexAction()
      {
        $this->view->setVar("name", "Mike");
        $this->view->setVar("t", $this->_getTranslation());
      }

    }

%{translate_2ff7c999eb2ae79e0b87ae7cbf371ac7}%

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

%{translate_7eb87d7bf9fe530fd9fae17b33249c82}%

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-user => 'Hello %name%' -->
    <p><?php echo $t->_("hi-user", array("name" => $name)); ?></p>

%{translate_bb2e4b323e92c9955c11a0f6c68ed7a8}%

%{translate_206bd6266ccc781d8844f3db2de5d557}%

------------------------------
%{translate_436fc39d983c41f556d736bfba690d89}%


.. code-block:: php

    <?php

    class MyTranslateAdapter implements Phalcon\Translate\AdapterInterface
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
        public function _($translateKey, $placeholders=null);

        /**
         * Returns the translation related to the given key
         *
         * @param   string $index
         * @param   array $placeholders
         * @return  string
         */
        public function query($index, $placeholders=null);

        /**
         * Check whether is defined a translation key in the internal array
         *
         * @param   string $index
         * @return  bool
         */
        public function exists($index);

    }

