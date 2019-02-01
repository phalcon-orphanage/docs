---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Forms\Element\Email'
---
# Class **Phalcon\Forms\Element\Email**

*extends* abstract class [Phalcon\Forms\Element](Phalcon_Forms_Element)

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element/email.zep)

Komponen INPUT [jenis = tanggal] untuk bentuk

## Metode

umum **membuat** ([*array* $attributes])

Menuliskan widget elemen kembali html

public **__construct** (*string* $name, [*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengatur bentuk induk ke elemen

public **getForm** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan bentuk induk ke elemen

public **setName** (*mixed* $name) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengatur nama elemen

public **getName** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan nama elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menyetel elemen filter

public **addFilter** (*mixed* $filter) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menambahkan filter ke daftar filter saat ini

public *mixed* **getFilters** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan filter elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menambahkan sekelompok validator

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menambahkan validator ke elemen

public **getValidators** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan validator yang terdaftar untuk elemen tersebut

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menetapkan atribut default untuk elemen

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan nilai atribut jika ada

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menetapkan atribut default untuk elemen

public **getAttributes** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan atribut default untuk elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menetapkan pilihan untuk elemen

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan nilai opsi jika ada

public **setUserOptions** (*array* $options) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menyetel opsi untuk elemen

public **getUserOptions** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan opsi untuk elemen

public **setLabel** (*mixed* $label) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengatur label elemen

public **getLabel** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan label elemen

public **label** ([*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Buat HTML untuk memberi label pada elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menetapkan nilai default jika formulir tidak menggunakan entitas atau tidak ada nilai yang tersedia untuk elemen di _POST

public **getDefault** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan nilai default yang ditetapkan ke elemen

public **getValue** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan nilai elemen

public **getMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Mengembalikan pesan yang termasuk elemen Elemen perlu dilampirkan ke formulir

public **hasMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Memeriksa apakah ada pesan yang dilampirkan pada elemen

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menetapkan pesan validasi yang terkait dengan elemen

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menambahkan pesan ke daftar pesan internal

public **clear** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Menghapus setiap elemen dalam bentuk ke nilai defaultnya

public **__toString** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Metode sihir __ketali membuat widget tanpa atribut