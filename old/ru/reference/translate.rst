Поддержка многоязычности
========================

Компонент :doc:`Phalcon\\Translate <../api/Phalcon_Translate>` поможет в создании многоязычных приложений. Приложения, использующие
этот компонент, отображают контент на разных языках, основываясь на выборе пользователя из поддерживаемых приложением.

Адаптеры
--------
Этот компонент позволяет использовать адаптеры для чтения, перевода сообщений из различных источников в едином виде.

+------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------+
| Адаптер                                                                                        | Описание                                                                                   |
+================================================================================================+============================================================================================+
| :doc:`Phalcon\\Translate\\Adapter\\NativeArray <../api/Phalcon_Translate_Adapter_NativeArray>` | Использует PHP массивы для хранения. Это лучший вариант с точки зрения производительности. |
+------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------+

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

    // app/messages/en.php
    $messages = [
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%",
    ];

.. code-block:: php

    <?php

    // app/messages/ru.php
    $messages = [
        "hi"      => "Здарова",
        "bye"     => "Прощай",
        "hi-name" => "Здарова %name%",
        "song"    => "Композиция %song%",
    ];

Механизм осуществления перевода в приложении тривиален, но зависит от того, как вы хотите реализовать ее. Вы можете использовать
автоматическое определение языка из браузера пользователя, или вы можете предоставить выбор языка пользователю.

Простой способ обнаружения языка пользователя - разбор содержимого :code:`$_SERVER['HTTP_ACCEPT_LANGUAGE']`, доступ к нему можно получить
непосредственно обратившись в :code:`$this->request->getBestLanguage()` из действия/контроллера:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;
    use Phalcon\Translate\Adapter\NativeArray;

    class UserController extends Controller
    {
        protected function getTranslation()
        {
            // Получение оптимального языка из браузера
            $language = $this->request->getBestLanguage();

            $translationFile = "app/messages/" . $language . ".php";

            // Проверка существования перевода для полученного языка
            if (file_exists($translationFile)) {
                require $translationFile;
            } else {
                // Переключение на язык по умолчанию
                require "app/messages/en.php";
            }

            // Возвращение объекта работы с переводом
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

Метод :code:`_getTranslation()` в этом примере доступен для всех действий требующих перевода. Переменная :code:`$t` передается в представление и позволяет
непосредственно переводить строки:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

Функция :code:`_()` возвращает переведенные строки на основе используемого индекса. В некоторых строках необходимо использовать шаблоны подстановок,
например: "Здравствуйте % name%". Эти подстановки (placeholders) могут быть заменены передаваемыми параметрами в функцию :code:`_()`. Параметры должны
передаваться в виде массива ключ/значение, где ключ соответствует названию подстановки, а значение - фактическим данным для заменены:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-name => 'Hello %name%' -->
    <p><?php echo $t->_("hi-name", ["name" => $name]); ?></p>

Существуют так же приложения с многоязычностью основанной на параметрах в URL, например как http://www.mozilla.org/**es-ES**/firefox/.
Реализовать такую схему на Phalcon можно используя компонент :doc:`Router <routing>`.

Реализация собственных адаптеров
--------------------------------
Для создания адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Translate\\AdapterInterface <../api/Phalcon_Translate_AdapterInterface>` или расширить существующий:

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
         * Возвращает перевод строки по ключу
         *
         * @param   string $translateKey
         * @param   array $placeholders
         * @return  string
         */
        public function _($translateKey, $placeholders = null);

        /**
         * Возвращает перевод, связанный с заданным ключом
         *
         * @param   string $index
         * @param   array $placeholders
         * @return  string
         */
        public function query($index, $placeholders = null);

        /**
         * Проверяет существование перевода ключа во внутреннем массиве
         *
         * @param   string $index
         * @return  bool
         */
        public function exists($index);
    }

Больше адаптеров перевода можно найти в `Инкубаторе Phalcon <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter>`_
