Class **Phalcon_Session**
=========================

Session client-server persistent state data management. This component allows you to separate your session data between application or modules. With this, it's possible to use the same index to refer a variable but they can be in different applications.   

.. code-block:: php

    <?php


    use Phalcon_Session as Session;

    Session::start(array('uniqueId' => 'my-private-app'));

    Session::set('var', 'some-value');

    echo Session::get('var');

Methods
---------

**start** (array $options)

Starts session, optionally using an adapter

**setOptions** (array $options)

Sets session options

**get** (string $index)

Gets a session variable from an application context

**set** (string $index, string $value)

Sets a session variable in an application context

**has** (string $index)

Check whether a session variable is set in an application context

**remove** (string $index)

Removes a session variable from an application context

**string** **getId** ()

Returns active session id

