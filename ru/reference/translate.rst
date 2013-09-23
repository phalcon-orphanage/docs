Поддержка многоязычности
========================
Компонент :doc:`Phalcon\\Translate <../api/Phalcon_Translate>` поможет в создании многоязычных приложений. Приложения, использующие
этот компонент, отображают контент на разных языках, основываясь на выборе пользователя из поддерживаемых приложением.

Адаптеры
--------
Этот компонент позволяет использовать адаптеры для чтения, перевода сообщений из различных источников в едином виде.

+-------------+--------------------------------------------------------------------------------------------+
| Адаптер     | Описание                                                                                   |
+=============+============================================================================================+
| NativeArray | Использует PHP массивы для хранения. Это лучший вариант с точки зрения производительности. |
+-------------+--------------------------------------------------------------------------------------------+

Использование компонента
------------------------
Строки переводов хранятся в файлах. Структура этих файлов может отличаться в зависимости от используемого адаптера. Phalcon дает вам свободу
выбора в организации правил перевода строк. Типичной структурой может быть:

.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

Каждый файл содержит массив строк с переводами в виде ключ=>значение. Для каждого файла перевода, ключи уникальны. Один и тот же массив используется в
разных файлах, ключи в нём остаются прежними, а значения содержат переводы строк, разные для разных языков.

.. code-block:: php

    <?php

    //app/messages/en.php
    $messages = array(
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%"
    );

.. code-block:: php

    <?php

    //app/messages/ru.php
    $messages = array(
        "hi"      => "Здарова",
        "bye"     => "Прощай",
        "hi-name" => "Здарова %name%",
        "song"    => "Композиция %song%"
    );

Механизм осуществления перевода в приложении тривиален, но зависит от того, как вы хотите реализовать ее. Вы можете использовать
автоматическое определение языка из браузера пользователя, или вы можете предоставить выбор языка пользователю.

Простой способ обнаружения языка пользователя - разбор содержимого $_SERVER['HTTP_ACCEPT_LANGUAGE'], доступ к нему можно получить
непосредственно обратившись в $this->request->getBestLanguage() из действия/контроллера:

.. code-block:: php

    <?php

    class UserController extends \Phalcon\Mvc\Controller
    {

      protected function _getTranslation()
      {

        // Получение оптимального языка из браузера
        $language = $this->request->getBestLanguage();

        // Проверка существования перевода для полученного языка
        if (file_exists("app/messages/".$language.".php")) {
           require "app/messages/".$language.".php";
        } else {
           // Переключение на язык по умолчанию
           require "app/messages/en.php";
        }

        // Возвращение объекта работы с переводом
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

Метод _getTranslation в этом примере доступен для всех действий требующих перевода. Переменная $t передается в представление и позволяет
непосредственно переводить строки:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

The "_" function is returning the translated string based on the index passed. Some strings need to incorporate placeholders for
calculated data i.e. Hello %name%. These placeholders can be replaced with passed parameters in the "_ function. The passed parameters
are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

Функция "_" возвращает переведенные строки на основе используемого индекса. В некоторых строках необходимо использовать шаблоны подстановок,
например: "Здравствуйте % name%". Эти подстановки (placeholders) могут быть заменены передаваемыми параметрами в функцию "_". Параметры должны
передаваться в виде массива ключ/значение, где ключ соответствует названию подстановки, а значение - фактическим данным для заменены:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-user => 'Hello %name%' -->
    <p><?php echo $t->_("hi-user", array("name" => $name)); ?></p>

Существуют так же приложения с многоязычностью основанной на параметрах в URL, например как http://www.mozilla.org/**es-ES**/firefox/.
Реализовать такую схему на Phalcon можно используя компонент :doc:`Router <routing>`.

Реализация собственных адаптеров
--------------------------------
Для создания адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Translate\\AdapterInterface <../api/Phalcon_Translate_AdapterInterface>` или расширить существующий:

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
         * Возвращает перевод строки по ключу
         *
         * @param   string $translateKey
         * @param   array $placeholders
         * @return  string
         */
        public function _($translateKey, $placeholders=null);

        /**
         * Возвращает перевод, связанный с заданным ключом
         *
         * @param   string $index
         * @param   array $placeholders
         * @return  string
         */
        public function query($index, $placeholders=null);

        /**
         * Проверяет существование перевода ключа во внутреннем массиве
         *
         * @param   string $index
         * @return  bool
         */
        public function exists($index);

    }

Больше адаптеров перевода можно найти в `Инкубаторе Phalcon <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter>`_
