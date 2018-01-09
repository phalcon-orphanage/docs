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
        Some of the data returned from queue methods require that the module Yaml be installed. Please refer to <a href="http://php.net/manual/book.yaml.php">this</a> for more information. Usted necesitará utilizar Yaml &gt;= 2.0.0
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

| Opción   | Descripción                                                                                                                                                                                 |
| -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| priority | It's an integer < 2**32. Jobs with smaller priority values will be scheduled before jobs with larger priorities. The most urgent priority is 0; the least urgent priority is 4,294,967,295. |
| delay    | Es un número entero de segundos a esperar antes de poner el trabajo en la cola de lista. El trabajo estará en estado 'delayed', osea retrasado, durante este tiempo.                        |
| ttr      | Tiempo para ejecutar: es un número entero de segundos para permitir a un trabajador ejecutar este trabajo. Este tiempo se cuenta desde el momento que un trabajador reserva este trabajo.   |

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