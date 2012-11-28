Class **Phalcon\\Session**
==========================

Session client-server persistent state data management. This component allows you to separate your session data between application or modules. With this, it's possible to use the same index to refer a variable but it can be in different applications. 

.. code-block:: php

    <?php

     $session = new Phalcon\Session\Adapter\Files(array(
        'uniqueId' => 'my-private-app'
     ));
    
     $session->start();
    
     $session->set('var', 'some-value');
    
     echo $session->get('var');



Methods
---------

public  **__construct** (*array* $options)

Phalcon\\Session construtor



public  **start** ()

Starts session, optionally using an adapter



public  **setOptions** (*array* $options)

Sets session options



public *array*  **getOptions** ()

Get internal options



public  **get** (*string* $index)

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value)

Sets a session variable in an application context



public  **has** (*string* $index)

Check whether a session variable is set in an application context



public  **remove** (*string* $index)

Removes a session variable from an application context



public *string*  **getId** ()

Returns active session id



public *boolean*  **isStarted** ()

Check whether the session has been started



public *boolean*  **destroy** ()

Destroys the active session



