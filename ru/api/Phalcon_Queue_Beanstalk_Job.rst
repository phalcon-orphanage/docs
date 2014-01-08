Class **Phalcon\\Queue\\Beanstalk\\Job**
========================================

Represents a job in a beanstalk queue


Methods
-------

public  **__construct** (:doc:`Phalcon\\Queue\\Beanstalk <Phalcon_Queue_Beanstalk>` $queue, *string* $id, *mixed* $body)





public *string*  **getId** ()

Returns the job id



public *mixed*  **getBody** ()

Returns the job body



public *boolean*  **delete** ()

Removes a job from the server entirely



public *boolean*  **release** ()

The release command puts a reserved job back into the ready queue (and marks its state as "ready") to be run by any client. It is normally used when the job fails because of a transitory error.



public *boolean*  **bury** ()

The bury command puts a job into the "buried" state. Buried jobs are put into a FIFO linked list and will not be touched by the server again until a client kicks them with the "kick" command.



public *boolean*  **touch** ()

The bury command puts a job into the "buried" state. Buried jobs are put into a FIFO linked list and will not be touched by the server again until a client kicks them with the "kick" command.



public *boolean*  **kick** ()

Move the job to the ready queue if it is delayed or buried.



public  **__wakeup** ()

...


