Сохранение данных в сессии
==========================

Компонент сессии предоставляет объектно-ориентированный интерфейс для работы с сессиями.

Причины использования этого компонента, а не обычных сессий:

* Вы можете легко изолировать сессии данных в различных приложениях на одном домене
* Можно перехватить места  установки/получения данных в приложении
* Использование адаптера сессий, оптимального для текущего приложения

Запуск сессий
-------------
Некоторые приложения активно используют в своей работе сессии, используя их в каждом действии. Другие наоборот, используют сессии мало и не часто.
Благодаря использованию контейнера сервисов, мы можем гарантировать, что запуск сессий будет произведён только по необходимости.

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // Сессии запустятся один раз, при первом обращении к объекту
    $di->setShared(
        "session",
        function () {
            $session = new Session();

            $session->start();

            return $session;
        }
    );

Сохранение/получение данных из сессий
-------------------------------------
Из контроллера, представления (view) или другого компонента расширяющего :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` можно
получить доступ к сессиям и работать с ними следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            // Установка значения сессии
            $this->session->set("user-name", "Michael");
        }

        public function welcomeAction()
        {
            // Проверка наличия переменной сессии
            if ($this->session->has("user-name")) {
                // Получение значения
                $name = $this->session->get("user-name");
            }
        }

    }

Удаление/очистка сессий
-----------------------
Таким же способом можно удалить переменную сессии, или целиком очистить сессию:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function removeAction()
        {
            // Удаление переменной сессии
            $this->session->remove("user-name");
        }

        public function logoutAction()
        {
            // Полная очистка сессии
            $this->session->destroy();
        }
    }

Изоляция данных сессии внутри приложения
----------------------------------------
Иногда пользователь может запускать одно и тоже приложение несколько раз, на одном и том же сервере, в одно время. Естественно, используя
переменные сессий нам бы хотелось, чтобы все приложения получали доступ к разным сессиям (хотя в одинаковых приложениях и код одинаковый и названия переменных).
Для решения этой проблемы можно использовать префикс для переменных сессий, разный для разных приложений.

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // Изоляция данных сессий
    $di->set(
        "session",
        function () {
            // Все переменные этого приложения будет иметь префикс "my-app-1"
            $session = new Session(
                [
                    "uniqueId" => "my-app-1",
                ]
            );

            $session->start();

            return $session;
        }
    );

На работе это никак не скажется. Добавлять префикс вручную во время установки или чтения сессий нет необходимости.

Наборы сессий (Session Bags)
----------------------------
Компонент :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` (Session Bags, дословно "Мешки с сессиями")
позволяет работать с сессиями разделяя их по пространствам имён. Работая таким образом, вы можете легко создавать
группы переменных сессии в приложении. Установив значение переменной такого объекта, оно автоматически сохранится в сессии:

.. code-block:: php

    <?php

    use Phalcon\Session\Bag as SessionBag;

    $user = new SessionBag("user");

    $user->setDI($di);

    $user->name = "Kimbra Johnson";
    $user->age  = 22;


Сохранение данных в компонентах
-------------------------------
Контроллеры, компоненты и классы расширяющие :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` могут работать
с :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` напрямую. Компонент в таком случае изолирует данные для каждого класса.
Благодаря этому вы можете сохранять данные между запросами, используя их как обычные переменные.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            // Создаётся постоянная (persistent) переменная "name"
            $this->persistent->name = "Laura";
        }

        public function welcomeAction()
        {
            if (isset($this->persistent->name)) {
                echo "Привет, ", $this->persistent->name;
            }
        }
    }

И в компоненте:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class Security extends Component
    {
        public function auth()
        {
            // Создаётся постоянная (persistent) переменная "name"
            $this->persistent->name = "Laura";
        }

        public function getAuthName()
        {
            return $this->persistent->name;
        }
    }

Данные, добавленные непосредственно в сессию (:code:`$this->session`) доступны во всём приложении, в то время как persistent (:code:`$this->persistent`)
переменные доступны только внутри своего текущего класса.

Реализация собственных адаптеров сессий
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Для создания адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Session\\AdapterInterface <../api/Phalcon_Session_AdapterInterface>`, или использовать наследование от готового с доработкой необходимой логики.

У нас есть некоторые готовые адаптеры для сессий `Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter>`_
