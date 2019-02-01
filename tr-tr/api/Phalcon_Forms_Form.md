---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Forms\Form'
---
# Class **Phalcon\Forms\Form**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/form.zep)

Bu bileşen, nesneye yönelik bir arabirimi kullanarak formlar oluşturmanıza olanak tanır

## Metodlar

public **setValidation** (*mixed* $validation)

...

public **getValidation** ()

...

public **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\Forms\Form constructor

public **setAction** (*mixed* $action)

Formun eylemini ayarlar

public **getAction** ()

Formun eylemini döndürür

public **setUserOption** (*string* $option, *mixed* $value)

Form için bir seçenek ayarlar

public **getUserOption** (*string* $option, [*mixed* $defaultValue])

Varsa, verilen seçeneğin değerini döner

public **setOptions** (*array* $options)

Öğe için seçenekleri belirler

public **getOptions** ()

Öğenin seçeneklerini döner

public **setEntity** (*object* $entity)

Modelle ilgili varlığı ayarlar

public *object* **getEntity** ()

Modelle ilgili varlığı döndürür

public **getElements** ()

Forma eklenen form unsurlarını döndürür

public **bind** (*array* $data, *object* $entity, [*array* $whitelist])

Verileri varlığa bağlar

public **isValid** ([*array* $data], [*object* $entity])

Formu doğrular

public **getMessages** ([*mixed* $byItemName])

Doğrulama sırasında üretilen iletileri döndürür

public **getMessagesFor** (*mixed* $name)

Belirli bir öğe için üretilen iletileri döndürür

public **hasMessagesFor** (*mixed* $name)

İletilerin belirli bir öğe için üretilip üretilmediğini kontrol etme

public **add** ([Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) $element, [*mixed* $position], [*mixed* $type])

Forma bir öğe ekler

public **render** (*string* $name, [*array* $attributes])

Formdaki belirli bir maddeyi temsil eder

public **get** (*mixed* $name)

Forma adıyla eklenen bir öğeyi döndürür

public **label** (*mixed* $name, [*array* $attributes])

Forma eklenen HTML de dahil olmak üzere bir öğenin etiketini oluşturun

public **getLabel** (*mixed* $name)

Bir öğe için bir etiketi döndürür

public **getValue** (*mixed* $name)

Dahili ilgili varlığın veya varsayılan değerin değerini alır

public **has** (*mixed* $name)

Formun bir eleman içerdiğini kontrol edin

public **remove** (*mixed* $name)

Formdaki bir öğeyi kaldırır

public **clear** ([*array* $fields])

Formdaki tüm öğeleri ön tanımlı değerlerine geri çevirir

herkese açık **say** ()

Formdaki öğelerin sayısını döndürür

herkese açık **geri sarma** ()

Dahili yineleyiciyi başa sarar

public **current** ()

Yineleyicide geçerli öğeyi döndürür

herkese açık **anahtar** ()

Yineleyicideki şuanki konumu/anahtarı döner

herkese açık **sonraki** ()

İç yineleyici işaretçisini sıradaki konuma taşır

herkese açık **geçerli** ()

Yineleyicideki geçerli öğenin geçerli olup olmadığını kontrol etme

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Bağımlılık enjektörünü ayarlar

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Olay yöneticisi ayarlar

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Dahili olay yöneticisini döndürür

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get