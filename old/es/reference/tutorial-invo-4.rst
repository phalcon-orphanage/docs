Tutorial 5: Customizing INVO
============================

To finish the detailed explanation of INVO we are going to explain how to customize INVO adding UI elements
and changing the title according to the controller executed.

Componentes de Usuario
----------------------
Todos los elementos visuales en la aplicación han sido logrados usando mayormente con `Bootstrap`_.
Algunos elementos, como la barra de navegación cambian de acuerdo al estado actual de la aplicación. Por ejemplo,
en la esquina superior derecha, el link "Log in / Sign Up" cambia a "Log out" si un usuario ha iniciado sesión en la aplicación.

Esta parte de la aplicación es implementada en el componente de usuario "Elements" (app/library/Elements.php).

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

Esta clase extiende de :doc:`Phalcon\\Mvc\\User\\Component <../api/Phalcon_Mvc_User_Component>`, no es obligatorio que los componentes de usuario extiendan de esa clase,
sin embargo esto ayuda a que puedan acceder facilmente a los servicios de la aplicación. Ahora vamos a registrar
esta clase en el contenedor de servicios:

.. code-block:: php

    <?php

    // Registrar un componente de usuario
    $di->set(
        "elements",
        function () {
            return new Elements();
        }
    );

Así como los controladores, plugins o componentes, dentro de una vista, este componente también puede acceder a los servicios
de la aplicación simplemente accediendo a un atributo con el mismo nombre de un servicio previamente registrado:

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

La parte relevante es:

.. code-block:: html+jinja

    {{ elements.getMenu() }}

Cambiar el título dinámicamente
-------------------------------
Cuando navegas entre una opción y otra verás que el título de la página cambia dinamicamente indicando
donde estamos trabajando actualmente. Esto se logra en el método inicializador de cada controlador:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        public function initialize()
        {
            // Establecer el título de la página
            $this->tag->setTitle(
                "Manage your product types"
            );

            parent::initialize();
        }

        // ...
    }

El método :code:`parent::initialize()` en la clase padre se llama igualmente, esté agrega más información al título:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ControllerBase extends Controller
    {
        protected function initialize()
        {
            // Agregar el nombre de la aplicación al principio del título
            $this->tag->prependTitle(
                "INVO | "
            );
        }

        // ...
    }

Finalmente, el título se imprime en la vista principal (app/views/index.volt):

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle(); ?>
        </head>

        <!-- ... -->
    </html>

.. _Bootstrap: http://getbootstrap.com/
