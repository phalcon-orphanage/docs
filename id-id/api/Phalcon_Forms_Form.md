---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Forms\Form'
---
# Class **Phalcon\Forms\Form**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/form.zep)

Komponen ini memungkinkan untuk membangun bentuk-bentuk yang menggunakan antarmuka berorientasi objek

## Metode

public **setValidation** (*mixed* $validation)

...

public **getValidation** ()

...

public **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\Forms\Form constructor

public **setAction** (*mixed* $action)

Menetapkan tindakan formulir

public **getAction** ()

Mengembalikan tindakan formulir

public **setUserOption** (*string* $option, *mixed* $value)

Menetapkan pilihan untuk elemen

public **getUserOption** (*string* $option, [*mixed* $defaultValue])

Mengembalikan nilai opsi jika ada

public **setUserOptions** (*array* $options)

Menyetel opsi untuk elemen

public **getUserOptions** ()

Mengembalikan opsi untuk elemen

public **setEntity** (*object* $entity)

Set entitas terkait dengan model

public *object* **getEntity** ()

Kembali entitas terkait dengan model

public **getElements** ()

Kembali unsur-unsur bentuk yang ditambahkan ke formulir

public **bind** (*array* $data, *object* $entity, [*array* $whitelist])

Mengikat data entitas

public **isValid** ([*array* $data], [*object* $entity])

Memvalidasi bentuk

public **getMessages** ([*mixed* $byItemName])

Mengembalikan pesan yang dihasilkan oleh validator

public **getMessagesFor** (*mixed* $name)

Mengembalikan pesan yang dihasilkan untuk elemen tertentu

public **hasMessagesFor** (*mixed* $name)

Mengembalikan pesan yang dihasilkan untuk elemen tertentu

public **add** ([Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) $element, [*mixed* $position], [*mixed* $type])

Menambahkan elemen ke bentuk

public **render** (*string* $name, [*array* $attributes])

Menuliskan item spesifik dalam bentuk

public **get** (*mixed* $name)

Returns an element added to the form by its name

public **label** (*mixed* $name, [*array* $attributes])

Menghasilkan label elemen ditambahkan ke bentuk termasuk HTML

public **getLabel** (*mixed* $name)

Mengembalikan label untuk elemen

public **getValue** (*mixed* $name)

Mendapat nilai dari entitas terkait internal atau dari nilai default

publik **telah** (*campuran* $name)

Periksa jika bentuk berisi elemen

umum **hapus** (*campuran* $nama)

Menambahkan elemen ke bentuk

public **clear** ([*array* $fields])

Menghapus setiap elemen dalam bentuk ke nilai defaultnya

publik **menghitung**()

Mengembalikan jumlah elemen dalam formulir

publik**mundur**()

Melakukan pemutaran balik internal iterator

public **current** ()

Mengembalikan elemen arus pada iterator

publik **kunci** ()

Mengembalikan posisi/kunci saat ini di iterator

publik **berikutnya** ()

Bergerak pointer internal iterasi kepada posisi yang berikut

publik **sah** ()

Periksa apakah pesan yang sekarang di iterator berlaku

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan manajer acara internal

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Metode __get