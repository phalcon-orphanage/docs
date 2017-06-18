Tutorial 5: Customizing INVO
============================

To finish the detailed explanation of INVO we are going to explain how to customize INVO adding UI elements
and changing the title according to the controller executed.

ユーザーコンポーネント
----------------------
全てのUI要素とスタイルは、 `Bootstrap`_ によって実現されています。ナビゲーションバーなどの要素は、アプリケーションの状態によって変わります。たとえば、右上のリンク "Log in / Sign Up" は、ユーザーがログインしている場合には "Log out" に変わります。

アプリケーションのこの部分は、"Elements" コンポーネント (app/library/Elements.php) で実装されています。

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

このクラスは :doc:`Phalcon\\Mvc\\User\\Component <../api/Phalcon_Mvc_User_Component>` を継承しています。このクラスのコンポーネントを継承することは必須ではありませんが、アプリケーションのサービスに素早くアクセスする助けになります。それでは、このクラスをサービスコンテナに登録します:

.. code-block:: php

    <?php

    // Register a user component
    $di->set(
        "elements",
        function () {
            return new Elements();
        }
    );

As controllers, plugins or components within a view, this component also has access to the services registered
in the container and by just accessing an attribute with the same name as a previously registered service:

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

The important part is:

.. code-block:: html+jinja

    {{ elements.getMenu() }}

タイトルの動的な変更
--------------------
When you browse between one option and another will see that the title changes dynamically indicating where
we are currently working. This is achieved in each controller initializer:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        public function initialize()
        {
            // Set the document title
            $this->tag->setTitle(
                "Manage your product types"
            );

            parent::initialize();
        }

        // ...
    }

Note, that the method :code:`parent::initialize()` is also called, it adds more data to the title:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ControllerBase extends Controller
    {
        protected function initialize()
        {
            // Prepend the application name to the title
            $this->tag->prependTitle(
                "INVO | "
            );
        }

        // ...
    }

Finally, the title is printed in the main view (app/views/index.volt):

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle(); ?>
        </head>

        <!-- ... -->
    </html>

.. _Bootstrap: http://getbootstrap.com/
