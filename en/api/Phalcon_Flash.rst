Class **Phalcon_Flash**
=======================

Shows HTML notifications related to different circumstances. Classes can be styled using CSS.

.. code-block:: php

    <?php
    
    Phalcon_Flash::success("The record was successfully deleted");
    Phalcon_Flash::error("Cannot open the file");
    Phalcon_Flash::error("Cannot open the file", "alert alert-error");

Methods
---------

**string** **error** (string $message, string $classes)

Shows a HTML error message  

.. code-block:: php

    <?php 

    Phalcon_Flash::error('This is an error'); 

**string** **notice** (string $message, string $classes)

Shows a HTML notice/information message  

.. code-block:: php

    <?php 

    Phalcon_Flash::notice('This is an information'); 

**string** **success** (string $message, string $classes)

Shows a HTML success message  

.. code-block:: php

    <?php 

    Phalcon_Flash::success('The process was finished successfully'); 

**string** **warning** (string $message, string $classes)

Shows a HTML warning message  

.. code-block:: php

    <?php 

    Phalcon_Flash::warning('Hey, this is important', 'alert alert-warning'); 

