Работа с пространством имён
===========================
`Пространства имён`_ могут быть использованы для исключения пересечений названий классов; это означает, что если в вашем приложении два контроллера с одинаковыми именами,
пространства имен могут использоваться, чтобы различать их. Пространства имен также полезны для создания бандлов (bundles) или модулей.

Настройка фреймворка
--------------------
Использование пространств имен накладывает некоторые последствия на загрузку соответствующего контроллера. Для настройки работы фреймворка
с пространством имен необходимо выполнить одно или все из следующих задач:

Использовать автозагрузку с учетом пространства имен, например как в Phalcon\\Loader:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        array(
           'Store\Admin\Controllers'    => "../bundles/admin/controllers/",
           'Store\Admin\Models'    => "../bundles/admin/models/",
        )
    );

Использовать в роутинге, как отдельный параметр маршрутизации пути:

.. code-block:: php

    <?php

    $router->add(
        '/admin/users/my-profile',
        array(
            'namespace'  => 'Store\Admin',
            'controller' => 'Users',
            'action'     => 'profile',
        )
    );

Использовать как часть маршрута:

.. code-block:: php

    <?php

    $router->add(
        '/:namespace/admin/users/my-profile',
        array(
            'namespace'  => 1,
            'controller' => 'Users',
            'action'     => 'profile',
        )
    );

Если в вашем приложении используется единое пространство имён для контроллеров, то вы можете определить пространство имен по умолчанию в диспетчере.
Делая это, вам не потребуется указывать полное имя класса в пути маршрутизатора:

.. code-block:: php

    <?php

    // Регистрация диспетчера
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Store\Admin\Controllers');
        return $dispatcher;
    });

Контроллеры в пространстве имён
-------------------------------
В следующем примере показано, как использовать контроллер, который использует пространство имен:

.. code-block:: php

    <?php

    namespace Store\Admin\Controllers;

    class UsersController extends \Phalcon\Mvc\Controller
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

    class Robots extends Phalcon\Mvc\Model
    {

    }

Если модели имеют связи с другими моделями, то они тоже должны быть включены в пространство имен:

.. code-block:: php

    <?php

    namespace Store\Models;

    class Robots extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasMany('id', 'Store\Models\Parts', 'robots_id', array(
                'alias' => 'parts'
            ));
        }
    }

В PHQL вы должны писать запросы с указанием пространства имен:

.. code-block:: php

    <?php

    $phql = 'SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p';

.. _Пространства имён: http://php.net/manual/en/language.namespaces.php
