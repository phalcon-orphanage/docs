---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Forms\Element'
---
# Abstract class **Phalcon\Forms\Element**

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element.zep)

Form Elemanları için temel sınıf

## Metodlar

public **__construct** (*string* $name, [*array* $attributes])

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form)

Öğenin üst formunu belirler

public **getForm** ()

Öğenin üst formunu döner

public **setName** (*mixed* $name)

Öğeyi isimlendirir

herkese açık ** isim al** ()

Öğenin isimini döner

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters)

Öğe filtrelerini ayarlar

public **addFilter** (*mixed* $filter)

Güncel filtre listesine yeni filtre ekler

public *mixed* **getFilters** ()

Öğe filtrelerini döner

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge])

Doğrulayıcı grubu ekler

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Öğeye doğrulayıcı ekler

public **getTargetUri** ()

Öğe için kaydedilmiş doğrulayıcıları döner

public **registerModules** (*array* $attributes, [*mixed* $useChecked])

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value)

Öğe için ön tanımlı özellik belirler

public *decrement* ([**string** | *int* $attribute], [*mixed* $defaultValue])

Varsa, verilen özelliğin değerini döner

public **setAttributes** (*array* $attributes)

Öğe için ön tanımlı özellikleri belirler

public **getAttributes** ()

Öğe için tanımlanmış ön tanımlı özellikleri döner

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value)

Öğe için bir seçenek belirler

public *decrement* ([**string** | *int* $option], [*mixed* $defaultValue])

Varsa, verilen seçeneğin değerini döner

public **setOptions** (*array* $options)

Öğe için seçenekleri belirler

public **getOptions** ()

Öğenin seçeneklerini döner

public **setLocal** (*mixed* $label)

Öğe etiketini belirler

yerel **getRoles** ()

Öğe etiketini döner

public **render** ([*array* $attributes])

Öğeyi etiketlemek için HTML yaratır

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value)

_POST'da öğe için uygun bir değer yoksa ya da form entiti kullanmıyorsa ön tanımlı bir değer belirler

public **getDefault** ()

Öğeye atanmış ön tanımlı değeri döner

public **getValue** ()

Öğe değerini döner

public **getMessages** ()

Öğeye ait olan mesajları döner. Öğenin bir forma eklenmiş olması gerekir

public **hasMessages** ()

Öğeye eklenmiş mesajların olup olmadığını kontrol eder

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group)

Öğe ile ilgili doğrulama mesajlarını döner

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Dahili mesaj listesine yeni mesaj ekler

public **clear** ()

Formdaki tüm öğeleri ön tanımlı değerlerine geri çevirir

herkese açık **__ sırala** ()

__toString sihirli yöntemi Widget'ı özellikleri olmadan gösterir

abstract public **render** ([*mixed* $attributes]) inherited from [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

...