* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Mejorar el Rendimiento

Para conseguir aplicaciones más rápidas requiere perfeccionar muchos aspectos: servidor, cliente, red, base de datos, servidor web, fuentes estáticas, etcétera. En este capítulo destacamos escenarios donde se puede mejorar el rendimiento y cómo detectar lo que es realmente lento en su aplicación.

<a name='profiling-server'></a>

## Perfil en el servidor

Cada aplicación es diferente, el perfilado permanente es importante para conocer donde se puede aumentar el rendimiento. Los perfiles nos dan un panorama real de lo que es realmente lento y lo que no. Estos pueden variar entre una petición y otra, por lo que es importante tomar suficientes mediciones para tomar decisiones.

Perfiles con XDebug

[XDebug](https://xdebug.org/docs) provides an easier way to profile PHP applications, just install the extension and enable profiling in the php.ini:

```ini
xdebug.profiler_enable = On
```

Usando una herramienta como [Webgrind](https://github.com/jokkedk/webgrind/) puedes ver qué métodos y funciones son más lentas que otras:

![](/assets/images/content/performance-webgrind.jpg)

<a name='profiling-server-xhprof'></a>

### Perfilando con Xhprof

[XHProf](https://github.com/facebook/xhprof) es otra extensión interesante para perfilar aplicaciones en PHP. Agregue la siguiente línea al comienzo del archivo bootstrap:

```php
<?php

xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
```

Luego al final del archivo, guardar los datos perfilados:

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

XHProf proporciona un visor HTML incorporado para analizar los datos perfilados:

![](/assets/images/content/performance-xhprof-2.jpg)

![](/assets/images/content/performance-xhprof-1.jpg)

<a name='profiling-server-sql-statements'></a>

### Perfilando sentencias SQL

La mayoría sistemas de bases de datos proporcionan herramientas para identificar sentencias SQL lentas. La detección y corrección de consultas lentas es muy importante para aumentar el rendimiento en el lado del servidor. En el caso de Mysql, puede usar el log de consultas lentas para saber que consultas SQL están tomando más tiempo de lo esperado:

```ini
log-slow-queries = /var/log/slow-queries.log
long_query_time = 1.5
```

<a name='profiling-client'></a>

## Perfil en el cliente

A veces podemos necesitar mejorar la carga de elementos estáticos como imágenes, javascript y css para mejorar el rendimiento. Las siguientes herramientas son útiles para detectar cuellos de botella comunes en el lado del cliente:

<a name='profiling-client-chrome-firefox'></a>

### Perfilar con Chrome/Firefox

Los navegadores más modernos disponen de herramientas para perfilar el tiempo de carga de la página. En Chrome puede utilizar el inspector web para saber cuánto tiempo está tomando la carga de los diferentes recursos requeridos por una sola página:

![](/assets/images/content/performance-chrome-1.jpg)

[Firebug](https://getfirebug.com/) provides a similar functionality:

![](/assets/images/content/performance-firefox-1.jpg)

<a name='profiling-client-yslow'></a>

### Yahoo! YSlow

[YSlow](https://developer.yahoo.com/yslow/) analyzes web pages and suggests ways to improve their performance based on a set of [rules for high performance web pages](https://developer.yahoo.com/performance/rules.html)

![](/assets/images/content/performance-yslow-1.jpg)

<a name='profiling-client-speed-tracer'></a>

### Perfilar con Speed Tracer

[Speed Tracer](https://developers.google.com/web-toolkit/speedtracer/) es una herramienta para ayudarle a identificar y solucionar problemas de rendimiento en las aplicaciones web. Visualiza las métricas que se toman desde puntos de instrumentación de bajo nivel dentro del navegador y los analiza a medida que se ejecuta su aplicación. Speed Tracer está disponible como una extensión de Chrome y funciona en todas las plataformas donde las extensiones son soportadas actualmente (Windows y Linux).

![](/assets/images/content/performance-speed-tracer.jpg)

Esta herramienta es muy útil porque le ayuda a obtener el tiempo real que se utiliza para representar toda la página, como el análisis del HTML, evaluación de Javascript y estilos CSS.

<a name='php-version'></a>

## Utilizar una versión reciente de PHP

PHP es más rápido cada día, usando la última versión mejora el rendimiento de sus aplicaciones y también de Phalcon.

<a name='bytecode-cache'></a>

## Utilizar un caché Bytecode de PHP

[APC](https://php.net/manual/en/book.apc.php) as many other bytecode caches help an application to reduce the overhead of read, tokenize and parse PHP files in each request. Una vez instalada la extensión utilice la siguiente configuración para activar APC:

```ini
apc.enabled = On
```

<a name='background-tasks'></a>

## Realizar labores de bloqueo en segundo plano

Procesar un video, enviar e-mails, comprimir un archivo o una imagen, etc., son tareas lentas que deben ser procesadas por trabajos en segundo plano. Hay una variedad de herramientas que proporcionan colas o sistemas de mensajería que funcionan bien con PHP:

* [Beanstalkd](https://kr.github.io/beanstalkd/)
* [Redis](https://redis.io/)
* [RabbitMQ](https://www.rabbitmq.com/)
* [Resque](https://github.com/chrisboulton/php-resque>)
* [Gearman](https://gearman.org/)
* [ZeroMQ](https://www.zeromq.org/)

<a name='page-speed'></a>

## Google Page Speed

El [mod_pagespeed](https://developers.google.com/speed/pagespeed/mod) acelera su sitio y reduce el tiempo de carga de página. Este módulo del servidor HTTP Apache de código abierto (también disponible para nginx como [ngx_pagespeed](https://developers.google.com/speed/pagespeed/ngx)) automáticamente aplica las mejores prácticas de performance web a las páginas y a los activos asociados (CSS, JavaScript, imágenes) sin necesidad de modificar su contenido o flujo de trabajo.