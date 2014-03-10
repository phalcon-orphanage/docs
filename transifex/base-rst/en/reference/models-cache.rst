%{models-cache_839f3f9c5311b487faa792e0587aa2c6}%
==================
%{models-cache_95cb61056b392ac5982d769f3a94770a}%

%{models-cache_e55c4c7c721ad73838373f9792e1c8c3}%

%{models-cache_6422e6a17a2941513403f9d3640a1c81}%
------------------
%{models-cache_9bc17a041fe4fe724ea7d4fdbe869c0f}%

%{models-cache_44caed33d968a824136a964a9949ebbe|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

%{models-cache_21d5d2514aaf252b9bb348c579753209|:doc:`cache <cache>`}%

.. code-block:: php

    <?php

    //{%models-cache_c46ec7fd0baf68b0a0398abad10d045c%}
    $di->set('modelsCache', function() {

        //{%models-cache_83b746e3e149c65f5d387ee018ce18e1%}
        $frontCache = new \Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 86400
        ));

        //{%models-cache_27c9c860a0e993fc9cd8fe1f98c2dd13%}
        $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });


%{models-cache_eb40dd6627183a961e507390d965a529}%

.. code-block:: php

    <?php

    // {%models-cache_d3f37d5d77852c3754f59d5c8bc38a1c%}
    $products = Products::find();

    // {%models-cache_c90421ba39563a01954c9e38a0efa33d%}
    $products = Products::find(array(
        "cache" => array("key" => "my-cache")
    ));

    // {%models-cache_d210140ea7a975f5af5204a35990b6c6%}
    $products = Products::find(array(
        "cache" => array("key" => "my-cache", "lifetime" => 300)
    ));

    // {%models-cache_051afb10c0cf687b846f3b6897f762d4%}
    $products = Products::find(array("cache" => $myCache));


%{models-cache_157e77512eaf5de628c5f6d233869c8d}%

.. code-block:: php

    <?php

    // {%models-cache_aa2e6bcafd60883ae49cc24e0cb61605%}
    $post = Post::findFirst();

    // {%models-cache_3207752bc461bd9261c3a11699997cc6%}
    $comments = $post->getComments(array(
        "cache" => array("key" => "my-key")
    ));

    // {%models-cache_ef555ec89407e63d3269ccd2b15d887d%}
    $comments = $post->getComments(array(
        "cache" => array("key" => "my-key", "lifetime" => 3600)
    ));


%{models-cache_9d4f9253bcab3867f5842dcb634dede4}%

%{models-cache_1309780b72f30496b61631983bcbdc8c}%

%{models-cache_3ed32570bf1cb380cb4f367cc81bb281}%
-------------------------
%{models-cache_d133521b4034fa05c7fd7bbaf09ff142|:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        public static function find($parameters=null)
        {
            return parent::find($parameters);
        }

        public static function findFirst($parameters=null)
        {
            return parent::findFirst($parameters);
        }

    }


%{models-cache_373fe0ef7bf8bbc1062fa79aa92fe215}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        protected static $_cache = array();

        /**
         * Implement a method that returns a string key based
         * on the query parameters
         */
        protected static function _createKey($parameters)
        {
            $uniqueKey = array();
            foreach ($parameters as $key => $value) {
                if (is_scalar($value)) {
                    $uniqueKey[] = $key . ':' . $value;
                } else {
                    if (is_array($value)) {
                        $uniqueKey[] = $key . ':[' . self::_createKey($value) .']';
                    }
                }
            }
            return join(',', $uniqueKey);
        }

        public static function find($parameters=null)
        {

            //{%models-cache_d96ab0d2abf8d06ac79f194da6dba4c9%}
            $key = self::_createKey($parameters);

            if (!isset(self::$_cache[$key])) {
                //{%models-cache_119ef0030a2b09b65c226429b076f571%}
                self::$_cache[$key] = parent::find($parameters);
            }

            //{%models-cache_663cf45b9f459a24aa2ac47eaa908b67%}
            return self::$_cache[$key];
        }

        public static function findFirst($parameters=null)
        {
            // ...
        }

    }


%{models-cache_af2c0186f6bd6b7836c204d7fbf89d42}%

%{models-cache_1684acf662dbb430e9bb369d7f6d9539}%

.. code-block:: php

    <?php

    public static function find($parameters=null)
    {

        //{%models-cache_d96ab0d2abf8d06ac79f194da6dba4c9%}
        $key = self::_createKey($parameters);

        if (!isset(self::$_cache[$key])) {

            //{%models-cache_1678a76d8468b285a88907821276306c%}
            if (apc_exists($key)) {

                $data = apc_fetch($key);

                //{%models-cache_119ef0030a2b09b65c226429b076f571%}
                self::$_cache[$key] = $data;

                return $data;
            }

            //{%models-cache_6d53a17bb9a5ffabff2ff97b2d171752%}
            $data = parent::find($parameters);

            //{%models-cache_119ef0030a2b09b65c226429b076f571%}
            self::$_cache[$key] = $data;

            //{%models-cache_5f532865df03a51e71ee2083bc94aa1e%}
            apc_store($key, $data);

            return $data;
        }

        //{%models-cache_663cf45b9f459a24aa2ac47eaa908b67%}
        return self::$_cache[$key];
    }


%{models-cache_3f0550c5ba8bc66b0145c05b696ba62f}%

.. code-block:: php

    <?php

    class CacheableModel extends Phalcon\Mvc\Model
    {

        protected static function _createKey($parameters)
        {
            // {%models-cache_4e1375f53ef0c978cf609acea7c76b38%}
        }

        public static function find($parameters=null)
        {
            //{%models-cache_3e18e6fd93493211f25173d06798d74b%}
        }

        public static function findFirst($parameters=null)
        {
            //{%models-cache_3e18e6fd93493211f25173d06798d74b%}
        }
    }


%{models-cache_cbef6dec996aaedacb875ab47b4a478c}%

.. code-block:: php

    <?php

    class Robots extends CacheableModel
    {

    }


%{models-cache_f619f9e90a14811a9326ce3d6a6e6aca}%
-------------
%{models-cache_6bbeb0f3b3dfb43ae7d746922da64e28}%

.. code-block:: php

    <?php

    // {%models-cache_d210140ea7a975f5af5204a35990b6c6%}
    $products = Products::find(array(
        "cache" => array("key" => "my-cache", "lifetime" => 300)
    ));


%{models-cache_5355522211efcea8d6cb4dddddc0d400}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        protected static function _createKey($parameters)
        {
            // {%models-cache_4e1375f53ef0c978cf609acea7c76b38%}
        }

        public static function find($parameters=null)
        {

            //{%models-cache_124512375dc436ec89c8e2e17f355c43%}
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            //{%models-cache_0c9372806ffb6745c9c9adacd667b27b%}
            //{%models-cache_d983887368bc1aeeb8a7d0dbf37820a2%}
            if (!isset($parameters['cache'])) {
                $parameters['cache'] = array(
                    "key" => self::_createKey($parameters),
                    "lifetime" => 300
                );
            }

            return parent::find($parameters);
        }

        public static function findFirst($parameters=null)
        {
            //...
        }

    }


%{models-cache_7f9169fdf457cb880ce9d25973c73f11}%
--------------------
%{models-cache_823b323401bce868288be958bb3ef207}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE name = :name:";

    $query = $this->modelsManager->createQuery($phql);

    $query->cache(array(
        "key" => "cars-by-name",
        "lifetime" => 300
    ));

    $cars = $query->execute(array(
        'name' => 'Audi'
    ));


%{models-cache_2dc92ee793d02090370464d78ca48dac}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE name = :name:";

    $cars = $this->modelsManager->executeQuery($phql, array(
        'name' => 'Audi'
    ));

    apc_store('my-cars', $cars);


%{models-cache_69ebf3305cc0af755ddf55bcad46f10c}%
------------------------
%{models-cache_aca1bd8a06b637f2491038b833ca4432}%

.. code-block:: php

    <?php

    //{%models-cache_1a35fb79d9063249f16d3ca67bead727%}
    $invoice = Invoices::findFirst();

    //{%models-cache_8a4daeca65f733dbdc9dbca6527f851d%}
    $customer = $invoice->customer;

    //{%models-cache_e16166444362b0fe474040cd3eaad5e1%}
    echo $customer->name, "\n";


%{models-cache_1450b2b316074644f2fd775d07035126}%

.. code-block:: php

    <?php

    //{%models-cache_734229e26203c940522b7093b2cf214a%}
    // SELECT * FROM invoices;
    foreach (Invoices::find() as $invoice) {

        //{%models-cache_8a4daeca65f733dbdc9dbca6527f851d%}
        // SELECT * FROM customers WHERE id = ?;
        $customer = $invoice->customer;

        //{%models-cache_e16166444362b0fe474040cd3eaad5e1%}
        echo $customer->name, "\n";
    }


%{models-cache_fbb8a44bfd4a304b97d2d4207789550b}%

.. code-block:: php

    <?php

    class Invoices extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo("customers_id", "Customer", "id", array(
                'reusable' => true
            ));
        }

    }


%{models-cache_cab4981195cf8fa7422a401ca5cd521f}%

.. code-block:: php

    <?php

    class CustomModelsManager extends \Phalcon\Mvc\Model\Manager
    {

        /**
         * Returns a reusable object from the cache
         *
         * @param string $modelName
         * @param string $key
         * @return object
         */
        public function getReusableRecords($modelName, $key){

            //{%models-cache_fc7175adef9a2ba7477f57e9ec8cb1f5%}
            if ($modelName == 'Products'){
                return apc_fetch($key);
            }

            //{%models-cache_5b802a5671396df846d4678aa45910c2%}
            return parent::getReusableRecords($modelName, $key);
        }

        /**
         * Stores a reusable record in the cache
         *
         * @param string $modelName
         * @param string $key
         * @param mixed $records
         */
        public function setReusableRecords($modelName, $key, $records){

            //{%models-cache_fc7175adef9a2ba7477f57e9ec8cb1f5%}
            if ($modelName == 'Products'){
                apc_store($key, $records);
                return;
            }

            //{%models-cache_5b802a5671396df846d4678aa45910c2%}
            parent::setReusableRecords($modelName, $key, $records);
        }
    }


%{models-cache_7029c833677ccfbe1f854bc8642b9631}%

.. code-block:: php

    <?php

    $di->setShared('modelsManager', function() {
        return new CustomModelsManager();
    });


%{models-cache_efe555e4b6c2aa4b091efcfdd07feba7}%
-----------------------
%{models-cache_167c1bde680b7a2a0bdf02e7f6a2a846}%

+---------------------+---------------------------------------------------------------------------------------------------------------+
| Type                | Description                                                                          | Implicit Method        |
+=====================+===============================================================================================================+
| Belongs-To          | Returns a model instance of the related record directly                              | findFirst              |
+---------------------+---------------------------------------------------------------------------------------------------------------+
| Has-One             | Returns a model instance of the related record directly                              | findFirst              |
+---------------------+---------------------------------------------------------------------------------------------------------------+
| Has-Many            | Returns a collection of model instances of the referenced model                      | find                   |
+---------------------+---------------------------------------------------------------------------------------------------------------+


%{models-cache_ae2a8ea75f237e1665de20deddd187af}%

.. code-block:: php

    <?php

    //{%models-cache_1a35fb79d9063249f16d3ca67bead727%}
    $invoice = Invoices::findFirst();

    //{%models-cache_8a4daeca65f733dbdc9dbca6527f851d%}
    $customer = $invoice->customer; // Invoices::findFirst('...');

    //{%models-cache_95b197310c9f475e448775744fbd67db%}
    $customer = $invoice->getCustomer(); // Invoices::findFirst('...');


%{models-cache_1f88a87fa11cb62e4d916071b5cf0ed4}%

.. code-block:: php

    <?php

    class Invoices extends Phalcon\Mvc\Model
    {

        public static function findFirst($parameters=null)
        {
            //{%models-cache_3e18e6fd93493211f25173d06798d74b%}
        }
    }


%{models-cache_22d2fa1350f9f3ee06e9af91feb8603f}%
-----------------------------------
%{models-cache_2bd99a946141b3039b298fa5dd8015c8}%

.. code-block:: php

    <?php

    class Invoices extends Phalcon\Mvc\Model
    {

        protected static function _createKey($parameters)
        {
            // {%models-cache_4e1375f53ef0c978cf609acea7c76b38%}
        }

        protected static function _getCache($key)
        {
            // {%models-cache_46d72b8da1dd6d78ff8f4a7a776363dd%}
        }

        protected static function _setCache($key)
        {
            // {%models-cache_3385399d048079251dee2de3ce0933c4%}
        }

        public static function find($parameters=null)
        {
            //{%models-cache_3162d85b9d80a0d6168430d6792ccb08%}
            $key = self::_createKey($parameters);

            //{%models-cache_2098f517516d00008a3963bd44c0b7bc%}
            $results = self::_getCache($key);

            // {%models-cache_b2a7f24709a2fea9345b6059afe5a32f%}
            if (is_object($results)) {
                return $results;
            }

            $results = array();

            $invoices = parent::find($parameters);
            foreach ($invoices as $invoice) {

                //{%models-cache_d91c9ea6ee79bfd38fd16847d2c76011%}
                $customer = $invoice->customer;

                //{%models-cache_d92eea8a14ab0e4d417e5cb4b407dfa6%}
                $invoice->customer = $customer;

                $results[] = $invoice;
            }

            //{%models-cache_fcbdd942176611635b18b4a09c2c4840%}
            self::_setCache($key, $results);

            return $results;
        }

        public function initialize()
        {
            // {%models-cache_89e355a6cd118fbef59f6f3851d1ac1d%}
        }
    }


%{models-cache_b2328f272dbe20be455b22c19b1ff9d5}%

.. code-block:: php

    <?php

    class Invoices extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            // {%models-cache_89e355a6cd118fbef59f6f3851d1ac1d%}
        }

        protected static function _createKey($conditions, $params)
        {
            // {%models-cache_4e1375f53ef0c978cf609acea7c76b38%}
        }

        public function getInvoicesCustomers($conditions, $params=null)
        {
            $phql = "SELECT Invoices.*, Customers.*
            FROM Invoices JOIN Customers WHERE " . $conditions;

            $query = $this->getModelsManager()->executeQuery($phql);

            $query->cache(array(
                "key" => self::_createKey($conditions, $params),
                "lifetime" => 300
            ));

            return $query->execute($params);
        }

    }


%{models-cache_6eb6ea83e4137a5f45e1ec79b91ec252}%
---------------------------
%{models-cache_5e6828717b8ad3c64fa12c43a9647bc6}%

+---------------------+--------------------+
| Type                | Cache Backend      |
+=====================+====================+
| 1 - 10000           | mongo1             |
+---------------------+--------------------+
| 10000 - 20000       | mongo2             |
+---------------------+--------------------+
| > 20000             | mongo3             |
+---------------------+--------------------+


%{models-cache_165c2321d4782029a5eccc88bbbd88f7}%

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public static function queryCache($initial, $final)
        {
            if ($initial >= 1 && $final < 10000) {
                return self::find(array(
                    'id >= ' . $initial . ' AND id <= '.$final,
                    'cache' => array('service' => 'mongo1')
                ));
            }
            if ($initial >= 10000 && $final <= 20000) {
                return self::find(array(
                    'id >= ' . $initial . ' AND id <= '.$final,
                    'cache' => array('service' => 'mongo2')
                ));
            }
            if ($initial > 20000) {
                return self::find(array(
                    'id >= ' . $initial,
                    'cache' => array('service' => 'mongo3')
                ));
            }
        }

    }


%{models-cache_b4eb94aa4b707ff948987f11f2495f1b}%

.. code-block:: php

    <?php

    $robots = Robots::find('id < 1000');
    $robots = Robots::find('id > 100 AND type = "A"');
    $robots = Robots::find('(id > 100 AND type = "A") AND id < 2000');

    $robots = Robots::find(array(
        '(id > ?0 AND type = "A") AND id < ?1',
        'bind' => array(100, 2000),
        'order' => 'type'
    ));


%{models-cache_e4b3c844d52b969d134289d33803be79}%

%{models-cache_49f732032f4ed83cde0f4665fd0fd0c5}%

.. code-block:: php

    <?php

    class CustomQueryBuilder extends Phalcon\Mvc\Model\Query\Builder
    {

        public function getQuery()
        {
            $query = new CustomQuery($this->getPhql());
            $query->setDI($this->getDI());
            return $query;
        }

    }


%{models-cache_272d7300204775890fec39f6cd0b2f4e}%

.. code-block:: php

    <?php

    class CustomQuery extends Phalcon\Mvc\Model\Query
    {

        /**
         * The execute method is overridden
         */
        public function execute($params=null, $types=null)
        {
            //{%models-cache_f1b035de1dc50b7dfd1086491b7ae3c8%}
            $ir = $this->parse();

            //{%models-cache_ea774c2ceec533e35b2612b8ca97cc8f%}
            if (isset($ir['where'])) {

                //{%models-cache_45aa40645c4c172881990fbb3fb9c2c3%}
                //{%models-cache_84bd683466da005c46771e0f7857866a%}
                //{%models-cache_4b795271f09b698f34ca37f35a50c234%}
                $visitor = new CustomNodeVisitor();

                //{%models-cache_ee145a2797f4511011485ecf69891e90%}
                $visitor->visit($ir['where']);

                $initial = $visitor->getInitial();
                $final = $visitor->getFinal();

                //{%models-cache_ad8dabad2ff8985fc4c2273aabaefe7a%}
                //...

                //{%models-cache_f161bcb6c3b55fd3a4badb79278d3c9e%}
                //...
            }

            //{%models-cache_d24ba4a062f845a259f6bd1397452bdd%}
            $result = $this->_executeSelect($ir, $params, $types);

            //{%models-cache_b5fdcd2ba8fb2872ce268fb85a100d41%}
            //...

            return $result;
        }

    }


%{models-cache_581b25c6139a967f221c16f07b976187}%

.. code-block:: php

    <?php

    class CustomNodeVisitor
    {

        protected $_initial = 0;

        protected $_final = 25000;

        public function visit($node)
        {
            switch ($node['type']) {

                case 'binary-op':

                    $left = $this->visit($node['left']);
                    $right = $this->visit($node['right']);
                    if (!$left || !$right) {
                        return false;
                    }

                    if ($left=='id') {
                        if ($node['op'] == '>') {
                            $this->_initial = $right;
                        }
                        if ($node['op'] == '=') {
                            $this->_initial = $right;
                        }
                        if ($node['op'] == '>=')    {
                            $this->_initial = $right;
                        }
                        if ($node['op'] == '<') {
                            $this->_final = $right;
                        }
                        if ($node['op'] == '<=')    {
                            $this->_final = $right;
                        }
                    }
                    break;

                case 'qualified':
                    if ($node['name'] == 'id') {
                        return 'id';
                    }
                    break;

                case 'literal':
                    return $node['value'];

                default:
                    return false;
            }
        }

        public function getInitial()
        {
            return $this->_initial;
        }

        public function getFinal()
        {
            return $this->_final;
        }
    }


%{models-cache_054a0fc78f44ab0a1bb8c9c985de828b}%

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {
        public static function find($parameters=null)
        {

            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            $builder = new CustomQueryBuilder($parameters);
            $builder->from(get_called_class());

            if (isset($parameters['bind'])) {
                return $builder->getQuery()->execute($parameters['bind']);
            } else {
                return $builder->getQuery()->execute();
            }

        }
    }


%{models-cache_ed63aed4efe90a846731cdb4b7dcf805}%
------------------------
%{models-cache_746ea0323975bebf6107bb63e8f3c362}%

.. code-block:: php

    <?php

    for ($i = 1; $i <= 10; $i++) {

        $phql = "SELECT * FROM Store\Robots WHERE id = " . $i;
        $robots = $this->modelsManager->executeQuery($phql);

        //...
    }


%{models-cache_2a89882635811354d83208102969e432}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";

    for ($i = 1; $i <= 10; $i++) {

        $robots = $this->modelsManager->executeQuery($phql, array($i));

        //...
    }


%{models-cache_d53e1af67acdb733459dec78b03de176}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";
    $query = $this->modelsManager->createQuery($phql);

    for ($i = 1; $i <= 10; $i++) {

        $robots = $query->execute($phql, array($i));

        //...
    }


%{models-cache_bdde4f7dba11a26c566d816a82550e0f|`prepared statements`_|`SQL Injections`_}%

