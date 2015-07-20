Tutorial 4: Using CRUDs
=======================
Backends usually provides forms to allow users to manipulate data. Continuing the explanation of
INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you
using forms, validations, paginators and more.

Travailler avec le CRUD
---------------------
La plupart des options qui manipulent des données (companies, products et types de products), ont été développés
en utilisant un CRUD_ (create/read/update/delete) basique et commun. Chaque CRUD contient les fichiers suivants :

.. code-block:: bash

    invo/
        app/
            app/controllers/
                ProductsController.php
            app/models/
                Products.php
            app/views/
                products/
                    edit.phtml
                    index.phtml
                    new.phtml
                    search.phtml

Chaque contrôleur a les actions suivantes :

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * The start action, it shows the "search" view
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Execute the "search" based on the criteria sent from the "index"
         * Returning a paginator for the results
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Shows the view to create a "new" product
         */
        public function newAction()
        {
            // ...
        }

        /**
         * Shows the view to "edit" an existing product
         */
        public function editAction()
        {
            // ...
        }

        /**
         * Creates a product based on the data entered in the "new" action
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Updates a product based on the data entered in the "edit" action
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Deletes an existing product
         */
        public function deleteAction($id)
        {
            // ...
        }

    }

Formulaire de recherche
^^^^^^^^^^^^^^^
Tous les CRUD commencent avec le formulaire de recherche. Ce formulaire montre tous les champs que la table products possède,
permettant à l'utilisateur de filtrer ses recherches. La tâche "products" est liée à la table "products_types".
Dans notre cas, nous avons déjà demandé des enregistrements de cette table, afin de faciliter la recherche dans ce champ :

.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

Tous les types de produits sont cherchés et passés à la vue en tant que variable locale "productType". Puis, dans la vue
(app/views/index.phtml) on montre un champ "select" remplis avec ces résultats :

.. code-block:: html+php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo Tag::select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Notez que $productTypes contient les données nécessaires pour remplir le tag SELECT en utilisant Phalcon\\Tag::select.
Une fois le formulaire validé, l'action "search" est exécuté dans le contrôleur, réalisant la recherche basé sur les
données entrées par l'utilisateur.

Exécuter une recherche
^^^^^^^^^^^^^^^^^^^
L'action de recherche a un double comportement. Quand on y accéde avec POST, cela fait une recherche basé sur les données
que l'on a envoyé à partir du formulaire. Mais quand on y accéde via GET cela change la page courante dans le paginateur.
Pour différencier la méthode (GET ou POST), nous utilisons le composant :doc:`Request <request>` :

.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            // create the query conditions
        } else {
            // paginate using the existing conditions
        }

        // ...

    }

Avec l'aide de :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` ,nous pouvons créer les conditions de recherche basé sur les types de données envoyé via le formulaire :

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

Cette méthode vérifie quelle valeur est différente de "" (chaine vide) et "null" et les prends en compte pour créer les critères de recherche :

* Si le champs de données est "text" ou similaire (char, varchar, text, etc.). L'opérateur "like" sera utilisé pour filtrer les résultats.
* Si le type de donnée est différent, l'opérateur "=" sera utilisé

De plus, "Criteria" ignore toutes les variables POST qui ne correspondent à aucun champs de la table.
Les valeurs seront automatiquement échappées en utilisant les paramètres liés (bond parameters).

Maintenant, on va stoquer les paramètres dans le "sac" de session du contrôleur :

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Un sac de session est un attribut particulier dans un contrôleur qui est sauvegardé entre les requêtes.
Quand on y accède, cet attribut injecte un service :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` qui est indépendant de chaque contrôleur.

Puis, basé sur les paramètres passé, on génère la requête :

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

Si la recherche ne retourne aucun produit, on transfert l'utilisateur à l'action index. Si la recherche retourne des résultats,
on créé un paginateur pour se déplacer à travers les pages facilement :

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    // Data to paginate
        "limit" => 5,           // Rows per page
        "page" => $numberPage   // Active page
    ));

    // Get active page in the paginator
    $page = $paginator->getPaginate();

Enfin, on passe la page retournée à la vue:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

Dans la vue (app/views/products/search.phtml), on affiche le résultat correspondant à la page actuelle :

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= Tag::linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= Tag::linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

Créer et modifier des entrées
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Voyons comment le CRUD créé et modifie des entrées. A partir des vues "new" et "edit", la donnée entrée par l'utilisateur
est envoyé à l'action "create" et "save" qui exécute l'action de créer ou de modifier les produits.

Dans la page de création, on récupère les données envoyés et on leur assigne une nouvelle instance de produit :

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        $products = new Products();

        $products->id = $this->request->getPost("id", "int");
        $products->product_types_id = $this->request->getPost("product_types_id", "int");
        $products->name = $this->request->getPost("name", "striptags");
        $products->price = $this->request->getPost("price", "double");
        $products->active = $this->request->getPost("active");

        // ...

    }

Les données sont filtrés avant d'être assignés à l'objet. Ce filtrage est optionnel, l'ORM échappe les données entrées et
caste les données en fonction des types des champs.

Quand on sauvegarde, nous saurons si la donnée est conforme aux règles et validations implémentés dans le model Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        // ...

        if (!$products->create()) {

            // The store failed, the following messages were produced
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

Maintenant, dans le cas de la modification de produit, on doit présenter les données à éditer à l'utilisateur en pré-remplissant les champs:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        // ...

        $product = Products::findFirstById($id);

        Tag::setDefault("id", $product->id);
        Tag::setDefault("product_types_id", $product->product_types_id);
        Tag::setDefault("name", $product->name);
        Tag::setDefault("price", $product->price);
        Tag::setDefault("active", $product->active);

    }

L'helper "setDefault" entre les valeurs du produit dans les champs qui portent le même nom comme valeur par défaut.
Grace à cela, l'utilisateur peut changer n'importe quelle valeur et ensuite envoyer ses modifications à la base de données avec l'action "save":

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        // ...

        // Find the product to update
        $product = Products::findFirstById($this->request->getPost("id"));
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        // ... assign the values to the object and store it

    }

We have seen how Phalcon lets you create forms and bind data from a database in a structured way.
In next chapter, we will see how to add custom HTML elements like a menu.

.. _Jinja: http://jinja.pocoo.org/
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
