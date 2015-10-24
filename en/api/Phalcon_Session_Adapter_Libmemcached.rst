Class **Phalcon\\Session\\Adapter\\Libmemcached**
=================================================

*extends* abstract class :doc:`Phalcon\\Session\\Adapter <Phalcon_Session_Adapter>`

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/session/adapter/libmemcached.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This adapter store sessions in libmemcached  

.. code-block:: php

    <?php

     $session = new Phalcon\Session\Adapter\Libmemcached(array(
         'servers' => array(
             array('host' => 'localhost', 'port' => 11211, 'weight' => 1),
         ),
         'client' => array(
             Memcached::OPT_HASH => Memcached::HASH_MD5,
             Memcached::OPT_PREFIX_KEY => 'prefix.',
         ),
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

public  **getLibmemcached** ()

...


public  **getLifetime** ()

...


public  **__construct** (*unknown* $options)

Phalcon\\Session\\Adapter\\Libmemcached constructor



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



public  **regenerateId** ([*unknown* $deleteOldSession]) inherited from Phalcon\\Session\\Adapter





public *mixed*  **get** (*string* $index, [*mixed* $defaultValue], [*boolean* $remove]) inherited from Phalcon\\Session\\Adapter

Gets a session variable from an application context 

.. code-block:: php

    <?php

    $session->get('auth', 'yes');




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



public  **__destruct** () inherited from Phalcon\\Session\\Adapter

...


