---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Translate\Adapter'
---
# Abstract class **Phalcon\Translate\Adapter**

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter.zep)

Base class for Phalcon\Translate adapters

## Metode

public **__construct** (*array* $options)

...

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders])

Mengembalikan string terjemahan dari kunci yang diberikan

public *string* **_** (*string* $translateKey, [*array* $placeholders])

Mengembalikan string terjemahan dari kunci yang diberikan (alias metode 't')

public **offsetSet** (*string* $offset, *string* $value)

Sets a translation value

public **offsetExists** (*mixed* $translateKey)

Periksa apakah ada kunci terjemahan

public **offsetUnset** (*string* $offset)

Unsets terjemahan dari kamus

public *string* **offsetGet** (*string* $translateKey)

Mengembalikan terjemahan yang terkait dengan kunci yang diberikan

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders])

Mengganti placeholder dengan nilai yang dilewatkan

abstract public **query** (*mixed* $index, [*mixed* $placeholders]) inherited from [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface)

...

abstract public **exists** (*mixed* $index) inherited from [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface)

...