Class **Phalcon\\Flash\\Session**
=================================

*extends* :doc:`Phalcon\\Flash <Phalcon_Flash>`

Temporarily stores the messages in session, then messages can be printed in the next request


Methods
---------

public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

Returns the internal dependency injector



protected *array*  **_getSessionMessages** ()

Returns the messages stored in session



protected  **_setSessionMessages** ()

Stores the messages in session



public  **message** (*string* $type, *string* $message)

Adds a message to the session flasher



public *array*  **getMessages** (*string* $type, *boolean* $remove)

Returns the messages in the session flasher



public  **output** (*boolean* $remove)

Prints the messages in the session flasher



public  **__construct** (*unknown* $cssClasses) inherited from Phalcon\\Flash

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



