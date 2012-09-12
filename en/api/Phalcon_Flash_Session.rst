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



public  **__construct** (*unknown* $cssClasses) inherited from Phalcon\Flash

...


public  **setImplicitFlush** (*unknown* $implicitFlush) inherited from Phalcon\Flash

...


public  **setAutomaticHtml** (*unknown* $automaticHtml) inherited from Phalcon\Flash

...


public  **setCssClasses** (*unknown* $cssClasses) inherited from Phalcon\Flash

...


public *string*  **error** (*string* $message) inherited from Phalcon\Flash

Shows a HTML error message <code>$flash->error('This is an error');



public *string*  **notice** (*string* $message) inherited from Phalcon\Flash

Shows a HTML notice/information message <code>$flash->notice('This is an information');



public *string*  **success** (*string* $message) inherited from Phalcon\Flash

Shows a HTML success message <code>$flash->success('The process was finished successfully');



public *string*  **warning** (*string* $message) inherited from Phalcon\Flash

Shows a HTML warning message <code>$flash->warning('Hey, this is important');



public  **outputMessage** (*unknown* $type, *unknown* $message) inherited from Phalcon\Flash

...


