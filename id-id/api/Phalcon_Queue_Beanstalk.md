---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Queue\Beanstalk'
---
# Class **Phalcon\Queue\Beanstalk**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/queue/beanstalk.zep)

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

## Metode

public **__construct** ([*array* $parameters])

public **connect** ()

Membuat koneksi ke server Beanstalkd

public **put** (*mixed* $data, [*array* $options])

Menempatkan pekerjaan yang ada pada antrian yang ditentukan oleh yang menggunakan tabung.

public **reserve** ([*mixed* $timeout])

Cadangan/kunci yang siap kerja dari yang ditentukan oleh tabung.

public **choose** (*mixed* $tube)

Change the active tube. By default the tube is "default".

public **watch** (*mixed* $tube)

Perintah menonton untuk menambahkan yang bernama tabung ke daftar menonton untuk sambungan yang berada saat ini.

public **ignore** (*mixed* $tube)

Menghilangkan yang bernama tabung dari daftar tontonan untuk sambungan yang berada saat ini.

public **pauseTube** (*mixed* $tube, *mixed* $delay)

Dapat menunda setiap pekerjaan yang baru dicadangkan untuk suatu waktu yang mungkin diberikan.

public **kick** (*mixed* $bound)

Tendangan perintah yang hanya akan berlaku untuk saat ini digunakan oleh tabung.

public **stats** ()

Memberikan informasi yang ada statistik tentang sistem sebagai keseluruhannya.

public **statsTube** (*mixed* $tube)

Memberikan informasi statistik tentang masalah yang ditentukan tabung jika ada.

public **listTubes** ()

Menampilkan daftar dari semua yang ada didalam tabung.

public **listTubeUsed** ()

Kembalikan tabung saat ini yang sedang digunakan oleh klien.

public **listTubesWatched** ()

Mengembalikan daftar ketabung yang saat ini diawasi oleh klien.

public **peekReady** ()

Periksa berikutnya siap kerja.

public **peekBuried** ()

Kembali kepekerjaan berikutnya yang ada dalam daftar dimakamkan pekerjaan.

umum **peekDelayed** ()

Kembali kepekerjaan berikutnya yang ada dalam daftar dimakamkan pekerjaan.

public **jobPeek** (*mixed* $id)

Mengintip perintah yang dibiarkan oleh klien untuk memeriksa pekerjaan dalam suatu sistem.

final public **readStatus** ()

Membaca status yang terbaru dari Beanstalkd server

final public **readYaml** ()

Fetch a YAML payload from the Beanstalkd server

public **read** ([*mixed* $length])

Reads a packet from the socket. Prior to reading from the socket will check for availability of the connection.

public **write** (*mixed* $data)

Writes data to the socket. Performs a connection if none is available

public **disconnect** ()

Menutup koneksi ke server beanstalk.

public **quit** ()

Cukup tutup koneksi.