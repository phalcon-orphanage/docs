Class **Phalcon\\Flash\\Session**
=================================

*extends* :doc:`Phalcon\\Flash <Phalcon_Flash>`

Methods
---------

public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



protected **_getSessionMessages** ()

...


protected **_setSessionMessages** ()

...


public **message** (*unknown* $type, *unknown* $message)

...


public **getMessages** (*unknown* $type, *unknown* $remove)

...


public **output** (*unknown* $remove)

...


public **__construct** (*unknown* $cssClasses) inherited from Phalcon_Flash

...


public **setImplicitFlush** (*unknown* $implicitFlush) inherited from Phalcon_Flash

...


public **setAutomaticHtml** (*unknown* $automaticHtml) inherited from Phalcon_Flash

...


public **setCssClasses** (*unknown* $cssClasses) inherited from Phalcon_Flash

...


*string* public **error** (*string* $message) inherited from Phalcon_Flash

Shows a HTML error message <code>$flash->error('This is an error');



*string* public **notice** (*string* $message) inherited from Phalcon_Flash

Shows a HTML notice/information message <code>$flash->notice('This is an information');



*string* public **success** (*string* $message) inherited from Phalcon_Flash

Shows a HTML success message <code>$flash->success('The process was finished successfully');



*string* public **warning** (*string* $message) inherited from Phalcon_Flash

Shows a HTML warning message <code>$flash->warning('Hey, this is important');



public **outputMessage** (*unknown* $type, *unknown* $message) inherited from Phalcon_Flash

...


