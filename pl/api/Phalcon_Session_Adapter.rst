Abstract class **Phalcon\\Session\\Adapter**
============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/session/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Base class for Phalcon\\Session adapters


Constants
---------

*integer* **SESSION_ACTIVE**

*integer* **SESSION_NONE**

*integer* **SESSION_DISABLED**

Methods
-------

public  **__construct** ([*array* $options])

Phalcon\\Session\\Adapter constructor



public  **start** ()

Starts the session (if headers are already sent the session will not be started)



public  **setOptions** (*unknown* $options)

Sets session's options 

.. code-block:: php

    <?php

    $session->setOptions(array(
    	'uniqueId' => 'my-private-app'
    ));




public  **getOptions** ()

Get internal options



public  **setName** (*unknown* $name)

Set session name



public  **getName** ()

Get session name



public  **regenerateId** ([*unknown* $deleteOldSession])





public *mixed*  **get** (*string* $index, [*mixed* $defaultValue], [*boolean* $remove])

Gets a session variable from an application context 

.. code-block:: php

    <?php

    $session->get('auth', 'yes');




public  **set** (*string* $index, *string* $value)

Sets a session variable in an application context 

.. code-block:: php

    <?php

    $session->set('auth', 'yes');




public  **has** (*unknown* $index)

Check whether a session variable is set in an application context 

.. code-block:: php

    <?php

    var_dump($session->has('auth'));




public  **remove** (*unknown* $index)

Removes a session variable from an application context 

.. code-block:: php

    <?php

    $session->remove('auth');




public  **getId** ()

Returns active session id 

.. code-block:: php

    <?php

    echo $session->getId();




public  **setId** (*unknown* $id)

Set the current session id 

.. code-block:: php

    <?php

    $session->setId($id);




public  **isStarted** ()

Check whether the session has been started 

.. code-block:: php

    <?php

    var_dump($session->isStarted());




public  **destroy** ([*unknown* $removeData])

Destroys the active session 

.. code-block:: php

    <?php

    var_dump($session->destroy());
    var_dump($session->destroy(true));




public  **status** ()

Returns the status of the current session. For PHP 5.3 this function will always return SESSION_NONE 

.. code-block:: php

    <?php

    var_dump($session->status());
    
      // PHP 5.4 and above will give meaningful messages, 5.3 gets SESSION_NONE always
      if ($session->status() !== $session::SESSION_ACTIVE) {
          $session->start();
      }




public *mixed*  **__get** (*string* $index)

Alias: Gets a session variable from an application context



public  **__set** (*string* $index, *string* $value)

Alias: Sets a session variable in an application context



public  **__isset** (*unknown* $index)

Alias: Check whether a session variable is set in an application context



public  **__unset** (*unknown* $index)

Alias: Removes a session variable from an application context



public  **__destruct** ()

...


