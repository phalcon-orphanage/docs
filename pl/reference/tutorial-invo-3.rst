Tutorial 4: Working with the CRUD
=================================

Backends usually provide forms to allow users to manipulate data. Continuing the explanation of
INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you
using forms, validations, paginators and more.

Most options that manipulate data in INVO (companies, products and types of products) were developed
using a basic and common CRUD_ (Create, Read, Update and Delete). Each CRUD contains the following files:

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

Each controller has the following actions:

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

The Search Form
^^^^^^^^^^^^^^^
Every CRUD starts with a search form. This form shows each field that the table has (products), allowing the user
to create a search criteria for any field. The "products" table has a relationship with the table "products_types".
In this case, we previously queried the records in this table in order to facilitate the search by that field:

.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;

        $this->view->form = new ProductsForm();
    }

An instance of the ProductsForm form (app/forms/ProductsForm.php) is passed to the view.
This form defines the fields that are visible to the user:

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
         * Initialize the products form
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

The form is declared using an object-oriented scheme based on the elements provided by the :doc:`forms <forms>` component.
Every element follows almost the same structure:

.. code-block:: php

    <?php

    // Create the element
    $name = new Text("name");

    // Set its label
    $name->setLabel("Name");

    // Before validating the element apply these filters
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // Apply this validators
    $name->addValidators(
        [
            new PresenceOf(
                [
                    "message" => "Name is required",
                ]
            )
        ]
    );

    // Add the element to the form
    $this->add($name);

Other elements are also used in this form:

.. code-block:: php

    <?php

    // Add a hidden input to the form
    $this->add(
        new Hidden("id")
    );

    // ...

    $productTypes = ProductTypes::find();

    // Add a HTML Select (list) to the form
    // and fill it with data from "product_types"
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

Note that :code:`ProductTypes::find()` contains the data necessary to fill the SELECT tag using :code:`Phalcon\Tag::select()`.
Once the form is passed to the view, it can be rendered and presented to the user:

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

This produces the following HTML:

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

When the form is submitted, the "search" action is executed in the controller performing the search
based on the data entered by the user.

Performing a Search
^^^^^^^^^^^^^^^^^^^
The "search" action has two behaviors. When accessed via POST, it performs a search based on the data sent from the
form but when accessed via GET it moves the current page in the paginator. To differentiate HTTP methods,
we check it using the :doc:`Request <request>` component:

.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            // Create the query conditions
        } else {
            // Paginate using the existing conditions
        }

        // ...
    }

With the help of :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, we can create the search
conditions intelligently based on the data types and values sent from the form:

.. code-block:: php

    <?php

    $query = Criteria::fromInput(
        $this->di,
        "Products",
        $this->request->getPost()
    );

This method verifies which values are different from "" (empty string) and null and takes them into account to create
the search criteria:

* If the field data type is text or similar (char, varchar, text, etc.) It uses an SQL "like" operator to filter the results.
* If the data type is not text or similar, it'll use the operator "=".

Additionally, "Criteria" ignores all the :code:`$_POST` variables that do not match any field in the table.
Values are automatically escaped using "bound parameters".

Now, we store the produced parameters in the controller's session bag:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

A session bag, is a special attribute in a controller that persists between requests using the session service.
When accessed, this attribute injects a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` instance
that is independent in each controller.

Then, based on the built params we perform the query:

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

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the
search returned results, then we create a paginator to navigate easily through them:

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

    // Get active page in the paginator
    $page = $paginator->getPaginate();

Finally we pass the returned page to view:

.. code-block:: php

    <?php

    $this->view->page = $page;

In the view (app/views/products/search.volt), we traverse the results corresponding to the current page,
showing every row in the current page to the user:

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

There are many things in the above example that worth detailing. First of all, active items
in the current page are traversed using a Volt's 'for'. Volt provides a simpler syntax for a PHP 'foreach'.

.. code-block:: html+jinja

    {% for product in page.items %}

Which in PHP is the same as:

.. code-block:: php

    <?php foreach ($page->items as $product) { ?>

The whole 'for' block provides the following:

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

Now you can go back to the view and find out what every block is doing. Every field
in "product" is printed accordingly:

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

As we seen before using :code:`product.id` is the same as in PHP as doing: :code:`$product->id`,
we made the same with :code:`product.name` and so on. Other fields are rendered differently,
for instance, let's focus in :code:`product.productTypes.name`. To understand this part,
we have to check the Products model (app/models/Products.php):

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
         * Products initializer
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

A model can have a method called :code:`initialize()`, this method is called once per request and it serves
the ORM to initialize a model. In this case, "Products" is initialized by defining that this model
has a one-to-many relationship to another model called "ProductTypes".

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

Which means, the local attribute "product_types_id" in "Products" has an one-to-many relation to
the "ProductTypes" model in its attribute "id". By defining this relationship we can access the name of
the product type by using:

.. code-block:: html+jinja

    <td>{{ product.productTypes.name }}</td>

The field "price" is printed by its formatted using a Volt filter:

.. code-block:: html+jinja

    <td>{{ "%.2f"|format(product.price) }}</td>

In plain PHP, this would be:

.. code-block:: php

    <?php echo sprintf("%.2f", $product->price) ?>

Printing whether the product is active or not uses a helper implemented in the model:

.. code-block:: php

    <td>{{ product.getActiveDetail() }}</td>

This method is defined in the model.

Creating and Updating Records
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views, the data entered by the user
is sent to the "create" and "save" actions that perform actions of "creating" and "updating" products, respectively.

In the creation case, we recover the data submitted and assign them to a new "Products" instance:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
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

Remember the filters we defined in the Products form? Data is filtered before being assigned to the object :code:`$product`.
This filtering is optional; the ORM also escapes the input data and performs additional casting according to the column types:

.. code-block:: php

    <?php

    // ...

    $name = new Text("name");

    $name->setLabel("Name");

    // Filters for name
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // Validators for name
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

When saving, we'll know whether the data conforms to the business rules and validations implemented
in the form ProductsForm form (app/forms/ProductsForm.php):

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

Finally, if the form does not return any validation message we can save the product instance:

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

Now, in the case of updating a product, we must first present the user with the data that is currently in the edited record:

.. code-block:: php

    <?php

    /**
     * Edits a product based on its id
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

The data found is bound to the form by passing the model as first parameter. Thanks to this,
the user can change any value and then sent it back to the database through to the "save" action:

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
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

We have seen how Phalcon lets you create forms and bind data from a database in a structured way.
In next chapter, we will see how to add custom HTML elements like a menu.

.. _CRUD: https://pl.wikipedia.org/wiki/CRUD
