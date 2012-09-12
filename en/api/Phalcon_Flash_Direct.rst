Class **Phalcon\\Flash\\Direct**
================================

*extends* :doc:`Phalcon\\Flash <Phalcon_Flash>`

This is a variant of the Phalcon\\Flash that inmediately flush to the output any message passed to it


Methods
---------

*string* public **message** (*string* $type, *string* $message)

Outputs a message



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


