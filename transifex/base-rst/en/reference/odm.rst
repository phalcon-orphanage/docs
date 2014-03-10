%{odm_48cb4cd9833b519dd8ca15aa818b67a3}%

============================
%{odm_a93a8d132de0914aa0ec12381c76fb5b}%


%{odm_2643e1e9a609735194337259764e21a5}%

%{odm_3d5d84c358d390d9d3d3e0fb17408a3a}%

+------------+----------------------------------------------------------------------+
| Name       | Description                                                          |
+============+======================================================================+
| MongoDB_   | MongoDB is a scalable, high-performance, open source NoSQL database. |
+------------+----------------------------------------------------------------------+

%{odm_6fe6eff5591f581f3c7a8b8db8748e2d}%

---------------
%{odm_7eb42c46882238eaeb6d7ea069aaa281}%


.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

    }

.. highlights::

    If you're using PHP 5.4/5.5 is recommended declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.

%{odm_711543eda4f95a18fd009d91e6579757}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {
        public function getSource()
        {
            return "the_robots";
        }
    }

%{odm_c0d736e3c6dc4ae7feeaca79f5a3119c}%

----------------------------------
%{odm_cef9c90442496b28c2daa4792f41dffe}%


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

%{odm_edc8f4356afdd63c106c2e25e75e3a4a}%

--------------------
%{odm_9438dc6649ff6249a00b13fcc1e94764}%


.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function getSource()
        {
            return "robots";
        }

    }

%{odm_a5e5e27596c85370e46e013c6edb33cd}%

.. code-block:: php

    <?php

    // {%odm_a8dde2fd8d68b987095ea611515887ae%}
    $robot = Robots::findById("5087358f2d42b8c3d15ec4e2");

    // {%odm_b7bf91428c8ca18fb00a45b797a06be6%}
    echo $robot->name;

%{odm_5593dab00434cec6bd7ff9eb6a5e4fa8}%

.. code-block:: php

    <?php

    $robot = Robots::findFirst(array(
        array('name' => 'Astroy Boy')
    ));
    $robot->name = "Voltron";
    $robot->save();

%{odm_c2ebf821b71d105eb45a15fb41e418a2}%

--------------------
%{odm_d4babb87a5be4b7ee76640eab4290f07}%


.. code-block:: php

    <?php

    // {%odm_8f607121278f2c25aae4f33cdcdb34b1%}
    $di->set('mongo', function() {
        $mongo = new Mongo();
        return $mongo->selectDb("store");
    }, true);

    // {%odm_fb044871c011d2b2fd2a8988073dbb20%}
    $di->set('mongo', function() {
        $mongo = new Mongo("mongodb:///tmp/mongodb-27017.sock,localhost:27017");
        return $mongo->selectDb("store");
    }, true);

%{odm_c395e1e396d378f13260b962ebc4d212}%

-----------------
%{odm_248e6d6351583db2622387a3d9fa82e2}%


.. code-block:: php

    <?php

    // {%odm_1499c1af63a87b3cd78713aeabe53fc5%}
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // {%odm_87078387b9e7d1df974b6134db85d304%}
    $robots = Robots::find(array(
        array("type" => "mechanical")
    ));
    echo "There are ", count($robots), "\n";

    // {%odm_374f2d32d70da2192748c10713fd747c%}
    $robots = Robots::find(array(
        array("type" => "mechanical"),
        "sort" => array("name" => 1)
    ));

    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // {%odm_cdd7f2c6e82f62f45ef918ef6fbd7c85%}
    $robots = Robots::find(array(
        array("type" => "mechanical"),
        "sort" => array("name" => 1),
        "limit" => 100
    ));

    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

%{odm_dca37eac806548a6c68a838011d99538}%

.. code-block:: php

    <?php

    // {%odm_2ccf3ab58d817b1f80e6e0471dc7c44b%}
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // {%odm_ce2141ebed99ef973b51d2858b4cc2fb%}
    $robot = Robots::findFirst(array(
        array("type" => "mechanical")
    ));
    echo "The first mechanical robot name is ", $robot->name, "\n";

%{odm_1c335b086c81eff06a897a5fbfa8161e}%

.. code-block:: php

    <?php

    // {%odm_f6e55c84bc61550224f8718ddb8901aa%}
    $robot = Robots::findFirst(array(
        "conditions" => array(
            "type" => "mechanical",
            "year" => "1999"
        )
    ));

    // {%odm_3478af64cc93c0cbb71db7996450e769%}
    $robots = Robots::find(array(
        "conditions" => array("type" => "virtual"),
        "sort"       => array("name" => -1)
    ));

%{odm_2b5aacc034cc35eb04d354e3f362416d}%

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                  | Example                                                                 |
+=============+==============================================================================================================================================================================================+=========================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | "conditions" => array('$gt' => 1990)                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| fields      | Returns specific columns instead of the full fields in the collection. When using this option an incomplete object is returned                                                               | "fields" => array('name' => true)                                       |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| sort        | It's used to sort the resultset. Use one or more fields as each element in the array, 1 means ordering upwards, -1 downward                                                                  | "order" => array("name" => -1, "status" => 1)                           |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                   | "limit" => 10                                                           |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| skip        | Skips a number of results                                                                                                                                                                    | "skip" => 50                                                            |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

%{odm_9d556e5bdfec0888023a85b4f7a82160}%

%{odm_0c496866e3b7ef5ccb7d7b86d29300ac}%

------------
%{odm_7c6c29f06857c49db2a97133b9542c98}%


.. code-block:: php

    <?php

    $data = Article::aggregate(array(
        array(
            '$project' => array('category' => 1)
        ),
        array(
            '$group' => array(
                '_id' => array('category' => '$category'),
                'id' => array('$max' => '$_id')
            )
        )
    ));

%{odm_a7f6efdf628627cbfb0183f461cfcd29}%

-------------------------
%{odm_7e1a60800ceef0e69421ebbbc0963ac9}%


%{odm_3985ac741064a84b198fbfb559b38e0a}%

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

%{odm_e27841ee99e14fc6519e0db9d17c2333}%

.. code-block:: php

    <?php

    $robot->save();
    echo "The generated id is: ", $robot->getId();

%{odm_39d425478bbbd8c190c1571d56968719}%

^^^^^^^^^^^^^^^^^^^
%{odm_1dfb448799cd9391845e5659e6a08fa1}%


%{odm_d27c98baf8000da38be80c02eed41dc0}%

.. code-block:: php

    <?php

    if ($robot->save() == false) {
        foreach ($robot->getMessages() as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

%{odm_291df405bc7e94cd5137b3f35777fe55}%

^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{odm_45bd7c03e46d3d6e4123c02b699b12a3}%


+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Operation          | Name                     | Can stop operation?   | Explanation                                                                                                         |
+====================+==========================+=======================+=====================================================================================================================+
| Inserting/Updating | beforeValidation         | YES                   | Is executed before the validation process and the final insert/update to the database                               |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeValidationOnCreate | YES                   | Is executed before the validation process only when an insertion operation is being made                            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeValidationOnUpdate | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an updating operation is being made  |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | onValidationFails        | YES (already stopped) | Is executed before the validation process only when an insertion operation is being made                            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterValidationOnCreate  | YES                   | Is executed after the validation process when an insertion operation is being made                                  |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | afterValidationOnUpdate  | YES                   | Is executed after the validation process when an updating operation is being made                                   |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterValidation          | YES                   | Is executed after the validation process                                                                            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | beforeSave               | YES                   | Runs before the required operation over the database system                                                         |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeUpdate             | YES                   | Runs before the required operation over the database system only when an updating operation is being made           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeCreate             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made          |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | afterUpdate              | NO                    | Runs after the required operation over the database system only when an updating operation is being made            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterCreate              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterSave                | NO                    | Runs after the required operation over the database system                                                          |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+

%{odm_8634db265f5cadee561f9981abadd4a3}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function beforeValidationOnCreate()
        {
            echo "This is executed before creating a Robot!";
        }

    }

%{odm_3fa8d189cbd898ffa9232f5519462f06}%

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Collection
    {

        public function beforeCreate()
        {
            // {%odm_49f3de45257d0e5b7096556a30c385cb%}
            $this->created_at = date('Y-m-d H:i:s');
        }

        public function beforeUpdate()
        {
            // {%odm_f74e28161b504a419d70d64f43d969de%}
            $this->modified_in = date('Y-m-d H:i:s');
        }

    }

%{odm_f8398ace84457fa6a9c43e61ca429370}%

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    //{%odm_7b4ffbc5f44152ae745312315447e233%}
    $eventsManager->attach('collection', function($event, $robot) {
        if ($event->getType() == 'beforeSave') {
            if ($robot->name == 'Scooby Doo') {
                echo "Scooby Doo isn't a robot!";
                return false;
            }
        }
        return true;
    });

    $robot = new Robots();
    $robot->setEventsManager($eventsManager);
    $robot->name = 'Scooby Doo';
    $robot->year = 1969;
    $robot->save();

%{odm_f9081cbced23976e340a4dd7d1c9137a}%

.. code-block:: php

    <?php

    //{%odm_32c6165efcca9e50e36b5db22a9cf784%}
    $di->set('collectionManager', function() {

        $eventsManager = new Phalcon\Events\Manager();

        // {%odm_7b4ffbc5f44152ae745312315447e233%}
        $eventsManager->attach('collection', function($event, $model) {
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

        // {%odm_c106c4e52bc599f6fe8708497906c4aa%}
        $modelsManager = new Phalcon\Mvc\Collection\Manager();
        $modelsManager->setEventsManager($eventsManager);
        return $modelsManager;

    }, true);

%{odm_a2333fe1d4949c60e0ffa88a36ec8b24}%

^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{odm_55a005b019c6e5cffa73b951673ab855}%


%{odm_58acea561b884f8775c83234389a6c67}%

%{odm_cca1ae2eb8ed215dc1a1202d65c9abf9}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";
                return false;
            }
        }

    }

%{odm_cc0c64759378d22ce091113bdd1a7f1c}%

%{odm_53c9ef435efdc751976636021ca78ae8}%

^^^^^^^^^^^^^^^^^^^^^^^^^
%{odm_44f73e5f781842638380d87cc3e0e58d}%


%{odm_1cc9ab87bdb41eb59d0ed209160c60d8}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\InclusionIn,
        Phalcon\Mvc\Model\Validator\Numericality;

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function validation()
        {

            $this->validate(new InclusionIn(
                array(
                    "field"  => "type",
                    "message" => "Type must be: mechanical or virtual",
                    "domain" => array("Mechanical", "Virtual")
                )
            ));

            $this->validate(new Numericality(
                array(
                    "field"  => "price",
                    "message" => "Price must be numeric"
                )
            ));

            return $this->validationHasFailed() != true;
        }

    }

%{odm_6fc5673ab45b31b06590374c8a04678a}%

+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Name         | Explanation                                                                                                                            | Example                                                           |
+==============+========================================================================================================================================+===================================================================+
| Email        | Validates that field contains a valid email format                                                                                     | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Email>`         |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                         | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Exclusionin>`   |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Validates that a value is within a list of possible values                                                                             | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Inclusionin>`   |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Numericality | Validates that a field has a numeric format                                                                                            | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Numericality>`  |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Validates that the value of a field matches a regular expression                                                                       | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Regex>`         |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Validates the length of a string                                                                                                       | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_StringLength>`  |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

%{odm_84bbc78bf253737de49fbc641775a65f}%

.. code-block:: php

    <?php

    class UrlValidator extends \Phalcon\Mvc\Collection\Validator
    {

        public function validate($model)
        {
            $field = $this->getOption('field');

            $value    = $model->$field;
            $filtered = filter_var($value, FILTER_VALIDATE_URL);
            if (!$filtered) {
                $this->appendMessage("The URL is invalid", $field, "UrlValidator");
                return false;
            }
            return true;
        }

    }

%{odm_52bc5373d71ac2fdd32cbb2d8ab1facd}%

.. code-block:: php

    <?php

    class Customers extends \Phalcon\Mvc\Collection
    {

        public function validation()
        {
            $this->validate(new UrlValidator(array(
                "field"  => "url",
            )));
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }

%{odm_54b18d3c6c9a0bde772d9da50d583189}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function validation()
        {
            if ($this->type == "Old") {
                $message = new Phalcon\Mvc\Model\Message(
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

%{odm_0dcecd441d09452dc45fa5fb8fdf84c9}%

----------------
%{odm_40af205b9a04743ad351275a69f4b65a}%


.. code-block:: php

    <?php

    $robot = Robots::findFirst();
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

%{odm_99549cf17570de7a53de04a9b45de1bc}%

.. code-block:: php

    <?php

    $robots = Robots::find(array(
        array("type" => "mechanical")
    ));
    foreach ($robots as $robot) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

%{odm_1754d4c775f9d294061fd18347afd1a0}%

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+

%{odm_9b8dadaae5e0186045cc25e173cc28e3}%

------------------------
%{odm_e5566c1a40baf6c9892dc4174579074f}%


+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSave            | Triggered when the insert/update operation fails for any reason    |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+

%{odm_8198f64c5bcb74146e7192fa3f9a5a40}%

----------------------------------
%{odm_bc3fa5701dfa4336c5777693f4cfb7c6}%


.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Collection
    {
        public function initialize()
        {
            $this->useImplicitObjectIds(false);
        }
    }

%{odm_78d81576bf0a8efea929a760098c2829}%

--------------------------
%{odm_af3d780bdb3c8ad0ddab1b38de1fe472}%


.. code-block:: php

    <?php

    // {%odm_30cd4ac5551309dc7c0bc54a17b89201%}
    $di->set('mongo1', function() {
        $mongo = new Mongo("mongodb://scott:nekhen@192.168.1.100");
        return $mongo->selectDb("management");
    }, true);

    // {%odm_d196fbb3e7afe012a3c3eae42ad22c26%}
    $di->set('mongo2', function() {
        $mongo = new Mongo("mongodb://localhost");
        return $mongo->selectDb("invoicing");
    }, true);

%{odm_aae5be7f170ab14ae4df454c73a9fc63}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {
        public function initialize()
        {
            $this->setConnectionService('mongo1');
        }

    }

%{odm_bf20ac68334be437956a656824fc4005}%

------------------------------
%{odm_4b0148a30c76d202c67e8fd1fd0e8642}%


.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function notSave()
        {
            // {%odm_208f521f101d584f8d276e843032b6c2%}
            $flash = $this->getDI()->getShared('flash');

            // {%odm_b15e59a4e29ae0f51c934d824558da35%}
            foreach ($this->getMessages() as $message){
                $flash->error((string) $message);
            }
        }

    }

%{odm_7b6fb7c569102e80d110f55f0042fe72}%

