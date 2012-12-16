Class **Phalcon\\Session\\Adapter**
===================================

Base class for Phalcon\\Session adapters


Methods
---------

public  **__construct** (*array* $options)

Phalcon\\Session\\Adapter constructor



public *boolean*  **start** ()

Starts the session (if headers are already sent the session will not started)



public  **setOptions** (*array* $options)

Sets session's options 

.. code-block:: php

    <?php

    $session->setOptions(array(
    	'uniqueId' => 'my-private-app'
    ));




public *array*  **getOptions** ()

Get internal options



public *mixed*  **get** (*string* $index, *unknown* $defaultValue)

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value)

Sets a session variable in an application context <comment> $session->set('auth', 'yes'); </comment>



public  **has** (*string* $index)

Check whether a session variable is set in an application context <comment> var_dump($session->has('auth')); </comment>



public  **remove** (*string* $index)

Removes a session variable from an application context <comment> $session->remove('auth'); </comment>



public *string*  **getId** ()

Returns active session id <comment> echo $session->getId(); </comment>



public *boolean*  **isStarted** ()

Check whether the session has been started <comment> var_dump($session->isStarted()); </comment>



public *boolean*  **destroy** ()

Destroys the active session <comment> var_dump($session->destroy()); </comment>



