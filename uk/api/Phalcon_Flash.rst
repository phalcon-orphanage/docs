Abstract class **Phalcon\\Flash**
=================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/flash.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS  

.. code-block:: php

    <?php

     $flash->success("The record was successfully deleted");
     $flash->error("Cannot open the file");



Methods
-------

public  **__construct** ([*unknown* $cssClasses])

Phalcon\\Flash constructor



public  **setImplicitFlush** (*unknown* $implicitFlush)

Set whether the output must be implicitly flushed to the output or returned as string



public  **setAutomaticHtml** (*unknown* $automaticHtml)

Set if the output must be implicitly formatted with HTML



public  **setCssClasses** (*array* $cssClasses)

Set an array with CSS classes to format the messages



public  **error** (*unknown* $message)

Shows a HTML error message 

.. code-block:: php

    <?php

     $flash->error('This is an error');




public  **notice** (*unknown* $message)

Shows a HTML notice/information message 

.. code-block:: php

    <?php

     $flash->notice('This is an information');




public  **success** (*unknown* $message)

Shows a HTML success message 

.. code-block:: php

    <?php

     $flash->success('The process was finished successfully');




public  **warning** (*unknown* $message)

Shows a HTML warning message 

.. code-block:: php

    <?php

     $flash->warning('Hey, this is important');




public  **outputMessage** (*unknown* $type, *string|array* $message)

Outputs a message formatting it with HTML 

.. code-block:: php

    <?php

     $flash->outputMessage('error', message);




public  **clear** ()

Clears accumulated messages when implicit flush is disabled



