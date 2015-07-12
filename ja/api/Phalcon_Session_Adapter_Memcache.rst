Class **Phalcon\\Session\\Adapter\\Memcache**
=============================================

*extends* abstract class :doc:`Phalcon\\Session\\Adapter <Phalcon_Session_Adapter>`

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`

This adapter store sessions in memcache  

.. code-block:: php

    <?php

     $session = new \Phalcon\Session\Adapter\Memcache(array(
        'uniqueId' => 'my-private-app'
        'host' => '127.0.0.1',
        'port' => 11211,
        'persistent' => TRUE,
        'lifetime' => 3600,
        'prefix' => 'my_'
     ));
    
     $session->start();
    
     $session->set('var', 'some-value');
    
     echo $session->get('var');



Constants
---------

*integer* **SESSION_ACTIVE**

*integer* **SESSION_NONE**

*integer* **SESSION_DISABLED**

Methods
-------

public  **getMemcache** ()

...


public  **getLifetime** ()

...


public  **__construct** ([*unknown* $options])

Phalcon\\Session\\Adapter\\Memcache constructor



public  **open** ()

...


public  **close** ()

...


public *mixed*  **read** (*string* $sessionId)





public  **write** (*string* $sessionId, *string* $data)





public *boolean*  **destroy** ([*string* $sessionId])





public  **gc** ()





public  **start** () inherited from Phalcon\\Session\\Adapter

Starts the session (if headers are already sent the session will not be started)



public  **setOptions** (*unknown* $options) inherited from Phalcon\\Session\\Adapter

Sets session's options 

.. code-block:: php

    <?php

    $session->setOptions(array(
    	'uniqueId' => 'my-private-app'
    ));




public  **getOptions** () inherited from Phalcon\\Session\\Adapter

Get internal options



public  **setName** (*unknown* $name) inherited from Phalcon\\Session\\Adapter

Set session name



public  **getName** () inherited from Phalcon\\Session\\Adapter

Get session name



public *mixed*  **get** (*string* $index, [*mixed* $defaultValue], [*boolean* $remove]) inherited from Phalcon\\Session\\Adapter

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value) inherited from Phalcon\\Session\\Adapter

Sets a session variable in an application context 

.. code-block:: php

    <?php

    $session->set('auth', 'yes');




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




public  **status** () inherited from Phalcon\\Session\\Adapter

Returns the status of the current session. For PHP 5.3 this function will always return SESSION_NONE 

.. code-block:: php

    <?php

    var_dump($session->status());
    
      // PHP 5.4 and above will give meaningful messages, 5.3 gets SESSION_NONE always
      if ($session->status() !== $session::SESSION_ACTIVE) {
          $session->start();
      }




public *mixed*  **__get** (*string* $index) inherited from Phalcon\\Session\\Adapter

Alias: Gets a session variable from an application context



public  **__set** (*string* $index, *string* $value) inherited from Phalcon\\Session\\Adapter

Alias: Sets a session variable in an application context



public  **__isset** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Alias: Check whether a session variable is set in an application context



public  **__unset** (*unknown* $index) inherited from Phalcon\\Session\\Adapter

Alias: Removes a session variable from an application context



