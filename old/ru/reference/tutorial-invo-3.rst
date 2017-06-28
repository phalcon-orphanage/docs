Урок 4: Работа с CRUD
=====================

Бэкенд обычно предоставляет формы, позволяющие пользователям работать с данными. Продолжая объяснение
INVO, мы подходим к созданию CRUD, очень распространенной задаче, которую Phalcon упростит
с помощью форм, валидации, пагинаторов и так далее.

Большинство функционала, требующего манипуляции данными (компании, товары и типы товаров), разрабатывается
с использованием простого и стандартного CRUD_ (Create, Read, Update и Delete). Каждый CRUD содержит примерно следующие файлы:

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

Каждый контроллер реализует следующие действия:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {
        /**
         * Начальное действие, которое позволяет отправить запрос к "search"
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Выполняет поиск на основании критериев, отправленных с "index"
         * Возвращает результаты с пагинацией
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Отображает форму создания нового продукта
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
         * Создает продукт на основе данных, введенных в действии "new"
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Изменяет продукт на основе данных, введенных в действии "edit"
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Удаляет существующий продукт
         */
        public function deleteAction($id)
        {
            // ...
        }
    }

Форма поиска
^^^^^^^^^^^^
Каждый CRUD начинается с формы поиска. Эта форма показывает все столбцы таблицы (products), позволяющие пользователю
задавать поисковые критерии по любому полю. Таблица "products" связана с таблицей "products_types".
Поэтому мы предварительно запрашиваем записи этой последней таблицы, чтобы предложить их для поиска по соответствующему полю:

.. code-block:: php

    <?php

    /**
     * Начальное действие, которое отображает представление "search"
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;

        $this->view->form = new ProductsForm();
    }

Экземпляр формы ProductsForm (app/forms/ProductsForm.php) передается в представление.
Эта форма определяет поля, видимые пользователю:

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
         * Инициализация формы
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

            $name->setLabel("Название");

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
                            "message" => "Название обязательно",
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

            $price->setLabel("Цена");

            $price->setFilters(
                [
                    "float",
                ]
            );

            $price->addValidators(
                [
                    new PresenceOf(
                        [
                            "message" => "Цена обязательна",
                        ]
                    ),
                    new Numericality(
                        [
                            "message" => "Цена обязательна",
                        ]
                    ),
                ]
            );

            $this->add($price);
        }
    }

Форма определена в объектно-ориентированном стиле, основываясь на элементах, предоставляемых компонентом :doc:`forms <forms>`.
Каждый элемент следует почти одной и той же структуре:

.. code-block:: php

    <?php

    // Создаем элемент
    $name = new Text("name");

    // Устанавливаем лейбл
    $name->setLabel("Название");

    // Перед валидацией применяем эти фильтры
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // Применяем валидаторы
    $name->addValidators(
        [
            new PresenceOf(
                [
                    "message" => "Название обязательно",
                ]
            )
        ]
    );

    // Добавляем элемент в форму
    $this->add($name);

Другие элементы также используются в форме:

.. code-block:: php

    <?php

    // Добавляем скрытое поле в форму
    $this->add(
        new Hidden("id")
    );

    // ...

    $productTypes = ProductTypes::find();

    // Добавляем HTML Select (список) в форму
    // и заполняем его данными из "product_types"
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

Заметьте, что :code:`ProductTypes::find()` содержит данные, необходимые для заполнения тега SELECT с помощью :code:`Phalcon\Tag::select()`.
После передачи формы представлению, она может быть показана пользователю:

.. code-block:: html+jinja

    {{ form("products/search") }}

        <h2>
            Поиск продуктов
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

Это генерирует следующий HTML:

.. code-block:: html

    <form action="/invo/products/search" method="post">

        <h2>
            Поиск продуктов
        </h2>

        <fieldset>

            <div class="control-group">
                <label for="id" class="control-label">Id</label>

                <div class="controls">
                    <input type="text" id="id" name="id" />
                </div>
            </div>

            <div class="control-group">
                <label for="name" class="control-label">Название</label>

                <div class="controls">
                    <input type="text" id="name" name="name" />
                </div>
            </div>

            <div class="control-group">
                <label for="profilesId" class="control-label">profilesId</label>

                <div class="controls">
                    <select id="profilesId" name="profilesId">
                        <option value="">...</option>
                        <option value="1">Овощи</option>
                        <option value="2">Фрукты</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="price" class="control-label">Цена</label>

                <div class="controls">
                    <input type="text" id="price" name="price" />
                </div>
            </div>



            <div class="control-group">
                <input type="submit" value="Search" class="btn btn-primary" />
            </div>

        </fieldset>

    </form>

Когда форма отправлена, в контроллере выполняется действие "search", производя поиск
на основе данных, введенных пользователем.

Выполнение поиска
^^^^^^^^^^^^^^^^^
Действие "search" имеет двойственное поведение. В случае POST-запроса оно выполняет поиск на основе данных, полученных с
формы. А в случае GET-запроса оно меняет текущую страницу пагинатора. Чтобы различить эти два HTTP метода,
мы используем компонент :doc:`Request <request>`:

.. code-block:: php

    <?php

    /**
     * Выполняет поиск на основе критериев, отправленных с "index"
     * Возвращает пагинатор результатов
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            // Формируем условия запроса
        } else {
            // Создаем страницу соответственно существующим условиям
        }

        // ...
    }

С помощью :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` мы можем создать условия поиска
на основе типов данных и значений, полученных с формы:

.. code-block:: php

    <?php

    $query = Criteria::fromInput(
        $this->di,
        "Products",
        $this->request->getPost()
    );

Этот метод проверяет все значения, отличные от "" (пустой строки) и null, а затем использует их для создания
критериев поиска:

* В случае текстового типа данных (char, varchar, text и т.д.), для фильтрации результатов поиска он использует оператор SQL "like".
* В противном случае он будет использовать оператор "=".

Кроме того, "Criteria" игнорирует все переменные :code:`$_POST`, которые не соответствуют полям таблицы.
Значения автоматически экранируются с помощью "связанных параметров".

Теперь сохраним созданные параметры в разделе сессии, предназначенном нашему контроллеру (сессионная сумка):

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Сессионная сумка - это специальный атрибут контроллера, значение которого сохраняется между запросами.
При обращении к нему, в него внедряется сервис :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`,
отдельный для каждого контроллера.

Теперь выполним запрос, основываясь на собранных параметрах:

.. code-block:: php

    <?php

    $products = Products::find($parameters);

    if (count($products) === 0) {
        $this->flash->notice(
            "Поиск не нашел никаких продуктов"
        );

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
    }

Если поиск не вернул ни одного продукта, мы снова перенаправляем пользователся на действие index. Если же
поиск что-то находит, то создаем пагинатор для облегчения навигации по ним:

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model as Paginator;

    // ...

    $paginator = new Paginator(
        [
            "data"  => $products,   // Данные для пагинации
            "limit" => 5,           // Количество записей на страницу
            "page"  => $numberPage, // Активная страница
        ]
    );

    // Получаем активную страницу пагинатора
    $page = $paginator->getPaginate();

Передадим, наконец, полученную страницу на вывод:

.. code-block:: php

    <?php

    $this->view->page = $page;

В представлении (app/views/products/search.volt) мы выводим результаты, соответствующие текущей странице,
отображая каждую строку пользователю:

.. code-block:: html+jinja

    {% for product in page.items %}
        {% if loop.first %}
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Тип продукта</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Активен</th>
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
                {{ link_to("products/edit/" ~ product.id, "Редактировать") }}
            </td>

            <td width="7%">
                {{ link_to("products/delete/" ~ product.id, "Удалить") }}
            </td>
        </tr>

        {% if loop.last %}
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="7">
                            <div>
                                {{ link_to("products/search", "Первая") }}
                                {{ link_to("products/search?page=" ~ page.before, "Предыдущая") }}
                                {{ link_to("products/search?page=" ~ page.next, "Следующая") }}
                                {{ link_to("products/search?page=" ~ page.last, "Последняя") }}
                                <span class="help-inline">{{ page.current }} из {{ page.total_pages }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        {% endif %}
    {% else %}
        В базе нет продуктов
    {% endfor %}

В примере выше многое требует уточнения. Прежде всего, активные товары
на текущей странице обходятся циклом 'for' шаблонизатора Volt. Volt предоставляет простой синтаксис для PHP 'foreach'.

.. code-block:: html+jinja

    {% for product in page.items %}

То же самое на PHP:

.. code-block:: php

    <?php foreach ($page->items as $product) { ?>

Весь блок 'for' представлен ниже:

.. code-block:: html+jinja

    {% for product in page.items %}
        {% if loop.first %}
            Выполняется до первого продукта в цикле
        {% endif %}

        Выполняется для каждого продукта из page.items

        {% if loop.last %}
            Выполняется после последнего продукта в цикле
        {% endif %}
    {% else %}
        Выполняется при отсутствии продуктов в page.items
    {% endfor %}

Теперь вы можете вернуться к представлению и выяснить назначение каждого блока. Каждое поле
в "product" выводится соответствующим образом:

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
            {{ link_to("products/edit/" ~ product.id, "Редактировать") }}
        </td>

        <td width="7%">
            {{ link_to("products/delete/" ~ product.id, "Удалить") }}
        </td>
    </tr>

Как мы уже увидели, использование :code:`product.id` то же, что и в PHP: :code:`$product->id`,
так же с :code:`product.name` и так далее. Другие поля выводятся иначе,
к примеру, давайте взглянем на product.productTypes.name. Чтобы понять эту часть,
мы должны проверить модель Products (app/models/Products.php):

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
         * Инициализация Products
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

Модель может иметь метод :code:`initialize()`, этот метод вызывается один раз при запросе и служит
ORM для инициализации модели. В данном случае, "Products" инициализируется с указанием того, что модель
имеет отношение один-ко-многим с другой моделью, называемой "ProductTypes".

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

Это значит, что локальный атрибут "product_types_id" в "Products" имеет отношение один-ко-многим с
моделью "ProductTypes" по ее атрибуту "id". Определяя такое отношение, мы можем получить доступ к названию
типа продукта следующим образом:

.. code-block:: html+jinja

    <td>{{ product.productTypes.name }}</td>

Поле "price" выводится форматированным с помощью Volt фильтра:

.. code-block:: html+jinja

    <td>{{ "%.2f"|format(product.price) }}</td>

Что то же самое на PHP выглядит как:

.. code-block:: php

    <?php echo sprintf("%.2f", $product->price) ?>

Вывод того, активен продукт или нет, использует вспомогательную функцию, реализованную в модели:

.. code-block:: php

    <td>{{ product.getActiveDetail() }}</td>

Этот метод определен в модели.

Создание и обновление записей
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Теперь давайте посмотрим на то, как CRUD создает и обновляет записи. Из представлений "new" и "edit" данные, введенные пользователем,
пересылаются в действие "create" и "save", которые производят операции по "созданию" и "обновлению" продуктов соответственно.

В случае создания мы берем отправленные данные и присваиваем их новому экземпляру "Products":

.. code-block:: php

    <?php

    /**
     * Создает продукт на основе данных, введенных в действии "new"
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

Помните фильтры, которые мы определили в форме Products? Данные фильтруются перед присваиванием объекту :code:`$product`.
Эта фильтрация опциональна, также ORM экранирует введенные данные и производит дополнительные преобразования соответственно типам полей:

.. code-block:: php

    <?php

    // ...

    $name = new Text("name");

    $name->setLabel("Название");

    // Фильтры для названия
    $name->setFilters(
        [
            "striptags",
            "string",
        ]
    );

    // Валидаторы для названия
    $name->addValidators(
        [
            new PresenceOf(
                [
                    "message" => "Название обязательно",
                ]
            )
        ]
    );

    $this->add($name);

При сохранении мы будем знать, соответствуют ли данные бизнес-логике и валидации, реализованной
в форме ProductsForm (app/forms/ProductsForm.php):

.. code-block:: php

    <?php

    // ...

    $form = new ProductsForm();

    $product = new Products();

    // Валидация ввода
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

В итоге, если форма не возвращает каких-либо сообщений валидации, то мы можем сохранить экземпляр продукта:

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
        "Продукт успешно создан"
    );

    return $this->dispatcher->forward(
        [
            "controller" => "products",
            "action"     => "index",
        ]
    );

Теперь, в случае обновления продукта, сперва мы должны представить пользователю данные, которые уже имеются в редактируемой записи:

.. code-block:: php

    <?php

    /**
     * Изменяет продукт по его id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $product = Products::findFirstById($id);

            if (!$product) {
                $this->flash->error(
                    "Продукт не найден"
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

Найденные данные связываются с формой, передавая модель первым параметром. Благодаря этому
пользователи могут менять любое значение, и затем отправлять его обратно в базу данных через действие "save":

.. code-block:: php

    <?php

    /**
     * Обновляет продукт на основе данных, введенных в действии "edit"
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
                "Продукт не существует"
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
            "Продукт успешно обновлен"
        );

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
    }

Теперь мы видим, как Phalcon позволяет создавать формы и привязывать данные из базы данных в структурированном стиле.
В следующей главе мы увидим, как добавить пользовательские HTML элементы наподобие меню.

.. _CRUD: http://ru.wikipedia.org/wiki/CRUD
