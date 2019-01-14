* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Formación de Colas

Actividades como el procesamiento de vídeos, redimensionamiento de imágenes o enviar correos electrónicos no son adecuados para ser ejecutados en línea o en tiempo real porque puede disminuir el tiempo de carga de páginas y afectan seriamente la experiencia de usuario.

Aquí la mejor solución es implementar trabajos de fondo o en paralelo. La aplicación web pone trabajos en una cola y que se tramitarán por separado.

While you can find more sophisticated PHP extensions to address queueing in your applications like [RabbitMQ](https://pecl.php.net/package/amqp); Phalcon provides a client for [Beanstalk](https://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/), a job queueing backend inspired by [Memcached](https://memcached.org/). Es simple, ligero y totalmente especializado para la formación de colas de trabajo.

<h5 class='alert alert-danger'>Some of the data returned from queue methods require that the module Yaml be installed. Please refer to <a href="https://php.net/manual/book.yaml.php">this</a> for more information. You will need to use Yaml >= 2.0.0 </h5>

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

## Temas avanzados

### Colas múltiples

Beanstalkd soporta múltiples colas (llamadas 'tubos') para permitir a un servidor de colas simple actuar como un hub para una variedad de trabajadores. Phalcon permite hacer esto fácilmente.

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

Los tubos pueden ser pausados o reanudados si lo necesita. Por ejemplo, pausaremos por 3 minutos el tubo `myOtherTube`.

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

Enterrar un trabajo, generalmente, se usa para tratar problemas potenciales que pueden resolverse fuera del trabajador. Esto toma el trabajo y lo pone en la cola enterrada.

```php
<?php

$job = $queue->reserve();
$job->bury();
```

Una lista de trabajos enterrados es almacenada en el servidor. Es posible inspeccionar el primer trabajo enterrado en la cola, de la siguiente manera.

```php
<?php

$job_data = $queue->peekBuried();
```

Si la cola de trabajos enterrados esta vacía, esto retornará `false`, en el caso contrario, retorna el objecto de trabajo.

Puede tomar los primeros [N] trabajos enterrados en la cola para ponerlos nuevamente en la cola de espera. A continuación hay un ejemplo de patear los primeros 3 trabajos enterrados.

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

La inspección de un trabajo en la cola se puede lograr con `jobPeek($job_id)`. El siguiente ejemplo intenta echar un vistazo a la identificación de trabajo 5.

```php
<?php

$queue->jobPeek(5)
```

Los trabajos que han sido eliminados no se pueden inspeccionar y devolverán `false`. Los trabajos listos, enterrados y retrasados devolverán un objeto de trabajo.

### Lecturas adicionales

[El texto del protocolo](https://github.com/kr/beanstalkd/blob/master/doc/protocol.txt) contiene todos los detalles operacionales internos de BeanstalkD, a menudo se considera la documentación de facto para BeanstalkD.