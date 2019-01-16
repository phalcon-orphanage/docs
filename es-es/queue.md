* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Formación de Colas

Activities like processing videos, resizing images or sending emails aren't suitable to be executed online or in real time because it may slow the loading time of pages and severely impact the user experience.

The best solution here is to implement background jobs. The web application puts jobs into a queue and which will be processed separately.

While you can find more sophisticated PHP extensions to address queueing in your applications like [RabbitMQ](https://pecl.php.net/package/amqp); Phalcon provides a client for [Beanstalk](https://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/), a job queueing backend inspired by [Memcached](https://memcached.org/). It’s simple, lightweight, and completely specialized for job queueing.

<h5 class='alert alert-danger'>Some of the data returned from queue methods require that the module Yaml be installed. Please refer to <a href="https://php.net/manual/book.yaml.php">this</a> for more information. You will need to use Yaml >= 2.0.0 </h5>

<a name='put-jobs-in-queue'></a>

## Poner Trabajos en la Cola

After connecting to Beanstalk you can insert as many jobs as required. You can define the message structure according to the needs of the application:

```php
<?php

use Phalcon\Queue\Beanstalk;

// Conectar a la cola
$queue = new Beanstalk(
    [
        'host' => '192.168.0.21',
        'port' => '11300',
    ]
);

// Insertar el trabajo en la cola
$queue->put(
    [
        'processVideo' => 4871,
    ]
);
```

Available connection options are:

| Opción | Descripción                                 | Predeterminado |
| ------ | ------------------------------------------- | -------------- |
| host   | IP donde se encuentra el servidor Beanstalk | 127.0.0.1      |
| port   | Puerto de conexión                          | 11300          |

In the above example we stored a message which will allow a background job to process a video. The message is stored in the queue immediately and does not have a certain time to live.

Additional options as: time to run, priority and delay can be passed as second parameter:

```php
<?php

// Insertar un trabajo en la cola usando opciones
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

| Opción   | Descripción                                                                                                                                                                                                                         |
| -------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| priority | Es un entero menor o igual a 4.294.967.295. Los trabajos con menores valores de prioridad se programarán antes de trabajos con prioridades más grandes. La prioridad más urgente es 0; la menos urgente prioridad es 4,294,967,295. |
| delay    | Es un número entero de segundos a esperar antes de poner el trabajo en la cola de lista. El trabajo estará en estado 'delayed', osea retrasado, durante este tiempo.                                                                |
| ttr      | Tiempo para ejecutar: es un número entero de segundos para permitir a un trabajador ejecutar este trabajo. Este tiempo se cuenta desde el momento que un trabajador reserva este trabajo.                                           |

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

## Recuperando Mensajes

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

## Temas avanzados

### Colas múltiples

Beanstalkd supports multiple queues (called 'tubes') to allow for a single queue server to act as a hub for a variety of workers. Phalcon supports this readily.

Viewing the tubes available on the server, and choosing a tube for the queue object to use:

```php
<?php

$tube_array = $queue->listTubes();

$queue->choose('myOtherTube');
```

All subsequent work with `$queue` now manipulates `myOtherTube` instead of `default`.

You can view which tube the queue is using as well.

```php
<?php

$current_tube = $queue->listTubeUsed();
```

### Manipulación de tubos

Tubes can be paused and resumed if needed. The example below pauses `myOtherTube` for 3 minutes.

```php
<?php

$queue->pauseTube('myOtherTube', 180);
```

Setting the delay to 0 will resume normal operation.

```php
<?php

$queue->pauseTube('myOtherTube', 0);
```

### Estado del servidor

You can get information about the entire server or specific tubes.

```php
<?php

$server_stats = $queue->stats();

$tube_stats = $queue->statsTube('myOtherTube');

$server_status = $queue->readStatus();

```

### Gestión de trabajos

Beanstalkd supports the ability to manage jobs with both the idea of delaying a job and removing a job from the queue for later processing.

Burying a job is typically used to deal with potential problems outside of the worker that can be resolved. This takes the job and puts it into the buried queue.

```php
<?php

$job = $queue->reserve();
$job->bury();
```

A list of buried jobs is stored on the server. You can inspect the first buried job in the queue.

```php
<?php

$job_data = $queue->peekBuried();
```

If the buried queue is empty, this will return `false`, else it returns a Job object.

You can kick the first [N] buried jobs in the buried queue to put it/them back in the ready queue. Below is an example of kicking the first three buried jobs.

```php
<?php

$queue->kick(3);
```

Releasing jobs back to the ready queue can be done, along with an optional delay. This is handy for transient errors while processing a job. Below is an example of putting a low (100) priority and a 3 minute delay on a job.

```php
<?php

$job = $queue->reserve();

$job->release(100, 180);
```

Priority and delay are the same as when `put`ing a job on the queue.

Inspecting a job in the queue can be accomplished with `jobPeek($job_id)`. The example below attempts to peek at job id 5.

```php
<?php

$queue->jobPeek(5)
```

Jobs that have been `delete`ed cannot be inspected and will return `false`. Ready, buried, and delayed jobs will return a Job object.

### Lecturas adicionales

[The protocol text](https://github.com/kr/beanstalkd/blob/master/doc/protocol.txt) contains all of the internal operational details of BeanstalkD and is often considered the defacto documentation for BeanstalkD.