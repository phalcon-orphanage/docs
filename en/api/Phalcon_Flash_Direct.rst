Class **Phalcon\\Flash\\Direct**
================================

*extends* :doc:`Phalcon\\Flash <Phalcon_Flash>`

This is a variant of the Phalcon\\Flash that inmediately outputs any message passed to it


Methods
---------

public *string*  **message** (*string* $type, *string* $message)

Outputs a message



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


