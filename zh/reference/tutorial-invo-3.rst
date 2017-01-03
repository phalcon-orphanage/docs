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

* 如果字段日期类型是text或者类似的(char, varchar, text, 等等) 它会使用一个SQL "like" 操作符来过滤结果.
* 如果日期类型不是text或者类似的, 它将会使用操作符"=".

另外, "Criteria" 会忽略 :code:`$_POST` 所有不与表中的任何字段相匹配的变量. 值会自动避免使用"参数绑定".

现在, 我们在控制器的会话袋里存储产品参数:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

会话袋在控制器里面是一个特殊的属性, 在使用 session 服务的不同请求之间依然存在. 当访问的时候, 这个属性会注入一个 :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` 实例, 对于每个控制器来说, 这是独立的.

然后, 基于内置的参数我们执行查询:

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

如果搜索不返回一些产品, 我们再一次转发用户到 index 方法. 让我们模拟搜索返回结果, 然后我们创建一个分页来轻松的浏览他们:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as Paginator;

    // ...

    $paginator = new Paginator(
        [
            "data"  => $products,   // 分页的数据
            "limit" => 5,           // 每页的行数
            "page"  => $numberPage, // 查看的指定页
        ]
    );

    // 获取分页中当前页面
    $page = $paginator->getPaginate();

最后我们通过返回的页面来浏览:

.. code-block:: php

    <?php

    $this->view->page = $page;

在视图里面 (app/views/products/search.volt), 我们在当前页面循环相应的结果, 在当前页面给用户展示每一行记录:

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

在上面的例子中有很多东西值得详细介绍. 首先, 当前页面的记录是使用 Volt 的 'for' 循环出来的. Volt 对 PHP 的 'foreach' 提供了一个简单的语法.

.. code-block:: html+jinja

    {% for product in page.items %}

对于 PHP 来说也是一样:

.. code-block:: php

    <?php foreach ($page->items as $product) { ?>

完整的 'for' 提供了以下:

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

现在你可以返回到页面找出每个块都在做什么. 在"product"中的每个字段都有相应的输出:

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

正如我们看到的, 在之前使用 :code:`product.id` 和在PHP中使用 :code:`$product->id` 是等价的, we made the same with :code:`product.name` and so on. 其它字段都表现的有些不同, 例如, 让我们看下 :code:`product.productTypes.name`. 要理解这部分, 我们必须看一下 Products 模型 (app/models/Products.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    /**
     * 产品
     */
    class Products extends Model
    {
        // ...

        /**
         * 产品初始化
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

一个模型有一个名为 :code:`initialize()` 的方法, 这个方法在每次请求的时候调用一次兵器它服务ORM去初始化一个模型. 在这种情况话, "Products" 通过定义这个模型跟另外一个叫做 "ProductTypes" 的模型有一对多的关系从而初始化.

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

它的意思是, "Products" 的本地属性"product_types_id" 跟 "ProductTypes" 模型里面的属性 "id" 是一对多的关系. 通过定义这个关系我们可以通过如下方法来访问产品类型的名字:

.. code-block:: html+jinja

    <td>{{ product.productTypes.name }}</td>

字段 "price" 使用一个 Volt 过滤器来格式化输出:

.. code-block:: html+jinja

    <td>{{ "%.2f"|format(product.price) }}</td>

在原生PHP中, 它将是这样的:

.. code-block:: php

    <?php echo sprintf("%.2f", $product->price) ?>

使用模型中已经实现的帮助者函数来输出产品是否是有效的:

.. code-block:: php

    <td>{{ product.getActiveDetail() }}</td>

这个方法在模型中定义了.

创建和更新记录(Creating and Updating Records)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
现在, 让我们看看 CRUD 如何创建和更新记录. 从 "new" 和 "edit" 视图, 通过用户输入的数据发送 "create" 和 "save" 方法从而分别执行 "creating" 和 "updating" 产品的方法.

在创建的情况下, 我们提取提交的数据然后分配它们到一个新的 "Products" 实例:

.. code-block:: php

    <?php

    /**
     * 基于在 "new" 方法中输入的数据创建一个产品
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

还记得我们在产品表单中定义的过滤器吗? 数据在开始分配到 :code:`$product` 对象前进行过滤. 这个过滤器是可选的; ORM同样也会转义输入的数据和根据列类型执行附加的转换:

.. code-block:: php

    <?php

    // ...

    $name = new Text("name");

    $name->setLabel("Name");

    // 过滤 name
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // 验证 name
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

当保存的时候, 我们就会知道 ProductsForm (app/forms/ProductsForm.php) 表单提交的数据是否否则业务规则和实现的验证:

.. code-block:: php

    <?php

    // ...

    $form = new ProductsForm();

    $product = new Products();

    // V验证输入
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

最后, 如果表单没有返回任何验证消息, 我们就可以保存产品实例了:

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

现在, 在更新产品的情况下, 我们必须先将当前编辑的记录展示给用户:

.. code-block:: php

    <?php

    /**
     * 基于它的id编辑一个产品
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

通过将模型作为第一个参数传递过去找出被绑定到表单的数据. 多亏了这个, 用户可以改变任何值, 然后通过 "save" 方法发送它到数据库:

.. code-block:: php

    <?php

    /**
     * 在 "edit"方法中基于输入的数据更新一个产品
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

我们已经看到 Phalcon 如何以一种结构化的方式让你创建表单和从一个数据库中绑定数据. 在下一章, 我们将会看到如何添加自定义 HTML 元素, 比如一个菜单.

.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
