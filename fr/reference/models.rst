Travailler avec les Modèles
===========================

Un modèle représente l'information (donnée) d'une application et les règles pour manipuler cette donnée. Les modèles sont principalement utilisés pour gérer
les règles d'interaction avec la table correspondante dans la base données. La plupart du temps, à chaque table dans la base correspondra un modèle dans
votre application. L'essentiel de la logique métier de votre application sera concentré dans les modèles.

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` est la base de chaque modèle dans une application Phalcon. Il fournit une indépendance vis à vis de la base de données,
une fonctionnalité _CRUD élémentaire, des capacités de recherche avancées et la possibilité de relier les modèles entre eux au travers d'autres service.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` évite la nécessité d'utiliser des instructions SQL parce qu'il traduit dynamiquement les méthodes vers
les opérations du moteur de bases de données respectif.

.. highlights::

    Les modèles sont prévus pour travailler avec les bases de données sur une couche élevée d'abstraction. Si vous devez exploiter des bases de données à un bas niveau
    consultez la documentation du composant :doc:`Phalcon\\Db <../api/Phalcon_Db>`.

Création de modèles
-------------------
Un modèle est une classe qui étend :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. Son nom de classe doit suivre la notation camel:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {

    }

.. highlights::

    Si vous utilisez PHP 5.4/5.5, il est recommandé que vous déclariez chaque colonne qui fait partie du modèle afin
    de préserver la mémoire et de réduire les allocations en mémoire.

Par défaut, le modèle "Store\\Toys\\RobotParts" fait référence à la table "robot_parts". Si vous souhaitez spécifiez un autre nom pour la table de correspondance,
vous pouvez utiliser la méthode :code:`setSource()`:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {
        public function initialize()
        {
            $this->setSource("toys_robot_parts");
        }
    }

Le modèle RobotParts est désormais relié à la table "toys_robots_parts". La méthode :code:`initialize()` facilite la mise en place d'un comportement personnalisé comme par exemple une table différente.

La méthode :code:`initialize()` n'est invoquée qu'une seule fois lors de la requête, il est destiné à effectuer des initialisations qui
s'appliquent à toutes les instances du modèle créées au sein de l'application. Si vous voulez réaliser des tâches d'initialisation à chaque instanciation
vous le pouvez avec la méthode :code:`onConstruct()`:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {
        public function onConstruct()
        {
            // ...
        }
    }

Propriétés publiques contre Accesseurs
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Les modèles peuvent être implémentés avec des propriétés à portée publique, ce qui signifie que chaque propriété peut être
lue ou écrite sans aucune restriction à partir de n'importe quel code qui instancie le modèle:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $price;
    }

Avec des accesseurs, vous contrôlez quelles sont les propriétés qui sont visibles publiquement et vous pouvez effectuer diverses transformations
sur les données (qui ne seraient pas possible autrement) ainsi qu'ajouter des règles de validation sur les données portées par l'objet:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use InvalidArgumentException;
    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        protected $id;

        protected $name;

        protected $price;

        public function getId()
        {
            return $this->id;
        }

        public function setName($name)
        {
            // Le nom est-il trop court ?
            if (strlen($name) < 10) {
                throw new InvalidArgumentException(
                    "Le nom est trop court"
                );
            }

            $this->name = $name;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setPrice($price)
        {
            // Les prix négatifs sont interdits
            if ($price < 0) {
                throw new InvalidArgumentException(
                    "Le prix ne peut être négatif"
                );
            }

            $this->price = $price;
        }

        public function getPrice()
        {
            // Conversion de la valeur en type double avant utilisation
            return (double) $this->price;
        }
    }

Les propriétés publiques sont moins complexes à développer. Cependant, les accesseurs augmentent grandement la testabilité,
l'extensibilité et la maintenabilité des applications. C'est au développeur de décider quelle est la stratégie est la plus appropriée pour
l'application en cours de création. L'ORM est compatible avec les deux approches de définition de propriétés.

.. highlights::

    Les tirets bas (_) dans les noms de propriétés peuvent être problématiques avec les accesseurs

Si vous utilisez des tirets bas dans les noms de propriété, vous devez toujours utiliser la forme camelcase pour la déclaration de vos accesseurs pour
une utilisation des méthodes magiques (par ex. $model->getPropertyName au lieu de $model->getProperty_name, $model->findByPropertyName
au lieu de $model->findByProperty_name, etc.). Comme le système s'attend à une forme camelcase, et que les tirets bas sont généralement
supprimés, il est recommandé de nommer vos propriétés de la manière indiquée dans la documentation. Vous pouvez utiliser un mapping
de colonnes (comme décrit avant) pour assurer une bonne correspondance entre vos propriétés et les homologues dans la base de données.


Comprendre le lien entre les Enregistrements et les Objets
----------------------------------------------------------
Chaque instance d'un modèle représente une ligne dans la table. Vous accédez facilement aux données de l'enregistrement en lisant les propriétés de l'objet.
Par exemple, pour une table "robots" avec ces enregistrements:

.. code-block:: bash

    mysql> select * from robots;
    +----+------------+------------+------+
    | id | name       | type       | year |
    +----+------------+------------+------+
    |  1 | Robotina   | mechanical | 1972 |
    |  2 | Astro Boy  | mechanical | 1952 |
    |  3 | Terminator | cyborg     | 2029 |
    +----+------------+------------+------+
    3 rows in set (0.00 sec)

Vous pourriez trouver un enregistrement particulier d'après sa clé primaire et imprimer son nom:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Trouve l'enrgt avec  id = 3
    $robot = Robots::findFirst(3);

    // Imprime "Terminator"
    echo $robot->name;

Une fois que l'enregistrement est en mémoire, vous pouvez effectuer des modifications sur ces données et enregistrer les changements:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(3);

    $robot->name = "RoboCop";

    $robot->save();

Comme vous pouvez le constater, il n'est pas nécessaire d'utiliser directement des instructions SQL. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` fournit
une haute abstraction de la base de données pour les applications web.

Trouver des enregistrements
---------------------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` offre également différentes méthodes pour chercher des enregistrements. Les exemples qui suivent vous
montrent comment extraire un ou plusieurs enregistrements à partir d'un modèle:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Combien y-a-t'il de robots ?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // Combien y-a-t'il de robots 'mechanical' ?
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // Récupère et imprime les robots 'virtual' par ordre de nom
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Récupère les 100 premier robots 'virtual' par ordre de nom
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
            "limit" => 100,
        ]
    );
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

.. highlights::

    Si vous voulez trouver un enregistrement d'après une donnée externe (telle qu'une entrée utilisateur) ou une variable, vous devez utiliser la `liaison de paramètres`_.

Vous pouvez également utiliser la méthode :code:`findFirst()` pour récupérer le premier enregistrement qui correspond au critère fournit:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Quel est le premier robot dans la table robots ?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // Quel est le premier robot 'mechanical' dans la table robots ?
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // Récupère le premier robot 'virtual' par ordre de nom
    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );
    echo "The first virtual robot name is ", $robot->name, "\n";

Les deux méthodes :code:`find()` et :code:`findFirst()` acceptent un tableau associatif spécifiant les critères de recherche:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name DESC",
            "limit" => 30,
        ]
    );

    $robots = Robots::find(
        [
            "conditions" => "type = ?1",
            "bind"       => [
                1 => "virtual",
            ]
        ]
    );

Les différentes options de requête sont:

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| Paramètre   | Description                                                                                                                                                                                                                                                    | Exemple                                                                         |
+=============+================================================================================================================================================================================================================================================================+=================================================================================+
| conditions  | Conditions pour l'opération de recherche. Il est utilisé pour extraire seulement les enregistrements qui répondent au critère spécifié. Par défaut :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` suppose que les conditions sont en premier paramètre. | :code:`"conditions" => "name LIKE 'steve%'"`                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| columns     | Spécifie les colonnes à renvoyer au lieu de toutes colonnes du modèles. Avec cette option, l'objet est incomplet lorsqu'il est retourné                                                                                                                        | :code:`"columns" => "id, name"`                                                 |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| bind        | Bind est utilisé conjointement avec des options en remplaçant des espaces réservés et échappant les valeurs améliorant ainsi la sécurité                                                                                                                       | :code:`"bind" => array("status" => "A", "type" => "some-time")`                 |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| bindTypes   | Lors de la liaison de paramètres, vous pouvez utiliser ce paramètre pour introduire une conversion de type du paramètre lié, augmentant encore la sécurité                                                                                                     | :code:`"bindTypes" => array(Column::BIND_PARAM_STR, Column::BIND_PARAM_INT)`    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| order       | Est utilisé pour trier le résultat. Un ou plusieurs champs séparés par une virgule.                                                                                                                                                                            | :code:`"order" => "name DESC, status"`                                          |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| limit       | Limite le résultat à une certaine plage                                                                                                                                                                                                                        | :code:`"limit" => 10`                                                           |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| offset      | Décale le resultat d'un certain nombre de lignes.                                                                                                                                                                                                              | :code:`"offset" => 5`                                                           |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| group       | Collecte les données au travers de plusieurs enregistrement et regroupe les résultats selon une ou plusieurs colonnes                                                                                                                                          | :code:`"group" => "name, status"`                                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| for_update  | Avec cette option, doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` lit les dernières données disponibles en activant un verrou exclusif sur chaque enregistrement                                                                                         | :code:`"for_update" => true`                                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| shared_lock | Avec cette option, doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` lit les dernières données disponibles en activant un verrou partagé sur chaque enregistrement                                                                                          | :code:`"shared_lock" => true`                                                   |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| cache       | Met en cache le résultat, réduisant les accès au système relationnel                                                                                                                                                                                           | :code:`"cache" => array("lifetime" => 3600, "key" => "my-find-key")`            |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+
| hydration   | Définit la stratégie d'hydratation pour alimenter chaque enregistrement du résultat                                                                                                                                                                            | :code:`"hydration" => Resultset::HYDRATE_OBJECTS`                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------------+

Si vous préférez, il existe une façon plus orientée objet pour créer des requêtes plutôt qu'utiliser un tableau de paramètres:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(["type" => "mechanical"])
        ->order("name")
        ->execute();

La méthode statique :code:`query()` retourne un objet :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` qui plus favorable à l'autocomplétion des IDE.

Toutes les requêtes sont gérées en interne comme des requêtes :doc:`PHQL <phql>`. PHQL est un langage de haut niveau semblable au SQL et orienté objet.
Ce langage dispose d'autre caractéristiques pour réaliser des requêtes comme des jointures avec d'autres modèles, des regroupement, des agrégats, etc.

Enfin, il existe la méthode :code:`findFirstBy<property-name>()`. Cette méthode étend la méthode :code:`findFirst()` mentionnée plus tôt. Elle permet de réaliser rapidement une
restitution depuis la table en exploitant le nom de la propriété elle-même et en transmettant en paramètre les données à rechercher sur cette colonne.
Suivons un exemple en reprenant notre modèle Robots mentionné précédemment:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $price;
    }

Nous disposons de trois propriétés pour travailler avec: :code:`$id`, :code:`$name` et :code:`$price`. Bon, mettons que vous voulez récupérer le
premier enregistrement de la table avec le nom "Terminator". Ceci peut être écrit ainsi:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $name = "Terminator";

    $robot = Robots::findFirstByName($name);

    if ($robot) {
        echo "Le premier robot avec le nom " . $name . " coûte " . $robot->price . ".";
    } else {
        echo "Il n'existe pas dans la table de robot avec le nom " . $name . ".";
    }

Notez que nous avons utilisé "Name" dans l'appel de la méthode et transmis la variable :code:`$name` qui contient le nom
que nous recherchons dans notre table. Notez également que lorsque nous trouvons une correspondance avec notre requête, toutes les autres propriétés
nous sont également disponibles.

Jeux de résultat de modèles
^^^^^^^^^^^^^^^^^^^^^^^^^^^
Alors que :code:`findFirst()` retourne directement une instance de la classe appelée (s'il existe des données à renvoyer), la méthode :code:`find()` retourne
un :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. C'est un objet qui encapsule toutes les fonctionnalités
d'un jeu d'enregistrement comme le parcours, la recherche d'enregistrements spécifiques, le décompte, etc.

Ces objets sont plus puissants que les tableaux standards. Une des plus intéressantes caractéristiques de :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`
est qu'à n'importe quel moment il n'y a qu'un seul enregistrement en mémoire. Ceci facilite grandement la gestion de la mémoire surtout lorsqu'on travaille avec de grands volumes de données.

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Récupère tous les robots
    $robots = Robots::find();

    // Parcours avec un foreach
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Parcours avec un while
    $robots->rewind();

    while ($robots->valid()) {
        $robot = $robots->current();

        echo $robot->name, "\n";

        $robots->next();
    }

    // Décompte du jeu de résultat
    echo count($robots);

    // Une autre façon de décompter le jeu de résultat
    echo $robots->count();

    // Déplace le curseur interne au troisième robot
    $robots->seek(2);

    $robot = $robots->current();

    // Accède au robot par sa position dans le jeu de résultat
    $robot = $robots[5];

    // Vérifie qu'il existe un enregistrement à une certaine position
    if (isset($robots[3])) {
       $robot = $robots[3];
    }

    // Prend le premier enregistrement dans le résultat
    $robot = $robots->getFirst();

    // Prend le dernier enregistrement
    $robot = $robots->getLast();

Les jeux de résultat de Phalcon émulent les curseurs défilables. Vous pouvez prendre n'importe quel ligne juste d'après sa position, ou déplacer le pointeur interne
à une position spécifique. Notez que certains SGBD ne supportent pas les curseurs défilables ce qui oblige à ré-exécuter la requête
pour faire repartir le curseur depuis le début et d'obtenir l'enregistrement à la position demandée. De même, si un jeu de résultat
doit être parcouru plusieurs fois, la requête sera exécutée d'autant de fois.

Comme le stockage en mémoire de volumineux résultats peut être gourmand en ressources, les jeux de résultat sont extraits
de la base données par morceaux de 32 lignes, réduisant la nécessité de re-exécuter la requête dans la plupart des cas.

Notez que les jeux de résultats peuvent être sérialisés et stockés dans un cache serveur. :doc:`Phalcon\\Cache <cache>` peut aider dans cette tâche. Cependant,
la sérialisation de données oblige :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` à récupérer toutes les données de la base dans un tableau
consommant ainsi plus de mémoire que nécessaire.

.. code-block:: php

    <?php

    // Demande tous les enregistrements depuis le modèle
    $parts = Parts::find();

    // Stocke le jeu de résultat dans un fichier
    file_put_contents(
        "cache.txt",
        serialize($parts)
    );

    // Récupère les données depuis un fichier
    $parts = unserialize(
        file_get_contents("cache.txt")
    );

    // Parcours les données
    foreach ($parts as $part) {
        echo $part->id;
    }

Filtrer les jeux d'enregistrement
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
La méthode la plus efficace pour filtrer les données est de définir des critères de recherche, les bases de données exploitant les index pour retourner les données plus rapidement.
Phalcon vous permet de filtrer les données avec PHP en utilisant n'importe quelle ressource qui n'est pas disponible dans la base de données:

.. code-block:: php

    <?php

    $customers = Customers::find();

    $customers = $customers->filter(
        function ($customer) {
            // Retourne que les clients avec un e-mail valide
            if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
                return $customer;
            }
        }
    );

Liaison de Paramètres
^^^^^^^^^^^^^^^^^^^^^
La liaison de paramètres est également supportée dans :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. Vous êtes encouragés à utiliser
cette méthode pour éliminer la possibilité que votre code soit le sujet d'attaques par injection SQL.

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Interrogation de robots en liant les paramètres avec des marqueurs texte
    // Paramètres dont les clés sont les même que les marqueurs
    $robots = Robots::find(
        [
            "name = :name: AND type = :type:",
            "bind" => [
                "name" => "Robotina",
                "type" => "maid",
            ],
        ]
    );

    // Interrogation de robots en liant les paramètres avec les marqueurs numériques
    $robots = Robots::find(
        [
            "name = ?1 AND type = ?2",
            "bind" => [
                1 => "Robotina",
                2 => "maid",
            ],
        ]
    );

    // Interrogation de robots avec à la fois des marqueurs numériques et textuels
    // Paramètres dont les clés sont les même que les marqueurs
    $robots = Robots::find(
        [
            "name = :name: AND type = ?1",
            "bind" => [
                "name" => "Robotina",
                1      => "maid",
            ],
        ]
    );

En plaçant des marqueurs numériques, vous devez les écrire sous forme d'entier comme 1 ou 2. Dans ce cas "1" ou "2" sont considérés comme du texte
et non des nombres, donc l'espace marqué ne peut pas être remplacé avec succès.

Les chaînes de caractères sont automatiquement échappées à l'aide de PDO_. Cette fonction prend en compte le jeu de caractères de la connexion, donc il est recommandé de définir
le bon jeu de caractères dans les paramètres de la connexion ou bien dans la configuration de la base de données. Un mauvais jeu de caractères risque de produire des effets indésirables
lors du stockage ou de la récupération des données.

De plus, vous pouvez définir le paramètre "bindTypes" qui permet de définir comment les paramètres sont liés en accord avec leurs types de données.

.. code-block:: php

    <?php

    use Phalcon\Db\Column;
    use Store\Toys\Robots;

    // Paramètre lié
    $parameters = [
        "name" => "Robotina",
        "year" => 2008,
    ];

    // Conversion de type
    $types = [
        "name" => Column::BIND_PARAM_STR,
        "year" => Column::BIND_PARAM_INT,
    ];

    // Interrogation de robots en liant les paramètres à des marqueurs textuels
    $robots = Robots::find(
        [
            "name = :name: AND year = :year:",
            "bind"      => $parameters,
            "bindTypes" => $types,
        ]
    );

.. highlights::

    Comme le type par défaut est :code:`Phalcon\Db\Column::BIND_PARAM_STR`, il n'est pas nécessaire de préciser
    le paramètre "bindTypes" si toutes les colonnes sont de ce type.

Si vous attachez des tableaux aux paramètres liés, conservez à l'esprit que les index sont basés zéro:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $array = ["a","b","c"]; // $array: [[0] => "a", [1] => "b", [2] => "c"]

    unset($array[1]); // $array: [[0] => "a", [2] => "c"]

    // Maintenant nous devons réindexer le tableau
    $array = array_values($array); // $array: [[0] => "a", [1] => "c"]

    $robots = Robots::find(
        [
            'letter IN ({letter:array})',
            'bind' => [
                'letter' => $array
            ]
        ]
    );

.. highlights::

    La liaison de paramètres est disponible pour chaque méthode de requêtage tel que :code:`find()` et :code:`findFirst()` mais aussi les méthodes
    de calcul comme :code:`count()`, :code:`sum()`, :code:`average()`, etc.

Si vous utilisez les "finders", les paramètres sont automatiquement liés:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Requête liant explicitement un paramètre
    $robots = Robots::find(
        [
            "name = ?0",
            "bind" => [
                "Ultron",
            ],
        ]
    );

    // Requête liant implicitement un paramètre
    $robots = Robots::findByName("Ultron");

Initialisation et Préparation d'Enregistrement récupéré
-------------------------------------------------------
Il peut arriver qu'après avoir obtenu un enregistrement depuis la base de données, il soit nécessaire d'initialiser les données avant
qu'elles ne soient utilisées dans le reste de l'application. Vous implémentez pour cela la méthode :code:`afterFetch()` dans le modèle, cet événement
sera exécuté juste après la création de l'instance et l'assignation des données:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $status;

        public function beforeSave()
        {
            // Conversion du tableau en chaîne de caractères
            $this->status = join(",", $this->status);
        }

        public function afterFetch()
        {
            // Conversion de la chaîne de caractères en tableau
            $this->status = explode(",", $this->status);
        }

        public function afterSave()
        {
            // Conversion de la chaîne de caractères en tableau
            $this->status = explode(",", $this->status);
        }
    }

Si vous utilisez les accesseurs et/ou les propriétés publiques, vous pouvez initialiser le champ une fois
qu'il est accédé:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $status;

        public function getStatus()
        {
            return explode(",", $this->status);
        }
    }

Génération de calculs
---------------------
Les calculs (ou les aggrégations) sont des aides pour les fonctions couramment utilisées des SGBD comme COUNT, SUM, MAX, MIN ou AVG.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` permet d'utiliser ces fonctions directement depuis les méthodes exposées.

Exemples de Count:

.. code-block:: php

    <?php

    // Combien y-a-t'il d'employés ?
    $rowcount = Employees::count();

    // Combien de zones différentes sont assignées aux employés ?
    $rowcount = Employees::count(
        [
            "distinct" => "area",
        ]
    );

    // Combien y-a-t'il d'employés dans le secteur "Testing" ?
    $rowcount = Employees::count(
        "area = 'Testing'"
    );

    // Dénombre les employés en groupant le résultat par secteur
    $group = Employees::count(
        [
            "group" => "area",
        ]
    );
    foreach ($group as $row) {
       echo "There are ", $row->rowcount, " in ", $row->area;
    }

    // Dénombre les employés en les groupant par secteur et ordonnant le résultat sur le compte
    $group = Employees::count(
        [
            "group" => "area",
            "order" => "rowcount",
        ]
    );

    // Évite les injections SQL avec des paramètres liés
    $group = Employees::count(
        [
            "type > ?0",
            "bind" => [
                $type
            ],
        ]
    );

Exemples de Sum:

.. code-block:: php

    <?php

    // A combien s'élève le salaire de tous les employés ?
    $total = Employees::sum(
        [
            "column" => "salary",
        ]
    );

    // A combien s'élève le salaire de tous les employés du secteur des ventes ?
    $total = Employees::sum(
        [
            "column"     => "salary",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Génère un regroupement des salaires par secteur
    $group = Employees::sum(
        [
            "column" => "salary",
            "group"  => "area",
        ]
    );
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $row->area, " is ", $row->sumatory;
    }

	// Génère un regroupement des salaires par secteur en ordonnant
	// les salaires du plus grand au plus petit
    $group = Employees::sum(
        [
            "column" => "salary",
            "group"  => "area",
            "order"  => "sumatory DESC",
        ]
    );

    // Évite les injections SQL avec des paramètres liés
    $group = Employees::sum(
        [
            "conditions" => "area > ?0",
            "bind"       => [
                $area
            ],
        ]
    );

Exemples d'Average:

.. code-block:: php

    <?php

    // Quel est le salaire moyen de tous les employés ?
    $average = Employees::average(
        [
            "column" => "salary",
        ]
    );

    // Quel est le salaire moyen de tous les employés du secteur des ventes ?
    $average = Employees::average(
        [
            "column"     => "salary",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Évite les injections SQL avec des paramètres liés
    $average = Employees::average(
        [
            "column"     => "age",
            "conditions" => "area > ?0",
            "bind"       => [
                $area
            ],
        ]
    );

Exemples Max/Min:

.. code-block:: php

    <?php

    // Quel est l'âge le plus élevé de tous les employés ?
    $age = Employees::maximum(
        [
            "column" => "age",
        ]
    );

    // Quel est l'âge le plus élevé de tous les employés du secteur des ventes ?
    $age = Employees::maximum(
        [
            "column"     => "age",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Quel est le salaire le plus bas de tous les employés ?
    $salary = Employees::minimum(
        [
            "column" => "salary",
        ]
    );

Création et Mise à jour d'Enregistrements
-----------------------------------------
La méthode :code:`Phalcon\Mvc\Model::save()` vous permet de créer ou de mettre à jour les enregistrement selon s'ils existent déjà dans la table
associée au modèle. La méthode "save" est appelée en interne par les méthodes "create" et "update" de :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
Pour que cela fonctionne comme prévu, il est nécessaire d'avoir correctement défini une clé primaire dans l'entité pour déterminer si un enregistrement
should be updated or created.


De plus, la méthode exécute les validateurs associés, les clés étrangères virtuelle ainsi que les événements qui sont définis dans le modèle:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    if ($robot->save() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

Un tableau peut être transmis à "save" pour éviter d'assigner chaque colonne manuellement. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` va vérifier s'il existe des setters
pour les colonnes indiquées dans le tableau en leur donnant priorité plutôt que d'affecter directement les valeurs des attributs:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save(
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

Les valeurs qui sont assignées soit directement, soit à l'aide d'un tableau d'attributs, sont échappées et assainies selon le type de données relatif à l'attribut. Donc, n'ayez crainte des 
injections SQL lors de la transmission d'un tableau peu sûr:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save($_POST);

.. highlights::

	Sans précaution, une affectation de masse pourrait permettre de définir la valeur à n'importe quelle colonne de la base de données. N'utilisez uniquement cette fonction
	que si vous voulez permettre à un utilisateur d'insérer ou de mettre à jour toutes les colonnes du modèle, même si ces champs ne sont pas soumis
	par le formulaire.
	
Vous pouvez ajouter un paramètre supplémentaire à "save" pour indiquer la liste blanche des champs qui seront pris en compte
lors de l'assignation de masse:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save(
        $_POST,
        [
            "name",
            "type",
        ]
    );

Créer/Mettre à jour avec Confiance
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Lorsqu'une application contient beaucoup d'accès concurrents, nous pourrions nous attendre à créer un enregistrement alors qu'il est mis à jour. Cela
peut arriver en utilisant :code:`Phalcon\Mvc\Model::save()` lors de la persistance des enregistrement en base. Pour être absolument certain
que l'enregistrement soit créé ou mis à jour, nous pouvons remplacer l'appel de :code:`save()` par :code:`create()` ou :code:`update()`:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    // Cet enregistrement sera seulement créé
    if ($robot->create() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }

Les méthodes "create" et "update" acceptent également un tableau de valeurs en paramètre.

Suppression d'enregistrements
-----------------------------
La méthode :code:`Phalcon\Mvc\Model::delete()` permet de supprimer un enregistrement. Vous pouvez l'utiliser comme suit:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(11);

    if ($robot !== false) {
        if ($robot->delete() === false) {
            echo "Sorry, we can't delete the robot right now: \n";

            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

Vous pouvez également supprimer plusieurs enregistrements en parcourant un jeu d'enregistrement avec foreach:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::find(
        "type = 'mechanical'"
    );

    foreach ($robots as $robot) {
        if ($robot->delete() === false) {
            echo "Sorry, we can't delete the robot right now: \n";

            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

Les événements qui suivent servent à définir des règles métier qui seront exécutées lors d'une opération de 
suppression:

+-----------+--------------+---------------------+------------------------------------------+
| Opération | Nom          | Opération stoppée ? | Explication                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | Oui                 | Lancé avant l'opération de suppression   |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | Non                 | Lancé après l'opération de suppression   |
+-----------+--------------+---------------------+------------------------------------------+

Avec les événements ci-dessus vous pouvez également définir des règles métier dans les modèles:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function beforeDelete()
        {
            if ($this->status === "A") {
                echo "The robot is active, it can't be deleted";

                return false;
            }

            return true;
        }
    }

.. _CRUD: https://fr.wikipedia.org/wiki/CRUD
.. _PDO: http://php.net/manual/fr/pdo.prepared-statements.php
