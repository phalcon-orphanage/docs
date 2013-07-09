Class **Phalcon\\Session\\Adapter**
===================================

Base class for Phalcon\\Session adapters


Methods
---------

public  **__construct** ([*array* $options])

Phalcon\\Session\\Adapter constructor



public *boolean*  **start** ()

Starts the session (if headers are already sent the session will not be started)



public  **setOptions** (*array* $options)

Sets session's options 

.. code-block:: php

    <?php

    $session->setOptions(array(
    	'uniqueId' => 'my-private-app'
    ));




public *array*  **getOptions** ()

Get internal options



public *mixed*  **get** (*string* $index, [*mixed* $defaultValue])

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value)

Sets a session variable in an application context 

.. code-block:: php

    <?php

    $session->set('auth', 'yes');




public *boolean*  **has** (*string* $index)

Check whether a session variable is set in an application context 

.. code-block:: php

    <?php

    var_dump($session->has('auth'));




public  **remove** (*string* $index)

Removes a session variable from an application context 

.. code-block:: php

    <?php

    $session->remove('auth');




public *string*  **getId** ()

Returns active session id 

.. code-block:: php

    <?php

    echo $session->getId();




public *boolean*  **isStarted** ()

Check whether the session has been started 

.. code-block:: php

    <?php

    var_dump($session->isStarted());




public *boolean*  **destroy** ()

Destroys the active session 

.. code-block:: php

    <?php

    var_dump($session->destroy());




