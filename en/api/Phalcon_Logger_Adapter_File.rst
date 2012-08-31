Class **Phalcon\\Logger\\Adapter\\File**
========================================

*extends* :doc:`Phalcon\\Logger <Phalcon_Logger>`

Phalcon\\Logger\\Adapter\\File   Adapter to store logs in plain text files  

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

**__construct** (*string* **$name**, *array* **$options**)

**setFormat** (*string* **$format**)

*format* **getFormat** ()

*string* **getTypeString** (*integer* **$type**)

*string* **_applyFormat** ()

**setDateFormat** (*string* **$date**)

*string* **getDateFormat** ()

**log** (*string* **$message**, *int* **$type**)

**begin** ()

**commit** ()

**rollback** ()

*boolean* **close** ()

**__wakeup** ()

**debug** (*unknown* **$message**)

**error** (*unknown* **$message**)

**info** (*unknown* **$message**)

**notice** (*unknown* **$message**)

**warning** (*unknown* **$message**)

**alert** (*unknown* **$message**)

