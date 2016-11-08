Access Control Lists - Listes de Contrôle d'Access (ACL)
========================================================

:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` fournit une gestion facile et légère des ACLs ainsi que les permissions qui lui sont rattachés. Les `Access Control Lists`_ (ACL) permettent à une application de contrôler l'accès à ses différentes zones ainsi que les objets concernés par les requêtes. Vous êtes encouragés de vous documenter sur la méthodologie ACL afin d'être familiarisé avec ces concepts.

En résumé, les ACLs possèdent des rôles et des ressources. Les ressources sont des objets qui doivent se conformer aux permissions qui leur sont attribuées par les ACLs. Les rôles sont des objets dont les requêtes d'accès aux ressources sont autorisées ou refusées par le méchanisme des ACLs.

Création d'une ACL
------------------
Ce composant est destiné initialement à fonctionner en mémoire. Ceci founit une utilisation simple et rapide pour accéder aux différents aspects de la liste.

Le constructeur de :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` prend en premier paramètre un adaptateur pour récupérer l'information relative à la liste de contrôle. Un exemple utilisant l'adaptateur en mémoire se trouve ci-dessous:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

Par défaut :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` autorise les actions sur les ressources qui ne sont pas encore définies. Pour augmenter le niveau de sécurité de la liste d'accès nous pouvons définir un niveau "deny" comme niveau d'accès par défaut.

.. code-block:: php

    <?php

    // Par défaut l'action est interdite
    $acl->setDefaultAction(Phalcon\Acl::DENY);

Ajout de Rôles à l'ACL
----------------------
Un rôle est un objet qui peut ou ne peut pas accéder à certaines ressource dans la liste d'accès. Par exemple nous associerons des rôles à des groupes de personnes dans une organisation. La classe :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` peut servir à créer des rôles d'une façon structurée. Ajoutons maintenant quelques rôles à notre liste récemment créée:

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // Création de quelques rôles
    // Le premier paramètre est le nom, le deuxmème une description optionnelle.
    $roleAdmins = new Role("Administrators", "Rôle super utilisateur");
    $roleGuests = new Role("Guests");

    // Ajoute le rôle "Guests" à l'ACL
    $acl->addRole($roleGuests);

    // Ajout le rôle "Designers" à l'ACL sans Phalcon\Acl\Role
    $acl->addRole("Designers");

Comme vous pouvez le voir, les rôles sont directement définis sans utiliser une instance.

Ajout de ressources
-------------------
Les ressources sont des objets dont l'accès est controlé. Dans les applications MVC il s'agit normalement des contrôleurs. Comme ce n'est pas obligatoire la classe :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` peut être utilisée pour définir des ressources. Il est important d'ajouter les actions ou les opérations associées à une ressource afin que l'ACL sache ce qu'il côntrôle.

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // Definition de la ressource "Customers"
    $customersResource = new Resource("Customers");

    // Ajoute la ressource "customers" a un couple d'opérations

    $acl->addResource(
        $customersResource,
        "search"
    );

    $acl->addResource(
        $customersResource,
        [
            "create",
            "update",
        ]
    );

Définition des Contrôles d'Accès
--------------------------------
Maintenant que nous avons des rôles et des ressources, il est temps de définir notre ACL (par ex. quels rôles peut accéder à quelles ressources). Cette partie est très importante surtout qu'il faut prendre en compte l'accès par défaut qui est "allow" ou "deny".

.. code-block:: php

    <?php

    // Définition des niveaux d'accès aux ressources

    $acl->allow("Guests", "Customers", "search");

    $acl->allow("Guests", "Customers", "create");

    $acl->deny("Guests", "Customers", "update");

La méthode :code:`allow()` indique qu'un rôle particulier peut accéder à une ressource en particulier. La méthode :code:`deny()` fait l'opposé.

Interrogation de l'ACL
----------------------
Une fois que la liste est complète, nous pouvons l'intérroger pour vérifier si un rôle dispose d'une autorisation ou non.

.. code-block:: php

    <?php

    // Vérifier quel rôle accède aux opérations

    // Returns 0
    $acl->isAllowed("Guests", "Customers", "edit");

    // Returns 1
    $acl->isAllowed("Guests", "Customers", "search");

    // Returns 1
    $acl->isAllowed("Guests", "Customers", "create");

Accès par fonction
------------------
Vous pouvez aussi ajouter en 4ème paramètre votre fonction personnalisée qui doit retourner un booléen. Celle-ci est invoquée dès que la méthode :code:`isAllowed()` est appelée. Vous pouvez passer les paramètres en tant que tableau associatif à la méthode :code:`isAllowed()` en tant que 4ème arguement où la clé est le nom du paramètre dans votre fonction.

.. code-block:: php

    <?php
    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Check whether role has access to the operation with custom function

    // Returns true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 4,
        ]
    );

    // Returns false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 3,
        ]
    );

Si vous ne fournissez pas de paramètres à la méthode :code:`isAllowed()`, le comportement par défaut est :code:`Acl::ALLOW`. Vous poucez changer cela en utilisant la méthode :code:`setNoArgumentsDefaultAction()`.

.. code-block:: php

    use Phalcon\Acl;

    <?php
    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Check whether role has access to the operation with custom function

    // Returns true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

    // Change no arguments default action
    $acl->setNoArgumentsDefaultAction(
        Acl::DENY
    );

    // Returns false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

Des objets en tant que nom de rôle et de ressource
--------------------------------------------------
Vous pouvez transmettre des objets à :code:`roleName` et :code:`resourceName`. Vos classes doivent implémenter :doc:`Phalcon\\Acl\\RoleAware <../api/Phalcon_Acl_RoleAware>` pour :code:`roleName` et :doc:`Phalcon\\Acl\\ResourceAware <../api/Phalcon_Acl_ResourceAware>` pour :code:`resourceName`.

Notre classe :code:`UserRole`

.. code-block:: php

    <?php

    use Phalcon\Acl\RoleAware;

    // Create our class which will be used as roleName
    class UserRole implements RoleAware
    {
        protected $id;

        protected $roleName;

        public function __construct($id, $roleName)
        {
            $this->id       = $id;
            $this->roleName = $roleName;
        }

        public function getId()
        {
            return $this->id;
        }

        // Implemented function from RoleAware Interface
        public function getRoleName()
        {
            return $this->roleName;
        }
    }

Et notre classe :code:`ModelResource`

.. code-block:: php

    <?php

    use Phalcon\Acl\ResourceAware;

    // Create our class which will be used as resourceName
    class ModelResource implements ResourceAware
    {
        protected $id;

        protected $resourceName;

        protected $userId;

        public function __construct($id, $resourceName, $userId)
        {
            $this->id           = $id;
            $this->resourceName = $resourceName;
            $this->userId       = $userId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        // Implemented function from ResourceAware Interface
        public function getResourceName()
        {
            return $this->resourceName;
        }
    }

Ainsi vous pouvez les utiliser dans la méthode :code:`isAllowed()`.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set access level for role into resources
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

    // Create our objects providing roleName and resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Check whether our user objects have access to the operation on model object

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Vous pouvez également accéder à ces objets dans votre fonction personnalisée dans :code:`allow()` ou :code:`deny()`. Les paramètres sont automatiquement liés selon les types dans la fonction.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function (UserRole $user, ModelResource $model) { // User and Model classes are necessary
            return $user->getId == $model->getUserId();
        }
    );

    $acl->allow(
        "Guests",
        "Customers",
        "create"
    );

    $acl->deny(
        "Guests",
        "Customers",
        "update"
    );

    // Create our objects providing roleName and resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Check whether our user objects have access to the operation on model object

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns false
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Vous pouvez toujours ajouter des paramètres personnalisés à la fonction et passer un tableau associatif à la méthode :code:`isAllowed()`. L'ordre n'a aucune importance.

Héritage de rôles
-----------------
Vous pouvez construire des structures de rôles complexes en exploitant l'héritage que fournit :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`. Les rôles peuvent hériter d'autre rôles, autorisant ainsi l'accès à des surensembles ou des sous-ensembles de ressources. Pour profiter de l'héritage, vous devrez passer le rôle parent en second paramètre lors de l'appel de la méthode d'ajout du rôle dans la liste.

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // Création de quelques rôles

    $roleAdmins = new Role("Administrators", "Super-User role");

    $roleGuests = new Role("Guests");

    // Ajout du rôle "Guests" à l'ACL
    $acl->addRole($roleGuests);

    // Ajout du rôle "Administrators" héritant des accès de "Guests"
    $acl->addRole($roleAdmins, $roleGuests);

Sérialisation des listes ACL
----------------------------
Pour améliorer les performances, les instance de :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` peuvent être sérialisées et stockées dans l'APC, en session, dans des fichiers textes ou une table de base de données, et peuvent être chargées à volonté sans avoir à redéfinir toute la liste. Vous pouvez faire ça comme suit:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // Vérifier que les données de l'ACL existent
    if (!is_file("app/security/acl.data")) {
        $acl = new AclList();

        // ... Définition des rôles, ressources, accès, etc.

        // Stockage de la liste sérialisée dans un fichier
        file_put_contents(
            "app/security/acl.data",
            serialize($acl)
        );
    } else {
        // Récupération des objets ACL depuis le fichier sérialisé
        $acl = unserialize(
            file_get_contents("app/security/acl.data")
        );
    }

    // Utilisation de la liste selon les besoins
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Accès autorisé!";
    } else {
        echo "Accès refusé :(";
    }

Nous vous recommandons d'utiliser l'adaptateur mémoire pendant le développement et d'utiliser l'un des autres adaptateurs en production.

Evénements ACL
--------------
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` est capable d'émettre des événements à :doc:`EventsManager <events>` s'il existe. Les événements sont déclenchés en utilisant le type "acl". Certains événements peuvent interrompre l'opération active lorqu'ils retournent faux. Les événements suivants sont supportés:

+-------------------+------------------------------------------------------------+---------------------+
| Nom d'évt         | Déclenché par                                              | Opération stoppée ? |
+===================+============================================================+=====================+
| beforeCheckAccess | Déclenché avant le contrôle d'accès d'un rôle ou ressource | Oui                 |
+-------------------+------------------------------------------------------------+---------------------+
| afterCheckAccess  | Déclenché après le contrôle d'accès d'un rôle ou ressource | Non                 |
+-------------------+------------------------------------------------------------+---------------------+

L'exemple suivant montre comment attacher un écouteur à ce composant:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // Création d'un gestionnaire d'événements
    $eventsManager = new EventsManager();

    // Attach a listener for type "acl"
    $eventsManager->attach(
        "acl:beforeCheckAccess",
        function (Event $event, $acl) {
            echo $acl->getActiveRole();

            echo $acl->getActiveResource();

            echo $acl->getActiveAccess();
        }
    );

    $acl = new AclList();

    // Setup the $acl
    // ...

    // Bind the eventsManager to the ACL component
    $acl->setEventsManager($eventsManager);

Création de vos propre adaptateurs
----------------------------------
Pour créer votre propre adaptateur vous devez implémenter l'interface :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` ou bien étendre un adaptateur existant.

.. _Access Control Lists: http://fr.wikipedia.org/wiki/Access_control_list
