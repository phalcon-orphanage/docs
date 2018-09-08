<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Increasing Performance</a> 
      <ul>
        <li>
          <a href="#profiling-server">Profile on the Server</a> 
          <ul>
            <li>
              <a href="#profiling-server-xhprof">Profiling with Xhprof</a>
            </li>
            <li>
              <a href="#profiling-server-sql-statements">Profiling SQL Statements</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#profiling-client">Profile on the Client</a> 
          <ul>
            <li>
              <a href="#profiling-client-chrome-firefox">Profile with Chrome/Firefox</a>
            </li>
            <li>
              <a href="#profiling-client-yslow">Yahoo! YSlow</a>
            </li>
            <li>
              <a href="#profiling-client-speed-tracer">Profile with Speed Tracer</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#php-version">Use a recent PHP version</a>
        </li>
        <li>
          <a href="#bytecode-cache">Use a PHP Bytecode Cache</a>
        </li>
        <li>
          <a href="#background-tasks">Do blocking work in the background</a>
        </li>
        <li>
          <a href="#page-speed">Google Page Speed</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Increasing Performance

Get faster applications requires refine many aspects: server, client, network, database, web server, static sources, etc. In this chapter we highlight scenarios where you can improve performance and how detect what is really slow in your application.

<a name='profiling-server'></a>

## Profile on the Server

Each application is different, the permanent profiling is important to understand where performance can be increased. Profiling gives us a real picture on what is really slow and what does not. Profiles can vary between a request and another, so it is important to make enough measurements to make conclusions.

Профилирование с XDebug

[XDebug](http://xdebug.org/docs) provides an easier way to profile PHP applications, just install the extension and enable profiling in the php.ini:

```ini
xdebug.profiler_enable = On
```

Using a tool like [Webgrind](https://github.com/jokkedk/webgrind/) you can see which functions/methods are slower than others:

![](/images/content/performance-webgrind.jpg)

<a name='profiling-server-xhprof'></a>

### Профилирование с Xhprof

[Xhprof](https://github.com/facebook/xhprof) is another interesting extension to profile PHP applications. Add the following line to the start of the bootstrap file:

```php
<?php

xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
```

Then at the end of the file save the profiled data:

```php
<?php

$xhprof_data = xhprof_disable('/tmp');

$XHPROF_ROOT = '/var/www/xhprof/';
include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';

$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, 'xhprof_testing');

echo "http://localhost/xhprof/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";
```

Xhprof provides a built-in HTML viewer to analyze the profiled data:

![](/images/content/performance-xhprof-2.jpg)

![](/images/content/performance-xhprof-1.jpg)

<a name='profiling-server-sql-statements'></a>

### Profiling SQL Statements

Most database systems provide tools to identify slow SQL statements. Detecting and fixing slow queries is very important in order to increase performance in the server side. In the Mysql case, you can use the slow query log to know what SQL queries are taking more time than expected:

```ini
log-slow-queries = /var/log/slow-queries.log
long_query_time = 1.5
```

<a name='profiling-client'></a>

## Profile on the Client

Sometimes we may need to improve the loading of static elements such as images, javascript and css to improve performance. The following tools are useful to detect common bottlenecks in the client side:

<a name='profiling-client-chrome-firefox'></a>

### Profile with Chrome/Firefox

Most modern browsers have tools to profile the page loading time. In Chrome you can use the web inspector to know how much time is taking the loading of the different resources required by a single page:

![](/images/content/performance-chrome-1.jpg)

[Firebug](http://getfirebug.com/) provides a similar functionality:

![](/images/content/performance-firefox-1.jpg)

<a name='profiling-client-yslow'></a>

### Yahoo! YSlow

[YSlow](http://developer.yahoo.com/yslow/) analyzes web pages and suggests ways to improve their performance based on a set of [rules for high performance web pages](http://developer.yahoo.com/performance/rules.html)

![](/images/content/performance-yslow-1.jpg)

<a name='profiling-client-speed-tracer'></a>

### Profile with Speed Tracer

[Speed Tracer](https://developers.google.com/web-toolkit/speedtracer/) is a tool to help you identify and fix performance problems in your web applications. It visualizes metrics that are taken from low level instrumentation points inside of the browser and analyzes them as your application runs. Speed Tracer is available as a Chrome extension and works on all platforms where extensions are currently supported (Windows and Linux).

![](/images/content/performance-speed-tracer.jpg)

This tool is very useful because it help you to get the real time used to render the whole page including HTML parsing, Javascript evaluation and CSS styling.

<a name='php-version'></a>

## Use a recent PHP version

PHP is faster every day, using the latest version improves the performance of your applications and also of Phalcon.

<a name='bytecode-cache'></a>

## Use a PHP Bytecode Cache

[APC](http://php.net/manual/en/book.apc.php) as many other bytecode caches help an application to reduce the overhead of read, tokenize and parse PHP files in each request. Once the extension is installed use the following setting to enable APC:

```ini
apc.enabled = On
```

<a name='background-tasks'></a>

## Do blocking work in the background

Process a video, send e-mails, compress a file or an image, etc., are slow tasks that must be processed in background jobs. There are a variety of tools that provide queuing or messaging systems that work well with PHP:

* [Beanstalkd](http://kr.github.io/beanstalkd/)
* [Redis](http://redis.io/)
* [RabbitMQ](http://www.rabbitmq.com/)
* [Resque](https://github.com/chrisboulton/php-resque>)
* [Gearman](http://gearman.org/)
* [ZeroMQ](http://www.zeromq.org/)

<a name='page-speed'></a>

## Google Page Speed

[mod_pagespeed](https://developers.google.com/speed/pagespeed/mod) speeds up your site and reduces page load time. This open-source Apache HTTP server module (also available for nginx as [ngx_pagespeed](https://developers.google.com/speed/pagespeed/ngx)) automatically applies web performance best practices to pages, and associated assets (CSS, JavaScript, images) without requiring that you modify your existing content or workflow.