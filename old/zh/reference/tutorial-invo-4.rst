教程5: 定制INVO(Tutorial 5: Customizing INVO)
============================

要完成 INVO 的详细说明, 我们将会解释如何自定义 INVO 添加 UI 元素和根据控制器的执行从而改变标题.

用户组件(User Components)
---------------
所有的UI元素和应用的视觉效果大部分都是通过 `Bootstrap`_ 实现的. 有些元素, 比如根据应用程序的状态而发生的导航条的变化. 例如, 右上角, 如果用户已经登录到应用程序, 链接"Log in / Sign Up" 变为 "Log out".

应用程序的这部分是用的组件 "Elements" (app/library/Elements.php) 来实现的.

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

这个类继承 :doc:`Phalcon\\Mvc\\User\\Component <../api/Phalcon_Mvc_User_Component>`. 这不是强加的去继承这个类的组件, 但是它会帮助我们更加快速的访问呢应用的服务. 现在, 我们将在服务容器中注册沃恩的第一个用户组件:

.. code-block:: php

    <?php

    // 注册用户组件
    $di->set(
        "elements",
        function () {
            return new Elements();
        }
    );

作为控制器, 在视图中的插件或者组件, 这个组件还可以已在容器中注册的服务和通过访问一个相同名字的属性作为一个预先注册的服务:

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

重要的部分是:

.. code-block:: html+jinja

    {{ elements.getMenu() }}

动态改变标题(Changing the Title Dynamically)
------------------------------
当你在不同的选项中浏览的时候就会看到标题在动态的改变. 在每个控制器初始化的时候实现:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        public function initialize()
        {
            // 设置文档标题
            $this->tag->setTitle(
                "Manage your product types"
            );

            parent::initialize();
        }

        // ...
    }

注意, 这个方法 :code:`parent::initialize()` 也被调用, 它添加更多的数据到标题:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ControllerBase extends Controller
    {
        protected function initialize()
        {
            // 在标题的前面加上应用名称
            $this->tag->prependTitle(
                "INVO | "
            );
        }

        // ...
    }

最后, 标题在 main 视图 (app/views/index.volt) 输出了 :

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle(); ?>
        </head>

        <!-- ... -->
    </html>

.. _Bootstrap: http://getbootstrap.com/
