Class **Phalcon\\Session\\Adapter\\Files**
==========================================

<<<<<<< HEAD
*extends* :doc:`Phalcon\\Session <Phalcon_Session>`

This adapter store sessions in plain files

=======
*extends* :doc:`Phalcon\\Session\\Adapter <Phalcon_Session_Adapter>`

*implements* :doc:`Phalcon\\Session\\AdapterInterface <Phalcon_Session_AdapterInterface>`
>>>>>>> 0.7.0

Methods
---------

<<<<<<< HEAD
public  **__construct** (*array* $options) inherited from Phalcon\\Session

Phalcon\\Session construtor



public  **start** () inherited from Phalcon\\Session
=======
public  **__construct** (*array* $options) inherited from Phalcon\\Session\\Adapter

Phalcon\\Session\\Adapter construtor



public  **start** () inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Starts session, optionally using an adapter



<<<<<<< HEAD
public  **setOptions** (*array* $options) inherited from Phalcon\\Session
=======
public  **setOptions** (*array* $options) inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Sets session options



<<<<<<< HEAD
public *array*  **getOptions** () inherited from Phalcon\\Session
=======
public *array*  **getOptions** () inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Get internal options



<<<<<<< HEAD
public  **get** (*string* $index) inherited from Phalcon\\Session
=======
public  **get** (*string* $index) inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Gets a session variable from an application context



<<<<<<< HEAD
public  **set** (*string* $index, *string* $value) inherited from Phalcon\\Session
=======
public  **set** (*string* $index, *string* $value) inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Sets a session variable in an application context



<<<<<<< HEAD
public  **has** (*string* $index) inherited from Phalcon\\Session
=======
public  **has** (*string* $index) inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Check whether a session variable is set in an application context



<<<<<<< HEAD
public  **remove** (*string* $index) inherited from Phalcon\\Session
=======
public  **remove** (*string* $index) inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Removes a session variable from an application context



<<<<<<< HEAD
public *string*  **getId** () inherited from Phalcon\\Session
=======
public *string*  **getId** () inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Returns active session id



<<<<<<< HEAD
public *boolean*  **isStarted** () inherited from Phalcon\\Session
=======
public *boolean*  **isStarted** () inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Check whether the session has been started



<<<<<<< HEAD
public *boolean*  **destroy** () inherited from Phalcon\\Session
=======
public *boolean*  **destroy** () inherited from Phalcon\\Session\\Adapter
>>>>>>> 0.7.0

Destroys the active session



