Class **Phalcon\\Flash\\Session**
=================================

*extends* :doc:`Phalcon\\Flash <Phalcon_Flash>`

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

>>>>>>> 0.7.0
Temporarily stores the messages in session, then messages can be printed in the next request


Methods
---------

<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

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



