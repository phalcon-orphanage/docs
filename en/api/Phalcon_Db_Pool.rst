Class **Phalcon_Db_Pool**
=========================

Manages the caching of database connections. With the help of Phalcon_Db\Pool, developers can be  sure that no new database connections will make when calling multiple of times Phalcon_Db\Pool::getConnection().  

.. code-block:: php

    <?php

    
    
     use Phalcon\Db\Pool as DbPool;
    
     $config = new stdClass();
     $config->adapter = 'Mysql';
     $config->host = '127.0.0.1';
     $config->username = 'root';
     $config->password = '';
     $config->name = 'phalcon_test';
    
     DbPool::setDefaultDescriptor($config);
    
    //Returns a connection
     $connection = DbPool::getConnection();
    
    //Returns the same connection
     $connection = DbPool::getConnection();
    
    //Returns a new connection
     $connection = DbPool::getConnection(new);

Methods
---------

**boolean** **hasDefaultDescriptor** ()

Check if a default descriptor has already defined

**boolean** **setDefaultDescriptor** (array $options)

Sets the default descriptor for database connections. 

.. code-block:: php

    <?php

    $config = array(
      "adapter" => "Mysql",
      "host" => "localhost",
      "username" => "scott",
      "password" => "cheetah",
      "name" => "test_db"
    );
    Phalcon\Db\Pool::setDefaultDescriptor($config);





**Phalcon\Db** **getConnection** (boolean $newConnection, boolean $renovate)

Returns a connection builded with the default descriptor parameters  

.. code-block:: php

    <?php $connection = Phalcon\Db\Pool::getConnection();





**reset** ()

Resets default descriptor and connection

