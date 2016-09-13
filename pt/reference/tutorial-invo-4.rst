Tutorial 5: Customizing INVO
============================

To finish the detailed explanation of INVO we are going to explain how to customize INVO adding UI elements
and changing the title according to the controller executed.

User Components
---------------
All the UI elements and visual style of the application has been achieved mostly through `Bootstrap`_.
Some elements, such as the navigation bar changes according to the state of the application. For example, in the
upper right corner, the link "Log in / Sign Up" changes to "Log out" if a user is logged into the application.

This part of the application is implemented in the component "Elements" (app/library/Elements.php).

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

This class extends the :doc:`Phalcon\\Mvc\\User\\Component <../api/Phalcon_Mvc_User_Component>`. It is not imposed to extend a component with this class, but
it helps to get access more quickly to the application services. Now, we are going to register
our first user component in the services container:

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

Changing the Title Dynamically
------------------------------
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
