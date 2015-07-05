Class **Phalcon\\Flash\\Direct**
================================

*extends* abstract class :doc:`Phalcon\\Flash <Phalcon_Flash>`

*implements* :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`

This is a variant of the Phalcon\\Flash that inmediately outputs any message passed to it


Methods
-------

public  **message** (*unknown* $type, *unknown* $message)

Outputs a message



public  **output** ([*unknown* $remove])

Prints the messages accumulated in the flasher



public  **__construct** ([*unknown* $cssClasses]) inherited from Phalcon\\Flash

Phalcon\\Flash constructor



public  **setImplicitFlush** (*unknown* $implicitFlush) inherited from Phalcon\\Flash

Set whether the output must be implicitly flushed to the output or returned as string



public  **setAutomaticHtml** (*unknown* $automaticHtml) inherited from Phalcon\\Flash

Set if the output must be implicitly formatted with HTML



public  **setCssClasses** (*unknown* $cssClasses) inherited from Phalcon\\Flash

Set an array with CSS classes to format the messages



public  **error** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML error message 

.. code-block:: php

    <?php

     $flash->error('This is an error');




public  **notice** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML notice/information message 

.. code-block:: php

    <?php

     $flash->notice('This is an information');




public  **success** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML success message 

.. code-block:: php

    <?php

     $flash->success('The process was finished successfully');




public  **warning** (*unknown* $message) inherited from Phalcon\\Flash

Shows a HTML warning message 

.. code-block:: php

    <?php

     $flash->warning('Hey, this is important');




public  **outputMessage** (*unknown* $type, *unknown* $message) inherited from Phalcon\\Flash

Outputs a message formatting it with HTML 

.. code-block:: php

    <?php

     $flash->outputMessage('error', message);




public  **clear** () inherited from Phalcon\\Flash

Clears accumulated messages when implicit flush is disabled



