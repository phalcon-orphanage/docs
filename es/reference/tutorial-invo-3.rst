Tutorial 4: Trabajando con CRUDs
================================

Backends usually provide forms to allow users to manipulate data. Continuing the explanation of
INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you
using forms, validations, paginators and more.

La mayor parte de opciones que manipulan datos (compañias, productos y tipos de productos), han sido desarrollados
usando un básico y común CRUD_ (Create, Read, Update and Delete). Cada CRUD contiene los siguientes archivos:

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

Cada controlador implementa las siguientes acciones:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        /**
         * La acción de inicio, permite buscar productos
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Realiza la búsqueda basada en los parámetros de usuario
         * devolviendo un paginador
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Muestra la vista de crear nuevos productos
         */
        public function newAction()
        {
            // ...
        }

        /**
         * Muestra la vista para editar productos existentes
         */
        public function editAction()
        {
            // ...
        }

        /**
         * Crea un nuevo producto basado en los datos ingresados en la acción "new"
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Actualiza un producto basado en los datos ingresados en la acción "edit"
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Elimina un producto existente
         */
        public function deleteAction($id)
        {
            // ...
        }
    }

Formulario de Buscar
^^^^^^^^^^^^^^^^^^^^
Cada CRUD inicia con un formulario de búsqueda. Este formulario muestra cada campo que tiene la tabla (productos), permitiendo al usuario
crear un criterio de búsqueda por cada campo. La tabla "productos" tiene una relación a la tabla "product_types".
En este caso, previamente consultamos los registros en esta tabla para facilitar al usuario su búsqueda por este campo:

.. code-block:: php

    <?php

    /**
     * La acción de inicio, permite buscar productos
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

Realizando una búsqueda
^^^^^^^^^^^^^^^^^^^^^^^
La acción "search" tiene un doble objetivo. Cuando es accedida via POST, realiza una búsqueda basada en los parámetros
ingresados por el usuario y cuando se accede via GET mueve la pagína actual en el paginador. Para diferenciar un método del
otro usamos el componente :doc:`Request <request>`:

.. code-block:: php

    <?php

    /**
     * Realiza la búsqueda basada en los parámetros de usuario
     * devolviendo un paginador
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            // Crear las condiciones de búsqueda
        } else {
            // Paginar usando las condiciones existentes
        }

        // ...
    }

Con la ayuda de :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, podemos crear una búsqueda
de manera inteligente basada en los tipos de datos enviados en el formulario:

.. code-block:: php

    <?php

    $query = Criteria::fromInput(
        $this->di,
        "Products",
        $this->request->getPost()
    );

Este método verifica que valores son diferentes a "" (cadena vacia) y nulo y los toma en cuenta para crear el criterio
de búsqueda:

* Si el campo tiene un tipo de dato de texto o similar (char, varchar, text, etc.) Usa el operador SQL "like" para filtrar los resultados.
* Si el tipo de dato no es texto, entonces usará el operador "=".

Adicionalmente, "Criteria" ignora todas las variables :code:`$_POST` que no correspondan a campos en la tabla.
Los valores son automáticamente escapados usando "bound parameters" evitando inyecciones de SQL.

Ahora, almacenamos los parametros producidos en la bolsa de datos de sesión del controlador:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Una bolsa de sesión, es un atributo especial en un controlador que es persistente entre peticiones.
Al ser accedido, este atributo es inyectado con un servicio :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
que es independiente por controlador/clase.

Luego, basado en los parámetros construidos anteriormente:

.. code-block:: php

    <?php

    $products = Products::find($parameters);

    if (count($products) === 0) {
        $this->flash->notice(
            "No se encontraron productos para la búsqueda realizada."
        );

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
    }

Si la búsqueda no retorna ningún producto, redireccionamos al usuario a la vista de inicio nuevamente. Supongamos que
retornó registros, entonces creamos un páginador para navegar fácilmente a través de ellos:

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

    // Obtener la página activa
    $page = $paginator->getPaginate();

Finalmente pasamos la página devuelta a la vista:

.. code-block:: php

    <?php

    $this->view->page = $page;

En la vista (app/views/products/search.volt), recorremos
los resultados correspondientes de la página actual:

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

Creando y Actualizando Registros
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Ahora vemos como en un CRUD se puede crear y actualizar registros. Desde las vistas "new" y "edit" los datos son ingresados por el usuario
y enviados a las acciones "create" y "save" que realizan las acciones de crear y actualizar productos respectivamente.

En el caso de creación, recuperamos los datos enviados y los asignamos a una nueva instancia de "Products":

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

Ahora, en el caso de la actualización, primero debemos presentar al usuario los datos correspondientes al registro editado:

.. code-block:: php

    <?php

    /**
     * Muestra la vista para editar un producto existente
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

The data found is bound to the form passing the model as first parameter. Gracias a esto,
un usuario puede cambiar cualquier valor y luego enviarlo de vuelta a la base de datos usando la acción "save":

.. code-block:: php

    <?php

    /**
     * Actualiza un producto basado en los datos ingresados en la acción "edit"
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

.. _CRUD: https://es.wikipedia.org/wiki/CRUD
