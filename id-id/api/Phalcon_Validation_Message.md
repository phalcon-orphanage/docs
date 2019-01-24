---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation\Message'
---
# Class **Phalcon\Validation\Message**

*implements* [Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/message.zep)

Encapsulates validation info generated in the validation process

## Metode

public **__construct** (*mixed* $message, [*mixed* $field], [*mixed* $type], [*mixed* $code])

Phalcon\Validation\Message constructor

publik **perangkat Tipe** (*dicampur* $type)

Menetapkan jenis pesan

publik **berhenti** ()

Mengembalikan jenis pesan

publik **perangkat Pesan** (*campur* $message)

Mengatur pesan verbose   Teks paragraf

public **getMessage** ()

Mengembalikan pesan verbose

publik **setelan Bidang** (*campur* $field)

Menetapkan nama bidang yang terkait dengan pesan

public *mixed* **getField** ()

Mengembalikan nama bidang yang terkait dengan pesan

publik **mengatur Kode** (*campur* $code)

Menetapkan kode untuk pesan

publik **mendapatkan Kode** ()

Mengembalikan kode pesan

publik **__keString** ()

Metode Magic __toString mengembalikan pesan verbose

statik publik **__menyetel_negara** (*aturan* $message)

Sihir __set_state membantu untuk memulihkan pesan dari serialisasi