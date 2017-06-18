Урок 6: Vökuró
==============
Vökuró - еще одно приложение, с помощью которого вы сможете узнать больше о Phalcon.
Vökuró - это небольшой сайт, показывающий, как реализовать защитный функционал и
управление пользователями и правами доступа. Вы можете клонировать код приложения с Github_.

Структура проекта
-----------------
После клонирования проекта вы увидите следующую структуру:

.. code-block:: bash

    vokuro/
        app/
            config/
            controllers/
            forms/
            library/
            models/
            views/
        cache/
        public/
            css/
            img/
        schemas/

Его структура весьма схожа с INVO. Открыв приложение в
браузере http://localhost/vokuro, вы увидите что-то подобное:

.. figure:: ../_static/img/vokuro-1.png
   :align: center

Приложение разбито на две части: фронтенд, где посетители могут авторизоваться в сервисе,
и бэкенд, где администраторы могут управлять зарегистрированными пользователями. Фронтенд и бэкенд
объединены в один модуль.

Загрузка классов и зависимостей
-------------------------------
Этот проект использует :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` для загрузки контроллеров, моделей, форм и так далее, и composer_
для загрузки зависимостей проекта. Таким образом, первое, что нужно сделать перед запуском Vökuró -
установить зависимости с помощью composer_. Если он у вас уже установлен, то введите
команду в консоли:

.. code-block:: bash

    cd vokuro
    composer install

Vökuró для подтверждения регистрации пользователей отправляет письма с помощью Swift,
composer.json выглядит следующим образом:

.. code-block:: json

    {
        "require" : {
            "php" : ">=5.5.0",
            "ext-phalcon" : ">=3.0.0",
            "swiftmailer/swiftmailer" : "^5.4",
            "amazonwebservices/aws-sdk-for-php" : "~1.0"
        }
    }

В файле app/config/loader.php настраивается вся автозагрузка. В конце
этого файла можно заметить подключение автозагрузчика composer, это позволяет приложению загружать
любой класс, указанный в зависимостях:

.. code-block:: php

    <?php

    // ...

    // Используем автозагрузчик composer для загрузки внешних зависимостей
    require_once BASE_PATH . "/vendor/autoload.php";

Кроме того, Vökuró, в отличие от INVO, использует пространства имен для контроллеров и моделей,
что является рекомендуемой практикой. Таким образом, автозагрузчик несколько
отличается от тех, что мы видели прежде (app/config/loader.php):

.. code-block:: php

    <?php

    use Phalcon\Loader;

    $loader = new Loader();

    $loader->registerNamespaces(
        [
            "Vokuro\\Models"      => $config->application->modelsDir,
            "Vokuro\\Controllers" => $config->application->controllersDir,
            "Vokuro\\Forms"       => $config->application->formsDir,
            "Vokuro"              => $config->application->libraryDir,
        ]
    );

    $loader->register();

    // ...

Вместо :code:`registerDirectories()` мы используем :code:`registerNamespaces()`. Каждое пространство имен указывает на директорию,
определенную в конфигурационном файле (app/config/config.php). К примеру, пространство имен Vokuro\\Controllers
указывает на app/controllers, таким образом, классам, находящимся в этом пространстве имен,
необходимо указывать его при определении:

.. code-block:: php

    <?php

    namespace Vokuro\Controllers;

    class AboutController extends ControllerBase
    {
        // ...
    }


Регистрация
-----------
Во-первых, давайте посмотрим на то, как пользователи регистрируются в Vökuró. Когда пользователь нажимает на кнопку "Создать аккаунт"
вызывается контроллер SessionController, и выполняется действие "signup":

.. code-block:: php

    <?php

    namespace Vokuro\Controllers;

    use Vokuro\Forms\SignUpForm;

    class RegisterController extends ControllerBase
    {
        public function signupAction()
        {
            $form = new SignUpForm();

            // ...

            $this->view->form = $form;
        }
    }

Это действие просто передает экземпляр формы SignUpForm в представление, которое отображает форму,
что позволяет пользователям ввести свои данные:

.. code-block:: html+jinja

    {{ form("class": "form-search") }}

        <h2>
            Регистрация
        </h2>

        <p>{{ form.label("name") }}</p>
        <p>
            {{ form.render("name") }}
            {{ form.messages("name") }}
        </p>

        <p>{{ form.label("email") }}</p>
        <p>
            {{ form.render("email") }}
            {{ form.messages("email") }}
        </p>

        <p>{{ form.label("password") }}</p>
        <p>
            {{ form.render("password") }}
            {{ form.messages("password") }}
        </p>

        <p>{{ form.label("confirmPassword") }}</p>
        <p>
            {{ form.render("confirmPassword") }}
            {{ form.messages("confirmPassword") }}
        </p>

        <p>
            {{ form.render("terms") }} {{ form.label("terms") }}
            {{ form.messages("terms") }}
        </p>

        <p>{{ form.render("Sign Up") }}</p>

        {{ form.render("csrf", ["value": security.getToken()]) }}
        {{ form.messages("csrf") }}

        <hr>

    {{ endForm() }}

.. _Github: https://github.com/phalcon/vokuro
.. _composer: https://getcomposer.org/
