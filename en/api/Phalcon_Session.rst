Class **Phalcon\\Session**
==========================

Session client-server persistent state data management. This component allows you to separate your session data between application or modules. With this, it's possible to use the same index to refer a variable but they can be in different applications. 

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

public **__construct** (*unknown* $options)

public **start** ()

Starts session, optionally using an adapter



public **setOptions** (*array* $options)

Sets session options



public **getOptions** ()

public **get** (*string* $index)

Gets a session variable from an application context



public **set** (*string* $index, *string* $value)

Sets a session variable in an application context



public **has** (*string* $index)

Check whether a session variable is set in an application context



public **remove** (*string* $index)

Removes a session variable from an application context



*string* public **getId** ()

Returns active session id



public **isStarted** ()

public **destroy** ()

