Logging
=======

:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` adalah komponen yang kegunaannya menyediakan layanan logging bagi aplikasi. Ia menyediakan logging ke backend berbeda dengan adapter berbeda. Ia juga menyediakan logging transaksi, opsi konfigurasi format berbeda dan filter. Anda dapat menggunakan :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` untuk semua kebutuhan logging aplikasi Anda, mulai debugging proses hingga melacak alir aplikasi.

Adapter
-------
Komponen ini memanfaatkan adapter untuk menyimpan pesan log. Penggunaan adapter memungkinkan antar muka umum bagi logging memudahkan berpindah backend jika diperlukan. Adapter yang didukung:

+----------------------------------------------------------------------------------+------------------------+
| Adapter                                                                          | Deskripsi              |
+==================================================================================+========================+
| :doc:`Phalcon\\Logger\\Adapter\\File <../api/Phalcon_Logger_Adapter_File>`       | Log ke plain text file |
+----------------------------------------------------------------------------------+------------------------+
| :doc:`Phalcon\\Logger\\Adapter\\Stream <../api/Phalcon_Logger_Adapter_Stream>`   | Log ke PHP Streams     |
+----------------------------------------------------------------------------------+------------------------+
| :doc:`Phalcon\\Logger\\Adapter\\Syslog <../api/Phalcon_Logger_Adapter_Syslog>`   | Log ke system logger   |
+----------------------------------------------------------------------------------+------------------------+
| :doc:`Phalcon\\Logger\\Adapter\\FirePHP <../api/Phalcon_Logger_Adapter_Firephp>` | Log ke FirePHP         |
+----------------------------------------------------------------------------------+------------------------+

Menciptakan Log
---------------
Contoh berikut menunjukkan bagaimana menciptakan sebuah log dan menambah pesan kedalamnya:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");



    // Ini adalah bermacam level log yang tersedia:

    $logger->critical(
        "This is a critical message"
    );

    $logger->emergency(
        "This is an emergency message"
    );

    $logger->debug(
        "This is a debug message"
    );

    $logger->error(
        "This is an error message"
    );

    $logger->info(
        "This is an info message"
    );

    $logger->notice(
        "This is a notice message"
    );

    $logger->warning(
        "This is a warning message"
    );

    $logger->alert(
        "This is an alert message"
    );



    // Anda dapat menggunakan metode log() dengan Logger constant:
    $logger->log(
        "This is another error message",
        Logger::ERROR
    );

    // Jika tidak ditentukan diasumsikan Logger::DEBUG.
    $logger->log(
        "This is a message"
    );

    // You can also pass context parameters like this
    $logger->log(
        "This is a {message}", 
        [ 
            'message' => 'parameter' 
        ]
    );

Log yang dihasilkan seperti berikut:

.. code-block:: none

    [Tue, 28 Jul 15 22:09:02 -0500][CRITICAL] This is a critical message
    [Tue, 28 Jul 15 22:09:02 -0500][EMERGENCY] This is an emergency message
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a debug message
    [Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is an error message
    [Tue, 28 Jul 15 22:09:02 -0500][INFO] This is an info message
    [Tue, 28 Jul 15 22:09:02 -0500][NOTICE] This is a notice message
    [Tue, 28 Jul 15 22:09:02 -0500][WARNING] This is a warning message
    [Tue, 28 Jul 15 22:09:02 -0500][ALERT] This is an alert message
    [Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is another error message
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a message
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a parameter

Anda dapat mengatur level log menggunakan metode :code:`setLogLevel()`. Metode ini membutuhkan Logger constant dan hanya akan menyimpan pesan log yang sama atau lebih penting dari nilai konstan:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");

    $logger->setLogLevel(
        Logger::CRITICAL
    );

Di contoh di atas, hanya pesan kritis dan darurat yang akan disimpan di log. Defaultnya, semua disimpan.

Transaksi
---------
Logging data ke adapter misal File (file system) adalah operasi mahal ditinjau dari sisi performa. Untuk melawannya, anda dapat menggunakan transaksi logging. Transaksi menyimpan data log sementara di memori yang nanti ditulis ke adapter terkait (dalam hal ini File) dalam operasi atomik tunggal.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Buat logger
    $logger = new FileAdapter("app/logs/test.log");

    // Mulai transaksi
    $logger->begin();

    // Tambahkan pesan

    $logger->alert(
        "This is an alert"
    );

    $logger->error(
        "This is another error"
    );

    // Commit pesan ke file
    $logger->commit();

Logging ke Handlers lebih dari satu
-----------------------------------
:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` dapat mengirim pesan ke handler lebih dari satu dengan sekali pemanggilan:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Multiple as MultipleStream;
    use Phalcon\Logger\Adapter\File as FileAdapter;
    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    $logger = new MultipleStream();



    $logger->push(
        new FileAdapter("test.log")
    );

    $logger->push(
        new StreamAdapter("php://stdout")
    );



    $logger->log(
        "This is a message"
    );

    $logger->log(
        "This is an error",
        Logger::ERROR
    );

    $logger->error(
        "This is another error"
    );

Pesan tersebut akan dikirim ke handler sesuai urutan pendaftarannya.

Format Pesan
------------
Komponen ini menggunakan 'formatters' untuk mengatur format pesan sebelum dikirim ke backend. Formatter yang tersedia:

+--------------------------------------------------------------------------------------+--------------------------------------------+
| Adapter                                                                              | Keterangan                                 |
+======================================================================================+============================================+
| :doc:`Phalcon\\Logger\\Formatter\\Line <../api/Phalcon_Logger_Formatter_Line>`       | Format pesan dengan string satu baris      |
+--------------------------------------------------------------------------------------+--------------------------------------------+
| :doc:`Phalcon\\Logger\\Formatter\\Firephp <../api/Phalcon_Logger_Formatter_Firephp>` | Format pesan agar dapat dikirim ke FirePHP |
+--------------------------------------------------------------------------------------+--------------------------------------------+
| :doc:`Phalcon\\Logger\\Formatter\\Json <../api/Phalcon_Logger_Formatter_Json>`       | Siapkan pesan untuk di encode sebagai JSON |
+--------------------------------------------------------------------------------------+--------------------------------------------+
| :doc:`Phalcon\\Logger\\Formatter\\Syslog <../api/Phalcon_Logger_Formatter_Syslog>`   | Siapkan pesan untuk diirim ke syslog       |
+--------------------------------------------------------------------------------------+--------------------------------------------+

Line Formatter
^^^^^^^^^^^^^^
Format pesan menggunakan string satu baris. Default format logging adalah:

.. code-block:: none

    [%date%][%type%] %message%

Anda dapat mengubah format default dengan :code:`setFormat()`, ini memungkinkan anda mengubah format pesan log dengan mendefinsikan format anda sendiri. Format variabel yang diizinkan adalah:

+-----------+------------------------------------------+
| Variabel  | Keterangan                               |
+===========+==========================================+
| %message% | Pesan yang akan di log                   |
+-----------+------------------------------------------+
| %date%    | Tanggal pesan ditambahkan                |
+-----------+------------------------------------------+
| %type%    | Tipe pesan dalam format uppercase        |
+-----------+------------------------------------------+

Contoh di bawah menunjukkan bagaimana mengubah format log:

.. code-block:: php

    <?php

    use Phalcon\Logger\Formatter\Line as LineFormatter;

    $formatter = new LineFormatter("%date% - %message%");

    // Ubah format logger
    $logger->setFormatter($formatter);

Membuat formatter Anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Logger\\FormatterInterface <../api/Phalcon_Logger_FormatterInterface>` harus diimplementasi untuk dapat menciptakan formatter logger Anda atau mengubah yang sudah ada.

Adapters
--------
Contoh berikut menunjukkan penggunaan dasar masing-masing adapter:

Stream Logger
^^^^^^^^^^^^^
Stream logger menulis pesan ke stream yang valid dalam PHP. Daftar stream yang tersedia `di sini <http://php.net/manual/en/wrappers.php>`_:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    // Buka stream dengan kompresi zlib
    $logger = new StreamAdapter("compress.zlib://week.log.gz");

    // Tulis log ke stderr
    $logger = new StreamAdapter("php://stderr");

File Logger
^^^^^^^^^^^
Logger ini menggunakan plain file untuk menyimpan log beragam data. Defaultnya semua logger file dibuka dengan mode append yang membuka file untuk penulisan saja; dan menempatkan pointer di akhir file.
Jika file tidak ada, maka file akan dicoba dibuat. Anda dapat mengubah mode ini dengan melewatkan opsi tambahan ke konstruktor:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Buat file logger dalam mode 'w'
    $logger = new FileAdapter(
        "app/logs/test.log",
        [
            "mode" => "w",
        ]
    );

Syslog Logger
^^^^^^^^^^^^^
Logger ini mengirim pesan ke system logger. Perilaku syslog bisa jadi berbeda antara satu sistem operasi dengan lainnya.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

    // Penggunaan dasar
    $logger = new SyslogAdapter(null);

    // Setting ident/mode/facility
    $logger = new SyslogAdapter(
        "ident-name",
        [
            "option"   => LOG_NDELAY,
            "facility" => LOG_MAIL,
        ]
    );

FirePHP Logger
^^^^^^^^^^^^^^
Logger ini mengirim pesan ke HTTP response headers yang ditampilkan oleh `FirePHP <http://www.firephp.org/>`_,
sebuah ekstensi `Firebug <http://getfirebug.com/>`_ untuk Firefox.

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\Firephp as Firephp;

    $logger = new Firephp("");



    $logger->log(
        "This is a message"
    );

    $logger->log(
        "This is an error",
        Logger::ERROR
    );

    $logger->error(
        "This is another error"
    );

Membuat adapter anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Logger\\AdapterInterface <../api/Phalcon_Logger_AdapterInterface>` harus diimplementasi untuk dapat menciptakan adapter logger Anda sendiri atau mengubah yang sudah ada.
