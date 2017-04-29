Tutorial 4: Travailler avec le CRUD
===================================

Les backends fournissent d'habitude des formulaires pour que les utilisateurs puissent manipuler les données. En poursuivant l'étude 
d'INVO, nous allons aborder la création de CRUDs, une tâche très ordinaire que Phalcon vous simplifie avec l'utilisation de formulaires,
de validation, de paginateurs et plus encore.

La plupart des options qui manipulent des données (sociétés, produits et types de produits), ont été développés
en utilisant un CRUD_ (create/read/update/delete) élémentaire et commun. Chaque CRUD contient les fichiers suivants :

.. code-block:: bash

    invo/
        app/
            controllers/
                ProductsController.php
            models/
                Products.php
            forms/
                ProductsForm.php
            views/
                products/
                    edit.volt
                    index.volt
                    new.volt
                    search.volt

Chaque contrôleur a les actions suivantes :

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        /**
         * L'action de départ, il sélectionne la vue "search"
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Réalise l'action "search" basée sur les critères envoyés par "index"
         * Retourne un paginateur pour les résultats
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Affiche la vue pour créer un nouveau ("new") produit
         */
        public function newAction()
        {
            // ...
        }

        /**
         * Affiche la vue pour modifier ("edit") un produit existant
         */
        public function editAction()
        {
            // ...
        }

        /**
         * Création d'un produit à partir des données saisies dans l'action "new"
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Mise à jour d'un produit à partir des données saisies dans l'action "edit"
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Suppression d'un produit existant
         */
        public function deleteAction($id)
        {
            // ...
        }
    }

Formulaire de recherche
^^^^^^^^^^^^^^^^^^^^^^^
Tous les CRUD commencent avec le formulaire de recherche. Ce formulaire montre tous les champs que la table products possède,
permettant à l'utilisateur de filtrer ses recherches. La tâche "products" est liée à la table "products_types".
Dans notre cas, nous avons déjà demandé des enregistrements de cette table, afin de faciliter la recherche dans ce champ :

.. code-block:: php

    <?php

    /**
     * L'action de départ, il sélectionne la vue "search"
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;

        $this->view->form = new ProductsForm();
    }

Une instance du formulaire "ProductsForm" (app/forms/ProductsForm.php) est transmise à la vue.
Ce formulaire défini les champs qui doivent être visibles par l'utilisateur:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;
    use Phalcon\Forms\Element\Select;
    use Phalcon\Validation\Validator\Email;
    use Phalcon\Validation\Validator\PresenceOf;
    use Phalcon\Validation\Validator\Numericality;

    class ProductsForm extends Form
    {
        /**
         * Initialise le formulaire "products"
         */
        public function initialize($entity = null, $options = [])
        {
            if (!isset($options["edit"])) {
                $element = new Text("id");

                $element->setLabel("Id");

                $this->add(
                    $element
                );
            } else {
                $this->add(
                    new Hidden("id")
                );
            }



            $name = new Text("name");

            $name->setLabel("Name");

            $name->setFilters(
                [
                    "striptags",
                    "string",
                ]
            );

            $name->addValidators(
                [
                    new PresenceOf(
                        [
                            "message" => "Name is required",
                        ]
                    )
                ]
            );

            $this->add($name);



            $type = new Select(
                "profilesId",
                ProductTypes::find(),
                [
                    "using"      => [
                        "id",
                        "name",
                    ],
                    "useEmpty"   => true,
                    "emptyText"  => "...",
                    "emptyValue" => "",
                ]
            );

            $this->add($type);



            $price = new Text("price");

            $price->setLabel("Price");

            $price->setFilters(
                [
                    "float",
                ]
            );

            $price->addValidators(
                [
                    new PresenceOf(
                        [
                            "message" => "Price is required",
                        ]
                    ),
                    new Numericality(
                        [
                            "message" => "Price is required",
                        ]
                    ),
                ]
            );

            $this->add($price);
        }
    }

Le formulaire est déclaré en utilisant un schéma orienté objet en se basant sur les éléments fournis par le composant  :doc:`forms <forms>`.
Chaque élément suit presque la même structure:

.. code-block:: php

    <?php

    // Création de l'élément
    $name = new Text("name");

    // Définition de l'étiquette
    $name->setLabel("Name");

    // Applique ces filtres avant la validation de l'élément
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // Applique ces validateurs
    $name->addValidators(
        [
            new PresenceOf(
                [
                    "message" => "Name is required",
                ]
            )
        ]
    );

    // Ajoute l'élément au formulaire
    $this->add($name);

D'autres éléments sont aussi utilisés dans ce formulaire:

.. code-block:: php

    <?php

    // Ajoute une entrée masquée dans le formulaire
    $this->add(
        new Hidden("id")
    );

    // ...

    $productTypes = ProductTypes::find();

    // Ajoute un HTML Select (liste) au formulaire
    // et l'alimente avec les données de "product_types"
    $type = new Select(
        "profilesId",
        $productTypes,
        [
            "using"      => [
                "id",
                "name",
            ],
            "useEmpty"   => true,
            "emptyText"  => "...",
            "emptyValue" => "",
        ]
    );

Notez que :code:`ProductTypes::find()` contient les données nécessaire pour alimenter le tag SELECT grâce à :code:`Phalcon\Tag::select()`.
Une fois que le formulaire est transmis à la vue, il peut être rendu et présenté à l'utilisateur:

.. code-block:: html+jinja

    {{ form("products/search") }}

        <h2>
            Search products
        </h2>

        <fieldset>

            {% for element in form %}
                <div class="control-group">
                    {{ element.label(["class": "control-label"]) }}

                    <div class="controls">
                        {{ element }}
                    </div>
                </div>
            {% endfor %}



            <div class="control-group">
                {{ submit_button("Search", "class": "btn btn-primary") }}
            </div>

        </fieldset>

    {{ endForm() }}

Ce qui produit le code HTML suivant:

.. code-block:: html

    <form action="/invo/products/search" method="post">

        <h2>
            Search products
        </h2>

        <fieldset>

            <div class="control-group">
                <label for="id" class="control-label">Id</label>

                <div class="controls">
                    <input type="text" id="id" name="id" />
                </div>
            </div>

            <div class="control-group">
                <label for="name" class="control-label">Name</label>

                <div class="controls">
                    <input type="text" id="name" name="name" />
                </div>
            </div>

            <div class="control-group">
                <label for="profilesId" class="control-label">profilesId</label>

                <div class="controls">
                    <select id="profilesId" name="profilesId">
                        <option value="">...</option>
                        <option value="1">Vegetables</option>
                        <option value="2">Fruits</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="price" class="control-label">Price</label>

                <div class="controls">
                    <input type="text" id="price" name="price" />
                </div>
            </div>



            <div class="control-group">
                <input type="submit" value="Search" class="btn btn-primary" />
            </div>

        </fieldset>

    </form>

Une fois que le formulaire est soumis, l'action "search" est exécutée dans le contrôleur réalisant ainsi la recherche
d'après les données saisies par l'utilisateur.

Exécuter une recherche
^^^^^^^^^^^^^^^^^^^^^^
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
            // Création des conditions de la requête
        } else {
            // Pagination en exploitant les conditions existantes
        }

        // ...
    }

Avec l'aide de :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` ,nous pouvons créer
les conditions de recherche basé sur les types de données envoyé via le formulaire :

.. code-block:: php

    <?php

    $query = Criteria::fromInput(
        $this->di,
        "Products",
        $this->request->getPost()
    );

Cette méthode vérifie quelle valeur est différente de "" (chaine vide) et "null" et les prend en compte pour créer
les critères de recherche :

* Si le champs de données est "text" ou similaire (char, varchar, text, etc.). L'opérateur "like" sera utilisé pour filtrer les résultats.
* Si le type de donnée est différent, l'opérateur "=" sera utilisé.

De plus, "Criteria" ignore toutes les variables :code:`$_POST` qui ne correspondent à aucun champs de la table.
Les valeurs seront automatiquement échappées en utilisant les paramètres liés (bond parameters).

Maintenant, on va stocker les paramètres dans le "sac" de session du contrôleur :

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Un sac à session est un attribut particulier dans un contrôleur qui est sauvegardé entre les requêtes.
Quand on y accède, cet attribut injecte un service :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
qui est indépendant de chaque contrôleur.

Puis, basé sur les paramètres passé, on génère la requête :

.. code-block:: php

    <?php

    $products = Products::find($parameters);

    if (count($products) === 0) {
        $this->flash->notice(
            "The search did not found any products"
        );

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
    }

Si la recherche ne retourne aucun produit, on transfert l'utilisateur à l'action index. Si la
recherche retourne des résultats, on créé un paginateur pour se déplacer à travers les pages facilement :

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as Paginator;

    // ...

    $paginator = new Paginator(
        [
            "data"  => $products,   // Data to paginate
            "limit" => 5,           // Rows per page
            "page"  => $numberPage, // Active page
        ]
    );

    // Récupère la page courante dans le paginateur
    $page = $paginator->getPaginate();

Enfin, on passe la page retournée à la vue:

.. code-block:: php

    <?php

    $this->view->page = $page;

Dans la vue (app/views/products/search.volt), on affiche
le résultat correspondant à la page actuelle :

.. code-block:: html+jinja

    {% for product in page.items %}
        {% if loop.first %}
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Type</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Active</th>
                    </tr>
                </thead>
                <tbody>
        {% endif %}

        <tr>
            <td>
                {{ product.id }}
            </td>

            <td>
                {{ product.getProductTypes().name }}
            </td>

            <td>
                {{ product.name }}
            </td>

            <td>
                {{ "%.2f"|format(product.price) }}
            </td>

            <td>
                {{ product.getActiveDetail() }}
            </td>

            <td width="7%">
                {{ link_to("products/edit/" ~ product.id, "Edit") }}
            </td>

            <td width="7%">
                {{ link_to("products/delete/" ~ product.id, "Delete") }}
            </td>
        </tr>

        {% if loop.last %}
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="7">
                            <div>
                                {{ link_to("products/search", "First") }}
                                {{ link_to("products/search?page=" ~ page.before, "Previous") }}
                                {{ link_to("products/search?page=" ~ page.next, "Next") }}
                                {{ link_to("products/search?page=" ~ page.last, "Last") }}
                                <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        {% endif %}
    {% else %}
        No products are recorded
    {% endfor %}

Il y a plusieurs choses dans l'exemple du dessus qui méritent d'être détaillées. Tout d'abord, les éléments actifs
de la page courante sont parcourus en utilisant un "for" de Volt. Volt fournit une syntaxe plus simple que le "foreach" du PHP. 

.. code-block:: html+jinja

    {% for product in page.items %}

Ce qui est similaire en PHP à:

.. code-block:: php

    <?php foreach ($page->items as $product) { ?>

Tout le bloc "for" est fournit ci-dessous:

.. code-block:: html+jinja

    {% for product in page.items %}
        {% if loop.first %}
            Executed before the first product in the loop
        {% endif %}

        Executed for every product of page.items

        {% if loop.last %}
            Executed after the last product is loop
        {% endif %}
    {% else %}
        Executed if page.items does not have any products
    {% endfor %}

Revenez maintenant à la vue pour découvrir ce que chaque bloc fait. Chaque champ
dans "product" est imprimé en conséquence:

.. code-block:: html+jinja

    <tr>
        <td>
            {{ product.id }}
        </td>

        <td>
            {{ product.productTypes.name }}
        </td>

        <td>
            {{ product.name }}
        </td>

        <td>
            {{ "%.2f"|format(product.price) }}
        </td>

        <td>
            {{ product.getActiveDetail() }}
        </td>

        <td width="7%">
            {{ link_to("products/edit/" ~ product.id, "Edit") }}
        </td>

        <td width="7%">
            {{ link_to("products/delete/" ~ product.id, "Delete") }}
        </td>
    </tr>

Comme nous avons vu précédemment, l'utilisation de :code:`product.id` est l'équivalent de :code:`$product->id` en PHP.
Nous faisons pareil pour :code:`product.name` et ainsi de suite. Les autres champs sont rendus différemments.
Par exemple, focalisons nous sur :code:`product.productTypes.name`. Pour comprendre cette partie,
nous devons consulter le modèle Products (app/models/Products.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    /**
     * Products
     */
    class Products extends Model
    {
        // ...

        /**
         * Initialisation de Products
         */
        public function initialize()
        {
            $this->belongsTo(
                "product_types_id",
                "ProductTypes",
                "id",
                [
                    "reusable" => true,
                ]
            );
        }

        // ...
    }

Un modèle peut avoir une méthode nommée :code:`initialize()`. Cette méthode n'est appelée qu'une fois par requête et
sert à l'ORM pour initialiser le modèle. Dans ce cas, "Products" est initialisé en indiquant que ce modèle dispose
d'une relation un-à-plusieurs vers un autre modèle nommé "ProductTypes".

.. code-block:: php

    <?php

    $this->belongsTo(
        "product_types_id",
        "ProductTypes",
        "id",
        [
            "reusable" => true,
        ]
    );

Ceci signifie que l'attribut local "product_types_id" de "Products" a une relation un-à-plusieurs
vers l'attribut "id" du modèle "ProductTypes". En définissant cette realtion nous pouvons accéder au 
nom du type de produit en utilisant:

.. code-block:: html+jinja

    <td>{{ product.productTypes.name }}</td>

Le champ "price" est formaté en utilisant un filtre Volt:

.. code-block:: html+jinja

    <td>{{ "%.2f"|format(product.price) }}</td>

En PHP pur, ce serait:

.. code-block:: php

    <?php echo sprintf("%.2f", $product->price) ?>

L'utilisation d'une méthode d'aide définie dans le modèle nous permet d'indiquer si le produit est actif ou non:

.. code-block:: php

    <td>{{ product.getActiveDetail() }}</td>

Cette méthode est définie dans le modèle.

Créer et modifier des entrées
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Voyons comment le CRUD créé et modifie des entrées. A partir des vues "new" et "edit", la donnée entrée par l'utilisateur
est envoyé à l'action "create" et "save" qui exécute l'action de créer ou de modifier les produits.

Dans la page de création, on récupère les données envoyés et on leur assigne une nouvelle instance de produit :

.. code-block:: php

    <?php

    /**
     * Création d'un produit basé sur les données fournies à l'action "new"
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "index",
                ]
            );
        }

        $form = new ProductsForm();

        $product = new Products();

        $product->id               = $this->request->getPost("id", "int");
        $product->product_types_id = $this->request->getPost("product_types_id", "int");
        $product->name             = $this->request->getPost("name", "striptags");
        $product->price            = $this->request->getPost("price", "double");
        $product->active           = $this->request->getPost("active");

        // ...
    }

Les données sont filtrés avant d'être assignés à l'objet :code:`$product`.
Ce filtrage est optionnel, l'ORM échappe les données entrées et convertit les données en fonction des types des champs:

.. code-block:: php

    <?php

    // ...

    $name = new Text("name");

    $name->setLabel("Name");

    // Filtres pour "name"
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // Validateurs pour "name"
    $name->addValidators(
        [
            new PresenceOf(
                [
                    "message" => "Name is required",
                ]
            )
        ]
    );

    $this->add($name);

Quand on sauvegarde, nous saurons si la donnée est conforme aux règles et validations mises en œuvre
dans le formulaire ProductsForm (app/forms/ProductsForm.php):

.. code-block:: php

    <?php

    // ...

    $form = new ProductsForm();

    $product = new Products();

    // Validate the input
    $data = $this->request->getPost();

    if (!$form->isValid($data, $product)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message);
        }

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "new",
            ]
        );
    }

Finalement, si le formulaire ne retourne pas de message de validation, nous pouvons sauvegarder l'instance du produit:

.. code-block:: php

    <?php

    // ...

    if ($product->save() === false) {
        $messages = $product->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message);
        }

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "new",
            ]
        );
    }

    $form->clear();

    $this->flash->success(
        "Product was created successfully"
    );

    return $this->dispatcher->forward(
        [
            "controller" => "products",
            "action"     => "index",
        ]
    );

Maintenant, dans le cas de la modification de produit, on doit présenter les données à éditer à l'utilisateur en remplissant au préalable les champs:

.. code-block:: php

    <?php

    /**
     * Modification d'un produit d'après son id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $product = Products::findFirstById($id);

            if (!$product) {
                $this->flash->error(
                    "Product was not found"
                );

                return $this->dispatcher->forward(
                    [
                        "controller" => "products",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new ProductsForm(
                $product,
                [
                    "edit" => true,
                ]
            );
        }
    }

L'aide "setDefault" introduit les valeurs du produit dans les champs qui portent le même nom comme valeur par défaut. Grâce à cela,
l'utilisateur peut changer n'importe quelle valeur et ensuite envoyer ses modifications à la base de données avec l'action "save":

.. code-block:: php

    <?php

    /**
     * Mise à jour d'un produit d'après les données fournies à l'action "edit"
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "index",
                ]
            );
        }

        $id = $this->request->getPost("id", "int");

        $product = Products::findFirstById($id);

        if (!$product) {
            $this->flash->error(
                "Product does not exist"
            );

            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "index",
                ]
            );
        }

        $form = new ProductsForm();

        $data = $this->request->getPost();

        if (!$form->isValid($data, $product)) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "new",
                ]
            );
        }

        if ($product->save() === false) {
            $messages = $product->getMessages();

            foreach ($messages as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success(
            "Product was updated successfully"
        );

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
    }

Nous avons vu comment Phalcon facilite la création de formulaire et les données d'une base d'une façon structurée.
Dans le chapitre suivant, nous verrons comment ajouter des éléments HTML personnalisés du genre menu par exemple.

.. _CRUD: https://fr.wikipedia.org/wiki/CRUD
