* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Queue\Beanstalk'

* * *

# Class **Phalcon\Queue\Beanstalk**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/queue/beanstalk.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

## Constants

*integer* **DEFAULT_DELAY**

*integer* **DEFAULT_PRIORITY**

*integer* **DEFAULT_TTR**

*string* **DEFAULT_TUBE**

*string* **DEFAULT_HOST**

*integer* **DEFAULT_PORT**

## Methods

public **__construct** ([*array* $parameters])

public **connect** ()

Makes a connection to the Beanstalkd server

public **put** (*mixed* $data, [*array* $options])

Puts a job on the queue using specified tube.

public **reserve** ([*mixed* $timeout])

Reserves/locks a ready job from the specified tube.

public **choose** (*mixed* $tube)

Change the active tube. By default the tube is "default".

public **watch** (*mixed* $tube)

The watch command adds the named tube to the watch list for the current connection.

public **ignore** (*mixed* $tube)

It removes the named tube from the watch list for the current connection.

public **pauseTube** (*mixed* $tube, *mixed* $delay)

Can delay any new job being reserved for a given time.

public **kick** (*mixed* $bound)

The kick command applies only to the currently used tube.

public **stats** ()

Gives statistical information about the system as a whole.

public **statsTube** (*mixed* $tube)

Gives statistical information about the specified tube if it exists.

public **listTubes** ()

Returns a list of all existing tubes.

public **listTubeUsed** ()

Returns the tube currently being used by the client.

public **listTubesWatched** ()

Returns a list tubes currently being watched by the client.

public **peekReady** ()

Inspect the next ready job.

public **peekBuried** ()

Return the next job in the list of buried jobs.

public **peekDelayed** ()

Return the next job in the list of buried jobs.

public **jobPeek** (*mixed* $id)

The peek commands let the client inspect a job in the system.

final public **readStatus** ()

Reads the latest status from the Beanstalkd server

final public **readYaml** ()

Fetch a YAML payload from the Beanstalkd server

public **read** ([*mixed* $length])

Reads a packet from the socket. Prior to reading from the socket will check for availability of the connection.

public **write** (*mixed* $data)

Writes data to the socket. Performs a connection if none is available

public **disconnect** ()

Closes the connection to the beanstalk server.

public **quit** ()

Simply closes the connection.