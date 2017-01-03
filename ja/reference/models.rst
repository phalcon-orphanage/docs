モデルの働き
===================

モデルは、そのデータを操作するアプリケーションの情報 (データ) およびルールを表します。モデルは、主に、対応するデータベーステーブルとの相互作用のルールを管理するために使用されます。多くの場合、データベース内の各テーブルには、アプリケーション内の一つのモデルに対応します。アプリケーションのビジネスロジックの大部分は、モデルに集中するでしょう。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` は、Phalconアプリケーション内のすべてのモデルのためのベースとなっています。これは、データベースの独立性、基本的なCRUD機能、高度な検索機能、およびその他のサービスの中でお互いにモデルを関連付ける機能を提供します。 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` は、それぞれのデータベースエンジン操作に動的にメソッドを変換するためのSQL文を使用することの必要性を避けています。

.. highlights::

    Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` component documentation.

モデルの作成
---------------
モデルは :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` から継承したクラスです。そのクラス名はキャメルケースで表記すべきです:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {

    }

.. highlights::

    If you're using PHP 5.4/5.5 it is recommended you declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.

デフォルトでは、モデル "Store\\Toys\\RobotParts" はテーブル "robot_parts" を参照します。手動でマッピングテーブルに別の名前を指定したい場合は、 :code:`setSource()` メソッドを使用することができます:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {
        public function initialize()
        {
            $this->setSource("toys_robot_parts");
        }
    }

モデル RobotParts は現在、「 toys_robot_parts 」テーブルにマップされています。上記の方法に加えて、 :code:`initialize()` メソッドが提供されています。

:code:`initialize()` メソッドはリクエストの間に一度だけ呼び出され、アプリケーション内で作成されたモデルのすべてのインスタンスに適用するために初期化を実行します。もし、あなたが、すべてのインスタンスで初期化処理を実行したい場合 :code:`onConstruct()` でできます:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {
        public function onConstruct()
        {
            // ...
        }
    }

パブリックプロパティ vs セッター/ゲッター
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
モデルの各プロパティは、パブリックスコープで実装することができます、つまり、特に制限なく、モデルクラスがインスタンス化されたコードのどの部分からでも更新/読み取ることができることを意味します。

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $price;
    }

ゲッターとセッターを使用して、どのプロパティで目に見える公的データに様々な変換を行い、また、オブジェクトに格納されたデータに検証ルールを追加するか制御することができます:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use InvalidArgumentException;
    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        protected $id;

        protected $name;

        protected $price;

        public function getId()
        {
            return $this->id;
        }

        public function setName($name)
        {
            // 名前が短すぎる？
            if (strlen($name) < 10) {
                throw new InvalidArgumentException(
                    "The name is too short"
                );
            }

            $this->name = $name;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setPrice($price)
        {
            // マイナスの価格が許可されていません
            if ($price < 0) {
                throw new InvalidArgumentException(
                    "Price can't be negative"
                );
            }

            $this->price = $price;
        }

        public function getPrice()
        {
            // 使用する前にdouble型に変換する
            return (double) $this->price;
        }
    }

パブリックプロパティは、開発中の複雑さを少なくします。しかしゲッター/セッターは、アプリケーションのテスト容易性、拡張性と保守性を大きく向上させることができます。開発者は、作成しているアプリケーションに、より適している戦略を決定することができます。 ORMは定義するプロパティの両方の方式に対応しています。

.. highlights::

    Underscores in property names can be problematic when using getters and setters.

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use
with magic methods. (e.g. $model->getPropertyName instead of $model->getProperty_name, $model->findByPropertyName
instead of $model->findByProperty_name, etc.). As much of the system expects camel case, and underscores are commonly
removed, it is recommended to name your properties in the manner shown throughout the documentation. You can use a
column map (as described above) to ensure proper mapping of your properties to their database counterparts.

レコードからオブジェクトを理解する
----------------------------------
モデルのすべてのインスタンスは、テーブル内の行を表します。あなたは簡単にオブジェクトのプロパティを読み取ることによってレコードデータにアクセスすることができます。例えば、"robots" テーブル:

.. code-block:: bash

    mysql> select * from robots;
    +----+------------+------------+------+
    | id | name       | type       | year |
    +----+------------+------------+------+
    |  1 | Robotina   | mechanical | 1972 |
    |  2 | Astro Boy  | mechanical | 1952 |
    |  3 | Terminator | cyborg     | 2029 |
    +----+------------+------------+------+
    3 rows in set (0.00 sec)

プライマリキーによって特定のレコードを検索し、その名前を出力できます:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // id = 3 を持つレコードを検索
    $robot = Robots::findFirst(3);

    // "Terminator" を出力
    echo $robot->name;

レコードはメモリに入ると、そのデータに変更を加えてから、変更内容を保存することができます:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(3);

    $robot->name = "RoboCop";

    $robot->save();

ご覧のように、生のSQL文を使用する必要はありません。  :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` は、Webアプリケーションのための高いデータベース抽象化を提供します。

レコードの検索
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` もレコードを照会するためのいくつかのメソッドを提供しています。次の例では、モデルから1つまたは複数のレコードを照会する方法を紹介します:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // いくつの robots がありますか？
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // いくつの mechanical robots がありますか？
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // name 順に並べた virtual robots を取得し印刷
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // virtual robotsのname順の最初の100件を取得
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
            "limit" => 100,
        ]
    );
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

.. highlights::

    If you want find record by external data (such as user input) or variable data you must use `パラメータの割り当て`_.

また、:code:`findFirst()` メソッドを使用することで、与えられた条件に一致する最初のレコードだけを取得することができます:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // robots テーブルの最初の robot は何ですか？
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // robots テーブルの最初の mechanical robot は何ですか？
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // virtual robotsのname順の最初を取得
    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );
    echo "The first virtual robot name is ", $robot->name, "\n";

:code:`find()` と :code:`findFirst()` メソッドの両方とも検索条件を指定する連想配列を受け入れます:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name DESC",
            "limit" => 30,
        ]
    );

    $robots = Robots::find(
        [
            "conditions" => "type = ?1",
            "bind"       => [
                1 => "virtual",
            ]
        ]
    );

利用可能なクエリオプションは次のとおり:

+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                                                          | Example                                                                    |
+=============+======================================================================================================================================================================================================================================+============================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` assumes the first parameter are the conditions. | :code:`"conditions" => "name LIKE 'steve%'"`                               |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| columns     | Return specific columns instead of the full columns in the model. When using this option an incomplete object is returned                                                                                                            | :code:`"columns" => "id, name"`                                            |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| bind        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security                                                                                                                           | :code:`"bind" => ["status" => "A", "type" => "some-time"]`                 |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| bindTypes   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security                                                                                           | :code:`"bindTypes" => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]`    |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| order       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                                                           | :code:`"order" => "name DESC, status"`                                     |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                                                           | :code:`"limit" => 10`                                                      |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| offset      | Offset the results of the query by a certain amount                                                                                                                                                                                  | :code:`"offset" => 5`                                                      |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                                                          | :code:`"group" => "name, status"`                                          |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| for_update  | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting exclusive locks on each row it reads                                                                                | :code:`"for_update" => true`                                               |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| shared_lock | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting shared locks on each row it reads                                                                                   | :code:`"shared_lock" => true`                                              |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| cache       | Cache the resultset, reducing the continuous access to the relational system                                                                                                                                                         | :code:`"cache" => ["lifetime" => 3600, "key" => "my-find-key"]`            |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| hydration   | Sets the hydration strategy to represent each returned record in the result                                                                                                                                                          | :code:`"hydration" => Resultset::HYDRATE_OBJECTS`                          |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

必要に応じて、パラメータの配列を使用する代わりに、オブジェクト指向の方法でクエリを作成する方法があります:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(["type" => "mechanical"])
        ->order("name")
        ->execute();

静的メソッドの :code:`query()` が返す :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` オブジェクトは、IDE オートコンプリートと相性が良いです。

すべてのクエリは、内部で :doc:`PHQL <phql>` クエリとして処理されます。 PHQLは、高レベル、オブジェクト指向やSQLに似た言語です。この言語はあなたに他のモデルを結合するようなクエリを実行するための多くの機能を提供し、グループを定義し、集計などを追加します。

Lastly, there is the :code:`findFirstBy<property-name>()` method. This method expands on the :code:`findFirst()` method mentioned earlier. It allows you to quickly perform a
retrieval from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column.
An example is in order, so taking our Robots model mentioned earlier:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $price;
    }

We have three properties to work with here: :code:`$id`, :code:`$name` and :code:`$price`. So, let's say you want to retrieve the first record in
the table with the name 'Terminator'. This could be written like:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $name = "Terminator";

    $robot = Robots::findFirstByName($name);

    if ($robot) {
        echo "The first robot with the name " . $name . " cost " . $robot->price . ".";
    } else {
        echo "There were no robots found in our table with the name " . $name . ".";
    }

Notice that we used 'Name' in the method call and passed the variable :code:`$name` to it, which contains the name
we are looking for in our table. Notice also that when we find a match with our query, all the other properties
are available to us as well.

モデルの結果セット
^^^^^^^^^^^^^^^^^^
While :code:`findFirst()` returns directly an instance of the called class (when there is data to be returned), the :code:`find()` method returns a
:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This is an object that encapsulates all the functionality
a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`
is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Get all robots
    $robots = Robots::find();

    // Traversing with a foreach
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Traversing with a while
    $robots->rewind();

    while ($robots->valid()) {
        $robot = $robots->current();

        echo $robot->name, "\n";

        $robots->next();
    }

    // Count the resultset
    echo count($robots);

    // Alternative way to count the resultset
    echo $robots->count();

    // Move the internal cursor to the third robot
    $robots->seek(2);

    $robot = $robots->current();

    // Access a robot by its position in the resultset
    $robot = $robots[5];

    // Check if there is a record in certain position
    if (isset($robots[3])) {
       $robot = $robots[3];
    }

    // Get the first record in the resultset
    $robot = $robots->getFirst();

    // Get the last record
    $robot = $robots->getLast();

Phalcon's resultsets emulate scrollable cursors, you can get any row just by accessing its position, or seeking the internal pointer
to a specific position. Note that some database systems don't support scrollable cursors, this forces to re-execute the query
in order to rewind the cursor to the beginning and obtain the record at the requested position. Similarly, if a resultset
is traversed several times, the query must be executed the same number of times.

As storing large query results in memory could consume many resources, resultsets are obtained
from the database in chunks of 32 rows - reducing the need to re-execute the request in several cases.

Note that resultsets can be serialized and stored in a cache backend. :doc:`Phalcon\\Cache <cache>` can help with that task. However,
serializing data causes :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to retrieve all the data from the database in an array,
thus consuming more memory while this process takes place.

.. code-block:: php

    <?php

    // Query all records from model parts
    $parts = Parts::find();

    // Store the resultset into a file
    file_put_contents(
        "cache.txt",
        serialize($parts)
    );

    // Get parts from file
    $parts = unserialize(
        file_get_contents("cache.txt")
    );

    // Traverse the parts
    foreach ($parts as $part) {
        echo $part->id;
    }

結果セットのフィルタリング
^^^^^^^^^^^^^^^^^^^^^^^^^^
The most efficient way to filter data is setting some search criteria, databases will use indexes set on tables to return data faster.
Phalcon additionally allows you to filter the data using PHP using any resource that is not available in the database:

.. code-block:: php

    <?php

    $customers = Customers::find();

    $customers = $customers->filter(
        function ($customer) {
            // Return only customers with a valid e-mail
            if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
                return $customer;
            }
        }
    );

パラメータの割り当て
^^^^^^^^^^^^^^^^^^^^
Bound parameters are also supported in :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. You are encouraged to use
this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks.
Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Query robots binding parameters with string placeholders
    // Parameters whose keys are the same as placeholders
    $robots = Robots::find(
        [
            "name = :name: AND type = :type:",
            "bind" => [
                "name" => "Robotina",
                "type" => "maid",
            ],
        ]
    );

    // Query robots binding parameters with integer placeholders
    $robots = Robots::find(
        [
            "name = ?1 AND type = ?2",
            "bind" => [
                1 => "Robotina",
                2 => "maid",
            ],
        ]
    );

    // Query robots binding parameters with both string and integer placeholders
    // Parameters whose keys are the same as placeholders
    $robots = Robots::find(
        [
            "name = :name: AND type = ?1",
            "bind" => [
                "name" => "Robotina",
                1      => "maid",
            ],
        ]
    );

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2" are considered strings
and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using PDO_. This function takes into account the connection charset, so its recommended to define
the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects
when storing or retrieving data.

Additionally you can set the parameter "bindTypes", this allows defining how the parameters should be bound according to its data type:

.. code-block:: php

    <?php

    use Phalcon\Db\Column;
    use Store\Toys\Robots;

    // Bind parameters
    $parameters = [
        "name" => "Robotina",
        "year" => 2008,
    ];

    // Casting Types
    $types = [
        "name" => Column::BIND_PARAM_STR,
        "year" => Column::BIND_PARAM_INT,
    ];

    // Query robots binding parameters with string placeholders
    $robots = Robots::find(
        [
            "name = :name: AND year = :year:",
            "bind"      => $parameters,
            "bindTypes" => $types,
        ]
    );

.. highlights::

    Since the default bind-type is :code:`Phalcon\Db\Column::BIND_PARAM_STR`, there is no need to specify the
    "bindTypes" parameter if all of the columns are of that type.

If you bind arrays in bound parameters, keep in mind, that keys must be numbered from zero:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $array = ["a","b","c"]; // $array: [[0] => "a", [1] => "b", [2] => "c"]

    unset($array[1]); // $array: [[0] => "a", [2] => "c"]

    // Now we have to renumber the keys
    $array = array_values($array); // $array: [[0] => "a", [1] => "c"]

    $robots = Robots::find(
        [
            'letter IN ({letter:array})',
            'bind' => [
                'letter' => $array
            ]
        ]
    );

.. highlights::

    Bound parameters are available for all query methods such as :code:`find()` and :code:`findFirst()` but also the calculation
    methods like :code:`count()`, :code:`sum()`, :code:`average()` etc.

If you're using "finders", bound parameters are automatically used for you:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Explicit query using bound parameters
    $robots = Robots::find(
        [
            "name = ?0",
            "bind" => [
                "Ultron",
            ],
        ]
    );

    // Implicit query using bound parameters
    $robots = Robots::findByName("Ultron");

取得したレコードの初期化／準備
--------------------------------------
May be the case that after obtaining a record from the database is necessary to initialise the data before
being used by the rest of the application. You can implement the :code:`afterFetch()` method in a model, this event
will be executed just after create the instance and assign the data to it:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $status;

        public function beforeSave()
        {
            // Convert the array into a string
            $this->status = join(",", $this->status);
        }

        public function afterFetch()
        {
            // Convert the string to an array
            $this->status = explode(",", $this->status);
        }
        
        public function afterSave()
        {
            // Convert the string to an array
            $this->status = explode(",", $this->status);
        }
    }

If you use getters/setters instead of/or together with public properties, you can initialize the field once it is
accessed:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $status;

        public function getStatus()
        {
            return explode(",", $this->status);
        }
    }

計算／集計の実行
-----------------------
Calculations (or aggregations) are helpers for commonly used functions of database systems such as COUNT, SUM, MAX, MIN or AVG.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` allows to use these functions directly from the exposed methods.

Count examples:

.. code-block:: php

    <?php

    // How many employees are?
    $rowcount = Employees::count();

    // How many different areas are assigned to employees?
    $rowcount = Employees::count(
        [
            "distinct" => "area",
        ]
    );

    // How many employees are in the Testing area?
    $rowcount = Employees::count(
        "area = 'Testing'"
    );

    // Count employees grouping results by their area
    $group = Employees::count(
        [
            "group" => "area",
        ]
    );
    foreach ($group as $row) {
       echo "There are ", $row->rowcount, " in ", $row->area;
    }

    // Count employees grouping by their area and ordering the result by count
    $group = Employees::count(
        [
            "group" => "area",
            "order" => "rowcount",
        ]
    );

    // Avoid SQL injections using bound parameters
    $group = Employees::count(
        [
            "type > ?0",
            "bind" => [
                $type
            ],
        ]
    );

Sum examples:

.. code-block:: php

    <?php

    // How much are the salaries of all employees?
    $total = Employees::sum(
        [
            "column" => "salary",
        ]
    );

    // How much are the salaries of all employees in the Sales area?
    $total = Employees::sum(
        [
            "column"     => "salary",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Generate a grouping of the salaries of each area
    $group = Employees::sum(
        [
            "column" => "salary",
            "group"  => "area",
        ]
    );
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $row->area, " is ", $row->sumatory;
    }

    // Generate a grouping of the salaries of each area ordering
    // salaries from higher to lower
    $group = Employees::sum(
        [
            "column" => "salary",
            "group"  => "area",
            "order"  => "sumatory DESC",
        ]
    );

    // Avoid SQL injections using bound parameters
    $group = Employees::sum(
        [
            "conditions" => "area > ?0",
            "bind"       => [
                $area
            ],
        ]
    );

Average examples:

.. code-block:: php

    <?php

    // What is the average salary for all employees?
    $average = Employees::average(
        [
            "column" => "salary",
        ]
    );

    // What is the average salary for the Sales's area employees?
    $average = Employees::average(
        [
            "column"     => "salary",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Avoid SQL injections using bound parameters
    $average = Employees::average(
        [
            "column"     => "age",
            "conditions" => "area > ?0",
            "bind"       => [
                $area
            ],
        ]
    );

Max/Min examples:

.. code-block:: php

    <?php

    // What is the oldest age of all employees?
    $age = Employees::maximum(
        [
            "column" => "age",
        ]
    );

    // What is the oldest of employees from the Sales area?
    $age = Employees::maximum(
        [
            "column"     => "age",
            "conditions" => "area = 'Sales'",
        ]
    );

    // What is the lowest salary of all employees?
    $salary = Employees::minimum(
        [
            "column" => "salary",
        ]
    );

レコードの作成、更新
-------------------------
The :code:`Phalcon\Mvc\Model::save()` method allows you to create/update records according to whether they already exist in the table
associated with a model. The save method is called internally by the create and update methods of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record
should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

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

An array could be passed to "save" to avoid assign every column manually. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will check if there are setters implemented for
the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save(
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass
an insecure array without worrying about possible SQL injections:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save($_POST);

.. highlights::

    Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature
    if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted
    form.

You can set an additional parameter in 'save' to set a whitelist of fields that only must taken into account when doing
the mass assignment:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save(
        $_POST,
        [
            "name",
            "type",
        ]
    );

確実に作成／更新する
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an application has a lot of competition, we could be expecting create a record but it is actually updated. This
could happen if we use :code:`Phalcon\Mvc\Model::save()` to persist the records in the database. If we want to be absolutely
sure that a record is created or updated, we can change the :code:`save()` call with :code:`create()` or :code:`update()`:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    // This record only must be created
    if ($robot->create() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }

These methods "create" and "update" also accept an array of values as parameter.

レコードの削除
----------------
The :code:`Phalcon\Mvc\Model::delete()` method allows to delete a record. You can use it as follows:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(11);

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

You can also delete many records by traversing a resultset with a foreach:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::find(
        "type = 'mechanical'"
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

The following events are available to define custom business rules that can be executed when a delete operation is
performed:

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+

With the above events can also define business rules in the models:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function beforeDelete()
        {
            if ($this->status === "A") {
                echo "The robot is active, it can't be deleted";

                return false;
            }

            return true;
        }
    }
.. _PDO: http://php.net/manual/ja/pdo.prepared-statements.php
