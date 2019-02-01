---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\formlar\öğe\seçmek'
---
# Class **Phalcon\Forms\Element\Select**

*extends* abstract class [Phalcon\Forms\Element](Phalcon_Forms_Element)

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element/select.zep)

Component SELECT (choice) for forms

## Metodlar

public **__construct** (*string* $name, [*object* | *array* $options], [*array* $attributes])

Phalcon\Forms\Element constructor

public [Phalcon\Forms\Element](Phalcon_Forms_Element) **setOptions** (*array* | *object* $options)

Seçim seçeneklerini belirleyin

public *array* | *object* **getOptions** ()

Seçeneklerin seçeneklerini döndürür

public *this* **addOption** (*array* $option)

Geçerli seçeneklere bir seçenek ekler

public **render** ([*array* $attributes])

Renders the element widget returning html

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğenin üst formunu belirler

public **getForm** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğenin üst formunu döner

public **setName** (*mixed* $name) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğeyi isimlendirir

public **getName** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğenin isimini döner

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe filtrelerini ayarlar

public **addFilter** (*mixed* $filter) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Güncel filtre listesine yeni filtre ekler

public *mixed* **getFilters** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe filtrelerini döner

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Doğrulayıcı grubu ekler

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğeye doğrulayıcı ekler

public **getValidators** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe için kaydedilmiş doğrulayıcıları döner

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe için ön tanımlı özellik belirler

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Varsa, verilen özelliğin değerini döner

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe için ön tanımlı özellikleri belirler

public **getAttributes** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe için tanımlanmış ön tanımlı özellikleri döner

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe için bir seçenek belirler

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Varsa, verilen seçeneğin değerini döner

public **setUserOptions** (*array* $options) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe için seçenekleri belirler

public **getUserOptions** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğenin seçeneklerini döner

public **setLabel** (*mixed* $label) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe etiketini belirler

public **getLabel** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe etiketini döner

public **label** ([*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğeyi etiketlemek için HTML yaratır

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

_POST'da öğe için uygun bir değer yoksa ya da form entiti kullanmıyorsa ön tanımlı bir değer belirler

public **getDefault** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğeye atanmış ön tanımlı değeri döner

public **getValue** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe değerini döner

public **getMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğeye ait olan mesajları döner. Öğenin bir forma eklenmiş olması gerekir

public **hasMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğeye eklenmiş mesajların olup olmadığını kontrol eder

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Öğe ile ilgili doğrulama mesajlarını döner

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Dahili mesaj listesine yeni mesaj ekler

public **clear** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Formdaki tüm öğeleri ön tanımlı değerlerine geri çevirir

public **__toString** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

__toString sihirli yöntemi Widget'ı özellikleri olmadan gösterir