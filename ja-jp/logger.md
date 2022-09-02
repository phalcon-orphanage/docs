---
layout: default
language: 'ja-jp'
version: '4.0'
upgrade: '#logger'
title: 'ログ'
keywords: 'psr-3, logger, adapters, noop, stream, syslog'
---

# ログ

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## 概要

[Phalcon\Logger](api/phalcon_logger#logger-logger) は、アプリケーションのログ採取サービスを提供するコンポーネントです。 異なるアダプタを使用して異なるバックエンドにログを記録することができます。 そして、トランザクションログ、設定オプション、さらに異なるログ形式も提供します。 [Phalcon\Logger](api/phalcon_logger#logger-logger) は、デバッグ作業から処理内容の追跡まで、アプリケーションで必要とされるあらゆるログ処理に使用できます。

![](/assets/images/implements-psr--3-blue.svg)

[Logger](api/phalcon_logger#logger-logger) コンポーネントは [PSR-3](https://www.php-fig.org/psr/psr-3/) に準拠するように書き換えられました。 これにより、Phalconベースのものだけでなく、 [PSR-3](api/phalcon_logger#logger-logger) ロガーを使用する任意のアプリケーションに [Phalcon\Logger](https://www.php-fig.org/psr/psr-3/) を使用できます。

v3では、ロガーはアダプタを同じコンポーネントに組み込んでいました。 したがって、本質的には、ロガーオブジェクトを作成する際には、開発者がロガー機能を持つアダプター(ファイル、ストリームなど)を作成していました。

v4においては、ロギング機能のみを実装するようにコンポーネントを書き換えました。そして、ログ処理を担当する1つ以上のアダプタを受け入れるようにしました。 これにより、[PSR-3](https://www.php-fig.org/psr/psr-3/)との互換性の速やかな提供と、コンポーネントの疎結合を実現しました。 また、複数のアダプタへのロギングを実現できるように、複数のアダプタをロギングコンポーネントに簡単に接続する方法も提供します。 この実装を使用することで、このコンポーネントに必要なコードを削減し、古い `Logger\Multiple` コンポーネントを削除しました。

## アダプター

このコンポーネントは、ログとして採取されたメッセージを記録するためにアダプターを使用します。 アダプタを使用することで、バックエンドを簡単に切り替えたり、必要に応じて複数のアダプタを使用したりできる一般的なロギングインターフェイスを実現します。 サポートされているアダプターは次のとおりです。

| アダプター                                                                        | Description                                 |
| ---------------------------------------------------------------------------- | ------------------------------------------- |
| [Phalcon\Logger\Adapter\Noop](api/phalcon_logger#logger-adapter-noop)     | Blackhole adapter (used for testing mostly) |
| [Phalcon\Logger\Adapter\Stream](api/phalcon_logger#logger-adapter-stream) | Logs messages on a file stream              |
| [Phalcon\Logger\Adapter\Syslog](api/phalcon_logger#logger-adapter-syslog) | Logs messages to the Syslog                 |

### Stream

このアダプターは、特定のファイルストリームにメッセージログを記録するときに使用されます。 このアダプターは、v3 `Stream` と `File` のいずれかを組み合わせます。 通常はファイル システム内のファイルにログを記録することが最も多いでしょう。

### Syslog

このアダプターはシステムログにメッセージを送信します。 syslogの動作はオペレーティングシステムによって異なる場合があります。

### Noop

これはブラックホールアダプタです *無限の彼方へ*メッセージを送信します！ このアダプターは、主にテストや同僚と冗談を言いたい場合に使用されます。

## Factory

[Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) コンポーネントを使用して、ロガーを作成できます。 [Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) が動作するには、 [Phalcon\Logger\AdapterFactory](api/phalcon_logger#logger-adapterfactory) でインスタンス化する必要があります。

```php
<?php

use Phalcon\Logger\LoggerFactory;
use Phalcon\Logger\AdapterFactory;

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);
```

### `load()`

[Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) は、設定に基づいてログ処理を構成する `load` メソッドを提供します。 構成は、配列または [Phalcon\Config](config) オブジェクトにすることができます。

> **注意**: これは、2つのストリームアダプタでロガーを作成する例です。 一つ目のアダプターは `main`から呼び出され、全てのメッセージログを採取します。一方、二つ目は`admin`（管理者）から呼び出され、アプリケーションの管理画面で生成されたメッセージログのみを採取します。 
{: .alert .alert-info}

```php
<?php

use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;

$config = [
    "name"     => "prod-logger",
    "adapters" => [
        "main"  => [
            "adapter" => "stream",
            "name"    => "/storage/logs/main.log",
            "options" => []
        ],
        "admin" => [
            "adapter" => "stream",
            "name"    => "/storage/logs/admin.log",
            "options" => []
        ],
    ],
];

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->load($config);
```

### `newInstance()`

[Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) は、`newInstance()` メソッドも提供しています。こちらのメソッドは、与えられた名前と関連するアダプタの配列に基づいてロガーを構成します。 上記の使用例は次の通りです:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;

$adapters = [
    "main"  => new Stream("/storage/logs/main.log"),
    "admin" => new Stream("/storage/logs/admin.log"),
];

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->newInstance('prod-logger', $adapters);
```

## ロガーの作成

ロガーの作成には、いくつかの手順があります。 まず最初にロガーオブジェクトを作成し、次にアダプターを追加します。 その後、アプリケーションに必要なメッセージのロギングを開始できます。

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

上記の例では、 [Stream](api/phalcon_logger#logger-adapter-stream) アダプタを作成します。 次に、ロガーオブジェクトを作成し、このアダプターを付与します。 ロガーに接続された各アダプターには、“どこでログにメッセージを記録するか”を知るために、固有の名前が必要です。 logger オブジェクトの `error()` メソッドを呼び出すと、メッセージは `/storage/logs/main.log` に保存されます。

ロガーコンポーネントは PSR-3 に準拠しているため、以下の方法を使用できます。

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->alert("This is an alert message");
$logger->critical("This is a critical message");
$logger->debug("This is a debug message");
$logger->error("This is an error message");
$logger->emergency("This is an emergency message");
$logger->info("This is an info message");
$logger->log(Logger::CRITICAL, "This is a log message");
$logger->notice("This is a notice message");
$logger->warning("This is a warning message");

```

The log generated is as follows:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] This is an alert message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a critical message
[Tue, 25 Dec 18 12:13:14 -0400][DEBUG] This is a debug message
[Tue, 25 Dec 18 12:13:14 -0400][ERROR] This is an error message
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] This is an emergency message
[Tue, 25 Dec 18 12:13:14 -0400][INFO] This is an info message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a log message
[Tue, 25 Dec 18 12:13:14 -0400][NOTICE] This is a notice message
[Tue, 25 Dec 18 12:13:14 -0400][WARNING] This is warning message
```

## Multiple Adapters

[Phalcon\Logger](api/phalcon_logger#logger-logger) は、一度の呼び出しで複数のアダプターにメッセージを送信できます:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

メッセージは、[first in first out](https://ja.wikipedia.org/wiki/FIFO) に基づき、登録された順序でハンドラーに送信されます。

### Excluding Adapters

[Phalcon\Logger](api/phalcon_logger#logger-logger) also offers the ability to exclude logging to one or more adapters when logging a message. This is particularly useful when in need to log a `manager` related message in the `manager` log but not in the `local` log without having to instantiate a new logger.

With the following setup:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);
```

we have the following:

```php
<?php

$logger->error('Something went wrong');
```

Log to all adapters

```php
<?php

$logger
    ->excludeAdapters(['local'])
    ->info('This does not go to the "local" logger');
```

Log only to remote and manager

> **NOTE** Internally, the component loops through the registered adapters and calls the relevant logging method to achieve logging to multiple adapters. If one of them fails, the loop will break and the remaining adapters (from the loop) will not log the message. In future versions of Phalcon we will be introducing asynchronous logging to alleviate this problem.
{: .alert .alert-warning }

## 定数

The class offers a number of constants that can be used to distinguish between log levels. These constants can also be used as the first parameter in the `log()` method.

| 定数          | Value |
| ----------- |:-----:|
| `EMERGENCY` |   0   |
| `CRITICAL`  |   1   |
| `ALERT`     |   2   |
| `ERROR`     |   3   |
| `WARNING`   |   4   |
| `NOTICE`    |   5   |
| `INFO`      |   6   |
| `DEBUG`     |   7   |
| `CUSTOM`    |   8   |

## Log Levels

[Phalcon\Logger](api/phalcon_logger#logger-logger) allows you to set the minimum log level for the logger(s) to log. If you set this integer value, any level higher in number than the one set will not be logged. Check the values of the constants in the previous section for the order that the levels are being set.

In the following example, we set the log level to `ALERT`. We will only see `EMERGENCY`, `CRITICAL` **and** `ALERT` messages.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->setLogLevel(Logger::ALERT);

$logger->alert("This is an alert message");
$logger->critical("This is a critical message");
$logger->debug("This is a debug message");
$logger->error("This is an error message");
$logger->emergency("This is an emergency message");
$logger->info("This is an info message");
$logger->log(Logger::CRITICAL, "This is a log message");
$logger->notice("This is a notice message");
$logger->warning("This is a warning message");

```

The log generated is as follows:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] This is an alert message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a critical message
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] This is an emergency message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a log message
```

The above can be used in situations where you want to log messages above a certain severity based on conditions in your application such as development mode vs. production.

> **NOTE**: The log level set is included in the logging. Anything **below** that level (i.e. higher number) will not be logged
{: .alert .alert-info }

> 
> **NOTE**: It is **never** a good idea to suppress logging levels in your application, since even warning errors do require CPU cycles to be processed and neglecting these errors could potentially lead to unintended circumstances 
{: .alert .alert-danger }

## トランザクション

[Phalcon\Logger](api/phalcon_logger#logger-logger) also offers the ability to queue the messages in your logger, and then *commit* them all together in the log file. This is similar to a database transaction with `begin` and `commit`. Each adapter exposes the following methods: - `begin` - begins the logging transaction - `inTransaction` - `bool` if you are in a transaction or not - `commit` - writes all the queued messages in the log file

Since the functionality is available at the adapter level, you can program your logger to use transactions on a per adapter basis.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

$logger->getAdapter('manager')->begin();

$logger->error('Something happened');

$logger->getAdapter('manager')->commit();
```

In the example above, we register three adapters. We set the `manager` logger to be in transaction mode. As soon as we call:

```php
$logger->error('Something happened');
```

the message will be logged in both `local` and `remote` adapters. It will be queued for the `manager` adapter and not logged until we call the `commit` method in the `manager` adapter.

> **NOTE**: If you set one or more adapters to be in transaction mode (i.e. call `begin`) and forget to call `commit`, The adapter will call `commit` for you right before it is destroyed.
{: .alert .alert-info }
## Message Formatting

This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

| アダプター                                                                        | Description                                  |
| ---------------------------------------------------------------------------- | -------------------------------------------- |
| [Phalcon\Logger\Formatter\Line](api/phalcon_logger#logger-formatter-line) | Formats the message on a single line of text |
| [Phalcon\Logger\Formatter\Json](api/phalcon_logger#logger-formatter-json) | Formats the message in a JSON string         |

### Line Formatter

Formats the messages using a one-line string. The default logging format is:

```bash
[%date%][%type%] %message%
```

#### Message Format

If the default format of the message does not fit the needs of your application you can change it using the `setFormat()` method. The log format variables allowed are:

| Variable    | Description                              |
| ----------- | ---------------------------------------- |
| `%message%` | The message itself expected to be logged |
| `%date%`    | Date the message was added               |
| `%type%`    | Uppercase string with message type       |

The following example demonstrates how to change the message format:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line('[%type%] - [%date%] - %message%');
$adapter   = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

which produces:

```bash
[ALERT] - [Tue, 25 Dec 18 12:13:14 -0400] - Something went wrong
```

If you do not want to use the constructor to change the message, you can always use the `setFormat()` on the formatter:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setFormat('[%type%] - [%date%] - %message%');

$adapter = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

#### Date Format

The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page](https://www.php.net/manual/en/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong'); 
```

which produces:

```bash
[ERROR] - [20181225-121314] - Something went wrong
```

### JSON Formatter

Formats the messages returning a JSON string:

```json
{
    "type"      : "Type of the message",
    "message"   : "The message",
    "timestamp" : "The date as defined in the date format"
}
```

#### Date Format

The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page](https://www.php.net/manual/en/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/storage/logs/main.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

which produces:

```json
{
    "type"      : "error",
    "message"   : "Something went wrong",
    "timestamp" : "20181225-121314"
}
```

### Custom Formatter

The [Phalcon\Logger\Formatter\FormatterInterface](api/phalcon_logger#logger-formatter-formatterinterface) interface must be implemented in order to create your own formatter or extend the existing ones. Additionally you can reuse the [Phalcon\Logger\Formatter\AbstractFormatter](api/phalcon_logger#logger-formatter-abstractformatter) abstract class.

## Interpolation

The logger also supports interpolation. There are times that you might need to inject additional text in your logging messages; text that is dynamically created by your application. This can be easily achieved by sending an array as the second parameter of the logging method (i.e. `error`, `info`, `alert` etc.). The array holds keys and values, where the key is the placeholder in the message and the value is what will be injected in the message.

The following example demonstrates interpolation by injecting in the message the parameter "framework" and "secs".

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$message = '{framework} executed the "Hello World" test in {secs} second(s)';
$context = [
    'framework' => 'Phalcon',
    'secs'      => 1,
];

$logger->info($message, $context);
```

## Item

The formatter classes above accept a [Phalcon\Logger\Item](api/phalcon_logger#logger-item) object. The object contains all the necessary data required for the logging process. It is used as a transport of data from the logger to the formatter.

## Exceptions

Any exceptions thrown in the Logger component will be of type [Phalcon\Logger\Exception](api/phalcon_logger#logger-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Exception;

try {
    $adapter = new Stream('/storage/logs/main.log');
    $logger  = new Logger(
        'messages',
        [
            'main' => $adapter,
        ]
    );

    // Log to all adapters
    $logger->error('Something went wrong');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Examples

### Stream

Logging to a file:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here](https://php.net/manual/en/wrappers.php). Logging to a stream

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('php://stderr');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Syslog

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Syslog;

// Setting identity/mode/facility
$adapter = new Syslog(
    'ident-name',
    [
        'option'   => LOG_NDELAY,
        'facility' => LOG_MAIL,
    ]
);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Noop

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Noop;

$adapter = new Noop('nothing');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Custom Adapters

The [Phalcon\Logger\AdapterInterface](api/phalcon_logger#logger-adapter-adapterinterface) interface must be implemented in order to create your own logger adapters or extend the existing ones. You can also take advantage of the functionality in [Phalcon\Logger\Adapter\AbstractAdapter](api/phalcon_logger#logger-adapter-abstractadapter) abstract class.

### Abstract Classes

There are two abstract classes that offer useful functionality when creating custom adapters: [Phalcon\Logger\Adapter\AbstractAdapter](api/phalcon_logger#logger-adapter-abstractadapter) and [Phalcon\Logger\Formatter\AbstractFormatter](api/phalcon_logger#logger-formatter-abstractformatter).

## 依存性の注入

You can register as many loggers as you want in the \[Phalcon\Di\FactoryDefault\]\[factorydefault\] container. An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new Di();

$container->set(
    'logger',
    function () {
        $adapter = new Stream('/storage/logs/main.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return $logger;
    }
);

// accessing it later:
$logger = $container->getShared('logger');

```
