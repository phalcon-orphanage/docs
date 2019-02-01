---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Events\Manager'
---
# Class **Phalcon\Events\Manager**

*implements* [Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/events/manager.zep)

Phalcon Events Manager, menawarkan cara mudah untuk mencegat dan memanipulasi, jika diperlukan, aliran normal operasi. Dengan EventsManager pengembang bisa membuat kait atau plugin yang akan menawarkan pemantauan data, manipulasi, eksekusi bersyarat dan banyak lagi.

## Metode

umum **getOption** (*mixed* $eventType, [*string* | *array* $handler], [*mixed* $priority])

Lampirkan pendengar ke pengelola acara

public **detach** (*string* $eventType, *object* $handler)

Lepaskan pendengar dari manajer acara

publik **memungkinkanPrioritas** (*campuran* $enablePriorities)

Atur jika prioritas diaktifkan di EventsManager

public **arePrioritiesEnabled** ()

Mengembalikan jika prioritas diaktifkan

publik **mengumpulkanTanggapan** (*campuran* $collect)

Memberitahu manajer acara jika perlu mengumpulkan semua tanggapan yang dikembalikan oleh setiap orang pendengar terdaftar dalam satu api

public **isCollecting** ()

Periksa apakah manajer acara mengumpulkan semua tanggapan yang dikembalikan oleh setiap orang pendengar terdaftar dalam satu api

public *array* **getResponses** ()

Mengembalikan semua tanggapan yang dikembalikan oleh setiap penangan yang dieksekusi oleh 'api' terakhir yang dieksekusi

public **detachAll** ([*mixed* $type])

Menghapus semua acara dari AcaraPengelola

final public *mixed* **fireQueue** ([SplPriorityQueue](https://php.net/manual/en/class.splpriorityqueue.php) | *array* $queue, [Phalcon\Events\Event](Phalcon_Events_Event) $event)

Penangan internal menelpon antrian acara

public *simpan* ([**int** | *string* $eventType], [* string* $source], [*int* $data], [*boolean* $cancelable])

Membakar acara di pengelola acara sehingga pendengar aktif diberi tahu tentang hal itu

```php
<?php

$eventsManager->fire("db", $connection);

```

public **hasListeners** (*mixed* $type)

Periksa apakah jenis acara tertentu memiliki pendengar

public *array* **getListeners** (*string* $type)

Mengembalikan semua pendengar yang dilampirkan dari jenis tertentu