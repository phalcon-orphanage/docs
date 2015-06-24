Class **Phalcon\\Queue\\Beanstalk\\Job**
========================================

* Phalcon\\Queue\\Beanstalk\\Job * * Represents a job in a beanstalk queue


Methods
-------

public  **getId** ()

...


public  **getBody** ()

...


public  **__construct** (*unknown* $queue, *unknown* $id, *unknown* $body)





public *boolean*  **delete** ()

Removes a job from the server entirely



public *boolean*  **release** ([*unknown* $priority], [*unknown* $delay])

The release command puts a reserved job back into the ready queue (and marks its state as "ready") to be run by any client. It is normally used when the job fails because of a transitory error.



public *boolean*  **bury** ([*unknown* $priority])

The bury command puts a job into the "buried" state. Buried jobs are put into a FIFO linked list and will not be touched by the server again until a client kicks them with the "kick" command.



public *boolean*  **touch** ()

The `touch` command allows a worker to request more time to work on a job. This is useful for jobs that potentially take a long time, but you still want the benefits of a TTR pulling a job away from an unresponsive worker. A worker may periodically tell the server that it's still alive and processing a job (e.g. it may do this on `DEADLINE_SOON`). The command postpones the auto release of a reserved job until TTR seconds from when the command is issued.



public *boolean*  **kick** ()

Move the job to the ready queue if it is delayed or buried.



public  **__wakeup** ()

...


