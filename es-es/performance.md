---
layout: default
language: 'es-es'
version: '5.0'
title: 'Rendimiento'
keywords: 'rendimiento, perfilado, xdebug, xhprof, yslow, bytecode'
---

# Rendimiento
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Una aplicación mal escrita siempre tendrá un rendimiento malo. Una forma muy común para que los desarrolladores incrementen el rendimiento de su aplicación es:

> just throw more hardware to it 
> 
> {: .alert .alert-info }

El problema con el enfoque anterior es doble. Para empezar, en la mayoría de casos el propietario es el que incurrirá en la costes adicionales. The second issue is that there comes a time that one can no longer upgrade the hardware and will have to resort to load balancers, docker swarms etc. which will skyrocket costs.

The problem will remain: _the poorly written application_

Para acelerar su aplicación, primero necesita asegurarse de que su aplicación esté escrita de la mejor forma posible que cumpla con sus requisitos. Nada supera a un buen diseño. After that, there are many aspects to consider:
- server hardware
- clients connecting (location, browsers)
- network latency
- database hardware

y muchos más. En este artículo intentaremos destacar algunos escenarios que podrían proporcionar más información sobre dónde su aplicación es realmente lenta.

> **NOTE** These are **recommendations** and good practices. De ninguna manera está obligado a seguir los consejos de este documento, y de ninguna manera esta lista es exhaustiva. Sus estrategias de mejora de rendimiento dependen principalmente de las necesidades de su aplicación. 
> 
> {: .alert .alert-danger }

## Servidor
[Profiling][profiling] is a form of dynamic application analysis that offers metrics regarding your application. El perfilado ofrece la imagen real sobre qué esta ocurriendo realmente en cualquier momento en su aplicación, y de este modo le conduce a las áreas en las que su aplicación necesita atención. El perfilado debería ser continuo en una aplicación en producción.

Tiene una sobrecarga, por lo que hay que tenerlo en cuenta. La mayoría de perfilados más detallados se hacen en cada petición pero todo dependerá de su tráfico. Desde luego no queremos incrementar la carga del servidor sólo porque estamos perfilando la aplicación. Una forma común de perfilar es una petición por cada 100 o una por cada 1.000. Después de un tiempo tendrá suficientes datos para sacar conclusiones sobre dónde hay lentitudes, por qué ocurren los picos, etc.

### Xdebug
[XDebug][xdebug] offers a very handy profiler right out of the box. Todo lo que tiene que hacer es instalar la extensión y habilitar el perfilador en su `php.ini`:

```ini
xdebug.profiler_enable = On
```

Using a tool such as [Webgrind][webgrind] will allow you to connect to [XDebug][xdebug] and get very valuable information as to what is going on with your code. [Webgrind][webgrind] offers statistics on which methods are slower than others and other statistics.

### Xhprof
[Xhprof][xhprof] is another extension to profile PHP applications. Para habilitarla, todo lo que necesita es añadir la siguiente línea al inicio de su fichero de arranque:

```php
<?php

xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
```

Entonces, al final del fichero guardar los datos perfilados:

```php
<?php

$xhprof_data = xhprof_disable('/tmp');

$XHPROF_ROOT = '/var/www/xhprof/';
include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';

$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, 'xhprof_testing');

echo "https://localhost/xhprof/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";
```

Xhprof proporciona un visor HTML integrado para analizar los datos perfilados:

![](/assets/images/content/performance-xhprof-2.jpg)

![](/assets/images/content/performance-xhprof-1.jpg)

Como se ha mencionado arriba, el perfilado puede incrementar la carga de su servidor. In the case of [Xhprof][xhprof], you can introduce a conditional that would start profiling only after X requests.

### Sentencias SQL
Casi todos los RDBMs ofrecen herramientas para identificar sentencias SQL lentas. Identificar y solucionar consultas lentas es muy importante en términos de rendimiento en el lado del servidor. MariaDB / MySql / AuroraDb ofrecen ajustes de configuración que activan un registro `consultas-lentas`. La base de datos mantiene sus propias métricas y cada vez que una consulta tarda en completarse será registrada en el registro `consultas-lentas`. El registro se puede analizar por el equipo de desarrollo y se pueden realizar los ajustes.

Para activar esta característica necesitará añadir esto a `my.cnf` (no olvide reiniciar su servidor de base de datos)

```ini
log-slow-queries = /var/log/consultas-lentas.log
long_query_time = 1.5
```

## Cliente
Otro área en la que concentrarse es el cliente. Mejorar la carga de recursos como imágenes, hojas de estilo, ficheros javascript pueden mejorar significativamente el rendimiento y mejorar la experiencia de usuario. Hay una serie de herramientas que pueden ayudar a identificar cuellos de botella en el cliente:

### Navegadores
La mayoría de navegadores modernos tienen herramientas para perfilar el tiempo de carga de una página. Those are easily called _web inspectors_ or _developer tools_. Por ejemplo cuando usa Brave o cualquier navegador basado en Chromium puede inspeccionar la página y las herramientas de desarrollador mostrarán una cascada de lo que ha cargado para la página actual (ficheros), cuanto tiempo ha tardado y el tiempo total de carga:

![](/assets/images/content/performance-chrome-1.jpg)

A relatively easy fix for increasing client performance is to set the correct headers for assets so that they expire in the future vs. being loaded from the server on every request. Additionally, [CDN][cdn] providers can help with distributing assets from their distribution centers that are closest to the client originating the request.

### Yahoo! YSlow
[YSlow][yslow] analyzes web pages and suggests ways to improve their performance based on a set of [rules for high performance web pages][yslow_rules]

![](/assets/images/content/performance-yslow-1.jpg)

## PHP
PHP se está volviendo más rápido con cada nueva versión. Usando la última versión mejora el rendimiento de su aplicación y también de Phalcon.

### Caché Bytecode
[OPcache][opcache] as many other bytecode caches helps applications reduce the overhead of read, tokenize and parse PHP files in each request. Los resultados interpretados se mantienen en RAM entre peticiones siempre y cuando PHP se ejecute como fcgi (fpm) o mod_php. OPcache is bundled with php starting 5.5.0. To check if it is activated, look for the following entry in php.ini:

```ini
opcache.enable = On
opcache.memory_consumption = 128    ;default
```
Además, la cantidad de memoria disponible para el cacheado opcode necesita ser suficiente para almacenar todos los archivos de sus aplicaciones. El valor por defecto de 128M suele ser suficiente para códigos incluso más grandes.

### Caché en el lado del Servidor
[APCu][apcu] can be used to cache the results of computational expensive operations or otherwise slow data sources like webservices with high latency. Lo que hace a un resultado cacheable es otro tema, como regla general: las operaciones que se deben ejecutar a menudo y producir resultados idénticos. Asegúrese de medir mediante un perfilador que las optimizaciones realmente mejoran el tiempo de ejecución.

```ini
apc.enabled = On
apc.shm_size = 32M  ;default
```

Al igual que con el opcache mencionado anteriormente, asegúrese que la cantidad de RAM disponible se adapta a su aplicación. Alternatives to APCu would be [Redis][redis] or [Memcached][memcached] - although they need extra processes running on your server or another machine.


## Tareas Lentas
Basado en los requisitos de su aplicación, puede haber veces que necesite realizar tareas de ejecución largas. Ejemplos de estas tareas podrían ser procesamiento de vídeo, optimización de imágenes, envío de emails, generación de documentos PDF, etc. Estas tareas se deberían procesar usando tareas en segundo plano. The usual process is:
- The application initiates a task by sending a message to a queue service
- The user sees a message that the task has been scheduled
- In the background (or different server), worker scripts peek at the queue
- When a message arrives, the worker script detects the type of message and calls the relevant task script
- Once the task finishes, the user is notified that their data is ready.

Lo anterior es una visión simplificada de como un servicio de colas para procesamiento en segundo plano funciona, pero puede ofrecer una idea de cómo se pueden ejecutar tareas en segundo plano. También hay una variedad de servicios de cola disponibles que puede aprovechar usando las librerías PHP relevantes:

* [NATS][nats]
* [RabbitMQ][rabbitmq]
* [Redis][redis]
* [Resque][resque]
* [SQS][sqs]
* [ZeroMQ][zeromq]

## Velocidad de Página
[mod_pagespeed][mod_pagespeed] speeds up your site and reduces page load time. Es un módulo del servidor HTTP Apache de código abierto (también disponible para nginx) automáticamente aplica las mejores prácticas de rendimiento web a las páginas, y recursos asociados (CSS, JavaScript, imágenes) sin requerirle que modifique su contenido o flujo de trabajo existente.

[apcu]: https://php.net/manual/en/book.apcu.php
[cdn]: https://en.wikipedia.org/wiki/Content_delivery_network
[memcached]: https://memcached.org/
[mod_pagespeed]: https://www.modpagespeed.com/
[nats]: https://nats.io
[opcache]: https://php.net/manual/en/book.opcache.php
[profiling]: https://en.wikipedia.org/wiki/Profiling_(computer_programming)
[rabbitmq]: https://www.rabbitmq.com/
[redis]: https://redis.io/
[resque]: https://github.com/chrisboulton/php-resque
[sqs]: https://aws.amazon.com/sqs/
[yslow]: http://yslow.org/
[yslow_rules]: https://developer.yahoo.com/performance/rules.html
[xdebug]: https://xdebug.org/docs
[xhprof]: https://github.com/facebook/xhprof
[webgrind]: https://github.com/jokkedk/webgrind
[zeromq]: https://www.zeromq.org/
