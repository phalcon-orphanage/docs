Class **Phalcon\\Queue\\Beanstalk\\Job**
========================================

Represents a job in a beanstalk queue


Methods
---------

public  **__construct** (:doc:`Phalcon\\Queue\\Beanstalk <Phalcon_Queue_Beanstalk>` $queue, *string* $id, *mixed* $body)





public *string*  **getId** ()

Returns the job id



public *mixed*  **getBody** ()

Returns the job body



public *boolean*  **delete** ()

Removes a job from the server entirely



public  **__wakeup** ()

...


