---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation'
---
# Class **Phalcon\Validation**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\ValidationInterface](Phalcon_ValidationInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation.zep)

Memungkinkan untuk memvalidasi data menggunakan kustom atau built-in validator

## Metode

publik **mendapatkan Data** ()

...

public **setValidators** (*mixed* $validators)

...

public **__construct** ([*array* $validators])

Phalcon\Validation constructor

public [Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) **validate** ([*array* | *object* $data], [*object* $entity])

Satu set data sesuai dengan seperangkat aturan validasi

public **add** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Adds a validator to a field

public **rule** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Alias of `add` method

public **rules** (*mixed* $field, *array* $validators)

Menambah validator bidang

public [Phalcon\Validation](Phalcon_Validation) **setFilters** (*string* $field, *array* | *string* $filters)

Menambahkan filter ke bidang

public *mixed* **getFilters** ([*string* $field])

Mengembalikan semua filter atau satu tertentu

public **getValidators** ()

Kembali validator yang ditambahkan ke validasi

public **setEntity** (*object* $entity)

Set entitas terikat

public *object* **getEntity** ()

Set entitas terikat

public **setDefaultMessages** ([*array* $messages])

Menambahkan pesan default validator

public **getDefaultMessage** (*mixed* $type)

Mendapatkan pesan default untuk jenis validator

public **getMessages** ()

Kembali validator terdaftar

public **setLabels** (*array* $labels)

Adds labels for fields

public *string* **getLabel** (*string* $field)

Mendapatkan label untuk bidang

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Menambahkan pesan ke daftar pesan

public [Phalcon\Validation](Phalcon_Validation) **bind** (*object* $entity, *array* | *object* $data)

Menetapkan data ke suatu entitas entitas yang digunakan untuk memperoleh nilai validasi

public *mixed* **getValue** (*string* $field)

Mendapat nilai untuk memvalidasi dalam array objek sumber data

protected **preChecking** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Internal validasi, jika itu kembali benar, maka mengabaikan validator saat ini

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