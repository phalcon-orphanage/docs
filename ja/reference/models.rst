モデルの働き
===================
モデルは、そのデータを操作するアプリケーションの情報 (データ) およびルールを表します。モデルは、主に、対応するデータベーステーブルとの相互作用のルールを管理するために使用されます。多くの場合、データベース内の各テーブルには、アプリケーション内の一つのモデルに対応します。アプリケーションのビジネスロジックの大部分は、モデルに集中するでしょう。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` は、Phalconアプリケーション内のすべてのモデルのためのベースとなっています。これは、データベースの独立性、基本的なCRUD機能、高度な検索機能、およびその他のサービスの中でお互いにモデルを関連付ける機能を提供します。 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` は、それぞれのデータベースエンジン操作に動的にメソッドを変換するためのSQL文を使用することの必要性を避けています。

.. highlights::

    Models are intended to work on a database high layer of abstraction. If you need to work with databases at a lower level check out the
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` component documentation.

モデルの作成
---------------
モデルは :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` から継承したクラスです。models ディレクトリに配置する必要があります。 モデルのファイルには、単一のクラスが含まれている必要があります。そのクラス名はキャメルケースで表記すべきです:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

    }

上記の例は、「ロボット」モデルの実装を示しています。クラス Robots は  :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` から継承していることに注目してください。このコンポーネントは、基本的なデータベースのCRUD （作成、読み取り、更新、削除）の操作、データ検証だけでなく、高度な検索をサポートし、相互に複数のモデルを関連付ける機能など、それを継承したモデルに多くの機能を提供します。

.. highlights::

    If you're using PHP 5.4/5.5 is recommended declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.

デフォルトでは、モデル "Robots" はテーブル "robots" を参照します。手動でマッピングテーブルに別の名前を指定したい場合は、 getSource() メソッドを使用することができます:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "the_robots";
        }

    }

モデル Robots は現在、「 the_robots 」テーブルにマップされています。上記の方法に加えて、 'initialize' メソッドが提供されています。カスタム動作、言い換えれば別のテーブルを使用してモデルをセットアップする方法を支援します:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setSource("the_robots");
        }

    }

initialize() メソッドはリクエストの間に一度だけ呼び出され、アプリケーション内で作成されたモデルのすべてのインスタンスに適用するために初期化を実行します。もし、あなたが、すべてのインスタンスで初期化処理を実行したい場合 'onConstruct' でできます:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function onConstruct()
        {
            //...
        }

    }

パブリックプロパティ vs セッター/ゲッター
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
モデルの各プロパティは、パブリックスコープで実装することができます、つまり、特に制限なく、モデルクラスがインスタンス化されたコードのどの部分からでも更新/読み取ることができることを意味します。

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public $price;
    }

ゲッターとセッターを使用して、どのプロパティで目に見える公的データに様々な変換を行い、また、オブジェクトに格納されたデータに検証ルールを追加するか制御することができます:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
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
            //名前が短すぎる？
            if (strlen($name) < 10) {
                throw new \InvalidArgumentException('The name is too short');
            }
            $this->name = $name;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setPrice($price)
        {
            //マイナスの価格が許可されていません
            if ($price < 0) {
                throw new \InvalidArgumentException('Price can\'t be negative');
            }
            $this->price = $price;
        }

        public function getPrice()
        {
            //使用する前にdouble型に変換する
            return (double) $this->price;
        }
    }

パブリックプロパティは、開発中の複雑さを少なくします。しかしゲッター/セッターは、アプリケーションのテスト容易性、拡張性と保守性を大きく向上させることができます。開発者は、作成しているアプリケーションに、より適している戦略を決定することができます。 ORMは定義するプロパティの両方の方式に対応しています。

名前空間内のモデル
^^^^^^^^^^^^^^^^^^^^
名前空間は、クラス名の衝突を回避するために使用することができます。マップされたテーブルはクラス名から取得されます、この場合は 'Robots':

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Model
    {

    }

レコードからオブジェクトを理解する
--------------------------------
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

    // id = 3 を持つレコードを検索
    $robot = Robots::findFirst(3);

    // "Terminator" を出力
    echo $robot->name;

レコードはメモリに入ると、そのデータに変更を加えてから、変更内容を保存することができます:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();

ご覧のように、生のSQL文を使用する必要はありません。  :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` は、Webアプリケーションのための高いデータベース抽象化を提供します。

レコードの検索
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` もレコードを照会するためのいくつかのメソッドを提供しています。次の例では、モデルから1つまたは複数のレコードを照会する方法を紹介します:

.. code-block:: php

    <?php

    // いくつの robots がありますか？
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // いくつの mechanical robots がありますか？
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // name 順に並べた virtual robots を取得し印刷
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name"
    ));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // virtual robotsのname順の最初の100件を取得
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100
    ));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

また、findFirst() メソッドを使用することで、与えられた条件に一致する最初のレコードだけを取得することができます:

.. code-block:: php

    <?php

    // robots テーブルの最初の robot は何ですか？
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // robots テーブルの最初の mechanical robot は何ですか？
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // virtual robotsのname順の最初を取得
    $robot = Robots::findFirst(array("type = 'virtual'", "order" => "name"));
    echo "The first virtual robot name is ", $robot->name, "\n";

find() と findFirst() メソッドの両方とも検索条件を指定する連想配列を受け入れます:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(array(
        "type = 'virtual'",
        "order" => "name DESC",
        "limit" => 30
    ));

    $robots = Robots::find(array(
        "conditions" => "type = ?1",
        "bind"       => array(1 => "virtual")
    ));

利用可能なクエリオプションは次のとおり:

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                        | Example                                                                 |
+=============+====================================================================================================================================================================================================+=========================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon\\Mvc\\Model assumes the first parameter are the conditions. | "conditions" => "name LIKE 'steve%'"                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| columns     | Return specific columns instead of the full columns in the model. When using this option an incomplete object is returned                                                                          | "columns" => "id, name"                                                 |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bind        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security                                                                                         | "bind" => array("status" => "A", "type" => "some-time")                 |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bindTypes   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security                                                         | "bindTypes" => array(Column::BIND_TYPE_STR, Column::BIND_TYPE_INT)      |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| order       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                         | "order" => "name DESC, status"                                          |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                         | "limit" => 10 / "limit" => array("number" => 10, "offset" => 5)         |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                        | "group" => "name, status"                                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| for_update  | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting exclusive locks on each row it reads                                              | "for_update" => true                                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| shared_lock | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting shared locks on each row it reads                                                 | "shared_lock" => true                                                   |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| cache       | Cache the resultset, reducing the continuous access to the relational system                                                                                                                       | "cache" => array("lifetime" => 3600, "key" => "my-find-key")            |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| hydration   | Sets the hydration strategy to represent each returned record in the result                                                                                                                        | "hydration" => Resultset::HYDRATE_OBJECTS                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

必要に応じて、パラメータの配列を使用する代わりに、オブジェクト指向の方法でクエリを作成する方法があります:

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(array("type" => "mechanical"))
        ->order("name")
        ->execute();

静的メソッドの query() が返す :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` オブジェクトは、IDE オートコンプリートと相性が良いです。

すべてのクエリは、内部で :doc:`PHQL <phql>` クエリとして処理されます。 PHQLは、高レベル、オブジェクト指向やSQLに似た言語です。この言語はあなたに他のモデルを結合するようなクエリを実行するための多くの機能を提供し、グループを定義し、集計などを追加します。

モデルの結果セット
^^^^^^^^^^^^^^^^
While findFirst() returns directly an instance of the called class (when there is data to be returned), the find() method returns a
:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This is an object that encapsulates all the functionality
a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`
is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

.. code-block:: php

    <?php

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

Storing large query results in memory could consume many resources, because of this, resultsets are obtained
from the database in chunks of 32 rows reducing the need for re-execute the request in several cases also saving memory.

Note that resultsets can be serialized and stored in a cache backend. :doc:`Phalcon\\Cache <cache>` can help with that task. However,
serializing data causes :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to retrieve all the data from the database in an array,
thus consuming more memory while this process takes place.

.. code-block:: php

    <?php

    // Query all records from model parts
    $parts = Parts::find();

    // Store the resultset into a file
    file_put_contents("cache.txt", serialize($parts));

    // Get parts from file
    $parts = unserialize(file_get_contents("cache.txt"));

    // Traverse the parts
    foreach ($parts as $part) {
       echo $part->id;
    }

結果セットのフィルタリング
^^^^^^^^^^^^^^^^^^^^
The most efficient way to filter data is setting some search criteria, databases will use indexes set on tables to return data faster.
Phalcon additionally allows you to filter the data using PHP using any resource that is not available in the database:

.. code-block:: php

    <?php

    $customers = Customers::find()->filter(function($customer) {

        //Return only customers with a valid e-mail
        if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return $customer;
        }

    });

パラメータの割り当て
^^^^^^^^^^^^^^^^^^
Bound parameters are also supported in :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. Although there is a minimal performance
impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject
to SQL injection attacks. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php

    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND type = :type:";

    //Parameters whose keys are the same as placeholders
    $parameters = array(
        "name" => "Robotina",
        "type" => "maid"
    );

    //Perform the query
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

    // Query robots binding parameters with integer placeholders
    $conditions = "name = ?1 AND type = ?2";
    $parameters = array(1 => "Robotina", 2 => "maid");
    $robots     = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

    // Query robots binding parameters with both string and integer placeholders
    $conditions = "name = :name: AND type = ?1";

    //Parameters whose keys are the same as placeholders
    $parameters = array(
        "name" => "Robotina",
        1 => "maid"
    );

    //Perform the query
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2" are considered strings
and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using PDO_. This function takes into account the connection charset, so its recommended to define
the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects
when storing or retrieving data.

Additionally you can set the parameter "bindTypes", this allows defining how the parameters should be bound according to its data type:

.. code-block:: php

    <?php

    use \Phalcon\Db\Column;

    //Bind parameters
    $parameters = array(
        "name" => "Robotina",
        "year" => 2008
    );

    //Casting Types
    $types = array(
        "name" => Column::BIND_PARAM_STR,
        "year" => Column::BIND_PARAM_INT
    );

    // Query robots binding parameters with string placeholders
    $robots = Robots::find(array(
        "name = :name: AND year = :year:",
        "bind" => $parameters,
        "bindTypes" => $types
    ));

.. highlights::

    Since the default bind-type is \\Phalcon\\Db\\Column::BIND_PARAM_STR, there is no need to specify the
    "bindTypes" parameter if all of the columns are of that type.

Bound parameters are available for all query methods such as find() and findFirst() but also the calculation
methods like count(), sum(), average() etc.

取得したレコードの初期化／準備
--------------------------------------
May be the case that after obtaining a record from the database is necessary to initialise the data before
being used by the rest of the application. You can implement the method 'afterFetch' in a model, this event
will be executed just after create the instance and assign the data to it:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        public $id;

        public $name;

        public $status;

        public function beforeSave()
        {
            //Convert the array into a string
            $this->status = join(',', $this->status);
        }

        public function afterFetch()
        {
            //Convert the string to an array
            $this->status = explode(',', $this->status);
        }
    }

If you use getters/setters instead of/or together with public properties, you can initialize the field once it is
accessed:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public $status;

        public function getStatus()
        {
            return explode(',', $this->status);
        }

    }

モデル間のリレーション
----------------------------
There are four types of relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be
unidirectional or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models).
The model manager manages foreign key constraints for these relationships, the definition of these helps referential
integrity as well as easy and fast access of related records to a model. Through the implementation of relations,
it is easy to access data in related models from each record in a uniform way.

単方向のリレーション
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Unidirectional relations are those that are generated in relation to one another but not vice versa.

双方向のリレーション
^^^^^^^^^^^^^^^^^^^^^^^
The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

リレーションの定義
^^^^^^^^^^^^^^^^^^^^^^
In Phalcon, relationships must be defined in the initialize() method of a model. The methods belongsTo(), hasOne(),
hasMany() and hasManyToMany() define the relationship between one or more fields from the current model to fields in
another model. Each of these methods requires 3 parameters: local fields, referenced model, referenced fields.

+---------------+----------------------------+
| Method        | Description                |
+===============+============================+
| hasMany       | Defines a 1-n relationship |
+---------------+----------------------------+
| hasOne        | Defines a 1-1 relationship |
+---------------+----------------------------+
| belongsTo     | Defines a n-1 relationship |
+---------------+----------------------------+
| hasManyToMany | Defines a n-n relationship |
+---------------+----------------------------+

The following schema shows 3 tables whose relations will serve us as an example regarding relationships:

.. code-block:: sql

    CREATE TABLE `robots` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        `type` varchar(32) NOT NULL,
        `year` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    );

    CREATE TABLE `robots_parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `robots_id` int(10) NOT NULL,
        `parts_id` int(10) NOT NULL,
        `created_at` DATE NOT NULL,
        PRIMARY KEY (`id`),
        KEY `robots_id` (`robots_id`),
        KEY `parts_id` (`parts_id`)
    );

    CREATE TABLE `parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        PRIMARY KEY (`id`)
    );

* The model "Robots" has many "RobotsParts".
* The model "Parts" has many "RobotsParts".
* The model "RobotsParts" belongs to both "Robots" and "Parts" models as a many-to-one relation.
* The model "Robots" has a relation many-to-many to "Parts" through "RobotsParts"

Check the EER diagram to understand better the relations:

.. figure:: ../_static/img/eer-1.png
   :align: center

The models with their relations could be implemented as follows:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "robots_id");
        }

    }

.. code-block:: php

    <?php

    class Parts extends \Phalcon\Mvc\Model
    {

        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "parts_id");
        }

    }

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {

        public $id;

        public $robots_id;

        public $parts_id;

        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id");
            $this->belongsTo("parts_id", "Parts", "id");
        }

    }

The first parameter indicates the field of the local model used in the relationship; the second indicates the name
of the referenced model and the third the field name in the referenced model. You could also use arrays to define multiple fields in the relationship.

Many to many relationships require 3 models and define the attributes involved in the relationship:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public function initialize()
        {
            $this->hasManyToMany(
                "id",
                "RobotsParts",
                "robots_id", "parts_id",
                "Parts",
                "id"
            );
        }

    }

リレーションの活用
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When explicitly defining the relationships between models, it is easy to find related records for a particular record.

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    foreach ($robot->robotsParts as $robotPart) {
        echo $robotPart->parts->name, "\n";
    }

Phalcon uses the magic methods __set/__get/__call to store or retrieve related data using relationships.

By accesing an attribute with the same name as the relationship will retrieve all its related record(s).

.. code-block:: php

    <?php

    $robot = Robots::findFirst();
    $robotsParts = $robot->robotsParts; // all the related records in RobotsParts

Also, you can use a magic getter:

.. code-block:: php

    <?php

    $robot = Robots::findFirst();
    $robotsParts = $robot->getRobotsParts(); // all the related records in RobotsParts
    $robotsParts = $robot->getRobotsParts(array('limit' => 5)); // passing parameters

If the called method has a "get" prefix :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will return a
findFirst()/find() result. The following example compares retrieving related results with using magic methods
and without:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts then
    $robotsParts = $robot->robotsParts;

    // Only parts that match conditions
    $robotsParts = $robot->getRobotsParts("created_at = '2012-03-15'");

    // Or using bound parameters
    $robotsParts = $robot->getRobotsParts(array(
        "created_at = :date:",
        "bind" => array("date" => "2012-03-15")
    ));

    $robotPart = RobotsParts::findFirst(1);

    // RobotsParts model has a n-1 (belongsTo)
    // relationship to RobotsParts then
    $robot = $robotPart->robots;

Getting related records manually:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts, then
    $robotsParts = RobotsParts::find("robots_id = '" . $robot->id . "'");

    // Only parts that match conditions
    $robotsParts = RobotsParts::find(
        "robots_id = '" . $robot->id . "' AND created_at = '2012-03-15'"
    );

    $robotPart = RobotsParts::findFirst(1);

    // RobotsParts model has a n-1 (belongsTo)
    // relationship to RobotsParts then
    $robot = Robots::findFirst("id = '" . $robotPart->robots_id . "'");


The prefix "get" is used to find()/findFirst() related records. Depending on the type of relation it will use
'find' or 'findFirst':

+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------+
| Type                | Description                                                                                                                | Implicit Method        |
+=====================+============================================================================================================================+========================+
| Belongs-To          | Returns a model instance of the related record directly                                                                    | findFirst              |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------+
| Has-One             | Returns a model instance of the related record directly                                                                    | findFirst              |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------+
| Has-Many            | Returns a collection of model instances of the referenced model                                                            | find                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------+
| Has-Many-to-Many    | Returns a collection of model instances of the referenced model, it implicitly does 'inner joins' with the involved models | (complex query)        |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------+

You can also use "count" prefix to return an integer denoting the count of the related records:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    echo "The robot has ", $robot->countRobotsParts(), " parts\n";

Aliasing Relationships
^^^^^^^^^^^^^^^^^^^^^^
To explain better how aliases work, let's check the following example:

Table "robots_similar" has the function to define what robots are similar to others:

.. code-block:: bash

    mysql> desc robots_similar;
    +-------------------+------------------+------+-----+---------+----------------+
    | Field             | Type             | Null | Key | Default | Extra          |
    +-------------------+------------------+------+-----+---------+----------------+
    | id                | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | robots_id         | int(10) unsigned | NO   | MUL | NULL    |                |
    | similar_robots_id | int(10) unsigned | NO   |     | NULL    |                |
    +-------------------+------------------+------+-----+---------+----------------+
    3 rows in set (0.00 sec)

Both "robots_id" and "similar_robots_id" have a relation to the model Robots:

.. figure:: ../_static/img/eer-2.png
   :align: center

A model that maps this table and its relationships is the following:

.. code-block:: php

    <?php

    class RobotsSimilar extends Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo('robots_id', 'Robots', 'id');
            $this->belongsTo('similar_robots_id', 'Robots', 'id');
        }

    }

Since both relations point to the same model (Robots), obtain the records related to the relationship could not be clear:

.. code-block:: php

    <?php

    $robotsSimilar = RobotsSimilar::findFirst();

    //Returns the related record based on the column (robots_id)
    //Also as is a belongsTo it's only returning one record
    //but the name 'getRobots' seems to imply that return more than one
    $robot = $robotsSimilar->getRobots();

    //but, how to get the related record based on the column (similar_robots_id)
    //if both relationships have the same name?

The aliases allow us to rename both releationships to solve these problems:

.. code-block:: php

    <?php

    class RobotsSimilar extends Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo('robots_id', 'Robots', 'id', array(
                'alias' => 'Robot'
            ));
            $this->belongsTo('similar_robots_id', 'Robots', 'id', array(
                'alias' => 'SimilarRobot'
            ));
        }

    }

With the aliasing we can get the related records easily:

.. code-block:: php

    <?php

    $robotsSimilar = RobotsSimilar::findFirst();

    //Returns the related record based on the column (robots_id)
    $robot = $robotsSimilar->getRobot();
    $robot = $robotsSimilar->robot;

    //Returns the related record based on the column (similar_robots_id)
    $similarRobot = $robotsSimilar->getSimilarRobot();
    $similarRobot = $robotsSimilar->similarRobot;

Magic Getters vs. Explicit methods
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Most IDEs and editors with auto-completion capabilities can not infer the correct types when using magic getters,
instead of use the magic getters you can optionally define those methods explicitly with the corresponding
docblocks helping the IDE to produce a better auto-completion:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "robots_id");
        }

        /**
         * Return the related "robots parts"
         *
         * @return \RobotsParts[]
         */
        public function getRobotsParts($parameters=null)
        {
            return $this->getRelated('RobotsParts', $parameters);
        }

    }

仮想外部キー
--------------------
By default, relationships do not act like database foreign keys, that is, if you try to insert/update a value without having a valid
value in the referenced model, Phalcon will not produce a validation message. You can modify this behavior by adding a fourth parameter
when defining a relationship.

The RobotsPart model can be changed to demonstrate this feature:

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {

        public $id;

        public $robots_id;

        public $parts_id;

        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id", array(
                "foreignKey" => true
            ));

            $this->belongsTo("parts_id", "Parts", "id", array(
                "foreignKey" => array(
                    "message" => "The part_id does not exist on the Parts model"
                )
            ));
        }

    }

If you alter a belongsTo() relationship to act as foreign key, it will validate that the values inserted/updated on those fields have a
valid value on the referenced model. Similarly, if a hasMany()/hasOne() is altered it will validate that the records cannot be deleted
if that record is used on a referenced model.

.. code-block:: php

    <?php

    class Parts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "parts_id", array(
                "foreignKey" => array(
                    "message" => "The part cannot be deleted because other robots are using it"
                )
            ));
        }

    }

Cascade/Restrict actions
^^^^^^^^^^^^^^^^^^^^^^^^
Relationships that act as virtual foreign keys by default restrict the creation/update/deletion of records
to maintain the integrity of data:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model,
        Phalcon\Mvc\Model\Relation;

    class Robots extends Model
    {

        public $id;

        public $name;

        public function initialize()
        {
            $this->hasMany('id', 'Store\\Models\Parts', 'robots_id', array(
                'foreignKey' => array(
                    'action' => Relation::ACTION_CASCADE
                )
            ));
        }

    }

The above code set up to delete all the referenced records (parts) if the master record (robot) is deleted.

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
    $rowcount = Employees::count(array("distinct" => "area"));

    // How many employees are in the Testing area?
    $rowcount = Employees::count("area = 'Testing'");

    // Count employees grouping results by their area
    $group = Employees::count(array("group" => "area"));
    foreach ($group as $row) {
       echo "There are ", $row->rowcount, " in ", $row->area;
    }

    // Count employees grouping by their area and ordering the result by count
    $group = Employees::count(array(
        "group" => "area",
        "order" => "rowcount"
    ));

    // Avoid SQL injections using bound parameters
    $group = Employees::count(array(
        "type > ?0",
        "bind" => array($type)
    ));

Sum examples:

.. code-block:: php

    <?php

    // How much are the salaries of all employees?
    $total = Employees::sum(array("column" => "salary"));

    // How much are the salaries of all employees in the Sales area?
    $total = Employees::sum(array(
        "column"     => "salary",
        "conditions" => "area = 'Sales'"
    ));

    // Generate a grouping of the salaries of each area
    $group = Employees::sum(array(
        "column" => "salary",
        "group"  => "area"
    ));
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $row->area, " is ", $row->sumatory;
    }

    // Generate a grouping of the salaries of each area ordering
    // salaries from higher to lower
    $group = Employees::sum(array(
        "column" => "salary",
        "group"  => "area",
        "order"  => "sumatory DESC"
    ));

    // Avoid SQL injections using bound parameters
    $group = Employees::sum(array(
        "conditions" => "area > ?0",
        "bind" => array($area)
    ));

Average examples:

.. code-block:: php

    <?php

    // What is the average salary for all employees?
    $average = Employees::average(array("column" => "salary"));

    // What is the average salary for the Sales's area employees?
    $average = Employees::average(array(
        "column" => "salary",
        "conditions" => "area = 'Sales'"
    ));

    // Avoid SQL injections using bound parameters
    $average = Employees::average(array(
        "column" => "age",
        "conditions" => "area > ?0",
        "bind" => array($area)
    ));

Max/Min examples:

.. code-block:: php

    <?php

    // What is the oldest age of all employees?
    $age = Employees::maximum(array("column" => "age"));

    // What is the oldest of employees from the Sales area?
    $age = Employees::maximum(array(
        "column" => "age",
        "conditions" => "area = 'Sales'"
    ));

    // What is the lowest salary of all employees?
    $salary = Employees::minimum(array("column" => "salary"));

Hydration Modes
---------------
As mentioned above, resultsets are collections of complete objects, this means that every returned result is an object
representing a row in the database. These objects can be modified and saved again to persistence:

.. code-block:: php

    <?php

    // Manipulating a resultset of complete objects
    foreach (Robots::find() as $robot) {
        $robot->year = 2000;
        $robot->save();
    }

Sometimes records are obtained only to be presented to a user in read-only mode, in these cases it may be useful
to change the way in which records are represented to facilitate their handling. The strategy used to represent objects
returned in a resultset is called 'hydration mode':

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;

    $robots = Robots::find();

    //Return every robot as an array
    $robots->setHydrateMode(Resultset::HYDRATE_ARRAYS);

    foreach ($robots as $robot) {
        echo $robot['year'], PHP_EOL;
    }

    //Return every robot as an stdClass
    $robots->setHydrateMode(Resultset::HYDRATE_OBJECTS);

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

    //Return every robot as a Robots instance
    $robots->setHydrateMode(Resultset::HYDRATE_RECORDS);

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

Hydration mode can also be passed as a parameter of 'find':

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;

    $robots = Robots::find(array(
        'hydration' => Resultset::HYDRATE_ARRAYS
    ));

    foreach ($robots as $robot) {
        echo $robot['year'], PHP_EOL;
    }

レコードの作成、更新
-------------------------
The method Phalcon\\Mvc\\Model::save() allows you to create/update records according to whether they already exist in the table
associated with a model. The save method is called internally by the create and update methods of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record
should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;
    if ($robot->save() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

An array could be passed to "save" to avoid assign every column manually. Phalcon\\Mvc\\Model will check if there are setters implemented for
the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save(array(
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952
    ));

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass
an insecure array without worrying about possible SQL injections:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save($_POST);

.. highlights::

    Without precautions mass assignment could allow attackers to set any database column’s value. Only use this feature
    if you want that a user can insert/update every column in the model, even if those fields are not in the submitted
    form.

You can set an additional parameter in 'save' to set a whitelist of fields that only must taken into account when doing
the mass assignment:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save($_POST, array('name', 'type'));

確実に作成／更新する
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an application has a lot of competition, we could be expecting create a record but it is actually updated. This
could happen if we use Phalcon\\Mvc\\Model::save() to persist the records in the database. If we want to be absolutely
sure that a record is created or updated, we can change the save() call with create() or update():

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    //This record only must be created
    if ($robot->create() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }

These methods "create" and "update" also accept an array of values as parameter.

自動採番のIDカラム
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Some models may have identity columns. These columns usually are the primary key of the mapped table. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
can recognize the identity column omitting it in the generated SQL INSERT, so the database system can generate an auto-generated value for it.
Always after creating a record, the identity field will be registered with the value generated in the database system for it:

.. code-block:: php

    <?php

    $robot->save();

    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is able to recognize the identity column. Depending on the database system, those columns may be
serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence "table_field_seq",
for example: robots_id_seq, if that sequence has a different name, the method "getSequenceName" needs to be implemented:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSequenceName()
        {
            return "robots_sequence_name";
        }

    }

関連レコードの保存
^^^^^^^^^^^^^^^^^^^^^^^
Magic properties can be used to store a records and its related properties:

.. code-block:: php

    <?php

    // Create a robot
    $artist = new Artists();
    $artist->name = 'Shinichi Osawa';
    $artist->country = 'Japan';

    // Create an album
    $album = new Albums();
    $album->name = 'The One';
    $album->artist = $artist; //Assign the artist
    $album->year = 2008;

    //Save both records
    $album->save();

Saving a record and its related records in a has-many relation:

.. code-block:: php

    <?php

    // Get an existing artist
    $artist = Artists::findFirst('name = "Shinichi Osawa"');

    // Create an album
    $album = new Albums();
    $album->name = 'The One';
    $album->artist = $artist;

    $songs = array();

    // Create a first song
    $songs[0] = new Songs();
    $songs[0]->name = 'Star Guitar';
    $songs[0]->duration = '5:54';

    // Create a second song
    $songs[1] = new Songs();
    $songs[1]->name = 'Last Days';
    $songs[1]->duration = '4:29';

    // Assign the songs array
    $album->songs = $songs;

    // Save the album + its songs
    $album->save();

Saving the album and the artist at the same time implictly makes use of a transaction so if anything
goes wrong with saving the related records, the parent will not be saved either. Messages are
passed back to the user for information regarding any errors.

Note: Adding related entities by overloading the following methods is not possible:
 - Phalcon\Mvc\Model::beforeSave()
 - Phalcon\Mvc\Model::beforeCreate()
 - Phalcon\Mvc\Model::beforeUpdate()
You need to overload Phalcon\Mvc\Model::save() for this to work from within a model.


バリデーション・メッセージ
^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the insert/update processes.

Each message consists of an instance of the class :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the method getMessages(). Each message provides extended information like the field name that
generated the message or the message type:

.. code-block:: php

    <?php

    if ($robot->save() == false) {
        foreach ($robot->getMessages() as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` can generate the following types of validation messages:

+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                 | Description                                                                                                                        |
+======================+====================================================================================================================================+
| PresenceOf           | Generated when a field with a non-null attribute on the database is trying to insert/update a null value                           |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation  | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidValue         | Generated when a validator failed because of an invalid value                                                                      |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidCreateAttempt | Produced when a record is attempted to be created but it already exists                                                            |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidUpdateAttempt | Produced when a record is attempted to be updated but it doesn't exist                                                             |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+

The method getMessages() can be overriden in a model to replace/translate the default messages generated automatically by the ORM:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public function getMessages()
        {
            $messages = array();
            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case 'InvalidCreateAttempt':
                        $messages[] = 'The record cannot be created because it already exists';
                        break;
                    case 'InvalidUpdateAttempt':
                        $messages[] = 'The record cannot be updated because it already exists';
                        break;
                    case 'PresenceOf':
                        $messages[] = 'The field ' . $message->getField() . ' is mandatory';
                        break;
                }
            }
            return $messages;
        }
    }

イベントとイベント・マネージャ
^^^^^^^^^^^^^^^^^^^^^^^^^
Models allow you to implement events that will be thrown when performing an insert/update/delete. They help define business rules for a
certain model. The following are the events supported by :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` and their order of execution:

+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Operation          | Name                     | Can stop operation?   | Explanation                                                                                                                       |
+====================+==========================+=======================+===================================================================================================================================+
| Inserting/Updating | beforeValidation         | YES                   | Is executed before the fields are validated for not nulls/empty strings or foreign keys                                           |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeValidationOnCreate | YES                   | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an insertion operation is being made |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeValidationOnUpdate | YES                   | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made  |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | onValidationFails        | YES (already stopped) | Is executed after an integrity validator fails                                                                                    |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterValidationOnCreate  | YES                   | Is executed after the fields are validated for not nulls/empty strings or foreign keys when an insertion operation is being made  |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | afterValidationOnUpdate  | YES                   | Is executed after the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made   |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterValidation          | YES                   | Is executed after the fields are validated for not nulls/empty strings or foreign keys                                            |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | beforeSave               | YES                   | Runs before the required operation over the database system                                                                       |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeUpdate             | YES                   | Runs before the required operation over the database system only when an updating operation is being made                         |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeCreate             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made                        |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | afterUpdate              | NO                    | Runs after the required operation over the database system only when an updating operation is being made                          |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterCreate              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made                         |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterSave                | NO                    | Runs after the required operation over the database system                                                                        |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+

モデルクラス内でのイベントの実装
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The easier way to make a model react to events is implement a method with the same name of the event in the model's class:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeValidationOnCreate()
        {
            echo "This is executed before creating a Robot!";
        }

    }

Events can be useful to assign values before performing an operation, for example:

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            //Set the creation date
            $this->created_at = date('Y-m-d H:i:s');
        }

        public function beforeUpdate()
        {
            //Set the modification date
            $this->modified_in = date('Y-m-d H:i:s');
        }

    }

カスタムイベントマネージャの使用
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Additionally, this component is integrated with :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`,
this means we can create listeners that run when an event is triggered.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model,
        Phalcon\Events\Manager as EventsManager;

    class Robots extends Model
    {

        public function initialize()
        {

            $eventsManager = new EventsManager();

            //Attach an anonymous function as a listener for "model" events
            $eventsManager->attach('model', function($event, $robot) {
                if ($event->getType() == 'beforeSave') {
                    if ($robot->name == 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";
                        return false;
                    }
                }
                return true;
            });

            //Attach the events manager to the event
            $this->setEventsManager($eventsManager);
        }

    }

In the example given above, EventsManager only acts as a bridge between an object and a listener (the anonymous function).
Events will be fired to the listener when 'robots' are saved:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Scooby Doo';
    $robot->year = 1969;
    $robot->save();

If we want all objects created in our application use the same EventsManager, then we need to assign it to the Models Manager:

.. code-block:: php

    <?php

    //Registering the modelsManager service
    $di->setShared('modelsManager', function() {

        $eventsManager = new \Phalcon\Events\Manager();

        //Attach an anonymous function as a listener for "model" events
        $eventsManager->attach('model', function($event, $model){

            //Catch events produced by the Robots model
            if (get_class($model) == 'Robots') {

                if ($event->getType() == 'beforeSave') {
                    if ($modle->name == 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";
                        return false;
                    }
                }

            }
            return true;
        });

        //Setting a default EventsManager
        $modelsManager = new ModelsManager();
        $modelsManager->setEventsManager($eventsManager);
        return $modelsManager;
    });

If a listener returns false that will stop the operation that is executing currently.

ビジネス・ルールの実装
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an insert, update or delete is executed, the model verifies if there are any methods with the names of
the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation
from being exposed publicly.

The following example implements an event that validates the year cannot be smaller than 0 on update or insert:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";
                return false;
            }
        }

    }

Some events return false as an indication to stop the current operation. If an event doesn't return anything, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
will assume a true value.

データ整合性の検証
^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides several events to validate data and implement business rules. The special "validation"
event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.

The following example shows how to use it:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\InclusionIn,
        Phalcon\Mvc\Model\Validator\Uniqueness;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function validation()
        {

            $this->validate(new InclusionIn(
                array(
                    "field"  => "type",
                    "domain" => array("Mechanical", "Virtual")
                )
            ));

            $this->validate(new Uniqueness(
                array(
                    "field"   => "name",
                    "message" => "The robot name must be unique"
                )
            ));

            return $this->validationHasFailed() != true;
        }

    }

The above example performs a validation using the built-in validator "InclusionIn". It checks the value of the field "type" in a domain list. If
the value is not included in the method then the validator will fail and return false. The following built-in validators are available:

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Name         | Explanation                                                                                                                                                      | Example                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Validates that a field's value isn't null or empty string. This validator is automatically added based on the attributes marked as not null on the mapped table  | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_PresenceOf>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Email        | Validates that field contains a valid email format                                                                                                               | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Email>`         |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                                                   | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Exclusionin>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Validates that a value is within a list of possible values                                                                                                       | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Inclusionin>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Numericality | Validates that a field has a numeric format                                                                                                                      | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Numericality>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Validates that the value of a field matches a regular expression                                                                                                 | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Regex>`         |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Uniqueness   | Validates that a field or a combination of a set of fields are not present more than once in the existing records of the related table                           | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Uniqueness>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Validates the length of a string                                                                                                                                 | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_StringLength>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Url          | Validates that a value has a valid URL format                                                                                                                    | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Url>`           |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

In addition to the built-in validatiors, you can create your own validators:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator,
        Phalcon\Mvc\Model\ValidatorInterface;

    class MaxMinValidator extends Validator implements ValidatorInterface
    {

        public function validate($model)
        {
            $field = $this->getOption('field');

            $min = $this->getOption('min');
            $max = $this->getOption('max');

            $value = $model->$field;

            if ($min <= $value && $value <= $max) {
                $this->appendMessage(
                    "The field doesn't have the right range of values",
                    $field,
                    "MaxMinValidator"
                );
                return false;
            }
            return true;
        }

    }

Adding the validator to a model:

.. code-block:: php

    <?php

    class Customers extends \Phalcon\Mvc\Model
    {

        public function validation()
        {
            $this->validate(new MaxMinValidator(
                array(
                    "field"  => "price",
                    "min" => 10,
                    "max" => 100
                )
            ));
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }

The idea of creating validators is make them reusable between several models. A validator can also be as simple as:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model,
        Phalcon\Mvc\Model\Message;

    class Robots extends Model
    {

        public function validation()
        {
            if ($this->type == "Old") {
                $message = new Message(
                    "Sorry, old robots are not allowed anymore",
                    "type",
                    "MyType"
                );
                $this->appendMessage($message);
                return false;
            }
            return true;
        }

    }

SQLインジェクションの回避
^^^^^^^^^^^^^^^^^^^^^^^
Every value assigned to a model attribute is escaped depending of its data type. A developer doesn't need to escape manually
each value before storing it on the database. Phalcon uses internally the `bound parameters <http://php.net/manual/en/pdostatement.bindparam.php>`_
capability provided by PDO to automatically escape every value to be stored in the database.

.. code-block:: bash

    mysql> desc products;
    +------------------+------------------+------+-----+---------+----------------+
    | Field            | Type             | Null | Key | Default | Extra          |
    +------------------+------------------+------+-----+---------+----------------+
    | id               | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | product_types_id | int(10) unsigned | NO   | MUL | NULL    |                |
    | name             | varchar(70)      | NO   |     | NULL    |                |
    | price            | decimal(16,2)    | NO   |     | NULL    |                |
    | active           | char(1)          | YES  |     | NULL    |                |
    +------------------+------------------+------+-----+---------+----------------+
    5 rows in set (0.00 sec)

If we use just PDO to store a record in a secure way, we need to write the following code:

.. code-block:: php

    <?php

    $productTypesId = 1;
    $name = 'Artichoke';
    $price = 10.5;
    $active = 'Y';

    $sql = 'INSERT INTO products VALUES (null, :productTypesId, :name, :price, :active)';
    $sth = $dbh->prepare($sql);

    $sth->bindParam(':productTypesId', $productTypesId, PDO::PARAM_INT);
    $sth->bindParam(':name', $name, PDO::PARAM_STR, 70);
    $sth->bindParam(':price', doubleval($price));
    $sth->bindParam(':active', $active, PDO::PARAM_STR, 1);

    $sth->execute();

The good news is that Phalcon do this for you automatically:

.. code-block:: php

    <?php

    $product = new Products();
    $product->product_types_id = 1;
    $product->name = 'Artichoke';
    $product->price = 10.5;
    $product->active = 'Y';
    $product->create();

Skipping Columns
----------------
To tell Phalcon\\Mvc\\Model that always omits some fields in the creation and/or update of records in order
to delegate the database system the assignation of the values by a trigger or a default:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            //Skips fields/columns on both INSERT/UPDATE operations
            $this->skipAttributes(array('year', 'price'));

            //Skips only when inserting
            $this->skipAttributesOnCreate(array('created_at'));

            //Skips only when updating
            $this->skipAttributesOnUpdate(array('modified_in'));
        }

    }

This will ignore globally these fields on each INSERT/UPDATE operation on the whole application.
Forcing a default value can be done in the following way:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Bender';
    $robot->year = 1999;
    $robot->created_at = new \Phalcon\Db\RawValue('default');
    $robot->create();

A callback also can be used to create a conditional assigment of automatic default values:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model,
        Phalcon\Db\RawValue;

    class Robots extends Model
    {
        public function beforeCreate()
        {
            if ($this->price > 10000) {
                $this->type = new RawValue('default');
            }
        }
    }

.. highlights::

    Never use a \\Phalcon\\Db\\RawValue to assign external data (such as user input)
    or variable data. The value of these fields is ignored when binding parameters to the query.
    So it could be used to attack the application injecting SQL.

Dynamic Update
^^^^^^^^^^^^^^
SQL UPDATE statements are by default created with every column defined in the model (full all-field SQL update).
You can change specific models to make dynamic updates, in this case, just the fields that had changed
are used to create the final SQL statement.

In some cases this could improve the performance by reducing the traffic between the application and the database server,
this specially helps when the table has blob/text fields:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->useDynamicUpdate(true);
        }
    }

レコードの削除
----------------
The method Phalcon\\Mvc\\Model::delete() allows to delete a record. You can use it as follows:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(11);
    if ($robot != false) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

You can also delete many records by traversing a resultset with a foreach:

.. code-block:: php

    <?php

    foreach (Robots::find("type='mechanical'") as $robot) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
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

    class Robots extends Phalcon\Mvc\Model
    {

        public function beforeDelete()
        {
            if ($this->status == 'A') {
                echo "The robot is active, it can't be deleted";
                return false;
            }
            return true;
        }

    }

バリデーション失敗のイベント
------------------------
Another type of events are available when the data validation process finds any inconsistency:

+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSave            | Triggered when the INSERT or UPDATE operation fails for any reason |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+

振る舞い(ビヘイビア)
---------
Behaviors are shared conducts that several models may adopt in order to re-use code, the ORM provides an API to implement
behaviors in your models. Also, you can use the events and callbacks as seen before as an alternative to implement Behaviors with more freedom.

A behavior must be added in the model initializer, a model can have zero or more behaviors:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior\Timestampable;

    class Users extends \Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public $created_at;

        public function initialize()
        {
            $this->addBehavior(new Timestampable(
                array(
                    'beforeCreate' => array(
                        'field' => 'created_at',
                        'format' => 'Y-m-d'
                    )
                )
            ));
        }

    }

The following built-in behaviors are provided by the framework:

+----------------+-------------------------------------------------------------------------------------------------------------------------------+
| Name           | Description                                                                                                                   |
+================+===============================================================================================================================+
| Timestampable  | Allows to automatically update a model's attribute saving the datetime when a record is created or updated                    |
+----------------+-------------------------------------------------------------------------------------------------------------------------------+
| SoftDelete     | Instead of permanently delete a record it marks the record as deleted changing the value of a flag column                     |
+----------------+-------------------------------------------------------------------------------------------------------------------------------+

タイムスタンプ化
^^^^^^^^^^^^^
This behavior receives an array of options, the first level key must be an event name indicating when the column must be assigned:

.. code-block:: php

    <?php

    public function initialize()
    {
        $this->addBehavior(new Timestampable(
            array(
                'beforeCreate' => array(
                    'field' => 'created_at',
                    'format' => 'Y-m-d'
                )
            )
        ));
    }

Each event can have its own options, 'field' is the name of the column that must be updated, if 'format' is a string it will be used
as format of the PHP's function date_, format can also be an anonymous function providing you the free to generate any kind timestamp:

.. code-block:: php

    <?php

    public function initialize()
    {
        $this->addBehavior(new Timestampable(
            array(
                'beforeCreate' => array(
                    'field' => 'created_at',
                    'format' => function() {
                        $datetime = new Datetime(new DateTimeZone('Europe/Stockholm'));
                        return $datetime->format('Y-m-d H:i:sP');
                    }
                )
            )
        ));
    }

If the option 'format' is omitted a timestamp using the PHP's function time_, will be used.

論理削除
^^^^^^^^^^
This behavior can be used in the following way:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior\SoftDelete;

    class Users extends \Phalcon\Mvc\Model
    {

        const DELETED = 'D';

        const NOT_DELETED = 'N';

        public $id;

        public $name;

        public $status;

        public function initialize()
        {
            $this->addBehavior(new SoftDelete(
                array(
                    'field' => 'status',
                    'value' => Users::DELETED
                )
            ));
        }

    }

This behavior accepts two options: 'field' and 'value', 'field' determines what field must be updated and 'value' the value to be deleted.
Let's pretend the table 'users' has the following data:

.. code-block:: bash

    mysql> select * from users;
    +----+---------+--------+
    | id | name    | status |
    +----+---------+--------+
    |  1 | Lana    | N      |
    |  2 | Brandon | N      |
    +----+---------+--------+
    2 rows in set (0.00 sec)

If we delete any of the two records the status will be updated instead of delete the record:

.. code-block:: php

    <?php

    Users::findFirst(2)->delete();

The operation will result in the following data in the table:

.. code-block:: bash

    mysql> select * from users;
    +----+---------+--------+
    | id | name    | status |
    +----+---------+--------+
    |  1 | Lana    | N      |
    |  2 | Brandon | D      |
    +----+---------+--------+
    2 rows in set (0.01 sec)

Note that you need to specify the deleted condition in your queries to effectively ignore them as deleted records, this behavior doesn't support that.

独自の振る舞いの作成
^^^^^^^^^^^^^^^^^^^^^^^^^^^
The ORM provides an API to create your own behaviors. A behavior must be a class implementing the :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <../api/Phalcon_Mvc_Model_BehaviorInterface>`
Also, Phalon\\Mvc\\Model\\Behavior provides most of the methods needed to ease the implementation of behaviors.

The following behavior is an example, it implements the Blamable behavior which helps identify the user
that is performed operations over a model:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior;
        Phalcon\Mvc\Model\BehaviorInterface;

    class Blameable extends Behavior implements BehaviorInterface
    {

        public function notify($eventType, $model)
        {
            switch ($eventType) {

                case 'afterCreate':
                case 'afterDelete':
                case 'afterUpdate':


                    $userName = // ... get the current user from session

                    //Store in a log the username - event type and primary key
                    file_put_contents(
                        'logs/blamable-log.txt',
                        $userName . ' ' . $eventType . ' ' . $model->id
                    );

                    break;

                default:
                    /* ignore the rest of events */
            }
        }

    }

The former is a very simple behavior, but it illustrates how to create a behavior, now let's add this behavior to a model:

.. code-block:: php

    <?php

    class Profiles extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->addBehavior(new Blamable());
        }

    }

A behavior is also capable of intercept missing methods on your models:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior,
        Phalcon\Mvc\Model\BehaviorInterface;

    class Sluggable extends Behavior implements BehaviorInterface
    {

        public function missingMethod($model, $method, $arguments=array())
        {
            // if the method is 'getSlug' convert the title
            if ($method == 'getSlug') {
                return Phalcon\Tag::friendlyTitle($model->title);
            }
        }

    }

Call that method on a model that implements Sluggable returns a SEO friendly title:

.. code-block:: php

    <?php

    $title = $post->getSlug();

振る舞いとしてのトレイトの使用
^^^^^^^^^^^^^^^^^^^^^^^^^
Starting from PHP 5.4 you can use Traits_ to re-use code in your classes, this is another way to implement
custom behaviors. The following trait implements a simple version of the Timestampable behavior:

.. code-block:: php

    <?php

    trait MyTimestampable
    {

        public function beforeCreate()
        {
            $this->created_at = date('r');
        }

        public function beforeUpdate()
        {
            $this->updated_at = date('r');
        }

    }

Then you can use it in your model as follows:

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {
        use MyTimestampable;
    }

トランザクション
------------
When a process performs multiple database operations, it is often that each step is completed successfully so that data integrity can
be maintained. Transactions offer the ability to ensure that all database operations have been executed successfully before the data
are committed to the database.

Transactions in Phalcon allow you to commit all operations if they have been executed successfully or rollback
all operations if something went wrong.

手動のトランザクション
^^^^^^^^^^^^^^^^^^^
If an application only uses one connection and the transactions aren't very complex, a transaction can be
created by just moving the current connection to transaction mode, doing a rollback or commit if the operation
is successfully or not:

.. code-block:: php

    <?php

    class RobotsController extends Phalcon\Mvc\Controller
    {
        public function saveAction()
        {
            $this->db->begin();

            $robot = new Robots();

            $robot->name = "WALL·E";
            $robot->created_at = date("Y-m-d");
            if ($robot->save() == false) {
                $this->db->rollback();
                return;
            }

            $robotPart = new RobotParts();
            $robotPart->robots_id = $robot->id;
            $robotPart->type = "head";
            if ($robotPart->save() == false) {
                $this->db->rollback();
                return;
            }

            $this->db->commit();
        }
    }

暗黙的なトランザクション
^^^^^^^^^^^^^^^^^^^^^
Existing relationships can be used to store records and their related instances, this kind of operation
implicitly creates a transaction to ensure that data are correctly stored:

.. code-block:: php

    <?php

    $robotPart = new RobotParts();
    $robotPart->type = "head";

    $robot = new Robots();
    $robot->name = "WALL·E";
    $robot->created_at = date("Y-m-d");
    $robot->robotPart = $robotPart;

    $robot->save(); //Creates an implicit transaction to store both records

Isolated Transactions
^^^^^^^^^^^^^^^^^^^^^
Isolated transactions are executed in a new connection ensuring that all the generated SQL,
virtual foreign key checks and business rules are isolated from the main connection.
This kind of transaction requires a transaction manager that globally manages each
transaction created ensuring that they are correctly rolled back/committed before ending the request:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TxManager,
        Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {

        //Create a transaction manager
        $manager = new TxManager();

        // Request a transaction
        $transaction = $manager->get();

        $robot = new Robots();
        $robot->setTransaction($transaction);
        $robot->name = "WALL·E";
        $robot->created_at = date("Y-m-d");
        if ($robot->save() == false) {
            $transaction->rollback("Cannot save robot");
        }

        $robotPart = new RobotParts();
        $robotPart->setTransaction($transaction);
        $robotPart->robots_id = $robot->id;
        $robotPart->type = "head";
        if ($robotPart->save() == false) {
            $transaction->rollback("Cannot save robot part");
        }

        //Everything goes fine, let's commit the transaction
        $transaction->commit();

    } catch(TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

Transactions can be used to delete many records in a consistent way:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TxManager,
        Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {

        //Create a transaction manager
        $manager = new TxManager();

        //Request a transaction
        $transaction = $manager->get();

        //Get the robots will be deleted
        foreach (Robots::find("type = 'mechanical'") as $robot) {
            $robot->setTransaction($transaction);
            if ($robot->delete() == false) {
                //Something goes wrong, we should to rollback the transaction
                foreach ($robot->getMessages() as $message) {
                    $transaction->rollback($message->getMessage());
                }
            }
        }

        //Everything goes fine, let's commit the transaction
        $transaction->commit();

        echo "Robots were deleted successfully!";

    } catch(TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

Transactions are reused no matter where the transaction object is retrieved. A new transaction is generated only when a commit() or rollback()
is performed. You can use the service container to create the global transaction manager for the entire application:

.. code-block:: php

    <?php

    $di->setShared('transactions', function(){
        return new \Phalcon\Mvc\Model\Transaction\Manager();
    });

Then access it from a controller or view:

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function saveAction()
        {

            //Obtain the TransactionsManager from the services container
            $manager = $this->di->getTransactions();

            //Or
            $manager = $this->transactions;

            //Request a transaction
            $transaction = $manager->get();

            //...
        }

    }

While a transaction is active, the transaction manager will always return the same transaction across the application.

Independent Column Mapping
--------------------------
The ORM supports an independent column map, which allows the developer to use different column names in the model to the ones in
the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database.
This is a great feature when one needs to rename fields in the database without having to worry about all the queries
in the code. A change in the column map in the model will take care of the rest. For example:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function columnMap()
        {
            //Keys are the real names in the table and
            //the values their names in the application
            return array(
                'id' => 'code',
                'the_name' => 'theName',
                'the_type' => 'theType',
                'the_year' => 'theYear'
            );
        }

    }

Then you can use the new names naturally in your code:

.. code-block:: php

    <?php

    //Find a robot by its name
    $robot = Robots::findFirst("theName = 'Voltron'");
    echo $robot->theName, "\n";

    //Get robots ordered by type
    $robot = Robots::find(array('order' => 'theType DESC'));
    foreach ($robots as $robot) {
        echo 'Code: ', $robot->code, "\n";
    }

    //Create a robot
    $robot = new Robots();
    $robot->code = '10101';
    $robot->theName = 'Bender';
    $robot->theType = 'Industrial';
    $robot->theYear = 2999;
    $robot->save();

Take into consideration the following the next when renaming your columns:

* References to attributes in relationships/validators must use the new names
* Refer the real column names will result in an exception by the ORM

The independent column map allow you to:

* Write applications using your own conventions
* Eliminate vendor prefixes/suffixes in your code
* Change column names without change your application code

結果セットの操作
--------------------------
If a resultset is composed of complete objects, the resultset is in the ability to perform operations on the records obtained in a simple manner:

関連するレコードの更新
^^^^^^^^^^^^^^^^^^^^^^^^
Instead of doing this:

.. code-block:: php

    <?php

    foreach ($robots->getParts() as $part) {
        $part->stock = 100;
        $part->updated_at = time();
        if ($part->update() == false) {
            foreach ($part->getMessages() as $message) {
                echo $message;
            }
            break;
        }
    }

you can do this:

.. code-block:: php

    <?php

    $robots->getParts()->update(array(
        'stock' => 100,
        'updated_at' => time()
    ));

'update' also accepts an anonymous function to filter what records must be updated:

.. code-block:: php

    <?php

    $data = array(
        'stock' => 100,
        'updated_at' => time()
    );

    //Update all the parts except these whose type is basic
    $robots->getParts()->update($data, function($part) {
        if ($part->type == Part::TYPE_BASIC) {
            return false;
        }
        return true;
    });

関連するレコードの削除
^^^^^^^^^^^^^^^^^^^^^^^^
Instead of doing this:

.. code-block:: php

    <?php

    foreach ($robots->getParts() as $part) {
        if ($part->delete() == false) {
            foreach ($part->getMessages() as $message) {
                echo $message;
            }
            break;
        }
    }

you can do this:

.. code-block:: php

    <?php

    $robots->getParts()->delete();

'delete' also accepts an anonymous function to filter what records must be deleted:

.. code-block:: php

    <?php

    //Delete only whose stock is greater or equal than zero
    $robots->getParts()->delete(function($part) {
        if ($part->stock < 0) {
            return false;
        }
        return true;
    });


レコードのスナップショット
----------------
Specific models could be set to maintain a record snapshot when they’re queried. You can use this feature to implement auditing or just to know what
fields are changed according to the data queried from the persistence:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->keepSnapshots(true);
        }
    }

When activating this feature the application consumes a bit more of memory to keep track of the original values obtained from the persistence.
In models that have this feature activated you can check what fields changed:

.. code-block:: php

    <?php

    //Get a record from the database
    $robot = Robots::findFirst();

    //Change a column
    $robot->name = 'Other name';

    var_dump($robot->getChangedFields()); // ['name']
    var_dump($robot->hasChanged('name')); // true
    var_dump($robot->hasChanged('type')); // false

モデルのメタデータ
----------------
To speed up development :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` helps you to query fields and constraints from tables
related to models. To achieve this, :doc:`Phalcon\\Mvc\\Model\\MetaData <../api/Phalcon_Mvc_Model_MetaData>` is available to manage
and cache table meta-data.

Sometimes it is necessary to get those attributes when working with models. You can get a meta-data instance as follows:

.. code-block:: php

    <?php

    $robot = new Robots();

    // Get Phalcon\Mvc\Model\Metadata instance
    $metaData = $robot->getModelsMetaData();

    // Get robots fields names
    $attributes = $metaData->getAttributes($robot);
    print_r($attributes);

    // Get robots fields data types
    $dataTypes = $metaData->getDataTypes($robot);
    print_r($dataTypes);

メタデータのキャッシュ
^^^^^^^^^^^^^^^^^
Once the application is in a production stage, it is not necessary to query the meta-data of the table from the database system each
time you use the table. This could be done caching the meta-data using any of the following adapters:

+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Adapter | Description                                                                                                                                                                                                                                                                                                                                   | API                                                                                       |
+=========+===============================================================================================================================================================================================================================================================================================================================================+===========================================================================================+
| Memory  | This adapter is the default. The meta-data is cached only during the request. When the request is completed, the meta-data are released as part of the normal memory of the request. This adapter is perfect when the application is in development so as to refresh the meta-data in each request containing the new and/or modified fields. | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`   |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Session | This adapter stores meta-data in the $_SESSION superglobal. This adapter is recommended only when the application is actually using a small number of models. The meta-data are refreshed every time a new session starts. This also requires the use of session_start() to start the session before using any models.                        | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Session <../api/Phalcon_Mvc_Model_MetaData_Session>` |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Apc     | This adapter uses the `Alternative PHP Cache (APC)`_ to store the table meta-data. You can specify the lifetime of the meta-data with options. This is the most recommended way to store meta-data when the application is in production stage.                                                                                               | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Apc <../api/Phalcon_Mvc_Model_MetaData_Apc>`         |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| XCache  | This adapter uses `XCache`_ to store the table meta-data. You can specify the lifetime of the meta-data with options. This is the most recommended way to store meta-data when the application is in production stage.                                                                                                                        | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Xcache <../api/Phalcon_Mvc_Model_MetaData_Xcache>`   |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Files   | This adapter uses plain files to store meta-data. By using this adapter the disk-reading is increased but the database access is reduced                                                                                                                                                                                                      | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Files <../api/Phalcon_Mvc_Model_MetaData_Files>`     |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+

As other ORM's dependencies, the metadata manager is requested from the services container:

.. code-block:: php

    <?php

    $di['modelsMetadata'] = function() {

        // Create a meta-data manager with APC
        $metaData = new \Phalcon\Mvc\Model\MetaData\Apc(array(
            "lifetime" => 86400,
            "prefix"   => "my-prefix"
        ));

        return $metaData;
    };

メタデータの取得方法
^^^^^^^^^^^^^^^^^^^^
As mentioned above the default strategy to obtain the model's meta-data is database introspection. In this strategy, the information
schema is used to know the fields in a table, its primary key, nullable fields, data types, etc.

You can change the default meta-data introspection in the following way:

.. code-block:: php

    <?php

    $di['modelsMetadata'] = function() {

        // Instantiate a meta-data adapter
        $metaData = new \Phalcon\Mvc\Model\MetaData\Apc(array(
            "lifetime" => 86400,
            "prefix"   => "my-prefix"
        ));

        //Set a custom meta-data introspection strategy
        $metaData->setStrategy(new MyInstrospectionStrategy());

        return $metaData;
    };

データベースの内部構造から取得する方法
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
This strategy doesn't require any customization and is implicitly used by all the meta-data adapters.

アノテーションによる方法
^^^^^^^^^^^^^^^^^^^^
This strategy makes use of :doc:`annotations <annotations>` to describe the columns in a model:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        /**
         * @Primary
         * @Identity
         * @Column(type="integer", nullable=false)
         */
        public $id;

        /**
         * @Column(type="string", length=70, nullable=false)
         */
        public $name;

        /**
         * @Column(type="string", length=32, nullable=false)
         */
        public $type;

        /**
         * @Column(type="integer", nullable=false)
         */
        public $year;

    }

Annotations must be placed in properties that are mapped to columns in the mapped source. Properties without the @Column annotation
are handled as simple class attributes.

The following annotations are supported:

+----------+-------------------------------------------------------+
| Name     | Description                                           |
+==========+=======================================================+
| Primary  | Mark the field as part of the table's primary key     |
+----------+-------------------------------------------------------+
| Identity | The field is an auto_increment/serial column          |
+----------+-------------------------------------------------------+
| Column   | This marks an attribute as a mapped column            |
+----------+-------------------------------------------------------+

The annotation @Column supports the following parameters:

+----------+-------------------------------------------------------+
| Name     | Description                                           |
+==========+=======================================================+
| type     | The column's type (string, integer, decimal, boolean) |
+----------+-------------------------------------------------------+
| length   | The column's length if any                            |
+----------+-------------------------------------------------------+
| nullable | Set whether the column accepts null values or not     |
+----------+-------------------------------------------------------+

The annotations strategy could be set up this way:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData,
        Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;

    $di['modelsMetadata'] = function() {

        // Instantiate a meta-data adapter
        $metaData = new ApcMetaData(array(
            "lifetime" => 86400,
            "prefix"   => "my-prefix"
        ));

        //Set a custom meta-data database introspection
        $metaData->setStrategy(new StrategyAnnotations());

        return $metaData;
    };

手動によるメタデータの管理
^^^^^^^^^^^^^^^^
Phalcon can obtain the metadata for each model automatically without the developer must set them manually
using any of the introspection strategies presented above.

The developer also has the option of define the metadata manually. This strategy overrides
any strategy set in the  meta-data manager. New columns added/modified/removed to/from the mapped
table must be added/modified/removed also for everything to work properly.

The following example shows how to define the meta-data manually:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model,
        Phalcon\Db\Column,
        Phalcon\Mvc\Model\MetaData;

    class Robots extends Model
    {

        public function metaData()
        {
            return array(

                //Every column in the mapped table
                MetaData::MODELS_ATTRIBUTES => array(
                    'id', 'name', 'type', 'year'
                ),

                //Every column part of the primary key
                MetaData::MODELS_PRIMARY_KEY => array(
                    'id'
                ),

                //Every column that isn't part of the primary key
                MetaData::MODELS_NON_PRIMARY_KEY => array(
                    'name', 'type', 'year'
                ),

                //Every column that doesn't allows null values
                MetaData::MODELS_NOT_NULL => array(
                    'id', 'name', 'type', 'year'
                ),

                //Every column and their data types
                MetaData::MODELS_DATA_TYPES => array(
                    'id' => Column::TYPE_INTEGER,
                    'name' => Column::TYPE_VARCHAR,
                    'type' => Column::TYPE_VARCHAR,
                    'year' => Column::TYPE_INTEGER
                ),

                //The columns that have numeric data types
                MetaData::MODELS_DATA_TYPES_NUMERIC => array(
                    'id' => true,
                    'year' => true,
                ),

                //The identity column, use boolean false if the model doesn't have
                //an identity column
                MetaData::MODELS_IDENTITY_COLUMN => 'id',

                //How every column must be bound/casted
                MetaData::MODELS_DATA_TYPES_BIND => array(
                    'id' => Column::BIND_PARAM_INT,
                    'name' => Column::BIND_PARAM_STR,
                    'type' => Column::BIND_PARAM_STR,
                    'year' => Column::BIND_PARAM_INT,
                ),

                //Fields that must be ignored from INSERT SQL statements
                MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => array(
                    'year' => true
                ),

                //Fields that must be ignored from UPDATE SQL statements
                MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => array(
                    'year' => true
                )

            );
        }

    }

別のスキーマの指定
------------------------------
If a model is mapped to a table that is in a different schemas/databases than the default. You can use the getSchema method to define that:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSchema()
        {
            return "toys";
        }

    }

複数のデータベースの設定
--------------------------
In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` needs to connect to the database it requests the "db" service
in the application's services container. You can overwrite this service setting it in the initialize method:

.. code-block:: php

    <?php

    //This service returns a MySQL database
    $di->set('dbMysql', function() {
         return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //This service returns a PostgreSQL database
    $di->set('dbPostgres', function() {
         return new \Phalcon\Db\Adapter\Pdo\PostgreSQL(array(
            "host" => "localhost",
            "username" => "postgres",
            "password" => "",
            "dbname" => "invo"
        ));
    });

Then, in the Initialize method, we define the connection service for the model:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setConnectionService('dbPostgres');
        }

    }

But Phalcon offers you more flexibility, you can define the connection that must be used to 'read' and for 'write'. This is specially useful
to balance the load to your databases implementing a master-slave architecture:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setReadConnectionService('dbSlave');
            $this->setWriteConnectionService('dbMaster');
        }

    }

The ORM also provides Horizontal Sharding facilities, by allowing you to implement a 'shard' selection
according to the current query conditions:

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        /**
         * Dynamically selects a shard
         *
         * @param array $intermediate
         * @param array $bindParams
         * @param array $bindTypes
         */
        public function selectReadConnection($intermediate, $bindParams, $bindTypes)
        {
            //Check if there is a 'where' clause in the select
            if (isset($intermediate['where'])) {

                $conditions = $intermediate['where'];

                //Choose the possible shard according to the conditions
                if ($conditions['left']['name'] == 'id') {
                    $id = $conditions['right']['value'];
                    if ($id > 0 && $id < 10000) {
                        return $this->getDI()->get('dbShard1');
                    }
                    if ($id > 10000) {
                        return $this->getDI()->get('dbShard2');
                    }
                }
            }

            //Use a default shard
            return $this->getDI()->get('dbShard0');
        }

    }

The method 'selectReadConnection' is called to choose the right connection, this method intercepts any new
query executed:

.. code-block:: php

    <?php

    $robot = Robots::findFirst('id = 101');

低レベルのSQL文のロギング
--------------------------------
When using high-level abstraction components such as :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to access a database, it is
difficult to understand which statements are finally sent to the database system. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
is supported internally by :doc:`Phalcon\\Db <../api/Phalcon_Db>`. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts
with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer, thus allowing us to log SQL
statements as they happen.

.. code-block:: php

    <?php

    use Phalcon\Logger,
        Phalcon\Db\Adapter\Pdo\Mysql as Connection,
        Phalcon\Events\Manager,
        Phalcon\Logger\Adapter\File;

    $di->set('db', function() {

        $eventsManager = new EventsManager();

        $logger = new Logger("app/logs/debug.log");

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                $logger->log($connection->getSQLStatement(), Logger::INFO);
            }
        });

        $connection = new Connection(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));

        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    });

As models access the default database connection, all SQL statements that are sent to the database system will be logged in the file:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = "Robby the Robot";
    $robot->created_at = "1956-07-21";
    if ($robot->save() == false) {
        echo "Cannot save robot";
    }

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots
    (name, created_at) VALUES ('Robby the Robot', '1956-07-21')

SQL文のプロファイリング
------------------------
Thanks to :doc:`Phalcon\\Db <../api/Phalcon_Db>`, the underlying component of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`,
it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. With
this you can diagnose performance problems and to discover bottlenecks.

.. code-block:: php

    <?php

    $di->set('profiler', function(){
        return new \Phalcon\Db\Profiler();
    }, true);

    $di->set('db', function() use ($di) {

        $eventsManager = new \Phalcon\Events\Manager();

        //Get a shared instance of the DbProfiler
        $profiler = $di->getProfiler();

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($profiler) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();
            }
        });

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));

        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    });

Profiling some queries:

.. code-block:: php

    <?php

    // Send some SQL statements to the database
    Robots::find();
    Robots::find(array("order" => "name"));
    Robots::find(array("limit" => 30));

    //Get the generated profiles from the profiler
    $profiles = $di->get('profiler')->getProfiles();

    foreach ($profiles as $profile) {
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Each generated profile contains the duration in miliseconds that each instruction takes to complete as well as the generated SQL statement.

Injecting services into Models
------------------------------
You may be required to access the application services within a model, the following example explains how to do that:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function notSave()
        {
            //Obtain the flash service from the DI container
            $flash = $this->getDI()->getFlash();

            //Show validation messages
            foreach ($this->getMesages() as $message) {
                $flash->error($message);
            }
        }

    }

The "notSave" event is triggered every time that a "create" or "update" action fails. So we're flashing the validation messages
obtaining the "flash" service from the DI container. By doing this, we don't have to print messages after each save.

機能の無効化/有効化
---------------------------
In the ORM we have implemented a mechanism that allow you to enable/disable specific features or options globally on the fly.
According to how you use the ORM you can disable that you aren't using. These options can also be temporarily disabled if required:

.. code-block:: php

    <?php

    \Phalcon\Mvc\Model::setup(array(
        'events' => false,
        'columnRenaming' => false
    ));

The available options are:

+---------------------+----------------------------------------------------------------------------------+---------+
| Option              | Description                                                                      | Default |
+=====================+==================================================================================+=========+
| events              | Enables/Disables callbacks, hooks and event notifications from all the models    | true    |
+---------------------+----------------------------------------------------------------------------------+---------+
| columnRenaming      | Enables/Disables the column renaming                                             | true    |
+---------------------+----------------------------------------------------------------------------------+---------+
| notNullValidations  | The ORM automatically validate the not null columns present in the mapped table  | true    |
+---------------------+----------------------------------------------------------------------------------+---------+
| virtualForeignKeys  | Enables/Disables the virtual foreign keys                                        | true    |
+---------------------+----------------------------------------------------------------------------------+---------+
| phqlLiterals        | Enables/Disables literals in the PHQL parser                                     | true    |
+---------------------+----------------------------------------------------------------------------------+---------+

スタンドアロン・コンポーネント
---------------------
Using :doc:`Phalcon\\Mvc\\Model <models>` in a stand-alone mode can be demonstrated below:

.. code-block:: php

    <?php

    use Phalcon\DI,
        Phalcon\Db\Adapter\Pdo\Sqlite as Connection,
        Phalcon\Mvc\Model\Manager as ModelsManager,
        Phalcon\Mvc\Model\Metadata\Memory as MetaData,
        Phalcon\Mvc\Model;

    $di = new DI();

    //Setup a connection
    $di->set('db', new Connection(array(
        "dbname" => "sample.db"
    )));

    //Set a models manager
    $di->set('modelsManager', new ModelsManager());

    //Use the memory meta-data adapter or other
    $di->set('modelsMetadata', new MetaData());

    //Create a model
    class Robots extends Model
    {

    }

    //Use the model
    echo Robots::count();

.. _Alternative PHP Cache (APC): http://www.php.net/manual/en/book.apc.php
.. _XCache: http://xcache.lighttpd.net/
.. _PDO: http://www.php.net/manual/en/pdo.prepared-statements.php
.. _date: http://php.net/manual/en/function.date.php
.. _time: http://php.net/manual/en/function.time.php
.. _Traits: http://php.net/manual/en/language.oop5.traits.php
