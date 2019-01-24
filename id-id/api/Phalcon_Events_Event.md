---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Events\Event'
---
# Class **Phalcon\Events\Event**

*implements* [Phalcon\Events\EventInterface](Phalcon_Events_EventInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/events/event.zep)

Kelas ini menawarkan informasi kontekstual tentang kejadian yang dipecat di EventsManager

## Metode

publik **berhenti** ()

Jenis Aktivitas

publik **mendapatkan Sumber** ()

Sumber Aktivitas

publik **mendapatkan Data** ()

Data Acara

publik **__buat** (*rangkaian* $type, *benda* $source, [*dicampur* $data], [*boolean* $cancelable])

Phalcon\Events\Event constructor

publik **mendapatkan Data** ([*dicampur* $data])

Atur Data Acara.

publik **perangkat Tipe** (*dicampur* $type)

Atur Tipe Acara.

publik ** berhenti ** ()

Menghentikan acara mencegah penyiaran.

```php
<?php

if ($event->dapat Dibatalkan()) {
    $event->berhenti();
}

```

publik **dpat Dihentikan** ()

Periksa apakah acara tersebut saat ini dihentikan.

publik **dapat Dibatalkan** ()

Periksa apakah acara tersebut dapat dibatalkan.

```php
<?php

if ($event->dapat Dibatalkan()) {
    $event->berhenti();
}

```