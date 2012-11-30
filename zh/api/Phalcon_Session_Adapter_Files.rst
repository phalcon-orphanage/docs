Class **Phalcon\\Session\\Adapter\\Files**
==========================================

*extends* :doc:`Phalcon\\Session\\Adapter <Phalcon_Session_Adapter>`

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`

Methods
---------

public  **__construct** (*array* $options) inherited from Phalcon\\Session\\Adapter

Phalcon\\Session\\Adapter construtor



public  **start** () inherited from Phalcon\\Session\\Adapter

Starts session, optionally using an adapter



public  **setOptions** (*array* $options) inherited from Phalcon\\Session\\Adapter

Sets session options



public *array*  **getOptions** () inherited from Phalcon\\Session\\Adapter

Get internal options



public  **get** (*string* $index) inherited from Phalcon\\Session\\Adapter

Gets a session variable from an application context



public  **set** (*string* $index, *string* $value) inherited from Phalcon\\Session\\Adapter

Sets a session variable in an application context



public  **has** (*string* $index) inherited from Phalcon\\Session\\Adapter

Check whether a session variable is set in an application context



public  **remove** (*string* $index) inherited from Phalcon\\Session\\Adapter

Removes a session variable from an application context



public *string*  **getId** () inherited from Phalcon\\Session\\Adapter

Returns active session id



public *boolean*  **isStarted** () inherited from Phalcon\\Session\\Adapter

Check whether the session has been started



public *boolean*  **destroy** () inherited from Phalcon\\Session\\Adapter

Destroys the active session



