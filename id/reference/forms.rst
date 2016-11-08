Forms
=====

:code:`Phalcon\Forms` is a component that aids you in the creation and maintenance of forms in web applications.

The following example shows its basic usage:

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

Forms can be rendered based on the form definition:

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

Each element in the form can be rendered as required by the developer. Internally,
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` is used to produce the correct HTML for each element and you can pass additional HTML attributes as the second parameter of :code:`render()`:

.. code-block:: html+php

    <p>
        <label>
            Name
        </label>

        <?php echo $form->render("name", ["maxlength" => 30, "placeholder" => "Type your name"]); ?>
    </p>

HTML attributes also can be set in the element's definition:

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

Initializing forms
------------------
As seen before, forms can be initialized outside the form class by adding elements to it. You can re-use code or organize your form
classes implementing the form in a separated file:

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

:doc:`Phalcon\\Forms\\Form <../api/Phalcon_Forms_Form>` extends :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`
so you have access to the application services if needed:

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

The associated entity added to the form in the initialization and custom user options are passed to the form constructor:

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

In the form's instantiation you must use:

.. code-block:: php

    <?php

    $form = new UsersForm(
        new Users(),
        [
            "edit" => true,
        ]
    );

Validation
----------
Phalcon forms are integrated with the :doc:`validation <validation>` component to offer instant validation. Built-in or
custom validators could be set to each element:

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

Then you can validate the form according to the input entered by the user:

.. code-block:: php

    <?php

    if (!$form->isValid($_POST)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Validators are executed in the same order as they were registered.

By default messages generated by all the elements in the form are joined so they can be traversed using a single foreach,
you can change this behavior to get the messages separated by the field:

.. code-block:: php

    <?php

    foreach ($form->getMessages(false) as $attribute => $messages) {
        echo "Messages generated by ", $attribute, ":", "\n";

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Or get specific messages for an element:

.. code-block:: php

    <?php

    $messages = $form->getMessagesFor("name");

    foreach ($messages as $message) {
        echo $message, "<br>";
    }

Filtering
---------
A form is also able to filter data before it is validated. You can set filters in each element:

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

Forms + Entities
----------------
An entity such as a model/collection/plain instance or just a plain PHP class can be linked to the form in order to set default values
in the form's elements or assign the values from the form to the entity easily:

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

Once the form is rendered if there is no default values assigned to the elements it will use the ones provided by the entity:

.. code-block:: html+php

    <?php echo $form->render("name"); ?>

You can validate the form and assign the values from the user input in the following way:

.. code-block:: php

    <?php

    $form->bind($_POST, $robot);

    // Check if the form is valid
    if ($form->isValid()) {
        // Save the entity
        $robot->save();
    }

Setting up a plain class as entity also is possible:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone = "Europe/Amsterdam";

        public $receiveEmails = "No";
    }

Using this class as entity, allows the form to take the default values from it:

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

Entities can implement getters, which have a higher precedence than public properties. These methods
give you more freedom to produce values:

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

Form Elements
-------------
Phalcon provides a set of built-in elements to use in your forms, all these elements are located in the :doc:`Phalcon\\Forms\\Element <../api/Phalcon_Forms_Element>` namespace:

+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| Name                                                                             | Description                                                 |
+==================================================================================+=============================================================+
| :doc:`Phalcon\\Forms\\Element\\Text <../api/Phalcon_Forms_Element_Text>`         | Generate INPUT[type=text] elements                          |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Password <../api/Phalcon_Forms_Element_Password>` | Generate INPUT[type=password] elements                      |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Select <../api/Phalcon_Forms_Element_Select>`     | Generate SELECT tag (combo lists) elements based on choices |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Check <../api/Phalcon_Forms_Element_Check>`       | Generate INPUT[type=check] elements                         |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\TextArea <../api/Phalcon_Forms_Element_TextArea>` | Generate TEXTAREA elements                                  |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Hidden <../api/Phalcon_Forms_Element_Hidden>`     | Generate INPUT[type=hidden] elements                        |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\File <../api/Phalcon_Forms_Element_File>`         | Generate INPUT[type=file] elements                          |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Date <../api/Phalcon_Forms_Element_Date>`         | Generate INPUT[type=date] elements                          |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Numeric <../api/Phalcon_Forms_Element_Numeric>`   | Generate INPUT[type=number] elements                        |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Submit <../api/Phalcon_Forms_Element_Submit>`     | Generate INPUT[type=submit] elements                        |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+

Event Callbacks
---------------
Whenever forms are implemented as classes, the callbacks: :code:`beforeValidation()` and :code:`afterValidation()` can be implemented
in the form's class to perform pre-validations and post-validations:

.. code-block:: html+php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function beforeValidation()
        {

        }
    }

Rendering Forms
---------------
You can render the form with total flexibility, the following example shows how to render each element using a standard procedure:

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

Or reuse the logic in your form class:

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

In the view:

.. code-block:: php

    <?php

    echo $element->renderDecorated("name");

    echo $element->renderDecorated("telephone");

Creating Form Elements
----------------------
In addition to the form elements provided by Phalcon you can create your own custom elements:

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

Forms Manager
-------------
This component provides a forms manager that can be used by the developer to register forms and access them via the service locator:

.. code-block:: php

    <?php

    use Phalcon\Forms\Manager as FormsManager;

    $di["forms"] = function () {
        return new FormsManager();
    };

Forms are added to the forms manager and referenced by a unique name:

.. code-block:: php

    <?php

    $this->forms->set(
        "login",
        new LoginForm()
    );

Using the unique name, forms can be accessed in any part of the application:

.. code-block:: php

    <?php

    $loginForm = $this->forms->get("login");

    echo $loginForm->render();

External Resources
------------------
* `Vökuró <http://vokuro.phalconphp.com>`_, is a sample application that uses the forms builder to create and manage forms, [`Github <https://github.com/phalcon/vokuro>`_]
