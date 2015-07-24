Tutorial 4: Using CRUDs
=======================
Backends usually provides forms to allow users to manipulate data. Continuing the explanation of
INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you
using forms, validations, paginators and more.

Trabajando con CRUDs
--------------------
La mayor parte de opciones que manipulan datos (compañias, productos y tipos de productos), han sido desarrollados
usando un básico y común CRUD_ (Create, Read, Update and Delete). Cada CRUD contiene los siguientes archivos:

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
Cada CRUD inicia con un formulario de búsqueda. Este formulario muestra cada campo que tiene la tabla (productos),
permitiendo al usuario crear un criterio de búsqueda por cada campo. La tabla "productos" tiene una relación
a la tabla "product_types". En este caso, previamente consultamos los registros en esta tabla para facilitar al usuario
su búsqueda por este campo.

.. code-block:: php

    <?php

    /**
     * La acción de inicio, permite buscar productos
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

Todos los tipos de productos son consultados y pasados a la vista como una variable local $productTypes. Luego,
en la vista (app/views/index.phtml) mostramos una etiqueta "select" llena con esos datos:

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

Fijate que $productTypes contiene todos los datos necesarios para llenar la etiqueta SELECT usando Phalcon\\Tag::select.
Una vez el formulario es enviado, la acción "search" es ejecutada en el controlado realizando la búsqueda basada en los parámetros entrados
por el usuario.

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

    $query = Criteria::fromInput($this->di, "Products", $_POST);

Este método verifica que valores son diferentes a "" (cadena vacia) y nulo y los toma en cuenta para crear el criterio de búsqueda

* Si el campo tiene un tipo de dato de texto o similar (char, varchar, text, etc.) Usa el operador SQL "like" para filtrar los resultados
* Si el tipo de dato no es texto, entonces usará el operador "="

Adicionalmente, "Criteria" ignora todas las variables $_POST que no correspondan a campos en la tabla.
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
    if (count($products) == 0) {
        $this->flash->notice("No se encontraron productos para la búsqueda realizada.");
        return $this->forward("products/index");
    }

Si la búsqueda no retorna ningún producto, redireccionamos al usuario a la vista de inicio nuevamente.
Supongamos que retornó registros, entonces creamos un páginador para navegar fácilmente a través de ellos:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    // Data to paginate
        "limit" => 5,           // Rows per page
        "page" => $numberPage   // Active page
    ));

    // Obtener la página activa
    $page = $paginator->getPaginate();

Finalmente pasamos la página devuelta a la vista:

.. code-block:: php

    <?php

    $this->view->page = $page;

En la vista (app/views/products/search.phtml), recorremos los resultados correspondientes de la página actual:

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

Creando y Actualizando Registros
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Ahora vemos como en un CRUD se puede crear y actualizar registros. Desde las vistas "new" y "edit" los datos
son ingresados por el usuario y enviados a las acciones "create" y "save" que realizan las acciones de crear y
actualizar productos respectivamente.

En el caso de creación, recuperamos los datos enviados y los asignamos a una nueva instancia de "Products":

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

Los datos son filtrados antes de ser asignados al objeto. Realizar este filtrado es opcional, el ORM escapa los datos
de entrada y realiza conversiones de tipos de dato antes de guardar. Sin embargo, es recomendable para asegurarnos
que la entrada no contiene caracteres basura ó invalidos.

Al guardar, sabremos si los datos cumplen con las reglas de negocio y validaciones adicionales implementadas en el modulo Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        // ...

        if (!$products->create()) {

            // Guardar falló, mostrar los mensajes
            foreach ($products->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->forward("products/new");
        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

Ahora, en el caso de la actualización, primero debemos presentar al usuario los datos correspondientes al registro editado:

.. code-block:: php

    <?php

    /**
     * Muestra la vista para editar un producto existente
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

El método "Tag::setDefault" nos permite asignar un valor predeterminado a un atributo con el mismo nombre en la forma.
Gracias a esto, un usuario puede cambiar cualquier valor y luego enviarlo de vuelta a la base de datos usando la acción "save":

.. code-block:: php

    <?php

    /**
     * Actualiza un producto basado en los datos ingresados en la acción "edit"
     */
    public function saveAction()
    {

        // ...

        // Buscar el producto a actualizar
        $product = Products::findFirstById($this->request->getPost("id"));
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        // ... asignar los valores al objeto y guardar

    }

We have seen how Phalcon lets you create forms and bind data from a database in a structured way.
In next chapter, we will see how to add custom HTML elements like a menu.

.. _Jinja: http://jinja.pocoo.org/
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
