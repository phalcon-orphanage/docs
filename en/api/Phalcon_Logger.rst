Class **Phalcon\\Logger**
=========================

Phalcon\\Logger is a component whose purpose is to create logs using different backends via adapters, generating options, formats and filters also implementing transactions. 

.. code-block:: php

    <?php

    $logger = new Phalcon\Logger\Adapter\File("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon\Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();



Constants
---------

integer **SPECIAL**

integer **CUSTOM**

integer **DEBUG**

integer **INFO**

integer **NOTICE**

integer **WARNING**

integer **ERROR**

integer **ALERT**

integer **CRITICAL**

integer **EMERGENCE**

Methods
---------

public **debug** (*string* $message)

Sends/Writes a debug message to the log



public **error** (*string* $message)

Sends/Writes an error message to the log



public **info** (*string* $message)

Sends/Writes an info message to the log



public **notice** (*string* $message)

Sends/Writes a notice message to the log



public **warning** (*string* $message)

Sends/Writes a warning message to the log



public **alert** (*string* $message)

Sends/Writes an alert message to the log



public **log** (*unknown* $message, *unknown* $type)

