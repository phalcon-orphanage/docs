Class **Phalcon\\Queue\\Beanstalk**
===================================

* Phalcon\\Queue\\Beanstalk * * Class to access the beanstalk queue service. * Partially implements the protocol version 1.2 *


Methods
-------

public  **__construct** ([*array* $options])





public  **connect** ()

Makes a connection to the Beanstalkd server



public  **put** (*string* $data, [*array* $options])

Inserts jobs into the queue



public  **reserve** ([*unknown* $timeout])

Reserves a job in the queue



public  **choose** (*unknown* $tube)

Change the active tube. By default the tube is "default"



public  **watch** (*unknown* $tube)

Change the active tube. By default the tube is "default"



public  **stats** ()

Get stats of the Beanstalk server.



public  **statsTube** (*unknown* $tube)

Get stats of a tube.



public  **peekReady** ()

Inspect the next ready job.



public  **peekBuried** ()

Return the next job in the list of buried jobs



final public  **readStatus** ()

Reads the latest status from the Beanstalkd server



final public  **readYaml** ()

Fetch a YAML payload from the Beanstalkd server



public *string|boolean Data or `false` on error.*  **read** ([*unknown* $length])

Reads a packet from the socket. Prior to reading from the socket will check for availability of the connection.



protected  **write** (*unknown* $data)

Writes data to the socket. Performs a connection if none is available



public  **disconnect** ()

Closes the connection to the beanstalk server.



