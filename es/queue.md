<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Formación de Colas</a>
       <ul>
        <li>
          <a href="#put-jobs-in-queue">Poner Trabajos en la Cola</a>
        </li>
        <li>
          <a href="#retrieving-messages">Recuperando Mensajes</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Formación de Colas

Actividades como el procesamiento de vídeos, redimensionamiento de imágenes o enviar correos electrónicos no son adecuados para ser ejecutados en línea o en tiempo real porque puede disminuir el tiempo de carga de páginas y afectan seriamente la experiencia de usuario.

Aquí la mejor solución es implementar trabajos de fondo o en paralelo. La aplicación web pone trabajos en una cola y que se tramitarán por separado.

Mientras que usted puede encontrar extensiones PHP más sofisticadas para atender la formación de colas en sus aplicaciones como [RabbitMQ](http://pecl.php.net/package/amqp); Phalcon provee a un cliente para [Beanstalk](http://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/), un backend de colas de trabajo inspirado en [Memcached](http://memcached.org/). Es simple, ligero y totalmente especializado para la formación de colas de trabajo.

<div class="alert alert-danger">
    <p>
        Algunos de los datos devueltos de métodos de cola requieren tener instalado el módulo Yaml. Refiera por favor a <a href="http://php.net/manual/book.yaml.php">la documentación de Yaml</a> para obtener más información. Usted necesitará utilizar Yaml &gt;= 2.0.0
    </p>
</div>

<a name='put-jobs-in-queue'></a>

## Poner Trabajos en la Cola

Después de conectar a Beanstalk se puede insertar tantos trabajos como sea necesario. Se puede definir la estructura del mensaje según las necesidades de la aplicación:

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

Opciones de conexión disponibles:

| Opción | Descripción                                 | Predeterminado |
| ------ | ------------------------------------------- | -------------- |
| host   | IP donde se encuentra el servidor Beanstalk | 127.0.0.1      |
| port   | Puerto de conexión                          | 11300          |

En el ejemplo anterior se almacena un mensaje que permitirá a un trabajo de fondo procesar un video. El mensaje se almacena en la cola inmediatamente y no tiene un tiempo determinado de vida.

Las opciones adicionales como: tiempo de funcionamiento, prioridad y el retardo pueden ser pasadas como segundo parámetro:

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

Las siguientes opciones están disponibles:

| Opción   | Descripción                                                                                                                                                                                                                         |
| -------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| priority | Es un entero menor o igual a 4.294.967.295. Los trabajos con menores valores de prioridad se programarán antes de trabajos con prioridades más grandes. La prioridad más urgente es 0; la menos urgente prioridad es 4,294,967,295. |
| delay    | Es un número entero de segundos a esperar antes de poner el trabajo en la cola de lista. El trabajo estará en estado 'delayed', osea retrasado, durante este tiempo.                                                                |
| ttr      | Tiempo para ejecutar: es un número entero de segundos para permitir a un trabajador ejecutar este trabajo. Este tiempo se cuenta desde el momento que un trabajador reserva este trabajo.                                           |

Cada trabajo puesto en la cola retornará un `job id` con el cual es posible hacer un seguimiento del trabajo:

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

Una vez que un trabajo se coloca en la cola, esos mensajes pueden ser consumidos por un trabajador de segundo plano que tendrá suficiente tiempo para completar la tarea:

```php
<?php

while (($job = $queue->peekReady()) !== false) {
    $message = $job->getBody();

    var_dump($message);

    $job->delete();
}
```

Los trabajos son removidos de la cola para evitar doble procesamiento. Si son implementados multiples trabajadores en segudo plano, los trabajos son `reserved` para evitar que otros trabajadores los vuelvan a procesar cuando otro trabajador lo tiene reservado:

```php
<?php

while (($job = $queue->reserve()) !== false) {
    $message = $job->getBody();

    var_dump($message);

    $job->delete();
}
```

Nuestro cliente implementa un conjunto básico de características provistas por Beanstalkd pero suficientes para permitir construir aplicaciones que implementen colas.

## Advanced Topics

### Multiple Queues

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

### Tube Manipulation

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

### Server Status

You can get information about the entire server or specific tubes.

```php
<?php

$server_stats = $queue->stats();

$tube_stats = $queue->statsTube('myOtherTube');

$server_status = $queue->readStatus();

```

### Job Management

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

### Further Reading

[The protocol text](https://github.com/kr/beanstalkd/blob/master/doc/protocol.txt) contains all of the internal operational details of BeanstalkD and is often considered the defacto documentation for BeanstalkD.