%{models_34315da4fc43fd95809ef78d65f1b018}%
===================
%{models_8f0e1f8b78c2a43f902d3f235a635750}%

%{models_1fc29f5b10e37dd7b4270c6440455798|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. highlights::

    Models are intended to work on a database high layer of abstraction. If you need to work with databases at a lower level check out the
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` component documentation.



%{models_6fe6eff5591f581f3c7a8b8db8748e2d}%
---------------
%{models_7eb42c46882238eaeb6d7ea069aaa281|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

    }


%{models_139aca56b2ede05fc3717f08091de0d8|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. highlights::

    If you're using PHP 5.4/5.5 is recommended declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.



%{models_05e5dc99584f680738cd051b39df365b}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "the_robots";
        }

    }


%{models_8f3415d39ec51500d37f9ea2ea3dd208}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setSource("the_robots");
        }

    }


%{models_d9eddcbb0d3e0a61317e98124dcce918}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function onConstruct()
        {
            //...
        }

    }


%{models_1e97aa8d4dac7771bfc41fdd1894aef2}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_8f39f4de8a4468ca1841f16ca911e887}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public $price;
    }


%{models_4b84c28ff8c3a142e1ad871b64c58147}%

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
            //{%models_9abd55be91e01075efab1307692d6146%}
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
            //{%models_8d86bc9aa53ea8fff3895ce1b32f0d45%}
            if ($price < 0) {
                throw new \InvalidArgumentException('Price can\'t be negative');
            }
            $this->price = $price;
        }

        public function getPrice()
        {
            //{%models_ffeb5a31ddd260dbc773168ae6f4513f%}
            return (double) $this->price;
        }
    }


%{models_9cf07cd93f23ce62d9699d5b32fbd557}%

%{models_edc8f4356afdd63c106c2e25e75e3a4a}%
^^^^^^^^^^^^^^^^^^^^
%{models_88ac463f7dbfa7bdbca9de455e37429b}%

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Model
    {

    }


%{models_0041176d3d251a7208621f2d87b1cb93}%
--------------------------------
%{models_d33935c04822b910b774c26ef3232937}%

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


%{models_a0af819e2255934cda03b3f923860f88}%

.. code-block:: php

    <?php

    // {%models_f148d3c6d723babc42a5f764f131694c%}
    $robot = Robots::findFirst(3);

    // {%models_eb38e78fafe2c0c6b7f749968a4b9d97%}
    echo $robot->name;


%{models_5593dab00434cec6bd7ff9eb6a5e4fa8}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();


%{models_ad50e75016400a97bdbd274e354b4c44|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models_f1139dc3521d331b62f0df072477011a}%
---------------
%{models_085a171b5244fb1f6da123f09f092416|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    // {%models_1499c1af63a87b3cd78713aeabe53fc5%}
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // {%models_87078387b9e7d1df974b6134db85d304%}
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // {%models_8565a9d6967f26ce0d27ddb21a21ea4e%}
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name"
    ));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // {%models_815bac1c09b347d15b0d2a88e4b3cacd%}
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100
    ));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }


%{models_dca37eac806548a6c68a838011d99538}%

.. code-block:: php

    <?php

    // {%models_757b55639cb0428356f22a0f5233a1f4%}
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // {%models_fa26e0247c99764efc46dcd460d4ecdd%}
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // {%models_d3f491a4553e16e050d7435bc9820fba%}
    $robot = Robots::findFirst(array("type = 'virtual'", "order" => "name"));
    echo "The first virtual robot name is ", $robot->name, "\n";


%{models_1c335b086c81eff06a897a5fbfa8161e}%

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


%{models_2b5aacc034cc35eb04d354e3f362416d}%

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


%{models_5d77a6c7de18b56c1eb8342c2e92d2d5}%

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(array("type" => "mechanical"))
        ->order("name")
        ->execute();


%{models_887526ed65120cae817e8c820fdf4a1d|:doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`}%

%{models_c09a664f846ecd7a4810662c0677495e|:doc:`PHQL <phql>`}%

%{models_be15026641c23ccd2162e2863a36cfa7}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public $price;
    }


%{models_c645e4e62b0b20d0f4c8ddb621caafda}%

.. code-block:: php

    <?php

    $name = "Terminator";
    $robot = Robots::findFirstByName($name);

    if($robot){
        $this->flash->success("The first robot with the name " . $name . " cost " . $robot->price ".");
    }else{
        $this->flash->error("There were no robots found in our table with the name " . $name ".");
    }


%{models_8958e99220592664d45664886ce5861e}%

%{models_21a896556ad0bf6560957107ee309ba3}%
^^^^^^^^^^^^^^^^
%{models_8c9a59a26ff1dad486ed903b0d891601|:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`}%

%{models_6edf89bff321568a3a675fc6973dbedc|:doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`}%

.. code-block:: php

    <?php

    // {%models_7e08ae7d62fdc1b33551d43f9602812c%}
    $robots = Robots::find();

    // {%models_265d657995626c9d4f384ef11722eca8%}
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // {%models_d7da602c7908501e5ffe575acdf8f7e5%}
    $robots->rewind();
    while ($robots->valid()) {
        $robot = $robots->current();
        echo $robot->name, "\n";
        $robots->next();
    }

    // {%models_2c4f0d3e50ef2ca74fe3702595b073ba%}
    echo count($robots);

    // {%models_8374c526ffbe27df430472fd1f6b152d%}
    echo $robots->count();

    // {%models_03999b6dca3873a01a4b1bed75545c36%}
    $robots->seek(2);
    $robot = $robots->current();

    // {%models_7bc4a21ddc2ad82cf1b38a888bf2b60f%}
    $robot = $robots[5];

    // {%models_61dce256ecb61e39d94f6fafab0735f2%}
    if (isset($robots[3])) {
       $robot = $robots[3];
    }

    // {%models_f14d815df113ce11bee5066886764644%}
    $robot = $robots->getFirst();

    // {%models_9f3354bdfbb07b92c2feeaa0ea831464%}
    $robot = $robots->getLast();


%{models_a7eda3d33dae65bae1e3872506079451}%

%{models_889722c4fb3fe2f1e51e29ccbcc6fdd8}%

%{models_9567ddda707a429493dd5ce29805b383|:doc:`Phalcon\\Cache <cache>`|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    // {%models_a5f8f286659fba574398fbf5fdcb780e%}
    $parts = Parts::find();

    // {%models_ba104fa9c42d242e1a6af55bfe40e610%}
    file_put_contents("cache.txt", serialize($parts));

    // {%models_4510ece94d63d9839b50bf9fd8372bec%}
    $parts = unserialize(file_get_contents("cache.txt"));

    // {%models_a0cbb885ba6e3dc7c363a116760a7f17%}
    foreach ($parts as $part) {
       echo $part->id;
    }


%{models_8e1663749196053db8cdfcf3c68e1dc1}%
^^^^^^^^^^^^^^^^^^^^
%{models_86e0576c863b930319c4291189b39a6a}%

.. code-block:: php

    <?php

    $customers = Customers::find()->filter(function($customer) {

        //{%models_7d19fb366e77789eb3890b49b6e2bad9%}
        if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return $customer;
        }

    });


%{models_822e9e4f30d1487b43dff638b7288be9}%
^^^^^^^^^^^^^^^^^^
%{models_2a61bf497a134af628a074d221cbc575|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    // {%models_295356ede93fa03dad388a6197c2196b%}
    $conditions = "name = :name: AND type = :type:";

    //{%models_f08282b4d4b0e7306d53eb5879c0f358%}
    $parameters = array(
        "name" => "Robotina",
        "type" => "maid"
    );

    //{%models_26adb21e78d7ecdd3bb31de5537f0bc1%}
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

    // {%models_a1747fdc994f4f858ac8d08f10f8592b%}
    $conditions = "name = ?1 AND type = ?2";
    $parameters = array(1 => "Robotina", 2 => "maid");
    $robots     = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

    // {%models_3c37368c296399eb7e88a056573aab64%}
    $conditions = "name = :name: AND type = ?1";

    //{%models_f08282b4d4b0e7306d53eb5879c0f358%}
    $parameters = array(
        "name" => "Robotina",
        1 => "maid"
    );

    //{%models_26adb21e78d7ecdd3bb31de5537f0bc1%}
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));


%{models_b84a0dd9d5714b34df69484d2d568a9f}%

%{models_1cb6fccdb0e82654bd3c3c0a38be3797}%

%{models_97a0dfe468ae9ccab829d71b5218b74d}%

.. code-block:: php

    <?php

    use \Phalcon\Db\Column;

    //{%models_d94d15bdc1ff8b0f14b506e232f9a43e%}
    $parameters = array(
        "name" => "Robotina",
        "year" => 2008
    );

    //{%models_1d5061aa7100726f1c7aa8d9692a03c4%}
    $types = array(
        "name" => Column::BIND_PARAM_STR,
        "year" => Column::BIND_PARAM_INT
    );

    // {%models_295356ede93fa03dad388a6197c2196b%}
    $robots = Robots::find(array(
        "name = :name: AND year = :year:",
        "bind" => $parameters,
        "bindTypes" => $types
    ));

.. highlights::

    Since the default bind-type is \\Phalcon\\Db\\Column::BIND_PARAM_STR, there is no need to specify the
    "bindTypes" parameter if all of the columns are of that type.


%{models_3b77c94021fad5966050602759289f10}%

%{models_e3367d0cb8544964094a208970c13117}%
--------------------------------------
%{models_c78c4b381ccc68e2f068e656ecb1f40a}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        public $id;

        public $name;

        public $status;

        public function beforeSave()
        {
            //{%models_680f042aa8c8e6a2c2c2871e00303b41%}
            $this->status = join(',', $this->status);
        }

        public function afterFetch()
        {
            //{%models_1f219c33d76e9d0facb13cfd5fe8f691%}
            $this->status = explode(',', $this->status);
        }
    }


%{models_57ebcfcd3b49b156d81661da7aab7c33}%

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


%{models_0d9e9111f6bc1e0e1dc17a2561b5064f}%
----------------------------
%{models_4bc54330429e293995594ada1ed43cf9}%

%{models_4ea603f3ea62e73772697db5f1650fb8}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_107da6f7c5aa5bb8a906812d1d01e5a4}%

%{models_095247fb250888acc0b22d0143826fef}%
^^^^^^^^^^^^^^^^^^^^^^^
%{models_5f0a1887228b0c923e22a57c7e338501}%

%{models_863202c90ac552ca019f552d58be5afd}%
^^^^^^^^^^^^^^^^^^^^^^
%{models_c7cb02eea3259c9b6054bb64ee43bff6}%

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


%{models_fe5294b94b279920eac0c40225f8ed4f}%

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


%{models_63f144f582941580c09c9b2538906f56}%

.. figure:: ../_static/img/eer-1.png
   :align: center



%{models_2f75e58fb7e6bc12ae5bef57b20cc968}%

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


%{models_93833c12540f148aabe14953a12538e4}%

%{models_52f9d1599bbfcb7cc9ae67dafe8d7c5c}%

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


%{models_2c2bc35a9e8125c1fe4646eb067470d3}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_0ba5ccfa2677fd8a79b241b5c04e4412}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    foreach ($robot->robotsParts as $robotPart) {
        echo $robotPart->parts->name, "\n";
    }


%{models_eaef5f5c0096ddca74ee216d9f6d5486}%

%{models_4f0d578a33ba4d8a00c99107737b68a5}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst();
    $robotsParts = $robot->robotsParts; // {%models_37634994dd76aceff8cc62e7660f001e%}


%{models_23ce3b5c26d63c47189e358eb6a0c062}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst();
    $robotsParts = $robot->getRobotsParts(); // {%models_37634994dd76aceff8cc62e7660f001e%}
    $robotsParts = $robot->getRobotsParts(array('limit' => 5)); // {%models_52cf0d0467fe9114e378ef9752ff0b3b%}


%{models_0b0ad8c13ef82f79c176d5e2d7772e21|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // {%models_26a9f5f5d2a48a1772f7ec1683ec9af8%}
    // {%models_e8edf474f27d462948b8b18e7efe17df%}
    $robotsParts = $robot->robotsParts;

    // {%models_e8b7484473dbf1ac5ca48ed7c6589c4a%}
    $robotsParts = $robot->getRobotsParts("created_at = '2012-03-15'");

    // {%models_5cb44bdc8c5acee60dcbeb3a84e9074b%}
    $robotsParts = $robot->getRobotsParts(array(
        "created_at = :date:",
        "bind" => array("date" => "2012-03-15")
    ));

    $robotPart = RobotsParts::findFirst(1);

    // {%models_60f3a49598ad9c89724ff31d05f76158%}
    // {%models_e8edf474f27d462948b8b18e7efe17df%}
    $robot = $robotPart->robots;


%{models_7c5cfa3c28a89beb95ee67f2167a7e52}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // {%models_26a9f5f5d2a48a1772f7ec1683ec9af8%}
    // {%models_322001a415014ca8eff038bc03561680%}
    $robotsParts = RobotsParts::find("robots_id = '" . $robot->id . "'");

    // {%models_e8b7484473dbf1ac5ca48ed7c6589c4a%}
    $robotsParts = RobotsParts::find(
        "robots_id = '" . $robot->id . "' AND created_at = '2012-03-15'"
    );

    $robotPart = RobotsParts::findFirst(1);

    // {%models_60f3a49598ad9c89724ff31d05f76158%}
    // {%models_e8edf474f27d462948b8b18e7efe17df%}
    $robot = Robots::findFirst("id = '" . $robotPart->robots_id . "'");



%{models_7b6b7ee99bf2d2dc7a5f9a50fe0afa42}%

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


%{models_1cd1930780e738c9a6c7e46b9329ef22}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    echo "The robot has ", $robot->countRobotsParts(), " parts\n";


%{models_54e332a56dc132b3e61043f709d4f3db}%
^^^^^^^^^^^^^^^^^^^^^^
%{models_10f4a34f73f5d711081cd02fbea0d570}%

%{models_c1c8d588fd78b55da43042ea6e0e8c53}%

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


%{models_f18297cdcc691c5743187e61076b9dce}%

.. figure:: ../_static/img/eer-2.png
   :align: center



%{models_39a3c3172d2e4e1980c335914c3e6c94}%

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


%{models_c271c8392737faa49a1be3302c2b8689}%

.. code-block:: php

    <?php

    $robotsSimilar = RobotsSimilar::findFirst();

    //{%models_a4324525bbbe756f7c2058b85b8c4f17%}
    //{%models_bb9996cf4ee81468968550efe88c2c7d%}
    //{%models_87a4e14fab9216e42cec72af533f2c34%}
    $robot = $robotsSimilar->getRobots();

    //{%models_4586e0ef082b5df78af450b4d5824a94%}
    //{%models_f7ca57241c64cb4ec7f683044043b98b%}


%{models_91c8cad15d031165dc93688f915cfc98}%

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


%{models_fb44b187803a7f753798591eae2e9c34}%

.. code-block:: php

    <?php

    $robotsSimilar = RobotsSimilar::findFirst();

    //{%models_a4324525bbbe756f7c2058b85b8c4f17%}
    $robot = $robotsSimilar->getRobot();
    $robot = $robotsSimilar->robot;

    //{%models_39856c93a5e5156f837d90a1fc59da3d%}
    $similarRobot = $robotsSimilar->getSimilarRobot();
    $similarRobot = $robotsSimilar->similarRobot;


%{models_c0498d367be6f00cf53866b7a15650a9}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_61ea72907fef0cf5280b43a54ce12a13}%

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


%{models_b8ddd6c9fa9efe7f8b22d5ee64b4e038}%
--------------------
%{models_ad089347bed015a469de37c65982646d}%

%{models_2807669f80c008114b3d11ad29bad56e}%

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


%{models_c4769cdcd3b3ddfbef7d6179ed1815aa}%

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


%{models_390f3980d9010ee42c5db1e409646b00}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{models_6d74d8a3eee3d85fb1e76211926aa2fb}%

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


%{models_b52c5786f39bc338ec9a3f4758cb9cbf}%

%{models_c8243703df38120bbd35d539ca33d3a9}%
-----------------------
%{models_6be948a780036412e5132cd7b8af4fe5|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models_960fa28a7174efaf18899956c56050cf}%

.. code-block:: php

    <?php

    // {%models_8eff2fb5b476538a43fc570b4fcc9f84%}
    $rowcount = Employees::count();

    // {%models_cc9f6c98548a5b9c1c3e9f912478c176%}
    $rowcount = Employees::count(array("distinct" => "area"));

    // {%models_7401fc0cf3f05aa51ebaf6ff1677dc89%}
    $rowcount = Employees::count("area = 'Testing'");

    // {%models_e23af7315970cf6165ac1c9a2c28e5d3%}
    $group = Employees::count(array("group" => "area"));
    foreach ($group as $row) {
       echo "There are ", $row->rowcount, " in ", $row->area;
    }

    // {%models_9653a88cc1b5ebdcf5e2b9ba4a0d89b9%}
    $group = Employees::count(array(
        "group" => "area",
        "order" => "rowcount"
    ));

    // {%models_b4df7af26d49273a9bba86f5f4e88793%}
    $group = Employees::count(array(
        "type > ?0",
        "bind" => array($type)
    ));


%{models_4618d74d3fe8438c957047b340d64f9f}%

.. code-block:: php

    <?php

    // {%models_e03121e9c09c30c2ce778a14db69b946%}
    $total = Employees::sum(array("column" => "salary"));

    // {%models_8238beeb9435a210dcff925cdfe8a8ac%}
    $total = Employees::sum(array(
        "column"     => "salary",
        "conditions" => "area = 'Sales'"
    ));

    // {%models_4099511fa6c1d6d08506e81d986bf5b0%}
    $group = Employees::sum(array(
        "column" => "salary",
        "group"  => "area"
    ));
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $row->area, " is ", $row->sumatory;
    }

    // {%models_44d715b56c621684b25e81885815c045%}
    // {%models_915ae8be0b495cfda0715d746b019424%}
    $group = Employees::sum(array(
        "column" => "salary",
        "group"  => "area",
        "order"  => "sumatory DESC"
    ));

    // {%models_b4df7af26d49273a9bba86f5f4e88793%}
    $group = Employees::sum(array(
        "conditions" => "area > ?0",
        "bind" => array($area)
    ));


%{models_a2b38ff9b1155040734f2bf3a05212c2}%

.. code-block:: php

    <?php

    // {%models_6be95309d8473a9a1029c83a2f8a7fea%}
    $average = Employees::average(array("column" => "salary"));

    // {%models_0066aa381bcf5623295b342139748eee%}
    $average = Employees::average(array(
        "column" => "salary",
        "conditions" => "area = 'Sales'"
    ));

    // {%models_b4df7af26d49273a9bba86f5f4e88793%}
    $average = Employees::average(array(
        "column" => "age",
        "conditions" => "area > ?0",
        "bind" => array($area)
    ));


%{models_684946bc5648c219d794240b6b7dc740}%

.. code-block:: php

    <?php

    // {%models_e8998c1c727a1702b25a3bd2217ebf84%}
    $age = Employees::maximum(array("column" => "age"));

    // {%models_c1ffe08178ab27d8d93adcd8a1dc7c10%}
    $age = Employees::maximum(array(
        "column" => "age",
        "conditions" => "area = 'Sales'"
    ));

    // {%models_2c63cde73a51a506e08d3eaa8ec2096c%}
    $salary = Employees::minimum(array("column" => "salary"));


%{models_da300e626c96660279800817373be665}%
---------------
%{models_6d7c6eb4758655c54dc6990ff7f19123}%

.. code-block:: php

    <?php

    // {%models_ca5554acc480307928ad818e385d7549%}
    foreach (Robots::find() as $robot) {
        $robot->year = 2000;
        $robot->save();
    }


%{models_1eb6ffebaa894cc85477ab4658ef7574}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;

    $robots = Robots::find();

    //{%models_0019ccf6219cda67bed6b40af0714e39%}
    $robots->setHydrateMode(Resultset::HYDRATE_ARRAYS);

    foreach ($robots as $robot) {
        echo $robot['year'], PHP_EOL;
    }

    //{%models_658e3f6a02b314a0fe2ae851e9b85363%}
    $robots->setHydrateMode(Resultset::HYDRATE_OBJECTS);

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

    //{%models_42c0b20a1762232fe05d204ce20a52d4%}
    $robots->setHydrateMode(Resultset::HYDRATE_RECORDS);

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }


%{models_cb3c4cbdce1e571a507dbbb9281a4af5}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;

    $robots = Robots::find(array(
        'hydration' => Resultset::HYDRATE_ARRAYS
    ));

    foreach ($robots as $robot) {
        echo $robot['year'], PHP_EOL;
    }


%{models_a7f6efdf628627cbfb0183f461cfcd29}%
-------------------------
%{models_d10514567f77ab7496ba0dccd7b51875|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models_c7e343496bcfc784c6263a56f00b407d}%

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


%{models_e123024286ad4cb9eb2b5d92b25fd734}%

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save(array(
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952
    ));


%{models_76fcd45612dc70788c0ca6177fb231f7}%

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save($_POST);

.. highlights::

    Without precautions mass assignment could allow attackers to set any database column’s value. Only use this feature
    if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted
    form.


%{models_45391c2973b138766ea846d6d7d85c61}%

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save($_POST, array('name', 'type'));


%{models_7d4b758e7334c310d6b7a126d7eedbdc}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_2e0f8969e5a5cf5d5c5674faf5409f74}%

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    //{%models_c7fefc99b5694f422d636b5a64c270a6%}
    if ($robot->create() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }


%{models_9afbc94d7c87924852bb6eaec4c24f2f}%

%{models_47d10dbbf95de1e4e67a5f17a81c4370}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_81a1ef00ba1fddad4f51fc66def6bc3d|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    $robot->save();

    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is able to recognize the identity column. Depending on the database system, those columns may be

%{models_d55994b62e51e018089e422de3aea43e}%

%{models_34e756014c1e42ff9eec737ec2e292e9}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSequenceName()
        {
            return "robots_sequence_name";
        }

    }


%{models_e0035a0f5ffbb4f6d432b4f70697cf78}%
^^^^^^^^^^^^^^^^^^^^^^^
%{models_501eac663748a2ce8ff81a0ca4077ee9}%

.. code-block:: php

    <?php

    // {%models_87c4ab8d15fb6563d8be4dcbacfbb8ed%}
    $artist = new Artists();
    $artist->name = 'Shinichi Osawa';
    $artist->country = 'Japan';

    // {%models_d4e71e6c320568f69f633bede4df9f5d%}
    $album = new Albums();
    $album->name = 'The One';
    $album->artist = $artist; //{%models_5e64e7adb598b372ffc3d64a0a5ed89a%}
    $album->year = 2008;

    //{%models_aa0b953f6d350a5577ebc11cfed71a1e%}
    $album->save();


%{models_47f31897cd3d97d3789b57c50d7dc10e}%

.. code-block:: php

    <?php

    // {%models_2c79df378328e8dd2cd1d1b7bb1c7b07%}
    $artist = Artists::findFirst('name = "Shinichi Osawa"');

    // {%models_d4e71e6c320568f69f633bede4df9f5d%}
    $album = new Albums();
    $album->name = 'The One';
    $album->artist = $artist;

    $songs = array();

    // {%models_2c7b195f3afca1886184d62caaa41191%}
    $songs[0] = new Songs();
    $songs[0]->name = 'Star Guitar';
    $songs[0]->duration = '5:54';

    // {%models_5792f06dbb1bb6ded00d1b3ef541a484%}
    $songs[1] = new Songs();
    $songs[1]->name = 'Last Days';
    $songs[1]->duration = '4:29';

    // {%models_2b4b34687271d7f155fb2dbaccf58ad3%}
    $album->songs = $songs;

    // {%models_c77858c47a2afaedb836fa45d116e489%}
    $album->save();


%{models_9482868dc98e03953151f38dd8c07038}%

%{models_d939a1c7ef3aa44a932cfff1b2ee1110}%

%{models_14fef3e904b2f9aa6116cf7656675e02}%

%{models_39d425478bbbd8c190c1571d56968719}%
^^^^^^^^^^^^^^^^^^^
%{models_1dfb448799cd9391845e5659e6a08fa1|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models_d27c98baf8000da38be80c02eed41dc0|:doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>`}%

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


%{models_f958e80e660f56d42517de25c94720b1}%

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


%{models_88dc8b91807ff4ba675e3c4d5fc6b7db}%
^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_ec346e4dfa21eab0d23bf387d6f1fe88|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

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


%{models_ffdc056a5ad04de3bf87e0e2bfb1cdb3}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_4fba9529bed771a750169aea7fe11c01}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeValidationOnCreate()
        {
            echo "This is executed before creating a Robot!";
        }

    }


%{models_3fa8d189cbd898ffa9232f5519462f06}%

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            //{%models_49f3de45257d0e5b7096556a30c385cb%}
            $this->created_at = date('Y-m-d H:i:s');
        }

        public function beforeUpdate()
        {
            //{%models_f74e28161b504a419d70d64f43d969de%}
            $this->modified_in = date('Y-m-d H:i:s');
        }

    }


%{models_f11eaba96f0c61a573317f0a69292340}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_f8398ace84457fa6a9c43e61ca429370|:doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model,
        Phalcon\Events\Manager as EventsManager;

    class Robots extends Model
    {

        public function initialize()
        {

            $eventsManager = new EventsManager();

            //{%models_7b4ffbc5f44152ae745312315447e233%}
            $eventsManager->attach('model', function($event, $robot) {
                if ($event->getType() == 'beforeSave') {
                    if ($robot->name == 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";
                        return false;
                    }
                }
                return true;
            });

            //{%models_c9534309ad139e07a87ea7518e861695%}
            $this->setEventsManager($eventsManager);
        }

    }


%{models_bd80e1f4bd54bb03b2cc233f99866b2d}%

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Scooby Doo';
    $robot->year = 1969;
    $robot->save();


%{models_9dba0dfb3be69611c21dd8738e27213f}%

.. code-block:: php

    <?php

    //{%models_8464ec16e7658d507e31c188e524c49d%}
    $di->setShared('modelsManager', function() {

        $eventsManager = new \Phalcon\Events\Manager();

        //{%models_7b4ffbc5f44152ae745312315447e233%}
        $eventsManager->attach('model', function($event, $model){

            //{%models_bc14603934930fe35354e4dcecb55c75%}
            if (get_class($model) == 'Robots') {

                if ($event->getType() == 'beforeSave') {
                    if ($model->name == 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";
                        return false;
                    }
                }

            }
            return true;
        });

        //{%models_c106c4e52bc599f6fe8708497906c4aa%}
        $modelsManager = new ModelsManager();
        $modelsManager->setEventsManager($eventsManager);
        return $modelsManager;
    });


%{models_a99f116006a7e6f8e0beedf2fa1f7293}%

%{models_a2333fe1d4949c60e0ffa88a36ec8b24}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_55a005b019c6e5cffa73b951673ab855}%

%{models_58acea561b884f8775c83234389a6c67}%

%{models_cca1ae2eb8ed215dc1a1202d65c9abf9}%

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


%{models_cc0c64759378d22ce091113bdd1a7f1c|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models_53c9ef435efdc751976636021ca78ae8}%
^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_44f73e5f781842638380d87cc3e0e58d|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models_1cc9ab87bdb41eb59d0ed209160c60d8}%

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


%{models_284e191d54feb148b504b19e86595cd5}%

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


%{models_84bbc78bf253737de49fbc641775a65f}%

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


%{models_52bc5373d71ac2fdd32cbb2d8ab1facd}%

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


%{models_21b521505501d7d235cf8c4486f015dc}%

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


%{models_a5b8ba4670620d3d0495cd4b993c2c36}%
^^^^^^^^^^^^^^^^^^^^^^^
%{models_18e6bdbe0312c1c503ae057657188a40|`bound parameters <http://php.net/manual/en/pdostatement.bindparam.php>`_}%

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


%{models_3cbc5493ec1d1fced277a1876a1d5bf6}%

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


%{models_e270c4873b9061d820db4505f1102e90}%

.. code-block:: php

    <?php

    $product = new Products();
    $product->product_types_id = 1;
    $product->name = 'Artichoke';
    $product->price = 10.5;
    $product->active = 'Y';
    $product->create();


%{models_e7d653d41a47b75951d0301d92fae13e}%
----------------
%{models_52905496ae0f50797717b9709adf5134}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            //{%models_a6fafe677ab3a48d278aa87829b365c3%}
            $this->skipAttributes(array('year', 'price'));

            //{%models_9d5a1c3994f83675016b36e4b8718cb6%}
            $this->skipAttributesOnCreate(array('created_at'));

            //{%models_fe8e2b615e1244280eeb6505979a1b3b%}
            $this->skipAttributesOnUpdate(array('modified_in'));
        }

    }


%{models_dff14ed91b9e1bfba3bbfd846b13c029}%

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Bender';
    $robot->year = 1999;
    $robot->created_at = new \Phalcon\Db\RawValue('default');
    $robot->create();


%{models_85946bc9767c0ac502ac9327d1eda99e}%

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


%{models_eeb5861768cb1d8e1b83f34166ba75e3}%
^^^^^^^^^^^^^^
%{models_cae7b7f779c605b98263207fc0c50b74}%

%{models_de37cceeaaf2862d1cfebbc7e0214218}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->useDynamicUpdate(true);
        }
    }


%{models_0dcecd441d09452dc45fa5fb8fdf84c9}%
----------------
%{models_0e75de2f191dfee5ebf610adee2f593b}%

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


%{models_76bc4e0b0f94d49a3359b7b87d0e8082}%

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


%{models_1754d4c775f9d294061fd18347afd1a0}%

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+


%{models_46fd4a379b90cb5f6446182c62871f6f}%

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


%{models_9b8dadaae5e0186045cc25e173cc28e3}%
------------------------
%{models_1c5941aa841724d5c5c3b19995195e7b}%

+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSave            | Triggered when the INSERT or UPDATE operation fails for any reason |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+


%{models_b9d973fddd00b0e7a636cdc2488b97c2}%
---------
%{models_ba55633b90ce74fe56a1f26bc2caa70c}%

%{models_a4ae958a2c79dbebf8a92d103bddf65f}%

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


%{models_0eb0b021dd27e2aa85dba6af77dfbcf3}%

+----------------+-------------------------------------------------------------------------------------------------------------------------------+
| Name           | Description                                                                                                                   |
+================+===============================================================================================================================+
| Timestampable  | Allows to automatically update a model's attribute saving the datetime when a record is created or updated                    |
+----------------+-------------------------------------------------------------------------------------------------------------------------------+
| SoftDelete     | Instead of permanently delete a record it marks the record as deleted changing the value of a flag column                     |
+----------------+-------------------------------------------------------------------------------------------------------------------------------+


%{models_e7809539aa252eae6a52c0e6ae502cb6}%
^^^^^^^^^^^^^
%{models_bb8b7c604e76018faa85a3e26939e787}%

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


%{models_4a76abb3c06b31460f75d83a5e479f77}%

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


%{models_46ad3d1c14e7ffc25f0de5834a23d3fc}%

%{models_af281cbd0128f9b889a08e8e6a23414d}%
^^^^^^^^^^
%{models_0141a60aa91a8b35e1b87ed208a7cf3e}%

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


%{models_125217bbbd6bc34b9459e8b4a85c4085}%

.. code-block:: bash

    mysql> select * from users;
    +----+---------+--------+
    | id | name    | status |
    +----+---------+--------+
    |  1 | Lana    | N      |
    |  2 | Brandon | N      |
    +----+---------+--------+
    2 rows in set (0.00 sec)


%{models_41be3c2f9af2dde83473639a1bd8743e}%

.. code-block:: php

    <?php

    Users::findFirst(2)->delete();


%{models_ca12e23cdec236f897708b9d47dda460}%

.. code-block:: bash

    mysql> select * from users;
    +----+---------+--------+
    | id | name    | status |
    +----+---------+--------+
    |  1 | Lana    | N      |
    |  2 | Brandon | D      |
    +----+---------+--------+
    2 rows in set (0.01 sec)


%{models_6cdd8eeb2c674a7ca7d8f638e3908bf5}%

%{models_0387f5f8f86514fd76635c5b996298a7}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_5169662f81f2a1d71453f90ff87be761|:doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <../api/Phalcon_Mvc_Model_BehaviorInterface>`}%

%{models_fbefc8402833e62596c10cc8fd57186b}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior;
    use Phalcon\Mvc\Model\BehaviorInterface;

    class Blameable extends Behavior implements BehaviorInterface
    {

        public function notify($eventType, $model)
        {
            switch ($eventType) {

                case 'afterCreate':
                case 'afterDelete':
                case 'afterUpdate':


                    $userName = // {%models_8b6993d9acf4981ac8565639dd87f7ba%}

                    //{%models_af04cd320ff5f0ea264a3121bc535e71%}
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


%{models_019293c46f20180b538e4829b6b2bc3f}%

.. code-block:: php

    <?php

    class Profiles extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->addBehavior(new Blamable());
        }

    }


%{models_e0cf9ab962c4202ec86581e7ab5d8a50}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Behavior,
        Phalcon\Mvc\Model\BehaviorInterface;

    class Sluggable extends Behavior implements BehaviorInterface
    {

        public function missingMethod($model, $method, $arguments=array())
        {
            // {%models_3127822a2aeb877c75788660804e7791%}
            if ($method == 'getSlug') {
                return Phalcon\Tag::friendlyTitle($model->title);
            }
        }

    }


%{models_0e6c82a5255904cf8a06e50df659fee6}%

.. code-block:: php

    <?php

    $title = $post->getSlug();


%{models_86902028f578be3733203f273cf005f9}%
^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_15225e9a2356f6a977351d29714d8c55}%

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


%{models_a2114c4340289628297fd7fe404775e0}%

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {
        use MyTimestampable;
    }


%{models_70f40070204552b5f24220685f1af1d5}%
------------
%{models_523caad38dca5a70a0f0df8adfa5392b}%

%{models_e3bf59100a4c3abaa191650a6f5136e7}%

%{models_088212b633bc7551876ebcd09049afd5}%
^^^^^^^^^^^^^^^^^^^
%{models_1baaab4adfb83d440c5b42201356136b}%

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


%{models_40fbff140ccf45a6aebbd09ef8b19fdf}%
^^^^^^^^^^^^^^^^^^^^^
%{models_4a388701aafbd80f2477b8eeef2d0e8b}%

.. code-block:: php

    <?php

    $robotPart = new RobotParts();
    $robotPart->type = "head";

    $robot = new Robots();
    $robot->name = "WALL·E";
    $robot->created_at = date("Y-m-d");
    $robot->robotPart = $robotPart;

    $robot->save(); //{%models_d6eb181c63ee8d0d3e27606f53733df5%}


%{models_b343a6effee4b8a33a6d3cd345196c36}%
^^^^^^^^^^^^^^^^^^^^^
%{models_cde7e7a38238e1e4337277766e8d4882}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TxManager,
        Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {

        //{%models_6b0527dc3798bd2c93b12c0a6fcc6bf1%}
        $manager = new TxManager();

        // {%models_8730d34bec19e8e359d185f197e47aae%}
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

        //{%models_6d85bdbbb75057a7a08583e805395628%}
        $transaction->commit();

    } catch(TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }


%{models_684fdc9b8b05dee0da51a3d679f5a2f2}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TxManager,
        Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {

        //{%models_6b0527dc3798bd2c93b12c0a6fcc6bf1%}
        $manager = new TxManager();

        //{%models_8730d34bec19e8e359d185f197e47aae%}
        $transaction = $manager->get();

        //{%models_9c6ea68e7c35029ab8340fc9f2ba420a%}
        foreach (Robots::find("type = 'mechanical'") as $robot) {
            $robot->setTransaction($transaction);
            if ($robot->delete() == false) {
                //{%models_a58a68df43013bf991dfe4e4b223fe63%}
                foreach ($robot->getMessages() as $message) {
                    $transaction->rollback($message->getMessage());
                }
            }
        }

        //{%models_6d85bdbbb75057a7a08583e805395628%}
        $transaction->commit();

        echo "Robots were deleted successfully!";

    } catch(TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }


%{models_8d689b69315df96ae544989ca3c68823}%

.. code-block:: php

    <?php

    $di->setShared('transactions', function(){
        return new \Phalcon\Mvc\Model\Transaction\Manager();
    });


%{models_e9fa44065ffbf68c6b093ede30a4e5fe}%

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function saveAction()
        {

            //{%models_6ecfae4116e66dc373c485de06019744%}
            $manager = $this->di->getTransactions();

            //{%models_3a2d5fe857d8f9541136a124c2edec6c%}
            $manager = $this->transactions;

            //{%models_8730d34bec19e8e359d185f197e47aae%}
            $transaction = $manager->get();

            //...
        }

    }


%{models_fa2202eae95bafde3a1d0f80d04c9ea0}%

%{models_b06efa6d21e5b000c6aa2d0359cf548b}%
--------------------------
%{models_42bf3fa32fab55ab4a3ff67d1d6c7c68}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function columnMap()
        {
            //{%models_f3d1188d844ee3313ca095f96e2687af%}
            //{%models_25fd88df9256c457036b8c6ccf511e95%}
            return array(
                'id' => 'code',
                'the_name' => 'theName',
                'the_type' => 'theType',
                'the_year' => 'theYear'
            );
        }

    }


%{models_c64de284c082a2c913bd581410a8a31a}%

.. code-block:: php

    <?php

    //{%models_2986e6244ae5248fc2da3f6c053ab4d0%}
    $robot = Robots::findFirst("theName = 'Voltron'");
    echo $robot->theName, "\n";

    //{%models_c529a0ae3d36266db59f3c829f010f00%}
    $robot = Robots::find(array('order' => 'theType DESC'));
    foreach ($robots as $robot) {
        echo 'Code: ', $robot->code, "\n";
    }

    //{%models_c57e823383479b57ac39125241d808e8%}
    $robot = new Robots();
    $robot->code = '10101';
    $robot->theName = 'Bender';
    $robot->theType = 'Industrial';
    $robot->theYear = 2999;
    $robot->save();


%{models_528e38143ba42116d5e4ec6c8c4ffb01}%

* {%models_4cb78697665b755adce89abbc9d01252%}
* {%models_c212b3ad4c6bdb1543a3aad2183b6757%}

%{models_e5d5ce5eb3b45441404d550fba11b91b}%

* {%models_a97010d560c03e5aba5668cf0e7b5a40%}
* {%models_28d88ab13e1f16b0d4fbd6c7aa5ad899%}
* {%models_72493b148e97c79baeaace0eab6fd5ee%}

%{models_4fec5c7316082223510a448180b8dad4}%
--------------------------
%{models_1c044d7aaef440ba786bdc767bda9fd9}%

%{models_b77e6d4bf8411c1cc8b034cc2a02b89a}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{models_5f5266b4beb59809046580a6b9a8d954}%

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


%{models_6b440a04add8ea312c29b3e07271d4d2}%

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

    //{%models_fb5daf83af9643f8a08851dd5131850b%}
    $robots->getParts()->update($data, function($part) {
        if ($part->type == Part::TYPE_BASIC) {
            return false;
        }
        return true;
    });


%{models_3a148cb8c3ab4930a041c5abd3aa9bdb}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{models_5f5266b4beb59809046580a6b9a8d954}%

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


%{models_6b440a04add8ea312c29b3e07271d4d2}%

.. code-block:: php

    <?php

    $robots->getParts()->delete();

'delete' also accepts an anonymous function to filter what records must be deleted:

.. code-block:: php

    <?php

    //{%models_0fb2d18df6dcf886494ce6de22d3c615%}
    $robots->getParts()->delete(function($part) {
        if ($part->stock < 0) {
            return false;
        }
        return true;
    });



%{models_68ad0c2d8a1b1d369991023ff57d29b7}%
----------------
%{models_f88a41ead0b918d0234e87adadb8f2b8}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->keepSnapshots(true);
        }
    }


%{models_d954f57ca241e469f69763172c6a9b69}%

.. code-block:: php

    <?php

    //{%models_af2ad94f6e64ec2420750c0b76ea5722%}
    $robot = Robots::findFirst();

    //{%models_b0b01a0fefa818b1edb5bdc9770155fb%}
    $robot->name = 'Other name';

    var_dump($robot->getChangedFields()); // {%models_4da47e07f5294b3af192e37566ca5503%}
    var_dump($robot->hasChanged('name')); // {%models_b326b5062b2f0e69046810717534cb09%}
    var_dump($robot->hasChanged('type')); // {%models_68934a3e9455fa72420237eb05902327%}


%{models_70374a9ca8493aae79270629e397bd00}%
----------------
%{models_9a962a5619f9371532434aab8feac19c|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`|:doc:`Phalcon\\Mvc\\Model\\MetaData <../api/Phalcon_Mvc_Model_MetaData>`}%

%{models_a8a4fb9cdb3c450c510e3f24ce4f4253}%

.. code-block:: php

    <?php

    $robot = new Robots();

    // {%models_923c421713a432036e3b787f7b957ac9%}
    $metaData = $robot->getModelsMetaData();

    // {%models_4880d88d5c6ff8820e22835d592966f7%}
    $attributes = $metaData->getAttributes($robot);
    print_r($attributes);

    // {%models_7a76d480d3cafc2a67a1c4fa13b01789%}
    $dataTypes = $metaData->getDataTypes($robot);
    print_r($dataTypes);


%{models_bfd71f3927f6c86526558f97925a5e8f}%
^^^^^^^^^^^^^^^^^
%{models_1440dbcf5f811b0cef85d8a3c4ee376a}%

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


%{models_b6b0ff2517693e49750e1f7b648d0ba6}%

.. code-block:: php

    <?php

    $di['modelsMetadata'] = function() {

        // {%models_48c4ce1c4709155ccb67e65d2ee625ce%}
        $metaData = new \Phalcon\Mvc\Model\MetaData\Apc(array(
            "lifetime" => 86400,
            "prefix"   => "my-prefix"
        ));

        return $metaData;
    };


%{models_55ca78ce00d3f2722f71be1173f6b3ce}%
^^^^^^^^^^^^^^^^^^^^
%{models_f8d1077a4feeb4ed05c90c606db3dc50}%

%{models_b0c27aa05dcb7d1c9b7811f112ad76d8}%

.. code-block:: php

    <?php

    $di['modelsMetadata'] = function() {

        // {%models_a6e8f466f78ee591bd17ab565a03cc24%}
        $metaData = new \Phalcon\Mvc\Model\MetaData\Apc(array(
            "lifetime" => 86400,
            "prefix"   => "my-prefix"
        ));

        //{%models_435b2b97d8852f4de4435b0662f1e971%}
        $metaData->setStrategy(new MyInstrospectionStrategy());

        return $metaData;
    };


%{models_fb54cb01fbccd42cd7a3b5b4b29c760f}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{models_9d03c973b5fc84b79884ffb6e8dabef1}%

%{models_ea3cffb13799871aefa54facf52160c4}%
^^^^^^^^^^^^^^^^^^^^
%{models_6f0310d76056f6e2ab63703f26e90a1b|:doc:`annotations <annotations>`}%

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


%{models_2b2322672392dd3dea9fff06ede98691}%

%{models_15b215324dfe32956e0c8e2aa256e0d9}%

+----------+-------------------------------------------------------+
| Name     | Description                                           |
+==========+=======================================================+
| Primary  | Mark the field as part of the table's primary key     |
+----------+-------------------------------------------------------+
| Identity | The field is an auto_increment/serial column          |
+----------+-------------------------------------------------------+
| Column   | This marks an attribute as a mapped column            |
+----------+-------------------------------------------------------+


%{models_18288132ec8f3aca3a23d0d6d61a616a}%

+----------+-------------------------------------------------------+
| Name     | Description                                           |
+==========+=======================================================+
| type     | The column's type (string, integer, decimal, boolean) |
+----------+-------------------------------------------------------+
| length   | The column's length if any                            |
+----------+-------------------------------------------------------+
| nullable | Set whether the column accepts null values or not     |
+----------+-------------------------------------------------------+


%{models_3fd9c7c7f0beb190f4f9394614ba70de}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData,
        Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;

    $di['modelsMetadata'] = function() {

        // {%models_a6e8f466f78ee591bd17ab565a03cc24%}
        $metaData = new ApcMetaData(array(
            "lifetime" => 86400,
            "prefix"   => "my-prefix"
        ));

        //{%models_6e1f5392a679a2a0f5f1116c0e86d1c6%}
        $metaData->setStrategy(new StrategyAnnotations());

        return $metaData;
    };


%{models_e2245e0ad6ce4309e33f9319c2be6b9c}%
^^^^^^^^^^^^^^^^
%{models_67cc3bdd8608baa67d5af54d1cb344e4}%

%{models_16d0fb50c035c6c0bda4e4df25a95edc}%

%{models_cd5f7a9c3139a9a56bd0033b779d4cd7}%

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

                //{%models_28dab1e1d1767233c25463a992f0b1d4%}
                MetaData::MODELS_ATTRIBUTES => array(
                    'id', 'name', 'type', 'year'
                ),

                //{%models_b5da62993c5209ad418f4de5e4a4df68%}
                MetaData::MODELS_PRIMARY_KEY => array(
                    'id'
                ),

                //{%models_5d59fb8f300a540fca45964ed2531bfc%}
                MetaData::MODELS_NON_PRIMARY_KEY => array(
                    'name', 'type', 'year'
                ),

                //{%models_255fc2b28f319aea951b90720fe0995d%}
                MetaData::MODELS_NOT_NULL => array(
                    'id', 'name', 'type', 'year'
                ),

                //{%models_4cd43e829c57883c03ee4d3d15d568f7%}
                MetaData::MODELS_DATA_TYPES => array(
                    'id' => Column::TYPE_INTEGER,
                    'name' => Column::TYPE_VARCHAR,
                    'type' => Column::TYPE_VARCHAR,
                    'year' => Column::TYPE_INTEGER
                ),

                //{%models_998be7a72bbf5c744723eab09c9847d1%}
                MetaData::MODELS_DATA_TYPES_NUMERIC => array(
                    'id' => true,
                    'year' => true,
                ),

                //{%models_5f935649f26859885cb22260217a68a5%}
                //{%models_4777c5d4a477e02489dde31350734ba2%}
                MetaData::MODELS_IDENTITY_COLUMN => 'id',

                //{%models_f211e4d989807e64d736aa0c4a7a08f4%}
                MetaData::MODELS_DATA_TYPES_BIND => array(
                    'id' => Column::BIND_PARAM_INT,
                    'name' => Column::BIND_PARAM_STR,
                    'type' => Column::BIND_PARAM_STR,
                    'year' => Column::BIND_PARAM_INT,
                ),

                //{%models_d7f10e08f74aa352297ef297211a4775%}
                MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => array(
                    'year' => true
                ),

                //{%models_5afce0b8bb54ca0aff5f871b7cf30342%}
                MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => array(
                    'year' => true
                )

            );
        }

    }


%{models_56d911cac7c77478592e074bfe9e0460}%
------------------------------
%{models_13738e1aa3deb47d73c26d2c1d47b25b}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSchema()
        {
            return "toys";
        }

    }


%{models_78d81576bf0a8efea929a760098c2829}%
--------------------------
%{models_48ad6c28516042ea030885a80828dbce|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    //{%models_719b0dc2e967ab897b04083c1a8a28a6%}
    $di->set('dbMysql', function() {
         return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //{%models_a796f07dab600aaacedc16a2bc376c77%}
    $di->set('dbPostgres', function() {
         return new \Phalcon\Db\Adapter\Pdo\PostgreSQL(array(
            "host" => "localhost",
            "username" => "postgres",
            "password" => "",
            "dbname" => "invo"
        ));
    });


%{models_aae5be7f170ab14ae4df454c73a9fc63}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setConnectionService('dbPostgres');
        }

    }


%{models_b5ca7287e02d9aa96e5539d8c935b459}%

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


%{models_d15589e70e20a93dc6fcba29c1570a2c}%

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
            //{%models_a6f9cb1ddd0720ae9f587d9b54ea9893%}
            if (isset($intermediate['where'])) {

                $conditions = $intermediate['where'];

                //{%models_3d0deca9ed049c11d36dc2c657e59e57%}
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

            //{%models_d7b311d89d5329dc2b956e8084f7e704%}
            return $this->getDI()->get('dbShard0');
        }

    }


%{models_6d5fa925b83f6aa8e7a9f922539e963e}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst('id = 101');


%{models_97bf04884de98c0f2516aba8c1820c0a}%
--------------------------------
%{models_8ebbcaebc2cc8a15596bd23885982a50|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`|:doc:`Phalcon\\Db <../api/Phalcon_Db>`|:doc:`Phalcon\\Logger <../api/Phalcon_Logger>`|:doc:`Phalcon\\Db <../api/Phalcon_Db>`}%

.. code-block:: php

    <?php

    use Phalcon\Logger,
        Phalcon\Db\Adapter\Pdo\Mysql as Connection,
        Phalcon\Events\Manager,
        Phalcon\Logger\Adapter\File;

    $di->set('db', function() {

        $eventsManager = new EventsManager();

        $logger = new Logger("app/logs/debug.log");

        //{%models_d15114be04209e5fae3b603ffbbf13b1%}
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

        //{%models_b7efb4940856cd2cf63a1277b1523399%}
        $connection->setEventsManager($eventsManager);

        return $connection;
    });


%{models_c98b4e61c4cf65ed96146755ecde763b}%

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = "Robby the Robot";
    $robot->created_at = "1956-07-21";
    if ($robot->save() == false) {
        echo "Cannot save robot";
    }


%{models_0088d92ba0746f6ca32168e18b0acd69}%

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots
    (name, created_at) VALUES ('Robby the Robot', '1956-07-21')


%{models_f7dc7675831e283edd54b6e7e3501a7e}%
------------------------
%{models_0a2a06fb3507bac817f276ad915dd3e9|:doc:`Phalcon\\Db <../api/Phalcon_Db>`|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    $di->set('profiler', function(){
        return new \Phalcon\Db\Profiler();
    }, true);

    $di->set('db', function() use ($di) {

        $eventsManager = new \Phalcon\Events\Manager();

        //{%models_ddf27bc91efad33c6b4ffec992cb261b%}
        $profiler = $di->getProfiler();

        //{%models_d15114be04209e5fae3b603ffbbf13b1%}
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

        //{%models_b7efb4940856cd2cf63a1277b1523399%}
        $connection->setEventsManager($eventsManager);

        return $connection;
    });


%{models_41c61785167c1dcf8f87ed63af11cddc}%

.. code-block:: php

    <?php

    // {%models_7a89bc08139ccf8e34cdd183e25474ee%}
    Robots::find();
    Robots::find(array("order" => "name"));
    Robots::find(array("limit" => 30));

    //{%models_f0d818119815d52445837e3e63169003%}
    $profiles = $di->get('profiler')->getProfiles();

    foreach ($profiles as $profile) {
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }


%{models_6c6b6fc7cddd80dc56fd5605ee79726d}%

%{models_bf20ac68334be437956a656824fc4005}%
------------------------------
%{models_4b0148a30c76d202c67e8fd1fd0e8642}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function notSave()
        {
            //{%models_208f521f101d584f8d276e843032b6c2%}
            $flash = $this->getDI()->getFlash();

            //{%models_b15e59a4e29ae0f51c934d824558da35%}
            foreach ($this->getMessages() as $message) {
                $flash->error($message);
            }
        }

    }


%{models_f651a3f30dbfb9e7186a28cc284e8ce5}%

%{models_6b15f5193c9dc33fd43d3c2de2f7a3fe}%
---------------------------
%{models_e90dafd6a6d737e3f11771c9e2615633}%

.. code-block:: php

    <?php

    \Phalcon\Mvc\Model::setup(array(
        'events' => false,
        'columnRenaming' => false
    ));


%{models_4a145c294a5e052cf51f7f37bac8dcc7}%

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


%{models_d3e54f7c04408d6d1a884897bca4169e}%
---------------------
%{models_c5b75fd5c3845db3b35849961c1ccf23|:doc:`Phalcon\\Mvc\\Model <models>`}%

