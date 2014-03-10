%{events_afb299ea125f4b358f027bbaeb866b2d}%

==============
%{events_aac87938048f8f57d6a8477faebe84e6}%


%{events_b2923a136099a523e93b60cda2e7677e}%

-------------
%{events_d3781bf0aa8891e4b4b478e626ec61ba}%


.. code-block:: php

    <?php

    class MyDbListener
    {

        public function afterConnect()
        {

        }

        public function beforeQuery()
        {

        }

        public function afterQuery()
        {

        }

    }

%{events_5f3235ad2fb6e8dba5ace17fd39e99f0}%

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    //{%events_90aa77c535449519564137eda423cd6f%}
    $dbListener = new MyDbListener();

    //{%events_d15114be04209e5fae3b603ffbbf13b1%}
    $eventsManager->attach('db', $dbListener);

    $connection = new DbAdapter(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //{%events_b7efb4940856cd2cf63a1277b1523399%}
    $connection->setEventsManager($eventsManager);

    //{%events_a0ea75b3e78f593f08de2e911b50a16d%}
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

%{events_fd5479e2985d7c1d56a8d7c64d0f5340}%

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as Logger;

    class MyDbListener
    {

        protected $_logger;

        public function __construct()
        {
            $this->_logger = new Logger("../apps/logs/db.log");
        }

        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
        }

    }

%{events_163988a35ef91aeddfd6eaae7eaa62f7}%

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler,
        Phalcon\Logger,
        Phalcon\Logger\Adapter\File;

    class MyDbListener
    {

        protected $_profiler;

        protected $_logger;

        /**
         * Creates the profiler and starts the logging
         */
        public function __construct()
        {
            $this->_profiler = new Profiler();
            $this->_logger = new Logger("../apps/logs/db.log");
        }

        /**
         * This is executed if the event triggered is 'beforeQuery'
         */
        public function beforeQuery($event, $connection)
        {
            $this->_profiler->startProfile($connection->getSQLStatement());
        }

        /**
         * This is executed if the event triggered is 'afterQuery'
         */
        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), Logger::INFO);
            $this->_profiler->stopProfile();
        }

        public function getProfiler()
        {
            return $this->_profiler;
        }

    }

%{events_f4ac5ffededae837cd3d46cf9f57cf0c}%

.. code-block:: php

    <?php

    //{%events_a0ea75b3e78f593f08de2e911b50a16d%}
    $connection->execute("SELECT * FROM products p WHERE p.status = 1");

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

%{events_c15d5e6bd78d7b5876de2af36691bda1}%

.. code-block:: php

    <?php

    //{%events_d15114be04209e5fae3b603ffbbf13b1%}
    $eventManager->attach('db', function($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

%{events_3b8e6a649d2826cb536fa01f0646965b}%

---------------------------------------
%{events_1b4f6a3242af44a8a67fd89078e36bc0}%


.. code-block:: php

    <?php

    use Phalcon\Events\EventsAwareInterface;

    class MyComponent implements EventsAwareInterface
    {

        protected $_eventsManager;

        public function setEventsManager($eventsManager)
        {
            $this->_eventsManager = $eventsManager;
        }

        public function getEventsManager()
        {
            return $this->_eventsManager;
        }

        public function someTask()
        {
            $this->_eventsManager->fire("my-component:beforeSomeTask", $this);

            // {%events_57b33ef02a4ae9378a58574fc10b6a9d%}

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }

    }

%{events_d55f27db8320d6582537f9bb067f83c6}%

.. code-block:: php

    <?php

    class SomeListener
    {

        public function beforeSomeTask($event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";
        }

        public function afterSomeTask($event, $myComponent)
        {
            echo "Here, afterSomeTask\n";
        }

    }

%{events_d08664e6abf6890d19799d45df0d5277}%

.. code-block:: php

    <?php

    //{%events_fc4786a23c525da4add9bcc3d60f8054%}
    $eventsManager = new Phalcon\Events\Manager();

    //{%events_a3ee1df6498c28ea889b5460d103cc0c%}
    $myComponent = new MyComponent();

    //{%events_322cc6e93a4ae29cbfe02d8ff7753704%}
    $myComponent->setEventsManager($eventsManager);

    //{%events_61dc62cc7c424897248c47a8c00ae149%}
    $eventsManager->attach('my-component', new SomeListener());

    //{%events_7db9f2fbcc01d80b3d28204cfffba8e4%}
    $myComponent->someTask();

%{events_bb8a89aaf595ffb10b7da5699454a29e}%

.. code-block:: php

    Here, beforeSomeTask
    Here, afterSomeTask

%{events_febbb228c19a2f26d17e27168fa25795}%

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

%{events_0b904e84f1ec1fa79efa8df387dfb9d4}%

.. code-block:: php

    <?php

    //{%events_48fd6aaddcb68b7c2560f23546d43fcf%}
    $eventManager->attach('my-component', function($event, $component, $data) {
        print_r($data);
    });

    //{%events_ca881428d69dabaaa5b05d9e6395829c%}
    $eventManager->attach('my-component', function($event, $component) {
        print_r($event->getData());
    });

%{events_14bd8a400efae29723f96be78bdb675a}%

.. code-block:: php

    <?php

    //{%events_619561ca4aaa80cf27dde0f8ac3d7efb%}
    $eventManager->attach('my-component:beforeSomeTask', function($event, $component) {
        //...
    });

%{events_aa0f658456ea9d7a3cd2da9a6ccaedf7}%

-----------------------------
%{events_8959d6f8105504c11841abab2ab8bd84}%


.. code-block:: php

    <?php

    $eventsManager->attach('db', function($event, $connection){

        //{%events_09482c6f09b220af893ba0134b0b93da%}
        if ($event->isCancelable()) {
            //{%events_f119c05ea80e3ed4ee7db2dda5946731%}
            $event->stop();
        }

        //...

    });

%{events_4ed65d632a3128d31fa81087f63e7043}%

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

%{events_f4e32e14dcbb772d36896def5709ee7b}%

-------------------
%{events_0fa41c6a956acf07a6651af119844aab}%


.. code-block:: php

    <?php

    $evManager->enablePriorities(true);

    $evManager->attach('db', new DbListener(), 150); //{%events_80405017035b0746c31b3d93adc4b60c%}
    $evManager->attach('db', new DbListener(), 100); //{%events_d908af86e640cf898aaf55a070a9f8a1%}
    $evManager->attach('db', new DbListener(), 50); //{%events_a32ccf656e86ac8335dc85271fd7051f%}

%{events_be2ad66dadd0459a65075bfc2343e9d5}%

--------------------
%{events_8192798658b3e74a5e39425665bffe65}%


.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $evManager = new EventsManager();

    //{%events_6d4fda59eb03b37047ef6f597e85a39a%}
    $evManager->collectResponses(true);

    //{%events_106eac9a28739f21d92acca480af02cc%}
    $evManager->attach('custom:custom', function() {
        return 'first response';
    });

    //{%events_106eac9a28739f21d92acca480af02cc%}
    $evManager->attach('custom:custom', function() {
        return 'second response';
    });

    //{%events_0b1cdf85c78347f11997406a17e7113a%}
    $evManager->fire('custom:custom', null);

    //{%events_33b4d38e391256eba619e73ab7c86dab%}
    print_r($evManager->getResponses());

%{events_347f19399137be68322d5db99c9f2d43}%

.. code-block:: html

    Array ( [0] => first response [1] => second response )

