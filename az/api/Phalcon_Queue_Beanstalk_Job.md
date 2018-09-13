<h1>Class <strong>Phalcon\\Queue\\Beanstalk\\Job</strong></h1>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/queue/beanstalk/job.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<p>Represents a job in a beanstalk queue</p>

<h2>Methods</h2>

<p>public  <strong>getId</strong> ()</p>

<p>public  <strong>getBody</strong> ()</p>

<p>public  <strong>__construct</strong> (<a href="/en/3.2/api/Phalcon_Queue_Beanstalk">Phalcon\Queue\Beanstalk</a> $queue, <em>mixed</em> $id, <em>mixed</em> $body)</p>

<p>public  <strong>delete</strong> ()</p>

<p>Removes a job from the server entirely</p>

<p>public  <strong>release</strong> ([<em>mixed</em> $priority], [<em>mixed</em> $delay])</p>

<p>The release command puts a reserved job back into the ready queue (and marks
its state as "ready") to be run by any client. It is normally used when the job
fails because of a transitory error.</p>

<p>public  <strong>bury</strong> ([<em>mixed</em> $priority])</p>

<p>The bury command puts a job into the "buried" state. Buried jobs are put into
a FIFO linked list and will not be touched by the server again until a client
kicks them with the "kick" command.</p>

<p>public  <strong>touch</strong> ()</p>

<p>The <code>touch</code> command allows a worker to request more time to work on a job.
This is useful for jobs that potentially take a long time, but you still
want the benefits of a TTR pulling a job away from an unresponsive worker.
A worker may periodically tell the server that it's still alive and processing
a job (e.g. it may do this on <code>DEADLINE_SOON</code>). The command postpones the auto
release of a reserved job until TTR seconds from when the command is issued.</p>

<p>public  <strong>kick</strong> ()</p>

<p>Move the job to the ready queue if it is delayed or buried.</p>

<p>public  <strong>stats</strong> ()</p>

<p>Gives statistical information about the specified job if it exists.</p>

<p>public  <strong>__wakeup</strong> ()</p>

<p>Checks if the job has been modified after unserializing the object</p>
