对象文档映射 ODM (Object-Document Mapper)
=========================================

除了可以 :doc:`映射关系数据库的表 <models>` 之外，Phalcon还可以使用NoSQL数据库如MongoDB等。Phalcon中的ODM具有可以非常容易的实现如下功能：CRUD,事件，验证等。

因为NoSQL数据库中无sql查询及计划等操作故可以提高数据操作的性能。再者，由于无SQL语句创建的操作故可以减少SQL注入的危险。

当前Phalcon中支持的NosSQL数据库如下：

+------------+----------------------------------------------------------------------+
| 名称       | 描述                                                                 |
+============+======================================================================+
| MongoDB_   | MongoDB是一个稳定的高性能的开源的NoSQL数据                           |
+------------+----------------------------------------------------------------------+

创建模型（Creating Models）
---------------------------
NoSQL中的模型类扩展自 :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>`.模型必须要放入模型文件夹中而且每个模型文件必须只能有一个模型类；
模型类名应该为小驼峰法书写：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {

    }

.. highlights::

    如果PHP版本为5.4/5.5或更高版本，为了提高性能节省内存开销，最好在模型类文件中定义每个字段。

    模型Robots默认和数据库中的robots表格映射。如果想使用别的名字映射数据库中的表格则只需要重写 :code:`setSource()` 方法即可：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->setSource("the_robots");
        }
    }

理解文档对象（Understanding Documents To Objects）
--------------------------------------------------
每个模型的实例和数据库表中的一个文档（记录）相对应。我们可以非常容易的通过读取对象属性来访问表格的数据。例如访问robots表格：

.. code-block:: bash

    $ mongo test
    MongoDB shell version: 1.8.2
    connecting to: test
    > db.robots.find()
    { "_id" : ObjectId("508735512d42b8c3d15ec4e1"), "name" : "Astro Boy", "year" : 1952,
        "type" : "mechanical" }
    { "_id" : ObjectId("5087358f2d42b8c3d15ec4e2"), "name" : "Bender", "year" : 1999,
        "type" : "mechanical" }
    { "_id" : ObjectId("508735d32d42b8c3d15ec4e3"), "name" : "Wall-E", "year" : 2008 }
    >

模型中使用命名空间（Models in Namespaces）
------------------------------------------
我们在这里可以使用命名空间来避免类名冲突。这个例子中我们使用:code:`setSource()`方法来标明要使用的数据库表：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->setSource("robots");
        }
    }

我们可以通过对象的ID查找到对象然后打印出其名字：

.. code-block:: php

    <?php

    // Find record with _id = "5087358f2d42b8c3d15ec4e2"
    $robot = Robots::findById("5087358f2d42b8c3d15ec4e2");

    // Prints "Bender"
    echo $robot->name;

一旦记录被加载到内存中，我们就可以对这些数据进行修改了，修改之后还可以保存：

.. code-block:: php

    <?php

    $robot = Robots::findFirst(
        [
            [
                "name" => "Astro Boy",
            ]
        ]
    );

    $robot->name = "Voltron";

    $robot->save();

设置连接（Setting a Connection）
--------------------------------
这里的MongoDB服务是从服务容器中取得的。默认，Phalcon会使mongo作服务名：

.. code-block:: php

    <?php

    // Simple database connection to localhost
    $di->set(
        "mongo",
        function () {
            $mongo = new MongoClient();

            return $mongo->selectDB("store");
        },
        true
    );

    // Connecting to a domain socket, falling back to localhost connection
    $di->set(
        "mongo",
        function () {
            $mongo = new MongoClient(
                "mongodb:///tmp/mongodb-27017.sock,localhost:27017"
            );

            return $mongo->selectDB("store");
        },
        true
    );

查找文档（Finding Documents）
-----------------------------
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 依赖于Mongo的PHP扩展，这样我们就可以直接从数据库中查询出文档记录然后Phalcon会
透明的（我们无需关心过程和方法）为我们转换为模型的实例。
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>`

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
            ]
        ]
    );
    echo "There are ", count($robots), "\n";

    // Get and print mechanical robots ordered by name upward
    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
            ],
            "sort" => [
                "name" => 1,
            ],
        ]
    );

    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 mechanical robots ordered by name
    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
            ],
            "sort"  => [
                "name" => 1,
            ],
            "limit" => 100,
        ]
    );

    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

这里我们可以使用 :code:`findFirst()` 来取得配置查询的第一条记录：

.. code-block:: php

    <?php

    // What's the first robot in robots collection?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots collection?
    $robot = Robots::findFirst(
        [
            [
                "type" => "mechanical",
            ]
        ]
    );
    echo "The first mechanical robot name is ", $robot->name, "\n";

:code:`find()` 和 :code:`findFirst()` 方法都接收一个关联数据组为查询的条件：

.. code-block:: php

    <?php

    // First robot where type = "mechanical" and year = "1999"
    $robot = Robots::findFirst(
        [
            "conditions" => [
                "type" => "mechanical",
                "year" => "1999",
            ],
        ]
    );

    // All virtual robots ordered by name downward
    $robots = Robots::find(
        [
            "conditions" => [
                "type" => "virtual",
            ],
            "sort" => [
                "name" => -1,
            ],
        ]
    );

可用的查询选项：

+---------------------------+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------+
| 参数                      | 描述                                                                                                   | 例子                                                  |
+===========================+========================================================================================================+=======================================================+
| :code:`conditions` (条件) | 搜索条件，用于取只满足要求的数，默认情况下Phalcon_model会假定关联数据的第一个参数为查询条              | :code:`"conditions" => array('$gt' => 1990)`          |
+---------------------------+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------+
| :code:`fields` (字段)     | 若指定则返回指定的字段而非全部字段，当设置此字段时会返回非完全版本的对象                               | :code:`"fields" => array('name' => true)`             |
+---------------------------+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------+
| :code:`sort` (排序)       | 这个选项用来对查询结果进行排序，使用一个或多个字段作为排序的标准，使用数组来表格，1代表升序，－1代表降 | :code:`"order" => array("name" => -1, "status" => 1)` |
+---------------------------+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------+
| :code:`limit` (限制)      | 限制查询结果集到指定的范围                                                                             | :code:`"limit" => 10`                                 |
+---------------------------+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------+
| :code:`skip` (间隔)       | 跳过指定的条目选取结果                                                                                 | :code:`"skip" => 50`                                  |
+---------------------------+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------+

如果你有使用sql(关系)数据库的经验，你也许想查看二者的映射表格 `SQL to Mongo Mapping Chart`_ .

聚合（Aggregations）
--------------------
我们可以使用Mongo提供的方法使用Mongo模型返回聚合结果。聚合结果不是使用MapReduce来计算的。基于此，我们可以非常容易的取得聚合值，比如总计或平均值等:

.. code-block:: php

    <?php

    $data = Article::aggregate(
        [
            [
                "\$project" => [
                    "category" => 1,
                ],
            ],
            [
                "\$group" => [
                    "_id" => [
                        "category" => "\$category"
                    ],
                    "id"  => [
                        "\$max" => "\$_id",
                    ],
                ],
            ],
        ]
    );

创建和更新记录（Creating Updating/Records）
-------------------------------------------
:code:`Phalcon\Mvc\Collection::save()` 方法可以用来保存数据，Phalcon会根据当前数据库中的数据来对比以确定是新加一条数据还是更新数据。在Phalcon内部会直接使用
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 的save或update方法来进行操作。

当然这个方法内部也会调用我们在模型中定义的验证方法或事件等：

.. code-block:: php

    <?php

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    if ($robot->save() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

"_id"属性会被Mongo驱动自动的随MongId_而更新。

.. code-block:: php

    <?php

    $robot->save();

    echo "The generated id is: ", $robot->getId();

验证信息（Validation Messages）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 提供了一个信息子系统，使用此系统开发者可以非常容易的实现在数据处理中的验证信息的显示及保存。

每条信息即是一个 :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>` 类的对象实例。我们使用getMessages来取得此信息。每条信息中包含了
如哪个字段产生的消息，或是消息类型等信息：

.. code-block:: php

    <?php

    if ($robot->save() === false) {
        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

验证事件和事件管理（Validation Events and Events Manager）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
在模型类的数据操作过程中可以产生一些事件。我们可以在这些事件中定义一些业务规则。下面是 :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 所支持的事件及其执行顺序：

+--------------------+----------------------------------+-----------------------+---------------------------------+
| 操作               | 名称                             | 能否停止操作          | 解释                            |
+====================+==================================+=======================+=================================+
| Inserting/Updating | :code:`beforeValidation`         | YES                   | 在验证和最终插入/更新进行之执行 |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting          | :code:`beforeValidationOnCreate` | YES                   | 仅当创建新条目验证之前执行      |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Updating           | :code:`beforeValidationOnUpdate` | YES                   | 仅在更新条目验证之前            |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting/Updating | :code:`onValidationFails`        | YES (already stopped) | 验证执行失败后执行              |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting          | :code:`afterValidationOnCreate`  | YES                   | 新建条目验证之后执行            |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Updating           | :code:`afterValidationOnUpdate`  | YES                   | 更新条目后执行                  |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting/Updating | :code:`afterValidation`          | YES                   | 在验证进行之前执                |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting/Updating | :code:`beforeSave`               | YES                   | 在请示的操作（保存）运行之前    |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Updating           | :code:`beforeUpdate`             | YES                   | 更新操作执行之前运行            |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting          | :code:`beforeCreate`             | YES                   | 创建操作执行之前运行            |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Updating           | :code:`afterUpdate`              | NO                    | 更新执行之后执行                |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting          | :code:`afterCreate`              | NO                    | 创建执行之后                    |
+--------------------+----------------------------------+-----------------------+---------------------------------+
| Inserting/Updating | :code:`afterSave`                | NO                    | 保存执行之后                    |
+--------------------+----------------------------------+-----------------------+---------------------------------+

为了响应一个事件，我们需在模型中实现同名方法：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function beforeValidationOnCreate()
        {
            echo "This is executed before creating a Robot!";
        }
    }

在执行操作之前先在指定的事件中设置值有时是非常有用的：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Products extends Collection
    {
        public function beforeCreate()
        {
            // Set the creation date
            $this->created_at = date("Y-m-d H:i:s");
        }

        public function beforeUpdate()
        {
            // Set the modification date
            $this->modified_in = date("Y-m-d H:i:s");
        }
    }

另外，这个组件也可以和 :doc:`Phalcon\\Events\\Manager <events>` 进行集成，这就意味着我们可以通过事件触发创建监听器。

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // Attach an anonymous function as a listener for "model" events
    $eventsManager->attach(
        "collection:beforeSave",
        function (Event $event, $robot) {
            if ($robot->name === "Scooby Doo") {
                echo "Scooby Doo isn't a robot!";

                return false;
            }

            return true;
        }
    );

    $robot = new Robots();

    $robot->setEventsManager($eventsManager);

    $robot->name = "Scooby Doo";
    $robot->year = 1969;

    $robot->save();

上面的例子中EventsManager仅在对象和监听器（匿名函数）之间扮演了一个桥接器的角色。如果我们想在创建应用时使用同一个EventsManager,我们需要把这个EventsManager对象设置到 collectionManager服务中：

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Mvc\Collection\Manager as CollectionManager;

    // Registering the collectionManager service
    $di->set(
        "collectionManager",
        function () {
            $eventsManager = new EventsManager();

            // Attach an anonymous function as a listener for "model" events
            $eventsManager->attach(
                "collection:beforeSave",
                function (Event $event, $model) {
                    if (get_class($model) === "Robots") {
                        if ($model->name === "Scooby Doo") {
                            echo "Scooby Doo isn't a robot!";

                            return false;
                        }
                    }

                    return true;
                }
            );

            // Setting a default EventsManager
            $modelsManager = new CollectionManager();

            $modelsManager->setEventsManager($eventsManager);

            return $modelsManager;
        },
        true
    );

实现业务规则（Implementing a Business Rule）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
当插入或更新删除等执行时，模型会检查上面表格中列出的方法是否存在。

我们建议定义模型里的验证方法以避免业务逻辑暴露出来。

下面的例子中实现了在保存或更新时对年份的验证，年份不能小于0年：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";

                return false;
            }
        }
    }

在响应某些事件时返回了false则会停止当前的操作。 如果事实响应未返回任何值， :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 会假定返回了true值。

验证数据完整性（Validating Data Integrity）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 提供了若干个事件用于验证数据和实现业务逻辑。特定的事件中我们可以调用内建的验证器，
Phalcon提供了一些验证器可以用在此阶段的验证上。

下面的例子中展示了如何使用：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;
    use Phalcon\Validation;
    use Phalcon\Validation\Validator\InclusionIn;
    use Phalcon\Validation\Validator\Numericality;

    class Robots extends Collection
    {
        public function validation()
        {
            $validation = new Validation();

            $validation->add(
                "type",
                new InclusionIn(
                    [
                        "message" => "Type must be: mechanical or virtual",
                        "domain" => [
                            "Mechanical",
                            "Virtual",
                        ],
                    ]
                )
            );

            $validation->add(
                "price",
                new Numericality(
                    [
                        "message" => "Price must be numeric"
                    ]
                )
            );

            return $this->validate($validation);
        }
    }

上面的例子使用了内建的"InclusionIn"验证器。这个验证器检查了字段的类型是否在指定的范围内。如果值不在范围内即验证失败会返回false.

.. highlights::

    For more information on validators, see the :doc:`Validation documentation <validation>`.

删除记录（Deleting Records）
----------------------------
:code:`Phalcon\Mvc\Collection::delete()` 方法用来删除记录条目。我们可以如下使用：

.. code-block:: php

    <?php

    $robot = Robots::findFirst();

    if ($robot !== false) {
        if ($robot->delete() === false) {
            echo "Sorry, we can't delete the robot right now: \n";

            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

也可以使用遍历的方式删除多个条目的数据：

.. code-block:: php

    <?php

    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
            ]
        ]
    );

    foreach ($robots as $robot) {
        if ($robot->delete() === false) {
            echo "Sorry, we can't delete the robot right now: \n";

            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

当删除操作执行时我们可以执行如下事件，以实现定制业务逻辑的目的：

+-----------+----------------------+---------------------+------------------------------------------+
| 操作      | 名称                 | 是否可停止          | 解释                                     |
+===========+======================+=====================+==========================================+
| 删除      | :code:`beforeDelete` | 是                  | 删除之前执行                             |
+-----------+----------------------+---------------------+------------------------------------------+
| 删除      | :code:`afterDelete`  | 否                  | 删除之后执行                             |
+-----------+----------------------+---------------------+------------------------------------------+

验证失败事件（Validation Failed Events）
----------------------------------------
验证失败时依据不同的情形下列事件会触发：

+--------------------+---------------------------+-------------------------+
| 操作               | 名称                      | 解释                    |
+====================+===========================+=========================+
| 插入和或更新       | :code:`notSave`           | 当插入/更新操作失败时触 |
+--------------------+---------------------------+-------------------------+
| 插入删除或更新     | :code:`onValidationFails` | 当数据操作失败时触发    |
+--------------------+---------------------------+-------------------------+

固有 Id 和 用户主键（Implicit Ids vs. User Primary Keys）
---------------------------------------------------------
默认 :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 会使用MongoIds_来产生 :code:`_id`.如果用户想自定义主键也可以只需：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->useImplicitObjectIds(false);
        }
    }

设置多个数据库（Setting multiple databases）
--------------------------------------------
Phalcon中，所有的模型可以只属于一个数据库或是多个数据库。事实上当 :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` 试图连接数据库时
Phalcon会从DI中取名为mongo的服务。当然我们可在模型的initialize方法中进行连接设置：

.. code-block:: php

    <?php

    // This service returns a mongo database at 192.168.1.100
    $di->set(
        "mongo1",
        function () {
            $mongo = new MongoClient(
                "mongodb://scott:nekhen@192.168.1.100"
            );

            return $mongo->selectDB("management");
        },
        true
    );

    // This service returns a mongo database at localhost
    $di->set(
        "mongo2",
        function () {
            $mongo = new MongoClient(
                "mongodb://localhost"
            );

            return $mongo->selectDB("invoicing");
        },
        true
    );

然后在初始化方法，我们定义了模型的连接：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->setConnectionService("mongo1");
        }
    }

注入服务到模型（Injecting services into Models）
------------------------------------------------
我们可能需要在模型内使用应用的服务，下面的例子中展示了如何去做：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function notSave()
        {
            // Obtain the flash service from the DI container
            $flash = $this->getDI()->getShared("flash");

            $messages = $this->getMessages();

            // Show validation messages
            foreach ($messages as $message) {
                $flash->error(
                    (string) $message
                );
            }
        }
    }

notSave事件在创建和更新失败时触发。我们使用flash服务来处理验证信息。如此做我们无需在每次保存后打印消息出来。

.. _MongoDB: http://www.mongodb.org/
.. _MongoId: http://www.php.net/manual/en/class.mongoid.php
.. _MongoIds: http://www.php.net/manual/en/class.mongoid.php
.. _`SQL to Mongo Mapping Chart`: http://www.php.net/manual/en/mongo.sqltomongo.php
.. _`aggregation framework`: http://docs.mongodb.org/manual/applications/aggregation/
