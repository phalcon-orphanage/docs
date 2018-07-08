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

The best solution here is to implement background jobs. The web application puts jobs into a queue and which will be processed separately.

Mientras que usted puede encontrar extensiones PHP más sofisticadas para atender la formación de colas en sus aplicaciones como [RabbitMQ](http://pecl.php.net/package/amqp); Phalcon provee a un cliente para [Beanstalk](http://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/), un backend de colas de trabajo inspirado en [Memcached](http://memcached.org/). Es simple, ligero y totalmente especializado para la formación de colas de trabajo.

<div class="alert alert-danger">
    <p>
        Algunos de los datos devueltos de métodos de cola requieren tener instalado el módulo Yaml. Refiera por favor a <a href="http://php.net/manual/book.yaml.php">este</a> para obtener más información. Usted necesitará utilizar Yaml &gt;= 2.0.0
    </p>
</div>

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

Opciones de conexión disponibles:

| Opción | Descripción                                 | Predeterminado |
| ------ | ------------------------------------------- | -------------- |
| host   | IP donde se encuentra el servidor Beanstalk | 127.0.0.1      |
| port   | Puerto de conexión                          | 11300          |

In the above example we stored a message which will allow a background job to process a video. The message is stored in the queue immediately and does not have a certain time to live.

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

| Opción   | Descripción                                                                                                                                                                                 |
| -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| priority | It's an integer < 2**32. Jobs with smaller priority values will be scheduled before jobs with larger priorities. The most urgent priority is 0; the least urgent priority is 4,294,967,295. |
| delay    | It's an integer number of seconds to wait before putting the job in the ready queue. The job will be in the 'delayed' state during this time.                                               |
| ttr      | Time to run -- is an integer number of seconds to allow a worker to run this job. This time is counted from the moment a worker reserves this job.                                          |

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

## Temas avanzados

### Colas múltiples

Beanstalkd supports multiple queues (called 'tubes') to allow for a single queue server to act as a hub for a variety of workers. Phalcon supports this readily.

Ver los tubos disponibles en el servidor y elegir un tubo para que el objeto de la cola lo use, ver el siguiente ejemplo:

```php
<?php

$tube_array = $queue->listTubes();

$queue->choose('myOtherTube');
```

Todo el trabajo posterior con `$queue` ahora se manipula en `myOtherTube` en lugar de `default`.

Puede ver qué tubo está usando la cola, a continuación un ejemplo.

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

Estableciendo el retraso en 0, se reanudará el funcionamiento normal.

```php
<?php

$queue->pauseTube('myOtherTube', 0);
```

### Estado del servidor

Puede obtener información sobre el servidor entero o de un tubo especifico.

```php
<?php

$server_stats = $queue->stats();

$tube_stats = $queue->statsTube('myOtherTube');

$server_status = $queue->readStatus();

```

### Gestión de trabajos

Beanstalkd admite la gestión de trabajos con la idea de retrasar un trabajo y eliminar un trabajo de la cola para su posterior procesamiento.

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

Si la cola de trabajos enterrados esta vacía, esto retornará `false`, en el caso contrario, retorna el objecto de trabajo.

You can kick the first [N] buried jobs in the buried queue to put it/them back in the ready queue. Below is an example of kicking the first three buried jobs.

```php
<?php

$queue->kick(3);
```

Se puede realizar trabajos de liberación a la lista de espera, junto con un retraso opcional. Esto es útil para errores transitorios al procesar un trabajo. A continuación se muestra un ejemplo de poner una prioridad baja (100) y una demora de 3 minutos en un trabajo.

```php
<?php

$job = $queue->reserve();

$job->release(100, 180);
```

La prioridad y el retraso son las mismas cuando pone un trabajo en la cola.

Inspecting a job in the queue can be accomplished with `jobPeek($job_id)`. The example below attempts to peek at job id 5.

```php
<?php

$queue->jobPeek(5)
```

Jobs that have been `delete`ed cannot be inspected and will return `false`. Ready, buried, and delayed jobs will return a Job object.

### Lecturas adicionales

[El texto del protocolo](https://github.com/kr/beanstalkd/blob/master/doc/protocol.txt) contiene todos los detalles operacionales internos de BeanstalkD, a menudo se considera la documentación de facto para BeanstalkD.