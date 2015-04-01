Заголовки запроса (Request)
===========================
Каждый HTTP-запрос (исходящий как правило из браузера) содержит дополнительную информацию о запросе, такую как заголовок,
данные, файлы, переменны и т.д. Веб-приложению требуется разобрать и проанализировать эту информацию, чтобы возвратить
правильный ответ. :doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` инкапсулирует информацию запроса, 
позволяя вам получать доступ к ней объектно-ориентированным способом.

.. code-block:: php

    <?php

    // Получение инстации request 
    $request = new \Phalcon\Http\Request();

    // Проверка что даные пришли методом POST
    if ($request->isPost() == true) {
        // Проверка что request создан через Ajax
        if ($request->isAjax() == true) {
            echo "Request создан используя POST и AJAX";
        }
    }

Получение значений
------------------
PHP автоматически заполняет суперглобальные массивы $_GET и $_POST в зависимости от типа запроса. Эти массивы
содержат значения, которые получены из формы или параметры, отправляемые через URL. Переменные в массивы
никогда не обезопасены и могут содержать недопустимые символы или даже вредоносный код, который может привести
к `SQL injection`_ или `Cross Site Scripting (XSS)`_ атакам.

:doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` предоставляет доступ к значениям $_REQUEST,
$_GET и $_POST массивам и обезопасивает или фильтрует через специальный сервис 'filter', (по умолчанию
:doc:`Phalcon\\Filter <filter>`). Следующие примеры показывают одинаковое поведение:

.. code-block:: php

    <?php           

    // Ручная фильтрация
    $filter = new Phalcon\Filter();

    $email  = $filter->sanitize($_POST["user_email"], "email");

    // Ручная фильтрация значения
    $filter = new Phalcon\Filter();
    $email  = $filter->sanitize($request->getPost("user_email"), "email");

    // Автоматическая фильтрация значения
    $email = $request->getPost("user_email", "email");

    // Получение значения по умолчанию, если параметр равен NULL
    $email = $request->getPost("user_email", "email", "some@example.com");

    // Получение значения по умолчанию, если параметр равен NULL без использования фильтрации
    $email = $request->getPost("user_email", null, "some@example.com");


Доступ к Request из Контроллера
-------------------------------
Доступ к Request чаще всего требуется в действиях контроллера. Для доступа к объекту
:doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` из контроллера, необходимо обратиться к публичному свойству $this->request:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // Проверка что данные пришли методом POST POST
            if ($this->request->isPost() == true) {

                // Получение POST данных
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");

            }

        }

    }

Загрузка файлов
---------------
Еще одна частая задача - загрузка файлов :doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` предлогает
объектно-ориентированный подход для решения этой задачи:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function uploadAction()
        {
            // Проверяем что файл загрузился
            if ($this->request->hasFiles() == true) {
                // Выводим имя и размер файла
                foreach ($this->request->getUploadedFiles() as $file) {

                    // Выводим детали
                    echo $file->getName(), " ", $file->getSize(), "\n";


                    // Перемещаем в приложение
                    $file->moveTo('files/');
                }
            }
        }

    }

Каждый объект, возвращаемый Phalcon\\Http\\Request::getUploadedFiles() является инстанцией для
:doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>`. Использование суперглобального массива $_FILES 
предоставляет такое же поведение. :doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>` инкапсулирует
только информацию, относящуюся к каждому загруженному в текущем запросе файлу.

Работа с заголовками
--------------------
Как уже упоминалось выше, заголовки запросов содержат полезную информацию, которая позволит нам оправить правильный ответ
пользователю. Следующие примеры показывают как получить эту информацию:

.. code-block:: php

    <?php

    // Получение заголовка Http-X-Requested-With
    $requestedWith = $response->getHeader("X_REQUESTED_WITH");
    if ($requestedWith == "XMLHttpRequest") {
        echo "Запрос отправлен через Ajax";
    }

    // Или так
    if ($request->isAjax()) {
        echo "The request was made with Ajax";
    }

    // Проверка уровня запроса
    if ($request->isSecureRequest() == true) {
        echo "The request was made using a secure layer";
    }

    // Получение IP сервера, например 192.168.0.100
    $ipAddress = $request->getServerAddress();

    // Получение IP клиента, например 201.245.53.51
    $ipAddress = $request->getClientAddress();

    // Получение строки User Agent (HTTP_USER_AGENT)
    $userAgent = $request->getUserAgent();

    // Получение оптимального типа контента для браузера, например text/xml
    $contentType = $request->getAcceptableContent();

    // Получение лучшей кодировки для браузера, например utf-8
    $charset = $request->getBestCharset();

    // Получение лучшего языка на котрый настроен браузер, например en-us
    $language = $request->getBestLanguage();


.. _SQL injection: http://en.wikipedia.org/wiki/SQL_injection
.. _Cross Site Scripting (XSS): http://en.wikipedia.org/wiki/Cross-site_scripting
