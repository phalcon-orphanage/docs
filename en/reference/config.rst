

Reading Configuration
=====================
The component allows to read configuration files indifferent formats into PHP objects facilitating the reading thereof. 

File Adapters
-------------
This component makes use of adapters to encapsulate the reading details of each format:

+-----------+---------------------------------------------------------------------------------------------------+
| File Type | Description                                                                                       | 
+===========+===================================================================================================+
| Ini       | Uses INI files to store settings. Internally it uses the PHP function parse_ini_file.             | 
+-----------+---------------------------------------------------------------------------------------------------+
| Array     | Uses PHP multidimensional arrays to store the configuration. In terms of performance is the best. | 
+-----------+---------------------------------------------------------------------------------------------------+



Native Arrays
-------------
The next example shows how to convert native arrays into Phalcon_Config objects. Because no files are readthe performance is better. 

.. code-block:: php

    <?php
    
    $settings = array(
    	"database" => array(
     		"adapter" => "Mysql",
     		"host" => "localhost",
    		"username" => "scott",
    		"password" => "cheetah",
    		"name" => "test_db"
    	),
     	"phalcon" => array(
     		"controllersDir" => "../app/controllers/",
     		"modelsDir" => "../app/models/",
    		"viewsDir" => "../app/views/"
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
Ini files are a common way to store settings. Phalcon_Config uses the optimizedPHP function parse_ini_file to read these files. Files sections are parsed into sub-settings that can be accessed then. 

.. code-block:: php

    [database]
    adapter = Mysql
    host = localhost
    username = scott
    password = cheetah
    name = test_db
    
    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir = "../app/models/"
    viewsDir = "../app/views/"



.. code-block:: php

    <?php
    
    $config = new Phalcon_Config_Adapter_Ini("path/config.ini");
    
    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";



Related Guides
--------------


* Settings supported by the Framework

