---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Forms\Element'
---
# Abstract class **Phalcon\Forms\Element**

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element.zep)

Ini adalah kelas dasar untuk elemen formulir

## Metode

public **__construct** (*string* $name, [*array* $attributes])

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form)

Mengatur bentuk induk ke elemen

public **getForm** ()

Mengembalikan bentuk induk ke elemen

publik **setNama** (*dicampur* $name)

Mengatur nama elemen

publik **getNama** ()

Mengembalikan nama elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters)

Menyetel elemen filter

public **addFilter** (*mixed* $filter)

Menambahkan filter ke daftar filter saat ini

public *mixed* **getFilters** ()

Mengembalikan filter elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge])

Menambahkan sekelompok validator

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Menambahkan validator ke elemen

public **getValidators** ()

Mengembalikan validator yang terdaftar untuk elemen tersebut

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked])

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value)

Menetapkan atribut default untuk elemen

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

Mengembalikan nilai atribut jika ada

public **setAttributes** (*array* $attributes)

Menetapkan atribut default untuk elemen

public **getAttributes** ()

Mengembalikan atribut default untuk elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value)

Menetapkan pilihan untuk elemen

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue])

Mengembalikan nilai opsi jika ada

public **setUserOptions** (*array* $options)

Menyetel opsi untuk elemen

public **getUserOptions** ()

Mengembalikan opsi untuk elemen

public **setLabel** (*mixed* $label)

Mengatur label elemen

public **getLabel** ()

Mengembalikan label elemen

public **label** ([*array* $attributes])

Buat HTML untuk memberi label pada elemen

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value)

Menetapkan nilai default jika formulir tidak menggunakan entitas atau tidak ada nilai yang tersedia untuk elemen di _POST

public **getDefault** ()

Mengembalikan nilai default yang ditetapkan ke elemen

publik **getValue** ()

Mengembalikan nilai elemen

public **getMessages** ()

Mengembalikan pesan yang termasuk elemen Elemen perlu dilampirkan ke formulir

public **hasMessages** ()

Memeriksa apakah ada pesan yang dilampirkan pada elemen

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group)

Menetapkan pesan validasi yang terkait dengan elemen

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Menambahkan pesan ke daftar pesan internal

publik **jelas** ()

Menghapus setiap elemen dalam bentuk ke nilai defaultnya

publik **__keString** ()

Metode sihir __ketali membuat widget tanpa atribut

abstract public **render** ([*mixed* $attributes]) inherited from [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

...