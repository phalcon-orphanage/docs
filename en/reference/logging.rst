

Logging
=======
is a component whose purpose is to provide logging servicesto applications using different backends via adapters, generating options, formats and filters also implementing transactions. You could use loggers to debug processes, trace or access information and more. 

Adapters
--------
This component makes use of backend adapters to encapsulate the details of each of them:

+---------+---------------------------+-----------------------------+
| Adapter | Description               | API                         | 
+=========+===========================+=============================+
| File    | Logs to a plain text file | Phalcon_Logger_Adapter_File | 
+---------+---------------------------+-----------------------------+



Creating a Log
--------------
The below example shows how to create a log and add messages to it:

.. code-block:: php

    <?php

    $logger = new Phalcon_Logger("File", "app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon_Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();

Now, It simply produces the following log:

.. code-block:: php

    [Tue, 17 Apr 12 22:09:02 -0500][DEBUG] This is a message
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is an error
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is another error



Transactions
------------
Because writing to the filesystem could be expensive in terms of performance,you can take advantage of logging transactions to temporariry store messages in memory and later write them to disk in a single atomic operation. 

.. code-block:: php

    <?php

    //Create the logger
    $logger = new Phalcon_Logger("File", "app/logs/test.log");
    
    //Start a transaction
    $logger->begin();
    
    //Add messages
    $logger->alert("This is an alert");
    $logger->error("This is another error");
    
    //Commit messages to file
    $logger->commit();
    
    $logger->close();



Message Formatting
------------------
By default the logger uses the following format: [%date%][%type%] %message%.Phalcon_Logger allows you to define your own message format by using the method setFormat(). Formats can contain variables that are replaced by their respective values according to the following table:

+-----------+------------------------------------------+
| Variable  | Description                              | 
+===========+==========================================+
| %message% | The message itself expected to be logged | 
+-----------+------------------------------------------+
| %date%    | Date the message was added               | 
+-----------+------------------------------------------+
| %type%    | Uppercase string with message type       | 
+-----------+------------------------------------------+

This example shows how to define another format:

.. code-block:: php

    <?php

    //Changing the logger format
    $logger->setFormat("%date% - %message%");

