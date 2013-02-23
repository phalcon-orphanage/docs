Interface **Phalcon\\Session\\AdapterInterface**
================================================

Phalcon\\Session\\AdapterInterface initializer


Methods
---------

abstract public  **__construct** (*array* $options)

Phalcon\\Session construtor



abstract public  **start** ()

Starts session, optionally using an adapter



abstract public  **setOptions** (*array* $options)

Sets session options



abstract public *array*  **getOptions** ()

Get internal options



abstract public  **get** (*string* $index)

Gets a session variable from an application context



abstract public  **set** (*string* $index, *string* $value)

Sets a session variable in an application context



abstract public  **has** (*string* $index)

Check whether a session variable is set in an application context



abstract public  **remove** (*string* $index)

Removes a session variable from an application context



abstract public *string*  **getId** ()

Returns active session id



abstract public *boolean*  **isStarted** ()

Check whether the session has been started



abstract public *boolean*  **destroy** ()

Destroys the active session



