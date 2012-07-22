Logging
=======
:doc:`Phalcon_Logger <../api/Phalcon_Logger>` is a component whose purpose is to provide logging services for applications. It offers logging to different backends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the :doc:`Phalcon_Logger <../api/Phalcon_Logger>` for every logging need your application has, from debugging processes to tracing application flow. 

Adapters
--------
This component makes use of backend adapters to store data. The use of adapters allows for a common interface for logging while switching backends if necessary. The backends supported are:

+---------+---------------------------+-------------------------------------------------------------------------+
| Adapter | Description               | API                                                                     | 
+=========+===========================+=========================================================================+
| File    | Logs to a plain text file | :doc:`Phalcon_Logger_Adapter_File <../api/Phalcon_Logger_Adapter_File>` | 
+---------+---------------------------+-------------------------------------------------------------------------+

Creating a Log
--------------
The example below shows how to create a log and add messages to it:

.. code-block:: php

    <?php

    $logger = new Phalcon_Logger("File", "app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon_Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();

The log generated is below:

.. code-block:: php

    [Tue, 17 Apr 12 22:09:02 -0500][DEBUG] This is a message
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is an error
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is another error

Transactions
------------
Logging data to an adapter i.e. File (file system) is always an expensive operation in terms of performance. To combat that, you can take advantage of logging transactions. Transactions store log data temporarily in memory and later on write the data to the relevant adapter (File in this case) in a single atomic operation. 

.. code-block:: php

    <?php

    // Create the logger
    $logger = new Phalcon_Logger("File", "app/logs/test.log");
    
    // Start a transaction
    $logger->begin();
    
    // Add messages
    $logger->alert("This is an alert");
    $logger->error("This is another error");
    
    // Commit messages to file
    $logger->commit();
    
    $logger->close();


Message Formatting
------------------
The default logging format is:

[%date%][%type%] %message%

:doc:`Phalcon_Logger <../api/Phalcon_Logger>` offers the setFormat() method, which allows you to change the format of the logged messages by defining your own. The log format variables allowed are:

+-----------+------------------------------------------+
| Variable  | Description                              | 
+===========+==========================================+
| %message% | The message itself expected to be logged | 
+-----------+------------------------------------------+
| %date%    | Date the message was added               | 
+-----------+------------------------------------------+
| %type%    | Uppercase string with message type       | 
+-----------+------------------------------------------+

The example below shows how to change the log format:

.. code-block:: php

    <?php

    //Changing the logger format
    $logger->setFormat("%date% - %message%");

.. _Phalcon_Logger_Adapter_File: ../api/Phalcon_Logger_Adapter_File