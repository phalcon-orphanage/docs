Class **Phalcon\\Flash\\Session**
=================================

*extends* abstract class :doc:`Phalcon\\Flash <Phalcon_Flash>`

*implements* :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

Temporarily stores the messages in session, then messages can be printed in the next request


Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



protected *array*  **_getSessionMessages** (*unknown* $remove)

Returns the messages stored in session



protected  **_setSessionMessages** (*unknown* $messages)

Stores the messages in session



public  **message** (*unknown* $type, *unknown* $message)

Adds a message to the session flasher



public *boolean*  **has** ([*unknown* $type])

Checks whether there are messages



public *array*  **getMessages** ([*unknown* $type], [*unknown* $remove])

Returns the messages in the session flasher



public  **output** ([*unknown* $remove])

Prints the messages in the session flasher



public  **clear** ()

...


public  **__construct** ([*unknown* $cssClasses]) inherited from Phalcon\\Flash

Phalcon\\Flash constructor



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setImplicitFlush** (*unknown* $implicitFlush) inherited from Phalcon\\Flash

Set whether the output must be implictly flushed to the output or returned as string



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setAutomaticHtml** (*unknown* $automaticHtml) inherited from Phalcon\\Flash

Set if the output must be implictily formatted with HTML



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setCssClasses** (*unknown* $cssClasses) inherited from Phalcon\\Flash

Set an array with CSS classes to format the messages



public *string*  **error** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML error message 

.. code-block:: php

    <?php

     $flash->error('This is an error');




public *string*  **notice** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML notice/information message 

.. code-block:: php

    <?php

     $flash->notice('This is an information');




public *string*  **success** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML success message 

.. code-block:: php

    <?php

     $flash->success('The process was finished successfully');




public *string*  **warning** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML warning message 

.. code-block:: php

    <?php

     $flash->warning('Hey, this is important');




public  **outputMessage** (*unknown* $type, *unknown* $message) inherited from Phalcon\\Flash

Outputs a message formatting it with HTML 

.. code-block:: php

    <?php

     $flash->outputMessage('error', message);




