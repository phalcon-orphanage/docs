Class **Phalcon\\Flash\\Direct**
================================

*extends* abstract class :doc:`Phalcon\\Flash <Phalcon_Flash>`

*implements* :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`

This is a variant of the Phalcon\\Flash that inmediately outputs any message passed to it


Methods
-------

public *string*  **message** (*unknown* $type, *unknown* $message)

Outputs a message



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




