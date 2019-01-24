---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Translate\Adapter\Csv'
---
# Class **Phalcon\Translate\Adapter\Csv**

*extends* abstract class [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/csv.zep)

Memungkinkan untuk menentukan daftar terjemahan menggunakan file CSV

## Metode

public **__construct** (*array* $options)

Phalcon\Translate\Adapter\Csv constructor

private **_load** (*string* $file, *int* $length, *string* $delimiter, *string* $enclosure)

Beban diterjemahkan dari file

public **query** (*mixed* $index, [*mixed* $placeholders])

Mengembalikan terjemahan yang terkait dengan kunci yang diberikan

public **exists** (*mixed* $index)

Periksa apakah didefinisikan kunci terjemahan dalam array internal

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengembalikan string terjemahan dari kunci yang diberikan

public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengembalikan string terjemahan dari kunci yang diberikan (alias metode 't')

public **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Sets a translation value

public **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Periksa apakah ada kunci terjemahan

public **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Unsets terjemahan dari kamus

public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengembalikan terjemahan yang terkait dengan kunci yang diberikan

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Mengganti placeholder dengan nilai yang dilewatkan