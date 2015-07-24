Tutorial 4: Using CRUDs
=======================
Backends usually provides forms to allow users to manipulate data. Continuing the explanation of
INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you
using forms, validations, paginators and more.

Работа с CRUD
-------------
Большинство функционала, требующего манипуляции данными (компании, товары и типы товаров), разрабатывается с использованием простого и стандартного CRUD_ (Create, Read, Update и Delete). Каждый CRUD содержит примерно следующие файлы:

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

Каждый контроллер реализует следующие действия:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * Начальное действие, которое позволяет отправить запрос к "search".
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Выполняет "search" на основание критериев, отправленных с "index".
         * Возвращает результаты с пагинацией.
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Отображает форму создания нового продукта ("new").
         */
        public function newAction()
        {
            // ...
        }

        /**
         * Отображает форму для редактирование существующего продукта
         */
        public function editAction()
        {
            // ...
        }

        /**
         * Создает продукт согласно данным, которые были заданы действием "new".
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Изменяет продукт согласно данным, которые были заданы действием "edit".
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Удаляет существующий продукт.
         */
        public function deleteAction($id)
        {
            // ...
        }

    }

Форма поиска
^^^^^^^^^^^^
Каждый CRUD начинается с формы поиска. Эта форма показывает все столбцы таблицы (products), позволяющие
пользователю задавать поисковые критерии по любому полю. Таблица "products" связана с таблицей "products_types".
Поэтому мы предварительно запрашиваем записи этой последней таблицы, чтобы предложить их для поиска по
соответствующему полю:

.. code-block:: php

    <?php

    /**
     * Начальное действие, которое отображает представление "search".
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

Все "типы продуктов" запрашиваются и выдаются в представление, как локальная переменная "productTypes". Затем,
в самом представлении (app/views/index.phtml) мы выводим тег "select", содержащий эти результаты:

.. code-block:: html+php

    <div>
        <label for="product_types_id">Тип продукта</label>
        <?php echo $this->tag->select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Заметим, что $productTypes содержит в себе данные, заполняющие тег SELECT посредством Phalcon\\Tag::select.
При сабмите формы выполняется действие "search" описанного выше контроллера, которое производит поиск на
основании введенных пользователем данных.

Выполнение поиска
^^^^^^^^^^^^^^^^^
Действие "search" имеет двойственное поведение. В случае POST-запроса оно выполняет поиск на основе данных,
полученных с формы. А в случае GET-запроса оно меняет текущую страницу пагинатора. Чтобы различить эти два метода HTTP,
мы используем компонент :doc:`Request <request>`:

.. code-block:: php

    <?php

    /**
     * Выполняет поиск на основе критериев, полученных из "index".
     * Возвращает пагинатор результатов.
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            // формируем условия запроса
        } else {
            // создаем страницу соответственно существующим условиям
        }

        // ...

    }

С помощью :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` мы можем интеллектульно создать
условия поиска на основе типов данных и значений, полученных с формы:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

Этот метод проверяет все значения, отличные от "" (пустой строки) и null, а затем использует их для создания критериев поиска:

* В случае текстового типа данных (char, varchar, text и т.д.), для фильтрации результатов поиска он использует оператор SQL "like".
* В противном случае он будет использовать оператор "=".

Кроме того, "Criteria" игнорирует все переменные $_POST, которые не соответствуют полям таблицы.
Значения автоматически эскейпируются с помощью "биндинга параметров".

Теперь сохраним созданные параметры в разделе сессии, предназначенном нашему контроллеру (сессионная сумка):

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Сессионная сумка - это специальный атрибут контроллера, значение которого сохраняется между запросами. При обращении к нему,
в него инъецируется сервис :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`, отдельный для каждого контроллера.

Теперь выполним запрос, основываясь на собранных параметрах:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("Поиск не нашел никаких продуктов");
        return $this->forward("products/index");
    }

Если поиск не вернул ни одного продукта, мы снова перенаправляем пользователся на действие index.
Если же поиск что-то находит, то создадим пагинатор для облегчения навигации по ним:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    // Данные для пагинации
        "limit" => 5,           // Число строк на страницу
        "page" => $numberPage   // Активная страница
    ));

    // Получение активной страницы пагинатора
    $page = $paginator->getPaginate();

Передадим, наконец, полученную страницу на вывод:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

В представлении (app/views/products/search.phtml) мы выводим результаты, соответствующие текущей странице:

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= $this->tag->linkTo("products/edit/" . $product->id, 'Редактировать') ?></td>
            <td><?= $this->tag->linkTo("products/delete/" . $product->id, 'Удалить') ?></td>
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

Creating and Updating Records
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views the data entered by the user
are sent to the actions "create" and "save" that perform actions of "creating" and "updating" products respectively.

In the creation case, we recover the data submitted and assign them to a new "products" instance:

.. code-block:: php

    <?php

    /**
     * Creates a new product
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("products/index");
        }

        $form    = new ProductsForm;
        $product = new Products();

        // ...
    }

Remember the filters we defined in the Products form? Data is filtered before being assigned to the object $product.
This filtering is optional, also the ORM escapes the input data and performs additional casting according to the column types:

.. code-block:: php

    <?php

    // ...

    $name = new Text("name");
    $name->setLabel("Name");

    // Filters for name
    $name->setFilters(array('striptags', 'string'));

    // Validators for name
    $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name is required'
            ))
    ));

    $this->add($name);

When saving we'll know whether the data conforms to the business rules and validations implemented
in the form ProductsForm (app/forms/ProductsForm.php):

.. code-block:: php

    <?php

    // ...

    $form    = new ProductsForm;
    $product = new Products();

    // Validate the input
    $data = $this->request->getPost();
    if (!$form->isValid($data, $product)) {
        foreach ($form->getMessages() as $message) {
            $this->flash->error($message);
        }
        return $this->forward('products/new');
    }

Finally, if the form does not return any validation message we can save the product instance:

.. code-block:: php

    <?php

    // ...

    if ($product->save() == false) {
        foreach ($product->getMessages() as $message) {
            $this->flash->error($message);
        }
        return $this->forward('products/new');
    }

    $form->clear();

    $this->flash->success("Product was created successfully");
    return $this->forward("products/index");

Now, in the case of product updating, first we must present to the user the data that is currently in the edited record:

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
                $this->flash->error("Product was not found");
                return $this->forward("products/index");
            }

            $this->view->form = new ProductsForm($product, array('edit' => true));
        }
    }

The data found is bound to the form passing the model as first parameter. Thanks to this,
the user can change any value and then sent it back to the database through to the "save" action:

.. code-block:: php

    <?php

    /**
     * Saves current product in screen
     *
     * @param string $id
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("products/index");
        }

        $id = $this->request->getPost("id", "int");
        $product = Products::findFirstById($id);
        if (!$product) {
            $this->flash->error("Product does not exist");
            return $this->forward("products/index");
        }

        $form = new ProductsForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('products/new');
        }

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('products/new');
        }

        $form->clear();

        $this->flash->success("Product was updated successfully");
        return $this->forward("products/index");
    }

We have seen how Phalcon lets you create forms and bind data from a database in a structured way.
In next chapter, we will see how to add custom HTML elements like a menu.

.. _Jinja: http://jinja.pocoo.org/
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
