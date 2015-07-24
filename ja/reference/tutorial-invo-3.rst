Tutorial 4: Using CRUDs
=======================
Backends usually provides forms to allow users to manipulate data. Continuing the explanation of
INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you
using forms, validations, paginators and more.

CRUDを使用した作業
---------------------
Most options that manipulate data (companies, products and types of products), were developed using a basic and
common CRUD_ (Create, Read, Update and Delete). Each CRUD contains the following files:

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

検索フォーム
^^^^^^^^^^^^^^^
Every CRUD starts with a search form. This form shows each field that has the table (products), allowing the user
creating a search criteria from any field. Table "products" has a relationship to the table "products_types".
In this case, we previously queried the records in this table in order to facilitate the search by that field:

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

An instance of the form ProductsForm (app/forms/ProductsForm.php) is passed to the view.
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
        public function initialize($entity = null, $options = array())
        {

            if (!isset($options['edit'])) {
                $element = new Text("id");
                $this->add($element->setLabel("Id"));
            } else {
                $this->add(new Hidden("id"));
            }

            $name = new Text("name");
            $name->setLabel("Name");
            $name->setFilters(array('striptags', 'string'));
            $name->addValidators(array(
                new PresenceOf(array(
                    'message' => 'Name is required'
                ))
            ));
            $this->add($name);

            $type = new Select('profilesId', ProductTypes::find(), array(
                'using'      => array('id', 'name'),
                'useEmpty'   => true,
                'emptyText'  => '...',
                'emptyValue' => ''
            ));
            $this->add($type);

            $price = new Text("price");
            $price->setLabel("Price");
            $price->setFilters(array('float'));
            $price->addValidators(array(
                new PresenceOf(array(
                    'message' => 'Price is required'
                )),
                new Numericality(array(
                    'message' => 'Price is required'
                ))
            ));
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
    $name->setFilters(array('striptags', 'string'));

    // Apply this validators
    $name->addValidators(array(
        new PresenceOf(array(
            'message' => 'Name is required'
        ))
    ));

    // Add the element to the form
    $this->add($name);

Other elements are also used in this form:

.. code-block:: php

    <?php

    // Add a hidden input to the form
    $this->add(new Hidden("id"));

    // ...

    // Add a HTML Select (list) to the form
    // and fill it with data from "product_types"
    $type = new Select('profilesId', ProductTypes::find(), array(
        'using'      => array('id', 'name'),
        'useEmpty'   => true,
        'emptyText'  => '...',
        'emptyValue' => ''
    ));

Note that ProductTypes::find() contains the data necessary to fill the SELECT tag using Phalcon\\Tag::select.
Once the form is passed to the view, it can be rendered and presented to the user:

.. code-block:: html+jinja

    {{ form("products/search") }}

    <h2>Search products</h2>

    <fieldset>

        {% for element in form %}
            <div class="control-group">
                {{ element.label(['class': 'control-label']) }}
                <div class="controls">{{ element }}</div>
            </div>
        {% endfor %}

        <div class="control-group">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </fieldset>

This produces the following HTML:

.. code-block:: html

    <form action="/invo/products/search" method="post">

    <h2>Search products</h2>

    <fieldset>

        <div class="control-group">
            <label for="id" class="control-label">Id</label>
            <div class="controls"><input type="text" id="id" name="id" /></div>
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
            <div class="controls"><input type="text" id="price" name="price" /></div>
        </div>

        <div class="control-group">
            <input type="submit" value="Search" class="btn btn-primary" />
        </div>

    </fieldset>

When the form is submitted, the action "search" is executed in the controller performing the search
based on the data entered by the user.

検索の実行
^^^^^^^^^^^^^^^^^^^
The action "search" has a dual behavior. When accessed via POST, it performs a search based on the data sent from the
form. But when accessed via GET it moves the current page in the paginator. To differentiate one from another HTTP method,
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
            // create the query conditions
        } else {
            // paginate using the existing conditions
        }

        // ...

    }

With the help of :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, we can create the search
conditions intelligently based on the data types and values sent from the form:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

This method verifies which values are different from "" (empty string) and null and takes them into account to create
the search criteria:

* If the field data type is text or similar (char, varchar, text, etc.) It uses an SQL "like" operator to filter the results.
* If the data type is not text or similar, it'll use the operator "=".

Additionally, "Criteria" ignores all the $_POST variables that do not match any field in the table.
Values are automatically escaped using "bound parameters".

Now, we store the produced parameters in the controller's session bag:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

A session bag, is a special attribute in a controller that persists between requests. When accessed, this attribute injects
a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` service that is independent in each controller.

Then, based on the built params we perform the query:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the
search returned results, then we create a paginator to navigate easily through them:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    // Data to paginate
        "limit" => 5,           // Rows per page
        "page" => $numberPage   // Active page
    ));

    // Get active page in the paginator
    $page = $paginator->getPaginate();

Finally we pass the returned page to view:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

In the view (app/views/products/search.phtml), we traverse the results corresponding to the current page:

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= $this->tag->linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= $this->tag->linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

There are many things in the above example that worth detailing. First of all, active items
in the current page are traversed using a Volt's 'for'. Volt provides a simpler syntax for a PHP 'foreach'.

.. code-block:: html+jinja

    {% for product in page.items %}

Which in PHP is the same as:

.. code-block:: php

    <?php foreach ($page->items as $product) { ?>

The whole 'for' block provides the following:

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
        <td>{{ product.id }}</td>
        <td>{{ product.productTypes.name }}</td>
        <td>{{ product.name }}</td>
        <td>{{ "%.2f"|format(product.price) }}</td>
        <td>{{ product.getActiveDetail() }}</td>
        <td width="7%">{{ link_to("products/edit/" ~ product.id, 'Edit') }}</td>
        <td width="7%">{{ link_to("products/delete/" ~ product.id, 'Delete') }}</td>
      </tr>

As we seen before using product.id is the same as in PHP as doing: $product->id,
we made the same with product.name and so on. Other fields are rendered differently,
for instance, let's focus in product.productTypes.name. To understand this part,
we have to check the model Products (app/models/Products.php):

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
            $this->belongsTo('product_types_id', 'ProductTypes', 'id', array(
                'reusable' => true
            ));
        }

        // ...
    }

A model, can have a method called "initialize", this method is called once per request and it serves
the ORM to initialize a model. In this case, "Products" is initialized by defining that this model
has a one-to-many relationship to another model called "ProductTypes".

.. code-block:: php

    <?php

    $this->belongsTo('product_types_id', 'ProductTypes', 'id', array(
        'reusable' => true
    ));

Which means, the local attribute "product_types_id" in "Products" has an one-to-many relation to
the model "ProductTypes" in its attribute "id". By defining this relation we can access the name of
the product type by using:

.. code-block:: html+jinja

    <td>{{ product.productTypes.name }}</td>

The field "price" is printed by its formatted using a Volt filter:

.. code-block:: html+jinja

    <td>{{ "%.2f"|format(product.price) }}</td>

What in PHP would be:

.. code-block:: php

    <?php echo sprintf("%.2f", $product->price) ?>

Printing whether the product is active or not uses a helper implemented in the model:

.. code-block:: php

    <td>{{ product.getActiveDetail() }}</td>

This method is defined in the model:

レコードの登録と更新
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views the data entered by the user
are sent to the actions "create" and "save" that perform actions of "creating" and "updating" products respectively.

In the creation case, we recover the data submitted and assign them to a new "products" instance:

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

Data is filtered before being assigned to the object. This filtering is optional, the ORM escapes the input data and
performs additional casting according to the column types.

When saving we'll know whether the data conforms to the business rules and validations implemented in the model Products:

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

Now, in the case of product updating, first we must present to the user the data that is currently in the edited record:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        // ...

        $product = Products::findFirstById($id);

        $this->tag->setDefault("id", $product->id);
        $this->tag->setDefault("product_types_id", $product->product_types_id);
        $this->tag->setDefault("name", $product->name);
        $this->tag->setDefault("price", $product->price);
        $this->tag->setDefault("active", $product->active);

    }

The "setDefault" helper sets a default value in the form on the attribute with the same name. Thanks to this,
the user can change any value and then sent it back to the database through to the "save" action:

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        // ...

        // Find the product to update
        $id = $this->request->getPost("id");
        $product = Products::findFirstById($id);
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
