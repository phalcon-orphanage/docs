Class **Phalcon\\Logger\\Multiple**
===================================

Handles multiples logger handlers


Methods
-------

public  **getLoggers** ()

...


public  **getFormatter** ()

...


public  **push** (*unknown* $logger)

Pushes a logger to the logger tail



public  **setFormatter** (*unknown* $formatter)

Sets a global formatter



public  **log** (*unknown* $type, [*unknown* $message], [*unknown* $context])

Sends a message to each registered logger



public  **critical** (*unknown* $message, [*unknown* $context])

Sends/Writes an critical message to the log



public  **emergency** (*unknown* $message, [*unknown* $context])

Sends/Writes an emergency message to the log



public  **debug** (*unknown* $message, [*unknown* $context])

Sends/Writes a debug message to the log



public  **error** (*unknown* $message, [*unknown* $context])

Sends/Writes an error message to the log



public  **info** (*unknown* $message, [*unknown* $context])

Sends/Writes an info message to the log



public  **notice** (*unknown* $message, [*unknown* $context])

Sends/Writes a notice message to the log



public  **warning** (*unknown* $message, [*unknown* $context])

Sends/Writes a warning message to the log



public  **alert** (*unknown* $message, [*unknown* $context])

Sends/Writes an alert message to the log



