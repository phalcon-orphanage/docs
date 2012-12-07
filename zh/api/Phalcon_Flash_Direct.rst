Class **Phalcon\\Flash\\Direct**
================================

*extends* :doc:`Phalcon\\Flash <Phalcon_Flash>`

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`

>>>>>>> 0.7.0
This is a variant of the Phalcon\\Flash that inmediately outputs any message passed to it


Methods
---------

public *string*  **message** (*string* $type, *string* $message)

Outputs a message



public  **__construct** (*array* $cssClasses) inherited from Phalcon\\Flash

Phalcon\\Flash constructor



public  **setImplicitFlush** (*unknown* $implicitFlush) inherited from Phalcon\\Flash

Set the if the output must be implictly flushed to the output or returned as string



public  **setAutomaticHtml** (*boolean* $automaticHtml) inherited from Phalcon\\Flash

Set the if the output must be implictly formatted with HTML



public  **setCssClasses** (*array* $cssClasses) inherited from Phalcon\\Flash

Set an array with CSS classes to format the messages



public *string*  **error** (*string* $message) inherited from Phalcon\\Flash

Shows a HTML error message 

.. code-block:: php

    <?php

     $flash->error('This is an error');




public *string*  **notice** (*string* $message) inherited from Phalcon\\Flash

Shows a HTML notice/information message 

.. code-block:: php

    <?php

     $flash->notice('This is an information');




public *string*  **success** (*string* $message) inherited from Phalcon\\Flash

Shows a HTML success message 

.. code-block:: php

    <?php

     $flash->success('The process was finished successfully');




public *string*  **warning** (*string* $message) inherited from Phalcon\\Flash

Shows a HTML warning message 

.. code-block:: php

    <?php

     $flash->warning('Hey, this is important');




public  **outputMessage** (*string* $type, *string* $message) inherited from Phalcon\\Flash

Outputs a message formatting it with HTML



