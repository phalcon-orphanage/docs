多语言支持
=====================
在应用程序开发中，可使用:doc:`Phalcon\\Translate <../api/Phalcon_Translate>` 组件帮助实现多语言。使用此组件，可根据用户选择的语言提供相应的语言支持。

适配器
--------
该组件使用适配器，以统一的方式读取相应的语言文件。

+-------------+-----------------------------------------------------------------------------------------+
| Adapter     | Description                                                                             |
+=============+=========================================================================================+
| NativeArray | Uses PHP arrays to store the messages. This is the best option in terms of performance. |
+-------------+-----------------------------------------------------------------------------------------+

Component Usage
---------------
翻译的字符串存储在文件中，这些文件的结构可能会有所不同，具体取决于你所使用的适配器。Phalcon允许你自由的组织翻译，简单的结构可能是这样：

.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

每个翻译文件都包含一个由key/value组成的数组。对于每一个翻译文件，key都是唯一的，相同的数组需要使用不同的文件，保持key不变，value值根据每种语言进行翻译即可。

.. code-block:: php

    <?php

    //app/messages/es.php
    $messages = array(
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%"
    );

.. code-block:: php

    <?php

    //app/messages/fr.php
    $messages = array(
        "hi"      => "Bonjour",
        "bye"     => "Au revoir",
        "hi-name" => "Bonjour %name%",
        "song"    => "La chanson est %song%"
    );

在应用程序中实现语言转化机制并不难，关键取决于你想如何实现它。你可以根据检测用户的浏览器语言为用户提供相应的语言支持或者提供一个设置页面供用户自己选择他们想要的语言。

一个简单的用于检测客户端用户语言的方式是通过 $_SERVER['HTTP_ACCEPT_LANGUAGE']，或者也可以在controller/action中直接调用 $this->request->getBestLanguage() 也可。

.. code-block:: php

    <?php

    class UserController extends \Phalcon\Mvc\Controller
    {

      protected function _getTranslation()
      {

        //Ask browser what is the best language
        $language = $this->request->getBestLanguage();

        //Check if we have a translation file for that lang
        if (file_exists("app/messages/".$language.".php")) {
           require "app/messages/".$language.".php";
        } else {
           // fallback to some default
           require "app/messages/en.php";
        }

        //Return a translation object
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

本例中的 _getTranslation 适用于整个控制器，通过变量 $t 传递翻译字符到视图，并且使用它。我们可以在视图层这样使用翻译字符串：

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

函数"_"通过传递的key返回翻译后的字符串。一些字符串中可能包含有占位符，如 Hello %name%。这些点位符可以通过函数"_"来传递参数进行替换，传递的参数是一个key/value的数组，其中的key是占位符名称，值是被替换的数据：

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-user => 'Hello %name%' -->
    <p><?php echo $t->_("hi-user", array("name" => $name)); ?></p>

一些应用程序实现了基于URL的多语言，如 http://www.mozilla.org/**es-ES**/firefox/. Phalcon 通过使用 :doc:`Router <routing>` 也可以实现一样的效果。

Implementing your own adapters
------------------------------
The :doc:`Phalcon\\Translate\\AdapterInterface <../api/Phalcon_Translate_AdapterInterface>` interface must be implemented in order to create your own translate adapters or extend the existing ones:

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


