Class **Phalcon\\Flash\\Session**
=================================

*extends* abstract class :doc:`Phalcon\\Flash <Phalcon_Flash>`

*implements* :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Temporarily stores the messages in session, then messages can be printed in the next request


Methods
-------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



protected *array*  **_getSessionMessages** ()

Returns the messages stored in session



protected  **_setSessionMessages** ()

Stores the messages in session



public  **message** (*string* $type, *string* $message)

Adds a message to the session flasher



public *array*  **getMessages** ([*string* $type], [*boolean* $remove])

Returns the messages in the session flasher



public  **output** ([*boolean* $remove])

Prints the messages in the session flasher



public  **has** (*unknown* $type)

bool \\Phalcon\\Flash\\Session::has(string $type)



public  **__construct** ([*array* $cssClasses]) inherited from Phalcon\\Flash

Phalcon\\Flash constructor



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setImplicitFlush** (*boolean* $implicitFlush) inherited from Phalcon\\Flash

Set whether the output must be implicitly flushed to the output or returned as string



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setAutomaticHtml** (*boolean* $automaticHtml) inherited from Phalcon\\Flash

Set if the output must be implictily formatted with HTML



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setCssClasses** (*array* $cssClasses) inherited from Phalcon\\Flash

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

.. code-block:: php

    <?php

     $flash->outputMessage('error', $message);




