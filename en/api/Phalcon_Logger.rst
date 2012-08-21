Class **Phalcon_Logger**
========================

Phalcon_Logger is a component whose purpose is to create logs using different backends via adapters, generating options, formats and filters and also implementing transactions.  

.. code-block:: php

    <?php
    
    $logger = new Phalcon_Logger("File", "app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon_Logger::ERROR);
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

**__construct** (string $adapter, string $name, array $options)

Phalcon_Logger constructor

**log** (string $message, int $type)

Sends/Writes a message to the log

**debug** (string $message)

Sends/Writes a debug message to the log

**error** (string $message)

Sends/Writes an error message to the log

**info** (string $message)

Sends/Writes an info message to the log

**notice** (string $message)

Sends/Writes a notice message to the log

**warning** (string $message)

Sends/Writes a warning message to the log

**alert** (string $message)

Sends/Writes an alert message to the log

**mixed** **__call** (string $method, array $arguments)

Pass any call to the internal adapter object

