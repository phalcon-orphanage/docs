Framework Settings
==================
This list includes the directives you can set to configure your Phalcon setup:

+---------+----------------+------------------------------------------------------------------------------+----------------------------------------+
| Section | File           | Description                                                                  | Example                                | 
+=========+================+==============================================================================+========================================+
| phalcon | controllersDir | Directory where Phalcon_Dispatcher will get the controllers classes          | controllersDir = "../app/controllers/" | 
+---------+----------------+------------------------------------------------------------------------------+----------------------------------------+
| phalcon | modelsDir      | Directory where Phalcon_Model_Manager will get the models classes            | modelsDir = "../app/models/"           | 
+---------+----------------+------------------------------------------------------------------------------+----------------------------------------+
| phalcon | viewsDir       | Directory on where Phalcon_View will get the views files                     | viewsDir = "../app/views/"             | 
+---------+----------------+------------------------------------------------------------------------------+----------------------------------------+
| phalcon | baseUri        | The absolute uri to the directory where the application was installed        | baseUri = "/store/"                    | 
+---------+----------------+------------------------------------------------------------------------------+----------------------------------------+
| phalcon | basePath       | The absolute local path to the directory where the application was installed | basePath = "/srv/www/htdocs/store/"    | 
+---------+----------------+------------------------------------------------------------------------------+----------------------------------------+


+----------+----------+------------------------------------------------------------------------------------------+---------------------+
| Section  | File     | Description                                                                              | Example             | 
+==========+==========+==========================================================================================+=====================+
| database | adapter  | Adapter used to connect to the database. This is usually the name of the database system | adapter = Mysql     | 
+----------+----------+------------------------------------------------------------------------------------------+---------------------+
| database | host     | Host where the database is located                                                       | host = "127.0.0.1"  | 
+----------+----------+------------------------------------------------------------------------------------------+---------------------+
| database | username | Database user to connect to the database                                                 | username = "root"   | 
+----------+----------+------------------------------------------------------------------------------------------+---------------------+
| database | password | Database password to connect to the database                                             | password = "secret" | 
+----------+----------+------------------------------------------------------------------------------------------+---------------------+
| database | name     | Name of the database or schema                                                           | name = "demo"       | 
+----------+----------+------------------------------------------------------------------------------------------+---------------------+

+---------+----------------+----------------------------------------------------------------+--------------------------+
| Section | File           | Description                                                    | Example                  | 
+=========+================+================================================================+==========================+
| models  | cache.adapter  | Name of the adapter used to cache resulsets with Phalcon_Cache | cache.adapter = "demo"   | 
+---------+----------------+----------------------------------------------------------------+--------------------------+
| models  | cache.host     | If Memcached is used as adapter, the memcached port            | cache.host = "localhost" | 
+---------+----------------+----------------------------------------------------------------+--------------------------+
| models  | cache.port     | If Memcached is used as adapter, the memcached port            | cache.port = 11211       | 
+---------+----------------+----------------------------------------------------------------+--------------------------+
| models  | cache.port     | If Memcached is used as adapter, the memcached port            | cache.port = 11211       | 
+---------+----------------+----------------------------------------------------------------+--------------------------+
| models  | cache.lifetime | Default time to live of the cache in seconds                   | cache.lifetime = 3600    | 
+---------+----------------+----------------------------------------------------------------+--------------------------+

+---------+------------------+-----------------------------------------------------------------------------+-------------------------------+
| Section | File             | Description                                                                 | Example                       | 
+=========+==================+=============================================================================+===============================+
| models  | metadata.adapter | Name of the adapter used to cache table meta-data in Phalcon_Model_MetaData | metadata.adapter = "Apc"      | 
+---------+------------------+-----------------------------------------------------------------------------+-------------------------------+
| models  | metadata.adapter | Suffix to group caches related to meta-data. This is optional               | metadata.suffix = "my-suffix" | 
+---------+------------------+-----------------------------------------------------------------------------+-------------------------------+
| models  | metadata.adapter | Suffix to group caches related to meta-data. This is optional               | metadata.suffix = "my-suffix" | 
+---------+------------------+-----------------------------------------------------------------------------+-------------------------------+


+---------+----------------+--------------------------------------------------------------------+--------------------------+
| Section | File           | Description                                                        | Example                  | 
+=========+================+====================================================================+==========================+
| views   | cache.adapter  | Name of the adapter used to cache the output of the view component | cache.adapter = "demo"   | 
+---------+----------------+--------------------------------------------------------------------+--------------------------+
| views   | cache.host     | If Memcached is used as adapter, the memcached port                | cache.host = "localhost" | 
+---------+----------------+--------------------------------------------------------------------+--------------------------+
| views   | cache.port     | If Memcached is used as adapter, the memcached port                | cache.port = 11211       | 
+---------+----------------+--------------------------------------------------------------------+--------------------------+
| views   | cache.port     | If Memcached is used as adapter, the memcached port                | cache.port = 11211       | 
+---------+----------------+--------------------------------------------------------------------+--------------------------+
| views   | cache.lifetime | Default time to live of the cache in seconds                       | cache.lifetime = 3600    | 
+---------+----------------+--------------------------------------------------------------------+--------------------------+


Related Guides
--------------

* :doc:`Reading Configurations <config>` 

