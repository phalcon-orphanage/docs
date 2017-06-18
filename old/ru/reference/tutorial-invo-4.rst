Урок 5: Настройка INVO
======================

В завершение детального погружения в INVO мы собираемся рассказать о том, как настроить INVO, добавив элементы UI,
и, изменив заголовок в соответствии с выполненным контроллером.

Пользовательские компоненты
---------------------------
Все элементы UI и визуальные стили приложения в основном задаются с помощью `Bootstrap`_.
Некоторые элементы, такие как панель навигации, меняются соответственно состоянию приложения. Например, в
верхнем правом углу ссылка "Войти / Зарегистрироваться" при авторизации пользователя меняется на "Выйти".

Эта часть приложения реализуется в компоненте "Elements" (app/library/Elements.php).

.. code-block:: php

    <?php

    use Phalcon\Mvc\User\Component;

    class Elements extends Component
    {
        public function getMenu()
        {
            // ...
        }

        public function getTabs()
        {
            // ...
        }
    }

Этот класс расширяет :doc:`Phalcon\\Mvc\\User\\Component <../api/Phalcon_Mvc_User_Component>`. Это, в общем, необязательно,
но помогает быстро получать доступ к сервисам приложения. Теперь мы зарегистрируем
этот класс в контейнере сервисов:

.. code-block:: php

    <?php

    // Регистрируем пользовательский компонент
    $di->set(
        "elements",
        function () {
            return new Elements();
        }
    );

Как и контроллеры, плагины или компоненты в представлениях, этот компонент также имеет доступ к сервисам, зарегистрированным
в контейнере, и сам будет доступен как атрибут с тем именем, с каким мы его зарегистрировали:

.. code-block:: html+jinja

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a class="brand" href="#">INVO</a>

                {{ elements.getMenu() }}
            </div>
        </div>
    </div>

    <div class="container">
        {{ content() }}

        <hr>

        <footer>
            <p>&copy; Company 2015</p>
        </footer>
    </div>

Обратите внимание на важную часть:

.. code-block:: html+jinja

    {{ elements.getMenu() }}

Динамическое изменениие заголовка
---------------------------------
По мере того, как вы просматриваете страницы одну за другой, можете заметить, что их заголовоки динамически меняются и показывают,
где вы сейчас находитесь. Это достигается с помощью инициализатора контроллера:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        public function initialize()
        {
            // Устанавливаем заголовок документа
            $this->tag->setTitle(
                "Управление типами ваших продуктов"
            );

            parent::initialize();
        }

        // ...
    }

Заметьте, что также вызывается метод :code:`parent::initialize()`, он может добавить в заголовок дополнительные данные:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ControllerBase extends Controller
    {
        protected function initialize()
        {
            // Дописываем в начало заголовка название приложения
            $this->tag->prependTitle(
                "INVO | "
            );
        }

        // ...
    }

Вот так этот заголовок выводится в главном представлении (app/views/index.volt):

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle(); ?>
        </head>

        <!-- ... -->
    </html>

.. _Bootstrap: http://getbootstrap.com/
