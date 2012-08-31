Class **Phalcon\\Flash**
========================

Phalcon\\Flash   Shows HTML notifications related to different circumstances. Classes can be stylized using CSS  

.. code-block:: php

    <?php

    
     $flash->success("The record was successfully deleted");
     $flash->error("Cannot open the file");
    





Methods
---------

**__construct** (*unknown* **$cssClasses**)

**setImplicitFlush** (*unknown* **$implicitFlush**)

**setAutomaticHtml** (*unknown* **$automaticHtml**)

**setCssClasses** (*unknown* **$cssClasses**)

*string* **error** (*string* **$message**)

*string* **notice** (*string* **$message**)

*string* **success** (*string* **$message**)

*string* **warning** (*string* **$message**)

**outputMessage** (*unknown* **$type**, *unknown* **$message**)

