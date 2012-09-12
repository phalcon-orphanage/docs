Class **Phalcon\\Session\\Adapter\\Files**
==========================================

*extends* :doc:`Phalcon\\Session <Phalcon_Session>`

Methods
---------

public **__construct** (*array* $options) inherited from Phalcon_Session

Phalcon\\Session construtor



public **start** () inherited from Phalcon_Session

Starts session, optionally using an adapter



public **setOptions** (*array* $options) inherited from Phalcon_Session

Sets session options



*array* public **getOptions** () inherited from Phalcon_Session

Get internal options



public **get** (*string* $index) inherited from Phalcon_Session

Gets a session variable from an application context



public **set** (*string* $index, *string* $value) inherited from Phalcon_Session

Sets a session variable in an application context



public **has** (*string* $index) inherited from Phalcon_Session

Check whether a session variable is set in an application context



public **remove** (*string* $index) inherited from Phalcon_Session

Removes a session variable from an application context



*string* public **getId** () inherited from Phalcon_Session

Returns active session id



*boolean* public **isStarted** () inherited from Phalcon_Session

Check whether the session has been started



*boolean* public **destroy** () inherited from Phalcon_Session

Destroys the active session



