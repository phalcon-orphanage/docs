---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Behavior'
---
# Abstract class **Phalcon\Mvc\Collection\Behavior**

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/behavior.zep)

Bu, ORM davranışlarına yönelik isteğe bağlı bir taban sınıfıdır

## Metodlar

herkese açık **__düzenle**([* sıra* $seçenekler])

protected **mustTakeAction** (*mixed* $eventName)

Davranışın belirli bir etkinlikte harekete geçip geçmeyeceğini denetler

protected *array* **getOptions** ([*string* $eventName])

Bir etkinlik ile alakalı davranış seçeneklerini döndürür

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

This method receives the notifications from the EventsManager

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments])

Koleksiyonda eksik bir yöntem çağrıldığında yedek olarak davranır