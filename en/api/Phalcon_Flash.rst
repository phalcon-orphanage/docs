Class **Phalcon\\Flash**
========================

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS  

.. code-block:: php

    <?php

     $flash->success("The record was successfully deleted");
     $flash->error("Cannot open the file");



Methods
---------

public **__construct** (*unknown* $cssClasses)

public **setImplicitFlush** (*unknown* $implicitFlush)

public **setAutomaticHtml** (*unknown* $automaticHtml)

public **setCssClasses** (*unknown* $cssClasses)

*string* public **error** (*string* $message)

Shows a HTML error message <code>$flash->error('This is an error');



*string* public **notice** (*string* $message)

Shows a HTML notice/information message <code>$flash->notice('This is an information');



*string* public **success** (*string* $message)

Shows a HTML success message <code>$flash->success('The process was finished successfully');



*string* public **warning** (*string* $message)

Shows a HTML warning message <code>$flash->warning('Hey, this is important');



public **outputMessage** (*unknown* $type, *unknown* $message)

