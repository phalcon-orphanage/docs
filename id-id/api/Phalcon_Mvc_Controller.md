---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Controller'
---
# Abstract class **Phalcon\Mvc\Controller**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ControllerInterface](Phalcon_Mvc_ControllerInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/controller.zep)

Setiap pengontrol aplikasi harus memperluas kelas ini yang merangkum semua fungsi pengontrol

Kontroler menyediakan "arus" di antara model dan tampilan. Controller bertanggung jawab untuk memproses permintaan masuk dari browser web, menginterogasi model untuk data, dan menyampaikan data tersebut ke tampilan presentasi.

```php
& lt;? PHP & lt;? PHP kelas peoplecontroller meluas\phalcon\MVC\controller {// tindakan ini akan dieksekusi secara default fungsi publik indexaction(){}fungsi publik findaction(){}fungsi publik saveaction(){// depan aliran ke indeks action kembali $this- > dispatcher- > maju (["controller" = > "orang-orang", "aksi" = & gt; "indeks",]);}}

```

## Metode

publik **__membangun** ()

Phalcon\Mvc\Controller constructor

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