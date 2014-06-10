Abstract class **Phalcon\\Flash**
=================================

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS

.. code-block:: php

    <?php

     $flash->success("The record was successfully deleted");
     $flash->error("Cannot open the file");



Methods
-------

public  **__construct** ([*array* $cssClasses])

Phalcon\\Flash constructor



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setImplicitFlush** (*boolean* $implicitFlush)

Set whether the output must be implicitly flushed to the output or returned as string



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setAutomaticHtml** (*boolean* $automaticHtml)

Set if the output must be implictily formatted with HTML



public :doc:`Phalcon\\FlashInterface <Phalcon_FlashInterface>`  **setCssClasses** (*array* $cssClasses)

Set an array with CSS classes to format the messages



public *string*  **error** (*string* $message)

Shows a HTML error message

.. code-block:: php

    <?php

     $flash->error('This is an error');




public *string*  **notice** (*string* $message)

Shows a HTML notice/information message

.. code-block:: php

    <?php

     $flash->notice('This is an information');




public *string*  **success** (*string* $message)

Shows a HTML success message

.. code-block:: php

    <?php

     $flash->success('The process was finished successfully');




public *string*  **warning** (*string* $message)

Shows a HTML warning message

.. code-block:: php

    <?php

     $flash->warning('Hey, this is important');




public  **outputMessage** (*string* $type, *string* $message)

Outputs a message formatting it with HTML

.. code-block:: php

    <?php

     $flash->outputMessage('error', $message);




