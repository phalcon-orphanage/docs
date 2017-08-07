<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Queueing</a>
       <ul>
        <li>
          <a href="#put-jobs-in-queue">Putting Jobs into the Queue</a>
        </li>
        <li>
          <a href="#retrieving-messages">Retrieving Messages</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Queueing

Activities like processing videos, resizing images or sending emails aren't suitable to be executed online or in real time because it may slow the loading time of pages and severely impact the user experience.

The best solution here is to implement background jobs. The web application puts jobs into a queue and which will be processed separately.

While you can find more sophisticated PHP extensions to address queueing in your applications like [RabbitMQ](http://pecl.php.net/package/amqp); Phalcon provides a client for [Beanstalk](http://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/), a job queueing backend inspired by [Memcached](http://memcached.org/). It’s simple, lightweight, and completely specialized for job queueing.

<div class="alert alert-danger">
    <p>
        Some of the data returned from queue methods require that the module Yaml be installed. Please refer to <a href="http://php.net/manual/book.yaml.php">this</a> for more information. You will need to use Yaml &gt;= 2.0.0
    </p>
</div>

<a name='put-jobs-in-queue'></a>

## Putting Jobs into the Queue

After connecting to Beanstalk you can insert as many jobs as required. You can define the message structure according to the needs of the application:

```php
<?php

use Phalcon\Queue\Beanstalk;

// Connect to the queue
$queue = new Beanstalk(
    [
        'host' => '192.168.0.21',
        'port' => '11300',
    ]
);

// Insert the job in the queue
$queue->put(
    [
        'processVideo' => 4871,
    ]
);
```

Available connection options are:

| Option | Description                              | Default   |
| ------ | ---------------------------------------- | --------- |
| host   | IP where the beanstalk server is located | 127.0.0.1 |
| port   | Connection port                          | 11300     |

In the above example we stored a message which will allow a background job to process a video. The message is stored in the queue immediately and does not have a certain time to live.

Additional options as: time to run, priority and delay can be passed as second parameter:

```php
<?php

// Insert the job in the queue with options
$queue->put(
    [
        'processVideo' => 4871,
    ],
    [
        'priority' => 250,
        'delay'    => 10,
        'ttr'      => 3600,
    ]
);
```

The following options are available:

| Option   | Description                                                                                                                                                                                 |
| -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| priority | It's an integer < 2**32. Jobs with smaller priority values will be scheduled before jobs with larger priorities. The most urgent priority is 0; the least urgent priority is 4,294,967,295. |
| delay    | It's an integer number of seconds to wait before putting the job in the ready queue. The job will be in the 'delayed' state during this time.                                               |
| ttr      | Time to run -- is an integer number of seconds to allow a worker to run this job. This time is counted from the moment a worker reserves this job.                                          |

Every job put into the queue returns a `job id` which you can use to track the status of the job:

```php
<?php

$jobId = $queue->put(
    [
        'processVideo' => 4871,
    ]
);
```

<a name='retrieving-messages'></a>

## Retrieving Messages

Once a job is placed into the queue, those messages can be consumed by a background worker which will have enough time to complete the task:

```php
<?php

while (($job = $queue->peekReady()) !== false) {
    $message = $job->getBody();

    var_dump($message);

    $job->delete();
}
```

Jobs must be removed from the queue to avoid double processing. If multiple background jobs workers are implemented, jobs must be `reserved` so other workers don't re-process them while other workers have them reserved:

```php
<?php

while (($job = $queue->reserve()) !== false) {
    $message = $job->getBody();

    var_dump($message);

    $job->delete();
}
```

Our client implements a basic set of the features provided by Beanstalkd but enough to allow you to build applications implementing queues.