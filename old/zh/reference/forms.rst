表单（Forms）
=============

Phalcon中提供了 :code:`Phalcon\Forms` 组件以方便开发者创建和维护应用中的表单。

下面的例子中展示了基本的使用方法：

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    $form = new Form();

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "telephone"
        )
    );

    $form->add(
        new Select(
            "telephoneType",
            [
                "H" => "Home",
                "C" => "Cell",
            ]
        )
    );

可在表单定义时穿插使用表单元素的字义：

.. code-block:: html+php

    <h1>
        Contacts
    </h1>

    <form method="post">

        <p>
            <label>
                Name
            </label>

            <?php echo $form->render("name"); ?>
        </p>

        <p>
            <label>
                Telephone
            </label>

            <?php echo $form->render("telephone"); ?>
        </p>

        <p>
            <label>
                Type
            </label>

            <?php echo $form->render("telephoneType"); ?>
        </p>



        <p>
            <input type="submit" value="Save" />
        </p>

    </form>

开发者可根据需要渲染HTML组件。 当使用:code:`render()`函数时， phalcon内部会使用 :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 生成相应的html项，
第二个参数中可以对一些属性进行设置。

.. code-block:: html+php

    <p>
        <label>
            Name
        </label>

        <?php echo $form->render("name", ["maxlength" => 30, "placeholder" => "Type your name"]); ?>
    </p>

HTML的属性也可以在创建时指定：

.. code-block:: php

    <?php

    $form->add(
        new Text(
            "name",
            [
                "maxlength"   => 30,
                "placeholder" => "Type your name",
            ]
        )
    );

初始化表单（Initializing forms）
--------------------------------
从上面的例子我们可以看到表单项也可以在form对象初始化后进行添加。 当然开发者也可以对原有的Form类进行扩展：

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    class ContactForm extends Form
    {
        public function initialize()
        {
            $this->add(
                new Text(
                    "name"
                )
            );

            $this->add(
                new Text(
                    "telephone"
                )
            );

            $this->add(
                new Select(
                    "telephoneType",
                    TelephoneTypes::find(),
                    [
                        "using" => [
                            "id",
                            "name",
                        ]
                    ]
                )
            );
        }
    }

由于 :doc:`Phalcon\\Forms\\Form <../api/Phalcon_Forms_Form>` 实现了 :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` 接口，
所以开发者可以根据自己的需要访问应用中的服务。

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class ContactForm extends Form
    {
        /**
         * This method returns the default value for field 'csrf'
         */
        public function getCsrf()
        {
            return $this->security->getToken();
        }

        public function initialize()
        {
            // Set the same form as entity
            $this->setEntity($this);

            // Add a text element to capture the 'email'
            $this->add(
                new Text(
                    "email"
                )
            );

            // Add a text element to put a hidden CSRF
            $this->add(
                new Hidden(
                    "csrf"
                )
            );
        }
    }

相关的实体在初始化时添加到表单， 自定义的选项通过构造器传送：

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class UsersForm extends Form
    {
        /**
         * Forms initializer
         *
         * @param Users $user
         * @param array $options
         */
        public function initialize(Users $user, array $options)
        {
            if ($options["edit"]) {
                $this->add(
                    new Hidden(
                        "id"
                    )
                );
            } else {
                $this->add(
                    new Text(
                        "id"
                    )
                );
            }

            $this->add(
                new Text(
                    "name"
                )
            );
        }
    }

在表单实例中必须要这样使用：

.. code-block:: php

    <?php

    $form = new UsersForm(
        new Users(),
        [
            "edit" => true,
        ]
    );

验证（Validation）
------------------
Phalcon表单组件可以和 :doc:`validation <validation>` 集成，以提供验证。 开发者要单独为每个html元素提供内置或自定义的验证器。

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;
    use Phalcon\Validation\Validator\PresenceOf;
    use Phalcon\Validation\Validator\StringLength;

    $name = new Text(
        "name"
    );

    $name->addValidator(
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $name->addValidator(
        new StringLength(
            [
                "min"            => 10,
                "messageMinimum" => "The name is too short",
            ]
        )
    );

    $form->add($name);

然后， 开发者可以根据用户的输入进行验证：

.. code-block:: php

    <?php

    if (!$form->isValid($_POST)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

验证器执行的顺序和注册的顺序一致。

默认情况下，所有的元素产生的消息是放在一起的， 所以开发者可以使用简单的foreach来遍历消息， 开发者可以按照自己的意愿组织输出：

.. code-block:: php

    <?php

    foreach ($form->getMessages(false) as $attribute => $messages) {
        echo "Messages generated by ", $attribute, ":", "\n";

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

或获取指定元素的消息：

.. code-block:: php

    <?php

    $messages = $form->getMessagesFor("name");

    foreach ($messages as $message) {
        echo $message, "<br>";
    }

过滤（Filtering）
-----------------
表单元素可以在进行验证前先进行过滤， 开发者可以为每个元素设置过滤器：

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;

    $name = new Text(
        "name"
    );

    // Set multiple filters
    $name->setFilters(
        [
            "string",
            "trim",
        ]
    );

    $form->add($name);



    $email = new Text(
        "email"
    );

    // Set one filter
    $email->setFilters(
        "email"
    );

    $form->add($email);

.. highlights::

    Learn more about filtering in Phalcon by reading the :doc:`Filter documentation <filter>`.

表单与实体（Forms + Entities）
------------------------------
我们可以把 model/collection/plain 设置到表单对象中， 这样 phalcon 会自动的设置表单元素的值：

.. code-block:: php

    <?php

    $robot = Robots::findFirst();

    $form = new Form($robot);

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "year"
        )
    );

在表单渲染时如果表单项未设置默认值， phalcon会使用对象实体值作为默认值：

.. code-block:: html+php

    <?php echo $form->render("name"); ?>

开发者可以使用下面的方式验证表单及利用用户的输入来设置值：

.. code-block:: php

    <?php

    $form->bind($_POST, $robot);

    // Check if the form is valid
    if ($form->isValid()) {
        // Save the entity
        $robot->save();
    }

也可以使用一个简单的类做为对象实体进行参数传递：

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone = "Europe/Amsterdam";

        public $receiveEmails = "No";
    }

使用此类做为对象实体，这样可以使用此类中的值作为表单的默认值：

.. code-block:: php

    <?php

    $form = new Form(
        new Preferences()
    );

    $form->add(
        new Select(
            "timezone",
            [
                "America/New_York"  => "New York",
                "Europe/Amsterdam"  => "Amsterdam",
                "America/Sao_Paulo" => "Sao Paulo",
                "Asia/Tokyo"        => "Tokyo",
            ]
        )
    );

    $form->add(
        new Select(
            "receiveEmails",
            [
                "Yes" => "Yes, please!",
                "No"  => "No, thanks",
            ]
        )
    );

实体中也可以使用getters, 这样可以给开发者更多的自由， 当然也会使开发稍麻烦一些，不过这是值得的：

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone;

        public $receiveEmails;



        public function getTimezone()
        {
            return "Europe/Amsterdam";
        }

        public function getReceiveEmails()
        {
            return "No";
        }
    }

表单控件（Form Elements）
-------------------------
Phalcon提供了一些内置的html元素类， 所有这些元素类仅位于 :doc:`Phalcon\\Forms\\Element <../api/Phalcon_Forms_Element>` 命名空间下：

+----------------------------------------------------------------------------------+----------------------------------+
| 名称                                                                             | 描述                             |
+==================================================================================+==================================+
| :doc:`Phalcon\\Forms\\Element\\Text <../api/Phalcon_Forms_Element_Text>`         | 产生 INPUT[type=text] 项         |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Password <../api/Phalcon_Forms_Element_Password>` | 产生 INPUT[type=password] 项     |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Select <../api/Phalcon_Forms_Element_Select>`     | 产生 SELECT tag (combo lists) 项 |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Check <../api/Phalcon_Forms_Element_Check>`       | 产生 INPUT[type=check] 项        |
+----------------------------------------------------------+-----------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\TextArea <../api/Phalcon_Forms_Element_TextArea>` | 产生 TEXTAREA 项                 |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Hidden <../api/Phalcon_Forms_Element_Hidden>`     | 产生 INPUT[type=hidden] 项       |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\File <../api/Phalcon_Forms_Element_File>`         | 产生 INPUT[type=file] 项         |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Date <../api/Phalcon_Forms_Element_Date>`         | 产生 INPUT[type=date] 项         |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Numeric <../api/Phalcon_Forms_Element_Numeric>`   | 产生 INPUT[type=number] 项       |
+----------------------------------------------------------------------------------+----------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Submit <../api/Phalcon_Forms_Element_Submit>`     | 产生 INPUT[type=submit] 项       |
+----------------------------------------------------------------------------------+----------------------------------+

事件回调（Event Callbacks）
---------------------------
当扩展表单时， 我们可以在表单类中实现验证前操作及验证后操作：

.. code-block:: html+php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function beforeValidation()
        {

        }
    }

渲染表单（Rendering Forms）
---------------------------
开发者对表单的渲染操作有完全的控制， 下面的的例子展示了如何使用标准方法渲染html元素：

.. code-block:: html+php

    <?php

    <form method="post">
        <?php

            // Traverse the form
            foreach ($form as $element) {
                // Get any generated messages for the current element
                $messages = $form->getMessagesFor(
                    $element->getName()
                );

                if (count($messages)) {
                    // Print each element
                    echo '<div class="messages">';

                    foreach ($messages as $message) {
                        echo $message;
                    }

                    echo "</div>";
                }

                echo "<p>";

                echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

                echo $element;

                echo "</p>";
            }

        ?>

        <input type="submit" value="Send" />
    </form>

或是在登录表单中重用表单类：

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function initialize()
        {
            // ...
        }

        public function renderDecorated($name)
        {
            $element  = $this->get($name);

            // Get any generated messages for the current element
            $messages = $this->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Print each element
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $this->flash->error($message);
                }

                echo "</div>";
            }

            echo "<p>";

            echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

            echo $element;

            echo "</p>";
        }
    }

视图中：

.. code-block:: php

    <?php

    echo $element->renderDecorated("name");

    echo $element->renderDecorated("telephone");

创建表单控件（Creating Form Elements）
--------------------------------------
除了可以使用phalcon提供的html元素以外， 开发者还可以使用自定义的html元素：

.. code-block:: php

    <?php

    use Phalcon\Forms\Element;

    class MyElement extends Element
    {
        public function render($attributes = null)
        {
            $html = // ... Produce some HTML

            return $html;
        }
    }

表单管理（Forms Manager）
-------------------------
此组件为开发者提供了一个表单管理器， 可以用来注册表单，此组件可以使用服务容器来访问：

.. code-block:: php

    <?php

    use Phalcon\Forms\Manager as FormsManager;

    $di["forms"] = function () {
        return new FormsManager();
    };

表单被添加到表单管理器， 然后设置了唯一的名字：

.. code-block:: php

    <?php

    $this->forms->set(
        "login",
        new LoginForm()
    );

使用唯一名， 我们可以在应用的任何地方访问到表单：

.. code-block:: php

    <?php

    $loginForm = $this->forms->get("login");

    echo $loginForm->render();

外部资源（External Resources)
-----------------------------
* `Vökuró <http://vokuro.phalconphp.com>`_ 是一个使用表单构建器来创建和维护表单的示例 [`Github <https://github.com/phalcon/vokuro>`_]
