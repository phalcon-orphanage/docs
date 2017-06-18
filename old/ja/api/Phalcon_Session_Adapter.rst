Abstract class **Phalcon\\Session\\Adapter**
============================================

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`

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



public  **setOptions** (*array* $options)

Sets session's options

.. code-block:: php

    <?php

    $session->setOptions(
        [
            "uniqueId" => "my-private-app",
        ]
    );




public  **getOptions** ()

Get internal options



public  **setName** (*mixed* $name)

Set session name



public  **getName** ()

Get session name



public  **regenerateId** ([*mixed* $deleteOldSession])





public  **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove])

Gets a session variable from an application context

.. code-block:: php

    <?php

    $session->get("auth", "yes");




public  **set** (*mixed* $index, *mixed* $value)

Sets a session variable in an application context

.. code-block:: php

    <?php

    $session->set("auth", "yes");




public  **has** (*mixed* $index)

Check whether a session variable is set in an application context

.. code-block:: php

    <?php

    var_dump(
        $session->has("auth")
    );




public  **remove** (*mixed* $index)

Removes a session variable from an application context

.. code-block:: php

    <?php

    $session->remove("auth");




public  **getId** ()

Returns active session id

.. code-block:: php

    <?php

    echo $session->getId();




public  **setId** (*mixed* $id)

Set the current session id

.. code-block:: php

    <?php

    $session->setId($id);




public  **isStarted** ()

Check whether the session has been started

.. code-block:: php

    <?php

    var_dump(
        $session->isStarted()
    );




public  **destroy** ([*mixed* $removeData])

Destroys the active session

.. code-block:: php

    <?php

    var_dump(
        $session->destroy()
    );

    var_dump(
        $session->destroy(true)
    );




public  **status** ()

Returns the status of the current session.

.. code-block:: php

    <?php

    var_dump(
        $session->status()
    );

    if ($session->status() !== $session::SESSION_ACTIVE) {
        $session->start();
    }




public  **__get** (*mixed* $index)

Alias: Gets a session variable from an application context



public  **__set** (*mixed* $index, *mixed* $value)

Alias: Sets a session variable in an application context



public  **__isset** (*mixed* $index)

Alias: Check whether a session variable is set in an application context



public  **__unset** (*mixed* $index)

Alias: Removes a session variable from an application context



public  **__destruct** ()

...


