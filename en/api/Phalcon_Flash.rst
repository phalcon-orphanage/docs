Class **Phalcon\\Flash**
========================

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS 

.. code-block:: php

    <?php

     $flash->success("The record was successfully deleted");
     $flash->error("Cannot open the file");



Methods
---------

public  **__construct** (*unknown* $cssClasses)

...


public  **setImplicitFlush** (*unknown* $implicitFlush)

...


public  **setAutomaticHtml** (*unknown* $automaticHtml)

...


public  **setCssClasses** (*unknown* $cssClasses)

...


public *string*  **error** (*string* $message)

Shows a HTML error message <code>$flash->error('This is an error');



public *string*  **notice** (*string* $message)

Shows a HTML notice/information message <code>$flash->notice('This is an information');



public *string*  **success** (*string* $message)

Shows a HTML success message <code>$flash->success('The process was finished successfully');



public *string*  **warning** (*string* $message)

Shows a HTML warning message <code>$flash->warning('Hey, this is important');



public  **outputMessage** (*unknown* $type, *unknown* $message)

...


