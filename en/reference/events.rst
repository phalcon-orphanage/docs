Events Manager
==============

The purpose of this component is to intercept the execution of most of the components of the framework by creating “hooks point”. These hook points allow the developer to obtain status information, manipulate data or change the flow of execution during the process of a component.

In the following example, we use the EventManager to listen for events produced in a MySQL connection managed by Phalcon\\Db. First of all, we need a listener object to do this. We create a class which methods are the events we want to listen:

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

This new class can be as verbose as we need it to. The EventsManager will interface between the component and our listener class, offering hook points based on the methods we defined in our listener class:

.. code-block:: php

    <?php

	$eventsManager = new \Phalcon\Events\Manager();

	//Create a database listener
	$dbListener = new MyDbListener()

	//Listen all the database events
	$eventsManager->attach('db', $dbListener);

	$connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
	    "host" => "localhost",
	    "username" => "root",
	    "password" => "secret",
	    "dbname" => "invo"
	));

	//Assign the eventsManager to the db adapter instance
	$connection->setEventsManager($eventsManager);

	//Send a SQL command to the database server
	$connection->query("SELECT * FROM products p WHERE p.status = 1");

In order to log all the SQL statements executed by our application, we need to use the event “afterQuery”. The first parameter passed to the event listener contains contextual information about the event that is running, the second is the connection itself.

.. code-block:: php

    <?php

	class MyDbListener
	{

	    protected $_logger;

	    public function __construct()
	    {
	        $this->_logger = new \Phalcon\Logger\Adapter\File("../apps/logs/db.log");
	    }

	    public function afterQuery($event, $connection)
	    {
	        $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
	    }

	}

As part of this example, we will also implement the Phalcon\Db\Profiler to detect the SQL statements that are taking longer to execute than expected:

.. code-block:: php

    <?php

	class MyDbListener
	{

	    protected $_profiler;

	    protected $_logger;

	    public function __construct()
	    {
	        $this->_profiler = new \Phalcon\Db\Profiler();
	        $this->_logger = new \Phalcon\Logger\Adapter\File("../apps/logs/db.log");
	    }

	    public function beforeQuery($event, $connection)
	    {
	        $this->_profiler->startProfile($connection->getSQLStatement());
	    }

	    public function afterQuery($event, $connection)
	    {
	        $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
	        $this->_profiler->stopProfile();
	    }

	    public function getProfiler()
	    {
	        return $this->_profiler;
	    }

	}

The resulting profile data can be obtained from the listener:

.. code-block:: php

    <?php

	//Send a SQL command to the database server
	$connection->query("SELECT * FROM products p WHERE p.status = 1");

	foreach($dbListener->getProfiler()->getProfiles() as $profile){
	    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
	    echo "Start Time: ", $profile->getInitialTime(), "\n"
	    echo "Final Time: ", $profile->getFinalTime(), "\n";
	    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
	}

In a similar manner we can register an lambda function to perform the task instead of a separate listener class (as seen above):

.. code-block:: php

    <?php

	//Listen all the database events
	$eventManager->attach('db', function($event, $connection){
	    if ($event->getType() == 'afterQuery') {
	        echo $connection->getSQLStatement();
	    }
	});

