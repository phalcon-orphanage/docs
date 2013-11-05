Abstract class **Phalcon\\Db**
==============================

Phalcon\\Db and its related classes provide a simple SQL database interface for Phalcon Framework. The Phalcon\\Db is the basic class you use to connect your PHP application to an RDBMS. There is a different adapter class for each brand of RDBMS.  This component is intended to lower level database operations. If you want to interact with databases using higher level of abstraction use Phalcon\\Mvc\\Model.  Phalcon\\Db is an abstract class. You only can use it with a database adapter like Phalcon\\Db\\Adapter\\Pdo  

.. code-block:: php

    <?php

    try {
    
      $connection = new Phalcon\Db\Adapter\Pdo\Mysql(array(
         'host' => '192.168.0.11',
         'username' => 'sigma',
         'password' => 'secret',
         'dbname' => 'blog',
         'port' => '3306',
      ));
    
      $result = $connection->query("SELECT * FROM robots LIMIT 5");
      $result->setFetchMode(Phalcon\Db::FETCH_NUM);
      while ($robot = $result->fetch()) {
        print_r($robot);
      }
    
    } catch (Phalcon\Db\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
    }



Constants
---------

*integer* **FETCH_ASSOC**

*integer* **FETCH_BOTH**

*integer* **FETCH_NUM**

*integer* **FETCH_OBJ**

Methods
---------

public static  **setup** (*array* $options)

Enables/disables options in the Database component



