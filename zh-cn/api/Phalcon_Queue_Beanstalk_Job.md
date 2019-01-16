* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Queue\Beanstalk\Job'

* * *

# Class **Phalcon\Queue\Beanstalk\Job**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/queue/beanstalk/job.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Represents a job in a beanstalk queue

## 方法

public **getId** ()

public **getBody** ()

public **__construct** ([Phalcon\Queue\Beanstalk](Phalcon_Queue_Beanstalk) $queue, *mixed* $id, *mixed* $body)

public **delete** ()

Removes a job from the server entirely

public **release** ([*mixed* $priority], [*mixed* $delay])

The release command puts a reserved job back into the ready queue (and marks its state as "ready") to be run by any client. It is normally used when the job fails because of a transitory error.

public **bury** ([*mixed* $priority])

The bury command puts a job into the "buried" state. Buried jobs are put into a FIFO linked list and will not be touched by the server again until a client kicks them with the "kick" command.

public **touch** ()

The `touch` command allows a worker to request more time to work on a job. This is useful for jobs that potentially take a long time, but you still want the benefits of a TTR pulling a job away from an unresponsive worker. A worker may periodically tell the server that it's still alive and processing a job (e.g. it may do this on `DEADLINE_SOON`). The command postpones the auto release of a reserved job until TTR seconds from when the command is issued.

public **kick** ()

Move the job to the ready queue if it is delayed or buried.

public **stats** ()

Gives statistical information about the specified job if it exists.

public **__wakeup** ()

Checks if the job has been modified after unserializing the object