---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine'
---
# Abstract class **Phalcon\Mvc\View\Engine**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine.zep)

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\Mvc\View component.

## Metode

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\View\Engine constructor

public ** getContent </ 0> ()</p> 

Mengembalikan hasil cache pada tahap tampilan yang lain

public *increment* ([**string** | *int* $partialPath], [*mixed* $params])

Membuat sebagian di dalam tampilan lain

publik **getName** ()

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

abstract public **render** (*mixed* $path, *mixed* $params, [*mixed* $mustClean]) inherited from [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface)

...