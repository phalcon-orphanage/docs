Class **Phalcon\\Session\\Adapter\\Files**
==========================================

*extends* abstract class :doc:`Phalcon\\Session\\Adapter <Phalcon_Session_Adapter>`

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`

Methods
-------

public  **__construct** ([*unknown* $options]) inherited from Phalcon\\Session\\Adapter

Phalcon\\Session\\Adapter constructor



public *boolean*  **start** () inherited from Phalcon\\Session\\Adapter

Starts the session (if headers are already sent the session will not be started)



public  **setOptions** (*unknown* $options) inherited from Phalcon\\Session\\Adapter

Sets session's options 

.. code-block:: php

    <?php

    session->setOptions(array(
    	'uniqueId' => 'my-private-app'
    ));




public *array*  **getOptions** () inherited from Phalcon\\Session\\Adapter

Get internal options



public *mixed*  **get** (*unknown* $index, [*unknown* $defaultValue], [*unknown* $remove]) inherited from Phalcon\\Session\\Adapter

Gets a session variable from an application context



public  **set** (*unknown* $index, *unknown* $value) inherited from Phalcon\\Session\\Adapter

Sets a session variable in an application context 

.. code-block:: php

    <?php

    session->set('auth', 'yes');




public  **has** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Check whether a session variable is set in an application context 

.. code-block:: php

    <?php

    var_dump($session->has('auth'));




public  **remove** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Removes a session variable from an application context 

.. code-block:: php

    <?php

    $session->remove('auth');




public  **getId** () inherited from Phalcon\\Session\\Adapter

Returns active session id 

.. code-block:: php

    <?php

    echo $session->getId();




public  **setId** (*unknown* $id) inherited from Phalcon\\Session\\Adapter

Set the current session id 

.. code-block:: php

    <?php

    $session->setId($id);




public  **isStarted** () inherited from Phalcon\\Session\\Adapter

Check whether the session has been started 

.. code-block:: php

    <?php

    var_dump($session->isStarted());




public  **destroy** () inherited from Phalcon\\Session\\Adapter

Destroys the active session 

.. code-block:: php

    <?php

    var_dump(session->destroy());




public *mixed*  **__get** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Alias: Gets a session variable from an application context



public  **__set** (*unknown* $index, *unknown* $value) inherited from Phalcon\\Session\\Adapter

Alias: Sets a session variable in an application context



public  **__isset** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Alias: Check whether a session variable is set in an application context



public  **__unset** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Alias: Removes a session variable from an application context



