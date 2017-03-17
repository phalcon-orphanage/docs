Tutorial 5: Customizing INVO
============================

To finish the detailed explanation of INVO we are going to explain how to customize INVO adding UI elements
and changing the title according to the controller executed.

Composants utilisateurs
-----------------------
Tous les éléments graphique et visuels de l'application ont été réalisés principalement avec `Bootstrap`_.
Certains éléments, comme la barre de navigation, changent en fonction de l'état de l'applicatin (connecté/déconnecté). Par exemple
dans le coin en haut à droite, les liens "Log in / Sign up" (se connecter/s'inscrire) se changent en "Log out" (Se déconnecter) quand un utilisateur se connecte.

Cette partie de l'application est implémentée en utilisant le composant "Elements" (app/library/Elements.php).

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

Cette classe étend de :doc:`Phalcon\\Mvc\\User\\Component <../api/Phalcon_Mvc_User_Component>`, il n'est pas imposé d'étendre un composant avec cette classe, mais
cela permet d'accéder plus rapidement/facilement aux services de l'application. Maintenant enregistrons
cette classe au conteneur de service :

.. code-block:: php

    <?php

    // Register a user component
    $di->set(
        "elements",
        function () {
            return new Elements();
        }
    );

Tout comme les contrôleurs, les plugins et les composants à l'intérieur des vues, ce composant à aussi accès aux services requis
dans le conteneur en accédant juste à l'attribut :

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

La partie la plus importante est :

.. code-block:: html+jinja

    {{ elements.getMenu() }}

Changer le titre de manière dynamique
-------------------------------------
Quand vous naviguez sur le site, vous remarquerez que le titre change d'une page à l'autre.
Cela est réalisé dans l'"initializer" de chaque contrôleur :

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

Notez que la méthode :code:`parent::initialize()` est aussi appelée, cela ajoute plus de donnée à la suite du titre :

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

Enfin, le titre est affiché dans la vue principale (app/views/index.volt) :

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle(); ?>
        </head>

        <!-- ... -->
    </html>

.. _Bootstrap: http://getbootstrap.com/
