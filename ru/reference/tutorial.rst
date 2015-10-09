Урок 1: Рассмотрим на примере
=============================
В этом примере рассмотрим создание приложения с простой формой регистрации "с нуля".
Также рассмотрим основные аспекты поведения фреймворка. Если вам интересна автоматическая генерация кода, посмотрите :doc:`developer tools <tools>`.

Проверка установки
------------------
Будем считать, что у вас уже установлено расширение Phalcon. Проверьте, есть ли в результатах phpinfo() секция "Phalcon" или выполните следующий код:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

В результате вы должны увидеть Phalcon в списке:

.. code-block:: php

    Array
    (
        [0] => Core
        [1] => libxml
        [2] => filter
        [3] => SPL
        [4] => standard
        [5] => phalcon
        [6] => pdo_mysql
    )

Создание проекта
----------------
Лучше всего следовать данному руководству шаг за шагом. Полный код можно посмотреть `здесь <https://github.com/phalcon/tutorial>`_.

Структура каталогов
^^^^^^^^^^^^^^^^^^^
Phalcon не обязывает использовать определенную структуру каталогов. В виду слабой связанности фреймворка, вы можете использовать любую удобную структуру.

В качестве отправной точки для данного урока мы предлагаем следующую структуру:

.. code-block:: php

    tutorial/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/

Обратите внимание на то, что вам не нужны директории с библиотеками, относящимися к фреймворку. Он полностью находится в памяти и все время готов к использованию.

"Красивые" ссылки (URLs)
^^^^^^^^^^^^^^^^^^^^^^^^
В этом примере будем использовать красивые УРЛ (ЧПУ). ЧПУ хороши как для SEO, так и для восприятия пользователя. Phalcon поддерживает rewrite-модули,
представленные самыми распространенными веб-серверами. Вы не обязаны использовать ЧПУ в вашем приложении, вы можете с легкостью обойтись и без них.

В этом примере будем использовать rewrite модуль для Apache. Создадим несколько правил в файле /.htaccess:

.. code-block:: apacheconf

    #/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

Все запросы будут перенаправлены в каталог public/, делая его тем самым корневым каталогом хоста. Данный шаг обеспечивает недоступность внутренних файлов проекта для внешнего пользователя, избегая таким образом угроз безопасности подобного характера.

Следующий набор правил проверяет существует ли запрашиваемый файл, и в случае его отсутствия перенаправляет запрос index-файлу:

.. code-block:: apacheconf

    #/public/.htaccess
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Bootstrap
^^^^^^^^^
Это первый файл, который вам необходимо создать. Это основной файл приложения, предназначенный для управления всеми его аспектами. Здесь
вы можете реализовать как инициализацию компонентов приложения, так и управление поведением приложения.

Файл public/index.php имеет следующее содержимое:

.. code-block:: php

    <?php

    try {

        // Register an autoloader
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers/',
            '../app/models/'
        ))->register();

        // Create a DI
        $di = new Phalcon\DI\FactoryDefault();

        // Setting up the view component
        $di->set('view', function () {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../app/views/');
            return $view;
        });

        // Handle the request
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch (\Phalcon\Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }

Автозагрузка
^^^^^^^^^^^^
Первое, что происходит в bootstrap-файле - это регистрация автозагрузчика. Он будет использоваться для загрузки классов проекта, таких как контроллеры и модели. Например, мы можем
зарегистрировать одну или более директорий для контроллеров, увеличив гибкость приложения. В данном примере используется компонент Phalcon\\Loader.

Он позволяет использовать разные стратегии загрузки классов, но в данном примере мы решили расположить классы в определенных директориях:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/'
        )
    )->register();

Управление зависимостями
^^^^^^^^^^^^^^^^^^^^^^^^
Важная концепция, которую стоит понять при использовании Phalcon - это :doc:`dependency injection <di>`. Это может показаться сложным,
но на самом деле это очень простой и практичный шаблон проектирования.

DI представляет из себя глобальный контейнер для сервисов, необходимых нашему приложению. Каждый раз, когда фреймворку необходим какой-то компонент, он будет обращаться
за ним к контейнеру, используя определенное имя компонента.
Так как Phalcon является слабосвязанным фреймворком, Phalcon\\DI выступает в роли клея, помогающего разным компонентам прозрачно взаимодействовать друг с другом.

.. code-block:: php

    <?php

    // Создание DI
    $di = new Phalcon\DI\FactoryDefault();

:doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon\_DI_FactoryDefault>` является вариантом Phalcon\\DI. Он берет на себя функции регистрации большинства компонентов из состава Phalcon, поэтому нам не придется регистрировать их вручную один за другим.
В будущем нет никакой проблемы для замены этого сервиса своим.

На следующем шаге мы регистрируем сервис 'view', который указывает на папку с файлами 'view' (представлениями). Т.к. данные файлы не относятся к классам, они не могут быть подгружены автозагрузчиком.

Существует несколько путей для регистрации сервисов, но в нашем примере мы используем анонимную функцию:

.. code-block:: php

    <?php

    // Setting up the view component
    $di->set('view', function () {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

На последнем этапе мы используем :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`.
Данный компонент служит для инициализации окружения входящих запросов, их перенаправления и обслуживания относящихся к ним действий. После отработки всех доступных действий, компонент возвращает полученные ответы.

.. code-block:: php

    <?php

    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

Как можно увидеть, файл инициализации очень короткий, нам нет необходимости подключать какие-либо дополнительные файлы. Таким образом, мы настроили гибкую структуру MVC-приложения менее чем за 30 строк кода.

Создание контроллера
^^^^^^^^^^^^^^^^^^^^
По умолчанию Phalcon будет искать контроллер с именем "Index". Как и во многих других фреймворках, он является исходной точкой, когда ни один другой контроллер или действие не были запрошены.
Наш контроллер по умолчанию (app/controllers/IndexController.php) выглядит так:

.. code-block:: php

    <?php

    class IndexController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            echo "<h1>Привет!</h1>";
        }

    }

Классы контроллеров должны заканчиваться на "Controller", чтобы автозагрузчик смог загрузить их, а их действия должны заканчиваться суффиксом "Action". Теперь можно открыть браузер и увидеть результат:

.. figure:: ../_static/img/tutorial-1.png
    :align: center

Ура, Phalcon взлетел!

Отправка результатов в представление
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Отображение вывода напрямую из контроллера иногда бывает необходимым решением (например, когда нужно отправить JSON), но нежелательно, и сторонники шаблона MVC это подтвердят.
Данные должны передаваться представлению (view), ответственному за отображение данных.
Phalcon ищет файл представления с именем, совпадающим с именем действия внутри папки, носящей имя последнего запущенного контроллера.
В нашем случае это будет выглядеть так (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Привет!</h1>";

В нашем контроллере (app/controllers/IndexController.php) сейчас существует пустое действие:

.. code-block:: php

    <?php

    class IndexController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }

Вывод браузера останется прежним. Когда действие завершит свою работу, будет автоматически создан статический компонент :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`. Узнать больше о представлениях можно :doc:`здесь <views>`.

Проектирование формы регистрации
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Давайте теперь изменим файл представления index.phtml, добавив ссылку на новый контроллер "signup". Идея проста - позволить пользователям регистрироваться в нашем приложении.

.. code-block:: php

    <?php

    echo "<h1>Привет!</h1>";

    echo Phalcon\Tag::linkTo("signup", "Регистрируйся!");

Сгенерированный код HTML будет выводить тэг "<a>", указывающий на наш новый контроллер:

.. code-block:: html

    <h1>Привет!</h1> <a href="/test/signup">Регистрируйся!</a>

Для генерации тэга мы воспользовались встроенный классом :doc:`\Phalcon\\Tag <../api/Phalcon_Tag>`. Это служебный класс, позволяющий конструировать HTML-разметку в Phalcon-подобном стиле. Более подробно можно :doc:`узнать здесь<tags>`.

.. figure:: ../_static/img/tutorial-2.png
    :align: center

Контроллер Signup сейчас очень похож на предыдущий контроллер и выглядит так (app/controllers/SignupController.php):

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }

Пустое действие index говорит нам о том, что будет использоваться одноименный файл представления с нашей формой для регистрации (app/views/signup/index.phtml):

.. code-block:: html+php

    <?php use Phalcon\Tag; ?>

    <h2>Sign using this form</h2>

    <?php echo Tag::form("signup/register"); ?>

     <p>
        <label for="name">Имя</label>
        <?php echo Tag::textField("name") ?>
     </p>

     <p>
        <label for="name">E-Mail</label>
        <?php echo Tag::textField("email") ?>
     </p>

     <p>
        <?php echo Tag::submitButton("Регистрация") ?>
     </p>

    </form>

В браузере это будет выглядеть так:

.. figure:: ../_static/img/tutorial-3.png
    :align: center

Класс :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` также содержит полезные методы для работы с формами.

Метод Phalcon\\Tag::form принимает единственный аргумент, например, относительный идентификатор контроллер/действие приложения.

При нажатии на кнопку "Регистрация" мы увидим исключение, вызванное фреймворком. Оно говорит нам о том, что у нашего контроллера "signup" отсутствует действие "register":

    PhalconException: Action "register" was not found on controller "signup"

Реализация этого метода прекратит генерацию исключения:

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

        }

    }

Снова жмем на кнопку "Регистрация" и видим пустую страницу. Поля name и email, введенные пользователем, должны сохраниться в базе данных.
Следуя традиции MVC, все взаимодействие с БД должно вестись через модели, следуя традициям ООП-стиля.

Создание модели
^^^^^^^^^^^^^^^
Phalcon содержит первую ORM для PHP, полностью написанную на языке C. Вместо усложнения процесса разработки, он упрощает его!

Мы должны связать таблицу в нашей базе данных перед созданием нашей первой модели. Простейшая таблица для регистрации пользователей приведена ниже:

.. code-block:: sql

    CREATE TABLE `users` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(70) NOT NULL,
      `email` varchar(70) NOT NULL,
      PRIMARY KEY (`id`)
    );

Файлы моделей должны находиться в папке app/models (app/models/Users.php). Модель, представляющая таблицу "users", выглядит следующим образом:

.. code-block:: php

    <?php

    class Users extends \Phalcon\Mvc\Model
    {

    }

Настройка соединения с базой данных
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Для использования базы данных и получения к ней доступа через наши модели нам необходимо указать настройки в файле инициализации нашего приложения (bootstrap).
Соединение с базой данных - это всего лишь еще один сервис в нашем сервис-локаторе:

.. code-block:: php

    <?php

    try {

        // Регистрация автозагрузчика
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            '../app/controllers/',
            '../app/models/'
        ))->register();

        // Создание DI
        $di = new Phalcon\DI\FactoryDefault();

        // Настраиваем сервис для работы с БД
        $di->set('db', function () {
            return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "test_db"
            ));
        });

        // Настраиваем компонент View
        $di->set('view', function () {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../app/views/');
            return $view;
        });

        // Обработка запроса
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch (Exception $e) {
         echo "PhalconException: ", $e->getMessage();
    }

При правильных настройках подключения наши модели будут готовы к работе и взаимодействию с остальными частями приложения.

Сохранение данных при работе с моделями
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Следующим шагом будет обработка данных нашей формы регистрации и сохранение их в таблице базы данных.

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

            $user = new Users();

            // Сохраняем и проверяем на наличие ошибок
            $success = $user->save($this->request->getPost(), array('name', 'email'));

            if ($success) {
                echo "Спасибо за регистрацию!";
            } else {
                echo "К сожалению, возникли следующие проблемы: ";
                foreach ($user->getMessages() as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }

            $this->view->disable();
        }

    }


В действии 'register' мы создаем экземпляр модели Users, отвечающий за записи пользователей. Публичные свойства класса указывают на их одноименные названия полей в таблице базы данных.
Установка необходимых значений нашей модели и вызов метода save() приводит к сохранению этих данных в базе данных.
Метод save() возвращает булево значение, указывающее, успешно ли были сохранены данные в таблице или нет (true и false, соответственно).

ORM автоматически экранирует ввод для предотвращения SQL-инъекций, так что мы можем передавать массив $_POST напрямую методу save().

Для полей, у которых установлен параметр not null (обязательные), вызывается дополнительная валидация. Если мы ничего не введем в форме регистрации, то получим что-то вроде этого:

.. figure:: ../_static/img/tutorial-4.png
    :align: center

Заключение
----------
На этом очень простом руководстве можно увидеть, как легко начать создавать приложения с помощью Phalcon.
То, что Phalcon является расширением, никак не влияет на сложность разработки и доступные возможности.
Продолжайте читать данное руководство для изучения новых возможностей, которые предоставляет Phalcon!

Примеры приложений
------------------
Можно ознакомиться с более развернутыми примерами приложений, написанных с помощью Phalcon:

* `INVO application`_: Приложение для создания счетов. Позволяет редактировать продукты, компании, типы продуктов и др.
* `PHP Alternative website`_: Мультиязычное приложение с продвинутым роутингом.
* `Album O'Rama`_: Витрина музыкальных альбомов. Обработка больших объемов данных с помощью диалекта :doc:`PHQL <phql>` и шаблонизатора :doc:`Volt <volt>`
* `Phosphorum`_: Простой форум

.. _INVO application: http://blog.phalconphp.com/post/20928554661/invo-a-sample-application
.. _PHP Alternative website: http://blog.phalconphp.com/post/24622423072/sample-application-php-alternative-site
.. _Album O'Rama: http://blog.phalconphp.com/post/37515965262/sample-application-album-orama
.. _Phosphorum: http://blog.phalconphp.com/post/41461000213/phosphorum-the-phalcons-forum
