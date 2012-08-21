Reading Configuration
=====================
:doc:`Phalcon_Config <../api/Phalcon_Config>` is a component used to read configuration files of various formats (using adapters) into PHP objects for use in an application. 

File Adapters
-------------
The adapters available are:

+-----------+---------------------------------------------------------------------------------------------------+
| File Type | Description                                                                                       | 
+===========+===================================================================================================+
| Ini       | Uses INI files to store settings. Internally the adapter uses the PHP function parse_ini_file.    | 
+-----------+---------------------------------------------------------------------------------------------------+
| Array     | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.     | 
+-----------+---------------------------------------------------------------------------------------------------+

Native Arrays
-------------
The next example shows how to convert native arrays into Phalcon_Config objects. This option offers the best performance since no files are read during this request. 

.. code-block:: php

    <?php
    
    $settings = array(
    	"database" => array(
     		"adapter"  => "Mysql",
     		"host"     => "localhost",
    		"username" => "scott",
    		"password" => "cheetah",
    		"name"     => "test_db",
    	),
     	"phalcon" => array(
     		"controllersDir" => "../app/controllers/",
     		"modelsDir"      => "../app/models/",
    		"viewsDir"       => "../app/views/",
    	),
    	"mysetting" => "the-value"
    );
    
    $config = new Phalcon_Config($settings);
    
    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

If you want to better organize your project you can save the array in another file and then read it.

.. code-block:: php

    <?php
    
    require "config/config.php";
    $config = new Phalcon_Config($settings);

Reading INI Files
-----------------
Ini files are a common way to store settings. Phalcon_Config uses the optimized PHP function parse_ini_file to read these files. Files sections are parsed into sub-settings for easy access. 

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    name     = test_db
    
    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

.. code-block:: php

    <?php
    
    $config = new Phalcon_Config_Adapter_Ini("path/config.ini");
    
    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";

Related Guides
--------------

* :doc:`Settings supported by the Framework <settings>`
