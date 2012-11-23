Class **Phalcon\\Session\\Adapter\\Files**
==========================================

*extends* :doc:`Phalcon\\Session <Phalcon_Session>`

This adapter store sessions in plain files


Methods
---------

public  **__construct** (*array* $options) inherited from Phalcon\\Session

Phalcon\\Session construtor



public  **start** () inherited from Phalcon\\Session

Starts session, optionally using an adapter



public  **setOptions** (*array* $options) inherited from Phalcon\\Session

Sets session options



public *array*  **getOptions** () inherited from Phalcon\\Session

Get internal options



public  **get** (*string* $index) inherited from Phalcon\\Session

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value) inherited from Phalcon\\Session

Sets a session variable in an application context



public  **has** (*string* $index) inherited from Phalcon\\Session

Check whether a session variable is set in an application context



public  **remove** (*string* $index) inherited from Phalcon\\Session

Removes a session variable from an application context



public *string*  **getId** () inherited from Phalcon\\Session

Returns active session id



public *boolean*  **isStarted** () inherited from Phalcon\\Session

Check whether the session has been started



public *boolean*  **destroy** () inherited from Phalcon\\Session

Destroys the active session



