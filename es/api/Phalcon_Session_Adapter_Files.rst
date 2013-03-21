Class **Phalcon\\Session\\Adapter\\Files**
==========================================

*extends* :doc:`Phalcon\\Session\\Adapter <Phalcon_Session_Adapter>`

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`

Methods
---------

public  **__construct** ([*array* $options]) inherited from Phalcon\\Session\\Adapter

Phalcon\\Session\\Adapter constructor



public *boolean*  **start** () inherited from Phalcon\\Session\\Adapter

Starts the session (if headers are already sent the session will not started)



public  **setOptions** (*array* $options) inherited from Phalcon\\Session\\Adapter

Sets session's options 

.. code-block:: php

    <?php

    $session->setOptions(array(
    	'uniqueId' => 'my-private-app'
    ));




public *array*  **getOptions** () inherited from Phalcon\\Session\\Adapter

Get internal options



public *mixed*  **get** (*string* $index, [*mixed* $defaultValue]) inherited from Phalcon\\Session\\Adapter

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value) inherited from Phalcon\\Session\\Adapter

Sets a session variable in an application context 

.. code-block:: php

    <?php

    $session->set('auth', 'yes');




public  **has** (*string* $index) inherited from Phalcon\\Session\\Adapter

Check whether a session variable is set in an application context 

.. code-block:: php

    <?php

    var_dump($session->has('auth'));




public  **remove** (*string* $index) inherited from Phalcon\\Session\\Adapter

Removes a session variable from an application context 

.. code-block:: php

    <?php

    $session->remove('auth');




public *string*  **getId** () inherited from Phalcon\\Session\\Adapter

Returns active session id 

.. code-block:: php

    <?php

    echo $session->getId();




public *boolean*  **isStarted** () inherited from Phalcon\\Session\\Adapter

Check whether the session has been started 

.. code-block:: php

    <?php

    var_dump($session->isStarted());




public *boolean*  **destroy** () inherited from Phalcon\\Session\\Adapter

Destroys the active session 

.. code-block:: php

    <?php

    var_dump($session->destroy());




