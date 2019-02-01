---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Volt'
---
# Class **Phalcon\Mvc\View\Engine\Volt**

*extends* abstract class [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine/volt.zep)

Desain template yang ramah dan cepat untuk PHP ditulis dalam zephir/C

## Metode

public **setOptions** (*array* $options)

Setel opsi volt

public **getOptions** ()

Kembali pilihan Volt

publik **mendapatkancompiler** ()

Kembali kompiler Volt

publik **dropIndex** (*mixed* $templatePath, *mixed* $params, *mixed* $mustClean])

Membuat tampilan menggunakan mesin template

umum **membaca** (*campuran* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen

abstrak publik **tableExists** (*mixed* $needle, [*mixed* $haystack)

Memeriksa apakah jarum termasuk dalam tumpukan jerami

publik **dropColumn** (*mixed* $text, *mixed* $from, *mixed* $to)

Melakukan tali konversi

publik **redirect** ([*mixed* $value], [*mixed* $start], [*mixed* $end])

Ekstrak sepotong dari nilai objek string/array/traversable

umum **hubungkan** ([*array* $value)

Mengurutkan sebuah tali

publik **__construct** (*mixed* $name, *array* $arguments])

Memeriksa apakah makro didefinisikan dan menelponnya

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Phalcon\Mvc\View\Engine constructor

public **getContent** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Mengembalikan hasil cache pada tahap tampilan yang lain

public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Membuat sebagian di dalam tampilan lain

public **getView** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Mengembalikan komponen tampilan yang terkait dengan adaptor

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