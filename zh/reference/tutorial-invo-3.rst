教程4: 使用CRUD(Tutorial 4: Working with the CRUD)
=================================

后台通常提供表单来允许用户提交数据. 继续对INVO的解释, 我们现在处理CRUD的创建, 一个非常常见的操作任务, Phalcon将会帮助你使用表单, 校验, 分页和更多.

在INVO(公司, 产品和产品类型)中大部分选项操作数据都是使用一个基础的常见的 CRUD_ (创建, 读取, 更新和删除)开发的. 每个CRUD包含以下文件:

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

每个控制器都有以下方法:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        /**
         * 开始操作, 它展示"search"视图
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * 基于从"index"发送过来的条件处理"search"
         * 返回一个分页结果
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * 展示创建一个"new"(新)产品的视图
         */
        public function newAction()
        {
            // ...
        }

        /**
         * 展示编辑一个已存在"edit"(编辑)产品的视图
         */
        public function editAction()
        {
            // ...
        }

        /**
         * 基于"new"方法中输入的数据创建一个产品
         */
        public function createAction()
        {
            // ...
        }

        /**
         * 基于"edit"方法中输入的数据更新一个产品
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * 删除一个已存在的产品
         */
        public function deleteAction($id)
        {
            // ...
        }
    }

表单搜索(The Search Form)
^^^^^^^^^^^^^^^
每个 CRUD 都开始于一个搜索表单. 这个表单展示了表(products)中的每个字段, 允许用户为一些字段创建一个搜索条件. 表 "products" 和表 "products_types" 是关系表. 既然这样, 我们先前查询表中的记录以便于字段的搜索:

.. code-block:: php

    <?php

    /**
     * 开始操作, 它展示"search"视图
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;

        $this->view->form = new ProductsForm();
    }

ProductsForm 表单的实例 (app/forms/ProductsForm.php)传递给了视图. 这个表单定义了用户可见的字段:

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
         * 初始化产品表单
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

表单是使用面向对象的方式声明的, 基于 :doc:`forms <forms>` 组件提供的元素. 每个元素都遵循近乎相同的结构:

.. code-block:: php

    <?php

    // 创建一个元素
    $name = new Text("name");

    // 设置它的label
    $name->setLabel("Name");

    // 在验证元素之前应用这些过滤器
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // 应用此验证
    $name->addValidators(
        [
            new PresenceOf(
                [
                    "message" => "Name is required",
                ]
            )
        ]
    );

    // 增加元素到表单
    $this->add($name);

在表单中其它元素也是这样使用:

.. code-block:: php

    <?php

    // 增加一个隐藏input到表单
    $this->add(
        new Hidden("id")
    );

    // ...

    $productTypes = ProductTypes::find();

    // 增加一个HTML Select (列表) 到表单
    // 数据从"product_types"中填充
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

注意, :code:`ProductTypes::find()` 包含的必须的数据 使用 :code:`Phalcon\Tag::select()` 来填充 SELECT 标签. 一旦表单传递给视图, 它会进行渲染并呈现给用户:

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

这会生成下面的HTML:

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

当表单提交的时候, 控制器里面的"search"操作是基于用户输入的数据执行搜索的.

执行搜索(Performing a Search)
^^^^^^^^^^^^^^^^^^^
"search"操作有两个行为. 当通过POST访问, 它基于表单发送的数据执行搜索, 但是当通过GET访问它会在分页中移动当前的页数. 为了区分HTTP方法,我们使用  :doc:`Request <request>` 组件进行校验:

.. code-block:: php

    <?php

    /**
     * 基于从"index"发送过来的条件处理"search"
     * 返回一个分页结果
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            // 创建查询条件
        } else {
            // 使用已存在的条件分页
        }

        // ...
    }

在 :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` 的帮助下, 我们基于从表单发送来的数据类型和值创建智能的搜索条件:

.. code-block:: php

    <?php

    $query = Criteria::fromInput(
        $this->di,
        "Products",
        $this->request->getPost()
    );

这个方法验证值 "" (空字符串) 和值 null 的区别并考虑到这些来创建搜索条件:

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

.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
