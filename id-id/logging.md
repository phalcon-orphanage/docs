---
layout: article
language: 'id-id'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Pembalakan

[Phalcon\Logger](api/Phalcon_Logger) is a component whose purpose is to provide logging services for applications. It offers logging to different backends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the [Phalcon\Logger](api/Phalcon_Logger) for every logging need your application has, from debugging processes to tracing application flow.

<a name='adapters'></a>

## Adaptor

This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface which provides the ability to easily switch backends if necessary. The adapters supported are:

| Adaptor                                                               | Deskripsi              |
| --------------------------------------------------------------------- | ---------------------- |
| [Phalcon\Logger\Adapter\File](api/Phalcon_Logger_Adapter_File)     | Log ke file teks biasa |
| [Phalcon\Logger\Adapter\Stream](api/Phalcon_Logger_Adapter_Stream) | Log ke Streaming PHP   |
| [Phalcon\Logger\Adapter\Syslog](api/Phalcon_Logger_Adapter_Syslog) | Log ke logger sistem   |
| `Phalcon\Logger\Adapter\FirePHP`                                   | Log ke FirePHP         |

<a name='adapters-factory'></a>

### Pabrik

Loads Logger Adapter class using `adapter` option

```php
<?php

use Phalcon\Logger\Factory;

$options = [
    'name'    => 'log.txt',
    'adapter' => 'file',
];

$logger = Factory::load($options);
```

<a name='creating'></a>

## Membuat Log

The example below shows how to create a log and add messages to it:

```php
& lt;? php

gunakan Phalcon \ Logger;
gunakan Phalcon \ Logger \ Adapter \ File sebagai FileAdapter;

$ logger = FileAdapter baru ('app / logs / test.log');

// Ini adalah tingkat log yang berbeda tersedia:

$ logger- & gt; kritis (
    'Ini adalah pesan penting'
);

$ logger- & gt; emergency (darurat)
    'Ini adalah pesan darurat'
);

$ logger- & gt; debug (
    'Ini adalah pesan debug'
);

kesalahan $ logger- & gt;
    'Ini adalah pesan kesalahan'
);

$ logger- & gt; info
    'Ini adalah pesan info'
);

pemberitahuan $ logger- & gt;
    'Ini adalah pesan pemberitahuan'
);

peringatan $ logger- & gt;
    'Ini adalah pesan peringatan'
);

$ logger- & gt; alert (
    'Ini adalah pesan peringatan'
);

// Anda juga bisa menggunakan metode log () dengan konstanta Logger:
$ logger- & gt; log (
    'Ini adalah pesan kesalahan lain',
    Logger :: ERROR
);

// Jika tidak ada konstanta yang diberikan, DEBUG diasumsikan.
logger- & gt; log
    'Ini adalah pesan'
);

// Anda juga bisa melewati parameter konteks seperti ini
$ logger- & gt; log (
    'Ini adalah sebuah {message}',
    [
        'pesan' = & gt; 'parameter'
    ]
);
```

The log generated is below:

```bash
Sel, 28 Jul 15 22:09:02 -0500] [KRITIS] Ini adalah pesan penting
[Tue, 28 Jul 15 22:09:02 -0500] [EMERGENCY] Ini adalah pesan darurat
[Tue, 28 Jul 15 22:09:02 -0500] [DEBUG] Ini adalah pesan debug
[Tue, 28 Jul 15 22:09:02 -0500] [ERROR] Ini adalah pesan kesalahan
[Tue, 28 Jul 15 22:09:02 -0500] [INFO] Ini adalah pesan info
[Tue, 28 Jul 15 22:09:02 -0500] [NOTICE] Ini adalah pesan pemberitahuan
[Sel, 28 Jul 15 22:09:02 -0500] [PERINGATAN] Ini adalah pesan peringatan
[Sel, 28 Jul 15 22:09:02 -0500] [ALERT] Ini adalah pesan peringatan
[Tue, 28 Jul 15 22:09:02 -0500] [ERROR] Ini adalah pesan kesalahan lainnya
[Tue, 28 Jul 15 22:09:02 -0500] [DEBUG] Ini adalah pesan
[Tue, 28 Jul 15 22:09:02 -0500] [DEBUG] Ini adalah parameter
```

You can also set a log level using the `setLogLevel()` method. This method takes a Logger constant and will only save log messages that are as important or more important than the constant:

```php
& lt;? php

gunakan Phalcon \ Logger;
gunakan Phalcon \ Logger \ Adapter \ File sebagai FileAdapter;

$ logger = FileAdapter baru ('app / logs / test.log');

$ logger- & gt; setLogLevel (
    Logger :: KRITIS
);
```

In the example above, only critical and emergency messages will get saved to the log. By default, everything is saved.

<a name='transactions'></a>

## Transaksi

Logging data to an adapter i.e. File (file system) is always an expensive operation in terms of performance. To combat that, you can take advantage of logging transactions. Transactions store log data temporarily in memory and later on write the data to the relevant adapter (File in this case) in a single atomic operation.

```php
& lt;? php

gunakan Phalcon \ Logger \ Adapter \ File sebagai FileAdapter;

// buat logger
$ logger = FileAdapter baru ('app / logs / test.log');

// Memulai transaksi
$ logger- & gt; begin ();

// Tambahkan pesan

$ logger- & gt; alert (
    'Ini adalah peringatan'
);

kesalahan $ logger- & gt;
    'Ini adalah kesalahan lain'
);

// Komit pesan ke file
$ logger- & gt; commit ();
```

<a name='multiple-handlers'></a>

## Logging ke Multiple Handler

[Phalcon\Logger](api/Phalcon_Logger) can send messages to multiple handlers with a just single call:

```php
& lt;? php

gunakan Phalcon \ Logger;
gunakan Phalcon \ Logger \ Multiple sebagai MultipleStream;
gunakan Phalcon \ Logger \ Adapter \ File sebagai FileAdapter;
gunakan Phalcon \ Logger \ Adapter \ Stream sebagai StreamAdapter;

$ logger = new MultipleStream ();



$ logger- & gt; push (
    FileAdapter baru ('test.log')
);

$ logger- & gt; push (
    StreamAdapter baru ('php: // stdout')
);

$ logger- & gt; log (
    'Ini adalah pesan'
);

$ logger- & gt; log (
    'Ini adalah kesalahan',
    Logger :: ERROR
);

kesalahan $ logger- & gt;
    'Ini adalah kesalahan lain'
);
```

The messages are sent to the handlers in the order they were registered.

<a name='message-formatting'></a>

## Pemformatan pesan

This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

| Adaptor                                                                     | Deskripsi                                                    |
| --------------------------------------------------------------------------- | ------------------------------------------------------------ |
| [Phalcon\Logger\Formatter\Line](api/Phalcon_Logger_Formatter_Line)       | Format pesannya menggunakan sebuah string satu-baris         |
| [Phalcon\Logger\Formatter\Firephp](api/Phalcon_Logger_Formatter_Firephp) | Format pesannya sehinggan mereka bisa mengirimnya ke FirePHP |
| [Phalcon\Logger\Formatter\Json](api/Phalcon_Logger_Formatter_Json)       | Mempersiapkan sebuah pesan untuk bisa dikodekan dengan JSON  |
| [Phalcon\Logger\Formatter\Syslog](api/Phalcon_Logger_Formatter_Syslog)   | Mempersiapkan sebuah pesan untuk bisa mengirim ke syslog     |

<a name='message-formatting-line'></a>

### Format garis

Formats the messages using a one-line string. The default logging format is:

```bash
[% date%] [% type%]% message%
```

You can change the default format using `setFormat()`, this allows you to change the format of the logged messages by defining your own. The log format variables allowed are:

| Variable  | Deskripsi                                |
| --------- | ---------------------------------------- |
| %message% | The message itself expected to be logged |
| %date%    | Tanggal pesan sudah ditambahkan          |
| %type%    | Huruf besar string dengan tipe pesan     |

The example below shows how to change the log format:

```php
& lt;? php

gunakan Phalcon \ Logger \ Formatter \ Line sebagai LineFormatter;

$ formatter = new LineFormatter ('% date% -% message%');

// Mengubah format logger
$ logger- & gt; setFormatter ($ formatter);
```

<a name='message-formatting-custom'></a>

### Melaksanakan formatters anda sendiri

The [Phalcon\Logger\FormatterInterface](api/Phalcon_Logger_FormatterInterface) interface must be implemented in order to create your own logger formatter or extend the existing ones.

<a name='usage'></a>

## Adaptor

The following examples show the basic use of each adapter:

<a name='usage-stream'></a>

### Stream Logger

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here](https://php.net/manual/en/wrappers.php):

```php
& lt;? php

gunakan Phalcon \ Logger \ Adapter \ Stream sebagai StreamAdapter;

// Membuka aliran menggunakan kompresi zlib
$ logger = new StreamAdapter ('compress.zlib: //week.log.gz');

// Menulis log ke stderr
$ logger = new StreamAdapter ('php: // stderr');
```

<a name='usage-file'></a>

### File Logger

This logger uses plain files to log any kind of data. By default all logger files are opened using append mode which opens the files for writing only; placing the file pointer at the end of the file. If the file does not exist, an attempt will be made to create it. You can change this mode by passing additional options to the constructor:

```php
& lt;? php

gunakan Phalcon \ Logger \ Adapter \ File sebagai FileAdapter;

// Buat file logger dalam mode 'w'
$ logger = FileAdapter baru
    'app / logs / test.log',
    [
        'mode' = & gt; 'w',
    ]
);
```

<a name='usage-syslog'></a>

### Logger Syslog

This logger sends messages to the system logger. The syslog behavior may vary from one operating system to another.

```php
& lt;? php

gunakan Phalcon \ Logger \ Adapter \ Syslog sebagai SyslogAdapter;

// Penggunaan Dasar
$ logger = SyslogAdapter baru (null);

// Setting ident / mode / fasilitas
$ logger = SyslogAdapter baru
    'ident-name',
    [
        'pilihan' = & gt; LOG_NDELAY,
        'fasilitas' = & gt; LOG_MAIL,
    ]
);
```

<a name='usage-firephp'></a>

### FirePHP Logger

This logger sends messages in HTTP response headers that are displayed by [FirePHP](https://www.firephp.org/), a [Firebug](https://getfirebug.com/) extension for Firefox.

```php
& lt;? php

gunakan Phalcon \ Logger;
gunakan Phalcon \ Logger \ Adapter \ Firephp sebagai Firephp;

$ logger = new Firephp ('');

$ logger- & gt; log (
    'Ini adalah pesan'
);

$ logger- & gt; log (
    'Ini adalah kesalahan',
    Logger :: ERROR
);

kesalahan $ logger- & gt;
    'Ini adalah kesalahan lain'
);
```

<a name='usage-custom'></a>

### Menerapkan adapter Anda sendiri

The [Phalcon\Logger\AdapterInterface](api/Phalcon_Logger_AdapterInterface) interface must be implemented in order to create your own logger adapters or extend the existing ones.