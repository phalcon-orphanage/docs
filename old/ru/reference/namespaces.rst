Работа с пространством имён
===========================

`Пространства имён`_ могут быть использованы для исключения пересечений названий классов; это означает, что если в вашем приложении два контроллера с одинаковыми именами,
пространства имен могут использоваться, чтобы различать их. Пространства имен также полезны для создания бандлов (bundles) или модулей.

Настройка фреймворка
--------------------
Использование пространств имен накладывает некоторые последствия на загрузку соответствующего контроллера. Для настройки работы фреймворка
с пространством имен необходимо выполнить одно или все из следующих задач:

Использовать автозагрузку с учетом пространства имен, например как в :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        [
           "Store\\Admin\\Controllers" => "../bundles/admin/controllers/",
           "Store\\Admin\\Models"      => "../bundles/admin/models/",
        ]
    );

Использовать в роутинге, как отдельный параметр маршрутизации пути:

.. code-block:: php

    <?php

    $router->add(
        "/admin/users/my-profile",
        [
            "namespace"  => "Store\\Admin",
            "controller" => "Users",
            "action"     => "profile",
        ]
    );

Использовать как часть маршрута:

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/admin/users/my-profile",
        [
            "namespace"  => 1,
            "controller" => "Users",
            "action"     => "profile",
        ]
    );

Если в вашем приложении используется единое пространство имён для контроллеров, то вы можете определить пространство имен по умолчанию в диспетчере.
Делая это, вам не потребуется указывать полное имя класса в пути маршрутизатора:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // Регистрация диспетчера
    $di->set(
        "dispatcher",
        function () {
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace(
                "Store\\Admin\\Controllers"
            );

            return $dispatcher;
        }
    );

Контроллеры в пространстве имён
-------------------------------
В следующем примере показано, как использовать контроллер, который использует пространство имен:

.. code-block:: php

    <?php

    namespace Store\Admin\Controllers;

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function indexAction()
        {

        }

        public function profileAction()
        {

        }
    }

Модели в пространстве имён
--------------------------
Примите во внимание при использовании модели в пространстве имен следующее:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {

    }

Если модели имеют связи с другими моделями, то они тоже должны быть включены в пространство имен:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->hasMany(
                "id",
                "Store\\Models\\Parts",
                "robots_id",
                [
                    "alias" => "parts",
                ]
            );
        }
    }

В PHQL вы должны писать запросы с указанием пространства имен:

.. code-block:: php

    <?php

    $phql = "SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p";

.. _Пространства имён: http://php.net/manual/en/language.namespaces.php
