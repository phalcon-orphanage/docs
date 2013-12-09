Class **Phalcon\\Queue\\Beanstalk**
===================================

Class to access the beanstalk queue service. Partially implements the protocol version 1.2


Methods
---------

public  **__construct** ([*array* $options])





public  **connect** ()

...


public  **put** (*string* $data, [*array* $options])

Inserts jobs into the queue



public *boolean|Phalcon\Queue\Beanstalk\Job*  **reserve** ([*unknown* $timeout])

Reserves a job in the queue



public *string|boolean*  **choose** (*string* $tube)

Change the active tube. By default the tube is 'default'



public *string|boolean*  **watch** (*string* $tube)

Change the active tube. By default the tube is 'default'



public *boolean|Phalcon\Queue\Beanstalk\Job*  **peekReady** ()

Inspect the next ready job.



protected *array*  **readStatus** ()

Reads the latest status from the Beanstalkd server



public *string|boolean Data or `false` on error.*  **read** ([*unknown* $length])

Reads a packet from the socket. Prior to reading from the socket will check for availability of the connection.



protected *integer|boolean*  **write** ()

Writes data to the socket. Performs a connection if none is available



public *boolean*  **disconnect** ()

Closes the connection to the beanstalk server.



public  **__sleep** ()

...


public  **__wakeup** ()

...


