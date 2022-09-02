---
layout: default
language: 'es-es'
version: '4.0'
title: 'Rendimiento'
keywords: 'rendimiento, perfilado, xdebug, xhprof, yslow, bytecode'
---

# Rendimiento

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Una aplicación mal escrita siempre tendrá un rendimiento malo. Una forma muy común para que los desarrolladores incrementen el rendimiento de su aplicación es:

> justo lanzarle más *hardware*
{: .alert .alert-info }

El problema con el enfoque anterior es doble. Para empezar, en la mayoría de casos el propietario es el que incurrirá en la costes adicionales. La segunda cuestión es que llega un momento en que uno ya no puede actualizar el *hardware* y tendrá que recurrir a los balanceadores de carga, enjambres docker, etc. lo que disparará los costes.

El problema permanecerá: *la aplicación mal escrita*

Para acelerar su aplicación, primero necesita asegurarse de que su aplicación esté escrita de la mejor forma posible que cumpla con sus requisitos. Nada supera a un buen diseño. Después de eso, hay muchos aspectos a considerar: - *hardware* del servidor - clientes que se conectan (localización, navegadores) - latencia de la red - *hardware* de la base de datos

y muchos más. En este artículo intentaremos destacar algunos escenarios que podrían proporcionar más información sobre dónde su aplicación es realmente lenta.

> **NOTA** Estas son **recomendaciones** y buenas prácticas. De ninguna manera está obligado a seguir los consejos de este documento, y de ninguna manera esta lista es exhaustiva. Sus estrategias de mejora de rendimiento dependen principalmente de las necesidades de su aplicación.
{: .alert .alert-danger }

## Servidor

[Perfilado](https://en.wikipedia.org/wiki/Profiling_(computer_programming)) es una forma de análisis de aplicación dinámico que ofrece métricas sobre su aplicación. El perfilado ofrece la imagen real sobre qué esta ocurriendo realmente en cualquier momento en su aplicación, y de este modo le conduce a las áreas en las que su aplicación necesita atención. El perfilado debería ser continuo en una aplicación en producción.

Tiene una sobrecarga, por lo que hay que tenerlo en cuenta. La mayoría de perfilados más detallados se hacen en cada petición pero todo dependerá de su tráfico. Desde luego no queremos incrementar la carga del servidor sólo porque estamos perfilando la aplicación. Una forma común de perfilar es una petición por cada 100 o una por cada 1.000. Después de un tiempo tendrá suficientes datos para sacar conclusiones sobre dónde hay lentitudes, por qué ocurren los picos, etc.

### Xdebug

[XDebug](https://xdebug.org/docs) ofrece un perfilador muy práctico desde el primer momento. Todo lo que tiene que hacer es instalar la extensión y habilitar el perfilador en su `php.ini`:

```ini
xdebug.profiler_enable = On
```

Usando una herramienta como [Webgrind](https://github.com/jokkedk/webgrind) le permitirá conectar a [XDebug](https://xdebug.org/docs) y obtener información muy valiosa sobre lo que está pasando con su código. [Webgrind](https://github.com/jokkedk/webgrind) ofrece estadísticas sobre qué métodos son más lentos que otros y otras estadísticas.

### Xhprof

[Xhprof](https://github.com/facebook/xhprof) es otra extensión para perfilar aplicaciones PHP. Para habilitarla, todo lo que necesita es añadir la siguiente línea al inicio de su fichero de arranque:

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

Como se ha mencionado arriba, el perfilado puede incrementar la carga de su servidor. En el caso de [Xhprof](https://github.com/facebook/xhprof), puede introducir un condicional que iniciaría el perfilado sólo después de X peticiones.

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

La mayoría de navegadores modernos tienen herramientas para perfilar el tiempo de carga de una página. Estos se llaman fácilmente *inspectores web* o *herramientas de desarrollador*. Por ejemplo cuando usa Brave o cualquier navegador basado en Chromium puede inspeccionar la página y las herramientas de desarrollador mostrarán una cascada de lo que ha cargado para la página actual (ficheros), cuanto tiempo ha tardado y el tiempo total de carga:

![](/assets/images/content/performance-chrome-1.jpg)

Una solución relativamente sencilla para incrementar el rendimiento del cliente es establecer las cabeceras correctas para los recursos de manera que caduquen en el futuro vs. se carguen desde el servidor en cada petición. Además, los proveedores [CDN](https://en.wikipedia.org/wiki/Content_delivery_network) pueden ayudar en la distribución de los recursos desde sus centros de distribución más cercanos al cliente que origina la petición.

### Yahoo! YSlow

[YSlow](http://yslow.org/) analiza las páginas web y sugiere formas de mejorar su rendimiento basado en un conjunto de [reglas para páginas web de alto rendimiento](https://developer.yahoo.com/performance/rules.html)

![](/assets/images/content/performance-yslow-1.jpg)

## PHP

PHP se está volviendo más rápido con cada nueva versión. Usando la última versión mejora el rendimiento de su aplicación y también de Phalcon.

### Caché Bytecode

[OPcache](https://php.net/manual/en/book.opcache.php) como muchos otros cachés de bytecode ayuda a las aplicaciones a reducir la sobrecarga de lectura, tokenización y análisis de ficheros PHP en cada petición. Los resultados interpretados se mantienen en RAM entre peticiones siempre y cuando PHP se ejecute como fcgi (fpm) o mod_php. OPcache está empaquetado con php empezando en 5.5.0. Para comprobar si está activado, busque la siguiente entrada en php.ini:

```ini
opcache.enable = On
opcache.memory_consumption = 128    ;default
```

Además, la cantidad de memoria disponible para el cacheado opcode necesita ser suficiente para almacenar todos los archivos de sus aplicaciones. El valor por defecto de 128M suele ser suficiente para códigos incluso más grandes.

### Caché en el lado del Servidor

Se puede usar [APCu](https://php.net/manual/en/book.apcu.php) para cachear los resultados de operaciones de cálculo costosas o fuentes de datos lentas como servicios web con alta latencia. Lo que hace a un resultado cacheable es otro tema, como regla general: las operaciones que se deben ejecutar a menudo y producir resultados idénticos. Asegúrese de medir mediante un perfilador que las optimizaciones realmente mejoran el tiempo de ejecución.

```ini
apc.enabled = On
apc.shm_size = 32M  ;default
```

Al igual que con el opcache mencionado anteriormente, asegúrese que la cantidad de RAM disponible se adapta a su aplicación. Alternativas a APCu serían [Redis](https://redis.io/) o [Memcached](https://memcached.org/) - aunque necesitan procesos adicionales ejecutándose en su servidor u otra máquina.

## Tareas Lentas

Basado en los requisitos de su aplicación, puede haber veces que necesite realizar tareas de ejecución largas. Ejemplos de estas tareas podrían ser procesamiento de vídeo, optimización de imágenes, envío de emails, generación de documentos PDF, etc. Estas tareas se deberían procesar usando tareas en segundo plano. El proceso normal es: - La aplicación inicia una tarea enviando un mensaje al servicio de colas - El usuario ve un mensaje de que la tarea ha sido programada - En segundo plano (o servidor diferente), los *scripts* trabajadores revisan la cola - Cuando llega un mensaje, el *script* trabajador detecta el tipo de mensaje y llama a *script* de la tarea relevante - Una vez que finaliza la tarea, se notifica al usuario de que sus datos están listos.

Lo anterior es una visión simplificada de como un servicio de colas para procesamiento en segundo plano funciona, pero puede ofrecer una idea de cómo se pueden ejecutar tareas en segundo plano. También hay una variedad de servicios de cola disponibles que puede aprovechar usando las librerías PHP relevantes:

* [NATS](https://nats.io)
* [RabbitMQ](https://www.rabbitmq.com/)
* [Redis](https://redis.io/)
* [Resque](https://github.com/chrisboulton/php-resque)
* [SQS](https://aws.amazon.com/sqs/)
* [ZeroMQ](https://www.zeromq.org/)

## Velocidad de Página

[mod_pagespeed](https://www.modpagespeed.com/) acelera su sitio y reduce el tiempo de carga de la página. Es un módulo del servidor HTTP Apache de código abierto (también disponible para nginx) automáticamente aplica las mejores prácticas de rendimiento web a las páginas, y recursos asociados (CSS, JavaScript, imágenes) sin requerirle que modifique su contenido o flujo de trabajo existente.
