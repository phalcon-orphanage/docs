Class **Phalcon\\Queue\\Beanstalk**
===================================

* Phalcon\\Queue\\Beanstalk * * Class to access the beanstalk queue service. * Partially implements the protocol version 1.2 *


Methods
-------

public  **__construct** ([*unknown* $options])





public *resource*  **connect** ()

Makes a connection to the Beanstalkd server



public  **put** (*unknown* $data, [*unknown* $options])

Inserts jobs into the queue



public *boolean|Phalcon\Queue\Beanstalk\Job*  **reserve** ([*unknown* $timeout])

Reserves a job in the queue



public *string|boolean*  **choose** (*unknown* $tube)

Change the active tube. By default the tube is "default"



public *string|boolean*  **watch** (*unknown* $tube)

Change the active tube. By default the tube is "default"



public *boolean|Phalcon\Queue\Beanstalk\Job*  **peekReady** ()

Inspect the next ready job.



public *boolean|Phalcon\Queue\Beanstalk\Job*  **peekBuried** ()

Return the next job in the list of buried jobs



final public *array*  **readStatus** ()

Reads the latest status from the Beanstalkd server



public *string|boolean Data or `false` on error.*  **read** ([*unknown* $length])

Reads a packet from the socket. Prior to reading from the socket will check for availability of the connection.



protected *integer|boolean*  **write** (*unknown* $data)

Writes data to the socket. Performs a connection if none is available



public *boolean*  **disconnect** ()

Closes the connection to the beanstalk server.



