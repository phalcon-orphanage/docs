---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Queue\Beanstalk'
---
# Class **Phalcon\Queue\Beanstalk**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/queue/beanstalk.zep)

Class to access the beanstalk queue service. Partially implements the protocol version 1.2

```php
<?php

use Phalcon\Queue\Beanstalk;

$queue = new Beanstalk(
    [
        "host"       => "127.0.0.1",
        "port"       => 11300,
        "persistent" => true,
    ]
);

```

## 常量

*integer* **DEFAULT_DELAY**

*integer* **DEFAULT_PRIORITY**

*integer* **DEFAULT_TTR**

*string* **DEFAULT_TUBE**

*string* **DEFAULT_HOST**

*integer* **DEFAULT_PORT**

## 方法

public **__construct** ([*array* $parameters])

public **connect** ()

使连接到 Beanstalkd 服务器

public **put** (*mixed* $data, [*array* $options])

在队列中使用指定的管提出一份工作。

public **reserve** ([*mixed* $timeout])

从指定的管道中储备/锁定一份现成的工作。

public **choose** (*mixed* $tube)

Change the active tube. By default the tube is "default".

public **watch** (*mixed* $tube)

监视命令添加命名的管到当前连接的观察名单。

public **ignore** (*mixed* $tube)

它从当前连接的表列表中移除命名的管。

public **pauseTube** (*mixed* $tube, *mixed* $delay)

可以延迟正在为某一给定时间保留任何新工作。

public **kick** (*mixed* $bound)

踢命令仅适用于当前使用的管。

public **stats** ()

给出了系统作为一个整体的统计信息。

public **statsTube** (*mixed* $tube)

如果它存在，给出了指定的管的统计信息。

public **listTubes** ()

返回列表中的所有现有管。

public **listTubeUsed** ()

返回当前正在使用的客户端的管。

public **listTubesWatched** ()

返回当前正在监视客户端列表管。

public **peekReady** ()

检查接下来的准备工作。

public **peekBuried** ()

在埋地作业的列表返回下一份工作。

public **peekDelayed** ()

在埋地作业的列表返回下一份工作。

public **jobPeek** (*mixed* $id)

Peek命令让客户端检查系统中的作业。

final public **readStatus** ()

从 Beanstalkd 服务器读取的最新状态

final public **readYaml** ()

从 Beanstalkd 服务器获取一个 YAML 有效载荷

public **read** ([*mixed* $length])

Reads a packet from the socket. Prior to reading from the socket will check for availability of the connection.

public **write** (*mixed* $data)

Writes data to the socket. Performs a connection if none is available

public **disconnect** ()

关闭到beanstalk 服务器的连接。

public **quit** ()

简单地关闭连接。