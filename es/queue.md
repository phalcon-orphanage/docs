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

Aquí la mejor solución es implementar trabajos en segundo plano. La aplicación web pone trabajos en una cola y que se procesarán por separado.

Mientras que usted puede encontrar extensiones PHP más sofisticadas para atender la formación de colas en sus aplicaciones como [RabbitMQ](http://pecl.php.net/package/amqp); Phalcon provee a un cliente para [Beanstalk](http://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/), un backend de colas de trabajo inspirado en [Memcached](http://memcached.org/). Es simple, ligero y totalmente especializado para la formación de colas de trabajo.

<div class="alert alert-danger">
    <p>
        Algunos de los datos devueltos de métodos de cola requieren tener instalado el módulo Yaml. Refiera por favor a <a href="http://php.net/manual/book.yaml.php">este</a> para obtener más información. Usted necesitará utilizar Yaml &gt;= 2.0.0
    </p>
</div>

<a name='put-jobs-in-queue'></a>

## Poner Trabajos en la Cola

Después de conectar a Beanstalk puede insertar tantos trabajos como sea necesario. Puede definir la estructura del mensaje según las necesidades de la aplicación:

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

En el ejemplo anterior almacenamos un mensaje que permite al trabajo en segundo plato procesar un video. Este mensaje es almacenado inmediatamente en una cola y no tiene un tiempo de vida definido.

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

| Opción   | Descripción                                                                                                                                                                                                |
| -------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| priority | Es un entero < 2 ** 32. Trabajos con valores menores de prioridad se programará antes de trabajos con prioridades más grandes. La prioridad más urgente es 0; la menos urgente prioridad es 4.294.967.295. |
| delay    | Es un número entero de segundos a esperar antes de poner el trabajo en la cola de lista. El trabajo estará en estado 'retrasado' durante este tiempo.                                                      |
| ttr      | Time To Run (tiempo para ejecutar), es un número entero de segundos que se permite al trabajador realizar este trabajo. Este tiempo es contado desde el momento en que el trabajador reserva este trabajo. |

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

Los tubos pueden ser pausados y reanudados si es necesario. En el siguiente ejemplo pausamos el tubo `myOtherTube` por 3 minutos.

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

Enterrar un trabajo generalmente se usa para tratar problemas potenciales fuera del trabajador que pueden resolverse. Este toma el trabajo y lo pone en una cola enterrada.

```php
<?php

$job = $queue->reserve();
$job->bury();
```

Una lista enterrada de trabajos es almacenada en el servidor. Puede inspeccionar el primer trabajo enterrado en la cola.

```php
<?php

$job_data = $queue->peekBuried();
```

Si la cola de trabajos enterrados esta vacía, esto retornará `false`, en el caso contrario, retorna el objecto de trabajo.

Puede patear los primeros trabajos enterrados [N] en la cola enterrada para ponerlos de nuevo en la lista de espera. A continuación un ejemplo de patear los primeros tres trabajos enterrados.

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

Inspeccionar un trabajo en la cola puede ser realizado con `jobPeek($job_id)`. El ejemplo siguiente intentamos ver el trabajo con id 5.

```php
<?php

$queue->jobPeek(5)
```

Los trabajos que han sido borrados `delete` no pueden ser inspeccionados y retornarán `false`. Los trabajos listos, enterrados y retrasados retornarán un objecto Job.

### Lecturas adicionales

[El texto del protocolo](https://github.com/kr/beanstalkd/blob/master/doc/protocol.txt) contiene todos los detalles operacionales internos de BeanstalkD, a menudo se considera la documentación de facto para BeanstalkD.